<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tipos-obras"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Tipos de Obras"></x-navbars.navs.auth>
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
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="d-flex justify-content-between align-items-center bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3">
                                <h6 class="text-white text-capitalize">Listado</h6>
                                <a href="{{ route('crear-tipoObra') }}" class="btn btn-success btn-sm">Nuevo Tipo de
                                    Obra</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="tipos-obras-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="1">Abreviatura</th>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="2">Descripcion</th>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="3">Interno</th>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tiposObras as $tipoObra)
                                            <tr class="solicitud-row" data-id="{{ $tipoObra->TOE_ID }}">
                                                <td class="align-middle text-center">{{ $tipoObra->TOE_ABREVIATURA }}
                                                </td>
                                                <td class="align-middle text-center">{{ $tipoObra->TOE_DESCRIPCION }}
                                                </td>
                                                <td class="align-middle text-center">{{ $tipoObra->TOE_INTERNO }}</td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('editar-tipoObra', ['tipoObra' => $tipoObra]) }}"
                                                        class="btn btn-sol btn-icon-only btn-facebook"
                                                        title="Editar Tipo de Obra" type="button">
                                                        <i class="fas fa-file-upload"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('eliminar-tipoObra', ['tipoObra' => $tipoObra->TOE_ID]) }}"
                                                        method="POST" style="display:inline;"
                                                        id="delete-form-{{ $tipoObra->TOE_ID }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sol btn-icon-only btn-danger"
                                                            title="Eliminar Tipo de Obra" type="button"
                                                            onclick="confirmDelete(event, {{ $tipoObra->TOE_ID }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">Advertencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>¿Estás seguro de eliminar el Tipo de Obra?</p>
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
            function confirmDelete(event, tipoObraId) {
                event.preventDefault();
                $('#modalEliminar').modal('show');
                $('#confirmEliminar').off('click').on('click', function() {
                    document.getElementById('delete-form-' + tipoObraId).submit();
                });
            }

            $(document).ready(function() {
                const table = document.getElementById("tipos-obras-table");
                const searchInput = document.getElementById("search-input");
                const rows = Array.from(table.querySelectorAll("tbody tr"));

                // Ordenamiento
                document.querySelectorAll(".sortable").forEach(header => {
                    header.addEventListener("click", function() {
                        const colIndex = Array.from(header.parentNode.children).indexOf(header);
                        const ascending = !header.classList.contains("asc");

                        rows.sort((a, b) => {
                            let cellA = a.children[colIndex].textContent.trim().toLowerCase();
                            let cellB = b.children[colIndex].textContent.trim().toLowerCase();

                            if (colIndex === 3) {
                                cellA = a.children[colIndex].dataset.fecha;
                                cellB = b.children[colIndex].dataset.fecha;
                            }

                            return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(
                                cellA);
                        });

                        rows.forEach(row => table.querySelector("tbody").appendChild(row));

                        // Resetear clases de ordenación
                        document.querySelectorAll(".sortable").forEach(el => el.classList.remove("asc",
                            "desc"));
                        header.classList.add(ascending ? "asc" : "desc");
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
