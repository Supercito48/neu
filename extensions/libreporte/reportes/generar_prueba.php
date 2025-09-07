<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../numeroaletras.php';
require_once '../../../models/rutas.php';
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();

$url = Ruta::ctrRuta();
$css=file_get_contents('estilos.css');

$consulta= "SELECT vc.idVenta,
da.Documento, 
vc.serie, 
vc.nro_comprobante,  
a.descripcion as nomalmacen,
a.ubicacion,
concat(em.nombres,' ',em.apellidos) as empleado,
c.nombres as cliente,
c.direccion,
c.dni,
vc.tipo_pago,
vc.codigo_transa,
vc.contacto, 
vc.subtotal as subtotalsuma, 
vc.igv as igvsuma, 
CONCAT('',CONVERT(ROUND(vc.pago_efe,2), CHAR)) as pago_efe,
CONCAT('',CONVERT(ROUND(vc.pago_tar,2), CHAR)) as pago_tar,
CONCAT('',CONVERT(ROUND(vc.total_venta,2), CHAR)) as total_venta,
CONCAT('',CONVERT(ROUND(vc.subtotal,2), CHAR)) as subtotal,
CONCAT('',CONVERT(ROUND(vc.igv,2), CHAR)) as igv,
CONCAT('',CONVERT(ROUND(vc.comision,2), CHAR)) as comision,
vc.comision as comisioncomp,
CONCAT('',CONVERT(ROUND(vc.delivery,2), CHAR)) as delivery,
vc.delivery as deliverycomp,
vc.total_venta as totalventaletras,
vc.estado, 
vc.fecha_venta,
emp.logo,
emp.ruc,
emp.razon_social,
emp.direccion as direccionemp,
emp.email,
emp.moneda,
emp.simbolom,
emp.impuesto
FROM venta_cabecera vc
INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
INNER JOIN clientes c ON vc.idCliente = c.idCliente
INNER JOIN almacen a ON vc.idAlmacen = a.idAlmacen
INNER JOIN empresa emp ON emp.idEmpresa = 1
where vc.idVenta='".$_GET['idVenta']."'";

$resultado=$mysqli->query($consulta);


