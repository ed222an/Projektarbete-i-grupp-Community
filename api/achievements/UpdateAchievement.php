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
	
	
	


	$sql = "SELECT user_pass FROM wp_users WHERE user_login = ?";
	$params = array($username);
	$query = $dbh -> prepare($sql);
	$query -> execute($params);
	$result = $query -> fetch();

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
	else{
	    echo "Error wrong username and or password";
	}
	

	

		
}