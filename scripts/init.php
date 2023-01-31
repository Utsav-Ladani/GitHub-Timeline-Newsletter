<?php

/**
 * This scripts run at startup.
 * It creates the User table in database if not exist.
 * Also log the success and error message.
 */

require_once __DIR__.'/../includes/DBConnection.class.php';

$DB = new DBConn\DBConnection();
$result = $DB->create_table();

// new log start indicator
echo "\n---x---x---x---x---x---x---x---x---x---\n";

// get date for log
$date = date("d-m-Y H:i:s");
echo $date." - ";


if($result) {
    echo "Table created successfully.";
}
else {
    echo "Failed to create table.";
}
