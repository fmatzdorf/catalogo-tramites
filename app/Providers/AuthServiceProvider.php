<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Policies\ActivityLogPolicy;
use App\Models\Category;
use App\Models\Institution;
use App\Models\Procedure;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\InstitutionPolicy;
use App\Policies\ProcedurePolicy;
use App\Policies\UserPolicy;
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
        Institution::class => InstitutionPolicy::class,
        Category::class => CategoryPolicy::class,
        Procedure::class => ProcedurePolicy::class,
        User::class => UserPolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define admin gate
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Define institutional gate
        Gate::define('institutional', function ($user) {
            return $user->role === 'institutional';
        });

        // Define can manage institution gate
        Gate::define('manage-institution', function ($user, $institution) {
            return $user->role === 'admin' ||
                   ($user->role === 'institutional' && $user->institution_id === $institution->id);
        });

        // Define can manage user gate
        Gate::define('manage-user', function ($user, $targetUser) {
            return $user->role === 'admin' ||
                   ($user->role === 'institutional' && $user->institution_id === $targetUser->institution_id);
        });

        // Define additional gates if needed
        Gate::define('view-activity-logs', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-all-institutions', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-categories', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
