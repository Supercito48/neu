//var tablaEmpleado;

/* Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaEmpleado = $(".tablaEmpleado").DataTable({
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
    url: "ajax/tablaEmpleado.ajax.php",
    dataSrc: "",
  },
  columns: [
    { data: "idEmpleado" },
    { data: "nombres" },
    { data: "apellidos" },
    { data: "telefono" },
    { data: "direccion" },
    { data: "dni" },
    { data: "correo" },
    { data: "fecNacimiento" },
    { data: "foto" },
    { data: "acciones" },
  ],
 
  bDestroy: true,
  iDisplayLength: 10,
});*/

var rutaOculta = $("#rutaOculta").val();

function limpiarEmpleado() {
	$(".idEmpleado").val("");
	$(".nombres").val("");
	$(".apellidos").val("");
	$(".telefono").val("");
	$(".direccion").val("");
	$(".dni").val("");
	$(".correo").val("");
	$(".fecNacimiento").val("");
	$(".foto").val("");
	$(".dni").removeAttr('disabled');
	$(".previsualizarFoto").attr("src", rutaOculta + "views/img/empleado/default/avatar4.png");
}

$("#modalEmpleado").on("show.bs.modal", function (event) {
	$(".modal-header").css("color", "white");
	$(".modal-title").text("Agregar Empleado");

	limpiarEmpleado();
});
/*=============================================
SUBIENDO LA FOTO
=============================================*/

var imagenFoto = null;
$(".foto").change(function () {
	imagenFoto = this.files[0];
	if (imagenFoto["type"] != "image/jpeg" && imagenFoto["type"] != "image/png") {
		$(".foto").val("");
		Swal.fire(
			'Error al subir la imagen',
			'¡La imagen debe estar en formato JPG o PNG!',
			'error',
		)
	} else if (imagenFoto["size"] > 2000000) {
		$(".foto").val("");
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
})


/*=============================================
EDITAR USUARIO
=============================================*/
$(document).on("click", ".editarEmpleado", function () {


	var id = $(this).attr("id");

	var datos = new FormData();
	datos.append("id", id);

	$.ajax({

		url: rutaOculta + "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$(".dni").attr('disabled','disabled');
			$(".idEmpleado").val(id);
			$(".nombres").val(respuesta["nombres"]);
			$(".apellidos").val(respuesta["apellidos"]);
			$(".telefono").val(respuesta["telefono"]);
			$(".direccion").val(respuesta["direccion"]);
			$(".dni").val(respuesta["dni"]);
			$(".correo").val(respuesta["correo"]);
			$(".fecNacimiento").val(respuesta["fecNacimiento"]);
			$(".antiguaFoto").val(respuesta["foto"]);
			if (respuesta["foto"] != "") {
				$(".previsualizarFoto").attr("src", rutaOculta + respuesta["foto"]);
			} else {
				$(".previsualizarFoto").attr("src", rutaOculta + "views/img/empleado/default/avatar4.png");
			}

			$(" .modal-header").css("color", "white");
			$(" .modal-title").text("Editar Empleado");
		}

	});

})

$(".dni").change(function () {

  var dni = $(this).val();

  var datos = new FormData();
  datos.append("ajaxValidarDni", dni);
 
  $.ajax({
    url: rutaOculta+"ajax/empleado.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        
        Toast.fire({
          icon: 'warning',
          title: '&nbsp;&nbsp;  Este dni ya existe en la base de datos!'
        })

        $(".dni").val("");
      }
     
    },
  });
});


$(".guardarEmpleado").click(function () {

	/*=============================================
	ALMACENAMOS TODOS LOS CAMPOS DE PRODUCTO
	=============================================*/
	var nombres = $(".nombres").val();
	var apellidos = $(".apellidos").val();
	var telefono = $(".telefono").val();
	var direccion = $(".direccion").val();
	var dni = $(".dni").val();
	var correo = $(".correo").val();
	var fecNacimiento = $(".fecNacimiento").val();

	var datos = new FormData();
	datos.append("nombres", nombres);
	datos.append("apellidos", apellidos);
	datos.append("telefono", telefono);
	datos.append("direccion", direccion);
	datos.append("dni", dni);
	datos.append("correo", correo);
	datos.append("fecNacimiento", fecNacimiento);
	datos.append("foto", imagenFoto);

	
	
       
	if($(".correo").val().indexOf('@', 0) == -1 || $(".correo").val().indexOf('.', 0) == -1) {
        Toast.fire({
		icon: 'warning',
		title: '&nbsp;&nbsp;  No es un formato de correo, intentelo nuevamente.'
		})
		$(".correo").focus()
		
        return false;
    }


	$.ajax({
		url: rutaOculta + "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {

			// console.log("respuesta", respuesta);	
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

						location.reload()
					}
				}).then((result) => {
					/* Read more about handling dismissals below */
					if (result.dismiss === Swal.DismissReason.timer) {
						console.log('se ha cerrado por el tiempo!')
					}
				})
				$("#modalEmpleado").modal("hide");
				limpiarEmpleado();


			}

		}

	})

});


