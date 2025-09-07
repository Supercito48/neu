var tablaClientes;
var rutaOculta = $("#rutaOculta").val();

var Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
});
var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaClientes = $(".tablaClientes").DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  responsive: true,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },

  ajax: {
    url: "ajax/tablas/tablaClientes.ajax.php",
    dataSrc: "",
  },

  columns: [
    {
      data: "idCliente ",
    },
    {
      data: "dni ",
    },
    {
      data: "nombres",
    },
    {
      data: "direccion",
    },
    {
      data: "telefono",
    },
    {
      data: "limite_credito",
    },
    {
      data: "credito_usado",
    },
    {
      data: "acciones",
    },
  ],

  bDestroy: true,
  iDisplayLength: 10,
});
$("#modalClientes").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Cliente");

  $(".guardarCli").show();
  $(".editarCli").hide();
  $(".dni").removeAttr("disabled");
  $(".dni").val("");
  $(".nombres").val("");
  $(".direccion").val("");
  $(".telefono").val("");
  $(".limite_credito").val("");
});

$(".guardarCli").on("click", function () {
  var dni = $(".dni").val(),
    nombres = $(".nombres").val(),
    direccion = $(".direccion").val(),
    telefono = $(".telefono").val(),
    limite_credito = $(".limite_credito").val();

  if (
    dni.length == 0 ||
    nombres.length == 0 ||
    direccion.length == 0 ||
    telefono.length == 0 ||
    limite_credito.length == 0
  ) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "Llene los campos vacios",
      "warning"
    );
  }
  var datos = new FormData();

  datos.append("ajaxRegistrarCliente", "ajaxRegistrarCliente");
  datos.append("dni", dni);
  datos.append("nombres", nombres);
  datos.append("direccion", direccion);
  datos.append("telefono", telefono);
  datos.append("limite_credito", limite_credito);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $("#modalClientes").modal("hide");
      tablaClientes.ajax.reload(null, false);

      $(".dni").val("");
      $(".nombres").val("");
      $(".direccion").val("");
      $(".telefono").val("");
      $(".limite_credito").val("");

      Swal.fire({
        title: "¡CORRECTO!",
        html: "¡Datos enviados exitosamente!",
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
        },
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log("se ha cerrado por el tiempo!");
        }
      });
    },
  });
});

$(document).on("click", ".editarCliente", function () {
  var idCliente = $(this).attr("idCliente");
  var ajaxMostrarCliente = "ajaxMostrarCliente";
  var datos = new FormData();
  datos.append("idCliente", idCliente);
  datos.append("ajaxMostrarCliente", ajaxMostrarCliente);
  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      $(".modal-header").css("color", "white");
      $(".modal-title").text("Editar Cliente");

      $(".dni").attr("disabled", "disabled");

      $(".idCliente").val(respuesta["idCliente"]);
      $(".dni").val(respuesta["dni"]);
      $(".nombres").val(respuesta["nombres"]);
      $(".direccion").val(respuesta["direccion"]);
      $(".telefono").val(respuesta["telefono"]);
      $(".limite_credito").val(respuesta["limite_credito"]);

      $(".guardarCli").hide();
      $(".editarCli").show();
    },
  });
});

$(".editarCli").on("click", function () {
  var idCliente = $(".idCliente").val(),
    dni = $(".dni").val(),
    nombres = $(".nombres").val(),
    direccion = $(".direccion").val(),
    telefono = $(".telefono").val(),
    limite_credito = $(".limite_credito").val();

  var datos = new FormData();

  datos.append("ajaxEditarCliente", "ajaxEditarCliente");
  datos.append("idCliente", idCliente);
  datos.append("dni", dni);
  datos.append("nombres", nombres);
  datos.append("direccion", direccion);
  datos.append("telefono", telefono);
  datos.append("limite_credito", limite_credito);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $("#modalClientes").modal("hide");
      tablaClientes.ajax.reload(null, false);

      $(".dni").val("");
      $(".nombres").val("");
      $(".direccion").val("");
      $(".telefono").val("");
      $(".limite_credito").val("");

      Swal.fire({
        title: "¡CORRECTO!",
        html: "¡Datos enviados exitosamente!",
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
        },
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log("se ha cerrado por el tiempo!");
        }
      });
    },
  });
});

