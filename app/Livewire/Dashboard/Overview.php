<?php

namespace App\Livewire\Dashboard;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Overview')]
class Overview extends Component
{
    /**
     * Render the component view.
     */
    public function render()
    {
        $userId = auth()->id();

        // 1. Total Profile Views (visits where project_id is null)
        $totalProfileViews = DB::table('portfolio_visits')
            ->where('user_id', $userId)
            ->whereNull('project_id')
            ->count();

        // 2. Total Project Clicks (visits where project_id is not null)
        $totalProjectClicks = DB::table('portfolio_visits')
            ->where('user_id', $userId)
            ->whereNotNull('project_id')
            ->count();

        // 3. Total Projects Count
        $totalProjects = Project::where('user_id', $userId)->count();

        // 4. Top Projects by Click Count
        $topProjects = Project::where('projects.user_id', $userId)
            ->leftJoin('portfolio_visits', 'projects.id', '=', 'portfolio_visits.project_id')
            ->select('projects.id', 'projects.title', 'projects.category', DB::raw('count(portfolio_visits.id) as clicks_count'))
            ->groupBy('projects.id', 'projects.title', 'projects.category')
            ->orderByDesc('clicks_count')
            ->take(5)
            ->get();

        // 5. Last 7 Days Daily Stats for SVG Charting
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dateLabel = now()->subDays($i)->format('d M');

            $views = DB::table('portfolio_visits')
                ->where('user_id', $userId)
                ->whereNull('project_id')
                ->whereDate('created_at', $date)
                ->count();

            $clicks = DB::table('portfolio_visits')
                ->where('user_id', $userId)
                ->whereNotNull('project_id')
                ->whereDate('created_at', $date)
                ->count();

            $dailyStats[] = [
                'date' => $dateLabel,
                'views' => $views,
                'clicks' => $clicks,
            ];
        }

        // Generate SVG Points for Line Chart
        $chartPointsViews = '';
        $chartPointsClicks = '';
        $maxVal = 10; // Default min max value for scale
        foreach ($dailyStats as $stat) {
            if ($stat['views'] > $maxVal) {
                $maxVal = $stat['views'];
            }
            if ($stat['clicks'] > $maxVal) {
                $maxVal = $stat['clicks'];
            }
        }

        // Generate points for SVG viewBox: w=500, h=200
        foreach ($dailyStats as $index => $stat) {
            $x = ($index * (500 / 6));

            // Map values to y-axis (inverted in SVG, 0 is top, 200 is bottom)
            // Leave a padding of 20px top and bottom
            $yViews = 180 - (($stat['views'] / $maxVal) * 160);
            $yClicks = 180 - (($stat['clicks'] / $maxVal) * 160);

            $chartPointsViews .= ($index === 0 ? 'M' : ' L')." {$x},{$yViews}";
            $chartPointsClicks .= ($index === 0 ? 'M' : ' L')." {$x},{$yClicks}";
        }

        return view('livewire.dashboard.overview', [
            'totalProfileViews' => $totalProfileViews,
            'totalProjectClicks' => $totalProjectClicks,
            'totalProjects' => $totalProjects,
            'topProjects' => $topProjects,
            'dailyStats' => $dailyStats,
            'chartPointsViews' => $chartPointsViews,
            'chartPointsClicks' => $chartPointsClicks,
            'maxVal' => $maxVal,
        ])->layout('layouts.app');
    }
}
