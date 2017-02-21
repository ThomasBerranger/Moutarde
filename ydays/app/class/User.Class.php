<?php
/**
 *
 */
class User
{
    private $id;
    private $email;
    private $password;
    public $connected;

    public function __construct()
    {
        if ($this->isConnected()) {
            $this->getEmail();
            $this->getInfos();
            $this->getPassword();
        } else {
            // print('pas connecté');
        }
    }
    /**
    * Permet de crééer un nouvel utilisateur
    */
    public function new($email, $password)
    {
        // on Regarde que nos inputs ne sont pas vides
        if (empty($email) or empty($password)) {
            // au moins l'un des 2 est vide
            return false;
        }

        // on vérifie l'email
        // (on va quand meme pas insérer un email invalide !)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // ben c'est pas un email valide !
            // on n'insère pas
            return false;
        }
        $query = "INSERT INTO users (email, password)
        VALUES (:email, :password)";

        $argv = [
            ":email" => $email,
            ":password" => password_hash($password, PASSWORD_BCRYPT)
        ];
        global $bdd;

        $result = $bdd->query($query, $argv);
        return $result; // true|false
    } // fin new


    /**
    * Permet d'afficher les infos perso de l'utilisateur (email + nom)
    */
    public function getInfos()
    {
        return ['email' => $this->email, 'id' => $this->id];
    } // fin GetInfos


   
    /**
    * Permet de déterminer si un utilisateur est connecté... ou non
    */
    public function isConnected()
    {
        if (isset($_SESSION['connected'])) {
            if ($_SESSION['connected']) {
                $this->connected = true;
            } else {
                $this->connected = false;
            }
        } else {
            // on définis la clée 'connected'
            $_SESSION['connected'] = false;
            $this->connected = false;
        }

        return $this->connected;
    } // fin IsConnected


    /**
    * Permet de définir l'utilisateur courrant conne étant connecté
    */
    private function setConnected()
    {
        // on inscrit en base de donnée notre sessionid
        global $bdd;

        $query = "INSERT INTO sessions (user_id, PHPSESSID) VALUES (:user_id, :phpsessid)";
        $result = $bdd->query($query, [":user_id" => $this->id, ":phpsessid" => session_id()]);

        // on met à jours notre session
        if ($result) {
            $_SESSION['connected'] = true;
        } else {
            $_SESSION['connected'] = false;
        }
        // on met à jours notre objet user
        $this->isConnected();

        return $result;
    } // fin setConnected


    /**
    * Permet valider les info de l'utilisateur et de le connecter par la suite
    * si les infos sont correctes
    */
    public function login($email, $password)
    {
        global $bdd;

        $query = "SELECT * FROM users WHERE email = :email";
        $result = $bdd->query($query, [":email" => $email]);

        if (!empty($result)) {
            $result = $result[0];
            // on regarde si le mot de passe est valide
            $this->password = $result['password'];
            if (password_verify($password, $this->password)) {
                // alors on set l'id et on connecte l'utilisateur
                $this->id = $result['id'];
                $this->email = $result['email'];
                $this->setConnected();
                return true;
            } else {
                // mauvais mdp
                return false;
            }
        } else {
            // pas de résultat en base pour cet email
            throw new Exception("L'utilisateur n'existe pas", 1);
            return false;
        }
    } // fin login


    /**
     * Permet de déconnecter un utilisateur
     */
    public function logout()
    {
        global $bdd;

        $query = "DELETE FROM sessions WHERE PHPSESSID = :phpsessid";
        $result = $bdd->query($query, [":phpsessid" => session_id()]);

        // on met à jours notre session
        if ($result) {
            $_SESSION['connected'] = false;
            return true;
        }
    }


    /**
     * Permet d'obtenir l'id de l'utilisateur
     *
     *  @return     str     :   id de l'utilisateur
     */
    public function getId()
    {
        global $bdd;

        $query = "SELECT user_id FROM sessions WHERE PHPSESSID = :phpsessid";

        $result = $bdd->query($query, [":phpsessid" => session_id()]);

        $this->id = $result[0]['user_id'];

        return $this->id;
    } // fin getId


    /**
     * Permet de récupérer l'email de l'utilsateur
     *
     * @return $email   :   email de l'utilisteur
     */
    public function getEmail()
    {
        // on regarde si nous avons récupérés l'id de notre utilisateur
        if (empty($this->id)) {
            $this->getId();
        }

        // on regarde si on a pas déjà récupérer l'email
        if (is_null($this->email)) {
            global $bdd;
            $query = "SELECT email FROM users WHERE id = :id";

            $result = $bdd->query($query, [":id" => $this->id]);
            
            $this->email = $result[0]['email'];
        }

        // on retourne l'email
        return $this->email;
    } // fin getEmail


   


    /**
     * Permet de modifier l'email de l'utilisateur courrant
     *
     * @return  bool    :   Vrai si modifié, faux si pas modifié
     *
     */
    public function editEmail($email, $password)
    {
        if (password_verify($password, $this->password)) {
            // c'est que c'est le bon mot de passe
            return $this->setEmail($email);
        } else {
            // mauvais mot de passe
            return false;
        }
    } // fin editEmail


    /**
     * Permet de modifier l'email de l'utilisateur courrant
     *
     * @return  bool    :   Vrai si modifié, faux si pas modifié
     *
     */
    private function setEmail($email)
    {
        // on regarde que l'email entré est bien un email :
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // ben c'est pas un email valide !
            // on n'insère pas
            return false;
        }


        // on regarde que le nouveau email n'est as déjà en base de donnée
        // comme en base de donnée la colonne email est set sur unique,
        // si on fais directement un update dessus et qu'il y a un conflic l'email
        // ne sera pas mis à jours
        $query = "UPDATE users SET email = :email WHERE id = :user_id";
        $argv = [
            ":email"    =>  $email,
            ":user_id"  =>  $this->id
            ];
        global $bdd;
        if ($bdd->query($query, $argv)) {
            // on met à jours l'email
            $this->email = $email;
            return true;
        }
        return false;
    } // fin setEmail


    /**
     * Permet d'obtenir le mot de passe
     *
     * @return  str     :   le mot de passe
     *          false   :   si pas de mdp pour l'email
     *
     */
    private function getPassword()
    {
        if (!is_null($this->password)) {
            return $this->password;
        }

        $query = "SELECT password FROM users WHERE email = :email";
        $argv = [
            ":email" => $this->email
        ];

        global $bdd;
        $result = $bdd->query($query, $argv);
        
        if ($result) {
            $this->password = $result[0]['password'];
            return $this->password;
        }
        return false;
    } // fin getPassword


    /**
     * Permet de d'obtenir le mot de passe
     *
     *  @param  $sure   :   vraiement
     *
     *  @return true    :   ben toute les images ont été supprimées
     *          false   :   on a éviter le pire
     *
     */
    
}
