<?php
function addComment($studentID, $classID, $content)
{
    global $db;
    $query = "INSERT INTO comments (studentID, classID, content) VALUES (:studentID, :classID, :content)";
    $statement = $db->prepare($query);
    $statement->bindValue(':studentID', $studentID);
    $statement->bindValue(':classID', $classID);
    $statement->bindValue(':content', $content);
    $statement->execute();
    $statement->closeCursor();
}

function selectCommentsByClassID($classID)
{
    global $db;
    $query = "SELECT * FROM comments WHERE classID=:classID";
    $statement = $db->prepare($query);
    $statement->bindValue(':classID', $classID);
    $statement->execute(); 
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function updateComment($commentID, $content)
{
    global $db;
    $query = "UPDATE comments SET content=:content WHERE commentID=:commentID";
    $statement = $db->prepare($query);
    $statement->bindValue(':commentID', $commentID);
    $statement->bindValue(':content', $content);
    $statement->execute();
    $statement->closeCursor();
}

function deleteComment($commentID) 
{
    global $db;
    $query = "DELETE FROM comments WHERE commentID=:commentID";
    $statement = $db->prepare($query);
    $statement->bindValue(':commentID', $commentID);
    $statement->execute(); 
    $statement->closeCursor();
}
function selectAllClasses()
{
    global $db;
    $query = "SELECT * FROM class";
    $statement = $db->prepare($query);
    $statement->execute(); 
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
function selectCommentsByUser($userID)
{
    global $db;
    $query = "SELECT * FROM comments WHERE studentID = :userID";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute(); 
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}
?>