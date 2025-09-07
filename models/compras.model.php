<?php

require_once "conexion.php";

class ComprasModel
{

    public $resultado;

    
    static public function mdlMostrarProovedor(){

        $stmt = Conexion::conectar()->prepare("SELECT idProveedor, RUC, nombre from proveedores");

        $stmt -> execute();
       
        return $stmt->fetchAll();
    }

   /* static public function mdlMostrarCompra($idCompra){

        if($idCompra != null){
            $stmt = Conexion::conectar()->prepare("SELECT c.idCompra,c.idDocalmacen, c.serie, c.num_documento, pr.nombre, concat(em.nombres,' ',em.apellidos) as empleado,c.tipo_pago, c.total_compra,c.subtotal, c.igv , c.estado,c.fecha_venta 
                                                    FROM compra c
                                                    INNER JOIN proveedores pr ON c.idProveedor = pr.idProveedor
                                                    INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                    INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado where c.idCompra = :idCompra");
            $stmt->bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
            $stmt -> execute();
            return $stmt->fetch();
		}else{
			$stmt = null;
            $stmt = Conexion::conectar()->prepare("SELECT c.idCompra,c.idDocalmacen, c.serie, c.num_documento, pr.nombre, concat(em.nombres,' ',em.apellidos) as empleado,c.tipo_pago, c.total_compra,c.subtotal, c.igv , c.estado, c.fecha_venta
                                                    FROM compra c
                                                    INNER JOIN proveedores pr ON c.idProveedor = pr.idProveedor
                                                    INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                    INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado");
            $stmt -> execute();
            return $stmt->fetchAll();
		}

    }*/

