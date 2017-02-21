    # Le dossier www
Le dossier www situé à la racine du projet est le dossier sur lequel apache pointe
Voici un exemple du fichier de configuration apache pour le port https:443
```
[...]
<VirtualHost *:443>
    DocumentRoot "C:/Users/rufol/Documents/Git/Github/Developpement_Web-PHP_Projet/www/"
    ServerName "main-serveur"
    SSLEngine on
    SSLCertificateKeyFile "{APACHEPATH}/certificats/main-server.com.key"
    SSLCertificateFile "{APACHEPATH}/certificats/main-server.com.cert"
    [...]
    <Directory "C:/Users/rufol/Documents/Git/Github/Developpement_Web-PHP_Projet/www/">
        AllowOverride All
        Options FollowSymLinks Indexes 
        {ONLINE_MODE}
    </Directory>
</VirtualHost>
[...]
```

Ainsi les fichier applicatif ne sont pas disponibles depuis le web, il n'est pas possible de lister les autres dossier car
ces derniers ne sont pas disponible via apache.