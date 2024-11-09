<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project</title>
    <link rel="stylesheet" href="styles/registration.css">
</head>
<body>
<div class="fake_form">
    <div id="progressBar">
        <div class="progress"></div>
    </div>
    <form action="regprocces/register.php" method="post" autocomplete="off" enctype="multipart/form-data">

        <!-- 1 Этап регистрации -->

        <div class="item active" data-width="0" data-stage="1">
        <div class="greet"><h1>Welcome to QazUnity </h1><span>Welcome to QazUnity - your supportive community for career development and growth opportunities.</span></div>
        <br><br>
            <div id="first"><label>First Name </label><input class="input"  type="text" name="name" placeholder="Enter your first name" autocomplete="off"></div>            
            <div id="last"><label>Last Name </label><input class="input"  type="text" name="surname" placeholder="Enter your last name" autocomplete="off"></div>
            <label>Email </label>
            <input class="input" type="email" name="email" placeholder="Enter your email" autocomplete="off">
            <label>Password</label>
            <input class="input" type="password" name="pass" placeholder="8 characters minimum" autocomplete="off">

            <button class="child1" type="button" id="back" onClick="newPage()">Back</button>
            <button class="child1" type="button" id="sign">Sign up</button>
        </div>

        <!-- 2 Этап регистрации -->

        <div class="item" data-width="20">
        <div class="greet"><h1>I am joining as a</h1></div>
        <div class="radio">
            <label class="label2"> <h2 class="role_h2">Career Explorer</h2> <span class="span">I'm looking for career advice and guidance to discover new professional paths.</span> <input class="radio_dot" type="radio" name="status" value="Explorer"/> </label>
        </div>
        <div class="radio">
             <label class="label2"> <h2 class="role_h2">Mentor</h2> <span class="span">I'll provide mentorship and share career advice with those seeking to grow professionally.</span> <input class="radio_dot" type="radio" name="status" value="Mentor"/> </label>
        </div>
        <div class="radio">
            <label class="label2"> <h2 class="role_h2">Resource Provider</h2> <span class="span">I'll share valuable resources such as job opportunities, articles, and advice related to career development.</span> <input class="radio_dot" type="radio" name="status" value="Provider"/> </label>
        </div>
        <div class="radio">
            <label class="label2"> <h2 class="role_h2">Community Friend</h2> <span class="span">I'm a friend of this community, supporting career development but not actively seeking or mentoring.</span> <input class="radio_dot" type="radio" name="status" value="Friend"/> </label>
        </div>
        </div>

        <!-- 3 Этап регистрации -->

        <div id="stageIII" class="item" data-width="40">
        <h1>What do you enjoy doing in your free time?</h1>
        <span class="span"> Select at least 1 hobby. We use this to recommend relevant career paths and resources.</span>
        <div id="creators">
        <h2>Creators</h2>
        <input id="crafts" type="checkbox" name="activity[]" value="Crafts"/><label for="crafts">Crafts</label>
        <input id="content" type="checkbox" name="activity[]" value="Content"/><label for="content">Creating content</label>
        <input id="language" type="checkbox" name="activity[]" value="Language"/><label for="language">Learning new languages</label>
        <input id="music" type="checkbox" name="activity[]" value="Music"/><label for="music">Music</label>
        <input id="photo" type="checkbox" name="activity[]" value="Photography"/><label for="photo">Photography</label>
        <input id="travel" type="checkbox" name="activity[]" value="Traveling"/><label for="travel">Traveling</label>
        </div>

        <div id="doers">
            <h2>Doers</h2>
            <input id="outdoor" type="checkbox" name="activity[]" value="Being outdoors"/><label for="outdoor">Being outdoors</label>
            <input id="building" type="checkbox" name="activity[]" value="Building"/><label for="building">Building</label>
            <input id="exercise" type="checkbox" name="activity[]" value="Exercise"/><label for="exercise">Exercise</label>
            <input id="garden" type="checkbox" name="activity[]" value="Gardening"/><label for="garden">Gardening</label>
        </div>

        <div id="helpers">
            <h2>Helpers</h2>
            <input id="group" type="checkbox" name="activity[]" value="Group activities"/><label for="group">Group activities</label>
            <input id="sus" type="checkbox" name="activity[]" value="Sustainability"/><label for="sus">Sustainability</label>
            <input id="team" type="checkbox" name="activity[]" value="Team exercise"/><label for="team">Team exercise</label>
            <input id="volonteer" type="checkbox" name="activity[]" value="Volunteering"/><label for="volonteer">Volunteering</label>
        </div>            
            </div>

            <!-- 4 этап регистрации -->
            <div id="stageVI" class="item" data-width="60">
    <div class="greet"><h1>What are you looking for right now?</h1><span class="span">Select the option that best describes your current career status.</span></div>
    
    <div id="unemploy" class="radio2"><label class="label3"><h2>Starting my career</h2><input class="radio_dot_2" type="radio" name="carier" value="Starting"/></label></div>

    <div class="radio2"><label class="label3"><h2>Developing new skills</h2><input class="radio_dot_2" type="radio" name="carier" value="Developing"/></label></div>

    <div class="radio2"><label class="label3"><h2>Faculty & Staff</h2><input class="radio_dot_2" type="radio" name="carier" value="Faculty"/></label></div>
 
    <div class="radio2"><label class="label3"><h2>Friend of the Community</h2><input class="radio_dot_2" type="radio" name="carier" value="Friend"/></label></div>
        </div>

        <!-- 5 Этап регистрации -->
        <div id="stageV" class="item" data-width="80" data-stage="5">
        <div class="greet"><h1 align="center">Add a photo to boost your professional presence!</h1><span class="span fil" align="center">Profiles with a picture are more likely to attract attention in the career community.</span></div>
        <div id="file_con">
        <input type="file" name="image" id="file" class="file">
        </div>
        </div>
        <!-- 6 этап -->
        <div id="stageIV" class="item" data-width="100" data-stage="6">
        <div class="greet">
            <h1>Thank you. Your profile has been created!</h1>
            <button id="sign" type="submit">Finish</button>
        </div>
    </div>
    </form>
    <div id="actions" class="actions">
        <button id="prevAct" type="button" class="fa fa-arrow-left prev">Back</button>
        <button id="nextAct"type="button" class="fa fa-arrow-left next">Next</button>
    </div>
</div>
<script src="scripts/registration.js"></script>
</body>
</html>
