  
/*tablaVerCompra = $(".tablaVerCompra").DataTable({
  "responsive": true,
  "lengthChange": false,
  "autoWidth": true,

  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  },

  'ajax': {
    'url': "ajax/compras.ajax.php",
    'data': {
      'ajaxVerCompras': 'ajaxVerCompras'
    },
    'type': 'post',
    'dataSrc': ''
  }, 
  columns: [{
      data: "idCompra"
    },
    {
      data: "idDocalmacen"
    },
    {
      data: "serie"
    },
    {
      data: "num_documento"
    },
    {
      data: "nombre"
    },
    {
      data: "empleado"
    },
    {
      data: "tipo_pago"
    },
    {
      data: "total_compra"
    },
    {
      data: "estado"
    },
    {
      data: "fecha_venta"
    },{

    
     
 
      render: function(data, type, full, meta) {
  
          return "<div class='btn-group'>"+
                  "<button class='btn btn-secondary verCompras' data-toggle='modal' data-target='#modal_vista' >"+
                      "<i class='fa fa-eye'></i>"+
                  "</button>"+
                    "<button class='btn btn-primary pdf'>"+
                    "<i class='fa fa-file-pdf'></i>"+
                    "</button>"+
                      "<button class='btn btn-danger btnAnularCompra'>"+
                      "<i class='fa fa-ban'></i>"+
                    "</button>"+
                  "</div>"
         } 
  
      
    }

  ]
  

});*/

var rutaOculta = $("#rutaOculta").val();
var simbolom = $("#simbolom").val();
var igvn = $("#igvn").val();
var impuesto = parseFloat(igvn / 100);
cargarSelectDocumento();


var toast2 = Swal.mixin({
  toast: true,
  position: 'top',
  showConfirmButton: false,
  timer: 3000
});

/*============================================================
    PARA EL AUTOCOMPLETADO DEL INPUT
    ===============================================================*/
var items = [];
var itemProducto = 1;

$("#iptCodigoCompra").focus();

table = $('#lstProductosCompra').DataTable({
  columnDefs: [{
    targets: 0,
    visible: false
  }, {
    targets: 6,
    visible: false
  }, {
    targets: 7,
    visible: false
  }],
  "order": [
    [0, 'desc']
  ],
  "language": {
    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
  }
});

$.ajax({
  async: false,
  url: rutaOculta + "ajax/producto.ajax.php",
  method: "POST",
  data: {
    'ajaxAutoComProducto': "ajaxAutoComProducto"
  },
  dataType: 'json',
  success: function (respuesta) {

    for (let i = 0; i < respuesta.length; i++) {
      items.push(respuesta[i]['descripcion_producto'])
    }
    $("#iptCodigoCompra").autocomplete({
      source: items,
      select: function (event, ui) {

        CargarProductos(ui.item.value);
        $("#iptCodigoCompra").val("");
        $("#iptCodigoCompra").focus();
        return false;
      }
    })

  }
})

$("#iptCodigoCompra").change(function () {
  CargarProductos();
  $("#iptCodigoCompra").val("");
  $("#iptCodigoCompra").focus();
});

$("#btnVaciarListado").on("click", function () {
  VaciarListado();
});

function VaciarListado() {
  table.clear().draw();
  LimpiarInputs();
  console.log(impuesto);
}

function LimpiarInputs() {
  $("#totalCompra").html("0.00");

  $("#boleta_total").html("0.00");
  $("#iptEfectivoRecibido").val("");
  $("#EfectivoEntregado").html("0.00");
  $("#boleta_subtotal").html("0.00");
  $("#subtotal").val("0.00");

  $("#boleta_igv").html("0.00");
  $("#Vuelto").html("0.00");
  $("#chkEfectivoExacto").prop("checked", false);
}

$("#lstProductosCompra tbody").on("click", ".btnEliminarproducto", function () {
  var totalCompra = 0.0;

  table.row($(this).parents("tr")).remove().draw();

  $("#iptCodigoVenta").focus();

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();
      totalCompra =
        parseFloat(totalCompra) + parseFloat(data[5].replace(simbolom, ""));
    });
  //0037128471 codigo interna, para reponer la nat
  $("#totalCompra").html("");
  $("#totalCompra").html(totalCompra.toFixed(2));

  var totalCompra = $("#totalCompra").html();
  var igv = parseFloat(totalCompra) * impuesto;
  var subtotal = parseFloat(totalCompra) - parseFloat(igv);
  $("#totalCompraRegistrar").html(totalCompra);

  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));
  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalCompra).toFixed(2));
  $("#iptCodigoVenta").focus();
});



