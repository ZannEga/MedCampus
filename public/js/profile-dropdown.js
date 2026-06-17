/**
 * MedCampus — js/profile-dropdown.js
 * Profile trigger button + dropdown menu untuk doctor & patient navbar.
 */

(function () {
    function getAvatarSrc(session) {
        // Try to get avatar from stored user data first
        if (window.AppData) {
            const users = AppData.getUsers?.() || [];
            const user = users.find((u) => u.id === session?.userId);
            if (user?.avatar) return user.avatar;
        }
        // Fallback to initials placeholder
        const initials = (session?.name || "U")
            .split(" ")
            .filter(Boolean)
            .map((w) => w[0].toUpperCase())
            .slice(0, 2)
            .join("");
        const color =
            session?.role === "Doctor" ? "a7c4a0/ffffff" : "fca5a5/ffffff";
        return `https://placehold.co/100x100/${color}?text=${initials}`;
    }

    function buildDropdown(session, profileHref, isDoctor) {
        const wrap = document.createElement("div");
        wrap.className = "profile-btn-wrap";
        const avatarSrc = getAvatarSrc(session);
        const name = session?.name || "—";
        const roleLabel = session?.role || "";
        const email = session?.email || "";

        wrap.innerHTML = `
      <button class="profile-trigger" id="profileTrigger" aria-haspopup="true" aria-expanded="false">
        <div class="${isDoctor ? "profile-avatar" : "p-avatar"}">
          <img src="${avatarSrc}" alt="Avatar" id="profileAvatarImg">
        </div>
        <span class="p-name" id="profileTriggerName">${name}</span>
        <span class="p-chevron">▼</span>
      </button>

      <div class="profile-menu" id="profileMenu" role="menu">
        <div class="profile-menu-header">
          <div class="pm-avatar"><img src="${avatarSrc}" alt="Avatar"></div>
          <div>
            <h4>${name}</h4>
            <p>${roleLabel}${email ? " • " + email : ""}</p>
          </div>
        </div>

        <a href="${profileHref}" class="profile-menu-item" role="menuitem">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          My Profile
        </a>

        ${
            isDoctor
                ? `
        <a href="${profileHref}?tab=preferences" class="profile-menu-item" role="menuitem">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
          Preferences
        </a>`
                : `
        <a href="${profileHref}?tab=preferences" class="profile-menu-item" role="menuitem">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
          Settings
        </a>`
        }

        <div class="profile-menu-divider"></div>

        <button class="profile-menu-item danger" id="dropdownLogoutBtn" role="menuitem">
          <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
          Logout
        </button>
      </div>
    `;
        return wrap;
    }

    function mountDropdown(isDoctor) {
        const session = window.AppData?.getSession?.();
        const profileHref = isDoctor ? "/doctor/profile" : "/patient/profile";
        const navProfile = document.querySelector(".nav-profile");
        if (!navProfile) return;

        // Remove any existing dropdown wrapper
        navProfile
            .querySelectorAll(".profile-btn-wrap, .profile-dropdown")
            .forEach((el) => el.remove());

        const wrap = buildDropdown(session, profileHref, isDoctor);
        navProfile.appendChild(wrap);

        const trigger = document.getElementById("profileTrigger");
        const menu = document.getElementById("profileMenu");
        if (!trigger || !menu) return;

        // Toggle open/close
        trigger.addEventListener("click", (e) => {
            e.stopPropagation();
            const btnWrap = trigger.closest(".profile-btn-wrap");
            const isOpen = btnWrap.classList.contains("open");
            document
                .querySelectorAll(".profile-btn-wrap.open")
                .forEach((el) => el.classList.remove("open"));
            if (!isOpen) {
                btnWrap.classList.add("open");
                trigger.setAttribute("aria-expanded", "true");
            } else {
                trigger.setAttribute("aria-expanded", "false");
            }
        });

        // Close on outside click
        document.addEventListener("click", () => {
            document
                .querySelectorAll(".profile-btn-wrap.open")
                .forEach((el) => {
                    el.classList.remove("open");
                    el.querySelector(".profile-trigger")?.setAttribute(
                        "aria-expanded",
                        "false",
                    );
                });
        });

        // Prevent close when clicking inside menu
        menu.addEventListener("click", (e) => e.stopPropagation());

        // Logout
        document
            .getElementById("dropdownLogoutBtn")
            ?.addEventListener("click", () => {
                window.AppData?.logout?.();
                window.location.href = isDoctor
                    ? "/login?role=doctor"
                    : "/login";
            });
    }

    document.addEventListener("DOMContentLoaded", () => {
        // Doctor pages have .nav-left (search bar left of logo area)
        const isDoctor = !!document.querySelector(".nav-left");
        mountDropdown(isDoctor);
    });
})();
