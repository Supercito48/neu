<div class="content-wrapper">

<section class="content">
      <div class="container-fluid">
        <div class="row">

        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
              <?php
            
            $item = "idEmpleado";
            $valor = $_SESSION["idEmpleado"];

            $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);

            $itemA = "idAlmacen";
            $valorA = $_SESSION["idAlmacen"];

            $almacen = ControllerAlmacen::ctrMostrarAlmacen($itemA, $valorA);

         //   $itemB = "idPerfil";
           // $valorB = $_SESSION["idPerfil"];

          
          // $perfil = ControllerPerfil::ctrMostrarPerfil($itemB, $valorB);

            $itemusuario= "idEmpleado" ;
            $valorusuario = $empleado["idEmpleado"];
    
            $usuarios = ControllerUsuarios::ctrMostrarUsuario($itemusuario,$valorusuario);

            ?>
            <div class="card-body box-profile">
                <div class="text-center">

                    <?php
                        if ($empleado["foto"] != "") {
                        echo '<img src="' . $url . '/' . $empleado["foto"] . '" class="profile-user-img img-fluid img-circle"';
                        } else {
                        echo '<img src="' . $url . 'views/img/empleado/default/avatar4.png"  class="profile-user-img img-fluid img-circle">';
                        }
                    ?>

                </div>

                </div>


        <h3 class="profile-username text-center"><?php echo ucwords($empleado["nombres"]) . ' ' . ucwords($empleado["apellidos"]); ?></h3>

        <p class="text-muted text-center">&nbsp; <?php echo $perfil["descripcion"]; ?></p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Celular</b> <a class="float-right"><?php echo $empleado["telefono"]; ?></a>
            </li>
            <li class="list-group-item">
                <b>Direccion</b> <a class="float-right"><?php echo $empleado["direccion"]; ?></a>
            </li>
            <li class="list-group-item">
                <b>Dni</b> <a class="float-right"><?php echo $empleado["dni"]; ?></a>
            </li>
            <li class="list-group-item">
                <b>Correo</b> <a class="float-right"><?php echo $empleado["correo"]; ?></a>
            </li>
            <li class="list-group-item">
                <b>Fecha de Nacimiento</b> <a class="float-right"><?php echo $empleado["fecNacimiento"]; ?></a>
            </li>
        </ul>

            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->


          <div class="col-md-9" id="modalUsuarios" >
            <div class="card">

            <form id="formularioUsuarios" role="form" method="post">
              <div class="card-header p-2">
               <h4>Datos Usuarios</h4>

              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                          
                    <input type="hidden" id="idUsuario" name=idUsuario>
                    <input type="hidden" id="idEmpleado" name=idEmpleado>
                    <input type="hidden" id="idAlmacen" nameidAlmacen>
                    <input type="hidden" id="idPerfil" name=idPerfil>
                    <input type="hidden" id="ultimo_login" name=ultimo_login>
                    <input type="hidden" id="fecha_creacion" name=fecha_creacion>
                   
                        <label>Usuario</label>
                        <input type="text" class="form-control" id="login" name="login" placeholder=<?php echo ucwords($usuarios["login"]); ?>>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Contraseña</label>
                        <input type="text" class="form-control" id="passlogin" name="passlogin" placeholder=<?php echo ucwords($usuarios["passlogin"]); ?> >
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Sucursal</label>
                        <input type="text" class="form-control" placeholder=<?php echo ucwords($almacen["descripcion"]); ?>  disabled>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                      <button type="button" class="btn btn-primary btn-block guardarUsuario">Guardar</button>
                      </div>
                    </div>
                  </div>
                  </div>
                
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>

                    </form>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      </div>

    </section>
    <!-- /.content -->
</div>
         