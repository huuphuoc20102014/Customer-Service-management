function service_page_callback() {
    // Trang hiển thị thông tin dịch vụ
    echo '<div class="wrap">';
    echo '<h2>Quản lý Dịch vụ</h2>';

    // Hiển thị danh sách dịch vụ
    $services = get_posts(array('post_type' => 'service', 'numberposts' => -1));
    if (!empty($services)) {
        echo '<table class="wp-list-table widefat fixed">';
        echo '<thead><tr>';
        echo '<th>ID</th>';
        echo '<th>Dịch vụ</th>';
        echo '<th>Giá</th>';
        echo '<th>VAT</th>';
        echo '<th>Ngày tạo</th>';
        echo '<th>Ngày hết hạn</th>';
        echo '<th>Trạng thái</th>';
        echo '<th>Action</th>'; // Thêm cột Action
        echo '</tr></thead><tbody>';

        foreach ($services as $service) {
            $service_id = $service->ID;
            $service_name = get_post_meta($service_id, 'service_name', true);
            $price = get_post_meta($service_id, 'service_price', true);
            $vat = get_post_meta($service_id, 'service_vat', true);
            $start_date = get_post_meta($service_id, 'service_start_date', true);
            $end_date = get_post_meta($service_id, 'service_end_date', true);

            $status = '';
            $today = date('Y-m-d');
            if ($end_date >= $today && $end_date <= date('Y-m-d', strtotime('+30 days'))) {
                $status = '<span style="background-color: orange;">Sắp hết hạn</span>';
            } elseif ($end_date < $today) {
                $status = '<span style="background-color: red;">Quá hạn</span>';
            } else {
                $status = 'Hoạt động';
            }

            echo '<tr>';
            echo '<td>' . $service_id . '</td>';
            echo '<td>' . $service_name . '</td>';
            echo '<td>' . $price . '</td>';
            echo '<td>' . $vat . '%</td>';
            echo '<td>' . $start_date . '</td>';
            echo '<td>' . $end_date . '</td>';
            echo '<td>' . $status . '</td>';
            echo '<td><a href="#" class="button button-primary">Báo gia hạn</a></td>'; // Nút "Báo gia hạn"
            echo '</tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p>Không có dịch vụ nào.</p>';
    }

    echo '</div>';
}
