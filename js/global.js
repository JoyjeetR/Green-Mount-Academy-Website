/**
 * global.js — Shared behaviour for all main site pages (Home, About, Gallery, Branches, Contact).
 * Handles: preloader show/hide, mobile menu preloader, link-click preloader, scroll-to-top/bottom button,
 * lazy-loaded Google Maps on Contact branch tabs, and contact form success popup / submit-button state.
 */
// ---------------------------------------------------------------------------
// Preloader: hide after page load and when returning from back/forward cache
// ---------------------------------------------------------------------------
function hidePreloader() {
    const preloader = document.getElementById("preloader");
    if (preloader) preloader.classList.add("hide");
}

document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");
    if (preloader) {
        setTimeout(hidePreloader, 300);
    }
});

// When returning from another page (e.g. Back from student login), bfcache restores the page
// without firing DOMContentLoaded again — so hide the preloader on pageshow if persisted
window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
        hidePreloader();
    }
});

// Hide preloader when mobile side menu (offcanvas) is opened or closed
document.addEventListener("DOMContentLoaded", function () {
    const sideMenu = document.getElementById("right_nav");
    if (sideMenu) {
        sideMenu.addEventListener("shown.bs.offcanvas", hidePreloader);
        sideMenu.addEventListener("hidden.bs.offcanvas", hidePreloader);
    }
});

// Show preloader on <a> or <button> click (instant navigation)
document.addEventListener("DOMContentLoaded", function() {
    const preloader = document.getElementById("preloader");

    // Delegate click events for <a> and <button>
    document.body.addEventListener("click", function(e) {
        let target = e.target;

        // Don't show preloader when opening or closing mobile side menu (toggler, offcanvas trigger, close button)
        if (
            target.closest(".navbar-toggler") ||
            target.closest("[data-bs-toggle='offcanvas']") ||
            target.closest(".btn-close[data-bs-dismiss='offcanvas']") ||
            target.closest(".offcanvas-backdrop")
        ) {
            return;
        }

        // Traverse up in case there's an icon or inner span clicked inside <a> or <button>
        while (target && target !== document.body) {
            if (target.tagName === "A") {
                const href = target.getAttribute("href");
                // Ignore links that open in new tab/window, or anchor same-page, or have no meaningful href
                if (
                    href &&
                    !href.startsWith("javascript:") &&
                    !href.startsWith("#") &&
                    !target.target // Don't show preloader on target="_blank"
                ) {
                    if (preloader) {
                        preloader.classList.remove("hide");
                    }
                    // Let navigation happen naturally
                }
                break;
            }
            if (target.tagName === "BUTTON" && !target.type?.toLowerCase().includes("submit")) {
                // If type is submit, ignore (for forms)
                if (preloader) {
                    preloader.classList.remove("hide");
                }
                break;
            }
            target = target.parentElement;
        }
    }, true);
});

// ---------------------------------------------------------------------------
// Contact page: inject map iframe when a branch tab is shown (legacy handler)
// ---------------------------------------------------------------------------
document.addEventListener("shown.bs.tab", function (event) {

    const targetId = event.target.getAttribute("data-bs-target");
    const tabPane = document.querySelector(targetId);

    const mapContainer = tabPane.querySelector(".map-frame");

    if (mapContainer && !mapContainer.querySelector("iframe")) {

        const iframe = document.createElement("iframe");
        iframe.src = mapContainer.dataset.src;
        iframe.className = "map-frame";
        iframe.loading = "lazy";
        iframe.referrerPolicy = "no-referrer-when-downgrade";

        mapContainer.appendChild(iframe);
    }

});


// ---------------------------------------------------------------------------
// Smart scroll button: floating button shows scroll progress; click scrolls to bottom or top
// ---------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {

    const wrapper = document.getElementById("smartScrollWrapper");
    const btn = document.getElementById("smartScrollBtn");
    const circle = document.querySelector(".progress-ring__circle");

    if (!wrapper || !btn || !circle) return;

    let lastScroll = 0;
    let hideTimer;
    let currentDirection = "down";

    const radius = 24;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    function setProgress(percent) {
        const offset = circumference - (percent / 100) * circumference;
        circle.style.strokeDashoffset = offset;
    }

    window.addEventListener("scroll", () => {

        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;

        setProgress(scrollPercent);

        if (Math.abs(scrollTop - lastScroll) < 5) return;

        wrapper.classList.add("show");

        // Detect scroll direction
        if (scrollTop > lastScroll) {
            currentDirection = "down";
            btn.innerHTML = '<i class="bi bi-arrow-down"></i>';
        } else {
            currentDirection = "up";
            btn.innerHTML = '<i class="bi bi-arrow-up"></i>';
        }

        lastScroll = scrollTop <= 0 ? 0 : scrollTop;

        clearTimeout(hideTimer);
        hideTimer = setTimeout(() => {
            wrapper.classList.remove("show");
        }, 800);

    });

    /* CLICK LOGIC — Sticky Header Safe */
    btn.addEventListener("click", () => {

        if (currentDirection === "down") {

            const footer = document.querySelector("footer");
            if (footer) {
                footer.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }

        } else {

            const main = document.querySelector("main");

            if (main) {
                main.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }

        }

    });

});

// ---------------------------------------------------------------------------
// Contact page: load Google Map iframe only when its branch tab becomes active (saves bandwidth)
// ---------------------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {

    function loadMap(iframe) {
        if (iframe && iframe.dataset.src && !iframe.src) {
            iframe.src = iframe.dataset.src;
        }
    }

    // 1️⃣ Load map for initially active tab
    const activePane = document.querySelector(".tab-pane.active");
    if (activePane) {
        const iframe = activePane.querySelector("iframe[data-src]");
        loadMap(iframe);
    }

    // 2️⃣ Load map when switching tabs
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function () {
            const targetPane = document.querySelector(this.dataset.bsTarget);
            const iframe = targetPane.querySelector("iframe[data-src]");
            loadMap(iframe);
        });
    });

});


// ---------------------------------------------------------------------------
// Contact page: success popup and enquiry form submit-button state
// ---------------------------------------------------------------------------
function showSuccessPopup() {
    const popup = document.getElementById("successPopup");
    if (popup) popup.classList.add("show");
}

function closeSuccessPopup() {
    const popup = document.getElementById("successPopup");
    if (popup) popup.classList.remove("show");
}




// Disable enquiry submit button and show "Submitting..." to prevent double submissions
document.querySelector("#enquiryForm")?.addEventListener("submit", function () {
    const enquiryBtn = document.getElementById("submitEnquiryBtn");
    enquiryBtn.disabled = true;
    enquiryBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
});