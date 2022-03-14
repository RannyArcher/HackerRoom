<?php
    session_start();
    require_once "../essentials/functions.php";

    if ( isset($_SESSION['CURRENT_USER_ID']) ) {

        removeUserRow($_SESSION['CURRENT_USER_ID']);
        $db->close();
        session_destroy();

    }

    redirect("/");
    exit;
?>