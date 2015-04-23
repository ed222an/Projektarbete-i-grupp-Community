<?php
include_once('confi.php');

include_once('PasswordHash.php');
//Tables
$dbTable = "wp_achievements";

$conn = new connection();
$dbh = $conn->getConnection();

//Mickes fulkod som löser problemet med att existerande användare inte får nya achivements om de läggs till nya.
//Fungerar bra och behövs bara ett knapptryck för att uppdatera allas achievements.

//Kontrollerar request metoden
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$achievement = isset($_POST['achievement']) ? $_POST['achievement'] : "";
	
		$sql = "SELECT user_login FROM `wp_users`";
		$params = array($achievement);
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
			echo"<h3>" . $user . "</h3>";
			foreach($achievements as $achievement) {
				if($achievement[0] != false)
					$sql = "INSERT INTO `wp_achievements` (achievement,achievementIsDone, username) VALUES (?,?,?)";
					$params = array($achievement[0], 0, $user);
					$query = $dbh -> prepare($sql);
					$query -> execute($params);
					//echo "<p>" . $achievement[0] . "</p>";
			}
		}
		//var_dump($namesAndAchievements);
		die();

		
}