// JavaScript code
jQuery(document).ready(function($) {
    $('.btn-bao-gia-han').click(function() {
        var serviceId = $(this).data('service-id');
        var serviceName = $(this).data('service-name');
        var price = $(this).data('price');
        var vat = $(this).data('vat');
        var endDate = $(this).data('end-date');
        var startDate = $(this).data('start-date');
        var endDateNew =  $(this).data('end-date-new');
      

        var popupContent = $('#service-extension-content').val();
        popupContent = popupContent.replace(/%%serviceName%%/g, serviceName);
        popupContent = popupContent.replace(/%%price%%/g, price);
        popupContent = popupContent.replace(/%%endDate%%/g, endDate);
        popupContent = popupContent.replace(/%%startDate%%/g, startDate);
        popupContent = popupContent.replace(/%%vat%%/g, vat);
        popupContent = popupContent.replace(/%%endDateNew%%/g, endDateNew);

        $('#bao-gia-han-popup .popup-content').html(popupContent);
        $('#bao-gia-han-popup').removeClass('hidden');

    });
    // Sao chép nội dung khi bấm nút "Copy Text"
    $('button#copy-text-btn').on( "click", function(e) {
        var popupContent = $('.popup-message').text();
        console.log('Đã sao chép nội dung vào clipboard: ', popupContent);
        copyToClipboard(popupContent);
    });

    $('#bao-gia-han-popup').on( "click", function(e) {
        $(this).addClass('hidden');
    });

    $('#bao-gia-han-popup .popup-content').on( "click", function(e) {
        e.stopPropagation();
    });

    // Hàm sao chép nội dung vào clipboard

function copyToClipboard(text) {
    var tempInput = $("<textarea>");
    $("body").append(tempInput);
    tempInput.val(text).select();
    document.execCommand("copy");
    tempInput.remove();
    alert("Formatted text copied to clipboard.");
}

 
    
});
