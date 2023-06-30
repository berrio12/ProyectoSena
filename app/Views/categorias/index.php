<a href="<?php echo base_url('categorias/nuevo') ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i></a>
<a href="<?php echo base_url('categorias/reciclaje') ?>" class="btn btn-danger mb-3"><i class="fas fa-recycle"></i></a>
<div class="card radius-10 border-start border-0 border-3 border-info">
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
        <h6 class="card-title text-center">Lista de categorias</h6>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="tblcat" style="width: 100%;">
                <thead class="border-info">
                    <tr>
                        <th>#</th>
                        <th>Categorias</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>