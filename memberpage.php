<?php require('includes/config.php'); 
require('layout/header.php');
 require('navbar.php');
require ('dbconnection.php'); ?>
 
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>

<?php
//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); } 

//define page title
$title = 'Members Page';


if(isset($_POST['Refresh']))
{
	
	
	
}

?>

<div class="container">
		
			<form role="form" method="post" action="memberpage.php" autocomplete="off" >
			<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<div class="form-group">
			<div class="form-group">
			 <input type="text" name="searchString" id="searchString"  style='float:left' class="form-control input-lg" placeholder="Search" >
			</div>
			
			<div class="row col-xs-6 col-xs-6">
			<label for="sel">Search Prefrence</label>
						<select class="form-control" style='float:right' name="searchSelect" id="searchSelect">
								<option value="2" >-- Search --</option>
								<option value="0" >Search By Title</option>
								<option value="1" >Search By Body</option>
						</select>
			
			<input class="btn btn-primary btn-block btn-lg" style='float:left' type='submit' name='Refresh' id='Refresh' value='Refresh' ></input>
			</div>
			<div class="row col-xs-6 col-md-6">
			<div id='feed' style='float:right'>
					<div class="form-group">
						<label for="sel1">Select your feed</label>
						<select class="form-control" name="feedSelect" id="feedSelect">
								<option value="0" >-- select --</option>
								<option value="6" >show all feed</option>
								<option value="3" >show friends feed</option>
								<option value="4" >show neighbour feed</option>
								<option value="1" >show block feed</option>
								<option value="2" >show hood feed</option>
								<option value="5" >show private feed</option>
							
						</select>
					</div>
					
			</div>
			</div>
			</div>
			<div id="message" >		
					<?php
					if(!isset($_POST['Refresh']))
					{
	
						require('showallfeed.php');
						
					}
				
				if(isset($_POST['Refresh']))
				{
					
					if( ( $_POST['feedSelect'] == 6  ) and isset($_POST['Refresh']) )
					{
						
						require('showallfeed.php');
						
						
					}	
					if($_POST['feedSelect'] == 1 and isset($_POST['Refresh']))
					{
						require('showblockfeed.php');
						
					}
					if($_POST['feedSelect'] == 2 and isset($_POST['Refresh']))
					{
						require('showhoodfeed.php');
						
					}
					if($_POST['feedSelect'] == 4 and isset($_POST['Refresh']))
					{
						require('showneighbourfeed.php');
						
					}
					if($_POST['feedSelect'] == 3 and isset($_POST['Refresh']))
					{
						require('showfriendfeed.php');
						
					}
					if($_POST['feedSelect'] == 5 and isset($_POST['Refresh']))
					{
						require('showprivatefeed.php');
						
					}
					if($_POST['searchSelect'] == 0 and isset($_POST['Refresh']) )
					{
						require('searchbytitle.php');
						
					}
					if($_POST['searchSelect'] == 1 and isset($_POST['Refresh']) )
					{
						require('searchbybody.php');
						
					}
					
					
					
					
					
					
			
					
					
					
				}


					
					
					?>
					
					
			</div>
			
			</form>
		
	
</div>
			
</form>
</body>
<?php 
//include header template
require('layout/footer.php'); ?>

</html>
