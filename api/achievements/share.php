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
	$username = isset($_POST['username']) ? $_POST['username'] : "";
	
	
		
		die();

		
}