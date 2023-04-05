
<?php
require("connect-db.php");

require("comment-db.php");

$classes = selectAllClasses();
//var_dump($friends);
$user_comment_to_update = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Update"))
  {
    $comment_info_to_update = selectCommentsByUser($_POST['user_comment_to_update']);
    #var_dump($friend_info_to_update);
  }
  
  else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Add comment"))
  {
    addComment($_POST['studentID'], $_POST['classID'], $_POST['content']);
    $friends = selectAllFriends();
  }
   else if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Delete"))
  {
    deleteComment($_POST['comment_to_delete']);
    $classes = selectAllClasses();
    // $friends = selectAllFriends();
  }
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Confirm update"))
  {
    
    updateComment($_POST['studentID'], $_POST['classID'], $_POST['content']);
    $classes = selectAllClasses();
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
  <h1>Friend Book</h1>  

  <form name="mainForm" action="simpleform.php" method="post">   
  <div class="row mb-3 mx-3">
    Name:
    <input type="text" class="form-control" name="studentID" required 
      value="<?php if ($user_comment_to_update !=null) echo $user_comment_to_update['studentID'];?>"
    />  
    </div> 
    <div class="row mb-3 mx-3">    
    Major:
    <input type="text" class="form-control" name="classID" required 
    value="<?php if ($user_comment_to_update !=null) echo $user_comment_to_update['classID'];?>"
    /> 
    </div>
    <div class="row mb-3 mx-3">  
    Year:
    <input type="text" class="form-control" name="content" required 
    value="<?php if ($user_comment_to_update !=null) echo $user_comment_to_update['content'];?>"
    />   
  </div> 
  <div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add comment" title="click to add comment"/> 
</div>
<div class="row mb-3 mx-3">
  <input type="submit" class="btn btn-dark" name="actionBtn" value="Confirm update" title="click to confirm update"/> 
</div>
</form> 



  
</div> 
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">studentID</th>        
    <th width="30%">classID</th>        
    <th width="30%">Comment</th> 
    <th>Update?</th>
    <th>Delete?</th>
  </tr>
  </thead>
<?php foreach ($friends as $item): ?>
  <tr>
     <td><?php echo $item['studentID']; ?></td>
     <td><?php echo $item['classID']; ?></td>        
     <td><?php echo $item['content']; ?></td>
     <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Update" class="btn btn-dark" />
        <input type="hidden" name="user_comment_to_update" value="<?php echo $item['studentID'];?>" />
      </form>
    </td>    
    <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Delete" class="btn btn-danger" />
        <input type="hidden" name="comment_to_delete" value="<?php echo $item['studentID'];?>" />
      </form>
    </td>                   
  </tr>
<?php endforeach; ?>
</table>
</div>     
</body>
</html>