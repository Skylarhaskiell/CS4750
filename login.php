<?php
require("connect-db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if user exists in database
    $sql = "SELECT * FROM login WHERE username = '$username' AND userPassword = '$password'";
    $result = $db->query($sql);


    if ($result->rowCount() > 0) {
        // User exists, show success message
        echo "Login successful!";
        header('Location: index.php');
        exit();
        
    } else {
        // User does not exist, give option to try again or create new user
        echo "Invalid login. Would you like to try again or create a new user?";
        echo "<br>";
        echo "<a href='login.php'>Try again</a> | <a href='create_user.php'>Create new user</a>";
    }
}

// Close connection
// $conn->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<style>
		.login {
			background-color: #ADE4DB;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			height: 100vh;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
	</style>
</head>
<body>
	<div class="login">
		<h2>Login Form</h2>
		<form method="post" action="login.php">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" required><br><br>

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required><br><br>

			<input type="submit" value="Login">
		</form>
		<p>New user? <a href="create_user.php">Create an account</a></p>
	</div>
</body>
</html>


