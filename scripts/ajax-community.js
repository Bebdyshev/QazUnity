document.addEventListener('DOMContentLoaded', function () {
    fetchFavoritesData();
    const updateForms = document.querySelectorAll('.update');

    updateForms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const userId = this.querySelector('input[name="user_id"]').value;
            const formData = new FormData();
            formData.append('user_id', userId);

            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            const data = JSON.parse(xhr.responseText);
                            handleFavoriteButtons(updateForms, data.favoritesArray);
                            console.log('Updated Favorites Array:', data.favoritesArray);
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                        }
                    } else {
                        console.error('Request failed with status:', xhr.status);
                    }
                }
            };

            xhr.open('POST', '../regprocces/update_favorites.php', true);
            xhr.send(formData);
        });
    });

    function fetchFavoritesData() {
        const initialXhr = new XMLHttpRequest();
        initialXhr.onreadystatechange = function () {
            if (initialXhr.readyState === XMLHttpRequest.DONE) {
                if (initialXhr.status === 200) {
                    try {
                        const initialData = JSON.parse(initialXhr.responseText);
                        handleFavoriteButtons(updateForms, initialData.favoritesArray);
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                } else {
                    console.error('Request failed with status:', initialXhr.status);
                }
            }
        };

        initialXhr.open('GET', '../regprocces/get_initial_favorites.php', true);
        initialXhr.send();
    }

    function handleFavoriteButtons(forms, favoritesArray) {
        forms.forEach(form => {
            const userId = form.querySelector('input[name="user_id"]').value;
            const button = form.querySelector('.favorite-btn');
            const icon = button.querySelector('i');
            const isUserInFavorites = favoritesArray.includes(userId);

            if (isUserInFavorites) {
                button.classList.add('favorited');
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                button.classList.remove('favorited');
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        });
    }
});