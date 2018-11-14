<?php
session_start();
ini_set('display_errors', '1');

require_once 'config.php';

$username = $_SESSION['username'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$description = $_POST['description'];
$itemType = $_POST['itemType'];

echo $_SESSION['username'];

$getUserQuery = mysqli_query($link, "SELECT id FROM users WHERE username = '".$username."'");
$userID = mysqli_fetch_object($getUserQuery)->id;

$sql = "INSERT INTO events (userID, startTime, endTime, description, itemType) VALUES ('".$userID."', '".$startTime."', '".$endTime."', '".$description."', '".$itemType."')";

if ($link->query($sql) === TRUE) {
    echo "Page saved!";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}
$link->close();

?>