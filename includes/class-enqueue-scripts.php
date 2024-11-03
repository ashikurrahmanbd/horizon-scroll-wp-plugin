<?php

class Class_enqueue_scripts{

    public static function init() {

        add_action('wp_enqueue_scripts', [__CLASS__, 'enqueue_frontend_assets']);

        add_action( 'admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets']);

    }

    public static function enqueue_frontend_assets() {

        wp_enqueue_style('horizon-styles', plugin_dir_url(__FILE__) . '../assets/css/style.css');

        wp_enqueue_script('horizon-script', plugin_dir_url(__FILE__) . '../assets/js/script.js', ['jquery'], null, true);

    }

    public static function enqueue_admin_assets($hook_suffix){

        if ($hook_suffix === 'options-general.php?page=hs-configure') {

            // Enqueue a CSS file
            wp_enqueue_style(
                'hs-admin-style',                    // Handle
                plugins_url('assets/css/admin-style.css', __FILE__), // Path to CSS file
                [],                                      // Dependencies
                filemtime(plugin_dir_path( __FILE__ ) . 'assets/css/admin-style.css' )// Version
            );

        }


    }

}