<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, SoftDeletes;

    public const int STATUS_IN_PROGRESS = 0;
    public const int STATUS_DONE = 1;
    public const int STATUS_PLANNED = 2;
    public const int STATUS_ON_APPROVAL = 3;
    public const int STATUS_PAUSED = 4;
    public const int STATUS_FAILED = 5;
    public const int STATUS_OBSOLETE = 6;

    protected $fillable = ['lead_id', 'code', 'name', 'description', 'status', 'visibility', 'priority', 'starts_at', 'ends_at'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
