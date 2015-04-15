<?php
	// Include confi.php
	include_once('confi.php');
	
	$uid = isset($_GET['uid']) ? mysql_real_escape_string($_GET['uid']) :  "";
	if(!empty($uid)){
		$qur = mysql_query("select name, email, status from `users` where ID='$uid'");
		$result =array();
		while($r = mysql_fetch_array($qur)){
			extract($r);
			$result[] = array("name" => $name, "email" => $email, 'status' => $status); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "User ID not define");
	}
	@mysql_close($conn);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);