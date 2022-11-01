<?php 
//session_start();


class Data extends Database {

    public function installBdd(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
            $sq=" CREATE TABLE communes(id INT(6) AUTO_INCREMENT,code INT(6),nom VARCHAR(45),PRIMARY KEY(id))$charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/plugin_meteo.php' );
            dbDelta( $sql );
    }
        
    // public function getAllCommunes() {
                //global $wpdb;
    //             CREATE TABLE communes(id INT(6) AUTO_INCREMENT,code INT(6),nom VARCHAR(45),PRIMARY KEY(id);
    //             $datas = $this->connect()->prepare("SELECT * FROM communes");
    //             $datas->execute();
    //             $allDatas = $datas->fetchAll(); 
    //             return $allDatas;
    //         }
            
    // public function insertCommunes($code, $nom){
    //             $ajouter = $this->connect()->prepare('INSERT INTO communes ( code, nom) VALUES (:code, :nom)');
    //             $ajouter->bindParam(':code', $code); 
    //             $ajouter->bindParam(':nom', $nom);
    //             $ajouter->execute(); 
    //             $ajouter->debugDumpParams();
                
    //             $result = $ajouter->execute();
    //             $result->debugDumpParams();
               
    //         }
    // public function getAllShortCode(){
    //             $requete ="CREATE TABLE shortcode(ID INT(6) AUTO_INCREMENT,shortcode VARCHAR(45),PRIMARY KEY(ID))";
    //             $datas = $this->connect()->prepare("SELECT * FROM shortcode");
    //             $datas->execute();
    //             $allDatas = $datas->fetchAll(); 
    //             return $allDatas;
    //         }
    
    // public function insertShortCode($code, $nom){
    //             $ajouter = $this->connect()->prepare('INSERT INTO  ( code, nom) VALUES (:code, :nom)');
    //             $ajouter->bindParam(':code', $code); 
    //             $ajouter->bindParam(':nom', $nom);
    //             $ajouter->execute(); 
    //             $ajouter->debugDumpParams();
                
    //            $result = $ajouter->execute();
    //             $result->debugDumpParams();
               
    //         }
    
    }
