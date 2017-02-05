<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=ydays_membre', 'root', '');

$reservations = $bdd->query("SELECT * FROM bretagne_nord_reservation"); //Récupère toutes les infos pour afficher les reservations bretagne nord

if(isset($_POST['formreservation']))
{

    $date = date($_POST['date']);
    $duree = intval($_POST['duree']);
    $nb_personne = intval($_POST['nb_personne']);
    $niveau = htmlspecialchars($_POST['niveau']);
    $nom = htmlspecialchars($_POST['nom']);

    if(!empty($_POST['date']) AND !empty($_POST['duree']) AND !empty($_POST['nb_personne']) AND !empty($_POST['niveau']) AND !empty($_POST['nom']))
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
                        $insertbretagne_nord_reservation = $bdd->prepare("INSERT INTO `bretagne_nord_reservation` (`id`, `date`, `duree`, `nb_personne`, `niveau`, `nom`) VALUES (NULL, ?, ?, ?, ?, ?);");
                        $insertbretagne_nord_reservation->execute(array($date, $duree, $nb_personne, $niveau, $nom));
                        $erreur = "Votre réservation a bien été enregistrée !";
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
                    <input type="text" placeholder="Votre nom" name="nom"/>
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <br>
                    <input type="submit" value="Je réserve !" name="formreservation">
                    <a href="connexion.php">Connexion</a>
                    <a href="calendrier_adapte.php">Voir calendrier</a>
                </td>
            </tr>

        </table>


        <?php

        if(isset($erreur))
        {
            echo $erreur;

        }

        ?>

        <br>
        <div class="col-md-12">
            <h2 align="center" >Les reservations : </h2>
            <br>
            <?php
            while($donnees = $reservations->fetch())
            {
                ?>
                <div class="col-md-12" align="left"><h2><?php echo
                  "Réservation n°".$donnees['id'], " | ",
                  "M/Mme : ",$donnees['nom'], " | ",
                  "Commence le  ", $donnees['date'],
                  " et dure ", $donnees['duree'], " jours | ",
                  "Nombre de personnes : " ,$donnees['nb_personne'], " | ",
                  "Mail du reservateur : " ,$donnees['mail'], " | ",
                  "Niveau du groupe : ", $donnees['niveau'];
                  ?></h2></div>
                <?php
            }
            ?>
        </div>

    </form>
</div>
</body>
</html>
