<?php

use App\Livewire\Dashboard\Overview;
use App\Livewire\Dashboard\Projects\ListProjects;
use App\Livewire\Dashboard\Projects\ManageProject;
use App\Livewire\PublicPortfolio;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', Overview::class)->name('dashboard');

    // Project management routes
    Route::livewire('dashboard/projects', ListProjects::class)->name('projects.index');
    Route::livewire('dashboard/projects/create', ManageProject::class)->name('projects.create');
    Route::livewire('dashboard/projects/{id}/edit', ManageProject::class)->name('projects.edit');
});

require __DIR__.'/settings.php';

// Public Portfolio fallback route
Route::livewire('/{username}', PublicPortfolio::class)->name('public.portfolio');
