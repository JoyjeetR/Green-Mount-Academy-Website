// Preloader Hide After Page Load
document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");

    if (preloader) {
        setTimeout(() => {
            preloader.classList.add("hide");
        }, 300);
    }
});



//----------------------------------------Lazy load map iframes in tabs----------------------------------------
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


// ----------------------------------------Quick scroll button to top and bottom----------------------------------------
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

// -------------------------------- Lazy Load Maps (Clean Version) --------------------------------
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


// Success popup after form submission
function showSuccessPopup() {
    const popup = document.getElementById("successPopup");
    if (popup) popup.classList.add("show");
}

function closeSuccessPopup() {
    const popup = document.getElementById("successPopup");
    if (popup) popup.classList.remove("show");
}




// Prevent Summit Button spam of enquiry form by disabling it after first click until the form is processed
document.querySelector("#enquiryForm")?.addEventListener("submit", function () {
    const enquiryBtn = document.getElementById("submitEnquiryBtn");
    enquiryBtn.disabled = true;
    enquiryBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
});