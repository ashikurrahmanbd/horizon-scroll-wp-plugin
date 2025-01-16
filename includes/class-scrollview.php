<?php

class Class_ScrollView{

    public static function init() {

        add_action('wp_body_open', [__CLASS__, 'scrollup_html']);

    }

    public static function scrollup_html(){

            $admin_hide_option = get_option('hs_hide_admin_view');

            ob_start();
        ?>
   
        <div class="indicator-wrapper">
            <div class="indicator"></div>
        </div>
     
        <?php

        $html  = ob_get_clean(); //get the buffered content

        echo esc_html( $html );

    }




}