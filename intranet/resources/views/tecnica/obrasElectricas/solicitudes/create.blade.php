<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="nueva-solicitud"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Nueva Solicitud'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-100 border-radius-xl mt-4">
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-body p-3">
                        @if (session('status'))
                            <div class="row">
                                <div class="alert alert-success alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <form method='POST' action='{{ route('crear-solicitud') }}'>
                            @csrf
                            <div class="row">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Conexión</h6>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Tipos</label>
                                    <select id="tipoSelect" name="tipo" class="form-select border border-2 p-2"
                                        required>
                                        <option value="" disabled selected></option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->TOE_ID }}"
                                                data-description="{{ $tipo->TOE_DESCRIPCION }}"
                                                data-interno="{{ $tipo->TOE_INTERNO }}">
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
                                <div class="form-section" id="formFields" style="pointer-events: none; opacity: 0.5;">
                                    <div class="row">
                                        <div class="card-header pb-0 p-3">
                                            <h6 class="mb-0">Titular</h6>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">DNI/CUIT</label>
                                            <input id="cuitInput" type="text" name="cuit"
                                                class="form-control border border-2 p-2">
                                            @error('cuit')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label class="form-label">Nombre</label>
                                            <input id="nombreInput" type="text" name="nombre"
                                                class="form-control border border-2 p-2">
                                            @error('nombre')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label class="form-label">Apellido</label>
                                            <input id="apellidoInput" type="text" name="apellido"
                                                class="form-control border border-2 p-2">
                                            @error('apellido')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="card-header pb-0 p-3">
                                            <h6 class="mb-0">Dirección</h6>
                                        </div>
                                        <div class="mb-3 col-md-8">
                                            <label class="form-label">Calle</label>
                                            <input type="text" name="calle"
                                                class="form-control border border-2 p-2" required>
                                            @error('calle')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Localidad</label>
                                            <select name="localidad" class="form-select border border-2 p-2" required>
                                                <option value="" disabled selected>Seleccione localidad</option>
                                                @foreach ($localidades as $localidad)
                                                    <option value="{{ $localidad->LOC_ID }}">
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
                                            <input type="number" name="altura"
                                                class="form-control border border-2 p-2" required>
                                            @error('altura')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Piso</label>
                                            <input type="text" name="piso"
                                                class="form-control border border-2 p-2">
                                            @error('piso')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Dpto</label>
                                            <input type="text" name="dpto"
                                                class="form-control border border-2 p-2">
                                            @error('dpto')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="card-header pb-0 p-3">
                                            <h6 class="mb-0">Contacto</h6>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Celular</label>
                                            <input type="text" name="celular"
                                                class="form-control border border-2 p-2">
                                            @error('celular')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-8">
                                            <label class="form-label">Email</label>
                                            <input id="emailInput" type="email" name="email"
                                                class="form-control border border-2 p-2">
                                            @error('email')
                                                <p class='text-danger inputerror'>{{ $message }} </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-warning bg-gradient-dark mx-2 mb-3 col-md-2">
                                    Crear
                                </button>
                                <button type="button" class="btn btn-danger mx-2 mb-3 col-md-2"
                                    onclick="window.location.href='{{ route('solicitudes') }}'">
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
                const formFields = document.getElementById('formFields');
                const cuitInput = document.getElementById('cuitInput');
                const nombreInput = document.getElementById('nombreInput');
                const apellidoInput = document.getElementById('apellidoInput');
                const emailInput = document.getElementById('emailInput');

                const setReadOnly = (isReadOnly) => {
                    const defaultValues = {
                        cuit: '30545719386',
                        nombre: 'Corpico Ltda',
                        apellido: 'Cooperativa',
                        email: '2dojefe_tecnico@corpico.com.ar'
                    };
                    if (isReadOnly) {
                        cuitInput.value = defaultValues.cuit;
                        nombreInput.value = defaultValues.nombre;
                        apellidoInput.value = defaultValues.apellido;
                        emailInput.value = defaultValues.email;

                        cuitInput.readOnly = true;
                        nombreInput.readOnly = true;
                        apellidoInput.readOnly = true;
                        emailInput.readOnly = true;
                    } else {
                        cuitInput.value = '';
                        nombreInput.value = '';
                        apellidoInput.value = '';
                        emailInput.value = '';

                        cuitInput.readOnly = false;
                        nombreInput.readOnly = false;
                        apellidoInput.readOnly = false;
                        emailInput.readOnly = false;
                    }
                };

                tipoSelect.addEventListener('change', function() {
                    const selectedOption = tipoSelect.options[tipoSelect.selectedIndex];

                    descripcionInput.value = selectedOption.getAttribute('data-description');

                    const interno = selectedOption.getAttribute('data-interno') === 'S';

                    setReadOnly(interno);

                    if (tipoSelect.value) {
                        formFields.style.pointerEvents = 'auto';
                        formFields.style.opacity = '1';
                    }
                });

                formFields.style.pointerEvents = 'none';
                formFields.style.opacity = '0.5';
                setReadOnly(false);
            });
        </script>
    @endpush
</x-layout>