$("#lstProductosCompra tbody").on("click", ".btnAumentarCantidad", function () {
  var data = table.row($(this).parents("tr")).data();
  var totalCompra = 0.0;
  if (data[3].replace("Und(s)", "") >= 1) {
    cantidad = parseInt(data[3].replace("Und(s)", "")) + 1;

    var idx = table.row($(this).parents("tr")).index();

    table
      .cell(idx, 3)
      .data(cantidad + " Und(s)")
      .draw();

    NuevoPrecio = (parseInt(data[3]) * data[4].replace(simbolom, "")).toFixed(2);
    NuevoPrecio = simbolom + NuevoPrecio;
    table.cell(idx, 5).data(NuevoPrecio).draw();
  }

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();
      totalCompra =
        parseFloat(totalCompra) + parseFloat(data[5].replace(simbolom, ""));
    });

  $("#totalCompra").html("");
  $("#totalCompra").html(totalCompra.toFixed(2));

  $("#iptCodigoVenta").focus();
  var totalCompra = $("#totalCompra").html();
  var igv = parseFloat(totalCompra) * impuesto;
  var subtotal = parseFloat(totalCompra) - parseFloat(igv);

  $("#totalCompraRegistrar").html(totalCompra);
  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));

  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalCompra).toFixed(2));
});

$("#lstProductosCompra tbody").on("click", ".btnDisminuirCantidad", function () {
  var data = table.row($(this).parents("tr")).data();
  var totalCompra = 0.0;
  if (data[3].replace("Und(s)", "") >= 2) {
    cantidad = parseInt(data[3].replace("Und(s)", "")) - 1;

    var idx = table.row($(this).parents("tr")).index();

    table
      .cell(idx, 3)
      .data(cantidad + " Und(s)")
      .draw();

    NuevoPrecio = (parseInt(data[3]) * data[4].replace(simbolom, "")).toFixed(2);
    NuevoPrecio = simbolom + NuevoPrecio;
    table.cell(idx, 5).data(NuevoPrecio).draw();
  }

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();
      totalCompra =
        parseFloat(totalCompra) + parseFloat(data[5].replace(simbolom, ""));
    });

  $("#totalCompra").html("");
  $("#totalCompra").html(totalCompra.toFixed(2));

  $("#iptCodigoVenta").focus();
  var totalCompra = $("#totalCompra").html();
  var igv = parseFloat(totalCompra) * impuesto;
  var subtotal = parseFloat(totalCompra) - parseFloat(igv);

  $("#totalCompraRegistrar").html(totalCompra);
  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));

  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalCompra).toFixed(2));
});

function cargarSelectDocumento() {

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/compras.ajax.php",
    method: "POST",
    data: {
      'ajaxVerProveedor': 'ajaxVerProveedor',
    },
    dataType: 'json',
    success: function (respuesta) {

      console.log(respuesta);
      var options = '<option selected value="">Seleccione un Documento</option>';

      for (let index = 0; index < respuesta.length; index++) {
        options = options + '<option value=' + respuesta[index][0] + '>' + respuesta[index][
          2
        ] + '</option>';
      }

      $("#selProveedor").append(options);
    }
  });
}



