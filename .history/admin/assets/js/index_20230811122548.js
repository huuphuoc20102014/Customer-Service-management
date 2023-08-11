function showRenewPopup(serviceName, price, vat, endDate) {
    const popupContent = `
        ${jQuery('#popup_content').val()}
    `;

    const popup = document.createElement('div');
    popup.className = 'popup-overlay';
    popup.innerHTML = popupContent;

    document.body.appendChild(popup);
}

function closeRenewPopup() {
    const popup = document.querySelector('.popup-overlay');
    if (popup) {
        document.body.removeChild(popup);
    }
}
