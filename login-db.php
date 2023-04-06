<?php
function checkLogin($username, $userPassword){
    global $db;
    $statement->bindValue('username', $username);
    $statement->bindValue('userPassword', $userPassword);
    

    $statement->execute();
    $statement->closeCursor();
}

?>