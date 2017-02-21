<?php
// Comme vous(le prof) travaillez sous mac, le chemin est différent (/app/class/ vs \app\class\)
// Afin d'éviter de produire 2 codes différents on définis une constante :
define('DS', DIRECTORY_SEPARATOR);


// on lance la session
session_start();


function my_autoloader($class)
{
    include dirname(__DIR__) .  DS . 'app' . DS . 'class' . DS . $class . '.Class.php';
}
spl_autoload_register('my_autoloader'); // On évite ainsi les includes/requires
// (et aussi car je voulais m'en servir pour apprendre ;) )


// On lance la connexion à la base de donnée !
$bdd = new Bdd();


// on regarde si notre session est valide
$session = new Session();


// on instancie un utilisateur
$user = new User();


// On regarde ensuite la page demandée
// si c'est la page 
// - /          =>  c'est le formulaire que l'on affiche
// - /login     =>  c'est le formulaire d'inscription/connexion qui traite ça
// - /logout    =>  c'est un script de déconnexion qui dois s'en charger
$route = new Route();
// et on applique la route (aka on charge la page correspondante)
$route->loadPage();
