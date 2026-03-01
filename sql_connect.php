<?php
/**
 * Database connection for Green Mount Academy site.
 * Creates a PDO instance $pdo used by contact.php (enquiry form) and any future backend (e.g. student auth).
 * Timezone set to Asia/Kolkata for consistent timestamps.
 */
    $dns = "mysql: host=localhost;dbname=green_mount_academy";
    $username = "root";
    $password = "new_password";

    try{
        date_default_timezone_set("Asia/Kolkata");
        
        $pdo = new PDO ($dns, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->exec("SET time_zone = '+05:30'");

    }
    catch(PDOException $e){
        echo "Connection Failed : ". $e->getMessage();
    }?>
