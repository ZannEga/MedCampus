/**
 * MedCampus — js/admin.js
 * Shared behaviour untuk semua halaman admin.
 */

document.addEventListener("DOMContentLoaded", () => {
    // ─── AUTH GUARD + SESSION ─────────────────────────────────────────────────
    // const session = window.AppData?.getSession?.();

    // if (!session) {
    //     window.location.href = "/login?role=admin";
    //     return;
    // }

    // if (session.role !== "Admin") {
    //     Toast.show("Access denied. Redirecting...", "warning");
    //     const dest =
    //         session.role === "Doctor" ? "/login?role=doctor" : "/login";
    //     setTimeout(() => {
    //         window.location.href = dest;
    //     }, 1500);
    //     return;
    // }

    // // Update nama admin di topbar
    // document.querySelectorAll(".admin-info h4").forEach((el) => {
    //     el.textContent = session.name;
    // });

    // ─── LOGOUT ───────────────────────────────────────────────────────────────
    document.querySelectorAll('[data-action="logout"]').forEach((btn) => {
        btn.addEventListener("click", () => {
            AppData.logout();
            window.location.href = "/login?role=admin";
        });
    });

    // ─── TOPBAR SEARCH ────────────────────────────────────────────────────────
    const searchInput = document.querySelector(".topbar .search-bar input");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            const q = searchInput.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach((row) => {
                row.style.display = row.textContent.toLowerCase().includes(q)
                    ? ""
                    : "none";
            });
        });
    }

    // ─── SHIFT CARD SELECTION (/admin/schedules/add) ───────────────────────
    document.querySelectorAll(".shift-card").forEach((card) => {
        card.addEventListener("click", () => {
            document
                .querySelectorAll(".shift-card")
                .forEach((c) => c.classList.remove("active"));
            card.classList.add("active");
        });
    });

    // ─── STATUS OPTION CARDS (admin-user-edit.html) ───────────────────────────
    document.querySelectorAll(".status-option").forEach((card) => {
        card.addEventListener("click", () => {
            document
                .querySelectorAll(".status-option")
                .forEach((c) => c.classList.remove("selected"));
            card.classList.add("selected");
        });
    });

    // ─── TOGGLE SWITCHES (admin-settings.html) ────────────────────────────────
    document
        .querySelectorAll('.toggle-switch input[type="checkbox"]')
        .forEach((toggle) => {
            toggle.addEventListener("change", () => {
                const label =
                    toggle.closest(".preference-card")?.querySelector("h4")
                        ?.textContent || "Setting";
                Toast.show(
                    `${label} ${toggle.checked ? "enabled" : "disabled"}.`,
                    "info",
                );
            });
        });

    // ─── MEDICINE STOCK → AUTO STATUS ─────────────────────────────────────────
    const stockInput = document.querySelector('input[type="number"]');
    const statusSel = document.querySelector(
        "#edit-status-display, #add-status-display",
    );
    if (stockInput && statusSel) {
        stockInput.addEventListener("input", () => {
            const n = parseInt(stockInput.value, 10);
            statusSel.value =
                n <= 0 ? "Out of Stock" : n < 20 ? "Low Stock" : "In Stock";
        });
    }

    // ─── USER ROLE / STATUS FILTER (admin-users.html) ─────────────────────────
    const roleFilter = document.querySelector(
        'select[data-filter="role"], #roleFilter',
    );
    if (roleFilter) {
        roleFilter.addEventListener("change", () => {
            const val = roleFilter.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach((row) => {
                const role =
                    row
                        .querySelector("td:nth-child(2)")
                        ?.textContent.toLowerCase() || "";
                row.style.display =
                    val === "all roles" || val === "all" || role.includes(val)
                        ? ""
                        : "none";
            });
        });
    }
    const statusFilter = document.querySelector(
        'select[data-filter="status"], #statusFilter',
    );
    if (statusFilter) {
        statusFilter.addEventListener("change", () => {
            const val = statusFilter.value.toLowerCase();
            document.querySelectorAll("tbody tr").forEach((row) => {
                const badge =
                    row.querySelector(".badge")?.textContent.toLowerCase() ||
                    "";
                row.style.display =
                    val === "active status" ||
                    val === "all" ||
                    badge.includes(val)
                        ? ""
                        : "none";
            });
        });
    }

    // ─── SCHEDULE VIEW TOGGLE ─────────────────────────────────────────────────
    const weeklyBtn = document.querySelector(
        '[data-view="weekly"], #btnWeekly',
    );
    const listBtn = document.querySelector('[data-view="list"],   #btnList');
    const weekHeader = document.querySelector(".admin-schedule-header");
    if (weeklyBtn && listBtn && weekHeader) {
        weeklyBtn.addEventListener("click", () => {
            weeklyBtn.classList.add("btn-primary");
            weeklyBtn.classList.remove("btn-outline");
            listBtn.classList.remove("btn-primary");
            listBtn.classList.add("btn-outline");
            weekHeader.style.display = "";
        });
        listBtn.addEventListener("click", () => {
            listBtn.classList.add("btn-primary");
            listBtn.classList.remove("btn-outline");
            weeklyBtn.classList.remove("btn-primary");
            weeklyBtn.classList.add("btn-outline");
            weekHeader.style.display = "none";
        });
    }

    // ─── FORM SUBMIT WITH VALIDATION (data-submit) ────────────────────────────
    document.querySelectorAll("form[data-submit]").forEach((form) => {
        form.addEventListener("submit", (e) => {
            // e.preventDefault();
            if (!Validator.form(form)) {
                Toast.show("Please fill in all required fields.", "error");
                return;
            }
            const redirect = form.getAttribute("action") || "#";
            const btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.textContent = "Saving…";
                btn.disabled = true;
            }
            Toast.show("Saved successfully!", "success");
            setTimeout(() => {
                if (redirect !== "#") window.location.href = redirect;
            }, 1000);
        });
    });

    // ─── DISCARD BUTTONS ──────────────────────────────────────────────────────
    document.querySelectorAll('[data-action="discard"]').forEach((btn) => {
        btn.addEventListener("click", (e) => {
            // e.preventDefault();
            if (confirm("Discard all changes?")) history.back();
        });
    });

    // ─── SAVE PROFILE (admin-settings.html) ───────────────────────────────────
    document.querySelectorAll('[data-action="save-profile"]').forEach((btn) => {
        btn.addEventListener("click", () =>
            Toast.show("Profile updated successfully!", "success"),
        );
    });

    // ─── SECURITY ITEMS (admin-settings.html) ────────────────────────────────
    document.querySelectorAll(".security-item").forEach((item) => {
        item.addEventListener("click", () => {
            const label = item
                .querySelector("span:first-child, div:first-child")
                ?.textContent?.trim()
                .split("\n")[0];
            if (label) Toast.show(`Opening: ${label}`, "info");
        });
    });

    // ─── AVATAR UPLOAD PREVIEW ────────────────────────────────────────────────
    const avatarInput = document.getElementById("avatarUpload");
    const avatarImgs = document.querySelectorAll(
        ".avatar-edit-box img, #avatarPreview",
    );
    if (avatarInput) {
        avatarInput.addEventListener("change", () => {
            const file = avatarInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) =>
                avatarImgs.forEach((img) => {
                    img.src = e.target.result;
                });
            reader.readAsDataURL(file);
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const isDark = localStorage.getItem('mc_dark_mode') === '1';
    if (isDark) {
        document.body.classList.add('dark-mode');
    }
});