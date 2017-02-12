<<?php
require ('dbconnection.php');
	
		$username = $_SESSION['username'];
		
		
					$stmt1=$link->prepare("call spShowPrivateFeed('$username')");
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
									echo $title;
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