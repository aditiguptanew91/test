<?php 
error_reporting(0);
 include ('header.php');  
 /***************************Access check************************/  
   if($usertype_id=='7' || in_array("Sub_Admin", $acces_sub))
   {
   $go= "allow to access this page";
   }else
   {
     header("location:".site_url."admin/home.php");
      exit();
   }
/***********************Access check code End********************/
$aid=$_GET['id'];
$id=$_SESSION['id'];
    $s="select * from `tbl_tradelines` WHERE `id`='$aid'";
    $result=mysqli_query($con,$s);
    $row=mysqli_fetch_array($result);
         $tradline_id=$row['id'];
          $bank_name=$row['bank_name'];
          $card_id=$row['card_id'];
          $card_limit=$row['card_limit'];
          $amount=$row['amount'];
          $reporting_period =$row['reporting_period'];
          $created_on =$row['created_on'];
          $created_by =$row['created_by'];
          $updated_by =$row['updated_by'];
          $image =$row['image'];
          $date_opened = date('Y-m-d', strtotime($row['date_opened']));
          $purchase_by_date = date('Y-m-d', strtotime($row['purchase_by_date']));  
   
if(isset($_POST['update'])){
   $bank_name=addslashes(trim($_POST['bank_name']));
   $card_id=$_POST['card_id'];
   $card_limit=$_POST['card_limit'];
   $amount=$_POST['amount'];
   $reporting_period=addslashes(trim($_POST['reporting_period']));
   $date_opened = $_POST['date_opened'];
   $purchase_by_date = $_POST['purchase_by_date'];
       $imgFile = $_FILES['profile']['name'];
        $tmp_dir = $_FILES['profile']['tmp_name'];
        $imgSize = $_FILES['profile']['size'];
        if($imgFile){
            $upload_dir = '../uploads/images/'; // upload directory 
            $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
            $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
            $userpic = rand(1000,1000000).".".$imgExt;
            if(in_array($imgExt, $valid_extensions)){
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
            }
        }
        else
        { 
            $userpic = $row['image']; // old image from database
        }
       $query="UPDATE `tbl_tradelines` SET `bank_name`='$bank_name',`card_id`='$card_id',`amount`='$amount',`reporting_period`='$reporting_period',`date_opened`='$date_opened',`purchase_by_date`='$purchase_by_date',`updated_on`=now(),`updated_by`='".$id."',`image` = '$userpic' WHERE `id`='$aid'";
            $res = mysqli_query($con, $query);
              if(mysqli_query($con, $query)){
                $successmsg = "Profile has been updated successfully.";     
                echo "<script type='text/javascript'>window.top.location='all_tradelines.php?mid=5'</script>"; 
                exit;
               }
           else{      
            $errormsg = "Failed To Updatate !";
        }
      }  
   
/*
    if(isset($_GET['id']))  {
 
         if($_GET['id']==$aid) {

            $successmsg = "Profile has been updated successfully.";

         }

   }*/

