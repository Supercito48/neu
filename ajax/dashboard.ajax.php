<?php

require_once "../controllers/dashboard.controller.php";
require_once "../models/dashboard.model.php";

class ajaxDashboard
{
  
    public function ajaxTotalProductos(){	
		$respuesta = DashboardController::ctrTotalProductos();
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxTotalConejos(){	
		$respuesta = DashboardController::ctrTotalConejos();
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxTotalEmpleado(){	
		$respuesta = DashboardController::ctrTotalEmpleado();
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxTotalAlmacen(){	
		$respuesta = DashboardController::ctrTotalAlmacen();
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
    public function ajaxTotalVCP(){	
		$respuesta = DashboardController::ctrTotalVCP($this->idAlmacen);
		echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
	}
   
    
  

   
   

}

/*=============================================
Guardar y Editar Persona
=============================================*/


if(isset($_POST["ajaxTotalProductos"])){
    $dashboard = new ajaxDashboard();
    $dashboard -> ajaxTotalProductos();
}
if(isset($_POST["ajaxTotalConejos"])){
    $dashboard = new ajaxDashboard();
    $dashboard -> ajaxTotalConejos();
}

if(isset($_POST["ajaxTotalEmpleado"])){
    $dashboard = new ajaxDashboard();
    $dashboard -> ajaxTotalEmpleado();
}
if(isset($_POST["ajaxTotalAlmacen"])){
    $dashboard = new ajaxDashboard();
    $dashboard -> ajaxTotalAlmacen();
}


if(isset($_POST["ajaxTotalVCP"])){
    $dashboard = new ajaxDashboard();
    $dashboard -> idAlmacen = $_POST["idAlmacen"];
    $dashboard -> ajaxTotalVCP();
}

