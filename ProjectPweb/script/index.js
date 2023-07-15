const navbar = document.querySelector(".navbar");

document.addEventListener("scroll", () => {
  if (window.scrollY > 0) {
    navbar.classList.add("scroll");
  } else {
    navbar.classList.remove("scroll");
  }
});

const redirectToPage = (link) => {
  window.location.href = link;
};

function showPage(shown, hidden) {
  document.getElementById(shown).style.display = "block";
  document.getElementById(hidden).style.display = "none";
}

function buttonActive(active, inactive) {
  document.getElementById(active).className = "active";
  document.getElementById(inactive).className = "";
}

function drugSelection() {
  let tipe = document.getElementById("tipe").value;
}
