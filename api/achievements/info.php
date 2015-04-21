<?php
	// Include confi.php
	include_once('confi.php');
	
	//Get database connection
	$conn = new connection();
	$dbh = $conn->getConnection();
	
	$username = isset($_GET['username']) ? $_GET['username'] :  "";
	$achievementName = isset($_GET['achievementName']) ? $_GET['achievementName'] :  "";
	//$achievementIsDone = isset($_GET['achievementIsDone']) ? $_GET['achievementIsDone'] :  "";
	
	if(!empty($username) && !empty($achievementName)){
		
		$sql = "SELECT * FROM test_achievementisdone WHERE username= ? AND name= ?";
		$params = array($username, $achievementName);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$rows = $query -> fetchColumn();
		
		if($rows)
		{
			$sql = "SELECT ta.name, taid.isDone, taid.username
					FROM test_achievement AS ta
					INNER JOIN test_achievementisdone AS taid 
					ON ta.name = taid.name
					WHERE taid.username = ?";
			$params = array($username);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
			
			$json = array("status" => 1, "name" => $result['name'], "is done" => $result['isDone'], "username" => $result['username']);
		}
		else{
			$json = array("status" => 0, "msg" => "Username and or achievement does not exist");
		}
		
	}
	elseif(!empty($username) && empty($achievementName)){
		
			$sql = "SELECT *
					FROM test_achievementisdone
					WHERE username = ?";
			$params = array($username);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetchAll();

			
		
		$json_data=array();//create the array  
		foreach($result as $rec)//foreach loop  
		{  
			$json_array['achievementIsDoneID']=$rec['achievementIsDoneID'];   
			$json_array['username']=$rec['username'];  
			$json_array['isDone']=$rec['isDone'];
			$json_array['name']=$rec['name']; 			
		//here pushing the values in to an array  
			array_push($json_data,$json_array);  
		  
		}  
		$json = $json_data;
		
			//$json1 = '{"achievementIsDoneID":"1","username":"Admin","isDone":"1","name":"10 kills"}';


			//$test = json_decode($json1, true);
			
			//echo $test['name'];

			
			
			
		}

	
	
	else{
		$json = array("status" => 0, "msg" => "Username and or achievement is empty");
	}

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);