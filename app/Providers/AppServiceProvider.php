<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\Institution;
use App\Models\Category;
use App\Models\Procedure;
use App\Models\User;
use App\Observers\InstitutionObserver;
use App\Observers\CategoryObserver;
use App\Observers\ProcedureObserver;
use App\Observers\UserObserver;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model observers
        Institution::observe(InstitutionObserver::class);
        Category::observe(CategoryObserver::class);
        Procedure::observe(ProcedureObserver::class);
        User::observe(UserObserver::class);

        // Register event listeners for authentication events
        Event::listen(Login::class, function (Login $event) {
            app(LogSuccessfulLogin::class)->handle($event);
        });
        
        Event::listen(Logout::class, function (Logout $event) {
            app(LogSuccessfulLogout::class)->handle($event);
        });
    }
}
