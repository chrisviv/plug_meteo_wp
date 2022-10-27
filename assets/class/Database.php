<?php

abstract class Database {

    public function connect() {

        
        $host = 'localhost';
        $dbname = 'wordpress';
        $port = 3306;
        $username = 'root';
        $password = '';
      

        try {
            $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8" ,$username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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


 


