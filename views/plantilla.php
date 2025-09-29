<?php
session_set_cookie_params(24 * 60 * 60);

session_start();

$url = Ruta::ctrRuta();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POS System</title>

    <!-- =============================================
  =           CSS         =
  ============================================= -->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/daterangepicker/daterangepicker.css">
    <!-- Jquery CSS -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/jquery-ui/css/jquery-ui.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo $url; ?>views/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo $url; ?>views/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/dist/css/adminlte.min.css">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/ekko-lightbox/ekko-lightbox.css">



    <link rel="stylesheet" href="<?php echo $url; ?>views/plugins/printjs/print.min.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->

    <!-- =============================================
  =           PLUGINS JAVASCRIPT           =
  ============================================= -->

    <!-- jQuery -->
    <script src="<?php echo $url; ?>views/plugins/jquery/jquery.min.js"></script>

    <!-- Ekko Lightbox -->
    <script src="<?php echo $url; ?>views/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="<?php echo $url; ?>views/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo $url; ?>views/plugins/moment/moment.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- jquery UI -->
    <script src="<?php echo $url; ?>views/plugins/jquery-ui/js/jquery-ui.js"></script>
    <!-- date-range-picker -->
    <script src="<?php echo $url; ?>views/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo $url; ?>views/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>

    <link href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <script src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script>

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>



    <!-- Select2 -->
    <script src="<?php echo $url; ?>views/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo $url; ?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?php echo $url; ?>views/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo $url; ?>views/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script src="<?php echo $url; ?>views/plugins/printjs/print.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.2.0/js/buttons.html5.styles.templates.min.js">
    </script>

    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
-->
</head>

<!-- =============================================
  =           CUERPO DOCUMENTO           =
  ============================================= -->

<!-- =============================================
        LLAAMAREMOS AL HEADER Y A LOS DEMAS MODULOS PARA INSTANCIARLO
        ============================================= -->
<input type="hidden" id="entrada" value="20:00">
<input type="hidden" id="salida" value="23:00">
<input type="hidden" id="rutaOculta" value="<?php echo $url; ?>">



<?php
if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == true) {

  echo '<body class="layout-fixed hold-transition sidebar-mini sidebar-collapse">

                <div class="wrapper">';

  include "modules/general/header.php";
  include "modules/general/menu.php";

  $ruta = array();


  if (isset($_GET["ruta"])) {

    $caja = "caja";
    $productos = "productos";
    $administracion = "administracion";
    $compras = "compras";
    $cotizacion = "cotizacion";
    $ventas = "ventas";


    $ruta = explode("/", $_GET["ruta"]);

    if (
      $ruta[0] == "inicio" ||
      $ruta[0] == "salir" ||
      $ruta[0] == "informacion" ||
      $ruta[0] == "configuracion" ||
      $ruta[0] == "perfil" ||
      $ruta[0] == "actas"

    ) {

      include "modules/" . $ruta[0] . ".php";
    } elseif (
      $ruta[0] == "almacen" ||
      $ruta[0] == "proveedores" ||
      $ruta[0] == "empleados" ||
      $ruta[0] == "clientes" ||
      $ruta[0] == "estadocuenta" ||
      $ruta[0] == "usuarios"
    ) {

      include "modules/" . $administracion . "/" . $ruta[0] . ".php";
    } elseif (
      $ruta[0] == "categoria" ||
      $ruta[0] == "producto" ||
      $ruta[0] == "productobajo" ||
      $ruta[0] == "inventario" ||
      $ruta[0] == "kardex"||
      $ruta[0] == "kardexdeposito"||
      $ruta[0] == "deposito"
    ) {

      include "modules/" . $productos . "/" . $ruta[0] . ".php";
    }  elseif (
      $ruta[0] == "compras" ||
      $ruta[0] == "vercompras" 
    ) {

      include "modules/" . $compras . "/" . $ruta[0] . ".php";
    }elseif (
      $ruta[0] == "cotizacion" ||
      $ruta[0] == "vercotizacion" 
    ) {

      include "modules/" . $cotizacion . "/" . $ruta[0] . ".php";
    }elseif(
      $ruta[0] == "ventas" ||
      $ruta[0] == "verventas" ||
      $ruta[0] == "comprobante"
      ){
      include "modules/" . $ventas . "/" . $ruta[0] . ".php";
    }  elseif ($ruta[0] == "caja") {

      include "modules/" . $caja . "/" . $ruta[0] . ".php";
    }else{

      include "modules/404.php";
      
    }
  } else {
    include "modules/inicio.php";
  }
  include "modules/general/footer.php";
  echo ' </div>
       

        <script src="' . $url . 'views/js/plantilla.js"></script>
        <script src="' . $url . 'views/js/dashboard.js"></script>

        </body>';
} else {

  include "modules/login.php";
}

?>
<!-- Bootstrap 4 -->
<script src="<?php echo $url; ?>views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $url; ?>views/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $url; ?>views/dist/js/demo.js"></script>


</html>