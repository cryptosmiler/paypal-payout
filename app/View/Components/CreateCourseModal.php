<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreateCourseModal extends Component
{
    public $subjects;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $subjects = []
    )
    {
        $this->subjects = $subjects;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.create-course-modal');
    }
}
