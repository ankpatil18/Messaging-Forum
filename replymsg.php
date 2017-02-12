<?php require('includes/config.php'); 
require('layout/header.php');
 require('navbar.php');
require ('dbconnection.php');  



$_Session['MessageID'] = trim($_GET['messageID']);
 $messageID = trim($_GET['messageID']);
 $username = $_SESSION['username'];

 echo "outside post";
 if(isset($_POST['msg'])){
echo "in post";
 $body = $_POST['msg'];
$stmt1=$link->prepare("insert into msgreply (replymsgID,messageID,author,createdOn,body) values(NULL,'$messageID','$username',now(),'$body')");
$stmt1->execute(); 


}

?>
<html>
<head>
 <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>

<form  method="post" action="replymsg.php?messageID=" autocomplete="off" onsubmit="location.href = this.action + this.messageID.value; return false;" >
			<div class="container">
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<input type='hidden' value='<?php echo $_Session['MessageID']; ?>' id='messageID' name='messageID' ></input>
			<div class="form-group">
			<?php
			 require ('replymessage.php');
			?>
			</div>
			
			<div class="form-group">
					
			<input type="text" name="msg" id="msg" class="form-control input-lg" placeholder="Enter a message">
			</div>
			<div class="row">
				<div class="col-xs-6 col-md-6"><input type="submit" name="submit"  id="submit" value="submit" class="btn btn-primary btn-block btn-lg" ></div>
			</div>
			
			</div>
		</div>
</form>

</body>

</html>