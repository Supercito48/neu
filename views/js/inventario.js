var tablaInventario;
var tablaKardex;

var rutaOculta = $("#rutaOculta").val();
var idAlmacen = $("#idAlmacen").val();
var idAlmacenGuardar = $(".idAlmacenGuardar").val();

cargarTotalInv();
var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});
// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaKardex = $(".tablaKardex").DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  responsive: true,

  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending: ": Activar para ordenar la columna de manera descendente",
    },
  },

  bDestroy: true,
  iDisplayLength: 10,
});
$('.buttons-excel').hide();

tablaInventario = $(".tablaInventario").DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  responsive: true,

  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },
  dom: "Bfrtip",

  buttons: [

    {
      text: 'Exportar a Excel   &nbsp; <i class="fas fa-file-excel"></i>',
      extend: "excelHtml5",
      className: "btn btn-success",
      exportOptions: {
        columns: [0, 1, 2, 3, 4]
      },
      filename: function () {
        return "Inventario"
      },

      insertCells: [ // Add an insertCells config option 
        {
          cells: 'sDh', // Target the header with smart selection
          content: 'Inventario', // New content for the cells
          pushCol: true, // pushCol causes the column to be inserted
        },
        {
          cells: 'sD1:D-0', // Target data row 5 and 6
          content: '', // Add empty content
          pushCol: true // push the rows down to insert the content
        },
      ],
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
      excelStyles: [{
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
    url: rutaOculta + "ajax/tablas/tablaInventario.ajax.php",
    dataSrc: "",
    data: {
      'idAlmacen': idAlmacenGuardar,

    },
  },
  columns: [{
      data: "codigoBarras"
    },
    {
      data: "descProducto"
    },
    {
      data: "desCat"
    },
    {
      data: "stock"
    },
    {
      data: "stock_minimo"
    },

    {
      data: "acciones"
    },
  ],


  bDestroy: true,
  iDisplayLength: 10,
});


tablaInventariotoProducto = $(".tablaInventariotoProducto").DataTable({
  "responsive": true,
  "autoWidth": false,
  "responsive": true,
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },

  ajax: {
    url: rutaOculta + "ajax/tablas/tablaAgrInventario.ajax.php",
    dataSrc: "",
    data: {
      'idAlmacen': idAlmacenGuardar,
    },
  },
  columns: [{
      data: "codigoBarras"
    },
    {
      data: "descProducto"
    },

    {
      data: "stock"
    },
    {
      data: "stock_minimo"
    },
    {
      data: "acciones"
    },
  ],


  bDestroy: true,
  iDisplayLength: 10,
});

function soloNumeros(e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  numeros = " 1234567890";
  especiales = [8, 37, 39, 46];

  tecla_especial = false;
  for (var i in especiales) {
    if (key == especiales[i]) {
      tecla_especial = true;
      break;
    }
  }

  if (numeros.indexOf(tecla) == -1 && !tecla_especial) return false;
}


function sumar() {
  var nuevoStock = $(".nuevostock").val();
  var stockActual = Number(nuevoStock) + Number($(".stockactual").val());
  stock = parseFloat(stockActual);
  $(".stock").val(stock);
}

function enviarStock() {
  var nuevoStockE = $(".nuevostockE").val();
  var stockActualE = Number($(".stockactual").val()) - Number(nuevoStockE);
  stockE = parseFloat(stockActualE);
  $(".stockE").val(stockE);
}

function AlertaSuccess(cierre) {

  Swal.fire({
    title: "¡CORRECTO!",
    html: "¡Datos enviados exitosamente!",
    icon: "success",
    timer: 1500,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
      timerInterval = setInterval(() => {}, 75);
    },
    willClose: () => {
      clearInterval(timerInterval);
      limpiarInventario();
      tablaInventario.ajax.reload();
      tablaInventariotoProducto.ajax.reload();
      return cierre;
    },
  }).then((result) => {
    /* Read more about handling dismissals below */
    if (result.dismiss === Swal.DismissReason.timer) {
      console.log("se ha cerrado por el tiempo!");
    }
  });

}

