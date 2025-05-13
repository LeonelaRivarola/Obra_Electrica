<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="solicitud"></x-navbars.sidebar>
    <main class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Presupuestar Solicitud'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4"></div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        <!-- Datos generales -->
                        <x-tecnica.obras-electricas.datos-solicitud :solicitud="$solicitud" :editSubestacion="true" />
                        <hr>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="archivo" class="form-label">Adjuntar Archivo</label>
                                <input type="file" class="form-control border border-2 p-2" id="archivo"
                                    name="archivo" onchange="habilitarModal()">
                            </div>
                        </div>
                        <hr>
                        <!-- Formulario de Presupuesto -->
                        <form method="POST" action="{{ route('crear-presupuesto') }}" enctype="multipart/form-data"
                            id="formPresupuesto">
                            @csrf
                            <input type="hidden" name="emailNotificar" id="emailNotificar" value="0">
                            <input type="hidden" name="solicitud" id="solicitud" value="{{ $solicitud->SOE_ID }}">
                            <input type="hidden" name="subestacion" id="hiddenSubestacion">
                            <input type="hidden" name="nombre" id="nombreHidden">
                            <input type="hidden" name="emailDestino" id="emailDestinoHidden">
                            <input type="hidden" name="emailOrigen" id="emailOrigenHidden">
                            <input type="hidden" name="emailAsunto" id="emailAsuntoHidden">
                            <input type="hidden" name="emailMensaje" id="emailMensajeHidden">
                            <div class="row d-flex justify-content-center align-items-center">
                                <a href="{{ route('solicitudes') }}"
                                    class="btn btn-danger mx-2 mb-3 col-md-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Email -->
        <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Notificación por Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            onclick="limpiarArchivo()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="checkEmail" checked
                                onchange="mostrarCamposEmail()">
                            <label class="form-check-label" for="checkEmail">¿Notificar vía e-mail?</label>
                        </div>
                        <div id="camposEmail" class="mt-3">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="emailDestino" class="form-label">Email Destino</label>
                                    <input type="email" class="form-control" id="emailDestino" name="emailDestino"
                                        value="{{ $solicitud->SOE_EMAIL }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="emailOrigen" class="form-label">Email Origen</label>
                                    <input type="email" class="form-control" id="emailOrigen" name="emailOrigen"
                                        value="otecnica_electrico1@corpico.com.ar" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="emailAsunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="emailAsunto" name="emailAsunto"
                                    value="Solicitud de Obra Eléctrica Presupuestada" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="emailMensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="emailMensaje" name="emailMensaje" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="limpiarArchivo()">Cancelar</button>
                        <button type="button" class="btn btn-primary"
                            onclick="enviarFormulario()">Presupuestar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Procesar -->
        <x-tecnica.obras-electricas.modal-procesar />
    </main>
    @push('js')
        <script>
            function habilitarModal() {
                if (document.getElementById('archivo').files.length > 0) {
                    new bootstrap.Modal(document.getElementById('emailModal')).show();
                    const checkEmail = document.getElementById('checkEmail');
                    checkEmail.checked = true;
                    mostrarCamposEmail();

                    const emailMensaje = document.getElementById('emailMensaje');
                    emailMensaje.value =
                        `A quien corresponda,\nSe informa que la solicitud de obra N°{{ $solicitud->SOE_ID }}, a nombre de {{ $solicitud->SOE_NOMBRE }} {{ $solicitud->SOE_APELLIDO }}, ha sido presupuestada.`;
                }
            }

            function limpiarArchivo() {
                const archivoInput = document.getElementById('archivo');
                archivoInput.value = "";
            }

            function mostrarCamposEmail() {
                let campos = document.getElementById('camposEmail');
                let check = document.getElementById('checkEmail');
                document.getElementById('emailNotificar').value = check.checked ? "1" : "0";
                campos.style.display = check.checked ? "block" : "none";
            }

            function enviarFormulario() {
                let check = document.getElementById('checkEmail');
                const archivoInput = document.getElementById('archivo');
                const archivo = archivoInput.files[0].name;
                document.getElementById('nombreHidden').value = archivo;
                document.getElementById('hiddenSubestacion').value = document.querySelector('input[name="subestacion"]').value;

                if (check.checked) {
                    document.getElementById('emailDestinoHidden').value = document.getElementById('emailDestino').value;
                    document.getElementById('emailOrigenHidden').value = document.getElementById('emailOrigen').value;
                    document.getElementById('emailAsuntoHidden').value = document.getElementById('emailAsunto').value;
                    document.getElementById('emailMensajeHidden').value = document.getElementById('emailMensaje').value;
                    document.getElementById('emailNotificar').value = '1';
                } else {
                    document.getElementById('emailNotificar').value = '0';
                }
                const modalProcesar = new bootstrap.Modal(document.getElementById('modalProcesar'));
                modalProcesar.show();
                document.getElementById('formPresupuesto').submit();
            }
        </script>
    @endpush
</x-layout>
