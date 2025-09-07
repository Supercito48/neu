<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(56, $idPerfil);
$permisosaper = ControllerPerfil::ctrMostrarMenuPermisos(57, $idPerfil); 
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
date_default_timezone_set("America/Lima");
?>
<?php if ($permisos["acronimo"] == "vercaja" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="animate__animated animate__zoomIn"><i class="fas fa-cash-register"></i>&nbsp;<b>CAJA</b>
                    </h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Caja</li>
                        <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
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

                        <?php
            $exp = explode("/", $_GET["ruta"]);


            ?>
                        <?php if ($_SESSION["idPerfil"] == 0) : ?>
                        <?php if (isset($exp[1])) : ?>
                        <?php

                $item = "idAlmacen";
                $valor = $exp[1];

                $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);



                $item = "idEmpleado";
                $valor = $_SESSION["idEmpleado"];

                $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);




                ?>
                        <div class="card-header">
                            <h2>Sucursal: <?php echo $AlmacenP["descripcion"]; ?></h2>

                            <input type="hidden" id="idAlmacen" value="<?php echo $exp[1]; ?>">
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                            <input type="hidden" id="nombreUsuario"
                                value="<?php echo $empleado["nombres"] . ' ' . $empleado["apellidos"]; ?>">


                            <?php if ($permisosaper["acronimo"] == "apercaja" && $permisosaper["estado"] == "on" && $permisosaper["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modal_Apertura">
                                APERTURAR CAJA
                            </button>
                            <?php else : ?>

                            <?php endif ?>

                            <button type="button" class="btn btn-inline btn-danger" onClick="history.back();">
                                REGRESAR
                            </button><br><br>

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
                                                <div class="col-md-3">
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
                                                                inputmode="numeric" id="txtfechainicio">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
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
                                                                inputmode="numeric" id="txtfechafin">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>



                                                <div class="col-md-2">

                                                </div>



                                                <div
                                                    class="col-md-4 d-inline-flex justify-content-end align-items-center">
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

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover tablaCaja" cellspacing="0" width="100%">
                                    <thead class="bg-success">
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha Apertura</th>
                                            <th>Fecha Cierre</th>
                                            <th>Apertura</th>
                                            <th>Ingresos</th>
                                            <th>Egresos</th>
                                            <th>Cierre</th>
                                            <th>Usuario</th>
                                            <th>Estado </th>
                                            <th>Acciones </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <?php else : ?>

                        <?php

                $item = null;
                $valor = null;

                $Almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                ?>
                        <div class="card-header">
                            <h3>Seleccione Sucursal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">

                                <?php foreach ($Almacen as $key => $value) : ?>

                                <?php if ($value["idAlmacen"] == 998) : ?>





                                <?php else : ?>
                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?php echo $value["descripcion"]; ?></h3>

                                            <p><?php echo $value["ubicacion"]; ?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <a href="caja/<?php echo $value["idAlmacen"]; ?>" class="small-box-footer">
                                            Ir a recepción <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>




                            </div>
                        </div>
                        <?php endif ?>
                        <!-- modificar hasta aqui sobre super administrador-->
                        <?php else : ?>


                        <?php

              $item = "idAlmacen";
              $valor = $_SESSION["idAlmacen"];

              $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);


              $item = "idEmpleado";
              $valor = $_SESSION["idEmpleado"];

              $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);



              ?>
                        <div class="card-header">
                            <h2>Sucursal: <?php echo $AlmacenP["descripcion"]; ?></h2>

                            <input type="hidden" id="idAlmacen" value="<?php echo $_SESSION["idAlmacen"]; ?>">
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                            <input type="hidden" id="nombreUsuario"
                                value="<?php echo $empleado["nombres"] . ' ' . $empleado["apellidos"]; ?>">
                            <?php if ($permisosaper["acronimo"] == "apercaja" && $permisosaper["estado"] == "on" && $permisosaper["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modal_Apertura">
                                APERTURAR CAJA
                            </button>
                            <?php else : ?>

                            <?php endif ?>

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
                                                <div class="col-md-3">
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
                                                                inputmode="numeric" id="txtfechainicio">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
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
                                                                inputmode="numeric" id="txtfechafin">
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>



                                                <div class="col-md-2">

                                                </div>



                                                <div
                                                    class="col-md-4 d-inline-flex justify-content-end align-items-center">
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

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover tablaCaja" cellspacing="0" width="100%">
                                    <thead class="bg-success">
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha Apertura</th>
                                            <th>Fecha Cierre</th>
                                            <th>Apertura</th>
                                            <th>Ingresos</th>
                                            <th>Egresos</th>
                                            <th>Cierre</th>
                                            <th>Usuario</th>
                                            <th>Estado </th>
                                            <th>Acciones </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>


                    <?php endif ?>


                </div>

            </div>

        </div>



    </section>

</div>

<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>




<div class="modal fade" id="modal_Apertura" tabindex="-1" aria-labelledby="modal_Apertura" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-green py-2">
                <h6 class="modal-title" id="titulo_modal_caja">Apertura Caja</h6>
                <button data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">


                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Monto apertura:</span>
                            </label>
                            <input type="number" min="0" step="0.1" class="form-control form-control-sm"
                                id="monto_apertura" placeholder="Ingrese el importe">
                        </div>
                    </div>



                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 guardarAbrirCaja "><i
                        class="fas fa-check"><b>&nbsp;Abrir caja</b></i></button>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_cuentas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger py-2">
                <h4 class="modal-title w-100 text-center" id="titleModal"><i
                        class="fas fa-cash-register"></i>&nbsp;<b>CIERRE CAJA</b></h>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-12 mb-3">
                        <input type="hidden" id="idCaja">
                        <label for="" class="form-label text-primary d-block">Monto Apertura:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="montoApertura"
                                class="text-secondary"></span></label>
                        <label for="" class="form-label text-primary d-block">Total Ventas:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="totalventas"
                                class="text-secondary"></span></label>
                        <label for="" class="form-label text-primary d-block">Total Ingreso:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="totalingreso"
                                class="text-secondary"></span></label>
                        <label for="" class="form-label text-primary d-block">Total Egreso:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="totalegreso"
                                class="text-danger"></span></label>

                        <label for="" class="form-label text-primary d-block">Total Efectivo Final:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="totalfinal"
                                class="text-success"></span></label>

                    </div>





                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 btnCerrarCaja "><i
                        class="fas fa-check"><b>&nbsp;Cerrar Caja</b></i></button>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="mdlGestionarCaja" tabindex="-1" aria-labelledby="mdlGestionarCaja" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success py-2">
                <h6 class="modal-title" id="titulo_modal_caja">Gestionar Caja</h6>
                <button data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <input type="hidden" id="tipo">
                    <input type="hidden" id="idCajaM">
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Importe:</span>
                            </label>
                            <input type="number" min="0" step="0.1" class="form-control form-control-sm" id="monto"
                                placeholder="Ingrese el importe">
                        </div>
                    </div>

                    <div class="col-12" id="col_descripcion">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Descripción:</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="descripcion"
                                placeholder="Ingrese la descripcion">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 btnGuardar "><i
                        class="fas fa-check"><b>&nbsp;Guardar Caja</b></i></button>

            </div>

        </div>
    </div>
</div>




<div class="modal fade animate__animated animate__slideInDown" id="modal_vista" tabindex="-1" role="dialog"
    data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="header-modal" class="card card-success">
                <div class="card-header">
                    <h4 class="modal-title w-100 text-center" id="titleModal"><i
                            class="nav-icon fas fa-info-circle"></i>&nbsp;<b>Detalle Movimientos Caja<b
                                id="titulo"></b></b></h>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12" id="contenedor-orden">
                            <div class="card border-secondary mx-auto mb-3" style="max-width: 45rem;">
                                <div class="card-header text-center" style="background-color: #F2F3F4">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Fecha:
                                                    <span class="text-muted" id="fechaCaja">21/21/21
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>

                                        <div class="col-md-6">
                                            <h5 class="font-weight-bold">
                                                <strong class="text-success">Cajero Resp.:
                                                    <span class="text-muted" style="text-transform:capitalize;"
                                                        id="cajeroCaja">JUAN QUISPE
                                                    </span>
                                                </strong>
                                            </h5>
                                        </div>



                                    </div>
                                </div>
                                <div class="card-body text-secondary">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2>Ingreso</h2>
                                            <table class="tablaIngreso table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Descripción</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                </thead>
                                                <tbody>





                                                </tbody>
                                            </table>


                                        </div>

                                        <div class="col-md-6">
                                            <h2>Egreso</h2>
                                            <table class="tablaEgreso table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Usuario</th>
                                                        <th>Descripción</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger float-right m-1 "><i
                                            class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo $url ?>views/js/caja.js"></script>