$("#selTipoPago").change(function () {

  var metodo = $(this).val();

  if (metodo == "Efectivo") {



    $(".cajasMetodoPago").html(


      '<div class="form-group">' +
      '<label for="iptEfectivoRecibido">Efectivo recibido</label>' +
      '<input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido" class="form-control form-control-sm" placeholder="Cantidad de efectivo recibida">' +
      '</div>' +
      '<div class="form-check">' +
      '<input class="form-check-input" type="checkbox" value="" id="chkEfectivoExacto">' +
      '<label class="form-check-label" for="chkEfectivoExacto">' +
      'Efectivo Exacto' +
      '</label>' +
      '</div>' +

      '<div class="row mt-2">' +
      '<div class="col-12">' +
      '<h5 class="text-start"><strong>Monto Efectivo: '+simbolom+' <span id="EfectivoEntregado">0.00</span></strong></h5>' +
      '</div>' +

      '<div class="col-12">' +
      '<h5 class="text-start text-danger"><strong>Vuelto: '+simbolom+' <span id="Vuelto">0.00</span></strong></h5>' +
      '</div>' +


      '</div>'

    )

    pruebaefectivo();
    pruebacheck();

  } else if (metodo == "Tarjeta") {


    $('.cajasMetodoPago').html(

      '<div class="form-group">' +
      '<label for="iptTransaccion">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptTransaccion" id="iptTransaccion" class="form-control form-control-sm" placeholder="Codigo Transacción recibida">' +
      '</div>'
    )



  } else if (metodo == "Deposito") {


    $('.cajasMetodoPago').html(

      '<div class="form-group">' +
      '<label for="iptDeposito">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptDeposito" id="iptDeposito" class="form-control form-control-sm" placeholder="Codigo Deposito recibida">' +
      '</div>' +
      '<div class="form-group">' +
      '<label for="nroContacto">Numero de contacto</label>' +
      '<input type="number" min="0" name="nroContacto" id="nroContacto" class="form-control form-control-sm" placeholder="Contacto telefonico">' +
      '</div>'
    )



  } else if (metodo == "Yape") {


    $('.cajasMetodoPago').html(

      '<div class="form-group">' +
      '<label for="iptYape">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptYape" id="iptYape" class="form-control form-control-sm" placeholder="Codigo yape">' +
      '</div>'
    )
  } else {
    $('.cajasMetodoPago').html(
      ''
    )
  }

})

function pruebaefectivo() {
  $("#iptEfectivoRecibido").keyup(function () {
    var totalVenta = $("#totalCompra").html();

    $("#chkEfectivoExacto").prop("checked", false);

    var efectivoRecibido = $("#iptEfectivoRecibido").val();
    if (efectivoRecibido > 0) {
      $("#EfectivoEntregado").html(parseFloat(efectivoRecibido).toFixed(2));

      vuelto = parseFloat(efectivoRecibido) - parseFloat(totalVenta);

      $("#Vuelto").html(vuelto.toFixed(2));
    } else {
      $("#EfectivoEntregado").html("0.00");
      $("#Vuelto").html("0.00");
    }
  });
}



function pruebacheck() {
  $("#chkEfectivoExacto").change(function () {
    // alert($("#chkEfectivoExacto").is(':checked'))

    if ($("#chkEfectivoExacto").is(":checked")) {
      var vuelto = 0;
      var totalCompra = $("#totalCompra").html();

      $("#iptEfectivoRecibido").val(totalCompra);

      $("#EfectivoEntregado").html(totalCompra);
      var EfectivoRecibido = parseFloat(
        $("#EfectivoEntregado").html().replace(simbolom, "")
      );

      vuelto = parseFloat(totalCompra) - parseFloat(EfectivoRecibido);

      $("#Vuelto").html(vuelto.toFixed(2));
    } else {
      $("#iptEfectivoRecibido").val("");
      $("#EfectivoEntregado").html("0.00");
      $("#Vuelto").html("0.00");
    }
  });
}

