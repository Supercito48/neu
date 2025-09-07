var tablaDeposito;
var tablaDepositoProducto;
var rutaOculta = $("#rutaOculta").val();

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

console.log(rutaOculta)
// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaDeposito = $(".tablaDeposito").DataTable({
  "responsive": true,
  "autoWidth": false,
  "responsive": true,
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },
  ajax: {
    url: "ajax/tablas/tablaDeposito.ajax.php",
    dataSrc: "",
  },
  columns: [{
      data: "idDeposito "
    },
    {
      data: "codigoBarras "
    },
    {
      data: "descProducto"
    },
    {
      data: "stock"
    },

    {
      data: "acciones"
    },
  ],
  columnDefs: [{
    targets: 0,
    visible: false
  }],

  bDestroy: true,
  iDisplayLength: 10,
});

tablaDepositoProducto = $(".tablaDepositoProducto").DataTable({
  "responsive": true,
  "autoWidth": false,
  "responsive": true,
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },
  ajax: {
    url: "ajax/tablas/tablaAgrDeposito.ajax.php",
    dataSrc: "",
  },
  columns: [
    {
      data: "codigoBarras"
    },
    {
      data: "descProducto"
    },
    {
      data: "stock"
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

$(document).on("click", ".btnSumaDeposito", function () {

  var idDeposito = $(this).attr("idDeposito");
  var ajaxDepositoU = "ajaxDepositoU";

  var datos = new FormData();

  datos.append("idDeposito", idDeposito);
  datos.append("ajaxDepositoU", ajaxDepositoU);

  $.ajax({
    url: rutaOculta + "ajax/deposito.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      console.log(respuesta)
      $(".idDeposito").val(idDeposito);
      $(".idProductos").val(respuesta["idProducto"]);
      $(".stockactual").val(respuesta["stock"]);


    },
  });
});

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

function limpiarDeposito() {
  $(".idDeposito").val("");
  $(".idProducto").val("");
  $(".idProductos").val("");
  $(".stock").val("");
  $(".nuevostock").val("");
  $(".nuevostockE").val("");
  $(".stockE").val("");
  $(".stockNuevo").val("");
  $("#Destino").val("");
  $(".idAlmacenDestino").val("");
  $(".descAlmacenDestino").val("");



}

$("#modalAumentoDeposito").on("show.bs.modal", function (event) {
  limpiarDeposito()
});
$("#modalTraslado").on("show.bs.modal", function (event) {
  limpiarDeposito()
});

/* 





*/
var stockGuardar;
function stockGuardado(e) {
  
  let tr = $(e.target).closest('tr');
  var stock = parseFloat($(tr).find(".stock").val()) ;
  stockGuardar = stock;
}

$(document).on("change", ".stock", stockGuardado);

$(document).on("click", ".guardarDeposito", function () {

  var idProducto = $(this).attr("idProducto");
  
  //var stock = parseFloat($(tr).find(".stock").val()) ;
  var idUsuario = $("#modalInventario .idUsuario").val();

  var datos = new FormData();

  datos.append("idProducto", idProducto);
  datos.append("stock", stockGuardar);
  datos.append("idUsuario", idUsuario);
  datos.append("ajaxRegistrarDeposito", 'ajaxRegistrarDeposito');


  $.ajax({
    url: rutaOculta + "ajax/deposito.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

     // $("#modalInventario").modal('hide');
      tablaDepositoProducto.ajax.reload(null, false);
      tablaDeposito.ajax.reload(null, false);
      limpiarDeposito();

      toast2.fire({
        icon: "success",
        title: "Stock agregado correctamente!",
      });
      

    }

  })

});



/* 






*/
$(".guardarAumentoStock").click(function () {

  var idDeposito = $("#modalAumentoDeposito .idDeposito").val();
  var stock = $("#modalAumentoDeposito .nuevostock").val();
  var idProducto = $("#modalAumentoDeposito .idProductos").val();
  var idUsuario = $("#modalAumentoDeposito .idUsuario").val();
  var habia = $("#modalAumentoDeposito .stockactual").val();


  var datos = new FormData();

  datos.append("idDeposito", idDeposito);
  datos.append("editarstock", stock);
  datos.append("idProducto", idProducto);
  datos.append("idUsuario", idUsuario);

  datos.append("habia", habia);
  datos.append("ajaxEditarSumarStock", "ajaxEditarSumarStock");


  $.ajax({
    url: rutaOculta + "ajax/deposito.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

      $("#modalAumentoDeposito").modal('hide');
      tablaDepositoProducto.ajax.reload(null, false);
      tablaDeposito.ajax.reload(null, false);

      limpiarDeposito();

      Swal.fire({
        title: '¡CORRECTO!',
        html: '¡Datos enviados exitosamente!',
        icon: 'success',
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {

          }, 75)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {

        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('se ha cerrado por el tiempo!')
        }
      })

    }

  })

});