$(document).on("click", ".eliminarCliente", function () {
  var idCliente = $(this).attr("idCliente");
  Swal.fire({
    title: "¿Está seguro de eliminar el cliente?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "ajax/clientes.ajax.php",
        type: "POST",
        data: {
          ajaxBorrarCliente: "ajaxBorrarCliente",
          idCliente: idCliente,
        },
        dataType: "json",
        success: function (respuesta) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Se elimino correctamente!",
            showConfirmButton: false,
            timer: 1500,
          });
          tablaClientes.ajax.reload(null, false);
        },
      });
    }
  });
});

$(".dni").change(function () {
  var dni = $(this).val();
  ValidarDni(dni);
  TraerDni(dni);
});

function ValidarDni(dni) {
  var datos = new FormData();
  datos.append("ajaxValidarDni", dni);

  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        Toast.fire({
          icon: "warning",
          title: "&nbsp;&nbsp;  Este dni ya existe en la base de datos!",
        });
        $(".dni").val("");
      }
    },
  });
}

function TraerDni(dni) {
  $.ajax({
    type: "POST",
    url: "ajax/consultadni.ajax.php",
    data: "dni=" + dni,
    dataType: "json",
    success: function (data) {
      if (data == 1) {
        alert("El dni tiene que tener 8 digitos");
      } else {
        console.log(data);
        $(".nombres").val(
          MaysPrimera(data.nombres.toLowerCase()) +
            " " +
            MaysPrimera(data.apellidoPaterno.toLowerCase()) +
            " " +
            MaysPrimera(data.apellidoMaterno.toLowerCase())
        );
        //$(".apellidos").val();
      }
    },
  });
}

function MaysPrimera(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

//

//AL MOMENTO DE HACER CLICK EN AGREGAR, NOS CAMBIA EL TITULO Y EL COLOR DE LETRA
$("#moda_pagar").on("show.bs.modal", function (event) {
  $("#metodo_pago").val("").trigger("change");
  $("#monto_p").val("");
  $("#montoescrito").val("");
});

var idClienteG;
var montoComparar;

$(document).on("click", ".pagarCredito", function () {
  var idCliente = $(this).attr("idCliente");
  var ajaxMostrarCliente = "ajaxMostrarCliente";
  var datos = new FormData();
  datos.append("idCliente", idCliente);
  datos.append("ajaxMostrarCliente", ajaxMostrarCliente);
  $.ajax({
    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);

      var monto_usado =
        Number(respuesta["limite_credito"]) -
        Number(respuesta["credito_usado"]);

      idClienteG = idCliente;
      montoComparar = monto_usado;
      console.log(montoComparar);
      $("#creditusado").html(monto_usado.toFixed(2));
    },
  });
});

