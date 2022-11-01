<?php
/**
 * @package Plugin_meteo
 * @version 1.0.0
 */
/*
Plugin Name: plugin_meteo
Plugin URI: LIEN VERS La page d'accueil du plugin 
Description: Une extension pour connaitre la météo du jour sur n'importe quel ville.
Version: 1.0
require PHP: 6.0
Author: Chris Vivancos
Author URI: LIEN VERS VOTRE PAGE D’ACCUEIL 
License: GPL 
*/

 // defined('ABSPATH') or die('Oups !');
/*
 **  Ajouter d'un nouveau menu à notre panel Admin
 */
// On attache l'action monLienAdmin à admin_menu
add_action('admin_menu', 'myPluginMeteo');

// Add a new top level menu link to the ACP
function myPluginMeteo()
{
    add_menu_page(
        'Plugin météo', // Titre de ma page
        'Plugin météo', // titre du menu qui va s'afficher
        'manage_options', // On a besoin de cette fonction afin de pouvoir arriver sur la bonne page quand on clique
        plugin_dir_path(__FILE__) . 'includes/plugin_page.php', // L'adresse de là ou l'on doit arriver quand on clique sur le lien
        '',
        'dashicons-cloud',
    );
}
?>


<?php 
// Le CURL c'est quoi?
// cURL est une bibliothèque qui vous permet de faire des requêtes HTTP en PHP. 

//Dans ce live Coding nous allons voir comment récupérer en php les informations issues d'une API et les stocker en base de données

//https://geo.api.gouv.fr/decoupage-administratif
//Traitement des données

//Dans un premier temps nous allons récuperer toutes les régions de france
// Tout d'abord il faut vérifier que la méthode CURL soit bien activé sur votre serveur.
// Pour vérifier cela vous pouvez interroger votre serveur grace à un phpinfo()

//phpinfo();
//die;

//Autoloader de Class 

spl_autoload_register(function ($class_name) {
include './class/'.$class_name . '.php';
});

// On utilisera principalement 4 méthodes
// curl_init : pour initialiser notre curl
// curl_exec : pour executer notre curl
// curl_error : pour récupérer l'erreur
// curl_close : pour fermer notre CURL

// POUR LA BASE DE DONNEE PARTIE COMMUNES

$curl = curl_init("https://geo.api.gouv.fr/communes");
//Alors si l'on ne lui spécifie rien le curl_exec lancera le CURL et affichera le résultat.
//Nous ce n'est pas totalement ce que nous souhaitons. 
//Nous allors grace a curl_setopt lui dire que nous souhaitons enregistrer le résultat de ce CURL dans une variable
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CAINFO, "C:\wamp64\www\wordpress\wp-content\plugins\plug_meteo_wp\geo-communes.pem");
$communes = curl_exec($curl);

//var_dump($communes);

if($communes === false){
    echo "<pre>";
    //Si jamais on récupère l'erreur et on la dump
    var_dump(curl_error($curl));
    echo "</pre>";
}
else{
    //Si tout est bon on va décoder le json, et on va dire true pour qu'il y ai un tableau associatif.
    $communes = json_decode($communes, true);

    
    if(isset($_GET['insertData'])){
        foreach ($communes as $commune) {
            $communeainserer = new Data;
            $communeainserer->insert($commune['code'], $commune['nom']);
        }
      
    }
    else{
        $communes = new Data;
        $datas = $communes->getAllCommunes();
        foreach ($datas as $commune) {
            echo "<li>".$commune['code']." - ".$commune['nom']."</li>";
        }
    }

}
//On termine en fermant la session CURL libérant ainsi la mémoire qui lui était associé
curl_close($curl);
?>

<a href="?insertData">Insérer les données</a>




/
























<!--  a tester le code after  -->

<!-- // add_action('wp_footer', 'meteo');
// add_filter('default_content', 'contenu_par_defaut');
// add_filter('the_content', 'insererApresContenu');
// add_shortcode('nouveauShortCode', 'gererShortCode');

// function insererApresContenu($content){
//             $content .= '<p>Activé votre plugin météo personnalisable !</p>';
//       return $content;
// }
//  function meteo(){
//      echo('<p>Plugin Meteo!</p>');
// }
// function gererShortCode(){
//      echo('<p>coucou je suis un shortcode </p>');
// }

//function contenu_par_defaut(){
//      return "Template par défaut
//      Titre1 ='Météo';
//      Titre 2
//     Contenu 
//      ";
// } -->


<?php
/* Shortcode – Google Maps Integration */
// function fn_googleMaps($atts, $content = null) {
//    extract(shortcode_atts(array(
//       "width" => 640,
//      "height" => 480,
//      "src" => ''
//   ), $atts));
//   return '<iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="' . $src . '&amp;output=embed"></iframe>';

// add_shortcode("googlemap", "fn_googleMaps") ;
?>


<!-- a modifier en fonction de ce qu'on veut  -->
    <!-- // function pp_add_promo($the_content){

    //     $promo = '<div class="promo">';
    //         $promo .= '<p>Vous voulez apprendre à créer un thème WordPress facilement ? <a href="https://www.tutowp.fr/comment-creer-un-theme-wordpress-facilement/">Suivez notre cours</a> !</p>';
    //     $promo .= '</div>';
    
    //     return $the_content.$promo;
    // }
    // add_filter('the_content', 'pp_add_promo');

    // function pp_style() {
    //     wp_enqueue_style('promopost', plugin_dir_url(__FILE__).'/promopost.css');
    // }
    // add_action('wp_enqueue_scripts', 'pp_style'); -->