function CargarProductos(producto = "") {
  if (producto != "") {
    var codigo_producto = producto;
  } else {
    var codigo_producto = $("#iptCodigoCompra").val();
  }

  var existe = 0;
  var indice = 0;
  var codigo_repetido;
  var NuevoPrecio = 0;
  var totalCompra = 0;
  var flag_stock = 1;


  // return false;
  // VERIFICAMOS QUE SI EL PRODUCTO YA FUE AGREGADO, AUMENTE EN 1 LA CANTIDAD
  table
    .column(1)
    .data()
    .each(function (value, index) {
      if (parseInt(codigo_producto) == parseInt(value)) {
        existe = 1;
        codigo_repetido = parseInt(value);
      }
    });
  if (parseInt(flag_stock) == 1) {
    if (existe == 1) {
      table
        .rows()
        .eq(0)
        .each(function (index) {
          var row = table.row(index);

          var data = row.data();

          if (data[1] == codigo_repetido) {
            table
              .cell(index, 3)
              .data(parseInt(data[3]) + 1 + " Und(s)")
              .draw();

            NuevoPrecio = (
              parseInt(data[3]) * data[4].replace(simbolom, "")
            ).toFixed(2);
            NuevoPrecio = simbolom + NuevoPrecio;

            table.cell(index, 5).data(NuevoPrecio).draw();

            $("#iptCodigoVenta").val("");

            table
              .rows()
              .eq(0)
              .each(function (index) {
                var row = table.row(index);

                var data = row.data();
                totalCompra =
                  totalCompra + parseFloat(data[5].replace(simbolom, ""));
              });

            $("#totalCompra").html("");
            $("#totalCompra").html(totalCompra.toFixed(2));
            $("#totalCompraRegistrar").html(totalCompra.toFixed(2));

            var igv = parseFloat(totalCompra) * impuesto;
            var subtotal = parseFloat(totalCompra) - parseFloat(igv);


            $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
            $("#subtotal").val(parseFloat(subtotal).toFixed(2));

            $("#boleta_igv").html(parseFloat(igv).toFixed(2));
            $("#boleta_total").html(totalCompra.toFixed(2));

            $("#iptCodigoVenta").focus();
            $("#iptCodigoVenta").val("");
            // console.log("entro repetido")
            // return false;
          }
        });

      /*============================================================================
            SI EL PRODUCTO NO ESTA REGISTRADO EN EL LISTADO DE VENTAS
            ============================================================================*/
    } else {
      $.ajax({
        url: "ajax/producto.ajax.php",
        method: "POST",
        data: {
          'ajaxGestorProductoC': "ajaxGestorProductoC",
          'codigo_producto': codigo_producto

        },

        dataType: "json",
        success: function (respuesta) {
          //  console.log(respuesta);
          if (respuesta) {
            var totalCompra = 0.0;

            table.row
              .add([
                itemProducto,
                respuesta["codigoBarras"],
                respuesta["descProducto"],
                respuesta["cantidad"] + " Und(s)",
                respuesta["precio_compra_producto"],
                respuesta["total"],
                respuesta["idProducto"],
                respuesta["stock"],
                "<center>" +
                "<span class='btnEditarCantidad text-secondary px-1' idProducto='" + respuesta["idProducto"] + "' codigo='" + respuesta["codigoBarras"] + "'   cantidad='" + respuesta['cantidad'] + "' data-toggle='modal' data-target='#modalCantidadCompra' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                "<i class='fas fa-plus-square fs-5'></i>" +
                "</span> " +
                "<span class='btnEditarPrecio text-primary px-1' idProducto='" + respuesta["idProducto"] + "' codigo='" + respuesta["codigoBarras"] + "'   precio_compra=' " + respuesta['precio_compra_producto'] + "' data-toggle='modal' data-target='#modalProductoCompra' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                "<i class='fas fa-file-invoice-dollar fs-5'></i> " +
                "</span> " +
                "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                "<i class='fas fa-cart-plus fs-5'></i> " +
                "</span> " +
                "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                "</span> " +
                "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                "<i class='fas fa-trash fs-5'> </i> " +
                "</span>" +
                "</center>",

              ])
              .draw();
            itemProducto = itemProducto + 1;




            table
              .rows()
              .eq(0)
              .each(function (index) {
                var row = table.row(index);

                var data = row.data();
                totalCompra =
                  parseFloat(totalCompra) +
                  parseFloat(data[5].replace(simbolom, ""));
              });

            $("#totalCompra").html("");
            $("#totalCompra").html(totalCompra.toFixed(2));

            $("#iptCodigoCompra").val("");

            var totalCompra = $("#totalCompra").html();
            var igv = parseFloat(totalCompra) * impuesto;
            var subtotal = parseFloat(totalCompra) - parseFloat(igv);

            $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
            $("#subtotal").val(parseFloat(subtotal).toFixed(2));

            $("#boleta_igv").html(parseFloat(igv).toFixed(2));
            $("#boleta_total").html(parseFloat(totalCompra).toFixed(2));

            $("#totalCompraRegistrar").html(totalCompra);
            $("#boleta_total").html(totalCompra);
          } else {
            toast2.fire({
              icon: "error",
              title: "&nbsp;  El producto no existe o no tiene stock",
            });

            $("#iptCodigoCompra").val("");
            $("#iptCodigoCompra").focus();
          }
        },
      });
    }
  }
}



