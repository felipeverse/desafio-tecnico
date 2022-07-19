<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $implementationPath = 'App\\Repositories\\';
    protected $implementationName = 'Eloquent';
    protected $interfacePath = 'App\\Repositories\\Contracts\\';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!file_exists(app_path('Repositories/Contracts'))) {
            return false;
        }

        $interfaces = collect(scandir(app_path('Repositories/Contracts')));

        $interfaces = $interfaces->reject(
            function ($interface) {
                return in_array($interface, ['.', '..']);
            }
        )->map(
            function ($interface) {
                return str_replace('.php', '', $interface);
            }
        );

        $interfaces->each(
            function ($interface) {
                $this->app->bind(
                    $this->interfacePath . $interface,
                    $this->implementationPath . $interface . $this->implementationName
                );
            }
        );
    }
}