$(".guardarEditEmpleado").click(function () {


	var id = $("#modalEditarEmpleado .idEmpleado").val();
	var nombres = $("#modalEditarEmpleado .nombres").val();
	var apellidos = $("#modalEditarEmpleado .apellidos").val();
	var telefono = $("#modalEditarEmpleado .telefono").val();
	var direccion = $("#modalEditarEmpleado .direccion").val();
	var dni = $("#modalEditarEmpleado .dni").val();
	var correo = $("#modalEditarEmpleado .correo").val();
	var fecNacimiento = $("#modalEditarEmpleado .fecNacimiento").val();



	var antiguaFoto = $("#modalEditarEmpleado .antiguaFoto").val();


	var datos = new FormData();
	datos.append("idEmpleado", id);
	datos.append("editarnombres", nombres);
	datos.append("apellidos", apellidos);
	datos.append("telefono", telefono);
	datos.append("direccion", direccion);
	datos.append("dni", dni);
	datos.append("correo", correo);
	datos.append("fecNacimiento", fecNacimiento);
	datos.append("foto", imagenFoto);
	datos.append("antiguaFoto", antiguaFoto);
	if($(".correo").val().indexOf('@', 0) == -1 || $(".correo").val().indexOf('.', 0) == -1) {
        Toast.fire({
		icon: 'warning',
		title: '&nbsp;&nbsp;  No es un formato de correo, intentelo nuevamente.'
		})
		$(".correo").focus()
		
        return false;
    }

	$.ajax({
		url: rutaOculta + "ajax/empleado.ajax.php",
		method: "POST",
		data: datos,
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
				$("#modalEditarEmpleado").modal("hide");
				limpiarEmpleado();

				setTimeout(function () {
					location.reload()
				}, 2000);

			}

		}

	})

});

/*=============================================
Eliminar Habitacion
=============================================*/
var Toast = Swal.mixin({
	toast: true,
	position: 'top-end',
	showConfirmButton: false,
	timer: 3000
});


$(document).on("click", ".eliminarEmpleado", function () {

	var UsuarioExiste = $(this).attr("idUsuarioEliminar");

	if(UsuarioExiste != ""){

		Toast.fire({
			icon: 'warning',
			title: '&nbsp;&nbsp;  El empleado no se puede eliminar, porque tiene un usuario disponible!'
		  })
		return;
	}
	var idEliminar = $(this).attr("idEliminar");
	var fotoEliminar = $(this).attr("fotoEliminar");

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
			datos.append("idEliminar", idEliminar);
			datos.append("fotoEliminar", fotoEliminar);

			$.ajax({

				url: rutaOculta + "ajax/empleado.ajax.php",
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
						setTimeout(function () {
							location.reload()
						}, 2000);

					}

				}

			})
		}

	})

})



$(".dni").change(function () {


	var dni = $(".dni").val();

	$.ajax({

		type:"POST",
		url: rutaOculta+"ajax/consultadni.ajax.php",
		data: 'dni='+dni,
		dataType: 'json',
		success: function(data){

			if(data==1){
				alert('El dni tiene que tener 8 digitos')
			}else{

				console.log(data);
				$(".nombres").val(MaysPrimera(data.nombres.toLowerCase()));
				$(".apellidos").val(MaysPrimera(data.apellidoPaterno.toLowerCase()) + ' ' + MaysPrimera(data.apellidoMaterno.toLowerCase()));

			}

		}

	})

})



function MaysPrimera(string){
	return string.charAt(0).toUpperCase() + string.slice(1);
  }