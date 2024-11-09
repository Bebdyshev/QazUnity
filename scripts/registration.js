let active = document.querySelector('.active');
let progress = document.querySelector('.progress');
let prevBtn = document.querySelector('.prev');
let nextBtn = document.querySelector('.next');
let form = document.querySelector('form');

prevBtn.style.display = 'none';
nextBtn.style.display = 'none';

function isPrev() {
  prevBtn.style.display =
    active.dataset.stage !== "1" && active.dataset.stage !== "6"
      ? 'inline-block'
      : 'none';
}

function isNext() {
  nextBtn.style.display =
    active.dataset.stage !== "1" && active.dataset.stage !== "6"
      ? 'inline-block'
      : 'none';
}


document.getElementById('sign').addEventListener('click', function () {
  let nextElem = active.nextElementSibling;
  if (nextElem) {
    active.classList.remove('active');
    active = nextElem;
    active.classList.add('active');

    progress.style.width = active.dataset.width + '%';

    isPrev();
    isNext();
  }
});

prevBtn.addEventListener('click', function () {
  let prevElem = active.previousElementSibling;
  active.classList.remove('active');
  active = prevElem;
  active.classList.add('active');

  progress.style.width = active.dataset.width + '%';

  isPrev();
  isNext();
});

nextBtn.addEventListener('click', function () {
  let nextElem = active.nextElementSibling;
  if (nextElem) {
    active.classList.remove('active');
    active = nextElem;
    active.classList.add('active');

    progress.style.width = active.dataset.width + '%';

    isPrev();
    isNext();
  }
});

isPrev();
isNext();

function newPage() {
  window.location.href = "index.php";
}

