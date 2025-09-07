var rutaOculta = $("#rutaOculta").val();
var table;
var items = [];
var itemProducto = 1;

var idCaja;

var idDocalmacen;
var serie;
var nro_boleta;

var simbolom = $("#simbolom").val();
var igvn = $("#igvn").val();
var impuesto = parseFloat(igvn / 100);

var subtotalVenta = $("#subtotal").val();
//CargarNroBoleta();

console.log(nro_boleta);
cargarSelectClientes();
cargarSelectDocumento();
pruebaefectivo();
pruebacheck();




var idAlmacen = $("#idAlmacenV").val();
var idUsuario = $("#idUsuario").val();

fnc_idCAja();

console.log("ALMACEN NR " + idAlmacen)
console.log("CAja numero " + idCaja)

var toast2 = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 3000,
});


function fnc_idCAja() {

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
    method: "POST",
    data: {
      'ajaxrVercaja': 'ajaxrVercaja',
      'idUsuario': idUsuario

    },
    dataType: 'json',
    success: function (respuesta) {

      if (respuesta == false) {
        console.log("no tiene caja abierta");
      } else {
        console.log(respuesta["idCaja"]);
        //$("#idCaja").val(respuesta["idCaja"]);

        idCaja = respuesta["idCaja"]

      }


    }
  });

}

table = $("#lstProductosVenta").DataTable({
  /*"responsive": true, 
  "lengthChange": false, 
  "autoWidth": false,
  "responsive": true,*/
  columns: [{
      data: "idProducto"
    },
    {
      data: "codigoBarras"
    },
    {
      data: "descProducto"
    },
    {
      data: "cantidad"
    },
    {
      data: "precio_venta_producto"
    },
    {
      data: "total"
    },
    {
      data: "acciones"
    },
    {
      data: "idProducto"
    },
    {
      data: "stock"
    },
    {
      data: "precioVentaMA"
    },
    
    {
      data: "oferta"
    },
    
  ],

  columnDefs: [{
      targets: 0,
      visible: false,
    },
    {
      targets: 7,
      visible: false,
    },
    {
      targets: 8,
      visible: false,
    },
    {
      targets: 9,
      visible: false,
    },
    
    {
      targets: 10,
      visible: false,
    },
    
  ],
  order: [
    [0, "desc"]
  ],
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
  },
});

/* ======================================================================================
    TRAER LISTADO DE PRODUCTOS PARA INPUT DE BUSQUEDA
    ======================================================================================*/
$.ajax({
  async: false,
  url: rutaOculta + "ajax/producto.ajax.php",
  method: "POST",
  data: {
    ajaxAutoProductoVenta: "ajaxAutoProductoVenta",
    idAlmacen: idAlmacen,
  },
  dataType: "json",
  success: function (respuesta) {
    for (let i = 0; i < respuesta.length; i++) {
      items.push(respuesta[i]["descripcion_producto"]);
    }
    $("#iptCodigoVenta").autocomplete({
      source: items,
      select: function (event, ui) {
        CargarProductosV(ui.item.value);
        $("#iptCodigoVenta").val("");
        $("#iptCodigoVenta").focus();
        return false;
      },
    });
  },
});

$(document).on("change", "#selDocumentoVenta", function () {
  var Boletas = $(this).val();
  var idAlmacenb = $("#idAlmacenV").val();
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/ventas.ajax.php",
    method: "POST",
    data: {
      ajaxVerNroBoleta: "ajaxVerNroBoleta",
      Documento: Boletas,
      idAlmacen: idAlmacenb,
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta["idDocalmacen"]);
      idDocalmacen = respuesta["idDocalmacen"];
      serie = respuesta["Serie"];
      nro_boleta = respuesta["nro_venta"];

      $("#iptNroSerie").val(respuesta["Serie"]);
      $("#iptNroVenta").val(respuesta["nro_venta"]);
    },
  });
});

function cargarSelectDocumento() {
  var idAlmacenselect = $("#idAlmacenV").val();
  $.ajax({
    async: false,
    url: rutaOculta + "ajax/ventas.ajax.php",
    method: "POST",
    data: {
      ajaxVerDocumento: "ajaxVerDocumento",
      idAlmacen: idAlmacenselect,
    },
    dataType: "json",
    success: function (respuesta) {
      var options =
        '<option selected value="">Seleccione un Documento</option>';

      for (let index = 0; index < respuesta.length; index++) {
        options =
          options +
          "<option value=" +
          respuesta[index][0] +
          ">" +
          respuesta[index][1] +
          "</option>";
      }

      $("#selDocumentoVenta").append(options);
    },
  });
}




$(".guardarCli").on('click', function () {

  var dni = $(".dni").val(),
    nombres = $(".nombres").val(),
    direccion = $(".direccion").val(),
    telefono = $(".telefono").val(),
    limite_credito = $(".limite_credito").val();

  if (
    dni.length == 0 ||
    nombres.length == 0 ||
    direccion.length == 0 ||
    telefono.length == 0 ||
    limite_credito.length == 0
  ) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "Llene los campos vacios",
      "warning"
    );
  }
  var datos = new FormData();

  datos.append('ajaxRegistrarCliente', 'ajaxRegistrarCliente')
  datos.append('dni', dni)
  datos.append('nombres', nombres)
  datos.append('direccion', direccion);
  datos.append('telefono', telefono);
  datos.append('limite_credito', limite_credito);

  $.ajax({
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {

      $("#modalClientes").modal('hide');
      $.ajax({
        async: false,
        url: rutaOculta + "ajax/clientes.ajax.php",
        method: "POST",
        data: {
          ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect"
        },
        dataType: "json",
        success: function (respuesta) {


          for (let index = 1; index < respuesta.length; index++) {
            options =
              "<option selected value=" +
              respuesta[index][0] +
              "> DNI: " +
              respuesta[index][1] + ' | ' + respuesta[index][2] +
              "</option>";
            $("#selcredito_usado").val(respuesta[index][6]);



          }

          $("#selCliente").append(options);

          console.log(respuesta);
          console.log(respuesta.length - 1);
          if (respuesta[respuesta.length - 1][6] == 0) {
            $(".creditoCli").remove();
          } else {
            $("#selTipoPago").html(
              '<option value="">Seleccione Tipo Pago</option>' +
              '<option value="Efectivo">Efectivo</option>' +
              '<option value="Tarjeta">Tarjeta</option>' +
              '<option value="Transferencia">Transferencia</option>' +
              '<option value="Yape">Yape</option>' +
              '<option value="Plin">Plin</option>' +
              '<option value="Mixto">Mixto</option>' +
              '<option  class="creditoCli" value="Credito">Credito</option>'
              // '<option class="creditoCli" value="Credito">Credito</option>' 
            );
          }


        },
      });

      $(".dni").val("");
      $(".nombres").val("");
      $(".direccion").val("");
      $(".telefono").val("");
      $(".limite_credito").val("");


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

function cargarSelectClientes() {

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarClienteSelect: "ajaxMostrarClienteSelect"
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta[0]["credito_usado"]);
      var options =
        "<option selected value=" + respuesta[0]["idCliente"] + ">DNI: " + respuesta[0]["dni"] + " | " + respuesta[0]["nombres"] + "</option>";
      for (let index = 1; index < respuesta.length; index++) {
        var options =
          options +
          "<option value=" +
          respuesta[index][0] +
          "> DNI: " +
          respuesta[index][1] + ' | ' + respuesta[index][2] +
          "</option>";
      }

      $("#selCliente").append(options);
      $("#selcredito_usado").val(respuesta[0]["credito_usado"]);
      

      if (respuesta[0]["credito_usado"] == 0) {
        $(".creditoCli").remove();
      } else {
        $("#selTipoPago").html(
          '<option value="">Seleccione Tipo Pago</option>' +
          '<option value="Efectivo">Efectivo</option>' +
          '<option value="Tarjeta">Tarjeta</option>' +
          '<option value="Transferencia">Transferencia</option>' +
          '<option value="Yape">Yape</option>' +
          '<option value="Plin">Plin</option>' +
          '<option value="Mixto">Mixto</option>' +
          '<option  class="creditoCli" value="Credito">Credito</option>'
          // '<option class="creditoCli" value="Credito">Credito</option>' 
        );
      }

     

    },
  });
}

