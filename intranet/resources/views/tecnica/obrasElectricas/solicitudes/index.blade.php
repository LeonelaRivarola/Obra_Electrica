<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="solicitudes"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Solicitudes"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if (session('status') || request('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ session('status') }} {{ request('status') }}</span>
                            </div>
                        </div>
                    @endif
                    <!-- Filtro y búsqueda -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('solicitudes') }}" class="d-flex align-items-center">
                                <div class="mb-3 me-3 d-flex align-items-center">
                                    <label for="estado" class="form-label me-2">Estado:</label>
                                    <select name="estado" id="estado" class="form-select border border-2 p-2">
                                        <option value="">Todas</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado->ESO_ID }}"
                                                {{ request('estado') == $estado->ESO_ID ? 'selected' : '' }}>
                                                {{ $estado->ESO_DESCRIPCION }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn bg-gradient-dark">Filtrar</button>
                            </form>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Buscar</label>
                                <input type="text" id="search-input" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Tabla de Solicitudes -->
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="d-flex justify-content-between align-items-center bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3">
                                <h6 class="text-white text-capitalize">Listado</h6>
                                <a href="{{ route('nueva-solicitud') }}" class="btn btn-secondary btn-sm">Nuevo
                                    Solicitud</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="solicitudes-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_ID">Número</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_FECHA">Fecha Solicitud</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="ESO_DESCRIPCION">Estado</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SES_FECHA">Fecha Estado</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_USUARIO">Usuario</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="TOE_ABREVIATURA">Tipo</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_CUIT">DNI/CUIT</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_APELLIDO">Apellido</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-sort="SOE_NOMBRE">Nombre</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitudes as $solicitud)
                                            <tr class="solicitud-row" data-id="{{ $solicitud->SOE_ID }}"
                                                style="cursor: pointer;">
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_ID }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_FECHA }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->ultimoEstado->estado->ESO_DESCRIPCION }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->ultimoEstado->SES_FECHA }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_USUARIO }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->tipos->TOE_ABREVIATURA }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_CUIT }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_APELLIDO }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $solicitud->SOE_NOMBRE }}</span>
                                                </td>
                                                <td class="align-middle text-center hidden-data" style="display: none;">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ strtolower($solicitud->SOE_CALLE) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <!-- Botón Documentar -->
                                                    @if ($solicitud->ultimoEstado->estado->ESO_ID == 4)
                                                        <a href="{{ route('acreditar-solicitud', ['solicitud' => $solicitud]) }}"
                                                            class="btn btn-sol btn-icon-only btn-facebook"
                                                            title="Documentar solicitud" type="button">
                                                            <i class="fas fa-file-upload"></i>
                                                        </a>
                                                    @endif
                                                    <!-- Botón Presupuestar -->
                                                    @if ($solicitud->ultimoEstado->estado->ESO_ID == 5 || $solicitud->ultimoEstado->estado->ESO_ID == 2)
                                                        <a href="{{ route('presupuestar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}"
                                                            class="btn btn-sol btn-icon-only btn-secondary"
                                                            title="Presupuestar solicitud" type="button">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </a>
                                                    @endif
                                                    <!-- Botón Cancelar (si la solicitud no está en estado 4 ni 3) -->
                                                    @if ($solicitud->ultimoEstado->estado->ESO_ID != 4 && $solicitud->ultimoEstado->estado->ESO_ID != 3)
                                                        <button type="button"
                                                            class="btn btn-sol btn-icon-only btn-warning"
                                                            title="Cancelar y cerrar solicitud" data-bs-toggle="modal"
                                                            data-bs-target="#cancelModalStep1-{{ $solicitud->SOE_ID }}">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    @endif
                                                    <!-- Botón Eliminar -->
                                                    @if ($solicitud->ultimoEstado->estado->ESO_ID == 4)
                                                        <form
                                                            action="{{ route('eliminar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}"
                                                            method="POST" style="display:inline;"
                                                            id="delete-form-{{ $solicitud->SOE_ID }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sol btn-icon-only btn-danger"
                                                                title="Eliminar solicitud" type="button"
                                                                onclick="confirmDelete(event, {{ $solicitud->SOE_ID }})">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!-- Modal Cancelación -->
                                            <div class="modal fade" id="cancelModalStep1-{{ $solicitud->SOE_ID }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="cancelModalStep1Label-{{ $solicitud->SOE_ID }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="cancelModalStep1Label-{{ $solicitud->SOE_ID }}">
                                                                Cancelar Solicitud</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="cancelReason-{{ $solicitud->SOE_ID }}"
                                                                    class="form-label">Motivo de Cancelación</label>
                                                                <textarea id="cancelReason-{{ $solicitud->SOE_ID }}" class="form-control" rows="3"
                                                                    oninput="onCancelReasonInput({{ $solicitud->SOE_ID }})" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="cancelStep1" class="btn btn-secondary"
                                                                onclick="limpiarTextarea('cancelReason-{{ $solicitud->SOE_ID }}', {{ $solicitud->SOE_ID }})">Cancelar</button>
                                                            <button type="button"
                                                                id="continueStep1-{{ $solicitud->SOE_ID }}"
                                                                class="btn btn-primary"
                                                                onclick="openEmailModal({{ $solicitud->SOE_ID }})"
                                                                disabled>Continuar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Email -->
                                            <div class="modal fade" id="cancelModalStep2-{{ $solicitud->SOE_ID }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="cancelModalStep2Label-{{ $solicitud->SOE_ID }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <form id="cancel-form-{{ $solicitud->SOE_ID }}"
                                                            action="{{ route('cancelar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="soe_id"
                                                                value="{{ $solicitud->SOE_ID }}">
                                                            <input type="hidden" name="observacion"
                                                                id="hiddenObservacion-{{ $solicitud->SOE_ID }}">
                                                            <input type="hidden" name="notificarEmail"
                                                                id="hiddenEmailNotificar-{{ $solicitud->SOE_ID }}">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="cancelModalStep2Label-{{ $solicitud->SOE_ID }}">
                                                                    Notificar Cancelación por E-mail
                                                                </h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 form-check form-switch">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="checkEmail-{{ $solicitud->SOE_ID }}"
                                                                        name="notificarEmail" checked
                                                                        onchange="toggleEmailFields({{ $solicitud->SOE_ID }})">
                                                                    <label class="form-check-label"
                                                                        for="checkEmail-{{ $solicitud->SOE_ID }}">¿Notificar
                                                                        vía e-mail?</label>
                                                                </div>
                                                                <div id="emailFields-{{ $solicitud->SOE_ID }}">
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-6">
                                                                            <label
                                                                                for="emailDestino-{{ $solicitud->SOE_ID }}"
                                                                                class="form-label">Email
                                                                                Destino</label>
                                                                            <input type="email"
                                                                                id="emailDestino-{{ $solicitud->SOE_ID }}"
                                                                                name="emailDestino"
                                                                                class="form-control"
                                                                                value="{{ $solicitud->SOE_EMAIL }}"
                                                                                readonly>
                                                                        </div>
                                                                        <div class="mb-3 col-md-6">
                                                                            <label
                                                                                for="emailOrigen-{{ $solicitud->SOE_ID }}"
                                                                                class="form-label">Email Origen</label>
                                                                            <input type="email"
                                                                                id="emailOrigen-{{ $solicitud->SOE_ID }}"
                                                                                name="emailOrigen"
                                                                                class="form-control"
                                                                                value="otecnica_electrico1@corpico.com.ar"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-12">
                                                                            <label
                                                                                for="emailAsunto-{{ $solicitud->SOE_ID }}"
                                                                                class="form-label">Asunto</label>
                                                                            <input type="text"
                                                                                id="emailAsunto-{{ $solicitud->SOE_ID }}"
                                                                                name="emailAsunto"
                                                                                class="form-control"
                                                                                value="Solicitud de Obra Eléctrica Cancelada"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="mb-3 col-md-12">
                                                                            <label
                                                                                for="emailMensaje-{{ $solicitud->SOE_ID }}"
                                                                                class="form-label">Mensaje</label>
                                                                            <textarea id="emailMensaje-{{ $solicitud->SOE_ID }}" name="emailMensaje" class="form-control" rows="4"
                                                                                required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal"
                                                                    onclick="openStep1Modal({{ $solicitud->SOE_ID }})">Volver</button>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="onContinue({{ $solicitud->SOE_ID }})">Aceptar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row card-footer m-auto">
                                {{ $solicitudes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
        <!-- Modal Procesando -->
        <x-tecnica.obras-electricas.modal-procesar />
        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Advertencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Estás seguro de eliminar la Solicitud?</p>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" id="confirmEliminar">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('js')
        <script>
            function confirmDelete(event, solicitudId) {
                event.preventDefault();
                $('#modalEliminar').modal('show');
                $('#confirmEliminar').off('click').on('click', function() {
                    document.getElementById('delete-form-' + solicitudId).submit();
                });
            }

            function limpiarTextarea(idTextarea, solicitudId) {
                document.getElementById(idTextarea).value = '';
                let modal = document.getElementById('cancelModalStep1-' + solicitudId);
                let modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.hide();
                }
            }

            function onCancelReasonInput(solicitudId) {
                var reasonElem = document.getElementById('cancelReason-' + solicitudId);
                var continueBtn = document.getElementById('continueStep1-' + solicitudId);
                var text = reasonElem.value.trim();
                continueBtn.disabled = (text.length === 0);
            }

            function openEmailModal(solicitudId) {
                var reasonElem = document.getElementById('cancelReason-' + solicitudId);
                var reason = reasonElem.value.trim();
                var modalStep1El = document.getElementById('cancelModalStep1-' + solicitudId);
                var modalStep1 = bootstrap.Modal.getInstance(modalStep1El);
                if (modalStep1) {
                    modalStep1.hide();
                }
                document.getElementById('hiddenObservacion-' + solicitudId).value = reason;
                updateEmailMessage(solicitudId, reason);
                var modalStep2El = document.getElementById('cancelModalStep2-' + solicitudId);
                var modalStep2 = new bootstrap.Modal(modalStep2El);
                modalStep2.show();
            }

            function openStep1Modal(solicitudId) {
                var modalStep2El = document.getElementById('cancelModalStep2-' + solicitudId);
                var modalStep2 = bootstrap.Modal.getInstance(modalStep2El);
                if (modalStep2) {
                    modalStep2.hide();
                }
                var modalStep1El = document.getElementById('cancelModalStep1-' + solicitudId);
                var modalStep1 = new bootstrap.Modal(modalStep1El);
                modalStep1.show();
            }

            function toggleEmailFields(solicitudId, forceShow) {
                var checkEmail = document.getElementById('checkEmail-' + solicitudId);
                var emailFields = document.getElementById('emailFields-' + solicitudId);
                var show = (forceShow !== undefined) ? forceShow : checkEmail.checked;

                if (show) {
                    emailFields.style.display = 'block';
                    emailFields.querySelectorAll('input, textarea').forEach(function(el) {
                        el.disabled = false;
                    });
                    var reasonElem = document.getElementById('cancelReason-' + solicitudId);
                    var reason = reasonElem ? reasonElem.value.trim() : '';
                    updateEmailMessage(solicitudId, reason);
                } else {
                    emailFields.style.display = 'none';
                    emailFields.querySelectorAll('input, textarea').forEach(function(el) {
                        el.disabled = true;
                    });
                    var emailMensaje = document.getElementById('emailMensaje-' + solicitudId);
                    if (emailMensaje) {
                        emailMensaje.value = '';
                    }
                }
            }

            function updateEmailMessage(solicitudId, observacion) {
                var emailMensaje = document.getElementById('emailMensaje-' + solicitudId);
                if (emailMensaje) {
                    var mensaje =
                        `A quien corresponda,\nSe informa que la solicitud de obra N° ${solicitudId} ha sido cancelada.\nMotivo de cancelación: ${observacion}`;
                    emailMensaje.value = mensaje;
                    emailMensaje.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                } else {
                    console.error("No se encontró el textarea con ID: emailMensaje-" + solicitudId);
                }
            }

            function onContinue(solicitudId) {
                var checkEmail = document.getElementById('checkEmail-' + solicitudId);
                document.getElementById('hiddenEmailNotificar-' + solicitudId).value = checkEmail.checked ? 1 : 0;
                mostrarModalProcesandoYEnviar(solicitudId);
            }

            function mostrarModalProcesandoYEnviar(solicitudId) {
                var modalProcesandoEl = document.getElementById('modalProcesar');
                var modalProcesando = new bootstrap.Modal(modalProcesandoEl);
                modalProcesando.show();
                setTimeout(function() {
                    document.getElementById('cancel-form-' + solicitudId).submit();
                }, 800);
            }

            // --- Funciones auxiliares (ordenamiento, búsqueda, etc.) ---
            $(document).ready(function() {
                $('.solicitud-row').on('dblclick', function() {
                    var solicitudId = $(this).data('id');
                    window.location.href = "{{ route('mostrar-solicitud', ':id') }}".replace(':id',
                        solicitudId);
                });

                const table = document.getElementById('solicitudes-table');
                const headers = table.querySelectorAll('.sortable');
                headers.forEach(header => {
                    header.addEventListener('click', function() {
                        const tableBody = table.querySelector('tbody');
                        const rows = Array.from(tableBody.querySelectorAll('tr'));
                        const column = header.dataset.sort;
                        const isAscending = header.classList.contains('asc');
                        rows.sort((a, b) => {
                            const aText = a.cells[header.cellIndex].textContent.trim();
                            const bText = b.cells[header.cellIndex].textContent.trim();
                            if (column.includes('FECHA')) {
                                return isAscending ? new Date(aText) - new Date(bText) :
                                    new Date(bText) - new Date(aText);
                            }
                            return isAscending ? aText.localeCompare(bText) : bText
                                .localeCompare(aText);
                        });
                        table.querySelector('tbody').innerHTML = '';
                        table.querySelector('tbody').append(...rows);
                        headers.forEach(h => h.classList.remove('asc', 'desc'));
                        header.classList.toggle('asc', !isAscending);
                        header.classList.toggle('desc', isAscending);
                    });
                });

                $('#search-input').on('input', function() {
                    var searchText = $(this).val().toLowerCase().trim();
                    $('#solicitudes-table tbody tr').each(function() {
                        var calle = $(this).find('.hidden-data').text().toLowerCase().trim();
                        var apellido = $(this).find('td:nth-child(8)').text().toLowerCase().trim();
                        if (calle.includes(searchText) || apellido.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });

                setTimeout(function() {
                    var alertElement = document.querySelector('.alert');
                    if (alertElement) {
                        new bootstrap.Alert(alertElement).close();
                    }
                }, 1500);
            });
        </script>
    @endpush
</x-layout>
