<?php
// admin/customer-service.php

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
        'menu_icon' => 'dashicons-hammer',
        'has_archive' => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'register_service_post_type');


// Add meta box for customer information
function customer_information_meta_box() {
    add_meta_box(
        'customer_info_meta',
        'Customer Information',
        'render_customer_information_meta_box',
        'customer',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'customer_information_meta_box');

// Render customer information meta box
function render_customer_information_meta_box($post) {
    // Retrieve customer information fields
    $customer_address = get_post_meta($post->ID, 'customer_address', true);
    $customer_mst = get_post_meta($post->ID, 'customer_mst', true);
    $customer_email = get_post_meta($post->ID, 'customer_email', true);
    $customer_phone = get_post_meta($post->ID, 'customer_phone', true);

    // Output fields in the meta box
    ?>
    <p>
        <label for="customer_address">Address:</label><br>
        <input type="text" id="customer_address" name="customer_address" value="<?php echo esc_attr($customer_address); ?>">
    </p>
    <p>
        <label for="customer_mst">MST:</label><br>
        <input type="text" id="customer_mst" name="customer_mst" value="<?php echo esc_attr($customer_mst); ?>">
    </p>
    <p>
        <label for="customer_email">Email:</label><br>
        <input type="email" id="customer_email" name="customer_email" value="<?php echo esc_attr($customer_email); ?>">
    </p>
    <p>
        <label for="customer_phone">Phone:</label><br>
        <input type="tel" id="customer_phone" name="customer_phone" value="<?php echo esc_attr($customer_phone); ?>">
    </p>
    <?php
}

// Save customer information
function save_customer_information($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    // Save customer information fields
    update_post_meta($post_id, 'customer_address', sanitize_text_field($_POST['customer_address']));
    update_post_meta($post_id, 'customer_mst', sanitize_text_field($_POST['customer_mst']));
    update_post_meta($post_id, 'customer_email', sanitize_email($_POST['customer_email']));
    update_post_meta($post_id, 'customer_phone', sanitize_text_field($_POST['customer_phone']));
}
add_action('save_post_customer', 'save_customer_information');

// Add meta box for service information
function service_information_meta_box() {
    add_meta_box(
        'service_info_meta',
        'Service Information',
        'render_service_information_meta_box',
        'service',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'service_information_meta_box');

// Render service information meta box
function render_service_information_meta_box($post) {
    // Retrieve service information fields
    $service_name = get_post_meta($post->ID, 'service_name', true);
    $service_price = get_post_meta($post->ID, 'service_price', true);
    $service_vat = get_post_meta($post->ID, 'service_vat', true);
    $service_start_date = get_post_meta($post->ID, 'service_start_date', true);
    $service_end_date = get_post_meta($post->ID, 'service_end_date', true);
    $service_customer = get_post_meta($post->ID, 'service_customer', true);

    // Output fields in the meta box
    ?>
    <p>
        <label for="service_name">Service:</label><br>
        <input type="text" id="service_name" name="service_name" value="<?php echo esc_attr($service_name); ?>">
    </p>
    <p>
        <label for="service_price">Price:</label><br>
        <input type="number" step="0.01" id="service_price" name="service_price" value="<?php echo esc_attr($service_price); ?>">
    </p>
    <p>
        <label for="service_vat">VAT:</label><br>
        <input type="number" step="0.01" id="service_vat" name="service_vat" value="<?php echo esc_attr($service_vat); ?>">
    </p>
    <p>
        <label for="service_start_date">Start Date:</label><br>
        <input type="date" id="service_start_date" name="service_start_date" value="<?php echo esc_attr($service_start_date); ?>">
    </p>
    <p>
        <label for="service_end_date">End Date:</label><br>
        <input type="date" id="service_end_date" name="service_end_date" value="<?php echo esc_attr($service_end_date); ?>">
    </p>
    <p>
        <label for="service_customer">Select Customer:</label><br>
        <select id="service_customer" name="service_customer">
            <?php
            $customers = get_posts(array(
                'post_type' => 'customer',
                'posts_per_page' => -1,
            ));

            foreach ($customers as $customer) {
                echo '<option value="' . $customer->ID . '" ' . selected($customer->ID, $service_customer, false) . '>' . esc_html($customer->post_title) . '</option>';
            }
            ?>
        </select>
    </p>
    <?php
}

// Save service information
function save_service_information($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    // Save service information fields
    update_post_meta($post_id, 'service_name', sanitize_text_field($_POST['service_name']));
    update_post_meta($post_id, 'service_price', sanitize_text_field($_POST['service_price']));
    update_post_meta($post_id, 'service_vat', sanitize_text_field($_POST['service_vat']));
    update_post_meta($post_id, 'service_start_date', sanitize_text_field($_POST['service_start_date']));
    update_post_meta($post_id, 'service_end_date', sanitize_text_field($_POST['service_end_date']));
    update_post_meta($post_id, 'service_customer', intval($_POST['service_customer']));
}
add_action('save_post_service', 'save_service_information');
