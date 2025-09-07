<?php

$url = Ruta::ctrRuta();
date_default_timezone_set("America/Lima");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0">Reportes</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Reportes</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Main content -->
        <div class="content pb-2">

            <div class="container-fluid">

                <!-- ROW PARA CRITERIOS DE BUSQUEDA -->
                <div class="row">

                    <div class="col">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>

                                <div class="card-tools">
                                    <span class="btn btn-tool text-white" id="btnLimpiarBusqueda">
                                        <i class="far fa-times-circle fs-4"></i>
                                    </span>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Ventas Desde:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="ventas_desde">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Ventas Hasta:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" inputmode="numeric" id="ventas_hasta">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>

                                    <div class="col-md-2">

                                    </div>

                                    <div class="col-md-2">

                                    </div>

                                    <div class="col-md-2">

                                    </div>

                                    <div class="col-md-2 d-inline-flex justify-content-end align-items-center">
                                        <div class="form-group">
                                            <button class="btn btn-primary" style="width:120px;" id="btnFiltrar">Buscar</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card card-primary -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->

                <!-- ROW PARA MOSTRAR EL TOTAL DE LAS VENTAS LISTADAS -->
                <div class="row mb-3">

                    <div class="col-md-10">
                        <h3>Total Venta: S./ <span id="totalVenta">0.00</span></h3>
                    </div>

                </div>
                <!-- /.row -->

                <!-- ROW QUE CONTIENE EL LA TABLA CON EL LISTADO DE VENTAS POR RANGO DE FECHAS -->
                <div class="row mt-4">

                    <div class="col-md-12">

                        <table id="lstVentas" class="display nowrap table-striped w-100 shadow ">
                            <thead class="bg-info">
                                <tr>

                                    <th style="width:10%;">idVenta</th>
                                    <th>Documento</th>
                                    <th>Serie</th>
                                    <th>Numero</th>
                                    <th>Usuario</th>
                                    <th>Forma pago</th>
                                    <th>Total venta</th>
                                    <th>Estado</th>
                                    <th>Fecha Venta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                            </tbody>
                        </table>
                        <!-- / table -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row -->

            </div>

        </div>

    </section>

</div>




<script>
    $(document).ready(function() {

        var table;
        var TotalVenta = 0.00;

        //Datemask dd/mm/yyyy
        $('#ventas_desde').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })

        $('#ventas_hasta').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })


        $("#ventas_desde").val(moment().format('DD/MM/YYYY'));
        $("#ventas_hasta").val(moment().format('DD/MM/YYYY'));

        ventas_desde = $("#ventas_desde").val();
        ventas_hasta = $("#ventas_hasta").val();


        ventas_desde = ventas_desde.substr(6, 4) + '-' + ventas_desde.substr(3, 2) + '-' + ventas_desde.substr(0, 2);
        ventas_hasta = ventas_hasta.substr(6, 4) + '-' + ventas_hasta.substr(3, 2) + '-' + ventas_hasta.substr(0, 2);


        var groupColumn = 0;

        table = $('#lstVentas').DataTable({
            "columnDefs": [{
                    "visible": false,
                    "targets": groupColumn
                },
                {
                    targets: 1,
                    orderable: true
                },
                {
                    targets: 2,
                    orderable: false
                },
                {
                    targets: 3,
                    orderable: false
                },
                {
                    targets: 4,
                    orderable: false
                },
                {
                    targets: 5,
                    orderable: false
                }
            ],
            "order": [
                [groupColumn, 'asc']
            ],
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print', 'pageLength',

            ],
            "ordering": true,
            orderCellsTop: true,
            fixedHeader: true,
            "scrollX": false,
            ajax: {

                url: 'ajax/ventas.ajax.php',
                type: 'POST',
                dataType: 'json',
                "dataSrc": function(respuesta) {
                    TotalVenta = 0.00;
                    for (let i = 0; i < respuesta.length; i++) {
                        TotalVenta = parseFloat(respuesta[i][5].replace('S./ ', '')) + parseFloat(TotalVenta);
                    }

                    $("#totalVenta").html(TotalVenta.toFixed(2))
                    return respuesta;
                },
                data: {
                    'ajaxListarVenta': 'ajaxListarVenta',
                    'fechaDesde': ventas_desde,
                    'fechaHasta': ventas_hasta
                },
                lengthMenu: [0, 5, 10, 15, 20, 50, 100, 200, 300, 500],
                "pageLength": 15
            },
            lengthMenu: [0, 5, 10, 15, 20, 50, 100, 200, 300, 500],
            "pageLength": 15,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                // console.log("🚀 ~ file: administrar_ventas.php ~ line 240 ~ $ ~ rows", rows)
                var last = null;

                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {



                    if (last !== group) {

                        const data = group.split("-");
                        var idVenta = data[0];
                        idVenta = idVenta.split(":")[1].trim();

                        $(rows).eq(i).before(
                            '<tr class="group"><td colspan="6" class="fs-6 fw-bold fst-italic bg-success text-white"> <i idVenta = ' + idVenta + ' class="fas fa-trash fs-6 text-danger mx-2 btnEliminarVenta" style="cursor:pointer;"></i> ' + group + ' </td></tr>'
                        );

                        last = group;
                    }
                });
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }

        })


    })
</script>