$(document).on("click", ".btnEditarPrecio", function () {
  var idProducto = $(this).attr("idProducto");
  var ajaxProducto = "ajaxProducto";

  var datos = new FormData();
  datos.append("idProducto", idProducto);
  datos.append("ajaxProducto", ajaxProducto);

  $.ajax({

    url: rutaOculta + "ajax/producto.ajax.php",
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
      $("#precioCompra").val(respuesta["precioCompra"]);

    },


  });
  $('#modalProductoCompra').on('shown.bs.modal', function (e) {
    $("#precioCompra").focus();
  })


});

$(document).on("click", ".btnEditarCantidad", function () {
  var idProducto = $(this).attr("idProducto");
  var ajaxProducto = "ajaxProducto";

  var datos = new FormData();
  datos.append("idProducto", idProducto);
  datos.append("ajaxProducto", ajaxProducto);

  $.ajax({

    url: rutaOculta + "ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idProductoc").val(idProducto);
      $("#descProductoc").val(respuesta["descProducto"]);
      $("#codigoBarrasc").val(respuesta["codigoBarras"]);
    

    },


  });
  $('#modalCantidadCompra').on('shown.bs.modal', function (e) {
    $("#cantidaCompra").focus();
  })


});


$(".btnEditPrecio").click(function (e) {

  var idProducto = $("#idProducto").val();
  var precioCompra = $("#precioCompra").val();
  var codigo_productos = $("#codigoBarras").val();

  var datos = new FormData();

  datos.append('ajaxEditarPrecio', 'ajaxEditarPrecio');
  datos.append('idProducto', idProducto);
  datos.append('precioCompra', precioCompra);

  $.ajax({
    url: rutaOculta + "ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

      toast2.fire({
        icon: 'success',
        title: '&nbsp; Precio compra corregido!'
      });

      $("#modalProductoCompra").modal("hide");

      if ($(this).attr("precio_compra") != "") {
        precio_compra = $("#precioCompra").val();
      }
      console.log(precio_compra);
      recalcularMontos(codigo_productos, precio_compra.replaceAll(simbolom, ""));

    }

  })
})

var pruebacodigo;
$(document).on("click", ".btnEditarCantidad", function () {
  var idProducto = $(this).attr("idProducto");
  var ajaxProducto = "ajaxProducto";
  pruebacodigo = $(this).attr("codigo");
  var datos = new FormData();
  datos.append("idProducto", idProducto);
  datos.append("ajaxProducto", ajaxProducto);

  $.ajax({

    url: rutaOculta + "ajax/producto.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#idProductoc").val(idProducto);
      $("#descProductoc").val(respuesta["descProducto"]);
      $("#codigoBarrasc").val(respuesta["codigoBarras"]);
      
    },


  });
  $('#modalCantidadCompra').on('shown.bs.modal', function (e) {
    $("#cantidaCompra").focus();
  })


});


//$(".btnEditCantidad2").click(function () {
$(document).on("click", ".btnEditCantidad2", function () {
  //  event.preventDefault();
  event.preventDefault();
 

  toast2.fire({
    icon: 'success',
    title: '&nbsp; La cantidad fue corregido!'
  });

  $("#modalCantidadCompra").modal("hide");
 
  
  if ($("#cantidaCompra").val() != "") {
    cantidad = $("#cantidaCompra").val();
  }
 // console.log(codigo_producto, cantidad);
 console.log(cantidad);
 console.log(pruebacodigo);
  recalcularCantidad(pruebacodigo, cantidad);

  
});

function recalcularMontos(codigo_producto, precio_compra) {

  // alert(codigo_producto);  

  table.rows().eq(0).each(function (index) {

    var row = table.row(index);

    var data = row.data();

    if (data[1] == codigo_producto) {

      // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
      table.cell(index, 4).data(simbolom + parseFloat(precio_compra).toFixed(2)).draw();

      // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
      NuevoPrecio = (parseInt(data[3]) * data[4].replace(simbolom, "")).toFixed(2);
      NuevoPrecio = simbolom + NuevoPrecio;
      table.cell(index, 5).data(NuevoPrecio).draw();

    }

  });

  recalcularTotales();
}


function recalcularCantidad(codigo_producto, cantidad) {

  table.rows().eq(0).each(function (index) {

    var row = table.row(index);

    var data = row.data();

    if (data[1] == codigo_producto) {

      //cantidad =  cantidad;
  
     // var idx = table.row($(this).parents("tr")).index();
  
      table
        .cell(index, 3)
        .data(cantidad + " Und(s)")
        .draw();
  
      NuevoPrecio = (parseInt(data[3]) * data[4].replace(simbolom, "")).toFixed(2);
      NuevoPrecio = simbolom + NuevoPrecio;
      table.cell(index, 5).data(NuevoPrecio).draw();
    }
  });

  recalcularTotales();
}


