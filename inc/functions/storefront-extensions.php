<?php
/**
 * Wootique Storefront extension compatibility
 *
 * @package wootique
 */

/**
 * Declare extensions this child theme doesn't support
 * @return  void
 */
function wootique_extension_support() {
	add_filter( 'storefront_blog_customiser_enabled', '__return_false' );
	add_filter( 'storefront_checkout_customizer_enabled', '__return_false' );
	add_filter( 'storefront_designer_enabled', '__return_false' );
	add_filter( 'storefront_woocommerce_customiser_enabled', '__return_false' );
}
add_action( 'init', 'wootique_extension_support', -1 );