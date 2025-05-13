<div class="row">
    <hr>
    <div class="col-md-12 d-flex align-items-center">
        <h6 class="mb-3">Información Estado</h6>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label">Estado</label>
        <input type="text" name="estado" class="form-control border border-2 p-2"
            value="{{ old('estado', $solicitud->ultimoEstado->estado->ESO_DESCRIPCION) }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">Usuario</label>
        <input type="text" name="update" class="form-control border border-2 p-2"
            value="{{ old('update', $solicitud->ultimoEstado->SES_USUARIO) }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">Fecha Estado</label>
        <input type="text" name="update" class="form-control border border-2 p-2"
            value="{{ old('update', $solicitud->ultimoEstado->SES_FECHA) }}" readonly>
    </div>
</div>
