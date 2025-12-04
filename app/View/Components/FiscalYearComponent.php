<?php

namespace App\View\Components;

use App\FiscalYear;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Request;

class FiscalYearComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $fiscalYears;
    public $routeName;
    public function __construct()
    {
        $this->fiscalYears=FiscalYear::latest()->get();
        $this->routeName=Request::route()->getName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.fiscal-year-component');
    }
}
