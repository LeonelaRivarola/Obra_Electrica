<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tipos-obras" />
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage="Editar Tipo de Obra" />
        <div class="container-fluid px-2 px-md-4 mt-8">
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Tipo de Obra</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('actualizar-tipoObra', $tipoObra->TOE_ID) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Abreviatura</label>
                                    <input type="text" name="abreviatura" class="form-control border border-2 p-2"
                                        value="{{ old('abreviatura', $tipoObra->TOE_ABREVIATURA) }}" required>
                                    @error('abreviatura')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-8">
                                    <label class="form-label">Descripción</label>
                                    <input type="text" name="descripcion" class="form-control border border-2 p-2"
                                        value="{{ old('descripcion', $tipoObra->TOE_DESCRIPCION) }}" required>
                                    @error('descripcion')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">¿Interno?</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input border border-2 p-2"
                                            id="interno" name="interno" value="S"
                                            {{ old('interno', $tipoObra->TOE_INTERNO) === 'S' ? 'checked' : '' }}
                                            onchange="toggleLabel()">
                                        <label class="form-check-label" for="interno">
                                            <span id="interno-label">
                                                {{ old('interno', $tipoObra->TOE_INTERNO) === 'S' ? 'Sí' : 'No' }}
                                            </span>
                                        </label>
                                    </div>
                                    @error('interno')
                                        <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn bg-gradient-dark mx-2">Actualizar</button>
                                <button type="button" class="btn btn-secondary mx-2"
                                    onclick="window.location.href='{{ route('tipos-obras') }}'">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth />
    </div>

    @push('js')
        <script>
            function toggleLabel() {
                const checkbox = document.getElementById('interno');
                const label = document.getElementById('interno-label');
                label.textContent = checkbox.checked ? 'Sí' : 'No';
            }
        </script>
    @endpush
</x-layout>
