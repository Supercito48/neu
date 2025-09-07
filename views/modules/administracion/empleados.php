<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(5, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verempleado" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Empleados</h1>
                </div>


                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Empleados</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-header">

                <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(6, $idPerfil); ?>

                <?php if ($permisosagr["acronimo"] == "agrempleado" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                    data-target="#modalEmpleado">
                    AGREGAR
                </button>
                <?php else : ?>

                <?php endif ?>


                <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">
            </div>
            <div class="card-body pb-0">
                <div id="prueba" class="row">
                    <?php

            /*=============================================
			LLAMADO DE PAGINACIÓN
			=============================================*/

            if (isset($ruta[1]) && preg_match('/^[0-9]+$/', $ruta[1])) {

              $item = null;
              $valor = null;
              $ordenar = "idEmpleado";
              $base = ($ruta[1] - 1) * 6;
              $tope = 6;
            } else {
              $item = null;
              $valor = null;
              $ordenar = "idEmpleado";
              $ruta[1] = 1;
              $base = 0;
              $tope = 6;
            }

            $empleado = ControllerEmpleado::ctrMostrarEmpleados($ordenar, $item, $valor, $base, $tope);
            $listaEmpleado = ControllerEmpleado::ctrListarEmpleado($ordenar, $item, $valor);



            ?>

                    <?php foreach ($empleado as $key => $value) : ?>

                    <?php
              $itemusuario = "idEmpleado";
              $valorusuario = $value["idEmpleado"];

              $usuarios = ControllerUsuarios::ctrMostrarUsuario($itemusuario, $valorusuario);

              ?>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                                Empleado
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b> Nombres: <?php echo $value["nombres"]; ?></b></h2>
                                        <h2 class="lead"><b> Apellidos:<?php echo $value["apellidos"]; ?></b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> Celular:
                                                <?php echo $value["telefono"]; ?> </li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-building"></i></span> Direccion:
                                                <?php echo $value["direccion"]; ?></li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> DNI:
                                                <?php echo $value["dni"]; ?></li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span>
                                                Email:<?php echo $value["correo"]; ?> </li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span> Fecha Nacimiento:
                                                <?php echo $value["fecNacimiento"]; ?></li>


                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="<?php echo $url; ?><?php echo $value["foto"]; ?>" alt="user-avatar"
                                            class="img-circle img-fluid" width="150px">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <?php $permisosed = ControllerPerfil::ctrMostrarMenuPermisos(7, $idPerfil); ?>

                                    <?php if ($permisosed["acronimo"] == "editempleado" && $permisosed["estado"] == "on" && $permisosed["existe"] == 1) : ?>
                                    <button data-toggle="modal" data-target="#modalEditarEmpleado"
                                        class="btn btn-warning btn-sm editarEmpleado"
                                        id="<?php echo $value["idEmpleado"]; ?>">
                                        <i class="fas fa-edit"></i>&nbsp; Editar
                                    </button>
                                    <?php else : ?>

                                    <?php endif ?>

                                    <?php $permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(8, $idPerfil); ?>
                                    <?php if ($permisoseli["acronimo"] == "elimempleado" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1) : ?>
                                    <?php if ($value["foto"] !=  "views/img/empleado/default/avatar4.png") : ?>

                                    <button class="btn btn-sm btn-danger eliminarEmpleado"
                                        idEliminar="<?php echo $value["idEmpleado"]; ?>"
                                        fotoEliminar="<?php echo $value["foto"]; ?>"
                                        idUsuarioEliminar="<?php echo $usuarios["idUsuario"]; ?>">
                                        <i class="fa fa-times"></i>&nbsp; Eliminar
                                    </button>

                                    <?php else : ?>

                                    <button class="btn btn-sm btn-danger eliminarEmpleado"
                                        idEliminar="<?php echo $value["idEmpleado"]; ?>" fotoEliminar=""
                                        idUsuarioEliminar="<?php echo $usuarios["idUsuario"]; ?>">
                                        <i class="fa fa-times"></i>&nbsp; Eliminar
                                    </button>

                                    <?php endif ?>
                                    <?php else : ?>

                                    <?php endif ?>



                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>




            <?php

        /*=============================================
			LLAMADO DE PAGINACIÓN
			=============================================*/
        if (count($listaEmpleado) != 0) {

          $pagEmpleado = ceil(count($listaEmpleado) / 6);

          if ($pagEmpleado > 4) {
          } else {

            echo '<div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                <ul class="pagination justify-content-center m-0">';

            for ($i = 1; $i <= $pagEmpleado; $i++) {

              echo '<li class="page-item' . $i . '"><a class="page-link" href="' . $url . $ruta[0] . '/' . $i . '">' . $i . '</a></li>';
            }

            echo '</ul>
              </nav>
              </div>';
          }
          //var_dump( $pagEmpleado );
        }

        ?>

            <!-- /.card-body -->
            <!--<div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
          <ul class="pagination justify-content-center m-0">
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>-->
            <!--<li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">20</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
          </ul>
        </nav>
      </div>
      /.card-footer -->
        </div>
        <!-- /.card -->

    </section>
</div>
<!-- Default box -->

<!-- ./w

rapper -->
<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>
<!-- Content Wrapper. Contains page content -->


<div class="modal fade" id="modalEmpleado" role="dialog">
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
                                <input type="number" name="dni" class="form-control dni" placeholder="dni">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-th"></i></span>
                                </div>
                                <input type="text" name="nombres" class="form-control nombres" placeholder="Nombres">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-th"></i></span>
                                </div>
                                <input type="text" name="apellidos" class="form-control apellidos"
                                    placeholder="apellidos">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="number" name="telefono" class="form-control telefono"
                                    placeholder="telefono">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="direccion" class="form-control direccion"
                                    placeholder="direccion">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                </div>
                                <input type="text" name="correo" class="form-control correo" placeholder="correo">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" name="fecNacimiento" class="form-control fecNacimiento"
                                    placeholder="Fecha de Nacimiento">
                            </div>


                        </div>

                    </div>

                    <div class="form-group">

                        <h6 class="with-border"><small>SUBIR FOTO</small></h6>

                        <input type="file" class="foto">

                        <p class="help-block"><small>Peso máximo de la foto 200 MB</small></p>

                        <img src="<?php echo $url; ?>views/img/empleado/default/avatar4.png"
                            class="img-thumbnail previsualizarFoto" width="100px">

                    </div>

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarEmpleado">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!--=============================================
              =           MODAL PARA EDITAR     =
              =============================================-->
<div class="modal fade" id="modalEditarEmpleado" role="dialog">
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
                                <input type="text" name="dni" class="form-control dni" placeholder="dni">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-th"></i></span>
                                </div>
                                <input type="hidden" class="idEmpleado">

                                <input type="text" name="nombres" class="form-control nombres" placeholder="Nombres">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-th"></i></span>
                                </div>
                                <input type="text" name="apellidos" class="form-control apellidos"
                                    placeholder="apellidos">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                </div>
                                <input type="text" name="telefono" class="form-control telefono" placeholder="telefono">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                </div>
                                <input type="text" name="direccion" class="form-control direccion"
                                    placeholder="direccion">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                                </div>
                                <input type="text" name="correo" class="form-control correo" placeholder="correo">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" name="fecNacimiento" class="form-control fecNacimiento"
                                    placeholder="Fecha de Nacimiento">
                            </div>


                        </div>

                    </div>

                    <div class="form-group">

                        <h6 class="with-border"><small>SUBIR FOTO</small></h6>

                        <input type="file" class="foto">
                        <input type="hidden" class="antiguaFoto">

                        <p class="help-block"><small>Peso máximo de la foto 200 MB</small></p>

                        <img src="<?php echo $url; ?>views/img/empleado/default/avatar4.png"
                            class="img-thumbnail previsualizarFoto" width="100px">

                    </div>

                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarEditEmpleado">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/empleado.js"></script>