<?php

class Class_settings{

    public static function init() {

        $plugin = plugin_basename(dirname(__DIR__) . '/horizon-scroll.php');


        add_action('admin_menu', [__CLASS__, 'add_settings_page']);
        add_filter( 'plugin_action_links_'.$plugin, [__CLASS__, 'plugin_action_links_callback'] );

        //register settings
        add_action( 'admin_init', [__CLASS__, 'register_settings']);
        
    }

    public static function add_settings_page() {

        add_options_page(
            'Horizon Scroll Configure',
            'Horizon Scroll',
            'manage_options',
            'hs-configure',
            [__CLASS__, 'render_settings_page']
        );


    }

    public static function render_settings_page() {

        ?>

        <div class="wrap">
            <h1>Horizon Scroll => Settings</h1>
            <form action="options.php" method="post">
                <?php
                // Output security fields for the registered setting "hs_options_group"
                settings_fields('hs_options_group');
                
                // Output setting sections and fields for the page "hs-configure"
                do_settings_sections('hs-configure');
                
                // Submit button
                submit_button('Save Settings');
                ?>
            </form>
        </div>

        <?php
        
    }


    //add a configure link on the Plugin name bottom
    public static function plugin_action_links_callback($links){
        
        $settings_link = '<a href="options-general.php?page=hs-configure">Configure</a>';

        //array_unshift just adding a new array item to the previous array
        //$links is the previous array
        array_unshift($links, $settings_link);
        return $links;
    }


    //start adding options using settings API


    public static function register_settings(){


        //register setting for primary color
        register_setting( 'hs_options_group', 'hs_primary_color');

        //register settings for hide admin view
        register_setting( 'hs_options_group', 'hs_hide_admin_view');



        //add a section tot he settings page hs-configure
        add_settings_section( 'appearance', 'Appearance', [__CLASS__, 'appearance_section_callback'], 'hs-configure');


        //add a field to the section
        add_settings_field( 'bar_primary_color', 'Scrollbar Primary Color', [__CLASS__, 'bar_primary_color_field_callback'], 'hs-configure', 'appearance');


        //adding new field under same option sectino
        add_settings_field( 'hs_hide_admin_view_field', 'Hide Admin Bar View', [__CLASS__, 'hs_hide_admin_view_field_callback'], 'hs-configure', 'appearance');



    }

    //section callbback
    public static function appearance_section_callback(){

        

    }

    //field callack
    public static function bar_primary_color_field_callback(){

        //retrive the saved option
        $primary_color = get_option( 'hs_primary_color', '#000000');

        ?>

        <input type="color" name="hs_primary_color" value="<?php echo esc_attr( $primary_color ); ?>" />

        <?php

    }


    //hide admin view callback
    public static function hs_hide_admin_view_field_callback() {
        $option = get_option('hs_hide_admin_view', 1);
        ?>
        <label class="switch">
            <input type="checkbox" name="hs_hide_admin_view" value="1" <?php checked( 1, $option, true ); ?>>
            <span class="slider round"></span>
            
            
            
        </label>
        <?php
    }


    //end of adding options using settings API

}