var clienteSelectG;

function cargarClienteCreditoU(idCliente) {

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarCliente: "ajaxMostrarCliente",
      idCliente: idCliente
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta["credito_usado"]);
      $("#iptCreditoDis").val(respuesta["credito_usado"]);


    },
  });
}

$(document).on("change", "#selCliente", function () {
  var idCliente = $(this).val();

  clienteSelectG = idCliente;


  $.ajax({
    async: false,
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: {
      ajaxMostrarCliente: "ajaxMostrarCliente",
      idCliente: idCliente
    },
    dataType: "json",
    success: function (respuesta) {
      console.log(respuesta["credito_usado"]);
      console.log(clienteSelectG);
      $("#selcredito_usado").val(respuesta["credito_usado"]);



      if (respuesta["credito_usado"] == 0) {

        $(".creditoCli").remove();
        $(".cajasMetodoPago").html('');
        // console.log("este esta en 0 y no tiene credito");
      } else {
        //console.log("si tiene credito");

        $("#selTipoPago").html(
          '<option value="">Seleccione Tipo Pago</option>' +
          '<option value="Efectivo">Efectivo</option>' +
          '<option value="Tarjeta">Tarjeta</option>' +
          '<option value="Transferencia">Transferencia</option>' +
          '<option value="Yape">Yape</option>' +
          '<option value="Plin">Plin</option>' +
          '<option value="Mixto">Mixto</option>' +
          '<option  class="creditoCli" value="Credito">Credito</option>'
          // '<option class="creditoCli" value="Credito">Credito</option>' 
        );

         $(".cajasMetodoPago").html('');
          

         
      }

    },
  });
});


$(".dni").change(function () {
  var dni = $(this).val();
  ValidarDni(dni);
  TraerDni(dni)

})



function ValidarDni(dni) {


  var datos = new FormData();
  datos.append("ajaxValidarDni", dni);

  $.ajax({
    url: rutaOculta + "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        toast2.fire({
          icon: 'warning',
          title: '&nbsp;&nbsp;  Este dni ya existe en la base de datos!'
        })
        $(".dni").val("");


      }

    },
  });

}

function TraerDni(dni) {

  $.ajax({

    type: "POST",
    url: rutaOculta + "ajax/consultadni.ajax.php",
    data: 'dni=' + dni,
    dataType: 'json',
    success: function (data) {

      if (data == 1) {
        alert('El dni tiene que tener 8 digitos')
      } else {

        console.log(data);
        $(".nombres").val(MaysPrimera(data.nombres.toLowerCase()) + " " + MaysPrimera(data.apellidoPaterno.toLowerCase()) + ' ' + MaysPrimera(data.apellidoMaterno.toLowerCase()));
        //$(".apellidos").val();

      }

    }



  })
}

