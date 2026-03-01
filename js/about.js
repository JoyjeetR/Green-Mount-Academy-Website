/**
 * about.js — About page: if branchesContainer and branches exist, render branch location badges.
 * Expects a global `branches` array and an element with id="branchesContainer".
 */
const container = document.getElementById("branchesContainer");

if (container && typeof branches !== "undefined") {
  branches.forEach(branch => {
    container.innerHTML += `
    <div class="col-md-3" data-aos="fade-up">
      <span class="badge bg-success p-3 w-100 rounded-pill">
        ${branch.location}
      </span>
    </div>
  `;
  });
}
