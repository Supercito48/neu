<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(46, $idPerfil);
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
?>
<?php if ($permisos["acronimo"] == "nuevacompra" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Compras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Compras</li>
                        <input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">

                        <input type="hidden" id="simbolom" value="<?php echo $configuracion[0]["simbolom"]; ?> ">
                        <input type="hidden" id="igvn" value="<?php echo $configuracion[0]["impuesto"]; ?> ">
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
                        <div class="card-body">

                            <div class="content">
                                <div class="container-fluid">

                                    <div class="row mb-3">

                                        <div class="col-md-9">
                                            <center>
                                                <h2><strong> Registrar Compra</strong> </h2>
                                            </center>
                                            <div class="row">

                                                <div class="col-md-12 mb-3">

                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label" for="iptCodigoCompra"><i
                                                                class="fas fa-barcode fs-6"></i> <span
                                                                class="small">Productos</span></label>

                                                        <input type="text" class="form-control form-control-sm"
                                                            id="iptCodigoCompra"
                                                            placeholder="Ingrese el código de barras o el nombre del producto">
                                                    </div>
                                                    <input type="hidden" id="idUsuario"
                                                        value="<?php echo $_SESSION["idUsuario"]; ?>">

                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h3><strong>Total Compra:
                                                            <?php echo $configuracion[0]["simbolom"];?> <span
                                                                id="totalCompra">0.00</span></strong></h3>
                                                </div>
                                                <div class="col-md-6 text-right">

                                                    <button class="btn btn-primary" id="btnIniciarCompra">
                                                        <i class="fas fa-shopping-cart"></i> Realizar Compra
                                                    </button>
                                                    <button class="btn btn-danger" id="btnVaciarListado">
                                                        <i class="far fa-trash-alt"></i> Vaciar Listado
                                                    </button>
                                                </div>
                                                <hr>

                                                <div class="col-md-12">

                                                    <div class="table-responsive">
                                                        <table id="lstProductosCompra" class="table table-bordered"
                                                            cellspacing="0" width="100%">

                                                            <thead class="bg-info text-left fs-6">
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th>Codigo</th>
                                                                    <th>Producto</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Precio compra</th>
                                                                    <th>Total</th>
                                                                    <th>idProducto</th>
                                                                    <th>stock</th>
                                                                    <th class="text-center">Opciones</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <!-- / table -->
                                                </div>
                                                <!-- /.col -->


                                            </div>


                                        </div>

                                        <div class="col-md-3 px-2">
                                            <div class="card shadow">

                                                <h5 class="card-header text-start bg-primary text-white text-center">
                                                    Total Compra: <?php echo $configuracion[0]["simbolom"];?> <span
                                                        id="totalCompraRegistrar">0.00</span>
                                                </h5>

                                                <div class="card-body">
                                                    <div class="form-group mb-2">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <label class="col-form-label" for="selCategoriaReg"><i
                                                                        class="fas fa-truck fs-6"></i>
                                                                    <span class="small">Proovedor</span><span
                                                                        class="text-danger">*</span></label>
                                                            </div>


                                                            <div class="col-md-4">
                                                                <button type="button" class="btn  btn-success btn-sm"
                                                                    data-toggle="modal" data-target="#modalProveedor">
                                                                    <i class="fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <select class="form-control form-control-sm"
                                                            aria-label=".form-control-sm example" id="selProveedor">

                                                        </select>
                                                        <span id="validate_categoria"
                                                            class="text-danger small fst-italic"
                                                            style="display:none">Debe
                                                            Seleccione documento</span>
                                                    </div>
                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label" for="selCategoriaReg"><i
                                                                class="fas fa-file-alt fs-6"></i>
                                                            <span class="small">Documento</span><span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm"
                                                            aria-label=".form-select-sm example"
                                                            id="selDocumentoCompra">
                                                            <option value="">Seleccione Documento</option>
                                                            <option value="Boleta">Boleta</option>
                                                            <option value="Factura">Factura</option>
                                                            <option value="Ticket">Ticket</option>
                                                        </select>
                                                        <span id="validate_categoriaCompra"
                                                            class="text-danger small fst-italic"
                                                            style="display:none">Debe
                                                            Seleccione documento</span>
                                                    </div>



                                                    <div class="form-group mb-2">
                                                        <label class="col-form-label" for="selCategoriaReg"><i
                                                                class="fas fa-money-bill-alt fs-6"></i>
                                                            <span class="small">Tipo Pago</span><span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control form-control-sm"
                                                            aria-label=".form-control-sm example" id="selTipoPago">
                                                            <option value="" selected="true">Seleccione Tipo Pago
                                                            </option>
                                                            <option value="Efectivo">Efectivo</option>
                                                            <option value="Tarjeta">Tarjeta</option>
                                                            <option value="Deposito">Deposito</option>
                                                            <option value="Yape">Yape</option>

                                                        </select>
                                                        <span id="validate_categoria"
                                                            class="text-danger small fst-italic"
                                                            style="display:none">Debe
                                                            Ingresar tipo de pago</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label for="iptNroSerie">Serie</label>
                                                                <input type="text" min="0" name="iptEfectivo"
                                                                    id="iptNroSerie"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="nro Serie">
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label for="iptNroVenta">Nro Venta</label>
                                                                <input type="text" min="0" name="iptEfectivo"
                                                                    id="iptNroVenta"
                                                                    class="form-control form-control-sm"
                                                                    placeholder="Nro Venta">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="cajasMetodoPago">

                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <span>SUBTOTAL</span>
                                                        </div>
                                                        <div class="col-md-5 text-right">
                                                            <?php echo $configuracion[0]["simbolom"];?> <span class=""
                                                                id="boleta_subtotal">0.00</span>
                                                        </div>

                                                        <div class="col-md-7">
                                                            <span>IGV
                                                                (<?php echo (int)$configuracion[0]["impuesto"];?>%)</span>
                                                        </div>
                                                        <div class="col-md-5 text-right">
                                                            <?php echo $configuracion[0]["simbolom"];?> <span class=""
                                                                id="boleta_igv">0.00</span>
                                                        </div>

                                                        <div class="col-md-7">
                                                            <span>TOTAL</span>
                                                        </div>
                                                        <div class="col-md-5 text-right">
                                                            <?php echo $configuracion[0]["simbolom"];?> <span class=""
                                                                id="boleta_total">0.00</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.col -->



                                    </div>
                                </div>


                            </div>





    </section>

</div>

<?php else : ?>
<?php   require_once "views/modules/404.php";?>
<?php endif ?>
<div class="modal fade" id="modalProductoCompra" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-success">


            <div class="modal-header">
                <h4 class="modal-title">Precio Compra</h4>
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
                            <dt class="col-sm-12">Codigo de Barras</dt>
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="hidden" id="idProducto" name="idProducto">

                                <input type="text" id="codigoBarras" name="codigoBarras" class="form-control"
                                    placeholder="Codigo barras" readonly>

                            </div>
                            <dt class="col-sm-12">Descripción producto</dt>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-product-hunt"></i></span>
                                </div>
                                <input type="text" id="descProducto" name="descProducto" class="form-control"
                                    placeholder="Descripcion" readonly>
                            </div>
                            <dt class="col-sm-12">Precio de Compra</dt>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                                </div>

                                <input type="number" id="precioCompra" name="precioCompra" class="form-control" min="0"
                                    step="any" placeholder="precio de compra">
                            </div>




                        </div>

                    </div>



                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light btnEditPrecio">Guardar</button>
            </div>


        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalCantidadCompra" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-success">


            <div class="modal-header">
                <h4 class="modal-title">Cantidad Compra</h4>
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
                            <dt class="col-sm-12">Codigo de Barras</dt>
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="hidden" id="idProductoc" name="idProductoc">

                                <input type="text" id="codigoBarrasc" name="codigoBarras" class="form-control"
                                    placeholder="Codigo barras" readonly>

                            </div>
                            <dt class="col-sm-12">Descripción producto</dt>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-product-hunt"></i></span>
                                </div>
                                <input type="text" id="descProductoc" name="descProducto" class="form-control"
                                    placeholder="Descripcion" readonly>
                            </div>
                            <dt class="col-sm-12">Cantidad Compra</dt>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-copyright"></i></span>
                                </div>

                                <input type="number" id="cantidaCompra" name="cantidaCompra" class="form-control"
                                    min="0" step="any" placeholder="cantidad de compra">
                            </div>




                        </div>

                    </div>



                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light btnEditCantidad2">Guardar</button>
            </div>


        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modalProveedor">
    <div class="modal-dialog">
        <div class="modal-content bg-success">

            <form id="formularioProveedor" role="form" method="post">

                <div class="modal-header">
                    <h4 class="modal-title">Agregar Proovedor</h4>
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
                    <button type="button" class="btn btn-outline-light guardarProveedor">Guardar</button>
                    <!-- onclick="validarCorreo(event)" -->
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/compras.js"></script>
<!-- SELECT inventario.*, producto.descProducto FROM producto  
inner JOIN inventario ON producto.idProducto = inventario.idProducto
WHERE inventario.idAlmacen = 1 and inventario.idProducto = 3
-->