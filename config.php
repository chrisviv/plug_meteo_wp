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
require_once __DIR__ . '/Controllers/ControllersMeteoController.php';

 // defined('ABSPATH') or die('Oups !');

/*
 * Ajouter d'un nouveau menu à notre panel Admin
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


//Ici nous avons une fonction qui va ajouter une page si le plugin est activé
function initialisationPlugin()
{
    //création de la table dans la BDD
    global $wpbd;
    $servername = $wpdb->dbhost;
    $username = $wpdb->dbuser;
    $password = $wpdb->dbpassword;
    $dbname = $wpdb->dbname;
    $port = $wpdb->dbport;
    $conn = new PDO("mysql:host=$se rvername;port=$port;dbname=$dbname",$username, $password);
    $createConn = $conn->prepare("DESCRIBE `meteo`");
    if(!createConn->execute()){
        $sql = "CREATE TABLE meteo (
             id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            shortcode VARCHAR(30) NOT NULL,
            ressenti VARCHAR(30) NULL,
            tempmin VARCHAR(30) NULL,
            tempmax VARCHAR(30) NULL,
            humidite VARCHAR(30) NULL,
            nebulosite VARCHAR(30) NULL,
            vitessevent VARCHAR(30) NULL,
            visibilite VARCHAR(30) NULL,
            pecipitation VARCHAR(30) NULL
         )";
    }
        $sqlcommune = $conn->prepare("DESCRIBE `communes`");

        if (!$sqlcommune->execute()) {
            $sqlcommunes = "CREATE TABLE communes (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                code INT(6) NOT NULL,
                nom VARCHAR(30) NOT NULL
                )";
            $conn->exec($sql);
            $conn->exec($sqlcommunes);
    }

    //On crée une page qui va contenir la météo détaillé
    $weather_arr = array(
        'post_title'   => 'Météo',
        'post_content' => '[pagemeteo ville=""]',
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => get_current_user_id(),
    );

    wp_insert_post($weather_arr);

// Le CURL c'est quoi?
// cURL est une bibliothèque qui vous permet de faire des requêtes HTTP en PHP. 
//Dans ce live Coding nous allons voir comment récupérer en php les informations issues d'une API et les stocker en base de données
//https://geo.api.gouv.fr/decoupage-administratif
//Traitement des données
//Dans un premier temps nous allons récuperer toutes les régions de france
// Tout d'abord il faut vérifier que la méthode CURL soit bien activé sur votre serveur. Pour vérifier cela vous pouvez interroger votre serveur grace à un phpinfo()

//phpinfo();
//die;

//Autoloader de Class 
// spl_autoload_register(function ($class_name) {
// include './class/'.$class_name . '.php';
// });

// On utilisera principalement 4 méthodes
// curl_init : pour initialiser notre curl
// curl_exec : pour executer notre curl
// curl_error : pour récupérer l'erreur
// curl_close : pour fermer notre CURL

// POUR LA BASE DE DONNEE PARTIE COMMUNES
//hydratation des communes
$supprimer = $conn->prepare('Delete from communes');
$supprimer->execute();
$curl = curl_init("https://geo.api.gouv.fr/communes");
//Alors si l'on ne lui spécifie rien le curl_exec lancera le CURL et affichera le résultat.//Nous ce n'est pas totalement ce que nous souhaitons. 
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
            foreach ($communes as $commune) {
                $cp = implode(",", $commune['codesPostaux']);
                $ajouter = $conn->prepare('INSERT INTO communes (code, nom) VALUES (:code, :nom)');
                $ajouter->bindParam(':code', $cp);
                $ajouter->bindParam(':nom', $commune['nom']);
                $ajouter->execute();
                $ajouter->debugDumpParams();
            }
//On termine en fermant la session CURL libérant ainsi la mémoire qui lui était associé
curl_close($curl);

$conn = null;


}
register_activation_hook(__FILE__, 'initialisationPlugin');

//Ici nous avons une fonction qui va supprimer une page si le plugin est désactivé
function myplugin_deactivate()
{
    //Ici on récup_re l'id de la page que l'on a créé
    $score_arr = get_page_by_title('Météo');
    wp_delete_post($score_arr->ID, true);
}


register_deactivation_hook(__FILE__, 'myplugin_deactivate');

/**
 * Généation de la fonction pour traiter un shortcode en fonction d'une ville sélectionnée
 *
 * @param  mixed $ville
 * @return string
 */
function shortcode_showWeather($ville)
{
    $s = isset($ville['ville']) ? $ville['ville'] : '';
    $view =  getWeather($s);
    return $view;
}
add_shortcode('meteo', 'shortcode_showWeather');


/**
 * Généation de la fonction pour traiter un shortcode en fonction d'une ville sélectionnée
 *
 * @param  mixed $ville
 * @return string
 */
function shortcode_showWeatherPage($ville, $ressenti)
{
    $s = isset($ville['ville']) ? $ville['ville'] : '';
    $views =  getWeatherPage($s, $ressenti);
    return $views;
   
}
add_shortcode('pagemeteo', 'shortcode_showWeatherPage');



?>

<a href="?insertData">Insérer les données</a>


























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

