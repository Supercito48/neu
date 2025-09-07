<?php

class ControllerEmpleado{

	static public function ctrMostrarEmpleado($item, $valor){

		$tabla = "empleado";
		
		$respuesta = ModelEmpleados::mdlMostrarEmpleado($tabla, $item, $valor);
		return $respuesta;

	}

	
	static public function ctrMostrarEmpleados( $ordenar, $item, $valor, $base, $tope){

		$tabla = "empleado";
		
		$respuesta = ModelEmpleados::mdlMostrarEmpleados($tabla, $ordenar, $item, $valor, $base, $tope);
		return $respuesta;

	}

	static public function ctrListarEmpleado($ordenar, $item,$valor){

		$tabla = "empleado";
		$respuesta = ModelEmpleados::mdlListarEmpleado($tabla, $ordenar,$item, $valor);
		return $respuesta;

	}

	

	/*=============================================
	CREAR PRODUCTOS
	=============================================*/

	static public function ctrCrearEmpleado($datos){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["nombres"])){

				/*=============================================
				VALIDAR IMAGEN PORTADA
				=============================================*/

				$rutaFoto = "../views/img/empleado/default/avatar4.png";

				if(isset($datos["foto"]["tmp_name"])&& !empty($datos["foto"]["tmp_name"])){

					/*=============================================
					DEFINIMOS LAS MEDIDAS
					=============================================*/

					list($ancho, $alto) = getimagesize($datos["foto"]["tmp_name"]);	

					$nuevoAncho = 500;
					$nuevoAlto = 500;
				

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($datos["foto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);
						
						$rutaFoto = "../views/img/empleado/".$datos["nombres"].".jpg";

						$origen = imagecreatefromjpeg($datos["foto"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $rutaFoto);

					}

					if($datos["foto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$rutaFoto = "../views/img/empleado/".$datos["nombres"].".png";

						$origen = imagecreatefrompng($datos["foto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagealphablending($destino, FALSE);
				
						imagesavealpha($destino, TRUE);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $rutaFoto);

					}

				}

					$datos = array(
						   "nombres"=>$datos["nombres"],
						   "apellidos"=>$datos["apellidos"],
						   "telefono"=>$datos["telefono"],
						   "direccion"=>$datos["direccion"],
						   "dni"=>$datos["dni"],
						   "correo"=>$datos["correo"],
						   "fecNacimiento"=>$datos["fecNacimiento"],
						   "foto"=>substr($rutaFoto,3),
					   );

					  

				$respuesta = ModelEmpleados::mdlIngresarEmpleado("empleado", $datos);

				return $respuesta;
				

			
		
		}else{
			echo 'error 1';
		}

	}

	/*=============================================
	EDITAR PRODUCTOS
	=============================================*/

	static public function ctrEditarEmpleado($datos){

	
		if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $datos["nombres"])){

				
				/*=============================================
				VALIDAR IMAGEN PORTADA
				=============================================*/
				$rutaFoto = "../".$datos["antiguaFoto"];

				if(isset($datos["foto"]["tmp_name"]) && !empty($datos["foto"]["tmp_name"])){

					/*=============================================
					BORRAMOS ANTIGUA FOTO 
					=============================================*/
					if($datos["antiguaFoto"] == "views/img/empleado/default/avatar4.png"){

					}else{
						unlink("../".$datos["antiguaFoto"]);	
					}
					

					/*=============================================
					DEFINIMOS LAS MEDIDAS
					=============================================*/

					list($ancho, $alto) = getimagesize($datos["foto"]["tmp_name"]);	

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
					DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
					=============================================*/

					if($datos["foto"]["type"] == "image/jpeg"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$rutaFoto = "../views/img/empleado/".$datos["nombres"].".jpg";

						$origen = imagecreatefromjpeg($datos["foto"]["tmp_name"]);						
						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $rutaFoto);

					}

					if($datos["foto"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

						$aleatorio = mt_rand(100,999);

						$rutaFoto = "../views/img/empleado/".$datos["nombres"].".png";

						$origen = imagecreatefrompng($datos["foto"]["tmp_name"]);						

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagealphablending($destino, FALSE);
				
						imagesavealpha($destino, TRUE);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $rutaFoto);

					}

				}

				$datos = array(
								   "idEmpleado"=>$datos["id"],
								   "nombres"=>$datos["nombres"],
								   "apellidos"=>$datos["apellidos"],
								   "telefono"=>$datos["telefono"],
								   "direccion"=>$datos["direccion"],
								   "dni"=>$datos["dni"],
								   "correo"=>$datos["correo"],
								   "fecNacimiento"=>$datos["fecNacimiento"],
								   "foto"=>substr($rutaFoto,3)
								   );

	
				$respuesta = ModelEmpleados::mdlEditarEmpleado("empleado", $datos);

				return $respuesta;


			}else{
				echo 'error 2';
			}

		
		
	}
	

	/*=============================================
	Eliminar Empleado
	=============================================*/

	static public function ctrEliminarEmpleado($datos){
		
		// Eliminamos la foto
		if($datos["fotoEliminar"] == ""){

		}else{
			unlink("../".$datos["fotoEliminar"]);	
		}
		$tabla = "empleado";

		$respuesta = ModelEmpleados::mdlEliminarEmpleado($tabla, $datos["idEliminar"]);

		return $respuesta;

	}

}

