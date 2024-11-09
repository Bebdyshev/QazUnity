let active = document.querySelector('.active');
let prevBtn = document.querySelector('.prev');
let nextBtn = document.querySelector('.next');
let form = document.querySelector('form');

function isPrev() {
  prevBtn.style.display =
    active.dataset.stage !== "1"
      ? 'inline-block'
      : 'none';
}

function isNext() {
  nextBtn.style.display =
    active.dataset.stage !== "2"
      ? 'inline-block'
      : 'none';
}

prevBtn.addEventListener('click', function () {
  let prevElem = active.previousElementSibling;
  active.classList.remove('active');
  active = prevElem;
  active.classList.add('active');

  isPrev();
  isNext();
});

nextBtn.addEventListener('click', function () {
  let nextElem = active.nextElementSibling;
  if (nextElem) {
    active.classList.remove('active');
    active = nextElem;
    active.classList.add('active');

    isPrev();
    isNext();
  }
});

isPrev();
isNext();

function newPage() {
  window.location.href = "index.php";
}

document.addEventListener("DOMContentLoaded", function() {
    const updateProfile = document.getElementById("update_profile");
    const formContainer = document.getElementById("form_container");

    updateProfile.addEventListener("click", function() {
        updateProfile.style.backgroundColor = "#e4f7ff";

        if (formContainer.style.display === "none") {
            formContainer.style.display = "block";
        } else {
            formContainer.style.display = "none";
            updateProfile.style.backgroundColor = "white";
        }
    });
});