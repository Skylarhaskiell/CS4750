
<?php 

$search = $_POST['search'];
$sql = "select * from class where classCode like '%$search%'";
$result = $conn->query($sql);
if ($result->num_rows > 0){
while($row = $result->fetch_assoc() ){
  echo $row["classCode"]."  ".$row["age"]."  ".$row["gender"]."<br>";
}
} else {
  echo "0 records";
}

$conn->close();

?>