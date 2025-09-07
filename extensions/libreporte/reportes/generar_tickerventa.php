<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';

require_once '../../numeroaletras.php';
require_once '../../../models/rutas.php';
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();

$url = Ruta::ctrRuta();


$numero2 = '35.00';
$consultaEmpresa = "SELECT * FROM empresa where idEmpresa = 1";

$consulta= "SELECT vc.idVenta,
da.Documento, 
vc.serie, 
vc.nro_comprobante,  
a.descripcion as nomalmacen,
a.ubicacion,
concat(em.nombres,' ',em.apellidos) as empleado,
a.descripcion as nomalmacen,
a.ubicacion,
c.nombres as cliente,
c.direccion,
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
vc.fecha_venta
FROM venta_cabecera vc
INNER JOIN usuario u ON vc.idUsuario = u.idUsuario
INNER JOIN empleado em ON u.idEmpleado = em.idEmpleado
INNER JOIN docalmacen da ON vc.idDocalmacen = da.idDocalmacen
INNER JOIN clientes c ON vc.idCliente = c.idCliente
INNER JOIN almacen a ON vc.idAlmacen = a.idAlmacen
where vc.idVenta='".$_GET['idVenta']."'";
$resultado=$mysqli->query($consulta);
$resultadoEmpresa=$mysqli->query($consultaEmpresa);
while($rowEmpresa=$resultadoEmpresa->fetch_assoc()){

while($row=$resultado->fetch_assoc()){

$totalTotal = $row['subtotalsuma'] + $row['igvsuma'] ;
$fecha = setlocale(LC_TIME, "spanish");					    
$numerosol= $modelonumero->numtoletras(abs($row['totalventaletras']),$rowEmpresa['moneda'],'centimos').'<br>';
$mesDesc = strftime("%d-%m-%Y", strtotime($row['fecha_venta']));
$html="
<body>
<table width='100%'>
<tr>

<td style='font-size: 8px;text-align:center'><img src='".$url."".$rowEmpresa["logo"]."' alt='Girl in a jacket' width='60' height='60'>
</td>
</tr>
</table>

<h2 style='font-size: 16px;text-align: center;margin: 0 0 5px 0;'>".$rowEmpresa["razon_social"]."</h2>
<div style='text-align:center;  font-size: 13px;' >
<span>".$rowEmpresa["direccion"]."</span><br>
<span>R.U.C: ".$rowEmpresa["ruc"]."</span><br>
<span>Email: ".$rowEmpresa["email"]."</span><br>
<span>".$row["nomalmacen"]."</span><br>
<span>".$row["ubicacion"]."</span>

<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<h2 style='font-size: 15px;text-align: center;margin: 0;'>".$row['Documento']."</h2>
<div style='text-align:center;  font-size: 13px;' >
<span>".$row['serie']." - ".$row['nro_comprobante']."</span>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />


<div style='text-align:left;  font-size: 13px;' >
<span>Fecha venta : ".$row['fecha_venta']." </span><br>
<span>Cliente : ".$row['cliente']."</span><br>
<span>Dirección : ".$row['direccion']."</span><br>
<span>Cajero : ".$row['empleado']."</span><br>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />

<table width='100%' style='margin: 0;border-bottom:1px solid;border-left:0px;border-right:0px;border-top:0px;'>
<thead>
<tr style='background-color: #CCCDCF;'>
<th width:'40%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Cant.</th>
<th width:'40%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Productos</th>
<th width:'30%' style='font-size: 14px; margin: 0;border-bottom:0px solid;border-left:0px;border-right:0px;border-top:0px;'>Importe</th>
</tr>
</thead>";
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

$html.="<tbody>
<tr>
<td  style='font-size: 14px; text-align:center'>".$rowtratamiento['cantidad']."</td>
<td  style='font-size: 14px; text-align:center'>".utf8_encode($rowtratamiento['descProducto'])."</td>
<td  style='font-size: 14px; text-align:center'>".$rowEmpresa["simbolom"]." ". $rowtratamiento['total_venta']."</td>
</tr>
</tbody>";
}
$html.="</table>";


if($row['deliverycomp']!=0 && $row['comisioncomp']!=0){
$html.="<div style='margin:8px'></div>
<div style='text-align:right; margin:0 15px 0 0'>
<span style=' font-size: 14px;'>SUB TOTAL:   &nbsp;&nbsp;  ".$rowEmpresa["simbolom"]." ".$row['subtotal']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>IGV 18%: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['igv']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>TOTAL: &nbsp;&nbsp; S/. ".number_format($totalTotal, 2, '.', ',')."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>COMISIÓN: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['comision']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>DELIVERY: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['delivery']."</span><div style='margin:3px'></div>
<b style=' font-size: 14px;'>TOTAL A PAGAR: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['total_venta']."</b></span><div style='margin:3px'></div>";
}else if($row['comisioncomp']!=0){
$html.="<div style='margin:8px'></div>
<div style='text-align:right; margin:0 15px 0 0'>
<span style=' font-size: 14px;'>SUB TOTAL:   &nbsp;&nbsp;  ".$rowEmpresa["simbolom"]." ".$row['subtotal']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>IGV 18%: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['igv']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>TOTAL: &nbsp;&nbsp; S/. ".number_format($totalTotal, 2, '.', ',')."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>COMISIÓN: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['comision']."</span><div style='margin:3px'></div>
<b style=' font-size: 14px;'>TOTAL A PAGAR: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['total_venta']."</b></span><div style='margin:3px'></div>";
}else if($row['deliverycomp']!=0){
$html.="<div style='margin:8px'></div>
<div style='text-align:right; margin:0 15px 0 0'>
<span style=' font-size: 14px;'>SUB TOTAL:   &nbsp;&nbsp;  ".$rowEmpresa["simbolom"]." ".$row['subtotal']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>IGV 18%: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['igv']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>TOTAL: &nbsp;&nbsp; ".$rowEmpresa["simbolom"]."  ".number_format($totalTotal, 2, '.', ',')."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>DELIVERY: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['delivery']."</span><div style='margin:3px'></div>
<b style=' font-size: 14px;'>TOTAL A PAGAR: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['total_venta']."</b></span><div style='margin:3px'></div>";
}else{
$html.="<div style='margin:8px'></div>
<div style='text-align:right; margin:0 15px 0 0'>
<span style=' font-size: 14px;'>SUB TOTAL:   &nbsp;&nbsp;  ".$rowEmpresa["simbolom"]." ".$row['subtotal']."</span><div style='margin:3px'></div>
<span style=' font-size: 14px;'>IGV 18%: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['igv']."</span><div style='margin:3px'></div>
<b style=' font-size: 14px;'>TOTAL: &nbsp;&nbsp;".$rowEmpresa["simbolom"]." ".$row['total_venta']."</b></span><div style='margin:3px'></div>";
}

$html.="</div><div style='margin:3px'></div>
<div style='text-align:center'>
<span style=' font-size: 11px;'><b>SON:</b> $numerosol</span>";
if($row['pago_efe'] != "0.00" && $row['tipo_pago']=="Transferencia"){
$html.="</div><hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<div style='text-align:center'>
<b style=' font-size: 13px;text-align:center'>METODO DE PAGO</b><br>
<b style='font-size: 13px; text-align: center;'>Mixto</b><br>
<b style='font-size: 13px; text-align: center;'>Efectivo : ".$rowEmpresa["simbolom"]." ".$row['pago_efe']."</b><br>
<b style='font-size: 13px; text-align: center;'>".$row['tipo_pago']." : ".$rowEmpresa["simbolom"]." ".$row['pago_tar']."</b><br>
<b style='font-size: 13px; text-align: center;'>Contacto : ".$row['contacto']."</b><br>
<b style='font-size: 13px; text-align: center;'>!Gracias por su preferencia¡</b><br><br>
<b style='font-size: 13px; text-align: center;'>!ESTE NO ES UN COMPROBANTE ELECTRONICO¡</b>
</div>";
}else if($row['pago_efe'] != "0.00" && $row['pago_tar'] !="0.00"){
$html.="</div><hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<div style='text-align:center'>
<b style=' font-size: 13px;text-align:center'>METODO DE PAGO</b><br>
<b style='font-size: 13px; text-align: center;'>Mixto</b><br>
<b style='font-size: 13px; text-align: center;'>Efectivo : ".$rowEmpresa["simbolom"]." ".$row['pago_efe']."</b><br>
<b style='font-size: 13px; text-align: center;'>".$row['tipo_pago']." : ".$rowEmpresa["simbolom"]." ".$row['pago_tar']."</b><br>
<b style='font-size: 13px; text-align: center;'>!Gracias por su preferencia¡</b><br><br>
<b style='font-size: 13px; text-align: center;'>!ESTE NO ES UN COMPROBANTE ELECTRONICO¡</b>
</div>";
}else if($row['tipo_pago']=="Transferencia"){
$html.="</div><hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<div style='text-align:center'>
<b style=' font-size: 13px;text-align:center'>METODO DE PAGO</b><br>
<b style='font-size: 13px; text-align: center;'>".$row['tipo_pago']."</b><br>
<b style='font-size: 13px; text-align: center;'>Contacto :".$row['contacto']."</b><br>
<b style='font-size: 13px; text-align: center;'>!Gracias por su preferencia¡</b><br><br>
<b style='font-size: 13px; text-align: center;'>!ESTE NO ES UN COMPROBANTE ELECTRONICO¡</b>
</div>";
}else{
$html.="</div><hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<div style='text-align:center'>
<b style=' font-size: 13px;text-align:center'>METODO DE PAGO</b><br>
<b style='font-size: 13px; text-align: center;'>".$row['tipo_pago']."</b><br>
<b style='font-size: 13px; text-align: center;'>!Gracias por su preferencia¡</b><br><br>
<b style='font-size: 13px; text-align: center;'>!ESTE NO ES UN COMPROBANTE ELECTRONICO¡</b>
</div>
</body>";
}
$Documento = $row['Documento'];
$serie = $row['serie'];
$nro_comprobante = $row['nro_comprobante'];
$filename = $serie.'_'.$nro_comprobante.'.pdf';
if($row['estado']==1){
$estado = true;
}else{
$estado= false;
}

if(preg_match('/Boleta.*/', $row['Documento'])){
$directorio = '../../libreporte/BOLETAS/';
}else{
$directorio = '../../libreporte/TICKET/';
}

}
}
//function mPDF($mode='',$format='format',$=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P')
//$mpdf = new \Mpdf\Mpdf(['mode' => ' utf-8', 'format' => [85, 250], 'default_font_size' => '', 'mgl' => 2 ,'mgr' => 2]);

			
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80,250],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->SetWatermarkText('ANULADO',1,20);
$mpdf->showWatermarkText = $estado;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.2;
$mpdf->SetTitle($Documento);
$mpdf->WriteHTML($html);

$mpdf->Output($filename,'I');
//$mpdf->Output($directorio.$filename,'F');