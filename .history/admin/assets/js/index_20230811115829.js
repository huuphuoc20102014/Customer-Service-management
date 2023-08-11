function showRenewPopup(serviceId, serviceName, price, vat, endDate) {
    jQuery('#renew-popup').html(
        '<p>Xin chào quý khách,</p>' +
        '<p>Hazo Media xin trân trọng thông báo dịch vụ của quý khách đã đến kỳ gia hạn</p>' +
        '<p>Phí duy trì "' + serviceName + '": ' + price + 'đ - 1 năm ("' + endDate + '" – "' + (parseInt(endDate.substring(0, 4)) + 1) + endDate.substring(4) + '")</p>' +
        '<p>Tổng: ' + price + 'đ – Đã bao gồm VAT ' + vat + '%</p>' +
        '<p>✅ Thông tin chuyển khoản</p>' +
        '<p>Số tài khoản: 809908888</p>' +
        '<p>Chủ tài khoản: CÔNG TY CỔ PHẦN CÔNG NGHỆ HAZO VIỆT NAM</p>' +
        '<p>Ngân hàng TMCP Á Châu (ACB) - chi nhánh Hà Thành</p>' +
        '<p>💥 Lưu ý: Hệ thống sẽ tự động tạm ngưng tài khoản sau ngày "' + endDate + '"</p>'
    );

    jQuery('#renew-popup').dialog({
        title: 'Thông báo gia hạn dịch vụ',
        modal: true,
        width: 500,
        buttons: {
            OK: function() {
                jQuery(this).dialog('close');
            }
        }
    });
}
