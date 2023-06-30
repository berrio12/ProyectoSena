<div class="col-md-6 mx-auto">
    <form action="<?php echo base_url('marcas/registrar') ?>" method="POST" autocomplete="off">
        <div class="card radius-10 border-start border-0 border-3 border-info">
            <div class="card-body">
                <h6 class="card-title text-center">Nueva marca</h6>
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
                <div class="row">
                    <div class="col-md-12 my-3">
                        <label for="marca">Nombre</label>
                        <input type="text" class="form-control" placeholder="Nombre" id="marca" name="marca" value="<?= set_value('marca') ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger font-weight-bold"><?php echo $validation->getError('marca'); ?></span>
                        <?php } ?>
                    </div>

                </div>

            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-registered"></i> Registrar</button>
                <a href="<?php echo base_url('marcas') ?>" class="btn btn-danger btn-block"><i class="fas fa-ban"></i> Atras</a>
            </div>
        </div>
    </form>
</div>