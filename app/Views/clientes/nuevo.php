<div class="card radius-10 border-start border-0 border-3 border-info">
    <form action="<?php echo base_url('/clientes/registrar') ?>" method="POST" autocomplete="off">
        <div class="card-body">
            <h6 class="card-title text-center">Nuevo cliente</h6>
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
            <div class="row p-4">
                <div class="col-md-7">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" value="<?= set_value('nombre') ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger"><?php echo $validation->getError('nombre'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-align-left"></i> Nombre <span class="text-danger fw-bold">*</span></label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Correo Electronico" name="correo" value="<?= set_value('correo') ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger"><?php echo $validation->getError('correo'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-envelope"></i> Correo</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Télefono" name="telefono" value="<?= set_value('telefono') ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger"><?php echo $validation->getError('telefono'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-phone-square"></i> Teléfono <span class="text-danger fw-bold">*</span></label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Dirección" name="direccion" value="<?= set_value('direccion') ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger"><?php echo $validation->getError('direccion'); ?></span>
                        <?php } ?>
                        <label for="direccion"><i class="fas fa-address-book"></i> Dirección <span class="text-danger fw-bold">*</span></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-registered"></i> Registrar</button>
            <a href="<?php echo base_url('/clientes') ?>" class="btn btn-outline-danger"><i class="fas fa-ban"></i> Atras</a>
        </div>
    </form>
</div>