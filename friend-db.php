<?php
function addFriend($name,$major, $year)
{
    global $db;
    // $query = "insert into friends values ($name, $major, $year)";
    // $statement = $db->query($query); //compile and execute
    $query = "insert into friends values (:name, :major, :year)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();
};

function selectAllFriends()
{
    //db
	global $db;
	//query
	$query = "SELECT * FROM friends";
	//prepare
	$statement = $db->prepare($query);
	//execute
	$statement->execute(); 
	//retrieve
	$results = $statement->fetchAll(); // fetch() will only retrieve the first row
	//close cursor
	$statement->closeCursor();
	//return result
	return $results;
};

function deleteFriend($friend_to_delete) 
{
	//db
	global $db;
	//query
	$query = "DELETE FROM friends WHERE name=:friend_to_delete";
	//prepare
	$statement = $db->prepare($query);
	//execute
	$statement->bindValue(':friend_to_delete', $friend_to_delete);
	$statement->execute(); 
	//close cursor
	$statement->closeCursor();
};
?>