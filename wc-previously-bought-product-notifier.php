<?php 
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wcpbpn.com
 * @since             1.0
 * @package           Previously Bought Product Notifier For WooCommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Previously Bought Product Notifier For WooCommerce
 * Plugin URI:        http://wcpbpn.com
 * Description:       This plugin will display notifications to shop customers about products they have already bought before with information that is customization . 
 * Version:           1.0
 * Author:            Varun Sridharan
 * Author URI:        http://varunsridharan.in
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-previously-bought-product-notifier
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) { die; }
 
define('WC_PBPN_FILE',plugin_basename( __FILE__ ));
define('WC_PBPN_PATH',plugin_dir_path( __FILE__ )); # Plugin DIR
define('WC_PBPN_INC',WC_PBPN_PATH.'includes/'); # Plugin INC Folder
define('WC_PBPN_DEPEN','woocommerce/woocommerce.php');

register_activation_hook( __FILE__, 'wc_pbpn_activate_plugin' );
register_deactivation_hook( __FILE__, 'wc_pbpn_deactivate_plugin' );
register_deactivation_hook( WC_PBPN_DEPEN, 'wc_pbpn_dependency_deactivate' );



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function wc_pbpn_activate_plugin() {
	require_once(WC_PBPN_INC.'helpers/class-activator.php');
	wc_previously_bought_product_notifier_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function wc_pbpn_deactivate_plugin() {
	require_once(WC_PBPN_INC.'helpers/class-deactivator.php');
	wc_previously_bought_product_notifier_Deactivator::deactivate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function wc_pbpn_dependency_deactivate() {
	require_once(WC_PBPN_INC.'helpers/class-deactivator.php');
	wc_previously_bought_product_notifier_Deactivator::dependency_deactivate();
}



require_once(WC_PBPN_INC.'functions.php');
require_once(WC_PBPN_PATH.'bootstrap.php');

if(!function_exists('wc_pbpn')){
    function wc_pbpn(){
        return wc_previously_bought_product_notifier::get_instance();
    }
}
wc_pbpn();