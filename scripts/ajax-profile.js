$(document).ready(function() {
	const leftButton = document.querySelector(".ninggers");

    var favoriteUserIdString;

    var isEqualIds = currentUserId != urlUserId;

    if (isEqualIds) {
        hideEditButtons();
    }

    $('.update').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var popup = $(this).closest('.popup');

        $.ajax({
            url: '../regprocces/update/update.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('succcces:', response.message);
                    popup.hide();
                } else {
                    console.error('loh:', response.message);
                }
            },
            error: function(error) {
                console.error('loh:', error);
            }
        });
    });

    $.ajax({
        url: "../regprocces/update/get_user_profile_data.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success && response.data) {

                currentUserId = response.data[0].id;
                urlUserId = response.data[0].id;
                favoriteUserIdString = response.data[0].favorites;

                loadUserProfileData();
                loadFavoriteProfileData(favoriteUserIdString);
            } else {
                console.error("Ошибка при загрузке данных:", response.message);
            }
        },
        error: function (error) {
            console.error("Произошла ошибка при загрузке данных:", error);
        }
    });

   

    function loadUserProfileData() {
        $.ajax({
            url: "../regprocces/update/get_user_profile_data.php",
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success && response.data) {
                    var fullname = response.data[0].name + ' ' + response.data[0].surname;

                    displayData("major", response.data[0].major, "popupA-btn");
                    displayData("impact", response.data[0].impact, "popupB-btn");
                    displayData("scale_uni", response.data[0].scale_uni, "popupC-btn");
                    displayData("scale_work", response.data[0].scale_work, "popupD-btn");
                    displayData("resources", response.data[0].resources, "popupE-btn");
                    displayData("advice", response.data[0].advice, "popupF-btn");
    
                    displayData2("profileFullname", fullname);
                    displayData2("profileExperience", response.data[0].experience);
                    displayData2("profilePlace", response.data[0].place);
    
                    var workplaceContent = document.getElementById('workplaceContent');
                    var roleplaceContent = document.getElementById('workroleContent');
                    var educationContent = document.getElementById('educationContent');
                    var majorityContent = document.getElementById('majorityContent');
    
                    if (response.data[0].work && response.data[0].role) {
                        workplaceContent.innerHTML = response.data[0].work;
                        roleplaceContent.innerHTML = response.data[0].role;
                    } else {
                        workplaceContent.innerHTML = "Work place";
                    }
    
                    if (response.data[0].education && response.data[0].majority) {
                        educationContent.innerHTML = response.data[0].education;
                        majorityContent.innerHTML = response.data[0].majority;
                    } else {
                        educationContent.innerHTML = "University";
                    }
    
                    var helpContainer = document.getElementById('profileHelp');
                    helpContainer.innerHTML = ''; 

                    if (response.data[0].help && response.data[0].help.trim() !== "") {
                        var helpArray = response.data[0].help.split(',');

                        helpArray.forEach(function (helpElement) {
                            var helpDiv = document.createElement('div');
                            helpDiv.className = 'help-item';
                            helpDiv.textContent = helpElement.trim(); 
                            helpContainer.appendChild(helpDiv);
                        });
                    } else {
                        var helpDiv = document.createElement('div');
                        helpDiv.className = 'help-item'; 
                        helpDiv.textContent = "No help specified";
                        helpContainer.appendChild(helpDiv);
                    }
                } else {
                    console.error("Ошибка при загрузке данных:", response.message);
                }
            },
            error: function (error) {
                console.error("Произошла ошибка при загрузке данных:", error);
            }
        });
    }


    function loadFavoriteProfileData(favoriteUserIds) {

        var favoriteUserIdArray = favoriteUserIds.split(',').map(Number);

        $.ajax({
            url: `../regprocces/update/community/get_favorite_profile_data.php?favorite_user_ids=${favoriteUserIdArray.join(',')}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success && response.data) {
                    $('.favoriteUsersCon').empty();

                    response.data.forEach(function(user) {
                        var userProfile = createProfileElement(user);
                        console.log(isset(userProfile));
                        $('.favoriteUsersCon').append(userProfile);
                    });
                } else {
                    leftButton.style.display = 'none';
                }
            },
            error: function (error) {
                console.error("Произошла ошибка при загрузке данных:", error);
            }
        });
    }

    function createProfileElement(user) {
        var userProfileDiv = $('<div class="user-profile"></div>');
        userProfileDiv.append('<img class="user-image" src="../regprocces/images/' + user.image + '">');
        userProfileDiv.append('<h2>' + user.name + ' ' + user.surname + '</h2>');
        userProfileDiv.append('<p class="experience">' + user.experience + '</p>');
        userProfileDiv.append('<h2> I can help with </h2>');

        var bookmarkContainer = $(`<div class="bookmark-profile"></div>`);
    
        bookmarkContainer.append(`<a class="remove-favorite" data-user-id="${user.user_id}"><i class="fa-solid fa-bookmark"></i></a>`);

        userProfileDiv.append(bookmarkContainer);

        var helpContainer = $('<div class="help-container"></div>');

        if (user.help && user.help.trim() !== "") {
            var helpArray = user.help.split(',');
    
            var maxItems = 2;
            for (var i = 0; i < Math.min(helpArray.length, maxItems); i++) {
                var helpItem = $('<div class="db_help"><p class="db_pol">' + helpArray[i].trim() + '</p></div>');
                helpContainer.append(helpItem);
            }
    
            if (helpArray.length > maxItems) {
                var remainingItems = helpArray.length - maxItems;
                var remainingItemDiv = $('<div class="db_help"><p class="db_pol">+' + remainingItems + '</p></div>');
                helpContainer.append(remainingItemDiv);
            }
        } else {
            var noHelpDiv = $('<div class="db_help"><p class="db_pol">No help specified</p></div>');
            helpContainer.append(noHelpDiv);
        }
        userProfileDiv.append(helpContainer);
        userProfileDiv.append(`<a href="message.php?recipient_id=${user.user_id}">Message</a>`);

        bookmarkContainer.on('click', '.remove-favorite', function (e) {
            e.preventDefault();
            var userIdToRemove = $(this).data('user-id');
            removeUserFromFavorites(userIdToRemove);
        });

        function removeUserFromFavorites(userId) {
            $.ajax({
                url: `../regprocces/update_favorites.php?user_id=${userId}`,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        console.log(`User ${userId} removed from favorites.`);
                        loadFavoriteProfileData(favoriteUserIdString);
                    } else {
                        console.error("Failed to remove user from favorites:", response.message);
                    }
                },
                error: function (error) {
                    console.error("Error removing user from favorites:", error);
                }
            });
            location.reload();

        }        

        //css

        helpContainer.css({
            'background-color': 'transparent',
        });

        userProfileDiv.find('.db_help').css({
            'display': 'inline-block',
            'margin': '1px 2px',
            'background-color': 'rgba(128, 128, 128, 0.158)',
            'border-radius': '8px',
            'padding': '2px 4px',
        });
        
        userProfileDiv.find('.db_poll').css({
            'margin': '7px 105px',
        });

        userProfileDiv.css({
            'display': 'inline-block', 
            'float': 'left',   
            'position': 'relative',
            'height': '500px',
            'min-width': '300px',
            'max-width': '300px',
            'padding': '0px 15px',
            'margin': '1px 10px',
            'border': '1px solid #f1f1f1',
            'overflow': 'hidden',
            '-webkit-box-shadow': '0px 0px 15px 2px rgb(0 0 0 / 10%)',
            'box-shadow': '0px 0px 15px 2px rgb(0 0 0 / 10%)',
            'background-color': 'white',
            'border-radius': '10px',
            'transition': '0.5s'
        });
        
        bookmarkContainer.css({
            'position': 'absolute',
            'top': '1%',
            'right': '15%',
        });

        bookmarkContainer.find('button').css({
            'background': 'transparent',
            'border': 'none'
        });

        userProfileDiv.hover(
            function () {
                $(this).css('transform', 'scale(1.035)');
            },
            function () {
                $(this).css('transform', 'scale(1)');
            }
        );

        userProfileDiv.find('a').css({
            'background-color': 'transparent',
            'color': '#7011ce',
            'position': 'absolute',
            'height': '40px',
            'width': '80%',
            'transition': '0.3s ease',
            'border-radius': '7px'
        });

        userProfileDiv.find('.user-image').css({
            'padding': 'auto',
            'width': '100%',
            'height': '60%',
            'margin-top': '15px', 
            'border-radius': '10px'
        });
    
        userProfileDiv.find('h2').css({
            'color': 'black',
            'padding': '5px 0px 1px 4px',
            'font-size': '20px'
        });
    
        userProfileDiv.find('.experience').css({
            'color': 'rgba(0, 0, 0, 0.603)'
        });

        return userProfileDiv;
    }
   

    function displayData2(titleId, data) {
        var titleElement = document.getElementById(titleId);
        titleElement.textContent = data;
        titleElement.parentNode.style.display = "block";
    }

    function displayData(titleId, data, buttonId) {
        var titleElement = document.getElementById(titleId);
        var buttonElemnt = document.getElementById(buttonId);

        if (data && data.trim() !== "") {
            titleElement.textContent = data;
            titleElement.parentNode.style.display = "block";
            buttonElemnt.style.display = "none";
        } else {
            titleElement.parentNode.style.display = "none";
            buttonElemnt.style.display = "block";
            if (isEqualIds) {
                hideEditButtons();
            }
        }
    }

    function hideEditButtons() {
        $('.show-popup').hide();
    }


    setInterval(function() {
        loadUserProfileData();
    }, 100);
});
