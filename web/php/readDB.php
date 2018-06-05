<?php


/**
 * Created by PhpStorm.
 * User: marek
 * Date: 19.05.2018
 * Time: 10:48
 */

function myOpenDB()
{
//define db settings
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'coderslab');
    define('DB_DB', 'Efemerydy');

    try {
        // DB connection
        $conn = new PDO('mysql:dbname=' . DB_DB . ';host=' . DB_HOST, DB_USER, DB_PASSWORD,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
    } catch (PDOException $e) {
        // Catch error
        echo 'Connection failed: ' . $e->getMessage();
        return false;
    }
    return $conn;
}