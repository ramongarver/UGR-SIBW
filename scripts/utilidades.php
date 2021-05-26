<?php

/**
 * Convierte un identificador entero al string rol correspondiente
 * @param $id_rol
 * @return string
 */
function id_roltoRol ($id_rol) {
    $rol = "Anónimo";

    switch ($id_rol) {
        case 1: $rol = "Registrado"; break;
        case 2: $rol = "Moderador"; break;
        case 3: $rol = "Gestor"; break;
        case 4: $rol = "Moderador y Gestor"; break;
        case 5: $rol = "Superusuario"; break;
    }

    return $rol;
}

/**
 * Convierte un carácter al string género correspondiente
 * @param $charGenero
 * @return string
 */
function charGenerotoStringGenero($charGenero) {
    $stringGenero = "Otro";

    switch ($charGenero) {
        case "H": $stringGenero = "Hombre"; break;
        case "M": $stringGenero = "Mujer"; break;
        case "O": $stringGenero = "Otro"; break;
    }

    return $stringGenero;
}

?>