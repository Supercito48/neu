var tablaKardex;
var tablaKardexDeposito;
var rutaOculta = $("#rutaOculta").val();
var idAlmacen = $("#idAlmacen").val();

var n = new Date();
var y= n.getFullYear();
var m= n.getMonth()+1;
var d= n.getDate();
if(d<10){
    d='0' + d;
}
if(m<10){
    m='0' + m;
}
document.getElementById('kardex_desde').value = y + "-" + m + "-" + d;
document.getElementById('kardex_hasta').value = y + "-" + m + "-" + d;

//idAlmacen = $("#idAlmacen").val();
kardex_desde = $("#kardex_desde").val();
kardex_hasta = $("#kardex_hasta").val();
        

tablaKardex = $(".tablaKardex").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
  
    ajax: {
      url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
      dataSrc: "",
      data: {
        'idAlmacen' : idAlmacen,
        'fechaDesde': kardex_desde,
        'fechaHasta': kardex_hasta 
      },
    },
    columns: [{
        data: "fecha_registro"
      },
      {
        data: "descProducto"
      },
      {
        data: "motivo"
      },
      {
        data: "tipo"
      },
      {
        data: "habia"
      },
      {
        data: "stock"
      },
      {
        data: "hay"
      },
      {
        data: "empleado"
      }
    ],
    
  
    bDestroy: true,
    iDisplayLength: 10,
  });

  
$("#btnFiltrar").on('click',function(){

    tablaKardex.destroy();
  
    if($("#kardex_desde").val() == ''){
        kardex_desde = '01/10/2000';
    }else{
        kardex_desde = $("#kardex_desde").val();
    }
    
    if($("#kardex_hasta").val() == ''){
        kardex_hasta = '10/10/9999';
    }else{
        kardex_hasta = $("#kardex_hasta").val();
    }
  
    
    kardex_desde = $("#kardex_desde").val();
    kardex_hasta = $("#kardex_hasta").val();
  
    tablaKardex = $(".tablaKardex").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : idAlmacen,
            'fechaDesde': kardex_desde,
            'fechaHasta': kardex_hasta 
          },
        },
        columns: [{
            data: "fecha_registro"
          },
          {
            data: "descProducto"
          },
          {
            data: "motivo"
          },
          {
            data: "tipo"
          },
          {
            data: "habia"
          },
          {
            data: "stock"
          },
          {
            data: "hay"
          },
          {
            data: "empleado"
          }
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
      
  
  })

  $("#btnQFiltro").on('click',function(){

    tablaKardex.destroy();
    var n = new Date();
    var y= n.getFullYear();
    var m= n.getMonth()+1;
    var d= n.getDate();
    if(d<10){
        d='0' + d;
    }
    if(m<10){
        m='0' + m;
    }
    document.getElementById('kardex_desde').value = y + "-" + m + "-" + d;
    document.getElementById('kardex_hasta').value = y + "-" + m + "-" + d;

   
    kardex_desde = $("#kardex_desde").val();
    kardex_hasta = $("#kardex_hasta").val();

   
    tablaKardex = $(".tablaKardex").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
       
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : idAlmacen,
            'fechaDesde': kardex_desde,
            'fechaHasta': kardex_hasta 
          },
        },
        columns: [{
            data: "fecha_registro"
          },
          {
            data: "descProducto"
          },
          {
            data: "motivo"
          },
          {
            data: "tipo"
          },
          {
            data: "habia"
          },
          {
            data: "stock"
          },
          {
            data: "hay"
          },
          {
            data: "empleado"
          }
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
     
  })

  $(".content").keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $("#btnFiltrar").click();   
    }
  });   

  $("#iptProducto").keyup(function () {
    tablaKardex.column($(this).data("index")).search(this.value).draw();
  });
  
  $("#iptResponsable").keyup(function () {
    tablaKardex.column($(this).data("index")).search(this.value).draw();
  });
  
  $("#iptTipo").change(function () {
    tablaKardex.column($(this).data("index")).search(this.value).draw();
  });



  tablaKardexDeposito = $(".tablaKardexDeposito").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": true,
    
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
  
    ajax: {
      url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
      dataSrc: "",
      data: {
        'idAlmacen' : 0,
        'fechaDesde': kardex_desde,
        'fechaHasta': kardex_hasta 
      },
    },
    columns: [{
        data: "fecha_registro"
      },
      {
        data: "descProducto"
      },
      {
        data: "motivo"
      },
      {
        data: "tipo"
      },
      {
        data: "habia"
      },
      {
        data: "stock"
      },
      {
        data: "hay"
      },
      {
        data: "empleado"
      }
    ],
    
  
    bDestroy: true,
    iDisplayLength: 10,
  });

  
$("#btnFiltrar").on('click',function(){

    tablaKardexDeposito.destroy();
  
    if($("#kardex_desde").val() == ''){
        kardex_desde = '01/10/2000';
    }else{
        kardex_desde = $("#kardex_desde").val();
    }
    
    if($("#kardex_hasta").val() == ''){
        kardex_hasta = '10/10/9999';
    }else{
        kardex_hasta = $("#kardex_hasta").val();
    }
  
    
    kardex_desde = $("#kardex_desde").val();
    kardex_hasta = $("#kardex_hasta").val();
  
    tablaKardexDeposito = $(".tablaKardexDeposito").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : 0,
            'fechaDesde': kardex_desde,
            'fechaHasta': kardex_hasta 
          },
        },
        columns: [{
            data: "fecha_registro"
          },
          {
            data: "descProducto"
          },
          {
            data: "motivo"
          },
          {
            data: "tipo"
          },
          {
            data: "habia"
          },
          {
            data: "stock"
          },
          {
            data: "hay"
          },
          {
            data: "empleado"
          }
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
      
  
  })

  $("#btnQFiltro").on('click',function(){

    tablaKardexDeposito.destroy();
    var n = new Date();
    var y= n.getFullYear();
    var m= n.getMonth()+1;
    var d= n.getDate();
    if(d<10){
        d='0' + d;
    }
    if(m<10){
        m='0' + m;
    }
    document.getElementById('kardex_desde').value = y + "-" + m + "-" + d;
    document.getElementById('kardex_hasta').value = y + "-" + m + "-" + d;

   
    kardex_desde = $("#kardex_desde").val();
    kardex_hasta = $("#kardex_hasta").val();

   
    tablaKardexDeposito = $(".tablaKardexDeposito").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
       
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        ajax: {
          url: rutaOculta+"ajax/tablas/tablaKardex.ajax.php",
          dataSrc: "",
          data: {
            'idAlmacen' : 0,
            'fechaDesde': kardex_desde,
            'fechaHasta': kardex_hasta 
          },
        },
        columns: [{
            data: "fecha_registro"
          },
          {
            data: "descProducto"
          },
          {
            data: "motivo"
          },
          {
            data: "tipo"
          },
          {
            data: "habia"
          },
          {
            data: "stock"
          },
          {
            data: "hay"
          },
          {
            data: "empleado"
          }
        ],
        
      
        bDestroy: true,
        iDisplayLength: 10,
      });
     
  })

  $("#iptProducto").keyup(function () {
    tablaKardexDeposito.column($(this).data("index")).search(this.value).draw();
  });
  
  $("#iptResponsable").keyup(function () {
    tablaKardexDeposito.column($(this).data("index")).search(this.value).draw();
  });
  
  $("#iptTipo").change(function () {
    tablaKardexDeposito.column($(this).data("index")).search(this.value).draw();
  });