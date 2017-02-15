<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', 'root');

if(isset($_POST['forminscription']))
{

    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {

        $prenomlenght = strlen($prenom);
        if($prenomlenght <= 255)
        {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {

                $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                $reqmail->execute(array($mail));
                $mailexist = $reqmail->rowCount();

                if($mailexist==0)
                {
                    if($mdp == $mdp2)
                    {
                        $insertmembre = $bdd->prepare("INSERT INTO membres (prenom, nom, mdp, mail) VALUES (?, ?, ?, ?)");
                        $insertmembre->execute(array($prenom, $nom, $mdp, $mail));
                        $erreur = "Votre compte a bien été crée !";
                    }
                    else
                    {
                        $erreur ="Vos mots de passe sont différents !";
                    }
                }
                else
                {
                    $erreur ="Cette adresse mail est déjà enregistrée !";
                }
            }
            else
            {
                $erreur = "Votre adresse mail n'est pas valide";
            }
        }
        else
        {
            $erreur = "Votre prenom est trop long !";
        }
    }
    else
    {
        $erreur = "Vous devez tout remplir !";
    }
}

?>
<html>
    <head>
        <title>Espace membre</title>
        <meta charset="utf-8">
    </head>
    <body>
        <div align="center">
            <h1>Espace membre :</h1>
            <br>
            <h2>Inscritpion :</h2>
            <br />
            <form method="POST" action="">

                <table>
                    <tr>
                        <td align="right">
                            <label for="prenom">Prénom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){echo $prenom;} ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="nom">Nom :</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){echo $nom;} ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mail">Mail :</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre mail" name="mail" value="<?php if(isset($mail)){echo $mail;} ?>" />
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mdp">Mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" name="mdp" />
                        </td>
                    </tr>

                    <tr>
                        <td align="right">
                            <label for="mdp2">Confirmation de votre mot de passe :</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Confirmer votre mdp" name="mdp2" />
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <br>
                            <input type="submit" value="Je m'inscris" name="forminscription">
                            <a href="connexion.php">Connexion</a>
                        </td>
                    </tr>

                </table>

                <br>
                <?php

                if(isset($erreur))
                {
                    echo $erreur;
                }

                ?>

            </form>
        </div>
    </body>
</html>
