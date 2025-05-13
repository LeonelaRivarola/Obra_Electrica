<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="acreditar-solicitud"></x-navbars.sidebar>
    <main class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Observar Solicitud"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
                <div class="card card-body mx-3 mx-md-4">
                    <div class="card card-plain h-100">
                        <div class="card-body p-3">
                            <!-- Datos generales -->
                            <x-tecnica.obras-electricas.datos-solicitud :solicitud="$solicitud" />
                            <hr>
                            <!-- Formulario de Observación -->
                            <div class="row">
                                <form id="observacionForm" method="POST" action="{{ route('crear-observacion') }}"
                                    class="w-100">
                                    @csrf
                                    <input type="hidden" name="soe_id" value="{{ $solicitud->SOE_ID }}">
                                    <input type="hidden" name="emailDestino" id="emailDestino">
                                    <input type="hidden" name="emailOrigen" id="emailOrigen">
                                    <input type="hidden" name="emailAsunto" id="emailAsunto">
                                    <input type="hidden" name="emailMensaje" id="emailMensaje">
                                    <input type="hidden" name="emailNotificar" id="emailNotificar">

                                    <div class="mb-3 col-12">
                                        <label class="form-label">Observación</label>
                                        <textarea name="observacion" class="form-control border border-2 p-2" id="observacion" required></textarea>
                                        @error('observacion')
                                            <p class="text-danger inputerror">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <button type="button" id="btnObservar"
                                            class="btn btn-warning bg-gradient-dark mx-2 mb-3 col-md-2" disabled>
                                            Observar
                                        </button>
                                        <button type="button" class="btn btn-danger mx-2 mb-3 col-md-2"
                                            onclick="window.location.href='{{ route('mostrar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}'">
                                            Volver
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal de Confirmación para Observación -->
            <div class="modal fade" id="confirmModal-{{ $solicitud->SOE_ID }}" tabindex="-1" role="dialog"
                aria-labelledby="confirmModalLabel-{{ $solicitud->SOE_ID }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel-{{ $solicitud->SOE_ID }}">
                                Confirmar Observación
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" id="checkEmail-{{ $solicitud->SOE_ID }}"
                                        name="notificarEmailModal" class="form-check-input" checked
                                        onchange="toggleEmailFields({{ $solicitud->SOE_ID }}, this.checked)">
                                    <label class="form-check-label" for="checkEmail-{{ $solicitud->SOE_ID }}">
                                        Notificar vía e-mail
                                    </label>
                                </div>
                            </div>
                            <!-- Campos de Email -->
                            <div id="emailFields-{{ $solicitud->SOE_ID }}">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="emailDestino-{{ $solicitud->SOE_ID }}" class="form-label">Email
                                            Destino</label>
                                        <input type="email" id="emailDestino-{{ $solicitud->SOE_ID }}"
                                            name="emailDestinoModal" class="form-control"
                                            value="{{ $solicitud->SOE_EMAIL }}" readonly>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="emailOrigen-{{ $solicitud->SOE_ID }}" class="form-label">Email
                                            Origen</label>
                                        <input type="email" id="emailOrigen-{{ $solicitud->SOE_ID }}"
                                            name="emailOrigenModal" class="form-control"
                                            value="otecnica_electrico1@corpico.com.ar" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="emailAsunto-{{ $solicitud->SOE_ID }}"
                                            class="form-label">Asunto</label>
                                        <input type="text" id="emailAsunto-{{ $solicitud->SOE_ID }}"
                                            name="emailAsuntoModal" class="form-control"
                                            value="Solicitud de Obra Eléctrica Observada" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="emailMensaje-{{ $solicitud->SOE_ID }}"
                                            class="form-label">Mensaje</label>
                                        <textarea id="emailMensaje-{{ $solicitud->SOE_ID }}" name="emailMensajeModal" class="form-control" rows="4"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" id="confirmBtn-{{ $solicitud->SOE_ID }}" class="btn btn-primary"
                                onclick="onConfirm({{ $solicitud->SOE_ID }})">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Procesar -->
        <x-tecnica.obras-electricas.modal-procesar />
        <x-footers.auth></x-footers.auth>
    </main>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const observacionTextarea = document.getElementById('observacion');
                const btnObservar = document.getElementById('btnObservar');

                observacionTextarea.addEventListener('input', function() {
                    const hasText = this.value.trim().length > 0;
                    btnObservar.disabled = !hasText;
                    updateEmailMessage({{ $solicitud->SOE_ID }}, this.value.trim());
                });

                btnObservar.addEventListener('click', function(event) {
                    event.preventDefault();
                    const modalEl = document.getElementById('confirmModal-{{ $solicitud->SOE_ID }}');
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                });
            });

            function updateEmailMessage(solicitudId, observacion) {
                const emailMensaje = document.getElementById('emailMensaje-' + solicitudId);
                if (emailMensaje) {
                    emailMensaje.value =
                        `A quien corresponda,\nSe informa que la solicitud de obra N° {{ $solicitud->SOE_ID }} a nombre de {{ $solicitud->SOE_APELLIDO }}, {{ $solicitud->SOE_NOMBRE }} ha sido observada.\nMotivo de observación: ${observacion}`;
                }
            }

            function toggleEmailFields(solicitudId, checked) {
                const camposEmail = document.getElementById('emailFields-' + solicitudId);
                if (checked) {
                    camposEmail.style.display = 'block';
                    const observacion = document.getElementById('observacion').value.trim();
                    updateEmailMessage(solicitudId, observacion);
                } else {
                    camposEmail.style.display = 'none';
                }
            }

            function onConfirm(solicitudId) {
                const form = document.getElementById('observacionForm');

                const checkEmail = document.getElementById('checkEmail-' + solicitudId);
                document.getElementById('emailNotificar').value = checkEmail.checked ? 1 : 0;

                if (checkEmail.checked) {
                    document.getElementById('emailDestino').value = document.getElementById('emailDestino-' + solicitudId)
                        .value;
                    document.getElementById('emailOrigen').value = document.getElementById('emailOrigen-' + solicitudId)
                        .value;
                    document.getElementById('emailAsunto').value = document.getElementById('emailAsunto-' + solicitudId)
                        .value;
                    document.getElementById('emailMensaje').value = document.getElementById('emailMensaje-' + solicitudId)
                        .value;
                }

                const modalProcesar = new bootstrap.Modal(document.getElementById('modalProcesar'));
                modalProcesar.show();

                form.submit();
            }
        </script>
    @endpush
</x-layout>
