<?php

class Class_shortcodes{

    public static function init() {

        add_shortcode('custom_shortcode', [__CLASS__, 'render_custom_shortcode']);

        add_action('wp_body_open', [__CLASS__, 'scrollup_html']);

    }

    public static function render_custom_shortcode($atts) {
        return '<p>This is a custom shortcode output.</p>';
    }

    public static function scrollup_html(){

            ob_start();
        ?>

        <div class="indicator-wrapper">
            <div class="indicator"></div>
        </div>

        <?php

        $html  = ob_get_clean(); //get the buffered content

        echo $html;

    }




}