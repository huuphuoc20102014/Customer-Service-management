// Hiển thị popup và thay thế nội dung mẫu
function showPopup(serviceName) {
    var popupContent = document.getElementById("popup-content-template").innerHTML;
    popupContent = popupContent.replace(/{{serviceName}}/g, serviceName);

    var overlay = document.createElement("div");
    overlay.id = "popup-overlay";

    var popup = document.createElement("div");
    popup.id = "popup-content";
    popup.innerHTML = popupContent;

    overlay.appendChild(popup);
    document.body.appendChild(overlay);

    overlay.addEventListener("click", function() {
        overlay.style.display = "none";
    });
}
