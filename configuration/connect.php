<?php 

    try
    {
        $connect = new PDO("mysql:host:=localhost; dbname=myproject; charset=utf8", "root", "");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        echo 'ERROR: ' . $e->getMessage();
    }

?>