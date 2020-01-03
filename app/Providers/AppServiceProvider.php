<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register the services that are only used for development
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
            $this->app->register('Backpack\Generators\GeneratorsServiceProvider');
        }
        $this->app->singleton(
            \App\Repositories\Contracts\CategoryRepositoryInterface::class,
            \App\Repositories\CategoryEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\VideoRepositoryInterface::class,
            \App\Repositories\VideoEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Repositories\UserEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\AlbumRepositoryInterface::class,
            \App\Repositories\AlbumEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\CreatorRepositoryInterface::class,
            \App\Repositories\CreatorEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\TopicRepositoryInterface::class,
            \App\Repositories\TopicEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\PlaylistRepositoryInterface::class,
            \App\Repositories\PlaylistEloquentRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contracts\AudioRepositoryInterface::class,
            \App\Repositories\AudioEloquentRepository::class
        );
       
    }
}
