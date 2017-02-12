<?php 
require('includes/config.php');
require('layout/header.php');
 require('navbar.php');
require('dbconnection.php');
?>
<html>
    
<head>
<link rel="stylesheet" type="text/css" href="Stylesheet.css">
</head>
   
<body>
<?php
$usr=$_SESSION['username'];

$stmt61=$con->prepare("Select mem1,timesent from notifications where receiver='$usr' and type='frapp'");

$stmt61->execute();

$stmt61->bind_result($dusr61,$rtime61);

$stmt61->store_result(); 
    
echo "<table border = '1' class='tablecss'>\n";
echo "<tr><td>Notifications</td><td>Time</td></tr>";
    
if($stmt61->num_rows() >0)
      {
							
							
							while ($stmt61->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo "$dusr61 approved your friend request" ;
								    echo "</td>";
                                    echo "<td>";
									echo $rtime61;
								    echo "</td>";
									echo "</tr>";
								
							
				       }
      }
    
             

    
$stmt62=$con->prepare("select mem1,timesent from notifications where receiver='$usr' and type='frreq'");
$stmt62->execute();
$stmt62->bind_result($dusr62,$rtime62);
$stmt62->store_result();
    
    if($stmt62->num_rows() >0)
      {
							
							
							while ($stmt62->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo "$dusr62 sent you a friend request &nbsp;";
                                    echo "<a href='http://localhost/project-master/addmem.php?approve=$dusr62'>";
                                    echo '<button type="button" class="btn btn-danger btn-xs">Accept Request</button>';
									echo "</a>";	
                                
								    echo "</td>";
                                    echo "<td>";
									echo $rtime62;
								    echo "</td>";
									echo "</tr>";
								
							
				       }
      }

    
$stmt63=$con->prepare("select mem1,timesent from notifications where receiver='$usr' and type='aneigh'");
$stmt63->execute();
$stmt63->bind_result($dusr63,$rtime63);
$stmt63->store_result();
        if($stmt63->num_rows() >0)
      {
							
							
							while ($stmt63->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo "$dusr63 added you as a neighbour" ;
								    echo "</td>";
                                    echo "<td>";
									echo $rtime63;
								    echo "</td>";
									echo "</tr>";
								
							
				       }
      }

    
    
    
$stmt64=$con->prepare("select mem1,timesent from notifications where receiver='$usr' and type='bapp'");
$stmt64->execute();
$stmt64->bind_result($dusr64,$rtime64);
$stmt64->store_result();
    
    if($stmt64->num_rows() >0)
      {
							
							
							while ($stmt64->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo "$dusr64 approved you to join the block" ;
								    echo "</td>";
                                    echo "<td>";
									echo $rtime64;
								    echo "</td>";
									echo "</tr>";
								
							
				       }
      }
   
?>
                    
                    
                    
</body>
</html>