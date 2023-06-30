<div class="col-md-8 mx-auto">
    <div class="card radius-10 border-start border-0 border-3 border-info">
        <?php if (!empty(session()->getFlashdata('perfil'))) { ?>
            <div class="alert alert-<?php echo (session()->getFlashdata('perfil') == 'ok') ? 'success' : 'danger'; ?>" role="alert">
                <?php if (session()->getFlashdata('perfil') == 'ok') { ?>
                    <h6>Contraseña Modificada</h6>
                <?php } else if (session()->getFlashdata('perfil') == 'incorrecta') { ?>
                    <h6>Contraseña actual incorrecta</h6>
                <?php } else { ?>
                    <h6>Error al modificar la contraseña</h6>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="card-body">
            <h6 class="card-title text-center">Modificar contraseña</h6>
            <hr>
            <form action="<?php echo base_url('usuarios/cambiar') ?>" method="POST">
                <?php csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Contraseña" name="clave_actual" value="<?= set_value('clave_actual') ?>">
                            <label for=""><i class="fas fa-key"></i> Contraseña Actual</label>
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger font-weight-bold"><?php echo $validation->getError('clave_actual'); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Nueva Contraseña" name="clave_nueva" value="<?= set_value('clave_neva') ?>">
                            <label for=""><i class="fas fa-key"></i> Nueva Contraseña</label>
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger font-weight-bold"><?php echo $validation->getError('clave_nueva'); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" placeholder="Confirmar Contraseña" name="confirmar" value="<?= set_value('confirmar') ?>">
                            <label for=""><i class="fas fa-key"></i> Confirmar Contraseña</label>
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger font-weight-bold"><?php echo $validation->getError('confirmar'); ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <input type="submit" value="Modificar" class="btn btn-outline-primary btn-lg">
                    <a href="<?php echo base_url('usuarios') ?>" class="btn btn-outline-danger btn-lg">Atras</a>
                </div>
            </form>
        </div>
    </div>
</div>