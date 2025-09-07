var tablaPerfil;

var idPerfiles;

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaPerfil = $(".tablaPerfil").DataTable({
  "columnDefs": [{
    "visible": false,
    "targets": 1
  }],
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
    url: "ajax/tablas/tablaPerfil.ajax.php",
    dataSrc: "",
  },
  columns: [{
      data: "idPerfiles"
    },
    {
      data: "idPerfiles2"
    },
    {
      data: "descripcion"
    },
    {
      data: "permisos"
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

var tablaMenu;
var collapsedGroups = {};

function fnc_tablacitaservicio() {
  // Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
  tablaMenu = $(".tablaMenu").DataTable({
    "deferRender": true,

    "processing": true,
    paging: false,
    "columnDefs": [{
      "visible": false,
      "targets": 1
    }],
    "order": [
      [1, 'asc']
    ],
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "responsive": true,

    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },

    ajax: {
      url: "ajax/tablas/tablaMenus.ajax.php",
      dataSrc: "",
      data: {
        idPerfiles: idPerfiles,
      },
    },
    columns: [{
        data: "descripcion"
      },
      {
        data: "grupo"
      },
      {
        data: "agregar"
      }
    ],

    bDestroy: true,
    iDisplayLength: 10,

    rowGroup: {
      // Uses the 'row group' plugin
      dataSrc: 'grupo',
      startRender: function (rows, group) {
        var collapsed = !!collapsedGroups[group];


        rows.nodes().each(function (r) {
          r.style.display = 'none';
          if (collapsed) {
            r.style.display = '';
          }
        });

        // Add category name to the <tr>. NOTE: Hardcoded colspan
        return $('<tr/>')
          .append('<td colspan="8"><strong>' + group + '&nbsp;&nbsp;</strong><i class="fas fa-plus-circle"></i></td>')
          .attr('data-name', group)
          .toggleClass('collapsed', collapsed);
      }
    },
  });
}
$('.tablaMenu tbody').on('click', 'tr.group-start', function () {
  var name = $(this).data('name');
  collapsedGroups[name] = !collapsedGroups[name];
  tablaMenu.draw(true);
});

$(document).on("click", ".btnPermisos", function () {
  var idPerfil = $(this).attr("idPerfiles");
  // $("#idPerfiles").val(idPerfil);
  idPerfiles = idPerfil;
  fnc_tablacitaservicio();

});


$(document).on("click", ".btnEditarPerfil", function () {
  
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Editar Perfiles");

  $(".guardarPerfiles").hide();
  $(".editarPerfiles").show();

  var data = tablaPerfil.row($(this).parents("tr")).data();
  var idPerfiledit = data["idPerfiles2"];
  var descrpcion = data["descripcion"];

  $("#idPerfiles").val(idPerfiledit);
  $(".descripcion").val(descrpcion);
});

$("#myModal").on("show.bs.modal", function (event) {
  $(".modal-header").css("color", "white");
  $(".modal-title").text("Agregar Perfiles");

  $(".guardarPerfiles").show();
  $(".editarPerfiles").hide();
});

$(document).on("click", ".guardarPerfiles", function () {
  var descripcion = $(".descripcion").val()

var datos = new FormData();

datos.append('ajaxAgregarPerfiles', 'ajaxAgregarPerfiles');
datos.append('descripcion', descripcion);

$.ajax({
  url: "ajax/perfil.ajax.php",
  method: "POST",
  data: datos,
  cache: false,
  contentType: false,
  processData: false,
  success: function (respuesta) {
      
      $("#myModal").modal('hide');
      tablaPerfil.ajax.reload(null, false);

      $(".descripcion").val("");
      

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


$(document).on("click", ".editarPerfiles", function () {
  var idPerfiledit = $("#idPerfiles").val()
  var descripcion = $(".descripcion").val()

var datos = new FormData();

datos.append('ajaxEditarPerfiles', 'ajaxEditarPerfiles');
datos.append('idPerfiles', idPerfiledit);
datos.append('descripcion', descripcion);

$.ajax({
  url: "ajax/perfil.ajax.php",
  method: "POST",
  data: datos,
  cache: false,
  contentType: false,
  processData: false,
  success: function (respuesta) {
      
      $("#myModal").modal('hide');
      tablaPerfil.ajax.reload(null, false);

      $("#idPerfiles").val("");
      $(".descripcion").val("");
      

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


$(document).on("click", ".btnEliminarPerfil", function () {
  var data = tablaPerfil.row($(this).parents("tr")).data();
  var idEliminar = data["idPerfiles2"];

  Swal.fire({
    title: "¿Está seguro de desactivar el perfil?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "ajax/perfil.ajax.php",
        type: "POST",
        data: {
          ajaxEliminarPerfiles: "ajaxEliminarPerfiles",
          idPerfiles: idEliminar,
          estado : 1,
        },
        dataType: "json",
        success: function (respuesta) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Se desactivo correctamente!",
            showConfirmButton: false,
            timer: 1500,
          });
          tablaPerfil.ajax.reload(null, false);
        },
      });
    }
  });
});

// aachicar este consulta para que solo use algo mas corto
$(document).on("click", ".btnActivarPerfil", function () {
  var data = tablaPerfil.row($(this).parents("tr")).data();
  var idEliminar = data["idPerfiles2"];

  Swal.fire({
    title: "¿Está seguro de activar el perfil?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "ajax/perfil.ajax.php",
        type: "POST",
        data: {
          ajaxEliminarPerfiles: "ajaxEliminarPerfiles",
          idPerfiles: idEliminar,
          estado : 0,
        },
        dataType: "json",
        success: function (respuesta) {
          Swal.fire({
            position: "center",
            icon: "success",
            title: "Se activo  correctamente!",
            showConfirmButton: false,
            timer: 1500,
          });
          tablaPerfil.ajax.reload(null, false);
        },
      });
    }
  });
});


$(document).on("click", ".guardarPermiso", function () {
  var idMenu = $(this).attr("idMenu");
  //console.log(idPerfiles, "- ", idMenu);

    var datos = new FormData();
    datos.append("ajaxRegistrarPermisos", "ajaxRegistrarPermisos");
    datos.append("idPerfiles", idPerfiles);
    datos.append("idMenu", idMenu);
  
    $.ajax({
      url: "ajax/perfil.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {

        toast2.fire({
          icon: "success",
          title:
            "Se le activo el permiso",
        });
        tablaMenu.ajax.reload();

      },
    });

})

$(document).on("click", ".btnDesactivarPermiso", function () {
  var idPermiso = $(this).attr("idPermiso");
  //console.log(idPerfiles, "- ", idMenu);

    var datos = new FormData();
    datos.append("ajaxDesactivarPermiso", "ajaxDesactivarPermiso");
    datos.append("idPermiso", idPermiso);
  
    $.ajax({
      url: "ajax/perfil.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {

        toast2.fire({
          icon: "warning",
          title:
            "Se le desactivo el permiso",
        });
        tablaMenu.ajax.reload();

      },
    });

})

$(document).on("click", ".btnActivarPermiso", function () {
  var idPermiso = $(this).attr("idPermiso");
  //console.log(idPerfiles, "- ", idMenu);

    var datos = new FormData();
    datos.append("ajaxActivarPermiso", "ajaxActivarPermiso");
    datos.append("idPermiso", idPermiso);
  
    $.ajax({
      url: "ajax/perfil.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {

        toast2.fire({
          icon: "success",
          title:
            "Se le activo el permiso",
        });
        tablaMenu.ajax.reload();

      },
    });

})


$(document).on("click", ".btnGuardar", function () {
  Swal.fire({
    title: "¿Está seguro de guardar los permisos?",
    text: "¡Si no lo está puede cancelar la acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, guardar!",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "¡CORRECTO!",
        html: "¡Permisos registrado exitosamente!",
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
      })
      $("#modal_permisos").modal("hide");
      tablaPerfil.ajax.reload();

    }
  });
});

