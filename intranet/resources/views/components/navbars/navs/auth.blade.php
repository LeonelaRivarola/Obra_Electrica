@props(['titlePage'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <div class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <h6 class="breadcrumb-item text-sm text-dark active font-weight-bolder mb-0" aria-current="page">
                    {{ $titlePage }}</h6>
            </div>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
            {{-- <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control">
                </div>
            </div> --}}
            <div class="navbar-nav justify-content-end ms-md-auto pe-md-3 d-flex align-items-center">
                <span class="nav-link text-body font-weight-bold px-0">
                    Hola {{ auth()->user()->USU_NOMBRE }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="d-none" id="logout-form">
                @csrf
            </form>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
