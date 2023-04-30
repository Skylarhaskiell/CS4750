<?php include 'header.php';
?>
<?php
require("connect-db.php");
require("friend-db.php");
require("rating-db.php");

// echo $professorID;

//$friends = selectAllFriends();
//var_dump($friends);
$friend_info_to_update = null;
$class_info_to_update = null;
session_start(); // Start the session

$studentID = $_SESSION['studentID'];
$comments = selectAllComments($studentID);
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && $_POST['actionBtn'] == "Update") {
    $commentID = $_POST['comment_to_update'];
    $class_info_to_update = getCommentByID($commentID);
    header("location:simpleform.php");
    exit();
  }
  
  
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add comment"))
  {
    
    // $classID = (int)getClassID($_POST['classID'], $professorID);
    // $classCode = ($_POST['classID']);
    $classCode = getClassCode($_POST['classID']);
    // createComment( $_POST['studentID'], $_POST['date_posted'], $_POST['content']);
    createComment( $studentID, $_POST['date_posted'], $_POST['content']);
    addclassComment(  $_POST['classID']);
    // addStudentComment($_POST['studentID']);
    addStudentComment($studentID);
    //$friends = selectAllFriends();
    $comments = selectAllComments($studentID);
    header("location:simpleform.php");

  }
   else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteComment($_POST['comment_to_delete']);
    //$friends = selectAllFriends();
    $comments = selectAllComments($studentID);
    header("location:simpleform.php");

  }
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm update")) {
    updateComment($_POST['commentID'], $_POST['studentID'], $_POST['date_posted'], $_POST['content']);
    $comments = selectAllComments($studentID);
    header("location:simpleform.php");
    exit();
  }
}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  <!-- 2. include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <meta name="author" content="Hannah Tuma">
  <meta name="description" content="include some description about your page">  
    
  <title>Bootstrap example</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  
       
</head>

<body>
<div class="container">
  <h1>Add Comment</h1>  
  

  <form name="mainForm" action="simpleform.php" method="post">   
    
    <div class="row mb-3 mx-3"> 
    Course: 
    <select type="text" class="form-control" name = 'classID' required>
      
      <option> SELECT COURSE </option>
      <?php 
        
        $connection = mysqli_connect("mysql01.cs.virginia.edu","smw6ure","CS4750!","smw6ure_c");
        $sql = mysqli_query($connection, "SELECT classID, classCode, firstName, lastName, professorID from class NATURAL JOIN professor ORDER BY classCode");
        while ($row = $sql->fetch_assoc()){
          if($row['professorID'] != ""){
            echo "<option value='" . $row['classID'] . "'>" . $row['classCode']. " - " . $row['firstName'] . " " . $row['lastName'] ."</option>";
          }
          else{
            echo "<option value='" . $row['classID'] . "'>" . $row['classCode']. " - Unknown Professor" ."</option>";
          }
        }
        if ($class_info_to_update != null) {
          $selectedCourseID = $class_info_to_update['classID'];
          $selectedContent = $class_info_to_update['content'];
          echo "<script>document.mainForm.classID.value = '$selectedCourseID';</script>";
        }
      ?>
  </select>
  </div>
    <div class="row mb-3 mx-3">  
    date_posted:
    <input type="text" class="form-control" name="date_posted" required 
    value="<?php echo date("Y-m-d")?> <?php if ($class_info_to_update !=null) echo $class_info_to_update['date_posted'];?>"
    />   
    </div>
    <div class="row mb-3 mx-3">
    content:
    <input type="text" class="form-control" name="content" required 
    value="<?php if ($class_info_to_update !=null) echo $class_info_to_update['content'];?>"
    />  
    </div> 

  </div> 
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add comment" title="click to insert comment" style='background-color:#f28482; stroke-width:0px;'/> 
</div>
<div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-dark" name="actionBtn" value="Confirm update" title="click to confirm update" style='background-color:#919191;'/> 
</div>
</form> 



  
</div> 
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
  <th width="10%">Course</th>  
  <th width="15%">Professor</th> 
    <th width="12%">Student ID</th>   
    <th width="12%">Date</th> 
    <th>Comment</th> 
    <th>Update?</th>
    <th>Delete?</th>
  </tr>
  </thead>
  <?php foreach ($comments as $item): ?>
  <tr>
     <td><?php echo $item['classCode'] ; ?></td>
     <td><?php echo $item['firstName']. ' ' . $item['lastName'] ?></td>
     <td><?php echo $item['studentID']; ?></td>
     <td><?php echo $item['date_posted']; ?></td>        
     <td><?php echo $item['content']; ?></td>
     <td>
      <form action="simpleform.php" method="post">
        <?php if ($class_info_to_update != null && $class_info_to_update['commentID'] == $item['commentID']): ?>
          <input type="hidden" name="classID" value="<?php echo $class_info_to_update['classID']; ?>" />
          <input type="hidden" name="content" value="<?php echo $class_info_to_update['content']; ?>" />
        <?php else: ?>
          <input type="submit" name="actionBtn" value="Update" class="btn btn-dark" style='background-color:#919191;'/>
          <input type="hidden" name="comment_to_update" value="<?php echo $item['commentID'];?>" />
        <?php endif; ?>
      </form>
    </td>    
    <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Delete" class="btn btn-danger" style='background-color:#f28482;'/>
        <input type="hidden" name="comment_to_delete" value="<?php echo $item['commentID'];?>" />
      </form>
    </td>                   
  </tr>
<?php endforeach; ?>

</table>
</div>   
</body>
</html>