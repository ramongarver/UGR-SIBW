<?php
require_once '../scripts/db.php';

$application = new AppDB();

header('Content-Type: application/json');

$datos = $_POST['datos'];

$datos = json_decode($datos, true);

$busqueda = $datos['busqueda'];
$rol = $datos['rol'];

if ($rol != '' and $rol != 'Registrado' and $rol != 'Moderador') {
    $eventos = $application->obtenerEventosBusquedaParcial($busqueda);
}
else {
    $eventos = $application->obtenerEventosBusquedaParcialPublicados($busqueda);
}

echo(json_encode($eventos));

$application->cerrarConexion();
?>