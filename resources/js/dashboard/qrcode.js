function openQrCodeModal(button) {
    // Get the QR code link and ID from the button
    const id = button.getAttribute("data-id");
    const link = button.getAttribute("data-link");

    // Generate the QR Code HTML
    const qrCodeHtml = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=${link}" alt="QR Code">`;
    document.getElementById("qrCodeContent").innerHTML = qrCodeHtml;

    // Set the download button URL
    const downloadUrl = `/qrcode/download/${id}`; // Ensure this matches your route
    document.getElementById("downloadButton").setAttribute("href", downloadUrl);
    document
        .getElementById("downloadButtonContainer")
        .classList.remove("hidden");

    // Show the modal
    toggleModal("qrCodeModal");
}

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle("hidden"); // Toggle the hidden class to show/hide the modal
}
