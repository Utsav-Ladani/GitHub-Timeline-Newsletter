<?php

require_once '../Includes/Subscribe.class.php';
require_once '../Includes/Verification.class.php';
require_once '../Includes/Unsubscribe.class.php';

// $subscriber = new Subscriber("UtsavLadani", "utsav.ladani@rtcamp.com");
// $subscriber = new Subscriber("UtsavLadani1", "utsav.ladani1@rtcamp.com");
// $subscriber = new Subscriber("UtsavLadani2", "utsav.ladani2@rtcamp.com");
$subscriber = new Subscriber("UtsavLadani3", "utsav.ladani3@rtcamp.com");
echo "<emp>".$subscriber->error."</emp>";

// $verifier = new Verification("utsav.ladani3@rtcamp.com", "?");
// echo "<emp>".$verifier->error."</emp>";

// $unsubscriber = new Unsubscriber("utsav.ladani3@rtcamp.com", "?");
// echo "<emp>".$unsubscriber->error."</emp>";

