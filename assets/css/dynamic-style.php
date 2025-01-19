<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
/**
 * add inline dynamic css
*/

// Create the dynamic CSS
$dynamic_css = '';

if ( is_user_logged_in() && is_admin_bar_showing() ) {

    $dynamic_css .= "
        .indicator-wrapper {
            top: 32px !important;
        }
    ";

}

$get_scrollbar_primary_color = get_option( 'pxls_hs_primary_color' );

$get_hide_admin_view = get_option( 'pxls_hs_hide_admin_view' );

$dynamic_css .= "
    .indicator {
        background-color: " . esc_html( $get_scrollbar_primary_color ) . ";
    }
";

if ( $get_hide_admin_view === '1' && is_admin_bar_showing() ) {

    $dynamic_css .= "
        .indicator-wrapper {
            display: none !important;
        }
    ";

}

// Add the dynamic CSS inline and binded to the horizon-style css file
wp_add_inline_style( 'pxls-hs-styles', $dynamic_css );