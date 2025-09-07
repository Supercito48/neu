<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../../conexion_reporte/r_conexion.php';
require_once '../../../models/rutas.php';

$url = Ruta::ctrRuta();

$consulta= 'CALL ReporteCaja('.$_GET['idCaja'].',"'.$_GET['fecha'].'")';

$resultado=$mysqli->query($consulta);

while($row=$resultado->fetch_assoc()){

$fecha = setlocale(LC_TIME, "spanish");				
$totalCajaDinero = $row['montoApertura'] + $row['TotalVentas'] +$row['TotalAbono'] + $row['Ingreso'] - $row['Egreso'];
$totalCajaVenta = $row['TotalVentas'] + $row['TotalVentasTarjeta'] + $row['TotalVentasTrans'] + $row['TotalVentasYape'] + $row['TotalVentasPlin'] + $row['TotalVentasCredito'];

$fechaapertura = strftime("%d-%m-%Y", strtotime($row['fecha_apertura']));
$html="
<body>
<table width='100%'>
<tr>
<td style='font-size: 8px;text-align:center'><img src='".$url."".$row["logo"]."' alt='Girl in a jacket' width='60' height='60'>
</td>
</tr>
</table>

<h2 style='font-size: 16px;text-align: center;margin: 0 0 5px 0;'>".$row["razon_social"]."</h2>
<div style='text-align:center;  font-size: 13px;' >
<span>".$row["direccion"]."</span><br>
<span>R.U.C: ".$row["ruc"]."</span><br>
<span>Email: ".$row["email"]."</span><br>
<span>".$row["descripcion"]."</span><br>
<span>".$row["ubicacion"]."</span>


<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<h2 style='font-size: 15px;text-align: center;margin: 0;'>REPORTE DE CAJA</h2>
<div style='text-align:center;  font-size: 13px;' >
<span> CAJA NRO: ".$row['nroCaja']."</span>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
</div>


<div style='text-align:left;  font-size: 13px;' >
<span>Fecha : ".$row['fecha_apertura']." </span><br>
<span>Cajero : ".$row['empleado']."</span><br>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
</div>
";

$html.="
<h2 style='font-size: 15px;text-align: center;margin: 0;'>== TOTAL GANANCIAS ==</h2><br>
<table width='100%'>
<tr>
<td style='font-size: 13px;text-align:left'>UTILIDADES: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalGanancias']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS TOTAL DÍA: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".number_format($totalCajaVenta, 2, '.', ',')."</td>
</tr>
</table><br>
<h2 style='font-size: 15px;text-align: center;margin: 0;'>== DINERO EN CAJA ==</h2><br>
<table width='100%'>
<tr>
<td style='font-size: 13px;text-align:left'>MONTO DE APERTURA: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['montoApertura']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS EN EFECTIVO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentas']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>ABONOS EN EFECTIVO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalAbono']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>INGRESO DE EFECTIVO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['Ingreso']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>EGRESO DE EFECTIVO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['Egreso']."</td>
</tr>
</table>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<table width='100%'>
<tr>
<td style='font-size: 13px;text-align:left'>EFECTIVO EN CAJA: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".number_format($totalCajaDinero, 2, '.', ',')."</td>
</tr>

</table>
<br>
<h2 style='font-size: 15px;text-align: center;margin: 0;'>== TOTAL VENTAS ==</h2><br>

<table width='100%'>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS EFECTIVO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentas']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS TARJETA: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentasTarjeta']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS DEPOSITO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentasTrans']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS YAPE: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentasYape']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS PLIN: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentasPlin']."</td>
</tr>
<tr>
<td style='font-size: 13px;text-align:left'>VENTAS CREDITO: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".$row['TotalVentasCredito']."</td>
</tr>
</table>
<hr style='height:1.5px;border:none;color:#333;background-color:#333;' />
<table width='100%'>
<tr>
<td style='font-size: 13px;text-align:left'>TOTAL VENTAS: </td>
<td style='font-size: 13px;text-align:Right '>".$row['simbolom']." ".number_format($totalCajaVenta, 2, '.', ',')."</td>
</tr>
</table>
</body>";
}

//function mPDF($mode='',$format='format',$=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P')
//$mpdf = new \Mpdf\Mpdf(['mode' => ' utf-8', 'format' => [85, 250], 'default_font_size' => '', 'mgl' => 2 ,'mgr' => 2]);

			
$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => [80,230],'margin_left' => 5,'margin_right' => 5,'margin_top' => 2,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]); 
$mpdf->SetTitle('Reporte caja');
$mpdf->WriteHTML($html);

$mpdf->Output('REPORTE_CAJA.pdf','I');
//$mpdf->Output($directorio.$filename,'F');