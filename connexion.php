<?php

session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

if(isset($_POST['formconnexion']))
{
    $prenomco = htmlspecialchars($_POST['prenomco']);
    $prenomco = htmlspecialchars($_POST['nomco']);
    $mdpco = sha1($_POST['mdpco']);

    if(!empty($prenomco) AND !empty($prenomco) AND !empty($mdpco))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE prenom = ? AND nom= ? AND  mdp = ?");
        $requser->execute(array($prenomco, $prenomco, $mdpco));
        $userexit = $requser->rowCount();
        if($userexit == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['prenom'] = $userinfo['prenom'];
            $_SESSION['nom'] = $userinfo['nom'];
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

        <input type="text" name="prenomco" placeholder="Prenom"/>
        <input type="text" name="nomco" placeholder="Nom"/>
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