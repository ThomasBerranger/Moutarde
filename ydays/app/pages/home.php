<?php
/**
 * Je suis la page d'accueil, je dois afficher un formulaire et je dois traiter
 * le/les fichiers uploadés
 */

// L'utilisateur a envoyé l'image
global $user;
?>
    <?php
                    if ($user->isConnected()) {
                        print('<a type="button" href="logout">Déconnexion</a>');
                        print('</br>    <a type=button" href="user">user</a>');
                    } else {
                        print('<a type="button" href="login">Connexion / Inscription</a>');
                    }?>