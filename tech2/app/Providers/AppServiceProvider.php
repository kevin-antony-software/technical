<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('admin-only', function (User $user) {
            return $user->position === 'admin';
        });
        Gate::define('director-only', function (User $user) {
            if ($user->position == 'admin' || $user->position == 'director') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('managers-only', function (User $user) {
            if ($user->position == 'admin' || $user->position == 'director' || $user->position == 'manager') {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('senior-tech-executive-only', function (User $user) {
            if (
                $user->position == 'admin' ||
                $user->position == 'director' ||
                $user->position == 'manager' ||
                $user->position == 'senior-tech-executive' ||
                $user->position == 'sales-executive'
            ) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('tech-executive-only', function (User $user) {
            if (
                $user->position == 'admin' ||
                $user->position == 'director' ||
                $user->position == 'manager' ||
                $user->position == 'senior-tech-executive' ||
                $user->position == 'technical-executive'
            ) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define('sales-executive-only', function (User $user) {
            if (
                $user->position == 'admin' ||
                $user->position == 'director' ||
                $user->position == 'manager' ||
                $user->position == 'senior-tech-executive' ||
                $user->position == 'technical-executive' ||
                $user->position == 'sales-executive'
            ) {
                return true;
            } else {
                return false;
            }
        });



    }
}
