<?php

session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

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

            header("Location: index.php?id=".$_SESSION['id']);

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



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Connexion</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

        <!-- Theme CSS -->
        <link href="css/agency.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>
    <body id="page-top" class="index w3-animate-opacity">

        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-custom">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>  <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand page-scroll" href="index.html#page-top">French Motor Trip</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="index.php#page-top">Accueil</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="index.php#circuits">Circuit</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="index.php#about">FAQ</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="index.php#contact">Contact</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background-color:none">Mon Compte<span class="caret"></span></a>
                            <ul class="dropdown-menu pull-left">
                              <?php if(isset($_GET['id']) AND $_GET['id'] > 0) {

                                $getid = intval($_GET['id']);
                                $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
                                $requser->execute(array($getid));
                                $userinfo = $requser->fetch();

                                ?>
                                <li><a href="edit_profil.php?id=<?php echo $_SESSION['id'] ?>">Aperçu de mon compte</a></li>
                                <li><a href="#">Mes commandes</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="deconnexion.php">Deconnexion</a></li>
                                <?php } else { ?>
                                <li><a href="connexion.php">Connexion</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="inscription.php">Inscription</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <div class="row">
            <div class="connexion col-xs-10 col-xs-offset-1">
                <h3>Mes commandes</h3>
            </div>
        </div>

        <?php
        $mail = $bdd->prepare("SELECT mail FROM membres WHERE id = ?");
        $mail->execute(array($_SESSION['id']));
        $mail = $mail->fetch();

        $reservation_bretagne_nord = $bdd->query("SELECT * FROM bretagne_nord_reservation");
        ?>

        <div class="row">
            <div class="formulaire col-xs-10 col-xs-offset-1">


            <?php
            $nouvelle_res = -1;
            while ($donnees = $reservation_bretagne_nord->fetch()) {
              if ($donnees['mail'] == $mail['mail'] and $nouvelle_res != $donnees['num_res']):
              $nouvelle_res = $donnees['num_res'];
              ?>

                  <br>
                  <ul>
                    <li>
                    <div style="height:50px;"><?php echo "Reservation du parcours 'Bretagne du nord' le ";
                    $date = strtotime("+0 day", strtotime($donnees['date']));
                    echo date("d-m-Y", $date), " au nom de ",
                    $donnees['nom'],", groupe de ",
                    $donnees['nb_personne'], " personne(s) pour une durée de ",
                    $donnees{'duree'}, " jours.";
                    ?></div>
                    </li>
                  </ul>

            <?php endif; } ?>



            </div>
        </div>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <span class="copyright">Copyright &copy; FrenchMotorTrip 2016</span>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li><a href="#">Conditions générales</a>
                            </li>
                            <li><a href="#">Termes d'usage</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>


        <!-- jQuery -->
        <script src="vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="js/jqBootstrapValidation.js"></script>
        <script src="js/contact_me.js"></script>

</body>
</html>
