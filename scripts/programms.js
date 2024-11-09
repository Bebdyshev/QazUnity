document.addEventListener('DOMContentLoaded', function () {
    const createButton =  document.querySelector('#create-btn');

    createButton.addEventListener('click', function () {
        Headers('../main/create.php');
    });
});