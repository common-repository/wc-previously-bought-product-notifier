<?php
class wc_previously_bought_product_notifier_Display_Single_Product_Page extends wc_previously_bought_product_notifier_Display_Handler {
    public function __construct(){
        $this->is_bought = array();
        $this->slug = 'single_product';
        parent::__construct(); 
    }
    
    public function hookup_area(){ 
        $position = $this->get_position();
        $key = 'woocommerce_single_product_summary';
		$where = $this->get_where();
		$p = 10; 
        if(empty($position)){ return;}
		if('title' == $position && 'before' == $where){ $p = 4;}
		if('rating' == $position && 'before' == $where){ $p = 9;}
		if('price' == $position && 'before' == $where){ $p = 9;}
		if('excerpt' == $position && 'before' == $where){ $p = 19;}
		if('add_to_cart' == $position && 'before' == $where){ $p = 29;}
		if('meta' == $position && 'before' == $where){ $p = 39;}
		
		if('title' == $position && 'after' == $where){ $p = 6;}
		if('rating' == $position && 'after' == $where){ $p = 11;}
		if('price' == $position && 'after' == $where){ $p = 11;}
		if('excerpt' == $position && 'after' == $where){ $p = 21;}
		if('add_to_cart' == $position && 'after' == $where){ $p = 31;}
		if('meta' == $position && 'after' == $where){ $p = 41;}
        add_action($key,array($this,'the_notice'),$p);
        add_filter( 'woocommerce_product_single_add_to_cart_text', array($this,'modify_cart_button') );
    } 
    
    public function the_notice(){
        global $product;
        $current_user = wp_get_current_user();
        echo $this->get_notice($current_user,$product);
    }
}
return new wc_previously_bought_product_notifier_Display_Single_Product_Page;