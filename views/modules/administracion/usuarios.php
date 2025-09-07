<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(9, $idPerfil);

?>

<?php if ($permisos["acronimo"] == "verusuarios" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión de usuarios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
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
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(10, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrusuarios" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalUsuarios">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-hover dt-responsive tablaUsuario" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Trabajador</th>
                                        <th>Sucursal</th>
                                        <th>Usuario</th>
                                        <th>Tipo de Usuario</th>
                                        <th>Ultimo Ingreso</th>
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
<div class="modal fade" id="modalUsuarios" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
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
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>

                                    <input type="hidden" id="idUsuario" name="idUsuario">
                                    <select class="form-control" id="idEmpleado" name="idEmpleado">
                                        <!-- <select class="form-control select2" > -->
                                        <option value="">Seleccionar Empleado</option>
                                        <?php

                                        $item = null;
                                        $valor = null;

                                        $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);

                                        foreach ($empleado as $key => $value) {
                                            echo '<option value="' . $value["idEmpleado"] . '">' . $value["nombres"] . ' ' . $value["apellidos"] . '</option>';
                                        }

                                        ?>

                                    </select>


                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-store"></i></span>
                                    </div>

                                    <select class="form-control" id="idAlmacen" name="idAlmacen">
                                        <!-- <select class="form-control select2" > -->
                                        <option value="">Seleccionar Sucursal</option>
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
                                        <span class="input-group-text"><i class="fas fa-user-secret"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="login" name="login"
                                        placeholder="Usuario">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="hidden" id="passActual" name="passActual">
                                    <input type="password" class="form-control" id="passlogin" name="passlogin"
                                        placeholder="Contraseña">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                    </div>

                                    <select class="form-control input-lg" id="idPerfil" name="idPerfil">

                                        <option value="">Selecionar perfil</option>

                                        <?php

                                        $item = null;
                                        $valor = null;

                                        $almacen = ControllerPerfil::ctrMostrarPerfil($item, $valor);

                                        foreach ($almacen as $key => $value) {
                                            if($value["estado"]==0){
                                                echo '<option value="' . $value["idPerfiles"] . '">' . $value["descripcion"] . '</option>';
                                            }else{

                                            }

                                          
                                        }

                                        ?>





                                    </select>
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarUsuario">Guardar</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/usuarios.js"></script>