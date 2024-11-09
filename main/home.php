<?php
    session_start();

    include '../regprocces/config.php';

    if($_SESSION['lang'] == "en") {
        include('languages/en-home.php');
    } else if($_SESSION['lang'] == "kz") {
        include('languages/kz-home.php');
    } else if($_SESSION['lang'] == "ru") {
        include('languages/ru-home.php');
    }

    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id']; 
        require_once('../regprocces/db.php');
        require_once('../regprocces/message_counter.php');

        $get_user_query = "SELECT name, image FROM users WHERE id = $id";
        $result = $conn->query($get_user_query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userName = $row["name"];
            $userImage = $row["image"]; 
        }
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
<div id="loader">
    <img id="loadGif" src="../images/loader.gif">
</div>
<header>
    <div class="logo">
        <img src="../images/logo-favicon.png" alt="logo" class="logo" width="50px" height="60px"> <span id="logoText">QAZUNITY</span>
    </div>
        <div id="line"></div>
        <nav>
            <ul class="nav_links">
                <li><a id="home" href="#" color="#7011ce" class="a"> <?php echo $lang['home']; ?> </a></li>    
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
                            <li><a href="?lang=kz">ҚАЗ</a></li>
                            <li><a href="?lang=ru">РУС</a></li>
                            <li><a href="?lang=en">ENG</a></li>
                        </ul>
                </li>
            </ul>  
            
        </nav>
        <a href="profile.php?user_id=<?php echo $_SESSION['id']; ?>" class="cta">
            <img id="user_pfp" src="../regprocces/images/<?php echo $userImage;?>" width="60px" height="60px">
        </a>
</header>

<div id="main_home">
    <div id="greet">
        <p class='content h1'><?php echo $lang['welcome-1']; ?><?php echo $userName;?><br class='br' ><?php echo $lang['welcome-2']; ?></p>
    </div>

    <div id="update_profile">
        <div class="profile-info">
            <i class="fa-solid fa-user user_i"></i>
            <div>
                <p class="content" id="update_inf"><?php echo $lang['update-p']; ?></p>
                <span id="update_span"><?php echo $lang['update-span']; ?></span>
            </div>
        </div>
    </div>  

<form action="../regprocces/info.php" method="post" enctypr="multipart/form-data" style="background-color:transparent;">
<input type="hidden" name="id" value="<?php echo $id; ?>">
<div id="form_container" style="display: none;">
    <div class="item active" data-stage="1">
            <div class="inf_form">  
                <p class="content inf_p"><?php echo $lang['help']; ?></p>
                <ul class="inf_span">
                    <li><span><?php echo $lang['help-description']; ?></span></li>
                </ul>
            </div>
        <div class="sel_form">
            <p class="content inf_p ii"><?php echo $lang['help-select']; ?></p>
            <select name="help[]" id="help" multiple>
                <option value="<?php echo $lang['help-anxiety']; ?>"><?php echo $lang['help-anxiety']; ?></option>
                <option value="<?php echo $lang['help-bulling']; ?>"><?php echo $lang['help-bulling']; ?></option>
                <option value="<?php echo $lang['help-depression']; ?>"><?php echo $lang['help-depression']; ?></option>
                <option value="<?php echo $lang['help-suicide']; ?>"><?php echo $lang['help-suicide']; ?></option>
            </select>
        </div>
        <div id="actions">
            <button id="nextAct"type="button" class="next"><i id="back" class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>    
        
    <div class="item" data-stage="2">
        <div class="inf_form">  
            <p class="content inf_p"><?php echo $lang['content']; ?></p>
            <ul class="inf_span">
                <li><span><?php echo $lang['content-description']; ?></span></li>
            </ul>
        </div>

        <div class="sel_form">
            <p class="content inf_p ii"><?php echo $lang['content-exp']; ?></p>
            <textarea id="text1" placeholder="<?php echo $lang['content-exp-placeholder'];?>" name="exp"></textarea>

            <p class="content inf_p ii"><?php echo $lang['content-place']; ?></p>
            <input class="text" type="text" placeholder="<?php echo $lang['content-place-placeholder']; ?>" name="place">
            <button id="sub" type="submit"><?php echo $lang['submit']; ?></button>
        </div>

        <div id="actions">
            <button id="prevAct" type="button" class="prev"><i id="next" class="fa-solid fa-arrow-left"></i></button>
        </div>
    </div>
</div>
</form>
</div>
<script src="../scripts/home.js"></script>
<script src="../scripts/main.js"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script>   new MultiSelectTag('help')  </script>
</body>
</html>