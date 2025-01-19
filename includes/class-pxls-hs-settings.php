<?php
class PXLS_HS_Settings{

    public static function init() {

        $plugin = plugin_basename(dirname(__DIR__) . '/horizon-scroll.php');

        add_action('admin_menu', [__CLASS__, 'pxls_hs_add_settings_page']);
        
        add_filter( 'plugin_action_links_'.$plugin, [__CLASS__, 'pxls_hs_plugin_action_links_callback'] );

        //register settings
        add_action( 'admin_init', [__CLASS__, 'pxls_hs_register_settings']);
        
    }

    public static function pxls_hs_add_settings_page() {

        add_options_page(
            'Horizon Scroll Configure',
            'Horizon Scroll',
            'manage_options',
            'pxls-hs-configure',
            [__CLASS__, 'pxls_hs_render_settings_page']
        );


    }

    public static function pxls_hs_render_settings_page() {

        ?>

        <div class="wrap">
            <h1>Horizon Scroll Settings</h1>
            <form action="options.php" method="post">
                <?php
                // Output security fields for the registered setting "pxls_hs_options_group"
                settings_fields('pxls_hs_options_group');
                
                // Output setting sections and fields for the page "hs-configure"
                do_settings_sections('pxls-hs-configure');
                
                // Submit button
                submit_button('Save Settings');
                ?>
            </form>
        </div>

        <?php
        
    }


    //add a configure link on the Plugin name bottom
    public static function pxls_hs_plugin_action_links_callback($links){
        
        $settings_link = '<a href="options-general.php?page=pxls-hs-configure">Configure</a>';

        //array_unshift just adding a new array item to the previous array
        //$links is the previous array
        array_unshift($links, $settings_link);

        return $links;
    }


    //start adding options using settings API

    public static function pxls_hs_register_settings(){


        //register setting for primary color
        register_setting( 'pxls_hs_options_group', 'pxls_hs_primary_color', array(
            'sanitize_callback' => array(__CLASS__, 'pxls_hs_sanitize_hex_color'), // Add the sanitize callback
        ));

        //register settings for hide admin view
        register_setting( 'pxls_hs_options_group', 'pxls_hs_hide_admin_view',  array(
            'type'              => 'boolean',
            'default'           => 0,
            'sanitize_callback' => array(__CLASS__, 'pxls_hs_sanitize_boolean'), // Add the sanitize callback
        ));


        //add a section tot he settings page hs-configure
        add_settings_section( 'appearance', 'Appearance', [__CLASS__, 'pxls_hs_appearance_section_callback'], 'pxls-hs-configure');


        //add a field to the section
        add_settings_field( 'bar_primary_color', 'Scrollbar Primary Color', [__CLASS__, 'pxls_hs_bar_primary_color_field_callback'], 'pxls-hs-configure', 'appearance');


        //adding new field under same option sectino
        add_settings_field( 
            'pxls_hs_hide_admin_view', 
            'Hide Admin Bar View', 
            [__CLASS__, 'pxls_hs_hide_admin_view_field_callback'], 
            'pxls-hs-configure', 
            'appearance'
        );


    }

    //section callbback
    public static function pxls_hs_appearance_section_callback(){

        

    }

    //field callack
    public static function pxls_hs_bar_primary_color_field_callback(){

        //retrive the saved option
        $primary_color = get_option( 'pxls_hs_primary_color', '#0fbcf9');

        ?>

        <input type="color" name="pxls_hs_primary_color" value="<?php echo esc_attr( $primary_color ); ?>" />

        <?php

    }


    //hide admin view callback
    public static function pxls_hs_hide_admin_view_field_callback() {

        $option = get_option( 'pxls_hs_hide_admin_view', 0 );
        ?>
        <label class="switch">
            <input type="checkbox" name="pxls_hs_hide_admin_view" value="1" <?php checked( 1, $option, true ); ?>>
        </label>
        <?php

    }
    //end of adding options using settings API


    //sanitize call back

    //sanitize call back for hex color
    public static function pxls_hs_sanitize_hex_color( $color ){

         // Check if the input is a valid hex color (#RRGGBB or #RGB)
        if ( preg_match( '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $color ) ) {

            return $color;

        }

        return null; // Return null if the value is not a valid hex color

    }

    public static function pxls_hs_sanitize_boolean($value){

        return filter_var( $value, FILTER_VALIDATE_BOOLEAN );

    }


}