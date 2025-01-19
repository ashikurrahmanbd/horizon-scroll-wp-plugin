<?php

class PXLS_HS_Enqueue_Scripts{

    public static function init() {

        add_action('wp_enqueue_scripts', [__CLASS__, 'pxles_hs_enqueue_frontend_assets']);

        add_action( 'admin_enqueue_scripts', [__CLASS__, 'pxls_hs_enqueue_admin_assets']);

    }

    public static function pxles_hs_enqueue_frontend_assets() {

        wp_register_style( 

            'pxls-hs-styles', 
            plugin_dir_url(__FILE__) . '../assets/css/style.css',
            [],
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/css/style.css' ),
            
        );

        wp_register_script( 
            'pxls-hs-script', 
            plugin_dir_url(__FILE__) . '../assets/js/script.js', 
            ['jquery'], 
            filemtime( plugin_dir_path( __FILE__ ) . '../assets/js/script.js' ), 
            array(
                'in_footer' => true,
                'strategy'  => 'async',
            )
        );
        

        wp_enqueue_style( 'pxls-hs-styles' );

        wp_enqueue_script( 'pxls-hs-script' );


        //all dynamic css
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/dynamic-style.php';


    }

    public static function pxls_hs_enqueue_admin_assets($hook_suffix){

        if ($hook_suffix === 'options-general.php?page=hs-configure') {

            // Enqueue a CSS file
            wp_enqueue_style(
                'pxls-hs-admin-style',                    // Handle
                plugins_url('assets/css/admin-style.css', __FILE__), // Path to CSS file
                [],                                      // Dependencies
                filemtime(plugin_dir_path( __FILE__ ) . 'assets/css/admin-style.css' )// Version
            );

        }


    }

}