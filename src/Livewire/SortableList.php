<?php

namespace MrShaneBarron\SortableList\Livewire;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class SortableList extends Component
{
    #[Modelable]
    public array $items = [];
    
    public bool $handle = false;
    public string $direction = 'vertical';

    public function mount(
        array $items = [],
        bool $handle = false,
        string $direction = 'vertical'
    ): void {
        $this->items = $items;
        $this->handle = $handle;
        $this->direction = $direction;
    }

    public function reorder(array $order): void
    {
        $reordered = [];
        foreach ($order as $id) {
            foreach ($this->items as $item) {
                if ((string)($item['id'] ?? $item) === (string)$id) {
                    $reordered[] = $item;
                    break;
                }
            }
        }
        $this->items = $reordered;
        $this->dispatch('items-reordered', items: $this->items);
    }

    public function render()
    {
        return view('ld-sortable-list::livewire.sortable-list');
    }
}
