<?php 
require('includes/config.php');
require('dbconnection.php');

?>
<html>
<body>
<head>
<style>
  #map_canvas {
        width: 400px;
        height: 600px;
		background-color: #CCC;
		float:left;
		margin-left:20px;
		margin-top:10px;
      }
    </style>


<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
var hood;
function initialize(){
    
var map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 13,
    center: new google.maps.LatLng(40.749726, -73.995285),
    mapTypeId: google.maps.MapTypeId.TERRAIN
});
    

var rectangle = new google.maps.Rectangle({
    strokeColor: '#002288',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#333322',
    fillOpacity: 0.35,
    map: map,
    bounds: new google.maps.LatLngBounds(
        new google.maps.LatLng(40.759674,-73.995492),
    new google.maps.LatLng(40.764363,-73.977264)
    )
});

var rectangle1 = new google.maps.Rectangle({
    strokeColor: '#ff3300',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#333322',
    fillOpacity: 0.35,
    map: map,
    bounds: new google.maps.LatLngBounds(
       new google.maps.LatLng(40.754798, -73.995886),
    new google.maps.LatLng(40.758959, -73.977175)
        
    )
});
    
var rectangle2 = new google.maps.Rectangle({
    strokeColor: '#00cc00',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#333322',
    fillOpacity: 0.35,
    map: map,
    bounds: new google.maps.LatLngBounds(
        new google.maps.LatLng(40.747645, -73.995714),
    new google.maps.LatLng(40.754147, -73.977432)
        
    )
});
    
var myMarker = new google.maps.Marker({
    position: new google.maps.LatLng(40.756098, -73.973741),
    draggable: true
});

google.maps.event.addListener(myMarker, 'dragend', function (evt) {
    
    
    
    document.getElementById('current').innerHTML = '<input type="latitude" name="latitude" class="form-control input-lg" placeholder="Latitude" value=' + evt.latLng.lat().toFixed(6) + '></input>'
		document.getElementById('current1').innerHTML ='<input type="longitude" name="longitude" class="form-control input-lg" placeholder="Longitude"  value=' + evt.latLng.lng().toFixed(6) +  '></input>'
        
    var bound_a = new google.maps.LatLngBounds(
    new google.maps.LatLng(40.759674,-73.995492),
    new google.maps.LatLng(40.764363,-73.977264)
);
    
var bound_b = new google.maps.LatLngBounds(
    new google.maps.LatLng(40.754798, -73.995886),
    new google.maps.LatLng(40.758959, -73.977175)
);
    
    
var bound_c = new google.maps.LatLngBounds(
    new google.maps.LatLng(40.747645, -73.995714),
    new google.maps.LatLng(40.754147, -73.977432)
);
    
    var in_a = bound_a.contains(new google.maps.LatLng(evt.latLng.lat().toFixed(6),evt.latLng.lng().toFixed(6)));
    var in_b = bound_b.contains(new google.maps.LatLng(evt.latLng.lat().toFixed(6),evt.latLng.lng().toFixed(6)));
    var in_c = bound_c.contains(new google.maps.LatLng(evt.latLng.lat().toFixed(6),evt.latLng.lng().toFixed(6)));
    
    

    if(in_a)
        {
             document.getElementById('current2').innerHTML = '<a>This locoation belongs to hood1</a>';
			document.getElementById("submit").disabled = false;
            document.getElementById("hood1").style.display = "block";
            document.getElementById("hood2").style.display = "none";
            document.getElementById("hood3").style.display= "none";
          
            
       
            /* var hello ="//
              
            //$stmt=$link->prepare('Select blockID,blockname from blocks where hoodID=1');
            //$stmt->execute();
            //$stmt->bind_result($blockID,$bname);
            /*while ($stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>$bname</td><td><input type='radio' name='inp' value='$bname' /></td>";
                        echo "</tr>\n";
                            }
                    echo "</table>";
            
            
            
            ?>"; */
        }
    else if(in_b)
        {
            document.getElementById('current2').innerHTML = '<a>This locoation belongs to hood2</a>';
            document.getElementById("submit").disabled = false;
            document.getElementById("hood2").style.display = "block";
            document.getElementById("hood1").style.display = "none";
            document.getElementById("hood3").style.display= "none";
           


        }
    else if(in_c)
        {
            document.getElementById('current2').innerHTML = '<a>This locoation belongs to hood3</a>';
            document.getElementById("submit").disabled = false;
            document.getElementById("hood3").style.display = "block";
            document.getElementById("hood2").style.display = "none";
            document.getElementById("hood1").style.display= "none";


        }
     else
         {
            document.getElementById('current2').innerHTML = '<a>Service not available in this location cannot register</a>';
            document.getElementById("submit").disabled = true;
            document.getElementById("hood1").style.display = "none";
            document.getElementById("hood2").style.display = "none";
            document.getElementById("hood3").style.display= "none";
         }
		 
		
		
		
});

google.maps.event.addListener(myMarker, 'dragstart', function (evt) {
    document.getElementById('current').innerHTML = '<p>Currently dragging marker...</p>';
});

map.setCenter(myMarker.position);
myMarker.setMap(map);
};

google.maps.event.addDomListener(window, 'load', initialize);
  
</script>
    

