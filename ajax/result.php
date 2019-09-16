<?php 

  if (isset($_POST['search'])) {
    
   echo $utype =addslashes(trim($_POST['uid'])).'<br>';
  echo  $uid = addslashes(trim($_POST['name']));

    // echo "<script>alert(".$utype.")</script>";
    //  echo "<script>alert(".$uid.")</script>";
  }
?>