<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$dsn = 'mysql:dbname=ydays_membre;host:127.0.0.1';
$user = 'root';
$password = 'root';
try {
    $dbh = new PDO($dsn, $user, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>