var tablaVerVenta;

var tablaVerDetalleVenta;
var totalVenta = 0.00;
var rutaOculta = $("#rutaOculta").val();
var simbolom = $("#simbolom").val();

var n = new Date();
var y= n.getFullYear();
var m= n.getMonth()+1;
var d= n.getDate();
if(d<10){
    d='0' + d;
}
if(m<10){
    m='0' + m;
}
document.getElementById('ventas_desde').value = y + "-" + m + "-" + d;
document.getElementById('ventas_hasta').value = y + "-" + m + "-" + d;

idAlmacen = $("#idAlmacen").val();
ventas_desde = $("#ventas_desde").val();
ventas_hasta = $("#ventas_hasta").val();
        
cargarTotalVenta();

tablaVerVenta = $(".tablaVerVenta").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    "responsive": true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
  
    ajax: {
      url: rutaOculta+"ajax/tablas/tablaVentas.ajax.php",
      dataSrc: "",
      data: {
        'idAlmacen' : idAlmacen,
        'fechaDesde': ventas_desde,
        'fechaHasta': ventas_hasta //1: LISTAR PRODUCTOS
      },
    },
    columns: [{
        data: "idVenta"
      },
      {
        data: "Documento"
      },
      {
        data: "serie"
      },
      {
        data: "nro_comprobante"
      },
      {
        data: "empleado"
      },
      {
        data: "tipo_pago"
      },
      {
        data: "total_venta"
      },
      {
        data: "estado"
      },
      {
        data: "fecha_venta"
      }, 
      {
        data: "acciones"
      },
    ],
    
  
    bDestroy: true,
    iDisplayLength: 10,
  });

 

  function cargarTotalVenta() {

    if($("#ventas_desde").val() == ''){
      ventas_desde = '01/10/2000';
    }else{
        ventas_desde = $("#ventas_desde").val();
    }
  
    if($("#ventas_hasta").val() == ''){
        ventas_hasta = '10/10/9999';
    }else{
        ventas_hasta = $("#ventas_hasta").val();
    }

    idAlmacen = $("#idAlmacen").val();
  
    ventas_desde = $("#ventas_desde").val();
    ventas_hasta = $("#ventas_hasta").val();
    $.ajax({
      async: false,
      url:  rutaOculta+"ajax/ventas.ajax.php",
      method: "POST",
      data: {
        'ajaxTotalVenta': 'ajaxTotalVenta',
        'idAlmacen' : idAlmacen,
        'fechaDesde': ventas_desde,
        'fechaHasta': ventas_hasta //1: LISTAR PRODUCTOS
      },
      dataType: 'json',
      success: function (respuesta) {
  
        console.log(respuesta);
        
        $("#totalVentas").html(parseFloat(respuesta[0]).toFixed(2));
  
      }
    });
  }

  
$("#btnFiltrar").on('click',function(){

    tablaVerVenta.destroy();
  
    if($("#ventas_desde").val() == ''){
        ventas_desde = '01/10/2000';
    }else{
        ventas_desde = $("#ventas_desde").val();
    }
    
    if($("#ventas_hasta").val() == ''){
        ventas_hasta = '10/10/9999';
    }else{
        ventas_hasta = $("#ventas_hasta").val();
    }
  
    idAlmacen = $("#idAlmacen").val();
    ventas_desde = $("#ventas_desde").val();
    ventas_hasta = $("#ventas_hasta").val();
  
    tablaVerVenta = $(".tablaVerVenta").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaVentas.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : idAlmacen,
            'fechaDesde': ventas_desde,
            'fechaHasta': ventas_hasta //1: LISTAR PRODUCTOS
          },
        },
        columns: [{
            data: "idVenta"
          },
          {
            data: "Documento"
          },
          {
            data: "serie"
          },
          {
            data: "nro_comprobante"
          },
          {
            data: "empleado"
          },
          {
            data: "tipo_pago"
          },
          {
            data: "total_venta"
          },
          {
            data: "estado"
          },
          {
            data: "fecha_venta"
          }, 
          {
            data: "acciones"
          },
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
      cargarTotalVenta();
  
  })

  $("#btnQFiltro").on('click',function(){

    tablaVerVenta.destroy();
    var n = new Date();
    var y= n.getFullYear();
    var m= n.getMonth()+1;
    var d= n.getDate();
    if(d<10){
        d='0' + d;
    }
    if(m<10){
        m='0' + m;
    }
    document.getElementById('ventas_desde').value = y + "-" + m + "-" + d;
    document.getElementById('ventas_hasta').value = y + "-" + m + "-" + d;

    idAlmacen = $("#idAlmacen").val();
    ventas_desde = $("#ventas_desde").val();
    ventas_hasta = $("#ventas_hasta").val();

   
    tablaVerVenta = $(".tablaVerVenta").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaVentas.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : idAlmacen,
            'fechaDesde': ventas_desde,
            'fechaHasta': ventas_hasta //1: LISTAR PRODUCTOS
          },
        },
        columns: [{
            data: "idVenta"
          },
          {
            data: "Documento"
          },
          {
            data: "serie"
          },
          {
            data: "nro_comprobante"
          },
          {
            data: "empleado"
          },
          {
            data: "tipo_pago"
          },
          {
            data: "total_venta"
          },
          {
            data: "estado"
          },
          {
            data: "fecha_venta"
          }, 
          {
            data: "acciones"
          },
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
      cargarTotalVenta();
  })

  $(".content").keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $("#btnFiltrar").click();   
    }
  });   

  

