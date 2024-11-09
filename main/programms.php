<?php
    session_start();

    include '../regprocces/config.php';

    if($_SESSION['lang'] == "en") {
        include('languages/en-programs.php');
    } else if($_SESSION['lang'] == "kz") {
        include('languages/kz-programs.php');
    } else if($_SESSION['lang'] == "ru") {
        include('languages/ru-programs.php');
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
    <link rel="stylesheet" href="../styles/programms.css">
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
    <div id="nav-bar">
        <div id="search">
            <div id="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i> <input type="text" id="search-bar-input" placeholder="<?php echo $lang['filter']; ?>">
            </div>    
        </div>
        <div id="create">
            <a id="create-btn" href="create.php"><i class="fa-regular fa-plus"></i> <span><?php echo $lang['create']; ?></span></a>
        </div>
    </div>
    <div id="page">
    <?php
    require_once('../regprocces/db.php');

    $get_articles_query = "SELECT a.*, u.name, u.surname, u.image FROM users_reddit a JOIN users u ON a.author_id = u.id";
    $articles_result = $conn->query($get_articles_query);

    if ($articles_result->num_rows > 0) {
        while ($article_row = $articles_result->fetch_assoc()) {

            $dateTime = new DateTime($article_row['date']);
            $formattedDate = $dateTime->format('j M Y');

            ?>
            <div class="article">
                <div class="article-info">
                    <p class="articleSubject"><?php echo $article_row['subject']; ?> <i>by <?php echo $article_row['name'] . ' ' . $article_row['surname']; ?></i></p>
                </div>
                <div class="article-text">
                    <p class="articleText"><?php echo $article_row['text']; ?></p>
                    <p class="atricleDate"><?php echo $formattedDate; ?></p>

                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No articles found.</p>";
    }
    ?>
</div>

</div>
</body>
<script src="../scripts/programms.js"></script>
<script src="../scripts/main.js"></script>
</html>