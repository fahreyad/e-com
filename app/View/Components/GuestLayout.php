<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GuestLayout extends Component
{

    public $title;

    /**
     * Create a new component instance.
     *
     * @param string|null $title
     * @return void
     */
    public function __construct($title = null)
    {
        // Provide a default fallback if needed
        $this->title = $title ?? config('app.name', 'Laravel');
    }
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.guest');
    }
}
