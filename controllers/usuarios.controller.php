<?php
class ControllerUsuarios
{
	static public function ctrIngresoUsuario()
	{
		$DateAndTime = date('H:i:s', time());
		if (isset($_POST["ingUsuario"])) {

			$tabla = "usuario";
			$item = "login";
			$valor = $_POST["ingUsuario"];

			$respuesta = ModelUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
			$encriptar = crypt($_POST["ingPassword"], '$2a$07$usesomesillystringforsalt$');

			$sucursal = ControllerAlmacen::ctrMostrarAlmacen("idAlmacen", $respuesta["idAlmacen"]);
			if ($respuesta["login"] == $_POST["ingUsuario"] && $respuesta["passlogin"] == $encriptar) {

				if ($respuesta["estado"] == 1) {

					if ($respuesta["idPerfil"] == 0) {

						$_SESSION["iniciarSesion"] = true;
						$_SESSION["idUsuario"] = $respuesta["idUsuario"];
						$_SESSION["idEmpleado"] = $respuesta["idEmpleado"];
						$_SESSION["idAlmacen"] = $respuesta["idAlmacen"];
						$_SESSION["login"] = $respuesta["login"];

						$_SESSION["idPerfil"] = $respuesta["idPerfil"];

						date_default_timezone_set('America/Lima');

						$fecha = date('Y-m-d');
						$hora = date('H:i:s');

						$fechaActual = $fecha . ' ' . $hora;

						$item1 = "ultimo_login";
						$valor1 = $fechaActual;

						$item2 = "idUsuario";
						$valor2 = $respuesta["idUsuario"];

						$ultimoLogin = ModelUsuarios::mdlActualizarUsuarios($tabla, $item1, $valor1, $item2, $valor2);

						if ($ultimoLogin == "ok") {

							echo '<script>
							
								window.location = "inicio";

							</script>';
						}
					} else {

						if ($DateAndTime >= $sucursal["entrada"]  && $DateAndTime <= $sucursal["salida"]) {

							$_SESSION["iniciarSesion"] = true;
							$_SESSION["idUsuario"] = $respuesta["idUsuario"];
							$_SESSION["idEmpleado"] = $respuesta["idEmpleado"];
							$_SESSION["idAlmacen"] = $respuesta["idAlmacen"];
							$_SESSION["login"] = $respuesta["login"];

							$_SESSION["idPerfil"] = $respuesta["idPerfil"];

							date_default_timezone_set('America/Lima');

							$fecha = date('Y-m-d');
							$hora = date('H:i:s');

							$fechaActual = $fecha . ' ' . $hora;

							$item1 = "ultimo_login";
							$valor1 = $fechaActual;

							$item2 = "idUsuario";
							$valor2 = $respuesta["idUsuario"];

							$ultimoLogin = ModelUsuarios::mdlActualizarUsuarios($tabla, $item1, $valor1, $item2, $valor2);

							if ($ultimoLogin == "ok") {

								echo '<script>
							
								window.location = "inicio";

							</script>';
							}
						} else {
							echo '<br>
							<div class= "alert alert-danger">Usuario se encuentra fuera de horario</div>';
						}
					}
				} else {
					echo '<br>
							<div class= "alert alert-danger">El usuario aún no está Activado</div>';
				}
			} else {
				echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
			}
		}
	}

	static public function ctrMostrarUsuario($item, $valor)
	{
		$tabla = "usuario";
		$respuesta = ModelUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrCrearUsuario($datos)
	{

		$encriptar = crypt($datos["passlogin"], '$2a$07$usesomesillystringforsalt$');
		$tabla = "usuario";
		$datos = array(
			"idEmpleado" => $datos["idEmpleado"],
			"idAlmacen" => $datos["idAlmacen"],
			"login" => $datos["login"],
			"passlogin" => $encriptar,
			"idPerfil" => $datos["idPerfil"],
			"estado" => 1
		);

		$respuesta = ModelUsuarios::mdlIngresarUsuarios($tabla, $datos);
		return $respuesta;
	}

	static public function ctrEditarUsuario($datos)
	{

		if ($datos["passlogin"] != "") {

			$encriptar = crypt($datos["passlogin"], '$2a$07$usesomesillystringforsalt$');
		} else {

			$encriptar = $datos["passActual"];
		}
		$tabla = "usuario";
		$datos = array(
			"idUsuario" => $datos["idUsuario"],
			"idEmpleado" => $datos["idEmpleado"],
			"idAlmacen" => $datos["idAlmacen"],
			"login" => $datos["login"],
			"passlogin" => $encriptar,
			"idPerfil" => $datos["idPerfil"]
		);

		$respuesta = ModelUsuarios::mdlEditarUsuarios($tabla, $datos);
		return $respuesta;
	}


	static public function ctrBorrarUsuario($idUsuario)
	{

		$tabla = "usuario";
		$respuesta = ModelUsuarios::mdlBorrarUsuarios($tabla, $idUsuario);
		return $respuesta;
	}
}
