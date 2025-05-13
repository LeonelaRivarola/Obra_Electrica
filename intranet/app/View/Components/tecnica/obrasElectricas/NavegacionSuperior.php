<?php

namespace App\View\Components\tecnica\obrasElectricas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavegacionSuperior extends Component
{
    public $solicitud;

    /**
     * Create a new component instance.
     */
    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tecnica.obras-electricas.navegacion-superior');
    }
}
