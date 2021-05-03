<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  require_once "./scripts/db.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  function startsWith($string, $query) {
      return substr($string, 0, strlen($query)) === $query;
  }

  $uri = $_SERVER['REQUEST_URI'];

  if (startsWith($uri, "/evento")) {
    include("scripts/evento.php");
  }
  else {
    $application = new AppDB();
    $eventos = $application->obtenerEventos();

    echo $twig->render('portada.html', ['eventos' => $eventos]);

    $application->cerrarConexion();
  }
?>
