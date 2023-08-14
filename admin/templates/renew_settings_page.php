<?php
function service_configuration_page_callback() {
    // Trang cấu hình gia hạn
    echo '<div class="wrap">';
    echo '<h2>Cấu hình Gia hạn Dịch vụ</h2>';
    echo '<p class="clearfix">Điền  %%serviceName%%  để hiển thị Tên đơn hàng, dịch vụ</p>';
    echo '<p class="clearfix">Điền  %%price%%  để hiển thị Giá đơn hàng, dịch vụ</p>';
    echo '<p class="clearfix">Điền  %%endDate%%  để hiển thị Ngày hết hạn của đơn hàng, dịch vụ</p>';
    echo '<p class="clearfix">Điền  %%startDate%%  để hiển thị Ngày tạo đơn hàng, dịch vụ</p>';
    echo '<p class="clearfix">Điền  %%vat%%  để hiển thị VAT của đơn hàng, dịch vụ</p>';
    echo '<p class="clearfix">Điền  %%endDateNew%%  để hiển thị Ngày hết hạn của mới đơn hàng, dịch vụ</p>';



    // Kiểm tra quyền truy cập
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    // Lưu nội dung cấu hình khi form được submit
    if (isset($_POST['update_configuration'])) {
        update_option('service_extension_content', wp_kses_post($_POST['service_extension_content']));
        echo '<div class="updated"><p>Cập nhật thành công.</p></div>';
    }

    // Hiển thị form cấu hình gia hạn
    $default_content = '<div class="popup-message success" style="color: #333;">
    <p class="clearfix" style="font-size: 22px; text-align: left;">Xin chào quý khách,</p>
    <p class="clearfix">Chúng tôi xin trân trọng thông báo dịch vụ của quý khách đã đến kỳ gia hạn</p>
    <p class="clearfix">Phí duy trì %%serviceName%%: %%price%%đ - 1 năm (%%startDate%% – %%endDateNew%%)</p>
    <p class="clearfix">--------------------------------</p>
    <p class="clearfix">Tổng: %%price%%đ – Đã bao gồm VAT %%vat%%%</p>
    <p class="clearfix">✅ Thông tin chuyển khoản</p>
    <p class="clearfix">Số tài khoản: 9999 9999 9999</p>
    <p class="clearfix">Chủ tài khoản: CÔNG TY CỔ PHẦN CÔNG NGHỆ</p>
    <p class="clearfix">Ngân hàng TMCP ABC (ABC) - chi nhánh HCM</p>
    <p class="clearfix">💥 Lưu ý: Hệ thống sẽ tự động tạm ngưng tài khoản sau ngày %%endDate%%</p>
    <p class="clearfix">💥 Phí khôi phục sau thời gian hết hạn là 300.000đ/1 lần</p>
    </div>';
    $configuration_content = get_option('service_extension_content', $default_content);
        

    echo '<form method="post" action="">';

    // Sử dụng trình soạn thảo WYSIWYG
    wp_editor($configuration_content, 'service_extension_content', array('textarea_name' => 'service_extension_content'));

    echo '<br><input type="submit" name="update_configuration" class="button button-primary" value="Cập nhật">';
    echo '</form>';

    echo '</div>';
}


function add_service_configuration_page_to_menu() {
    add_submenu_page(
        'edit.php?post_type=service', // Menu "Pages"
        'Cấu hình Gia hạn Dịch vụ',    // Tiêu đề trang
        'Cấu hình Gia hạn',            // Tên hiển thị trên menu
        'manage_options',              // Quyền truy cập
        'service_configuration',      // Slug trang
        'service_configuration_page_callback' // Hàm callback để hiển thị nội dung trang
    );
}

add_action('admin_menu', 'add_service_configuration_page_to_menu');

