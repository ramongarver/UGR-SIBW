<?php
  include("bd.php");

  $resto = substr($uri, 8);

  var_dump($resto);

  $idEvento = intval($resto);

  var_dump($idEvento);

  $resto = substr($resto, strlen((string)$idEvento));

  var_dump($resto);

  //$evento = getEvento($idEvento);

  if ($resto === "/imprimir" || $resto === "/imprimir/") {
    echo $twig->render('evento-imprimir.html', ['id' => $idEvento]);
  }
  else {
    echo $twig->render('evento.html', ['id' => $idEvento]);
  }
?>