function recalcularTotales() {

  var totalCompra = 0.00;

  table.rows().eq(0).each(function (index) {

    var row = table.row(index);
    var data = row.data();

    totalCompra = parseFloat(totalCompra) + parseFloat(data[5].replace(simbolom, ""));

  });

  $("#totalCompra").html("");
  $("#totalCompra").html(totalCompra.toFixed(2));

  var totalCompra = $("#totalCompra").html();
  var igv = parseFloat(totalCompra) * 0.18
  var subtotal = parseFloat(totalCompra) - parseFloat(igv);

  $("#totalCompraRegistrar").html(totalCompra);

  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalCompra).toFixed(2));

  $("#iptCodigoVenta").val("");
  $("#iptCodigoVenta").focus();
}



$("#chkEfectivoExacto").change(function () {
  // alert($("#chkEfectivoExacto").is(':checked'))

  if ($("#chkEfectivoExacto").is(":checked")) {
    var vuelto = 0;
    var totalCompra = $("#totalCompra").html();

    $("#iptEfectivoRecibido").val(totalCompra);

    $("#EfectivoEntregado").html(totalCompra);
    var EfectivoRecibido = parseFloat(
      $("#EfectivoEntregado").html().replace(simbolom, "")
    );

    vuelto = parseFloat(totalCompra) - parseFloat(EfectivoRecibido);

    $("#Vuelto").html(vuelto.toFixed(2));
  } else {
    $("#iptEfectivoRecibido").val("");
    $("#EfectivoEntregado").html("0.00");
    $("#Vuelto").html("0.00");
  }
});

$("#btnIniciarCompra").on('click', function () {


  var count = 0;

  var totalCompra = $("#totalCompra").html();

  var idUsuario = $("#idUsuario").val();
  var idDocalmacen = $("#selDocumentoCompra").val();
  var idProovedor = $("#selProveedor").val();
  var nroserie = $("#iptNroSerie").val();
  var nrocompra = $("#iptNroVenta").val();
  var selTipoPagoV = $("#selTipoPago").val();

  if (selTipoPagoV == "Efectivo") {
    var codigo_transa = "";
    var contacto = "";
  } else if (selTipoPagoV == "Tarjeta") {
    var codigo_transa = $("#iptTransaccion").val();
    var contacto = "";
  } else if (selTipoPagoV == "Deposito") {
    var codigo_transa = $("#iptDeposito").val();
    var contacto = $("#nroContacto").val();
  } else if (selTipoPagoV == "Yape") {
    var codigo_transa = $("#iptYape").val();
    var contacto = "";
  }


  table.rows().eq(0).each(function (index) {
    count = count + 1;
  });

  if (count > 0) {

    if ($("#selDocumentoCompra").val() == 0) {

      toast2.fire({
        icon: 'warning',
        title: '&nbsp; seleccione un documento'
      });

      return false;

    }

    if ($("#iptNroSerie").val() == "") {

      toast2.fire({
        icon: 'warning',
        title: '&nbsp; Llene el campo "Nro serie"'
      });

      return false;

    }

    if ($("#iptNroVenta").val() == "") {

      toast2.fire({
        icon: 'warning',
        title: '&nbsp; Llene el campo "Nro Compra"'
      });

      return false;

    }

    if ($("#iptEfectivoRecibido").val() == 0 && $("#iptEfectivoRecibido").val() == "") {
      toast2.fire({
        icon: 'error',
        title: '&nbsp; Ingrese el monto en efectivo'
      });

      return false;
    }

    if ($("#iptEfectivoRecibido").val() < parseFloat(totalCompra)) {
      toast2.fire({
        icon: 'warning',
        title: 'El efectivo es menor al costo total de la venta'
      });

      return false;
    }

    var formData = new FormData();
    var arr = [];

    table.rows().eq(0).each(function (index) {

      var row = table.row(index);

      var data = row.data();

      arr[index] = data[1] + "," + parseFloat(data[3]) + "," + data[5].replace(
        simbolom, "") + "," + data[6] + "," + data[7];

      formData.append('arr[]', arr[index]);

    })

    formData.append('idProveedor', idProovedor);
    formData.append('idUsuario', idUsuario);
    formData.append('idDocalmacen', idDocalmacen);
    formData.append('num_documento', nrocompra);
    formData.append('serie', nroserie);
    formData.append('subtotal', $("#boleta_subtotal").html());
    formData.append('igv', $("#boleta_igv").html());
    formData.append('total_compra', parseFloat(totalCompra));
    formData.append('tipo_pago', selTipoPagoV);
    formData.append('codigo_transa', codigo_transa);
    formData.append('contacto', contacto);

    $.ajax({
      url: rutaOculta + "ajax/compras.ajax.php",
      method: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: respuesta,
          showConfirmButton: false,
          timer: 1500
        })

        table
          .clear()
          .draw();

        $("#selProveedor").val("");
        $("#selDocumentoCompra").val(0);
        $("#selTipoPago").val("");
        $("#iptYape").val("");

        $("#iptNroSerie").val("");
        $("#iptNroVenta").val("");
        $("#totalCompra").html("0.00");

        $("#boleta_total").html("0.00");
        $("#boleta_igv").html("0.00");
        $("#boleta_subtotal").html("0.00");
        $("#subtotal").val("0.00");

        $("#iptEfectivoRecibido").val("");
        $("#EfectivoEntregado").html("0.00");
        $("#Vuelto").html("0.00");
        $("#chkEfectivoExacto").prop('checked', false);



        $("#iptCodigoCompra").focus();
        //cargarSelectDocumento();


      }
    });


  } else {

    toast2.fire({
      icon: 'error',
      title: '&nbsp; No hay productos en el listado.'
    });

    $("#iptCodigoCompra").focus();
  }

  $("#iptCodigoCompra").focus();

})




