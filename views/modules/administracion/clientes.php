<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(62, $idPerfil);

?>

<?php if ($permisos["acronimo"] == "vercli" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de clientes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Clientes</li>
                        <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
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
                        <div class="card-header">
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(63, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrcli" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalClientes">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-hover dt-responsive tablaClientes" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Nombres</th>
                                        <th>Dirección</th>
                                        <th>Telefono</th>
                                        <th>Limite de Credito</th>
                                        <th>Credito restante</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php else : ?>
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>
<div class="modal fade" id="modalClientes" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <form id="formularioUsuarios" role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                    <div class="box-body">

                        <div class="form-group">

                            <div class="input-group">

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                    </div>

                                    <input type="hidden" class="idCliente" name="idCliente">

                                    <input type="number" class="form-control dni" name="dni" placeholder="DNI">

                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control nombres" name="nombres"
                                        placeholder="Nombres">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>

                                    <input type="text" class="form-control direccion" name="direccion"
                                        placeholder="Dirección">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>

                                    <input type="number" class="form-control telefono" name="telefono"
                                        placeholder="Telefono">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    </div>

                                    <input type="number" class="form-control limite_credito" name="limite_credito"
                                        placeholder="Credito">
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarCli">Guardar</button>
                    <button type="button" class="btn btn-outline-light editarCli">Editar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

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
<script src="<?php echo $url ?>views/js/clientes.js"></script>