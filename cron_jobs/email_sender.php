<?php

require_once '/app/includes/EmailSender.class.php';

$email_sender = new EmailSender();
$result = $email_sender->run_email_sender();

echo "\n---x---x---x---x---x---x---x---x---x---\n";

$date = date("d-m-Y H:i:s");
echo $date." - ";

if($result) {
    echo "Error: $result";
}
else {
    echo "Success.";
}

?>
