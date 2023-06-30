<div class="card radius-10 border-start border-0 border-3 border-info">
    <div class="card-body">
        <h5 class="card-title">Asignar Permisos</h5>
        <hr>
        <?php if (!empty(session()->getFlashdata('rol'))) { ?>
            <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Mensaje</h6>
                        <div><?php echo session()->getFlashdata('rol'); ?></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <form action="<?php echo base_url('/usuarios/permisos') ?>" method="POST">
            <?php csrf_field();
            $datos = array();
            foreach ($asignados as $asignado) {
                $datos[$asignado['id_permiso']] = true;
            }
            foreach ($permisos as $row) { ?>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="permisos[]" id="flexSwitchCheckChecked" value="<?php echo $row['id']; ?>" <?php echo (isset($datos[$row['id']])) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="flexSwitchCheckChecked"><?php echo $row['nombre']; ?></label>
                </div>
            <?php } ?>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id'] ?>">
                <input type="submit" value="Registrar" class="btn btn-outline-primary btn-lg">
                <a href="<?php echo base_url('usuarios') ?>" class="btn btn-outline-danger btn-lg">Atras</a>
            </div>
        </form>
    </div>
</div>