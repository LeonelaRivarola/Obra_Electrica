<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="solicitudes" />
    <main class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Detalle de Solicitud" />
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4"></div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <!-- Navegación superior -->
                <x-tecnica.obras-electricas.navegacion-superior :solicitud="$solicitud" />
                <!-- Detalle de Solicitud -->
                <div class="row">
                    <div class="col-12">
                        <!-- Datos generales -->
                        <x-tecnica.obras-electricas.datos-solicitud :solicitud="$solicitud" />
                        <!-- Información Estado -->
                        <x-tecnica.obras-electricas.info-estado :solicitud="$solicitud" />
                        <!-- Información Presupuesto -->
                        <x-tecnica.obras-electricas.info-presupuesto :solicitud="$solicitud" />
                        <!-- Información Observación -->
                        <x-tecnica.obras-electricas.info-observacion :solicitud="$solicitud" />
                        <!-- Botones de Acción (cuando SES_ESTADO_ID == 6) -->
                        @if ($solicitud->ultimoEstado->SES_ESTADO_ID == 6)
                            <hr>
                            <div class="d-flex justify-content-center">
                                <!-- Botón Notificar Presupuesto -->
                                <button type="button" class="btn btn-info me-2" data-bs-toggle="modal"
                                    data-bs-target="#modalEmail" onclick="habilitarModal()">
                                    <span class="material-icons">email</span>
                                    <span class="ms-1">Notificar</span>
                                </button>
                                <!-- Botón Aceptar Presupuesto -->
                                <x-tecnica.obras-electricas.btn-aceptar-presupuesto :solicitud="$solicitud" />
                                <!-- Botón Rechazar Presupuesto -->
                                <x-tecnica.obras-electricas.btn-rechazar-presupuesto :solicitud="$solicitud" />

                                <!-- Modal Email -->
                                <div class="modal fade" id="modalEmail" tabindex="-1" aria-labelledby="modalEmailLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalEmailLabel">Notificación por Email
                                                </h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-check form-switch d-none">
                                                    <input class="form-check-input" type="checkbox" id="checkEmail"
                                                        checked>
                                                    <label class="form-check-label" for="checkEmail">¿Notificar vía
                                                        e-mail?</label>
                                                </div>
                                                <div id="camposEmail" class="mt-3">
                                                    <form method="POST"
                                                        action="{{ route('notificar-presupuesto', $solicitud->SOE_ID) }}"
                                                        id="emailForm">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="emailDestino" class="form-label">Email
                                                                    Destino</label>
                                                                <input type="email" class="form-control"
                                                                    id="emailDestino" name="emailDestino"
                                                                    value="{{ $solicitud->SOE_EMAIL }}" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="emailOrigen" class="form-label">Email
                                                                    Origen</label>
                                                                <input type="email" class="form-control"
                                                                    id="emailOrigen" name="emailOrigen"
                                                                    value="otecnica_electrico1@corpico.com.ar" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="emailAsunto" class="form-label">Asunto</label>
                                                            <input type="text" class="form-control" id="emailAsunto"
                                                                name="emailAsunto"
                                                                value="Solicitud de Obra Eléctrica Presupuestada"
                                                                readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="emailMensaje" class="form-label">Mensaje</label>
                                                            <textarea class="form-control" id="emailMensaje" name="emailMensaje" rows="4" required>
                                                            </textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="enviarFormulario()">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($solicitud->ultimoEstado->SES_ESTADO_ID == 1)
                            <hr>
                            <div class="d-flex justify-content-center">
                                <!-- Botón Finalizar Solicitud-->
                                <x-tecnica.obras-electricas.btn-finalizar-solicitud :solicitud="$solicitud" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <x-footers.auth />
        </div>
        <!-- Modal de procesar -->
        <x-tecnica.obras-electricas.modal-procesar />
    </main>
    @push('js')
        <script>
            function habilitarModal() {
                const emailMensaje = document.getElementById('emailMensaje');
                emailMensaje.value =
                    `A quien corresponda,\nSe informa que la solicitud de obra N°{{ $solicitud->SOE_ID }}, a nombre de {{ $solicitud->SOE_NOMBRE }} {{ $solicitud->SOE_APELLIDO }}, ha sido presupuestada {{ $solicitud->ultimoPresupuesto?->SPR_FECHA ? 'el ' . $solicitud->ultimoPresupuesto->SPR_FECHA : '' }}.`;
            }

            // Habilitar/deshabilitar campo de observación
            document.getElementById('habilitarObservacion').addEventListener('change', function() {
                const campoObservacion = document.getElementById('campoObservacion');
                campoObservacion.disabled = !this.checked;
            });

            document.addEventListener("DOMContentLoaded", function() {
                const modalEmail = new bootstrap.Modal(document.getElementById("modalEmail"));
                const modalProcesar = new bootstrap.Modal(document.getElementById("modalProcesar"));
                const emailForm = document.getElementById("emailForm");

                function enviarFormulario() {
                    modalEmail.hide();
                    modalProcesar.show();
                    setTimeout(() => {
                        emailForm.submit();
                    }, 800);
                }

                window.enviarFormulario = enviarFormulario;
            });
        </script>
    @endpush
</x-layout>
