<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../../models/rutas.php';
$url = Ruta::ctrRuta();

$consultaEmpresa = "SELECT * FROM empresa where idEmpresa = 1";
$consulta= "SELECT c.nombres,
date_format(SYSDATE() , '%d-%m-%Y') fecha,
c.limite_credito  - c.credito_usado as saldo_pendiente 
FROM clientes c
INNER JOIN pago_credito pc
ON pc.idCliente = c.idCliente
where c.idCliente = ".$_GET['idCliente']."
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
<br>
<h2 style='font-size: 20px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>ESTADO DE CUENTA</h2>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'> * ".$row['nombres']." * </h4>
<h4 style='font-size: 13px;text-align: center;margin: 0 0 5px 0;border-radius: 5px;'>$mesDesc</h4>

<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 10px 0' />";
$consultatratamiento= "SELECT descripcion, montod
FROM bitacora_credito
WHERE estado = 1
AND idCliente = '".$_GET['idCliente']."'";
$resultadotratamiento=$mysqli->query($consultatratamiento);
$contadortratamiento=0;
while($rowtratamiento=$resultadotratamiento->fetch_assoc()){

$html.="<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>".$rowtratamiento['descripcion']."  </td>
<td style='font-size: 11px;text-align:Right '>".$rowEmpresa["simbolom"]." ".$rowtratamiento['montod']."</td>

</tr>

<tr>
<td></td>
</tr>
</table>";

}


$html.="<hr style='height:1.5px;border:none;color:#333;background-color:#333; margin: 0 0 13px 0' />
<table width='100%'>
<tr>
<td style='font-size: 11px;text-align:left'>SALDO PENDIENTE: </td>
<td style='font-size: 11px;text-align:Right '>".$rowEmpresa["simbolom"]." ".$row['saldo_pendiente']."</td>
</tr>
<tr>
<td></td>
</tr>
</table>


</div>
";
}
}
//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter-L']);
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80, 90],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->WriteHTML($html);
$mpdf->Output();