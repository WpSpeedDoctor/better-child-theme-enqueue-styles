<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/*
    To activate script add to functions PHP of the child theme following line
    require_once ( trailingslashit( get_theme_file_path() ) . 'custom-styles/custom-styles.php');
*/

require_once (__DIR__.'/custom-styles-functions.php');

if ( !function_exists( 'load_my_styles' ) ){
    function load_my_styles() {

        //disable main CSS
        // wp_dequeue_style('astra-theme-css');
        

        //add custom main style
        // enqueue_my_style('style-main','style.css');

        create_css_file();
        
        load_css('template'); 
        load_css('page'); 
        load_css('inline'); 

        //load fonts
        // enqueue_my_asset_style('proxmanova-font','proximanova.css');
        
        // enqueue_my_asset_style( 'fontello' ,'fontello.css');      

         // wp_enqueue_style( 'gfonts', 'https://fonts.googleapis.com/css?family=EB+Garamond:500|Rubik&display=swap');

        the_debug();
    }

    add_action( 'wp_print_styles', 'load_my_styles', 1 );
}


?>
