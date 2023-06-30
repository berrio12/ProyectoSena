<div class="col-md-6 mx-auto">
    <div class="card radius-10 border-start border-0 border-3 border-info">
        <form action="<?php echo base_url('categorias/actualizar') ?>" method="POST" autocomplete="off">
            <div class="card-body">
                <h6 class="card-title text-center">Modificar categoria</h6>
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
                    <div class="col-md-12 my-2">
                        <div class="form-floating mb-3">
                            <input type="hidden" value="<?php echo $categoria['idcat'] ?>" name="id">
                            <input type="text" class="form-control" placeholder="Nombre de la categoria" name="categoria" value="<?= set_value('categoria', $categoria['categoria']) ?>">
                            <?php if (isset($validation)) { ?>
                                <span class="text-danger"><?php echo $validation->getError('categoria'); ?></span>
                            <?php } ?>
                            <label for="categoria">Nombre</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-registered"></i> Modificar</button>
                <a href="<?php echo base_url('categorias') ?>" class="btn btn-danger btn-block"><i class="fas fa-ban"></i> Atras</a>
            </div>
        </form>
    </div>
</div>