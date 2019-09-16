<?php

session_start();

include '../../includes/connection.php';



$mid ='';

$id  = '';

$id =  $_GET['utype'];

$mid = $_GET['mid'];

$query="SELECT a.*, d.name as user_type
       from admin  as a 
       left join designation as d on d.id=a.usertype_id
       where a.usertype_id='".$id."' and a.status='0'";

$result=mysqli_query($con,$query) or die(mysqli_error($con));


echo "<select name='name' id='cid' class='form-control'>";

echo "<option value=''>Please Select User</option>";

while ($row=mysqli_fetch_array($result)) 
{

    if($row['id']==$mid)
    {



     $st = "selected";



    }else{$st='';}



	$name=$row['suffix_name']." ".$row['first_name']." ".$row['middle_name']." ".$row['last_name']." - ".$row['username']." ( ".$row["user_type"]." )" ;

	echo "<option value='".$row['id']."' ".$st." >".$name;"</option>";

}

echo "</select>";







?>