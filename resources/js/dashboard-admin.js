const STATUS_STORAGE_KEY = "administrasi-dashboard-status";
const PIN_STORAGE_KEY = "administrasi-dashboard-pin";

document.addEventListener("DOMContentLoaded", () => {
    initProfileDropdown();
    initStatusControls();
    initRecentSearch();
    initArchiveFilters();
    initSmoothScroll();
});

function initProfileDropdown() {
    const toggle = document.getElementById("profileButton");
    const menu = document.getElementById("dropdownMenu");

    if (!toggle || !menu) return;

    toggle.addEventListener("click", (event) => {
        event.stopPropagation();
        menu.classList.toggle("show");
    });

    document.addEventListener("click", (event) => {
        if (!menu.contains(event.target) && !toggle.contains(event.target)) {
            menu.classList.remove("show");
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            menu.classList.remove("show");
        }
    });
}

function initStatusControls() {
    const storedStatus = JSON.parse(localStorage.getItem(STATUS_STORAGE_KEY) || "{}");

    document.querySelectorAll("[data-status-control]").forEach((group) => {
        const id = group.getAttribute("data-status-control");
        const buttons = group.querySelectorAll("button[data-value]");
        const current = storedStatus[id] || "menunggu";

        buttons.forEach((button) => {
            if (button.dataset.value === current) {
                button.classList.add("active");
            }

            button.addEventListener("click", () => {
                buttons.forEach((btn) => btn.classList.remove("active"));
                button.classList.add("active");
                storedStatus[id] = button.dataset.value;
                localStorage.setItem(STATUS_STORAGE_KEY, JSON.stringify(storedStatus));
                updateStatusFilters(storedStatus);
            });
        });
    });

    updateStatusFilters(storedStatus);
}

function updateStatusFilters(statusCollection) {
    const tableRows = document.querySelectorAll("#recentTableBody tr");
    const filterGroups = document.querySelectorAll("[data-status-group]");

    filterGroups.forEach((group) => {
        const buttons = group.querySelectorAll("button[data-status]");
        buttons.forEach((button) => {
            if (!button.dataset.bound) {
                button.dataset.bound = "true";
                button.addEventListener("click", () => {
                    buttons.forEach((btn) => btn.classList.remove("active"));
                    button.classList.add("active");
                    applyStatusFilter(button.dataset.status || "", statusCollection, tableRows);
                });
            }
        });
    });

    const active = document.querySelector("[data-status-group] button.active");
    applyStatusFilter(active?.dataset.status || "", statusCollection, tableRows);
}

function applyStatusFilter(targetStatus, statusCollection, rows) {
    if (!rows) return;

    rows.forEach((row) => {
        if (!(row instanceof HTMLElement)) return;
        const id = row.getAttribute("data-id");
        const rowStatus = statusCollection[id] || "menunggu";
        const visible = !targetStatus || targetStatus === "semua" || rowStatus === targetStatus;
        row.style.display = visible ? "" : "none";
    });
}

function initRecentSearch() {
    const searchInput = document.getElementById("recentSearch");
    const rows = Array.from(document.querySelectorAll("#recentTableBody tr"));

    if (!searchInput || rows.length === 0) return;

    searchInput.addEventListener("input", (event) => {
        const query = event.target.value.toLowerCase();

        rows.forEach((row) => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? "" : "none";
        });
    });
}

function initArchiveFilters() {
    const filters = document.querySelectorAll("[data-archive-filter]");
    const cards = document.querySelectorAll("[data-archive-card]");
    const pinned = JSON.parse(localStorage.getItem(PIN_STORAGE_KEY) || "[]");

    cards.forEach((card) => {
        const pinButton = card.querySelector("[data-pin]");
        const id = pinButton?.dataset.pin;

        if (id && pinned.includes(id)) {
            card.classList.add("pinned");
        }

        pinButton?.addEventListener("click", () => {
            if (!id) return;
            const index = pinned.indexOf(id);
            if (index >= 0) {
                pinned.splice(index, 1);
                card.classList.remove("pinned");
            } else {
                pinned.push(id);
                card.classList.add("pinned");
            }
            localStorage.setItem(PIN_STORAGE_KEY, JSON.stringify(pinned));
        });
    });

    filters.forEach((filter) => {
        filter.addEventListener("click", () => {
            filters.forEach((btn) => btn.classList.remove("active"));
            filter.classList.add("active");
            const type = filter.dataset.archiveFilter;
            const now = new Date();

            cards.forEach((card) => {
                const created = card.dataset.created ? new Date(card.dataset.created) : null;
                let visible = true;

                if (created) {
                    if (type === "bulan") {
                        visible =
                            created.getMonth() === now.getMonth() &&
                            created.getFullYear() === now.getFullYear();
                    } else if (type === "tahun") {
                        visible = created.getFullYear() === now.getFullYear();
                    }
                }

                card.style.display = visible || type === "all" ? "" : "none";
            });
        });
    });
}

function initSmoothScroll() {
    document.querySelectorAll("[data-scroll]").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const targetId = trigger.getAttribute("data-scroll");
            const target = document.getElementById(targetId);
            if (!target) return;
            target.scrollIntoView({ behavior: "smooth", block: "start" });
        });
    });
}