$("#monto_p").change(function () {
  if (Number($("#monto_p").val()) > Number($("#creditusado").html())) {
    /*=============================================
      SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
      =============================================*/
    $(this).val("");
    $("#monto_p").focus();
    //$(".precio").val("");

    Swal.fire({
      title: "El monto super al restante",
      html: "¡Solo puede pagar hasta S/. " + $("#creditusado").html() + "",
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
});

$("#metodo_pago").change(function () {
  var metodo = $(this).val();

  if (metodo == "Tarjeta") {
    //$("#monto_p").focus();

    setTimeout(function () {
      $("#monto_p").focus();
    }, 10);

    $("#chkComision").prop("disabled", false);
    comisionCambio();
  } else {
    $("#chkComision").prop("disabled", true);
    $("#chkComision")[0].checked = false;
    $("#monto_p").focus();
    comisionCambio();
  }
});

$(document).on("keyup", "#monto_p", function () {
  $("#montoescrito").val($(this).val());
});
var comisionPagar = 0;

$("#chkComision").change(function () {
  comisionCambio();
});
function comisionCambio() {
  if ($("#chkComision").is(":checked")) {
    var comision = parseFloat($("#montoescrito").val()) * 0.05;
    var totalrestanteC =
      parseFloat($("#montoescrito").val()) + parseFloat(comision);
    //var totalrestanteC2 = parseFloat(totalPagar) + parseFloat(comision)

    $("#monto_p").val(parseFloat(totalrestanteC).toFixed(2));
    //$("#total").html(' S/. '+parseFloat(totalrestanteC2).toFixed(2));

    comisionPagar = comision;

    console.log(comisionPagar.toFixed(2));
  } else {
    var comision = parseFloat($("#montoescrito").val()) * 0.05;
    var totalrestanteC =
      parseFloat($("#montoescrito").val()) +
      parseFloat(comision) -
      parseFloat(comision);
    //var totalrestanteC2 = parseFloat(totalPagar) + parseFloat(comision)

    $("#monto_p").val(parseFloat(totalrestanteC).toFixed(2));
    //$("#total").html(' S/. '+parseFloat(totalrestanteC2).toFixed(2));

    comisionPagar = 0;

    console.log(comisionPagar.toFixed(2));
  }
}

var idUsuario = $("#idUsuario").val();
var idCaja;

fnc_idCAja();

function fnc_idCAja() {
  $.ajax({
    async: false,
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxrVercaja: "ajaxrVercaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      if (respuesta == false) {
        console.log("no tiene caja abierta");
      } else {
        idCaja = respuesta["idCaja"];

        //$("#idCaja").val(respuesta["idCaja"]);
      }
    },
  });
}

$(".pagarCreditoC ").on("click", function () {
  realizarPago();
});

function realizarPago() {
  var estado_caja;

  $.ajax({
    async: false,
    url: "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxVerificarCaja: "ajaxVerificarCaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      estado_caja = respuesta["count(*)"];

      if (respuesta["count(*)"] == 0) {
        estado_caja = 0;
      }
    },
  });
  if (estado_caja > 0) {
    var monto = $("#monto_p").val();

    //juan
    var metodo = $("#metodo_pago").val();

    var montoCompararP = montoComparar - monto;

    if (metodo.length == 0 || monto.length == 0) {
      return Swal.fire(
        "Mensaje De Advertencia",
        "Llene los campos vacios",
        "warning"
      );
    }
    Swal.fire({
      title: "¿Está seguro de pagar la cita?",
      text: "¡Si no lo está puede cancelar la acción!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, pagar!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/clientes.ajax.php",
          type: "POST",
          data: {
            ajaxPagarCredito: "ajaxPagarCredito",
            idCliente: idClienteG,
            monto: monto,
            comision: comisionPagar,
            metodo: metodo,
            idCaja: idCaja,
            montoComparar: montoCompararP,
          },
          dataType: "json",
          success: function (respuesta) {
            Swal.fire({
              title: "Cita pagada correctamente!",
              text: "Datos de Confirmación",
              icon: "success",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Imprimir Ticket!",
            }).then((result) => {
              if (result.isConfirmed) {
                
                window.open(
                  rutaOculta +
                    "/extensions/libreporte/reportes/generar_ticket.php?idCliente=" +
                    idClienteG +
                    "#zoom=100%",
                  "Ticket",
                  "scrollbars=NO"
                );
                $("#moda_pagar").modal("hide");
                tablaClientes.ajax.reload();
              } else {
                $("#moda_pagar").modal("hide");
                tablaClientes.ajax.reload();
              }
            });
          },
        });
      }
    });
  } else {
    toast2.fire({
      icon: "warning",
      title:
        "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura",
    });
  }
}

//

var idClienteStatu;

$(document).on("click", ".btnverHistorial", function () {
  var idCliente = $(this).attr("idCliente");
  idClienteStatu = idCliente;
  console.log(idClienteStatu);
  window.location = "index.php?ruta=estadocuenta&idCliente=" + idCliente;
  //window.location = "/estadocuenta/" + idCliente;
  //navigator.vibrate(3000);
});
