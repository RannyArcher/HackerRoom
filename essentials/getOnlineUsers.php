<?php
    session_start();
    require_once "functions.php";

    if ( isset($_SESSION['CURRENT_USER_ID']) ) {

        $htmlOutput = "";
        $onlineUsersRows = getOnlineUsersRows();

        if ($onlineUsersRows) {
            
            echo json_encode($onlineUsersRows);
            exit;
        }
        echo "[]";
        exit;

    }
    else {

        redirect("/");

    }


?>