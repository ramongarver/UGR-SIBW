<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];
    $publicado = $_POST['publicado'];
    if ($publicado === 'on') { $publicado = 1; }
    else $publicado = 0;

    if ($application->actualizarEventoPublicado($idEvento, $publicado)) {
        header("Location: /listado-eventos");
    }
}

$application->cerrarConexion();
?>