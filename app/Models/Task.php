<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
        'due_date',
        'priority' // Added if you want priority functionality
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date',
    ];

    /**
     * Relationship: Task belongs to a User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Get only completed tasks
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('completed', true);
    }

    /**
     * Scope: Get only pending tasks
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('completed', false);
    }

    /**
     * Scope: Get overdue tasks
     */
   public function scopeOverdue(Builder $query): Builder
{
    return $query->where('completed', false)
                ->whereDate('due_date', '<', now());
}

public function isOverdue(): bool
{
    return !$this->completed && $this->due_date && $this->due_date->isPast();
}
    /**
     * Mark task as complete/incomplete
     */
    public function toggleComplete(): void
    {
        $this->update(['completed' => !$this->completed]);
    }
}