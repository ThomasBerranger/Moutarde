<?php

require('connection.php');

if(isset($_POST['forminscription']))
{

    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $mail = htmlspecialchars($_POST['mail']);
    $news_letter = htmlspecialchars($_POST['news_letter']);
    $conditions = htmlspecialchars($_POST['conditions']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    if(!empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {
        if($conditions == "oui")
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
                          $insertmembre = $bdd->prepare("INSERT INTO membres (prenom, nom, mdp, mail, news_letter) VALUES (?, ?, ?, ?, ?)");
                          $insertmembre->execute(array($prenom, $nom, $mdp, $mail, $news_letter));
                          $erreur = "Votre compte a bien été crée ! Merci de vous connecter.";
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
         $erreur = "Vous devez accépter nos conditions générales d'utilisation.";
       }
    }
    else
    {
        $erreur = "Vous devez tout remplir !";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>

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
                                <li><a href="profil.php?id=<?php echo $_SESSION['id'] ?>">Aperçu de mon compte</a></li>
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
                <h3>INSCRIPTION</h3>
            </div>
        </div>



<form class="" action="" method="post">
        <div class="row">
            <div class="formulaire col-xs-10 col-xs-offset-1">
               <div class="input">
                    <label for="mon_id">Prénom *</label>
                    <input type="text" class="form-control" id="firstname" name="prenom" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="input">
                    <label for="mon_id">Nom *</label>
                    <input type="text" class="form-control" id="lastname" name="nom" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="input">
                    <label for="mon_id">Identifiant ou adresse e-mail *</label>
                    <input type="mail" class="form-control"  id="mail" name="mail" required data-validation-required-message="S'il vous plaît entrez votre e-mail.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="input">
                    <label for="mon_id">Mot de passe *</label>
                    <input type="password" class="form-control" id="password" name="mdp" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                    <p class="help-block text-danger"></p>
                </div>
                <div class="input">
                    <label for="mon_id">Confirmation de mot de passe *</label>
                    <input type="password" class="form-control" id="password" name="mdp2" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                    <p class="help-block text-danger"></p>
                </div>

                <label for="mon_id">Recevoir notre news letter ?</label>
                <br>
                <input type="radio" name="news_letter" value="oui" checked > <label for="mon_id">Oui </label>
                <br>
                <input type="radio" name="news_letter" value="non" > <label for="mon_id">Non </label>
                <p class="help-block text-danger"></p>

                <label for="mon_id">En vous inscrivant, vous accépter nos conditions d'utilisations générales.</label>
                <br>
                <input type="radio" name="conditions" value="oui" checked > <label for="mon_id">Oui </label>
                <br>
                <input type="radio" name="conditions" value="non" > <label for="mon_id">Non </label>
                <p class="help-block text-danger"></p>

                <div id="success"></div>
                <div class="row">
                    <button type="submit" name="forminscription" class="button col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">Inscription</button>
                    <br>
                    <?php if(isset($erreur)) { ?> <br> <?php  echo $erreur; } ?>
                </div>
                <div class="row">
                    <div class="mdp col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">
                        <a href="connexion.php">Déjà membre ?<br> Connectez vous</a>
                    </div>
                </div>
            </div>
        </div>
</form>



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
