<?php

// add to function PHP 
//include ( trailingslashit( get_theme_file_path() ) . 'enqueue-styles.php');

if ( !function_exists( 'better_custom_styles' ) ):
    function better_custom_styles() {

        $display_debug = false; // second debug switch is in function selective_disable_styles()

        $main_handler = 'main-stylesheet';
    	//disable main CSS
    	//wp_dequeue_style('');
    	

    	//add custom main style
        wp_enqueue_style( $main_handler, trailingslashit( get_stylesheet_directory_uri() ) . 'style.css' );

        //disable stylesheets
        //selective_disable_styles();

        load_template_css($display_debug); // load template CSS
        
        load_page_css($main_handler,$display_debug); // load page file and inline CSS
        //load fonts
        
        //wp_enqueue_style( 'gfonts', 'https://fonts.googleapis.com/css?family=EB+Garamond:500|Rubik&display=swap');
        //wp_enqueue_style( 'fontello', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/fontello.css' );
    }

add_action( 'wp_print_styles', 'better_custom_styles', 1 );
endif;


if ( !function_exists( 'selective_disable_styles' ) ):
    function selective_disable_styles() {
        
        $display_debug = false;

        // this functions disables styles on given pages

        /* 0 disable on all pages*/
        /* positive ID of the page that is ALLOWED otherwise disabled*/
        /* negative ID of the page will DISABLE only on given page*/
        $page_id = get_the_ID();

        $CSS_disable=array(
                'wp-block-library'=> 0,
                'twentytwenty-style' => 0

                );

        foreach ($CSS_disable as $key => $value) {
            
            if (!is_numeric($key)) { 
                $handler = $key;
                $disable_style=false;
                $disabled_style_already = false;
            }
            
            if ($value>=0) { 
                if ($value != $page_id or $value=0) { //disable if page ID is not on list
                    $disable_style = true;
                } 
            } else {    
                $value = abs($value); //turn negative number to positive    
                if ($value == $page_id) { //disable if page ID is on the list
                    $disable_style = true;
                }
            }

            if ($disable_style and !$disabled_style_already) {
                wp_dequeue_style($handler); 
                wp_deregister_style($handler);
                $disabled_style_already = true;

                if ($display_debug) {
                    echo $handler." - disabled<br>";
                }

            }
        }
    }

add_action( 'wp_print_styles', 'selective_disable_styles', 100 );
endif;


if ( ! function_exists( 'load_page_css' )){
    function load_page_css($main_handler,$display_debug=false) {
        

        $page_id = get_the_ID();

        // page id file
        $page_custom_css_path = trailingslashit( get_theme_file_path()).'assets/css/page-'.$page_id.'.css';

        if (file_exists($page_custom_css_path)) {
            
            $css_url = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/page-'.$page_id.'.css';
            wp_enqueue_style( 'page-'.$page_id, $css_url );

            if ($display_debug) {
                echo $css_url." -enqueued<br>";
            }
        }

        //page id inline

        $page_custom_inline_css_path = trailingslashit( get_theme_file_path()).'assets/css/page-inline-'.$page_id.'.css';

        if (file_exists($page_custom_inline_css_path)) {
            $data = file_get_contents($page_custom_inline_css_path);
            wp_add_inline_style( $main_handler, $data );

            if ($display_debug) {
                echo 'page ID: '.$page_id." -inlined<br>";
            }

        }
    }
}

if ( ! function_exists( 'load_template_css' )){
    function load_template_css($display_debug=false) {

        global $template;

        //template name ( = theme folder name and template filename without .php)
        //  if template is in the parent theme twentytwenty/singular.php
        // template CSS filename will be: assets/css/template-twentytwenty-singular.css

        //  if template is in the child theme theme twentytwenty-child/singular.php 
        // template CSS filename will be: assets/css/template-twentytwenty-child-singular.css

        $template_array = explode('/', $template);
        $array_count = count($template_array);

        $template_slug = 'template-'.$template_array[$array_count-2].'-'.str_replace('.php','',$template_array[$array_count-1]);


        $template_custom_css_path = trailingslashit( get_theme_file_path()).'assets/css/'.$template_slug.'.css';

        if (file_exists($template_custom_css_path)) {
     
            wp_enqueue_style( $template_slug, trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/'.$template_slug.'.css' );
        }
    }
}


?>