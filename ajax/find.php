<?php 

include ('header.php');



?>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">

<link rel="stylesheet" href="../lib/table/datatable.css">

<script type="text/javascript" src="ajax/select.js"></script>

<script src="ajax/submit.js"></script>

<style>



.paginate_button{



  background-color:red #ccc;

  padding:10px 10px;

  margin:10px 5px;

  

}





.dataTables_info{



  padding:10px 0;

  display:block;



}



.table th{



 background-color:skyblue;



}



.table tr td{



  background-color:#dee2e6;

  color:#000 !important;

  border:1px solid #ccc;



}







@media(max-width:767px){



  .table-wrapper{

  overflow-x: scroll;

  overflow-y:none !important;

  min-height:500px;



}



}

</style>

<style>



label{



  padding:10px 15px;





}





table tr td{

    

  border-bottom:1px solid #ccc; 

  padding:10px 0;

}





.dataTables_info{

  

  display:none;

  

  

}





#datatable1_previous{



    padding:10px 5px !important;

    

}







#datatable1_previous{



    padding:10px 5px !important;

    

}



.paginate_button{

  

  padding:10px;

  

}

@media(max-width:767px){



  

    .br-section-wrapper{



 

    }

  

  

  .card{

    

  overflow-x:scroll;    

      

    

  }

  



}



  

}



</style>



<?php



   



   if(isset($_POST['search']))

   {

    

   $utype   = trim($_POST['uid']);

   $uid     = trim($_POST['name']);

   $fdate   = trim($_POST['fdate']);

   $tdate   = trim($_POST['tdate']);



   $comp_id =  $_SESSION['c_id'];

    





    if($utype!='' && $uid!='' &&  $fdate!='' && $tdate!='') 

    {





    $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and a.created_by = ".$uid."

             and (date(a.created_on)  between '".$fdate."' and  '".$tdate."')

             and a.status='0' and ls.final_amount !='NULL'";



    }

    elseif($utype!='' && $uid=='' &&  $fdate=='' && $tdate=='')

    {

      



     if($utype=='2')

     {

     

     $select = "select id from admin where usertype_id='2' and status='0' ";

     $query  = mysqli_query($con,$select); 

     while ($row=mysqli_fetch_array($query)){

           $new[] =  $row['id'];

           }

     $all_id = implode(",", $new);



     }elseif($utype=='3') {

        

        $select = "select id from admin where usertype_id='3' and status='0' ";

        $query  = mysqli_query($con,$select); 

        while ($row=mysqli_fetch_array($query)){

           $new[] =  $row['id'];

           }

        $all_id = implode(",", $new);



     }elseif($utype=='4')

     {

    

         $select = "select id from admin where usertype_id='4' and status='0' ";

         $query  = mysqli_query($con,$select); 

         while ($row=mysqli_fetch_array($query)){

           $new[] =  $row['id'];

           }

         $all_id = implode(",", $new);



     } 



   



    $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and a.created_by IN (".$all_id.")

             and a.status='0' and ls.final_amount !='NULL'";



    }elseif($utype!='' && $uid!='' &&  $fdate=='' && $tdate=='')

    {



     

      $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and a.created_by = ".$uid."

             and a.status='0' and ls.final_amount !='NULL'";



    }elseif($utype!='' && $uid!='' &&  $fdate!='' && $tdate=='')

    {



    

      $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and a.created_by = ".$uid."

             and date(a.created_on) = '".$fdate."'

             and a.status='0' and ls.final_amount !='NULL'";







    }elseif($utype=='' && $uid=='' &&  $fdate!='' && $tdate=='')

    {





       $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and date(a.created_on)='".$fdate."'

             and a.status='0' and ls.final_amount !='NULL'";



    }

    elseif($utype=='' && $uid=='' &&  $fdate=='' && $tdate!='')

    {





       $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and date(a.created_on)= '".$tdate."'

             and a.status='0' and ls.final_amount !='NULL'";



    }

     elseif($utype=='' && $uid=='' &&  $fdate!='' && $tdate!='')

    {





       $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and (date(a.created_on) between '".$fdate."' and '".$tdate."')

             and a.status='0' and ls.final_amount !='NULL'";



    }

    else

    {



    



      $condition = "a.company_id=".$comp_id." 

             and a.usertype_id='6' 

             and a.status='0' and ls.final_amount !='NULL'";



    }











   

  }





