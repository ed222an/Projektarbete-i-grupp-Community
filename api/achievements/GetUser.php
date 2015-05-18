<?php
	include_once('confi.php');
	
	//Get database connection
	$conn = new connection();
	$dbh = $conn->getConnection();
	
	$username = isset($_GET['username']) ? $_GET['username'] : "";
	$password = isset($_GET['password']) ? $_GET['password'] : "";
	
	
	
	
	$key = 'This1KeyIsTheBestKey2EvermadeYo3';
	$iv = 'ThisIv23KeyIsAlsoOneOfTheBestest';

	$decrypted = base64_decode($password);
	$password1 = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decrypted, MCRYPT_MODE_CBC, $iv);

	$pass = preg_replace(
		array(
			'/\x00/', '/\x01/', '/\x02/', '/\x03/', '/\x04/',
			'/\x05/', '/\x06/', '/\x07/', '/\x08/', '/\x09/', '/\x0A/',
			'/\x0B/','/\x0C/','/\x0D/', '/\x0E/', '/\x0F/', '/\x10/', '/\x11/',
			'/\x12/','/\x13/','/\x14/','/\x15/', '/\x16/', '/\x17/', '/\x18/',
			'/\x19/','/\x1A/','/\x1B/','/\x1C/','/\x1D/', '/\x1E/', '/\x1F/'
		), 
		array(
			"", "", "", "", "",
			"", "", "", "", "", "",
			"", "", "", "", "", "", "",
			"", "", "", "", "", "", "",
			"", "", "", "", "", "", ""
		), 
		$password1
	);

	//Databasanroper körs
	if(!empty($username) && !empty($pass) ){

			$sql = "SELECT user_login FROM wp_users WHERE user_login = ?";
			$params = array($username);
			$query = $dbh -> prepare($sql);
			$query -> execute($params);
			$result = $query -> fetch();
		
			if ($result['user_login'] !== null) {
				
				$sql = "SELECT user_pass FROM wp_users WHERE user_login = ?";
				$params = array($username);
				$query = $dbh -> prepare($sql);
				$query -> execute($params);
				$result = $query -> fetch();
				
				$hash = $result['user_pass'];
				$wp_hasher = new PasswordHash(8, TRUE);
				$check = $wp_hasher->CheckPassword($pass, $hash);

				
				
						if($check)	
						{
							$json = array("result" => 1, "message" => "Login succeed!");
						}
						else{
							$json = array("result" => 0, "message" => "Wrong username and or password!");
						}
			}
			else{
				$json = array("result" => 0, "message" => "User doesn't exist!");
			}
			
	}		
	else{
		
		$json = array("result" => 0, "message" => "Empty username and or password");
	}

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);