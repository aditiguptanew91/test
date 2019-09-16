<?php
include_once '../connection.php';
$id=$_GET['cid'];

$select=mysqli_query($con,"SELECT * from manager where email='$id'");
$row=mysqli_num_rows($select);
if ($row>0) 
{
	echo "<p style='color:white;'>Emailid already exist, please enter other emailid.</p>";
}
else
{
	echo "<p style='color:white;'>Emailid is available to use.</p>";
}
?>
