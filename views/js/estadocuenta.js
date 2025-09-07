var idClienteStatu = $("#idCliente").val();
var lstMes;
var monto_usado;
var idUsuario = $("#idUsuario").val();
var idCaja;
var rutaOculta = $("#rutaOculta").val();
var montoComparar;
var tablaAbono;

mostrarClientes(idClienteStatu);
fnc_idCAja();

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

function mostrarClientes(idClienteStatu) {
  var ajaxMostrarCliente = "ajaxMostrarCliente";
  var datos = new FormData();
  datos.append("idCliente", idClienteStatu);
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

      monto_usado =
        Number(respuesta["limite_credito"]) -
        Number(respuesta["credito_usado"]);

      montoComparar = monto_usado;

      if (monto_usado == 0) {
        $("#btnAbonar").prop("disabled", true);
        $("#btnLiquidarAdeudo").prop("disabled", true);
        $("#btnImprimirEstado").prop("disabled", true);
      }
      $("#nomCli").html(respuesta["nombres"]);
      $("#saldoAct").html(formatMoney(monto_usado));
      $("#limitCredit").html(formatMoney(respuesta["limite_credito"]));
    },
  });
}

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
    (decPlaces
      ? decSep +
        Math.abs(number - i)
          .toFixed(decPlaces)
          .slice(2)
      : "")
  );
}

lstMes = $("#lstMes").DataTable({
  lengthChange: false,
  autoWidth: false,

  searching: false,
  info: false,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },

  ajax: {
    url: "ajax/tablas/tablaClienFC.ajax.php",
    dataSrc: "",
    data: {
      idCliente: idClienteStatu,
    },
  },

  columns: [
    {
      data: "id",
    },
    {
      data: "fecha",
    },
    {
      data: "idVenta",
    },
    {
      data: "acciones",
    },
  ],

  columnDefs: [
    {
      targets: 0,
      visible: false,
    },
    {
      targets: 2,
      visible: false,
    },
  ],
  bDestroy: true,
  iDisplayLength: 10,
});

lstDetCred = $("#lstDetCred").DataTable({
  responsive: true,
  lengthChange: false,
  autoWidth: false,
  responsive: true,
  searching: false,
  info: false,
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
  columnDefs: [
    {
      targets: 0,
      visible: false,
    },
  ],

  bDestroy: true,
  iDisplayLength: 10,
});
$(document).on("click", ".btnVerDetalle", function () {
  var data = lstMes.row($(this).parents("tr")).data();

  var idVenta = data["idVenta"];

  lstDetCred.destroy();

  lstDetCred = $("#lstDetCred").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    searching: false,
    info: false,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: "ajax/tablas/tablaClientDet.ajax.php",
      dataSrc: "",
      data: {
        idVenta: idVenta,
      },
    },

    columns: [
      {
        data: "idVenta",
      },
      {
        data: "codigo_producto",
      },
      {
        data: "descProducto",
      },
      {
        data: "precio_venta",
      },
      {
        data: "cantidad",
      },
      {
        data: "total_venta",
      },
    ],
    columnDefs: [
      {
        targets: 0,
        visible: false,
      },
    ],

    bDestroy: true,
    iDisplayLength: 10,
  });
});

$("#moda_pagar").on("show.bs.modal", function (event) {
  $("#metodo_pago").val("").trigger("change");
  $("#monto_p").val("");
  $("#montoescrito").val("");
});

$(document).on("click", "#btnAbonar", function () {
  $("#creditusado").html(monto_usado.toFixed(2));
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
            idCliente: idClienteStatu,
            monto: monto,
            comision: comisionPagar,
            metodo: metodo,
            idCaja: idCaja,
            montoComparar: montoCompararP,
          },
          dataType: "json",
          success: function (respuesta) {
            Swal.fire({
              title: "Se abono correctamente!",
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
                    idClienteStatu +
                    "#zoom=100%",
                  "Ticket",
                  "scrollbars=NO"
                );
                $("#moda_pagar").modal("hide");
                mostrarClientes(idClienteStatu);
                tablaAbono.ajax.reload();
                //tablaClientes.ajax.reload();
              } else {
                $("#moda_pagar").modal("hide");
                mostrarClientes(idClienteStatu);
                tablaAbono.ajax.reload();
                //tablaClientes.ajax.reload();
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

$(document).on("click", "#btnLiquidarAdeudo", function () {
  Swal.fire({
    title: "¿Está seguro de liquidar el adeudo de este cliente?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, liquidar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "ajax/clientes.ajax.php",
        type: "POST",
        data: {
          ajaxPagarCredito: "ajaxPagarCredito",
          idCliente: idClienteStatu,
          monto: $("#saldoAct").html(),
          comision: 0,
          metodo: "Efectivo",
          idCaja: idCaja,
        },
        dataType: "json",
        success: function (respuesta) {
          Swal.fire({
            title: "Deuda liquidara correctamente!",
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
                  idClienteStatu +
                  "#zoom=100%",
                "Ticket",
                "scrollbars=NO"
              );
              $("#moda_pagar").modal("hide");
              mostrarClientes(idClienteStatu);
              tablaAbono.ajax.reload();
              //tablaClientes.ajax.reload();
            } else {
              $("#moda_pagar").modal("hide");
              mostrarClientes(idClienteStatu);
              tablaAbono.ajax.reload();
              //tablaClientes.ajax.reload();
            }
          });
        },
      });
    }
  });
});

$(document).on("click", "#btnImprimirEstado", function () {
  Swal.fire({
    title: "¿Imprimir Estado de cuenta?",
    text: "Datos de Confirmación",
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, Imprimir!",
  }).then((result) => {
    if (result.isConfirmed) {
      window.open(
        rutaOculta +
          "/extensions/libreporte/reportes/generar_boleta.php?idCliente=" +
          idClienteStatu +
          "#zoom=100%",
        "Ticket",
        "scrollbars=NO"
      );
    } else {
    }
  });
});

function mostrarDetalleAbono(idClienteStatu) {
  tablaAbono = $("#lstDetalleAbono").DataTable({
    aaSorting: [[0, "DESC"]],
    ajax: {
      url: "ajax/clientes.ajax.php",
      dataSrc: "",
      type: "POST",
      data: {
        ajaxMostrarDetalleAbono: "ajaxMostrarDetalleAbono",
        idCliente: idClienteStatu,
      },
    },
    responsive: {
      details: {
        type: "column",
      },
    },

    columnDefs: [
      {
        targets: 0,
        orderable: false,
        className: "control",
      },
      {
        targets: 0,
        visible: false,
      },
      /*, {
                targets: 3,
                orderable: false,
                render: function(data, type, full, meta) {
                    return "<center>" +
                        "<span class='btnEditarProducto text-primary px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-pencil-alt fs-5'></i>" +
                        "</span>" +
                        "<span class='btnAumentarStock text-success px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-plus-circle fs-5'></i>" +
                        "</span>" +
                        "<span class='btnDisminuirStock text-warning px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-minus-circle fs-5'></i>" +
                        "</span>" +
                        "<span class='btnEliminarProducto text-danger px-1' style='cursor:pointer;'>" +
                        "<i class='fas fa-trash fs-5'></i>" +
                        "</span>" +
                        "</center>"
                }
            }*/
    ],

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    bDestroy: true,
  });
}

$(document).on("click", "#btnDetalleAbono", function () {
  mostrarDetalleAbono(idClienteStatu);
});
