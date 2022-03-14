<?php
    session_start();
    require_once "functions.php";

    if ( isset($_SESSION['CURRENT_USER_ID']) ) {
        
        $lastMessagesRows = getLastMessagesRows();
        
        if ($lastMessagesRows) {

            end($lastMessagesRows);
            $output = json_encode($lastMessagesRows);

            echo "$output";
            exit;
        }

        echo "[]";
        
    }

    exit;
?>