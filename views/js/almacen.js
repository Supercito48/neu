var tablaAlmacen;

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaAlmacen = $(".tablaAlmacen").DataTable({
  "responsive": true,
  "lengthChange": false,
  "autoWidth": false,
  "responsive": true,
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

  ajax: {
    url: "ajax/tablas/tablaAlmacen.ajax.php",
    dataSrc: "",
  },
  columns: [{
      data: "idAlmacen"
    },
    {
      data: "descripcion"
    },
    {
      data: "ubicacion"
    },
    {
      data: "entrada"
    },
    {
      data: "salida"
    },
    {
      data: "estado"
    },
    {
      data: "editar"
    },
    {
      data: "eliminar"
    },
  ],

  bDestroy: true,
  iDisplayLength: 10,
});

//LIMPAREMOS TODOS LOS INPUTS
function limpiarAlmacen() {
  $("#idAlmacen").val("");
  $("#descripcion").val("");
  $("#ubicacion").val("");
  $("#hora_entrada").val("");
  $("#hora_salida").val("");
  $("#descripcion").removeAttr('disabled');
}

//AL MOMENTO DE HACER CLICK EN AGREGAR, NOS CAMBIA EL TITULO Y EL COLOR DE LETRA
$("#modalAlmacen").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Almacen");

  limpiarAlmacen();
});

//AAL MOMENTO DE HACER CLICK EN EDITAR, NOS TIENE QUE TRAER LOS DATOS DE LA BASE, HACIA LOS INPUTS
$(document).on("click", ".editarAlmacen", function () {
  var idAlmacen = $(this).attr("idAlmacen");
  var ajaxAlmacen = "ajaxAlmacen";

  var datos = new FormData();
  datos.append("idAlmacen", idAlmacen);
  datos.append("ajaxAlmacen", ajaxAlmacen);

  $.ajax({
    url: "ajax/almacen.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta);

      if(idAlmacen == 1){
        $("#descripcion").attr('disabled','disabled');
      }

      $("#idAlmacen").val(idAlmacen);
      $("#descripcion").val(respuesta["descripcion"]);
      $("#ubicacion").val(respuesta["ubicacion"]);
      $("#hora_entrada").val(respuesta["entrada"]);
      $("#hora_salida").val(respuesta["salida"]);    
      $(".modal-header").css("color", "white");
      $(".modal-title").text("Editar Almacen");
    },
  });
});


//al hacer click al boton, se ejecutara la funcion que estamos realizando "LLAMAMOS GUARDARALMACEN DE almacen.php"
$(".guardarAlmacen").click(function (e) {
  var descripcion = $("#descripcion").val();
  var ubicacion = $("#ubicacion").val();
  //Validaremos que no se permitan campos vacios.

  //Validaremos que no se permitan campos vacios.
  if (descripcion == "") {
    /*var expresion = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/;
			
    if(!expresion.test(descripcion)){
      Swal.fire(
      '¡ERROR!',
      'El campo descripcion solo acepta numeros',
      'error',
      );
      return;
  
    }
    }else{
*/
    Swal.fire(
      '¡ERROR!',
      'El campo descripcion no debe ir vacio!',
      'error',
    );
    return;
  }

  if (ubicacion == "") {
    /*
    var ubicacion = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/;
      
    if(!expresion.test(ubicacion)){*/
    Swal.fire(
      '¡ERROR!',
      'El campo descripcion solo acepta numeros',
      'error',
    );
    return;

  }
  //}
  else {
    e.preventDefault();
    var formData = new FormData($("#formularioAlmacen")[0]);
    $.ajax({
      url: "ajax/almacen.ajax.php",
      method: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta == "ok") {

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
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log('se ha cerrado por el tiempo!')
            }
          })
          $("#modalAlmacen").modal("hide");
          limpiarAlmacen();
          tablaAlmacen.ajax.reload();

        } else {
          Swal.fire(
              'ERROR!',
              '¡No se permiten caracteres especiales o estar vacío!',
              'error',
            )
            .then(function (result) {
              if (result.value) {}
            });
        }
      },
    });
  }
});

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

$(document).on("click", ".eliminarAlmacen", function () {
  var idAlmacen = $(this).attr("idAlmacen");

  

    if(idAlmacen == 1){

      Toast.fire({
        icon: 'error',
        title: '&nbsp;&nbsp;  El almacen "Principal" no se puede eliminar!'
      })

          return;
  
    }

  Swal.fire({
    title: '¿Está seguro de eliminar este documento?',
    text: "¡Si no lo está puede cancelar la acción!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {

      var datos = new FormData();
      datos.append("idEliminar", idAlmacen);
      $.ajax({
        url: "ajax/almacen.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {

            let timerInterval
            Swal.fire({
              title: '¡CORRECTO!',
              html: 'Se elimino correctamente.',
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
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log('se ha cerrado por el tiempo!')
              }
            })
            tablaAlmacen.ajax.reload();
          }
        },
      });


    }
  })


});

$(document).on("click", ".btnActivarAlm" , function () {
  var idAlmacen = $(this).attr("idAlmacen");
  var estado = $(this).attr("estado");


//  var boton = $(this);

 if(idAlmacen == 1){

      Toast.fire({
        icon: 'warning',
        title: '&nbsp;&nbsp;  El almacen "Principal" no se puede desactivar!'
      })

          return;
  
    }

  var datos = new FormData();
  datos.append("ajaxEstado", "ajaxEstado");
  datos.append("idAlmacen", idAlmacen);
  datos.append("estado", estado);

  $.ajax({
    url: "ajax/almacen.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log("respuesta",respuesta)
      
    },
  });
  if (estado == 0) {
    $(this).removeClass("btn-success");
    $(this).addClass("btn-danger");

    
    
    $(this).html('<i class="fa fa-toggle-off"></i> Desactivado');
    $(this).attr("estado", 1);
  
  } else {
    $(this).removeClass("btn-danger");
    $(this).addClass("btn-success");

   
    $(this).html('<i class="fa fa-toggle-on"></i> Activado');
    $(this).attr("estado", 0);
  }
});


/*// fecha actual
let date = new Date();

// la hora en tu zona horaria actual
var hora = date.getHours()+":"+ date.getMinutes() ;

console.log(hora)

var entrada = $("#entrada").val();
var salida = $("#salida").val();

console.log(entrada)



if (hora >= entrada &&  hora <= salida) {
  
  console.log("true")
  
  
}else{
  
  console.log("false")
}
*/
function pruebaprueba() {
  console.log("Se ejecuta la funcion")
}
function pruebacambios() {
  // fecha actual
  let date = new Date();

  // la hora en tu zona horaria actual
  var hora = date.getHours() + ":" + date.getMinutes();

  console.log(hora)

  var entrada = $("#entrada").val();
  var salida = $("#salida").val();

  console.log(entrada)



  if (hora >= entrada && hora <= salida) {

    console.log("true")


  } else {

    pruebaprueba();
  }
}

/*setInterval(function () {
  pruebacambios();
}, 10000);*/