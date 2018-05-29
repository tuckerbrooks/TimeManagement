<?php
session_start();

require_once 'config.php';

$username = mysqli_real_escape_string($conn, $_SESSION['username']);
$userID = "SELECT id FROM users WHERE username = '$username'";
$eventID = mysqli_real_escape_string($conn, $_POST['eventID']);
$startTime = mysqli_real_escape_string($conn, $_POST['startTime']);
$endTime = mysqli_real_escape_string($conn, $_POST['endTime']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$itemType = mysqli_real_escape_string($conn, $_POST['itemType']);

$sql = "INSERT INTO events (userID, eventID, startTime, endTime, description, itemType) VALUES ('$userID', '$eventID', '$startTime', '$endTime', '$description', 'itemType')"

if ($conn->query($sql) === TRUE) {
    echo "Page saved!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>