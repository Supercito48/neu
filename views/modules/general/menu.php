<?php

$idPerfil = $_SESSION["idPerfil"];
$permisoalm = ControllerPerfil::ctrMostrarMenuPermisos(1, $idPerfil); // veralmacen
$permisoempl = ControllerPerfil::ctrMostrarMenuPermisos(5, $idPerfil); // verempleado
$permisousu = ControllerPerfil::ctrMostrarMenuPermisos(9, $idPerfil); // verusuarios
$permisoprov = ControllerPerfil::ctrMostrarMenuPermisos(13, $idPerfil); // verprov
$permisocli = ControllerPerfil::ctrMostrarMenuPermisos(62, $idPerfil); // vercli
$permisoserv = ControllerPerfil::ctrMostrarMenuPermisos(17, $idPerfil); // verservicio
$permisoperfil = ControllerPerfil::ctrMostrarMenuPermisos(21, $idPerfil); // verperfil
$permisocat = ControllerPerfil::ctrMostrarMenuPermisos(25, $idPerfil); // vercat
$permisoproc = ControllerPerfil::ctrMostrarMenuPermisos(29, $idPerfil); // verproduc
$permisoinv = ControllerPerfil::ctrMostrarMenuPermisos(33, $idPerfil); // verinv
$permisokardex = ControllerPerfil::ctrMostrarMenuPermisos(39, $idPerfil); // verkardex
$permisocent = ControllerPerfil::ctrMostrarMenuPermisos(40, $idPerfil); // vercent
$permisoncompra = ControllerPerfil::ctrMostrarMenuPermisos(46, $idPerfil); // nuevacompra
$permisovcompra = ControllerPerfil::ctrMostrarMenuPermisos(47, $idPerfil); // vercompra
$permisonventa = ControllerPerfil::ctrMostrarMenuPermisos(49, $idPerfil); // nuevaventa
$permisovventa = ControllerPerfil::ctrMostrarMenuPermisos(50, $idPerfil); // verventa
$permisocomprob = ControllerPerfil::ctrMostrarMenuPermisos(52, $idPerfil); // vercomprob
$permisocaja = ControllerPerfil::ctrMostrarMenuPermisos(56, $idPerfil); // vercaja
$permisoconfig = ControllerPerfil::ctrMostrarMenuPermisos(68, $idPerfil); // verconfiguracion
$permisocotiz = ControllerPerfil::ctrMostrarMenuPermisos(71, $idPerfil); // vercoti
$permisoncotiz = ControllerPerfil::ctrMostrarMenuPermisos(72, $idPerfil); // vercoti

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <img src="<?php echo $url; ?>views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Zanahoria System</span>
    </a>


    <div class="sidebar text-sm">

        <?php

    $item = "idEmpleado";
    $valor = $_SESSION["idEmpleado"];

    $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);



    ?>


        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

            <div class="image">

                <?php
        if ($empleado["foto"] != "") {
          echo '<img src="' . $url . '/' . $empleado["foto"] . '" class="img-circle elevation-2">';
        } else {
          echo '<img src="' . $url . 'views/img/empleado/default/avatar4.png"  class="img-circle elevation-2">';
        }
        ?>

            </div>

            <div class="info">
                <a href="#" class="d-block"><?php echo $empleado["nombres"] ." ". $empleado["apellidos"]; ?> </a>
            </div>

        </div>

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">

                <?php if (isset($_GET["ruta"])) : ?>

                <!--  <li class="nav-header">Administración</li>-->
                <!-- =============================================
          MENU INICIO / COMIENZO
          ============================================= -->

                <?php if ($_GET["ruta"] == "inicio") : ?>

                <li class="nav-item">
                    <a href="<?php echo $url; ?>inicio" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>

                <?php else : ?>

                <li class="nav-item">
                    <a href="<?php echo $url; ?>inicio" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>

                <?php endif ?>

                <?php if ($_GET["ruta"] == "actas") : ?>

                <li class="nav-item">
                    <a href="<?php echo $url; ?>actas" class="nav-link active">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Carga de Actas
                        </p>
                    </a>
                </li>

                <?php else : ?>

                <li class="nav-item">
                    <a href="<?php echo $url; ?>actas" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Carga de Actas
                        </p>
                    </a>
                </li>

                <?php endif ?>

                <!-- =============================================
          MENU INICIO / FINAL
          ============================================= -->

                <!-- =============================================
          MENU ADMINISTRACION / COMIENZO
          MENU ADMINISTRACION / COMIENZO
          MENU ADMINISTRACION / COMIENZO
          MENU ADMINISTRACION / COMIENZO
          ============================================= -->
                <?php if (
            $permisoalm["estado"] == "on" && $permisoalm["existe"] == 1 ||
            $permisoempl["estado"] == "on" && $permisoempl["existe"] == 1 ||
            $permisousu["estado"] == "on" && $permisousu["existe"] == 1 ||
            $permisoprov["estado"] == "on" && $permisoprov["existe"] == 1 ||
            $permisocli["estado"] == "on" && $permisocli["existe"] == 1

          ) : ?>

                <?php if ($_GET["ruta"] == "almacen" or $_GET["ruta"] == "empleados" or $_GET["ruta"] == "usuarios" or $_GET["ruta"] == "proveedores" or $_GET["ruta"] == "clientes"): ?>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Administracion
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <?php else : ?>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>
                                    Administracion
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <?php endif ?>
                                <!-- =============================================
                  MENU ADMINISTRACION / FINAL
                  ============================================= -->

                                <!-- =============================================
                  MENU ALMACEN / COMIENZO
                  ============================================= -->

                                <?php if ($permisoalm["acronimo"] == "veralmacen" && $permisoalm["estado"] == "on" && $permisoalm["existe"] == 1) : ?>
                                <?php if ($_GET["ruta"] == "almacen") : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>almacen" class="nav-link acrt active">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Almacen
                                        </p>
                                    </a>
                                </li>

                                <?php else : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>almacen" class="nav-link acrt">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Almacen
                                        </p>
                                    </a>
                                </li>

                                <?php endif ?>
                                <?php else : ?>

                                <?php endif ?>


                                <!-- =============================================
                  MENU ALMACEN / FINAL
                  ============================================= -->

                                <!-- =============================================
                  MENU EMPLEADOS / COMIENZO
                  ============================================= -->

                                <?php if ($permisoempl["acronimo"] == "verempleado" && $permisoempl["estado"] == "on" && $permisoempl["existe"] == 1) : ?>
                                <?php if ($_GET["ruta"] == "empleados") : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>empleados" class="nav-link active">
                                        <i class=" nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Empleados
                                        </p>
                                    </a>
                                </li>

                                <?php else : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>empleados" class="nav-link">
                                        <i class=" nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Empleados
                                        </p>
                                    </a>
                                </li>

                                <?php endif ?>
                                <?php else : ?>

                                <?php endif ?>


                                <!-- =============================================
                  MENU EMPLEADOS / FINAL
                  ============================================= -->

                                <!-- =============================================
                  MENU USUARIOS / COMIENZO
                  ============================================= -->

                                <?php if ($permisousu["acronimo"] == "verusuarios" && $permisousu["estado"] == "on" && $permisousu["existe"] == 1) : ?>
                                <?php if ($_GET["ruta"] == "usuarios") : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>usuarios" class="nav-link active">
                                        <i class=" nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Usuarios
                                        </p>
                                    </a>
                                </li>

                                <?php else : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>usuarios" class="nav-link">
                                        <i class=" nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Usuarios
                                        </p>
                                    </a>
                                </li>

                                <?php endif ?>
                                <?php else : ?>

                                <?php endif ?>



                                <!-- =============================================
                  MENU USUARIOS / FINAL
                  ============================================= -->


                                <!-- =============================================
                  MENU PROVEEDORES / INICIO
                  ============================================= -->

                                <?php if ($permisoprov["acronimo"] == "verprov" && $permisoprov["estado"] == "on" && $permisoprov["existe"] == 1) : ?>
                                <?php if ($_GET["ruta"] == "proveedores") : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>proveedores" class="nav-link active">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Proveedores
                                        </p>
                                    </a>
                                </li>

                                <?php else : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>proveedores" class="nav-link">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Proveedores
                                        </p>
                                    </a>
                                </li>

                                <?php endif ?>
                                <?php else : ?>

                                <?php endif ?>


                                <?php if ($permisocli["acronimo"] == "vercli" && $permisocli["estado"] == "on" && $permisocli["existe"] == 1) : ?>
                                <?php if ($_GET["ruta"] == "clientes") : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>clientes" class="nav-link active">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Clientes
                                        </p>
                                    </a>
                                </li>

                                <?php else : ?>

                                <li class="nav-item">
                                    <a href="<?php echo $url; ?>clientes" class="nav-link">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Clientes
                                        </p>
                                    </a>
                                </li>

                                <?php endif ?>
                                <?php else : ?>

                                <?php endif ?>



                                <!-- =============================================
                  MENU PROVEEDORES / FINAL
                  ============================================= -->

                            </ul>
                        </li>
                        <?php else : ?>

                        <?php endif ?>

                        <?php if ($permisoperfil["estado"] == "on" && $permisoperfil["existe"] == 1) : ?>
                        <?php if ($_GET["ruta"] == "perfil") : ?> <li class="nav-item">
                            <a href="<?php echo $url; ?>perfil" class="nav-link active">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Perfil
                                </p>
                            </a>
                        </li>
                        <?php else : ?>

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>perfil" class="nav-link">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Perfil
                                </p>
                            </a>
                        </li>

                        <?php endif ?>
                        <?php else : ?>

                        <?php endif ?>

                        <?php if ($permisoconfig["estado"] == "on" && $permisoconfig["existe"] == 1) : ?>
                        <?php if ($_GET["ruta"] == "configuracion") : ?> <li class="nav-item">
                            <a href="<?php echo $url; ?>configuracion" class="nav-link active">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Configuracion
                                </p>
                            </a>
                        </li>
                        <?php else : ?>

                        <li class="nav-item">
                            <a href="<?php echo $url; ?>configuracion" class="nav-link">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Configuracion
                                </p>
                            </a>
                        </li>

                        <?php endif ?>
                        <?php else : ?>

                        <?php endif ?>
                        <!-- =============================================
                  MENU ADMINISTRACION / FINAL - ETIQUETAS
                  MENU ADMINISTRACION / FINAL - ETIQUETAS
                  MENU ADMINISTRACION / FINAL - ETIQUETAS
                  MENU ADMINISTRACION / FINAL - ETIQUETAS
                  MENU ADMINISTRACION / FINAL - ETIQUETAS
                ============================================= -->



                        <?php if (
                        $permisocat["estado"] == "on" && $permisocat["existe"] == 1 ||
                        $permisoproc["estado"] == "on" && $permisoproc["existe"] == 1 ||
                        $permisoinv["estado"] == "on" && $permisoinv["existe"] == 1 ||
                        $permisocent["estado"] == "on" && $permisocent["existe"] == 1 ||
                        $permisoncompra["estado"] == "on" && $permisoncompra["existe"] == 1 ||
                        $permisovcompra["estado"] == "on" && $permisovcompra["existe"] == 1 ||
                        $permisonventa["estado"] == "on" && $permisonventa["existe"] == 1 ||
                        $permisovventa["estado"] == "on" && $permisovventa["existe"] == 1 ||
                        $permisocomprob["estado"] == "on" && $permisocomprob["existe"] == 1
                      ) : ?>
                        <li class="nav-header">Compra y Venta</li>

                        <?php else : ?>

                        <?php endif ?>
                        <?php if (
                        $permisocat["estado"] == "on" && $permisocat["existe"] == 1 ||
                        $permisoproc["estado"] == "on" && $permisoproc["existe"] == 1 ||
                        $permisoinv["estado"] == "on" && $permisoinv["existe"] == 1 ||
                        $permisocent["estado"] == "on" && $permisocent["existe"] == 1
                      ) : ?>

                        <?php if ($_GET["ruta"] == "categoria" or $_GET["ruta"] == "producto" or $_GET["ruta"] == "inventario" or $_GET["ruta"] == "kardex" or $_GET["ruta"] == "deposito") : ?>

                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-box-open"></i>

                                <p>
                                    Productos
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <?php else : ?>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-box-open"></i>

                                        <p>
                                            Productos
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                        <?php endif ?>

                                        <!-- =============================================
                        MENU PRODUCTOS / INICIO
                        ============================================= -->

                                        <!-- =============================================
                        MENU CATEGORIA / INICIO
                        ============================================= -->

                                        <?php if ($permisocat["acronimo"] == "vercat" && $permisocat["estado"] == "on" && $permisocat["existe"] == 1) : ?>
                                        <?php if ($_GET["ruta"] == "categoria") : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>categoria" class="nav-link active">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Categorias
                                                </p>
                                            </a>
                                        </li>

                                        <?php else : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>categoria" class="nav-link">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Categorias
                                                </p>
                                            </a>
                                        </li>

                                        <?php endif ?>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                        MENU CATEGORIAN / FINAL
                        ============================================= -->

                                        <!-- =============================================
                        MENU PRODUCTOS-LISTA / INICIO
                        ============================================= -->
                                        <?php if ($permisoproc["acronimo"] == "verproduc" && $permisoproc["estado"] == "on" && $permisoproc["existe"] == 1) : ?>
                                        <?php if ($_GET["ruta"] == "producto") : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>producto" class="nav-link active">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Producto
                                                </p>
                                            </a>
                                        </li>

                                        <?php else : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>producto" class="nav-link">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Producto
                                                </p>
                                            </a>
                                        </li>

                                        <?php endif ?>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                        MENU PRODUCTOS-LISTA / FINAL
                        ============================================= -->

                                        <!-- =============================================
                        MENU INVENTARIO / INICIO
                        ============================================= -->
                                        <?php if ($permisoinv["acronimo"] == "verinv" && $permisoinv["estado"] == "on" && $permisoinv["existe"] == 1) : ?>
                                        <?php if ($_GET["ruta"] == "inventario") : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>inventario" class="nav-link active">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Inventario
                                                </p>
                                            </a>
                                        </li>

                                        <?php else : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>inventario" class="nav-link">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Inventario
                                                </p>
                                            </a>
                                        </li>

                                        <?php endif ?>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                        MENU INVENTARIO / FINAL
                        ============================================= -->

                                        <!-- =============================================
                        MENU KARDEX / INICIO



                        ============================================= -->
                                        <?php if ($permisokardex["acronimo"] == "verkardex" && $permisokardex["estado"] == "on" && $permisokardex["existe"] == 1) : ?>
                                        <?php if ($_GET["ruta"] == "kardex") : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>kardex" class="nav-link active">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Kardex
                                                </p>
                                            </a>
                                        </li>

                                        <?php else : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>kardex" class="nav-link">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Kardex
                                                </p>
                                            </a>
                                        </li>

                                        <?php endif ?>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                        MENU KARDEX / FINAL
                        ============================================= -->

                                        <!-- =============================================
                        MENU DEPOSITO / INICIO
                        ============================================= -->

                                        <?php if ($permisocent["acronimo"] == "vercent" && $permisocent["estado"] == "on" && $permisocent["existe"] == 1) : ?>
                                        <?php if ($_GET["ruta"] == "deposito") : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>deposito" class="nav-link active">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Almacen Central
                                                </p>
                                            </a>
                                        </li>

                                        <?php else : ?>

                                        <li class="nav-item">
                                            <a href="<?php echo $url; ?>deposito" class="nav-link">
                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                <p>
                                                    Almacen Central
                                                </p>
                                            </a>
                                        </li>

                                        <?php endif ?>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                                    MENU DEPOSITO / FINAL
                                  ============================================= -->


                                    </ul>
                                </li>

                                <?php else : ?>

                                <?php endif ?>
                                <!-- =============================================
                      MENU PRODUCTO / FINAL-ETIQUETA
                       MENU PRODUCTO / FINAL-ETIQUETA
                        MENU PRODUCTO / FINAL-ETIQUETA
                         MENU PRODUCTO / FINAL-ETIQUETA
                          MENU PRODUCTO / FINAL-ETIQUETA
                           MENU PRODUCTO / FINAL-ETIQUETA
                      ============================================= -->

                                <!-- =============================================
                                  MENU compras / INICIO-ETIQUETA
                                  MENU compras / INICIO-ETIQUETA
                                  MENU compras / INICIO-ETIQUETA
                                  MENU compras / INICIO-ETIQUETA
                                  MENU compras / INICIO-ETIQUETA
                            ============================================= -->
                                <?php if (
                              $permisoncompra["estado"] == "on" && $permisoncompra["existe"] == 1 ||
                              $permisovcompra["estado"] == "on" && $permisovcompra["existe"] == 1
                            ) : ?>

                                <?php if ($_GET["ruta"] == "compras" or $_GET["ruta"] == "vercompras") : ?>
                                <li class="nav-item menu-open">
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon fas fa-shipping-fast text-ligth"></i>


                                        <p>
                                            Compras
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <?php else : ?>

                                        <li class="nav-item ">
                                            <a href="#" class="nav-link">
                                                <i class="nav-icon fas fa-shipping-fast text-ligth"></i>
                                                <p>
                                                    Compras
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                <?php endif ?>

                                                <!-- =============================================
                                    MENU venta / FINAL
                                    ============================================= -->

                                                <!-- =============================================
                                    MENU crear compra / INICIO
                                    ============================================= -->

                                                <?php if ($permisoncompra["acronimo"] == "nuevacompra" && $permisoncompra["estado"] == "on" && $permisoncompra["existe"] == 1) : ?>
                                                <?php if ($_GET["ruta"] == "compras") : ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo $url; ?>compras" class="nav-link active">
                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                        <p>
                                                            Nueva Compra
                                                        </p>
                                                    </a>
                                                </li>
                                                <?php else : ?>

                                                <li class="nav-item">
                                                    <a href="<?php echo $url; ?>compras" class="nav-link">
                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                        <p>
                                                            Nueva Compra
                                                        </p>
                                                    </a>
                                                </li>

                                                <?php endif ?>
                                                <?php else : ?>

                                                <?php endif ?>
                                                <!-- =============================================
                                    MENU crear compra / FINAL
                                    ============================================= -->

                                                <!-- =============================================
                                    MENU ver compra / INICIO
                                    ============================================= -->

                                                <?php if ($permisovcompra["acronimo"] == "vercompra" && $permisovcompra["estado"] == "on" && $permisovcompra["existe"] == 1) : ?>
                                                <?php if ($_GET["ruta"] == "vercompras") : ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo $url; ?>vercompras" class="nav-link active">
                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                        <p>
                                                            Ver Compras
                                                        </p>
                                                    </a>
                                                </li>
                                                <?php else : ?>

                                                <li class="nav-item">
                                                    <a href="<?php echo $url; ?>vercompras" class="nav-link">
                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                        <p>
                                                            Ver Compras
                                                        </p>
                                                    </a>
                                                </li>

                                                <?php endif ?>
                                                <?php else : ?>

                                                <?php endif ?>
                                                <!-- =============================================
                                    MENU ver compra / FINAL
                                    ============================================= -->



                                            </ul>
                                        </li>
                                        <?php else : ?>

                                        <?php endif ?>
                                        <!-- =============================================
                                  MENU COMPRAS / FINAL-ETIQUETA
                                  MENU COMPRAS / FINAL-ETIQUETA
                                  MENU COMPRAS / FINAL-ETIQUETA
                                  MENU COMPRAS / FINAL-ETIQUETA
                                  MENU COMPRAS / FINAL-ETIQUETA
                                  ============================================= -->


                                        <!-- =============================================
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  ============================================= -->

                                        <?php if (
                                    $permisonventa["estado"] == "on" && $permisonventa["existe"] == 1 ||
                                    $permisovventa["estado"] == "on" && $permisovventa["existe"] == 1 ||
                                    $permisocomprob["estado"] == "on" && $permisocomprob["existe"] == 1
                                  ) : ?>

                                        <?php if ($_GET["ruta"] == "ventas" or $_GET["ruta"] == "comprobante") : ?>
                                        <li class="nav-item menu-open">
                                            <a href="#" class="nav-link active">
                                                <i class="nav-icon fas fa-shopping-cart text-ligth"></i>

                                                <p>
                                                    Ventas
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                <?php else : ?>

                                                <li class="nav-item ">
                                                    <a href="#" class="nav-link">
                                                        <i class="nav-icon fas fa-shopping-cart text-ligth"></i>
                                                        <p>
                                                            Ventas
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <?php endif ?>

                                                        <!-- =============================================
                                    MENU MANTENIMIENTO / FINAL
                                    ============================================= -->

                                                        <!-- =============================================
                                    MENU crear venta / INICIO
                                    ============================================= -->
                                                        <?php if ($permisonventa["acronimo"] == "nuevaventa" && $permisonventa["estado"] == "on" && $permisonventa["existe"] == 1) : ?>
                                                        <?php if ($_GET["ruta"] == "ventas") : ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>ventas" class="nav-link active">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Nueva Venta
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <?php else : ?>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>ventas" class="nav-link">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Nueva Venta
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <?php endif ?>
                                                        <?php else : ?>

                                                        <?php endif ?>

                                                        <?php if ($permisovventa["acronimo"] == "verventa" && $permisovventa["estado"] == "on" && $permisovventa["existe"] == 1) : ?>
                                                        <?php if ($_GET["ruta"] == "verventas") : ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>verventas"
                                                                class="nav-link active">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Ver ventas
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <?php else : ?>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>verventas" class="nav-link">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Ver ventas
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <?php endif ?>
                                                        <?php else : ?>

                                                        <?php endif ?>
                                                        <!-- =============================================
                                    MENU crear venta / FINAL
                                    ============================================= -->

                                                        <!-- =============================================
                                    MENU comprobante / INICIO
                                    ============================================= -->

                                                        <?php if ($permisocomprob["acronimo"] == "vercomprob" && $permisocomprob["estado"] == "on" && $permisocomprob["existe"] == 1) : ?>
                                                        <?php if ($_GET["ruta"] == "comprobante") : ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>comprobante"
                                                                class="nav-link active">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Conf. Comprobante
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <?php else : ?>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>comprobante" class="nav-link">
                                                                <i class="nav-icon far fa-circle nav-icon"></i>
                                                                <p>
                                                                    Conf. Comprobante
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <?php endif ?>
                                                        <?php else : ?>

                                                        <?php endif ?>
                                                        <!-- =============================================
                                    MENU comprobante / FINAL
                                    ============================================= -->



                                                    </ul>
                                                </li>
                                                <?php else : ?>

                                                <?php endif ?>


                                                <!-- =============================================
                                  MENU VENTAS / FINAL-ETIQUETA
                                   MENU VENTAS / FINAL-ETIQUETA
                                    MENU VENTAS / FINAL-ETIQUETA
                                     MENU VENTAS / FINAL-ETIQUETA
                                      MENU VENTAS / FINAL-ETIQUETA
                                  ============================================= -->


                                                <!-- =============================================
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  MENU VENTAS / INICIO-ETIQUETA
                                  ============================================= -->

                                                <?php if (
                                    $permisocotiz["estado"] == "on" && $permisocotiz["existe"] == 1 ||
                                    $permisoncotiz["estado"] == "on" && $permisoncotiz["existe"] == 1 
                                  ) : ?>

                                                <?php if ($_GET["ruta"] == "cotizacion" or $_GET["ruta"] == "vercotizacion") : ?>
                                                <li class="nav-item menu-open">
                                                    <a href="#" class="nav-link active">
                                                        <i class="nav-icon fas fa-book text-ligth"></i>

                                                        <p>
                                                            Cotizacion
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        <?php else : ?>

                                                        <li class="nav-item ">
                                                            <a href="#" class="nav-link">
                                                                <i class="nav-icon fas fa-book text-ligth"></i>
                                                                <p>
                                                                    Cotizacion
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">
                                                                <?php endif ?>

                                                                <!-- =============================================
                                    MENU MANTENIMIENTO / FINAL
                                    ============================================= -->

                                                                <!-- =============================================
                                    MENU crear venta / INICIO
                                    ============================================= -->
                                                                <?php if ($permisoncotiz["acronimo"] == "nuevacoti" && $permisoncotiz["estado"] == "on" && $permisoncotiz["existe"] == 1) : ?>
                                                                <?php if ($_GET["ruta"] == "cotizacion") : ?>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>cotizacion"
                                                                        class="nav-link active">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Nueva Cotizacion
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <?php else : ?>

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>cotizacion"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Nueva Cotizacion
                                                                        </p>
                                                                    </a>
                                                                </li>

                                                                <?php endif ?>
                                                                <?php else : ?>

                                                                <?php endif ?>

                                                                <?php if ($permisocotiz["acronimo"] == "vercoti" && $permisocotiz["estado"] == "on" && $permisocotiz["existe"] == 1) : ?>
                                                                <?php if ($_GET["ruta"] == "vercotizacion") : ?>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>vercotizacion"
                                                                        class="nav-link active">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Ver Cotizacion
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <?php else : ?>

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>vercotizacion"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Ver Cotizacion
                                                                        </p>
                                                                    </a>
                                                                </li>

                                                                <?php endif ?>
                                                                <?php else : ?>

                                                                <?php endif ?>
                                                                <!-- =============================================
                                    MENU crear venta / FINAL
                                    ============================================= -->


                                                            </ul>
                                                        </li>
                                                        <?php else : ?>

                                                        <?php endif ?>


                                                        <!-- =============================================
                                  MENU VENTAS / FINAL-ETIQUETA
                                   MENU VENTAS / FINAL-ETIQUETA
                                    MENU VENTAS / FINAL-ETIQUETA
                                     MENU VENTAS / FINAL-ETIQUETA
                                      MENU VENTAS / FINAL-ETIQUETA
                                  ============================================= -->
                                                        <!-- =============================================
                                  MENU CAJA / INICIO
                                  ============================================= -->
                                                        <?php if ($permisocaja["acronimo"] == "vercaja" && $permisocaja["estado"] == "on" && $permisocaja["existe"] == 1) : ?>
                                                        <?php if ($_GET["ruta"] == "caja") : ?>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>caja" class="nav-link active">
                                                                <i class="nav-icon fas fa-cash-register"></i>
                                                                <p>
                                                                    Caja
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <?php else : ?>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>caja" class="nav-link">
                                                                <i class="nav-icon fas fa-cash-register"></i>
                                                                <p>
                                                                    Caja
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <?php endif ?>
                                                        <?php else : ?>

                                                        <?php endif ?>



                                                        <?php else : ?>

                                                        <li class="nav-header">Administración</li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>inicio" class="nav-link">
                                                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                                                <p>
                                                                    Inicio
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>actas" class="nav-link">
                                                                <i class="nav-icon fas fa-file-signature"></i>
                                                                <p>
                                                                    Carga de Actas
                                                                </p>
                                                            </a>
                                                        </li>


                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link">
                                                                <i class="nav-icon fas fa-folder"></i>
                                                                <p>
                                                                    Administracion
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>almacen"
                                                                        class="nav-link acrt">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Almacen
                                                                        </p>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>empleados"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Empleados
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>usuarios"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Usuarios
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>proveedores"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Proveedores
                                                                        </p>
                                                                    </a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>clientes"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Clientes
                                                                        </p>
                                                                    </a>
                                                                </li>


                                                            </ul>
                                                        </li>



                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>perfil" class="nav-link">
                                                                <i class="nav-icon fas fa-address-card"></i>
                                                                <p>
                                                                    Perfil
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>configuracion" class="nav-link">
                                                                <i class="nav-icon fas fa-tools"></i>
                                                                <p>
                                                                    Configuracion
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-header">Compra y Venta</li>

                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link">
                                                                <i class="nav-icon fas fa-box-open"></i>

                                                                <p>
                                                                    Productos
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>categoria"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Categorias
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>producto"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Producto
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>inventario"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Inventario
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>kardex"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Kardex
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>deposito"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Almacen Central
                                                                        </p>
                                                                    </a>
                                                                </li>


                                                            </ul>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link">

                                                                <i class="nav-icon fas fa-shipping-fast"></i>
                                                                <p>
                                                                    Compras
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>compras"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Nueva Compra
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>vercompras"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>

                                                                        <p>
                                                                            Ver Compras
                                                                        </p>
                                                                    </a>
                                                                </li>



                                                            </ul>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link">

                                                                <i class="nav-icon fas fa-shopping-cart text-ligth"></i>
                                                                <p>
                                                                    Ventas
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>ventas"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Nueva Venta
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>verventas"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Ver ventas
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>comprobante"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>

                                                                        <p>
                                                                            Conf. Comprobante
                                                                        </p>
                                                                    </a>
                                                                </li>



                                                            </ul>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="#" class="nav-link">

                                                                <i class="nav-icon fas fa-book text-ligth"></i>
                                                                <p>
                                                                    Cotizacion
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <ul class="nav nav-treeview">

                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>cotizacion"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                                                        <p>
                                                                            Nueva Cotizacion
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="<?php echo $url; ?>vercotizacion"
                                                                        class="nav-link">
                                                                        <i class="nav-icon far fa-circle nav-icon"></i>

                                                                        <p>
                                                                            Ver Cotizaciones
                                                                        </p>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="<?php echo $url; ?>caja" class="nav-link">
                                                                <i class="nav-icon fas fa-cash-register"></i>
                                                                <p>
                                                                    Caja
                                                                </p>
                                                            </a>
                                                        </li>


                                                        <?php endif ?>
                                                    </ul>

        </nav>

    </div>



</aside>