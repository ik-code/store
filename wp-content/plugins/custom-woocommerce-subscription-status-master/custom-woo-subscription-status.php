<?php

/**
 * A sample plugin to demonstrate how to create a custom Woocommerce Subscription status
 * For demonstration we will be implementing `On Hold` like functionality, and name the new status `Canceled by user`
 * Things covered in this sample plugin are :-
 * - Add new status to the status list.
 * - Show new status in drop down only if the current subscription has certain status.
 * - Handle update code for new status.
 * - Show status option in bulk action dropdown on the listing page
 * - Add custom color for the new status tag on the list page
 * - Handle bulk update action
 * - Add Same status in Woocommerce
 * - Mark all subscription in an order with same status if status is changed from woocommerce order page.
 *
 * @package custom-woocommerce-subscription-status
 *
 * Plugin Name:       Custom Woocommerce Subscription Status.
 * Description:       A sample plugin to demostrate how to add a new custom woocommerce subscription status called `Canceled by user` which works similart to `On Hold`.
 * Version:           1.0.0
 * Author:            
 * Author URI:        http://wisdmLabs.com/
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require plugin_dir_path(__FILE__) . 'class-custom-woocommerce-subscriptions-status.php';
$CWSS = new Custom_Woocommerce_Subscription_Status();
$CWSS->run(); // initiate the status hooks from woocommerce subscription

require plugin_dir_path(__FILE__) . 'class-custom-woocommerce-status-for-subscription.php';
$CWSFS = new Custom_Woocommerce_Status_For_Subscription();
$CWSFS->run(); // initiate the status hooks from woocommerce
