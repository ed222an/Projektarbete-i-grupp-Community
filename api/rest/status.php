<?php
include_once('confi.php');
//include_once('C:\Users\Mikael\Documents\GitHub\Projektarbete-i-grupp-Community\wordpress\wp-includes\pluggable.php');
//include_once('C:\Users\Mikael\Documents\GitHub\Projektarbete-i-grupp-Community\wordpress\wp-includes\compat.php');
//include_once('C:\Users\Mikael\Documents\GitHub\Projektarbete-i-grupp-Community\wordpress\wp-includes\class-phpass.php');
include_once('PasswordHash.php');
//Tables
$dbTable = "wp_stats";
//$password = "Password";
//Get connection string
$conn = new connection();
$dbh = $conn->getConnection();
//echo '$P$BxS.rtj1mR6CNNcQuDblL.qc7vv0H2/';
//$test = wp_check_password( 'password', '$P$BxS.rtj1mR6CNNcQuDblL.qc7vv0H2/', 'Admin');
//$hash = wp_hash_password( $password );


//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$statName = isset($_POST['statName']) ? $_POST['statName'] : "";
	$statCount = isset($_POST['statCount']) ? $_POST['statCount'] : "";
	$username = isset($_POST['username']) ? $_POST['username'] : "";
	$password = isset($_POST['password']) ? $_POST['password'] : "";
	
//Databasanroper körs
	if(!empty($username)){


		
		
		// if(){
			// 
		// }

		

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
				$check = $wp_hasher->CheckPassword($password, $hash);

				echo ">" . $check . "<";
				
						if($check)	
						{						
							$sql = "SELECT * FROM wp_stats WHERE username= ? AND statName= ?";
							$params = array($username, $statName);
							$query = $dbh -> prepare($sql);
							$query -> execute($params);
							$rows = $query -> fetchColumn();
							
							if($rows) {
								
								$sql = "UPDATE $dbTable SET statCount = ? WHERE username = ? AND statName= ?";
								$params = array($statCount, $username, $statName);
								$query = $dbh -> prepare($sql);
								$query -> execute($params);
								$json = array("result" => 1, "message" => "Edit Success");
							}
							else{
								
								$sql = "INSERT INTO $dbTable (statName,statCount, username) VALUES (?,?,?)";
								$params = array($statName, $statCount,$username);
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
		$json = array("result" => 0, "message" => "User ID not defined");
	}
}else{
		$json = array("result" => 0, "message" => "User ID not defined");
	}
//Output to browser
	header('Content-type: application/json');
	echo json_encode($json);