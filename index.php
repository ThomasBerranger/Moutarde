<?php

session_start();

require('connection.php');

$userinfo = 0;

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

<!DOCTYPE html>
<html lang="fr">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Projet Y days">
        <meta name="author" content="Groupe Moutarde">

        <title>French Motor Trip</title>

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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
    jQuery(function($){
        $('.month').hide();
        $('.month:first').show();
        $('.months a:first').addClass('active');
        var current = 1;
        $('.months a').click(function(){
            var month = $(this).attr('id').replace('linkMonth','');
            if(month != current){
                $('#month'+current).slideUp();
                $('#month'+month).slideDown();
                $('.months a').removeClass('active');
                $('.months a#linkMonth'+month).addClass('active');
                current = month;
            }
            return false;
        });
    });
</script>
    </head>

    <body id="page-top" class="index w3-animate-opacity">

        <!-- Navigation -->
        <nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>  <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand page-scroll" href="#page-top">French Motor Trip</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="hidden">
                            <a href="#page-top"></a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#page-top">Accueil</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#circuits">Circuits</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#about">FAQ</a>
                        </li>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
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
                                <li><a href="edit_profil.php?id=<?php echo $_SESSION['id']?>">Aperçu de mon compte</a></li>
                                <li><a href="mes_commandes.php?id=<?php echo $_SESSION['id']?>">Mes commandes</a></li>
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

        <!-- Header -->
        <header>
            <div class="container">
                <div class="intro-text">
                    <div class="intro-lead-in">Bienvenue</div>
                    <div class="intro-heading">French Motor Trip</div>
                    <?php if ($userinfo['prenom'] == 'admin' and $userinfo['nom'] == 'admin' and $userinfo['mail'] == 'admin@gmail.com') {?>
                    <h1> <a href="accueil.php?id=<?php echo $_SESSION['id'] ?>">Espace Administrateur</a> </h1>
                    <?php } ?>
                </div>
            </div>
        </header>


        <!-- Circuits Grid Section -->
        <section id="circuits" class="bg-light-gray">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">Circuits</h2>
                        <h3 class="section-subheading text-muted">Choisissez votre région</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 circuits-item">
                        <a href="franche_comte.php" class="circuits-link" target="_blank">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/franchecomte.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Franche-comté</h4>
                            <p class="text-muted"></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 circuits-item">
                        <a href="bretagne_nord.php" class="circuits-link" target="_blank">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/bretagnenord.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Bretagne Nord</h4>
                            <p class="text-muted"></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 circuits-item">
                        <a href="bretagne_sud.php" class="circuits-link" target="_blank">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/bretagnesud.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Bretagne sud</h4>
                            <p class="text-muted"></p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-heading text-center">F.A.Q</h2>
                    <div class="question col-lg-10 col-lg-offset-1">
                        <h3>Puis-je vous faire confiance ?</h3>
                        <p>Bien sûr ! malgré notre récente arrivée sur le marché, vous êtes assuré de la réservation jusqu’à la fin de votre séjour.</p>
                    </div>
                    <div class="question col-lg-10 col-lg-offset-1">
                        <h3>Est-il possible de venir avec sa propre moto ?</h3>
                        <p>Tout a fait ! Une formule est disponible sur le site avec réduction du prix afin que vous puissiez profiter au mieux du séjour.</p>
                    </div>
                    <div class="question col-lg-10 col-lg-offset-1" style="margin-bottom:0;">
                        <h3>Pourquoi voyager avec french motor trip ?</h3>
                        <p>Nous avons créé french motor trip pour faciliter la vie des voyageurs et des road-trippers en France. En choisissant French motor trip, vous trouvez les meilleurs Spécialistes mondiaux du road-trip, vous payez moins cher qu’en passant par une agence traditionnelle et vous bénéficiez de garanties en plus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>



    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contactez Nous</h2>
                    <h3 class="section-subheading text-muted">Nous vous répondrons le plus rapidement possible !</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="nom *" id="name" required data-validation-required-message="S'il vous plaît entrez votre nom.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email *" id="email" required data-validation-required-message="S'il vous plait entrez votre adresse mail.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Telephone *" id="phone" required data-validation-required-message="S'il vous plaît entrez votre numéro de téléphone.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Message *" id="message" required data-validation-required-message="S'il vous plaît entrez un message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-xl">Envoyer message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
        <div id="google_translate_element"></div>
      <script type="text/javascript">
          function googleTranslateElementInit() {
              new google.translate.TranslateElement({
                  pageLanguage: 'fr'
                  , layout: google.translate.TranslateElement.InlineLayout.SIMPLE
              }, 'google_translate_element');
          }
      </script>
      <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
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

    <!-- Theme JavaScript -->
    <script src="js/agency.js"></script>

    </body>

</html>