$(".nuevostockE").change(function () {
  if (Number($(".nuevostockE").val()) > Number($("#stockactual").val())) {

    /*=============================================
    SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
    =============================================*/
    $(this).val("");
    $(".nuevostockE").focus();
    $(".stockE").val("");

    Swal.fire({
      title: "La cantidad supera el stock",
      html: "¡Solo hay " + $("#stockactual").val() + " unidades!",
      icon: "error",
      timer: 1500,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading();

        timerInterval = setInterval(() => {}, 75);
      },
      willClose: () => {
        clearInterval(timerInterval);

      },
    }).then((result) => {

      if (result.dismiss === Swal.DismissReason.timer) {
        console.log("se ha cerrado por el tiempo!");
      }
    });


  }

})

$(document).on("click", ".btnSumaStock", function () {

  var idInventario = $(this).attr("idInventario");
  var ajaxInventario = "ajaxInventario";

  var datos = new FormData();

  datos.append("idInventario", idInventario);
  datos.append("ajaxInventario", ajaxInventario);

  $.ajax({
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      var ajaxAlmacen = "ajaxAlmacen";

      var datos = new FormData();
      datos.append("idAlmacen", respuesta["idAlmacen"]);
      datos.append("ajaxAlmacen", ajaxAlmacen);

      $.ajax({
        url: rutaOculta + "ajax/almacen.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          $(".idAlmacen").val(respuesta["idAlmacen"]);
          $(".idAlmacen").html(respuesta["descripcion"]);
          $(".pruebaAlmacen").val(respuesta["descripcion"]);
        },
      })



      $(".idInventario").val(idInventario);
      $(".stockactual").val(respuesta["stock"]);
      $(".idProductos").val(respuesta["idProducto"]);


    },
  });
});


//LIMPAREMOS TODOS LOS INPUTS
function limpiarInventario() {
  $(".idInventario").val("");
  $(".idAlmacen").val("");
  $(".idProducto").val("");
  $(".stock").val("");
  $(".stock_minimo").val("");
  $(".nuevostock").val("");
  $(".nuevostockE").val("");
  $(".stockE").val("");
}




$("#modalAumentoInventario").on("show.bs.modal", function (event) {
  limpiarInventario()
});
$("#modalTraslado").on("show.bs.modal", function (event) {

  $(".nuevostockE").val("");
  $("#Destino").val("");

});

var stockGuardar;
var stock_minimoGuardar;

function stockGuardado(e) {
  let tr = $(e.target).closest('tr');
  var stock = parseFloat($(tr).find(".stock").val());
  stockGuardar = stock;
}

$(document).on("change", ".stock", stockGuardado);

function stockminimoGuardado(e) {
  let tr = $(e.target).closest('tr');
  var stock_minimo = parseFloat($(tr).find(".stock_minimo").val());
  stock_minimoGuardar = stock_minimo;
}

$(document).on("change", ".stock_minimo", stockminimoGuardado);

//$(document).on("change", ".stock_minimo", function (e) {
$(document).on("click", ".guardarInventario", function () {
  //$(".guardarInventario").click(function (e) {

  var idProducto = $(this).attr("idProducto");
  var idUsuario = $(this).attr("idUsuario");

  var datos = new FormData();

  datos.append("idAlmacen", idAlmacenGuardar);
  datos.append("idProducto", idProducto);
  datos.append("stock", stockGuardar);
  datos.append("stock_minimo", stock_minimoGuardar);
  datos.append("idUsuario", idUsuario);

  $.ajax({
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta == "ok") {

        var datos = new FormData();

        datos.append("idAlmacen", idAlmacenGuardar);
        datos.append("idProducto", idProducto);
        datos.append("stock", stockGuardar);
        datos.append("idUsuario", idUsuario);

        $.ajax({
          url: rutaOculta + "ajax/kardex.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta == "ok") {


              tablaInventario.ajax.reload(null, false);
              tablaInventariotoProducto.ajax.reload(null, false);
              traerNotificacionBajoInv();
              cargarTotalInv();
              toast2.fire({
                icon: "success",
                title: "Stock agregado correctamente!",
              });
            }
          },

        });
      } else {
        Swal.fire(
          "ERROR!",
          "¡No se permiten caracteres especiales o estar vacío!",
          "error"
        ).then(function (result) {
          if (result.value) {}
        });
      }
    },
  });

});



