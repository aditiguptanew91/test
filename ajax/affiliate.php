<?php
include '../connection.php';
$aid=$_GET['afid'];
$fetch=mysqli_query($con,"SELECT * from affiliate where username='$aid'");
$count=mysqli_num_rows($fetch);
if ($count>0) 
{
	echo "<p style='color:black;'>Username is not available</p>";
}
else
{
	echo "<p style='color:green'>Username is available</p>";
}

?>