<div class="card radius-10 border-start border-0 border-3 border-info">
    <form method="post" action="<?php echo base_url('cajas/registrarCajaCierre') ?>" autocomplete="off">
        <?php csrf_field(); ?>
        <div class="card-body">
        <h6 class="card-title text-center">Cerrar caja</h6>
            <hr>
            <div class="row">
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Monto Inicial" value="<?php echo $monto_inicial; ?>" disabled>
                        <label>Monto Inicial: </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Monto Final" value="<?php echo $monto_final; ?>" disabled>
                        <label>Monto Final: </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Monto Final" value="<?php echo $ventas; ?>" disabled>
                        <label>Total de ventas: </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>">
                        <label>Fecha de cierre</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" value="Cerrar caja" class="btn btn-outline-primary btn-lg">
                <a class="btn btn-outline-danger btn-lg" href="<?php echo base_url('cajas/cierre') ?>">Cancelar</a>
            </div>
        </div>
    </form>
</div>