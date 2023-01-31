<?php

require_once __DIR__ . '/../includes/Subscribe.class.php';
require_once __DIR__ . '/../includes/EmailSender.class.php';

// init status variables
$error = "";
$success = 0;

//run if form is submitted
if (isset($_POST['subscribe'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";

    // run subscription script to get verification email
    $subscriber = new Subscribe\Subscriber($name, $email);
    $error = $subscriber->error;
    $success = $error == "";
}

?>

<?php
echo "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to GitHub Timeline</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <main>
        <?php
        // show error or success
        if ($error) {
            echo '<div class="error">' . $error . '</div>';
        } else if ($success) {
            echo '<div class="success">Email verification link is send to your device.</div>';
        }
        ?>
        <div class="logo"></div>
        <div class="info">
            <h1 class="title">Subscribe to GitHub Timeline</h1>
            <p class="description">Subscribe us to get GitHub timeline update after every 5 minutes.</p>
            <form action="#" method="post">
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" id="name" placeholder="Name" />
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Email" />
                </div>
                <button type="submit" name="subscribe">Subscribe</button>
            </form>
        </div>
    </main>
</body>

</html>
