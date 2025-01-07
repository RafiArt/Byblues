<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DashboardLayout extends Component
{

    public function render(): View
    {
        return view('layouts.dashboard');
    }
}