function MaysPrimera(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

$("#selTipoPago").change(function () {
  var metodo = $(this).val();

  if (metodo == "Efectivo") {
    $(".cajasMetodoPago").html(
      '<div class="form-group">' +
      '<label for="iptEfectivoRecibido">Efectivo recibido</label>' +
      '<input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibido" class="form-control form-control-sm" placeholder="Cantidad de efectivo recibida">' +
      "</div>" +
      '<div class="form-check">' +
      '<input class="form-check-input" type="checkbox" value="" id="chkEfectivoExacto">' +
      '<label class="form-check-label" for="chkEfectivoExacto">' +
      "Efectivo Exacto" +
      "</label>" +
      "</div>" +
      '<div class="row mt-2">' +
      '<div class="col-12">' +
      '<h5 class="text-start"><strong>Monto Efectivo: '+simbolom+' <span id="EfectivoEntregado">0.00</span></strong></h5>' +
      "</div>" +
      '<div class="col-12">' +
      '<h5 class="text-start text-danger"><strong>Vuelto: '+simbolom+' <span id="Vuelto">0.00</span></strong></h5>' +
      "</div>" +
      "</div>"
    );
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');

    recalcularTotales();
    // $(".cajacomision1").hide();
    //$(".cajacomision2").hide();

    pruebaefectivo();
    pruebacheck();
  } else if (metodo == "Tarjeta") {
    $(".cajasMetodoPago").html(
      '<div class="form-group">' +
      '<label for="iptTransaccion">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptTransaccion" id="iptTransaccion" class="form-control form-control-sm" placeholder="Codigo Transacción recibida">' +
      "</div>"

    );
    $(".cajacomision1").html(
      '<span>COMISIÓN</span> '

    );
    $(".cajacomision2").html(
      ''+simbolom+' <span class="" id="comision_bol">0.00</span>'

    );
    recalcularTotales();
    //$(".cajacomision1").show();
    //$(".cajacomision2").show();


  } else if (metodo == "Transferencia") {
    $(".cajasMetodoPago").html(
      '<div class="form-group">' +
      '<label for="iptDeposito">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptDeposito" id="iptDeposito" class="form-control form-control-sm" placeholder="Codigo Deposito recibida">' +
      "</div>" +
      '<div class="form-group">' +
      '<label for="nroContacto">Numero de contacto</label>' +
      '<input type="number" min="0" name="nroContacto" id="nroContacto" class="form-control form-control-sm" placeholder="Contacto telefonico">' +
      "</div>"
    );
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');

    recalcularTotales();
    // $(".cajacomision1").hide();
    //$(".cajacomision2").hide();
  } else if (metodo == "Yape") {
    $(".cajasMetodoPago").html(
      '<div class="form-group">' +
      '<label for="iptYape">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptYape" id="iptYape" class="form-control form-control-sm" placeholder="Codigo yape">' +
      "</div>"
    );
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');
    recalcularTotales();
  } else if (metodo == "Plin") {
    $(".cajasMetodoPago").html(
      '<div class="form-group">' +
      '<label for="iptPlin">Codigo Transacción</label>' +
      '<input type="number" min="0" name="iptPlin" id="iptPlin" class="form-control form-control-sm" placeholder="Codigo plin">' +
      "</div>"
    );
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');

    recalcularTotales();
    //    $(".cajacomision1").hide();
    //   $(".cajacomision2").hide();
  } else if (metodo == "Mixto") {
    $(".cajasMetodoPago").html(

      '<div class="form-group">' +

      '<div class="row">' +
      '<div class="col-md-6">' +
      '<label for="iptEfectivoRecibidoCM">Efectivo</label>' +
      '<input type="number" min="0" name="iptEfectivo" id="iptEfectivoRecibidoCM" class="form-control form-control-sm" placeholder="Monto">' +
      '</div>' +
      '<div class="col-md-6">' +
      '<label for="iptTarjetaRecibido">Tarjeta</label>' +
      '<input type="number" min="0" name="iptTarjetaRecibido" id="iptTarjetaRecibido" class="form-control form-control-sm" placeholder="Monto">' +
      '<input type="hidden" id="iptTarjetaRecibidoH">' +
      '</div>' +
      '</div>' +
      '</div>' +

      '<div class="form-check">' +

      '<div class="row">' +
      '<div class="col-md-3">' +
      '<input class="form-check-input" type="radio" name="radio1" value="Tarjeta" id="rdTarjeta">' +
      '<label class="form-check-label" for="rdTarjeta">' +
      "Tarjeta" +
      "</label>" +
      '</div>' +
      '<div class="col-md-3">' +
      '<input class="form-check-input" type="radio" name="radio1"value="Transferencia" id="rdTransf">' +
      '<label class="form-check-label" for="rdTransf">' +
      "Transf." +
      "</label>" +
      '</div>' +
      '<div class="col-md-3">' +
      '<input class="form-check-input" type="radio"name="radio1" value="Yape" id="rdYape">' +
      '<label class="form-check-label" for="rdYape">' +
      "Yape" +
      "</label>" +
      '</div>' +
      '<div class="col-md-3">' +
      '<input class="form-check-input" type="radio" name="radio1"value="Plin" id="rdPlin">' +
      '<label class="form-check-label" for="rdPlin">' +
      "Plin" +
      "</label>" +
      '</div>' +
      '</div>' +
      '</div>' +
      '<div class="row mt-2">' +
      '<div class="col-12">' +
      '<h5 class="text-start"><strong>Total Restante: '+simbolom+' <span id="EfectivoEntregadoCM">0.00</span></strong></h5>' +
      "</div>" +

      "</div>"


    );
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');

    recalcularTotales();
    //    $(".cajacomision1").hide();
    //   $(".cajacomision2").hide();
  } else if (metodo == "Credito") {
    
    $(".cajasMetodoPago").html(

      '<div class="form-group">' +

      '<div class="row">' +
      '<div class="col-md-12">' +
      '<label for="iptCreditoDis">Credito Disponible</label>' +
      '<input type="number" min="0" name="iptCreditoDis" id="iptCreditoDis" class="form-control form-control-sm" placeholder="Credito Disponible" readonly>' +
      '</div>' +
     
      '</div>' +
      '</div>' +


      "</div>"

     

    );
     
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');

    recalcularTotales();
    cargarClienteCreditoU(clienteSelectG) ;
    //    $(".cajacomision1").hide();
    //   $(".cajacomision2").hide();
  }else {
    $(".cajasMetodoPago").html("");
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');


    // $(".cajacomision1").hide();
    //$(".cajacomision2").hide();
    recalcularTotales();
  }
});
//var pruebarestar;
$(document).on("change", "input[name='radio1']", function () {
  // var tipo1 = document.querySelector('input[name = "radio1"]:checked');
  var metodo = $(this).val();


  if (metodo == "Tarjeta") {
    $(".cajacomision1").html(
      '<span>COMISIÓN</span> '

    );
    $(".cajacomision2").html(
      ''+simbolom+' <span class="" id="comision_bol_mixto">0.00</span>'

    );
    /*var comision = parseFloat($("#iptTarjetaRecibido").val()) * 0.05;
    var totalComision = parseFloat($("#iptTarjetaRecibido").val()) + parseFloat(comision)
    $("#iptTarjetaRecibido").val(parseFloat(totalComision).toFixed(2));
    $("#comision_bol_mixto").html(parseFloat(comision).toFixed(2));


    
    var totalCM = parseFloat(pruebatotales) + parseFloat(comision);
    $("#boleta_total").html(parseFloat(totalCM).toFixed(2));*/

    //pruebarestar = comision.toFixed(2);
    // console.log(comision.toFixed(2))


    recalcularTotalesCM();
  } else {
    $(".cajacomision1").html(
      ''

    );
    $(".cajacomision2").html('');
    //$("#iptTarjetaRecibido").val(0);



    recalcularTotalesCM();
  }
  metodoradio1 = $(this).val();
});

$(document).on("keyup", "#iptTarjetaRecibido", function () {

  $("#iptTarjetaRecibidoH").val($(this).val());

})

/* ======================================================================================
    EVENTO PARA ELIMINAR UN PRODUCTO DEL LISTADO
    ======================================================================================*/
$("#lstProductosVenta tbody").on("click", ".btnEliminarproducto", function () {

  table.row($(this).parents("tr")).remove().draw();

  $("#iptCodigoVenta").focus();
  recalcularTotales();

  /*table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();
      TotalVenta =
        parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
    });
  //0037128471 codigo interna, para reponer la nat
  $("#totalVenta").html("");
  $("#totalVenta").html(TotalVenta.toFixed(2));

  var totalVenta = $("#totalVenta").html();
  var igv = parseFloat(totalVenta) * impuesto;
  var subtotal = parseFloat(totalVenta) - parseFloat(igv);
  $("#totalVentaRegistrar").html(totalVenta);

  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));
  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));*/
  //$("#iptCodigoVenta").focus();
});


/* ======================================================================================
    EVENTO PARA AUMENTAR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ======================================================================================*/
$("#lstProductosVenta tbody").on("click", ".btnAumentarCantidad", function () {
  //$(document).on("click", ".btnAumentarCantidad", function () {
  var data = table.row($(this).parents("tr")).data();
  var TotalVenta = 0.0;
  var codigo_producto = data["codigoBarras"];
  var flag_stock = 0;

  // VERIFICAMOS QUE EL PRODUCTO TENGA STOCK
  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();

      if (parseInt(codigo_producto) == data["codigoBarras"]) {
        $.ajax({
          async: false,
          url: rutaOculta + "ajax/producto.ajax.php",
          method: "POST",
          data: {
            ajaxVerificarStock: "ajaxVerificarStock",
            codigo_producto: data["codigoBarras"],
            cantidad_a_comprar: data["cantidad"],
            idAlmacen: idAlmacen,
          },

          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta[0]) == 0) {
              toast2.fire({
                icon: "error",
                title: "&nbsp;  El producto " +
                  data["descProducto"] +
                  " ya no tiene stock",
              });

              flag_stock = 0;
              $("#iptCodigoVenta").val("");
              $("#iptCodigoVenta").focus();
            } else {
              flag_stock = 1;
            }
          },
        });
      }
    });

  if (flag_stock == 1) {
    cantidad = parseInt(data["cantidad"]) + 1;

    var idx = table.row($(this).parents("tr")).index();

    table
      .cell(idx, 3)
      .data(cantidad + " Und(s)")
      .draw();

    NuevoPrecio = (
      parseInt(data["cantidad"]) *
      data["precio_venta_producto"].replace(simbolom, "")
    ).toFixed(2);
    NuevoPrecio = simbolom + NuevoPrecio;
    table.cell(idx, 5).data(NuevoPrecio).draw();
    recalcularTotales();
    // recalcularTotalesCM();
    /*  table
        .rows()
        .eq(0)
        .each(function (index) {
          var row = table.row(index);

          var data = row.data();
          TotalVenta =
            parseFloat(TotalVenta) +
            parseFloat(data["total"].replace(simbolom, ""));
        });

      $("#totalVenta").html("");
      $("#totalVenta").html(TotalVenta.toFixed(2));

      $("#iptCodigoVenta").focus();
      var totalVenta = $("#totalVenta").html();
      var igv = parseFloat(totalVenta) * impuesto;
      var subtotal = parseFloat(totalVenta) - parseFloat(igv);
      $("#totalVentaRegistrar").html(totalVenta);

      $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
      $("#subtotal").val(parseFloat(subtotal).toFixed(2));

      $("#boleta_igv").html(parseFloat(igv).toFixed(2));
      $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));*/
  }
});

