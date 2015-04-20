<?php
	// Include confi.php
	include_once('confi.php');
	
	//Get database connection
	$conn = new connection();
	$dbh = $conn->getConnection();
	
	$username = isset($_GET['username']) ? $_GET['username'] :  "";
	$achievement = isset($_GET['achievement']) ? $_GET['achievement'] :  "";
	
	if(!empty($username) && !empty($achievement)){
		
		$sql = "SELECT * FROM achievements WHERE username= ? AND achievements= ?";
		$params = array($username, $achievement);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$rows = $query -> fetchColumn();
		
		if($rows)
		{
			$sql = "SELECT * FROM achievements WHERE username= ? AND achievement= ?";
			$params = array($username, $achievement);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();

			$json = array("status" => 1, "achievement" => $result['achievement'], "achivementIsDone" => $result['achievementIsDone'], "username" => $result['username']);
		}
		else{
			$json = array("status" => 0, "msg" => "Username and or achievement does not exist");
		}
		
	}else{
		$json = array("status" => 0, "msg" => "Username and or achievement is empty");
	}

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);