<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Usuarios</p>
                        <h4 class="my-1 text-info"><?php echo $usuarios; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('usuarios'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                        <i class='fas fa-user'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Clientes</p>
                        <h4 class="my-1 text-info"><?php echo $clientes; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('clientes'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='fas fa-users'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total medidas</p>
                        <h4 class="my-1 text-info"><?php echo $medidas; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('medidas'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                        <i class='fas fa-list'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10 border-start border-0 border-3 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Productos</p>
                        <h4 class="my-1 text-info"><?php echo $productos; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('productos'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                        <i class='fas fa-list-alt'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total categorias</p>
                        <h4 class="my-1 text-success"><?php echo $categorias; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('categorias'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons bg-light-success text-success ms-auto"><i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total marcas</p>
                        <h4 class="my-1 text-warning"><?php echo $marcas; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('marcas'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="fas fa-copyright"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Compras por día</p>
                        <h4 class="my-1 text-primary"><?php echo $compras; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('compras'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons bg-light-primary text-primary ms-auto"><i class="fas fa-truck"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Ventas por día</p>
                        <h4 class="my-1 text-danger"><?php echo $ventas; ?></h4>
                        <a class="mb-0 font-13" href="<?php echo base_url('ventas'); ?>">Detalle</a>
                    </div>
                    <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class="fas fa-cash-register"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->

<div class="row">
    <div class="col-12 col-lg-7">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex justify-content-end align-items-center">
                    <div class="form-group">
                        <label for="year">Año</label>
                        <select id="year" onchange="comparacion()">
                            <?php
                            $fecha = date('Y');
                            for ($i = 2020; $i <= $fecha; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo ($fecha == $i) ? 'selected' : ''; ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="chart-container-1">
                    <canvas id="comparacion"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0">Producto con stock mínimo</h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="<?php echo base_url('admin/minimo') ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> PDF</a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="chart-container-2 mt-4">
                    <canvas id="minimo"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->