$(document).on('click', '.verVentas', function() {
   
    var idVenta = $(this).attr("idVenta");

    var ajaxVerVenta = "ajaxVerVenta";
  
    var datos = new FormData();
    datos.append("idVenta", idVenta);
    datos.append("ajaxVerVenta", ajaxVerVenta);
  
    $.ajax({
  
      url: rutaOculta+"ajax/ventas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        //respuesta[0][prueba] si es fetchall sera asi si no lo contrario
     
        console.log(respuesta)
        $("#idVenta").val(respuesta["idVenta"]);
        $("#fecha_registro").html(respuesta["fecha_venta"]);
  
        if(respuesta["estado"]==1){
          $("#header-modal").removeClass("card-success");
          $("#header-modal").addClass("card-danger");
          $("#titulo").text(" - Anulado");
        }else{
          $("#header-modal").removeClass("card-danger");
          $("#header-modal").addClass("card-success");
          $("#titulo").text("");
        }
  
       
        $("#idUsuario").html(respuesta["empleado"]);
        
        $("#Documento").html(respuesta["Documento"]);
        $("#serie").html(respuesta["serie"]);
        $("#nro_comprobante").html(respuesta["nro_comprobante"]);
        $("#subtotal").val(simbolom + parseFloat(respuesta["subtotal"]).toFixed(2));
        $("#igv").val(simbolom + parseFloat(respuesta["igv"]).toFixed(2));
  
  
        $("#total").val(simbolom + parseFloat(respuesta["total_venta"]).toFixed(2));
        
        //$('#modal_vista').on('shown.bs.modal', function () {
   
            var idVenta = $("#idVenta").val();

            // Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
            tablaVerDetalleVenta = $(".pruebadata").DataTable({
              
              "lengthChange": false,
              "autoWidth": false,
              "responsive": false,
              "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
              },
    
              'ajax': {
                'url': rutaOculta+"ajax/ventas.ajax.php",
                'data': {
                  'idVenta': idVenta,
                  'ajaxVerDetalleVenta': 'ajaxVerDetalleVenta'
                },
                'type': 'post',
                'dataSrc': ''
              },
              rowCallback:function(row,data)
              {
               
                $($(row).find("td")[2]).css("text-align","center");
                $($(row).find("td")[2]).css("font-weight","bold");
    
                $($(row).find("td")[4]).css("font-weight","bold");
           
              },
              columns: [
                {
                  data: "idVenta"
                },
                {
                  data: "codigo_producto"
                },
                {
                  data: "descProducto"
                },
                {
                  data: "cantidad"
                },
                {
                  data: "precio_venta"
                },
                {
                  data: "total_venta"
                }
              ],
              columnDefs: [
                {
                  targets: 0,
                  visible: false
                }
              ],
    
    
              bDestroy: true,
              iDisplayLength: 10,
              "bPaginate": false,
              "bFilter": false,
              "bInfo": false
            });
         // })
  
       
      },
  
  
    });
  
  
  });

  
$(document).on("click", ".btnAnularVenta", function () {
    var idVenta = $(this).attr("idVenta");
   
    Swal.fire({
      title: '¿Está seguro de Anular la venta?',
      text: "¡Si no lo está puede cancelar la acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, anular!'
    }).then((result) => {
      if (result.isConfirmed) {
  
        $.ajax({
          url:   rutaOculta+"ajax/ventas.ajax.php",
          type: "POST",
          data: {'ajaxAnularVenta' : 'ajaxAnularVenta','idVenta':idVenta},
          dataType: 'json',
          success:function(respuesta){
    
              Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: respuesta[0],
                      showConfirmButton: false,
                      timer: 1500
                  })
    
              tablaVerVenta.ajax.reload();
              cargarTotalVenta();
              traerNotificacionBajoInv();
  
          }
      })
  
      }
     
    })
   
   
  });

  $(document).on("click", ".pdf", function () {
    var idventa = $(this).attr("idventa");

   
    //printJS(rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idVenta="+idventa)
    window.open(
      rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idVenta=" +
      idventa +
      "#zoom=100%",
      "Ticket",
      "scrollbars=NO"
    );
    
  });

  $(document).on("click", ".imprimira4", function () {
    var idventa = $(this).attr("idventa");

   
    //printJS(rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idVenta="+idventa)
    window.open(
      rutaOculta+"/extensions/libreporte/reportes/generar_prueba.php?idVenta=" +
      idventa +
      "#zoom=100%",
      "Ticket",
      "scrollbars=NO"
    );
    
  });

  