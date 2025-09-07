var tablaCategoria;

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaCategoria = $(".tablaCategoria").DataTable({
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
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },

  ajax: {
    url: "ajax/tablas/tablaCategoria.ajax.php",
    dataSrc: "",
  },
  columns: [
    { data: "idCategoria" },
    { data: "desCat" },
    { data: "estadoCat" },
    { data: "editar" },
    { data: "eliminar" },
  ],
 
  bDestroy: true,
  iDisplayLength: 10,
});

//LIMPAREMOS TODOS LOS INPUTS
function limpiarCategoria() {
  $("#idCategoria").val("");
  $("#desCat").val("");
}

//AL MOMENTO DE HACER CLICK EN AGREGAR, NOS CAMBIA EL TITULO Y EL COLOR DE LETRA
$("#modalCategoria").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Categoria");

  limpiarCategoria();
});

//AAL MOMENTO DE HACER CLICK EN EDITAR, NOS TIENE QUE TRAER LOS DATOS DE LA BASE, HACIA LOS INPUTS
$(document).on("click", ".editarCategoria", function () {
  var idCategoria = $(this).attr("idCategoria");
  var ajaxCategoria = "ajaxCategoria";

  var datos = new FormData();
  datos.append("idCategoria", idCategoria);
  datos.append("ajaxCategoria", ajaxCategoria);

  $.ajax({
    url: "ajax/categoria.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idCategoria").val(idCategoria);
      $("#desCat").val(respuesta["desCat"]);
     
      $(".modal-header").css("color", "white");
      $(".modal-title").text("Editar Categoria");
    },
  });
});


//al hacer click al boton, se ejecutara la funcion que estamos realizando "LLAMAMOS GUARDARPERSONA DE persona.php"
$(".guardarCategoria").click(function (e) {
  var desCat = $("#desCat").val();
  //Validaremos que no se permitan campos vacios.
  if (desCat == "") {
   
      Swal.fire(
        '¡ERROR!',
        'Solo se aceptan mayusculas y minusculas',
        'error',
      );
        return;
    
  } else {
    e.preventDefault();
    var formData = new FormData($("#formularioCategoria")[0]);
    $.ajax({
      url: "ajax/categoria.ajax.php",
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
              $("#modalCategoria").modal("hide");
              limpiarCategoria();
              tablaCategoria.ajax.reload();
          
        } else {
          Swal.fire(
            'ERROR!',
            '¡No se permiten caracteres especiales!',
            'error',
          )
          .then(function (result) {
            if (result.value) {
            }
          });
        }
      },
    });
  }
});

/*=============================================
Activar o desactivar administrador
=============================================*/

$(document).on("click", ".btnActivar" , function () {
  var idCategoria = $(this).attr("idCategoria");
  var estadoCat = $(this).attr("estadoCat");


//  var boton = $(this);

  var datos = new FormData();
  datos.append("idCategoria", idCategoria);
  datos.append("estadoCat", estadoCat);

  $.ajax({
    url: "ajax/categoria.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      console.log("respuesta",respuesta)
      
    },
  });
  if (estadoCat == 0) {
    $(this).removeClass("btn-success");
    $(this).addClass("btn-danger");

    
    
    $(this).html('<i class="fa fa-toggle-off"></i> Desactivado');
    $(this).attr("estadoCat", 1);
  
  } else {
    $(this).removeClass("btn-danger");
    $(this).addClass("btn-success");

   
    $(this).html('<i class="fa fa-toggle-on"></i> Activado');
    $(this).attr("estadoCat", 0);
  }
});




  $(document).on("click", ".eliminarCategoria", function () {

    var idProductoExis = $(this).attr("idProductoExis");

    if(idProductoExis != ""){
  
      Toast.fire({
        icon: 'warning',
        title: '&nbsp;&nbsp;  Categoria no se puede eliminar, porque se encuentra en uso!'
        })
      return;
    }

   var idCategoria = $(this).attr("idCategoria");
   
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
        datos.append("idEliminar", idCategoria);
        $.ajax({
          url: "ajax/categoria.ajax.php",
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
                    b.textContent = Swal.getTimerLeft()
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
              tablaCategoria.ajax.reload();
            }
          },
        });

       
      }
    })
   

  });