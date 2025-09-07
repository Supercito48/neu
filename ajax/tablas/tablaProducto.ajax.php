<?php
error_reporting(0); // Ocultar warnings/notices en la salida JSON
ini_set('display_errors', 0);
session_start();

// vamos a requerir el controlador y el modelo
require_once "../../controllers/producto.controller.php";
require_once "../../models/producto.model.php";

require_once "../../controllers/categoria.controller.php";
require_once "../../models/categoria.model.php";

require_once "../../controllers/inventario.controller.php";
require_once "../../models/inventario.model.php";

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

require_once "../../controllers/configuracion.controller.php";
require_once "../../models/configuracion.model.php";

class TablaProducto
{

	/*=============================================
	Tabla Producto
	=============================================*/
	public function mostrarTabla()
	{
		$idPerfil = $_SESSION["idPerfil"];
		
		// obtenemos todos los productos
		$Producto = ControllerProducto::ctrMostrarProducto(null, null, null);

		// permisos
		$permisosedit = ControllerPerfil::ctrMostrarMenuPermisos(31, $idPerfil); 
		$permisoseli = ControllerPerfil::ctrMostrarMenuPermisos(32, $idPerfil); 

		// Si no hay productos
		if (!$Producto || count($Producto) == 0) {
			echo json_encode([]);
			return;
		}

		$configuracion = ControllerConfiguracion::ctrMostrarConfiguracion();
		$simbolo = $configuracion[0]["simbolom"];

		$datos = [];

		foreach ($Producto as $key => $value) {

			// traemos categoría (validamos si existe)
			$categorias = ControllerCategorias::ctrMostrarCategorias("idCategoria", $value["idCategoria"]);
			$desCat = $categorias && isset($categorias["desCat"]) ? $categorias["desCat"] : "";

			// inventario
			$itemInventario = "idProducto";
			$valorInventario = $value["idProducto"];
			$inventario = ControllerInventario::ctrMostrarInventario($itemInventario, $valorInventario);

			// acciones según permisos
			if (
				$permisosedit["acronimo"] == "editproduc" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1 &&
				$permisoseli["acronimo"] == "elimproduc" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1
			) {
				$acciones = "<div class='btn-group'>
								<button class='btn btn-warning editarProducto' data-toggle='modal' data-target='#modalProducto' idProducto='".$value["idProducto"]."'><i class='fa fa-edit'></i></button>
								<button class='btn btn-danger eliminarProducto' idProducto='".$value["idProducto"]."' idInventarioExis='".($inventario ? $inventario["idProducto"] : 0)."'><i class='fa fa-times'></i></button>
							</div>";
			
			} else if ($permisosedit["acronimo"] == "editproduc" && $permisosedit["estado"] == "on" && $permisosedit["existe"] == 1) {
				$acciones = "<div class='btn-group'>
								<button class='btn btn-warning editarProducto' data-toggle='modal' data-target='#modalProducto' idProducto='".$value["idProducto"]."'><i class='fa fa-edit'></i></button>
								<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>
							</div>";
			
			} else if ($permisoseli["acronimo"] == "elimproduc" && $permisoseli["estado"] == "on" && $permisoseli["existe"] == 1) {
				$acciones = "<div class='btn-group'>
								<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>
								<button class='btn btn-danger eliminarProducto' idProducto='".$value["idProducto"]."' idInventarioExis='".($inventario ? $inventario["idProducto"] : 0)."'><i class='fa fa-times'></i></button>
							</div>";
			
			} else {
				$acciones = "<div class='btn-group'>
								<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>
								<button class='btn btn-secondary'><i class='fas fa-ban'></i></button>
							</div>";
			}

			$datos[] = [
				"idProducto"     => $key + 1,
				"descProducto"   => $value["descProducto"],
				"codigoBarras"   => $value["codigoBarras"],
				"desCat"         => $desCat,
				"precioCompra"   => $simbolo . " " . number_format($value["precioCompra"], 2, ',', '.'),
				"precioVenta"    => $simbolo . " " . number_format($value["precioVenta"], 2, ',', '.'),
				"precioVentaMA"  => $simbolo . " " . number_format($value["precioVentaMA"], 2, ',', '.'),
				"oferta"         => $simbolo . " " . number_format($value["oferta"], 2, ',', '.'),
				"acciones"       => $acciones
			];
		}

		// Devolver JSON válido
		echo json_encode($datos);
	}
}

/*=============================================
Ejecutar
=============================================*/
$tabla = new TablaProducto();
$tabla->mostrarTabla();