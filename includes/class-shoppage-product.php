<?php
class wc_previously_bought_product_notifier_Display_Shop_Page extends wc_previously_bought_product_notifier_Display_Handler {
    public function __construct(){
        $this->is_bought = array();
        $this->slug = 'shop_page';
        parent::__construct(); 
    }
    
    public function hookup_area(){ 
        $position = $this->get_position();
        $where = $this->get_where();
        $p = 10; 
        $key = '';
        if(empty($position)){ return;}
        if('title' == $position && 'before' == $where){ $p = 9; $key = 'woocommerce_shop_loop_item_title';}
        if('rating' == $position && 'before' == $where){ $p = 4; $key = 'woocommerce_after_shop_loop_item_title';}
        if('price' == $position && 'before' == $where){ $p = 9; $key = 'woocommerce_after_shop_loop_item_title';}
        if('title' == $position && 'after' == $where){ $p = 11; $key = 'woocommerce_shop_loop_item_title';}
        if('rating' == $position && 'after' == $where){ $p = 6; $key = 'woocommerce_after_shop_loop_item_title';}
        if('price' == $position && 'after' == $where){ $p = 11; $key = 'woocommerce_after_shop_loop_item_title';}

        add_action($key,array($this,'the_notice'),$p);
        add_filter( 'woocommerce_product_add_to_cart_text', array($this,'modify_cart_button') );
    } 
    
    public function the_notice(){
        global $product;
        $current_user = wp_get_current_user();
        echo $this->get_notice($current_user,$product);
    }
}
return new wc_previously_bought_product_notifier_Display_Shop_Page;