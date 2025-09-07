var tablaProveedores;
var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaProveedores = $(".tablaProveedores").DataTable({
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
    url: "ajax/tablas/tablaProveedores.ajax.php",
    dataSrc: "",
  },
  columns: [
    { data: "idProveedor" },
    { data: "RUC" },
    { data: "nombre" },
    { data: "direccion" },
    { data: "celular" },
    { data: "telefono" },
    { data: "email" },
    { data: "acciones" },
  ],
 
  bDestroy: true,
  iDisplayLength: 10,
});

function limpiarProveedores() {
    $("#idProveedor").val("");
    $("#RUC").val("");
    $("#nombre").val("");
    $("#direccion").val("");
    $("#celular").val("");
    $("#telefono").val("");
    $("#email").val("");
  }
  
  $("#modalProveedores").on("show.bs.modal", function (event) {
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Agregar Proveedores");
  
    limpiarProveedores();
  });
  
  $(document).on("click", ".editarProveedores", function () {
    var idProveedor = $(this).attr("idProveedor");
    var ajaxProveedores = "ajaxProveedores";
  
    var datos = new FormData();
    datos.append("idProveedor", idProveedor);
    datos.append("ajaxProveedores", ajaxProveedores);
  
    $.ajax({
      url: "ajax/proveedores.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#idProveedor").val(idProveedor);
        $("#RUC").val(respuesta["RUC"]);
        $("#nombre").val(respuesta["nombre"]);
        $("#direccion").val(respuesta["direccion"]);
        $("#celular").val(respuesta["celular"]);
        $("#telefono").val(respuesta["telefono"]);
        $("#email").val(respuesta["email"]);
       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Categoria");
      },
    });
  });


$(".guardarProveedores").click(function (e) {
    var RUC = $("#RUC").val();
    var nombre = $("#nombre").val();
    var direccion = $("#direccion").val();
    var celular = $("#celular").val();
    var email = $("#email").val();
    
    if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
        Toast.fire({
		icon: 'warning',
		title: '&nbsp;&nbsp;  No es un formato de correo, intentelo nuevamente.'
		})
		$("#email").focus()
		
        return false;
    }
    
      e.preventDefault();
      var formData = new FormData($("#formularioProveedores")[0]);
      $.ajax({
        url: "ajax/proveedores.ajax.php",
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
                $("#modalProveedores").modal("hide");
                limpiarProveedores();
                tablaProveedores.ajax.reload();
            
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
    
  });

  $(document).on("click", ".eliminarProveedores", function () {
    var idProveedor = $(this).attr("idProveedor");
   
    Swal.fire({
      title: '¿Está seguro de eliminar este proveedor?',
      text: "¡Si no lo está puede cancelar la acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
      if (result.isConfirmed) {

        var datos = new FormData();
        datos.append("idEliminar", idProveedor);
        $.ajax({
          url: "ajax/proveedores.ajax.php",
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
              tablaProveedores.ajax.reload();
            }
          },
        });

       
      }
    })
   
   
  });

  function validarCorreo(correo){ 
    var expReg= /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
    var esValido = expReg.test(correo);
    if(esValido==true){
    alert ('valido')
    }else{
    alert('invalido')}
    }


    

$("#RUC").change(function () {


	var ruc = $("#RUC").val();

	$.ajax({

		type:"POST",
		url: "ajax/consultaruc.ajax.php",
		data: 'ruc='+ruc,
		dataType: 'json',
		success: function(data){

			if(data==1){
				alert('El ruc tiene que tener 11 digitos')
			}else{

				$("#nombre").val(MaysPrimera(data.nombre.toLowerCase()));
        $("#direccion").val(MaysPrimera(data.direccion.toLowerCase()));
        
			}

		}

	})

})

function MaysPrimera(string){
	return string.charAt(0).toUpperCase() + string.slice(1);
  }