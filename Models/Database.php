<?php

abstract class Database {   

    public function connect()  // fonction de connexion à la base 
    {

        try 
        {   global $wpdb;
            $servername = $wpdb->dbhost;
            $username = $wpdb->dbuser;
            $password = $wpdb->dbpassword;
            $dbname = $wpdb->dbname;
            $port = $wpdb->dbport;
           
            $bdd = new PDO("mysql:host=$servername;port=$port;dbname=$dbname",$username, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
            echo 'connexion réussie';


        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
        //on ferme la connexion
        // $db = null;
    }
}

