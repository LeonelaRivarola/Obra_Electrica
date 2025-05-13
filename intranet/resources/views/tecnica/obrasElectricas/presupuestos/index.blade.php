<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="presupuestos"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Presupuestos"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="row align-items-center">
                        <!-- Campo de Búsqueda -->
                        <div class="d-flex justify-content-end mb-3">
                            <div class="input-group input-group-outline w-25">
                                <label class="form-label">Buscar</label>
                                <input type="text" id="search-input" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- Tabla de datos -->
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Listado</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="presupuestos-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-col="0">
                                                Apellido <i class="fas fa-sort"></i>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-col="1">
                                                Nombre <i class="fas fa-sort"></i>
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 sortable"
                                                data-col="3">
                                                Presupuesto <i class="fas fa-sort"></i>
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($archivosConDatos as $data)
                                            <tr>
                                                <td class="align-middle text-center">{{ $data['apellido'] }}</td>
                                                <td class="align-middle text-center">{{ $data['nombre'] }}</td>
                                                <td class="align-middle text-center hidden-data" style="display: none;">
                                                    {{ strtolower($data['calle']) }}</td>
                                                <td class="align-middle text-center">{{ $data['archivo'] }}</td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('mostrar-presupuesto', ['presupuesto' => basename($data['ultimo_presupuesto'] ?? $data['archivo'])]) }}"
                                                        target="_blank" class="btn btn-icon btn-info"
                                                        title="Abrir archivo">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
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
    </main>

    @push('js')
        <script>
            $(document).ready(function() {
                // Búsqueda en tiempo real
                $('#search-input').on('input', function() {
                    var searchText = $(this).val().toLowerCase().trim();

                    $('#presupuestos-table tbody tr').each(function() {
                        var apellido = $(this).find('td:nth-child(1)').text().toLowerCase().trim();
                        var nombre = $(this).find('td:nth-child(2)').text().toLowerCase().trim();
                        var calle = $(this).find('.hidden-data').text().toLowerCase().trim();
                        var archivo = $(this).find('td:nth-child(4)').text().toLowerCase().trim();

                        if (apellido.includes(searchText) || nombre.includes(searchText) || calle
                            .includes(searchText) || archivo.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });

                // Ordenamiento de columnas
                $('.sortable').on('click', function() {
                    var table = $('#presupuestos-table tbody');
                    var rows = table.find('tr').toArray();
                    var columnIndex = $(this).data('col');
                    var asc = $(this).hasClass('asc');

                    rows.sort(function(a, b) {
                        var aText = $(a).find('td').eq(columnIndex).text().toLowerCase();
                        var bText = $(b).find('td').eq(columnIndex).text().toLowerCase();

                        return asc ? aText.localeCompare(bText) : bText.localeCompare(aText);
                    });

                    $(this).toggleClass('asc', !asc);
                    $(this).toggleClass('desc', asc);
                    $(this).find('i').toggleClass('fa-sort-up', !asc).toggleClass('fa-sort-down', asc);

                    table.empty().append(rows);
                });
            });
        </script>
    @endpush
</x-layout>
