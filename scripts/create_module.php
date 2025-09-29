<?php
/**
 * CLI script to scaffold a new module for the application.
 *
 * Usage:
 *   php scripts/create_module.php NombreModulo "Título legible"
 */

declare(strict_types=1);

$usage = "Usage: php scripts/create_module.php <ModuleName> [Readable Title]\n";

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "This script must be executed from the command line.\n");
    exit(1);
}

if ($argc < 2) {
    fwrite(STDERR, $usage);
    exit(1);
}

$rawName = $argv[1];

$normalized = preg_replace('/[^a-zA-Z0-9]+/', '_', $rawName);
$normalized = trim($normalized ?? '', '_');

if ($normalized === '') {
    fwrite(STDERR, "The provided module name does not contain valid characters.\n");
    exit(1);
}

$slug = strtolower($normalized);
$title = $argv[2] ?? ucwords(str_replace('_', ' ', $slug));
$camel = str_replace(' ', '', ucwords(str_replace('_', ' ', $slug)));

$root = realpath(__DIR__ . '/..');

if ($root === false) {
    fwrite(STDERR, "Unable to resolve project root directory.\n");
    exit(1);
}

$placeholders = [
    '{{CONTROLLER_CLASS}}' => 'Controller' . $camel,
    '{{MODEL_CLASS}}' => 'Model' . $camel,
    '{{AJAX_CLASS}}' => 'Ajax' . $camel,
    '{{TITLE}}' => $title,
    '{{SLUG}}' => $slug,
    '{{NORMALIZED}}' => $normalized,
    '{{CAMEL}}' => $camel,
];

$templates = [
    "controllers/{$slug}.controller.php" => <<<'PHP_CONTROLLER'
<?php

class {{CONTROLLER_CLASS}}
{
    /**
     * Punto de entrada para listar información del módulo {{TITLE}}.
     */
    public static function ctrMostrar{{CAMEL}}()
    {
        return {{MODEL_CLASS}}::mdlMostrar{{CAMEL}}();
    }
}
PHP_CONTROLLER,
    "models/{$slug}.model.php" => <<<'PHP_MODEL'
<?php

require_once "conexion.php";

class {{MODEL_CLASS}}
{
    public static function mdlMostrar{{CAMEL}}()
    {
        $stmt = Conexion::conectar()->prepare("SELECT 1");
        $stmt->execute();
        return $stmt->fetch();
    }
}
PHP_MODEL,
    "ajax/{$slug}.ajax.php" => <<<'PHP_AJAX'
<?php

require_once "../controllers/{{SLUG}}.controller.php";
require_once "../models/{{SLUG}}.model.php";

class {{AJAX_CLASS}}
{
    public function ajaxMostrar{{CAMEL}}()
    {
        $respuesta = {{CONTROLLER_CLASS}}::ctrMostrar{{CAMEL}}();
        echo json_encode($respuesta);
    }
}

if (isset($_POST["mostrar{{NORMALIZED}}"])) {
    $ajax = new {{AJAX_CLASS}}();
    $ajax->ajaxMostrar{{CAMEL}}();
}
PHP_AJAX,
    "views/modules/{$slug}.php" => <<<'PHP_VIEW'
<div class="content-wrapper">
    <section class="content-header">
        <h1>{{TITLE}}</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <!-- Contenido del módulo {{TITLE}} -->
            </div>
        </div>
    </section>
</div>
PHP_VIEW,
    "views/js/{$slug}.js" => <<<'JS'
$(function () {
    console.log('Módulo {{TITLE}} listo');
});
JS,
];

$report = [];

foreach ($templates as $relative => $template) {
    $target = $root . DIRECTORY_SEPARATOR . $relative;

    if (file_exists($target)) {
        $report[] = [
            'path' => $relative,
            'status' => 'exists',
        ];
        continue;
    }

    $directory = dirname($target);

    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        fwrite(STDERR, "Cannot create directory: {$directory}\n");
        exit(1);
    }

    $content = strtr($template, $placeholders);

    file_put_contents($target, $content);

    $report[] = [
        'path' => $relative,
        'status' => 'created',
    ];
}

foreach ($report as $entry) {
    fwrite(STDOUT, sprintf("[%s] %s\n", strtoupper($entry['status']), $entry['path']));
}
