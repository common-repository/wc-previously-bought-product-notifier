<?php
global $fields;
$rich_text_settings = array( 'textarea_rows' => 5, 'media_buttons' => false,  'quicktags' => false);

$attr_fields = 'This field supports html. & Use the below listed attributes to get dynamic information <br/>
            Order ID : <code>{orderID}</code> <br/>
            Order Date : <code>{orderdate}</code> <br/>
            Order View Link : <code>{orderlink}</code> <br/>
            Selected Product Name : <code>{prodname}</code> <br/>';

$single_product_options = array(
    '' => __("Disable / Use Shortcode",WC_PBPN_TXT),
    'title' => __('Product Title',WC_PBPN_TXT),
    'rating' => __('Product Rating',WC_PBPN_TXT),
    'price' => __('Product Price',WC_PBPN_TXT),
    'excerpt' => __('Product Excerpt',WC_PBPN_TXT),
    'add_to_cart' => __('Product Add to cart',WC_PBPN_TXT),
    'meta' => __('Product Meta',WC_PBPN_TXT),
);

    
$loop_product_area = array(
    '' => __("Disable / Use Shortcode",WC_PBPN_TXT),
    'title' => __('Product Title',WC_PBPN_TXT),
    'rating' => __('Product Rating',WC_PBPN_TXT),
    'price' => __('Product Price',WC_PBPN_TXT),
);




$fields['general']['asp'] = array(
    array( 
        'id' => WC_PBPN_DB.'shop_page_pos', 
        'type'    => 'select',
        'options' => $loop_product_area ,
        'label' => __('Notice Position',WC_PBPN_TXT),
        'desc' => __(' Where to show the subtitle ',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'shop_page_where', 
        'type'    => 'select',
        'options' => array('before' => __('Before',WC_PBPN_TXT),'after' => __('After',WC_PBPN_TXT)),
        'label' => __('',WC_PBPN_TXT),
        'desc' => __('Where to show the subtitle',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'shop_page_msg',
        'type'    => 'richtext',
        'value' => html_entity_decode(wc_pbpn_option('shop_page_msg')),
        'richtext_settings' => $rich_text_settings,
        'label' => __('Message To Show',WC_PBPN_TXT),
        'desc' => __($attr_fields,WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;' ),
    ),
    array( 
        'id' => WC_PBPN_DB.'shop_page_theme', 
        'type'    => 'select',
        'options' => array("wc_notice" => __("WC Notice Style",WC_PBPN_TXT),"custom" => __("Custom Style",WC_PBPN_TXT)),
        'label' => __('Display Theme',WC_PBPN_TXT),
        'desc' => __(' How you would like to show it ? ',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'shop_page_date_format',
        'type'    => 'text',
        'label' => __('Date Format',WC_PBPN_TXT),
        'desc' => __('<a href="https://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date and time formatting. </a>',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;' ),
    ),
);


























$fields['general']['spp'] = array(
    array( 
        'id' => WC_PBPN_DB.'single_product_pos', 
        'type'    => 'select',
        'options' => $single_product_options,
        'label' => __('Notice Position',WC_PBPN_TXT),
        'desc' => __(' Where to show the subtitle ',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'single_product_where', 
        'type'    => 'select',
        'options' => array('before' => __('Before',WC_PBPN_TXT),'after' => __('After',WC_PBPN_TXT)),
        'label' => __('',WC_PBPN_TXT),
        'desc' => __('Where to show the subtitle',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'single_product_msg',
        'type'    => 'richtext',
        'value' => html_entity_decode(wc_pbpn_option('single_product_msg')),
        'richtext_settings' => $rich_text_settings,
        'label' => __('Message To Show',WC_PBPN_TXT),
        'desc' => __($attr_fields,WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;' ),
    ),
    array( 
        'id' => WC_PBPN_DB.'single_product_theme', 
        'type'    => 'select',
        'options' => array("wc_notice" => __("WC Notice Style",WC_PBPN_TXT),"custom" => __("Custom Style",WC_PBPN_TXT)),
        'label' => __('Display Theme',WC_PBPN_TXT),
        'desc' => __(' How you would like to show it ? ',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%', 'class' => 'wc-enhanced-select' ),
    ),
    array(
        'id' => WC_PBPN_DB.'single_product_date_format',
        'type'    => 'text',
        'label' => __('Date Format',WC_PBPN_TXT),
        'desc' => __('<a href="https://codex.wordpress.org/Formatting_Date_and_Time">Documentation on date and time formatting. </a>',WC_PBPN_TXT), 
        'attr'    => array('style' => 'width:50%;' ),
    ),     
);

$fields['general']['asp']  = array_merge($fields['general']['asp'] ,wc_pbpn_get_type_based_fields('shop_page'));
$fields['general']['spp']  = array_merge($fields['general']['spp'] ,wc_pbpn_get_type_based_fields('single_product'));