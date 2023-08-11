jQuery(document).ready(function($) {
    $('.button-primary').click(function() {
        var serviceId = $(this).data('service-id');
        var popup_content_template = $('.popup-content-template').html()
        var popupContent = popup_content_template

        // Hiển thị popup
        $('body').append(popupContent);
        $('.close-button').click(function() {
            $('.popup-background').remove();
        });
    });
});
