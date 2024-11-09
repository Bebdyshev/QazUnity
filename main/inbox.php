<?php
session_start();

include '../regprocces/config.php';
require_once('../regprocces/db.php');

if($_SESSION['lang'] == "en") {
    include('languages/en-inbox.php');
} else if($_SESSION['lang'] == "kz") {
    include('languages/kz-inbox.php');
} else if($_SESSION['lang'] == "ru") {
    include('languages/ru-inbox.php');
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $get_messages_query = "SELECT m.*, u1.name AS sender_name, u1.surname AS sender_surname, u2.name AS receiver_name, u2.surname AS receiver_surname
        FROM users_mes m
        JOIN users u1 ON m.user_send_id = u1.id
        JOIN users u2 ON m.user_rec_id = u2.id
        WHERE m.user_send_id = ? OR m.user_rec_id = ?";
        
    $stmt = $conn->prepare($get_messages_query);
    $stmt->bind_param('ii', $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $myMessages = [];
    $otherMessages = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['user_send_id'] == $user_id) {
                $myMessages[] = $row;
            } else {
                $otherMessages[] = $row;
            }
        }
    }

    $count_other_messages_query = "SELECT COUNT(*) AS count 
        FROM users_mes 
        WHERE (user_send_id != ? AND user_rec_id = ?)";
    $stmt_count = $conn->prepare($count_other_messages_query);
    $stmt_count->bind_param('ii', $user_id, $user_id);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $count_other_messages = $row_count['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/inbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
</head>
<body>
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
                <!-- <li><a id="connect" href="#" class="a">--- <i class="fa-solid fa-caret-down nav_i"></i></a>
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

<?php
        if (!empty($myMessages)) {
            echo "<div id='myMessages'><h2>" . $lang['my_messages'] ."</h2></div>";
            echo "<div id='myMesCon'>";
            foreach ($myMessages as $message) {
            $dateString = $message['created_at'];
            $dateTime = new DateTime($dateString);
            $formattedDate = $dateTime->format('H:i j M Y');

            echo "<div class='db_mesbox'> <button id='nig' onclick='deleteMessage({$message['id']})'><i class='fa-solid fa-x'></i></button>";
            echo "<div class='m'>";
            echo "<p class='db_p' style='display: inline;'>" . $lang['message_to'] ." ". $message['receiver_name'] . " " . $message['receiver_surname'] . "</p>";
            echo "<p class='time' style='display: inline; color: grey; margin-left: 5px;'> at " . $formattedDate ."</p>";
            echo "</div>";
            
                    
            echo "<div class='db_mes'><h3 align='center'>" . $message['title'] . "</h3>";
            echo "<p class='db_p par'>" . $message['message'] . "</p></div>";
            echo "</div>";
            }
            echo "</div>";
        }

        if (!empty($otherMessages)) {
            echo "<div id='otherMessages'><h2>". $lang['others_messages'] . "</h2></div>";
            echo "<div id='otherMesCon'>";
            foreach ($otherMessages as $message) {
                $dateString = $message['created_at'];
                $dateTime = new DateTime($dateString);
                $formattedDate = $dateTime->format('H:i j M Y');
            echo "<div class='db_mesbox'> <button id='nig' onclick='deleteMessage({$message['id']})'><i class='fa-solid fa-x'></i></button>";
            echo "<div class='m'>";
            $send_name = $message['sender_name'] . " " . $message['sender_surname'];
            $rec_name = $message['receiver_name'] . " " . $message['receiver_surname'];
            echo "<p class='db_p' style='display: inline;'>". $lang['message_from'] . $send_name . " to you </p>";
            echo "<p class='time' style='display: inline; color: grey; margin-left: 5px;'> at " . $formattedDate ."</p>";
            echo "</div>";            
            echo "<div class='db_mes'><h3 align='center'>" . $message['title'] . "</h3>";
            echo "<div class='db_p par'>" . $message['message'] . "</div></div>";
            echo "<a href='message.php?recipient_id=" . $message['user_send_id'] . "' class='db_but' data-message-id='" . $message['id'] . "><p class='db_poll'>" . $lang['respond'] . "</p></a>";
            echo "</div>";
        }
            echo "</div>";
    }

    if (empty($myMessages) && empty($otherMessages)) {
        echo $lang['no_mes'];
    }
?>

</div>
<script>
    function deleteMessage(messageId) {
        if (confirm("Вы уверены, что хотите удалить это сообщение?")) {
            fetch('delete_mes.php?id=' + messageId, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Ошибка удаления сообщения');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        }
    }
</script>
</body>
</html>