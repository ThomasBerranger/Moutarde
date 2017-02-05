<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

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
        <label for="">Prenom : </label>
        <h2 align="center"><?php echo $userinfo['prenom'] ?></h2>
        <br/>
        <label for="">Nom : </label>
        <h2 align="center"><?php echo $userinfo['nom'] ?></h2>
        <br/>
        <label for="">Mail : </label>
        <h2 align="center"><?php echo $userinfo['mail'] ?></h2>


        <?php
        if($userinfo['id'] == $_SESSION['id'])
        {
        ?>
        <a href="edit_profil.php">Editer son profil</a><a> | </a>
        <a href="calendrier.php">Calendrier</a><a> | </a>
        <a href="deconnexion.php">Se déconnecter</a>
        <?php
        }
        ?>

    </div>
    </body>
    </html>

    <?php
}
?>
