<?php
  $trx=$_GET['trxno'];
  $apvno=$_GET['apvno'];
//======>header
  $call = "{call  SP_DATA_ORDER(?)}";
  $param = array(array($trx, SQLSRV_PARAM_IN));
  $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
  $header = sqlsrv_fetch_array($exec); 

//=====>VERIFFF
  $callverif = "{call  SP_APPROVAL_VERIFIKASI_DOC(?,?,?)}";
  $paramverif = array(array($trx, SQLSRV_PARAM_IN),array($apvno, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
  $execverif = sqlsrv_query( $conn, $callverif, $paramverif) or die( print_r( sqlsrv_errors(), true)); 
  $verif = sqlsrv_fetch_array($execverif); 


  if (isset($_POST['apv'])) {

     $apv=$_POST['apv']; 
     $notes=$_POST['notes'];
	 $reject_reason = $_POST['reject_reason'];
	
     if ($user=="") {
     
        echo "<script>alert('Username cant be blank !')</script>";   
         return false;      
        }else if ($apv=="") {
         
        echo "<script>alert('Please Choose Approval !')</script>";   
         return false;      
        }else if ($apvno=="") {
         
        echo "<script>alert('Approval Number cant be blank !')</script>";   
         return false;      
        }else{
			if($notes == "RETURN"){
				echo "<script>window.location='index.php?page=reject-order&USERNAME=".$user."&no=".$trx."'</script>";
			}else{
   	 if($apv == "REJECT"){	
		$call4 = "{call  SP_INSERT_REJECT_NOTE(?,?,?,?)}";
		$param4 = array(
			  array($trx, SQLSRV_PARAM_IN),
			  array($reject_reason, SQLSRV_PARAM_IN),
			  array($notes, SQLSRV_PARAM_IN),
			  array($user, SQLSRV_PARAM_IN)
			);
		$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));
		  if ($exec4) {
    //  echo '<script>swal("Success!", "", "success")</script>';   
     echo "<script>alert('Submit reject Successfully !')</script>";   
        echo "<script>window.location='index.php?page=aproval&USERNAME=".$user."'</script>";
        }
	 }else{
		
     $call = "{call SP_APPROVAL_SUBMIT(?,?,?,?)}";
     $param = array(
     array($user, SQLSRV_PARAM_IN),
     array($apv, SQLSRV_PARAM_IN),
     array($apvno, SQLSRV_PARAM_IN),
     array($notes, SQLSRV_PARAM_IN));

     $exec5 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	 

    if ($exec5) {
    //  echo '<script>swal("Success!", "", "success")</script>';   
     echo "<script>alert('Submit Successfully !')</script>";   
        echo "<script>window.location='index.php?page=aproval&USERNAME=".$user."'</script>";
        }
	 }
    }
	}
}

