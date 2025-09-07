<?php

class ControllerConfiguracion
{

    static public function ctrMostrarConfiguracion()
    {
        $respuesta = ModelConfiguracion::mdlMostrarConfiguracion();
        return $respuesta;
    }

    static public function ctrEditarEmpresa($idEmpresa, $logo, $ruc, $razon_social, $direccion, $email, $moneda,$simbolom, $impuesto, $antiguoLogo)
    {

        $rutaLogo = "../" . $antiguoLogo;
        if (isset($logo["tmp_name"]) && !empty($logo["tmp_name"])) {
            if ($antiguoLogo == "views/img/empleado/default/avatar4.png") {
            } else {
                unlink("../" . $antiguoLogo);
            }

            list($ancho, $alto) = getimagesize($logo["tmp_name"]);

            $nuevoAncho = 500;
            $nuevoAlto = 500;

            if ($logo["type"] == "image/jpeg") {
                $aleatorio = mt_rand(1,99);
                $rutaLogo = "../views/img/empleado/logoempresa_".$aleatorio.".jpg";
                $origen = imagecreatefromjpeg($logo["tmp_name"]);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagejpeg($destino, $rutaLogo);
            }

            if ($logo["type"] == "image/png") {
                $aleatorio = mt_rand(1,99);
                $rutaLogo = "../views/img/empleado/logoempresa_".$aleatorio.".png";
                $origen = imagecreatefrompng($logo["tmp_name"]);
                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                imagealphablending($destino, FALSE);
                imagesavealpha($destino, TRUE);
                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
                imagepng($destino, $rutaLogo);
            }
        }
        $respuesta = ModelConfiguracion::mdlEditarEmpresa($idEmpresa, substr($rutaLogo,3), $ruc, $razon_social, $direccion, $email, $moneda,$simbolom, $impuesto);
        return $respuesta;
    }
}