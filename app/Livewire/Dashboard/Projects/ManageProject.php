<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Manage Project')]
class ManageProject extends Component
{
    use WithFileUploads;

    public ?Project $project = null;

    public bool $isEdit = false;

    // Form fields
    public string $title = '';

    public string $category = '';

    public array $tech_stack = [];

    public array $features = [];

    public string $description = '';

    public string $project_url = '';

    public string $github_url = '';

    public string $status = 'draft';

    public array $images = []; // Existing image paths

    // Upload & temp states
    public $new_images = []; // Temp uploads

    public string $new_feature = '';

    public string $tech_search = '';

    public array $available_techs = [
        'HTML', 'CSS', 'JavaScript', 'TypeScript', 'PHP', 'Laravel', 'Symfony', 'CodeIgniter', 'WordPress',
        'Python', 'Django', 'Flask', 'FastAPI', 'Ruby', 'Ruby on Rails', 'Java', 'Spring Boot', 'Kotlin', 'Swift',
        'Flutter', 'React Native', 'Go', 'Rust', 'C', 'C++', 'C#', 'Node.js', 'Express', 'NestJS', 'React', 'Vue',
        'Angular', 'Svelte', 'Next.js', 'Nuxt.js', 'Tailwind CSS', 'Bootstrap', 'MySQL', 'PostgreSQL', 'SQLite',
        'MariaDB', 'MongoDB', 'Redis', 'Firebase', 'Supabase', 'Docker', 'Kubernetes', 'AWS', 'Google Cloud',
        'Azure', 'Vercel', 'Netlify', 'Git', 'GitHub', 'GitLab', 'Docker Compose',
    ];

    /**
     * Mount the component.
     */
    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->project = Auth::user()->projects()->findOrFail($id);
            $this->isEdit = true;

            $this->title = $this->project->title;
            $this->category = $this->project->category;
            $this->tech_stack = $this->project->tech_stack ?? [];
            $this->features = $this->project->features ?? [];
            $this->description = $this->project->description ?? '';
            $this->project_url = $this->project->project_url ?? '';
            $this->github_url = $this->project->github_url ?? '';
            $this->status = $this->project->status;
            $this->images = $this->project->images ?? [];
        }
    }

    /**
     * Listen for new image uploads to add them to list.
     */
    public function updatedNewImages(): void
    {
        $this->validate([
            'new_images.*' => 'image|max:3072', // 3MB max per image
        ]);

        foreach ($this->new_images as $image) {
            $path = $image->store('projects', 'public');
            $this->images[] = $path;
        }

        $this->new_images = []; // Clear temporary property
    }

    /**
     * Add a feature to the list.
     */
    public function addFeature(): void
    {
        $feature = trim($this->new_feature);
        if ($feature !== '') {
            $this->features[] = $feature;
        }
        $this->new_feature = '';
    }

    /**
     * Remove a feature.
     */
    public function removeFeature(int $index): void
    {
        if (isset($this->features[$index])) {
            unset($this->features[$index]);
            $this->features = array_values($this->features);
        }
    }

    /**
     * Add technology to tech stack.
     */
    public function addTech(string $tech): void
    {
        $tech = trim($tech);
        if ($tech !== '' && ! in_array($tech, $this->tech_stack)) {
            $this->tech_stack[] = $tech;
        }
        $this->tech_search = '';
    }

    /**
     * Add a custom tech stack typed by user.
     */
    public function addCustomTech(): void
    {
        $this->addTech($this->tech_search);
    }

    /**
     * Remove technology.
     */
    public function removeTech(int $index): void
    {
        if (isset($this->tech_stack[$index])) {
            unset($this->tech_stack[$index]);
            $this->tech_stack = array_values($this->tech_stack);
        }
    }

    /**
     * Move image sorting.
     */
    public function moveImage(int $index, string $direction): void
    {
        $images = $this->images;
        if ($direction === 'left' && $index > 0) {
            $temp = $images[$index - 1];
            $images[$index - 1] = $images[$index];
            $images[$index] = $temp;
        } elseif ($direction === 'right' && $index < count($images) - 1) {
            $temp = $images[$index + 1];
            $images[$index + 1] = $images[$index];
            $images[$index] = $temp;
        }
        $this->images = $images;
    }

    /**
     * Remove project image.
     */
    public function removeImage(int $index): void
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    /**
     * Save the project.
     */
    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'tech_stack' => ['required', 'array', 'min:1'],
            'features' => ['required', 'array', 'min:1'],
            'description' => ['nullable', 'string'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', 'in:draft,published'],
        ]);

        if (count($this->images) < 1) {
            $this->addError('images', __('Silakan upload minimal 1 gambar proyek.'));

            return;
        }

        $data = $validated;
        $data['images'] = $this->images;
        $data['user_id'] = Auth::id();

        if ($this->isEdit) {
            $this->project->update($data);
            Flux::toast(variant: 'success', text: __('Project updated successfully.'));
        } else {
            Project::create($data);
            Flux::toast(variant: 'success', text: __('Project created successfully.'));
        }

        $this->redirect(route('projects.index'), navigate: true);
    }

    /**
     * Render view.
     */
    public function render()
    {
        $filtered_techs = [];
        if ($this->tech_search !== '') {
            $filtered_techs = collect($this->available_techs)
                ->filter(fn ($t) => str_contains(strtolower($t), strtolower($this->tech_search)) && ! in_array($t, $this->tech_stack))
                ->take(6)
                ->toArray();
        }

        return view('livewire.dashboard.projects.manage-project', [
            'filtered_techs' => $filtered_techs,
        ]);
    }
}
