<?php

class PXLS_HS_ScrollView{

    public static function init() {

        add_action('wp_body_open', [__CLASS__, 'pxls_hs_scrollup_html']);

    }

    public static function pxls_hs_scrollup_html(){

            $admin_hide_option = get_option('pxls_hs_hide_admin_view');

            ob_start();
        ?>
   
        <div class="indicator-wrapper">
            <div class="indicator"></div>
        </div>
     
        <?php

        $html  = ob_get_clean(); //get the buffered content

        echo wp_kses(
            $html,
            array(
                'div' => array( // Allow 'div' tags with these attributes
                    'class' => array(),
                ),
            )
        );

    }




}