$(".guardarAumentoStock").click(function () {


  var id = $("#modalAumentoInventario .idInventario").val();
  var stock = $("#modalAumentoInventario .stock").val();

  var datos = new FormData();

  datos.append("idInventario", id);
  datos.append("editarstock", stock);



  $.ajax({
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {


      if (respuesta == "ok") {

        var idAlmacen = $(".idAlmacen").val();
        var idProducto = $(".idProductos").val();
        var stock = $(".nuevostock").val();
        var idUsuario = $(".idUsuario").val();
        var habia = $(".stockactual").val();
        var hay = $(".stock").val();
        //var hay = Number($(".stock").val()) + Number($(".nuevostock").val()) ;

        var datos = new FormData();

        datos.append("AidAlmacen", idAlmacen);
        datos.append("AidProducto", idProducto);
        datos.append("Astock", stock);
        datos.append("AidUsuario", idUsuario);
        datos.append("Ahabia", habia);
        datos.append("Ahay", hay);

        $.ajax({
          url: rutaOculta + "ajax/kardex.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            // console.log("respuesta", respuesta);
            if (respuesta == "ok") {
              AlertaSuccess($("#modalAumentoInventario").modal("hide"))
              traerNotificacionBajoInv();
              cargarTotalInv();
            }
          },

        });
      } else {
        Swal.fire(
          "ERROR!",
          "¡No se permiten caracteres especiales o estar vacío!",
          "error"
        ).then(function (result) {
          if (result.value) {}
        });
      }

    }

  })

});




$(".guardarAjusteStock").click(function () {


  var id = $("#modalAjustarInventario .idInventario").val();
  var stock = $("#modalAjustarInventario .stockNuevo").val();

  var datos = new FormData();

  datos.append("idInventario", id);
  datos.append("editarstock", stock);



  $.ajax({
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {


      if (respuesta == "ok") {

        var idAlmacen = $(".idAlmacen").val();
        var idProducto = $(".idProductos").val();
        var stock = $(".stockNuevo").val();
        var idUsuario = $(".idUsuario").val();
        var habia = $(".stockactual").val();
        var hay = $(".stockNuevo").val();

        var datos = new FormData();

        datos.append("AJidAlmacen", idAlmacen);
        datos.append("AJidProducto", idProducto);
        datos.append("AJstock", stock);
        datos.append("AJidUsuario", idUsuario);
        datos.append("AJhabia", habia);
        datos.append("AJhay", hay);

        $.ajax({
          url: rutaOculta + "ajax/kardex.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            // console.log("respuesta", respuesta);
            if (respuesta == "ok") {
              AlertaSuccess($("#modalAjustarInventario").modal("hide"))
              traerNotificacionBajoInv();
              cargarTotalInv();
            }
          },

        });
      } else {
        Swal.fire(
          "ERROR!",
          "¡No se permiten caracteres especiales o estar vacío!",
          "error"
        ).then(function (result) {
          if (result.value) {}
        });
      }

    }

  })

});

