<?php
class ControllerPerfil{

	static public function ctrMostrarPerfil($item, $valor){
		$tabla = "perfiles";
		$respuesta = ModelPerfil::mdlMostrarPerfiles($tabla, $item, $valor);
		return $respuesta;
	}

    static public function ctrMostrarDtPerfil($item, $valor){
		$tabla = "perfil";
		$respuesta = ModelPerfil::mdlMostrarPerfiles($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrRegistrarPerfiles($descripcion){
        $perfiles = ModelPerfil::mdlRegistrarPerfiles($descripcion);
        return $perfiles;
    }

	static public function ctrEditarPerfiles($idPerfiles,$descripcion){
        $perfiles = ModelPerfil::mdlEditarPerfiles($idPerfiles,$descripcion);
        return $perfiles;
    }

	static public function ctrEliminarPerfiles($idPerfiles,$estado){
        $perfiles = ModelPerfil:: mdlEliminarPerfiles($idPerfiles,$estado);
        return $perfiles;
    }




	static public function ctrMostrarMenus(){
        $menus = ModelPerfil::mdlMostrarMenus();
        return $menus;
    }
	static public function ctrMostrarMenuPermisos($idMenu, $idPerfiles){
        $menus = ModelPerfil::mdlMostrarMenuPermisos($idMenu, $idPerfiles);
        return $menus;
    }





    static public function ctrRegistrarPermisos($idPerfiles, $idMenu){
        $permisos = ModelPerfil::mdlRegistrarPermisos($idPerfiles, $idMenu);
        return $permisos;
    }

    static public function ctrDesactivarPermiso($idPermiso){
        $permisos = ModelPerfil::mdlDesactivarPermiso($idPermiso);
        return $permisos;
    }

    static public function ctrActivarPermiso($idPermiso){
        $permisos = ModelPerfil::mdlActivarPermiso($idPermiso);
        return $permisos;
    }
	
	
    

}
