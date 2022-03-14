<?php
    session_start();
    require_once "essentials/functions.php";

    $error_message = "";

    if ( isset($_SESSION["USER_ID"]) ) {
        // redirect the user to chat page in case the user_id variable exists
        redirect("/pages/chat.php");
        exit;
    }
    elseif ( isset($_POST["login"]) ){

        if ( isset($_POST["fullname"]) ){
            // the coming 2nd line of this statement will switch the name of the user to leet chars
            // in case he/she checked the checkbox
            $fullname = htmlspecialchars( $_POST["fullname"] );
            $nickname = htmlspecialchars( isset($_POST["leet"]) ? strtr($_POST["fullname"], 'letsoa', '137504') : $_POST["fullname"] );
            
            

            if ( ($id = addUser($fullname)) !== false ) {
                // creating account if the user is not already exist in the database
                $_SESSION["CURRENT_USER_ID"] = $id;

                redirect("/pages/chat.php");
            }
            else {
                $error_message = "Error: The fullname and nickname already exist, choose another one.";
            }

            
        }
        else {
            $error_message = "Error: Please fill the entries with valid information.";
        }
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
        <title>Hacker Room - Chat With Special People!</title>
    </head>
    <body class="login">
        <form method="POST" action="/index.php">
            <table>
                <tr>
                    <td colspan="3" class="login-title">
                        <h2>Hi... Time to say godbye!</h2>
                    </td>
                </tr>
                <tr>
                    <td class="label-container"><label>Fullname: </label></td>
                    <td colspan="2"><input type="text" name="fullname" placeholder="Enter your full name..." required></td>
                </tr>
                <tr>
                    <td class="label-container"><label>Leet</label></td>
                    <td><input type="checkbox" name="leet" value="true"></td>
                    <td><button name="login" value="OK">Login</button></td>
                </tr>
            </table>
            <p class="error-paragraph">
                <?php
                    echo $error_message;
                ?>
            </p>
        </form>
    </body>
</html>