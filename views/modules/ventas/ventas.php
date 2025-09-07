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
                    <h1>Ventas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Ventas</li>
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
                    <?php if ($_SESSION["idPerfil"] == 0) : ?>
                    <?php if (isset($exp[1])) : ?>

                    <?php

                                $item = "idAlmacen";
                                $valor = $exp[1];

                                $AlmacenP = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                                ?>


                    <h2>Sucursal: <?php echo $AlmacenP["descripcion"]; ?></h2>

                    <button type="button" class="btn btn-inline btn-danger" onClick="history.back();">
                        REGRESAR
                    </button>
                    <center>
                        <h2><strong> Registrar Venta</strong> </h2>
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

                            <h3><strong>Total Venta: <?php echo $configuracion[0]["simbolom"];?> <span
                                        id="totalVenta">0.00</span></strong></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success" id="btnEntradaDinero" data-toggle='modal'
                                data-target='#mdlGestionarCajaV'>
                                <i class="fas fa-coins"></i> Entrada
                            </button>
                            <button class="btn btn-warning" id="btnSalidadaDinero" data-toggle='modal'
                                data-target='#mdlGestionarCajaV'>
                                <i class="fas fa-door-open"></i>Salida
                            </button>
                            <button class="btn btn-primary" id="btnIniciarVenta">
                                <i class="fas fa-shopping-cart"></i> Realizar Venta
                            </button>
                            <button class="btn btn-danger" id="btnVaciarListado">
                                <i class="far fa-trash-alt"></i> Vaciar Listado
                            </button>
                            <input type="hidden" id="idAlmacenV" value="<?php echo $exp[1]; ?>">
                            <input type="hidden" id="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                            <input type="hidden" id="idCaja">

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

                        <h5 class="card-header text-start bg-primary text-white text-center">Total Venta:
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <select class="form-control form-control-sm select2"
                                            aria-label=".form-control-sm example" style="width:100%!important;"
                                            id="selCliente">
                                        </select>
                                        <input id="selcredito_usado" type="hidden">
                                        <span id="validate_categoria" class="text-danger small fst-italic"
                                            style="display:none">Debe
                                            Seleccione documento</span>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group mb-2">
                                <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-file-alt fs-6"></i>
                                    <span class="small">Documento</span><span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" aria-label=".form-control-sm example"
                                    id="selDocumentoVenta">

                                </select>
                                <span id="validate_categoria" class="text-danger small fst-italic"
                                    style="display:none">Debe
                                    Seleccione documento</span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="col-form-label" for="selCategoriaReg"><i
                                        class="fas fa-money-bill-alt fs-6"></i>
                                    <span class="small">Tipo Pago</span><span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" aria-label=".form-control-sm example"
                                    id="selTipoPago">
                                    <option value="" selected="true">Seleccione Tipo Pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Yape">Yape</option>
                                    <option value="Plin">Plin</option>
                                    <option value="Mixto">Mixto</option>
                                    <option class="creditoCli" value="Credito">Credito</option>

                                </select>
                                <span id="validate_categoria" class="text-danger small fst-italic"
                                    style="display:none">Debe
                                    Ingresar tipo de pago</span>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="iptNroSerie">Serie</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroSerie"
                                            class="form-control form-control-sm" placeholder="nro Serie" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="iptNroVenta">Nro Venta</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroVenta"
                                            class="form-control form-control-sm" placeholder="Nro Venta" disabled>
                                    </div>
                                </div>


                            </div>

                            <div class="cajasMetodoPago">
                                <!--<div class="form-group">
                                <label for="iptEfectivoRecibido">Efectivo recibido</label>
                                <input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido" class="form-control form-control-sm" placeholder="Cantidad de efectivo recibida">
                            </div>
                            
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="chkEfectivoExacto">
                                    <label class="form-check-label" for="chkEfectivoExacto">
                                        Efectivo Exacto
                                    </label>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-12">
                                        <h5 class="text-start"><strong>Monto Efectivo: <?php echo $configuracion[0]["simbolom"];?> <span id="EfectivoEntregado">0.00</span></strong></h5>
                                    </div>
                                   comenta aqui <div class="col-12">
                                    <h5 class="text-start text-primary">Total Venta: <?php echo $configuracion[0]["simbolom"];?> <span
                                            id="totalVentaRegistrar">0.00</span>
                                    </h5>
                                </div> aqui acaba comen tado
                                    <div class="col-12">
                                        <h5 class="text-start text-danger"><strong>Vuelto: <?php echo $configuracion[0]["simbolom"];?> <span id="Vuelto">0.00</span></strong></h5>
                                    </div>

                                    comenta aqui<div class="col-12 text-start mt-2">
                                    <button class="btn btn-danger" id="btnIniciarVenta">Realizar Venta</button>
                                </div> aqui acaba el comentado
                                </div>-->
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chkDeliveryExacto">
                                <label class="form-check-label" for="chkDeliveryExacto">
                                    Delivery
                                </label>
                            </div>

                            <div class="row mt-2 ">
                                <div class="col-12 deliveryaparece">

                                    <input id="iptDelivery" type="hidden" value="0">
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
                                    <span>IGV (<?php echo (int)$configuracion[0]["impuesto"];?>%)</span>
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




                    <?php else : ?>



                    <?php

                                $item = null;
                                $valor = null;

                                $Almacen = ControllerAlmacen::ctrMostrarAlmacen($item, $valor);

                        ?>
                    <div class="card">
                        <div class="card-header">
                            <h3>Seleccione Sucursal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($Almacen as $key => $value) : ?>

                                <?php if ($value["idAlmacen"] == 998) : ?>




                                <?php else : ?>

                                <div class="col-lg-3 col-6">
                                    <!-- small card -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?php echo $value["descripcion"]; ?></h3>

                                            <p><?php echo $value["ubicacion"]; ?></p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </div>
                                        <a href="ventas/<?php echo $value["idAlmacen"]; ?>" class="small-box-footer">
                                            Ir a Ventas <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    </div>
                                </div>

                                <?php endif ?>


                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <!-- modificar hasta aqui sobre super administrador-->
                    <?php else : ?>




                    <center>
                        <h2><strong> Registrar Venta</strong> </h2>
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

                            <h3><strong>Total Venta: <?php echo $configuracion[0]["simbolom"];?> <span
                                        id="totalVenta">0.00</span></strong></h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-success" id="btnEntradaDinero" data-toggle='modal'
                                data-target='#mdlGestionarCajaV'>
                                <i class="fas fa-coins"></i> Entrada
                            </button>
                            <button class="btn btn-warning" id="btnSalidadaDinero" data-toggle='modal'
                                data-target='#mdlGestionarCajaV'>
                                <i class="fas fa-door-open"></i>Salida
                            </button>
                            <button class="btn btn-primary" id="btnIniciarVenta">
                                <i class="fas fa-shopping-cart"></i> Realizar Venta
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

                        <h5 class="card-header text-start bg-primary text-white text-center">Total Venta:
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
                                <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-file-alt fs-6"></i>
                                    <span class="small">Documento</span><span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" aria-label=".form-control-sm example"
                                    id="selDocumentoVenta">


                                </select>
                                <span id="validate_categoria" class="text-danger small fst-italic"
                                    style="display:none">Debe
                                    Seleccione documento</span>
                            </div>

                            <div class="form-group mb-2">
                                <label class="col-form-label" for="selCategoriaReg"><i
                                        class="fas fa-money-bill-alt fs-6"></i>
                                    <span class="small">Tipo Pago</span><span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm" aria-label=".form-control-sm example"
                                    id="selTipoPago">
                                    <option value="">Seleccione Tipo Pago</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Yape">Yape</option>
                                    <option value="Plin">Plin</option>
                                    <option value="Mixto">Mixto</option>
                                    <option class="creditoCli" value="Credito">Credito</option>

                                </select>
                                <span id="validate_categoria" class="text-danger small fst-italic"
                                    style="display:none">Debe
                                    Ingresar tipo de pago</span>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="iptNroSerie">Serie</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroSerie"
                                            class="form-control form-control-sm" placeholder="nro Serie" disabled>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="iptNroVenta">Nro Venta</label>
                                        <input type="text" min="0" name="iptEfectivo" id="iptNroVenta"
                                            class="form-control form-control-sm" placeholder="Nro Venta" disabled>
                                    </div>
                                </div>


                            </div>

                            <div class="cajasMetodoPago">

                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="chkDeliveryExacto">
                                <label class="form-check-label" for="chkDeliveryExacto">
                                    Delivery
                                </label>
                            </div>

                            <div class="row mt-2 ">
                                <div class="col-12 deliveryaparece">

                                    <input id="iptDelivery" type="hidden" value="0">
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


                    <?php endif ?>




                </div>

            </div>

        </div>

    </section>

