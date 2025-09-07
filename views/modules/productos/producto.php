<?php
$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(29, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "verproduc" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Producto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Producto</li>
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
                            <?php $permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(30, $idPerfil); ?>

                            <?php if ($permisosagr["acronimo"] == "agrproduc" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>
                            <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                data-target="#modalProducto">
                                AGREGAR
                            </button>
                            <?php else : ?>

                            <?php endif ?>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover dt-responsive tablaProducto">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Descripcion</th>
                                        <th>Codigo Barras</th>
                                        <th>Categoria</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Mayoreo</th>
                                        <th>Oferta</th>
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


<div class="modal fade" id="modalProducto" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">

            <form id="formularioProducto" role="form" method="post">
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
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="hidden" id="idProducto" name="idProducto">
                                    <input type="text" id="descProducto" name="descProducto" class="form-control"
                                        placeholder="Descripcion">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>

                                    <select class="form-control" id="idCategoria" name="idCategoria">
                                        <!-- <select class="form-control select2" > -->
                                        <option value="">Seleccionar Categoria</option>
                                        <?php

                    $item = null;
                    $valor = null;

                    $categoria = ControllerCategorias::ctrMostrarCategorias($item, $valor);

                    foreach ($categoria as $key => $value) {

                      if ($value["estadoCat"] == 1) {

                        echo '<option value="' . $value["idCategoria"] . '">' . $value["desCat"] . '</option>';
                      } else {
                      }
                    }

                    ?>

                                    </select>


                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="number" id="codigoBarras" name="codigoBarras" class="form-control"
                                        placeholder="Codigo barras">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>

                                    <input type="number" id="precioCompra" name="precioCompra" class="form-control"
                                        min="0" step="any" placeholder="precio de compra">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="number" id="precioVenta" name="precioVenta" class="form-control"
                                        placeholder="precio de venta">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="number" id="precioVentaMA" name="precioVentaMA" class="form-control"
                                        placeholder="precio venta mayorista Aqp">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-th"></i></span>
                                    </div>
                                    <input type="number" id="oferta" name="oferta" class="form-control"
                                        placeholder="Oferta">
                                </div>



                            </div>

                        </div>



                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarProducto">Guardar</button>
                </div>

            </form>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script src="<?php echo $url ?>views/js/producto.js"></script>