<?php
session_start();

require('connection.php');

if(isset($_SESSION['id']))
{

   $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
   $requser->execute(array($_SESSION['id']));
   $userinfo = $requser->fetch();

     $reservation = $bdd->query("SELECT * FROM reservations"); //Récupère toutes les infos pour afficher les reservations

     $verif_unique = 0;

     $numero_reservation = 1;
     $verif_unique = 1;
     while($donnees = $reservation->fetch())
     {
       if ($numero_reservation <= $donnees['num_res'])
       {
         $numero_reservation = $donnees['num_res'] + 1;
       }
       if ($verif_unique <= $donnees['verif_unique'])
       {
         $verif_unique = $donnees['verif_unique'] +1;
       }
     }

    if(isset($_POST['formreservation']))
    {

        $date = date($_POST['date']);
        $duree = intval($_POST['duree']);
        $num_res = intval($_POST['num_res']);
        $verif_unique = intval($_POST['verif_unique']);
        $nb_personne = intval($_POST['nb_personne']);
        $niveau = htmlspecialchars($_POST['niveau']);
        $nom = htmlspecialchars($_POST['nom']);
        $mailres = htmlspecialchars($_POST['mailres']);
        $destination = htmlspecialchars($_POST['destination']);
        $prix = intval($_POST['prix']);

        if(!empty($_POST['date']) AND !empty($_POST['duree']) AND !empty($_POST['nb_personne']) AND !empty($_POST['niveau']) AND !empty($_POST['nom']) AND !empty($_POST['mailres']) AND !empty($_POST['num_res']))
        {

            $dureelenght = strlen($duree);
            $nb_personnelenght = strlen($nb_personne);
            $nomlenght = strlen($nom);

            if($dureelenght <= 100 && $duree >= 0)
            {
                if($nb_personne <= 10)
                {
                    if($nomlenght <= 50)
                    {
                      if($prix >= 0)
                      {

                      $i=0;
                      while ($i!=$duree) {
                        $insertreservation = $bdd->prepare("INSERT INTO `reservations` (`id`, `date`, `duree`, `nb_personne`, `niveau`, `nom`, `mail`, `num_res`, `verif_unique`, `prix`, `destination`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                        $insertreservation->execute(array($date, $duree, $nb_personne, $niveau, $nom, $mailres, $num_res, $verif_unique, $prix, $destination));
                        $i++;
                        $verif_unique++;
                        $date = date('Y-m-d', strtotime("$date +1 day"));
                      }
                      $redirec = "Location: calendrier_b_n.php?id="?><?php echo $_SESSION['id'] ?><?php
                      header($redirec);

                    }
                    else
                    {
                      $erreur = "Le prix doit être supérieur à 0.";
                    }
                  }
                  else
                  {
                      $erreur ="Ce nom est trop long.";
                  }
                }
                else
                {
                    $erreur = "Le nobre de personnes inscrites ne peut dépasser 10.";
                }
            }
            else
            {
                $erreur = "La durée de votre séjour ne peut exéder 100 jours et doit être supérieure à 0.";
            }
        }
        else
        {
            $erreur = "Vous devez tout remplir !";
        }
    }



    if(isset($_POST['form_delete_reservation']))
    {

      $nb_reservation = intval($_POST['nb_reservation']);

      $delete_reservations = $bdd->prepare('DELETE FROM `reservations` WHERE `num_res` = ?');
      $delete_reservations->execute(array($nb_reservation));

     $redirec = "Location: calendrier_b_n.php?id="?><?php echo $_SESSION['id'] ?><?php
     header($redirec);

    }
    ?>

 <!DOCTYPE html>
 <html lang="en">
     <head>
         <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
         <meta charset="utf-8" />
         <title>Tableau utilisateur</title>

         <meta name="description" content="Static &amp; Dynamic Tables" />
         <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

         <!-- bootstrap & fontawesome -->
         <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
         <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

         <!-- page specific plugin styles -->

         <!-- text fonts -->
         <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

         <!-- ace styles -->
         <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
         <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
         <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

         <!-- ace settings handler -->
         <script src="assets/js/ace-extra.min.js"></script>

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

         <!-- ---------------------------------------------------------- NAVBAR GAUCHE ---------------------------------------------------------------------------------->

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

                     <li class="active open">
                         <a href="#" class="dropdown-toggle">
                             <i class="menu-icon fa fa-pencil-square-o"></i>
                             <span class="menu-text"> Formulaires </span>

                             <b class="arrow fa fa-angle-down"></b>
                         </a>

                         <b class="arrow"></b>

                         <ul class="submenu">
                             <li class="active">
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

                 <!-- ------------------------------------------------------------------- CONTENU -------------------------------------------------------------------->

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
                                 <a href="#">Acceuil</a>
                             </li>

                             <li>
                                 <a href="#">Formulaires</a>
                             </li>
                             <li class="active">Ajout / Suppression de réservation</li>
                         </ul><!-- /.breadcrumb -->
                     </div>

                     <div class="page-content">


                         <div class="page-header">
                             <h1>
                                 Ajout / Suppression de réservation
                             </h1>
                         </div><!-- /.page-header -->

                         <div class="row">
                             <div class="col-xs-12">
                                 <!-- PAGE CONTENT BEGINS -->
                                 <div align="center" class="col-md-6">
                                     <h2>Ajouter une reservation : </h2>
                                     <br>


                                 <form method="POST" action="">
                                     <table>
                                       <tr>
                                           <td align="right">
                                               <label for="destination">Destination :</label>
                                           </td>
                                           <td>
                                               <select title="La destination choisie" name="destination">
                                                   <option value="Bretagne du nord">Bretagne du nord</option>
                                                   <option value="Bretagne du sud">Bretagne du sud</option>
                                                   <option value="Franche-Comte">Franche-Comte</option>
                                               </select>
                                           </td>
                                       </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="date">Date de début :</label>
                                             </td>
                                             <td>
                                                 <input type="date" placeholder="" name="date" />
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="duree">Duree de séjour :</label>
                                             </td>
                                             <td>
                                                 <input type="number" placeholder="La durée" name="duree"/>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="prix">Prix du séjour :</label>
                                             </td>
                                             <td>
                                                 <input type="number" placeholder="Le prix" name="prix"/>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="nb_personne">Nombre de personne :</label>
                                             </td>
                                             <td>
                                                 <select title="Le nombre de personnes dans le groupe" name="nb_personne">
                                                     <option value="1">1</option>
                                                     <option value="2">2</option>
                                                     <option value="3">3</option>
                                                     <option value="4">4</option>
                                                     <option value="5">5</option>
                                                     <option value="6">6</option>
                                                     <option value="7">7</option>
                                                     <option value="8">8</option>
                                                     <option value="9">9</option>
                                                     <option value="10">10</option>
                                                 </select>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="niveau">Niveau du groupe :</label>
                                             </td>
                                             <td>
                                                 <select title="Le niveau du groupe" name="niveau">
                                                     <option value="Debutant">débutant</option>
                                                     <option value="Moyen">intermédiaire</option>
                                                     <option value="Expert">expert</option>
                                                 </select>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="nom">Nom du réservateur :</label>
                                             </td>
                                             <td>
                                                 <input type="text" placeholder="Le nom du reservateur" name="nom"/>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="mailres">Mail du réservateur :</label>
                                             </td>
                                             <td>
                                                 <input type="text" placeholder="L'adresse mail @" name="mailres"/>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td align="right">
                                                 <label for="num_res">Numéro de réservation :</label>
                                             </td>
                                             <td>
                                                 <input type="number" value="<?php echo $numero_reservation; ?>" name="num_res" readonly>
                                             </td>
                                         </tr>
                                         <tr style="display:none;">
                                             <td align="right">
                                                 <label for="verif_unique">Verification de l'unicitée :</label>
                                             </td>
                                             <td>
                                                 <input type="number" value="<?php echo $verif_unique; ?>" name="verif_unique" readonly>
                                             </td>
                                         </tr>

                                         <tr>
                                             <td></td>
                                             <td>
                                                 <br>
                                                 <input type="submit" class="btn btn-success" value="Je réserve !" name="formreservation">
                                             </td>
                                         </tr>
                                     </table>
                                     <?php if(isset($erreur)){ echo $erreur; } ?>
                                     </form>
                                     </div>



                                     <div align="center" class="col-md-6">
                                     <h2 align="center" >Supprimer une reservation : </h2>
                                     <form method="POST" action="">
                                         <table>
                                             <tr>
                                                 <td align="right">
                                                     <label for="duree">Numéo de la réservation :</label>
                                                 </td>
                                                 <td>
                                                     <input type="number" name="nb_reservation"/>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td></td>
                                                 <td>
                                                     <br>
                                                     <input type="submit" class="btn btn-danger" value="Supprimer" name="form_delete_reservation">
                                                 </td>
                                             </tr>
                                         </table>
                                         <?php
                                         if(isset($erreur2))
                                         {
                                         echo $erreur2;

                                         }
                                         ?>
                                     </form>
                                     </div>



                             </div><!-- /.modal-content -->
                         </div><!-- /.modal-dialog -->
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
                 <span class="blue bolder">French Motor Trip</span>
                 &copy; 2016 - 2017
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
 <script src="assets/js/jquery.dataTables.min.js"></script>
 <script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
 <script src="assets/js/dataTables.buttons.min.js"></script>
 <script src="assets/js/buttons.flash.min.js"></script>
 <script src="assets/js/buttons.html5.min.js"></script>
 <script src="assets/js/buttons.print.min.js"></script>
 <script src="assets/js/buttons.colVis.min.js"></script>
 <script src="assets/js/dataTables.select.min.js"></script>

 <!-- ace scripts -->
 <script src="assets/js/ace-elements.min.js"></script>
 <script src="assets/js/ace.min.js"></script>

 <!-- inline scripts related to this page -->
 <script type="text/javascript">
     jQuery(function($) {
         //initiate dataTables plugin
         var myTable =
             $('#dynamic-table')
         //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
         .DataTable( {
             bAutoWidth: false,
             "aoColumns": [
                 { "bSortable": false },
                 null, null,null, null, null,
                 { "bSortable": false }
             ],
             "aaSorting": [],


             //"bProcessing": true,
             //"bServerSide": true,
             //"sAjaxSource": "http://127.0.0.1/table.php"	,

             //,
             //"sScrollY": "200px",
             //"bPaginate": false,

             //"sScrollX": "100%",
             //"sScrollXInner": "120%",
             //"bScrollCollapse": true,
             //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
             //you may want to wrap the table inside a "div.dataTables_borderWrap" element

             //"iDisplayLength": 50


             select: {
                 style: 'multi'
             }
         } );



         $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

         new $.fn.dataTable.Buttons( myTable, {
             buttons: [
                 {
                     "extend": "colvis",
                     "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                     "className": "btn btn-white btn-primary btn-bold",
                     columns: ':not(:first):not(:last)'
                 },
                 {
                     "extend": "copy",
                     "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                     "className": "btn btn-white btn-primary btn-bold"
                 },
                 {
                     "extend": "csv",
                     "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                     "className": "btn btn-white btn-primary btn-bold"
                 },
                 {
                     "extend": "excel",
                     "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                     "className": "btn btn-white btn-primary btn-bold"
                 },
                 {
                     "extend": "pdf",
                     "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                     "className": "btn btn-white btn-primary btn-bold"
                 },
                 {
                     "extend": "print",
                     "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                     "className": "btn btn-white btn-primary btn-bold",
                     autoPrint: false,
                     message: 'This print was produced using the Print button for DataTables'
                 }
             ]
         } );
         myTable.buttons().container().appendTo( $('.tableTools-container') );

         //style the message box
         var defaultCopyAction = myTable.button(1).action();
         myTable.button(1).action(function (e, dt, button, config) {
             defaultCopyAction(e, dt, button, config);
             $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
         });


         var defaultColvisAction = myTable.button(0).action();
         myTable.button(0).action(function (e, dt, button, config) {

             defaultColvisAction(e, dt, button, config);


             if($('.dt-button-collection > .dropdown-menu').length == 0) {
                 $('.dt-button-collection')
                     .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                     .find('a').attr('href', '#').wrap("<li />")
             }
             $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
         });

         ////

         setTimeout(function() {
             $($('.tableTools-container')).find('a.dt-button').each(function() {
                 var div = $(this).find(' > div').first();
                 if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
                 else $(this).tooltip({container: 'body', title: $(this).text()});
             });
         }, 500);





         myTable.on( 'select', function ( e, dt, type, index ) {
             if ( type === 'row' ) {
                 $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
             }
         } );
         myTable.on( 'deselect', function ( e, dt, type, index ) {
             if ( type === 'row' ) {
                 $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
             }
         } );




         /////////////////////////////////
         //table checkboxes
         $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

         //select/deselect all rows according to table header checkbox
         $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
             var th_checked = this.checked;//checkbox inside "TH" table header

             $('#dynamic-table').find('tbody > tr').each(function(){
                 var row = this;
                 if(th_checked) myTable.row(row).select();
                 else  myTable.row(row).deselect();
             });
         });

         //select/deselect a row when the checkbox is checked/unchecked
         $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
             var row = $(this).closest('tr').get(0);
             if(this.checked) myTable.row(row).deselect();
             else myTable.row(row).select();
         });



         $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
             e.stopImmediatePropagation();
             e.stopPropagation();
             e.preventDefault();
         });



         //And for the first simple table, which doesn't have TableTools or dataTables
         //select/deselect all rows according to table header checkbox
         var active_class = 'active';
         $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
             var th_checked = this.checked;//checkbox inside "TH" table header

             $(this).closest('table').find('tbody > tr').each(function(){
                 var row = this;
                 if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                 else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
             });
         });

         //select/deselect a row when the checkbox is checked/unchecked
         $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
             var $row = $(this).closest('tr');
             if($row.is('.detail-row ')) return;
             if(this.checked) $row.addClass(active_class);
             else $row.removeClass(active_class);
         });



         /********************************/
         //add tooltip for small view action buttons in dropdown menu
         $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

         //tooltip placement on right or left
         function tooltip_placement(context, source) {
             var $source = $(source);
             var $parent = $source.closest('table')
             var off1 = $parent.offset();
             var w1 = $parent.width();

             var off2 = $source.offset();
             //var w2 = $source.width();

             if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
             return 'left';
         }




         /***************/
         $('.show-details-btn').on('click', function(e) {
             e.preventDefault();
             $(this).closest('tr').next().toggleClass('open');
             $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
         });
         /***************/





         /**
 				//add horizontal scrollbars to a simple table
 				$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
 				  {
 					horizontal: true,
 					styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
 					size: 2000,
 					mouseWheelLock: true
 				  }
 				).css('padding-top', '12px');
 				*/


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
