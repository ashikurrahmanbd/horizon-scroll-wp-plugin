<?php
/**
 * Plugin Name: Horizon Scroll
 * Plugin URI: https://wordpress.org/plugins/horizon-scroll
 * Description: Horizontal Scroll, Reading Indicator, Scroll to top and more
 * Version: 1.1.0
 * Author Ashikur Rahman
 * Author URI: https://ashikurrahmanbd.github.io/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: horizon-scroll
 * Domain Path: /languages
 */

class PixeleseHorizonScroll{

    //version of this plugin
    private $version = '1.1.0';

    private static $instance = null;

    //private constructor to prevents external instantiaton
    private function __construct(){

        $this->define_constants();

        register_activation_hook( __FILE__, array($this, 'plugin_activation_callback') );
        register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivation_callback' ) );

        $this->load_dependencies();
        $this->initialize_hooks();

    }

    //singleton instance method
    public static function get_instance(){

        if(self::$instance === null){

            self::$instance = new self();

        }

        return self::$instance;

    }

    //plugin constants
    public function define_constants(){

        define('HS_VERSION', $this->version);
        define('HS_DIR_PATH', plugin_dir_path( __FILE__ ));
        define('HS_DIR_URL', plugin_dir_url( __FILE__ ));

    }

    //plugin activation hook callback
    public function plugin_activation_callback(){

        $plugin_installed = get_option('horizon_scroll_installed');

        if ( ! $plugin_installed ) {

            update_option( 'horizon_scroll_installed', time());

        }

        update_option( 'horizon_scroll_installed_version', HS_VERSION );

    }

    //plugin deactivation callback
    public function plugin_deactivation_callback(){

        $default_options = [

            'hs_primary_color' => '#8c14fc',
            'hs_hide_admin_view' => '0',

        ];

        foreach( $default_options as $option_name => $default_value ){

            update_option( $option_name, $default_value );

        }

    }


    //Load Dependencies by nclcuding modular files
    private function load_dependencies(){

        require_once plugin_dir_path( __FILE__ ) . 'includes/class-scrollview.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-settings.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-enqueue-scripts.php';
        require_once plugin_dir_path( __FILE__ ) . 'assets/css/dynamic-style.php';

    }

    //Initialize Hooks
    private function initialize_hooks(){

        //initialize enque-scripts
        Class_enqueue_scripts::init();

        //initialize shortcode
        Class_ScrollView::init();

        //initialize Option menu
        Class_settings::init();


    }

    //prevent object clonning
    private function __clone(){}

    //Prevent unserialization
    public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }

}

//intialize the plugin instance
PixeleseHorizonScroll::get_instance();