<?php
/**
 * Plugin Name: Horizon Scroll
 * Plugin URI: https://wordpress.org/plugins/horizon-scroll
 * Description: Horizontal Scroll, Reading Indicator, and more
 * Version: 1.2.1
 * Author Ashikur Rahman
 * Author URI: https://ashikurrahmanbd.github.io/
 * Requires at least: 5.0
 * Requires PHP: 5.0
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: horizon-scroll
 * Domain Path: /languages
 */

/**
 * Catch Direct Access and return, die or exit
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

class PixeleseHorizonScroll{

    //version of this plugin
    private $version = '1.2.1';

    private static $instance = null;

    //private constructor to prevents external instantiaton
    private function __construct(){

        $this->pxls_hs_define_constants();

        register_activation_hook( __FILE__, array($this, 'pxls_hs_plugin_activation_callback') );
        register_deactivation_hook( __FILE__, array( $this, 'pxls_hs_plugin_deactivation_callback' ) );

        $this->pxls_hs_load_dependencies();
        $this->pxls_hs_initialize_hooks();

    }

    //singleton instance method
    public static function pxls_hs_get_instance(){

        if(self::$instance === null){

            self::$instance = new self();

        }

        return self::$instance;

    }

    //plugin constants
    public function pxls_hs_define_constants(){

        define('PXLS_HS_VERSION', $this->version);
        define('PXLS_HS_DIR_PATH', plugin_dir_path( __FILE__ ));
        define('PXLS_HS_DIR_URL', plugin_dir_url( __FILE__ ));

    }

    //plugin activation hook callback
    public function pxls_hs_plugin_activation_callback(){

        $plugin_installed = get_option('pxls_hs_installed');

        if ( ! $plugin_installed ) {

            update_option( 'pxls_hs_installed', time());

        }

        update_option( 'pxls_hs_installed_version', PXLS_HS_VERSION );

    }

    //plugin deactivation callback
    public function pxls_hs_plugin_deactivation_callback(){

        $default_options = [

            'pxls_hs_primary_color' => '#0fbcf9',
            'pxls_hs_hide_admin_view' => '0',

        ];

        foreach( $default_options as $option_name => $default_value ){

            update_option( $option_name, $default_value );

        }

    }


    //Load Dependencies by nclcuding modular files
    private function pxls_hs_load_dependencies(){

        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pxls-hs-enqueue-scripts.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pxls-hs-scrollview.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-pxls-hs-settings.php';

    }

    //Initialize Hooks
    private function pxls_hs_initialize_hooks(){

        //initialize enque-scripts
        PXLS_HS_Enqueue_Scripts::init();

        //initialize shortcode
        PXLS_HS_ScrollView::init();

        //initialize Option menu
        PXLS_HS_Settings::init();


    }

    //prevent object clonning
    private function __clone(){}

    //Prevent unserialization
    public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }

}

//intialize the plugin instance
PixeleseHorizonScroll::pxls_hs_get_instance();