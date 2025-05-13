<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalRechazo">
    <span class="material-icons">close</span>
    <span class="ms-1">Rechazar</span>
</button>
<!-- Modal Rechazo -->
<div class="modal fade" id="modalRechazo" tabindex="-1" role="dialog" aria-labelledby="modalRechazoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('procesar-presupuesto', $solicitud->SOE_ID) }}">
                @csrf
                @method('POST')
                <input type="hidden" name="accion" value="rechazar">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalRechazoLabel">
                        Rechazar Presupuesto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="observacionRechazo" class="form-label">Motivo de
                            Rechazo</label>
                        <textarea name="observacion" id="observacionRechazo" class="form-control" rows="3"
                            placeholder="Escribe el motivo del rechazo..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Rechazar</button>
                    <button type="button" class="btn btn-link ml-auto" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
