<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../../models/rutas.php';
$url = Ruta::ctrRuta();

$consultaEmpresa = "SELECT * FROM empresa where idEmpresa = 1";
$consulta= "SELECT c.nombres, 
date_format(pc.fecha , '%d-%m-%Y') fecha,
c.limite_credito  - c.credito_usado + pc.monto as adeudo_anterior,
pc.monto,
pc.metodo,
c.limite_credito  - c.credito_usado as saldo_pendiente 
FROM clientes c
INNER JOIN pago_credito pc
ON pc.idCliente = c.idCliente
where c.idCliente = ".$_GET['idCliente']."
order by idPagoc desc
limit 1";

$resultado=$mysqli->query($consulta);
$resultadoEmpresa=$mysqli->query($consultaEmpresa);
while($rowEmpresa=$resultadoEmpresa->fetch_assoc()){
while($row=$resultado->fetch_assoc()){
$fecha = setlocale(LC_TIME, "spanish");					    
$mesDesc = strftime("%d de %B de %Y", strtotime($row['fecha']));

$html="
<table width='100%'>
<tr>

<td style='font-size: 8px;text-align:center'><img src='".$url."".$rowEmpresa["logo"]."' alt='Girl in a jacket' width='60' height='60'>
</td>
</tr>
</table>

<h2 style='font-size: 20px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>RECIBO DE ABONO</h2>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'> * ".$row['nombres']." * </h4>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>$mesDesc</h4>

<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 10px 0' />


<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>ADEUDO ANTERIOR: </td>
<td style='font-size: 11px;text-align:Right '>".$rowEmpresa["simbolom"]." ".$row['adeudo_anterior']."</td>
</tr>
<tr>
<td style='font-size: 11px;text-align:left'>SALDO ABONO: </td>
<td style='font-size: 11px;text-align:Right '> - ".$rowEmpresa["simbolom"]." ".$row['monto']."</td>
</tr>
<tr>
<td></td>
</tr>
</table>



<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 13px 0' />
<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>SALDO PENDIENTE: </td>
<td style='font-size: 11px;text-align:Right '>".$rowEmpresa["simbolom"]." ".$row['saldo_pendiente']."</td>
</tr>
<tr>
<td></td>
</tr>
</table>

<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 13px 0' />
<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>METODO DE PAGO: </td>
<td style='font-size: 11px;text-align:Right '>".$row['metodo']."</td>
</tr>
</table>
</div>
";
}
}
//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L']);
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80, 83],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->WriteHTML($html);
$mpdf->Output();