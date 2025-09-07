<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(68, $idPerfil);

?>

<?php if ($permisos["acronimo"] == "verconf" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Configuración Sistema</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Configuracion</li>
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

                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="tablaConfiguracion" class="table table-bordered table-hover" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Logo</th>
                                        <th>Ruc</th>
                                        <th>Razon Social</th>
                                        <th>Direccion</th>
                                        <th>Email</th>
                                        <th>Moneda</th>
                                        <th>Simbolo</th>
                                        <th>Impuesto</th>
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

<div class="modal fade" id="modalConfiguracion" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
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
                                <input type="hidden" class="idEmpresa">
                                <input type="number" name="ruc" class="form-control ruc" placeholder="RUC">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-th"></i></span>
                                </div>
                                <input type="text" name="razon_social" class="form-control razon_social"
                                    placeholder="Razon Social">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="direccion" class="form-control direccion"
                                    placeholder="Dirección">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control email" placeholder="Email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                </div>
                                <input type="text" name="moneda" class="form-control moneda" placeholder="Moneda">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                </div>
                                <input type="text" name="simbolom" class="form-control simbolom"
                                    placeholder="Simbolo Moneda">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                </div>
                                <input type="number" name="impuesto" class="form-control impuesto"
                                    placeholder="Impuesto">
                            </div>



                        </div>

                    </div>

                    <div class="form-group">

                        <h6 class="with-border"><small>SUBIR Logo</small></h6>
                        <input type="hidden" class="antiguoLogo">

                        <input type="file" class="logo">

                        <p class="help-block"><small>Peso máximo de la foto 200 MB</small></p>

                        <img src="<?php echo $url; ?>views/img/empleado/default/avatar4.png"
                            class="img-thumbnail previsualizarFoto" width="100px">

                    </div>

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarConfiguracion">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script src="<?php echo $url ?>views/js/configuracion.js"></script>