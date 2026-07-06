<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $category
 * @property array $tech_stack
 * @property array $features
 * @property string|null $description
 * @property string|null $project_url
 * @property string|null $github_url
 * @property string $status
 * @property array $images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'user_id',
    'title',
    'category',
    'tech_stack',
    'features',
    'description',
    'project_url',
    'github_url',
    'status',
    'images',
])]
class Project extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'features' => 'array',
            'images' => 'array',
        ];
    }

    /**
     * Get the user that owns the project.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
