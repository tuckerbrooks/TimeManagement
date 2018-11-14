<?php
session_start();
require_once 'config.php';

$username = $_SESSION['username'];
$getUserQuery = mysqli_query($link, "SELECT id FROM users WHERE username = '".$username."'");
$userID = mysqli_fetch_object($getUserQuery)->id;
$deleteOld = mysqli_query($link, "DELETE FROM events WHERE endTime <= '".(time() * 1000)."'");
$pullEvents = mysqli_query($link, "SELECT * FROM events WHERE userID = ".$userID."");

$objects = array();

while($obj = mysqli_fetch_object($pullEvents)){
	$myObj = new stdClass();
    $myObj->itemID = $obj->id;
	$myObj->startTime = $obj->startTime;
	$myObj->endTime = $obj->endTime;
	$myObj->desc = $obj->description;
	$myObj->itemType = $obj->itemType;
	$objects[] = $myObj;
} 
$myJSON = json_encode($objects);
echo $myJSON;
?>