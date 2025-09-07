var tablaComprobante;

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaComprobante = $(".tablaComprobante").DataTable({
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
        url: "ajax/tablas/tablaComprobante.ajax.php",
        dataSrc: "",
    },
    columns: [{
            data: "idDocalmacen "
        },
        {
            data: "descAlmacen "
        },
        {
            data: "Documento"
        },
        {
            data: "Serie"
        },
        {
            data: "Cantidad"
        },
        {
            data: "acciones"
        },
    ],

    bDestroy: true,
    iDisplayLength: 10,
});
$("#modalComprobante").on("show.bs.modal", function (event) {
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Agregar Comprobante");
  
    $(".guardarComprobante").show();
    $(".editarComprob").hide();
});
  


$(".guardarComprobante").on('click', function () {

    var idAlmacen = $("#idAlmacen").val(),
        Documento = $(".Documento").val(),
        Serie = $(".Serie").val(),
        Cantidad = $(".Cantidad").val();

    var datos = new FormData();

    datos.append('ajaxRegistrar', 'ajaxRegistrar')
    datos.append('idAlmacen', idAlmacen)
    datos.append('Documento', Documento)
    datos.append('Serie', Serie);
    datos.append('Cantidad', Cantidad);

    $.ajax({
        url: "ajax/comprobante.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            
            $("#modalComprobante").modal('hide');
            tablaComprobante.ajax.reload(null, false);

            $(".Documento").val("");
            $(".Serie").val("");
            $(".Cantidad").val("");

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
    });
})



$(document).on("click", ".editarComprobante", function () {
    var idDocalmacen = $(this).attr("idDocalmacen");
    var ajaxVerComprobante = "ajaxVerComprobante";
    var datos = new FormData();
    datos.append("idDocalmacen", idDocalmacen);
    datos.append("ajaxVerComprobante", ajaxVerComprobante);
    $.ajax({
      url: "ajax/comprobante.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        console.log(respuesta);
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Comprobante");
        $("#idDocalmacen").val(respuesta["idDocalmacen"]);
        $("#Documento").val(respuesta["Documento"]);
        $("#Serie").val(respuesta["Serie"]);
        $("#Cantidad").val(respuesta["Cantidad"]);
        $("#idAlmacen").val(respuesta["idAlmacen"]).trigger("change");

        $(".guardarComprobante").hide();
        $(".editarComprob").show();
      },
    });
  });

  
$(".editarComprob").on('click', function () {

    var idDocalmacen = $("#idDocalmacen").val(),
        idAlmacen = $("#idAlmacen").val(),
        Documento = $(".Documento").val(),
        Serie = $(".Serie").val(),
        Cantidad = $(".Cantidad").val();

    var datos = new FormData();

    datos.append('ajaxEditarComprobante', 'ajaxEditarComprobante')
    datos.append('idDocalmacen', idDocalmacen)
    datos.append('idAlmacen', idAlmacen)
    datos.append('Documento', Documento)
    datos.append('Serie', Serie);
    datos.append('Cantidad', Cantidad);

    $.ajax({
        url: "ajax/comprobante.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            
            $("#modalComprobante").modal('hide');
            tablaComprobante.ajax.reload(null, false);

            $(".Documento").val("");
            $(".Serie").val("");
            $(".Cantidad").val("");

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
    });
})


$(document).on("click", ".eliminarComprobante", function () {
    var idDocalmacen = $(this).attr("idDocalmacen");
    Swal.fire({
      title: "¿Está seguro de eliminar el comprobante?",
      text: "¡Si no lo está puede cancelar la acción!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, eliminar!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "ajax/comprobante.ajax.php",
          type: "POST",
          data: {
            ajaxBorrarComprobante: "ajaxBorrarComprobante",
            idDocalmacen: idDocalmacen,
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
            tablaComprobante.ajax.reload(null, false);
          },
        });
      }
    });
  });