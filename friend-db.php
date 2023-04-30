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
// Create a new comment
function createComment( $studentID, $date_posted, $content) {
    // Establish database connection
    global $db;
    $query = "INSERT into comments (studentID, date_posted, content) values (:studentID, :date_posted, :content)";
	$statement = $db->prepare($query);
	
	$statement->bindValue('studentID', $studentID);
	$statement->bindValue('date_posted', $date_posted);
	$statement->bindValue('content', $content);
	$statement->execute();
    $statement->closeCursor();
    
}
function getClassCode($classID) {
    global $db;
    $query1 = "SELECT classCode from classCode where classID = :classID";
    $statement1 = $db->prepare($query1);
    $statement1->bindValue(':classID', $classID);
    $statement1->execute();
	$classID = $statement1->fetch();
    $statement1->closeCursor();
	return $classID[0];
}

function addclassComment  ( $classID )
{
    global $db;
    $query = "INSERT INTO classComment (classID) values ( :classID)";
    $statement = $db->prepare($query);
   
    $statement->bindValue(':classID', $classID);

    $statement->execute();
    $statement->closeCursor();

}
function addStudentComment ($studentID ){
	global $db;
    $query = "INSERT into studentComment (studentID) values (:studentID)";
    $statement = $db->prepare($query);
   
    $statement->bindValue(':studentID', $studentID);

    $statement->execute();
    $statement->closeCursor();

}
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
function checkClasses ()
{
	global $db;
	$query = "GRANT ALL PRIVILEGES ON classes .* TO administrator";
	$statement = $db -> prepare($query);
	$statement -> execute();
	$query = "Create assertion check_class_code check ( not exists ( select * from classCode cc left join class c on cc. classID = c.classID and cc.classCode = c.classCode where c.classID is null))";
	$statement = $db -> prepare ($query);
	$statement -> exectute();
	$statement->closeCursor();
	
}
function updateCodes(){
	global $db;
	$query = "create procedure update_class_code( in in_classID int, in in_classCode varchar (255)) begin update class set classCode = in_classCode where classID = in_classID; update classCode set classCode = in_classCode where classId = in_classID; end";
	$statement = $db -> prepare ($query);
	$statement -> exectute();
	$statement->closeCursor();
}
function selectAllComments($studentID)
{
	global $db;
	$query = "SELECT * from comments NATURAL JOIN studentComment  NATURAL JOIN classComment NATURAL JOIN class NATURAL JOIN professor WHERE studentID = :studentID";
	//prepare
	$statement = $db->prepare($query);
	//execute
	$statement->bindValue(":studentID", $studentID);
	$statement->execute(); 
	//retrieve
	$results = $statement->fetchAll(); // fetch() will only retrieve the first row
	//close cursor
	$statement->closeCursor();
	//return result
	return $results;
}

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
function deleteComment($comment_to_delete)
{
	global $db;
	//query
	$query = "DELETE FROM comments WHERE commentID=:comment_to_delete";
	//prepare
	$statement = $db->prepare($query);
	//execute
	$statement->bindValue(':comment_to_delete', $comment_to_delete);
	$statement->execute(); 
	//close cursor
	$statement->closeCursor();

}
function getFriendByName($name)
{
	global $db;
	$query = "select * from friends where name=:name";
	$statement = $db->prepare($query);
	$statement->bindValue(':name', $name);
	$statement->execute(); 
	$result = $statement->fetch(); // fetch() will only retrieve the first row
	$statement->closeCursor();
	return $result;
};

function getCommentByID($commentID)
{
	global $db;
	$query = "SELECT * from comments where commentID=:commentID";
	$statement = $db->prepare($query);
	$statement->bindValue(':commentID', $commentID);
	$statement->execute(); 
	$result = $statement->fetch(); // fetch() will only retrieve the first row
	$statement->closeCursor();
	return $result;
}
function updateFriend($name, $major, $year)
{
    global $db;
    $query = "update friends set major=:major, year=:year where name=:name";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':major', $major);
    $statement->bindValue(':year', $year);
    $statement->execute();
    $statement->closeCursor();
};
function updateComment($commentID, $studentID, $date_posted, $content)
{
	global $db;
    $query = "update comments set  studentID=:studentID, date_posted=:date_posted, content=:content where commentID=:commentID";
	$statement = $db->prepare($query);
	$statement->bindValue('commentID', $commentID);
	$statement->bindValue('studentID', $studentID);
	$statement->bindValue('date_posted', $date_posted);
	$statement->bindValue('content', $content);
	$statement->execute();
    $statement->closeCursor();

}

// Update an existing comment




?>