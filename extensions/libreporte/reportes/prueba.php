<?php 

include "../vendor/mpdf/mpdf.php";


function getPlantilla(){

    require_once __DIR__ . '/../vendor/autoload.php';
    require_once '../../conexion_reporte/r_conexion.php';

$consulta= "SELECT  
fecha_cita, 
hora_cita,
se.descServicio,
co.nombreConejo,
co.nombreDueno,
co.celular,
c.cita_descripcion
FROM cita c 
INNER JOIN conejo co ON c.idConejo = co.idConejo 
INNER JOIN servicios se ON C.idServicio = se.idServicio
where c.idCita=1";

$resultado=$mysqli->query($consulta);
while($row=$resultado->fetch_assoc()){}
$plantilla='<body>
        <table class="tablareceipt">
            <tbody>
                <tr>
                    <td>
                        <p>Zanahoria S.A.C.</p>
                        <img class="logofactura"  src="../../../views/img/logo.png">
                        <p style="text-transform: none !important;">Av Leticia 616</p>
                        <p style="text-transform: none !important;"><img src="../../../views/img/telephone.png" style="width: 12px;" /> 946683827</p>
                        <p style="text-transform: none !important;"><img src="../../../views/img/email.png" style="width: 12px;" /> Email: Juan.1996.jb65@gmail.com</p>
                    </td>
                    <td class="datoruc">
                        <p>R.U.C. 123123</p>                    
                        <p>ASDASD</p>
                        <p>ASD</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="tabladatos" >
            <tbody>
                <tr>
                    <td class="tdatoslabel">
                        <div style="padding-bottom: 10px; padding-right: 19px;">
                            <span style="float: left;">Nombre Cliente:</span>
                            
                            <div style="margin-left: 105px; border-bottom: solid 1px #000;">Cliente</div>
                        </div>
                    </td>
                    <td class="tdatoslabel tdatodlabeldos">
                        <div>
                            <span style="float: left;">Fecha de Emisión:</span>
                            <div style="margin-left: 118px; border-bottom: solid 1px #000;">12/12/12</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="tdatoslabel">
                        <div style="padding-bottom: 10px; padding-right: 19px;">
                            <span style="float: left;">DNI:</span>
                            <div style="margin-left: 105px; border-bottom: solid 1px #000;"> 757676575 </div>
                        </div>
                    </td>
                    <td class="tdatoslabel tdatodlabeldos">
                        <div>
                            <span style="float: left;">Moneda: </span>
                            <div style="margin-left: 118px; border-bottom: solid 1px #000;">SOLES</div>
                        </div>
                    </td>
                </tr>
                JR PRUEBA.COM
            </tbody>
        </table>
        <h2>hola</h2>
        <div class="tablageneral">        
            <table cellpadding="0" cellspacing="0">
           
                <tbody>
                    <tr class="titulotable">
                        <td style="text-align: center">Descripción</td>
                        <td class="cantidadtabla" style="text-align: center">Cantidad</td>
                        <td class="preciotabla" style="text-align: center">Precio Unitario</td>
                        <td class="preciotabla" style="text-align: center">Sub Total</td>
                        <td class="preciotabla ulttable" style="text-align: center">Valor de venta</td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
        <h2>hola</h2>
        <div class="tablageneral tablacostos tablaboleta">        
            <table cellpadding="0" cellspacing="0">
                <tbody>   
                    <tr class="detalletable">                                                                
                        <td colspan="2" rowspan="3" style="vertical-align: top">
                            <div>SON: DOLARES</div>
                            <hr/><br/>
                            <div>obs</div>
                        </td>
                        <td class="preciotabla fintabla fintabla fintablados"><b>SUB TOTAL</b></td>
                        <td class="preciotabla ulttable fintabla" style="text-align:right">S/. 10.00</td>
                    </tr>  
                    <tr class="detalletable">                                                                
                     
                        <td class="preciotabla fintabla fintabla fintablados"><b>IGV</b></td>
                        <td class="preciotabla ulttable fintabla" style="text-align:right">S/. 10.00</td>
                    </tr>  
                    <tr class="detalletable">                                                                
                       
                        <td class="preciotabla fintabla fintabla fintablados"><b>TOTAL</b></td>
                        <td class="preciotabla ulttable fintabla" style="text-align:right">S/. 10.00</td>
                    </tr>  
                </tbody>
            </table>        
        </div>

        <table cellpadding="0" cellspacing="0" class="tablacan">
            <tbody>
                <tr>    
                    <td style="text-align: center;">
                        <img style="width: 124px; margin-bottom: 11px;" src="{QR}" />
                    </td>                    
                    <td>
                        <div>Representación impresa de la FACTURA Electrónica.
                            <br /> 
                            <span style="font-size: 10px; display: none">LINK</span>
                        </div>
                        HASH
                    </td>
                </tr>   
            </tbody>
        </table>
        
        <table cellpadding="0" cellspacing="0" class="tablacan">
            <tbody>
                <tr>    
                    <td style="font-size: 10px">
                       Caja
                    </td>                    
                </tr>   
            </tbody>
        </table>
    </body>';

return $plantilla;

}