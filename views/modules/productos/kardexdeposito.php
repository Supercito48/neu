<?php

$url = Ruta::ctrRuta();
$idMenu = 1;
$idPerfil = $_SESSION["idPerfil"];
$permisos = ControllerPerfil::ctrMostrarMenuPermisos(39, $idPerfil);
date_default_timezone_set("America/Lima");
?>
<?php if ($permisos["acronimo"] == "verkardex" && $permisos["estado"] == "on" && $permisos["existe"] == 1) : ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kardex Deposito</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo $url; ?>inicio">Inicio</a></li>
                        <li class="breadcrumb-item active">Kardex</li>
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

                                <div class="card-body">
                                <button type="button" class="btn btn-inline btn-danger" onClick="history.back();">
                                        REGRESAR
                                    </button><br><br>
                                    <div class="row">
                                            <div class="col-12 col-md-4" role="document">
                                                <div class="form-group">
                                                    <label for="txtfechainicio">Fecha Desde:</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="date" class="form-control" id="kardex_desde" name="txtfechainicio" required>
                                                        <div class="valid-input invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4" role="document">
                                                <div class="form-group">
                                                    <label for="txtfechafin">Fecha Hasta:</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="fas fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                        <input type="date" class="form-control" id="kardex_hasta" name="txtfechafin" required>
                                                        <div class="valid-input invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-12 col-md-2" role="document">
                                                <label for="">&nbsp;</label><br>

                                                <button class="btn btn-danger mr-2" style="width:100%" id="btnQFiltro"><i class="fas fa-trash mr-1"></i>Quitar</button>

                                            </div>
                                            <div class="col-12 col-md-2" role="document">
                                                <label for="">&nbsp;</label><br>


                                                <button class="btn btn-primary mr-2" style="width:100%" id="btnFiltrar"><i class="fas fa-search mr-1"></i>Buscar</button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-md-4" role="document">
                                                <div class="form-group">
                                                    <label for="txtfechafin">Producto:</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">

                                                                <i class="fab fa-product-hunt"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" id="iptProducto" class="form-control" data-index="1">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-4" role="document">
                                                <div class="form-group">
                                                    <label for="txtalmacen">Tipo:</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">

                                                                <i class="fas fa-layer-group"></i>
                                                            </div>
                                                        </div>
                                                        <select type="text" class="form-control" id="iptTipo" name="iptTipo" data-index="3">
                                                            <option value="">Selecionar tipo</option>

                                                            <option value="Entrada">Entrada</option>

                                                            <option value="Eliminado">Eliminado</option>
                                                            <option value="Ajuste">Ajuste</option>
                                                            <option value="Salida">Salida</option>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4" role="document">
                                                <div class="form-group">
                                                    <label for="txtfechafin">Responsable:</label>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">

                                                                <i class="fas fa-users"></i>
                                                            </div>
                                                        </div>
                                                        <input type="text" id="iptResponsable" class="form-control" data-index="7">

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    <table class="table table-bordered table-hover dt-responsive tablaKardexDeposito" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <!-- cambiar aqui-->
                                                <th>Fecha</th>
                                                <th>Producto</th>
                                                <th>Motivo</th>
                                            
                                                <th>Tipo</th>
                                             
                                                <th>Saldo Inicial</th>
                                                <th>Cantidad</th>
                                                <th>Saldo</th>
                                                <th>Responsable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
  
                                           
                                        </tbody>
                                    </table>


                                </div>
                            
                           



                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<?php else : ?>
  <?php   require_once "views/modules/404.php";?>
<?php endif ?>
<script src="<?php echo $url ?>views/js/kardex.js"></script>