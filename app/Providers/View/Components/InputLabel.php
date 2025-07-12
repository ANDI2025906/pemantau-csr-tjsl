<?php

namespace App\Providers\View\Components;

use Illuminate\View\Component;

class InputLabel extends Component
{
    /**
     * The input label value.
     *
     * @var string
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @param  string|null  $value
     * @return void
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-label');
    }
}