<?php if (isset($estado['status']) == 0) { ?>
    <a class="btn btn-outline-primary mb-2" href="<?php echo base_url('cajas/abrir') ?>">Abrir</button>
    <?php } ?>
    <a href="<?php echo base_url() ?>/cajas" class="btn btn-outline-success mb-2">Cajas</a>
    <div class="card">
        <div class="card-body">
            <?php if (!empty(session()->getFlashdata('message'))) { ?>
                <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-success">Mensaje</h6>
                            <div><?php echo session()->getFlashdata('message'); ?></div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
            <h6 class="card-title text-center">Apertura y cierre</h6>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="t_cierre" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Fecha apertura</th>
                            <th>Fecha cierre</th>
                            <th>Monto inicial</th>
                            <th>Monto final</th>
                            <th>Total</th>
                            <th>Ventas</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cierre as $row) {
                            if ($row['status'] == 0) {
                                $estado = '<span class="badge bg-primary">Cerrado</span>';
                            } else {
                                $estado = '<span class="badge bg-danger">Abierto</span>';
                            }
                            $total = number_format($row['monto_inicial'] + $row['monto_fin'], 2, ",", ".");
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['fecha_inicio']; ?></td>
                                <td><?php echo $row['fecha_fin']; ?></td>
                                <td><?php echo $row['monto_inicial']; ?></td>
                                <td><?php echo $row['monto_fin']; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $row['total_ventas']; ?></td>
                                <td><?php echo $estado; ?></td>
                                <td>
                                    <?php if ($row['status'] == 1) { ?>
                                        <a class="btn btn-primary" href="<?php echo base_url('cajas/cerrar') ?>">Cerrar</button>
                                        <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>