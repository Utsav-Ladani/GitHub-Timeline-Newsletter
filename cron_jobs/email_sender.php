<?php

require_once '/app/includes/EmailSender.class.php';

// send email to every user
$email_sender = new EmailSender();
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