$(".guardarAjusteStock").click(function () {

  var idDeposito = $("#modalAjustarDeposito .idDeposito").val();
  var stock = $("#modalAjustarDeposito .stockNuevo").val();
  var idProducto = $("#modalAjustarDeposito .idProductos").val();
  var idUsuario = $("#modalAjustarDeposito .idUsuario").val();
  var habia = $("#modalAjustarDeposito .stockactual").val();


  var datos = new FormData();

  datos.append("idDeposito", idDeposito);
  datos.append("editarstock", stock);
  datos.append("idProducto", idProducto);
  datos.append("idUsuario", idUsuario);

  datos.append("habia", habia);
  datos.append("ajaxEditarAjustarStock", "ajaxEditarAjustarStock");


  $.ajax({
    url: rutaOculta + "ajax/deposito.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

      $("#modalAjustarDeposito").modal('hide');
      tablaDeposito.ajax.reload(null, false);
      tablaDepositoProducto.ajax.reload(null, false);

      limpiarDeposito();

      Swal.fire({
        title: '¡CORRECTO!',
        html: '¡Datos enviados exitosamente!',
        icon: 'success',
        timer: 1500,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {

          }, 75)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {

        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('se ha cerrado por el tiempo!')
        }
      })

    }

  })

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

    var idDeposito = $("#modalTraslado .idDeposito").val();
    var stock = $("#modalTraslado .nuevostockE").val();
    var idAlmacen = $("#modalTraslado #Destino").val();
    var idProducto = $("#modalTraslado .idProductos").val();
    var idUsuario = $("#modalTraslado .idUsuario").val();
    var habia = $("#modalTraslado .stockactual").val();
    var habidst = $("#modalTraslado .idAlmacenDestino").val();

    var datos = new FormData();

    datos.append("idDeposito", idDeposito);
    datos.append("editarstock", stock);
    datos.append("idAlmacen", idAlmacen);
    datos.append("idProducto", idProducto);
    datos.append("idUsuario", idUsuario);
    datos.append("habia", habia);
    datos.append("habidst", habidst);
    datos.append("ajaxEditarTraslado", "ajaxEditarTraslado");

    $.ajax({
      url: rutaOculta + "ajax/deposito.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {

        $("#modalTraslado").modal('hide');
        tablaDeposito.ajax.reload(null, false);
        tablaDepositoProducto.ajax.reload(null, false);

        limpiarDeposito();

        Swal.fire({
          title: '¡CORRECTO!',
          html: '¡Datos enviados exitosamente!',
          icon: 'success',
          timer: 1500,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {

            }, 75)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {

          if (result.dismiss === Swal.DismissReason.timer) {
            console.log('se ha cerrado por el tiempo!')
          }
        })

      }

    })

  }

});

$(document).on("click", ".eliminarDeposito", function () {
  var idDeposito = $(this).attr("idDeposito");
  var stock = $(this).attr("stock");
  var idProducto = $(this).attr("idProducto");
  var idUsuario = $(".idUsuario").val();

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

      datos.append("idDeposito", idDeposito);
      datos.append("stock", stock);
      datos.append("idProducto", idProducto);
      datos.append("idUsuario", idUsuario);
      datos.append("ajaxBorrarDeposito", "ajaxBorrarDeposito");

      $.ajax({
        url: rutaOculta + "ajax/deposito.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

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
              tablaDeposito.ajax.reload(null, false);
              tablaDepositoProducto.ajax.reload(null, false);
            },
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("se ha cerrado por el tiempo!");
            }
          });


        },
      });
    }
  });
});