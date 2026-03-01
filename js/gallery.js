/**
 * gallery.js — Gallery page behaviour.
 * - Image lightbox: click any gallery image to open it in a Bootstrap modal.
 * - Quick links: highlight the current section in the nav as user scrolls.
 * - Scroll animation: add .show to elements when they enter the viewport.
 */

// ---------------------------------------------------------------------------
// Image preview / lightbox: one modal for all images with class .openModal
// ---------------------------------------------------------------------------
let images = document.querySelectorAll(".openModal");

images.forEach((img) => {
    img.addEventListener("click", function () {
        document.getElementById("modalImage").src = this.src;
        let modal = new bootstrap.Modal(document.getElementById("imgModal"));
        modal.show();
    });
});



// ---------------------------------------------------------------------------
// Quick-link active state: when a gallery section scrolls into view, highlight its link in the nav
// ---------------------------------------------------------------------------
const sections = document.querySelectorAll(".ImgSection");
const navLinks = document.querySelectorAll(".quick-link");

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            navLinks.forEach(link => {
                link.classList.remove("active");
                if (link.getAttribute("href").includes(entry.target.id)) {
                    link.classList.add("active");
                }
            });
        }
    });
}, {
    threshold: 0.6  // Section is "in view" when 60% visible
});

sections.forEach(section => observer.observe(section));


// ---------------------------------------------------------------------------
// Scroll animation: add class .show to .scroll-animate elements when they enter the viewport
// ---------------------------------------------------------------------------
const animatedElements = document.querySelectorAll(".scroll-animate");

const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add("show");
        }
    });
}, {
    threshold: 0.2  // Trigger when 20% of element is visible
});

animatedElements.forEach(el => scrollObserver.observe(el));

