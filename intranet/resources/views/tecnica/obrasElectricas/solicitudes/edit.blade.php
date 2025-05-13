<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="solicitudes"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Editar Solicitud'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Editar Datos de la Solicitud</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status'))
                            <div class="row">
                                <div class="alert alert-success alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ session('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('actualizar-solicitud', $solicitud->SOE_ID) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Titular</h6>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">DNI/CUIT</label>
                                    <input type="text" name="cuit" class="form-control border border-2 p-2"
                                        value="{{ old('cuit', $solicitud->SOE_CUIT) }}" required>
                                    @error('cuit')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control border border-2 p-2"
                                        value="{{ old('nombre', $solicitud->SOE_NOMBRE) }}" required>
                                    @error('nombre')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Apellido</label>
                                    <input type="text" name="apellido" class="form-control border border-2 p-2"
                                        value="{{ old('apellido', $solicitud->SOE_APELLIDO) }}" required>
                                    @error('apellido')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                @if ($solicitud->ultimoEstado->estado->ESO_ID != 4)
                                    <div class="card-header pb-0 p-3">
                                        <h6 class="mb-0">Técnica</h6>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">SubEstación</label>
                                        <input type="text" name="subestacion"
                                            class="form-control border border-2 p-2"
                                            value="{{ old('subestacion', $solicitud->SOE_SUBESTACION) }}">
                                        @error('subestacion')
                                            <p class='text-danger inputerror'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @if ($solicitud->ultimoEstado->estado->ESO_ID != 6)
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Asociado</label>
                                            <input type="text" name="asociado"
                                                class="form-control border border-2 p-2"
                                                value="{{ old('asociado', $solicitud->SOE_ASOCIADO) }}">
                                            @error('asociado')
                                                <p class='text-danger inputerror'>{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">Suministro</label>
                                            <input type="text" name="suministro"
                                                class="form-control border border-2 p-2"
                                                value="{{ old('suministro', $solicitud->SOE_SUMINISTRO) }}">
                                            @error('suministro')
                                                <p class='text-danger inputerror'>{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Valor de Obra</label>
                                            <input type="text" name="obra"
                                                class="form-control border border-2 p-2"
                                                value="{{ old('obra', $solicitud->SOE_OBRA) }}">
                                            @error('obra')
                                                <p class='text-danger inputerror'>{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Dirección</h6>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Calle</label>
                                    <input type="text" name="calle" class="form-control border border-2 p-2"
                                        value="{{ old('calle', $solicitud->SOE_CALLE) }}" required>
                                    @error('calle')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Localidad</label>
                                    <select name="localidad" class="form-control border border-2 p-2" required>
                                        <option value="" disabled>Seleccione localidad</option>
                                        @foreach ($localidades as $localidad)
                                            <option value="{{ $localidad->LOC_ID }}"
                                                {{ $localidad->LOC_ID == old('localidad', $solicitud->SOE_LOCALIDAD_ID) ? 'selected' : '' }}>
                                                {{ $localidad->LOC_DESCRIPCION }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('localidad')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Altura</label>
                                    <input type="number" name="altura" class="form-control border border-2 p-2"
                                        value="{{ old('altura', $solicitud->SOE_ALTURA) }}" required>
                                    @error('altura')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Piso</label>
                                    <input type="text" name="piso" class="form-control border border-2 p-2"
                                        value="{{ old('piso', $solicitud->SOE_PISO) }}">
                                    @error('piso')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Dpto</label>
                                    <input type="text" name="dpto" class="form-control border border-2 p-2"
                                        value="{{ old('dpto', $solicitud->SOE_DPTO) }}">
                                    @error('dpto')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Contacto</h6>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Celular</label>
                                    <input type="text" name="celular" class="form-control border border-2 p-2"
                                        value="{{ old('celular', $solicitud->SOE_CELULAR) }}">
                                    @error('celular')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control border border-2 p-2"
                                        value="{{ old('email', $solicitud->SOE_EMAIL) }}" required>
                                    @error('email')
                                        <p class='text-danger inputerror'>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Conexión</h6>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Tipos</label>
                                    <select id="tipoSelect" name="tipo" class="form-control border border-2 p-2"
                                        required>
                                        <option value="" disabled></option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->TOE_ID }}"
                                                data-description="{{ $tipo->TOE_DESCRIPCION }}"
                                                {{ $tipo->TOE_ID == old('tipo', $solicitud->SOE_TIPO_ID) ? 'selected' : '' }}>
                                                {{ $tipo->TOE_ABREVIATURA }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipo')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-10">
                                    <label class="form-label">Descripción</label>
                                    <input id="descripcionInput" type="text" name="descripcion"
                                        class="form-control border border-2 p-2" readonly>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn bg-gradient-dark mx-2">Actualizar</button>
                                <button type="button" class="btn btn-secondary mx-2"
                                    onclick="window.location.href='{{ route('mostrar-solicitud', ['solicitud' => $solicitud->SOE_ID]) }}'">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tipoSelect = document.getElementById('tipoSelect');
                const descripcionInput = document.getElementById('descripcionInput');

                function updateDescription() {
                    const selectedOption = tipoSelect.options[tipoSelect.selectedIndex];
                    const description = selectedOption.getAttribute('data-description');
                    descripcionInput.value = description;
                }

                tipoSelect.addEventListener('change', updateDescription);
                updateDescription();
            });
        </script>
    @endpush
</x-layout>
