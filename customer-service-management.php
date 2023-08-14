<?php
/*
 * Customer Service Management
 *
 * Plugin Name: Customer Service Management
 * Description: Manage customer and service information, renew reminders quickly 
 * Version: 1.1.0
 * Author: Huu Phuoc DEV
 * Author URI:  https://www.facebook.com/tranhuuphuoc.0305/
 * Text Domain: csm
 * Requires PHP: 7.4.19
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
*/


// Enqueue your scripts and styles for the admin interface
function customer_service_enqueue_admin_assets() {
    wp_enqueue_script('select2', plugins_url('admin/assets/select2/select2.min.js',  __FILE__), array('jquery'), null, true);
    wp_enqueue_script('customer-service-admin-script', plugins_url('admin/assets/js/index.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('select2-script', plugins_url('admin/assets/js/custom-select2.js',  __FILE__), array('jquery'), null, true);


    wp_enqueue_style('select2', plugins_url('admin/assets/select2/select2.min.css', __FILE__), array());
    wp_enqueue_style('customer-service-admin-style', plugins_url('admin/assets/css/style.css', __FILE__), array());

}
add_action('admin_enqueue_scripts', 'customer_service_enqueue_admin_assets');


// Your plugin logic for customer and service management goes here
include_once plugin_dir_path(__FILE__) . 'admin/templates/renew_settings_page.php';
include_once plugin_dir_path(__FILE__) . 'admin/customer-service.php';
include_once plugin_dir_path(__FILE__) . 'admin/templates/service-list.php';

