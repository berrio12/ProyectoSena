<div class="card radius-10 border-start border-0 border-3 border-info">
    <form action="<?php echo base_url('productos/actualizar') ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="card-body">
            <h6 class="card-title text-center">Modificar producto</h6>
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
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="hidden" name="id" value="<?= set_value('id', $producto['id']) ?>">
                        <input type="text" class="form-control" placeholder="Código de barras" id="codigo" name="codigo" value="<?= set_value('codigo', $producto['codigo']) ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('codigo'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-barcode"></i> Codigo de barras</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Descripción" name="descripcion" value="<?= set_value('descripcion', $producto['descripcion']) ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('descripcion'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-align-left"></i> Nombre</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Precio compra" name="precio_compra" value="<?= set_value('precio_compra', $producto['precio_compra']) ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('precio_compra'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-dollar-sign"></i> Precio Compra</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Precio Venta" name="precio_venta" value="<?= set_value('precio_venta', $producto['precio_venta']) ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('precio_venta'); ?></span>
                        <?php } ?>
                        <label for=""><i class="fas fa-dollar-sign"></i> Precio Venta</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Stock Mínimo" name="stock_minimo" value="<?= set_value('stock_minimo', $producto['stock_minimo']) ?>">
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('stock_minimo'); ?></span>
                        <?php } ?>
                        <label for="">Stock Mínimo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select id="marca" name="marca" class="form-control">
                            <?php foreach ($marcas as $row) { ?>
                                <option value="<?php echo $row['idmarca']; ?>"><?php echo $row['marca']; ?></option>
                            <?php } ?>
                        </select>
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('marca'); ?></span>
                        <?php } ?>
                        <label for="marca"><i class="fas fa-copyright"></i> Marca</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select id="medida" name="medida" class="form-control">
                            <?php foreach ($medidas as $row) { ?>
                                <option value="<?php echo $row['idmedida']; ?>"><?php echo $row['medida']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="medida">Medidas</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select id="categoria" name="categoria" class="form-control">
                            <?php foreach ($categorias as $row) { ?>
                                <option value="<?php echo $row['idcat']; ?>"><?php echo $row['categoria']; ?></option>
                            <?php } ?>
                        </select>
                        <label for="categoria">Categorias</label>
                        <?php if (isset($validation)) { ?>
                            <span class="text-danger "><?php echo $validation->getError('categoria'); ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="imagen"><i class="fas fa-image"></i> Imagen</label>
                        <input id="imagen" class="form-control" type="file" name="imagen">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <img src="<?php echo base_url('img/productos/' . $producto['imagen']) ?>" width="100">
                    <input type="hidden" name="foto_actual" value="<?php echo $producto['imagen'] ?>">
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-registered"></i> Modificar</button>
                <a href="<?php echo base_url('productos') ?>" class="btn btn-danger btn-block"><i class="fas fa-ban"></i> Atras</a>
            </div>
        </div>
    </form>
</div>