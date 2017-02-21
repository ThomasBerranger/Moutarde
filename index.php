<?php

session_start();
$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

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
                    <h1> <a href="calendrier.php">Espace Administrateur</a> </h1>
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
                        <a href="#circuitsModal1" class="circuits-link" data-toggle="modal">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/franchecomte.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Franche-comté</h4>
                            <p class="text-muted">3000.00 €</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 circuits-item">
                        <a href="#circuitsModal2" class="circuits-link" data-toggle="modal">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/bretagnenord.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Bretagne Nord</h4>
                            <p class="text-muted">3000.00 €</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 circuits-item">
                        <a href="#circuitsModal3" class="circuits-link" data-toggle="modal">
                            <div class="circuits-hover">
                                <div class="circuits-hover-content">
                                    <img src="./img/assets/compass.png" alt="arrow">
                                </div>
                            </div>
                            <img src="./img/bretagnesud.jpg" class="img-responsive" alt="">
                        </a>
                        <div class="circuits-caption">
                            <h4>Bretagne sud</h4>
                            <p class="text-muted">3000.00 €</p>
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
                        <h3>Premiere question</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, minus, expedita? Id voluptates, atque, laudantium unde optio numquam eligendi quaerat illum. Sapiente ipsum harum ad doloremque eum temporibus ex delectus.</p>
                    </div>
                    <div class="question col-lg-10 col-lg-offset-1">
                        <h3>Deuxieme question</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, minus, expedita? Id voluptates, atque, laudantium unde optio numquam eligendi quaerat illum. Sapiente ipsum harum ad doloremque eum temporibus ex delectus.</p>
                    </div>
                    <div class="question col-lg-10 col-lg-offset-1" style="margin-bottom:0;">
                        <h3>Troisieme question</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum, minus, expedita? Id voluptates, atque, laudantium unde optio numquam eligendi quaerat illum. Sapiente ipsum harum ad doloremque eum temporibus ex delectus.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr>

    <!-- Clients Aside -->
    <aside class="clients">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/envato.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/designmodo.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/themeforest.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="#">
                        <img src="img/logos/creative-market.jpg" class="img-responsive img-centered" alt="">
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Contactez Nous</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
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
    </footer>

    <!-- circuits Modals -->
    <!-- Use the modals below to showcase details about your circuits projects! -->

    <!-- circuits Modal 1 -->
    <div class="circuits-modal modal fade" id="circuitsModal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Franche-Comté</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/Franche-comte/paysage.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Présentation</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">La Franche-Comté charme d’abord par la diversité de ses paysages : forêts à perte de vue, lacs majestueux, grottes et gouffres profonds, rivières impétueuses, cascades impressionnantes. Au nord, la beauté préservée des ballons des Vosges, au centre, la chute magnifique du Saut du Doubs, au sud, l’impressionnant panorama du crêt de Chalam, dans le parc naturel régional du Haut-Jura, ne sont qu’un aperçu des richesses naturelles innombrables de la région.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/moto.jpeg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quelle moto ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Pour votre parcours nous vous proposons une  Suzuki 650 V-STROM ABS (645m3) ou une Ducati Scrambler Classic ABS (803m3) au choix.</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/Franche-comte/resto.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Restaurant</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">La gastronomie fait partie intégrante de la découverte de la région. Elle s'articule autour de produits célèbres: saucisse de Morteau, comté, morbier, vins du Jura renommés comme le vin jaune, le vin de paille.</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/Franche-comte/carte.png" alt="">
                                    </div>
                                    <div class="timeline-panel parcours">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quel parcours ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">
                                                Nous commencerons dans le Jura où nous pourrons contempler les cascades de la région. Puis nous finirons notre séjour dans le département des Haute-Saône connus pour ses superbes lacs. </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <h4>Enjoy
                                            <br>Your
                                            <br>Trip !</h4>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- Container -->
            </div>
        </div>
    </div>

    <!-- circuits Modal 2 -->
    <div class="circuits-modal modal fade" id="circuitsModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Bretagne Nord</h2>
                            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/1.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quel parcours ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/2.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quelle moto ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/3.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">A propos de l'assurance</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/4.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Paiement</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <h4>Enjoy
                                            <br>Your
                                            <br>Trip !</h4>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- Container -->
            </div>
        </div>
    </div>

    <!-- circuits Modal 3 -->
    <div class="circuits-modal modal fade" id="circuitsModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Bretagne Sud</h2>
                            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/1.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quel parcours ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/2.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Quelle moto ?</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/3.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">A propos de l'assurance</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <img class="img-circle img-responsive" src="img/about/4.jpg" alt="">
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="subheading">Paiement</h4>
                                        </div>
                                        <div class="timeline-body">
                                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-image">
                                        <h4>Enjoy
                                            <br>Your
                                            <br>Trip !</h4>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> <!-- Container -->
            </div>
        </div>
    </div>

    <!-- circuits Modal 4 -->
    <div class="circuits-modal modal fade" id="circuitsModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/circuits/golden-preview.png" alt="">
                                <p>Start Bootstrap's Agency theme is based on Golden, a free PSD website template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Golden is a modern and clean one page web template that was made exclusively for Best PSD Freebies. This template has a great circuits, timeline, and meet your team sections that can be easily modified to fit your needs.</p>
                                <p>You can download the PSD template in this circuits sample item at <a href="http://freebiesxpress.com/gallery/golden-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- circuits Modal 5 -->
    <div class="circuits-modal modal fade" id="circuitsModal5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/circuits/escape-preview.png" alt="">
                                <p>Escape is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Escape is a one page web template that was designed with agencies in mind. This template is ideal for those looking for a simple one page solution to describe your business and offer your services.</p>
                                <p>You can download the PSD template in this circuits sample item at <a href="http://freebiesxpress.com/gallery/escape-one-page-psd-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- circuits Modal 6 -->
    <div class="circuits-modal modal fade" id="circuitsModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <!-- Project Details Go Here -->
                                <h2>Project Name</h2>
                                <p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
                                <img class="img-responsive img-centered" src="img/circuits/dreams-preview.png" alt="">
                                <p>Dreams is a free PSD web template built by <a href="https://www.behance.net/MathavanJaya">Mathavan Jaya</a>. Dreams is a modern one page web template designed for almost any purpose. It’s a beautiful template that’s designed with the Bootstrap framework in mind.</p>
                                <p>You can download the PSD template in this circuits sample item at <a href="http://freebiesxpress.com/gallery/dreams-free-one-page-web-template/">FreebiesXpress.com</a>.</p>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script src="js/agency.min.js"></script>

    </body>

</html>
