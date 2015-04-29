<?php
include_once('confi.php');

include_once('PasswordHash.php');
//Tables
$dbTable = "wp_achievements";

$conn = new connection();
$dbh = $conn->getConnection();


//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$username = isset($_POST['username']) ? $_POST['username'] : "";
	$password = isset($_POST['password']) ? $_POST['password'] : "";
	
	
	
	$key = 'This1KeyIsTheBestKey2EvermadeYo3';
	$iv = 'ThisIv23KeyIsAlsoOneOfTheBestest';
	
	$decrypted = base64_decode($password);
	$password1 = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decrypted, MCRYPT_MODE_CBC, $iv);
	
	$password = preg_replace(
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
	
				$sql = "SELECT user_pass FROM wp_users WHERE user_login = ?";
				$params = array($username);
				$query = $dbh -> prepare($sql);
				$query -> execute($params);
				$result = $query -> fetch();
				$password = "Password";
				$hash = $result['user_pass'];
	
	
	$wp_hasher = new PasswordHash(8, TRUE);
	$check = $wp_hasher->CheckPassword($password, $hash);
	
	
	//Only the Admin user can do this
	if($check && $username = "Admin"){
		$sql = "SELECT user_login FROM `wp_users`";
		$params = array();
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		//hämtar alla users
		$result = $query -> fetchAll();

		
		$sql = "SELECT name FROM `wp_achievementlist`";
		$params = array();
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		//hämtar alla users
		$resultAchievements = $query -> fetchAll();
		
		$namesAndAchievements = array();
		
		for($i = 0; $i < count($result); $i++) {
			$namesAndAchievements[$result[$i][0]] = array();
			foreach($resultAchievements as $achievementName) {
				$sql = "SELECT name from `wp_achievementlist` WHERE name = '" . $achievementName[0] . "' AND (SELECT COUNT(*) FROM `wp_achievements` WHERE username = '" . $result[$i][0] . "' AND achievement = '" . $achievementName[0] . "') = 0";
				$query = $dbh -> prepare($sql);
				$query -> execute();
				array_push($namesAndAchievements[$result[$i][0]], $query -> fetch());
			}
		}
		
		//Lägger till de achievement som saknas på användarna
		foreach($namesAndAchievements as $user => $achievements) {
			
			foreach($achievements as $achievement) {
				if($achievement[0] != false)
					$sql = "INSERT INTO `wp_achievements` (achievement,achievementIsDone, username) VALUES (?,?,?)";
					$params = array($achievement[0], 0, $user);
					$query = $dbh -> prepare($sql);
					$query -> execute($params);
					//echo "<p>" . $achievement[0] . "</p>";
			}
		}
			echo "Achievements were added successfully!";
	}
	

		//var_dump($namesAndAchievements);
		die();

		
}