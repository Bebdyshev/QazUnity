<?php
session_start();

    include '../regprocces/config.php';

    if($_SESSION['lang'] == "en") {
        include('languages/en-message.php');
    } else if($_SESSION['lang'] == "kz") {
        include('languages/kz-message.php');
    } else if($_SESSION['lang'] == "ru") {
        include('languages/ru-message.php');
    }

if (isset($_SESSION['id'])) {
    require_once('../regprocces/db.php');
    $user_send = $_SESSION['id'];

    $get_users_query = "SELECT u.id as user_id, u.name, u.surname, i.experience, i.place, u.image, i.help 
            FROM users u 
            JOIN users_inf i ON u.id = i.user_id";

    $result = $conn->query($get_users_query);

    if (isset($_GET['recipient_id'])) {
        $user_rec_id = $_GET['recipient_id'];

        $get_recipient_query = "SELECT u.name, u.surname, u.image, u.multi, i.experience, i.place, i.help FROM users u JOIN users_inf i ON u.id = i.user_id where u.id = $user_rec_id";
        $recipient_result = $conn->query($get_recipient_query);

        if ($recipient_result && $recipient_result->num_rows > 0) {
            $recipient_info = $recipient_result->fetch_assoc();
            $recipient_image = $recipient_info['image'];
            $recipient_name = $recipient_info['name'];
            $recipient_surname = $recipient_info['surname'];
            $recipient_fullname = $recipient_info['name'] . ' ' . $recipient_info['surname'];
            $recipient_exp = $recipient_info['experience'];
            $place = $recipient_info['place'];
            $help_items = explode(',', $recipient_info['help']);
            $interests = explode(',', $recipient_info['multi']);
        } else {
            $recipient_fullname = "Unknown";
        }
    } else {
        echo "Recipient ID not provided.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/message.css">
    <title>Test</title>
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

        svg {
            border-radius: 3px;
        }

        .tox-tinymce .tox-editor-container .tox-statusbar .tox-statusbar__resize-handle {
            display: none;
        }
    </style>
</head>
<body>
    <div id="loader">
        <img id="loadGif" src="../images/loader.gif">
    </div>
    <div id="info">
        <div id="info_ac">
            <?php
                echo "<img class='user_img' src='../regprocces/images/" . $recipient_image .  "' alt='User Image'>";
                echo "<p align='center'>" . $recipient_fullname . "</p>";
                echo "<p align='center' class='min_inf'>" . $recipient_exp . "</p>";
            ?>
            <div id="line"></div>
            <?php
                echo "<h4>" . $lang['live'] . "</h4>";
                echo "<p class='min_inf2'>" . $place . "</p>";

                echo "<h4>" . $lang['help'] . "</h4>";

                foreach ($help_items as $help_item) {
                    $help_item = trim($help_item);
                    echo "<p class='min_inf2'>" . $help_item . "</p>"; // Каждый элемент помощи внутри тега <li>
                }

                echo "<h4>" . $lang['hobby'] . "</h4>";

                foreach ($interests as $interest) {
                    $interest = trim($interest);
                    echo "<p class='min_inf2'>" . $interest . "</p>"; // Каждый элемент помощи внутри тега <li>
                }
            ?>
        </div>
    </div>

    <div id="main">
        <div id="main_inf">
            <form action="../regprocces/message.php" method="post">
                <input type="hidden" name="user_send_id" value="<?php echo $user_send; ?>">
                <input type="hidden" name="user_rec_id" value="<?php echo $user_rec_id; ?>">
                <div id="buttons">
                    <input id="textareaAI" class="buttonAI" type="text" placeholder="<?php echo $lang['ai']; ?>">
                    <button class="buttonAI" id="send-btn" type="button">
                        <svg class="fi fi-sr-artificial-intelligence" xmlns="http://www.w3.org/2000/svg" style="display: block" width="20" height="20" viewBox="0 0 24 24">
                            <path d="m19.026,12v6c0,.552-.448,1-1,1s-1-.448-1-1v-6c0-.552.448-1,1-1s1,.448,1,1Zm-7.42-5.283l3.071,11.029c.175.63-.298,1.254-.953,1.254-.443,0-.831-.294-.952-.72l-.643-2.28h-5.206l-.643,2.28c-.12.426-.509.72-.952.72h0c-.654,0-1.128-.624-.953-1.254l3.091-11.108c.141-.608.541-1.12,1.098-1.405.568-.292,1.22-.31,1.839-.05.587.246,1.037.817,1.204,1.535Zm-.041,7.283l-1.929-6.835c-.029-.114-.191-.114-.219,0l-1.929,6.835h4.077Zm11.462-4c-.552,0-1,.448-1,1v8c0,1.654-1.346,3-3,3H5.026c-1.654,0-3-1.346-3-3V5c0-1.654,1.346-3,3-3h8c.552,0,1-.448,1-1S13.578,0,13.026,0H5.026C2.269,0,.026,2.243.026,5v14c0,2.757,2.243,5,5,5h14c2.757,0,5-2.243,5-5v-8c0-.552-.448-1-1-1Zm-6.85-4.82l1.868.787.745,1.865c.161.404.552.668.987.668s.825-.265.987-.668l.741-1.854,1.854-.741c.404-.161.668-.552.668-.987s-.265-.825-.668-.987l-1.854-.741-.741-1.854C20.601.265,20.21,0,19.776,0s-.825.265-.987.668l-.737,1.843-1.84.697c-.406.154-.678.54-.686.974-.008.435.25.83.65.999Z"/>
                        </svg>
                        <svg class="loaderIcon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none; margin: auto; background: transparent; shape-rendering: auto;" width="26px" height="26px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <g transform="translate(50 50)">
                            <g>
                            <animateTransform attributeName="transform" type="rotate" values="0;45" keyTimes="0;1" dur="0.2s" repeatCount="indefinite"></animateTransform><path d="M29.491524206117255 -5.5 L37.491524206117255 -5.5 L37.491524206117255 5.5 L29.491524206117255 5.5 A30 30 0 0 1 24.742744050198738 16.964569457146712 L24.742744050198738 16.964569457146712 L30.399598299691117 22.621423706639092 L22.621423706639096 30.399598299691114 L16.964569457146716 24.742744050198734 A30 30 0 0 1 5.5 29.491524206117255 L5.5 29.491524206117255 L5.5 37.491524206117255 L-5.499999999999997 37.491524206117255 L-5.499999999999997 29.491524206117255 A30 30 0 0 1 -16.964569457146705 24.742744050198738 L-16.964569457146705 24.742744050198738 L-22.621423706639085 30.399598299691117 L-30.399598299691117 22.621423706639092 L-24.742744050198738 16.964569457146712 A30 30 0 0 1 -29.491524206117255 5.500000000000009 L-29.491524206117255 5.500000000000009 L-37.491524206117255 5.50000000000001 L-37.491524206117255 -5.500000000000001 L-29.491524206117255 -5.500000000000002 A30 30 0 0 1 -24.742744050198738 -16.964569457146705 L-24.742744050198738 -16.964569457146705 L-30.399598299691117 -22.621423706639085 L-22.621423706639092 -30.399598299691117 L-16.964569457146712 -24.742744050198738 A30 30 0 0 1 -5.500000000000011 -29.491524206117255 L-5.500000000000011 -29.491524206117255 L-5.500000000000012 -37.491524206117255 L5.499999999999998 -37.491524206117255 L5.5 -29.491524206117255 A30 30 0 0 1 16.964569457146702 -24.74274405019874 L16.964569457146702 -24.74274405019874 L22.62142370663908 -30.39959829969112 L30.399598299691117 -22.6214237066391 L24.742744050198738 -16.964569457146716 A30 30 0 0 1 29.491524206117255 -5.500000000000013 M0 -20A20 20 0 1 0 0 20 A20 20 0 1 0 0 -20" fill="#ffffff"></path></g></g>
                        </svg>
                    </button>
                </div>
                <textarea id="text" type="text" name="title" placeholder="<?php echo $lang['subject']; ?>"></textarea>
                <textarea id="mytextarea" name="message" placeholder=<?php echo " ' " . $lang['text'] . " ' "; ?> value=""></textarea>
            <button align="center" id="submit" type="submit"><?php echo $lang['send']; ?></button>
            </form>
            <a href="http://localhost/qaz/main/kaspi.php" class="invest">Invest to Gabitov Abdulaziz</a>
        </div>
    </div>
    <div id="popupAI" style="display: none;">
            <div class="popupText">
                <button id="popupBtn"><i class="fa-solid fa-xmark"></i></button>
                <button id="copyBtn"><i class="fa-regular fa-clone"></i></button>
                <label id="labelAi"><?php echo $lang['ai_text']; ?></label>
                <textarea class="henText"></textarea>
            </div>
        </div>
    <script>
        const recipientName = "<?php echo $recipient_name; ?>";
        const recipientSurname = "<?php echo $recipient_surname; ?>";
    </script>
    <script src="../scripts/message.js"></script>
    <script src="../scripts/main.js"></script>
</body>
</html>
