

var tablaGeneral;

// Vamos a traer lo que es la accion de databla table sobre la clase tablaPersonas - .class, #ID
tablaGeneral = $(".tablaGeneral").DataTable({

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
 
 
  bDestroy: true,
  iDisplayLength: 10,
});
/*=============================================
Inicializar Select2
=============================================*/
$('.select2').select2();

// //Funcionamiento de Select2 para modal
$.fn.modal.Constructor.prototype._enforceFocus = function() {};

 //Datemask dd/mm/yyyy
 $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
 //Datemask2 mm/dd/yyyy
 $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
 //Money Euro
 $('[data-mask]').inputmask()

 //Date picker
 $('#desde').datetimepicker({
     format: 'L'
 });
 $('#hasta').datetimepicker({
    format: 'L'
});

$('#editarfecha').datetimepicker({
    format: 'L'
});

