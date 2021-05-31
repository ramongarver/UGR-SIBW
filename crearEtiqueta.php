<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

session_start();

$application = new AppDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];
    $etiqueta = $_POST['etiqueta'];

    $idEtiqueta = $application->conexion->query("SELECT max(id_etiqueta) FROM etiquetas");
    $idEtiqueta = $idEtiqueta->fetch_all(MYSQLI_ASSOC)[0]['max(id_etiqueta)'];
    if ($idEtiqueta == null) { $idEtiqueta = 1; }
    else { $idEtiqueta = intval($idEtiqueta) + 1; }

    if($application->crearEtiqueta($idEvento, $idEtiqueta, $etiqueta)) {
        header("Location: /evento/$idEvento");
    }
}

$application->cerrarConexion();
?>