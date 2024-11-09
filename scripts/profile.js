document.addEventListener('DOMContentLoaded', function() {
    const scrollImages = document.querySelector(".favoriteUsersCon");
	const scrollLength = scrollImages.scrollWidth - scrollImages.clientWidth;
	const leftButton = document.querySelector(".left-pro");
	const rightButton = document.querySelector(".right-pro");
    const showPopupIcons = document.querySelectorAll('.show-popup');
    const hidePopupIcons = document.querySelectorAll('.cancel');

    showPopupIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const popup = document.getElementById(target);
            popup.style.display = 'block';
        });
    });

    hidePopupIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            const popup = document.getElementById(target);
            popup.style.display = 'none';
        });
    });

    $('.row').click(function() {
        $(this).find('input[type="radio"]').prop('checked', true);
        $('.row').removeClass('highlight');
        $(this).addClass('highlight');
    });
  
	function checkScroll() {
	  const currentScroll = scrollImages.scrollLeft;
	  if (currentScroll === 0) {
		leftButton.setAttribute("disabled", "true");
		rightButton.removeAttribute("disabled");
	  } else if (currentScroll === scrollLength) {
		rightButton.setAttribute("disabled", "true");
		leftButton.removeAttribute("disabled");
	  } else {
		leftButton.removeAttribute("disabled");
		rightButton.removeAttribute("disabled");
	  }
	}
  
	scrollImages.addEventListener("scroll", checkScroll);
	window.addEventListener("resize", checkScroll);
	checkScroll();
  
	function leftScroll() {
	  scrollImages.scrollBy({
		left: -400,
		behavior: "smooth"
	  });
	}
  
	function rightScroll() {
	  scrollImages.scrollBy({
		left: 400,
		behavior: "smooth"
	  });
	}
  
	leftButton.addEventListener("click", leftScroll);
	rightButton.addEventListener("click", rightScroll);
});