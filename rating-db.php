<?php

#function to add a rating into the rating table

function addRating($overall, $hours_a, $hours_s, $num_a)
{
    global $db;
    $query = "INSERT INTO rating (overall_rating, hours_assignment_per_week, hours_studying_per_week, num_assignments) VALUES (:overall, :hours_a, :hours_s, :num_a)";
    $statement = $db->prepare($query);
    $statement->bindValue('overall', $overall);
    $statement->bindValue('hours_a', $hours_a);
    $statement->bindValue('hours_s', $hours_s);
    $statement->bindValue('num_a', $num_a);
    $statement->execute();
    $statement->closeCursor();
}

# function to get the rank id from the rating that was just created

// function getRankID()
// {
//     global $db;
//     $query = "SELECT rankID FROM rating ORDER BY rankID DESC LIMIT 0,1";
//     $statement = $db->prepare($query);
//     $statement->execute();
//     $result = $statement->fetchALL();
//     $statement->closeCursor();
//     return $result;
// }

# function to add information to ranks table

// function addRanks($rankID, $studentID)
// {
//     global $db;
//     $query = "INSERT INTO ranks (rankID, studentID) VALUES (:rankID, :studentID)";
//     $statement = $db->prepare($query);
//     $statement->bindValue('rankID', $rankID);
//     $statment->bindValue('studentID', $studentID);
//     $statement->execute();
//     $statement->closeCursor();
// }

// function addRating($student_id, $class, $overall, $hours_a, $hours_s, $num_a)
// {
//     #for incrementing ratingID
//     global $db;
//     $query1 = "select max(rankID) from rating";
//     $statement1 = $db->prepare($query1);
//     $statement1->execute();
//     $rating_id = $statement1->fetch();
//     $rating_id += 1;
//     $statement1->closeCursor();


//     #inserting data into the rating table
//     $query2 = "insert into rating values (:rating_id, :hours_a, :overall, :hours_s, :num_a)";
//     $statement2 = $db->prepare($query2);
//     $statement2->bindValue(':rating_id', $rating_id);
//     $statement2->bindValue(':hours_a', $hours_a);
//     $statement2->bindValue(':overall', $overall);
//     $statement2->bindValue(':hours_s', $hours_s);
//     $statement2->bindValue(':num_a', $num_a);

//     $statement2->execute();
//     $statement2->closeCursor();

//     #inserting data into the ranks table
//     $query3 = "insert into ranks values (:rating_id, :student_id)";
//     $statement3 = $db->prepare($query3);
//     $statement3->bindValue(':rating_id', $rating_id);
//     $statement3->bindValue(':student_id', $student_id);
//     $statement3->execute();
//     $statement3->closeCursor();

//     #inserting data into rankAbout table
//     #need to fetch classID

//     #fetching classID from classCode table
//     $query4 = "select classID from rankAbout where classCode = :class";
//     $statement4 = $db->prepare($query4);
//     $statement4->bindValue(':class', $class);
//     $statement4->execute();
//     $classID = $statement4->fetch();
//     $statement5->closeCursor();

//     $query5 = "insert into rankAbout values (:rating_id, :classID)";
//     $statement5 = $db->prepare($query5);
//     $statement5->bindValue(':rating_id', $rating_id);
//     $statement5->bindValue(':classID', $classID);
//     $statement5->execute();
//     $statement5->closeCursor();


// }

?>