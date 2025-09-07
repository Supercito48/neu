/*$(document).ready(function() {
  $("#idCategoria").select2({
    dropdownParent: $("#modalProducto")
  });
});*/

var tablaProducto;
var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});


// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaProducto = $(".tablaProducto").DataTable({
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
    url: "ajax/tablas/tablaProducto.ajax.php",
    dataSrc: "",
  },
  columns: [
    { data: "idProducto" },
    { data: "descProducto" },
    { data: "codigoBarras" },
    { data: "desCat" },
    { data: "precioCompra" },
    { data: "precioVenta" },
    { data: "precioVentaMA" },
    { data: "oferta" },
    { data: "acciones" },
  
  ],
 
  bDestroy: true,
  iDisplayLength: 10,
});

//LIMPAREMOS TODOS LOS INPUTS
function limpiarProducto() {
  $("#idProducto").val("");
  $("#descProducto").val("");
  $("#codigoBarras").val("");
  $('#idCategoria').val(null).trigger('change');
  $("#precioCompra").val("");
  $("#precioVenta").val("");
  $("#precioVentaMA").val("");
  $("#oferta").val("");
}

//AL MOMENTO DE HACER CLICK EN AGREGAR, NOS CAMBIA EL TITULO Y EL COLOR DE LETRA
$("#modalProducto").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Producto");

  limpiarProducto();
});

//AAL MOMENTO DE HACER CLICK EN EDITAR, NOS TIENE QUE TRAER LOS DATOS DE LA BASE, HACIA LOS INPUTS
$(document).on("click", ".editarProducto", function () {
  var idProducto = $(this).attr("idProducto");
  var ajaxProducto = "ajaxProducto";

  var datos = new FormData();
  datos.append("idProducto", idProducto);
  datos.append("ajaxProducto", ajaxProducto);

  $.ajax({
    
    url: "ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idProducto").val(idProducto);
      $("#descProducto").val(respuesta["descProducto"]);
      $("#codigoBarras").val(respuesta["codigoBarras"]);
      $("#idCategoria").val(respuesta["idCategoria"]);
     // $("#idCategoria").select2("val", respuesta["idCategoria"]);
      $("#precioCompra").val(respuesta["precioCompra"]);
      $("#precioVenta").val(respuesta["precioVenta"]);
      $("#precioVentaMA").val(respuesta["precioVentaMA"]);
      $("#oferta").val(respuesta["oferta"]);

     
      $(".modal-header").css("color", "white");
      $(".modal-title").text("Editar Producto");
    },
  });
});


//al hacer click al boton, se ejecutara la funcion que estamos realizando "LLAMAMOS GUARDARProducto DE Producto.php"
$(".guardarProducto").click(function (e) {
  var descProducto = $("#descProducto").val();
  var codigoBarras = $("#codigoBarras").val();
  var precioCompra = $("#precioCompra").val();
  var precioVenta = $("#precioVenta").val();
  var precioVentaMA = $("#precioVentaMA").val();
  var oferta = $("#oferta").val();

  //Validaremos que no se permitan campos vacios.
  
  //Validaremos que no se permitan campos vacios.
  if (descProducto == "") {
    Swal.fire(
      '¡ERROR!',
      'La descripción no debe ir vacia!',
      'error',
    );
    return;
    
  }
  if (codigoBarras == "") {
    Swal.fire(
      '¡ERROR!',
      'El codigo no debe ir vacia!',
      'error',
    );
    return;
    
  }
  if (precioCompra == "") {
    Swal.fire(
      '¡ERROR!',
      'El precio compra no debe ir vacia!',
      'error',
    );
    return;
    
  }
  if (precioVenta == "") {
    Swal.fire(
      '¡ERROR!',
      'El precio venta no debe ir vacia!',
      'error',
    );
    return;
    
  }
  if (precioVentaMA == "") {
    Swal.fire(
      '¡ERROR!',
      'El precio venta amyoritario Arequipa no debe ir vacia!',
      'error',
    );
    return;
    
  }
  
  if (oferta == "") {
    Swal.fire(
      '¡ERROR!',
      'La oferta no debe ir vacia!',
      'error',
    );
    return;
    
  }

  else {
    e.preventDefault();
    var formData = new FormData($("#formularioProducto")[0]);
    $.ajax({
      url: "ajax/producto.ajax.php",
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
              $("#modalProducto").modal("hide");
              limpiarProducto();
              tablaProducto.ajax.reload();
          
        } else {
          Swal.fire(
            'ERROR!',
            '¡No se permiten caracteres especiales o estar vacío!',
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

$(document).on("click", ".eliminarProducto", function () {

  var idInventarioExis = $(this).attr("idInventarioExis");

	if(idInventarioExis != ""){

		toast2.fire({
			icon: 'warning',
			title: '&nbsp;&nbsp;  El Producto no se puede eliminar, porque tiene stock disponible!'
		  })
		return;
	}
  var idProducto = $(this).attr("idProducto");
 
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
      datos.append("idEliminar", idProducto);
      $.ajax({
        url: "ajax/producto.ajax.php",
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
            $("#modalProducto").modal("hide");
            limpiarProducto();
            tablaProducto.ajax.reload();
          }
        },
      });

     
    }
  })
 
 
});

