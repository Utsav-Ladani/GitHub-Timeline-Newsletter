<?php

require_once '../Includes/Verification.class.php';

$error = "";
$success = 0;

$email = isset($_GET["email"]) ? $_GET["email"] : "";
$token = isset($_GET["token"]) ? $_GET["token"] : "";

$verification = new Verification($email, $token);
$error = $verification->error;
$success = $error=="";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify your email</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php
        if($error) { 
            echo '<div class="error">'.$error.'</div>';
        } 
        else if($success) { 
            echo '<div class="success">Your email verified successfully.</div>';
        } 
    ?>
</body>
</html>