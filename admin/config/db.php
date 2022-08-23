<?php
$username = "root";
$password = "";

function conectarDB():mysqli{
    $db = mysqli_connect('localhost','root','','ventas_de_vehiculos');
    if (!$db) {
        echo "No se pudo conecta ala base de datos.";
        exit;
    }
    return $db;
}

?>