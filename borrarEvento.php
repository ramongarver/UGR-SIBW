<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];

    if ($application->eliminarEvento($idEvento)) {
        header("Location: /");
    }
}

$application->cerrarConexion();
?>