?>
<style>
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>
<div class="row">
   <div class="col-md-12">
       <div class="card">
           <div class="header">
               <h4 class="title">Input Approval</h4>
           </div>
           <div class="content">
               <form action="#" method="post">
               <div class="row">
					
					
						<div class="col-md-6">
					
							<label style="font-size:15px;">Order No</label>	
							<div class="form-group">
                            <label style="font-size:15px;"><a style="color:blue;" href="<?php echo 'index.php?page=view-inquiry&USERNAME='.$user.'&trxno='.$header['ORDER_NO'].'&apvno='.$apvno?>"><?php echo $header['ORDER_NO']?></a></label>
							</div>
						</div> 
            
					<div class="col-md-6">
						
							<label  style="font-size:15px">Customer</label>	
                            <label style="font-size:15px"><b><?php echo $header['CUST_NAME']?></b></label> 
						</div>
					</div> 
              
				 <div class="row">
					<div class="col-md-6">
							<label  style="font-size:15px">Verifikasi Dokumen</label>	
							<div class="form-group">
							<!--<b><a style="color:blue;" href="<?php// echo 'index.php?USERNAME='.$user.'&page=view-request&orderno='.$header['ORDER_NO'].'&id='.$header['MOBILE_REQUEST_ID'].'&request_id='.$header['MOBILE_ASSIGNMENT_ID'].'&apvno='.$apvno ?>"> -->
							<?php if($verif['IS_VERIFIED']=='1'){ echo 'VERIFIED';}else if ($verif['IS_VERIFIED']=='2'){ echo 'VERIFIED PROGRESS';}else {echo 'NOT VERIFIED';}?></a></b>
						 &nbsp; &nbsp;  &nbsp; &nbsp;
								<a href="<?php echo 'index.php?USERNAME='.$user.'&page=view-request&orderno='.$header['ORDER_NO'].'&id='.$header['MOBILE_REQUEST_ID'].'&request_id='.$header['MOBILE_ASSIGNMENT_ID'].'&apvno='.$apvno?>" class="btn btn-primary btn-sm"> VERIFIKASI DOKUMEN</a>
							</div>
							
						</div> 
					 </div>
		
                <div class="row">
						<div class="col-md-6">
							<label>Approval</label>	
							<div class="form-group">
							 <select class="form-control" name="apv" id="apv">
                             <option value="">-Select-</option>
							<?php if ($verif['IS_VERIFIED']=='1'){ ?>
                             <option value="APPROVE">Approve</option>
							    <option value="RETURN">Return</option>
							  <option value="REJECT">Reject</option>
							<?php } else if($verif['IS_VERIFIED']=='2'){?>
                             <option value="RETURN">Return</option>
                             <option value="REJECT">Reject</option>
							<?php }else{ ?>
							<option value="APPROVE">Approve</option>
							<option value="RETURN">Return</option>
                            <option value="REJECT">Reject</option>
							<?php } ?>
                             </select>
							</div>
						</div> 
				</div> 
		
				<div class="row">
						<div class="col-md-6">
							<label>Notes</label>	
							<div class="form-group">
                            <input type="text" name="notes" class="form-control" >
							</div>
						</div> 
                </div>
				
				<div class="row" id="reject_div" hidden>
						<div class="col-md-6">
							<label>Reject Reason</label>
							<div class="form-group">
								<select name="reject_reason" id="reject_reason"  class="form-control">
									<option value="I-01 HASIL FOTO DOKUMEN PERSYARATAN KREDIT TIDAK LENGKAP">I-01 HASIL FOTO DOKUMEN PERSYARATAN KREDIT TIDAK LENGKAP</option>
									<option value="I-02 HASIL FOTO DOKUMEN PERSYARATAN KREDIT TIDAK TERBACA">I-02 HASIL FOTO DOKUMEN PERSYARATAN KREDIT TIDAK TERBACA</option>
									<!--<option value="E01 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (DSR > 60%)">E01 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (DSR > 60%)</option>
									<option value="E03 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (REGULASI MINIMUM TDP)">E03 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (REGULASI MINIMUM TDP)</option>-->
								</select>
							</div>
						</div> 
                </div>
               
              
              
                <div class="pull-left">
					 <?php if ($verif['IS_VERIFIED']=='1'){ ?>
						<button type="submit" name="submit" class="btn btn-primary" onclick="submit()">Submit</button>
					 <?php }else if ($verif['IS_VERIFIED']=='2'){ ?>
						<button type="submit" name="submit" class="btn btn-primary" onclick="submit()">Submit</button>
						<?php } else { ?>
						<button type="submit" name="submit" class="btn btn-primary" disabled>Submit</button>
						<?php } ?>
                </div>
                <br>
				<br>
				<hr>
                   <div class="row">
                   <div class="col-md-12">
                       <div class="table-responsive">
                           <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">APPROVAL NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">LEVEL</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">JABATAN</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">USERNAME</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NOTES</th>
									   <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL APPROVE</th>
                                    
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                 
                                       $no=0;
                                       $call = "{call  SP_APPROVAL_GETLIST_LOA(?)}";
                                       $param = array(array($apvno, SQLSRV_PARAM_IN));
                                       $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
                                       while($data = sqlsrv_fetch_array($exec)){
                                           $no++;
                                   ?> 
                                   <tr>
                                       
                                       <td class="td-center"><?php echo $no;?></td>
                                       <td class="td-center"><?php echo $data['APV_NO']?></td>
                                       <td class="td-center"><?php echo $data['LEVEL']?></td>
                                       <td class="td-center"><?php echo $data['ROLE_CODE']?></td>
                                       <td class="td-center"><?php echo $data['USERNAME']?></td>
                                       <td class="td-center"><?php echo $data['STATUS']?></td>
                                       <td class="td-center"><?php echo $data['NOTES'];?></td>
									      <td class="td-center"><?php if($data['UPDATE_DATE']<>NULL){echo $data['UPDATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
                                    
                                        
                                   </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
                   <div style="clear:both;"></div>
               </form>
           </div>
       </div>
   </div>
</div>
  </div>
<script type="text/javascript">
   $(window).on("load", function(){
       setTimeout(function(){
           $("#loader").fadeOut("slow");
       }, 2000);
   });
</script>
<script>
$(document).ready(function() {
   $('#tb_list_apv').DataTable({
       "bPaginate": true,
       "bLengthChange": true,
       "bFilter": true,
       "bInfo": true
   });
   $('#startDate').datepicker({
       dateFormat: 'yy-mm-dd',
       changeMonth: true,
       changeYear: true,
       showButtonPanel: true,
       onClose: function(selectedDate) {
           $('#endDate').datepicker("option", "minDate", selectedDate);
       }
   });
   $('#endDate').datepicker({
       dateFormat: 'yy-mm-dd',
       changeMonth: true,
       changeYear: true,
       showButtonPanel: true,
       onClose: function(selectedDate) {
           $('#startDate').datepicker("option", "maxDate", selectedDate);
       }
   });
   $('#apv').change(function() { 
  	var type =$('#apv').val();
	if(type == 'REJECT'){
		document.getElementById('reject_div').style.display='block';
	}else{
		document.getElementById('reject_div').style.display='none';

	}
	
    });
} );
</script>