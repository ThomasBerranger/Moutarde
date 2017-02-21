<?php
/**
 * Je suis la page d'accueil, je dois afficher un formulaire et je dois traiter
 * le/les fichiers uploadés
 */

global $user;
if ($user->isConnected()) {
    // alors on affiche un simple "bonjour M. X, puis un lien vers son profile
    // ben c'est bien
    $result = $user->logout();
}
header('Location: /');
exit;
