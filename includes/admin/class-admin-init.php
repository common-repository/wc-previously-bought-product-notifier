<?php
/**
 * Plugin's Admin code
 *
 * @link http://wcpbpn.com
 * @package Previously Bought Product Notifier For WooCommerce
 * @subpackage Previously Bought Product Notifier For WooCommerce/Admin
 * @since 1.0
 */
if ( ! defined( 'WPINC' ) ) { die; }

class wc_previously_bought_product_notifier_Admin {

    /**
	 * Initialize the class and set its properties.
	 * @since      0.1
	 */
	public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ),99);
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ));

        add_filter( 'plugin_row_meta', array($this, 'plugin_row_links' ), 10, 2 );
        add_filter( 'plugin_action_links_'.WC_PBPN_FILE, array($this,'plugin_action_links'),10,10); 
        add_filter( 'woocommerce_screen_ids',array($this,'set_wc_screen_ids'),99);
	}

    public function set_wc_screen_ids($screens){ 
        $screen = $screens; 
      	$screen[] = wc_pbpn_vars('settings_page');
        return $screen;
    }
    
    /**
     * Inits Admin Sttings
     */
    public function admin_init(){
        
    } 
     
    /**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {  
        $pages = wc_pbpn_get_screen_ids();
        $current_screen = wc_pbpn_current_screen();
        
        //$addon_url = admin_url('admin-ajax.php?action=wc_pbpn_addon_custom_css');
        wp_register_style(WC_PBPN_SLUG.'_backend_style',WC_PBPN_CSS.'backend.css' , array(), WC_PBPN_V, 'all' );  
        //wp_register_style(WC_PBPN_SLUG.'_addons_style',$addon_url , array(), WC_PBPN_V, 'all' );  

        
        if(in_array($current_screen ,$pages)) {
            wp_enqueue_style(WC_PBPN_SLUG.'_backend_style');  
            //wp_enqueue_style(WC_PBPN_SLUG.'_addons_style');  
        }
        
        do_action('wc_pbpn_admin_styles',$current_screen,$pages);
	}
    
    /**
	 * Register the JavaScript for the admin area.
	 */
	public function enqueue_scripts() {
        $pages = wc_pbpn_get_screen_ids();
        $current_screen = wc_pbpn_current_screen();
        wp_register_script(WC_PBPN_SLUG.'_backend_script', WC_PBPN_JS.'backend.js', array('jquery'), WC_PBPN_V, false ); 

        if(in_array($current_screen ,$pages)) {
            wp_enqueue_script(WC_PBPN_SLUG.'_backend_script' ); 
        } 
        
        do_action('wc_pbpn_admin_scripts',$current_screen,$pages); 
 	}
 
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
    public function plugin_action_links($action,$file,$plugin_meta,$status){
        $menu_link = admin_url('admin.php?page=wc-previously-bought-product-notifier-settings');
        $actions[] = sprintf('<a href="%s">%s</a>', $menu_link, __('Settings',WC_PBPN_TXT) );
        $actions[] = sprintf('<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __('Contact Author',WC_PBPN_TXT) );
        $action = array_merge($actions,$action);
        return $action;
    }
    
    /**
	 * Adds Some Plugin Options
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 * @since 0.11
	 * @return array
	 */
	public function plugin_row_links( $plugin_meta, $plugin_file ) {
		if ( WC_PBPN_FILE == $plugin_file ) {
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'http://wordpress.org/plugins/wc-previously-bought-product-notifier', __('F.A.Q',WC_PBPN_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', '#', __('View On Github',WC_PBPN_TXT) );
            $plugin_meta[] = sprintf('<a href="%s">%s</a>', 'http://wordpress.org/plugins/wc-previously-bought-product-notifier', __('Report Issue',WC_PBPN_TXT) );
            $plugin_meta[] = sprintf('&hearts; <a href="%s">%s</a>', 'http://paypal.me/varunsridharan23', __('Donate',WC_PBPN_TXT) );
		}
		return $plugin_meta;
	}	    
}