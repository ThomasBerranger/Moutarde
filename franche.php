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
    <?php
    include 'navbar.php';
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Franche-Comté</h2> </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Mon carousel -->
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#myCarousel" data-slide-to="1"></li>
                        </ol>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active"> <img src="./img/Franche-comte/pa.jpg" alt="Bretagne du nord" class="image-responsive"> </div>
                            <div class="item"> <img src="./img/Franche-comte/pa2.jpg" alt="bretagne du nord" class="image-responsive"> </div>
                        </div>
                    </div>
                    <div class="timeline-heading">
                        <h4 class="subheading">Présentation</h4> </div>
                    <div class="timeline-body">
                        <p class="text-muted">La Franche-Comté charme d’abord par la diversité de ses paysages : forêts à perte de vue, lacs majestueux, grottes et gouffres profonds, rivières impétueuses, cascades impressionnantes. Au nord, la beauté préservée des ballons des Vosges, au centre, la chute magnifique du Saut du Doubs, au sud, l’impressionnant panorama du crêt de Chalam, dans le parc naturel régional du Haut-Jura, ne sont qu’un aperçu des richesses naturelles innombrables de la région.</p>
                    </div>
                    <div class="separate"></div>
                    <ul class="timeline">
                        <li class="timeline-inverted">
                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/moto.jpeg" alt=""> </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="subheading">Quelle moto ?</h4> </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Pour votre parcours nous vous proposons une Suzuki 650 V-STROM ABS (645m3) ou une Ducati Scrambler Classic ABS (803m3) au choix.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/Franche-comte/resto.jpg" alt=""> </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4 class="subheading">Restaurant</h4> </div>
                                <div class="timeline-body">
                                    <p class="text-muted">La gastronomie fait partie intégrante de la découverte de la région. Elle s'articule autour de produits célèbres: saucisse de Morteau, comté, morbier, vins du Jura renommés comme le vin jaune, le vin de paille.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/Franche-comte/carte.png" alt=""> </div>
                            <div class="timeline-panel parcours">
                                <div class="timeline-heading">
                                    <h4 class="subheading">Quel parcours ?</h4> </div>
                                <div class="timeline-body">
                                    <p class="text-muted"> Nous commencerons dans le Jura où nous pourrons contempler les cascades de la région. Puis nous finirons notre séjour dans le département des Haute-Saône connus pour ses superbes lacs. </p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <h4>Enjoy
                                            <br>Your
                                            <br>Trip !</h4> </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <?php
                    require('connection.php');
                    $destination = "Bretagne du nord";

                    $reservation_bretagne_nord = $bdd->prepare('SELECT * FROM reservations WHERE destination=?');
                    $reservation_bretagne_nord->execute(array($destination));

                    require('date.php');
                    require('config.php');
                    $date = new Date();
                    $year = date('Y');
                    $dates = $date->getAll($year);
                    $nom = $date->getNom($year);
                    $verif_unique = $date->getVerif_unique($year);
                    $nb_personne = $date->getNb_personne($year);
                    ?>
            <div class="page-header">
                <h1 style="text-align:center;">
       											Calendrier Franche Comté
       									</h1> </div>
            <!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="periods">
                        <div class="year">
                            <?php echo $year; ?>
                        </div>
                        <!--Affiche l'année-->
                        <div class="months">
                            <!--Affiche les mois-->
                            <div class="mois">
                                <?php foreach ($date->months as $id=>$m): ?>
                                    <a class="linkMonth" href="#" id="linkMonth<?php echo $id+1; ?>">
                                        <?php echo utf8_encode(substr(utf8_decode($m),0,10)); ?>
                                    </a>
                                    <?php endforeach; ?>
                            </div>
                        </div>
                        <hr class="hr1">
                        <div class="col-xs-0 col-sm-0 col-md-4"></div>
                        <div class="col-md-8">
                            <?php $dates = current($dates); ?>
                                <!--Prend la première valeure-->
                                <?php foreach ($dates as $m=>$days): ?>
                                    <!--Affiche les dates jours par jours-->
                                    <div class="month relative" id="month<?php echo $m; ?>">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <?php foreach ($date ->days as $d): ?>
                                                        <!--Affiche les jours de la semaine-->
                                                        <th>
                                                            <?php echo substr($d,0,10); ?>
                                                        </th>
                                                        <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php $end = end($days); foreach ($days as $d=>$w): ?>
                                                        <!--Affiche tous les jours du mois en question-->
                                                        <?php $time = strtotime("$year-$m-$d"); ?>
                                                            <?php if ($d==1 and $w != 1): ?>
                                                                <td colspan="<?php echo $w-1; ?>" class="padding"></td>
                                                                <!-- Remplis le tableau pour que les jours correspondent aux dates -->
                                                                <?php endif; ?>
                                                                    <td <?php if($time==s trtotime(date( 'Y-m-d'))): ?> class="today"
                                                                        <?php endif; // Met en évidence quel jours nous sommes

                                                  $verif_nb_personne = 0;
                                                  if (isset($verif_unique[$time])) //Grosse boucle permettant d'afficher une couleur en fonction du nombre de personne inscrites
                                                  {
                                                  foreach ($verif_unique[$time] as $e):
                                                  reset($reservation_bretagne_nord);
                                                  $reservation_bretagne_nord = $bdd->prepare("SELECT * FROM reservations WHERE destination=?");
                                                  $reservation_bretagne_nord->execute(array($destination));
                                                  while ($donnees = $reservation_bretagne_nord->fetch()) {
                                                    if ($e == $donnees['verif_unique']): ?>
                                                                            <?php $verif_nb_personne = $verif_nb_personne + $donnees['nb_personne'];
                                                  endif;
                                                  }
                                                  endforeach;
                                                  }
                                                  if($verif_nb_personne >= 10): ?> style="background-color: #c0392b"
                                                                                <?php endif;
                                                  if($verif_nb_personne > 0): ?> style="background-color: #2980b9"
                                                                                    <?php endif;?>>
                                                                                        <div class="relative">
                                                                                            <div class="day">
                                                                                                <?php echo $d; ?>
                                                                                            </div>
                                                                                        </div>
                                                                    </td>
                                                                    <?php if ($w == 7): ?>
                                                </tr>
                                                <tr>
                                                    <?php endif; ?>
                                                        <?php endforeach; ?>
                                                            <?php if ($end != 7): ?>
                                                                <td colspan="<?php echo 7-$end; ?>" class="padding"></td>
                                                                <?php endif; ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <br>
                <br>
                <div class="col-xs-0 col-sm-0 col-md-4"></div>
                <div class="col-xs-0 col-sm-0 col-md-4">
                    <div style="border: solid; height:50px; width: 50px;"></div>
                    <h3>Pas de reservation à cette date.</h3> </div>
            </div>
            <div class="row">
                <div class="col-xs-0 col-sm-0 col-md-4"></div>
                <div class="col-xs-0 col-sm-0 col-md-4">
                    <div style="background-color: #2980b9; height:50px; width: 50px;"></div>
                    <h3>Il reste de la plasse !</h3> </div>
            </div>
            <div class="row">
                <div class="col-xs-0 col-sm-0 col-md-4"></div>
                <div class="col-xs-0 col-sm-0 col-md-4">
                    <div style="background-color: #c0392b; height:50px; width: 50px;"></div>
                    <h3>Plus de plasse :c</h3> </div>
            </div>
            <!-- Contact Section -->
            <section id="contact">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2 class="section-heading">Réservation</h2>
                            <h3 class="section-subheading text-muted">Nous vous répondrons le plus rapidement possible !</h3> </div>
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
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
            <!-- Optional theme -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>