<?php
require ('dbconnection.php');




		$username = $_SESSION['username'];
		
		
					$stmt1=$link->prepare("Select messageID,author,title,body,createdOn from message m
 where m.author in (
 Select username2 from neighbour
where username1 ='$username'
) and m.visibilityStatus=4 
group by messageID
union	
Select messageID,author,title,body,createdOn from message where author in (
Select username from member where blockiD in (
Select blockid from member where username ='$username'))
and visibilityStatus = 1
group by messageID
union
Select messageID,author,title,body,CreatedOn from message where author in (
Select username from member where blockiD in (Select BlockId from blocks where hoodId in(
Select HoodID from blocks where blockID in (
Select blockid from member where username = '$username'))))
and visibilityStatus = 2 
group by messageID
union
Select messageID,author,title,body,createdOn from message m
 where m.visibilityStatus=3 and author in (
 Select username1 as Friend from friends where username2='$username' and status='approved')
 union
 Select messageID,author,title,body,createdOn from message m
 where m.visibilityStatus=3 and author in(
 select username2 as Friend from friends where username1='$username'and status='approved'  )
group by messageID
union
Select m.messageID,author,title,body,createdOn from message m,privatemsg p
where  m.messageID =p.messageID and viewusername ='$username'
group by messageID
order by messageID;");
					$stmt1->execute();
					$stmt1->bind_result($messageID,$author,$title,$body,$createdOn);
					$stmt1->store_result();
						if($stmt1->num_rows() >0)
						{ 
					echo "<table border = '1' class='tablecss'>\n";
					echo "<tr><td>MessageID</td><td>Author</td><td>Title</td><td>Body</td><td>Time</td></tr>";
							while ($stmt1->fetch()) {
							
							 echo "<tr><td>";
							 
							 $str1 = "<a href='replymsg.php?messageID=$messageID'>$messageID</a> ";
							 
							echo $str1;	
			  
			  echo '</a></td>';
			  echo "<td>";
				echo $author ;
				echo "</td>";
				echo "<td>";
				
				echo $title ;
				
				echo "</td>";
				echo "<td>";
				echo $body;
				echo "</td>";
				echo "<td>";
				echo $createdOn;
				echo "</td>";
			  echo "</tr>";
			
							
		
							
							}
						}
						
		
?>
