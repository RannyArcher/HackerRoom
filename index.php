<?php
    session_start();
    include_once "essentials/db.conf.php";
    include_once "essentials/functions.php";
    $error_message = "";
    if ( isset($_SESSION["USER_ID"]) ) {
        // redirect the user to chat page in case the user_id variable exists
        redirect("HackerRoom/pages/chat.php");
        exit;
    }
    elseif ( isset($_POST["login"]) ){
        if ( isset($_POST["fullname"]) and isset($_POST["nickname"]) ){
            $fullname = $_POST["fullname"];
            $nickname = isset($_POST["leet"]) ? strtr($_POST["nickname"], 'letsoa', '137504') : $_POST["nickname"];
            
            $fullname = htmlspecialchars($fullname);
            $nickname = htmlspecialchars($nickname);
            
            // the credentials are imported in the first line
            $db = new mysqli($db_host, $db_user, $db_pass, "HackerRoom");
            
            if (!(getUserRow($db, $fullname, $nickname)->num_rows)) {
                // creating account if the user is not already exist in the database
                $q = $db->prepare("INSERT INTO users (fullname, nickname) VALUES (?, ?)");
                $q->bind_param('ss', $fullname, $nickname);
                $q->execute();
                $error_message = "user doesn't exist, we create it for you ;D";

                $user_row = getUserRow($db, $fullname, $nickname)->fetch_assoc();
                $_SESSION["USER_ID"] = $user_row['id'];
                redirect("HackerRoom/pages/chat.php");
                exit;

            }
            else {
                $error_message = "Error: The fullname and nickname already exist, choose another one.";
            }

            $db->close();   
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
        <link rel="stylesheet" href="styles/main.css">
        <script defer src="scripts/main.js"></script>
        <title>Hacker Room - Chat With Special People!</title>
    </head>
    <body class="login">
        <form method="POST" action="index.php">
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
                    <td class="label-container"><label>Nickname: </label></td>
                    <td colspan="2"><input type="text" name="nickname" placeholder="Enter your nickname..." required></td>
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