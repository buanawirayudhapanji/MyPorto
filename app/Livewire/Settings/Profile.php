<?php

namespace App\Livewire\Settings;

use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profile settings')]
class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $username = '';

    public $avatar = null;

    public ?string $avatar_path = null;

    public string $status = '';

    public string $job_title = '';

    public string $phone = '';

    public string $address = '';

    public ?string $birth_date = null;

    public array $skills = [];

    public string $new_skill = '';

    public string $github_url = '';

    public $cv = null;

    public ?string $cv_path = null;

    public string $bio = '';

    public bool $hide_contact = false;

    public string $linkedin_url = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username ?? '';
        $this->avatar_path = $user->avatar_path;
        $this->status = $user->status ?? '';
        $this->job_title = $user->job_title ?? '';
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->birth_date = $user->birth_date ? $user->birth_date->format('Y-m-d') : null;
        $this->skills = $user->skills ?? [];
        $this->github_url = $user->github_url ?? '';
        $this->cv_path = $user->cv_path;
        $this->bio = $user->bio ?? '';
        $this->hide_contact = (bool) $user->hide_contact;
        $this->linkedin_url = $user->linkedin_url ?? '';
    }

    /**
     * Add a skill to the tag list.
     */
    public function addSkill(): void
    {
        $skill = trim($this->new_skill);
        if ($skill !== '' && ! in_array($skill, $this->skills)) {
            $this->skills[] = $skill;
        }
        $this->new_skill = '';
    }

    /**
     * Remove a skill from the tag list.
     */
    public function removeSkill(int $index): void
    {
        if (isset($this->skills[$index])) {
            unset($this->skills[$index]);
            $this->skills = array_values($this->skills);
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'alpha_dash', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
            'status' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'birth_date' => ['nullable', 'date'],
            'skills' => ['nullable', 'array'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
            'bio' => ['nullable', 'string', 'max:5000'],
            'hide_contact' => ['boolean'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ]);

        // Process uploads
        if ($this->avatar) {
            $validated['avatar_path'] = $this->avatar->store('avatars', 'public');
            $this->avatar_path = $validated['avatar_path'];
            $this->avatar = null;
        }

        if ($this->cv) {
            $validated['cv_path'] = $this->cv->store('cvs', 'public');
            $this->cv_path = $validated['cv_path'];
            $this->cv = null;
        }

        $validated['skills'] = $this->skills;

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Flux::toast(text: __('A new verification link has been sent to your email address.'));
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        $user = Auth::user();

        return $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        $user = Auth::user();

        return ! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail();
    }
}
