<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $layout, $dir, $assets, $modalJs;

    public function __construct($layout = '', $dir=false, $assets = [], $modalJs = false)
    {
        $this->layout = $layout;
        $this->dir = $dir;
        $this->assets = $assets;
        $this->modalJs = $modalJs;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.dashboard');
        
    }
}
