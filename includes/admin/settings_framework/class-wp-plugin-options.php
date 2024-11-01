<?php
/**
 * The admin-specific functionality of the plugin.
 * @link http://wcpbpn.com
 * @package Previously Bought Product Notifier For WooCommerce
 * @subpackage Previously Bought Product Notifier For WooCommerce/Admin
 * @since 3.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class wc_previously_bought_product_notifier_Admin_Settings_Options {

    public function __construct() {
    	add_filter('wc_pbpn_settings_pages',array($this,'settings_pages'));
		add_filter('wc_pbpn_settings_section',array($this,'settings_section'));
		add_filter('wc_pbpn_settings_fields',array($this,'settings_fields'));
    }
	public function settings_pages($page){
		$page[] = array('id'=>'general','slug'=>'general','title'=>__('Previously Bought Product Notifier For WooCommerce',WC_PBPN_TXT));
		return $page;
	}

    public function settings_section($section){
		$section['general'][] = array( 'id'=>'asp', 'title'=> __('Archive / Search Page',WC_PBPN_TXT));
        $section['general'][] = array( 'id'=>'spp', 'title'=> __('Single Product Page',WC_PBPN_TXT));
       // $section['general'][] = array( 'id'=>'shortcode', 'title'=> __('Shortcode',WC_PBPN_TXT));
		return $section;
	}

    public function settings_fields($fields){
        global $fields;
        include(WC_PBPN_SETTINGS.'fields.php'); 
		return $fields;
	}
}

return new wc_previously_bought_product_notifier_Admin_Settings_Options;