<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Course;
use App\Policies\CategoryPolicy;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        // Define Super Admin role

        
        try {
            Permission::defaultGuardName('web');
            Role::defaultGuardName('web');
        } catch (\Exception $e) {
            // Handle exception if tables don't exist yet
        }
    }
}
