<?php

class ControllerDeposito{

	static public function ctrVerDepositoPrueba(){
		$respuesta = ModelDeposito::mdlVerDepositoPrueba();
		return $respuesta;
	}
	

	static public function ctrMostrarDeposito(){
		$respuesta = ModelDeposito::mdlVerDeposito();
		return $respuesta;
	}

    static public function ctrMostrarDepositoProducto($idProducto){
		$respuesta = ModelDeposito::mdlVerDepositoProducto($idProducto);
		return $respuesta;
	}

	static public function ctrMostrarDepositoU($idDeposito){
		$respuesta = ModelDeposito::mldMostrarDeposito($idDeposito);
		return $respuesta;
	}

	static public function ctrRegistroDeposito($idProducto, $stock,$idUsuario){
		$respuesta = ModelDeposito::mdlRegistroDeposito($idProducto, $stock,$idUsuario);
		return $respuesta;
	}

	/*static public function ctrRegistroDeposito(){
		if(isset($_POST["stock"])){

			$tablaBD = "deposito";

			$datosC = array("stock" => $_POST["stock"], 
							"idProducto"=>$_POST["idProducto"]);

			$resultado = ModelDeposito::mdlRegistroDeposito($tablaBD, $datosC);

			if($resultado == true){

				echo '<script>
					let timerInterval
						Swal.fire({
						title: "¡CORRECTO!",
						html: "Se Agrego el stock correctamente.",
						icon: "success",
						timer: 1500,
						timerProgressBar: true,
						didOpen: () => {
							Swal.showLoading()
							const b = Swal.getHtmlContainer().querySelector("b")
							timerInterval = setInterval(() => {
						
							}, 75)
						},
						willClose: () => {
							clearInterval(timerInterval)
						}
						}).then((result) => {
						
						if (result.dismiss === Swal.DismissReason.timer) {
							console.log("se ha cerrado por el tiempo!")
							window.location = "deposito";
						}
						})

			  </script>';

			}

		}
	}*/

	static public function ctreditarSumaStock($idDeposito,$stock,$idProducto,$idUsuario,$habia){
		$respuesta = ModelDeposito::mdlEditarStock($idDeposito,$stock,$idProducto,$idUsuario,$habia);
		return $respuesta;
	}

	static public function ctreditarAjustarStock($idDeposito,$stock,$idProducto,$idUsuario,$habia){
		$respuesta = ModelDeposito::mdlEditarAjuste($idDeposito,$stock,$idProducto,$idUsuario,$habia);
		return $respuesta;
	}

	static public function ctreditarTraslado($idDeposito,$stock,$idAlmacen,$idProducto,$idUsuario,$habia,$habidst){
		$respuesta = ModelDeposito::mdlEditarTraslado($idDeposito,$stock,$idAlmacen,$idProducto,$idUsuario,$habia,$habidst);
		return $respuesta;
	}
	
	static public function ctrBorrarDeposito($idDeposito,$stock,$idProducto,$idUsuario){
		$respuesta = ModelDeposito::mdlBorrarDeposito($idDeposito,$stock,$idProducto,$idUsuario);
		return $respuesta;
	}
	


}


