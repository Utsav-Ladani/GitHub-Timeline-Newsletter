<?php

require_once __DIR__.'/../includes/Subscribe.class.php';
require_once __DIR__.'/../includes/EmailSender.class.php';

$error = "";
$success = 0;

if(isset($_POST['subscribe'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";

    $subscriber = new Subscriber($name, $email);
    $error = $subscriber->error;
    $success = $error=="";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to GitHub Timeline</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <?php 
        if($error) { 
            echo '<div class="error">'.$error.'</div>';
        } 
        else if($success) { 
            echo '<div class="success">Email verification link is send to your device.</div>';
        } 
    ?>
    <form action="#" method="post">
        <h1 class="title">Subscribe to GitHub Timeline</h1>
        <input type="text" name="name" id="name" placeholder="Name"/>
        <input type="email" name="email" id="email" placeholder="Email" />
        <button type="submit" name="subscribe">Subscribe</button>
    </form>
</body>
</html>