while($row=$resultado->fetch_assoc()){

$totalTotal = $row['subtotalsuma'] + $row['igvsuma'] ;
$fecha = setlocale(LC_TIME, "spanish");					    
$numerosol= $modelonumero->numtoletras(abs($row['totalventaletras']),$row['moneda'],'centimos').'<br>';
$mesDesc = strftime("%d-%m-%Y", strtotime($row['fecha_venta']));
$html.="
<body>
<div class='tablageneral tablacostos tablaboleta'>        
    
    

<table class='tablareceipt' style=' text-align: center !important;'>
    <tbody>
        <tr >
        <td style=' text-align: center !important;'>
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class='logofactura' text-align: left !important  src='../../../views/img/empleado/logoempresa_28.png'>
                <p style='text-transform: none !important;'><strong>".$row['razon_social']."</strong></p>
                <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección: ".$row['direccionemp']."</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/email.png' style='width: 12px;' /> Email: ".$row['email']."</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/store-solid.svg' style='width: 12px;' /> Sucursal : ".$row['nomalmacen']."</p>
                 <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección Sucursal : ".$row['ubicacion']."</p>
            </td>
            <td style=' text-align: left !important;'>
            <br><br><br><br><br><br><br>
               <p style='text-transform: none !important;'><img src='../../../views/img/calendar-alt-solid.svg' style='width: 12px;' /> Fecha Emisión: ".$mesDesc." </p>
                <p style='text-transform: none !important;'><img src='../../../views/img/user-solid.svg' style='width: 12px;' /> Cliente: ".$row['cliente']." </p>
               <p style='text-transform: none !important;'><img src='../../../views/img/id-card-regular.svg' style='width: 12px;' /> DNI: ".$row['dni']."</p>
                <p style='text-transform: none !important;'><img src='../../../views/img/map-marker-alt-solid.svg' style='width: 12px;' /> Dirección: ".$row['direccion']."</p>
            </td>
            
            <td class='textruc'>
        
                <p style='font-size: 30px'>R.U.C. ".$row['ruc']."</p>                    
                <p style='font-size: 25px'>".$row['Documento']."</p>
                <p style='font-size: 25px'>".$row['serie']." - ".$row['nro_comprobante']."</p>
            </td>
        </tr>
       
       
    </tbody>
</table>

</div>
<div class='tablageneral'>        
    <table cellpadding='0' cellspacing='0'>
   
        <tbody>
            <tr class='titulotable'>
                <td class='cantidadtabla'  style='text-align: center;font-size: 12px'>Codigo</td>
                <td style='text-align: center;font-size: 12px'>Descripción</td>
                
                <td class='preciotabla' style='text-align: center;font-size: 12px'>Precio Unitario</td>
                <td class='cantidadtabla' style='text-align: center;font-size: 12px'>Cantidad</td>
                <td class='preciotabla' style='text-align: center;font-size: 12px'>Sub Total</td>
                </tr>";
$consultatratamiento= "SELECT 
vc.idDetalle, 
vc.idVenta, 
vc.codigo_producto, 
p.descProducto,
ROUND(vc.cantidad,2) cantidad,
CONCAT('',CONVERT(ROUND(vc.total_venta/vc.cantidad,2), CHAR)) as precio_venta,
CONCAT('',CONVERT(ROUND(vc.total_venta,2), CHAR)) as total_venta
FROM venta_detalle vc 
INNER JOIN producto p 
ON vc.codigo_producto = p.codigoBarras 
where vc.idVenta='".$_GET['idVenta']."'";
$resultadotratamiento=$mysqli->query($consultatratamiento);
$contadortratamiento=0;
while($rowtratamiento=$resultadotratamiento->fetch_assoc()){

$html.="

            <tr class='detalletable'>
                <td style='text-align: center;font-size: 12px'>". $rowtratamiento['codigo_producto']."</td>
                <td style='text-align: center;font-size: 12px'>".utf8_encode($rowtratamiento['descProducto'])."</td>
                <td style='text-align: center;font-size: 12px'>".$row["simbolom"]." ". $rowtratamiento['precio_venta']."</td>
                <td style='text-align: center;font-size: 12px'>".$rowtratamiento['cantidad']."</td>
                <td style='text-align: center;font-size: 12px'>".$row["simbolom"]." ". $rowtratamiento['total_venta']."</td>
               
            </tr>";
}
           
       $html.=" </tbody>
    </table>
</div>

<div class='tablageneral tablacostos tablaboleta'>        
    <table cellpadding='0' cellspacing='0'>
        <tbody>   
            <tr class='detalletable'>                                                                
                <td colspan='2' rowspan='3' style='vertical-align: top'>
                    <div style='font-size: 12px'>SON: ".$numerosol."</div>
                    <hr/><br/>
                    <div  style='font-size: 12px'>Observación</div>
                </td>
                <td class='preciotabla fintabla fintabla fintablados'style='text-align:right; font-size: 12px'><b>SUB TOTAL</b></td>
                <td class='preciotabla ulttable fintabla' style='text-align:right;font-size: 12px'>".$row["simbolom"]." ".$row['subtotal']."</td>
            </tr>  
            <tr class='detalletable'>                                                                
             
                <td class='preciotabla fintabla fintabla fintablados'style='text-align:right; font-size: 12px'><b>IGV</b></td>
                <td class='preciotabla ulttable fintabla' style='text-align:right; font-size: 12px'>".$row["simbolom"]." ".$row['igv']."</td>
            </tr>  
            <tr class='detalletable'>                                                                
               
                <td class='preciotabla fintabla fintabla fintablados'style='text-align:right; font-size: 12px'><b >TOTAL</b></td>
                <td class='preciotabla ulttable fintabla' style='text-align:right; font-size: 12px'>".$row["simbolom"]." ".$row['total_venta']."</td>
            </tr>  
        </tbody>
    </table>        
    
</div>
<table cellpadding='0' cellspacing='0' class='tablacan'>
            <tbody>
                <tr>    
                    <td style=''>
                        <img style='width: 124px; margin-bottom: 11px;' src='../../../views/img/qr.png' />
                        <p style='font-size: 10px'>
                        Cajero/ ".$row["empleado"]."
                        </p>   
                    </td>                    
                    <td style='text-align:center'>
                    <div>
                    <br><b style='text-align: center'>¡Gracias por su preferencia!</b><br>
            
                    <b style='text-align: center;'></b><br>
                    
                    </div>
                        
                    </td>
                </tr>   
            </tbody>
        </table>
        
    
  

</body>
";
if($row['estado']==1){
$estado = true;
}else{
$estado= false;
}
}


$mpdf = new \Mpdf\Mpdf(['mode' => ' utf-8', 'format' => 'A4','margin_left' => 8,'margin_right' => 8,'margin_top' => 5,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->SetWatermarkText('ANULADO',2,50);
$mpdf->showWatermarkText = $estado;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.12;
$mpdf->Output();