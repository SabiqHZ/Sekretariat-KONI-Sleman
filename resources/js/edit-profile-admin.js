document.addEventListener("DOMContentLoaded", () => {
    // Toggle eye
    document.querySelectorAll(".eye").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-toggle");
            const input = document.getElementById(id);
            if (!input) return;
            input.type = input.type === "password" ? "text" : "password";
            btn.classList.toggle("is-off", input.type === "text");
        });
    });

    // Live match
    const p = document.getElementById("password");
    const c = document.getElementById("password_confirmation");
    const fb = document.getElementById("password-match");
    function sync() {
        if (!p || !c || !fb) return;
        const a = p.value,
            b = c.value;
        if (!a && !b) {
            fb.className = "match";
            fb.textContent = "";
            return;
        }
        if (a === b) {
            fb.className = "match show ok";
            fb.textContent = "Password cocok";
        } else {
            fb.className = "match show no";
            fb.textContent = "Password tidak cocok";
        }
    }
    p?.addEventListener("input", sync);
    c?.addEventListener("input", sync);

    // Submit guard
    const form = document.getElementById("profileForm");
    const submitBtn = document.getElementById("submitBtn");
    form?.addEventListener("submit", (e) => {
        const a = p?.value || "",
            b = c?.value || "";
        if ((a || b) && (a.length < 8 || a !== b)) {
            e.preventDefault();
            sync();
            (a.length < 8 ? p : c)?.focus();
            return;
        }
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.opacity = ".7";
            submitBtn.querySelector("span:last-child").textContent =
                "Memproses...";
        }
    });
});
