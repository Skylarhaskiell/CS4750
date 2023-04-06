<?php
require("connect-db.php");
require("rating-db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add Rating")) 
  {
    addRating($_POST['overall_rating'], $_POST['hours_per_week_assignments'], $_POST['hours_per_week_study'], $_POST['num_assignments']);
    // $rankID = getRankID();
    // addRanks($rankID, $_POST['computingID']);
    #echo "<p please $rankID </p>";
  }

}
?>



<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  
  <meta name="author" content="Hannah Tuma">
  <meta name="description" content="include some description about your page">  
    
  <title>Bootstrap example</title>
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  

  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

       
</head>

<body>
<div class="container">
  <h1>Course Rating</h1>  

  <form name="mainForm" action="rating_simpleform.php" method="post">  
  <div class="row mb-3 mx-3">
    ComputingID:
    <input type="text" class="form-control" name="computingID" required />        
  </div>
  <div class="row mb-3 mx-3">
    Course:
    <input type="text" class="form-control" name="course" required />        
  </div>
  <div class="row mb-3 mx-3">
    Overall Rating:
    <input type="text" class="form-control" name="overall_rating" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent on assignments per week:
    <input type="text" class="form-control" name="hours_per_week_assignments" required />        
  </div>
  <div class="row mb-3 mx-3">
    Hours spent studying per week:
    <input type="text" class="form-control" name="hours_per_week_study" required />        
  </div>
  <div class="row mb-3 mx-3">
    Number of assingments:
    <input type="text" class="form-control" name="num_assignments" required />        
  </div>
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add Rating" title="click to add rating">
</div>

</form>  
 
  
</div>    
</body>
</html>

