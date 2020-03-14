<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;


/**
 * We use RepositoryServiceProvider for binding the interfaces to repositories in the service container app.
 */

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array $repositories holds the interfaces and the implementations
     * 
     */
    protected $repositories = [
        CategoryContract::class => CategoryRepository::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach( $this->repositories as $interface => $implementation){
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
