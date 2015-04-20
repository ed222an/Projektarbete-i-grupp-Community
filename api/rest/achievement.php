<?php

// Include confi.php
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
	$achievementID = isset($_POST['achievementID']) ? mysql_real_escape_string($_POST['achievementID']) : "";
	$achievement = isset($_POST['achievement']) ? mysql_real_escape_string($_POST['achievement']) : "";
	$achievementIsDone = isset($_POST['achievementIsDone']) ? mysql_real_escape_string($_POST['achievementIsDone']) : "";
	$achievementUserID = isset($_POST['achievementUserID']) ? mysql_real_escape_string($_POST['achievementUserID']) : "";
	
	// Insert data into data base
	$sql = "INSERT INTO `wordpress`.`achievements` (`achievementID`, `achievement`, `achievementIsDone`, `achievementUserID`) VALUES ('NULL', '$achievement', '$achievementIsDone', '$achievementUserID');";
	$qur = mysql_query($sql);
	if($qur){
		$json = array("status" => 1, "msg" => "Done achievement added!");
	}else{
		$json = array("status" => 0, "msg" => "Error adding achievement!");
	}
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

	@mysql_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);