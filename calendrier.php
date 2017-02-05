<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?'); // Récupère les infos de l'utilisateur connecté
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    $reservation_bretagne_nord = $bdd->query("SELECT * FROM bretagne_nord_reservation");


?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Calendrier</title>
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>

<?php
require('date.php');
require('config.php');
$date = new Date();
$year = date('Y');
$dates = $date->getAll($year);
$nom = $date->getNom($year);
$num_reservation = $date->getNum_res($year);
$nb_personne = $date->getNb_personne($year);
?>


<?php if ($userinfo['prenom'] == 'admin' and $userinfo['nom'] == 'admin' and $userinfo['mail'] == 'admin@gmail.com') {?>
    <h1>Vous êtes bien connecté en tant qu'administrateur.</h1>

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

        <div class="col-xs-0 col-sm-0 col-md-2"></div>
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
                          <?php if($time == strtotime(date('Y-m-d'))): ?> class="today" <?php endif; // Met en évidence quel jours somme nous
                          $verif_nb_personne = 0;
                          if (isset($num_reservation[$time])) //Grosse boucle permettant d'afficher une couleur en fonction du nombre de personne inscrites
                          {
                          foreach ($num_reservation[$time] as $e):
                          reset($reservation_bretagne_nord);
                          $reservation_bretagne_nord = $bdd->query("SELECT * FROM bretagne_nord_reservation");
                          while ($donnees = $reservation_bretagne_nord->fetch()) {
                            if ($e == $donnees['num_res']): ?>
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
                            <?php if (isset($num_reservation[$time]))
                            {
                            foreach ($num_reservation[$time] as $e):
                            reset($reservation_bretagne_nord);
                            $reservation_bretagne_nord = $bdd->query("SELECT * FROM bretagne_nord_reservation");
                            while ($donnees = $reservation_bretagne_nord->fetch()) {
                              if ($e == $donnees['num_res']): ?>
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


<!---------------------------------------------------------- Utilisateur ---------------------------------------------------------------------->

<?php } else { ?>
<h1>Vous êtes connecté en tant qu'utilisateur.<h1>

    <br>

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

        <div class="col-xs-0 col-sm-2 col-md-4"></div>
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
                            <td colspan="<?php echo $w-1; ?>" class="padding"></td>
                        <?php endif; ?>
                        <td
                        <?php if($time == strtotime(date('Y-m-d'))): ?> class="today" <?php endif;

                          $verif_nb_personne = 0;
                          if (isset($num_reservation[$time]))
                          {
                          foreach ($num_reservation[$time] as $e):
                          reset($reservation_bretagne_nord);
                          $reservation_bretagne_nord = $bdd->query("SELECT * FROM bretagne_nord_reservation");
                          while ($donnees = $reservation_bretagne_nord->fetch()) {
                            if ($e == $donnees['num_res']): ?>
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

<?php } ?>


<?php
if($userinfo['id'] == $_SESSION['id'])
{
    ?>
    <div class="col-md-12">
      <br><br>
    <a href="edit_profil.php">Editer son profil</a><a> | </a>
    <a href="deconnexion.php">Se déconnecter</a>
    <?php if ($userinfo['prenom'] == 'admin' and $userinfo['nom'] == 'admin' and $userinfo['mail'] == 'admin@gmail.com'):?>
    <a> | </a><a href="reservation.php">Modifier les reservation</a>
    <?php endif; ?>
      <br><br>
    </div>
    <?php
}
?>

</body>
</html>

<?php
}
else
{
    header("Location: index.php");
}
?>
