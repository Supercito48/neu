var tablaActas;

$(document).ready(function () {
  tablaActas = $(".tablaActas").DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sSearch: "Buscar:",
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
      url: "ajax/tablas/tablaActas.ajax.php",
      dataSrc: "",
    },
    columns: [
      { data: "provincia" },
      { data: "distrito" },
      { data: "mesa" },
      { data: "total_habiles" },
      { data: "blanco" },
      { data: "nulo" },
      { data: "impugnado" },
      { data: "emitidos" },
      { data: "foto", orderable: false, searchable: false },
    ],
    bDestroy: true,
    iDisplayLength: 10,
  });

  $("#provinciaActa, #distritoActa").select2({
    theme: "bootstrap4",
    dropdownParent: $("#modalActa"),
  });

  cargarProvincias();

  $("#provinciaActa").on("change", function () {
    const idProvincia = $(this).val();
    limpiarDistrito();

    if (idProvincia) {
      cargarDistritos(idProvincia);
    } else {
      mostrarMensajeCandidatos(
        "Seleccione una provincia y distrito para cargar los candidatos."
      );
    }
  });

  $("#distritoActa").on("change", function () {
    const ubigeo = $(this).val();
    $("#ubigeoActa").val(ubigeo || "");

    if (ubigeo) {
      cargarCandidatos(ubigeo);
    } else {
      mostrarMensajeCandidatos(
        "Seleccione una provincia y distrito para cargar los candidatos."
      );
    }
  });

  $("#modalActa").on("show.bs.modal", function () {
    resetFormularioActa();
  });

  $("#formActa").on("submit", function (event) {
    event.preventDefault();
    guardarActa();
  });
});

function cargarProvincias() {
  $.ajax({
    url: "ajax/actas.ajax.php",
    method: "GET",
    data: { accion: "listarProvincias" },
    dataType: "json",
    success: function (respuesta) {
      const $provincia = $("#provinciaActa");
      $provincia.empty().append('<option value="">Seleccione</option>');

      if (Array.isArray(respuesta)) {
        respuesta.forEach(function (provincia) {
          $provincia.append(
            '<option value="' +
              provincia.id_provincia +
              '">' +
              provincia.provincia +
              "</option>"
          );
        });
      }

      $provincia.val(null).trigger("change.select2");
    },
  });
}

function cargarDistritos(idProvincia) {
  $.ajax({
    url: "ajax/actas.ajax.php",
    method: "POST",
    data: {
      accion: "listarDistritos",
      idProvincia: idProvincia,
    },
    dataType: "json",
    success: function (respuesta) {
      const $distrito = $("#distritoActa");
      $distrito.prop("disabled", false);
      $distrito.empty().append('<option value="">Seleccione</option>');

      if (Array.isArray(respuesta) && respuesta.length) {
        respuesta.forEach(function (distrito) {
          $distrito.append(
            '<option value="' +
              distrito.ubigeo_reniec +
              '">' +
              distrito.nom_distrito +
              "</option>"
          );
        });
      }

      $distrito.val(null).trigger("change.select2");
    },
  });
}

function cargarCandidatos(ubigeo) {
  $.ajax({
    url: "ajax/actas.ajax.php",
    method: "POST",
    data: {
      accion: "listarCandidatos",
      ubigeo: ubigeo,
    },
    dataType: "json",
    success: function (respuesta) {
      const $tbody = $("#tablaCandidatosActa tbody");
      $tbody.empty();

      if (!Array.isArray(respuesta) || !respuesta.length) {
        mostrarMensajeCandidatos(
          "No se encontraron candidatos para el distrito seleccionado."
        );
        return;
      }

      respuesta.forEach(function (candidato) {
        const $fila = $("<tr>");
        $("<td>").text(candidato.agrupacion_politica).appendTo($fila);
        $("<td>").text(candidato.nombre_candidato).appendTo($fila);

        const $input = $("<input>", {
          type: "number",
          class: "form-control votosCandidato",
          min: 0,
          value: 0,
          required: true,
        }).attr("data-codigo", candidato.codigo_agrupacion);

        $("<td>", { class: "text-center" }).append($input).appendTo($fila);
        $tbody.append($fila);
      });
    },
  });
}

