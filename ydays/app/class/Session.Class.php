<?php
/**
 *
 */
class Session
{
    protected $id;
    protected $creation_date; // date au format timestamp


    public function __construct()
    {
        // on regarde tout d'abord si la session valide
        if (!$this->isValid()) {
            $this->regenerate();
        }
    }

    /**
    * Permet de vérifier si la session est valide (date d'expiration principalement)
    */
    public function isValid()
    {
        if (!isset($_SESSION['creation_date'])) {
            // pas de date de création en session
            return false;
        }
        $this->creation_date = $_SESSION['creation_date'];
        $expire_date = time() + (3600*24*7); // on ajoute 7 jours

        if ($this->creation_date > $expire_date) {
            // c'est que la session a expirée, on regénère, et on supprime de
            // la base de donnée si liée à un utilisateur
            global $user;
            if ($user->isConnected()) {
                $query = "DELETE FROM sessions WHERE PHPSESSID = :phpsessid";
                global $bdd;
                $bdd->query($query, ['phpsessid' => session_id()]);
            }
            return false;
        } else {
            return true;
        }
    } // fin IsValid


    /**
    * Permet de regénérer une session
    */
    private function regenerate()
    {
        session_regenerate_id(true); // true, pour supprimer les infos de sessions
        $_SESSION['creation_date'] = time();
        return true;
    }
}
