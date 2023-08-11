function showRenewPopup(serviceId, serviceName, price, vat, endDate) {
    const popupContent = `
        ${jQuery('#popup_content').val()}
    `;

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
