<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageCropInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $requireText, 
        public string $name, 
        public string $imageSrc
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-crop-input');
    }
}
