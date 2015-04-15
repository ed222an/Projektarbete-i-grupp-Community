<?php
include_once('confi.php');

//Tables
$dbTable = "wp_stats";

//Get connection string
$conn = new connection();
$dbh = $conn->getConnection();

//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$statName = isset($_POST['statName']) ? $_POST['statName'] : "";
	$statCount = isset($_POST['statCount']) ? $_POST['statCount'] : "";
	$userID = isset($_POST['userID']) ? $_POST['userID'] : "";
	
//Databasanroper körs
	if(!empty($userID)){			
		$sql = "UPDATE $dbTable SET statCount = ? WHERE userID = ?";
		$params = array($statCount, $userID);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		
//Skickar tillbaka ett meddelande
		if($query){
			$json = array("result" => 1, "message" => "Success");
		}else{
			$json = array("result" => 0, "message" => "Error occurred when updating stats");
		}
	}else{
		$json = array("result" => 0, "message" => "User ID not defined");
	}
}else{
		$json = array("result" => 0, "message" => "User ID not defined");
	}
//Output to browser
	header('Content-type: application/json');
	echo json_encode($json);