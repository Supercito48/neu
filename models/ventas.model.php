<?php

require_once "conexion.php";

class VentasModel
{

    public $resultado;

    static public function mdlObtenerNroBoleta($Documento, $idAlmacen)
    {


        $stmt = Conexion::conectar()->prepare("SELECT idDocalmacen,Serie, IFNULL(LPAD(max(d.Cantidad)+1,8,'0'),'00000001') nro_venta from docalmacen d 
                                                WHERE d.idDocalmacen = :Documento AND d.idAlmacen = :idAlmacen");


        $stmt->bindParam(":Documento", $Documento, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    static public function mdlMostrarDocumento($idAlmacen)
    {

        $stmt = Conexion::conectar()->prepare("SELECT idDocalmacen,Documento from docalmacen WHERE idAlmacen = :idAlmacen");

        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    static public function mdlRegistrarVenta($datos, $idCliente, $idAlmacen, $idUsuario, $idDocalmacen, $serie, $nro_comprobante, $descripcion, $pago_efe, $pago_tar, $pago_credit, $subtotal, $igv, $comision, $delivery, $total_venta, $tipo_pago, $codigo_transa, $contacto, $idCaja)
    {

        $con = Conexion::conectar();
        $stmt =  $con->prepare("INSERT INTO venta_cabecera(idCliente,idAlmacen,idUsuario,idDocalmacen,serie,nro_comprobante,descripcion,pago_efe,pago_tar,pago_credit,subtotal,
                                                        igv,comision,delivery,total_venta,tipo_pago,codigo_transa,contacto,idCaja) 
                                                VALUES(:idCliente,:idAlmacen,:idUsuario,:idDocalmacen,:serie,:nro_comprobante,:descripcion,:pago_efe,:pago_tar,:pago_credit,:subtotal,:igv,:comision,:delivery,:total_venta,:tipo_pago,:codigo_transa,:contacto,:idCaja)");

        $stmt->bindParam(":idCliente", $idCliente, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_STR);
        $stmt->bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
        $stmt->bindParam(":serie", $serie, PDO::PARAM_STR);
        $stmt->bindParam(":nro_comprobante", $nro_comprobante, PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);

        $stmt->bindParam(":pago_efe", $pago_efe, PDO::PARAM_STR);
        $stmt->bindParam(":pago_tar", $pago_tar, PDO::PARAM_STR);
        $stmt->bindParam(":pago_credit", $pago_credit, PDO::PARAM_STR);

        $stmt->bindParam(":subtotal", $subtotal, PDO::PARAM_STR);
        $stmt->bindParam(":igv", $igv, PDO::PARAM_STR);
        $stmt->bindParam(":comision", $comision, PDO::PARAM_STR);
        $stmt->bindParam(":delivery", $delivery, PDO::PARAM_STR);
        $stmt->bindParam(":total_venta", $total_venta, PDO::PARAM_STR);
        $stmt->bindParam(":tipo_pago", $tipo_pago, PDO::PARAM_STR);
        $stmt->bindParam(":codigo_transa", $codigo_transa, PDO::PARAM_STR);
        $stmt->bindParam(":contacto", $contacto, PDO::PARAM_STR);
        $stmt->bindParam(":idCaja", $idCaja, PDO::PARAM_STR);



        if ($stmt->execute()) {

            $stmt = null;
            $stmt = Conexion::conectar()->prepare("UPDATE docalmacen SET Cantidad = LPAD(Cantidad + 1,8,'0') WHERE idDocalmacen = :idDocalmacen AND idAlmacen = :idAlmacen");

            $stmt->bindParam(":idDocalmacen", $idDocalmacen, PDO::PARAM_STR);
            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $stmt = null;
                $stmt = Conexion::conectar()->prepare("UPDATE clientes SET credito_usado = credito_usado - $pago_credit WHERE idCliente = $idCliente");

                if ($stmt->execute()) {
                    if ($tipo_pago == "Credito") {
                        $stmt = null;
                        $stmt = Conexion::conectar()->prepare("INSERT bitacora_credito (idCliente,descripcion,montod)
														VALUES ($idCliente,'COMPRA DE PRODUCTO + ',CONCAT(' ', CAST($total_venta AS DECIMAL(7, 2))))");
                    }
                } else {
                }

                if ($stmt->execute()) {

                    $listaProductos = [];

                    for ($i = 0; $i < count($datos); ++$i) {

                        $listaProductos = explode(",", $datos[$i]);

                        //var_dump($listaProductos);

                        $stmt = Conexion::conectar()->prepare("INSERT INTO venta_detalle(idVenta,codigo_producto, cantidad, total_venta) 
                                                            VALUES((select IFNULL(max(c.idVenta),'1') idVenta from venta_cabecera c),:codigo_producto,:cantidad,:total_venta)");

                        $stmt->bindParam(":codigo_producto", $listaProductos[0], PDO::PARAM_STR);
                        $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);
                        $stmt->bindParam(":total_venta", $listaProductos[2], PDO::PARAM_STR);



                        if ($stmt->execute()) {
                            $stmt = null;

                            $stmt = Conexion::conectar()->prepare("UPDATE inventario as i INNER JOIN producto as p ON i.idProducto = p.idProducto SET i.stock = i.stock - :cantidad 
                                                                    WHERE i.idAlmacen = :idAlmacen AND p.codigoBarras = :codigo_producto");

                            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
                            $stmt->bindParam(":codigo_producto", $listaProductos[0], PDO::PARAM_STR);
                            $stmt->bindParam(":cantidad", $listaProductos[1], PDO::PARAM_STR);

                            if ($stmt->execute()) {
                                $stmt = null;

                                $stmt = Conexion::conectar()->prepare("INSERT INTO kardex(motivo,stock, idProducto, idAlmacen, idUsuario, tipo, estado,habia, hay) 
                                                                    VALUES ('Salida por Venta',:stock, :idProducto, $idAlmacen,$idUsuario, 'Salida', 1, :habia, :habia - :hay)");


                                $stmt->bindParam(":idProducto", $listaProductos[3], PDO::PARAM_STR);
                                $stmt->bindParam(":stock", $listaProductos[1], PDO::PARAM_STR);
                                $stmt->bindParam(":habia", $listaProductos[4], PDO::PARAM_STR);
                                $stmt->bindParam(":hay", $listaProductos[1], PDO::PARAM_STR);

                                if ($stmt->execute()) {
                                    $resultado = "Se registró la venta correctamente.";
                                } else {
                                    $resultado = "Error al actualizar el stock";
                                }
                            }
                        } else {
                            $resultado = "Error al registrar la venta";
                        }
                    }

                    $stmt = null;
                }
            }
            $idd =  $con->lastInsertId();
            return intval($idd);
        }
    }

    static public function mdlListarVenta($idVenta)
    {
        $stmt = Conexion::conectar()->prepare("SELECT vc.idVenta,da.Documento, vc.serie, vc.nro_comprobante,  concat(em.nombres,' ',em.apellidos) as empleado,vc.tipo_pago, vc.total_venta,vc.subtotal,vc.igv,
                                                vc.estado, vc.fecha_venta
                                                FROM venta_cabecera vc
                                                INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
                                                INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
                                                WHERE  vc.idVenta= :idVenta");
        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
        $stmt->execute();
        //return $stmt->fetchAll(); para que aparescan muchos
        return $stmt->fetch(); //para que aparesca uno
    }

    static public function mdlListarVentas($idAlmacen, $fechaDesde, $fechaHasta)
    {

        try {
            // SELECT v.id,v.codigo_producto,c.nombre_categoria,p.descripcion_producto,v.cantidad, concat('S./ ',round(v.total_venta,2)) as total_venta,v.fecha_venta
            $stmt = Conexion::conectar()->prepare("SELECT vc.idVenta,da.Documento, vc.serie, vc.nro_comprobante,  concat(em.nombres,' ',em.apellidos) as empleado,vc.pago_efe,vc.pago_tar,vc.tipo_pago, vc.total_venta,vc.subtotal,vc.igv,
                                                    vc.estado, vc.fecha_venta
                                                    FROM venta_cabecera vc
                                                    INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
                                                    INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
                                                    INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
                                                    where DATE(vc.fecha_venta) >= date(:fechaDesde) and DATE(vc.fecha_venta) <= date(:fechaHasta) 
                                                    AND vc.idAlmacen= :idAlmacen");

            $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
            $stmt->bindParam(":fechaDesde", $fechaDesde, PDO::PARAM_STR);
            $stmt->bindParam(":fechaHasta", $fechaHasta, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return 'Excepción capturada: ' .  $e->getMessage() . "\n";
        }

        $stmt = null;
    }

    static public function mdlMostrarDetalleVenta($idVenta)
    {

        $stmt = Conexion::conectar()->prepare("SELECT vc.idDetalle, vc.idVenta, vc.codigo_producto, p.descProducto,vc.cantidad,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_venta/vc.cantidad,2), CHAR)) as precio_venta,
                                                CONCAT(emp.simbolom,' ',CONVERT(ROUND(vc.total_venta,2), CHAR)) as total_venta
                                                FROM venta_detalle vc 
                                                INNER JOIN producto p 
                                                ON vc.codigo_producto = p.codigoBarras 
                                                INNER JOIN empresa emp
                                                ON emp.idEmpresa = 1
                                                WHERE vc.idVenta = :idVenta");
        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    static public function mdlAnularVenta($idVenta)
    {

        $stmt = Conexion::conectar()->prepare("call prc_anular_venta(:idVenta)");

        $stmt->bindParam(":idVenta", $idVenta, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch();
    }
    static public function mdlTotalVenta($idAlmacen, $fechaDesde, $fechaHasta)
    {

        $stmt = Conexion::conectar()->prepare("SELECT IFNULL(ROUND(SUM(pago_efe),2),'0.00') Total_Efectivo FROM `venta_cabecera` 
                                                WHERE estado = 0
                                                AND idAlmacen = :idAlmacen
                                                AND DATE(fecha_venta) >= date(:fechaDesde) and DATE(fecha_venta) <= date(:fechaHasta)");

        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDesde", $fechaDesde, PDO::PARAM_STR);
        $stmt->bindParam(":fechaHasta", $fechaHasta, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt = null;
    }
}