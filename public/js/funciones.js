let t_user, t_userD, t_caja, t_cajaD, t_cli, t_cliD,
    t_med, t_medD, t_cat, t_catD, t_marca, t_marcaD, t_pro,
    t_proD, neditor, t_h_c, t_h_v;
let myChart;
document.addEventListener("DOMContentLoaded", function () {
    const language = {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
    const buttons = [{
        //Botón para Excel
        extend: 'excel',
        footer: true,
        //Aquí es donde generas el botón personalizado
        text: '<span class="badge bg-success"><i class="fas fa-file-excel"></i></span>'
    },
    //Botón para PDF
    {
        extend: 'pdf',
        footer: true,
        text: '<span class="badge bg-danger"><i class="fas fa-file-pdf"></i></span>'
    },
    //Botón para print
    {
        extend: 'print',
        footer: true,
        text: '<i class="fas fa-print"></i>'
    }
    ]
    $('#t_cierre').DataTable({
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language,
        "order": [
            [0, "desc"]
        ],
    });
    //usuarios
    t_user = $('#tblusers').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/usuarios/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "usuario"
        },
        {
            "data": "nombre"
        },
        {
            "data": "correo"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_userD = $('#tblusers_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/usuarios/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "usuario"
        },
        {
            "data": "nombre"
        },
        {
            "data": "correo"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //cajas
    t_caja = $('#tblcaja').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/cajas/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "caja"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_cajaD = $('#tblcaja_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/cajas/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "caja"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //Clientes
    t_cli = $('#tblcli').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/clientes/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "nombre"
        },
        {
            "data": "telefono"
        },
        {
            "data": "direccion"
        },
        {
            "data": "correo"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_cliD = $('#tblcli_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/clientes/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "nombre"
        },
        {
            "data": "telefono"
        },
        {
            "data": "direccion"
        },
        {
            "data": "correo"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //medidas
    t_med = $('#tblmedida').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/medidas/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idmedida"
        },
        {
            "data": "medida"
        },
        {
            "data": "nombre_corto"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_medD = $('#tblmedida_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/medidas/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idmedida"
        },
        {
            "data": "medida"
        },
        {
            "data": "nombre_corto"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //categorias
    t_cat = $('#tblcat').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/categorias/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idcat"
        },
        {
            "data": "categoria"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_catD = $('#tblcat_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/categorias/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idcat"
        },
        {
            "data": "categoria"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //marcas
    t_marca = $('#tblmarca').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/marcas/listar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idmarca"
        },
        {
            "data": "marca"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_marcaD = $('#tblmarca_r').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/marcas/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "idmarca"
        },
        {
            "data": "marca"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //productos
    t_pro = $('#tblpro').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/productos/listar",
            "dataSrc": ""
        },
        "columns": [
            {
                "data": "imagen"
            },
            {
                "data": "codigo"
            },
            {
                "data": "descripcion"
            },
            {
                "data": "precio_compra"
            },
            {
                "data": "precio_venta"
            },
            {
                "data": "stock"
            },
            {
                "data": "medida"
            },
            {
                "data": "marca"
            },
            {
                "data": "estado"
            },
            {
                "data": "acciones"
            }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    t_proD = $('#tpro_D').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": "" + base_url + "/productos/vaciar",
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "imagen"
        },
        {
            "data": "codigo"
        },
        {
            "data": "descripcion"
        },
        {
            "data": "precio_compra"
        },
        {
            "data": "precio_venta"
        },
        {
            "data": "stock"
        },
        {
            "data": "medida"
        },
        {
            "data": "marca"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //autocomplete compra
    $("#codigo").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: base_url + '/compras/buscar',
                dataType: "json",
                data: {
                    pro: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id').value = ui.item.id;
            document.getElementById('codigo').value = ui.item.codigo;
            document.getElementById('precio').value = ui.item.precio;
            document.getElementById('nombre').value = ui.item.descripcion;
            document.getElementById('cantidad').removeAttribute('disabled');
            document.getElementById('cantidad').focus();
        }
    })
    $("#nom_cli").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: base_url + '/clientes/buscar',
                dataType: "json",
                data: {
                    cli: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id_cli').value = ui.item.id;
            document.getElementById('nom_cli').value = ui.item.nombre;
            document.getElementById('dir_cli').value = ui.item.direccion;
        }
    })
    //historial compras
    t_h_c = $('#t_compras').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": base_url + '/compras/listar',
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "total"
        },
        {
            "data": "fecha"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
    //autocomplete compra
    $("#cod_venta").autocomplete({
        minLength: 3,
        source: function (request, response) {
            $.ajax({
                url: base_url + '/ventas/buscar',
                dataType: "json",
                data: {
                    pro: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            document.getElementById('id').value = ui.item.id;
            document.getElementById('cod_venta').value = ui.item.codigo;
            document.getElementById('precio').value = ui.item.precio;
            document.getElementById('nombre').value = ui.item.descripcion;
            document.getElementById('cantidad').removeAttribute('disabled');
            document.getElementById('cantidad').focus();
        }
    })
    t_h_v = $('#t_ventas').DataTable({
        "aPreocesing": true,
        "aServerSide": true,
        "ajax": {
            "url": base_url + '/ventas/listar',
            "dataSrc": ""
        },
        "columns": [{
            "data": "id"
        },
        {
            "data": "total"
        },
        {
            "data": "fecha"
        },
        {
            "data": "estado"
        },
        {
            "data": "acciones"
        }
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons,
        language
    });
})
function btnEliminarUser(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El usuario no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/usuarios/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_user.ajax.reload();
                }
            }

        }
    })
}
function btnreingresar_user(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/usuarios/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_userD.ajax.reload();
                }
            }

        }
    })
}
//cajas
function btnEliminarCaja(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "La caja no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/cajas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_caja.ajax.reload();
                }
            }

        }
    })
}
function btnreingresar_caja(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/cajas/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_cajaD.ajax.reload();
                }
            }

        }
    })
}
//clientes
function btnEliminarCli(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El cliente no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/clientes/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_cli.ajax.reload();
                }
            }

        }
    })
}

