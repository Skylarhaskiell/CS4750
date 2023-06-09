
<?php
// Connect to the database
require("connect-db.php");
global $db;

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password = sha1($password);
    $password2 = $_POST["password2"];
    $password2 = sha1($password2);
    $studentID = $_POST["studentID"];

    // Check if the passwords match
    if ($password != $password2) {
        // Show error message
        echo "Passwords do not match!";
    } else {
        // Check if the username or studentID already exists in the database
        $sql = "SELECT * FROM login WHERE username = '$username' OR studentID = '$studentID'";
        $result = $db->query($sql);
        if ($result->rowCount() > 0) {
            // Show warning message
            echo "Username or student ID already exists in the database!";
        } else {
            // Insert new user into database
            $sql = "INSERT INTO login (studentID, username, userPassword) VALUES ('$studentID', '$username', '$password')";
            $db->query($sql);
            $sql = "SELECT * FROM login WHERE username = '$username' AND userPassword = '$password'";
            $result = $db->query($sql);
            if ($result->rowCount() > 0) {
                // Success message
                session_start();
    	        $sql = "SELECT studentID from login where username = '$username'";
    	        $result = $db->query($sql);
    	        $_SESSION['studentID'] = $result->fetchColumn();
                echo "User created successfully!";
                header('Location: student_details.php');
                exit();
            } else {
                // Error message
                echo "Error creating user";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Create User</title>
	<style>
		body {
			background-color: #6DA9E4;
		}
		form {
			text-align: center;
			margin-top: 50px;
		}
	</style>
</head>
<body>
	
	<form method="post" action="create_user.php">
		
        <h2>Create User</h2>
    
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>

		<label for="password2">Re-Enter Password:</label>
		<input type="password" id="password2" name="password2" required><br><br>

		<label for="studentID">Student ID:</label>
		<input type="text" id="studentID" name="studentID" ><br><br>

		<input type="submit" value="Create User">
	</form>
</body>
</html>


