<?php
/*  
 *    Author: Jaro Kurimsky
 *    Git: https://github.com/jarowp/better-child-theme-enqueue-styles
 *
 *    To activate script add to functions PHP of the child theme following line
 *    require_once ( trailingslashit( get_theme_file_path() ) . 'custom-styles/custom-styles.php');
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once (__DIR__.'/custom-styles-functions.php');

if ( !function_exists( 'load_my_styles' ) ){
    function load_my_styles() {

        /*disable main CSS example of disabling Astra parent theme*/
        //wp_dequeue_style('astra-theme-css');
        

        /*Example of enqueuing child theme style.css + astra inline CSS example*/
        //$astra__inline_css = apply_filters( 'astra_dynamic_theme_css', '' );
        //wp_enqueue_style ('main-style', trailingslashit( get_stylesheet_directory_uri() ).'style.css');
        //wp_add_inline_style( 'main-style', $astra__inline_css );

        create_css_file();
        
        load_css('template'); 
        load_css('page'); 
        load_css('inline'); 

        /*Example of enqueuing fonts*/

        // enqueue_my_asset_style( 'fontello' ,'fontello.css');      

        // wp_enqueue_style( 'gfonts', 'https://fonts.googleapis.com/css?family=EB+Garamond:500|Rubik&display=swap');

        the_debug();
    }

    add_action( 'wp_print_styles', 'load_my_styles', 1 );
}


?>
