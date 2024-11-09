<?php
    if(!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = "ru";
    } else if(isset($_SESSION['lang']) && isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])) {
        if( $_GET['lang'] == "ru") {
            $_SESSION['lang'] = "ru";
        } else if($_GET['lang'] == "kz") {
            $_SESSION['lang'] = "kz";
        } else {
            $_SESSION['lang'] = "en";
        }
    }
?>
