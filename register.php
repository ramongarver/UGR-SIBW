<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

require_once './scripts/db.php';

$application = new AppDB();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST;

    if (!$application->existeUsuario($usuario['username'])) {
        if($application->registrarUsuario($usuario)) {
            $_SESSION['username'] = $usuario['username'];  // Guardo en la sesión el username del usuario que se ha registrado
            header("Location:/");
        }
        else {
            header("Location:/register");
        }
    }
}

echo $twig->render('register.html', []);
?>