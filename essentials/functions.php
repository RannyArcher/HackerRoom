<?php
    function getUserRow($database, $fullname, $nickname) {
        // this function is used to get a row in users table in selected database.
        $users = $database->prepare("SELECT * FROM users WHERE fullname = ? AND nickname = ?");
        $users->bind_param('ss', $fullname, $nickname);
        $users->execute();
        return $users->get_result();
    }

    function redirect($page) {
        // this funciton is used to redirect to another page in the current server.
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . $page);
    }

?>