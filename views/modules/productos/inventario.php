<?php
$url = Ruta::ctrRuta();

$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(33, $idPerfil);
$permisosagr = ControllerPerfil::ctrMostrarMenuPermisos(34, $idPerfil);
$permisossum = ControllerPerfil::ctrMostrarMenuPermisos(35, $idPerfil);
$permisosajus = ControllerPerfil::ctrMostrarMenuPermisos(36, $idPerfil);
$permisostras = ControllerPerfil::ctrMostrarMenuPermisos(37, $idPerfil);
$permisoselim = ControllerPerfil::ctrMostrarMenuPermisos(38, $idPerfil);
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
?>

<?php if ($permisos["acronimo"] == "verinv" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Perfiles</li>
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

                        <?php
                            $exp = explode("/", $_GET["ruta"]);


                            ?>
                        <?php if ($_SESSION["idPerfil"] == 0) : ?>
                        <?php if (isset($exp[1])) : ?>

                        <?php

                                    $item = "idAlmacen";
                                    $valor = $exp[1];

                                    $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                    ?>
                        <div class="card-header">
                            <div class="row">
                                <?php if ($permisosagr["acronimo"] == "agrinv" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                            data-target="#modalInventario">
                                            AGREGAR
                                        </button>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <?php else : ?>

                                <?php endif ?>

                                <div class="col-md-2">

                                    <button type="button" class="btn btn-inline btn-danger" onClick="history.back();">
                                        REGRESAR
                                    </button>


                                </div>
                                <div class="col-md-4">

                                    <h3><strong>Costo de Inventario: <?php echo $configuracion[0]["simbolom"];?> <span
                                                id="CostoInv">
                                                0.00</span></strong></h3>
                                    <!-- /.input group -->

                                </div>
                                <div class="col-md-4">

                                    <h3><strong>Cantidad de productos: <span id="CantInv">
                                                0.00</span></strong></h3>
                                    <!-- /.input group -->

                                </div>
                            </div>



                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-hover dt-responsive tablaInventario"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Categoria</th>
                                        <th>Stock</th>
                                        <th>Stock minimo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>


                            </table>


                        </div>
                        <?php else : ?>

                        <?php

                                    $item = null;
                                    $valor = null;

                                    $Almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                    ?>
                        <div class="card-header">
                            <h3>Seleccione Sucursal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($Almacen as $key => $value) : ?>


                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h4><strong><?php echo $value["descripcion"]; ?></strong></h4>

                                            <p><?php echo $value["ubicacion"]; ?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <a href="inventario/<?php echo $value["idAlmacen"]; ?>"
                                            class="small-box-footer">
                                            Ir a inventario <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <?php endforeach ?>
                            </div>
                        </div>
                        <?php endif ?>

                        <?php else : ?>
                        <?php

                                $item = "idAlmacen";

                                $valor = $_SESSION["idAlmacen"];

                                $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                ?>
                        <div class="card-header">
                            <h2>Sucursal: <?php echo $AlmacenP["descripcion"]; ?></h2><br>
                            <div class="row">
                                <?php if ($permisosagr["acronimo"] == "agrinv" && $permisosagr["estado"] == "on" && $permisosagr["existe"] == 1) : ?>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal"
                                            data-target="#modalInventario">
                                            AGREGAR
                                        </button>
                                        <!-- /.input group -->
                                    </div>
                                </div>

                                <?php else : ?>

                                <?php endif ?>

                                <div class="col-md-5">

                                    <h3><strong>Costo de Inventario: <?php echo $configuracion[0]["simbolom"];?> <span
                                                id="CostoInv">
                                                0.00</span></strong></h3>
                                    <!-- /.input group -->

                                </div>
                                <div class="col-md-5">

                                    <h3><strong>Cantidad de productos: <span id="CantInv">
                                                0.00</span></strong></h3>
                                    <!-- /.input group -->

                                </div>
                            </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-bordered table-hover dt-responsive tablaInventario"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Categoria</th>
                                        <th>Stock</th>
                                        <th>Stock minimo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>



                                <tbody>




                                </tbody>






                            </table>


                        </div>


                        <?php endif ?>


                    </div>

                </div>

            </div>

        </div>

    </section>

</div>
<?php else : ?>
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>

<div class="modal fade" id="modalInventario" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">



            <div class="modal-body">


                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                <div class="box-body">
                    <div class="table-responsive">
                        <?php
                        if ($_SESSION["idPerfil"] == 0) {

                            $idAlmacen = $exp[1];
                        } else {

                            $idAlmacen = $_SESSION["idAlmacen"];
                        }
                        ?>
                        <input type="hidden" name="idAlmacenGuardar" class="idAlmacenGuardar"
                            value="<?php echo $idAlmacen; ?>">
                        <table class="table table-bordered table-hover dt-responsive  tablaInventariotoProducto"
                            cellspacing="0" width="100%">

                            <thead>
                                <tr>

                                    <th>Nombre</th>
                                    <th>Código</th>

                                    <th>Stock</th>
                                    <th>Stock minimo</th>
                                    <th>Agregar</th>

                                </tr>
                            </thead>

                            <tbody>

                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>


        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAumentoInventario" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title">Aumento de stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                <div class="form-group mb-2">

                    <label for="AntiguoStock">
                        <input type="hidden" class="idInventario">
                        <input type="hidden" class="idProductos">
                        <input type="hidden" class="idAlmacen">
                        <input type="hidden" name="idUsuario" class="idUsuario"
                            value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <span class="h2">Stock Actual</span>
                    </label>

                    <input type="number" id="stockactual" name="stockactual" class="form-control stockactual" readonly>

                </div>


                <div class="form-group mb-2">

                    <label for="NuevoStock">
                        <span class="h2">Sumar</span>
                    </label>
                    <input type="number" id="nuevostock" name="nuevostock" class="form-control nuevostock"
                        onchange="sumar()" onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4"
                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                </div>

                <div class="form-group mb-2">

                    <label for="Stock">
                        <span class="h2">Nuevo stock</span>
                    </label>
                    <input type="number" id="stock" name="stock" class="form-control stock" readonly>

                </div>


            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarAumentoStock">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalAjustarInventario" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title">Ajustar de stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                <div class="form-group mb-2  ">

                    <label for="AntiguoStock">
                        <input type="hidden" class="idInventario">
                        <input type="hidden" class="idProductos">
                        <input type="hidden" class="idAlmacen">
                        <input type="hidden" name="idUsuario" class="idUsuario"
                            value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <span class="h2">Stock Actual</span>
                    </label>

                    <input type="number" name="stockactual" class="form-control stockactual">


                </div>

                <div class="form-group mb-2">

                    <label for="Stock">
                        <span class="h2">Nuevo stock</span>
                    </label>
                    <input type="number" id="stock" name="stockNuevo" class="form-control stockNuevo"
                        onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4"
                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                </div>




            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarAjusteStock">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalTraslado" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title">Ajustar de stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                <div class="form-group mb-2">

                    <label for="AntiguoStock">
                        <input type="hidden" class="idInventario">
                        <input type="hidden" class="idProductos">

                        <input type="hidden" class="stockactual">
                        <input type="hidden" class="form-control stockE">
                        <input type="hidden" name="idUsuario" class="idUsuario"
                            value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <span class="h2">Almacen Saliente</span>
                    </label>


                    <select class="form-control" id="idAlmacen" name="idAlmacen" readonly>
                        <!-- <select class="form-control select2" > -->
                        <option class="idAlmacen" value="">Seleccionar Almacen</option>

                    </select>
                    <input type="hidden" class="pruebaAlmacen">
                </div>


                <div class="form-group mb-2">

                    <label for="NuevoStock">
                        <span class="h2">Enviar</span>
                    </label>
                    <input type="number" id="nuevostockE" name="nuevostockE" class="form-control nuevostockE" Required
                        onchange="enviarStock()" onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4"
                        oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

                </div>

                <div class="form-group mb-2">

                    <label for="Stock">
                        <span class="h2">Almacen Entrante</span>
                    </label>


                </div>

                <?php

                $item = null;
                $valor = null;

                $almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);



                ?>


                <select class="form-control" id="Destino" name="Destino">


                    <option value="">Seleccionar Destino</option>
                    <?php foreach ($almacen as $key => $value) : ?>

                    <?php

                        $item = "idAlmacen";
                        $valor = $value["idAlmacen"];

                        $inventario = ControllerInventario::ctrMostrarInventario($item, $valor);

                        ?>

                    <?php if ($value["idAlmacen"] != $idAlmacen) : ?>



                    <!--<option class="form-control idAlmacenDestino"  stockDespues="<?php echo $inventario["stock"]; ?>" value="<?php echo $value["idAlmacen"]; ?>"><?php echo $value["descripcion"]; ?></option>-->
                    <option class="form-control" value="<?php echo $value["idAlmacen"]; ?>">
                        <?php echo $value["descripcion"]; ?></option>



                    <?php else : ?>



                    <?php endif ?>



                    <?php endforeach ?>

                    <input type="hidden" class="idAlmacenDestino">
                    <input type="hidden" class="descAlmacenDestino">

                </select>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light guardarTraslado">Guardar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog  VALIDAR QUE SOLO SALGAN LAS SUCURSALES QUE TIENEN EL MISMO PRODUCTO -->
</div>

<script src="<?php echo $url ?>views/js/inventario.js"></script>