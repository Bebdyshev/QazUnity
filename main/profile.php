<?php
    session_start();

    include '../regprocces/config.php';

    if($_SESSION['lang'] == "en") {
        include('languages/en-profile.php');
    } else if($_SESSION['lang'] == "kz") {
        include('languages/kz-profile.php');
    } else if($_SESSION['lang'] == "ru") {
        include('languages/ru-profile.php');
    }

    $currentUserId = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

    $urlUserId = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

    $_SESSION['url_id'] = $urlUserId;

    if (isset($_SESSION['id'])) {
        require_once('../regprocces/db.php');
        require_once('../regprocces/message_counter.php');

        $get_user_query = "SELECT u.* FROM users u WHERE u.id=$urlUserId";
        $result = $conn->query($get_user_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userUrlImage = $row["image"]; 
        }

        $get_user_query = "SELECT u.* FROM users u WHERE u.id=$currentUserId";
        $result = $conn->query($get_user_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userImage = $row["image"]; 
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile page</title>
    <link rel="icon" href="C:\xampp\htdocs\phpscript\images\favicon_io\favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="C:\xampp\htdocs\phpscript\images\favicon_io\favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../styles/profile.css">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    <script src="../scripts/profile.js"></script>
</head>
<body>
<div id="loader">
    <img id="loadGif" src="../images/loader.gif">
</div>
<header>
<div class="logo">
        <img src="../images/logo-favicon.png" alt="logo" class="logo" width="50px" height="60px"> <span id="logoText">QAZUNITY</span>
    </div>        <div id="line"></div>
        <nav>
            <ul class="nav_links">
                <li><a id="home" href="home.php" color="#7011ce" class="a"> <?php echo $lang['home']; ?> </a></li>    
                <li><a id="career" href="#" class="a"><?php echo $lang['connect']; ?> <i class="fa-solid fa-caret-down nav_i"></i></a>
                        <ul class="dropdown">
                            <li><a href="community.php"><?php echo $lang['community']; ?></a></li>
                            <li><a href="#"><?php echo $lang['groups']; ?></a></li>
                            <li><a href="programms.php"><?php echo $lang['programs']; ?></a></li>
                        </ul>
                </li>    
                <!-- <li><a id="connect" href="#" class="a">---<i class="fa-solid fa-caret-down nav_i"></i></a>
                        <ul class="dropdown">
                            <li><a href="#">Career Paths</a></li>
                            <li><a href="#">Jobs</a></li>
                            <li><a href="#">Projects</a></li>
                        </ul>
                </li>     -->
                <li><a id="inbox" href="inbox.php" class="a"><?php echo $lang['inbox']; ?><?php if (isset($count_other_messages) && $count_other_messages > 0) { ?><span class="message-counter"><?php echo $count_other_messages; ?></span><?php } ?></a></li>
                <li><a id="contacts" href="#" class="a"><?php echo $lang['contacts']; ?></a></li>    
                <li><a id="career" href="#" class="a"><?php echo $lang['lang']; ?> <i class="fa-solid fa-caret-down nav_i"></i></a>
                        <ul class="dropdown">
                            <li><a href="home.php?lang=kz">ҚАЗ</a></li>
                            <li><a href="home.php?lang=ru">РУС</a></li>
                            <li><a href="home.php?lang=en">ENG</a></li>
                        </ul>
                </li>
            </ul>  
        </nav>
        <a href="profile.php?user_id=<?php echo $_SESSION['id']; ?>" class="cta">
            <img id="user_pfp" src="../regprocces/images/<?php echo $userImage;?>" width="60px" height="60px">
        </a>
</header>

<div id="main_home">
    <div id="page">
        <div class="profileSection">
            <section>
                <div class="scale"><img id="profileImage" src="../regprocces/images/<?php echo $userUrlImage ?>" width="400px" height="450px"></div>
                <div id="profileInfo">
                    <h1 style="font-size: 35px;" > <?php echo $lang['iam']; ?> <span style="font-size: 35px;" id="profileFullname"> </span><i class="fa-regular fa-pen-to-square show-popup" data-target="popup1"></i> </h1>
                    <span style="color:rgba(0, 0, 0, 0.603); font-weight: 500; font-size: 25px; margin: 10px 0px"> <span id="profileExperience" style="color:rgba(0, 0, 0, 0.603); font-weight: 500; font-size: 25px; margin: 10px 0px"></span> <i class="fa-regular fa-pen-to-square show-popup" data-target="popup2"></i> </span>
                    <span style="margin: 30px 0px; font-size: 25px; padding-top:0px;"> <?php echo $lang['ilive']; ?> <span id="profilePlace" style="margin: 30px 0px; font-size: 25px; padding-top:20px;"></span> <i class="fa-regular fa-pen-to-square show-popup" data-target="popup3"></i> </span> 
                    <h3 style="color:black; font-weight: 600; font-size: 25px; margin: 10px -1px "><?php echo $lang['ihelp']; ?> <i class="fa-regular fa-pen-to-square show-popup" data-target="popup4"></i></h3>
                    <div class='help' id="profileHelp"></div>
                </div>
            </section>
        </div>

        <div class="ninggers">
            <div id="hen">
                <p class="profileTitle"><?php echo $lang['favorite']; ?></p>
            </div>
            <div class="profileSection">
                <div id="favoriteScroll">
                    <div class="favoriteUsersCon">
                        <!-- favorites -->
                    </div>
                    <button class="right-pro" onclick="rightScroll()">
                        <i class="fas fa-angle-double-right"></i>
                    </button>
                    <button class="left-pro" onclick="leftScroll()">
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="profileSection">
            <h2 class="profileTitle"><?php echo $lang['mycareer']; ?></h2>
                <div id="profileProgress">
                    <div id="uni_container">
                        <div class="career-step">
                            <h4><?php echo $lang['major']; ?></h4>
                            <p class="career-p" id="major"></p>
                        </div>

                        <div class="career-step">
                            <h4><?php echo $lang['impact']; ?></h4>
                            <p class="career-p" id="impact"></p>
                        </div>

                        <div class="career-step">
                            <h4><?php echo $lang['major_scale']; ?></h4>
                            <p class="career-p" id="scale_uni"></p>
                        </div>
                    </div>
                    <div class="profile-btn-container">
                        <button id="popupA-btn" data-target="popupA" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i><?php echo $lang['major']; ?></button>
                        <button id="popupB-btn" data-target="popupB" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i><?php echo $lang['impact']; ?></button>
                        <button id="popupC-btn" data-target="popupC" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i><?php echo $lang['major_scale']; ?></button>
                    </div>

                    <div class="career-block" id="studyplaceBlock">
                        <h2>
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span id="educationContent">

                            </span>
                            <i class='fa-regular fa-pen-to-square lol show-popup' data-target='popup6'></i>
                        </h2>
                        <p class='h-mini-p' id="majorityContent">

                        </p>
                    </div>
                    <div id="line-pro"></div>
                    <div id="work_container">
                        <div class="career-step">
                            <h4><?php echo $lang['resources']; ?></h4>
                            <p class="career-p" id="resources"></p>
                        </div>

                        <div class="career-step">
                            <h4><?php echo $lang['advice']; ?></h4>
                            <p class="career-p" id="advice"></p>
                        </div>

                        <div class="career-step">
                            <h4><?php echo $lang['career_scale']; ?></h4>
                            <p class="career-p" id="scale_work"></p>
                        </div>
                    </div>
                    <div class="profile-btn-container">
                        <button id="popupD-btn" data-target="popupD" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i> <?php echo $lang['career_scale']; ?></button>
                        <button id="popupE-btn" data-target="popupE" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i> <?php echo $lang['resources']; ?></button>
                        <button id="popupF-btn" data-target="popupF" class="profile_btn show-popup"><i class="fa-solid fa-plus"></i> <?php echo $lang['advice']; ?></button>
                    </div>
                    <div class="career-block" id="workplaceBlock">
                        <h2> 
                            <i class="fa-solid fa-briefcase"></i>
                            <span id="workplaceContent"></span>
                            <i class='fa-regular fa-pen-to-square lol show-popup' data-target='popup5'></i>
                        </h2>
                        <p id="workroleContent" class='h-mini-p'></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CAREER POPUP -->

<!-- major -->
<div class="popup" id="popupA" style="display:none;"> 
    <div class="popForm">        
        <form id="myForm" class="update" method="post">
        <h3><?php echo $lang['career_story']; ?></h3>
        <label><?php echo $lang['major']; ?></label>
            <textarea name="major" placeholder="Share your thoughts"></textarea>
            <div class="btn-pan"><button type="button" class="cancel btn left" data-target="popupA"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right update"><?php echo $lang['save']; ?></button>  
            </div>  
        </form>
    </div>
</div>
<!-- impact -->
<div class="popup" id="popupB" style="display:none;"> 
<div class="popForm">
    <form id="myForm" class="update" method="post">
        <h3><?php echo $lang['career_story']; ?></h3>
        <label><?php echo $lang['impact']; ?></label>
        <textarea name="impact" placeholder="Share your thoughts"></textarea>
        <div class="btn-pan"><button type="button" class="cancel btn left" data-target="popupB"><?php echo $lang['cancel']; ?></button>
        <button type="submit" class="btn right update"><?php echo $lang['save']; ?></button>
    </div>
</form>
</div>
</div>
<!-- scale university -->
<div class="popup" id="popupC" style="display:none;"> <div class="popForm">
    <form id="myForm" class="update" method="post">
    <h3><?php echo $lang['career_story']; ?></h3>
        <label style="position:absolute;"><?php echo $lang['major_scale']; ?></label>
        <div class="radio-con" id="radio-con1">
            <div class="row">
                <label class="radio">
                    <input type="radio" name="scale_uni" value="Never">1
                </label>
                </div>
                <div class="row">
                    <label class="radio">
                        <input type="radio" name="scale_uni" value="Rare">2</label>
                    </div>
                    <div class="row">
                        <label class="radio">
                            <input type="radio" name="scale_uni" value="Usually">3
                        </label>
                        </div><div class="row"><label class="radio">
                            <input type="radio" name="scale_uni" value="Often">4
                        </label></div><div class="row">
                        <label class="radio">
                            <input type="radio"name="scale_uni" value="Always">5
                        </label>
                    </div>
                </div>
            <label style="position:absolute; margin-top: 120px; padding-right: 100px; color:#7c7c84; z-index: 999"><?php echo $lang['never']; ?></label>
            <label style="position:absolute; margin-top: 120px; padding-left: 260px; color:#7c7c84; z-index: 999"><?php echo $lang['always']; ?></label>
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popupC"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right update"><?php echo $lang['save']; ?></button>  </div></form></div></div>
<!-- scale work -->
<div class="popup" id="popupD" style="display:none;"> 
    <div class="popForm">        
        <form id="myForm" class="update" method="post">
        <h3><?php echo $lang['career_story']; ?></h3>
            <label style="position:absolute;"><?php echo $lang['career_scale']; ?></label>
                <div class="radio-con" id="radio-con1"><div class="row"><label class="radio">
                    <input type="radio" name="scale_work" value="Very easy">1</label>
                </div>
                <div class="row">
                    <label class="radio"><input type="radio" name="scale_work" value="Easy">2</label>
                </div>
                <div class="row">
                <label class="radio">
                    <input type="radio" name="scale_work" value="Okay">3
                </label>
                </div>
                <div class="row">
                    <label class="radio">
                        <input type="radio" name="scale_work" value="Hard">4
                    </label>
                </div>
                <div class="row">
                    <label class="radio">
                        <input type="radio"name="scale_work" value="Very hard">5
                    </label>
                </div>
            </div>
            <label style="position:absolute; margin-top: 120px; padding-right: 100px; color:#7c7c84; z-index: 999"><?php echo $lang['easy']; ?></label>
            <label style="position:absolute; margin-top: 120px; padding-left: 250px; color:#7c7c84; z-index: 999"><?php echo $lang['hard']; ?></label>
            <div class="btn-pan"><button type="button" class="cancel btn left" data-target="popupD"><?php echo $lang['cancel']; ?></button>
            <button type="submit" class="btn right update"><?php echo $lang['save']; ?></button>  
            </div>  
        </form>
    </div>
</div>
<!-- resources -->
<div class="popup" id="popupE" style="display:none;"> 
<div class="popForm">
    <form id="myForm" class="update" method="post">
    <h3><?php echo $lang['career_story']; ?></h3>
        <label style="position:absolute;"><?php echo $lang['resources']; ?></label>
        <textarea name="resources" placeholder="Share your thoughts" style="position:absolute; margin-top:50px; width:92.5%"></textarea>    
        <div class="btn-pan"><button type="button" class="cancel btn left" data-target="popupE"><?php echo $lang['cancel']; ?></button>
        <button type="submit" class="btn right update"><?php echo $lang['save']; ?></button>  
    </div>  </form></div></div>
<!-- advice -->
<div class="popup" id="popupF" style="display:none;"> 
    <div class="popForm">
        <form id="myForm" class="update" method="post">
        <h3><?php echo $lang['career_story']; ?></h3>
            <label><?php echo $lang['advice']; ?></label>
            <textarea name="advice" placeholder="Share your thoughts"></textarea>
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popupF"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>  
            </div>  
        </form>
    </div>
</div>


<!-- POPUPS -->

<div class="popup Name" id="popup1" style="display:none;"> 
    <div class="popForm Name">
        <form id="myForm" class="update" method="post">
            <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['name']; ?></label>
            <input class="text-name" type="text" name="name">
            <label><?php echo $lang['surname']; ?></label>
            <input class="text-name" type="text" name="surname" >
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup1"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>  
        </form>
    </div>
</div>

<div class="popup Exp" id="popup2" style="display:none;">
    <div class="popForm Exp">
        <form class="update" method="post">
        <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['content-exp']; ?></label>
            <textarea name="experience" placeholder="<?php echo $lang['content-exp-placeholder']; ?>"></textarea>
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup2"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>  
        </form>
    </div>
</div>

<div class="popup Place" id="popup3" style="display:none;">
    <div class="popForm Place">
        <form class="update" method="post">
        <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['content-place']; ?></label>
            <input type="text" name="place">
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup3"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>
    
<div class="popup Place" id="popup4" style="display:none;">
    <div class="popForm Place">
        <form class="update" method="post" enctypr="multipart/form-data">
        <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['help-description']; ?></label> <br>
            <div class="sel_form">
                <select name="help[]" id="help" multiple>
                    <option value="<?php echo $lang['help-anxiety']; ?>"><?php echo $lang['help-anxiety']; ?></option>
                    <option value="<?php echo $lang['help-bulling']; ?>"><?php echo $lang['help-bulling']; ?></option>
                    <option value="<?php echo $lang['help-depression']; ?>"><?php echo $lang['help-depression']; ?></option>
                    <option value="<?php echo $lang['help-suicide']; ?>"><?php echo $lang['help-suicide']; ?></option>
                </select>
            </div>
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup4"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>

<div class="popup Place" id="popup5" style="display:none;">
    <div class="popForm Place">
        <form class="update" method="post">
        <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['work_place']; ?></label>
            <input type="text" name="work" >
            <label><?php echo $lang['work_role']; ?></label>
            <input type="text" name="role" >
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup5"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
    </div>

<div class="popup Name" id="popup6" style="display:none;">
    <div class="popForm Place">
        <form class="update" method="post">
        <h3><?php echo $lang['update_profile']; ?></h3>
            <label><?php echo $lang['study_place']; ?></label>
            <input type="text" name="education" >
            <label><?php echo $lang['study_role']; ?></label>
            <input type="text" name="majority">
            <div class="btn-pan">
                <button type="button" class="cancel btn left" data-target="popup6"><?php echo $lang['cancel']; ?></button>
                <button type="submit" class="btn right"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script>new MultiSelectTag('help')</script>
</body>
<script>
    var currentUserId = <?php echo json_encode($currentUserId); ?>;
    var urlUserId = <?php echo json_encode($urlUserId); ?>;
</script>
<script src="../scripts/ajax-profile.js"></script>
<script src="../scripts/profile.js"></script>
<script>
    var loader = document.getElementById("loader");
    window.addEventListener("load", function(){
        loader.style.display = "none";
    });
</script>

</html>