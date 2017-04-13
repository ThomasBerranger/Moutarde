<?php
session_start();

require('connection.php');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?'); // Récupère les infos de l'utilisateur connecté
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    $destination = "Franche-Comte";

    $reservation_bretagne_nord = $bdd->prepare('SELECT * FROM reservations WHERE destination=?');
    $reservation_bretagne_nord->execute(array($destination));
 ?>

 <!DOCTYPE html>
 <html lang="en">
 	<head>
 		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 		<meta charset="utf-8" />
 		<title>Calendrier Franche-Comté</title>

 		<meta name="description" content="responsive photo gallery using colorbox" />
 		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

 		<!-- bootstrap & fontawesome -->
 		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
 		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

 		<!-- page specific plugin styles -->
 		<link rel="stylesheet" href="assets/css/colorbox.min.css" />

 		<!-- text fonts -->
 		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

 		<!-- ace styles -->
 		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

 		<!--[if lte IE 9]>
 			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
 		<![endif]-->
 		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
 		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

 		<!--[if lte IE 9]>
 		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
 		<![endif]-->

 		<!-- inline styles related to this page -->

 		<!-- ace settings handler -->
 		<script src="assets/js/ace-extra.min.js"></script>

 		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

 		<!--[if lte IE 8]>
 		<script src="assets/js/html5shiv.min.js"></script>
 		<script src="assets/js/respond.min.js"></script>
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
 	<body class="no-skin">

    <?php
    require('date.php');
    require('config.php');
    $date = new Date();
    $year = date('Y');
    $dates = $date->getAll($year);
    $nom = $date->getNom($year);
    $verif_unique = $date->getVerif_unique($year);
    $nb_personne = $date->getNb_personne($year);
    ?>


 		<div id="navbar" class="navbar navbar-default          ace-save-state">
             <div class="navbar-container ace-save-state" id="navbar-container">
                 <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                     <span class="sr-only">Toggle sidebar</span>

                     <span class="icon-bar"></span>

                     <span class="icon-bar"></span>

                     <span class="icon-bar"></span>
                 </button>

                 <div class="navbar-header pull-left">
                     <a href="accueil.php?id=<?php echo $_SESSION['id'] ?>" class="navbar-brand">
                         <small>
                             <i class="fa fa-leaf"></i>
                             French Motor Trip
                         </small>
                     </a>
                 </div>
                 <div class="navbar-buttons navbar-header pull-right" role="navigation">
                     <ul class="nav ace-nav">
                         <li class="light-blue dropdown-modal">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="background-color:none">Mon Compte<span class="caret"></span></a>
                           <ul class="dropdown-menu pull-left">
                               <li><a href="index.php?id=<?php echo $_SESSION['id']?>">Site</a></li>
                               <li role="separator" class="divider"></li>
                               <li><a href="deconnexion.php">Deconnexion</a></li>
                         </li>
                     </ul>
                 </div>
             </div><!-- /.navbar-container -->
         </div>

 		<div class="main-container ace-save-state" id="main-container">
 			<script type="text/javascript">
 				try{ace.settings.loadState('main-container')}catch(e){}
 			</script>

 			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
 				<script type="text/javascript">
 					try{ace.settings.loadState('sidebar')}catch(e){}
 				</script>



 				<ul class="nav nav-list">
 					<li class="">
 						<a href="accueil.php?id=<?php echo $_SESSION['id'] ?>">
 							<i class="menu-icon fa fa-home"></i>
 							<span class="menu-text"> Acceuil </span>
 						</a>

 						<b class="arrow"></b>
 					</li>


 					<li class="">
 							<a href="#" class="dropdown-toggle">
 									<i class="menu-icon fa fa-list"></i>
 									<span class="menu-text"> Tableaux </span>

 									<b class="arrow fa fa-angle-down"></b>
 							</a>

 							<b class="arrow"></b>

              <ul class="submenu">
                  <li class="">
                      <a href="table_users.php?id=<?php echo $_SESSION['id'] ?>">
                          <i class="menu-icon fa fa-caret-right"></i>
                          Tableau utilisateurs
                      </a>

                      <b class="arrow"></b>
                  </li>

                  <li class="">
                      <a href="table_b_n.php?id=<?php echo $_SESSION['id'] ?>">
                          <i class="menu-icon fa fa-caret-right"></i>
                          Tableau reservation bretagne du nord
                      </a>

                      <b class="arrow"></b>
                  </li>

                  <li class="">
                      <a href="table_b_s.php?id=<?php echo $_SESSION['id'] ?>">
                          <i class="menu-icon fa fa-caret-right"></i>
                          Tableau reservation bretagne du sud
                      </a>

                      <b class="arrow"></b>
                  </li>

                  <li class="">
                      <a href="table_f_c.php?id=<?php echo $_SESSION['id'] ?>">
                          <i class="menu-icon fa fa-caret-right"></i>
                          Tableau reservations Franche-Comté
                      </a>

                      <b class="arrow"></b>
                  </li>
              </ul>
 					</li>

 					<li class="">
 						<a href="#" class="dropdown-toggle">
 							<i class="menu-icon fa fa-pencil-square-o"></i>
 							<span class="menu-text"> Formulaires </span>

 							<b class="arrow fa fa-angle-down"></b>
 						</a>

 						<b class="arrow"></b>

 						<ul class="submenu">
 							<li class="">
 								<a href="form_1.php?id=<?php echo $_SESSION['id'] ?>">
 									<i class="menu-icon fa fa-caret-right"></i>
 									Ajout / Suppression de réservation
 								</a>

 								<b class="arrow"></b>
 							</li>

 						</ul>
 					</li>

 					<li class="">
 						<a href="historique.php?id=<?php echo $_SESSION['id'] ?>">
 							<i class="menu-icon fa fa-list-alt"></i>
 							<span class="menu-text"> Historique </span>
 						</a>

 						<b class="arrow"></b>
 					</li>

 					<li class="active open">
 						<a href="#" class="dropdown-toggle">
 							<i class="menu-icon fa fa-calendar"></i>
 							<span class="menu-text"> Calendriers </span>

 							<b class="arrow fa fa-angle-down"></b>
 						</a>

 						<b class="arrow"></b>
 						<ul class="submenu">
 							<li class="">
 								<a href="calendrier_b_n.php?id=<?php echo $_SESSION['id'] ?>">
 									<i class="menu-icon fa fa-caret-right"></i>
 									Bretagne du nord
 								</a>

 								<b class="arrow"></b>
 							</li>
 							<li class="">
 								<a href="calendrier_b_s.php?id=<?php echo $_SESSION['id'] ?>">
 									<i class="menu-icon fa fa-caret-right"></i>
 									Bretagne de sud
 								</a>

 								<b class="arrow"></b>
 							</li>
 							<li class="active">
 								<a href="calendrier_f_c.php?id=<?php echo $_SESSION['id'] ?>">
 									<i class="menu-icon fa fa-caret-right"></i>
 									Franche-Comté
 								</a>

 								<b class="arrow"></b>
 							</li>

 						</ul>
 					</li>

 					<li class="">
 						<a href="galerie.php?id=<?php echo $_SESSION['id'] ?>">
 							<i class="menu-icon fa fa-picture-o"></i>
 							<span class="menu-text"> Galerie </span>
 						</a>

 						<b class="arrow"></b>
 					</li>


          <li class="">
 						<a href="#" class="dropdown-toggle">
 							<i class="menu-icon fa fa-file-o"></i>
 							<span class="menu-text">
 								 Page
 								<span class="badge badge-primary">1</span>
 							</span>
 							<b class="arrow fa fa-angle-down"></b>
 						</a>

 						<b class="arrow"></b>
 						<ul class="submenu">
 							<li class="">
 								<a href="index.php?id=<?php echo $_SESSION['id'] ?>">
 									<i class="menu-icon fa fa-caret-right"></i>
 									Index
 								</a>
 								<b class="arrow"></b>
 							</li>
 						</ul>
					</li>

 				</ul><!-- /.nav-list -->

 				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
 					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
 				</div>
 			</div>

 			<div class="main-content">
 				<div class="main-content-inner">
 					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
 						<ul class="breadcrumb">
 							<li>
 								<i class="ace-icon fa fa-home home-icon"></i>
 								<a href="#">Accueil</a>
 							</li>
              <li>
 								<i class="ace-icon fa fa-calendar home-icon"></i>
 								<a href="#">Calendriers</a>
 							</li>
 							<li class="active">Calendrier Franche-Comté</li>
 						</ul><!-- /.breadcrumb -->

 					</div>

 					<div class="page-content">


 							<div class="page-header">
 									<h1>
 											Calendrier Franche-Comté
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

                          <div class="col-xs-0 col-sm-0 col-md-1"></div>
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
                                            $reservation_franche_comte = $bdd->prepare("SELECT * FROM reservations WHERE destination=?");
                                            $reservation_franche_comte->execute(array($destination));
                                            while ($donnees = $reservation_franche_comte->fetch()) {
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

                                            <div class="daytitle">
                                                <?php echo $date->days[$w-1]." ", $d." ", $date->months[$m-1]; ?>
                                            </div>

                                            <ul class="events">
                                              <?php if (isset($verif_unique[$time]))
                                              {
                                              foreach ($verif_unique[$time] as $e):
                                              reset($reservation_bretagne_nord);
                                              $reservation_bretagne_nord = $bdd->prepare("SELECT * FROM reservations WHERE destination=?");
                                              $reservation_bretagne_nord->execute(array($destination));
                                              while ($donnees = $reservation_bretagne_nord->fetch()) {
                                                if ($e == $donnees['verif_unique']): ?>
                                                  <div><?php echo "Reservation N° ", $donnees['num_res'], " : M/Mme : ",$donnees['nom'],", mail : ",$donnees['mail'], ", groupe de ", $donnees['nb_personne'], " personnes ", $donnees['niveau'],", pendant : ", $donnees{'duree'}, " jours.";?></div>
                                                <?php endif;
                                              }
                                              endforeach;
                                              }
                                              else
                                              {
                                              ?>
                                                <div2><?php echo "Aucune reservation aujourd'hui." ?></div2><?php
                                              } ?>
                                             </ul>
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
 					</div><!-- /.page-content -->
 				</div>
 			</div><!-- /.main-content -->

 			<div class="footer">
 				<div class="footer-inner">
 					<div class="footer-content">
 						<span class="bigger-120">
 							<span class="blue bolder">FrenchMotorTrip</span>
 							 &copy; 2016-2017
 						</span>

 						&nbsp; &nbsp;
 						<span class="action-buttons">
 							<a href="#">
 								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
 							</a>

 							<a href="#">
 								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
 							</a>

 							<a href="#">
 								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
 							</a>
 						</span>
 					</div>
 				</div>
 			</div>

 			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
 				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
 			</a>
 		</div><!-- /.main-container -->

 		<!-- basic scripts -->

 		<!--[if !IE]> -->
 		<script src="assets/js/jquery-2.1.4.min.js"></script>

 		<!-- <![endif]-->

 		<!--[if IE]>
 <script src="assets/js/jquery-1.11.3.min.js"></script>
 <![endif]-->
 		<script type="text/javascript">
 			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
 		</script>
 		<script src="assets/js/bootstrap.min.js"></script>

 		<!-- page specific plugin scripts -->
 		<script src="assets/js/jquery.colorbox.min.js"></script>

 		<!-- ace scripts -->
 		<script src="assets/js/ace-elements.min.js"></script>
 		<script src="assets/js/ace.min.js"></script>

 		<!-- inline scripts related to this page -->
 		<script type="text/javascript">
 			jQuery(function($) {
 	var $overflow = '';
 	var colorbox_params = {
 		rel: 'colorbox',
 		reposition:true,
 		scalePhotos:true,
 		scrolling:false,
 		previous:'<i class="ace-icon fa fa-arrow-left"></i>',
 		next:'<i class="ace-icon fa fa-arrow-right"></i>',
 		close:'&times;',
 		current:'{current} of {total}',
 		maxWidth:'100%',
 		maxHeight:'100%',
 		onOpen:function(){
 			$overflow = document.body.style.overflow;
 			document.body.style.overflow = 'hidden';
 		},
 		onClosed:function(){
 			document.body.style.overflow = $overflow;
 		},
 		onComplete:function(){
 			$.colorbox.resize();
 		}
 	};

 	$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
 	$("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


 	$(document).one('ajaxloadstart.page', function(e) {
 		$('#colorbox, #cboxOverlay').remove();
    });
 })
 		</script>
 	</body>
 </html>


 <?php
 }
 else
 {
     header("Location: index.php");
 }
 ?>
