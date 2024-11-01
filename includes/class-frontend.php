<?php
/**
 * Dependency Checker
 *
 * Checks if required Dependency plugin is enabled
 *
 * @link http://wcpbpn.com
 * @package Previously Bought Product Notifier For WooCommerce
 * @subpackage Previously Bought Product Notifier For WooCommerce/FrontEnd
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class wc_previously_bought_product_notifier_Functions {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        $this->selected_order = null;
        $this->selected_order_date = null;
        add_action( 'wp_enqueue_scripts', array($this,'enqueue_styles') );
        //add_action( 'wp_enqueue_scripts', array($this,'enqueue_scripts') );
    }

    
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() { 
		wp_enqueue_style(WC_PBPN_NAME.'frontend_style', WC_PBPN_CSS. 'frontend.css', array(), WC_PBPN_V, 'all' );
	}
    
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() { 
		wp_enqueue_script(WC_PBPN_NAME.'frontend_script', WC_PBPN_JS.'frontend.js', array( 'jquery' ), WC_PBPN_V, false );
	}

}