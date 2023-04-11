<?php
require("connect-db.php");

require("login-db.php");
$user_to_login = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['actionBtn']) && ($_POST['actionBtn'] == "Login"))
  {
    $user_to_login = getCommentByID($_POST['user_to_login']);
    #var_dump($friend_info_to_update);
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
  commentID:
    <input type="text" class="form-control" name="commentID" required 
      value="<?php if ($class_info_to_update !=null) echo $class_info_to_update['commentID'];?>"
    />  
    </div> 
    <div class="row mb-3 mx-3">    
    studentID:
    <input type="text" class="form-control" name="studentID" required 
    value="<?php if ($class_info_to_update !=null) echo $class_info_to_update['studentID'];?>"
    /> 
    </div>
    <div class="row mb-3 mx-3">  
    date_posted:
    <input type="text" class="form-control" name="date_posted" required 
    value="<?php if ($class_info_to_update !=null) echo $class_info_to_update['date_posted'];?>"
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
  <input type="submit" class="btn btn-primary" name="actionBtn" value="Add comment" title="click to insert comment"/> 
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
    <th width="30%">commentID</th>        
    <th width="30%">date_posted</th> 
    <th width="30%">content</th> 
    <th>Update?</th>
    <th>Delete?</th>
  </tr>
  </thead>
<?php foreach ($comments as $item): ?>
  <tr>
     <td><?php echo $item['studentID']; ?></td>
     <td><?php echo $item['commentID']; ?></td>
     <td><?php echo $item['date_posted']; ?></td>        
     <td><?php echo $item['content']; ?></td>
     <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Update" class="btn btn-dark" />
        <input type="hidden" name="comment_to_update" value="<?php echo $item['commentID'];?>" />
      </form>
    </td>    
    <td>
      <form action="simpleform.php" method="post">
        <input type="submit" name="actionBtn" value="Delete" class="btn btn-danger" />
        <input type="hidden" name="comment_to_delete" value="<?php echo $item['commentID'];?>" />
      </form>
    </td>                   
  </tr>
<?php endforeach; ?>
</table>
</div>     
</body>
</html>