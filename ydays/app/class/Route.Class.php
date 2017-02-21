<?php
/**
 *
 */
class Route
{
    protected $method       =   null;
    protected $requesturi   =   null;
    protected $page         =   null;
    public $argv = [];
    
    public function __construct()
    {
        
        $this->getMethod();
        $this->getRequestURI();
        $this->getPage();
    } // fin __construct


    /**
     * Permet définir la façon dont la page a été chargé, en Get ? ou en
     * POST ou autrement ?
     */
    public function getMethod()
    {
        if (is_null($this->method)) {
            // c'est que l'on dois la définir
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
        return $this->method;
    } // fin GetMethod


    /**
     * Permet de définir le chemin demandé
     */
    public function getRequestURI()
    {
        if (is_null($this->requesturi)) {
            // c'est que l'on dois la définir
            $this->requesturi = $_SERVER['REQUEST_URI'];
        }
        return $this->requesturi;
    } // fin GetRequestURI


    /**
     * Permet de définir la page a charger
     */
    public function getPage()
    {
        if (is_null($this->page)) {
            // c'est que l'on dois la définir

            if ($this->requesturi === "/") {
                // c'est que la page demandée est home
                $this->page = "home";
            } elseif ($this->requesturi === "/login") {
                $this->page = "login";
            } elseif ($this->requesturi === "/logout") {
                $this->page = "logout";
            } elseif ($this->requesturi === "/user") {
                $this->page = "user";
            } elseif ($this->requesturi === "/FichierPageQuiNexistePas") {
                $this->page = "FichierPageQuiNexistePas"; // uniquement dans le but de lancer une exception
            }
        }
        return $this->page;
    } // fin GetPage


    /**
     * Permet de charger la page
     */
    public function loadPage()
    {
        try {
            // on regarde si le fichier existe
            $file_path = dirname(__DIR__) .  DS . 'pages'  .  DS . $this->page . '.php';
            if (!file_exists($file_path)) {
                // le fichier n'existe pas on lance une exception
                throw new Exception($this->page . '.php does not exist'); // car je voulais tester les exceptions
            }
        } catch (Exception $e) {
            print($e);
            return false;
        }
        require($file_path);
        return true;
    } // fin loadPage


    /**
     * Dois-t-on rediriger l'utilisateur car il n'est pas sur le bon domaine
     */
   
}
