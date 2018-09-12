<?php
require_once 'config.php';

$myObj->itemID = 1;
$myObj->startTime = time()*1000;
$myObj->endTime = time()*1000 + 120000;
$myObj->desc = "PHP Test";
$myObj->itemType = "r";

$myJSON = json_encode($myObj);

echo $myJSON;
?>