<?php 

require_once "controllers/plantilla.controlador.php";
require_once "controllers/usuarios.controller.php";
require_once "controllers/almacen.controller.php";
require_once "controllers/clientes.controller.php";
require_once "controllers/categoria.controller.php";
require_once "controllers/perfil.controller.php";
require_once "controllers/proveedores.controller.php";
require_once "controllers/empleado.controller.php";
require_once "controllers/producto.controller.php";
require_once "controllers/inventario.controller.php";
require_once "controllers/kardex.controller.php";
require_once "controllers/compras.controller.php";
require_once "controllers/comprobante.controller.php";
require_once "controllers/ventas.controller.php";
require_once "controllers/deposito.controller.php";
require_once "controllers/caja.controller.php";
require_once "controllers/dashboard.controller.php";
require_once "controllers/configuracion.controller.php";

require_once "models/usuarios.model.php";
require_once "models/almacen.model.php";
require_once "models/clientes.model.php";
require_once "models/categoria.model.php";
require_once "models/perfil.model.php";
require_once "models/proveedores.model.php";
require_once "models/empleado.model.php";
require_once "models/producto.model.php";
require_once "models/inventario.model.php";
require_once "models/kardex.model.php";
require_once "models/compras.model.php";
require_once "models/comprobante.model.php";
require_once "models/ventas.model.php";
require_once "models/deposito.model.php";
require_once "models/caja.model.php";
require_once "models/dashboard.model.php";
require_once "models/configuracion.model.php";


require_once "models/rutas.php";


$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();