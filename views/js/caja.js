var tablaCaja;
var rutaOculta = $("#rutaOculta").val();
var idAlmacen = $("#idAlmacen").val();
var idUsuario = $("#idUsuario").val();
var estado_caja;

fnc_estado_caja();
fnc_idCAja();
var n = new Date();
var y = n.getFullYear();
var m = n.getMonth() + 1;
var d = n.getDate();
if (d < 10) {
  d = "0" + d;
}
if (m < 10) {
  m = "0" + m;
}
document.getElementById("txtfechainicio").value = y + "-" + m + "-" + d;
document.getElementById("txtfechafin").value = y + "-" + m + "-" + d;

txtfechainicio = $("#txtfechainicio").val();
txtfechafin = $("#txtfechafin").val();

tablaCaja = $(".tablaCaja").DataTable({
  responsive: false,
  lengthChange: true,
  autoWidth: true,

  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },

  ajax: {
    url: rutaOculta + "ajax/tablas/tablaCaja.ajax.php",
    dataSrc: "",
    data: {
      idAlmacen: idAlmacen,
      fechaDesde: txtfechainicio,
      fechaHasta: txtfechafin, //1: LISTAR PRODUCTOS
    },
  },
  columns: [
    {
      data: "idCaja",
    },
    {
      data: "fecha_apertura",
    },
    {
      data: "fecha_cierre",
    },
    {
      data: "monto_apertura",
    },
    {
      data: "monto_ingreso",
    },
    {
      data: "monto_egreso",
    },
    {
      data: "monto_cierre",
    },
    {
      data: "nombres",
    },
    {
      data: "estado",
    },
    {
      data: "acciones",
    },
  ],

  bDestroy: true,
  iDisplayLength: 10,
});

$("#btnFiltrar").on("click", function () {
  tablaCaja.destroy();

  if ($("#txtfechainicio").val() == "") {
    txtfechainicio = "01/10/2000";
  } else {
    txtfechainicio = $("#txtfechainicio").val();
  }

  if ($("#txtfechafin").val() == "") {
    txtfechafin = "10/10/9999";
  } else {
    txtfechafin = $("#txtfechafin").val();
  }

  txtfechainicio = $("#txtfechainicio").val();
  txtfechafin = $("#txtfechafin").val();

  tablaCaja = $(".tablaCaja").DataTable({
    responsive: false,
    lengthChange: false,
    autoWidth: false,

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: rutaOculta + "ajax/tablas/tablaCaja.ajax.php",
      dataSrc: "",
      data: {
        idAlmacen: idAlmacen,
        fechaDesde: txtfechainicio,
        fechaHasta: txtfechafin, //1: LISTAR PRODUCTOS
      },
    },
    columns: [
      {
        data: "idCaja",
      },
      {
        data: "fecha_apertura",
      },
      {
        data: "fecha_cierre",
      },
      {
        data: "monto_apertura",
      },
      {
        data: "monto_ingreso",
      },
      {
        data: "monto_egreso",
      },
      {
        data: "monto_cierre",
      },
      {
        data: "nombres",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],

    bDestroy: true,
    iDisplayLength: 10,
  });
});

$("#btnQFiltro").on("click", function () {
  var n = new Date();
  var y = n.getFullYear();
  var m = n.getMonth() + 1;
  var d = n.getDate();
  if (d < 10) {
    d = "0" + d;
  }
  if (m < 10) {
    m = "0" + m;
  }
  $("#iptPaciente").val("");
  $("#iptRaza").val("");
  document.getElementById("txtfechainicio").value = y + "-" + m + "-" + d;
  document.getElementById("txtfechafin").value = y + "-" + m + "-" + d;

  txtfechainicio = $("#txtfechainicio").val();
  txtfechafin = $("#txtfechafin").val();

  tablaCaja = $(".tablaCaja").DataTable({
    responsive: false,
    lengthChange: false,
    autoWidth: false,

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: rutaOculta + "ajax/tablas/tablaCaja.ajax.php",
      dataSrc: "",
      data: {
        idAlmacen: idAlmacen,
        fechaDesde: txtfechainicio,
        fechaHasta: txtfechafin, //1: LISTAR PRODUCTOS
      },
    },
    columns: [
      {
        data: "idCaja",
      },
      {
        data: "fecha_apertura",
      },
      {
        data: "fecha_cierre",
      },
      {
        data: "monto_apertura",
      },
      {
        data: "monto_ingreso",
      },
      {
        data: "monto_egreso",
      },
      {
        data: "monto_cierre",
      },
      {
        data: "nombres",
      },
      {
        data: "estado",
      },
      {
        data: "acciones",
      },
    ],

    bDestroy: true,
    iDisplayLength: 10,
  });
});

var idcajaPrueba;
var fechaPrueba;

