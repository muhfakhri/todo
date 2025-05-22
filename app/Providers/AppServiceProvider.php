<?php

namespace App\Providers;

use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        // Add other model-policy mappings here if needed
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Optional: Define additional gates if needed
        Gate::define('view-dashboard', function ($user) {
            return $user->is_active; // Example: Only active users can view dashboard
        });

        // Or using a class callback:
        Gate::define('update-settings', [SettingsPolicy::class, 'update']);
    }
}