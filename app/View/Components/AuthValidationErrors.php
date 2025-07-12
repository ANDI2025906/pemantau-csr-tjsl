<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthValidationErrors extends Component
{
    /**
     * The error messages.
     *
     * @var array|\Illuminate\Support\MessageBag
     */
    public $errors;

    /**
     * Create a new component instance.
     *
     * @param array|\Illuminate\Support\MessageBag $errors
     * @return void
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auth-validation-errors');
    }
}