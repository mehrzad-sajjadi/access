<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    
    public function boot(): void
    {

        
        Vite::prefetch(concurrency: 3);
        App::setLocale("fa");
        Gate::policy(User::class ,UserPolicy::class);
        Gate::policy(Post::class ,PostPolicy::class);
        Gate::policy(Category::class ,CategoryPolicy::class);


    }
}
