<?php

if ( ! defined( 'WPINC' ) ) { die; }

class wc_previously_bought_product_notifier_Product_Handler {
	public function __construct() {
        $this->selected_order = null;
        $this->selected_order_date = null;
    }
 
    private function get_users_orders($user_id,$product_id){
        global $wpdb;
        $query = "SELECT post.ID , post.post_date  FROM {$wpdb->posts} as post
        LEFT JOIN {$wpdb->postmeta} as pmeta ON  pmeta.post_id = post.ID 
        INNER JOIN {$wpdb->prefix}woocommerce_order_items as order_items ON order_items.order_id = post.ID 
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_meta ON order_meta.order_item_id = order_items.order_item_id AND order_meta.meta_key = '_product_id' AND order_meta.meta_value = {$product_id} 
        WHERE post.post_type = 'shop_order' AND pmeta.meta_key = '_customer_user' AND pmeta.meta_value = '$user_id' ;";
        $orders = $wpdb->get_results($query);
        $order_dates = wp_list_pluck($orders,'ID','post_date');
        return $order_dates;
    }
    
    public function sort_order_dates($order_dates){
        usort($order_dates, "wc_pbpn_date_sort");
        return $order_dates;
    }
    
    public function check_product_status($user_email,$user_id,$product_id){
        if ( is_user_logged_in() ) {
            if(wc_customer_bought_product($user_email, $user_id, $product_id) ){

                $order_dates = $this->get_users_orders($user_id,$product_id);
                $order_date = array_keys($order_dates);
                $order_ids = array_values($order_dates);
                $order_date = $this->sort_order_dates($order_date);
                $selected_date = $order_date[0];

                if(isset($order_dates[$selected_date])){ 
                    $selected_order_id = $order_dates[$selected_date]; 
                    $order = new WC_Order($selected_order_id);
                    return array('order_id' => $selected_order_id,'order_date' => $selected_date,'order' => $order);
                }
            } else {
                return false;
            }          
        }
        return false;
    }
    
    
    public function woo_in_cart($product_id) {
        global $woocommerce;
        foreach($woocommerce->cart->get_cart() as $key => $val ) { 
            $_product = $val['data']; 
            if($product_id == $_product->get_id() ) { return true; } }
        return false;
    }
}