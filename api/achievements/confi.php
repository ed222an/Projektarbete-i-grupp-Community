<?php	
class connection{
	//Returns the connection string
	public function getConnection(){
		return new PDO('mysql:host=127.0.0.1;dbname=wordpress', 'root', '');
	}
}