?>



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">



      <div class="br-pagetitle">

        <i class="fa fa-credit-card" aria-hidden="true" style="font-size:30px;"></i>

        <div>

          <h4>Credit Summary</h4>

           

        </div>

      </div><!-- d-flex -->



     <div class="br-pagebody">



        <div class="br-section-wrapper">

          <div class="row">



            <form method="post" id="myForm" style="width:100%">



             <div class="row">





                

                <div class="col-md-3">



                  <div class="form-group">



                    <label class="label-control">User Type</label>



                    <span class="col-md-6">



                      <select name="uid" class="form-control" onchange="find()" id="id" >

                      <option value="">Select User</option>

                      <option value="5" <?php if(isset($_POST['search'])){ if($_POST['uid']=='7'){ echo "selected";}}?>>Admin</option>

                      <option value="2" <?php if(isset($_POST['search'])){ if($_POST['uid']=='2'){ echo "selected";}}?>>Sub Admin</option>

                      <option value="3" <?php if(isset($_POST['search'])){ if($_POST['uid']=='3'){ echo "selected";}}?>>Manager</option>

                      <option value="4" <?php if(isset($_POST['search'])){ if($_POST['uid']=='4'){ echo "selected";}}?>>Affiliate</option>

                      </select>

                    

                    </span>

                  </div><!--form grop ed-->

                </div><!--col ed-->







                <div class="col-md-3">



                  <div class="form-group">



                    <label class="label-control">User Name</label>



                    <span class="col-md-8">

                    

                      <div class="" id="uid">

                        <select name="name" class="form-control" id="cid">

                        <option>Please Select</option>

                        </select>

                        </div>



                    </span>



                  </div><!--form grop ed-->



                </div><!--col 6 ed-->





               <div class="col-md-2">



                  <div class="form-group" style="padding:0">



                    <label class="label-control col-md-3" style="color:#fff">From</label>



                    <span class="col-md-9">



                    <input type="text"  id="datepicker1"  value="<?php if(isset($_POST['fdate'])){ echo $_POST['fdate']; } ?>" 

                   class="form-control" name="fdate" placeholder="Form Date">

                    

                    </span>

                  </div><!--form grop ed-->

                </div><!--col ed-->







                <div class="col-md-2">



                  <div class="form-group" style="padding:0">



                    <label class="label-control col-md-4" style="color:#fff">To</label>



                    <span class="col-md-8">

                    

                   <input type="text"  id="datepicker2" value="<?php if(isset($_POST['tdate'])){ echo $_POST['tdate']; } ?>" 

                   class="form-control" name="tdate" placeholder="To Date">





                    </span>



                  </div><!--form grop ed-->



                </div><!--col 6 ed-->



     

                <div class="col-md-2">

                  





                    <input type="submit" name="search" class='btn btn-info' id="submitFormData" style="margin-top:50px; display: block;">





                </div><!--col 2 ed-->





             </div><!--row ed-->



            </form>



          </div>

          <div id="results">

            

          </div>



    <?php if(!empty($successmsg)): ?>

            <p class="alert alert-success text-center"><?php echo $successmsg; ?></p>

            <?php elseif(!empty($errormsg)): ?>

            <p class="alert alert-danger text-center"><?php echo $errormsg; ?></p>

          <?php endif; ?>   



          <div class="row">

            <div class="col-md-12">

              <div class="header_start">

        

          <div class="row" style="padding:0px 0">

          

            

            <div class="col-md-12 text-right">

            

    <!--<a href="affiliate_register.php" class="btn btn-info">+ Add new Affiliate</a>-->

          

            

            </div><!--col end-->



            

          

          </div><!--row end-->

          

           <div class="row">

            

            </div>

          

          

          

          

<div class="row">

          

    



 <div style="overflow-x:auto;width:100%"> 



  <?php if(!empty($successmsg)): ?>

            <p class="alert alert-success text-center"><?php echo $successmsg; ?></p>

            <?php elseif(!empty($errormsg)): ?>

            <p class="alert alert-danger text-center"><?php echo $errormsg; ?></p>

          <?php endif; ?>



        <table class="table table-hover table-responsive table-bordered" border="1">



         <tr>

          <th style="color:#FFF;" align="left" valign="middle">S.No</th>

          

          <th style="color:#FFF;" align="left" valign="middle">Full Name (Lead)</th>

          <th style="color:#FFF;" align="left" valign="middle">Services</th>

           <th style="color:#FFF;" align="left" valign="middle">Final Amount</th>

          

           <th style="color:#FFF;" align="left" valign="middle">Manager %</th>

           <th style="color:#FFF;" align="left" valign="middle">Aff to Mngr %</th>

           <th style="color:#FFF;" align="left" valign="middle">Affiliate %</th>

           <th style="color:#FFF;" align="left" valign="middle">Under Mngr Aff %</th>

           <th style="color:#FFF;" align="left" valign="middle">Created On</th>

           

         </tr>

          

