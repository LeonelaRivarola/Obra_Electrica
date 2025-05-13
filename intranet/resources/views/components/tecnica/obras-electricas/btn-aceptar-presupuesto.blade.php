<button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalNotificacion">
    <span class="material-icons">check</span>
    <span class="ms-1">Aceptar</span>
</button>
<!-- Modal Aceptar -->
<div class="modal fade" id="modalNotificacion" tabindex="-1" role="dialog" aria-labelledby="modalNotificacionLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('procesar-presupuesto', $solicitud->SOE_ID) }}">
                @csrf
                @method('POST')
                <input type="hidden" name="accion" value="aceptar">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalNotificacionLabel">Aceptar Presupuesto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 d-flex align-items-center col-md-12">
                        <label for="numeroAsociado" class="form-label">Asociado</label>
                        <input type="text" name="nroAsociado" id="numeroAsociado"
                            class="form-control border border-2 p-2">
                        <label for="numeroSuministro" class="form-label">Suministro</label>
                        <input type="text" name="nroSuministro" id="numeroSuministro"
                            class="form-control border border-2 p-2">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="habilitarObservacion">
                        <label class="form-check-label" for="habilitarObservacion">Añadir observación</label>
                    </div>
                    <div class="mt-3">
                        <textarea name="observacion" id="campoObservacion" class="form-control" rows="3"
                            placeholder="Escribe una observación..." disabled></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                    <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
