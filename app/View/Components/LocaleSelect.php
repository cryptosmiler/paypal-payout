<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LocaleSelect extends Component
{
    public string $sLocale;
    public bool $isSearch;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $sLocale = "en", 
        $isSearch = false
    )
    {
        $this->sLocale = $sLocale;
        $this->isSearch = $isSearch;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.locale-select');
    }
}
