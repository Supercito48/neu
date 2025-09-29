# Creación rápida de módulos

Este proyecto incluye muchos módulos (controladores, modelos, vistas, archivos AJAX y scripts de JavaScript). Para facilitar la creación de nuevas características se añadió un pequeño generador de scaffolding accesible desde la línea de comandos.

## Requisitos previos

* Tener PHP instalado y disponible en la línea de comandos.
* Ejecutar los comandos desde la raíz del proyecto (`/workspace/neu`).

## Uso

```bash
php scripts/create_module.php NombreModulo "Título legible"
```

Donde:

* `NombreModulo` es un identificador sin espacios (el script normaliza mayúsculas, guiones o espacios y los convierte en `snake_case`).
* `"Título legible"` es opcional y se muestra en la vista generada.

Ejemplo:

```bash
php scripts/create_module.php Reportes "Panel de reportes"
```

El comando anterior crea automáticamente los siguientes archivos si no existen:

* `controllers/reportes.controller.php`
* `models/reportes.model.php`
* `ajax/reportes.ajax.php`
* `views/modules/reportes.php`
* `views/js/reportes.js`

Cada archivo contiene una plantilla mínima para comenzar a trabajar.

## Qué hacer después

1. Completar la lógica del modelo y del controlador según la funcionalidad requerida.
2. Ajustar la vista (`views/modules/<modulo>.php`) y el JavaScript (`views/js/<modulo>.js`).
3. Registrar nuevas rutas o entradas de menú en caso de ser necesario.
