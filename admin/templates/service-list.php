<?php
function service_page_callback() {
    // Trang hiển thị thông tin dịch vụ
    echo '<div class="wrap">';
    echo '<h2>Quản lý Dịch vụ</h2>';

    // Hiển thị danh sách dịch vụ theo thứ tự ưu tiên
    $services_list = get_services_list();

    $current_page = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
    $items_per_page = 10;
    $total_items = count($services_list);
    $total_pages = ceil($total_items / $items_per_page);

    $start_index = ($current_page - 1) * $items_per_page;
    $end_index = min($start_index + $items_per_page, $total_items);

    if (!empty($services_list)) {
        echo '<table id="service-list-table" class="wp-list-table widefat fixed">';
        echo '<thead><tr>';
        echo '<th class="column-id">ID</th>';
        echo '<th>Dịch vụ</th>';
        echo '<th>Tên khách hàng</th>';
        echo '<th>Giá</th>';
        echo '<th>VAT</th>';
        echo '<th>Ngày tạo</th>';
        echo '<th>Ngày hết hạn</th>';
        echo '<th>Trạng thái</th>';
        echo '<th></th>'; // Thêm cột Action
        echo '</tr></thead><tbody>';

        for ($i = $start_index; $i < $end_index; $i++) {
            $service = $services_list[$i];
            echo '<tr>';
            echo '<td class="column-id">' . $service['id'] . '</td>';
            echo '<td>' . $service['name'] . '</td>';
            echo '<td>' . $service['customer_name'] . '</td>'; // Hiển thị tên khách hàng
            echo '<td>' . $service['price'] . ' đ</td>';
            echo '<td>' . $service['vat'] . '%</td>';
            echo '<td>' . $service['start_date'] . '</td>';
            echo '<td>' . $service['end_date'] . '</td>';
            echo '<td>' . $service['status'] . '</td>';
            echo '<td><button class="button button-secondary btn-bao-gia-han" data-service-id="' . $service['id'] . 
            '" data-service-name="' . $service['name'] . '" data-price="' . $service['price'] . '" data-vat="' . $service['vat'] . '" data-start-date="' . $service['start_date_formatted'] .
            '" data-end-date="' . $service['end_date'] . '" data-end-date-new="' . $service['end_date_formatted'] . '">Báo gia hạn</button></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';

        // Hiển thị phân trang
        echo '<div class="tablenav">';
        echo '<div class="tablenav-pages">';
        echo paginate_links(array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $total_pages,
            'current' => $current_page,
        ));
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>Không có dịch vụ nào.</p>';
    }

    // Hiển thị form cấu hình gia hạn
    $configuration_content = get_option('service_extension_content', '');
    echo '<form method="post" action="">';
    echo '<input type="hidden" id="service-extension-content" value="' . esc_attr($configuration_content) . '">';
    echo '</form>';

    // Popup template
    echo '<div id="bao-gia-han-popup" class="hidden"><div class="popup-content"></div><button id="copy-text-btn" class="button button-secondary">Copy Text</button></div>';

    echo '</div>';
}

function get_services_list() {
    $services = get_posts(array('post_type' => 'service', 'numberposts' => -1));

    $services_list = array();

    foreach ($services as $service) {
        $service_id = $service->ID;
        $service_name = get_post_meta($service_id, 'service_name', true);
        $price = get_post_meta($service_id, 'service_price', true);
        $vat = get_post_meta($service_id, 'service_vat', true);
        $start_date = get_post_meta($service_id, 'service_start_date', true);
        $end_date = get_post_meta($service_id, 'service_end_date', true);

        // Truy xuất thông tin khách hàng
        $customer_id = get_post_meta($service_id, 'service_customer', true);
        $customer_name = get_the_title($customer_id); // Lấy tên khách hàng từ ID

        $status = '';
        $today = date('Y-m-d');
        if ($end_date >= $today && $end_date <= date('Y-m-d', strtotime('+30 days'))) {
            $status = '<span style="background-color: orange;color: #fff;padding: 3px 7px;">Sắp hết hạn</span>';
        } elseif ($end_date < $today) {
            $status = '<span style="background-color: red;color: #fff;padding: 3px 7px;">Quá hạn</span>';
        } else {
            $status = 'Hoạt động';
        }

        $start_date = date('d-m-Y', strtotime($start_date));
        $end_date = date('d-m-Y', strtotime($end_date));

        $price = number_format($price, 0, '.', ',');
        $start_date_formatted = date('d-m-Y', strtotime($end_date));
        $end_date_formatted = date('d-m-Y', strtotime($end_date . ' +1 year'));

        $services_list[] = array(
            'id' => $service_id,
            'name' => $service_name,
            'customer_name' => $customer_name,
            'price' => $price,
            'vat' => $vat,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'start_date_formatted' => $start_date_formatted,
            'end_date_formatted' => $end_date_formatted,
        );
    }

    // Sắp xếp danh sách theo thứ tự ưu tiên
    usort($services_list, 'compare_services');

    return $services_list;
}
function compare_services($a, $b) {
    $status_order = array(
        '<span style="background-color: orange;color: #fff;padding: 3px 7px;">Sắp hết hạn</span>' => 1,
        'Hoạt động' => 3,
        '<span style="background-color: red;color: #fff;padding: 3px 7px;">Quá hạn</span>' => 2,
    );

    $status_a = $a['status'];
    $status_b = $b['status'];

    return $status_order[$status_a] - $status_order[$status_b];
}




function add_service_page_to_menu() {
    add_submenu_page(
        'edit.php?post_type=service', // Menu "Pages"
        'Quản lý Dịch vụ',          // Tiêu đề trang
        'Quản lý Dịch vụ',          // Tên hiển thị trên menu
        'manage_options',          // Quyền truy cập
        'service_management',      // Slug trang
        'service_page_callback'    // Hàm callback để hiển thị nội dung trang
    );
}

add_action('admin_menu', 'add_service_page_to_menu');