$(document).on("change", "#Destino", function () {


  var PRidAlmacen = $(this).val();
  var PRidProducto = $("#modalTraslado .idProductos").val();
  var ajaxTraslado = "ajaxTraslado";

  var datos = new FormData();
  datos.append("PRidAlmacen", PRidAlmacen);
  datos.append("PRidProducto", PRidProducto);
  datos.append("ajaxTraslado", ajaxTraslado);

  $.ajax({
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      var ajaxAlmacen = "ajaxAlmacen";

      var datos = new FormData();
      datos.append("idAlmacen", respuesta["idAlmacen"]);
      datos.append("ajaxAlmacen", ajaxAlmacen);

      $.ajax({
        url: rutaOculta + "ajax/almacen.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          $(".descAlmacenDestino").val(respuesta["descripcion"]);

        },
      })

      $(".idAlmacenDestino").val(respuesta["stock"]);
      console.log(respuesta["stock"])
    },
  });
});

$(".guardarTraslado").click(function () {

  var destino = $("#Destino").val();
  var destinoAlm = $(".idAlmacenDestino").val();

  if (destinoAlm == "") {
    Swal.fire(
      '¡ERROR!',
      'Esteo producto no se encuentra en ese almacen!',
      'error',
    );
    return;

  }
  if (destino == "") {
    Swal.fire(
      '¡ERROR!',
      'Seleccione sucursal Destino!',
      'error',
    );
    return;

  } else {
    var idAlmacen = $("#modalTraslado .idAlmacen").val();
    var idProducto = $("#modalTraslado .idProductos").val();
    var stock = $("#modalTraslado .stockE").val();

    var datos = new FormData();

    datos.append("TidAlmacen", idAlmacen);
    datos.append("TidProducto", idProducto);
    datos.append("Tstocck", stock);



    $.ajax({
      url: rutaOculta + "ajax/inventario.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {


        if (respuesta == "ok") {


          var idAlmacen = $(".idAlmacen").val();
          var idProducto = $(".idProductos").val();
          var stock = $(".nuevostockE").val();
          var idUsuario = $(".idUsuario").val();
          var habia = $(".stockactual").val();
          var hay = $(".stockE").val();


          var destinodesc = $(".descAlmacenDestino").val();
          //var hay = Number($(".stock").val()) + Number($(".nuevostock").val()) ;

          var datos = new FormData();

          datos.append("TidAlmacen", idAlmacen);
          datos.append("TidProducto", idProducto);
          datos.append("Tstock", stock);
          datos.append("TidUsuario", idUsuario);
          datos.append("Thabia", habia);
          datos.append("Thay", hay);

          datos.append("Tdestinodesc", destinodesc);

          $.ajax({
            url: rutaOculta + "ajax/kardex.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
              // console.log("respuesta", respuesta);
              if (respuesta == "ok") {

              }
            },

          });


          var RidAlmacen = $("#modalTraslado #Destino").val();
          var RidProducto = $("#modalTraslado .idProductos").val();
          var stockDespues = +Number($(".idAlmacenDestino").val()) + Number($("#modalTraslado .nuevostockE").val());

          console.log(stockDespues)

          var datos = new FormData();

          datos.append("RidAlmacen", RidAlmacen);
          datos.append("RidProducto", RidProducto);
          datos.append("Rstocck", stockDespues);

          $.ajax({
            url: rutaOculta + "ajax/inventario.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {

              if (respuesta == "ok") {



                var idAlmacen = $("#Destino").val();
                var idProducto = $(".idProductos").val();
                var stock = $(".nuevostockE").val();
                var idUsuario = $(".idUsuario").val();
                var habia = $(".idAlmacenDestino").val();
                var hay = +Number($(".idAlmacenDestino").val()) + Number($("#modalTraslado .nuevostockE").val());

                var destinodesc = $(".pruebaAlmacen").val();
                //var hay = Number($(".stock").val()) + Number($(".nuevostock").val()) ;

                var datos = new FormData();

                datos.append("ETidAlmacen", idAlmacen);
                datos.append("ETidProducto", idProducto);
                datos.append("ETstock", stock);
                datos.append("ETidUsuario", idUsuario);
                datos.append("EThabia", habia);
                datos.append("EThay", hay);

                datos.append("ETdestinodesc", destinodesc);

                $.ajax({
                  url: rutaOculta + "ajax/kardex.ajax.php",
                  method: "POST",
                  data: datos,
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function (respuesta) {
                    // console.log("respuesta", respuesta);
                    if (respuesta == "ok") {
                      AlertaSuccess($("#modalTraslado").modal("hide"))
                      traerNotificacionBajoInv();
                      cargarTotalInv();
                    }
                  },

                });




              }
            },

          });





        } else {
          Swal.fire(
            "ERROR!",
            "¡No se permiten caracteres especiales o estar vacío!",
            "error"
          ).then(function (result) {
            if (result.value) {}
          });
        }

      }

    })


  }

});

