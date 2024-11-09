<?php
    session_start();
    require_once('../regprocces/message_counter.php');
    
    include '../regprocces/config.php';

    if($_SESSION['lang'] == "en") {
        include('languages/en-community.php');
    } else if($_SESSION['lang'] == "kz") {
        include('languages/kz-community.php');
    } else if($_SESSION['lang'] == "ru") {
        include('languages/ru-community.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/community.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
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

<div id="search">
<input type="text" id="search-bar" placeholder="Search users...">

<select id="filter-by">
    <option value=""><?php echo $lang['filter']; ?></option>
    <option value="<?php echo $lang['1']; ?>"><?php echo $lang['1']; ?></option>
    <option value="<?php echo $lang['2']; ?>"><?php echo $lang['2']; ?></option>
    <option value="<?php echo $lang['3']; ?>"><?php echo $lang['3']; ?></option>
    <option value="<?php echo $lang['4']; ?>"><?php echo $lang['4']; ?></option>
</select>
</div>

<section id="page">

    

<?php
if (isset($_SESSION['id'])) {
    $current_user_id = $_SESSION['id'];
    require_once('../regprocces/db.php');

    $get_logged_user_interests_query = "SELECT multi FROM users WHERE id = ?";
    $stmt = $conn->prepare($get_logged_user_interests_query);
    $stmt->bind_param('i', $current_user_id);
    $stmt->execute();
    $stmt->bind_result($logged_user_interests);
    $stmt->fetch();
    $stmt->close();

    $logged_user_interests = explode(',', $logged_user_interests);

    $get_users_query = "SELECT u.id as user_id, u.name, u.surname, u.status, i.experience, i.place, u.image, u.multi, i.help
                        FROM users u 
                        JOIN users_inf i ON u.id = i.user_id";

    $result = $conn->query($get_users_query);

    if ($result && $result->num_rows > 0) {
        $users = [];

        while ($row = $result->fetch_assoc()) {
            if ($row['user_id'] != $current_user_id) {
                $current_user_interests = explode(',', $row['multi']);
                $matching_interests_count = 0;

                foreach ($logged_user_interests as $interest) {
                    if (in_array(trim($interest), $current_user_interests)) {
                        $matching_interests_count++;
                    }
                }

                $row['common_interests'] = $matching_interests_count;
                $users[] = $row;
            } else {
                $userImage = $row['image'];
            }
        }

        usort($users, function ($a, $b) {
            return $b['common_interests'] - $a['common_interests'];
        });

    foreach ($users as $user) {
        echo "<div class='user'>";
        echo "<img class='user_img' src='../regprocces/images/" . $user['image'] . "' alt='User Image'>";
        ?>
        <form class='update' method='post' id='myForm'>
            <input type='hidden' name='user_id' value='<?php echo $user['user_id']; ?>' data-active='<?php echo $user['is_favorite'] ? 'solid' : 'regular'; ?>'>
            <button class='favorite-btn <?php echo $user['is_favorite'] ? 'favorited' : ''; ?>' type='submit' name='add'>
                <i class='fa-regular fa-bookmark' id='favorite-icon-regular-<?php echo $user['user_id']; ?>'></i>
            </button>
        </form>
    <?php
    echo "<a id='username' href='profile.php?user_id=" . $user['user_id'] . "'><h3 class='db_ac'>" . $user['name'] . " " . $user['surname'] . "</h3></a>";
    
    $current_user_interests = explode(',', $user['multi']);
    $matching_interests_count = 0;

    foreach ($logged_user_interests as $interest) {
        if (in_array(trim($interest), $current_user_interests)) {
            $matching_interests_count++;
        }
    }

    if ($matching_interests_count != 0) {
    echo "<p class='user_int'> <i class='fa-solid fa-fire'></i>  " . $matching_interests_count . " in common</p>";
    }
    $experience_lines = explode("\n", $user['experience']);
    $max_lines = 2;
    if (count($experience_lines) > $max_lines) {
        $user['experience'] = implode("\n", array_slice($experience_lines, 0, $max_lines)) . '...';
    }

    echo "<p class='db_p'>" . nl2br($user['experience']) . "</p>";
    echo "<h4 class='db_h4'>" . $lang['help'] ."</h4>";
    $help_items = explode(',', $user['help']);

    $max_items = 2;
    if (count($help_items) > $max_items) {
        for ($i = 0; $i < $max_items; $i++) {
            $help_item = trim($help_items[$i]);
            echo "<div class='db_help'> <p class='db_pol'>" . $help_item . "</p></div>";
        }
        $remaining_items = count($help_items) - $max_items;
        echo "<div class='db_help'> <p class='db_pol'>+" . $remaining_items . "</p></div>";
    } else {
        foreach ($help_items as $help_item) {
            $help_item = trim($help_item);
            echo "<div class='db_help'> <p class='db_pol'>" . $help_item . "</p></div>";
        }
    }

    echo "<a href='message.php?recipient_id=" . $user['user_id'] . "' class='db_but'><p class='db_poll' align='center'>" . $lang['message'] ."</p></a>";
    echo "</div>";
}

    } else {
        echo "<p>No users found.</p>";
    }
}
?>

    </section>
</div>

<script>
const filterBy = document.getElementById('filter-by');
const searchBar = document.getElementById('search-bar');
const userDivs = document.querySelectorAll('.user');

function filterUsers() {
  const filterValue = filterBy.value.toLowerCase();
  const searchValue = searchBar.value.toLowerCase(); 

  userDivs.forEach(userDiv => {
    const userName = userDiv.querySelector('.db_ac').textContent.toLowerCase(); 
    const userSurname = userDiv.querySelector('.db_ac').textContent.toLowerCase();

    const helpItems = userDiv.querySelectorAll('.db_help p'); 

    let containsFilter = false;

    helpItems.forEach(helpItem => {
      const itemText = helpItem.textContent.toLowerCase();
      if (itemText.includes(filterValue)) {
        containsFilter = true;
      }
    });

    if ((containsFilter || filterValue === '') && (userName.includes(searchValue) || userSurname.includes(searchValue) || searchValue === '')) {
      userDiv.style.display = 'block';
    } else {
      userDiv.style.display = 'none';
    }
  });
}

filterBy.addEventListener('change', filterUsers);
searchBar.addEventListener('input', filterUsers);

</script>
<script src="../scripts/header.js"></script>
<script src="../scripts/community.js"></script>
<script src="../scripts/ajax-community.js"></script>
<script src="../scripts/main.js"></script>

</body>
</html>