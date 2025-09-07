<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(52, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "vercomprob" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Conf. Comprobante</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                            <li class="breadcrumb-item active">Conf. Comprobante</li>
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

                                <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(53, $idPerfil); ?>

                                <?php if ($permisosagr["acronimo"] == "agrcomprob" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                                    <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#modalComprobante">
                                        AGREGAR
                                    </button>
                                <?php else : ?>

                                <?php endif ?>


                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table class="table table-bordered table-hover dt-responsive tablaComprobante" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sucursal</th>
                                            <th>Documento</th>
                                            <th>Serie</th>
                                            <th>Cantidad</th>
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

<div class="modal fade" id="modalComprobante" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-success">

            <form id="formularioComprobante" role="form" method="post">

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
                        <input type="hidden" id="idDocalmacen">
                        <?php if ($_SESSION["idPerfil"] == 0) : ?>

                            <div class="form-group">

                                <div class="input-group">

                                    <div class="input-group mb-3">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                                        </div>

                                        <select class="form-control" id="idAlmacen" name="idAlmacen">

                                            <option value="">Seleccionar Almacen</option>
                                            <?php

                                            $item = null;
                                            $valor = null;

                                            $almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                            foreach ($almacen as $key => $value) {
                                                echo '<option value="' . $value["idAlmacen"] . '">' . $value["descripcion"] . '</option>';
                                            }

                                            ?>

                                        </select>

                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>

                                        <input type="text" class="form-control Documento" id="Documento" name="Documento" placeholder="Descripción">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>

                                        <input type="text" class="form-control Serie" id="Serie" name="Serie" placeholder="Serie">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>
                                        <input type="number" class="form-control Cantidad" id="Cantidad" name="Cantidad" placeholder="Cantidad" value="00000000">

                                    </div>

                                </div>

                            </div>

                        <?php else : ?>

                            <div class="form-group">

                                <div class="input-group">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>
                                        <input type="hidden" id="idDocalmacen" name="idDocalmacen">
                                        <input type="hidden" id="idAlmacen" name="idAlmacen" value="<?php echo $_SESSION["idAlmacen"] ?>">
                                        <input type="text" class="form-control Documento" id="Documento" name="Documento" placeholder="Descripción">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>

                                        <input type="text" class="form-control Serie" id="Serie" name="Serie" placeholder="Serie">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-th"></i></span>
                                        </div>
                                        <input type="text" class="form-control Cantidad" id="Cantidad" name="Cantidad" placeholder="Cantidad">

                                    </div>

                                </div>

                            </div>

                        <?php endif ?>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarComprobante">Guardar</button>
                    <button type="button" class="btn btn-outline-light editarComprob">Editar</button>
                </div>

            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<script src="<?php echo $url ?>views/js/comprobante.js"></script>