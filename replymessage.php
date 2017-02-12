<?php
require ('dbconnection.php');
$messageID = $_Session['MessageID'] ;
$username = $_SESSION['username'];
		
		
					$stmt1=$link->prepare("Select m.messageID,p.author,p.body,p.createdOn from message m inner join msgreply p on p.messageID=m.messageID  where p.messageID ='$messageID' ");
					$stmt1->execute();
					$stmt1->bind_result($messageID,$author,$body,$createdOn);
					$stmt1->store_result();
						if($stmt1->num_rows() >0)
						{
							
							echo "<table border = '1' class='tablecss'>\n";
					echo "<tr><td>Author</td><td>Body</td><td>Time</td></tr>";
							while ($stmt1->fetch()) {
							
									echo "<tr>";
									
									echo "<td>";
									echo $author ;
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