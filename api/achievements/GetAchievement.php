<?php
	include_once('confi.php');
	
	//Get database connection
	$conn = new connection();
	$dbh = $conn->getConnection();
	
	//Get parameters
	$username = isset($_GET['username']) ? $_GET['username'] :  "";
	$achievementName = isset($_GET['achievementName']) ? $_GET['achievementName'] :  "";
	$achievementName = strtolower($achievementName);
	$status = isset($_GET['status']) ? $_GET['status'] :  "";

	//Gets single achievement by username
	if(!empty($username) && !empty($achievementName) && empty($status)){
		
		$sql = "SELECT * FROM wp_achievements WHERE username= ? AND achievement= ?";
		$params = array($username, $achievementName);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$rows = $query -> fetchColumn();
		
		if($rows)
		{
			$sql = "SELECT * FROM wp_achievements WHERE username = ? AND achievement = ?";
			$params = array($username, $achievementName);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
			
			$sql = "SELECT description FROM wp_achievementlist WHERE name = ?";
			$params = array($achievementName);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$resultDesc = $query -> fetch();
			
			$json = array("status" => 1, "name" => $result['achievement'], "is done" => $result['achievementIsDone'], "username" => $result['username'], "description" => $resultDesc['description']);
		}else{
			$json = array("status" => 0, "msg" => "Username and or achievement does not exist");
		}	
	}
	
	//Get all achivements
	elseif(!empty($username) && empty($achievementName) && empty($status)){
		
		$sql = "SELECT *
				FROM wp_achievements
				WHERE username = ?";
		$params = array($username);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$result = $query -> fetchAll();
		$json_data=array();
		
		foreach($result as $rec){     
			$json_array['username']=$rec['username'];  
			$json_array['achievementIsDone']=$rec['achievementIsDone'];
			$json_array['achievement']=$rec['achievement'];

			$sql = "SELECT description FROM wp_achievementlist WHERE name = ?";
			$params = array($rec['achievement']);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$resultDesc = $query -> fetch();
			
			$json_array['description']=$resultDesc['description'];

			
			
			
			array_push($json_data,$json_array);  
		}  
		$json = $json_data;		
	}
	//Gets all achievements that is either done or in progress	
	elseif(!empty($username) && empty($achievementName) && !empty($status)){

		if($status == "true"){
			$status = "1";
		}
		elseif($status == "false"){
			$status = "0";
		}
		$sql = "SELECT *
				FROM wp_achievements
				WHERE username = ? AND achievementIsDone = ?";
		$params = array($username, $status);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$result = $query -> fetchAll();

		$json_data=array(); 
		
		foreach($result as $rec)  
		{     
			$json_array['username']=$rec['username'];  
			$json_array['achievementIsDone']=$rec['achievementIsDone'];
			$json_array['achievement']=$rec['achievement'];


			$sql = "SELECT description FROM wp_achievementlist WHERE name = ?";
			$params = array($rec['achievement']);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$resultDesc = $query -> fetch();
			
			$json_array['description']=$resultDesc['description'];

			array_push($json_data,$json_array);  
		}  
		$json = $json_data;
	}
	elseif(!empty($username) && !empty($achievementName) && !empty($status))
	{
		$json = array("status" => 0, "msg" => "Error input try choose get all alternative");
	}
	
	else{
		$json = array("status" => 0, "msg" => "Username and or achievement is empty");
	}

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);