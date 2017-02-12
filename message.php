<?php require('includes/config.php'); 
require('layout/header.php');
require('navbar.php');
require ('dbconnection.php')  ?>
<html>
<head>
<script type="text/javascript">
$(document).ready(function() {
    document.getElementById('groupDiv').style.display = 'none';
	document.getElementById('privateDiv').style.display = 'none';
		
		
});

function validate() {
    if (document.getElementById('1').checked == true) {
        document.getElementById('groupDiv').style.display = 'none';
		document.getElementById('privateDiv').style.display = 'block';


		

    }
    else if (document.getElementById('2').checked == true) {
       document.getElementById('groupDiv').style.display = 'block';
		document.getElementById('privateDiv').style.display = 'none';
    }
 }	


</script>
</head>
<?php 
if(isset($_POST['Post']))
{
 echo $_POST['groupSelect']; 
  
  
  
	$username = $_SESSION['username'];
	$title = $_POST['title'];
	$body = $_POST['messageBody'];
	if(isset($_POST['groupSelect']) and $_POST['groupSelect']!=0 ){
			$visibiltyStatus = $_POST['groupSelect'];
			$viewusername =null;
			echo $visibiltyStatus;
			
	}
	else if(isset($_POST['viewusername'])){
		$visibiltyStatus = 5;
		$viewusername= $_POST['viewusername'];
		echo $visibiltyStatus;
	}
		
		
					$stmt1=$link->prepare("call spMessageThread('$username','$title','$body','$visibiltyStatus','$viewusername') ");
					$stmt1->execute();
					
			
					
	
	
}


?>
<body>


<div class="container">
		<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="message.php" autocomplete="off" >
			<div class="form-group">
			
				<div class="radio">
				<label><input type="radio" name="optradio" id='1' onClick="validate();">Create a private post </label>
				</div>
				<div class="radio">
				<label><input type="radio" name="optradio" id='2' onClick="validate();">Create a group post</label>
				</div>
			<div id='msg'>
			<div class="form-group">
					<input type="title" name="title" id="title" class="form-control input-lg" placeholder="Enter a title" value="<?php if(isset($error)){ echo $_POST['title']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input style="height:100px;width=100%"  type="Mesaagebody" name="messageBody" id="messageBody" class="form-control input-lg" placeholder="Type in Message" value="<?php if(isset($error)){ echo $_POST['messageBody']; } ?>" tabindex="2">
				</div>
			</div>
			
			<div id='privateDiv'>
					<input type="viewusername" name="viewusername" id="viewusername" class="form-control input-lg" placeholder="Enter a username to whom post should be visible" value="<?php if(isset($error)){ echo $_POST['viewusername']; } ?>" tabindex="3">
			</div>
			<div id='groupDiv'>
					<div class="form-group">
						<label for="sel1">Select your post Visibility</label>
						<select class="form-control" name="groupSelect" id="groupSelect">
								<option value="0" >--- Select ---</option>
								<option value="3" >show friends</option>
								<option value="4" >show neighbour</option>
								<option value="1" >show block</option>
								<option value="2" >show hood</option>
						</select>
					</div>
					
			</div>
		
			<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="Post"  id="Post" value="Post" class="btn btn-primary btn-block btn-lg" tabindex="4"></div>
			</div>
			
			</div>
			
			</form>
		
	</div>
</div>

</body>
</html> 
 