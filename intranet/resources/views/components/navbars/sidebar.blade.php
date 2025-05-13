@props(['activePage'])

@php
    $institucionalActivePages = [];
    $tecnicaActivePages = [
        'obras-electricas',
        'nueva-solicitud',
        'solicitudes',
        'presupuestos',
        'tipos-obras',
        'emails',
    ];
    $obrasSubActivePages = ['nueva-solicitud', 'solicitudes', 'presupuestos', 'tipos-obras', 'emails'];
@endphp

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0 d-flex text-wrap justify-content-center" href="{{ route('index') }}">
            <img src="{{ asset('assets') }}/img/logos/gray-logos/Corpico_logo.svg" class="navbar-brand-img h-100"
                alt="main_logo">
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Dropdown Institucional -->
            <li class="nav-item">
                <a class="nav-link text-white" href="#" data-bs-toggle="collapse"
                    data-bs-target="#institucionalSubmenu" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="material-icons" style="font-size: 1.2rem;">domain</span>
                    </div>
                    <span class="nav-link-text ms-1">Institucional</span>
                </a>
                <div class="collapse" id="institucionalSubmenu" data-bs-parent="#sidenav-collapse-main">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="http://ciatinfo.com.ar/internos/" target="_blank">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <span class="material-icons" style="font-size: 1rem;">phone</span>
                                </div>
                                <span class="nav-link-text ms-1">Internos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="https://corpico.com.ar/" target="_blank">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <span class="material-icons" style="font-size: 1rem;">business</span>
                                </div>
                                <span class="nav-link-text ms-1">Corpico</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="https://app.humand.co/" target="_blank">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <span class="material-icons" style="font-size: 1rem;">group</span>
                                </div>
                                <span class="nav-link-text ms-1">Humand</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="https://sugad.corpico.com.ar/init/sso/sign-in"
                                target="_blank">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <span class="material-icons" style="font-size: 1rem;">receipt_long</span>
                                </div>
                                <span class="nav-link-text ms-1">Personal</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="https://www.instagram.com/corpico_coop/"
                                target="_blank">
                                <div
                                    class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <span class="material-icons" style="font-size: 1rem;">camera_alt</span>
                                </div>
                                <span class="nav-link-text ms-1">Instagram</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Dropdown Técnica -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, $tecnicaActivePages) ? 'active bg-gradient-primary' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#tecnicaSubmenu"
                    aria-expanded="{{ in_array($activePage, $tecnicaActivePages) ? 'true' : 'false' }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <span class="material-icons" style="font-size: 1.2rem;">electrical_services</span>
                    </div>
                    <span class="nav-link-text ms-1">Técnica</span>
                </a>
                <div class="collapse {{ in_array($activePage, $tecnicaActivePages) ? 'show' : '' }}" id="tecnicaSubmenu"
                    data-bs-parent="#sidenav-collapse-main">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ in_array($activePage, $obrasSubActivePages) ? 'active' : '' }}"
                                href="#" data-bs-toggle="collapse" data-bs-target="#obrasSubmenu"
                                aria-expanded="{{ in_array($activePage, $obrasSubActivePages) ? 'true' : 'false' }}">
                                Obras Eléctricas
                            </a>
                            <div class="collapse {{ in_array($activePage, $obrasSubActivePages) ? 'show' : '' }}"
                                id="obrasSubmenu" data-bs-parent="#tecnicaSubmenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ $activePage == 'nueva-solicitud' ? 'active bg-gradient-primary' : '' }}"
                                            href="{{ route('nueva-solicitud') }}">
                                            Nueva Solicitud
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ $activePage == 'solicitudes' ? 'active bg-gradient-primary' : '' }}"
                                            href="{{ route('solicitudes') }}">
                                            Solicitudes
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ $activePage == 'presupuestos' ? 'active bg-gradient-primary' : '' }}"
                                            href="{{ route('presupuestos') }}">
                                            Presupuestos
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ $activePage == 'tipos-obras' ? 'active bg-gradient-primary' : '' }}"
                                            href="{{ route('tipos-obras') }}">
                                            Tipos de Obras
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white {{ $activePage == 'emails' ? 'active bg-gradient-primary' : '' }}"
                                            href="{{ route('emails') }}">
                                            E-mails Solicitudes
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
