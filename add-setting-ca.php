<?php

require_once("config/configuration.php");
require_once("config/connection.php");


if(isset($_POST['submit'])){
$user = $_GET['USERNAME'];
$branch = $_POST['branch'];

}
else if(isset($_POST['submit1'])){
    $user = $_GET['USERNAME'];
    $branch = $_POST['branch'];

    
		//pemohon 
		$callIns = "{call SP_GET_INSERT_SETTING_CA_NON(?,?)}";
		$paramIns = array(	array($branch, SQLSRV_PARAM_IN),
						    array($_GET['USERNAME'], SQLSRV_PARAM_IN));
		$execIns = sqlsrv_query( $conn, $callIns, $paramIns) or die( print_r( sqlsrv_errors(), true)); 
	
		
		if($execIns){
			//update status jadi on progress
			
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?page=add-setting-ca&USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
    
}
else{
$order = "";
$user = $_GET['USERNAME'];
$branch = "";
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
<h4 class="title">Add Ca Non Aktif</h4>
<p class="category">Cari Cabang</p>
</div>
<div class="content">
<form action="" method="post">


<div class="col-md-6">
<div class="form-group">
<label>Search Cabang</label>
<select name="branch" class="form-control">
											<option value="">ALL BRANCH</option>
											<?php
                                          
												$call2 = "{call sp_COuserFindByBranchID (?)}"; 
												$param2 = array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
												$exec2 = sqlsrv_query($conn, $call2,$param2) or die( print_r( sqlsrv_errors(), true));
												while($data2=sqlsrv_fetch_array($exec2)){
											
                                                ?>
											<option value="<?php echo $data2['Branchid'];?>" <?php if($data2['Branchid']==$branch){ echo "selected"; }?>><?php echo $data2['BranchName'];?></option>
											<?php }?>
										</select>
</div>
</div>


<div class="col-md-6">
<br>
<div class="pull-right">
<input type="submit" name="submit" class="btn btn-custom" value="Cari">
</div>
</div>
<div style="clear:both;"></div>
<hr>



</div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<h4 class="title">LOA CA NON AKTIF</h4><br>
						<div class="table-responsive">
							<?php if(isset($_POST['submit'])){ ?>
                                <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">BRANCH ID</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">FULLNAME</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">JABATAN LOA</th>
                                    
                                   </tr>
                               </thead> 
                               <tbody>
                                   <?php
										/*
										$callApv = "{call SP_APPROVAL_GETLIST_APV_NO_RAK(?)}";
										$paramApv =  array(array($prospect, SQLSRV_PARAM_IN));
										$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_errors(), true));
										$dataApv= sqlsrv_fetch_array($execApv);
										*/
                                       $no=0;
                                       $callLoa = "{call  SP_GET_LOA_SETTING_CA_NON(?,?)}";
                                       $paramLoa = array(array($branch, SQLSRV_PARAM_IN),
                                                          array($user, SQLSRV_PARAM_IN));
                                       $execLoa = sqlsrv_query( $conn, $callLoa, $paramLoa) or die( print_r( sqlsrv_errors(), true)); 
                                       while($dataLoa = sqlsrv_fetch_array($execLoa)){
                                           $no++;
                                   ?> 
                                   <tr>
                                       
                                       <td class="td-center"><?php echo $no;?></td>
                                       <td class="td-center"><?php echo $dataLoa['BRANCH_ID']?></td>
                                       <td class="td-center"><?php echo $dataLoa['FULLNAME']?></td>
                                       <td class="td-center"><?php echo $dataLoa['JOB_ID']?></td>
									  
                                        
                                   </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
							   
                           </table>
                           <span style="color:red"> *  Apabila Loa tidak sesuai dapat menghubungi Team IT melalui email Helpdesk 
							</span>
                          
                           <br><br> 
                           <input type="submit" name="submit1" class="btn btn-custom" value="SAVE" style="width:200px;">      
							<?php }else{ ?>
								<table class="table table-bordered table-stripped" style="width:100%;font-size:12px;">
									<thead>
										<tr>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;">LOA CA NON AKTIF</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align:center;">Silahkan cari cabang terlebih dahulu</td>
										</tr>
									</tbody>
								</table>
							<?php } ?>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#history').DataTable({
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
} );
</script>
</script>