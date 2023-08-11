<?php
/*
Plugin Name: Customer Service Management
Description: Plugin quản lý khách hàng và dịch vụ web site
Version: 1.0
Author: Your Name
*/



// Enqueue your scripts and styles for the admin interface
function customer_service_enqueue_admin_assets() {
    wp_enqueue_style('customer-service-admin-style', plugins_url('admin/assets/css/style.css', __FILE__));
    wp_enqueue_script('customer-service-admin-script', plugins_url('admin/assets/js/index.js', __FILE__), array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'customer_service_enqueue_admin_assets');


// Your plugin logic for customer and service management goes here

include_once plugin_dir_path(__FILE__) . 'admin/customer-service.php';
include_once plugin_dir_path(__FILE__) . 'admin/templates/service-list.php';
