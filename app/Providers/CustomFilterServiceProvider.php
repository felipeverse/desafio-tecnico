<?php

namespace App\Providers;

use Sanitizer;
use Illuminate\Support\ServiceProvider;

class CustomFilterServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (class_exists('Waavi\Sanitizer\Laravel\SanitizerServiceProvider')) {
            $filters = collect(scandir(app_path('Filters')));

            $filters->reject(function ($filter) {
                return in_array($filter, ['.', '..']);
            })
            ->map(function ($filter) {
                return 'App\\Filters\\' . str_replace('.php', '', $filter);
            })
            ->each(function ($filter) {
                $filter = new $filter();
                Sanitizer::extend($filter->name, get_class($filter));
            });
        }
    }
}
