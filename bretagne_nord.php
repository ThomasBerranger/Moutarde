<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bretagne du Nord</title>
  </head>
  <link href="css/bootstrap.min.css" rel="stylesheet">

          <!-- Theme CSS -->

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Bretagne Nord" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <link href="css/agency.css" rel="stylesheet">
        <link href="css/circuits.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="style.css" />
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
  <body>
    <nav id="mainNav" class="navbar navbar-default navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>  <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php#page-top">French Motor Trip</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right" >
                    <li class="hidden">
                        <a href="index.php#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#page-top">Accueil</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#circuits">Circuits</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#about">FAQ</a>
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
    <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h2 class="section-heading">Bretagne du nord</h2> </div>
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
                                            <div class="item active"> <img src="./img/bretagnenord/pa5.jpg" alt="Bretagne du nord" class="image-responsive"> </div>
                                            <div class="item"> <img src="./img/bretagnenord/pa4.jpg" alt="bretagne du nord" class="image-responsive"> </div>
                                        </div>
                                    </div>
                                    <div class="timeline-heading">
                                        <h4 class="subheading">Présentation</h4> </div>
                                    <div class="timeline-body">
                                        <p class="text-muted">Laissez-vous séduire par sa nature vierge par ses côtes sauvages, ses falaises battues par les vents et les embruns , la partie nord de la Bretagne présente une remarquable variété de paysages : bocage et vergers à cidre, collines chauves et landes des monts d’Arrée, vallées fluviales remontées par les marées (la Rance, la rivière de Morlaix, les abers), plateau du Léon, jardin potager de la Bretagne. De Saint-Malo, fière cité corsaire cernée de remparts, jusqu’à Brest, le port de tous les départs, le voyage en Bretagne passe aussi par la mythique forêt de Brocéliande et les enclos paroissiaux du Léon, fleurons de l’architecture et de l’art breton. </p>
                                    </div>
                                    <div class="separate"></div>
                                    <ul class="timeline">
                                        <li class="timeline-inverted">
                                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/harley.jpg" alt="harley"> </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="subheading">Quelle moto ?</h4> </div>
                                                <div class="timeline-body">
                                                    <p class="text-muted">Pour votre parcours nous vous proposons une Harley Davidson 1200 Sportser XL Custom.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/Franche-comte/resto.jpg" alt="restaurant"> </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="subheading">Restaurant</h4> </div>
                                                <div class="timeline-body">
                                                    <p class="text-muted">Convaincus que la découverte d’une région se fait aussi par le goût et la rencontre avec les producteurs locaux, les « Restaurants e Bretagne Nord » sont particulièrement attentifs à la qualité et à l’origine des produits qu’ils cuisinent. Ils contribuent à valoriser une économie de proximité respectant les savoir-faire traditionnels des petits producteurs en proposant une expérience gustative qui garantit une rencontre conviviale et authentique avec la Bretagne d’aujourd’hui.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="timeline-inverted">
                                            <div class="timeline-image"> <img class="img-circle img-responsive" src="img/bretagnenord/ro1.png" alt="parcours"> </div>
                                            <div class="timeline-panel parcours">
                                                <div class="timeline-heading">
                                                    <h4 class="subheading">Quel parcours ?</h4> </div>
                                                    <div class="timeline-body">
                                                        <p class="text-muted"> Ce voyage entre nature et culture vous fait parcourir les hauts lieux de la bretagne du nord. Vous ridez hors des sentiers battus et goûtez au caractère indomptable de la région.  Découvrez une multitude de paysages en Bretagne à moto, des thalassos de Saint-Malo au Mont Saint-Michel en passant par les côtes de granit rose de Perros-Guirec jusqu’aux villes fortifiées de Bretagne. Ce circuit, confectionné avec soin, vous permet de savourer pleinement l’ambiance bretonne. Prenez également plaisir à découvrir les spécialités gastronomiques incontournables de cette région. </p>
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
       											Calendrier Bretagne du nord
       									</h1>
       							</div><!-- /.page-header -->

       							<div class="row">
       									<div class="col-xs-12">
       											<!-- PAGE CONTENT BEGINS -->


                            <div class="periods">
                                <div class="year"><?php echo $year; ?></div> <!--Affiche l'année-->
                                <div class="months"> <!--Affiche les mois-->
                                    <div class="mois">
                                        <?php foreach ($date->months as $id=>$m): ?>
                                            <a class="linkMonth" href="#" id="linkMonth<?php echo $id+1; ?>"><?php echo utf8_encode(substr(utf8_decode($m),0,10)); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <hr class="hr1">

                                <div class="col-xs-0 col-sm-0 col-md-4"></div>
                                <div class="col-md-8">
                                    <?php $dates = current($dates); ?><!--Prend la première valeure-->
                                    <?php foreach ($dates as $m=>$days): ?><!--Affiche les dates jours par jours-->
                                    <div class="month relative" id="month<?php echo $m; ?>">
                                        <table>
                                            <thead>
                                            <tr>
                                                <?php foreach ($date ->days as $d): ?> <!--Affiche les jours de la semaine-->
                                                    <th><?php echo substr($d,0,10); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <?php $end = end($days); foreach ($days as $d=>$w): ?> <!--Affiche tous les jours du mois en question-->

                                                <?php $time = strtotime("$year-$m-$d"); ?>
                                                <?php if ($d==1 and $w != 1): ?>
                                                    <td colspan="<?php echo $w-1; ?>" class="padding"></td> <!-- Remplis le tableau pour que les jours correspondent aux dates -->
                                                <?php endif; ?>

                                                <td
                                                  <?php if($time == strtotime(date('Y-m-d'))): ?> class="today" <?php endif; // Met en évidence quel jours nous sommes

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
                                                  if($verif_nb_personne >= 10): ?> style="background-color: #c0392b" <?php endif;
                                                  if($verif_nb_personne > 0): ?> style="background-color: #2980b9" <?php endif;?>>

                                                  <div class="relative">
                                                      <div class="day"><?php echo $d; ?></div>
                                                  </div>


                                                </td>

                                                <?php if ($w == 7): ?>
                                            </tr><tr>
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
       									</div><!-- /.col -->
       							</div><!-- /.row -->


                    <div class="row" style="padding-top: 5vh;margin: auto;text-align: center;">
                      <div class="col-md-4">
                      <div style="border: solid;height:50px;margin: auto;width: 50px;"></div>
                      <h3>indisponible</h3> </div>
                      <div class="col-md-4">
                      <div style="background-color: #2980b9;border: solid;height:50px;width: 50px;margin: auto;"></div>
                      <h3>places libres</h3> </div>
                      <div class="col-md-4">
                      <div style="background-color: #c0392b;border: solid;height:50px;width: 50px;margin: auto;"></div>
                      <h3>complet</h3> </div>
                    </div>



                                  <!-- Contact Section -->
                                  <section id="contact">
                                      <div class="container">
                                          <div class="row">
                                              <div class="col-lg-12 text-center">
                                                  <h2 class="section-heading">Réservation</h2>
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

                                                                        <!-- Latest compiled and minified JavaScript -->
                                                                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>
