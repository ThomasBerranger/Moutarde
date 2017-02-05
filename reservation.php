<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

if(isset($_SESSION['id']))
{

    $requser = $bdd->prepare('SELECT * FROM membres WHERE id=?');
    $requser->execute(array($_SESSION['id']));
    $userinfo = $requser->fetch();

    $reservations = $bdd->query("SELECT * FROM bretagne_nord_reservation"); //Récupère toutes les infos pour afficher les reservations bretagne nord

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

        if(!empty($_POST['date']) AND !empty($_POST['duree']) AND !empty($_POST['nb_personne']) AND !empty($_POST['niveau']) AND !empty($_POST['nom']) AND !empty($_POST['mailres']) AND !empty($_POST['num_res']))
        {

            $dureelenght = strlen($duree);
            $nb_personnelenght = strlen($nb_personne);
            $nomlenght = strlen($nom);

            if($dureelenght <= 100)
            {
                if($nb_personne <= 10)
                {
                    if($nomlenght <= 50)
                    {
                    $i=0;
                    while ($i!=$duree) {
                      $insertbretagne_nord_reservation = $bdd->prepare("INSERT INTO `bretagne_nord_reservation` (`id`, `date`, `duree`, `nb_personne`, `niveau`, `nom`, `mail`, `num_res`, `verif_unique`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);");
                      $insertbretagne_nord_reservation->execute(array($date, $duree, $nb_personne, $niveau, $nom, $mailres, $num_res, $verif_unique));
                      $i++;
                      $verif_unique++;
                      $date = date('Y-m-d', strtotime("$date +1 day"));
                      $erreur = "GG";
                    }
                  }
                  else
                  {
                      $erreur ="Ce nom est trop long !";
                  }
                }
                else
                {
                    $erreur = "Le nobre de personnes inscrites ne peut dépasser 10.";
                }
            }
            else
            {
                $erreur = "La durée de votre séjours ne peut exéder 100 jours !";
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

      $deletebretagne_nord_reservation = $bdd->prepare('DELETE FROM `bretagne_nord_reservation` WHERE `num_res` = ?');
      $deletebretagne_nord_reservation->execute(array($nb_reservation));
    }




    ?>
    <html>


    <head>
        <title>Espace administrateur :</title>
        <meta charset="utf-8">
    </head>
    <body>
    <div align="center">
        <h1>Espace Administrateur :</h1>
        <br>
        <br>

          <div class="col-md-12">
            <h2 align="center" >Les reservations : </h2>
            <br>
            <?php
            $numero_reservation = 1;
            $verif_unique = 1;
            while($donnees = $reservations->fetch())
            {
              ?>
              <div class="col-md-12" align="left"><h2><?php echo
                "Réservation n°".$donnees['num_res'], " | ",
                "M/Mme : ",$donnees['nom'], " | ";
                $date = strtotime("+0 day", strtotime($donnees['date']));
                echo "Commence le  ",date("d-m-Y", $date),
                " et dure ", $donnees['duree'], " jour(s) | ",
                "Nombre de personnes : " ,$donnees['nb_personne'], " | ",
                "Mail : " ,$donnees['mail'], " | ",
                "Niveau : ", $donnees['niveau'],
                " ||| Verification de l'unicité : ", $donnees['verif_unique'];
                if ($numero_reservation == $donnees['num_res']) {
                  $numero_reservation ++;
                }
                if ($verif_unique == $donnees['verif_unique']) {
                  $verif_unique ++;
                }
                ?></h2></div>
            <?php
            }
            ?>
          </div>

        <h2>Inscritpion :</h2>
        <br />
        <form method="POST" action="">

            <table>
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
                        <label for="duree">Duree de séjours :</label>
                    </td>
                    <td>
                        <input type="number" placeholder="La durée" name="duree"/>
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
                            <option value="Debutant">Debutant</option>
                            <option value="Moyen">Moyen</option>
                            <option value="Expert">Expert</option>
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

                <tr  style="display:none;">
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
                        <input type="submit" value="Je réserve !" name="formreservation">
                        <a href="deconnexion.php">Se déconnecter</a>
                        <a href="calendrier.php">Voir calendrier</a>
                    </td>
                </tr>
            </table>


            <?php if(isset($erreur)){ echo $erreur; } ?>








<br>
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
                        <input type="submit" value="Supprimer" name="form_delete_reservation">
                    </td>
                </tr>
            </table>


            <?php
            if(isset($erreur))
            {
                echo $erreur;

            }
            ?>
        </form>
    </div>
    </body>
    </html>

<?php
}
else
{
header("Location: index.php");
}
?>
