<?php

namespace MrShaneBarron\sortable-list;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\sortable-list\Livewire\sortable-list;
use MrShaneBarron\sortable-list\View\Components\sortable-list as Bladesortable-list;
use Livewire\Livewire;

class sortable-listServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ld-sortable-list.php', 'ld-sortable-list');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ld-sortable-list');

        Livewire::component('ld-sortable-list', sortable-list::class);

        $this->loadViewComponentsAs('ld', [
            Bladesortable-list::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ld-sortable-list.php' => config_path('ld-sortable-list.php'),
            ], 'ld-sortable-list-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/ld-sortable-list'),
            ], 'ld-sortable-list-views');
        }
    }
}
