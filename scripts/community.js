document.addEventListener('DOMContentLoaded', function () {
    const favoriteButtons = document.querySelectorAll('.favorite-btn');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function () {
            
            const userId = button.dataset.userId;
            const iconRegular = document.getElementById('favorite-icon-regular-' + userId);
            const iconSolid = document.getElementById('favorite-icon-solid-' + userId);

            if (iconRegular && iconSolid) {
                const isSolidActive = button.dataset.active === 'solid';

                if (isSolidActive) {
                    iconRegular.style.display = 'inline-block';
                    iconSolid.style.display = 'none';
                    button.dataset.active = 'regular';
                } else {
                    iconRegular.style.display = 'none';
                    iconSolid.style.display = 'inline-block';
                    button.dataset.active = 'solid';
                }
            }
        });
    });
});
