<?php require('includes/config.php'); 
require('layout/header.php');
 require('navbar.php');
require('dbconnection.php');
?>
 
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="Stylesheet.css">

  
</head>
<body>
    

<div class="container">
    
  <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Filter
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
         <li><a href="http://localhost:8888/addmem.php?show=1"> Friends</a></li>
         <li><a href="http://localhost:8888/addmem.php?show=2"> Neighbours</a></li>
         <li><a href="http://localhost:8888/addmem.php?show=3"> People in my Neighbourhood</a></li>
         <li><a href="http://localhost:8888/addmem.php?show=4">People in my Block</a></li>
         <li><a href="http://localhost:8888/addmem.php?show=5">Show All</a></li>
    </ul>
            <button type="button" class="btn btn-primary">Show</button>

 </div>
    
    <div>
    <?php
    $usr=$_SESSION['username'];
    $choice=trim($_GET['show']);
  
    if(!empty($choice))
    {

       if($choice==1)
       {

        $stmt=$link->prepare("call spShowAllFriends('$usr')");
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        if($stmt->num_rows() >0)
						{
							
							echo "<table border = '1' class='tablecss'>\n";
                            echo "<tr><td>Friends</td></tr>";
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
									echo "</tr>";
								
							
							      }
                         }
        
    
						
    }
        
    if($choice==2)
       {

        $stmt=$link->prepare("call spShowAllNeighbour('$usr')");
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        if($stmt->num_rows() >0)
						{
							
							echo "<table border = '1' class='tablecss'>\n";
                            echo "<tr><td>Neighbours</td></tr>";
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
									echo "</tr>";
								
							
							      }
                         }
        
    
						
    }    
        
    if($choice==3)
       {

        $stmt=$link->prepare("Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr')))");
    $stmt2=$db->prepare("Select username from blockmembership where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))) and username not in(Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))))");
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        $stmt2->execute();
        echo 4;
        $stmt2->bind_result($dusr2);
        echo 4;
        $stmt2->store_result();
        echo 4;
        echo $stmt2->num_rows();
        if($stmt->num_rows() >0)
						{
							
							echo "<table border = '1' class='tablecss'>\n";
                            echo "<tr><td>Neighbours</td></tr>";
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
									echo "</tr>";
								
							
							      }
                        /*  while ($stmt2->fetch()) {
                            echo "<table border = '1' class='tablecss'>\n";
                            echo "<tr><td>Neighbours who need approval</td><td>Actions required</td></tr>";
									echo "<tr>";
									echo "<td>";
									echo $dusr2 ;
									echo "</td>";
									echo "<td>";
									echo "<button type="button" class="btn btn-danger">Approve</button>";
									echo "</td>";
									echo "</tr>";
								
							
							      }
            */
                         }
        
    
						
    }        
        
        
    
    
        
     }
    
    
    ?>

</div>
    



</div>

</body>
<?php 
//include header template
require('layout/footer.php'); ?>

</html>
