<?php

function addRating($student_id, $class, $overall, $hours_a, $hours_s, $num_a)
{
    #for incrementing ratingID
    global $db;
    $query1 = "select max(rankID) from rating";
    $statement1 = $db->prepare($query1);
    $statement1->execute();
    $rating_id = $statement1->fetch();
    $rating_id += 1;
    $statement1->closeCursor();


    #inserting data into the rating table
    $query2 = "insert into rating values (:rating_id, :hours_a, :overall, :hours_s, :num_a)";
    $statement2 = $db->prepare($query2);
    $statement2->bindValue(':rating_id', $rating_id);
    $statement2->bindValue(':hours_a', $hours_a);
    $statement2->bindValue(':overall', $overall);
    $statement2->bindValue(':hours_s', $hours_s);
    $statement2->bindValue(':num_a', $num_a);

    $statement2->execute();
    $statement2->closeCursor();

    #inserting data into the ranks table
    $query3 = "insert into ranks values (:rating_id, :student_id)";
    $statement3 = $db->prepare($query3);
    $statement3->bindValue(':rating_id', $rating_id);
    $statement3->bindValue(':student_id', $student_id);
    $statement3->execute();
    $statement3->closeCursor();

    #inserting data into rankAbout table
    #need to fetch classID

    #fetching classID from classCode table
    $query4 = "select classID from rankAbout where classCode = :class";
    $statement4 = $db->prepare($query4);
    $statement4->bindValue(':class', $class);
    $statement4->execute();
    $classID = $statement4->fetch();
    $statement5->closeCursor();

    $query5 = "insert into rankAbout values (:rating_id, :classID)";
    $statement5 = $db->prepare($query5);
    $statement5->bindValue(':rating_id', $rating_id);
    $statement5->bindValue(':classID', $classID);
    $statement5->execute();
    $statement5->closeCursor();


}

?>