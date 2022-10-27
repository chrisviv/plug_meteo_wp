<?php
/**
 * @package Plugin_meteo
 * @version 1.0.0
 */
/*
Plugin Name: plugin_meteo
Plugin URI: LIEN VERS La page d'accueil du plugin 
Description: Une extension  pour connaitre la météo du jour sur n'importe ville.
Version: 1.0
require PHP: 6.0
Author: Chris Vivancos
Author URI: LIEN VERS VOTRE PAGE D’ACCUEIL 
License: GPL 
*/

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


// add_action('wp_footer', 'meteo');
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
// }

?>

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