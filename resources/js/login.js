/**
 * ====================================
 * Login Page JavaScript
 * ====================================
 */

// Wait for DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    initializeLoginPage();
});

/**
 * Initialize all login page functionality
 */
function initializeLoginPage() {
    setupFormValidation();
    setupInputAnimations();
    setupPasswordToggle();
    animateLoginContainer();
}

/**
 * Setup form validation
 */
function setupFormValidation() {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        const name = document.getElementById("name");
        const password = document.getElementById("password");

        // Basic validation
        if (!name.value.trim()) {
            e.preventDefault();
            showError(name, "Nama Pengguna harus diisi");
            return;
        }
        if (!password.value) {
            e.preventDefault();
            showError(password, "Password harus diisi");
            return;
        }

        // Show loading state
        showLoadingState(form);
    });
}

/**
 * Show error message for input field
 */
function showError(input, message) {
    // Remove existing error
    const existingError = input.parentElement.querySelector(".error-message");
    if (existingError) {
        existingError.remove();
    }

    // Create and add new error message
    const errorDiv = document.createElement("div");
    errorDiv.className = "error-message";
    errorDiv.textContent = message;
    input.parentElement.appendChild(errorDiv);

    // Add error styling to input
    input.style.borderColor = "#dc2626";
    input.focus();

    // Remove error on input
    input.addEventListener("input", function () {
        if (errorDiv) errorDiv.remove();
        input.style.borderColor = "";
    });
}

/**
 * Setup input field animations and interactions
 */
function setupInputAnimations() {
    const inputs = document.querySelectorAll(
        'input[type="text"], input[type="password"]',
    );

    inputs.forEach((input) => {
        // Add floating label effect
        input.addEventListener("focus", function () {
            this.parentElement.classList.add("focused");
        });

        input.addEventListener("blur", function () {
            if (!this.value) {
                this.parentElement.classList.remove("focused");
            }
        });

        // Clear error on input
        input.addEventListener("input", function () {
            const errorMsg = this.parentElement.querySelector(".error-message");
            if (errorMsg) {
                errorMsg.remove();
            }
        });
    });
}

/**
 * Setup password visibility toggle (optional feature)
 */
function setupPasswordToggle() {
    const passwordInput = document.getElementById("password");
    if (!passwordInput) return;

    // Create toggle button
    const toggleBtn = document.createElement("button");
    toggleBtn.type = "button";
    toggleBtn.className = "password-toggle";
    toggleBtn.innerHTML = `
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
        </svg>
    `;
    toggleBtn.style.cssText = `
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 4px;
        display: none;
    `;

    // Add toggle button to password field container
    const passwordContainer = passwordInput.parentElement;
    passwordContainer.style.position = "relative";
    passwordContainer.appendChild(toggleBtn);

    // Toggle password visibility
    toggleBtn.addEventListener("click", function () {
        const type = passwordInput.type === "password" ? "text" : "password";
        passwordInput.type = type;

        // Update icon
        if (type === "text") {
            this.innerHTML = `
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                    <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                    <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                </svg>
            `;
        } else {
            this.innerHTML = `
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                </svg>
            `;
        }
    });
}

/**
 * Animate login container on page load
 */
function animateLoginContainer() {
    const loginContainer = document.querySelector(".login-container");
    if (!loginContainer) return;

    // Add animation class
    loginContainer.style.opacity = "0";
    loginContainer.style.transform = "translateY(30px)";

    // Trigger animation
    setTimeout(() => {
        loginContainer.style.transition = "all 1s ease-out";
        loginContainer.style.opacity = "1";
        loginContainer.style.transform = "translateY(0)";
    }, 100);
}

/**
 * Show loading state on form submission
 */
function showLoadingState(form) {
    const submitBtn = form.querySelector(".btn-primary");
    if (!submitBtn) return;

    // Store original text
    const originalText = submitBtn.textContent;

    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.textContent = "Loading...";
    submitBtn.style.opacity = "0.7";

    // Add spinner
    submitBtn.innerHTML = `
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="animation: spin 1s linear infinite;">
            <path d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm0 14a6 6 0 1 1 6-6 6 6 0 0 1-6 6z" opacity=".4"/>
            <path d="M8 2a6 6 0 0 1 6 6h2a8 8 0 0 0-8-8z"/>
        </svg>
        Loading...
    `;

    // Add spin animation
    const style = document.createElement("style");
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
}

/**
 * Auto-dismiss status messages
 */
function autoDismissMessages() {
    const statusMessage = document.querySelector(".status-message");
    if (statusMessage) {
        setTimeout(() => {
            statusMessage.style.transition = "opacity 0.5s ease-out";
            statusMessage.style.opacity = "0";
            setTimeout(() => statusMessage.remove(), 500);
        }, 5000);
    }
}

// Initialize auto-dismiss
autoDismissMessages();
