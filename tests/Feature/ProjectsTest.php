<?php

use App\Livewire\Dashboard\Projects\ListProjects;
use App\Livewire\Dashboard\Projects\ManageProject;
use App\Livewire\PublicPortfolio;
use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;

test('authenticated user can view projects list', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard/projects')
        ->assertOk();
});

test('user can create a new project', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(ManageProject::class)
        ->set('title', 'My Portfolio Site')
        ->set('category', 'Web Development')
        ->set('tech_stack', ['PHP', 'Laravel'])
        ->set('features', ['Responsive design', 'Search filter'])
        ->set('description', 'Detailed description')
        ->set('images', ['projects/dummy.png'])
        ->set('status', 'published')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/dashboard/projects');

    expect(Project::where('title', 'My Portfolio Site')->exists())->toBeTrue();
});

test('user can update a project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create([
        'user_id' => $user->id,
        'title' => 'Old Title',
    ]);

    $this->actingAs($user);

    Livewire::test(ManageProject::class, ['id' => $project->id])
        ->set('title', 'Updated Title')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect('/dashboard/projects');

    expect($project->refresh()->title)->toEqual('Updated Title');
});

test('user can delete a project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    Livewire::test(ListProjects::class)
        ->call('deleteProject', $project->id)
        ->assertHasNoErrors();

    expect(Project::find($project->id))->toBeNull();
});

test('visitor can view public portfolio page', function () {
    $user = User::factory()->create([
        'username' => 'panji',
        'name' => 'Panji Wira',
    ]);

    $project = Project::factory()->create([
        'user_id' => $user->id,
        'status' => 'published',
        'title' => 'Public App',
    ]);

    $this->get('/panji')
        ->assertOk()
        ->assertSee('Panji Wira')
        ->assertSee('Public App');
});

test('visitor can filter public portfolio projects', function () {
    $user = User::factory()->create(['username' => 'panji']);

    $projectWeb = Project::factory()->create([
        'user_id' => $user->id,
        'title' => 'Web Application',
        'category' => 'Web Development',
        'status' => 'published',
        'tech_stack' => ['Laravel'],
    ]);

    $projectMobile = Project::factory()->create([
        'user_id' => $user->id,
        'title' => 'Mobile Application',
        'category' => 'Mobile App Development',
        'status' => 'published',
        'tech_stack' => ['Flutter'],
    ]);

    // Test filtering by Category
    Livewire::test(PublicPortfolio::class, ['username' => 'panji'])
        ->set('category', 'Web Development')
        ->assertSee('Web Application')
        ->assertDontSee('Mobile Application');

    // Test filtering by Tech Stack
    Livewire::test(PublicPortfolio::class, ['username' => 'panji'])
        ->set('tech', 'Flutter')
        ->assertSee('Mobile Application')
        ->assertDontSee('Web Application');
});
