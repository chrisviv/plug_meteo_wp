<?php
//Variable globale qui contiendra l'objet PDO
$GLOBALS['db'];
//Tentative de connexion à la base de données
try {
    //Chaine de connexion, serveur, base, encodage, port, user, pw
    $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';'
                 .'charset='.DB_CHARSET.';port='.DB_PORT,
                  DB_USER, DB_PASS);
    //Active la gestion des erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    //Cacher les messages d'erreur en production.
    //Envoyer email ou fichier de log à la place
    echo $e->getMessage() . "<br>";
    echo $e->getFile() . "<br>";
    echo $e->getLine() . "<br>";
}