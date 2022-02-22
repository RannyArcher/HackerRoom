<?php
    session_start();
    include_once "functions.php";
    include_once "db.conf.php";

    if ( isset($_SESSION['USER_ID']) ) {
        $output = "";
        $users = $db->prepare("SELECT * FROM users WHERE id != ?");
        $users->bind_param('d', $_SESSION['USER_ID']);
        $users->execute();
        $result = $users->get_result();
        if ($result->num_rows > 0) {
            while($row=$result->fetch_assoc()) {
                $output .= "<div class='online-user'>{$row['fullname']}</div>";
            }
        }
        echo "{$output}";
    }
    else {
        redirect("index.php");
    }


?>