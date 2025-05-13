<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="emails"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Detalle de Email'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-md-4 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <!-- Botón Volver -->
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="{{ route('emails') }}"
                                        role="tab">
                                        <i class="fa-solid fa-reply"></i>
                                        <span class="ms-1">Volver</span>
                                    </a>
                                </li>
                                <!-- Botón Imprimir -->
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" href="javascript:void(0);" role="tab"
                                        id="print-btn">
                                        <i class="fa-solid fa-print"></i>
                                        <span class="ms-1">Imprimir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row print-section">
                    <div class="col-12">
                        <div class="row">
                            <div class="card-header pb-0 p-3 d-flex justify-content-center align-content-center">
                                <h6 class="mb-0 display-5">Solicitud {{ $email->EMSO_SOLICITUD_ID }}
                                </h6>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control border border-2 p-2"
                                    value="{{ old('nombre', $email->solicitud->SOE_NOMBRE) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control border border-2 p-2"
                                    value="{{ old('apellido', $email->solicitud->SOE_APELLIDO) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email Destino</label>
                                <input type="text" name="destino" class="form-control border border-2 p-2"
                                    value="{{ old('destino', $email->EMSO_DESTINO) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email Origen</label>
                                <input type="text" name="origen" class="form-control border border-2 p-2"
                                    value="{{ old('origen', $email->EMSO_ORIGEN) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email Asunto</label>
                                <input type="text" name="asunto" class="form-control border border-2 p-2"
                                    value="{{ old('asunto', $email->EMSO_ASUNTO) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Email Mensaje</label>
                                <textarea name="mensaje" class="form-control border border-2 p-2" rows="6" readonly>{{ old('mensaje', $email->EMSO_MENSAJE) }}</textarea>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Usuario Emisor</label>
                                <input type="text" name="usuario" class="form-control border border-2 p-2"
                                    value="{{ old('usuario', $email->EMSO_USUARIO) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Fecha Emisión</label>
                                <input type="text" name="fecha" class="form-control border border-2 p-2"
                                    value="{{ old('fecha', $email->EMSO_FECHA) }}" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Archivo Adjunto</label>
                                <input type="email" name="adjunto" class="form-control border border-2 p-2"
                                    value="{{ old('adjunto', $email->EMSO_ADJUNTO) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    @push('js')
        <script>
            document.getElementById('print-btn').addEventListener('click', function() {
                var contentToPrint = document.querySelector('.print-section');
                var bodyContent = document.body.innerHTML;
                var printSectionHTML = contentToPrint.innerHTML;
                document.body.innerHTML = printSectionHTML;
                window.print();
                document.body.innerHTML = bodyContent;
            });
        </script>
    @endpush
</x-layout>
