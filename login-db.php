<?php
function checkLogin($username, $userPassword){
    global $db;
    $statement->bindValue('username', $username);
    $statement->bindValue('userPassword', $userPassword);
    

    $statement->execute();
    $statement->closeCursor();
}

// function login($username, $password) {
// 	global $db;
// 	$query = "SELECT * FROM login WHERE username = :username AND userPassword = :password";
// 	$statement = $db->prepare($query);
// 	$statement->bindValue(':username', $username);
// 	$statement->bindValue(':password', $password);
// 	$result = $statement->fetch();
// 	return $result;
// }

# function to get studentID of user after they login
function getStudentID($username, $pwd) {
	global $db;
	$query = "SELECT studentID FROM login WHERE username = :username AND userPassword = :pwd";
	$statement = $db->prepare($query);
	$statement->bindValue(':username', $username);
	$statement->bindValue(':pwd', $pwd);
	$result = $statement->fetch();
	$statement->closeCursor();
	return $result[0];
}

?>