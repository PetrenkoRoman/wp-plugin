<?php
/**
 * Cart
 *
 * @link              /
 * @since             1.0.0
 * @package           Nixwood-Cart
 *
 * @wordpress-plugin
 * Plugin Name:         Nixwood Cart
 * Plugin URI:          /
 * Description:         Creates cart for site.
 * displaying the data.
 * Version:             1.0.0
 * Author:              Roman Petrenko
 * Author URI:          https://github.com/
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         nixwood-cart
 * Domain Path:         nixwood-cart/languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'NIXWOOD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( ! class_exists( 'Nixwood_Cart' ) ) :

	/**
	 * Plugin's main class.
	 *
	 * @since   1.0.0
	 * @package Nixwood_Cart
	 */
	class Nixwood_Cart {

		/**
		 * Main constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {}

		/**
		 * Plugin's hooks.
		 *
		 * @since 1.0.0
		 */
		public function init() {
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
			add_shortcode( 'nixwood', array( __CLASS__, 'get_cart' ) );
			add_filter( 'basic_price', array( __CLASS__, 'get_basic_price' ) );
			add_filter( 'extra_page_price', array( __CLASS__, 'get_extra_page_price' ) );
			add_action( 'wp_ajax_submit_cart', array( __CLASS__, 'submit_cart' ) );
			add_action( 'wp_ajax_nopriv_submit_cart', array( __CLASS__, 'submit_cart' ) );
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since   1.0.0
		 *
		 * add_action('wp_enqueue_styles', 'enqueue_scripts');
		 */
		public function enqueue_assets() {
			wp_enqueue_style( 'nixwood-css', plugin_dir_url( __FILE__ ) . 'assets/css/styles.css');
			wp_enqueue_script('nixwoodcart-js', plugin_dir_url( __FILE__ ) . 'assets/js/nixwood-cart.js', array('jquery'));
			wp_localize_script( 'nixwoodcart-js', 'ajaxParams', array(
				                                    'ajaxurl' => admin_url( 'admin-ajax.php' ),
				                                    'action'  => 'submit_cart',
				                                    'nonce'   => wp_create_nonce( 'nixwood_cart_plugin' ),
			                                    )
			);
		}
		/**
		 * Displays cart by the shortcode.
		 *
		 * @since 1.0.0
		 *
		 * add_shortcode('nixwood', 'get_cart');
		 *
		 * @param array $atts Shortcode attributes.
		 */
		public function get_cart( $atts ) {
			$page = ! empty( $atts ) ? $atts['page'] : '';
			if ( 'cart' === $page ) {
				require_once NIXWOOD_PLUGIN_DIR . '/views/cart-view.php';
			}
		}

		/**
		 * Basic price filter callback.
		 *
		 * @param int $price Basic price.
		 *
		 * @return int
		 * @since 1.0.0
		 */
		public function get_basic_price( $price ): int {
			return $price;
		}

		/**
		 * Extra page filter callback.
		 *
		 * @param int $price Extra page price.
		 *
		 * @return int
		 * @since 1.0.0
		 */
		public function get_extra_page_price( $price ): int {
			return $price;
		}

		/**
		 * AJAX callback function for cart submitting.
		 *
		 * @since 1.0.0
		 */
		public function submit_cart() {
			if ( ! check_ajax_referer( 'nixwood_cart_plugin', 'security', false ) ) {

				wp_send_json_error( 'Invalid security token sent.' );
				wp_die();
			}
			$total = isset( $_POST['total'] ) ? sanitize_text_field( wp_unslash( $_POST['total'] ) ) : '';
			wp_send_json_success( $total );

		}

	}

	add_action( 'plugins_loaded', array( 'Nixwood_Cart', 'init' ) );
endif;
