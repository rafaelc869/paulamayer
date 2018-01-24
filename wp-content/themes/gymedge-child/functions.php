<?php
add_action( 'wp_enqueue_scripts', 'gymedge_child_styles', 18 );
function gymedge_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}