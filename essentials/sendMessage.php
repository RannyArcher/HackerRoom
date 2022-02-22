<?php
    session_start();
    include_once "../essentials/functions.php";
    include_once "../essentials/db.conf.php";

    if ( isset($_SESSION['USER_ID']) and (isset($_POST['message']) and $_POST['message'] !== "") ) {
        $message = htmlspecialchars($_POST['message']);

        // entering the message into database
        $q = $db->prepare('INSERT INTO messages (senderid, message) VALUES (?, ?)');
        $q->bind_param('is', $_SESSION['USER_ID'], $message);
        $q->execute();

    }
    else {
        redirect("index.php");
    }
?>