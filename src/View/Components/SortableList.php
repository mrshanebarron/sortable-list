<?php

namespace MrShaneBarron\SortableList\View\Components;

use Illuminate\View\Component;

class SortableList extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('sb-sortable-list::components.sortable-list');
    }
}