function fnc_actualizar_totales() {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxTotalTodo: "ajaxTotalTodo",
      idCaja: idcajaPrueba,
      idUsuario: idUsuario,
      fecha: fechaPrueba,
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);

      $("#montoApertura").html(respuesta["montoApertura"]);
      $("#totalventas").html(respuesta["TotalVentas"]);
      $("#totalingreso").html(respuesta["Ingreso"]);
      $("#totalegreso").html(respuesta["Egreso"]);
   

      var totalfinal =
        Number($("#montoApertura").html()) +
        Number($("#totalventas").html()) +
        Number($("#totalingreso").html()) -
        Number($("#totalegreso").html()) ;

      console.log(totalfinal);
      prueba = parseFloat(totalfinal).toFixed(2);
      $("#totalfinal").html(prueba);

      //$("#totalVentasRealizadas").html(respuesta["total_ventas"]);
      //$("#saldoCaja").html(respuesta["saldo_caja"]);
    },
  });
}

function fnc_idCAja() {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
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
        //console.log(respuesta["idCaja"]);
        $("#idCaja").val(respuesta["idCaja"]);
      }
    },
  });
}

$(".guardarAbrirCaja").on("click", function () {
  var html_confirm =
    '<div>Se creará una apertura de caja con los siguientes datos:</div>\
  <br><div style="width: 100% !important; float: none !important;">\
  <table class="table m-b-0">\
  <tr><td class="text-left">Cajero: </td><td class="text-right">' +
    $("#nombreUsuario").val() +
    '</td></tr>\
  <tr><td class="text-left">Monto: </td><td class="text-right">' +
    parseFloat($("#monto_apertura").val()).toFixed(2) +
    '</td></tr>\
  </table>\
  </div><br>\
  <div><span class="text-success" style="font-size: 17px;">¿Está Usted de Acuerdo?</span></div>';
  Swal.fire({
    title: "Necesitamos de tu Confirmación",
    html: html_confirm,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#34d16e",
    confirmButtonText: "Si, Adelante!",
    cancelButtonText: "No!",
    showLoaderOnConfirm: true,
    preConfirm: function () {
      if (estado_caja == 0) {
        var idUsuario = $("#idUsuario").val(),
          monto_apertura = $("#monto_apertura").val(),
          idAlmacen = $("#idAlmacen").val();

        var datos = new FormData();

        datos.append("ajaxAperturaCaja", "ajaxAperturaCaja");
        datos.append("idUsuario", idUsuario);
        datos.append("monto_apertura", monto_apertura);
        datos.append("idAlmacen", idAlmacen);

        $.ajax({
          url: rutaOculta + "ajax/caja.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            Swal.fire({
              title: "¡CORRECTO!",
              html: "¡Caja abierta exitosamente!",
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
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log("se ha cerrado por el tiempo!");
              }
            });
            $("#modal_Apertura").modal("hide");
            fnc_estado_caja();
            tablaCaja.ajax.reload();
          },
        });
      } else {
        Swal.fire({
          title: "Error!",
          html: "¡Ya tienes una caja abierta!",
          icon: "error",
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
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
            console.log("se ha cerrado por el tiempo!");
          }
        });
        $("#modal_Apertura").modal("hide");
        fnc_estado_caja();
        tablaCaja.ajax.reload();
      }
    },
    allowOutsideClick: false,
  });
});

function fnc_estado_caja() {
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxVerificarCaja: "ajaxVerificarCaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
      estado_caja = respuesta["count(*)"];
    },
  });
}

$(document).on("click", ".btnCierre", function () {
  var idCaja = $(this).attr("idCaja");
  $("#idCaja").val(idCaja);
  idcajaPrueba = idCaja;
  $("#modal_cuentas").modal("show");

  var data = tablaCaja.row($(this).parents("tr")).data();
  var fechaTraer = data["fecha_apertura"];
  fechaPrueba = fechaTraer.substr(-20, 10);

  fnc_actualizar_totales();
});

$(document).on("click", ".btnCerrarCaja", function () {
  var idCaja = $("#idCaja").val();
  var monto_ingreso=  $("#totalingreso").html();
  var monto_egreso=  $("#totalegreso").html();
  var monto_cierre=  $("#totalfinal").html();
      

  $("#modal_cuentas").modal("hide");

  Swal.fire({
    title: "¿Está seguro de cerrar caja?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, cerrar!",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("ajaxCierreCaja", "ajaxCierreCaja");
      datos.append("idCaja", idCaja);
      datos.append("monto_ingreso",monto_ingreso);
      datos.append("monto_egreso",monto_egreso);
      datos.append("monto_cierre",monto_cierre);
      $.ajax({
        url: rutaOculta + "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          let timerInterval;
          Swal.fire({
            title: "¡CORRECTO!",
            html: "Se cerro correctamente.",
            icon: "success",
            timer: 1500,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
              const b = Swal.getHtmlContainer().querySelector("b");
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft();
              }, 75);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("se ha cerrado por el tiempo!");
            }
          });
          tablaCaja.ajax.reload();
          fnc_estado_caja();
        },
      });
    }
  });
});

