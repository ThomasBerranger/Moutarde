<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    if(isset($_POST['modif']))
    {

      if(isset($_POST['newmdp']) and !empty($_POST['newmdp'] and $_POST['newmdp2']) and !empty($_POST['newmdp2']))
      {
          $newmdp = sha1($_POST['newmdp']);
          $newmdp2 = sha1($_POST['newmdp2']);

              if($newmdp == $newmdp2)
              {
                  $insertmdp = $bdd->prepare("UPDATE membres SET mdp = ? WHERE id = ?");
                  $insertmdp->execute(array($newmdp, $_SESSION['id']));

                  if (isset($_POST['newmail']) and !empty($_POST['newmail']))
                  {
                      $newmail = htmlspecialchars($_POST['newmail']);
                      $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
                      $insertmail->execute(array($newmail, $_SESSION['id']));
                  }

                  if(isset($_POST['newprenom']) and !empty($_POST['newprenom']))
                  {
                      $newprenom = htmlspecialchars($_POST['newprenom']);
                      $insertprenom = $bdd->prepare("UPDATE membres SET prenom = ? WHERE id = ?");
                      $insertprenom->execute(array($newprenom, $_SESSION['id']));
                  }

                  if(isset($_POST['newnom']) and !empty($_POST['newnom']))
                  {
                      $newnom = htmlspecialchars($_POST['newnom']);
                      $insertnom = $bdd->prepare("UPDATE membres SET nom = ? WHERE id = ?");
                      $insertnom->execute(array($newnom, $_SESSION['id']));
                      $erreur = "Votre compte a bien été modifié";
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
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edition profil</title>

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
                          <a class="page-scroll" href="index.html#page-top">Accueil</a>
                      </li>
                      <li>
                          <a class="page-scroll" href="index.html#circuits">Circuit</a>
                      </li>
                      <li>
                          <a class="page-scroll" href="index.html#about">FAQ</a>
                      </li>
                      <li>
                          <a class="page-scroll" href="index.html#contact">Contact</a>
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

       <div class="body">

        <div class="row">
            <div class="connexion col-xs-10 col-xs-offset-1">
                <h3 style="padding-top:30px; text-align:center;" >Bienvenue <?php echo $userinfo['prenom'], " ", $userinfo['nom'];  ?></h3>
            </div>
        </div>

        <div class="row">
            <form action="" method="POST">

            <div class="formulaire col-xs-10 col-xs-offset-1">
                <div class="form-group">
                    <label for="">Prénom *</label>
                    <input type="text" class="form-control" name="newprenom" placeholder="Prenom" value="<?php echo $userinfo['prenom']?>" required data-validation-required-message="S'il vous plaît entrez votre e-mail.">
                    <p class="help-block text-danger"></p>
                </div>
            <div class="form-group">
                    <label for="">Nom *</label>
                    <input type="text" class="form-control" name="newnom" placeholder="Nom" value="<?php echo $userinfo['nom']?>" id="name" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                    <p class="help-block text-danger"></p>
              </div>
              <div class="form-group">
                  <label for="">Identifiant ou adresse e-mail *</label>
                  <input type="mail" class="form-control" name="newmail" placeholder="Mail" value="<?php echo $userinfo['mail']?>" id="mail" name="mdp" required data-validation-required-message="S'il vous plaît entrez votre mail.">
                  <p class="help-block text-danger"></p>
              </div>
              <div class="form-group">
                  <label for="">Mot de passe *</label>
                  <input type="password" class="form-control" id="password" name="newmdp" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                  <p class="help-block text-danger"></p>
              </div>

              <div class="form-group">
                <label for="">Confirmation de mot de passe*</label>
                <input type="password" class="form-control" id="password" name="newmdp2" required data-validation-required-message="S'il vous plaît entrez votre mot de passe.">
                <p class="help-block text-danger"></p>
              </div>
              <div class="clearfix"></div>
              <div class="row bouton">
                <div id="success"></div>
                <button type="submit" name="modif" class="button col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3">Modifier</button>
                <?php if(isset($erreur)){echo $erreur;} ?>
            </form>
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
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
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

        </div> <!-- body -->


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

<?php
}
else
{
header("Location: index.php");
}
?>
