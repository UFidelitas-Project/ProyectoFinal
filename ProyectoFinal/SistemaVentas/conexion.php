<?php

    $elServidor = "localhost";
    $elUsuario ="root";
    $elPassword = "";
    $laBD = "factura";
    $laconexion = new mysqli($elServidor, $elUsuario, $elPassword, $laBD);
    
    if ($laconexion->connect_error) {
      die("Error al Conectar con la BD: " . $laconexion->connect_error);
    } 		

?>