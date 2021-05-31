<?php
require_once "/usr/local/lib/php/vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEvento = $_POST['idEvento'];

    header("location: /evento/$idEvento/editar");
}
?>