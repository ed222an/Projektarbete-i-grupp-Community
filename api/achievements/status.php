<?php
include_once('confi.php');

include_once('PasswordHash.php');
//Tables
$dbTable = "wp_achievements";

$conn = new connection();
$dbh = $conn->getConnection();
//decrypt av lösenord fått ifrån.
//https://gist.github.com/t-kashima/5714358


//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$achievement = isset($_POST['achievement']) ? $_POST['achievement'] : "";
	$achievementIsDone = isset($_POST['achievementIsDone']) ? $_POST['achievementIsDone'] : "";
	$username = isset($_POST['username']) ? $_POST['username'] : "";
	$password = isset($_POST['password']) ? $_POST['password'] : "";
	
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
	if(!empty($username) && !empty($achievement) /*&& !empty($password)*/ ){

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
				$pass = "Password";
				$hash = $result['user_pass'];
				$wp_hasher = new PasswordHash(8, TRUE);
				$check = $wp_hasher->CheckPassword($pass, $hash);

				
				
						if($check)	
						{						
							$sql = "SELECT * FROM wp_achievements WHERE username= ? AND achievement= ? AND achievementIsDone= ?";
							$params = array($username, $achievement, $achievementIsDone);
							$query = $dbh -> prepare($sql);
							$query -> execute($params);
							$rows = $query -> fetchColumn();
							
							if($rows) {
								
								$sql = "UPDATE $dbTable SET achievementIsDone = ? WHERE username = ? AND achievement= ?";
								$params = array($achievementIsDone, $username, $achievement);
								$query = $dbh -> prepare($sql);
								$query -> execute($params);
								$json = array("result" => 1, "message" => "Edit Success");
							}
							else{
								
								$sql = "INSERT INTO $dbTable (achievement,achievementIsDone, username) VALUES (?,?,?)";
								$params = array($achievement, $achievementIsDone,$username);
								$query = $dbh -> prepare($sql);
								$query -> execute($params);
								$json = array("result" => 1, "message" => "Add Success");
							}
						}
						else{
							$json = array("result" => 0, "message" => "Username or password is incorrect");
						}
				
				
			}else{
				$json = array("result" => 0, "message" => "User do not exist");
			}
		
	}else{
		$json = array("result" => 0, "message" => "Username and or password and or achievement");
	}
}else{
		$json = array("result" => 0, "message" => "Error no send");
	}
//Output to browser
	header('Content-type: application/json');
	echo json_encode($json);