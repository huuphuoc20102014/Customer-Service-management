<?php
// admin/customer-service.php

// Tạo post type "Customer"
function create_customer_post_type() {
    register_post_type('customer', array(
        'labels' => array(
            'name' => 'Customers',
            'singular_name' => 'Customer',
        ),
        'public' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-businessman',
    ));
}
add_action('init', 'create_customer_post_type');

// Tạo post type "Service"
function create_service_post_type() {
    register_post_type('service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
        ),
        'public' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-hammer',
    ));
}
add_action('init', 'create_service_post_type');

// Thêm các trường tùy chỉnh vào post type "Customer"
function add_customer_custom_fields() {
    add_meta_box('customer_fields', 'Customer Information', 'render_customer_fields', 'customer', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_customer_custom_fields');

// Hiển thị form nhập thông tin khách hàng
function render_customer_fields($post) {
    // Lấy giá trị hiện tại của các trường
    $customer_address = get_post_meta($post->ID, 'customer_address', true);
    $customer_tax_number = get_post_meta($post->ID, 'customer_tax_number', true);
    $customer_email = get_post_meta($post->ID, 'customer_email', true);
    $customer_phone = get_post_meta($post->ID, 'customer_phone', true);
    ?>
    <label for="customer_address">Address:</label>
    <input type="text" name="customer_address" value="<?php echo esc_attr($customer_address); ?>"><br>

    <label for="customer_tax_number">Tax Number:</label>
    <input type="text" name="customer_tax_number" value="<?php echo esc_attr($customer_tax_number); ?>"><br>

    <label for="customer_email">Email:</label>
    <input type="email" name="customer_email" value="<?php echo esc_attr($customer_email); ?>"><br>

    <label for="customer_phone">Phone:</label>
    <input type="tel" name="customer_phone" value="<?php echo esc_attr($customer_phone); ?>"><br>
    <?php
}

// Lưu thông tin khách hàng khi được tạo hoặc cập nhật
function save_customer_custom_fields($post_id) {
    if (array_key_exists('customer_address', $_POST)) {
        update_post_meta($post_id, 'customer_address', sanitize_text_field($_POST['customer_address']));
    }
    if (array_key_exists('customer_tax_number', $_POST)) {
        update_post_meta($post_id, 'customer_tax_number', sanitize_text_field($_POST['customer_tax_number']));
    }
    if (array_key_exists('customer_email', $_POST)) {
        update_post_meta($post_id, 'customer_email', sanitize_email($_POST['customer_email']));
    }
    if (array_key_exists('customer_phone', $_POST)) {
        update_post_meta($post_id, 'customer_phone', sanitize_text_field($_POST['customer_phone']));
    }
}
add_action('save_post_customer', 'save_customer_custom_fields');

// Thêm trường chọn khách hàng vào post type "Service"
function add_service_customer_field() {
    add_meta_box('service_customer_field', 'Select Customer', 'render_service_customer_field', 'service', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_service_customer_field');

// Hiển thị dropdown chọn khách hàng trong trang tạo/sửa dịch vụ
function render_service_customer_field($post) {
    $customers = get_posts(array(
        'post_type' => 'customer',
        'numberposts' => -1,
    ));
    ?>
    <label for="service_customer">Select Customer:</label>
    <select name="service_customer" id="service_customer">
        <option value="">Select a customer</option>
        <?php foreach ($customers as $customer) : ?>
            <option value="<?php echo $customer->ID; ?>" <?php selected(get_post_meta($post->ID, 'service_customer', true), $customer->ID); ?>><?php echo get_the_title($customer->ID); ?></option>
        <?php endforeach; ?>
    </select><br>
    <?php
}

// Lưu thông tin khách hàng cho dịch vụ
function save_service_customer_field($post_id) {
    if (array_key_exists('service_customer', $_POST)) {
        update_post_meta($post_id, 'service_customer', sanitize_text_field($_POST['service_customer']));
    }
}
add_action('save_post_service', 'save_service_customer_field');
?>
