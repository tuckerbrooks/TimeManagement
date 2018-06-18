<?php
session_start();
ini_set('display_errors', '1');

require_once 'config.php';

$username = $_SESSION['username'];
$eventID = $_POST['eventID'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$description = $_POST['description'];
$itemType = $_POST['itemType'];

$event = json_decode($_POST, true);
echo $_SESSION['username'];

$userID = mysqli_query($link, "SELECT id FROM users WHERE username = '".$username."'");

$sql = "INSERT INTO events (userID, eventID, startTime, endTime, description, itemType) VALUES ('".$userID."', '".$eventID."', '".$startTime."', '".$endTime."', '".$description."', '".$itemType."')";

if ($link->query($sql) === TRUE) {
    echo "Page saved!";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}
$link->close();

?>