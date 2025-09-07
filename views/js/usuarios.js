var tablaUsuario;
//
//var collapsedGroups = {};


// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaUsuario = $(".tablaUsuario").DataTable({
  // paging: false,
 // "order": [[ 4, 'asc' ]],
  //"columnDefs": [
   // { "visible": false, "targets": 4 }
//],
//

  "responsive": true, 
  "lengthChange": false, 
  "autoWidth": false,
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
    url: "ajax/tablas/tablaUsuarios.ajax.php",
    dataSrc: "",
  },
  columns: [
    { data: "idUsuario" },
    { data: "idEmpleado" },
    { data: "idAlmacen" },
    { data: "login" },
    { data: "descPerfil" },
    { data: "ultimo_login" },
    { data: "acciones" },
  ],
  

  bDestroy: true,
  iDisplayLength: 10,

 
 //

 
 /*rowGroup: {
  // Uses the 'row group' plugin
  dataSrc: 'descPerfil',
  startRender: function(rows, group) {
    var collapsed = !!collapsedGroups[group];

    
    rows.nodes().each(function(r) {
      r.style.display = 'none';
      if (collapsed) {
        r.style.display = '';
      }
    });

    // Add category name to the <tr>. NOTE: Hardcoded colspan
    return $('<tr/>')
      .append('<td colspan="8">' + group + '&nbsp;&nbsp;<i class="fas fa-plus-circle"></i></td>')
      .attr('data-name', group)
      .toggleClass('collapsed', collapsed);
  }
},*/
   /*"drawCallback": function ( settings ) {
        var api = this.api();
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;

        api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
         
            if ( last !== group ) {
                $(rows).eq( i ).before(
                    '<td colspan="8">' + group + '&nbsp;&nbsp;<i class="fas fa-plus-circle"></i></td>'
                );

                last = group;
            }
        } );
    }*/
//

});

/*$('.tablaUsuario tbody').on('click', 'tr.group-start', function() {
  var name = $(this).data('name');
  collapsedGroups[name] = !collapsedGroups[name];
  tablaUsuario.draw(true);
});
*/

var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

function limpiarUsuarios() {
    $("#idUsuario").val("");
    $("#idEmpleado").val("");
    $("#idEmpleado").attr("disabled", false);
    $("#idAlmacen").val("");
    $("#login").val("");
    $("#passlogin").val("");
    $("#idPerfil").val("");
  
}

$("#modalUsuarios").on("show.bs.modal", function (event) {
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Agregar Usuarios");
  
    limpiarUsuarios();
  });

  
$("#login").change(function () {

  var usuario = $(this).val();

  var datos = new FormData();
  datos.append("validarUsuario", usuario);
 
  $.ajax({
    url: "ajax/usuarios.ajax.php",
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
          title: '&nbsp;&nbsp;  Este usuario ya existe en la base de datos!'
        })

        $("#login").val("");
      }
     
    },
  });
});

//AAL MOMENTO DE HACER CLICK EN EDITAR, NOS TIENE QUE TRAER LOS DATOS DE LA BASE, HACIA LOS INPUTS
$(document).on("click", ".editarUsuario", function () {
    var idUsuario = $(this).attr("idUsuario");
    var ajaxUsuarios = "ajaxUsuarios";
    
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);
    datos.append("ajaxUsuarios", ajaxUsuarios);
  
    $.ajax({
      url: "ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        $("#idUsuario").val(idUsuario);
        $("#idEmpleado").val(respuesta["idEmpleado"]);
        $("#idAlmacen").val(respuesta["idAlmacen"]);
        $("#login").val(respuesta["login"]);
        $("#passActual").val(respuesta["passlogin"]);
        $("#passlogin").val("");
       // $("#idCategoria").select2("val", respuesta["idCategoria"]);
        $("#idPerfil").val(respuesta["idPerfil"]);
       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Usuarios");
      },
    });
  });


  
//al hacer click al boton, se ejecutara la funcion que estamos realizando "LLAMAMOS GUARDARALMACEN DE almacen.php"
$(".guardarUsuario").click(function (e) {
    var login = $("#login").val();
   
    if(login != ""){

      var expresion = /^[a-zA-Z]*$/;

      if(!expresion.test(login)){
        Swal.fire(
          '¡ERROR!',
          'El campo <strong>usuario</strong> solo acepta mayusculas y minusculas',
          'error',
        );
        $("#login").val("");
        
        return;
     
      }

    }else{

      Swal.fire(
        '¡ERROR!',
        'El campo usuario no debe ir vacio!',
        'error',
      );
      return;
    }


  
      e.preventDefault();
      var formData = new FormData($("#formularioUsuarios")[0]);
      $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          console.log(respuesta);
          if (respuesta == "ok") {
  
            Swal.fire({
              title: '¡CORRECTO!',
              html: '¡Datos enviados exitosamente!',
              icon: 'success',
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading()
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
                $("#modalUsuarios").modal("hide");
                limpiarUsuarios();
                tablaUsuario.ajax.reload();
                $("#passActual").val("");
            
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

  //falta validar que solo registre un usuario por cada nombre que pongamos
  
  
$(document).on("click", ".eliminarUsuario", function () {
    var idUsuario = $(this).attr("idUsuario");

    if(idUsuario == 1){

      Toast.fire({
        icon: 'error',
        title: '&nbsp;&nbsp;  El usuario "admin" no se puede eliminar!'
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
        datos.append("idEliminar", idUsuario);
        $.ajax({
          url: "ajax/usuarios.ajax.php",
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
               
                if (result.dismiss === Swal.DismissReason.timer) {
                  console.log('se ha cerrado por el tiempo!')
                }
              })
              tablaUsuario.ajax.reload();
            }
          },
        });
  
       
      }
    })
   
   
  });