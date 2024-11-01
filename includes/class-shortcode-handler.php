<?php
class wc_previously_bought_product_notifier_Display_Shortcode_handler {
    public function __construct(){
        add_shortcode("wc_pbpn_product_list",array($this,'render_products_list'));
    }
    
    private function get_all_wc_orders($user_id){
        global $wpdb;        
        $query = "SELECT order_items.order_item_id as item_id ,post.ID  as order_id FROM {$wpdb->posts} as post
        LEFT JOIN {$wpdb->postmeta} as pmeta ON  pmeta.post_id = post.ID 
        INNER JOIN {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id = post.ID
        WHERE post.post_type = 'shop_order' AND pmeta.meta_key = '_customer_user' AND pmeta.meta_value = '$user_id ';"; 
        $result = $wpdb->get_results($query,ARRAY_A);         
        return $result;
    }
    
    public function extract_db_result($result){
        $return = array();
        foreach($result as $data){
             $return[$data['item_id']] = $data['order_id'];
        }
        
        return $return;
    }
    
    public function get_order_items($o){
        global $wpdb;
        $item_ids = array_keys($o);
        $item_ids = implode(',',$item_ids);
        $return = array();
        
        $product_ids = "SELECT meta_value,order_item_id FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` IN ({$item_ids}) AND `meta_key`  = '_product_id'";
        $qtys = "SELECT meta_value,order_item_id FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` IN ({$item_ids}) AND `meta_key` = '_qty' ";
        $variation_ids = "SELECT meta_value,order_item_id FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` IN ({$item_ids}) AND `meta_key` = '_variation_id' ";
        
        $product_ids_result = $wpdb->get_results($product_ids,ARRAY_A);
        $qtys_result = $wpdb->get_results($qtys,ARRAY_A);
        $variation_ids_result = $wpdb->get_results($variation_ids,ARRAY_A);
        
        $variation_ids = wp_list_pluck($variation_ids_result,'meta_value','order_item_id');
        $product_ids = wp_list_pluck($product_ids_result,'meta_value','order_item_id');
        $qtys = wp_list_pluck($qtys_result,'meta_value','order_item_id');
        
        foreach($product_ids as $oid => $pid){
            $order_id = isset($o[$oid]) ? $o[$oid] : null;
            
            if(!is_null($order_id)){
                $qty = isset($qtys[$oid]) ? $qtys[$oid] : 1;
                $vid = isset($variation_ids[$oid]) ? $variation_ids[$oid] : null;
                
                if(! isset($return[$order_id]))
                    $return[$order_id] = array(); 
                
                
                if($vid > 0){
                    if(! isset($return[$order_id][$vid])){
                        $return[$order_id][$vid] = array('qty' => $qty,'is_variation' => true,'product_id' => $pid);
                    } else{
                        
                    }
                } else {
                    $return[$order_id][$pid] = array('qty' => $qty,'is_variation' => false,'product_id' => $pid);
                }
                
                
            }
        }
        
        return $return;
    }
    
    public function consolidate_orders($product_ids){
        $return = array();
        foreach($product_ids as $order_id => $prod){
            foreach($prod as $product_id => $data){
                $array_key = $product_id;
                $xtra_arr = array();
                $xtra_arr = array("order_id" => array($order_id),'is_variation' => false,'variation_id'=>0);
                
                if($data['is_variation'])  {
                    $array_key = $data['product_id'].'_'.$product_id;
                    $xtra_arr['is_variation'] =true;                    
                    $xtra_arr['variation_id'] =$product_id;
                }
                
                
                if(isset($return[$array_key])){
                        $return[$array_key]['qty'] = $return[$array_key]['qty'] + $data['qty'];
                        $return[$array_key]['order_id'][] = $order_id;
                } else {
                    $return[$array_key] = array_merge($xtra_arr,$data);
                }
            }
        }
        
        return $return;
    }
    
    public function render_products_list($args){
        global $wpdb;
        $default_args = array( 
            'user_id' => null, 
            'template' => 'advanced',
            'group_orders' => true,
            'show_image' => true,
            'show_qty' => true,
            'show_action' => true,
            'show_orderdate' => true,
            'show_orderid' => true,
        );
        $args = wp_parse_args($args,$default_args);
        
        if(is_null($args['user_id'])){
            $args['user_id'] = get_current_user_id();
        }
        
        if(intval($args['user_id']) == 0){return '';}
        
        if($args['show_image'] == 'false' && $args['show_image'] == '0'){$args['show_image'] = false;}
        if($args['show_qty'] == 'false' && $args['show_qty'] == '0'){$args['show_qty'] = false;}
        if($args['show_action'] == 'false' && $args['show_action'] == '0'){$args['show_action'] = false;}
        if($args['group_orders'] == 'false' && $args['group_orders'] == '0'){$args['group_orders'] = false;}
        if($args['show_orderdate'] == 'false' && $args['show_orderdate'] == '0'){$args['show_orderdate'] = false;}
        if($args['show_orderid'] == 'false' && $args['show_orderid'] == '0'){$args['show_orderid'] = false;}
        
        
        $orders = $this->get_all_wc_orders($args['user_id']);
        $iorders = $this->extract_db_result($orders);
        $product_ids = $this->get_order_items($iorders);
        
        if($args['template'] == 'simple'){
            $product_ids = $this->consolidate_orders($product_ids);
        }
        
        $templates = apply_filters('wc_pbpn_templates',array('simple' => 'listing-simple.php','advanced' => 'listing-advanced.php'));
        if(isset($templates[$args['template']])){
            return wc_pbpn_get_template('wc_pbpn/'.$templates[$args['template']],array('options' => $args,'orders' => $product_ids));    
        }
        
        return false;
        
        
    }
}
return new wc_previously_bought_product_notifier_Display_Shortcode_handler;