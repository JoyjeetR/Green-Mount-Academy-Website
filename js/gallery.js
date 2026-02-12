

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



const sections = document.querySelectorAll(".content-section");
const navLink = document.querySelectorAll(".quick-link");

window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach(section => {
        const sectionTop = section.offsetTop - 150;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop) {
            current = section.getAttribute("id");
        }
    });

    navLink.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href").includes(current)) {
            link.classList.add("active");
        }
    });
});
