<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Portfolio')]
class PublicPortfolio extends Component
{
    public User $user;

    public ?Project $selectedProject = null;

    public bool $showModal = false;

    // Filters
    public string $search = '';

    public string $category = '';

    public string $tech = '';

    /**
     * Mount the component.
     */
    public function mount(string $username): void
    {
        $this->user = User::where('username', $username)->firstOrFail();

        // Track profile visit (skip if visitor is owner to avoid polluting stats)
        if (auth()->id() !== $this->user->id) {
            \DB::table('portfolio_visits')->insert([
                'user_id' => $this->user->id,
                'project_id' => null,
                'ip_hash' => hash('sha256', request()->ip() ?? '127.0.0.1'),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Open details modal for project.
     */
    public function selectProject(int $projectId): void
    {
        $this->selectedProject = Project::where('user_id', $this->user->id)
            ->where('status', 'published')
            ->findOrFail($projectId);
        $this->showModal = true;

        // Track project click/view (skip if owner)
        if (auth()->id() !== $this->user->id) {
            \DB::table('portfolio_visits')->insert([
                'user_id' => $this->user->id,
                'project_id' => $projectId,
                'ip_hash' => hash('sha256', request()->ip() ?? '127.0.0.1'),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Close the details modal.
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->selectedProject = null;
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $projects = $this->user->projects()
            ->where('status', 'published')
            ->when($this->search !== '', function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->category !== '', function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->tech !== '', function ($query) {
                $query->where('tech_stack', 'like', '%"'.$this->tech.'"%');
            })
            ->latest()
            ->get();

        // Get all unique tech stack elements for the filter dropdown
        $allTechs = $this->user->projects()
            ->where('status', 'published')
            ->pluck('tech_stack')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        return view('livewire.public-portfolio', [
            'projects' => $projects,
            'allTechs' => $allTechs,
        ])->layout('layouts.public');
    }
}
