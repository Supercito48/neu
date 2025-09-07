<?php
$url = Ruta::ctrRuta();
$idMenu = 1;
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(1, $idPerfil);

$DateAndTime = date('H:i:s', time());  
echo "The current date and time are $DateAndTime.";
?>
<?php if ($permisos["acronimo"] == "veralmacen" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Almacen</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>

                        <li class="breadcrumb-item active">Almacen</li>
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

                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(2, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agralmacen" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalAlmacen">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover tablaAlmacen">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descripcion</th>
                                        <th>Ubicacion</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Estado</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
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
<?php   require_once "views/modules/404.php";?>
<?php endif ?>


<div class="modal fade" id="modalAlmacen" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-success">

            <form id="formularioAlmacen" role="form" method="post">

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
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <input type="hidden" id="idAlmacen" name="idAlmacen">
                                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                                        placeholder="Descripción">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="hidden" class="idEmpleado">

                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion"
                                        placeholder="Ubicacion">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" class="form-control" id="hora_entrada" name="hora_entrada"
                                        placeholder="Ingrese correo" required><br>

                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                    <input type="time" class="form-control" id="hora_salida" name="hora_salida"
                                        placeholder="Ingrese correo" required><br>
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">

                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarAlmacen">Guardar</button>




                </div>

            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<script src="<?php echo $url ?>views/js/almacen.js"></script>