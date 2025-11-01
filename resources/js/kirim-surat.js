// ===================================
// FILE UPLOAD HANDLER
// ===================================
document.addEventListener("DOMContentLoaded", function () {
    // Element references
    const fileInput = document.getElementById("file-upload");
    const dropZone = document.getElementById("drop-zone");
    const fileNameDisplay = document.getElementById("file-name-display");
    const filePreview = document.getElementById("file-preview");
    const selectedFileName = document.getElementById("selected-file-name");
    const removeFileBtn = document.getElementById("remove-file");
    const submitButton = document.getElementById("submit-button");
    const form = document.querySelector("form");

    // ===================================
    // FILE INPUT CHANGE HANDLER
    // ===================================
    if (fileInput) {
        fileInput.addEventListener("change", function (e) {
            handleFiles(this.files);
        });
    }

    // ===================================
    // DRAG AND DROP HANDLERS
    // ===================================
    if (dropZone) {
        // Prevent default drag behaviors
        ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop zone when dragging over it
        ["dragenter", "dragover"].forEach((eventName) => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ["dragleave", "drop"].forEach((eventName) => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZone.addEventListener("drop", handleDrop, false);
    }

    // ===================================
    // FILE REMOVAL HANDLER
    // ===================================
    if (removeFileBtn) {
        removeFileBtn.addEventListener("click", function (e) {
            e.preventDefault();
            clearFileInput();
        });
    }

    // ===================================
    // FORM SUBMISSION HANDLER
    // ===================================
    if (form) {
        form.addEventListener("submit", function (e) {
            // Validate file upload
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert("Silakan upload file PDF terlebih dahulu!");
                return false;
            }

            // Show loading state
            showLoadingState();
        });
    }

    // ===================================
    // HELPER FUNCTIONS
    // ===================================

    // Prevent default behavior for drag events
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop zone
    function highlight() {
        dropZone.classList.add("drag-over");
    }

    // Remove highlight from drop zone
    function unhighlight() {
        dropZone.classList.remove("drag-over");
    }

    // Handle dropped files
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    // Process selected or dropped files
    function handleFiles(files) {
        if (!files || files.length === 0) {
            return;
        }

        const file = files[0];

        // Validate file type
        if (file.type !== "application/pdf") {
            showAlert("Hanya file PDF yang diperbolehkan!", "error");
            clearFileInput();
            return;
        }

        // Validate file size (10MB max)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            showAlert("Ukuran file maksimal 10MB!", "error");
            clearFileInput();
            return;
        }

        // Update display
        updateFileDisplay(file.name);
    }

    // Update file display with selected file name
    function updateFileDisplay(fileName) {
        if (fileNameDisplay) {
            fileNameDisplay.textContent = fileName;
        }
        if (selectedFileName) {
            selectedFileName.textContent = fileName;
        }
        if (filePreview) {
            filePreview.classList.remove("hidden");
            filePreview.classList.add("show");
        }
    }

    // Clear file input and reset display
    function clearFileInput() {
        if (fileInput) {
            fileInput.value = "";
        }
        if (fileNameDisplay) {
            fileNameDisplay.textContent = "Tidak ada file dipilih";
        }
        if (filePreview) {
            filePreview.classList.add("hidden");
            filePreview.classList.remove("show");
        }
    }

    // Show loading state on submit button
    function showLoadingState() {
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = `
                <span class="submit-button-content">
                    <svg class="icon-sm animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                </span>
            `;
        }
    }

    // Show alert message
    function showAlert(message, type = "info") {
        // Use browser's alert for simplicity
        // You can replace this with a custom modal or toast notification
        alert(message);
    }
});

// ===================================
// SCROLL TO SECTION FUNCTION
// ===================================
window.scrollToSection = function (sectionId) {
    const element = document.getElementById(sectionId);
    if (element) {
        element.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
    } else {
        // If section not found on this page, you might want to navigate to home page
        console.warn(`Section with id "${sectionId}" not found`);
    }
};

// ===================================
// UTILITY: FORMAT FILE SIZE
// ===================================
function formatFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";

    const k = 1024;
    const sizes = ["Bytes", "KB", "MB", "GB"];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + " " + sizes[i];
}

// ===================================
// UTILITY: VALIDATE FILE EXTENSION
// ===================================
function validateFileExtension(filename) {
    const allowedExtensions = ["pdf"];
    const fileExtension = filename.split(".").pop().toLowerCase();
    return allowedExtensions.includes(fileExtension);
}

// ===================================
// PREVENT FORM RESUBMISSION
// ===================================
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
