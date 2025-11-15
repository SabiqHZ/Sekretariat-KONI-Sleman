// ===========================
// SMOOTH SCROLL NAV
// ===========================
function scrollToSection(id) {
    const section = document.getElementById(id);
    if (section) {
        section.scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
    }
}

window.scrollToSection = scrollToSection;

// ===========================
// INTERSECTION OBSERVER
// ===========================
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("visible");
        }
    });
}, observerOptions);

// ===========================
// DOM READY
// ===========================
document.addEventListener("DOMContentLoaded", () => {
    const detailDropdown = document.getElementById("detailDropdown");
    const detailPdfBtn = document.getElementById("detailActionPdf");
    const detailEditBtn = document.getElementById("detailActionEdit");
    const detailDeleteBtn = document.getElementById("detailActionDelete");
    const detailDeleteForm = document.getElementById("detailDeleteForm");
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    let activeDetailToggle = null;

    document.querySelectorAll(".table-detail-toggle").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            activeDetailToggle = btn;

            if (!detailDropdown) return;

            const rect = btn.getBoundingClientRect();
            detailDropdown.style.top = `${rect.bottom + window.scrollY + 4}px`;
            detailDropdown.style.left = `${rect.left + window.scrollX}px`;
            detailDropdown.classList.add("show");

            if (detailPdfBtn) {
                const hasFile = btn.dataset.hasFile === "1";
                detailPdfBtn.disabled = !hasFile;
                detailPdfBtn.classList.toggle(
                    "detail-dropdown-item-disabled",
                    !hasFile,
                );
            }
        });
    });

    // Aksi PDF
    if (detailPdfBtn) {
        detailPdfBtn.addEventListener("click", () => {
            if (!activeDetailToggle) return;
            const url = activeDetailToggle.dataset.pdfUrl;
            const hasFile = activeDetailToggle.dataset.hasFile === "1";

            if (url && hasFile) {
                window.open(url, "_blank");
            }

            detailDropdown.classList.remove("show");
        });
    }

    // ============================
    // MODAL EDIT SURAT (via dropdown global Detail)
    // ============================
    const editOverlay = document.getElementById("editOverlay");
    const closeEditBtn = document.getElementById("closeEditCard");
    const editForm = document.getElementById("editSuratForm");

    const editJenisSelect = document.getElementById("edit-jenis-surat");
    const editNomorInput = document.getElementById("edit-nomor-surat");
    const editTanggalSuratInput = document.getElementById("edit-tanggal-surat");
    const editTanggalMasukInput = document.getElementById("edit-tanggal-masuk");
    const editPengirimInput = document.getElementById("edit-instansi-pengirim");
    const editKeteranganInput = document.getElementById("edit-keterangan");

    if (detailEditBtn) {
        detailEditBtn.addEventListener("click", () => {
            if (!activeDetailToggle || !editOverlay || !editForm) return;

            const btn = activeDetailToggle;
            const updateUrl = btn.dataset.updateUrl;

            if (updateUrl) {
                editForm.setAttribute("action", updateUrl);
            }

            if (editJenisSelect)
                editJenisSelect.value = btn.dataset.jenisId || "";
            if (editNomorInput) editNomorInput.value = btn.dataset.nomor || "";
            if (editTanggalSuratInput)
                editTanggalSuratInput.value = btn.dataset.tanggalSurat || "";
            if (editTanggalMasukInput)
                editTanggalMasukInput.value = btn.dataset.tanggalMasuk || "";
            if (editPengirimInput)
                editPengirimInput.value = btn.dataset.instansiPengirim || "";
            if (editKeteranganInput)
                editKeteranganInput.value = btn.dataset.keterangan || "";

            detailDropdown?.classList.remove("show");
            editOverlay.classList.add("show");
        });
    }

    if (closeEditBtn && editOverlay) {
        closeEditBtn.addEventListener("click", () => {
            editOverlay.classList.remove("show");
        });
    }

    if (editOverlay) {
        editOverlay.addEventListener("click", (e) => {
            if (e.target === editOverlay) {
                editOverlay.classList.remove("show");
            }
        });
    }

    // Aksi Hapus
    if (detailDeleteBtn && detailDeleteForm) {
        detailDeleteBtn.addEventListener("click", () => {
            if (!activeDetailToggle) return;

            const deleteUrl = activeDetailToggle.dataset.deleteUrl;
            if (!deleteUrl) return;

            if (!confirm("Yakin ingin menghapus surat ini?")) return;

            detailDeleteForm.setAttribute("action", deleteUrl);
            detailDeleteForm.submit();
            detailDropdown.classList.remove("show");
        });
    }

    // Tutup dropdown global Detail kalau klik di luar / scroll
    document.addEventListener("click", () => {
        detailDropdown?.classList.remove("show");
        activeDetailToggle = null;
    });

    window.addEventListener("scroll", () => {
        detailDropdown?.classList.remove("show");
        activeDetailToggle = null;
    });

    // ---------------------------
    // OBSERVE ELEMENTS + ANIMATION DELAY
    // ---------------------------
    const animatedElements = document.querySelectorAll(
        ".stat-card, .table-wrapper",
    );
    animatedElements.forEach((el, index) => {
        observer.observe(el);
        el.style.transitionDelay = `${(index % 3) * 0.06}s`;
    });

    // ---------------------------
    // NAV ACTIVE ON SCROLL
    // ---------------------------
    const sections = document.querySelectorAll("section[id]");
    const navButtons = document.querySelectorAll("nav .btn");

    window.addEventListener("scroll", () => {
        let current = "";

        sections.forEach((section) => {
            const sectionTop = section.offsetTop;
            if (window.pageYOffset >= sectionTop - 200) {
                current = section.getAttribute("id");
            }
        });

        navButtons.forEach((btn) => {
            btn.classList.remove("active");
            if (btn.getAttribute("onclick")?.includes(current)) {
                btn.classList.add("active");
            }
        });
    });

    // ---------------------------
    // COUNTER ANIMATION
    // ---------------------------
    const animateCounter = (element, target) => {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 30);
    };

    const counterObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (
                    entry.isIntersecting &&
                    !entry.target.classList.contains("animated")
                ) {
                    const target = parseInt(
                        entry.target.textContent || "0",
                        10,
                    );
                    entry.target.textContent = "0";
                    animateCounter(entry.target, isNaN(target) ? 0 : target);
                    entry.target.classList.add("animated");
                }
            });
        },
        { threshold: 0.5 },
    );

    const statNumbers = document.querySelectorAll(".stat-number");
    statNumbers.forEach((num) => counterObserver.observe(num));

    // ---------------------------
    // TABLE FILTER + CARD UPDATE
    // ---------------------------
    const tableSearchInput = document.getElementById("tableSearch");
    const statusFilter = document.getElementById("statusFilter");
    const suratTable = document.getElementById("suratTable");

    const statTotal = document.getElementById("statTotal");
    const statGuest = document.getElementById("statGuest");
    const statPending = document.getElementById("statPending");

    const sortOrderSelect = document.getElementById("sortOrder");

    let dataRows = [];
    let emptyRow = null;

    if (suratTable) {
        const allRows = suratTable.querySelectorAll("tbody tr");
        allRows.forEach((row) => {
            if (row.classList.contains("table-empty-row")) {
                emptyRow = row;
            } else {
                dataRows.push(row);
            }
        });
    }

    function updateCardsFromTable() {
        if (!statTotal || !statGuest || !statPending) return;

        let total = 0;
        let guest = 0;
        let pending = 0;

        dataRows.forEach((row) => {
            total++;

            if (row.dataset.isGuest === "1") {
                guest++;
            }

            const status = (row.dataset.status || "").toLowerCase();
            if (status === "menunggu") {
                pending++;
            }
        });

        statTotal.textContent = total;
        statGuest.textContent = guest;
        statPending.textContent = pending;
    }
    function sortTableRows() {
        if (!suratTable) return;

        const sortValue = sortOrderSelect?.value || "tanggal_masuk_desc";
        const tbody = suratTable.querySelector("tbody");
        const rows = [...dataRows];

        const getDateKey = (row) => row.dataset.tanggalMasuk || "";
        const getStatusKey = (row) => (row.dataset.status || "").toLowerCase();

        rows.sort((a, b) => {
            if (
                sortValue === "tanggal_masuk_asc" ||
                sortValue === "tanggal_masuk_desc"
            ) {
                const aKey = getDateKey(a);
                const bKey = getDateKey(b);

                if (aKey === bKey) return 0;
                const cmp = aKey < bKey ? -1 : 1;
                return sortValue === "tanggal_masuk_asc" ? cmp : -cmp;
            }

            if (sortValue === "status_asc" || sortValue === "status_desc") {
                const aKey = getStatusKey(a);
                const bKey = getStatusKey(b);

                if (aKey === bKey) return 0;
                const cmp = aKey < bKey ? -1 : 1;
                return sortValue === "status_asc" ? cmp : -cmp;
            }

            return 0;
        });

        rows.forEach((row) => tbody.appendChild(row));
    }

    function applyTableFilters() {
        if (!suratTable) return;

        const searchTerm = (tableSearchInput?.value || "").toLowerCase();
        const statusValue = (statusFilter?.value || "").toLowerCase();

        let visibleCount = 0;

        dataRows.forEach((row) => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = (row.dataset.status || "").toLowerCase();

            let visible = true;

            if (searchTerm && !rowText.includes(searchTerm)) {
                visible = false;
            }

            if (statusValue && rowStatus !== statusValue) {
                visible = false;
            }

            row.style.display = visible ? "" : "none";
            if (visible) visibleCount++;
        });

        if (emptyRow) {
            emptyRow.style.display = visibleCount === 0 ? "" : "none";
        }

        updateCardsFromTable();
        sortTableRows();
    }

    tableSearchInput?.addEventListener("input", applyTableFilters);
    statusFilter?.addEventListener("change", applyTableFilters);
    sortOrderSelect?.addEventListener("change", applyTableFilters);

    updateCardsFromTable();
    applyTableFilters();
    // ===========================
    // PAGINATION QUERY STRING PERSISTENCE
    // ===========================
    document.addEventListener("DOMContentLoaded", () => {
        // Preserve search and filter params on pagination clicks
        const paginationLinks = document.querySelectorAll(
            ".pagination-btn, .pagination-number",
        );

        paginationLinks.forEach((link) => {
            if (link.tagName === "A") {
                link.addEventListener("click", (e) => {
                    const url = new URL(link.href);

                    // Add current search term
                    const searchValue = tableSearchInput?.value;
                    if (searchValue) {
                        url.searchParams.set("search", searchValue);
                    }

                    // Add current status filter
                    const statusValue = statusFilter?.value;
                    if (statusValue) {
                        url.searchParams.set("status", statusValue);
                    }

                    // Add current sort
                    const sortValue = sortOrderSelect?.value;
                    if (sortValue) {
                        const [sort, order] = sortValue.split("_");
                        url.searchParams.set("sort", sort);
                        url.searchParams.set(
                            "order",
                            order === "desc" ? "desc" : "asc",
                        );
                    }

                    // Update href
                    link.href = url.toString();
                });
            }
        });
    });
    // ---------------------------
    // STATUS DROPDOWN (FRONT-END ONLY)
    // ---------------------------
    const statusBadges = document.querySelectorAll(".status-badge");
    let activeStatusBadge = null;

    const statusDropdown = document.createElement("div");
    statusDropdown.className = "status-dropdown";
    statusDropdown.innerHTML = `
        <button type="button" data-status-value="menunggu">Menunggu</button>
        <button type="button" data-status-value="diproses">Proses</button>
        <button type="button" data-status-value="selesai">Selesai</button>
    `;
    document.body.appendChild(statusDropdown);
    function saveStatusToBackend(row, newStatus) {
        const url = row.dataset.statusUrl;
        if (!url || !csrfToken) return;

        fetch(url, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: JSON.stringify({ status: newStatus }),
        })
            .then((res) => {
                if (!res.ok) {
                    // buat debug ringan
                    console.error(
                        "Status update failed:",
                        res.status,
                        res.statusText,
                    );
                    throw new Error("Request failed");
                }
                return res.json();
            })
            .catch(() => {
                alert(
                    "Gagal menyimpan status ke server. Halaman akan di-reload.",
                );
                window.location.reload();
            });
    }

    function setStatusForRow(badge, newStatus) {
        if (!badge) return;
        const row = badge.closest("tr");
        if (!row) return;

        row.dataset.status = newStatus;

        const labelMap = {
            menunggu: "Menunggu",
            diproses: "Diproses",
            selesai: "Selesai",
        };
        badge.textContent = labelMap[newStatus] || newStatus;

        badge.classList.remove("badge-warning", "badge-info", "badge-success");
        if (newStatus === "menunggu") {
            badge.classList.add("badge-warning");
        } else if (newStatus === "diproses") {
            badge.classList.add("badge-info");
        } else if (newStatus === "selesai") {
            badge.classList.add("badge-success");
        }

        updateCardsFromTable();
        applyTableFilters();

        // simpan ke backend
        saveStatusToBackend(row, newStatus);
    }

    statusBadges.forEach((badge) => {
        badge.addEventListener("click", (e) => {
            e.stopPropagation();
            activeStatusBadge = badge;

            const rect = badge.getBoundingClientRect();
            statusDropdown.style.top = `${rect.bottom + window.scrollY + 4}px`;
            statusDropdown.style.left = `${rect.left + window.scrollX}px`;
            statusDropdown.classList.add("show");
        });
    });

    statusDropdown.addEventListener("click", (e) => {
        const btn = e.target.closest("button[data-status-value]");
        if (!btn || !activeStatusBadge) return;

        const value = btn.getAttribute("data-status-value");
        setStatusForRow(activeStatusBadge, value);
        statusDropdown.classList.remove("show");
        activeStatusBadge = null;
    });

    document.addEventListener("click", () => {
        statusDropdown.classList.remove("show");
        activeStatusBadge = null;
    });

    // ---------------------------
    // UPLOAD SURAT MODAL (ADMIN)
    // ---------------------------
    const openUploadBtn = document.getElementById("openUploadCard");
    const uploadOverlay = document.getElementById("uploadOverlay");
    const closeUploadBtn = document.getElementById("closeUploadCard");
    const openJenisBtn = document.getElementById("openJenisCard");
    const jenisOverlay = document.getElementById("jenisOverlay");
    const closeJenisBtn = document.getElementById("closeJenisCard");
    const cancelJenisBtn = document.getElementById("cancelJenisBtn");

    if (openUploadBtn && uploadOverlay) {
        openUploadBtn.addEventListener("click", () => {
            uploadOverlay.classList.add("show");
        });
    }

    if (closeUploadBtn && uploadOverlay) {
        closeUploadBtn.addEventListener("click", () => {
            uploadOverlay.classList.remove("show");
        });
    }

    if (uploadOverlay) {
        uploadOverlay.addEventListener("click", (e) => {
            if (e.target === uploadOverlay) {
                uploadOverlay.classList.remove("show");
            }
        });
    }

    // MODAL TAMBAH JENIS SURAT (baru)
    if (openJenisBtn && jenisOverlay) {
        openJenisBtn.addEventListener("click", () => {
            jenisOverlay.classList.add("show");
        });
    }

    if (closeJenisBtn && jenisOverlay) {
        closeJenisBtn.addEventListener("click", () => {
            jenisOverlay.classList.remove("show");
        });
    }

    if (cancelJenisBtn && jenisOverlay) {
        cancelJenisBtn.addEventListener("click", () => {
            jenisOverlay.classList.remove("show");
        });
    }

    if (jenisOverlay) {
        jenisOverlay.addEventListener("click", (e) => {
            if (e.target === jenisOverlay) {
                jenisOverlay.classList.remove("show");
            }
        });
    }
    const adminFileInput = document.getElementById("admin-file-upload");
    const adminFileNameDisplay = document.getElementById(
        "admin-file-name-display",
    );
    const adminFilePreview = document.getElementById("admin-file-preview");
    const adminSelectedFileName = document.getElementById(
        "admin-selected-file-name",
    );

    if (
        adminFileInput &&
        adminFileNameDisplay &&
        adminFilePreview &&
        adminSelectedFileName
    ) {
        adminFileInput.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                adminFileNameDisplay.textContent = file.name;
                adminSelectedFileName.textContent = file.name;
                adminFilePreview.classList.add("show");
            } else {
                adminFileNameDisplay.textContent = "Tidak ada file dipilih";
                adminSelectedFileName.textContent = "";
                adminFilePreview.classList.remove("show");
            }
        });
    }
    // ---------------------------
    // FILE UPLOAD CLICK TRIGGER
    // ---------------------------
    const adminDropZone = document.getElementById("admin-drop-zone");

    if (adminDropZone && adminFileInput) {
        // Klik pada drop zone untuk buka file picker
        adminDropZone.addEventListener("click", () => {
            adminFileInput.click();
        });

        // Prevent default drag behaviors
        ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {
            adminDropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Highlight drop zone saat drag
        ["dragenter", "dragover"].forEach((eventName) => {
            adminDropZone.addEventListener(eventName, () => {
                adminDropZone.style.borderColor = "var(--primary-color)";
                adminDropZone.style.background = "#fef3c7";
            });
        });

        ["dragleave", "drop"].forEach((eventName) => {
            adminDropZone.addEventListener(eventName, () => {
                adminDropZone.style.borderColor = "";
                adminDropZone.style.background = "";
            });
        });

        // Handle dropped files
        adminDropZone.addEventListener("drop", (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                adminFileInput.files = files;
                // Trigger change event
                const event = new Event("change", { bubbles: true });
                adminFileInput.dispatchEvent(event);
            }
        });
    }
    // Escape untuk kedua overlay (upload + edit)
    document.addEventListener("keydown", (e) => {
        if (e.key !== "Escape") return;

        if (uploadOverlay?.classList.contains("show")) {
            uploadOverlay.classList.remove("show");
        }
        if (editOverlay?.classList.contains("show")) {
            editOverlay.classList.remove("show");
        }
        if (jenisOverlay?.classList.contains("show")) {
            jenisOverlay.classList.remove("show");
        }
    });

    // ---------------------------
    // PROFILE DROPDOWN
    // ---------------------------
    const profileButton = document.getElementById("profileButton");
    const dropdownMenu = document.getElementById("dropdownMenu");

    if (profileButton && dropdownMenu) {
        profileButton.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle("show");
        });

        document.addEventListener("click", (e) => {
            if (
                !profileButton.contains(e.target) &&
                !dropdownMenu.contains(e.target)
            ) {
                dropdownMenu.classList.remove("show");
            }
        });

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                dropdownMenu.classList.remove("show");
            }
        });

        dropdownMenu.addEventListener("click", (e) => {
            if (e.target.tagName !== "A" && e.target.tagName !== "BUTTON") {
                e.stopPropagation();
            }
        });
    }

    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", function () {
            const dropdown = document.getElementById("dropdownMenu");
            if (dropdown && !this.closest("form")) {
                dropdown.style.transition = "all 0.2s ease";
            }
        });
    });
    // ... (kode profile dropdown existing)

    // ===========================
    // ANCHOR SMOOTH SCROLL
    // ===========================
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = this.getAttribute("href").substring(1);
            scrollToSection(target);
        });
    });
});

// ===========================
// WINDOW LOAD
// ===========================
window.addEventListener("load", () => {
    document.body.classList.add("loaded");
});
