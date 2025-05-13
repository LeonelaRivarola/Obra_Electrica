<div class="row gx-4 mb-2">
    <div class="col-md-8 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <!-- Botón Volver (Siempre visible) -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-center mb-0 px-0 py-1 active"
                        href="{{ route('solicitudes') }}" role="tab">
                        <span class="material-icons">arrow_back</span>
                        <span class="ms-1">Volver</span>
                    </a>
                </li>
                <!-- Botón Editar (Siempre visible) -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-center mb-0 px-0 py-1"
                        href="{{ route('editar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}" role="tab">
                        <span class="material-icons">edit</span>
                        <span class="ms-1">Editar</span>
                    </a>
                </li>
                <!-- Botón Documento (Estados 1, 2, 3, 5, 6 y con SOE_PATH) -->
                @if (in_array($solicitud->ultimoEstado->estado->ESO_ID, [1, 2, 3, 5, 6]) && $solicitud->SOE_PATH)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-center mb-0 px-0 py-1"
                            href="{{ route('abrir-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}" target="_blank"
                            role="tab">
                            <span class="material-icons">folder_open</span>
                            <span class="ms-1">Documento</span>
                        </a>
                    </li>
                @endif
                <!-- Botón Presupuesto (Estados 1, 2, 3, 6 y con PSO_PATH) -->
                @if (in_array($solicitud->ultimoEstado->estado->ESO_ID, [1, 2, 3, 6]) &&
                        $solicitud->ultimoPresupuesto?->presupuesto?->PSO_PATH)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-center mb-0 px-0 py-1"
                            href="{{ route('abrir-presupuesto', ['solicitud' => $solicitud->SOE_ID]) }}" target="_blank"
                            role="tab">
                            <span class="material-icons">account_balance_wallet</span>
                            <span class="ms-1">Presupuesto</span>
                        </a>
                    </li>
                @endif
                <!-- Botón Observar (Todos los estados excepto 4) -->
                @if ($solicitud->ultimoEstado->estado->ESO_ID != 4)
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-center mb-0 px-0 py-1"
                            href="{{ route('observar-solicitud', ['solicitud' => $solicitud]) }}" role="tab">
                            <span class="material-icons">visibility</span>
                            <span class="ms-1">Observar</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
