<?php
// Register custom post type for Customers
function register_customer_post_type() {
    $labels = array(
        'name' => 'Customers',
        'singular_name' => 'Customer',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Customer',
        'edit_item' => 'Edit Customer',
        'new_item' => 'New Customer',
        'view_item' => 'View Customer',
        'search_items' => 'Search Customers',
        'not_found' => 'No customers found',
        'not_found_in_trash' => 'No customers found in Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'supports' => array('title'),
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-businessman',
        'has_archive' => true,
    );

    register_post_type('customer', $args);
}
add_action('init', 'register_customer_post_type');
// Register custom post type for Services
function register_service_post_type() {
    $labels = array(
        'name' => 'Services',
        'singular_name' => 'Service',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Service',
        'edit_item' => 'Edit Service',
        'new_item' => 'New Service',
        'view_item' => 'View Service',
        'search_items' => 'Search Services',
        'not_found' => 'No services found',
        'not_found_in_trash' => 'No services found in Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'supports' => array('title'),
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-portfolio',
        'has_archive' => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'register_service_post_type');


//Tạo Trường Nhập Thông Tin Khách Hàng:
function add_customer_meta_box() {
    add_meta_box('customer_info', 'Thông tin khách hàng', 'customer_info_callback', 'customer', 'normal', 'high');
}

function customer_info_callback($post) {
    // Lấy dữ liệu từ post meta
    $name = get_post_meta($post->ID, '_customer_name', true);
    $address = get_post_meta($post->ID, '_customer_address', true);
    $tax_code = get_post_meta($post->ID, '_customer_tax_code', true);
    $email = get_post_meta($post->ID, '_customer_email', true);
    $phone = get_post_meta($post->ID, '_customer_phone', true);

    // Hiển thị trường nhập
    echo '<label for="customer_name">Tên:</label>';
    echo '<input type="text" id="customer_name" name="customer_name" value="' . esc_attr($name) . '"><br>';

    echo '<label for="customer_address">Địa chỉ:</label>';
    echo '<input type="text" id="customer_address" name="customer_address" value="' . esc_attr($address) . '"><br>';

    echo '<label for="customer_tax_code">MST:</label>';
    echo '<input type="text" id="customer_tax_code" name="customer_tax_code" value="' . esc_attr($tax_code) . '"><br>';

    echo '<label for="customer_email">Email:</label>';
    echo '<input type="email" id="customer_email" name="customer_email" value="' . esc_attr($email) . '"><br>';

    echo '<label for="customer_phone">SĐT:</label>';
    echo '<input type="tel" id="customer_phone" name="customer_phone" value="' . esc_attr($phone) . '"><br>';
}
function save_customer_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'customer') {
        update_post_meta($post_id, '_customer_name', sanitize_text_field($_POST['customer_name']));
        update_post_meta($post_id, '_customer_address', sanitize_text_field($_POST['customer_address']));
        update_post_meta($post_id, '_customer_tax_code', sanitize_text_field($_POST['customer_tax_code']));
        update_post_meta($post_id, '_customer_email', sanitize_email($_POST['customer_email']));
        update_post_meta($post_id, '_customer_phone', sanitize_text_field($_POST['customer_phone']));
    }
}

add_action('add_meta_boxes', 'add_customer_meta_box');
add_action('save_post', 'save_customer_meta');

//Tạo Trường Nhập Thông Tin Dịch Vụ:
function add_service_meta_box() {
    add_meta_box('service_info', 'Thông tin dịch vụ', 'service_info_callback', 'service', 'normal', 'high');
}

function service_info_callback($post) {
    // Lấy dữ liệu từ post meta
    $service_name = get_post_meta($post->ID, '_service_name', true);
    $price = get_post_meta($post->ID, '_service_price', true);
    $vat = get_post_meta($post->ID, '_service_vat', true);
    $start_date = get_post_meta($post->ID, '_service_start_date', true);
    $end_date = get_post_meta($post->ID, '_service_end_date', true);

    // Hiển thị trường nhập
    echo '<label for="service_name">Dịch vụ:</label>';
    echo '<input type="text" id="service_name" name="service_name" value="' . esc_attr($service_name) . '"><br>';

    echo '<label for="service_price">Giá:</label>';
    echo '<input type="number" id="service_price" name="service_price" value="' . esc_attr($price) . '"><br>';

    echo '<label for="service_vat">VAT:</label>';
    echo '<input type="number" id="service_vat" name="service_vat" value="' . esc_attr($vat) . '"><br>';

    echo '<label for="service_start_date">Ngày tạo:</label>';
    echo '<input type="date" id="service_start_date" name="service_start_date" value="' . esc_attr($start_date) . '"><br>';

    echo '<label for="service_end_date">Ngày hết hạn:</label>';
    echo '<input type="date" id="service_end_date" name="service_end_date" value="' . esc_attr($end_date) . '"><br>';

    // Dropdown chọn khách hàng
    $customers = get_posts(array('post_type' => 'customer', 'numberposts' => -1));
    echo '<label for="customer_id">Chọn khách hàng:</label>';
    echo '<select id="customer_id" name="customer_id">';
    echo '<option value="">-- Chọn khách hàng --</option>';
    foreach ($customers as $customer) {
        echo '<option value="' . $customer->ID . '" ' . selected($customer->ID, get_post_meta($post->ID, '_customer_id', true), false) . '>' . $customer->post_title . '</option>';
    }
    echo '</select><br>';
}

function save_service_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['post_type']) && $_POST['post_type'] == 'service') {
        update_post_meta($post_id, '_service_name', sanitize_text_field($_POST['service_name']));
        update_post_meta($post_id, '_service_price', sanitize_text_field($_POST['service_price']));
        update_post_meta($post_id, '_service_vat', sanitize_text_field($_POST['service_vat']));
        update_post_meta($post_id, '_service_start_date', sanitize_text_field($_POST['service_start_date']));
        update_post_meta($post_id, '_service_end_date', sanitize_text_field($_POST['service_end_date']));
        update_post_meta($post_id, '_customer_id', sanitize_text_field($_POST['customer_id']));
    }
}

add_action('add_meta_boxes', 'add_service_meta_box');
add_action('save_post', 'save_service_meta');

include_once plugin_dir_path(__FILE__) . 'admin/customer-service.php';
