<div class="card radius-10 border-start border-0 border-3 border-info">
    <form method="post" action="<?php echo base_url('cajas/registrarCajaCierre') ?>" autocomplete="off">
        <?php csrf_field(); ?>
        <div class="card-body">
            <h6 class="card-title text-center">Abrir caja</h6>
            <hr>
            <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-info"><i class='bx bx-info-square'></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-info">Advertencia</h6>
                        <div>Todo los campos con <b class="text-danger">*</b> son obligatorios</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input id="fecha_apertura" class="form-control" type="date" name="fecha_apertura" value="<?php echo date("Y-m-d"); ?>">
                        <label for="nombre">Fecha de apertura <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input id="monto_inicial" class="form-control" type="text" name="monto_inicial" placeholder="Monto inicial">
                        <label for="monto_inicial">Monto Inicial</label>
                        <input type="hidden" name="id" id="id">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" value="Abrir" class="btn btn-outline-primary">
                <a class="btn btn-outline-danger" href="<?php echo base_url('cajas/cierre') ?>">Cancelar</a>
            </div>
        </div>
    </form>
</div>