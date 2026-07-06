<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Projects')]
class ListProjects extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    /**
     * Delete the specified project.
     */
    public function deleteProject(int $id): void
    {
        $project = Auth::user()->projects()->findOrFail($id);

        // Delete images from storage if needed (optional, or just clean database)
        $project->delete();

        Flux::toast(variant: 'success', text: __('Project deleted successfully.'));
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $projects = Auth::user()->projects()
            ->when($this->search !== '', function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.projects.list-projects', [
            'projects' => $projects,
        ]);
    }
}
