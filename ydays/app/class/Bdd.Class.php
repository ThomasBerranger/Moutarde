<?php
/**
 * Connexion à la base de donnée
 */
class Bdd
{
    public $state = false; // false si déco | true si connecté
    public $pdo = false; // objet pdo
    private $hostname;
    private $dbname;
    private $user;
    private $password;

    /**
    * On instancie la connexion
    */
    public function __construct()
    {
        $this->loadCredentials();
        try {
            $strConnection = 'mysql:host=' . $this->hostname . ';dbname=' . $this->dbname;
            $arrExtraParam= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
            $this->pdo = new PDO($strConnection, $this->user, $this->password, $arrExtraParam);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // pour avoir un peu plus de codes d'erreurs
        } catch (PDOException $e) {
            header('HTTP/1.0 503 Service Unavailable');
            print('erreur de connexion à la base de donnée');
            // $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
            exit;
        }
        $this->state = true;
    } // fin __construct


    /**
    * Permet d'effectuer une simple requete, retourne true si la requete s'est bien
    * passée mais ne retourne pas de donnée,
    *
    * @return   bool    :   selon le résultat de la requete
    *           false   :   si une erreur durant la requête
    *
    */
    public function query($query, $argv)
    {
        
        $stmt = $this->pdo->prepare($query);
        
        try {
            $result = $stmt->execute($argv);
        } catch (Exception $e) {
            //print($e);
            return false;
        }

        // DOIS-T-ON récupérer des résultats ?
        // la requete commence-t-elle par select ?
        
        if (substr($query, 0, 6) == "SELECT" || substr($query, 0, 6) == 'select') {
            try {
                $result = $stmt->fetchAll();
            } catch (Exception $e) {
                //print($e);
                return false;
            }
            return $result;
        } else {
            // on retourne le résultat de la requete
            return $result;
        }
    } // fin query


}
