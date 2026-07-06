<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('status')->nullable();
            $table->string('job_title')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('skills')->nullable(); // JSON or comma-separated string
            $table->string('github_url')->nullable();
            $table->string('cv_path')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('hide_contact')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'avatar_path',
                'status',
                'job_title',
                'phone',
                'address',
                'birth_date',
                'skills',
                'github_url',
                'cv_path',
                'bio',
                'hide_contact',
            ]);
        });
    }
};
