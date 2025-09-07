<?php

//vamos a requerir el controlador y el modelo

require_once "../../controllers/perfil.controller.php";
require_once "../../models/perfil.model.php";

class TablaMenus
{

	/*=============================================
	Tabla Servicio
	=============================================*/

	public function mostrarTabla()
	{
		$menus = ControllerPerfil::ctrMostrarMenus();
		if (count($menus) == 0) {
			$datosJson = '[]';
			echo $datosJson;
			return;
		}

		$datosJson = '[';

		foreach ($menus as $key => $value) {

            $idMenu= $value["idMenu"] ;
            $idPerfiles =  $_GET["idPerfiles"];
            $permisos = ControllerPerfil::ctrMostrarMenuPermisos($idMenu, $idPerfiles);	
			
         //para eliminar se hara por id menu y id perfil en la tabla permisos
			/*if($permisos["idMenu"] == ""){
			
				$agregar="<button  type='button' class='btn btn-danger guardarPermiso' idMenu='".$value["idMenu"]."' ><i class='fa fa-toggle-off'></i> &nbsp;APAGADO</button>";
				
			}else{
				if($permisos["estado"] == "on"){
					$agregar="<button  type='button' class='btn btn-success btnDesactivarPermiso'  idMenu='".$value["idMenu"]."' idPruebaExiste='".$permisos["idMenu"]."' ><i class='fa fa-toggle-on'> </i>&nbsp;ENCENDIDO</button>";
				}else if($permisos["estado"] == "off"){
					$agregar="<button  type='button' class='btn btn-danger btnActivarPermiso'  idMenu='".$value["idMenu"]."' idPruebaExiste='".$permisos["idMenu"]."' ><i class='fa fa-toggle-off'> </i>&nbsp;APAGADO</button>";
				}
				
			}
		 */
		if($permisos["idMenu"] == ""){
			
			$agregar="<button type='button' class='btn btn-danger guardarPermiso' idMenu='".$value["idMenu"]."' >".
					"<i class='fa fa-toggle-off'></i> &nbsp;APAGADO".
					"</button>";
			
		}else{
			if($permisos["estado"] == "on"){
				$agregar="<button type='button' class='btn btn-success btnDesactivarPermiso'  idPermiso='".$permisos["idPermiso"]."' >".
						"<i class='fa fa-toggle-on'> </i>&nbsp;ENCENDIDO".
						"</button>";
			}else if($permisos["estado"] == "off"){
				$agregar="<button type='button' class='btn btn-danger btnActivarPermiso'  idPermiso='".$permisos["idPermiso"]."' >".
						"<i class='fa fa-toggle-off'> </i>&nbsp;APAGADO".
						"</button>";
			}
			
		}
			$datosJson .= '{
						"descripcion": "' . $value["descripcion"] . '",
                        "grupo": "' . $value["grupo"] . '",
						"agregar" : "' . $agregar . '"
			},';
		}

		$datosJson = substr($datosJson, 0, -1);
		$datosJson .=  ']';
		echo $datosJson;
	}
}

$tabla = new TablaMenus();
$tabla->mostrarTabla();