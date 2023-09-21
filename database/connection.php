<?php

    // Especifico el nombre de host del servidor de la base de datos, que está configurado como "localhost".
    $servername = "localhost";
    // Especifico el nombre de usuario para el servidor de la base de datos. En este caso, está configurado como "root"
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=rems", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e) {
        $error_message = $e->getMessage();
    }