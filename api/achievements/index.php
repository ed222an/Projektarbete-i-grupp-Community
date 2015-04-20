<h2>API</h2>
<h3>POST</h3>
<form action="http://127.0.0.1/achievements/status.php" method="POST">
    <br>Stat name
	<input type="text" name="statName" value="kills">
	<br>Count
    <input type="text" name="statCount" value="250">
	<br>Username
	<input type="text" name="username" value="Admin">
	<br>Password
	<input type="text" name="password" value="Password">
        <input type="submit" value="Skicka">
</form>
<h3>GET</h3>
<form action="http://127.0.0.1/achievements/info.php" method="GET">
    <br>Stat name
	<input type="text" name="statName" value="kills">
	<br>Username
	<input type="text" name="username" value="Admin">
	<br>Password
	<input type="text" name="password" value="Password" disabled>
        <input type="submit" value="Skicka">
</form>