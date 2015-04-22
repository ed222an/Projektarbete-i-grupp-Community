<?php
include_once('confi.php');

include_once('PasswordHash.php');
//Tables
$dbTable = "wp_achievements";

$conn = new connection();
$dbh = $conn->getConnection();
//decrypt av lösenord fått ifrån.
//https://gist.github.com/t-kashima/5714358

function array_delete($array, $element) {
    return array_diff($array, [$element]);
}


//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$achievement = isset($_POST['achievement']) ? $_POST['achievement'] : "";
	
		$sql = "SELECT user_login FROM `wp_users`";
		$params = array($achievement);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		//hämtar alla users
		$result = $query -> fetchAll();
		
		//var_dump($result);
		//die();
		
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
		
		foreach($namesAndAchievements as $user => $achievements) {
			echo"<h3>" . $user . "</h3>";
			foreach($achievements as $achievement) {
				if($achievement[0] != false)
					echo "<p>" . $achievement[0] . "</p>";
			}
		}
		
		var_dump($namesAndAchievements);
		die();

	
		$sql = "SELECT username FROM `wp_achievements` WHERE `achievement` = ? group by `username`";
		$params = array($achievement);
		$query = $dbh -> prepare($sql);
		$query -> execute($params);
		//hämtar vilka som har detta achievement
		$result2 = $query -> fetchAll();
		
		$result = array_diff($result, $result2);
		
		var_dump($result);
		
}