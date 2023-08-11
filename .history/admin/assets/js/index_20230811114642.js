jQuery(document).ready(function($) {
    $('.button-primary').click(function() {
        var serviceId = $(this).data('service-id');

        var popupContent = `
            <div class="popup-background">
                <div class="popup-content">
                    <h3>Mẫu hiển thị báo gia hạn</h3>
                    <p>
                        Xin chào quý khách,<br>
                        Hazo Media xin trân trọng thông báo dịch vụ của quý khách đã đến kỳ gia hạn<br>
                        ... (Nội dung khác của mẫu) ...
                    </p>
                    <button class="close-button">Đóng</button>
                </div>
            </div>
        `;

        // Hiển thị popup
        $('body').append(popupContent);
        $('.close-button').click(function() {
            $('.popup-background').remove();
        });
    });
});
