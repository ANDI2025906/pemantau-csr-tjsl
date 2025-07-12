<?php

namespace App\Providers\View\Components;

use Illuminate\View\Component;

class InputError extends Component
{
    /**
     * The error messages.
     *
     * @var array|string
     */
    public $messages;

    /**
     * Create a new component instance.
     *
     * @param  array|string  $messages
     * @return void
     */
    public function __construct($messages = null)
    {
        $this->messages = $messages;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input-error');
    }
}