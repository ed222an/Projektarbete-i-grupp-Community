<?php

// Include confi.php
include_once('confi.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){

	$statName = isset($_POST['statName']) ? mysql_real_escape_string($_POST['statName']) : "";
	$statCount = isset($_POST['statCount']) ? mysql_real_escape_string($_POST['statCount']) : "";
	$userID = isset($_POST['userID']) ? mysql_real_escape_string($_POST['userID']) : "";
	
	//echo $status;
	
	// Add your validations
	if(!empty($userID)){
		//$qur = mysql_query("UPDATE  `wordpress`.`wp_stats` SET  `statCount` = `statCount` + 1 WHERE  `wp_stats`.`userID` ='$userID';");
		$qur = mysql_query("UPDATE  `wordpress`.`wp_stats` SET  `statCount` = $statCount WHERE  `wp_stats`.`userID` ='$userID';");
		if($qur){
			$json = array("status" => 1, "msg" => "Status updated!!.");
		}else{
			$json = array("status" => 0, "msg" => "Error updating status");
		}
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	@mysql_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);