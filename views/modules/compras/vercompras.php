<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(47, $idPerfil);
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();

date_default_timezone_set("America/Lima");
?>
<?php if ($permisos["acronimo"] == "vercompra" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Administrar Compras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Administrar Compras</li>
                        <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
                        <input type="hidden" id="simbolom" value="<?php echo $configuracion[0]["simbolom"]; ?> ">
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="compras" class="btn btn-inline btn-success">
                                Nueva Compra
                            </a>
                            <br><br>
                            <div class="row">

                                <div class="col">
                                    <div class="card card-success">
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
                                                                <span class="input-group-text"><i
                                                                        class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control"
                                                                data-inputmask-alias="datetime"
                                                                data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                                                                inputmode="numeric" id="compras_desde">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Ventas Hasta:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                            <input type="date" class="form-control"
                                                                data-inputmask-alias="datetime"
                                                                data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                                                                inputmode="numeric" id="compras_hasta">
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

                                                <div
                                                    class="col-md-2 d-inline-flex justify-content-end align-items-center">
                                                    <div class="form-group">
                                                        <button class="btn btn-danger" style="width:120px;"
                                                            id="btnQFiltro">Quitar</button>
                                                        <button class="btn btn-primary" style="width:120px;"
                                                            id="btnFiltrar">Buscar</button>
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

                            <div class="row mb-3">

                                <div class="col-md-10">
                                    <h3><strong>Total Compra: <?php echo $configuracion[0]["simbolom"];?> <span
                                                id="totalCompra2">0.00</span></strong></h3>

                                </div>

                            </div>
                            <table class="table table-bordered table-hover nowrap dt-responsive tablaVerCompra"
                                cellspacing="0" width="100%">
                                <thead class="bg-success">


                                    <tr>
                                        <!-- cambiar aqui-->
                                        <th>#</th>
                                        <th>Comprobante</th>
                                        <th>Serie</th>

                                        <th>Numero</th>

                                        <th>Proveedor</th>
                                        <th>Usuario</th>
                                        <th>Forma pago</th>
                                        <th>Total compra</th>
                                        <th>Estado </th>
                                        <th>Fecha </th>

                                        <th>Acciones </th>
                                        <!-- <th class="all">Acciones </th>-->
                                    </tr>
                                </thead>
                                <tbody class="text-left">


                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>
<div class="modal fade animate__animated animate__slideInDown" id="modal_vista" tabindex="-1" role="dialog"
    data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="header-modal" class="card card-success">
                <div class="card-header">
                    <h4 class="modal-title w-100 text-center" id="titleModal"><i
                            class="nav-icon fas fa-info-circle"></i>&nbsp;<b>Detalle Compra<b id="titulo"></b></b></h>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="contenedor-orden">
                            <div class="card border-secondary mx-auto mb-3" style="max-width: 45rem;">
                                <div class="card-header text-center" style="background-color: #F2F3F4">
                                    <h5 class="font-weight-bold">
                                        <strong class="text-success">Fecha registro:
                                            <input type="hidden" id="idCompra">
                                            <span class="text-muted" id="fecha_registro">fecha
                                            </span>
                                        </strong>
                                    </h5>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Proveedor:
                                                    <span class="text-muted" id="idProveedor">Proveedor
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Responsable:
                                                    <span class="text-muted" style="text-transform:capitalize;"
                                                        id="idUsuario">Usuario
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Comprobante:
                                                    <span class="text-muted" id="idDocalmacen">Comprobante
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Serie:
                                                    <span class="text-muted" id="serie">Serie
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                        <div class="col-md-4">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">N°:
                                                    <span class="text-muted" id="num_documento">N°
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-body text-secondary">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <table class="pruebadata table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>idCompra</th>
                                                        <th>Codigo</th>
                                                        <th>Descripción</th>
                                                        <th style="width: 40px">Cantidad</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Total</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="subtotal">Sub Total:</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                        class="fas fa-money-bill-alt"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="subtotal"
                                                                name="subtotal" disabled>
                                                            <div class="valid-input invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="igv">IGV:</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                        class="fas fa-money-bill-alt"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="igv" name="igv"
                                                                disabled>
                                                            <div class="valid-input invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="total">Total:</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text"><i
                                                                        class="fas fa-money-bill-alt"></i></div>
                                                            </div>
                                                            <input type="text" class="form-control" id="total"
                                                                name="total" disabled>
                                                            <div class="valid-input invalid-feedback"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script src="<?php echo $url ?>views/js/vercompras.js"></script>