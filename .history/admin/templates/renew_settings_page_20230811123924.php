<?php
function add_renew_settings_page() {
    add_submenu_page(
        'edit.php?post_type=service', // Menu "Dịch vụ"
        'Cấu hình gia hạn',           // Tiêu đề trang
        'Cấu hình gia hạn',           // Tên hiển thị trên menu
        'manage_options',             // Quyền truy cập
        'renew_settings',             // Slug trang
        'renew_settings_page_callback' // Hàm callback để hiển thị nội dung trang
    );
}
add_action('admin_menu', 'add_renew_settings_page');

function renew_settings_page_callback() {
    ?>
    <div class="wrap">
        <h2>Cấu hình gia hạn</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('renew-settings-group');
            do_settings_sections('renew-settings-group');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function setup_renew_settings() {
    add_settings_section('renew-settings-section', 'Nội dung popup gia hạn', 'renew_settings_section_callback', 'renew-settings-group');

    add_settings_field('popup-content', 'Nội dung popup', 'popup_content_callback', 'renew-settings-group', 'renew-settings-section');

    register_setting('renew-settings-group', 'popup_content');
}
add_action('admin_init', 'setup_renew_settings');

function renew_settings_section_callback() {
    echo 'Chỉnh sửa nội dung popup gia hạn dịch vụ';
}

function popup_content_callback() {
    $popup_content = get_option('popup_content', '');
    wp_editor($popup_content, 'popup_content', array('textarea_rows' => 10));
}