?>
<style>
@media(max-width:767px){
 #dddd{
 padding:60px !important;
  }
}
label { color : #fff; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pagetitle">
          <i class="fa fa-edit" style="font-size:30px;"></i>
             <div>
                <h4 style="color: #343a40">Edit Tradeline Profile</h4></span>
      </div>
          <a href="all_tradelines.php"><button class="btn btn-info" style="dispay:block; position:absolute; right:40px; margin-top:-25px;">Back</button></a>
  </div>
      <div class="br-pagebody">
        <div class="row row-sm">
          <div class="col-sm-12 col-xs-12" id="dddd" style="overflow:hidden; border: 1px solid #ccc; box-shadow: 5px 5px 25px #999; padding:100px; background-color: #1d2939; border-radius: 10px;" >
            <?php if(!empty($successmsg)): ?>
            <p class="alert alert-success text-center"><?php echo $successmsg ?></p>
            <?php elseif(!empty($errormsg)): ?>
            <p class="alert alert-danger text-center"><?php echo $errormsg; ?></p>
          <?php endif; ?>
        <form method="post" action="" style=""  autocomplete="off" enctype="multipart/form-data" onsubmit="return phone();">
              <?php if(isset($_SESSION['error'])): ?>
                  <p class="alert alert-danger text-center"><?php echo $_SESSION['error']; ?></p>
                     <?php unset($_SESSION['error']);endif; ?>
                        <div class="form-group">
                            <label for="pwd">Bank Name <span style="color: red;">*</span></label>
                                 <input type="text" value="<?php echo $bank_name; ?>" class="form-control bank_name"  placeholder="" name="bank_name" id="bank_name" required="true">
                       </div>
        <div class="form-group">
             <label for="pwd">Card Id <span style="color: red;">*</span></label>
                <input type="text"  autocomplete="off" value="<?php echo $card_id; ?>" class="form-control card_id"  placeholder="" name="card_id" id="card_id" required="true">
        </div>
                <div class="form-group">
                    <label for="pwd">Card Limit<span style="color: red;">*</span></label>
                         <input type="text"  autocomplete="off" value="<?php echo $card_limit; ?>" class="form-control card_limit" placeholder="" id="card_limit" name="card_limit" required>
        </div>        

        <div class="form-group">

          <label for="pwd">Amount<span style="color: red;"> *</span></label>
             <input type="text" autocomplete="off" value="<?php echo $amount; ?>" class="form-control amount"  placeholder="" name="amount" id="amount" required maxlength="6" >

      </div>

        <div class="form-group">

            <label for="pwd">Date Opened</label>

               <input type="text"  autocomplete="off" value="<?php echo $date_opened; ?>" class="form-control"  placeholder="" name="date_opened" id="datepicker1">

        </div>

        

        <div class="form-group">
 
          <label for="pwd">Purchase Date <span style="color: red;">*</span></label>

             <input type="text" autocomplete="off" value="<?php echo $purchase_by_date; ?>" class="form-control" id="datepicker2" placeholder="" name="purchase_by_date" required="true" >

        </div>

        
          <div class="form-group">

           <label for="pwd">Reporting Period <span style="color: red;">*</span></label>

              <input type="text" autocomplete="off" value="<?php echo $reporting_period; ?>" class="form-control" id="contact" placeholder="" name="reporting_period" required="true">

        </div>
             

        <div class="form-group">

          <div class="row">

            <div class="col-md-6 col-lg-offset-3">

              <div class="main-login main-center">

                <div class="col-md-3" style="padding:0;"> 

                   <div class="form-group">

                    <label for="Image">Image</label>



                    <input type="file" name="profile" >

                   <?php 

                   if(trim($image)=='')

                   {

                   ?>
                   
                   <?php

                   } else {

                   ?>

              
  <img src="../uploads/images/<?php echo $image; ?>" class="img-thumbnail" style="margin-top:5px;"   alt=""/>

  <?php } ?>

  
                  </div>              

                  </div>

                </div>

              </div>

            </div>

          </div>



          <button type="submit" name="update" class="btn btn-info">Update</button>



            </div>

          </div>

        </div>

      </form>

    </div><!-- col-3 -->

  </div><!-- row -->

</div><!-- br-pagebody -->

      <footer class="br-footer">

         <div class="footer-left">

       </div>

        <div class="footer-right d-flex align-items-center">

            <div class="mg-b-2"></div>

                <br>

               <div></div>

        </div>

      </footer>

    </div><!-- br-mainpanel -->


    <!-- ########## END: MAIN PANEL ########## -->
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 
<script type="text/javascript">

  $( document ).ready(function() {

  

  $('#bank_name').keyup(function () {



            var count = $(this).val();

            //to allow decimals,use/[^0-9\.]/g 

            var regex = new RegExp(/[^()a-z\.A-Z\s]/g);

            var containsNonNumeric = this.value.match(regex);

            if (containsNonNumeric) {

                this.value = this.value.replace(regex, '');

              }

           });
  $('#card_id').keyup(function () {



            var count = $(this).val();

            //to allow decimals,use/[^0-9\.]/g 

            var regex = new RegExp(/[^()0-9\.\$\s]/g);

            var containsNonNumeric = this.value.match(regex);

            if (containsNonNumeric) {

                this.value = this.value.replace(regex, '');

              }

           });
  $('#card_limit').keyup(function () {



            var count = $(this).val();

            //to allow decimals,use/[^0-9\.]/g 

            var regex = new RegExp(/[^()0-9\.\$\s]/g);

            var containsNonNumeric = this.value.match(regex);

            if (containsNonNumeric) {

                this.value = this.value.replace(regex, '');

              }

           });

$('.amount').keyup(function () {



            var count = $(this).val();

            //to allow decimals,use/[^0-9\.]/g 

            var regex = new RegExp(/[^()0-9\.\$\s]/g);

            var containsNonNumeric = this.value.match(regex);

            if (containsNonNumeric) {

                this.value = this.value.replace(regex, '');

              }

           });



  });

</script>

<script type="text/javascript">
  

  $( function() {



    $( "#datepicker1" ).datepicker();
     $( "#datepicker2" ).datepicker();



  } );
</script>







</body>



</html>
