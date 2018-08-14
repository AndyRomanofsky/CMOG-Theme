<?php
function aac_rss_feed( $atts ) {
    $atts = shortcode_atts( array(
        'url' => '',
        'words' => 0,
        'chars' => 0,
        'items' => 3,
    ), $atts, 'aac_feed' );

    return get_rss_feed($atts["url"], $atts["words"], $atts["chars"], $atts["items"]);
}
add_shortcode( 'aac_feed', 'aac_rss_feed' );

?>