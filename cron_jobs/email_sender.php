<?php

/**
 * Script which create an object to send an email to every subscriber
 * Email contains the latest github timeline update
 */

require_once '/app/includes/EmailSender.class.php';

// send email to every user
$email_sender = new EmailSender\EmailSender();
$result = $email_sender->run_email_sender();

// new log start indicator
echo "\n---x---x---x---x---x---x---x---x---x---\n";

// get date for log
$date = date("d-m-Y H:i:s");
echo $date." - ";

// show message to ensure that emails are sent
if($result) {
    echo "Error: $result";
}
else {
    echo "Success.";
}

?>