$("#lstProductosVenta tbody").on("click", ".dropdown-item", function () {
  event.preventDefault();
  console.log("precio_normal", $(this).attr("precio_normal"));
  console.log("precio_mayor", $(this).attr("precio_mayor"));
  console.log("precio_oferta", $(this).attr("precio_oferta"));
  console.log("precio_oferta2", $(this).attr("precio_oferta2"));

  codigo_producto = $(this).attr("codigo");

  if ($(this).attr("precio_normal") != null) {
    precio_venta = $(this).attr("precio_normal");
  }
  if ($(this).attr("precio_mayor") != null) {
    precio_venta = $(this).attr("precio_mayor");
  }
  if ($(this).attr("precio_oferta") != null) {
    precio_venta = $(this).attr("precio_oferta");
  }
  if ($(this).attr("precio_oferta2") != null) {
    precio_venta = $(this).attr("precio_oferta2");
  }
  if ($(this).attr("precio_oferta3") != null) {
    precio_venta = $(this).attr("precio_oferta3");
  }
  recalcularMontos(codigo_producto, precio_venta.replaceAll(simbolom, ""));
});

function recalcularMontos(codigo_producto, precio_venta) {
  // alert(codigo_producto);

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();

      if (data["codigoBarras"] == codigo_producto) {
        // AUMENTAR EN 1 EL VALOR DE LA CANTIDAD
        table
          .cell(index, 4)
          .data(simbolom + parseFloat(precio_venta).toFixed(2))
          .draw();

        // ACTUALIZAR EL NUEVO PRECIO DEL ITEM DEL LISTADO DE VENTA
        NuevoPrecio = (
          parseInt(data["cantidad"]) *
          data["precio_venta_producto"].replace(simbolom, "")
        ).toFixed(2);
        NuevoPrecio = simbolom + NuevoPrecio;
        table.cell(index, 5).data(NuevoPrecio).draw();

        // RECALCULAMOS TOTALES
      }
    });

  recalcularTotales();
}



var pruebatotales;

function recalcularTotales() {
  var TotalVenta = 0.0;

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);
      var data = row.data();
      pruebatotales = parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
      TotalVenta =
        parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
    });



  //if(comisionbol==""){
  if (!document.getElementById("comision_bol")) {

    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));


    var deliverys = $("#iptDelivery").val();
    var totalVenta = $("#totalVenta").html();
    var igv = parseFloat(totalVenta) * impuesto;
    var subtotal = parseFloat(totalVenta) - parseFloat(igv);

    var totaltotal = parseFloat(totalVenta) + parseFloat(deliverys);

    $("#totalVentaRegistrar").html(totaltotal.toFixed(2));
    $("#subtotal").val(parseFloat(subtotal).toFixed(2));
    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#boleta_igv").html(parseFloat(igv).toFixed(2));
    $("#boleta_total").html(parseFloat(totaltotal).toFixed(2));

    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();


  } else {


    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));

    $("#iptCodigoVenta").val("");

    var totalVenta = $("#totalVenta").html();
    var igv = parseFloat(totalVenta) * impuesto;
    var subtotal = parseFloat(totalVenta) - parseFloat(igv);
    var deliverys = $("#iptDelivery").val();

    var comision = parseFloat(totalVenta) * 0.05;
    var totaltotal = parseFloat(totalVenta) + parseFloat(comision) + parseFloat(deliverys);

    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#subtotal").val(parseFloat(subtotal).toFixed(2));
    $("#comision_bol").html(parseFloat(comision).toFixed(2));
    $("#boleta_igv").html(parseFloat(igv).toFixed(2));
    //    $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

    $("#totalVentaRegistrar").html(totaltotal.toFixed(2));
    // $("#boleta_total").html(totalVenta);
    $("#boleta_total").html(parseFloat(totaltotal).toFixed(2));
    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();

  }

}

function recalcularTotalesCM() {
  var TotalVenta = 0.0;

  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);
      var data = row.data();
      pruebatotales = parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
      TotalVenta =
        parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
    });



  //if(comisionbol==""){
  if (!document.getElementById("comision_bol_mixto")) {

    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));


    var deliverys = $("#iptDelivery").val();
    var totalVenta = $("#totalVenta").html();
    var igv = parseFloat(totalVenta) * impuesto;
    var subtotal = parseFloat(totalVenta) - parseFloat(igv);

    var comision = parseFloat($("#iptTarjetaRecibidoH").val()) * 0.05;

    var totalComision = parseFloat($("#iptTarjetaRecibidoH").val()) + parseFloat(comision) - parseFloat(comision)
    $("#iptTarjetaRecibido").val(parseFloat(totalComision).toFixed(2));

    var totaltotal = parseFloat(totalVenta) + parseFloat(deliverys);

    $("#totalVentaRegistrar").html(totaltotal.toFixed(2));
    $("#subtotal").val(parseFloat(subtotal).toFixed(2));
    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#boleta_igv").html(parseFloat(igv).toFixed(2));
    $("#boleta_total").html(parseFloat(totaltotal).toFixed(2));

    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();


  } else {


    $("#totalVenta").html("");
    $("#totalVenta").html(TotalVenta.toFixed(2));

    $("#iptCodigoVenta").val("");

    var totalVenta = $("#totalVenta").html();
    var igv = parseFloat(totalVenta) * impuesto;
    var subtotal = parseFloat(totalVenta) - parseFloat(igv);
    var deliverys = $("#iptDelivery").val();




    var comision = parseFloat($("#iptTarjetaRecibidoH").val()) * 0.05;

    var totalComision = parseFloat($("#iptTarjetaRecibidoH").val()) + parseFloat(comision)
    $("#iptTarjetaRecibido").val(parseFloat(totalComision).toFixed(2));

    var totaltotal = parseFloat(totalVenta) + parseFloat(comision) + parseFloat(deliverys);

    $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
    $("#subtotal").val(parseFloat(subtotal).toFixed(2));
    $("#comision_bol_mixto").html(parseFloat(comision).toFixed(2));
    $("#boleta_igv").html(parseFloat(igv).toFixed(2));
    //    $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

    $("#totalVentaRegistrar").html(totaltotal.toFixed(2));
    // $("#boleta_total").html(totalVenta);
    $("#boleta_total").html(parseFloat(totaltotal).toFixed(2));
    // $("#iptTarjetaRecibido").focus();
    $("#iptCodigoVenta").val("");
    $("#iptCodigoVenta").focus();

  }

}


/* ======================================================================================
    EVENTO PARA DESMINUIR LA CANTIDAD DE UN PRODUCTO DEL LISTADO
    ======================================================================================*/
