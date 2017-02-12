<?php require('includes/config.php'); 
require('layout/header.php');
 require('navbar.php');  ?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include "dbconnection.php";


if(!isset($_POST['Update']))
{
	
		$username = $_SESSION['username'];
		
		
					$stmt1=$link->prepare("Select contactNumber,description,image from userprofile where username='$username' ");
					$stmt1->execute();
					$stmt1->bind_result($contactNumber1,$description1,$content1);
					$stmt1->store_result();
						if($stmt1->num_rows() >0)
						{ 
							while ($stmt1->fetch()) {
							$_SESSION['contactNumber']	= $contactNumber1;
							$_SESSION['description'] = $description1;
							$_SESSION['image']= $content1;
		
							
							}
						}

}


if(isset($_POST['Update']) && $_FILES['Userimage']['size'] > 0)
{
	$_SESSION['post_data'] = $_POST;
	
	$fileName = $_FILES['Userimage']['name'];
	$tmpName  = $_FILES['Userimage']['tmp_name'];
	$fileSize = $_FILES['Userimage']['size'];
	$fileType = $_FILES['Userimage']['type'];

		
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
$_SESSION['imageUpdate'] = $content;
	
	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}
		$username = $_SESSION['username'];
		$contactNumber = $_POST['contactNumber'];
		$description = $_POST['description'];

					$stmt1=$link->prepare("Select username from userprofile where username='$username' ");
					$stmt1->execute();
					$stmt1->bind_result($username1);
					$stmt1->store_result();
						if($stmt1->num_rows() >0)
						{
							$stmt3=$con->prepare("Update userprofile set contactNumber='$contactNumber' , description='$description', image= '$content' , image_size='$fileSize', image_name='$fileName' where username='$username'");
							$stmt3->execute();
							
						}
					else
						{
							$stmt2=$link->prepare("Insert into userprofile(username,contactNumber,description,image_size,image_name,image) values ('$username','$contactNumber','$description','$fileSize','$fileName','$content')") ;
							$stmt2->execute();
					
						}
						
						
header("Location: updateprofile.php?action=upadtedProfile");
	
echo 'Profile Updated';

} 
        
if(isset($_POST['Update']))
{
	$_SESSION['post_data'] = $_POST;
	
		$username = $_SESSION['username'];
		$contactNumber = $_POST['contactNumber'];
		$description = $_POST['description'];

					$stmt1=$link->prepare("Select username from userprofile where username='$username' ");
					$stmt1->execute();
					$stmt1->bind_result($username1);
					$stmt1->store_result();
						if($stmt1->num_rows() >0)
						{
							$stmt3=$con->prepare("Update userprofile set contactNumber='$contactNumber' , description='$description' where username='$username'");
							$stmt3->execute();
							
						}
					else
						{
							$stmt2=$link->prepare("Insert into userprofile(username,contactNumber,description) values ('$username','$contactNumber','$description')") ;
							$stmt2->execute();
					
						}

header("Location: updateprofile.php?action=upadtedProfile");
echo 'Profile Updated';

	
}			
				
		

?>



<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="updateprofile.php" autocomplete="off" enctype="multipart/form-data">
				<div class="form-group">
				<label class="control-label">Select File</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="99999999" />
				<input id="Userimage" type="file" name='Userimage' class="file">
    			</div>
				<div class="form-group" id="putImage">
				<img  style="z-index: -1;" width="175" height="200" src="data:image/jpeg;base64,<?php if(isset($content)){echo base64_encode( $content );} else { echo base64_encode( $_SESSION['image'] );} ?>" />

				</div>
				<div class="form-group">
					<input type="text" name="contactNumber" id="contactNumber" class="form-control input-lg" placeholder="contactNumber" value="<?php if(isset($_SESSION['post_data']['contactNumber'])) {echo $_SESSION['post_data']['contactNumber'];} else { if(isset($_SESSION['contactNumber'])) echo $_SESSION['contactNumber'] ;}  ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="text" name="description" id="description" class="form-control input-lg" placeholder="Bio" value="<?php if(isset($_SESSION['post_data']['description'])) {echo $_SESSION['post_data']['description'];} else { if(isset($_SESSION['description'])) echo $_SESSION['description'];} ?>" tabindex="2">
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="Update" id='Update' value="Update" class="btn btn-primary btn-block btn-lg" tabindex="7" ></div>
				</div>
				
			
			</form>
		</div>
	</div>
</div>

</body>


</html>
<?php
//include header template
require('layout/footer.php');
?>

