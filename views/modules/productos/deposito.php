<?php

$url = Ruta::ctrRuta();

$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(40, $idPerfil);

?>
<?php if ($permisos["acronimo"] == "vercent" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Deposito</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="contenido">Inicio</a></li>
                        <li class="breadcrumb-item active">Deposito</li>
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

       
                            <div class="card-header">
                            
                                <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#modalInventario">
                                    AGREGAR
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <table class="table table-bordered table-hover dt-responsive tablaDeposito" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Codigo</th>
                                            <th>Producto</th>
                                            <th>Stock</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                </table>


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
<div class="modal fade" id="modalInventario" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">



            <div class="modal-body">


                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

                <div class="box-body">
                    <div class="table-responsive">
                    <input type="hidden" name="idUsuario" class="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <table class="table table-bordered table-hover dt-responsive  tablaDepositoProducto" cellspacing="0" width="100%">

                            <thead>
                                <tr>
                                   
                                    <th>Nombre</th>
                                    <th>Código</th>                      
                                    <th>Stock</th>
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

<div class="modal fade" id="modalAumentoDeposito" role="dialog">
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
                        <input type="hidden" class="idDeposito">
                        <input type="hidden" class="idProductos">
                        <input type="hidden" name="idUsuario" class="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <span class="h2">Stock Actual</span>
                    </label>

                    <input type="number" id="stockactual" name="stockactual" class="form-control stockactual" readonly>

                </div>


                <div class="form-group mb-2">

                    <label for="NuevoStock">
                        <span class="h2">Sumar</span>
                    </label>
                    <input type="number" id="nuevostock" name="nuevostock" class="form-control nuevostock" onchange="sumar()" onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

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

<div class="modal fade" id="modalAjustarDeposito" role="dialog">
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
                        <input type="hidden" class="idDeposito">
                        <input type="hidden" class="idProductos" >
        
                        <input type="hidden" name="idUsuario" class="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                        <span class="h2">Stock Actual</span>
                    </label>

                    <input type="number" name="stockactual" class="form-control stockactual">


                </div>

                <div class="form-group mb-2">

                    <label for="Stock">
                        <span class="h2">Nuevo stock</span>
                    </label>
                    <input type="number" id="stock" name="stockNuevo" class="form-control stockNuevo" onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

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
                <h4 class="modal-title">Enviar stock </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <!--=============================================
              =            CUERPO DEL MODAL        =
              =============================================-->

               

                  

                <input type="hidden" class="idDeposito">
                <input type="hidden" class="idProductos">
                <input type="hidden" class="stockactual">
                <input type="hidden" class="form-control stockE">
                <input type="hidden" name="idUsuario" class="idUsuario" value="<?php echo $_SESSION["idUsuario"]; ?>">
                       
             
                <div class="form-group mb-2">

                    <label for="NuevoStock">
                        <span class="h2">Enviar</span>
                    </label>
                    <input type="number" id="nuevostockE" name="nuevostockE" class="form-control nuevostockE" Required onchange="enviarStock()" onkeypress="return soloNumeros(event)" min="0" max="9999" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

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

                       
                        <?php if ($value["idAlmacen"] != 29) : ?>

        
                            <option class="form-control" value="<?php echo $value["idAlmacen"]; ?>"><?php echo $value["descripcion"]; ?></option>

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


<script src="<?php echo $url ?>views/js/deposito.js"></script>