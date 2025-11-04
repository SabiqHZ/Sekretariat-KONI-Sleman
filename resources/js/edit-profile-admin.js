// ===================================
// EDIT PROFILE FUNCTIONALITY
// ===================================

document.addEventListener("DOMContentLoaded", function () {
    // Initialize all functionality
    initPasswordToggle();
    initPasswordMatch();
    initFormValidation();
    initNotifications();
});

// ===================================
// PASSWORD VISIBILITY TOGGLE
// ===================================
function initPasswordToggle() {
    window.togglePassword = function (inputId) {
        const input = document.getElementById(inputId);
        const button = input.parentElement.querySelector(".password-toggle");
        const icon = button.querySelector(".eye-icon");

        if (input.type === "password") {
            input.type = "text";
            // Change icon to eye-off
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
            `;
        } else {
            input.type = "password";
            // Change icon to eye
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    };
}

// ===================================
// PASSWORD MATCH VALIDATION
// ===================================
function initPasswordMatch() {
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("password_confirmation");
    const feedback = document.getElementById("password-match-feedback");

    if (!passwordInput || !confirmInput || !feedback) return;

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        if (password && confirm) {
            feedback.classList.remove("hidden");
            feedback.classList.add("show");

            if (password === confirm) {
                feedback.className = "password-feedback show match";
                feedback.innerHTML = `
                    <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Password cocok</span>
                `;
            } else {
                feedback.className = "password-feedback show no-match";
                feedback.innerHTML = `
                    <svg class="icon-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Password tidak cocok</span>
                `;
            }
        } else {
            feedback.classList.remove("show");
            feedback.classList.add("hidden");
        }
    }

    passwordInput.addEventListener("input", checkPasswordMatch);
    confirmInput.addEventListener("input", checkPasswordMatch);
}

// ===================================
// FORM VALIDATION
// ===================================
function initFormValidation() {
    const forms = document.querySelectorAll("form");

    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            let isValid = true;
            const requiredInputs = form.querySelectorAll("input[required]");

            // Clear previous error styles
            requiredInputs.forEach((input) => {
                input.classList.remove("border-red-500");
            });

            // Check empty fields
            requiredInputs.forEach((input) => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add("border-red-500");
                    showAlert(
                        "Error",
                        "Harap isi semua field yang diperlukan!",
                        "error",
                    );
                }
            });

            // Check password match for password form
            const passwordInput = form.querySelector("#password");
            const confirmInput = form.querySelector("#password_confirmation");

            if (passwordInput && confirmInput) {
                if (passwordInput.value !== confirmInput.value) {
                    isValid = false;
                    confirmInput.classList.add("border-red-500");
                    showAlert("Error", "Password tidak cocok!", "error");
                }

                // Check minimum password length
                if (passwordInput.value && passwordInput.value.length < 8) {
                    isValid = false;
                    passwordInput.classList.add("border-red-500");
                    showAlert("Error", "Password minimal 8 karakter!", "error");
                }
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            // Show loading state
            showLoadingState(form);
        });
    });
}

// ===================================
// SHOW LOADING STATE ON SUBMIT
// ===================================
function showLoadingState(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        const originalHTML = submitButton.innerHTML;
        submitButton.innerHTML = `
            <svg class="icon-sm animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memproses...</span>
        `;
        submitButton.disabled = true;

        // Reset after 5 seconds if still on page
        setTimeout(() => {
            submitButton.innerHTML = originalHTML;
            submitButton.disabled = false;
        }, 5000);
    }
}

// ===================================
// NOTIFICATION SYSTEM
// ===================================
function initNotifications() {
    // Check for success messages from session
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.get("profile_updated") === "success") {
        showAlert("Berhasil!", "Profile berhasil diperbarui!", "success");
    }

    if (urlParams.get("password_updated") === "success") {
        showAlert("Berhasil!", "Password berhasil diperbarui!", "success");
    }
}

// ===================================
// SIMPLE ALERT FUNCTION
// ===================================
function showAlert(title, message, type) {
    // Simple native alert - can be replaced with a custom modal
    const icon = type === "success" ? "✓" : "✗";
    alert(`${icon} ${title}\n\n${message}`);
}

// ===================================
// UTILITY: VALIDATE EMAIL FORMAT
// ===================================
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// ===================================
// UTILITY: SMOOTH SCROLL
// ===================================
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}

// ===================================
// ERROR BORDER ANIMATION
// ===================================
const style = document.createElement("style");
style.textContent = `
    .border-red-500 {
        border-color: #dc2626 !important;
        animation: shake 0.3s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .opacity-25 {
        opacity: 0.25;
    }
    
    .opacity-75 {
        opacity: 0.75;
    }
`;
document.head.appendChild(style);
