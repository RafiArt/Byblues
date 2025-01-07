import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document
    .getElementById("toggleDropdown")
    .addEventListener("click", function () {
        document.getElementById("nav-dropdown").classList.toggle("hidden");
    });

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (
        !event.target.matches("#toggleDropdown") &&
        !event.target.closest("#nav-dropdown")
    ) {
        var dropdown = document.getElementById("nav-dropdown");
        if (!dropdown.classList.contains("hidden")) {
            dropdown.classList.add("hidden");
        }
    }
};
