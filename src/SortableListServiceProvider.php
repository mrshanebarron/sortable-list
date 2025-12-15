<?php

namespace MrShaneBarron\SortableList;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\SortableList\Livewire\SortableList;
use MrShaneBarron\SortableList\View\Components\sortable-list as BladeSortableList;
use Livewire\Livewire;

class SortableListServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-sortable-list.php', 'sb-sortable-list');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-sortable-list');

        Livewire::component('sb-sortable-list', sortable-list::class);

        $this->loadViewComponentsAs('ld', [
            BladeSortableList::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sb-sortable-list.php' => config_path('sb-sortable-list.php'),
            ], 'sb-sortable-list-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/sb-sortable-list'),
            ], 'sb-sortable-list-views');
        }
    }
}
