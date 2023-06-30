<div class="card radius-10 border-start border-0 border-3 border-info">
    <div class="card-body">
        <div class="alert border-0 border-start border-5 border-info alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-info"><i class='bx bxs-check-circle'></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success">Mensaje solo en el DEMO</h6>
                        <div>BUSCAR PRODUCTO, SELECCIONAR, INGRESA CANTIDAD Y PRESIONA ENTER</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-center">Nueva compra</h6>
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-floating mb-3">
                                    <input type="hidden" id="id" name="id">
                                    <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Buscar producto">
                                    <label for="codigo"><i class="fas fa-search"></i> Buscar producto</label>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-floating mb-3">
                                    <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripción del productos" disabled>
                                    <label for="nombre">Descripción</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input id="cantidad" class="form-control" type="number" name="cantidad" onchange="insertarCompra(event, 1)" disabled>
                                    <label for="cantidad">Cant</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio compra" disabled>
                                    <label for="precio">Precio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Sub total" disabled>
                                    <label for="sub_total">Sub Total</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="table" style="width: 100%;">
                                        <thead class="border-info">
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Cant</th>
                                                <th>Precio</th>
                                                <th>Sub Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblDetalle">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Total a Pagar</h3>
                        <hr>
                        <h1 id="total">0.00</h1>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary btn-lg" type="button" onclick="generar(1)">Generar Compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>