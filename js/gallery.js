

// Creating a image previewer for all the images using only one bootstrap modal 
let images = document.querySelectorAll(".openModal") // Selecting all the images 

images.forEach((img) => {
    img.addEventListener("click", function () {
        // Set Modal image source
        document.getElementById("modalImage").src = this.src;

        // show modal
        let modal = new bootstrap.Modal(document.getElementById("imgModal"));
        modal.show();
    })
})



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
    threshold: 0.6
});

sections.forEach(section => observer.observe(section));


// Scroll Animation Observer
const animatedElements = document.querySelectorAll(".scroll-animate");

const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add("show");
        }
    });
}, {
    threshold: 0.2
});

animatedElements.forEach(el => scrollObserver.observe(el));

