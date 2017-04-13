<?php

session_start();

require('connection.php');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    if ($userinfo['prenom']=="admin" && $userinfo['nom']=="admin") {

 ?>

 <!DOCTYPE html>
 <html lang="en">
 	<head>
 		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 		<meta charset="utf-8" />
 		<title>Galerie</title>

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
 	</head>

 	<body class="no-skin">
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

 					<li class="">
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
                  Bretagne du sud
                </a>

                <b class="arrow"></b>
              </li>
              <li class="">
                <a href="calendrier_f_c.php?id=<?php echo $_SESSION['id'] ?>">
                  <i class="menu-icon fa fa-caret-right"></i>
                  Franche-Comté
                </a>

                <b class="arrow"></b>
              </li>

            </ul>
 					</li>






 					<li class="active">
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
 							<li class="active">Galerie</li>
 						</ul><!-- /.breadcrumb -->

 					</div>

 					<div class="page-content">


 							<div class="page-header">
 									<h1>
 											Galerie
 									</h1>
 							</div><!-- /.page-header -->

 							<div class="row">
 									<div class="col-xs-12">
 											<!-- PAGE CONTENT BEGINS -->


 											<div class="row">
 													<div class="col-xs-12">
                            <!-- Page Content -->
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bretagne du nord
                </h1> </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="img/bretagnenord.jpg" alt="Bretagne du nord"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/bretagnenord/pa5.jpg" alt="Bretagne du nord"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/bretagnenord/pa4.jpg" alt="Bretagne du nord"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="img/harley.jpg" alt="Harley"> </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Franche-Comté
                </h1> </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive"  src="img/franchecomte.jpg"  alt="Franche comte"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/Franche-comte/pa2.jpg" alt="Franche comte"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/Franche-comte/pa.jpg" alt="Franche comte"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="img/harley2.jpg" alt="Harley"> </a>
            </div>
        </div>
        <!-- /.row -->
        <hr>
    <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Bretagne du sud
                </h1> </div>
        </div>
        <!-- /.row -->
        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="img/bretagnesud.jpg" alt="Bretagne du sud"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/bretagnesud/bresud.jpg" alt="Bretagne du sud"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="./img/bretagnesud/bresud2.jpg" alt="bretagne sud" alt="Bretagne du sud"> </a>
            </div>
            <div class="col-md-3 portfolio-item">
                <a href="#"> <img class="img-responsive" src="img/harley.jpg" alt="harley"> </a>
            </div>
        </div>
        <!-- /.row -->
        <hr> </div>
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
 							<span class="blue bolder">FrnchMotorTrip</span>
 							 &copy; 2017
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
 }
 else
 {
 header("Location: index.php");
 }
 ?>
