@if (
    $solicitud->ultimoEstado->estado->ESO_ID != 4 &&
        $solicitud->ultimoEstado->estado->ESO_ID != 5 &&
        $solicitud->ultimoPresupuesto)
    <div class="row">
        <hr>
        <div class="col-md-12 d-flex align-items-center">
            <h6 class="mb-3">Información Presupuesto</h6>
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Presupuestado por</label>
            <input type="text" name="preusuario" class="form-control border border-2 p-2"
                value="{{ old('preusuario', $solicitud->ultimoPresupuesto->SPR_USUARIO) }}" readonly>
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Fecha Presupuesto</label>
            <input type="text" name="prefecha" class="form-control border border-2 p-2"
                value="{{ old('prefecha', $solicitud->ultimoPresupuesto->SPR_FECHA) }}" readonly>
        </div>
        @if ($solicitud->ultimoPresupuesto->presupuesto?->PSO_NOTIFICA == 'S')
            <div class="mb-3 col-md-2">
                <label class="form-label">¿Se notificó?</label>
                <input type="text" name="notificado" class="form-control border border-2 p-2"
                    value="{{ old('notificado', 'SI') }}" readonly>
            </div>
            <div class="mb-3 col-md-2">
                <label class="form-label">Veces</label>
                <input type="text" name="veces" class="form-control border border-2 p-2"
                    value="{{ old('veces', $solicitud->ultimoPresupuesto->presupuesto->PSO_VECES) }}" readonly>
            </div>
            <div class="mb-3 col-md-2">
                <label class="form-label">Fecha Notificación</label>
                <input type="text" name="notfecha" class="form-control border border-2 p-2"
                    value="{{ old('notfecha', $solicitud->ultimoPresupuesto->presupuesto->PSO_F_NOTIFICA) }}" readonly>
            </div>
        @else
            <div class="mb-3 col-md-2">
                <label class="form-label">¿Se Notificó?</label>
                <input type="text" name="notificado" class="form-control border border-2 p-2"
                    value="{{ old('notificado', 'NO') }}" readonly>
            </div>
        @endif
        @if ($solicitud->ultimoPresupuesto->presupuesto?->PSO_ACEPTA)
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label class="form-label">¿Aceptado o Rechazado?</label>
                    <input type="text" name="notificado" class="form-control border border-2 p-2"
                        value="{{ old('notificado', $solicitud->ultimoPresupuesto->presupuesto->PSO_ACEPTA == 'S' ? 'Aceptado' : 'Rechazado') }}"
                        readonly>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">Fecha
                        {{ $solicitud->ultimoPresupuesto->presupuesto->PSO_ACEPTA == 'S' ? 'Aceptado' : 'Rechazado' }}</label>
                    <input type="text" name="notfecha" class="form-control border border-2 p-2"
                        value="{{ old('notfecha', $solicitud->ultimoPresupuesto->presupuesto->PSO_F_ACEPTA) }}"
                        readonly>
                </div>
            </div>
        @endif
    </div>
@endif
