<div class="content-wrapper" style="min-height: 1604.44px;">

    <section class="content-header">

    </section>

    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>
        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Pagina no encontrada.</h3>
          <p>
            No pudimos encontrar la página que estabas buscando.
            Mientras tanto, puede <a href="inicio">volver al panel de control</a> o intentar usar el formulario de búsqueda.
          </p>

        </div>

      </div>

    </section>

  </div>
  <script>
    Swal.fire({
      title: "¡NO TIENE PERMISOS!",
      text: "¡Comunicarse con su administrador!",
      icon: "warning",
      showConfirmButton: true,
      confirmButtonText: "ACEPTAR"

    }).then(function(result) {

      if (result.value) {

        window.location = "inicio";

      }

    });
  </script>