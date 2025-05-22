<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // ... existing properties and methods ...

    /**
     * Get all tasks for the user
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}