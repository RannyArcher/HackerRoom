<?php
    session_start();
    require_once "functions.php";


    if ( isset(
        $_SESSION['CURRENT_USER_ID'],
        $_POST['message']
        ) 
    ) {
        $message = htmlspecialchars($_POST['message']);

        // inserting the message into database
        sendMessage($_SESSION['CURRENT_USER_ID'], $message);

    }
    else {
        redirect("/");
    }
?>