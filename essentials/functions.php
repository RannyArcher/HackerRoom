<?php
    require_once "db.conf.php";
    



    function redirect(string $page) {
        // this funciton is used to redirect to another page in the current server.
        header("Location: http://" . $_SERVER['HTTP_HOST'] . $page);
    }







    function addUser(string $fullname) {
        // this function is used to add a user to database
        // where $fullname is the full name of user
        // the function returns false if user was already exist in database
        // and returns user's id if it doesn't

        global $db;

        // checking wheter the fullname exists
        $q = "SELECT fullname FROM users";
        $r = $db->query($q);
        $users_list = $r->fetch_row();
        if ( in_array($fullname, $users_list) ) {
            // this will be executed in case fullname was already exist
            
            return false;
        }
        
        // inserting user in case doesn't choose a used name
        $q = "INSERT INTO users (fullname) VALUES (?)";
        $s = $db->prepare($q);
        $s->bind_param('s', $fullname);
        $s->execute();

        $id = $s->insert_id;
        $s->close();

        return $id;
    }







    function getLastMessageId() {
        // this function will return the last message id
        
        global $db;
        
        $q = "SELECT MAX(message_id) AS message_id FROM messages";

        $r =  $db->query($q);
        $last_message_id = $r->fetch_assoc()['message_id'];

        return $last_message_id;

    }




    function getLastMessagesRows() {
        // this function returns the last messages rows in the database
        // will return null if no messages have id greater than the current one
        // else will return messages_rows

        global $db;
        if (! isset($_SESSION['LAST_MESSAGE_ID']) ) {
            $_SESSION['LAST_MESSAGE_ID'] = getLastMessageId();
        }

        // $q = "SELECT * FROM messages WHERE message_id > " . $_SESSION['LAST_MESSAGE_ID'];
        $q = "SELECT users.fullname AS fullname,
                messages.sender_id AS sender_id,
                messages.message AS message,
                messages.message_id AS message_id
                    FROM messages inner join users on users.id = messages.sender_id
                    WHERE message_id > " . $_SESSION['LAST_MESSAGE_ID'];

        $r = $db->query($q);
        $messages_rows = $r->fetch_all(MYSQLI_ASSOC);
        $_SESSION['LAST_MESSAGE_ID'] = getLastMessageId();

        
        return $messages_rows;

    }


    


    function getOnlineUsersRows() {
        // this function will return allr rows of online users

        global $db;

        $q = "SELECT fullname FROM users WHERE id != " . $_SESSION["CURRENT_USER_ID"];
        
        $r = $db->query($q);
        $onlineUsersRows = $r->fetch_all(MYSQLI_ASSOC);

        return $onlineUsersRows;

    }





    function sendMessage(int $sender_id, string $message) {
        // this function will 
        // while $message is the message to be added to database
        // and $senderid is the id of owner of the message

        global $db;

        $q = "INSERT INTO messages (sender_id, message) VALUES (?, ?)";

        $s = $db->prepare($q);
        $s->bind_param('is', $sender_id, $message);
        $s->execute();
        $s->close();

    }





    function removeUserRow(int $id) {
        // this function will delete the row of selected id
        // while $id is the id of the user

        global $db;

        $q = "DELETE FROM users WHERE id = ?";

        $s = $db->prepare($q);
        $s->bind_param('i', $id);
        $s->execute();
        $s->close();

    }






    function getFullnameById(int $id) {
        // this function returns the fullname of the $id
        global $db;


        $q = "SELECT fullname FROM users WHERE id = ?";

        $s = $db->prepare($q);
        $s->bind_param('i', $id);
        $s->execute();

        $r = $s->get_result()->fetch_assoc();
        $fullname = $r["fullname"];

        return $fullname;

    }






?>