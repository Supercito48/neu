<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(49, $idPerfil);
$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
date_default_timezone_set("America/Lima");
?>

<style>
.transparentbar {
    background-repeat: no-repeat;
    cursor: pointer;
    outline: none;
    border: none;
    box-shadow: none;
    background-image: none;

    background-color: transparent;
    /* background: transparent;
  border-color: transparent; */

}

.transparentbar:focus {
    color: #fff;
    background-color: transparent !important;
    border-color: transparent !important;
    box-shadow: none !important;
}

.transparentbar:hover {
    color: #fff;
    background-color: transparent !important;
    border-color: transparent !important;
}
</style>

<?php if ($permisos["acronimo"] == "nuevaventa" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cotizacion</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Cotizacion</li>
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
            <div class="row mb-3">

                <div class="col-md-9">
                    <?php
                        $exp = explode("/", $_GET["ruta"]);


                        ?>




                    <center>
                        <h2><strong> Registrar Cotizacion</strong> </h2>
                    </center>
                    <div class="row">

                        <div class="col-md-12 mb-3">

                            <div class="form-group mb-2">
                                <label class="col-form-label" for="iptCodigoVenta"><i class="fas fa-barcode fs-6"></i>
                                    <span class="small">Productos</span></label>

                                <input type="text" class="form-control form-control-sm" id="iptCodigoVenta"
                                    placeholder="Ingrese el código de barras o el nombre del producto">
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <h3><strong>Total Cotizacion: <?php echo $configuracion[0]["simbolom"];?> <span
                                        id="totalVenta">0.00</span></strong></h3>
                        </div>
                        <div class="col-md-6 text-right">

                            <button class="btn btn-primary" id="btnIniciarVenta">
                                <i class="fas fa-shopping-cart"></i> Realizar Cotizacion
                            </button>
                            <button class="btn btn-danger" id="btnVaciarListado">
                                <i class="far fa-trash-alt"></i> Vaciar Listado
                            </button>
                            <input type="hidden" id="idAlmacenV" value="<?php echo $_SESSION["idAlmacen"]; ?>">
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">

                                <table id="lstProductosVenta" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead class="bg-info text-left fs-6">
                                        <tr>
                                            <th>Item</th>
                                            <th>Codigo</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Total</th>
                                            <th class="text-center">Opciones</th>
                                            <th>idProducto</th>
                                            <th>stock</th>
                                            <th>precioVentaMA</th>
                                            <th>oferta</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-left fs-6">
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

                        <h5 class="card-header text-start bg-primary text-white text-center">Total Cotizacion:
                            <?php echo $configuracion[0]["simbolom"];?> <span id="totalVentaRegistrar">0.00</span>
                        </h5>
                        <?php
                            $item = "idEmpleado";
                            $valor = $_SESSION["idEmpleado"];
                            $Empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);
                            ?>


                        <div class="card-body">
                            <div class="form-group mb-2">
                                <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-user-tie fs-6"></i>
                                    <span class="small">Vendedor</span><span class="text-danger">*</span></label>
                                <input type="text" name="iptVendedor" id="iptVendedor"
                                    class="form-control form-control-sm"
                                    value="<?php echo ucwords($Empleado["nombres"]) . ' ' . ucwords($Empleado["apellidos"]); ?>"
                                    disabled>
                            </div>

                            <div class="form-group mb-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="col-form-label" for="selCliente"><i
                                                class="fas fa-user-secret fs-6"></i>
                                            <span class="small">Cliente</span><span class="text-danger">*</span></label>
                                    </div>


                                    <div class="col-md-4">
                                        <button type="button" class="btn  btn-success btn-sm" data-toggle="modal"
                                            data-target="#modalClientes">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <select class="form-control form-control-sm " aria-label=".form-control-sm example"
                                    id="selCliente">
                                </select>
                                <input id="selcredito_usado" type="hidden">
                                <span id="validate_categoria" class="text-danger small fst-italic"
                                    style="display:none">Debe
                                    Seleccione documento</span>
                            </div>



                            <div class="form-group mb-2">
                                <label class="col-form-label" for="selCategoriaReg"><i
                                        class="fas fa-money-bill-alt fs-6"></i>
                                    <span class="small">Documento</span><span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" aria-label=".form-control-sm example"
                                    id="selDocumentoCotizacion">
                                    <option value="Cotizacion">Cotizacion</option>


                                </select>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="iptNroSerie">Serie</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroSerie"
                                            class="form-control form-control-sm" placeholder="nro Serie" readonly>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="iptNroVenta">Nro Venta</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroVenta"
                                            class="form-control form-control-sm" placeholder="Nro Venta" readonly>
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-7">
                                    <span>SUBTOTAL</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    <?php echo $configuracion[0]["simbolom"];?> <span class=""
                                        id="boleta_subtotal">0.00</span>

                                    <input type="hidden" id="subtotal" value="">
                                </div>

                                <div class="col-md-7">
                                    <span>IGV (18%)</span>
                                </div>
                                <div class="col-md-5 text-right">
                                    <?php echo $configuracion[0]["simbolom"];?> <span class=""
                                        id="boleta_igv">0.00</span>
                                </div>

                                <div class="col-md-7 cajacomision1">
                                    <!-- <span>COMISIÓN</span> -->
                                </div>
                                <div class="col-md-5 text-right cajacomision2">
                                    <!-- <?php echo $configuracion[0]["simbolom"];?> <span class="" id="comision_bol">0.00</span>-->
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

            </div>

        </div>

    </section>

</div>

<?php else : ?>
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>


<div class="modal fade" id="modalCantidadVenta" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content bg-success">


            <div class="modal-header">
                <h4 class="modal-title">Cantidad Venta</h4>
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

                                <input type="number" id="cantidaVenta" name="cantidaVenta" class="form-control" min="0"
                                    step="any" placeholder="cantidad de venta">
                            </div>

                        </div>

                    </div>



                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light btnEditCantidadVnta">Guardar</button>
            </div>


        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalClientes" tabindex="-1" role="dialog" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <form id="formularioUsuarios" role="form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Clientes</h4>
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

                                    <input type="hidden" class="idCliente" name="idCliente">

                                    <input type="number" class="form-control dni" name="dni" placeholder="DNI">

                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control nombres" name="nombres"
                                        placeholder="Nombres">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>

                                    <input type="text" class="form-control direccion" name="direccion"
                                        placeholder="Dirección">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>

                                    <input type="number" class="form-control telefono" name="telefono"
                                        placeholder="Telefono">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                    </div>

                                    <input type="number" class="form-control limite_credito" name="limite_credito"
                                        placeholder="Credito">
                                </div>


                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline-light guardarCli">Guardar</button>

                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="<?php echo $url ?>views/js/cotizacion.js"></script>