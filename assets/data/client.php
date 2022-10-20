<?php
/**
 * Fonction qui retourne la "liste" des clients 
 * sous forme de tableau associatif
 * en fonction des paramètres passés lors de l'appel
 *
 * Cette fonction perment de :
 *  - rechercher un client (chaine trouvée dans nom ou prénom)
 *  - définir le tri
 *  - définir le nombre de clients a retourner
 *
 * @param string $s     chaine de recherche dans le nom ou prénom
 * @param string $tri   tri nom et prénom ASC par défaut
 * @param int $limit    nombre de clients à afficher, 30 par défaut
 * @return array|bool   tablau associatif de clients ou tableau vide
 */
function getClient($s='' ,$tri= 'client_nom ASC,
    client_prenom ASC', $limit = 30
){
    global $db;
 
    //Préparation et envoi de la requête de sélection
    try {
        $sql = "SELECT client_nom, client_prenom, client_genre "
            . "FROM clients.client "
            . "WHERE (client_nom LIKE :q OR client_prenom LIKE :q) "
            . "ORDER BY $tri "
            . "LIMIT :limit";
 
 
        //Préparation de la requête
        $req = $db->prepare($sql);
 
        //Passage des paramètres à la requête
        $req->bindValue('q', '%'.$s.'%');
        $req->bindParam('limit', $limit, PDO::PARAM_INT);
 
        //Exécution de la requête
        $req->execute();
 
        //Retourne les résultats sous forme de tableau associatif
        return $req->fetchAll();
 
    }
    catch(Exception $e)
    {
        //A améliorer
        //echo $e->getMessage()."<br>";
        //echo $e->getFile()."<br>";
        //echo $e->getLine()."<br>";
        return [];
    }
}