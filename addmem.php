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
         <li><a href="addmem.php?show=1"> Friends</a></li>
         <li><a href="addmem.php?show=2"> Neighbours</a></li>
         <li><a href="addmem.php?show=3"> People in my Neighbourhood</a></li>
         <li><a href="addmem.php?show=4">People in my Block</a></li>
         <li><a href="addmem.php?show=5">Show all people in other Neighbourhood</a></li>
    </ul>
 </div>
    
    <div>
    <?php
    $usr=$_SESSION['username'];
	if(isset($_GET['show']))
	{
    $choice=trim($_GET['show']);
	}
	if(isset($_GET['approve']))
	{
     $frapproval=trim($_GET['approve']);
	}
   if(isset($_GET['afriend']))
	{
     $addfriend=trim($_GET['afriend']);
	}
   if(isset($_GET['aneigh']))
	{
     $addneigh=trim($_GET['aneigh']);
	}
   if(isset($_GET['bmemapprove']))
   {
	   $bmemapp=trim($_GET['bmemapprove']);
   }
   
    
        
	
        if(!empty($_GET['approve']))
        {
        $stmt1=$con->prepare("update friends set status='approved' where username2='$usr' and username1='$frapproval'");
        $stmt1->execute();
        
        $stmt6=$con->prepare("insert into notifications values('$usr','$frapproval','frapp',now())");
        $stmt6->execute();
        
            
        echo "<h1>";
        echo "$frapproval has been accepted to be a friend";
        echo "<h1>";

        }
        
        
        
        if(!empty($_GET['afriend']))
        {
            $stmt2=$con->prepare("Insert into friends values(null,'$usr','$addfriend','pending')");
            $stmt2->execute();
            
            $stmt7=$con->prepare("Insert into notifications values('$usr','$addfriend','frreq',now())");
            $stmt7->execute();
            
            echo "<h1>";
            echo "Friend request sent to $addfriend";
            echo "<h1>";

        }
        
        if(!empty($_GET['aneigh']))
        {
            $stmt3=$con->prepare("Insert into neighbour values('$usr','$addneigh')");
            $stmt3->execute();
            
            
            $stmt8=$con->prepare("insert into notifications values('$usr','$addneigh','aneigh',now())");
            $stmt8->execute();
            echo "<h1>";
            echo "$addneigh added as a neighbour";
            echo "<h1>";

        }
        
        if(!empty($_GET['bmemapprove']))
        {
			$smst=$con->prepare("Select requestcounter from blockmembership where username='$bmemapp'");
			$smst->execute();
			$smst->bind_result($req);
			while($smst->fetch())
			{
				$counter=$req;
				
				$counter=$counter + 1;
				echo $counter;
			}
			
          $stmt6=$con->prepare("update blockmembership set requestcounter='$counter' where username='$bmemapp' ");
            $stmt6->execute();
            
            $stmt9=$con->prepare("insert into notifications values('$usr','$bmemapp','bapp',now())");
            $stmt9->execute();
        
            echo "<h1>";
            echo "you approved $bmemapp to join the block";
            echo "<h1>";

        }
        
   
       $stmt4=$link->prepare("Select blockID from member where username ='$usr'");
        $stmt4->execute();
        $stmt4->bind_result($bid);
        $stmt4->store_result();
        $stmt4->fetch();
        
        $stmt5=$link->prepare("Select hoodID from blocks where blockID ='$bid'");
        $stmt5->execute();
        $stmt5->bind_result($hid);
        $stmt5->store_result();
        $stmt5->fetch();
       
        
    if(!empty($choice))
    {

       if($choice==1)
       {

        $stmt=$link->prepare("call spShowAllFriends('$usr')");
        
        
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
           
        echo "<table border = '1' class='tablecss'>\n";
        echo "<tr><td>Friends</td><td>Status</td></tr>";
        
        
        if($stmt->num_rows() >0)
						{
							
							
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
                                    echo "<td>";
                                    echo "<p>Approved<p>";
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
                         
                          }
        $stmt1=$con->prepare("Select username2 from friends where username1='$usr' and status='pending'");
        $stmt1->execute();
        $stmt1->bind_result($dusr1);
        $stmt1->store_result();

    
        if($stmt1->num_rows() >0)
        {
            while ($stmt1->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr1;
									echo "</td>";
                                    echo "<td>";
                                    echo "<p>Request sent awaiting approval<p>";
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
        }
        
        $stmt2=$con->prepare("select username1 from friends where username2='$usr' and status='pending'");
        $stmt2->execute();
        $stmt2->bind_result($dusr2);
        $stmt2->store_result();

        if($stmt2->num_rows() >0)
        {
            while ($stmt2->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr2;
									echo "</td>";
                                    echo "<td>";
                                    echo "<a href='http://localhost/project-master/addmem.php?approve=$dusr2'>";
                                    echo '<button type="button" class="btn btn-danger">Accept Request</button>';
									echo "</a>";	
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
Select blockid from member where username = '$usr'))) and username not in(Select username2 from friends where username1='$usr' )
and username not in(Select username1 from friends where username2='$usr') and username not in(Select username2 from neighbour where username1='$usr') and username <> '$usr'");
        
        $stmt2=$link->prepare("Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))) and (username in(Select username2 from friends where username1='$usr' )
or username  in(Select username1 from friends where username2='$usr')) and username not in (Select username2 from neighbour where username1='$usr') and username <> '$usr'");
        
        $stmt3=$link->prepare("Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))) and (username not in(Select username2 from friends where username1='$usr' )
and username  not in(Select username1 from friends where username2='$usr')) and username in(Select username2 from neighbour where username1='$usr') and username <> '$usr'");
        
         $stmt41=$link->prepare("Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))) and (username in(Select username2 from friends where username1='$usr' )
or username  in(Select username1 from friends where username2='$usr')) and username in (Select username2 from neighbour where username1='$usr') and username <> '$usr'");
        
        
        
        
   /* $stmt2=$link->prepare("Select username from blockmembership where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))) and username not in(Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$usr'))))");*/
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        echo "<table border = '1' class='tablecss'>\n";
        echo "<tr><td>Members in Hood</td><td>Send Requests</td></tr>";
       
        if($stmt->num_rows() >0)
						{
							
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
                                    echo "<td>";  
                        echo "<a href='http://localhost/project-master/addmem.php?afriend=$dusr'>";
                        echo '<button type="button" class="btn btn-success" >Add as Friend</button>&nbsp';
                        echo "</a>";
                                    echo "<a href='http://localhost/project-master/addmem.php?aneigh=$dusr'>";
                                    echo '<button type="button" class="btn btn-success">Add as Neighbour</button>';
									echo "</a>";
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
        }
       
        
        $stmt2->execute();
        $stmt2->bind_result($dusr2);
        $stmt2->store_result();
        if($stmt2->num_rows() >0)
        {
                             
                           while ($stmt2->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr2 ;
									echo "</td>";
									echo "<td>";
                        echo '<button type="button" class="btn btn-danger" disabled>Already a Friend</button>&nbsp';
                                    echo "<a href='http://localhost/project-master/addmem.php?aneigh=$dusr2'>";
                                    echo '<button type="button" class="btn btn-success">Add as Neighbour</button>';
									echo "</a>";									
                                     echo "</td>";
									echo "</tr>";
								
							
							      }
        }
        
        
         $stmt3->execute();
        $stmt3->bind_result($dusr3);
        $stmt3->store_result();
        if($stmt3->num_rows() >0)
        {
             while ($stmt3->fetch()) {
             echo "<tr>";
             echo "<td>";
             echo $dusr3 ;
             echo "</td>";
             echo "<td>";
             echo "<a href='http://localhost/project-master/addmem.php?afriend=$dusr3'>";
             echo '<button type="button" class="btn btn-success" >Add as Friend</button>&nbsp';
             echo "</a>";             
             echo '<button type="button" class="btn btn-danger" disabled>Already a Neighbour</button>';
             echo "</td>";
             echo "</tr>";
             }
        
        
        }
        
         $stmt41->execute();
        $stmt41->bind_result($dusr41);
        $stmt41->store_result();
        
        if($stmt41->num_rows() >0)
        {
             while ($stmt41->fetch()) {
             echo "<tr>";
             echo "<td>";
             echo $dusr41 ;
             echo "</td>";
             echo "<td>";
             echo '<button type="button" class="btn btn-danger" disabled>Request already sent</button>';
             echo '<button type="button" class="btn btn-danger" disabled>Already a Neighbour</button>';
             echo "</td>";
             echo "</tr>";
             }
        
        
        }

        
       
						
    } 
        
        
    if($choice==4)
    {
$stmt=$link->prepare("Select username from member where blockID = '$bid' and username <> '$usr' 
 and (username not in(Select username2 from friends where username1='$usr' )
and username  not in(Select username1 from friends where username2='$usr')) and username not in(Select username2 from neighbour where username1='$usr')");

$stmt2=$link->prepare("Select username from member where blockID = '$bid' and username <> '$usr' 
 and (username in(Select username2 from friends where username1='$usr')
or username   in(Select username1 from friends where username2='$usr')) and username not in(Select username2 from neighbour where username1='$usr')");
        
$stmt3=$link->prepare("Select username from member where blockID = '$bid' and username <> '$usr' 
 and (username not in(Select username2 from friends where username1='$usr')
and username  not in(Select username1 from friends where username2='$usr')) and username in(Select username2 from neighbour where username1='$usr')");
        
$stmt21=$link->prepare("Select username from member where blockID = '$bid' and username <> '$usr' 
 and (username in(Select username2 from friends where username1='$usr')
or username in(Select username1 from friends where username2='$usr')) and username in(Select username2 from neighbour where username1='$usr')");
        
        


        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        
        echo "<table border = '1' class='tablecss'>\n";
        echo "<tr><td>BlockMemebers</td><td>Send Requests</td></tr>";
        
        if($stmt->num_rows() >0)
						{
							
							
							while ($stmt->fetch()) {
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
                                    echo "<td>";
								   echo "<a href='http://localhost/project-master/addmem.php?afriend=$dusr'>";
                                   echo '<button type="button" class="btn btn-success" >Add as Friend</button>&nbsp';
                                   echo "</a>";
                                    echo "<a href='http://localhost/project-master/addmem.php?aneigh=$dusr'>";
                                    echo '<button type="button" class="btn btn-success">Add as Neighbour</button>';
									echo "</a>";
									echo "</td>";
									echo "</tr>";
								
							
							      }
        }
        
        
        
        
        $stmt2->execute();
        $stmt2->bind_result($dusr3);
        $stmt2->store_result();
        if($stmt2->num_rows() >0)
        {
                             
                           while ($stmt2->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr3 ;
									echo "</td>";
									echo "<td>";
                        echo '<button type="button" class="btn btn-danger" disabled>Already a Friend</button>&nbsp';
                                    echo "<a href='http://localhost/project-master/addmem.php?aneigh=$dusr3'>";
                                    echo '<button type="button" class="btn btn-success">Add as Neighbour</button>';
									echo "</a>";									
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
        
        
        
        
        }
        
        
        $stmt3->execute();
        $stmt3->bind_result($dusr4);
        $stmt3->store_result();
        if($stmt3->num_rows() >0)
        {
                             
                           while ($stmt3->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr4 ;
									echo "</td>";
									echo "<td>";
                                    echo "<a href='http://localhost/project-master/addmem.php?afriend=$dusr4'>";
                                   echo '<button type="button" class="btn btn-success" >Add as Friend</button>&nbsp';
                                   echo "</a>";								
                            echo '<button type="button" class="btn btn-danger" disabled>Already a Neighbour</button>';
									echo "</td>";
									echo "</tr>";
								
							
							      }
        
        
        
        
        }
        
        
        
        
        $stmt21->execute();
        $stmt21->bind_result($dusr21);
        $stmt21->store_result();
        if($stmt21->num_rows() >0)
        {
                             
                           while ($stmt21->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr21 ;
									echo "</td>";
									echo "<td>";
                            echo '<button type="button" class="btn btn-danger" disabled>Friend Request sent</button>';
							
                            echo '<button type="button" class="btn btn-danger" disabled>Already a Neighbour</button>';
									echo "</td>";
									echo "</tr>";
								
							
							      }
        
        
        
        
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        $stmt1=$link->prepare("Select username from blockmembership where blockID ='$bid' and username not in(select username from member where blockID='$bid')");
         $stmt1->execute();
        $stmt1->bind_result($dusr2);
        $stmt1->store_result();

        if($stmt1->num_rows() >0)
        {
              echo "<table border = '1' class='tablecss'>\n";
              echo "<tr><td>Awaiting approval</td><td>Actions required</td></tr>";
                             
                           while ($stmt1->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr2 ;
									echo "</td>";
									echo "<td>";
                                    echo "<a href='http://localhost/project-master/addmem.php?bmemapprove=$dusr2'>";
				echo '<button type="button" id="approve" class="btn btn-success">Approve</button>';
                                    $_session['count']=0;
                                    echo "</a>";
									echo "</td>";
									echo "</tr>";
								
							
							      }
        }
       
        
    }
        
    if($choice==5)
    {
        $stmt=$link->prepare("Select username from member where blockID not in(select blockID from blocks where hoodID='$hid') and username not in (Select username2 from friends where username1='$usr')
and username not in(Select username1 from friends where username2='$usr')");
        
        $stmt6=$link->prepare("Select username from member where blockID not in(select blockID from blocks where hoodID='$hid') and username in (Select username2 from friends where username1='$usr' and status='pending')
or username in(Select username1 from friends where username2='$usr'and status='pending')");
        
        $stmt->execute();
        $stmt->bind_result($dusr);
        $stmt->store_result();
        
         if($stmt->num_rows() >0)
        {
              echo "<table border = '1' class='tablecss'>\n";
              echo "<tr><td>Members in other neighbour hoods</td><td>Actions required</td></tr>";
                             
                           while ($stmt->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr ;
									echo "</td>";
									echo "<td>";
                                    echo "<a href='http://localhost/project-master/addmem.php?afriend=$dusr'>";
                                   echo '<button type="button" class="btn btn-success" >Add as Friend</button>&nbsp';
                                   echo "</a>";	
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
        }
        
        $stmt6->execute();
        $stmt6->bind_result($dusr2);
        $stmt6->store_result();
        
        
        if($stmt6->num_rows() >0)
        {
             
                             
                           while ($stmt6->fetch()) {
                            
									echo "<tr>";
									echo "<td>";
									echo $dusr2;
									echo "</td>";
									echo "<td>";
                            echo '<button type="button" class="btn btn-danger" disabled>Awaiting approval</button>&nbsp';
                                    echo "</td>";
									echo "</tr>";
								
							
							      }
        }
       
        
        
    }
        
        
    
        
     }
    
    
    ?>




</body>
<?php 
//include header template
require('layout/footer.php'); ?>

</html>
