<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(13, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verprov" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Proveedores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Proveedores</li>
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
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(14, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrprov" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalProveedores">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover dt-responsive tablaProveedores">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>RUC</th>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Celular</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>


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

<div class="modal fade" id="modalProveedores">
    <div class="modal-dialog">
        <div class="modal-content bg-success">

            <form id="formularioProveedores" role="form" method="post">

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
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="hidden" id="idProveedor" name="idProveedor">
                                    <input type="number" class="form-control" id="RUC" name="RUC" placeholder="RUC">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombre">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        placeholder="Direccion">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="celular" name="celular"
                                        placeholder="Celular">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input type="number" class="form-control" id="telefono" name="telefono"
                                        placeholder="Telefono">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-light guardarProveedores">Guardar</button>
                    <!-- onclick="validarCorreo(event)" -->
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/proveedores.js"></script>