<?php
/**
 * Je suis la page d'accueil, je dois afficher un formulaire et je dois traiter
 * le/les fichiers uploadés
 */
global $user;

if (!$user->isConnected()) {
    // utilisateur non connecté, on redirige vers la page de connection/inscription
    // to do
    header('HTTP/1.0 403 Forbidden');
    sleep(2); // pour faire croire que on fait réfléchir le site
    header('Location: login'); // et on redirige sur la page de connexion/inscription
    exit;
}

// l'utilisateur est connecté
// on regarde si l'on a un email à modifier
if (isset($_POST)) {
    if (!empty($_POST)) {
        // on reçoit des données
        if (isset($_POST['email']) && isset($_POST['mdp'])) {
            if (!$user->editEmail(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['mdp']))) {
                // print('mauvais mdp');
                print('mauvais mot de passe ou email déjà en base</br>');
            } else {
                // on redirige ensuite vers la page d'accueil
                print('Vous avez bien modifié votre email !</br>');
            }
        }
    }
}
// on a besoin de l'url de l'image gravatar
$email = $user->getEmail();
?>
    <!DOCTYPE html>
    <html lang="en">

    <body> <span>Welcome,</span>
        <?= $email; ?>
            </br> <a href="/">home </a></br> <a href="/logout">disconnect </a>
            <form method="POST">
                <label for="email">Email </label>
                <input type="email" id="email" name="email" value="<?= $email; ?>"> </div>
                <label for="password">Mot de passe </label>
                <input id="password" type="password" name="mdp"> </div>
                <button type="submit">Modifier mon email</button>
            </form>
    </body>

    </html>