<?php
    session_start();
    require_once "../essentials/functions.php";

    
    if ( isset($_SESSION['CURRENT_USER_ID']) ) {



        // getting last message row in the db
        if ( ($last_message_id = getLastMessageId()) !== null ) {

            $_SESSION['LAST_MESSAGE_ID'] = $last_message_id;
            
        }
        else {

            $_SESSION['LAST_MESSAGE_ID'] = 0;

        }



    }
    else {

        redirect("/");
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
        <link rel="stylesheet" href="/styles/main.css">
        <script defer src="/scripts/main.js"></script>
        <script>
            let USER_ID = <?php echo $_SESSION['CURRENT_USER_ID']; ?>;
        </script>
        <title>N0N3!</title>
    </head>
    <body class="chat">
        <div class="container">
            <div class="nav-row">
                <div class="welcome">Brothers & Sisters... welcome here!</div>
                <a href="/pages/logout.php" class="btn logout">Logout</a>
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
                <div class="online-users-col hidden-scrollbar" id="online-users-section" data-onlineUsers="">
                </div>
            </div>
            <form  class="form-row" method="POST" action="/essentials/sendMessage.php">
                <input name="message" autocomplete="off" placeholder="Message them..." class="message-input">
                <button class="btn" style="border-left: 1px solid var(--light-green);">Send</button>
            </form>
        </div>
    </body>
</html>