<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="emails"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Emails"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="input-group input-group-outline w-25">
                                <label class="form-label">Buscar</label>
                                <input type="text" id="search-input" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Listado</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="emails-table" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="1">Destino</th>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="2">Usuario</th>
                                            <th class="text-center text-uppercase text-secondary text-xs sortable"
                                                data-col="3">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($emails as $email)
                                            <tr class="email-row" data-id="{{ $email->EMSO_ID }}">
                                                <td class="align-middle text-center">{{ $email->EMSO_DESTINO }}</td>
                                                <td class="align-middle text-center">{{ $email->EMSO_USUARIO }}</td>
                                                <td class="align-middle text-center">{{ $email->EMSO_FECHA }}</td>
                                                <td class="d-none">{{ $email->EMSO_SOLICITUD_ID }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row card-footer m-auto">
                                {{ $emails->links() }}
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
            document.addEventListener("DOMContentLoaded", function() {
                const table = document.getElementById("emails-table");
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

                // Filtro en tiempo real
                searchInput.addEventListener("input", function() {
                    const searchTerm = searchInput.value.trim().toLowerCase();


                    rows.forEach(row => {
                        const solicitudID = row.querySelector("td.d-none").textContent.trim()
                            .toLowerCase();
                        const destino = row.children[0].textContent.trim().toLowerCase();
                        const fecha = row.children[2].textContent.trim().toLowerCase();

                        const matchSolicitudID = solicitudID === searchTerm;
                        const matchDestino = destino.includes(searchTerm);
                        const matchFecha = fecha.includes(searchTerm);

                        // Mostrar la fila si coincide en cualquiera de los campos
                        const match = matchSolicitudID || matchDestino || matchFecha;
                        row.style.display = match ? "" : "none";
                    });
                });

                // Redirección al hacer doble clic
                document.querySelectorAll(".email-row").forEach(row => {
                    row.addEventListener("dblclick", function() {
                        const emailId = row.getAttribute("data-id");
                        const url = @json(route('mostrar-email', ':id')).replace(':id', emailId);
                        window.location.href = url;
                    });
                });
            });
        </script>
    @endpush
</x-layout>
