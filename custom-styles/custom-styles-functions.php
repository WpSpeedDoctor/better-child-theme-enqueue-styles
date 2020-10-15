<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// add to function PHP 
//include ( trailingslashit( get_theme_file_path() ) . 'enqueue-styles.php');


if ( ! function_exists( 'get_css_asset_folder' )){
    function get_css_asset_folder() {
        return 'assets/css/';
    }
}

if ( ! function_exists( 'get_css_assets_path' )){
    function get_css_assets_path() {
        return trailingslashit( get_theme_file_path() ).get_css_asset_folder();
    }
}

if ( ! function_exists( 'get_css_assets_url' )){
    function get_css_assets_url() {
        return trailingslashit( get_stylesheet_directory_uri() ).get_css_asset_folder();
    }
}


if ( ! function_exists( 'get_css_qs' )){
    function get_css_qs() {

        return ( isset($_GET['css']) === true ? $_GET['css'] : false);

    }
}

if ( ! function_exists( 'get_file_slug' )){
    function get_file_slug($css_type) {
        
        switch ($css_type) {
            case 'template':
                $result = 'template-'.get_template_slug();
                break;
            
            case 'page':
                $result = 'page-'.get_the_ID();
                break;
            
            case 'inline':
                $result = 'inline-'.get_the_ID();
                break;
            
            default:
               $result = false;
                break;
        }

        return $result;
    }
}

if ( ! function_exists( 'get_template_slug' )){
    function get_template_slug() {
        
        global $template; 
        
        return basename($template,'.php');
    }
}

if ( ! function_exists( 'the_debug_window' )){
    function the_debug_window( $value='empty' ) {
        ?>
        <style>
            .debug_box {
                position:fixed;
                bottom:55px;
                right:10px;
                z-index:9999;
                background-color:#ddd;
                border:1px solid grey;
                line-height:30px;
                color:#000;
                font-size:20px;
                max-height:800px;
                overflow-y:scroll;
                padding:0 35px 0 5px;
            }
        </style>
        <div id="dw" class="debug_box"><?php echo $value; ?></div>';
        <?php
    }
}

if ( ! function_exists( 'enqueue_my_style' )){
    function enqueue_my_style( $handle, $file ) {
        
        $style_url =  get_css_assets_url(). $file;

        $style_path = get_css_assets_path(). $file;

        $css_query_string = filemtime( $style_path );

        wp_enqueue_style( $handle, $style_url, array(), $css_query_string, false );

    }
}

if ( ! function_exists( 'the_debug' )){
    function the_debug() {
        
        if ( get_css_qs() !== false and is_user_logged_in() ) {

            global $debug_data_css;

            the_debug_window($debug_data_css);

        }
    }
}

if ( ! function_exists( 'add_to_debug' )){
    function add_to_debug($value) {
        global $debug_data_css;

        if (!isset($debug_data_css)) $GLOBALS['debug_data_css'] =='';

        $GLOBALS['debug_data_css'] .= ( empty($value) == true ? '' : $value.'<br>');
    }
}


if ( ! function_exists( 'create_assets_css_folder' )){
    function create_assets_css_folder() {
        
        $style_folder =  trailingslashit( get_theme_file_path() );
        
        $assets_folder_path =  $style_folder.'assets';

        $css_folder_path = $assets_folder_path.'/css';

        if (!file_exists($assets_folder_path)) {
            mkdir( $assets_folder_path, 0755, true);
        }

        if (!file_exists($css_folder_path)) {
            mkdir( $css_folder_path, 0755, true);
        }      
    }
}

if ( ! function_exists( 'get_create_filename' )){
    function get_create_filename() {
    
        $query_string = get_css_qs();

       return get_file_slug ($query_string);
    }
}


if ( ! function_exists( 'create_css_file' )){
    function create_css_file() {
        
        if( !is_user_logged_in() ) return;

        $filename = get_create_filename();

        if ($filename === false ) return;

        $file_path = get_css_assets_path().$filename.'.css';

        if ( file_exists( $file_path) ) return;

        create_assets_css_folder();

        $create_file = fopen ($file_path, 'w');
        fclose($create_file);

        the_debug_window('Created -> '.$file_path);

    }
}

if ( ! function_exists( 'create_template_css' )){
    function create_template_css($template_path) {
        
        if ( file_exists($template_path) ) return;

        $query_string = get_css_qs();
        if ( $query_string != 'createfolder' ) return;

        create_assets_css_folder();

        $template_file = fopen ($template_path, 'w');
        fclose($template_file);
    }
}

if ( ! function_exists( 'load_css' )){
    function load_css( $css_type ) {
        
        $file_slug = get_file_slug($css_type);
        $css_type .='-';
        $file_name = $file_slug.'.css';
        $css_file_path = get_css_assets_path().$file_name;
        $handle = $file_slug;

        if ( file_exists($css_file_path) ) {
            
            if ($css_type == 'inline-') {

                $inline_content = file_get_contents($css_file_path);
                
                wp_register_style( $handle, false );
                wp_enqueue_style( $handle );

                wp_add_inline_style( $handle, $inline_content );

            } else {

                enqueue_my_style( $handle, $file_name);

            }

            add_to_debug( 'Loaded '.$css_type.' ->'.$css_file_path);            

        } else {

            add_to_debug( 'Not present '.$css_type.' ->'.$css_file_path);
        
        }

    }
}


?>
