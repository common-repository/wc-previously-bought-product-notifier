<table class="product_listing simple">
    <thead>
        <tr>
            <td><?php _e("Product Name",WC_PBPN_TXT); ?> </td>
            <td><?php _e("Related Order",WC_PBPN_TXT); ?> </td>
            <?php if($options['show_qty']) : ?> <td> <?php _e("Qty",WC_PBPN_TXT); ?> </td> <?php endif; ?>
            <?php if($options['show_action']) : ?> <td> <?php _e("Action",WC_PBPN_TXT); ?> </td> <?php endif; ?>
        </tr>
    </thead>

    <tbody>

        <?php
            foreach($orders as $order){
                $product_id = $order['product_id'];
                if($order['is_variation']){$product_id = $order['variation_id'];}
                $product = wc_get_product($product_id);
                if(!$product){continue;}
                
                $name = '';
                if(method_exists($product,'get_name')){
                    $name = $product->get_name();
                } else {
                    $name = $product->get_title();
                }
                
                $image = $product->get_image(); 
                $link = $product->get_permalink();
                $qty  = $order['qty'];
                
                $cartUrl = add_query_arg('quantity',$qty,$product->add_to_cart_url());
                
                $order_links = array();
                if(is_array($order['order_id'])){
                    foreach($order['order_id'] as $id){
                        $order = new WC_Order($id);
                        $oid = $order->get_order_number();

                        $title = sprintf(__("View %s Order",WC_PBPN_TXT),'#'.$oid);
                        $order_date = '';
                        $order_id = '';
                        $order_url = wc_get_endpoint_url( 'view-order', $id, wc_get_page_permalink( 'myaccount' ) );
                        
                        if($options['show_orderdate'])
                            $order_date = get_the_date(null,$id);
                        
                        if($options['show_orderid'])
                            $order_id = '#'.$oid;
                        
                        $order_links[] = '<a title="'.$title.'" href="'.$order_url.'" >'.$order_id.' '.$order_date.'</a>';
                    }
                }
                
                $order_links = '<ul><li>'.implode($order_links,'</li><li>').'</li></ul>';
        ?>

            <tr>
                <td class="product_info">
                    <?php if($options['show_image']) : ?> <a class="image" href="<?php echo $link; ?>" title="<?php echo $name; ?>"> <?php echo $image; ?> </a> <?php endif; ?>
                    <a class="product_title" href="<?php echo $link; ?>" title="<?php echo $name; ?>"> <?php echo $name; ?> </a>
                </td>
                <td> <?php echo $order_links; ?> </td>
                <?php if($options['show_qty']) : ?> <td class="qty"> <?php echo $qty; ?> </td> <?php endif; ?>
                <?php if($options['show_action']) : ?> <td class="actions"> <a href="<?php echo $cartUrl; ?>" class="button"> <?php _e("Order Again"); ?> </a> </td> <?php endif; ?>
            </tr>

            <?php
                
            }   
        ?>
    </tbody>



    <tfoot>
        <tr>
            <td><?php _e("Product Name",WC_PBPN_TXT); ?> </td>
            <td><?php _e("Related Order",WC_PBPN_TXT); ?> </td>
            <?php if($options['show_qty']) : ?> <td> <?php _e("Qty",WC_PBPN_TXT); ?> </td> <?php endif; ?>
            <?php if($options['show_action']) : ?> <td> <?php _e("Action",WC_PBPN_TXT); ?> </td> <?php endif; ?>
        </tr>
    </tfoot>
</table>
