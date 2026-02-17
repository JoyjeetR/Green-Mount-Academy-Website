<?php
    $dns = "mysql: host=localhost;dbname=green_mount_academy";
    $username = "root";
    $password = "new_password";

    try{
        $pdo = new PDO ($dns, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "Connection Failed : ". $e->getMessage();
    }?>