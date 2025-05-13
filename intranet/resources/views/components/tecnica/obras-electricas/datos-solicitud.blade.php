@props(['editSubestacion' => false])
<div class="row">
    <div class="card-header pb-0 p-3 d-flex justify-content-center align-content-center">
        <h6 class="mb-0 display-5">Solicitud Nro. {{ $solicitud->SOE_ID }}</h6>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">DNI/CUIT</label>
        <input type="text" name="dni" class="form-control border border-2 p-2"
            value="{{ old('dni', $solicitud->SOE_CUIT) }}" readonly>
    </div>
    <div class="mb-3 col-md-4">
        <label class="form-label">Solicitante</label>
        <input type="text" name="solicitante" class="form-control border border-2 p-2"
            value="{{ old('apellido', $solicitud->SOE_APELLIDO) . ' ' . old('solicitante', $solicitud->SOE_NOMBRE) }}"
            readonly>
    </div>
    <div class="mb-3 col-md-4">
        <label class="form-label">Dirección</label>
        <input type="text" name="sede" class="form-control border border-2 p-2"
            value="{{ old('sede', $solicitud->SOE_CALLE) . ' ' . old('altura', $solicitud->SOE_ALTURA) . ' ' . old('piso', $solicitud->SOE_PISO) . ' ' . old('dpto', $solicitud->SOE_DPTO) }}"
            readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">Localidad</label>
        <input type="text" name="localidad" class="form-control border border-2 p-2"
            value="{{ old('localidad', $solicitud->localidad->LOC_DESCRIPCION) }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">Celular</label>
        <input type="text" name="celular" class="form-control border border-2 p-2"
            value="{{ old('celular', $solicitud->SOE_CELULAR) }}" readonly>
    </div>
    <div class="mb-3 col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control border border-2 p-2"
            value="{{ old('email', $solicitud->SOE_EMAIL) }}" readonly>
    </div>
    <div class="mb-3 col-md-4">
        <label class="form-label">Tipo de Conexión</label>
        <input type="text" name="descripcion" class="form-control border border-2 p-2"
            value="{{ old('descripcion', $solicitud->tipos->TOE_DESCRIPCION) }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label">Inicio de Solicitud</label>
        <input type="text" name="f_inicio" class="form-control border border-2 p-2"
            value="{{ old('f_inicio', $solicitud->SOE_FECHA) }}" readonly>
    </div>
    @if ($solicitud->ultimoEstado->SES_ESTADO_ID != 4)
        @if ($solicitud->ultimoEstado->SES_ESTADO_ID != 5)
            <div class="mb-3 col-md-2">
                <label class="form-label">Asociado</label>
                <input type="text" name="asociado" class="form-control border border-2 p-2"
                    value="{{ old('asociado', $solicitud->SOE_ASOCIADO) }}" readonly>
            </div>
            <div class="mb-3 col-md-2">
                <label class="form-label">Suministro</label>
                <input type="text" name="suministro" class="form-control border border-2 p-2"
                    value="{{ old('suministro', $solicitud->SOE_SUMINISTRO) }}" readonly>
            </div>
        @endif
        <div class="mb-3 col-md-2">
            <label class="form-label">Sub-Estación</label>
            <input type="text" name="subestacion" class="form-control border border-2 p-2"
                value="{{ old('subestacion', $solicitud->SOE_SUBESTACION) }}" {{ $editSubestacion ? '' : 'readonly' }}>
        </div>
    @endif
    @if (
        $solicitud->SOE_OBRA &&
            ($solicitud->ultimoEstado->SES_ESTADO_ID == 1 || $solicitud->ultimoEstado->SES_ESTADO_ID == 3))
        <div class="mb-3 col-md-2">
            <label class="form-label">Obra</label>
            <input type="text" name="obra" class="form-control border border-2 p-2"
                value="{{ old('obra', $solicitud->SOE_OBRA) }}" readonly>
        </div>
    @endif
</div>