    static public function mdlMostrarCompras($fechaDesde,$fechaHasta){
        
		$stmt = null;
        $stmt = Conexion::conectar()->prepare("SELECT c.idCompra,c.idDocalmacen, c.serie, c.num_documento, pr.nombre, concat(em.nombres,' ',em.apellidos) as empleado,c.tipo_pago, c.total_compra,c.subtotal,c.igv,
                                              c.estado, c.fecha_venta
                                                FROM compra c
                                                INNER JOIN proveedores pr ON c.idProveedor = pr.idProveedor
                                                INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                where DATE(c.fecha_venta) >= date(:fechaDesde) and DATE(c.fecha_venta) <= date(:fechaHasta)");

        $stmt -> bindParam(":fechaDesde",$fechaDesde,PDO::PARAM_STR);
        $stmt -> bindParam(":fechaHasta",$fechaHasta,PDO::PARAM_STR);
/*$stmt = Conexion::conectar()->prepare("SELECT c.idCompra,c.idDocalmacen, c.serie, c.num_documento, pr.nombre, concat(em.nombres,' ',em.apellidos) as empleado,c.tipo_pago, CONCAT('S./ ',CONVERT(ROUND(c.total_compra,2), CHAR)) as total_compra,CONCAT('S/. ',CONVERT(ROUND(c.subtotal,2), CHAR)) as subtotal,CONCAT('S./ ',CONVERT(ROUND(c.igv,2), CHAR)) as igv ,
case when c.estado = 1 
then concat('<span>Anulado</span>')
else concat('<span>Aceptado</span>') 
end as estado, c.fecha_venta
FROM compra c
INNER JOIN proveedores pr ON c.idProveedor = pr.idProveedor
INNER JOIN usuario u ON c.idUsuario = u.idUsuario
INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado");*/
        $stmt -> execute();
        return $stmt->fetchAll();
    }

    static public function mdlMostrarCompra($idCompra){
        $stmt = Conexion::conectar()->prepare("SELECT c.idCompra,c.idDocalmacen, c.serie, c.num_documento, pr.nombre, concat(em.nombres,' ',em.apellidos) as empleado,c.tipo_pago, c.total_compra,c.subtotal, c.igv , c.estado,c.fecha_venta 
                                                FROM compra c
                                                INNER JOIN proveedores pr ON c.idProveedor = pr.idProveedor
                                                INNER JOIN usuario u ON c.idUsuario = u.idUsuario
                                                INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado 
                                                WHERE c.idCompra = :idCompra");
        $stmt->bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
        $stmt -> execute();
        //return $stmt->fetchAll(); para que aparescan muchos
        return $stmt->fetch(); //para que aparesca uno
    }

    static public function mdlMostrarDetalleCompra($idCompra){

        $stmt = Conexion::conectar()->prepare("SELECT dc.idDetalleCompra, dc.idCompra, dc.codigo_producto, p.descProducto,dc.cantidad,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(p.precioCompra,2), CHAR)) as precio_compra,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(dc.total_compra,2), CHAR)) as total_compra
                                                FROM detalle_compra dc 
                                                INNER JOIN producto p 
                                                ON dc.codigo_producto = p.codigoBarras 
                                                INNER JOIN empresa emp
                                                ON emp.idEmpresa = 1
                                                WHERE dc.idCompra = :idCompra");
        $stmt->bindParam(":idCompra", $idCompra, PDO::PARAM_INT);
        $stmt -> execute();
       
        return $stmt->fetchAll();
    }

    static public function mdlRegistrarCompra($datos, $idProveedor, $idUsuario, $idDocalmacen, $num_documento, $serie, $subtotal, $igv, $total_compra,$tipo_pago,$codigo_transa,$contacto)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO compra(idProveedor,idUsuario,idDocalmacen,num_documento,serie,subtotal,
                                                        igv,total_compra,tipo_pago,codigo_transa,contacto) 
                                                VALUES(:idProveedor,:idUsuario,:idDocalmacen,:num_documento,:serie,:subtotal,
                                                        :igv,:total_compra,:tipo_pago,:codigo_transa,:contacto)");

        $stmt->bindParam(":idProveedor", $idProveedor, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
        $stmt->bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
        $stmt->bindParam(":num_documento", $num_documento, PDO::PARAM_STR);
        $stmt->bindParam(":serie", $serie, PDO::PARAM_STR);
        $stmt->bindParam(":subtotal", $subtotal, PDO::PARAM_STR);
        $stmt->bindParam(":igv", $igv, PDO::PARAM_STR);
        $stmt->bindParam(":total_compra", $total_compra, PDO::PARAM_STR);
        $stmt->bindParam(":tipo_pago", $tipo_pago , PDO::PARAM_STR);
        $stmt->bindParam(":codigo_transa", $codigo_transa , PDO::PARAM_STR);
        $stmt->bindParam(":contacto", $contacto , PDO::PARAM_STR);

        if ($stmt->execute()) {

            $listaProductos = [];
              
                for ($i = 0; $i < count($datos); ++$i){
                    
                    $listaProductos = explode(",",$datos[$i]);


               

                $stmt = Conexion::conectar()->prepare("INSERT INTO detalle_compra(idCompra,codigo_producto, cantidad, total_compra) 
                                                        VALUES((select IFNULL(max(c.idCompra),'1') idCompra from compra c),:codigo_producto,:cantidad,:total_compra)");

                $stmt->bindParam(":codigo_producto", $listaProductos[0], PDO::PARAM_STR);
                $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);
                $stmt->bindParam(":total_compra", $listaProductos[2], PDO::PARAM_STR);



                if ($stmt->execute()) {
                    $stmt = null;

                    $stmt = Conexion::conectar()->prepare("UPDATE deposito as d INNER JOIN producto as p ON d.idProducto = p.idProducto SET d.stock = d.stock + :cantidad 
                                                            WHERE p.codigoBarras = :codigo_producto");

                    $stmt->bindParam(":codigo_producto",$listaProductos[0], PDO::PARAM_STR);
                    $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $stmt = null;
    
                        $stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
                                                                VALUES ('Registro por Compra',:stock ,:idProducto,'0',:idUsuario ,'Entrada',1, :habia, :stock + :habia)");
    
                        $stmt->bindParam(":stock", $listaProductos[1], PDO::PARAM_STR);
                        $stmt->bindParam(":idProducto",$listaProductos[3], PDO::PARAM_STR);
                        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
                        $stmt->bindParam(":habia", $listaProductos[4], PDO::PARAM_STR);
                        
    
                        if ($stmt->execute()) {
                            $resultado = "Se registró la compra correctamente.";
                        } else {
                            $resultado = "Error al actualizar el stock";
                        }
                    } else {
                        $resultado = "Error al registrar la venta";
                    }

                } 
            }


            return $resultado;

            $stmt = null;
        }
    }

    static public function mdlAnularCompra($idCompra){

        $stmt = Conexion::conectar()->prepare("call prc_anular_compra(:idCompra)");

        $stmt -> bindParam(":idCompra",$idCompra,PDO::PARAM_STR);
        
        $stmt -> execute();

        return $stmt->fetch();

        // return $nroBoleta;

    }

    static public function mdlTotalCompra($fechaDesde,$fechaHasta){

        $stmt = Conexion::conectar()->prepare("SELECT IFNULL(SUM(total_compra), '0.00') as total_compra FROM compra
                                                WHERE estado = 0
                                                AND DATE(fecha_venta) >= date(:fechaDesde) and DATE(fecha_venta) <= date(:fechaHasta)");

        $stmt -> bindParam(":fechaDesde",$fechaDesde,PDO::PARAM_STR);
        $stmt -> bindParam(":fechaHasta",$fechaHasta,PDO::PARAM_STR);
        $stmt -> execute();
        return $stmt->fetch();
        $stmt = null;
    }
}