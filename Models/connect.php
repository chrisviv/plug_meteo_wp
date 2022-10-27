<?php session_start();

function connect(){
    try {
        $db = new PDO('mysql:host=localhost;port=3306;charset=utf8', 'root', '');
        //echo 'ok';
        return $db;
        }
    catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }

   }
   