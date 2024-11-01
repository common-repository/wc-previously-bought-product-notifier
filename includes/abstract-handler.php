<?php 
if ( ! defined( 'WPINC' ) ) { die; }
 
abstract class wc_previously_bought_product_notifier_Display_Handler {
	public $slug = '';
    public $name = '';
    public $desc = '';
	
	public function __construct(){
        add_action('wc_pbpn_before_init',array($this,'hookup_area'));
    }
	
	public function get_position(){ 
		$value = wc_pbpn_option($this->slug.'_pos');
		return $value;
	}
	
	public function get_where(){
		$value = wc_pbpn_option($this->slug.'_where',true);
		return $value;
	}
	
	public function get_msg(){
		$value = wc_pbpn_option($this->slug.'_msg',true);
		return $value;
	}
	
	public function get_date_format(){
		$value = wc_pbpn_option($this->slug.'_date_format',true);
		return $value;
	}
    
    
    public function get_addtocart_bought_title($type = 'simple'){
		$value = wc_pbpn_option($this->slug.'_'.$type.'_addtocart_ifbought','');
		return $value;
	}
	
	public function get_addtocart_incart_title($type = 'simple'){
		$value = wc_pbpn_option($this->slug.'_'.$type.'_addtocart_ifcart','');
		return $value;
	}
	
	public function get_theme(){
		$value = wc_pbpn_option($this->slug.'_theme',true);
		return $value;
	}
    
    public function get_search_string(){
        return array('{orderID}','{orderdate}','http://{orderlink}','{prodname}');
    }
    
    public function is_wc3x(){
        if(version_compare(WOOCOMMERCE_VERSION,'3.0','>=')){return true;}
        return false;
    }
    
    public function get_product_type($product){
        if($this->is_wc3x()){
            return $product->get_type();
        }
        
        return $product->type;
    }
    
    public function get_replace_string($order,$product,$customer){
        $oid = '';
        if($this->is_wc3x()){
            $oid = $order['order']->get_id();
        } else {
            $oid = $order['order']->ID;
        }
        
        $order_link = $order['order']->get_view_order_url();
        $title = get_the_title($product->get_id());
        return array($oid,$order['order_date'],$order_link,$title);
        
    }
    
    public function hookup_area(){
        
    }
    
    public function modify_cart_button($return){
        global $product;
        $pid = $product->get_id();
        
        if(isset($this->is_bought[$pid])){
            $is_bought = 1;
            $type = $this->get_product_type($product);
            
            $title = $this->get_addtocart_bought_title($type);
            if(empty($title)){return $return;}
            return $title;
        } else {
            $is_in_cart = wc_pbpn()->func()->woo_in_cart($pid);
            $type = $this->get_product_type($product);
            if($is_in_cart === true){
                $title = $this->get_addtocart_incart_title($type);
                if(empty($title)){return $return;}
                return $title;

            } 
        }
        
        
        return $return;
    }

    public function get_notice($current_user,$product){
        $pid = $product->get_id();
        $is_bought = wc_pbpn()->func()->check_product_status($current_user->email,$current_user->ID,$pid);
        if($is_bought !== false){
            $search = $this->get_search_string();
            $replace = $this->get_replace_string($is_bought,$product,$current_user);
            $msg = $this->get_msg();
            $msg = html_entity_decode($msg);
            $format = $this->get_date_format();
            $replace[1] = date($format,strtotime($replace[1]));
            $msg = str_replace($search,$replace,$msg);
            $type = $this->get_theme();
            $this->is_bought[$pid] = $is_bought;
            if($type == 'wc_notice'){
                ob_start();
                    wc_print_notice( $msg,  'success' );
                return ob_get_clean();

            } else {
                return $msg;
            }
        }
    }
    
}