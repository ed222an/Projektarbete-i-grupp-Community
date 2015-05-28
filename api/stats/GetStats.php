<?php
	// Include confi.php
	include_once('confi.php');
	
	//Get database connection
	$conn = new connection();
	$dbh = $conn->getConnection();
	
	$username = isset($_GET['username']) ? $_GET['username'] :  "";
	$statName = isset($_GET['statName']) ? $_GET['statName'] :  "";
	
	if(!empty($username) && !empty($statName)){
		
		$sql = "SELECT * FROM wp_stats WHERE username= ? AND statName= ?";
		$params = array($username, $statName);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$rows = $query -> fetchColumn();
		
		if($rows)
		{
			$sql = "SELECT * FROM wp_stats WHERE username= ? AND statName= ?";
			$params = array($username, $statName);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();

			$json = array("status" => 1, "statName" => $result['statName'], "statCount" => $result['statCount'], "username" => $result['username']);
		}
		else{
			$json = array("status" => 0, "msg" => "Username and or statname does not exist");
		}
		
	}
	else if(!empty($username))
	{
	    $sql = "SELECT * FROM wp_stats WHERE username= ?";
		$params = array($username);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		$rows = $query -> fetchColumn();
		
			if($rows)
		    {
    			$sql = "SELECT * FROM wp_stats WHERE username= ?";
    			$params = array($username);
    			$query = $dbh -> prepare($sql);
    			$query -> execute($params);
    			$result = $query -> fetchAll();
    			
    			$json_data=array(); 
		
        		foreach($result as $rec)  
        		{     
        		  
        			$json_array['statName']=$rec['statName'];
        			$json_array['statCount']=$rec['statCount'];
        			$json_array['username']=$rec['username'];
        
        			array_push($json_data,$json_array);  
        		}  
        		$json = $json_data;
    
    		
		    }
		    else{
			    $json = array("status" => 0, "msg" => "Username and or statname does not exist");
		    }
	}
	else{
		$json = array("status" => 0, "msg" => "Username is empty");
	}

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);