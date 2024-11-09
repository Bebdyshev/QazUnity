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
    <link rel="stylesheet" href="../styles/create.css">
    <link rel="stylesheet" href="../styles/vanillaSelectBox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    <script src="../scripts/profile.js"></script>
    <script src="https://cdn.tiny.cloud/1/x0zkjzmqlc5gkikrhasqlkz1kjutetpaxsxh4id5pkkf7hew/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <style>
        .tox-statusbar__branding a svg path, .tox-statusbar__branding a svg {
            display: none;
        }
        
        .tox-tinymce .tox-editor-container .tox-editor-header .tox-menubar {
            display: none;
        }

        .tox-tinymce .tox-editor-container .tox-statusbar .tox-statusbar__text-container--flex-start .tox-statusbar__path .tox-statusbar__path-item {
            display: none;
        }
    </style>
</head>
<body>
<div id="loader">
    <img id="loadGif" src="../images/loader.gif">
</div>
<header class="header" id="myHeader">
<div class="logo">
        <img src="../images/logo-favicon.png" alt="logo" class="logo" width="50px" height="60px"> <span id="logoText">QAZUNITY</span>
    </div>    <div id="line"></div>
        <nav>
            <ul class="nav_links">
                <li><a id="home" href="home.php" color="#7011ce" class="a"> <?php echo $lang['home']; ?> </a></li>    
                <li><a id="connect" href="#" class="a"><?php echo $lang['connect']; ?> <i class="fa-solid fa-caret-down nav_i"></i></a>
                    <ul class="dropdown">
                        <li><a href="community.php"><?php echo $lang['community']; ?></a></li>
                        <li><a href="#"><?php echo $lang['groups']; ?></a></li>
                        <li><a href="programms.php"><?php echo $lang['programs']; ?></a></li>
                    </ul>
                </li>    
                <!-- <li><a id="career" href="#" class="a">--- <i class="fa-solid fa-caret-down nav_i"></i></a>
                    <ul class="dropdown">
                        <li><a href="#">---</a></li>
                        <li><a href="#">---</a></li>
                        <li><a href="#">---</a></li>
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

        <?php

            if (isset($_SESSION['id'])) {
                $current_user_id = $_SESSION['id'];
                require_once('../regprocces/db.php');

                $get_user_image_query = "SELECT image FROM users WHERE id = $current_user_id";
                $result_image = $conn->query($get_user_image_query);

                if ($result_image && $result_image->num_rows > 0) {
                    $row_image = $result_image->fetch_assoc();
                    $userImage = $row_image['image'];
                }
            }
        ?>
    <a href="profile.php?user_id=<?php echo $_SESSION['id']; ?>" class="cta">
        <img id="user_pfp" src="../regprocces/images/<?php echo $userImage;?>" width="60px" height="60px">
    </a>
</header>

<div id="main_home">
    <div id="header">
        <h2>Create a post</h2>
        <div id="hr"></div>
    </div>
    <div id="page">
        <form method="post" action="../regprocces/create.php" id="form" enctype="multipart/form-data">
            <div id="utiCon">
                <div class="selectCon">
                    <select class="selectCategory" name="category">
                        <option value="0"> Choose a category</option>
                        <option value="1"> Article</option>
                        <option value="2"> Resource</option>
                    </select>
                </div>

                <button type="submit" class="submit">Submit</button>
            </div>
            <div id="type1">
                <textarea class="subject" name="subject" placeholder="Subject..."></textarea>
                <textarea id="mytextarea" name="text" placeholder="Text..." ></textarea>
            </div>
            <input type="hidden" name="author_id" value="<?php echo $currentUserId; ?>">
        </form>
    </div>
</div>
</body>
<script src="../scripts/main.js"></script>
</html>