$("#lstProductosVenta tbody").on("click", ".btnDisminuirCantidad", function () {
  var data = table.row($(this).parents("tr")).data();
  var TotalVenta = 0.0;
  if (data["cantidad"].replace("Und(s)", "") >= 2) {
    cantidad = parseInt(data["cantidad"].replace("Und(s)", "")) - 1;

    var idx = table.row($(this).parents("tr")).index();

    table
      .cell(idx, 3)
      .data(cantidad + " Und(s)")
      .draw();

    NuevoPrecio = (
      parseInt(data["cantidad"]) *
      data["precio_venta_producto"].replace(simbolom, "")
    ).toFixed(2);
    NuevoPrecio = simbolom + NuevoPrecio;
    table.cell(idx, 5).data(NuevoPrecio).draw();
  }
  recalcularTotales();
  /*table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();
      TotalVenta =
        parseFloat(TotalVenta) + parseFloat(data["total"].replace(simbolom, ""));
    });

  $("#totalVenta").html("");
  $("#totalVenta").html(TotalVenta.toFixed(2));

  $("#iptCodigoVenta").focus();
  var totalVenta = $("#totalVenta").html();
  var igv = parseFloat(totalVenta) * impuesto;
  var subtotal = parseFloat(totalVenta) - parseFloat(igv);

  $("#totalVentaRegistrar").html(totalVenta);
  $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
  $("#subtotal").val(parseFloat(subtotal).toFixed(2));

  $("#boleta_igv").html(parseFloat(igv).toFixed(2));
  $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));*/
});

/* ======================================================================================
    EVENTO QUE PERMITE CHECKEAR EL EFECTIVO CUANDO ES EXACTO
    =========================================================================================*/

function pruebacheck() {
  $("#chkEfectivoExacto").change(function () {
    // alert($("#chkEfectivoExacto").is(':checked'))

    if ($("#chkEfectivoExacto").is(":checked")) {
      var vuelto = 0;
      var totalVenta = $("#totalVentaRegistrar").html();

      $("#iptEfectivoRecibido").val(totalVenta);

      $("#EfectivoEntregado").html(totalVenta);
      var EfectivoRecibido = parseFloat(
        $("#EfectivoEntregado").html().replace(simbolom, "")
      );

      vuelto = parseFloat(totalVenta) - parseFloat(EfectivoRecibido);

      $("#Vuelto").html(vuelto.toFixed(2));
    } else {
      $("#iptEfectivoRecibido").val("");
      $("#EfectivoEntregado").html("0.00");
      $("#Vuelto").html("0.00");
    }
  });
}

$("#chkDeliveryExacto").change(function () {
  // alert($("#chkEfectivoExacto").is(':checked'))

  if ($("#chkDeliveryExacto").is(":checked")) {

    $(".deliveryaparece").html(
      '<input type="number" min="0" name="iptDelivery" id="iptDelivery" class="form-control form-control-sm"  value="0"placeholder="Monto delivery recibido"> <br>'
    );


  } else {
    $(".deliveryaparece").html(
      '<input id="iptDelivery" type="hidden" value = "0" >'
    );

  }
  recalcularTotales();
  recalcularTotalesCM();

});

$(document).on("change", "#iptDelivery", function () {


  recalcularTotales();

  recalcularTotalesCM();
})


//17/06/2022
//comprar para que no ponga stock inexistente
var pruebacodigo;
$(document).on("click", ".btnEditarCantidad", function () {

  var data = table.row($(this).parents("tr")).data();
  var codigo_barra = data["codigoBarras"];
  var producto = data["descProducto"];


  $("#codigoBarrasc").val(codigo_barra);
  $("#descProductoc").val(producto);

  $('#modalCantidadVenta').on('shown.bs.modal', function (e) {
    $("#cantidaVenta").val("");
    $("#cantidaVenta").focus();

    $("#cantidaVenta").change(function () {

      if (data["codigoBarras"] == pruebacodigo) {
        if (Number($("#cantidaVenta").val()) > data["stock"]) {


          $("#cantidaVenta").focus();
          $("#cantidaVenta").val("");

          Swal.fire({
            title: "La capacidad fue superada",
            html: "¡Solo hay " + data["stock"] + " de capacidad!",
            icon: "error",
            timer: 1500,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();

              timerInterval = setInterval(() => {}, 75);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("se ha cerrado por el tiempo!");
            }
          });
        }
      }


    });

  })
  pruebacodigo = $(this).attr("codigo");

});




$(document).on("click", ".btnEditCantidadVnta", function () {
  //  event.preventDefault();
  event.preventDefault();

  toast2.fire({
    icon: 'success',
    title: '&nbsp; La cantidad fue corregido!'
  });

  $("#modalCantidadVenta").modal("hide");

  if ($(this).attr("cantidad") != "") {
    cantidad = $("#cantidaVenta").val();
  }
  console.log(cantidad);
  console.log(pruebacodigo);
  // console.log(codigo_producto, cantidad);
  recalcularCantidad(pruebacodigo, cantidad);


});

function recalcularCantidad(codigo_producto, cantidad) {

  table.rows().eq(0).each(function (index) {

    var row = table.row(index);

    var data = row.data();

    if (data["codigoBarras"] == codigo_producto) {

      //cantidad =  cantidad;

      //var idx = table.row($(this).parents("tr")).index();

      table
        .cell(index, 3)
        .data(cantidad + " Und(s)")
        .draw();

      NuevoPrecio = (parseInt(data["cantidad"]) * data["precio_venta_producto"].replace(simbolom, "")).toFixed(2);
      NuevoPrecio = simbolom + NuevoPrecio;
      table.cell(index, 5).data(NuevoPrecio).draw();
    }
  });

  recalcularTotales();
}

$("#btnIniciarVenta").on("click", function () {
  realizarVenta();
});

