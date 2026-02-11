// Closing the offcanvas menu on clicking on the list items inside it

let navLinks = document.querySelectorAll(".galNav");
navLinks.forEach((item) => {
      item.addEventListener('click', () => {
            const offcanvasE1 = document.getElementById('staticBackdrop');
            // Create Bootstrap instance if not existing
            const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasE1);

            offcanvasInstance.hide();
      });
});

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

let natation_gallery = document.querySelectorAll(".galnavLink");
natation_gallery.forEach((item) => {
      item.addEventListener('click', () => {
            document.querySelector(".nav_menu").classList.remove("show");
            const offcanvasE1 = document.getElementById('staticBackdrop');
            // Create Bootstrap instance if not existing
            const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasE1);

            offcanvasInstance.hide();
      })
});