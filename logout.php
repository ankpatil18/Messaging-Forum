<?php require('includes/config.php');
require ('dbconnection.php');

//logout
$username = $_SESSION['username'];
if($stmt=$link->prepare("Call spLoggedOUt('$username')"))
		{
			$stmt->execute();
		
		}
		
$user->logout();
//logged in return to index page
header('Location: index.php');
exit;
?>