$(document).on("click", ".eliminarInventario", function () {
  var idInventario = $(this).attr("idInventario");
  var ELidAlmacen = $(this).attr("idAlmacen");
  var ELidProducto = $(this).attr("idProducto");
  var ELstock = $(this).attr("stock");
  var ELidUsuario = $(this).attr("idUsuario");
  Swal.fire({
    title: "¿Está seguro de eliminar este documento?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("idEliminar", idInventario);
      $.ajax({
        url: rutaOculta + "ajax/inventario.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {


            //var ELidAlmacen = $(".idAlmacenBorrar").val();
            //var ELidProducto = $(".idProductoBorrar").val();
            //var ELstock = $(".stockBorrar").val();
            //var ELidUsuario = $(".idUsuarioBorrar").val();

            var datos = new FormData();

            datos.append("ELidAlmacen", ELidAlmacen);
            datos.append("ELidProducto", ELidProducto);
            datos.append("ELstock", ELstock);
            datos.append("ELidUsuario", ELidUsuario);


            $.ajax({
              url: rutaOculta + "ajax/kardex.ajax.php",
              method: "POST",
              data: datos,
              cache: false,
              contentType: false,
              processData: false,
              success: function (respuesta) {
                // console.log("respuesta", respuesta);
                if (respuesta == "ok") {

                  let timerInterval;
                  Swal.fire({
                    title: "¡CORRECTO!",
                    html: "Se elimino correctamente.",
                    icon: "success",
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading();
                      const b = Swal.getHtmlContainer().querySelector("b");
                      timerInterval = setInterval(() => {}, 75);
                    },
                    willClose: () => {
                      clearInterval(timerInterval);
                      tablaInventario.ajax.reload();
                      tablaInventariotoProducto.ajax.reload();
                      traerNotificacionBajoInv();
                      cargarTotalInv();
                    },
                  }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                      console.log("se ha cerrado por el tiempo!");
                    }
                  });


                }
              },

            });


          }
        },
      });
    }
  });
});
function formatMoney(number, decPlaces, decSep, thouSep) {
  (decPlaces = isNaN((decPlaces = Math.abs(decPlaces))) ? 2 : decPlaces),
  (decSep = typeof decSep === "undefined" ? "." : decSep);
  thouSep = typeof thouSep === "undefined" ? "," : thouSep;
  var sign = number < 0 ? "-" : "";
  var i = String(
    parseInt((number = Math.abs(Number(number) || 0).toFixed(decPlaces)))
  );
  var j = (j = i.length) > 3 ? j % 3 : 0;

  return (
    sign +
    (j ? i.substr(0, j) + thouSep : "") +
    i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
    (decPlaces ?
      decSep +
      Math.abs(number - i)
      .toFixed(decPlaces)
      .slice(2) :
      "")
  );
}

function cargarTotalInv() {


  idAlmacens = $(".idAlmacenGuardar").val();


  $.ajax({
    async: false,
    url: rutaOculta + "ajax/inventario.ajax.php",
    method: "POST",
    data: {
      'ajaxTotalInventario': 'ajaxTotalInventario',
      'idAlmacen': idAlmacens
    },
    dataType: 'json',
    success: function (respuesta) {

      console.log(respuesta);

      $("#CostoInv").html(addCommas(respuesta[0]));

      $("#CantInv").html(addCommas(respuesta[1]));
      
    }
  });
}

//console.log(addCommas(valor.toFixed(2)));
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}