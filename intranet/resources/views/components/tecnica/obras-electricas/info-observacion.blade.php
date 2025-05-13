@if ($solicitud->ultimoEstado->ultimaObservacion)
    <div class="row">
        <hr>
        <div class="col-md-12 d-flex align-items-center">
            <h6 class="mb-3">Información Observación</h6>
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Usuario</label>
            <input type="text" name="obsusuario" class="form-control border border-2 p-2"
                value="{{ old('obsusuario', $solicitud->ultimoEstado->ultimaObservacion->SOB_USUARIO) }}" readonly>
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Fecha Observación</label>
            <input type="text" name="obsfecha" class="form-control border border-2 p-2"
                value="{{ old('obsfecha', $solicitud->ultimoEstado->ultimaObservacion->SOB_FECHA) }}" readonly>
        </div>
        <div class="mb-3 col-md-8">
            <label class="form-label">Motivo</label>
            <input type="text" name="obsmotivo" class="form-control border border-2 p-2"
                value="{{ old('obsmotivo', $solicitud->ultimoEstado->ultimaObservacion->observacion->OSO_DESCRIPCION) }}"
                readonly>
        </div>
    </div>
@endif
