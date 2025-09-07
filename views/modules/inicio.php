<div class="content-wrapper" style="min-height: 855px;">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>

                    </ol>
                </div><br><br>
                <?php if ($_SESSION["idPerfil"] == 0) : ?>




                <div class="col-12">
                    <div class="col-md-3 px-2">

                        <div class="form-group mb-2">
                            <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-store-alt mr-2"></i>
                                <span class="small">Seleccionar Sucursales</span><span
                                    class="text-danger">*</span></label>
                            <select type="text" class="form-control select2" id="idAlmacenSelect"
                                name="idAlmacenSelect"></select>




                        </div>


                    </div>
                </div>


                <?php else : ?>


                <input type="hidden" id="idAlmacenSelect" value="<?php  echo $_SESSION["idAlmacen"]?>">


                <?php endif ;?>

                <!-- <div class="col-sm-6">
            
          <select class="form-control select2" aria-label=".form-control-sm example" id="selTipoPago">
                                    <option value="" selected="true">Seleccione Sucursal</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    
                                </select>
          </div>-->



            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">


                <div class="col-lg-3 col-6">

                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="totalProductos">2</h3>

                            <p>Productos</p>
                        </div>

                        <div class="icon">
                            <i class="fab fa-product-hunt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!--<div class="col-lg-3 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="totalConejos">4</h3>

                            <p>Total Conejos</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-paw"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>-->

                <!-- <div class="col-lg-3 col-6">

                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3 id="totalEmpleado">2</h3>

                            <p>Empleados</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>-->

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3 id="totalAlmacen">2</h3>

                            <p>Sucursales</p>
                        </div>

                        <div class="icon">
                            <i class="fas fa-store-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="totalVentasMesAD">S./ 2,500.00</h3>

                            <p>Total Ventas del Mes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="totalVentasDiaAD">S./ 2,500.00</h3>

                            <p>Total Ventas del Día</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <!--<?php if ($_SESSION["idPerfil"] == 0) : ?>



            <div class="row">
                <div class="col-12">
                    <div class="col-md-3 px-2">

                        <div class="form-group mb-2">
                            <label class="col-form-label" for="selCategoriaReg"><i class="fas fa-store-alt mr-2"></i>
                                <span class="small">Seleccionar Sucursales</span><span
                                    class="text-danger">*</span></label>
                            <select type="text" class="form-control select2" id="idAlmacenSelect"
                                name="idAlmacenSelect"></select>




                        </div>


                    </div>
                </div>
            </div><br>

            <?php else : ?>


            <input type="hidden" id="idAlmacenSelect" value="<?php  echo $_SESSION["idAlmacen"]?>">


            <?php endif ;?>
             AQUI PONER UN FILTRO PARA BUSCAR POR SUCURSALES 19/06/2022 -->




            <!--<div class="row">

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="totalVentasMesAD">S./ 2,500.00</h3>

                            <p>Total Ventas del Mes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">

                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="totalVentasDiaAD">S./ 2,500.00</h3>

                            <p>Total Ventas del Día</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <a href="#" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>



            </div>-->


            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Los 10 productos mas vendidos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbl_productos_mas_vendidos">
                                    <thead>
                                        <tr class="text-danger">
                                            <th>Cod. producto</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Ventas</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Listado de productos con poco stock</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbl_productos_poco_stock">
                                    <thead>
                                        <tr class="text-danger">
                                            <th>#</th>
                                            <th>Cod. producto</th>
                                            <th>Producto</th>

                                            <th>Precio Venta</th>
                                            <th>Stock Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>

</div>