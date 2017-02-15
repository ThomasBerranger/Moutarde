<?php
try{
    $DB = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

}
catch(PDOException $e){
    echo 'Erreure';
    exit();
}

?>