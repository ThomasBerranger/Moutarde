<?php
try{
    $DB = new PDO('mysql:host=mysql.hostinger.fr;dbname=u793918682_ybdd', 'u793918682_ydays', 'frenchP@$$w0rd', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));

}
catch(PDOException $e){
    echo 'Erreure';
    exit();
}

?>