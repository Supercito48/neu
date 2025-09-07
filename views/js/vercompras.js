var tablaVerCompra;

var totalCompra2 = 0.00;
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
document.getElementById('compras_desde').value = y + "-" + m + "-" + d;
document.getElementById('compras_hasta').value = y + "-" + m + "-" + d;

compras_desde = $("#compras_desde").val();
compras_hasta = $("#compras_hasta").val();
        
cargarTotalCompra();
// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaVerCompra = $(".tablaVerCompra").DataTable({
  "responsive": true,
  "lengthChange": false,
  "autoWidth": false,
  "responsive": true,
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },

  ajax: {
    url: "ajax/tablas/tablaCompras.ajax.php",
    dataSrc: "",
    data: {
      'fechaDesde': compras_desde,
      'fechaHasta': compras_hasta //1: LISTAR PRODUCTOS
    },
  },
  columns: [{
      data: "idCompra"
    },
    {
      data: "idDocalmacen"
    },
    {
      data: "serie"
    },
    {
      data: "num_documento"
    },
    {
      data: "nombre"
    },
    {
      data: "empleado"
    },
    {
      data: "tipo_pago"
    },
    {
      data: "total_compra"
    },{
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


$(document).on('click', '.verCompras', function() {

 
    var idCompra = $(this).attr("idCompra");
    //var data = tablaVerCompra.row($(this).parents('tr')).data();
  
    //var idCompra = data["idCompra"];
  
    var ajaxVerCompra = "ajaxVerCompra";
  
    var datos = new FormData();
    datos.append("idCompra", idCompra);
    datos.append("ajaxVerCompra", ajaxVerCompra);
  
    $.ajax({
  
      url: "ajax/compras.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        //respuesta[0][prueba] si es fetchall sera asi si no lo contrario
        console.log(respuesta)
        $("#idCompra").val(respuesta["idCompra"]);
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
  
       
      
        $("#idProveedor").html(respuesta["nombre"]);
        $("#idUsuario").html(respuesta["empleado"]);
        
        $("#idDocalmacen").html(respuesta["idDocalmacen"]);
        $("#serie").html(respuesta["serie"]);
        $("#num_documento").html(respuesta["num_documento"]);
        $("#subtotal").val(simbolom + parseFloat(respuesta["subtotal"]).toFixed(2));
        $("#igv").val(simbolom + parseFloat(respuesta["igv"]).toFixed(2));
  
  
        $("#total").val(simbolom + parseFloat(respuesta["total_compra"]).toFixed(2));
  
        $('#modal_vista').on('shown.bs.modal', function (e) {
  
  
          var idCompras = $("#idCompra").val();
          // Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
          tablaVerDetalleCompra = $(".pruebadata").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
  
            'ajax': {
              'url': "ajax/compras.ajax.php",
              'data': {
                'idCompra': idCompras,
                'ajaxVerDetalleCompra': 'ajaxVerDetalleCompra'
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
                data: "idCompra"
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
                data: "precio_compra"
              },
              {
                data: "total_compra"
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
        })
  
       
      },
  
  
    });
  
  
  });
  
  $(document).on('click','.pdf',function(){
    
  
  
      window.open("extensions/tcpdf/pdf/historia.php","Ticket","scrollbars=NO");
  
    
  
  })

function cargarTotalCompra() {

    if($("#compras_desde").val() == ''){
      compras_desde = '01/10/2000';
    }else{
        compras_desde = $("#compras_desde").val();
    }
  
    if($("#compras_hasta").val() == ''){
        compras_hasta = '10/10/9999';
    }else{
        compras_hasta = $("#compras_hasta").val();
    }
  
    compras_desde = $("#compras_desde").val();
    compras_hasta = $("#compras_hasta").val();
    $.ajax({
      async: false,
      url:  "ajax/compras.ajax.php",
      method: "POST",
      data: {
        'ajaxTotalCompra': 'ajaxTotalCompra',
        'fechaDesde': compras_desde,
        'fechaHasta': compras_hasta //1: LISTAR PRODUCTOS
      },
      dataType: 'json',
      success: function (respuesta) {
  
        console.log(respuesta);
        
        $("#totalCompra2").html(parseFloat(respuesta[0]).toFixed(2));
  
      }
    });
  }
  
  $("#btnQFiltro").on('click',function(){
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
    document.getElementById('compras_desde').value = y + "-" + m + "-" + d;
    document.getElementById('compras_hasta').value = y + "-" + m + "-" + d;
    
    compras_desde = $("#compras_desde").val();
    compras_hasta = $("#compras_hasta").val();

    tablaVerCompra = $(".tablaVerCompra").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "responsive": true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: "ajax/tablas/tablaCompras.ajax.php",
          dataSrc: "",
          data: {
            'fechaDesde': compras_desde,
            'fechaHasta': compras_hasta //1: LISTAR PRODUCTOS
          },
        },
        columns: [{
            data: "idCompra"
          },
          {
            data: "idDocalmacen"
          },
          {
            data: "serie"
          },
          {
            data: "num_documento"
          },
          {
            data: "nombre"
          },
          {
            data: "empleado"
          },
          {
            data: "tipo_pago"
          },
          {
            data: "total_compra"
          },{
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
      cargarTotalCompra();
  })

$("#btnFiltrar").on('click',function(){

  tablaVerCompra.destroy();

  if($("#compras_desde").val() == ''){
    compras_desde = '01/10/2000';
  }else{
      compras_desde = $("#compras_desde").val();
  }

  if($("#compras_hasta").val() == ''){
      compras_hasta = '10/10/9999';
  }else{
      compras_hasta = $("#compras_hasta").val();
  }

  compras_desde = $("#compras_desde").val();
  compras_hasta = $("#compras_hasta").val();

  tablaVerCompra = $(".tablaVerCompra").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "responsive": true,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
  
    ajax: {
      url: "ajax/tablas/tablaCompras.ajax.php",
      dataSrc: "",
      data: {
        'fechaDesde': compras_desde,
        'fechaHasta': compras_hasta //1: LISTAR PRODUCTOS
      },
    },
    columns: [{
        data: "idCompra"
      },
      {
        data: "idDocalmacen"
      },
      {
        data: "serie"
      },
      {
        data: "num_documento"
      },
      {
        data: "nombre"
      },
      {
        data: "empleado"
      },
      {
        data: "tipo_pago"
      },
      {
        data: "total_compra"
      },{
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
  cargarTotalCompra();

})

$(".content").keypress(function(event) {
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
      $("#btnFiltrar").click();   
  }
});   


$(document).on("click", ".btnAnularCompra", function () {
    var idCompra = $(this).attr("idCompra");
   
    Swal.fire({
      title: '¿Está seguro de Anular la compra?',
      text: "¡Si no lo está puede cancelar la acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, anular!'
    }).then((result) => {
      if (result.isConfirmed) {
  
        $.ajax({
          url:  "ajax/compras.ajax.php",
          type: "POST",
          data: {'ajaxAnularCompra' : 'ajaxAnularCompra','idCompra':idCompra},
          dataType: 'json',
          success:function(respuesta){
    
              Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: respuesta[0],
                      showConfirmButton: false,
                      timer: 1500
                  })
    
              tablaVerCompra.ajax.reload();
              cargarTotalCompra();
           
  
          }
      })
  
      }
     
    })
   
   
  });


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