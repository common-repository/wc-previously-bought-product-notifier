<?php 
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link http://wcpbpn.com
 * @package Previously Bought Product Notifier For WooCommerce
 * @subpackage Previously Bought Product Notifier For WooCommerce/core
 * @since 1.0
 */
class wc_previously_bought_product_notifier_Activator {
	
    public function __construct() {
    }
	
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once(WC_PBPN_INC.'helpers/class-version-check.php');
		require_once(WC_PBPN_INC.'helpers/class-dependencies.php');
		
		if(wc_previously_bought_product_notifier_Dependencies(WC_PBPN_DEPEN)){
			wc_previously_bought_product_notifier_Version_Check::activation_check('3.7');	
		} else {
			if ( is_plugin_active(WC_PBPN_FILE) ) { deactivate_plugins(WC_PBPN_FILE);} 
			wp_die(wc_pbpn_dependency_message());
		}
	} 
 
}