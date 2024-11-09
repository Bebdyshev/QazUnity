document.addEventListener("DOMContentLoaded", function() {
    const updateProfile = document.getElementById("myMessages");
    const formContainer = document.getElementById("myMesCon");

    updateProfile.addEventListener("click", function() {

        if (formContainer.style.display === "none") {
            formContainer.style.display = "block";
        } else {
            formContainer.style.display = "none";
            updateProfile.style.backgroundColor = "white";
        }
    });
});