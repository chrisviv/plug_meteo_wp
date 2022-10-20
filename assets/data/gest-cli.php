<?php
/*
Plugin Name: Gestion des clients
*/
 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/client.php';
 
/* shortcode qui affiche la liste des clients
 * Possède un attribut "s" qui recherche l'existance
 * d'une chaine dans le nom ou le prénom
 *
 * [clients s="jean"]
 */
function gest_cli_clients_shortcode($atts) {
    //Récupéation de l'attribut "search
    //Recherche dans nom ou prénom
    $s = isset($atts['s']) ? $atts['s'] : '';
 
    //Récupère le tableau des clients
    $clients = getClient($s);
 
    //Si pas de clients on retourne un message d'info
    if(empty($clients)){
       return "<p>Aucun client trouvé !</p>";
    }
 
    //Constuction de la sortie HTML, <ul>
    $html = '<ul id="clients">';
    //Parcours et ajoute un <li> par client avec nom et prénom
    foreach ($clients as $client) {
        $html .= '<li>' . $client['client_prenom'] . ' '
               . $client['client_nom'] . '</li>';
    }
    //Fermeture de la liste </ul>
    $html .= '</ul>';
 
    //Retourne le code HTML du shortcode
    return $html;
}
 
//Enregistre les shortcodes du plugin
function gest_cli_register_shortcode() {
    add_shortcode( 'clients', 'gest_cli_clients_shortcode' );
}
add_action( 'init', 'gest_cli_register_shortcode' );