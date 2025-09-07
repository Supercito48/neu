var tablaConfiguracion;
var rutaOculta = $("#rutaOculta").val();

var imagenFoto = null;
$(".logo").change(function () {
  imagenFoto = this.files[0];
  if (imagenFoto["type"] != "image/jpeg" && imagenFoto["type"] != "image/png") {
    $(".logo").val("");
    Swal.fire(
      'Error al subir la imagen',
      '¡La imagen debe estar en formato JPG o PNG!',
      'error',
    )
  } else if (imagenFoto["size"] > 2000000) {
    $(".logo").val("");
    Swal.fire(
      'Error al subir la imagen',
      '¡La imagen no debe pesar más de 2MB!',
      'error',
    )
  } else {
    var datosImagen = new FileReader;
    datosImagen.readAsDataURL(imagenFoto);
    $(datosImagen).on("load", function (event) {
      var rutaImagen = event.target.result;
      $(".previsualizarFoto").attr("src", rutaImagen);
    })
  }
  console.log(datosImagen)
})

tablaConfiguracion = $("#tablaConfiguracion").DataTable({
lengthChange: false,
  autoWidth: false,

  ajax: {
    url: "ajax/configuracion.ajax.php",
    dataSrc: "",
    type: "POST",
    data: {
      ajaxMostrarConfiguracion: "ajaxMostrarConfiguracion",
    },
  },
  responsive: {
    details: {
      type: "column",
      target: 0
    },

  },

  columnDefs: [{
      targets: 0,
      orderable: false,
      className: "control",
    },
    {
      //2
      targets: 1,
      "render": function (data, type, row, meta) {
        return '<img src="' + rutaOculta + '' + row[1] + '" style="height:50px;width:50px;" />';
      },

    },
    {
      targets: 9,
      orderable: false,
      render: function (data, type, row, meta) {
        return "<center>" +
          "<button class='btn btn-warning btneditarEmpresa'  idEmpresa ='" + row[0] + "' data-toggle='modal' data-target='#modalConfiguracion'>" +
          "<i class='fas fa-edit'></i></button>" +
          "</center>"
      }
    }

  ],

  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
  bDestroy: true,


});



$(document).on("click", ".btneditarEmpresa", function () {


  var data = tablaConfiguracion.row($(this).parents('tr')).data();

  $(".idEmpresa").val(data[0]);
  $(".ruc").val(data[2]);
  $(".razon_social").val(data[3]);
  $(".direccion").val(data[4]);
  $(".email").val(data[5]);
  $(".moneda").val(data[6]);
  $(".simbolom").val(data[7]);
  $(".impuesto").val(data[8]);
  $(".antiguoLogo").val(data[1]);
  $(".previsualizarFoto").attr("src", rutaOculta + data[1]);
  /*var idEmpresa = $(this).attr("idEmpresa");
  var ajaxMostrarConfiguracionEdit = "ajaxMostrarConfiguracionEdit";
  var datos = new FormData();
  datos.append("idEmpresa", idEmpresa);
  datos.append("ajaxMostrarConfiguracionEdit", ajaxMostrarConfiguracionEdit);
  $.ajax({
    url: "ajax/configuracion.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);
     
    },
  });*/
});

$(".guardarConfiguracion").on("click", function () {
  var idEmpresa = $(".idEmpresa").val(),
    ruc = $(".ruc").val(),
    razon_social = $(".razon_social").val(),
    direccion = $(".direccion").val(),
    email = $(".email").val(),
    moneda = $(".moneda").val(),
    simbolom = $(".simbolom").val(),
    email = $(".email").val(),
    impuesto = $(".impuesto").val(),
    antiguoLogo = $(".antiguoLogo").val();

  var datos = new FormData();

  datos.append("ajaxEditarEmpresa", "ajaxEditarEmpresa");
  datos.append("idEmpresa", idEmpresa);
  datos.append("logo", imagenFoto);
  datos.append("ruc", ruc);
  datos.append("razon_social", razon_social);
  datos.append("direccion", direccion);
  datos.append("email", email);
  datos.append("moneda", moneda);
  datos.append("simbolom", simbolom);
  datos.append("impuesto", impuesto);
  datos.append("antiguoLogo", antiguoLogo);

  $.ajax({
    url: "ajax/configuracion.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

      $("#modalConfiguracion").modal("hide");
      tablaConfiguracion.ajax.reload();

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