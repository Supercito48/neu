<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(46, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "nuevacompra" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Estado de Cuenta del cliente</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Estado de cuenta</li>
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
                        <div class="card-body">

                            <div class="content">
                                <div class="container-fluid">

                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <center>
                                                <h2 class="text-success"><strong> Estado de Cuenta</strong> </h2>
                                            </center>
                                            <div class="row">


                                                <div class="col-md-12 mb-3">

                                                    <div class="form-group mb-2">
                                                        <h3><strong>Cliente: <span id="nomCli"> Juan Quispe
                                                                </span></strong></h3>
                                                        <input type="hidden" id="idCliente" name="idCliente"
                                                            value="<?php echo $_GET["idCliente"]; ?>">


                                                    </div>
                                                    <input type="hidden" id="idUsuario"
                                                        value="<?php echo $_SESSION["idUsuario"]; ?>">

                                                </div>

                                                <?php $configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();?>

                                                <div class="col-md-6 mb-3">
                                                    <h3 class="text-success"><strong>Saldo Utilizado Actual:
                                                            <?php echo $configuracion[0]["simbolom"];?> <span
                                                                id="saldoAct">10.00</span></strong></h3>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h3 class="text-success"><strong>Limite de credito:
                                                            <?php echo $configuracion[0]["simbolom"];?> <span
                                                                id="limitCredit">10.00</span></strong></h3>
                                                </div>

                                                <div class="col-md-12">

                                                    <button class="btn btn-secondary" id="btnImprimirEstado">
                                                        <i class="fas fa-print"></i> Imprimir Estado
                                                    </button>

                                                    <button class="btn btn-warning" id="btnAbonar" data-toggle='modal'
                                                        data-target='#moda_pagar'>
                                                        <i class="fas fa-hand-holding-usd"></i> Abonar
                                                    </button>

                                                    <button class="btn btn-success" id="btnLiquidarAdeudo">
                                                        <i class="fas fa-coins"></i> Liquidar Adeudo
                                                    </button>

                                                    <button class="btn btn-primary" id="btnDetalleAbono"
                                                        data-toggle='modal' data-target='#modal_detalleAbono'>
                                                        <i class="fas fa-file-invoice-dollar"></i> Detalle de Abono
                                                    </button>


                                                </div>

                                            </div>
                                            <br>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="table-responsive">

                                                <table id="lstMes" class="table table-bordered" cellspacing="0"
                                                    width="100%">

                                                    <thead class="bg-info text-left fs-6">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>idVenta</th>
                                                            <th>Acción</th>


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- / table -->
                                        </div>
                                        <!-- /.col -->







                                        <div class="col-md-9 px-2">

                                            <div class="col-md-12">

                                                <div class="table-responsive">

                                                    <table id="lstDetCred" class="table table-bordered" cellspacing="0"
                                                        width="100%">

                                                        <thead class="bg-info text-left fs-6">
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Codigo</th>
                                                                <th>Producto</th>
                                                                <th>Precio Venta</th>
                                                                <th>Cantidad</th>

                                                                <th>Total</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <!-- / table -->
                                            </div>
                                        </div>
                                        <!-- /.col -->



                                    </div>
                                </div>


                            </div>





    </section>

</div>

<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>

<div class="modal fade" id="moda_pagar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success py-2">
                <h4 class="modal-title w-100 text-center" id="titleModal"><i
                        class="fas fa-concierge-bell"></i>&nbsp;<b>Pagar Deuda</b></h>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-12 mb-3">


                        <h4 class="montopagarlabel form-label text-primary">Monto de credito usado: S/.<span
                                id="creditusado" class="text-secondary">0.00</span></h4>
                        <input type="hidden" id="preciopagado">



                    </div>

                    <div class="col-12" id="pruebaesconder">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fab fa-cc-visa fs-6"></i> <span class="small" id="titulo_modal_label">Metodo
                                    de
                                    pago</span>
                            </label>
                            <select type="text" class="form-control select2" id="metodo_pago" name="metodo_pago">
                                <option value="" selected="true">Seleccione Tipo Pago</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Yape">Yape</option>
                                <option value="Plin">Plin</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fab fa-cc-visa fs-6"></i> <span class="small" id="titulo_modal_label">Monto a
                                    pagar</span>
                            </label>
                            <input type="number" class="form-control" id="monto_p" name="monto_p" placeholder="Monto"
                                required>

                            <input type="hidden" id="montoescrito">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="chkComision" disabled>
                            <label class="form-check-label" for="chkComision">
                                COMISIÓN
                            </label>
                        </div>

                    </div>



                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 pagarCreditoC "><i
                        class="fas fa-check"><b>&nbsp;Pagar</b></i></button>

            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modal_detalleAbono" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success py-2">
                <h4 class="modal-title w-100 text-center" id="titleModal"><i
                        class="fas fa-concierge-bell"></i>&nbsp;<b>Detalle Abonos</b></h>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">

                <div class="row">




                    <table id="lstDetalleAbono" class="table table-bordered" cellspacing="0" width="100%">

                        <thead class="bg-success text-left fs-6">
                            <tr>
                                <th>Metodo</th>
                                <th>Metodo</th>
                                <th>Monto</th>
                                <th>Fecha</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>




                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>


            </div>

        </div>
    </div>
</div>
<script src="<?php echo $url ?>views/js/estadocuenta.js"></script>