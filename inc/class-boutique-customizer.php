<?php
/**
 * Boutique_Customizer Class
 * Makes adjustments to Storefront cores Customizer implementation.
 *
 * @author   WooThemes
 * @since    1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Boutique_Customizer' ) ) {

class Boutique_Customizer {

	/**
	 * Setup class.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 	1000 );
		add_action( 'customize_register', array( $this, 'edit_default_settings' ), 	99 );
		add_action( 'customize_register', array( $this, 'edit_default_controls' ), 	99 );
	}

	/**
	 * Returns an array of the desired default Storefront options
	 * @return array
	 */
	public function get_boutique_defaults() {
		return apply_filters( 'boutique_default_settings', $args = array(
			'storefront_heading_color'					=> '#2b2b2b',
			'storefront_footer_heading_color'			=> '#2b2b2b',
			'storefront_button_text_color'				=> '#2b2b2b',
			'storefront_header_background_color'		=> '#2b2b2b',
			'storefront_footer_background_color'		=> '#2b2b2b',
			'storefront_header_link_color'				=> '#ffffff',
			'storefront_header_text_color'				=> '#ffffff',
			'storefront_button_alt_text_color'			=> '#ffffff',
			'storefront_footer_link_color'				=> '#111111',
			'storefront_text_color'						=> '#777777',
			'storefront_footer_text_color'				=> '#777777',
			'storefront_accent_color'					=> '#7c7235',
			'storefront_button_alt_background_color'	=> '#7c7235',
			'storefront_background_color'				=> '#303030',
			'storefront_button_background_color'		=> '#eeeeee',
		) );
	}

	/**
	 * Set default Customizer settings based on Storechild design.
	 * @uses get_boutique_defaults()
	 * @return void
	 */
	public function edit_default_settings( $wp_customize ) {
		foreach ( Boutique_Customizer::get_boutique_defaults() as $mod => $val ) {
			$setting = $wp_customize->get_setting( $mod );

			if ( is_object( $setting ) ) {
				$setting->default = $val;
			}
		}
	}

	/**
	 * Modify the default controls
	 * @return void
	 */
	public function edit_default_controls( $wp_customize ) {
		$wp_customize->get_setting( 'storefront_header_text_color' )->transport 	= 'refresh';
	}

	/**
	 * Add CSS using settings obtained from the theme options.
	 * @return void
	 */
	public function add_customizer_css() {
		$header_background_color 		= get_theme_mod( 'storefront_header_background_color' );
		$header_text_color 				= get_theme_mod( 'storefront_header_text_color' );

		$style = '
			.boutique-primary-navigation,
			.main-navigation ul.menu > li > ul,
			.main-navigation ul.menu ul,
			.site-header-cart .widget_shopping_cart {
				background: ' . storefront_adjust_color_brightness( $header_background_color, -10 ) . ';
			}

			@media screen and (min-width: 768px) {
				.main-navigation ul.menu ul,
				.main-navigation ul.nav-menu ul,
				.main-navigation .smm-mega-menu,
				.sticky-wrapper,
				.sd-sticky-navigation,
				.sd-sticky-navigation:before,
				.sd-sticky-navigation:after {
					background: ' . storefront_adjust_color_brightness( $header_background_color, -10 ) . ' !important;
				}
			}

			.main-navigation ul li.smm-active li ul.products li.product h3 {
				color: ' . $header_text_color . ';
			}';

		wp_add_inline_style( 'storefront-child-style', $style );
	}
}

}

return new Boutique_Customizer();