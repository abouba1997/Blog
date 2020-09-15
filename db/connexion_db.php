<?php 
    $dsn = "mysql:host=localhost;dbname=Blog";
    $username = "root";
    $passwd = "";

    try {
        $db = new PDO($dsn, $username, $passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,));
    } catch(PDOException $e) {
        die("Error : somes error reached -> ".$e->getMessage());
    }
?>