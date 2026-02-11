const container = document.getElementById("branchesContainer");

branches.forEach(branch => {
  container.innerHTML += `
    <div class="col-md-3" data-aos="fade-up">
      <span class="badge bg-success p-3 w-100 rounded-pill">
        ${branch.location}
      </span>
    </div>
  `;
});