function mostrarMensajeCandidatos(mensaje) {
  const $tbody = $("#tablaCandidatosActa tbody");
  $tbody.empty().append(
    '<tr><td colspan="3" class="text-center text-muted">' +
      mensaje +
      "</td></tr>"
  );
}

function limpiarDistrito() {
  const $distrito = $("#distritoActa");
  $distrito.val(null).trigger("change.select2");
  $distrito.prop("disabled", true);
  $("#ubigeoActa").val("");
}

function resetFormularioActa() {
  const $form = $("#formActa");
  $form[0].reset();
  $("#provinciaActa").val(null).trigger("change.select2");
  limpiarDistrito();
  mostrarMensajeCandidatos(
    "Seleccione una provincia y distrito para cargar los candidatos."
  );
}

function guardarActa() {
  const ubigeo = $("#ubigeoActa").val();

  if (!ubigeo) {
    Swal.fire("¡ATENCIÓN!", "Debe seleccionar una provincia y distrito.", "warning");
    return;
  }

  const candidatos = [];
  let hayError = false;

  $("#tablaCandidatosActa tbody tr").each(function () {
    const $input = $(this).find(".votosCandidato");

    if (!$input.length) {
      return;
    }

    const codigo = $input.data("codigo");
    const votos = parseInt($input.val(), 10);

    if (isNaN(votos) || votos < 0) {
      hayError = true;
      $input.addClass("is-invalid");
    } else {
      $input.removeClass("is-invalid");
    }

    candidatos.push({
      codigo_agrupacion: codigo,
      votos: isNaN(votos) ? 0 : votos,
    });
  });

  if (hayError) {
    Swal.fire(
      "¡ATENCIÓN!",
      "Todos los votos de los candidatos deben ser números mayores o iguales a 0.",
      "warning"
    );
    return;
  }

  if (!candidatos.length || !$("#tablaCandidatosActa tbody tr").find(".votosCandidato").length) {
    Swal.fire(
      "¡ATENCIÓN!",
      "No se encontraron candidatos para registrar votos.",
      "warning"
    );
    return;
  }

  const archivo = $("#fotoActa")[0].files[0];

  if (!archivo) {
    Swal.fire("¡ATENCIÓN!", "Debe adjuntar la fotografía del acta.", "warning");
    return;
  }

  if (archivo.size > 5 * 1024 * 1024) {
    Swal.fire(
      "¡ATENCIÓN!",
      "La fotografía supera el tamaño máximo permitido (5 MB).",
      "warning"
    );
    return;
  }

  const formData = new FormData();
  formData.append("accion", "guardarActa");
  formData.append("ubigeo", ubigeo);
  formData.append("mesa_sufragio", $("#mesaSufragio").val());
  formData.append("total_reniec_habiles", $("#totalHabiles").val());
  formData.append("vt_blanco_dist", $("#votosBlanco").val());
  formData.append("vt_nulo_dist", $("#votosNulo").val());
  formData.append("vt_impugnado_dist", $("#votosImpugnado").val());
  formData.append("total_vt_emitidos_dist", $("#totalEmitidos").val());
  formData.append("candidatos", JSON.stringify(candidatos));
  formData.append("fotoActa", archivo);

  const $boton = $("#formActa button[type='submit']");
  $boton.prop("disabled", true);

  $.ajax({
    url: "ajax/actas.ajax.php",
    method: "POST",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        Swal.fire("¡Correcto!", respuesta.mensaje, "success");
        $("#modalActa").modal("hide");
        tablaActas.ajax.reload(null, false);
      } else {
        Swal.fire("¡Error!", respuesta.mensaje || "No se pudo registrar el acta.", "error");
      }
    },
    error: function () {
      Swal.fire("¡Error!", "No se pudo registrar el acta.", "error");
    },
    complete: function () {
      $boton.prop("disabled", false);
    },
  });
}
