<?php
class Date{

    var $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    var $months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septempbre', 'Octobre', 'Novembre', 'Decembre');

    function getNom($year){
        global $DB;
        $req = $DB->query('SELECT id,nom,date FROM bretagne_nord_reservation WHERE YEAR(date)='.$year);
        $nom = array();
        while ($d  = $req->fetch(PDO::FETCH_OBJ))
        {
            $nom[strtotime($d->date)][$d->id] = $d->nom;
        }
        return $nom;
    }

    function getNum_res($year){
        global $DB;
        $req = $DB->query('SELECT id,num_res,date FROM bretagne_nord_reservation WHERE YEAR(date)='.$year);
        $num_res = array();
        while ($d  = $req->fetch(PDO::FETCH_OBJ))
        {
            $num_res[strtotime($d->date)][$d->id] = $d->num_res;
        }
        return $num_res;
    }

    function getNb_personne($year){
        global $DB;
        $req = $DB->query('SELECT id,nb_personne,date FROM bretagne_nord_reservation WHERE YEAR(date)='.$year);
        $nb_personne = array();
        while ($d  = $req->fetch(PDO::FETCH_OBJ))
        {
            $nb_personne[strtotime($d->date)][$d->id] = $d->nb_personne;
        }
        return $nb_personne;
    }




    function getAll($year){

        $tableaudate = array();

        $date = new DateTime($year.'-01-01');

        while($date->format('Y') <= $year)
        {
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));
            $tableaudate[$y][$m][$d] = $w;
            $date->add(new DateInterval('P1D'));
        }

        return $tableaudate;
    }
}