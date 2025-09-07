<?php

$url = Ruta::ctrRuta();
$idPerfil = $_SESSION["idPerfil"];

$permisoproc = ControllerPerfil::ctrMostrarMenuPermisos(29, $idPerfil); // verproduc
$permisoinv = ControllerPerfil::ctrMostrarMenuPermisos(33, $idPerfil); // verinv
$permisoncompra = ControllerPerfil::ctrMostrarMenuPermisos(46, $idPerfil); // nuevacompra
$permisonventa = ControllerPerfil::ctrMostrarMenuPermisos(49, $idPerfil); // nuevaventa
$permisocaja = ControllerPerfil::ctrMostrarMenuPermisos(56, $idPerfil); // vercaja
$permisocita = ControllerPerfil::ctrMostrarMenuPermisos(62, $idPerfil); // vercita

?>
<nav class="main-header navbar navbar-expand navbar-dark">

    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        <?php if ($permisoproc["acronimo"] == "verproduc" && $permisoproc["estado"] == "on" && $permisoproc["existe"] == 1) : ?>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="producto" class="nav-link">Productos</a>
        </li>

        <?php else : ?>

        <?php endif ?>

        <?php if ($permisoinv["acronimo"] == "verinv" && $permisoinv["estado"] == "on" && $permisoinv["existe"] == 1) : ?>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="inventario" class="nav-link">Inventario</a>
        </li>

        <?php else : ?>

        <?php endif ?>

        <?php if ($permisoncompra["acronimo"] == "nuevacompra" && $permisoncompra["estado"] == "on" && $permisoncompra["existe"] == 1) : ?>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="compras" class="nav-link">Compras</a>
        </li>

        <?php else : ?>

        <?php endif ?>

        <?php if ($permisonventa["acronimo"] == "nuevaventa" && $permisonventa["estado"] == "on" && $permisonventa["existe"] == 1) : ?>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="ventas" class="nav-link">Crear Ventas</a>
        </li>
        <?php else : ?>

        <?php endif ?>

        <?php if ($permisocaja["acronimo"] == "vercaja" && $permisocaja["estado"] == "on" && $permisocaja["existe"] == 1) : ?>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="caja" class="nav-link">Caja</a>
        </li>

        <?php else : ?>

        <?php endif ?>
    </ul>


    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url ?>inicio" role="button">
                <i class="fas fa-home"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-exclamation-circle"></i>
                <span id="contado_noti" class="badge badge-danger navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <span class="dropdown-item dropdown-header">Productos Bajo en inventario</span>

                <div class="dropdown-divider"></div>
                <a href="<?php echo $url ?>productobajo" class="dropdown-item">
                    <i class="fas fa-boxes mr-2"></i> <span id="contado_noti2"></span> Productos bajo en inventario

                </a>

            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Notificaciones</span>


                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-truck mr-2"></i>Productos recibidos (1)

                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-paper-plane mr-2"></i>Productos enviados (1)

                </a>

            </div>
        </li>

        <li class="nav-item dropdown">

            <?php

            $item = "idEmpleado";
            $valor = $_SESSION["idEmpleado"];

            $empleado = ControllerEmpleado::ctrMostrarEmpleado($item, $valor);

            $itemA = "idAlmacen";
            $valorA = $_SESSION["idAlmacen"];

            $almacen = ControllerAlmacen::ctrMostrarAlmacen($itemA, $valorA);

            $itemB = "idPerfiles";
            $valorB = $_SESSION["idPerfil"];

            $perfil = ControllerPerfil::ctrMostrarPerfil($itemB, $valorB);

            ?>

            <?php if ($_SESSION["idPerfil"] == 0) : ?>

            <input type="hidden" id="idAlmacenBajo" value="">

            <?php else : ?>

            <input type="hidden" id="idAlmacenBajo" value="<?php  echo $_SESSION["idAlmacen"]?>">

            <?php endif ;?>

            <a class="nav-link" data-toggle="dropdown" href="#">
                <span class="hidden-xs"><?php echo $_SESSION["login"]?></span>

            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i>&nbsp;
                    <?php echo ucwords($empleado["nombres"]) . ' ' . ucwords($empleado["apellidos"]); ?>
                </a>
                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-store-alt mr-2"></i> <?php echo ucwords($almacen["descripcion"]); ?>
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-address-card mr-2"></i> <?php echo $perfil["descripcion"]; ?>
                </a>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item">
                    <i class="fas fa-map-marker-alt mr-2"></i> &nbsp;
                    <?php echo ucwords($empleado["direccion"]); ?>
                </a>

                <div class="dropdown-divider"></div>


                <a href="<?php echo $url; ?>/salir" class="bdropdown-item dropdown-footer">Salir</a>
                <a href="<?php echo $url; ?>/informacion" class="bdropdown-item dropdown-footer">Informacion</a>

            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" role="button">

            </a>
        </li>



    </ul>

</nav>