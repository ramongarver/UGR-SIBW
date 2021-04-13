<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);

  function startsWith($string, $query) {
      return substr($string, 0, strlen($query)) === $query;
  }

  $uri = $_SERVER['REQUEST_URI'];

  var_dump($uri);

  if (startsWith($uri, "/evento")) {
    include("scripts/evento.php");
  }
  else {
    echo $twig->render('portada.html', []);
  }
?>
