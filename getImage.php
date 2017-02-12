<?php require('includes/config.php'); 
require ('dbconnection.php');
	// echo "call made";

 $username =$_SESSION['username'];

// $stmt=$link ->prepare("SELECT image FROM userprofile WHERE username=$username");
// $stmt->execute();
// $stmt->bind_result($image);
// $stmt1->store_result();
// if($stmt1->num_rows() >0)
// {
	// while ($stmt1->fetch()) 
	// {
		// header("Content-type: image/jpeg");
		// echo $image;
		// echo "call made inside";
			
							
	// }
	 
	





  
  $sql = "SELECT image FROM userprofile WHERE username=$username";
  $result = mysql_query("$sql");
  $row = mysql_fetch_assoc($result);
  mysql_close($link);

  header("Content-type: image/jpeg");
  echo $row['image'];

 


 ?>