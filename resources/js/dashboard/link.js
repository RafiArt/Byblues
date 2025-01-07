document.addEventListener("DOMContentLoaded", () => {
    const navDropdown = document.getElementById("nav-dropdown");
    const toggleDropdownBtn = document.getElementById("toggleDropdown");

    if (navDropdown && toggleDropdownBtn) {
        const toggleDropdown = () => navDropdown.classList.toggle("hidden");

        toggleDropdownBtn.addEventListener("click", (event) => {
            event.stopPropagation(); // Prevent event propagation
            toggleDropdown();
        });

        document.addEventListener("click", (event) => {
            if (
                !navDropdown.classList.contains("hidden") &&
                !navDropdown.contains(event.target) &&
                !toggleDropdownBtn.contains(event.target)
            ) {
                navDropdown.classList.add("hidden");
            }
        });
    }

    const showButton = document.getElementById("show-more-btn");
    const hiddenShowButton = document.getElementById("hidden-show-more-btn");
    const moreInput = document.getElementById("more-input");

    if (showButton && hiddenShowButton && moreInput) {
        showButton.addEventListener("click", () => {
            moreInput.classList.toggle("hidden");
            showButton.classList.toggle("hidden");
            hiddenShowButton.classList.toggle("hidden");
            hiddenShowButton.classList.add("flex");
        });

        hiddenShowButton.addEventListener("click", () => {
            moreInput.classList.toggle("hidden");
            showButton.classList.toggle("hidden");
            hiddenShowButton.classList.toggle("hidden");
        });
    }

    const protectedBtn = document.getElementById("protected-btn");
    const timeBasedBtn = document.getElementById("time-based-btn");
    const protectedComponent = document.getElementById("protected");
    const timeBasedComponent = document.getElementById("time-based");

    if (
        protectedBtn &&
        timeBasedBtn &&
        protectedComponent &&
        timeBasedComponent
    ) {
        const showComponent = (component) => {
            component.classList.remove("hidden");
            component.classList.add("block");
        };

        const hideComponent = (component) => {
            component.classList.remove("block");
            component.classList.add("hidden");
        };

        const toggleButtonStyles = (activeBtn, inactiveBtn) => {
            activeBtn.classList.add("bg-blue-100", "text-blue-600");
            inactiveBtn.classList.remove("bg-blue-100", "text-blue-600");
            inactiveBtn.classList.add(
                "bg-gray-100",
                "text-gray-600",
                "hover:bg-gray-300"
            );
            activeBtn.classList.remove(
                "bg-gray-100",
                "text-gray-600",
                "hover:bg-gray-300"
            );
        };

        protectedBtn.addEventListener("click", () => {
            hideComponent(timeBasedComponent);
            showComponent(protectedComponent);
            toggleButtonStyles(protectedBtn, timeBasedBtn);
        });

        timeBasedBtn.addEventListener("click", () => {
            hideComponent(protectedComponent);
            showComponent(timeBasedComponent);
            toggleButtonStyles(timeBasedBtn, protectedBtn);
        });
    }

    const togglePassword = document.getElementById("toggle-password");
    const passwordInput = document.getElementById("password-input");

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("click", () => {
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                togglePassword.classList.remove("fa-eye");
                togglePassword.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                togglePassword.classList.remove("fa-eye-slash");
                togglePassword.classList.add("fa-eye");
            }
        });
    }
});
