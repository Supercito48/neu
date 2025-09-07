<?php

$url = Ruta::ctrRuta();
date_default_timezone_set("America/Lima");
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(21, $idPerfil);
?>
<?php if ($permisos["acronimo"] == "verperfil" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfiles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
              <li class="breadcrumb-item active">Perfiles</li>
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
                <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(22, $idPerfil); ?>

                <?php if ($permisosagr["acronimo"] == "agrperfil" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                  <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#myModal">
                    AGREGAR
                  </button>
                <?php else : ?>

                <?php endif ?>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover dt-responsive tablaPerfil">
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>idPerfiles</th>
                      <th>Descripcion</th>
                      <th>Permisos</th>

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
  <?php require_once "views/modules/404.php"; ?>
<?php endif ?>



<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Agregar Perfil</h4>
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
                  <span class="input-group-text"><i class="fas fa-th"></i></span>
                </div>
                <input type="hidden" id="idPerfiles">
                <input type="text" class="form-control descripcion" placeholder="Descripción">

              </div>

            </div>

          </div>

        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light guardarPerfiles">Guardar</button>
        <button type="button" class="btn btn-outline-light editarPerfiles">Editar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<div class="modal fade animate__animated animate__slideInDown" id="modal_permisos" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="card card-success">
        <div class="card-header">
          <h4 class="modal-title w-100 text-center" id="titleModal"><i class="fas fa-file-signature"></i>&nbsp;<b>PERMISOS AL PERFIL</b></h>
            <button data-dismiss="modal" aria-label="close" class="close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-12 col-md-12">
              <div style="text-align: center;" class="form-group">
                <h3><strong>Nombre del Perfil : <span id="fechaS"></span></strong></h3>
                <input type="hidden" id="idPerfiles">

                <div class="input-group mb-2">

                  <div class="valid-input invalid-feedback"></div>
                </div>
              </div>
            </div>

            <div class="col-md-12">

              <table class="tablaMenu table table-bordered">
                <thead>
                  <tr>
                    <th>Menu</th>
                    <th>Grupo</th>
                    <th class="text-center">Atender</th>



                  </tr>
                </thead>
                <tbody>


                </tbody>
              </table>
            </div>
          </div>

        </div>
        <div class="card-footer">


          <button type="button" class="btn btn-primary float-right m-1 btnGuardar"><i class="fas fa-check ml-1"><b>&nbsp;Guardar</b></i></button>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo $url ?>views/js/perfil.js"></script>