$(document).on("click", ".btnIngreso", function () {
  $("#tipo").val("Ingreso");
  $(".modal-header").removeClass("bg-red");
  $(".modal-header").addClass("bg-success");
  var idCaja = $(this).attr("idCaja");
  $("#idCajaM").val(idCaja);
});

$(document).on("click", ".btnEgreso", function () {
  $("#tipo").val("Egreso");
  $(".modal-header").removeClass("bg-success");
  $(".modal-header").addClass("bg-red");
  var idCaja = $(this).attr("idCaja");
  $("#idCajaM").val(idCaja);
});

$(document).on("click", ".btnGuardar", function () {
  var idCaja = $("#idCajaM").val();
  var tipo = $("#tipo").val();
  var descripcion = $("#descripcion").val();
  var monto = $("#monto").val();

  console.log(idUsuario, idCaja, tipo, descripcion, monto);

  var texto = "";
  var text2 = "";

  if (tipo == "Ingreso") {
    texto = "¿Está seguro de realizar un ingreso a caja?";
    text2 = "Se realizo el ingreso correctamente.";
  } else {
    texto = "¿Está seguro de realizar un egreso a caja?";
    text2 = "Se realizo el Egreso correctamente.";
  }

  $("#mdlGestionarCaja").modal("hide");

  Swal.fire({
    title: texto,
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si!",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("ajaxGuardarDetalle", "ajaxGuardarDetalle");
      datos.append("idCaja", idCaja);
      datos.append("tipo", tipo);
      datos.append("descripcion", descripcion);
      datos.append("monto", monto);
      datos.append("idUsuario", idUsuario);
      $.ajax({
        url: rutaOculta + "ajax/caja.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          let timerInterval;
          Swal.fire({
            title: "¡CORRECTO!",
            html: text2,
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
          tablaCaja.ajax.reload();
        },
      });
    }
  });
});

var tablaIngreso;
var tablaEgreso;

$(document).on("click", ".btnverDetalle", function () {
  var data = tablaCaja.row($(this).parents("tr")).data();
  //console.log("🚀 ~ file: productos.php ~ line 751 ~ $ ~ data", data)

  var fechaTraer = data["fecha_apertura"];

  $("#fechaCaja").html(data["fecha_apertura"]);
  $("#cajeroCaja").html(data["nombres"]);

  var fecha = fechaTraer.substr(-20, 10);

  var idCaja = $(this).attr("idCaja");
  //var tipo = "Ingreso"

  tablaIngreso = $(".tablaIngreso").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: rutaOculta + "ajax/caja.ajax.php",
      data: {
        idCaja: idCaja,
        tipo: "Ingreso",
        fecha: fecha,
        ajaxMostrarDetalleC: "ajaxMostrarDetalleC",
      },
      type: "post",
      dataSrc: "",
    },

    columns: [
      {
        data: "empleado",
      },

      {
        data: "descripcion",
      },
      {
        data: "monto",
      },
    ],

    bDestroy: true,
    iDisplayLength: 10,
    bPaginate: false,
    bFilter: false,
    bInfo: false,
  });

  tablaEgreso = $(".tablaEgreso").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    responsive: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: rutaOculta + "ajax/caja.ajax.php",
      data: {
        idCaja: idCaja,
        tipo: "Egreso",
        fecha: fecha,
        ajaxMostrarDetalleC: "ajaxMostrarDetalleC",
      },
      type: "post",
      dataSrc: "",
    },

    columns: [
      {
        data: "empleado",
      },

      {
        data: "descripcion",
      },
      {
        data: "monto",
      },
    ],

    bDestroy: true,
    iDisplayLength: 10,
    bPaginate: false,
    bFilter: false,
    bInfo: false,
  });
});

$(document).on("click", ".imprimirResumen", function () {
  var idCaja = $(this).attr("idCaja");
  var data = tablaCaja.row($(this).parents("tr")).data();
  //console.log("🚀 ~ file: productos.php ~ line 751 ~ $ ~ data", data)

  var fechaTraer = data["fecha_apertura"];

  var fechaImpr = fechaTraer.substr(-20, 10);
  
  //printJS(rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idCaja="+idCaja)
  window.open(
    rutaOculta+"/extensions/libreporte/reportes/generar_caja.php?idCaja=" +
    idCaja + "&fecha=" + fechaImpr +
    "#zoom=100%",
    "Ticket",
    "scrollbars=NO"
  );
  
});
