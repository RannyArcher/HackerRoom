<?php
    session_start();
    include_once "../essentials/functions.php";
    include_once "../essentials/db.conf.php";


    if ( isset($_SESSION['USER_ID']) ) {
        $output = "";
        
        $q = $db->prepare("SELECT * FROM messages WHERE messageid > ? ORDER BY messageid");
        $q->bind_param('i', $_SESSION['LAST_MESSAGE_ID']);
        $q->execute();
        $result = $q->get_result();
        while ($row=$result->fetch_assoc()){
            $_SESSION['LAST_MESSAGE_ID'] = $row['messageid'];
            if ($row['senderid'] !== $_SESSION['USER_ID']) {
                // in case the current user was not the message owner, the owner's name will be present
                // and the message will be at the left of the screen

                // getting fullname of senderid
                $USER_FULLNAME = $db->query("SELECT fullname FROM users WHERE id = {$row['senderid']}")->fetch_row()[0];
                $output .= '<div class="message-row">
                                <div class="sender-info">&lt;' . $USER_FULLNAME .'&gt;: </div>
                                <div class="message">'. $row['message'] .'</div>
                            </div>';
            }
            else {
                // in case the current users was the message owner the name will not be printed
                // and the message will be at the right of the screen
                $output .= '<div class="message-row mine">
                                <div class="message">' . $row['message'] . '</div>
                            </div>';
            }
            
        }
        echo "$output";
    }
    exit;
?>