<?php

session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', 'root');

if(isset($_POST['formconnexion']))
{
    $mailco = htmlspecialchars($_POST['mailco']);
    $mdpco = sha1($_POST['mdpco']);

    if(!empty($mailco) AND !empty($mdpco))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail= ? AND  mdp = ?");
        $requser->execute(array($mailco, $mdpco));
        $userexit = $requser->rowCount();
        if($userexit == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['mdp'] = $userinfo['mdp'];

            header("Location: profil.php?id=".$_SESSION['id']);

            $erreur = "Connecté !";
        }
        else
        {
            $erreur = "Erreur de saisie !";
        }
    }
    else
    {
        $erreur = "Tout les champs doivent être complétés !";
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
    <h2>Connexion :</h2>
    <br />
    <form method="POST" action="">

        <input type="email" name="mailco" placeholder="mail"/>
        <input type="password" name="mdpco" placeholder="Mot de passe"/>
        <input type="submit" name="formconnexion" value="Se connecter !"/>

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
