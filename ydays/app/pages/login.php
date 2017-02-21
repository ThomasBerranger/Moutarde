<?php
/**
 * Je suis la page de connexion, je dois afficher un formulaire et inscrire/
 * connecter les utilisateurs selon les infos renseignés
 */

global $user;
// On regarde si il est connecté
if ($user->isConnected()) {
    header('Location: /');
    exit;
}

if (isset($_POST)) {
    if (!empty($_POST)) {
        // on reçoit des données
        if (isset($_POST['email']) && isset($_POST['mdp'])) {
            // on peut se connecter
            
            try {
                if (!$user->login($_POST['email'], $_POST['mdp'])) {
                    // print('mauvais mdp');
                    print ('mauvais mot de passe');
                } else {
                    // on redirige ensuite vers la page d'accueil
                    header('Location: /');
                }
            } catch (Exception $e) {
                // l'email n'est pas dans la base de donnée, on créé donc un user (car colonne email type unique)
                if ($user->new($_POST['email'], $_POST['mdp'])) {
                    // si l'inscription est true on le connecte d'office
                    $user->login($_POST['email'], $_POST['mdp']);
                    header('Location: /'); // et oui c'était juste ça
                }
            }
        }
    }
}
// dans les autres cas on affiche le formulaire
?>
    <!DOCTYPE html>
    <html>

    <body>
        <form method="POST" id="login">
            <div>
                <input name="email" type="email" required <?php if (isset($error)) { print( ' value="' . htmlspecialchars($_POST[ 'email']) . ''); } else { print( 'autofocus'); } ?>>
                <label>Email</label>
            </div>
            <div>
                <input name="mdp" type="password" required<?php if (isset($error)) { print( ' autofocus placeholder="Mauvais mot de passe"'); } 
            if (isset($error)) {
                print(' bar_error');
            }
            ?>"></span>
                <label<?php if (isset($error)) { print( ' class="label_error"'); } ?>>Password</label>
            </div>
            <button type="submit">Login </button>
        </form>
    </body>

    </html>