function realizarVenta() {
  var estado_caja;

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxVerificarCaja: "ajaxVerificarCaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      estado_caja = respuesta["count(*)"];

      if (respuesta["count(*)"] == 0) {
        estado_caja = 0;
      }
    },
  });

  if (estado_caja > 0) {
    var count = 0;

    var igvVenta = $("#boleta_igv").html();

    var totalVenta = $("#boleta_total").html();
    var selTipoPagoV = $("#selTipoPago").val();
    var selCliente = $("#selCliente").val();

    var delivery = $("#iptDelivery").val();

    if (selTipoPagoV == "Efectivo") {
      var selTipoPagoV = $("#selTipoPago").val();
      var pago_efe = $("#boleta_total").html();
      var pago_tar = 0;
      var pago_credit = 0;
      var codigo_transa = "";
      var contacto = "";
      var comision = 0;
      var totalVentatarjeta = 0;
    } else if (selTipoPagoV == "Tarjeta") {
      var selTipoPagoV = $("#selTipoPago").val();
      var pago_efe = 0;
      var pago_tar = $("#boleta_total").html();
      var pago_credit = 0;
      var codigo_transa = $("#iptTransaccion").val();
      var contacto = "";
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = $("#comision_bol").html();
    } else if (selTipoPagoV == "Transferencia") {
      var selTipoPagoV = $("#selTipoPago").val();
      var pago_efe = 0;
      var pago_tar = $("#boleta_total").html();
      var pago_credit = 0;
      var codigo_transa = $("#iptDeposito").val();
      var contacto = $("#nroContacto").val();
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = 0;
    } else if (selTipoPagoV == "Yape") {
      var selTipoPagoV = $("#selTipoPago").val();
      var pago_efe = 0;
      var pago_tar = $("#boleta_total").html();
      var pago_credit = 0;
      var codigo_transa = $("#iptYape").val();
      var contacto = "";
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = 0;
    } else if (selTipoPagoV == "Plin") {

      var pago_efe = 0;
      var pago_tar = $("#boleta_total").html();
      var pago_credit = 0;
      var codigo_transa = $("#iptPlin").val();
      var contacto = "";
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = 0;
    } else if (selTipoPagoV == "Mixto") {
      var selTipoPagoV = document.querySelector('input[name = "radio1"]:checked');

      if (selTipoPagoV != null) {
        var selTipoPagoV = selTipoPagoV.value;
      } else {
        var selTipoPagoV = "";
      }

      var pago_efe = $("#iptEfectivoRecibidoCM").val();
      var pago_tar = $("#iptTarjetaRecibido").val();
      var pago_credit = 0;
      var codigo_transa = "";
      var contacto = "";
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = $("#comision_bol_mixto").html();


    }else if (selTipoPagoV == "Credito") {
      
      var pago_efe = 0;
      var pago_tar = 0;
      var pago_credit = $("#boleta_total").html();
      var codigo_transa = "";
      var contacto = "";
      var totalVentatarjeta = $("#totalVenta").html();
      var comision = $("#comision_bol_mixto").html();

    }

    table
      .rows()
      .eq(0)
      .each(function (index) {
        count = count + 1;
      });

    if (count > 0) {
      if ($("#iptEfectivoRecibido").val() < parseFloat(totalVenta)) {
        toast2.fire({
          icon: "warning",
          title: "El efectivo es menor al costo total de la venta",
        });

        return false;
      }

      if ($("#selDocumentoVenta").val() == 0) {
        toast2.fire({
          icon: "warning",
          title: "&nbsp; seleccione un documento",
        });

        return false;
      }

      if ($("#selTipoPago").val() == 0) {
        toast2.fire({
          icon: "warning",
          title: "&nbsp; seleccione un tipo de pago",
        });

        return false;
      }

      if ($("#selTipoPago").val() == 1) {
        if (
          $("#iptEfectivoRecibido").val() == 0 &&
          $("#iptEfectivoRecibido").val() == ""
        ) {
          toast2.fire({
            icon: "error",
            title: "&nbsp; Ingrese el monto en efectivo",
          });

          return false;
        }
      }

      if ($("#selTipoPago").val() == 2) {
        if ($("#iptTransaccion").val() == "") {
          toast2.fire({
            icon: "error",
            title: "&nbsp; Ingrese el codigo de transacción",
          });

          return false;
        }
      }

      if ($("#selTipoPago").val() == 3) {
        if ($("#iptYape").val() == 0) {
          toast2.fire({
            icon: "error",
            title: "&nbsp; Ingrese el codigo de yape",
          });

          return false;
        }
      }

 
      if ($("#iptCreditoDis").val() < parseFloat(totalVenta)) {
        toast2.fire({
          icon: "warning",
          title: "El total no debe exceder al credito establecido",
        });

        return false;
      }

      var formData = new FormData();
      var arr = [];

      //var listarprueba=[];

      table
        .rows()
        .eq(0)
        .each(function (index) {
          // var datos = new FormData();

          var row = table.row(index);

          var data = row.data();

          arr[index] =
            data["codigoBarras"] +
            "," +
            parseFloat(data["cantidad"]) +
            "," +
            data["total"].replace(simbolom, "") +
            "," +
            data["idProducto"] +
            "," +
            data["stock"];
          formData.append("arr[]", arr[index]);

          /* listarprueba.push(data[1],
                              parseFloat(data[3]),
                               data[5].replace(
              simbolom, "") ,data[6] ,data[7])*/

          //  console.log("lista,", listarprueba)
        });

        
      formData.append("idCliente", selCliente);
      formData.append("idAlmacen", idAlmacen);
      formData.append("idUsuario", idUsuario);
      formData.append("idDocalmacen", idDocalmacen);
      formData.append("serie", serie);
      formData.append("nro_comprobante", nro_boleta);
      formData.append("descripcion", "Venta realizada con Nro: " + nro_boleta);

      formData.append("pago_efe", pago_efe);
      formData.append("pago_tar", pago_tar);
      formData.append("pago_credit", pago_credit);
      
      formData.append("subtotal", $("#subtotal").val());
      formData.append("igv", igvVenta);
      formData.append("comision", comision);
      formData.append("delivery", delivery);
      formData.append("total_venta", parseFloat(totalVenta));
      formData.append("tipo_pago", selTipoPagoV);
      formData.append("codigo_transa", codigo_transa);
      formData.append("contacto", contacto);
      formData.append("idCaja", idCaja);


      formData.append("totalVentatarjeta", totalVentatarjeta);

      $.ajax({
        url: rutaOculta + "ajax/ventas.ajax.php",
        method: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {


          Swal.fire({
            position: "center",
            title: "Se registró la venta correctamente.",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Imprimir!",
          }).then((result) => {
            if (result.isConfirmed) {
              printJS(rutaOculta + "/extensions/libreporte/reportes/generar_tickerventa.php?idVenta=" + respuesta)
              /*window.open(
                rutaOculta+"/extensions/libreporte/reportes/generar_tickerventa.php?idVenta=" +
                respuesta +
                "#zoom=100%",
                "Ticket",
                "scrollbars=NO"
              );*/

            } else {

            }
          });

          console.log(respuesta);
          table.clear().draw();
          traerNotificacionBajoInv();
          $("#selDocumentoVenta").val("");
          $("#selTipoPago").val("");
         
          $("#selCliente").val("1").trigger("change");

          $("#iptNroSerie").val("");
          $("#iptNroVenta").val("");
          $("#totalVenta").html("0.00");
          $("#totalVentaRegistrar").html("0.00");
          $("#boleta_total").html("0.00");
          $("#boleta_igv").html("0.00");
          $("#boleta_subtotal").html("0.00");
          $("#subtotal").val("0.00");
          $("#comision_bol").html("0.00");


          $("#iptTransaccion").val("");
          $("#nroContacto").val("");
          $("#iptYape").val("");

          $("#iptEfectivoRecibido").val("");
          $("#EfectivoEntregado").html("0.00");
          $("#Vuelto").html("0.00");
          $("#chkEfectivoExacto").prop("checked", false);
          $(".cajasMetodoPago").html("");
          $("#chkDeliveryExacto").prop("checked", false);
          $(".deliveryaparece").html(
            '<input id="iptDelivery" type="hidden" value = "0" >'
          );


          $("#iptCodigoVenta").focus();
          //cargarSelectDocumento();
        },
      });
    } else {
      toast2.fire({
        icon: "error",
        title: "&nbsp; No hay productos en el listado.",
      });

      $("#iptCodigoVenta").focus();
    }

    $("#iptCodigoVenta").focus();
  } else {
    toast2.fire({
      icon: "warning",
      title: "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura",
    });
  }
}
//})

$(document).ready(function () {
  function CargaNroBoletaValidate() {
    var Boletas = $("#selDocumentoVenta").val();
    var idAlmacenb = $("#idAlmacenV").val();
    $.ajax({
      async: false,
      url: rutaOculta + "ajax/ventas.ajax.php",
      method: "POST",
      data: {
        ajaxVerNroBoleta: "ajaxVerNroBoleta",
        Documento: Boletas,
        idAlmacen: idAlmacenb,
      },
      dataType: "json",
      success: function (respuesta) {
        // console.log(respuesta["idDocalmacen"])
        idDocalmacen = respuesta["idDocalmacen"];
        serie = respuesta["Serie"];
        nro_boleta = respuesta["nro_venta"];

        $("#iptNroSerie").val(respuesta["Serie"]);
        $("#iptNroVenta").val(respuesta["nro_venta"]);
      },
    });
  }

  /*setInterval(function () {
    CargaNroBoletaValidate();
  }, 1000);*/
});

