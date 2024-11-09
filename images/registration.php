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
        <div class="greet"><h1>Welcome to *Название*</h1><span>Welcome to *Название* -- your supportive and passionate community for life's ever-changing journey.</span></div>
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
            <label class="label2"> <h2>Student</h2> <span class="span">I'm a current student / member of this community.</span> <input class="radio_dot" type="radio" name="status" value="Student"/> </label>
        </div>
        <div class="radio">
             <label class="label2"> <h2>Alumn</h2> <span class="span">I'm a graduate or former student / member of this community.</span> <input class="radio_dot" type="radio" name="status" value="Alumn"/> </label>
        </div>
        <div class="radio">
            <label class="label2"> <h2>Faculty & Staff</h2> <span class="span">I'm a faculty / staff member of this community.</span> <input class="radio_dot" type="radio" name="status" value="Faculty"/> </label>
        </div>
        <div class="radio">
            <label class="label2"> <h2>Friend of the Community</h2> <span class="span">I'm a friend of this community, but neither a student nor an alum/na.</span> <input class="radio_dot" type="radio" name="status" value="Friend"/> </label>
        </div>
        </div>

        <!-- 3 Этап регистрации -->

        <div id="stageIII" class="item" data-width="40">
        <h1>What do you enjoy doing in your free time?</h1>
        <span class="span"> Select at least 1 hobby. We use this to provide you with relevant recommendations and resources.</span>
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
            <input id="volonteer" type="checkbox" name="activity[]" value="Volonteering"/><label for="volonteer">Volonteering</label>
        </div>            
            </div>

            <!-- 4 этап регистрации -->
            <div id="stageVI" class="item" data-width="60">
    <div class="greet"><h1>Where are you in your career today?</h1><span class="span">Select the one that best matches your current status. You can update this at any time.</span></div>
    
    <div id="unemploy" class="radio"><label class="label2"><h2>Find the best career path for me</h2><input class="radio_dot" type="radio" name="carier" value="Noob"/></label></div>

    <div class="radio"><label class="label2"><h2>Upskill and gain exposure</h2><input class="radio_dot" type="radio" name="carier" value="Pro"/></label></div>

    <div class="radio"><label class="label2"><h2>Faculty & Staff</h2><input class="radio_dot" type="radio" name="carier" value="Cheater"/></label></div>
 
    <div class="radio"><label class="label2"><h2>Friend of the Community</h2><input class="radio_dot" type="radio" name="carier" value="God"/></label></div>
        </div>

        <!-- 5 Этап регистрации -->
        <div id="stageV" class="item" data-width="80" data-stage="5">
        <div class="greet"><h1 align="center">Add a photo to 4x your engagement!</h1><span class="span fil" align="center">Members with profile picture experience higher engagement in the community.</span></div>
        <div id="file_con">
        <input type="file" name="image" id="file" class="file">
        </div>
        </div>
        <!-- 6 этап -->
        <div id="stageIV" class="item" data-width="100" data-stage="6">
        <div class="greet">
            <h1 c>Thank you. Your account has been submitted!</h1>
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