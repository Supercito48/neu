cargarSelectAlmacen();
var idAlmacenSelect = $("#idAlmacenSelect").val();
var rutaOculta = $("#rutaOculta").val();
var idAlmacenBajo = $("#idAlmacenBajo").val();

cargarDatostotales(idAlmacenSelect);
cargarDatosCero(idAlmacenSelect);
cargarDatosMasVendido(idAlmacenSelect);
traerNotificacionBajoInv();
traerTablaProductoB();
$.ajax({
  url: rutaOculta+"ajax/dashboard.ajax.php",
  method: "POST",
  data: {
    ajaxTotalProductos: "ajaxTotalProductos",
  },
  dataType: "json",
  success: function (respuesta) {
    $("#totalProductos").html(respuesta["TotalProductos"]);
  },
});

$.ajax({
  url: rutaOculta+ "ajax/dashboard.ajax.php",
  method: "POST",
  data: {
    ajaxTotalConejos: "ajaxTotalConejos",
  },
  dataType: "json",
  success: function (respuesta) {
    $("#totalConejos").html(respuesta["TotalConejos"]);
  },
});

$.ajax({
  url: rutaOculta+"ajax/dashboard.ajax.php",
  method: "POST",
  data: {
    ajaxTotalEmpleado: "ajaxTotalEmpleado",
  },
  dataType: "json",
  success: function (respuesta) {
    $("#totalEmpleado").html(respuesta["TotalEmpleado"]);
  },
});

$.ajax({
  url: rutaOculta+"ajax/dashboard.ajax.php",
  method: "POST",
  data: {
    ajaxTotalAlmacen: "ajaxTotalAlmacen",
  },
  dataType: "json",
  success: function (respuesta) {
    $("#totalAlmacen").html(respuesta["TotalAlmacen"]);
  },
});

$(document).on("change", "#idAlmacenSelect", function () {
  var idAlmacenSelect = $(this).val();
  cargarDatostotales(idAlmacenSelect);
  cargarDatosCero(idAlmacenSelect) ;
  cargarDatosMasVendido(idAlmacenSelect);
});

function cargarDatostotales(idAlmacenSelect) {
  $.ajax({
    async: false,
    url: rutaOculta+"ajax/dashboard.ajax.php",
    method: "POST",
    data: {
      ajaxTotalVCP: "ajaxTotalVCP",
      idAlmacen: idAlmacenSelect,
    },
    dataType: "json",
    success: function (respuesta) {
      $("#totalVentasMesAD").html(respuesta["TotalVentaMes"]);
      $("#totalVentasDiaAD").html(respuesta["TotalVentaDia"]);
      $("#totalCitasAD").html(respuesta["totalCita"]);
      $("#totalRecepcionAD").html(respuesta["totalRecepcion"]);
    },
  });
}

function cargarDatosCero(idAlmacenSelect) {

  tbl_productos_poco_stock = $("#tbl_productos_poco_stock").DataTable({
    
   
  "lengthChange": false,
  "autoWidth": false,
  "responsive": true,
 
              "bFilter": false,
              "bInfo": false,
   
    ajax: {
      url: rutaOculta+"ajax/producto.ajax.php",
      dataSrc: "",
      type: "POST",
      data: {
        ajaxMostrarBajosInvD: "ajaxMostrarBajosInvD",
        idAlmacen: idAlmacenSelect,
      },
    },
   

    columnDefs: [
     
      {
        targets: 0,
        visible: false,
      
      },
      
    ],

  

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    bDestroy: true,
     iDisplayLength: 5
  });
}

function cargarDatosMasVendido(idAlmacenSelect) {

 
  tbl_productos_mas_vendidos = $("#tbl_productos_mas_vendidos").DataTable({
    
   
  "lengthChange": false,
  "autoWidth": false,
  "responsive": true,
  
              "bFilter": false,
              "bInfo": false,
   
    ajax: {
      url: rutaOculta+"ajax/producto.ajax.php",
      dataSrc: "",
      type: "POST",
      data: {
        ajaxMostrarMasVendido: "ajaxMostrarMasVendido",
        idAlmacen: idAlmacenSelect,
      },
    },
   


    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    bDestroy: true,
    iDisplayLength: 5
  });


}

function cargarSelectAlmacen() {
  $.ajax({
    async: false,
    url:"ajax/almacen.ajax.php",
    method: "POST",
    data: {
      ajaxAlmacenS: "ajaxAlmacenS",
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta[0]["estado"]);
      var options = '<option selected value="">Seleccione Almacen</option>';
      for (let index = 0; index < respuesta.length; index++) {
        if (respuesta[index][2].match(/defectuoso.*/)) {
        } else {
          options =
            options +
            "<option value=" +
            respuesta[index][0] +
            ">" +
            respuesta[index][2] +
            "</option>";
        }
      }
      $("#idAlmacenSelect").html(options);
      $("#idAlmacen_editar").html(options);
    },
  });
}
//setInterval(traerNotificacionBajoInv, 1000)
//
function traerNotificacionBajoInv() {
  $.ajax({
    url: rutaOculta+ "ajax/producto.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarBajosInv: "ajaxMostrarBajosInv",
      idAlmacen: idAlmacenBajo,
    },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta["cantidadprom"] == 0) {
        //document.getElementById('contado_noti').innerHTML = "";
        $("#contado_noti").html("");
        $("#contado_noti2").html("Nigun ");
      } else {
        //document.getElementById('contado_noti').innerHTML = respuesta["cantidadprom"];
        $("#contado_noti").html(respuesta["cantidadprom"]);
        $("#contado_noti2").html(respuesta["cantidadprom"]);
      }

      console.log(respuesta["cantidadprom"]);
    },
  });
}

function traerTablaProductoB() {
  tablaProductoBajo = $("#tablaProductoBajo").DataTable({
    
   
  "lengthChange": false,
  "autoWidth": false,
  "responsive": true,
    dom: "Bfrtip",
    buttons: [
      {
        text: 'Exportar a Excel   &nbsp; <i class="fas fa-file-excel"></i>',
        extend: "excelHtml5",
        className: "btn btn-success",
        exportOptions: {
          columns: ":visible",
        },

        pageStyle: {
          sheetPr: {
            pageSetUpPr: {
              fitToPage: 1,
            },
          },
          printOptions: {
            horizontalCentered: true,
            verticalCentered: true,
          },
          pageSetup: {
            orientation: "landscape",
            paperSize: "9",
            fitToWidth: "1",
            fitToHeight: "0",
          },
          pageMargins: {
            left: "0.2",
            right: "0.2",
            top: "0.4",
            bottom: "0.4",
            header: "0",
            footer: "0",
          },
          repeatHeading: true,
          repeatCol: "A:A",
        },
        excelStyles: [
          {
            template: "blue_medium",
          },
          {
            cells: "A2:",
            //template: "cyan_medium",
            style: {
              // Alignment Object
              alignment: {
                vertical: "center",
                horizontal: "center",
                wrapText: true,
              },
            },
          },
        ],
      },
    ],
    ajax: {
      url: rutaOculta+"ajax/producto.ajax.php",
      dataSrc: "",
      type: "POST",
      data: {
        ajaxMostrarBajosInvD: "ajaxMostrarBajosInvD",
        idAlmacen: idAlmacenBajo,
      },
    },
   

    columnDefs: [
     
      {
        targets: 0,
        visible: false,
      },
      
    ],

    rowCallback:function(row,data){
			
				$($(row).find("td")[3]).css("background-color","#E60026");
			
		},
    

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    bDestroy: true,
  });
}
