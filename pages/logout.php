<?php
    session_start();
    include_once "../essentials/functions.php";
    include_once "../essentials/db.conf.php";

    if ( isset($_SESSION['USER_ID']) ) {
        $USER_ID = $_SESSION['USER_ID'];
        delUserRow($db, $_SESSION['USER_ID']);
        $db->close();
        session_destroy();
    }

    redirect("index.php");
    exit;
?>