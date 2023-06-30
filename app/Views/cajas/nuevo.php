<div class="col-md-5 mx-auto">
    <div class="card radius-10 border-start border-0 border-3 border-info">
        <form action="<?php echo base_url('cajas/registrar') ?>" method="POST" autocomplete="off">
            <div class="card-body">
                <h6 class="card-title text-center">Registro de caja</h6>
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
                <?php csrf_field(); ?>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Ejemplo: Caja General" id="caja" name="caja" value="<?= set_value('caja') ?>">
                    <?php if (isset($validation)) { ?>
                        <span class="text-danger font-weight-bold"><?php echo $validation->getError('caja'); ?></span>
                    <?php } ?>
                    <label for="nombre"><i class="fas fa-list"></i> Nombre de la Caja<span class="text-danger fw-bold">*</span></label>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-registered"></i> Registrar</button>
                <a href="<?php echo base_url('cajas') ?>" class="btn btn-outline-danger"><i class="fas fa-ban"></i> Atras</a>
            </div>
        </form>
    </div>
</div>