</head>
<?php 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM user WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT emailID FROM user WHERE emailID = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO user (username,password,emailID,active,firstname,lastname,createdOn,updatedOn,DOB,addlatitude,addlongitude) VALUES (:username, :password, :emailID, :active, :firstName, :lastName, now() , now(), :DOB, :lat, :long)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':emailID' => $_POST['email'],
				':active' => $activasion,
				':firstName' =>  $_POST['firstName'],
				':lastName' => $_POST['lastName'],
				':DOB' =>  $_POST['DOB'],
				':lat' => $_POST['latitude'],
				':long' => $_POST['longitude']				
				
			));
            
            
           
            
            
            
            $stmt = $db->prepare('INSERT INTO blockmembership (username,blockID,requestcounter) VALUES (:username, :blockID,0)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':blockID' => $_POST['inp']				
			));
            $block=$_POST['inp'];
             $stmt = $link->prepare("select count(*) from member where blockID= '$block'");
			$stmt -> execute();             
			$stmt->bind_result($reqcount);

			if($stmt->fetch())
            {

            
            if($reqcount < 3)
            {
            $stmt = $db->prepare('INSERT INTO member (username,blockID,joined) VALUES (:username, :blockID,now())');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':blockID' => $_POST['inp']				
			));
            }
            
            }
            
			$id = $_POST['username'];
			
			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at demo site.</p>
			<p>To activate your account, please click on this link: <a href='".localpath."activate.php?x=$id&y=$activasion'>".localpath."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();
             
           echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account </h2>";
			//redirect to index page
			//header("Location: index.php?action=joined");
			//exit();

		//else catch the exception and show the error.
		} 
        
        catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Demo';

//include header template
require('layout/header.php');
?>


<div class="container" style="float:right; margin-left:0px; width:60%">

	<div class="row">

	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Please Sign Up</h2>
				<p>Already a member? <a href='login.php'>Login</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account </h2>";
				}
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
				</div>
				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
				</div>
				<div class="form-group">
					<input type="firstName" name="firstName" id="firstName" class="form-control input-lg" placeholder="FirstName" value="<?php if(isset($error)){ echo $_POST['firstName']; } ?>" tabindex="3">
				</div>
				<div class="form-group">
					<input type="lastName" name="lastName" id="lastName" class="form-control input-lg" placeholder="LastName" value="<?php if(isset($error)){ echo $_POST['lastName']; } ?>" tabindex="4">
				</div>
				<div class="form-group">
					<input type="DOB" name="DOB" id="DOB" class="form-control input-lg" placeholder="DOB" value="<?php if(isset($error)){ echo $_POST['DOB']; } ?>" tabindex="4">
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="5">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="6">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<div id="current"></div>
						</div>
					</div>
            
               
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<div id="current1"></div>
						</div>
					</div>
                    </div>
                    <div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<div id="current2"></div>
						</div>
					</div>
					
				</div>
                <div class="row">
                 <?php
                
                  echo "<div class='col-xs-12 col-sm-12 col-md-12'>";
                echo "<div class='form-group'>";
                
                
                echo "<div id='hood1'>";    
                $stmt = $link->prepare("SELECT blockname,blockID FROM blocks WHERE hoodID=1");
                $stmt->execute();
                $stmt->bind_result($bname,$blockID);
                echo '<p>Please select the block that you want to join<p>';
                echo '<table class="table table-bordered">';
                while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>";
                echo $bname;
                echo "</td>";
                echo "<td><input type='radio' name='inp' value=$blockID/></td>";
                echo "</tr>\n";
                }
               echo "</table>";  
                echo "</div>";
                    
                    
                     echo "<div id='hood2'>";    
                $stmt = $link->prepare("SELECT blockname,blockID FROM blocks WHERE hoodID=2");
                $stmt->execute();
                $stmt->bind_result($bname,$blockID);
                echo '<p>Please select the block that you want to join<p>';
                echo '<table class="table table-bordered">';
                while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>";
                echo $bname;
                echo "</td>";
                echo "<td><input type='radio' name='inp' value=$blockID /></td>";
                echo "</tr>\n";
                }
               echo "</table>";  
                echo "</div>";
                    
                    
                    
                       echo "<div id='hood3' >";    
                $stmt = $link->prepare("SELECT blockname,blockID FROM blocks WHERE hoodID=3");
                $stmt->execute();
                $stmt->bind_result($bname,$blockID);
                echo '<p>Please select the block that you want to join<p>';
                echo '<table class="table table-bordered">';
                while ($stmt->fetch()) {
                echo "<tr>";
                echo "<td>";
                echo $bname;
                echo "</td>";
                echo "<td><input type='radio' name='inp' value=$blockID /></td>";
                echo "</tr>\n";
        
                }
               echo "</table>";  
                echo "</div>";
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                echo "</div>";
                echo "</div>";
              
                ?>
               
                </div>   
                    
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit"  id="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="7"></div>
				</div>
                    </div>
                </div>
				</div>
			</form>
    
    
    
		</div>
	</div>
<div id='map_canvas'></div>
</div>



<?php
//include header template
require('layout/footer.php');
?>
<script>
document.getElementById("hood1").style.display = "none";
document.getElementById("hood2").style.display = "none";
document.getElementById("hood3").style.display = "none";
</script>

</body>
</html>