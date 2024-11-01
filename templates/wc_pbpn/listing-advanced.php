<table class="product_listing simple">
    <thead>
        <tr>
            <?php if(!$options['group_orders']) : ?> <td><?php _e("Order",WC_PBPN_TXT); ?> </td> <?php endif; ?>            
            <td><?php _e("Product Name",WC_PBPN_TXT); ?> </td>
            <?php if($options['show_qty']) : ?> <td> <?php _e("Qty",WC_PBPN_TXT); ?> </td> <?php endif; ?>
            <?php if($options['show_action']) : ?> <td> <?php _e("Action",WC_PBPN_TXT); ?> </td> <?php endif; ?>
        </tr>
    </thead>

    <tbody>

        <?php
        foreach($orders as $order_id => $order_data){
            $order = new WC_Order($order_id);
            $oid = $order->get_order_number();
            
            $title = sprintf(__("View %s Order",WC_PBPN_TXT),'#'.$oid);
            $order_url = wc_get_endpoint_url( 'view-order', $order_id, wc_get_page_permalink( 'myaccount' ) );
            $id = '';
            $order_date = '';
            if($options['show_orderdate'])
                $order_date = get_the_date(null,$id);

            if($options['show_orderid'])
                $id = '#'.$oid;
            
            $order_links = '<a title="'.$title.'" href="'.$order_url.'" >'.$id.' '.$order_date.'</a>';
        ?>
            <?php if($options['group_orders']) : ?>
                <tr class="order_group_tr"><td class="order_group_td" colspan="3"> <?php echo $order_links; ?> </td></tr>
            <?php endif; ?>
        <?php    
            foreach($order_data as $pid => $order){
                $product_id = $order['product_id']; 
                if($order['is_variation']){$product_id = $pid;}
                $product = wc_get_product($product_id);
                if(!$product){continue;}
                $image = $product->get_image();
                $name = '';
                if(method_exists($product,'get_name')){
                    $name = $product->get_name();
                } else {
                    $name = $product->get_title();
                }
                $link = $product->get_permalink();
                $qty  = $order['qty'];
                $cartUrl = add_query_arg('quantity',$qty,$product->add_to_cart_url());
        ?>

        <tr>
            <?php if(!$options['group_orders']) : ?> <td class="order_id"> <?php echo $order_links; ?> </td> <?php endif; ?>
            <td class="product_info">
                <?php if($options['show_image']) : ?> <a class="image" href="<?php echo $link; ?>" title="<?php echo $name; ?>"> <?php echo $image; ?> </a> <?php endif; ?>
                <a class="product_title" href="<?php echo $link; ?>" title="<?php echo $name; ?>"> <?php echo $name; ?> </a>
            </td>
            <?php if($options['show_qty']) : ?> <td class="qty"> <?php echo $qty; ?> </td> <?php endif; ?>
            <?php if($options['show_action']) : ?> <td class="actions"> <a href="<?php echo $cartUrl; ?>" class="button"> <?php _e("Order Again"); ?> </a> </td> <?php endif; ?>
        </tr>
    <?php } } ?>
    </tbody>
    
    <tfoot>
        <tr>
            <?php if(!$options['group_orders']) : ?> <td><?php _e("Order",WC_PBPN_TXT); ?> </td> <?php endif; ?>
            <td><?php _e("Product Name",WC_PBPN_TXT); ?> </td>
            <?php if($options['show_qty']) : ?> <td> <?php _e("Qty",WC_PBPN_TXT); ?> </td> <?php endif; ?>            
            <?php if($options['show_action']) : ?> <td> <?php _e("Action",WC_PBPN_TXT); ?> </td> <?php endif; ?>
        </tr>
    </tfoot>
</table>
