<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', 'root');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    if(isset($_POST['newmdp']) and !empty($_POST['newmdp'] and $_POST['newmdp2']) and !empty($_POST['newmdp2']))
    {
        $newmdp = sha1($_POST['newmdp']);
        $newmdp2 = sha1($_POST['newmdp2']);

            if($newmdp == $newmdp2)
            {
                $insertmdp = $bdd->prepare("UPDATE membres SET mdp = ? WHERE id = ?");
                $insertmdp->execute(array($newmdp, $_SESSION['id']));
                header("Location: profil.php?id=".$_SESSION['id'] );

                if (isset($_POST['newmail']) and !empty($_POST['newmail']))
                {
                    $mail = htmlspecialchars($_POST['mail']);
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL))
            {

                $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                $reqmail->execute(array($mail));
                $mailexist = $reqmail->rowCount();

                if($mailexist==0)
                {
                    $newmail = htmlspecialchars($_POST['newmail']);
                    $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
                    $insertmail->execute(array($newmail, $_SESSION['id']));
                    header("Location: profil.php?id=".$_SESSION['id']);
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


                if(isset($_POST['newprenom']) and !empty($_POST['newprenom']))
                {
                    $newprenom = htmlspecialchars($_POST['newprenom']);
                    $insertprenom = $bdd->prepare("UPDATE membres SET prenom = ? WHERE id = ?");
                    $insertprenom->execute(array($newprenom, $_SESSION['id']));
                    header("Location: profil.php?id=".$_SESSION['id'] );
                }

                if(isset($_POST['newnom']) and !empty($_POST['newnom']))
                {
                    $newnom = htmlspecialchars($_POST['newnom']);
                    $insertnom = $bdd->prepare("UPDATE membres SET nom = ? WHERE id = ?");
                    $insertnom->execute(array($newnom, $_SESSION['id']));
                    header("Location: profil.php?id=".$_SESSION['id'] );
                }
            }
            else
            {
                $erreur = "Vos mdp sont différents";
            }
    }
    else
    {
        $erreur = "Vous devez remplire les deux mdp";
    }

?>

<html>
<head>
    <title>Espace membre</title>
    <meta charset="utf-8">
</head>
<body>
<div align="center">
    <h1>Profil de <?php echo $userinfo['prenom'], " ", $userinfo['nom'];  ?> :</h1>
    <br>
    <br/>

    <form action="" method="POST">
        <label for="">Prenom</label>
        <input type="text" name="newprenom" placeholder="Prenom" value="<?php echo $userinfo['prenom']?>"><br><br>
        <label for="">Nom</label>
        <input type="text" name="newnom" placeholder="Nom" value="<?php echo $userinfo['nom']?>"><br><br>
        <label for="">Mail</label>
        <input type="text" name="newmail" placeholder="Mail" value="<?php echo $userinfo['mail']?>"><br><br>
        <label for="">Mot de passe</label>
        <input type="password" name="newmdp" placeholder="Mot de passe" ><br><br>
        <label for="">Confirmation du mot de passe</label>
        <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" ><br><br>
        <input type="submit" value="Mettre à jour mon profil">
    </form>

    <?php if(isset($erreur)){echo $erreur;} ?>

</div>

<?php if ($userinfo['prenom'] == 'admin' and $userinfo['nom'] == 'admin' and $userinfo['mail'] == 'admin@gmail.com') {?>
<h1>Vous êtes bien connecté en tant qu'administrateur.<h1>
<?php } else { ?>
<h1>Vous êtes connecté en tant qu'utilisateur.<h1>
<?php } ?>

</body>
</html>

<?php
}
else
{
header("Location: index.php");
}
?>
