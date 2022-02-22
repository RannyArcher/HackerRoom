<?php
    function getUserRow($database, $fullname) {
        // this function is used to get a row in users table in selected database.
        $user = $database->prepare("SELECT * FROM users WHERE fullname = ?");
        $user->bind_param('s', $fullname);
        $user->execute();
        return $user->get_result();
    }


    function delUserRow($database, $id) {
        // this function is used to get a row in users table in selected database.
        $users = $database->prepare("DELETE FROM users WHERE id = ?");
        $users->bind_param('i', $id);
        $users->execute();
    }



    function redirect($page) {
        // this funciton is used to redirect to another page in the current server.
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/" . $page);
    }



?>