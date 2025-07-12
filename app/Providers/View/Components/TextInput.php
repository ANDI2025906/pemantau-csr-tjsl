<?php

namespace App\Providers\View\Components;

use Illuminate\View\Component;

class TextInput extends Component
{
    /**
     * Indicates if the input is disabled.
     *
     * @var bool
     */
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @param  bool  $disabled
     * @return void
     */
    public function __construct($disabled = false)
    {
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.text-input');
    }
}