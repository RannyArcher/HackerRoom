<?php
    session_start();
    include_once "../essentials/functions.php";
    include_once "../essentials/db.conf.php";
    if ( isset($_SESSION['USER_ID']) ) {


        // getting last message in the db
        $result = $db->query("SELECT * FROM messages WHERE messageid = (SELECT MAX(messageid) FROM messages)");
        $LAST_MESSAGE_ID = $result->fetch_assoc()['messageid'];
        if ( $LAST_MESSAGE_ID !== null ) {
            $_SESSION['LAST_MESSAGE_ID'] = $LAST_MESSAGE_ID;
        }
        else {
            // in case the db returns no row the number 0 will be set as last message id
            $_SESSION['LAST_MESSAGE_ID'] = 0;
        }

    }
    else {
        redirect("HackerRoom/index.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <link rel="stylesheet" href="../styles/main.css">
        <script defer src="../scripts/chat.js"></script>
        <title>N0N3!</title>
    </head>
    <body class="chat">
        <div class="container">
            <div class="nav-row">
                <div class="welcome">Brothers & Sisters... welcome here!</div>
                <a href="logout.php" class="btn logout">Logout</a>
                <h2 class="online-users-header">ONLINE USERS:</h2>
            </div>
            <div class="interface-row">
                <div class="messages-container-col hidden-scrollbar" id="messages-section">
                    <!-- <div class="message-row">
                        <div class="sender-info">&lt;NAME&gt;: </div>
                        <div class="message">message goes here.</div>
                    </div>
                    <div class="message-row mine">
                        <div class="message">this is my message</div>
                    </div> -->
                </div>
                <div class="online-users-col hidden-scrollbar" id="online-users-section">
                </div>
            </div>
            <form  class="form-row" method="POST" action="../essentials/sendMessage.php">
                <input name="message" autocomplete="off" placeholder="Message them..." class="message-input">
                <button class="btn" style="border-left: 1px solid var(--light-green);">Send</button>
            </form>
        </div>
    </body>
</html>