function btnreingresar_cli(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/clientes/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_cliD.ajax.reload();
                }
            }

        }
    })
}
//medidas
function btnEliminarMed(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "La medida no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/medidas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_med.ajax.reload();
                }
            }

        }
    })
}

function btnreingresar_med(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/medidas/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_medD.ajax.reload();
                }
            }

        }
    })
}
//categorias
function btnEliminarCat(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "La categoria no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/categorias/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_cat.ajax.reload();
                }
            }

        }
    })
}

function btnreingresar_cat(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/categorias/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_catD.ajax.reload();
                }
            }

        }
    })
}
//marcas
function btnEliminarMarca(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "La marca no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/marcas/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_marca.ajax.reload();
                }
            }

        }
    })
}

function btnreingresar_marca(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/marcas/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_marcaD.ajax.reload();
                }
            }

        }
    })
}
//productos
function btnEliminarPro(id) {
    Swal.fire({
        title: 'Esta seguro de eliminar?',
        text: "El producto no se eliminará de forma permanente, solo cambiará el estado a inactivo!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/productos/eliminar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_pro.ajax.reload();
                }
            }

        }
    })
}

function ingresar_pro(id) {
    Swal.fire({
        title: 'Esta seguro de reingresar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const url = base_url + "/productos/restaurar/" + id;
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    Swal.fire(
                        'Mensaje',
                        res.mensaje,
                        res.icono
                    )
                    t_proD.ajax.reload();
                }
            }

        }
    })
}
function insertarCompra(e, accion) {
    e.preventDefault();
    const cant = e.target.value;
    const id = document.getElementById("id").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
    let url;
    if (accion == 1) {
        url = base_url + "/compras/ingresar/" + id + '/' + cant;
    } else {
        url = base_url + "/ventas/ingresar/" + id + '/' + cant;
    }
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertas(res.msg, res.icono);
            document.getElementById('id').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('cantidad').value = '';
            document.getElementById('cantidad').setAttribute('disabled', 'disabled');
            document.getElementById('precio').value = '';
            document.getElementById('sub_total').value = '';
            if (accion == 1) {
                document.getElementById('codigo').value = '';
                cargarDetalle(1);
                document.getElementById('codigo').focus();
            } else {
                document.getElementById('cod_venta').value = '';
                cargarDetalle(0);
                document.getElementById('cod_venta').focus();
            }
        }
    }
}
function generar(accion) {
    let url, ruta;
    Swal.fire({
        title: 'Esta seguro de procesar?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const fila = document.querySelectorAll("#table tr").length;
            if (fila < 2) {
                alertas('No hay productos en la tabla', 'warning');
            } else {
                if (accion == 1) {
                    url = base_url + "/compras/generar";
                } else {
                    const id_cli = document.getElementById('id_cli').value;
                    url = base_url + "/ventas/generar/" + id_cli;
                }
                const http = new XMLHttpRequest();
                http.open("GET", url, true);
                http.send();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        const res = JSON.parse(this.responseText);
                        if (res.estado) {
                            alertas(res.msg, res.icono);
                            if (accion == 1) {
                                ruta = base_url + '/compras/generarPdf/' + res.id;
                            } else {
                                ruta = base_url + '/ventas/generarPdf/' + res.id;
                            }
                            setTimeout(() => {
                                window.open(ruta)
                                if (accion == 1) {
                                    cargarDetalle(1);
                                } else {
                                    cargarDetalle(0);
                                    document.getElementById('id_cli').value = '';
                                    document.getElementById('nom_cli').value = '';
                                }
                            }, 300);
                        } else {
                            alertas(res.msg, res.icono);
                        }
                    }
                }
            }
        }
    })
}
if (document.getElementById('tblDetalle')) {
    cargarDetalle(1);
}
if (document.getElementById('tblDetalleVenta')) {
    cargarDetalle(0);
}
function cargarDetalle(accion) {
    let url;
    if (accion == 1) {
        url = base_url + "/compras/detalle";
    } else {
        url = base_url + "/ventas/detalle";
    }
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.detalle.forEach(row => {
                html += `<tr>
               <td>${row['descripcion']}</td>
               <td>${row['cantidad']}</td>
               <td>${row['precio']}</td>
               <td>${row['cantidad'] * row['precio']}</td>
               <td>
               <button class="btn btn-outline-danger" type="button" onclick="deleteDetalle(${row['id_temp']})">
               <i class="fas fa-trash-alt"></i></button>
               </td>
               </tr>`;
            });
            if (accion == 1) {
                document.getElementById("tblDetalle").innerHTML = html;
            } else {
                document.getElementById("tblDetalleVenta").innerHTML = html;
            }
            document.getElementById("total").textContent = res.total_pagar;
        }
    }
}
function alertas(msg, icono) {
    notie.alert({
        type: icono,
        text: msg.toUpperCase(),
        time: 4,
        position: 'top'
    })
}
function deleteDetalle(id) {
    const url = window.location + '/eliminar/' + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            alertas(res.msg, res.icono);
            if (document.getElementById('tblDetalle')) {
                cargarDetalle(1);
            } else {
                cargarDetalle(0);
            }
        }
    }
}
function Anular(id, accion) {
    Swal.fire({
        title: 'Esta seguro de Anular?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            if (accion == 1) {
                url = base_url + "/compras/anular/" + id;
            } else {
                url = base_url + "/ventas/anular/" + id;
            }
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    alertas(res.msg, res.icono);
                    if (accion == 1) {
                        t_h_c.ajax.reload();
                    } else {
                        t_h_v.ajax.reload();
                    }
                }
            }

        }
    })
}
if (document.getElementById('comparacion')) {
    comparacion();
    stockMinimo();
}
function comparacion() {
    if (myChart) {
        myChart.destroy();
    }
    const anio = document.getElementById("year").value;
    const http = new XMLHttpRequest();
    const url = base_url + '/admin/comparacion/' + anio;
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var ctx = document.getElementById('comparacion').getContext('2d');

            var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke1.addColorStop(0, '#17ead9');
            gradientStroke1.addColorStop(1, '#6078ea');

            var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke2.addColorStop(0, '#FCFF33');
            gradientStroke2.addColorStop(1, '#C7FF33');

            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
                        "Jul", "Ago", "Sep", "Oct", "Nov", "Dic",
                    ],
                    datasets: [{
                        label: 'Ventas',
                        data: [res.venta.ene, res.venta.feb, res.venta.mar,
                        res.venta.abr, res.venta.may, res.venta.jun,
                        res.venta.jul, res.venta.ago, res.venta.sep,
                        res.venta.oct, res.venta.nov, res.venta.dic,
                        ],
                        pointBorderWidth: 2,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: gradientStroke1,
                        //backgroundColor: gradientStroke1,
                        borderColor: gradientStroke1,
                        borderWidth: 2
                    }, {
                        label: 'Compras',
                        data: [res.compra.ene, res.compra.feb, res.compra.mar,
                        res.compra.abr, res.compra.may, res.compra.jun,
                        res.compra.jul, res.compra.ago, res.compra.sep,
                        res.compra.oct, res.compra.nov, res.compra.dic,
                        ],
                        pointBorderWidth: 2,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: gradientStroke2,
                        //backgroundColor: gradientStroke2,
                        borderColor: gradientStroke2,
                        borderWidth: 2
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        labels: {
                            boxWidth: 40
                        }
                    },
                    tooltips: {
                        displayColors: false
                    }

                }
            });
        }
    }
}

function stockMinimo() {
    const url = base_url + '/admin/stockMinimo';
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let nombre = [];
            let cantidad = [];
            for (let i = 0; i < res.length; i++) {
                nombre.push(res[i].descripcion);
                cantidad.push(res[i].stock);
            }
            var ctx = document.getElementById("minimo").getContext('2d');

            var gradientStroke8 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke8.addColorStop(0, '#42e695');
            gradientStroke8.addColorStop(1, '#3bb2b8');

            var gradientStroke9 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke9.addColorStop(0, '#4776e6');
            gradientStroke9.addColorStop(1, '#8e54e9');


            var gradientStroke10 = ctx.createLinearGradient(0, 0, 0, 300);
            gradientStroke10.addColorStop(0, '#ee0979');
            gradientStroke10.addColorStop(1, '#ff6a00');

            var myChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: nombre,
                    datasets: [{
                        backgroundColor: [
                            gradientStroke8,
                            gradientStroke9,
                            gradientStroke10
                        ],

                        hoverBackgroundColor: [
                            gradientStroke8,
                            gradientStroke9,
                            gradientStroke10
                        ],
                        data: cantidad
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true
                    },
                    tooltips: {
                        displayColors: false
                    }
                }
            });
        }
    };
}