jQuery(document).ready(function($) {
    $('.button-primary').click(function() {
        var serviceId = $(this).data('service-id');
        var popup-content-template = $(this).data('service-id');
        var popupContent = popup-content-template

        // Hiển thị popup
        $('body').append(popupContent);
        $('.close-button').click(function() {
            $('.popup-background').remove();
        });
    });
});
