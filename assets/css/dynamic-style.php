<?php

add_action( 'wp_head', function(){

    if ( is_user_logged_in() && is_admin_bar_showing() ) {
        ?>

            <style>
                .indicator-wrapper {
                   
                    top: 32px !important;
                    
                }
                
            </style>

        <?php
    
    }

    //normal css based on the option

    $get_scrollbar_primary_color = get_option( 'hs_primary_color', '#000000');

    $get_hide_admin_view = get_option('hs_hide_admin_view', 1);

    ?>

    <style>

        .indicator {
                            
            background-color: <?php echo $get_scrollbar_primary_color; ?>
            /* box-shadow: 0 2px 5px #4f46e5; */
        }

        <?php if($get_hide_admin_view === '1') : ?>

            .indicator-wrapper {
                   
                display: none !important;
                   
            }

        <?php endif; ?>

    </style>

    <?php

});