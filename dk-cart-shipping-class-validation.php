<?php

/**
 * @link              d.kasperavicius@gmail.com
 * @since             1.0.0
 * @package           Dk_Cart_Shipping_Class_Validation
 * @wordpress-plugin
 * Plugin Name:       Only one shipping class in the cart
 * Description:       Ability to add products to the cart only with the same shipping class
 * Plugin URI:        d.kasperavicius@gmail.com
 * Version:           1.0.0
 * Author:            Dainius Kasperavicius
 * Author URI:        d.kasperavicius@gmail.com
 * Text Domain:       dk-cart-shipping-class-validation
 */

if (!defined('WPINC')) {
    die;
}

function dk_shipping_class_add_to_cart_validation($passed, $product_id)
{
    if (WC()->cart->get_cart_contents_count() > 0) {
        $cartItemShippingClass = array_values(WC()->cart->get_cart())[0]['data']->get_shipping_class_id();
        $shippingClass = wc_get_product($product_id)->get_shipping_class_id();
        if ($cartItemShippingClass !== $shippingClass) {
            wc_add_notice(
                apply_filters(
                    'dk_shipping_class_add_to_cart_validation_error_message',
                    __(
                        'Unable add to the cart. Cart items have different shipping classes.',
                        'dk-cart-shipping-class-validation'
                    )
                ),
                'error'
            );

            return false;
        }
    }

    return $passed;
}

add_filter('woocommerce_add_to_cart_validation', 'dk_shipping_class_add_to_cart_validation', 1, 2);