/* ======================================================================================
    EVENTO QUE SE DISPARA AL DIGITAR EL MONTO EN EFECTIVO ENTREGADO POR EL CLIENTE
    =========================================================================================*/
function pruebaefectivo() {
  $("#iptEfectivoRecibido").keyup(function () {
    var totalVenta = $("#totalVentaRegistrar").html();

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

//verificar que acepte letras y numeros en su codigo de barras
$("#btnVaciarListado").on("click", function () {
  VaciarListado();
});

function VaciarListado() {
  table.clear().draw();
  LimpiarInputs();
}

function LimpiarInputs() {
  $("#totalVenta").html("0.00");
  $("#totalVentaRegistrar").html("0.00");
  $("#boleta_total").html("0.00");
  $("#iptEfectivoRecibido").val("");
  $("#EfectivoEntregado").html("0.00");
  $("#boleta_subtotal").html("0.00");
  $("#subtotal").val("0.00");

  $("#boleta_igv").html("0.00");
  $("#Vuelto").html("0.00");
  $("#chkEfectivoExacto").prop("checked", false);
}

/* ======================================================================================
    EVENTO QUE REGISTRA EL PRODUCTO EN EL LISTADO CUANDO SE INGRESA EL CODIGO DE BARRAS
    ======================================================================================*/
$("#iptCodigoVenta").change(function () {
  CargarProductosV();
  $("#iptCodigoVenta").val("");
  $("#iptCodigoVenta").focus();
});

$(document).on("click", ".btneditarOfertaDNI", function () {
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
      $("#codigoBarras").val(respuesta["codigoBarras"]);
      $("#preciocambio").val(respuesta["ofertaDNI"]);
    },
  });
  $("#modalProductoVenta").on("shown.bs.modal", function (e) {
    $("#dniConejo").focus();
  });
});

$(".btnEditarPrecioOferta").on("click", function () {
  event.preventDefault();

  //AHORA TRAER LA TABLA DNI Y COMPARARLOS SI EXISTE EN LA BASE DE DAATOS
  var codigo_producto = $("#codigoBarras").val();

  var dniConejo = $("#dniConejo").val();

  var datos = new FormData();
  datos.append("ajaxDniConejo", "ajaxDniConejo");
  datos.append("dniConejo", dniConejo);

  $.ajax({
    url: rutaOculta + "ajax/conejo.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta) {
        toast2.fire({
          icon: "success",

          title: "&nbsp; Precio Oferta para " + respuesta["nombreConejo"],
        });

        $("#modalProductoVenta").modal("hide");
        $("#dniConejo").val("");
        //tengo que traer el precio y el codigo de producto

        if ($(this).attr("precio_oferta3") != "") {
          precio_venta = $("#preciocambio").val();
          //precio_venta = $(this).attr("precio_oferta3");
        }
        recalcularMontos(codigo_producto, precio_venta.replaceAll(simbolom, ""));
      } else {
        toast2.fire({
          icon: "error",
          title: "&nbsp; DNI no coincide",
        });
        $("#modalProductoVenta").modal("hide");
        $("#dniConejo").val("");
      }
    },
  });
});

