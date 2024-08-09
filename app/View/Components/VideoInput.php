<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class VideoInput extends Component
{
    public string $name;
    public string $videoSrc;
    public bool $isInfo;
    public int $duration;
    public int $size;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name = "video", 
        $videoSrc = "", 
        $isInfo = false, 
        $duration = 0, 
        $size = 0, 
    )
    {
        $this->name = $name;
        $this->videoSrc = $videoSrc;
        $this->isInfo = $isInfo;
        $this->duration = $duration;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.video-input');
    }
}
