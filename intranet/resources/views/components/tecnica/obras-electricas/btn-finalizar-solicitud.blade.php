<button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalObra">
    Finalizar
</button>
<!-- Modal Finalizar -->
<div class="modal fade" id="modalObra" tabindex="-1" role="dialog" aria-labelledby="modalObraLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Formulario -->
            <form method="POST" action="{{ route('finalizar-solicitud', $solicitud->SOE_ID) }}">
                @csrf
                @method('PUT') <!-- Cambia el método HTTP a PUT -->
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalObraLabel">
                        Ingresar Valor de Obra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Campo para valor de Obra -->
                    <div class="mb-3">
                        <label for="valorObra" class="form-label">Valor de
                            Obra</label>
                        <input type="text" name="valorObra" id="valorObra" class="form-control border border-2 p-2"
                            value="T.V." placeholder="Ingresa un valor">
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