function CargarProductosV(producto = "") {
  if (producto != "") {
    var codigo_producto = producto;
  } else {
    var codigo_producto = $("#iptCodigoVenta").val();
  }

  var existe = 0;
  var codigo_repetido;
  var NuevoPrecio = 0;
  var TotalVenta = 0;
  var flag_stock = 1;

  // VERIFICAMOS QUE EL PRODUCTO TENGA STOCK
  table
    .rows()
    .eq(0)
    .each(function (index) {
      var row = table.row(index);

      var data = row.data();

      if (parseInt(codigo_producto) == data["codigo_producto"]) {
        $.ajax({
          async: false,
          url: rutaOculta + "ajax/producto.ajax.php",
          method: "POST",
          data: {
            ajaxVerificarStock: "ajaxVerificarStock",
            codigo_producto: data["codigo_producto"],
            cantidad_a_comprar: data["cantidad"],
            idAlmacen: idAlmacen,
          },

          dataType: "json",
          success: function (respuesta) {
            if (parseInt(respuesta[0]) == 0) {
              // alert('entro')

              toast2.fire({
                icon: "error",
                title: "&nbsp;  El producto " +
                  data["descProducto"] +
                  " ya no tiene stock",
              });

              flag_stock = 0;
              $("#iptCodigoVenta").val("");
              $("#iptCodigoVenta").focus();
            } else {
              flag_stock = 1;
            }
          },
        });
      }
    });

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

          if (data["codigoBarras"] == codigo_repetido) {
            table
              .cell(index, 3)
              .data(parseInt(data["cantidad"]) + 1 + " Und(s)")
              .draw();

            NuevoPrecio = (
              parseInt(data["cantidad"]) *
              data["precio_venta_producto"].replace(simbolom, "")
            ).toFixed(2);
            NuevoPrecio = simbolom + NuevoPrecio;

            table.cell(index, 5).data(NuevoPrecio).draw();

            $("#iptCodigoVenta").val("");
            recalcularTotales();
            /* table
              .rows()
              .eq(0)
              .each(function (index) {
                var row = table.row(index);

                var data = row.data();
                TotalVenta =
                  TotalVenta + parseFloat(data["total"].replace(simbolom, ""));
              });
*/
            /* $("#totalVenta").html("");
             $("#totalVenta").html(TotalVenta.toFixed(2));
             $("#totalVentaRegistrar").html(TotalVenta.toFixed(2));

             var igv = parseFloat(TotalVenta) * impuesto;
             var subtotal = parseFloat(TotalVenta) - parseFloat(igv);

             $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
             $("#subtotal").val(parseFloat(subtotal).toFixed(2));

             $("#boleta_igv").html(parseFloat(igv).toFixed(2));
             $("#boleta_total").html(TotalVenta.toFixed(2));

             $("#iptCodigoVenta").focus();
             $("#iptCodigoVenta").val("");*/
            // console.log("entro repetido")
            // return false;
          }
        });

      /*============================================================================
            SI EL PRODUCTO NO ESTA REGISTRADO EN EL LISTADO DE VENTAS
            ============================================================================*/
    } else {
      $.ajax({
        url: rutaOculta + "ajax/producto.ajax.php",
        method: "POST",
        data: {
          ajaxGestorProductoV: "ajaxGestorProductoV",
          codigo_producto: codigo_producto,
          idAlmacen: idAlmacen,
        },

        dataType: "json",
        success: function (respuesta) {
          //  console.log(respuesta);
          if (respuesta) {
            var TotalVenta = 0.0;

            
              table.row
                .add({
                  idProducto: itemProducto,
                  codigoBarras: respuesta["codigoBarras"],
                  descProducto: respuesta["descProducto"],
                  cantidad: respuesta["cantidad"] + " Und(s)",
                  precio_venta_producto: respuesta["precio_venta_producto"],
                  total: respuesta["total"],
                  acciones: "<center>" +
                    "<span class='btnAumentarCantidad text-success px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Aumentar Stock'> " +
                    "<i class='fas fa-cart-plus fs-5'></i> " +
                    "</span> " +
                    "<span class='btnDisminuirCantidad text-warning px-1' style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Disminuir Stock'> " +
                    "<i class='fas fa-cart-arrow-down fs-5'></i> " +
                    "</span> " +
                    "<span class='btnEliminarproducto text-danger px-1'style='cursor:pointer;' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar producto'> " +
                    "<i class='fas fa-trash fs-5'> </i> " +
                    "</span>" +
                    
                    "<div class='btn-group'>" +
                    "<button type='button' class='transparente p-0 btn transparentbar dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>" +
                    "<i class='fas fa-cog text-primary fs-5'></i> <i class='fas fa-chevron-down text-primary'></i>" +
                    "</button>" +
                    "<ul class='dropdown-menu'>" +
                    "<li><a class='dropdown-item' codigo = '" +
                    respuesta["codigoBarras"] +
                    "' precio_normal=' " +
                    respuesta["precio_venta_producto"] +
                    "' style='cursor:pointer; font-size:14px;'>Normal (" +
                    respuesta["precio_venta_producto"] +
                    ")</a></li>" +
                    //"<li><a class='dropdown-item' codigo = '" + respuesta['codigoBarras'] + "' precio_mayor=' " + respuesta['precioVentaMA'] + "' style='cursor:pointer; font-size:14px;'>Mayorista AQP (S./ " + parseFloat(respuesta['precioVentaMA']).toFixed(2) + ")</a></li>" +
                    //"<li><a class='dropdown-item' codigo = '" + respuesta['codigoBarras'] + "' precio_oferta=' " + respuesta['precioVentaMO'] + "' style='cursor:pointer; font-size:14px;'>Mayorista Otros (S./ " + parseFloat(respuesta['precioVentaMO']).toFixed(2) + ")</a></li>" +
                     "<li><a class='dropdown-item' codigo = '" +
                    respuesta["codigoBarras"] +
                    "' precio_mayor=' " +
                    respuesta["precioVentaMA"] +
                    "' style='cursor:pointer; font-size:14px;'>Mayoreo (S./ " +
                    parseFloat(respuesta["precioVentaMA"]).toFixed(2) +
                    ")</a></li>" +
                    "<li><a class='dropdown-item' codigo = '" +
                    respuesta["codigoBarras"] +
                    "' precio_oferta2=' " +
                    respuesta["oferta"] +
                    "' style='cursor:pointer; font-size:14px;'>Oferta (S./ " +
                    parseFloat(respuesta["oferta"]).toFixed(2) +
                    ")</a></li>" +
                    //"<li><a class='dropdown-item' codigo = '" + respuesta['codigoBarras'] + "' precio_oferta3=' " + respuesta['ofertaDNI'] + "' style='cursor:pointer; font-size:14px;'>Oferta DNI (S./ " + parseFloat(respuesta['ofertaDNI']).toFixed(2) + ")</a></li>" +
                    "</ul>" +
                    "</div>" +
                    "</center>",
                  idProducto: respuesta["idProducto"],
                  stock: respuesta["stock"],
                  precioVentaMA: respuesta["precioVentaMA"],
                  oferta: respuesta["oferta"],
                })
                .draw();
            
            itemProducto = itemProducto + 1;
            recalcularTotales();
            /*  table
                .rows()
                .eq(0)
                .each(function (index) {
                  var row = table.row(index);

                  var data = row.data();
                  TotalVenta =
                    parseFloat(TotalVenta) +
                    parseFloat(data["total"].replace(simbolom, ""));
                });

              $("#totalVenta").html("");
              $("#totalVenta").html(TotalVenta.toFixed(2));

              $("#iptCodigoVenta").val("");

              var totalVenta = $("#totalVenta").html();
              var igv = parseFloat(totalVenta) * impuesto;
              var subtotal = parseFloat(totalVenta) - parseFloat(igv);

              
              //var comision = parseFloat(totalVenta) * 0.05;
              //var totaltotal = parseFloat(totalVenta) + parseFloat(comision);

              $("#boleta_subtotal").html(parseFloat(subtotal).toFixed(2));
              $("#subtotal").val(parseFloat(subtotal).toFixed(2));
              $("#comision_bol").html(parseFloat(comision).toFixed(2));
              $("#boleta_igv").html(parseFloat(igv).toFixed(2));
              $("#boleta_total").html(parseFloat(totalVenta).toFixed(2));

              $("#totalVentaRegistrar").html(totalVenta);
             // $("#boleta_total").html(totalVenta);

             $("#boleta_total").html(totalVenta);*/
          } else {
            toast2.fire({
              icon: "error",
              title: "&nbsp;  El producto no existe o no tiene stock",
            });

            $("#iptCodigoVenta").val("");
            $("#iptCodigoVenta").focus();
          }
        },
      });
    }
  }
}


$(document).on("click", "#btnEntradaDinero", function () {
  $("#tipo").val("Ingreso");
  $(".modal-header").removeClass("bg-red");
  $(".modal-header").addClass("bg-success");

})


$(document).on("click", "#btnSalidadaDinero", function () {
  $("#tipo").val("Egreso");
  $(".modal-header").removeClass("bg-success");
  $(".modal-header").addClass("bg-red");

})


function realizarIngresoEgreso() {
  var estado_caja;

  $.ajax({
    async: false,
    url: rutaOculta + "ajax/caja.ajax.php",
    method: "POST",
    data: {
      ajaxVerificarCaja: "ajaxVerificarCaja",
      idUsuario: idUsuario,
    },
    dataType: "json",
    success: function (respuesta) {
      estado_caja = respuesta["count(*)"];

      if (respuesta["count(*)"] == 0) {
        estado_caja = 0;
      }
    },
  });
  if (estado_caja > 0) {
    var tipo = $("#tipo").val();
    var descripcion = $("#descripcion").val();
    var monto = $("#monto").val();


    var texto = "";
    var text2 = "";

    if (tipo == "Ingreso") {
      texto = '¿Está seguro de realizar un ingreso a caja?';
      text2 = 'Se realizo el ingreso correctamente.';
    } else {
      texto = '¿Está seguro de realizar un egreso a caja?';
      text2 = 'Se realizo el Egreso correctamente.';
    }



    Swal.fire({
      title: texto,
      text: "¡Si no lo está puede cancelar la acción!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si!'
    }).then((result) => {
      if (result.isConfirmed) {
        var datos = new FormData();
        datos.append("ajaxGuardarDetalle", 'ajaxGuardarDetalle');
        datos.append("idCaja", idCaja);
        datos.append("tipo", tipo);
        datos.append("descripcion", descripcion);
        datos.append("monto", monto);
        datos.append("idUsuario", idUsuario);
        $.ajax({
          url: rutaOculta + "ajax/caja.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            let timerInterval
            Swal.fire({
              title: '¡CORRECTO!',
              html: text2,
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
            $("#mdlGestionarCajaV").modal("hide");
          },
        });
      }
    })
  } else {
    toast2.fire({
      icon: "warning",
      title: "Debe aperturar la Caja, ingrese al menú Caja y realize la apertura",
    });
  }
}

$(document).on("click", ".btnGuardarCaja", function () {
  realizarIngresoEgreso();


})