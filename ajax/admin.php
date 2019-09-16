<?php
include_once '../connection.php';
$id=$_GET['aid'];

$select=mysqli_query($con,"SELECT * from admin where username='$id'");
$row=mysqli_num_rows($select);
if ($row>0) 
{
	echo "<p style='color:white;'>Username already exist, please enter other username.</p>";
}
else
{
	echo "<p style='color:white;'>Username is available</p>";
}
?>
