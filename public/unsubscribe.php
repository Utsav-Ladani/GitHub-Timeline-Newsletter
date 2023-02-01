<?php

/**
 * Unsubscribe page html code, which handles the unsubscribe request and show the log message 
 */

require_once __DIR__ . '/../includes/Unsubscribe.class.php';

// init status variables
$error = "";
$success = 0;

// check email and token present in url or not
$email = isset($_GET["email"]) ? $_GET["email"] : "";
$token = isset($_GET["token"]) ? $_GET["token"] : "";

// unsubscribe if token and email match
$unsubscriber = new Unsubscribe\Unsubscriber($email, $token);
$error = $unsubscriber->error;

// set the success status to false if error come, otherwise set it to true;
$success = ($error == "");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
    <link rel="stylesheet" href="./css/log.style.css">
</head>

<body>
    <div class="logo"></div>
    <p class="description"> Sorry to say you bye :(</div>
        <?php
        // show error or success status
        if ($error) {
            echo '<div class="error">' . $error . '</div>';
        } else if ($success) {
            echo '<div class="success">You have successfully unsubscribe GitHub Timeline.</div>';
        }
        ?>
</body>

</html>
