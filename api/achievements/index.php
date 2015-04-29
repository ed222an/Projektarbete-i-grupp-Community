<h2>API</h2>
<h3>POST</h3>
<form action="http://127.0.0.1/achievements/PostAchievement.php" method="POST">
    <br>Achievement
	<input type="text" name="achievement" value="10 Kills">
	<br>Achievement is done
    <input type="number" name="achievementIsDone" value="1">
	<br>Username
	<input type="text" name="username" value="Admin">
	<br>Password
	<input type="text" name="password" value="">
        <input type="submit" value="Skicka">
</form>

<h3>GET all achievements on user</h3>
<form action="http://127.0.0.1/achievements/GetAchievement.php" method="GET">
    <br>Achievement name
	<input type="text" name="achievementName" value="10 Kills">
	<br>Username
	<input type="text" name="username" value="Admin">
	<br>Status
	<select name="status">
	  <option value="">Get all</option>
	  <option value="true">Done</option>
	  <option value="false">In progress</option>
	</select>

        <input type="submit" value="Skicka">
</form>

<h3>Test</h3>
<form action="http://127.0.0.1/achievements/UpdateAchievement.php" method="POST">
    <br>Update achievements on all users
	<input type="text" name="username" value="Admin">
	<input type="text" name="password" value="Password">

        <input type="submit" value="Skicka">
</form>