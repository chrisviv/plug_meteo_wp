<?php //config of plugin

//Base de données
define('DB_HOST', 'localhost');   //Adresse du serveur de BD
define('DB_NAME', 'clients');     //Nom de la BD
define('DB_CHARSET', 'utf8');     //Encodage de la connexion BD
define('DB_PORT', '3306');        //3306 port par défaut MySQL
define('DB_USER', 'votre-login');
define('DB_PASS', 'votre-mot-de-passe-secret');
 
//Date et heure
date_default_timezone_set('Europe/Zurich');
setlocale(LC_TIME, 'fr_FR', 'fra');