$("#iptEfectivoRecibido").keyup(function () {
  var totalCompra = $("#totalCompra").html();

  $("#chkEfectivoExacto").prop('checked', false);

  var efectivoRecibido = $("#iptEfectivoRecibido").val();
  if (efectivoRecibido > 0) {
    $("#EfectivoEntregado").html(parseFloat(efectivoRecibido).toFixed(2));

    vuelto = parseFloat(efectivoRecibido) - parseFloat(totalCompra);

    $("#Vuelto").html(vuelto.toFixed(2));

  } else {
    $("#EfectivoEntregado").html("0.00");
    $("#Vuelto").html("0.00");
  }
});



$(".guardarProveedor").click(function (e) {
if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
        toast2.fire({
		icon: 'warning',
		title: '&nbsp;&nbsp;  No es un formato de correo, intentelo nuevamente.'
		})
		$("#email").focus()
		
        return false;
    }

  e.preventDefault();
  var formData = new FormData($("#formularioProveedor")[0]);
  $.ajax({
    url: rutaOculta + "ajax/proveedores.ajax.php",
    method: "POST",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta == "ok") {

        toast2.fire({
          icon: 'success',
          title: '&nbsp; Proveedor Agregado'
        });

        $("#modalProveedor").modal("hide");
        // cargarSelectDocumento() ;
        $.ajax({
          async: false,
          url: rutaOculta + "ajax/compras.ajax.php",
          method: "POST",
          data: {
            'ajaxVerProveedor': 'ajaxVerProveedor',
          },
          dataType: 'json',
          success: function (respuesta) {

            for (let index = 0; index < respuesta.length; index++) {
              options = '<option value=' + respuesta[index][0] + '>' + respuesta[index][
                2
              ] + '</option>';
            }

            $("#selProveedor").append(options);
          }
        });

        $("#RUC").val("");
        $("#nombre").val("");
        $("#direccion").val("");
        $("#celular").val("");
        $("#telefono").val("");
        $("#email").val("");

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

});

$("#RUC").change(function () {


  var ruc = $("#RUC").val();

  $.ajax({

    type: "POST",
    url: rutaOculta + "ajax/consultaruc.ajax.php",
    data: 'ruc=' + ruc,
    dataType: 'json',
    success: function (data) {

      if (data == 1) {
        alert('El ruc tiene que tener 11 digitos')
      } else {

        $("#nombre").val(MaysPrimera(data.nombre.toLowerCase()));
        $("#direccion").val(MaysPrimera(data.direccion.toLowerCase()));

      }

    }

  })

})

function MaysPrimera(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}




