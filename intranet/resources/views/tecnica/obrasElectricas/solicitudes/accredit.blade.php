<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="solicitudes"></x-navbars.sidebar>
    <main class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Acreditar Solicitud'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        <x-tecnica.obras-electricas.datos-solicitud :solicitud="$solicitud" />
                        <div class="row d-flex justify-content-center align-items-center">
                            <button class="btn btn-warning bg-gradient-dark mx-2 open-scanner mb-3 col-md-5"
                                data-soe-id="{{ $solicitud->SOE_ID }}" title="Generar Documento PDF" type="button">
                                Acreditar Solicitud
                            </button>
                            <button type="button" class="btn btn-danger mx-2 mb-3 col-md-2"
                                onclick="window.location.href='{{ route('solicitudes') }}'">
                                Volver
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.open-scanner').forEach(button => {
                    button.addEventListener('click', function() {
                        const soeId = this.getAttribute('data-soe-id');
                        if (soeId) {
                            const username = {!! @json_encode(Auth::user()->USU_CODIGO) !!};
                            window.location.href = `wndScanningProtocol:${soeId}:${username}`;
                        } else {
                            alert('El SOE_ID no está disponible.');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layout>
