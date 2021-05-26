<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

$application = new AppDB();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST;

    if (!$application->existeUsuario($usuario['username']) or $_SESSION['username'] === $usuario['username']) {
        $usuario['previousUsername'] = $_SESSION['username'];
        if($application->actualizarUsuario($usuario)) {
            $_SESSION['username'] = $usuario['username'];  // Guardo en la sesión el username del usuario que se ha actualizado
            header("Location:/perfil");
        }
        else {
            header("Location:/perfil/editar");
        }
    }
    else {
        header("Location:/perfil/editar");
    }
}

echo $twig->render('perfil_editar.html', []);
?>