</div>

<?php else : ?>
<?php require_once "views/modules/404.php"; ?>
<?php endif ?>

<div class="modal fade" id="modalProductoVenta" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-success">


            <div class="modal-header">
                <h4 class="modal-title">Precio Oferta DNI</h4>
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
                            <dt class="col-sm-12">DNI</dt>
                            <div class="input-group mb-3">

                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                </div>
                                <input type="hidden" id="idProducto" name="idProducto">
                                <input type="hidden" id="codigoBarras" name="codigoBarras">
                                <input type="hidden" id="preciocambio" name="preciocambio">

                                <input type="number" id="dniConejo" name="dniConejo" class="form-control"
                                    placeholder="Escriba su DNI porfavor">

                            </div>

                        </div>

                    </div>



                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-light btnEditarPrecioOferta">Guardar</button>
            </div>


        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="mdlGestionarCajaV" tabindex="-1" aria-labelledby="mdlGestionarCaja" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-success py-2">
                <h6 class="modal-title" id="titulo_modal_caja">Gestionar Caja</h6>
                <button data-dismiss="modal" aria-label="close" class="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <input type="hidden" id="tipo">

                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Importe:</span>
                            </label>
                            <input type="number" min="0" step="0.1" class="form-control form-control-sm" id="monto"
                                placeholder="Ingrese el importe">
                        </div>
                    </div>

                    <div class="col-12" id="col_descripcion">
                        <div class="form-group mb-2">
                            <label class="" for="iptStockSumar">
                                <i class="fas fa-plus-circle fs-6"></i> <span class="small"
                                    id="titulo_modal_label">Descripción:</span>
                            </label>
                            <input type="text" class="form-control form-control-sm" id="descripcion"
                                placeholder="Ingrese la descripcion">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger float-right m-1 "><i
                        class="fas fa-times ml-1 "><b>&nbsp;Cerrar</b></i></button>
                <button class="btn bg-gradient-primary float-right m-1 btnGuardarCaja"><i
                        class="fas fa-check"><b>&nbsp;Guardar Caja</b></i></button>

            </div>

        </div>
    </div>
</div>

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

<script src="<?php echo $url ?>views/js/ventas.js"></script>