<?php

  

    $select ="Select ls.*,a.*,a.first_name as first_name, a.last_name as last_name,a.middle_name as middle_name,sr.service as service,ls.final_amount as final_amount,ls.cr_amt_affilate as cr_amt_affilate,ls.created_on as created_on 

             from admin as a

             left join lead_service as ls on ls.lead_id=a.id

             left join service as sr on sr.id=ls.service_id

             where 1 and ".$condition."";      



    $res=mysqli_query($con,$select);

    $i=1;

   

 

    while ($row = mysqli_fetch_array($res))

    {

    

      

   $final_amount_sum +=  $row['final_amount'];

   $manger_amount_sum +=  $row['cr_amt_manager'];

   $manger_under_amount_sum +=  $row['cr_amt_aff_to_mngr'];



   $affilate_amount_sum +=  $row['cr_amt_affilate'];

   $affilate_under_amount_sum +=  $row['cr_amt_um_aff'];









?>

    <tr>

                         

              <td><?php echo $i; $i++;?></td>             

              <td><?php echo $row['suffix_name']." ".$row['first_name']." ".$row['middle_name']." ".$row['last_name']; ?></td>    

              <td><?php echo $row['service'];?></td>

              <td><?php echo $row['final_amount'];?></td>

              

             

               <td><?php echo $row['cr_amt_manager'];?></td>

              <td><?php echo $row['cr_amt_aff_to_mngr'];?></td>

              <td><?php echo $row['cr_amt_affilate'];?></td>

              <td><?php echo $row['cr_amt_um_aff'];?></td>

              <td><?php echo $row['created_on'];?></td>

       





         </tr>

         <?php

         }



       ?>

      <tr style='background-color:transparent;'>

       <td colspan="3" style="text-align:center; font-size:20px; font-weight:600;">Total Amount</td>

       <td><?php echo $final_amount_sum; ?></td>

       

       <td><?php echo $manger_amount_sum ; ?></td>

       <td><?php echo $manger_under_amount_sum ; ?></td>

        <td><?php echo $affilate_amount_sum ; ?></td>

       <td><?php echo $affilate_under_amount_sum ; ?></td>



      <td></td>





      </tr> 









        </table>

   

  </div><!--overlfow ed--> 

</div>

</div><!--row ed-->

          







        

        </div><!--card end-->

      

      </div><!--col 12 end-->

    

      </div><!--row ed--> 

      



    <!-- content-wrapper ends -->

        <!-- partial:partials/_footer.html -->

        <footer class="footer">

          <div class="d-sm-flex justify-content-center justify-content-sm-between">

            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"> 

      <a href="" target="_blank"></a></span>

            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i class="mdi mdi-heart text-danger"></i></span>

          </div>

        </footer>

    

<!--model start-->    

    



    

    

        <!-- partial -->

      </div>

    



      

        </div>

       </div><!--br pagebody-->



        </div>



    <!-- ########## END: MAIN PANEL ########## -->



  

    <script src="../lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>

    <script src="../lib/moment/moment.js"></script>

    

    <script src="../lib/jquery-ui/jquery-ui.js"></script>



    <script src="../lib/jquery-switchbutton/jquery.switchButton.js"></script>

    <script src="../lib/peity/jquery.peity.js"></script>

    <script src="../lib/highlightjs/highlight.pack.js"></script> 

    <script src="../lib/select2/js/select2.min.js"></script>

    



  





      <script>

  

  $(function(){

    $("#datepicker1").datepicker({dateFormat: 'yy-mm-dd' });

  });

  

  </script>



      <script>

  

  $(function(){

    $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});

  });

  

  </script>

      

  



<script type="text/javascript">

      

 myFunction();



function myFunction() {



   

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function()

  {

    if (xmlhttp.readyState==4 && xmlhttp.status==200) 

    {

      document.getElementById('uid').innerHTML=

      xmlhttp.responseText;

    }

  }

  var c = document.getElementById('id').value;
  
  var cid = "<?php if(isset($_POST['search'])){ echo $_POST['name'];}?>";

  //alert(c);

  //alert(cid);

  xmlhttp.open("get","ajax/name.php?utype="+c+"&mid="+cid,true);

  xmlhttp.send();

}

</script>
<script>
 $(function(){
  'use strict';
 $('#datatable1').DataTable({
  responsive: true,
language: {
 searchPlaceholder: 'Search...',
 sSearch: '',
 lengthMenu: '_MENU_ items/page',
 }
 });
$('#datatable2').DataTable({
bLengthChange: false,
 searching: false,
responsive: true
 });
 $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
       });
</script>

