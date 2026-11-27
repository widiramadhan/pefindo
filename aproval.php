 <?php
   $user=$_GET['USERNAME'];
   $branchfrom='';
   $branchto='';
   $datefrom='';
   $dateto='';
   $no_prospect='';

   $sp = "{call sp_COuserFindByBranchID (?)}"; 
   $param1 = array(array($user, SQLSRV_PARAM_IN));
   $ex = sqlsrv_query( $conn, $sp,$param1) or die( print_r( sqlsrv_errors(), true)); 
   $exx = sqlsrv_query( $conn, $sp,$param1) or die( print_r( sqlsrv_errors(), true)); 

   if (isset($_POST['branchfrom'])) {
       $branchfrom=trim($_POST['branchfrom']);
       $branchto=trim($_POST['branchto']);
       $datefrom=trim($_POST['datefrom']);
       $dateto=trim($_POST['dateto']);
       $no_prospect=trim($_POST['no_prospect']);
       $_SESSION['brfrom']=$branchfrom;    
       $_SESSION['brto']=$branchto;    
       $_SESSION['dtfrom']=$datefrom;    
       $_SESSION['dtto']=$dateto;    
       $_SESSION['orderno']=$no_prospect; 
   } 
    //   var_dump($branchfrom);
    //    var_dump($branchto);
    //    exit();
      
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
				<h4 class="title">List Approval Document</h4>
				<!-- <p class="category">Sistem Informasi Debitur</p> -->
			</div>
			<div class="content">
				<form action="#" method="post">
                <div class="row">
						<div class="col-md-3">
							<label>Branch ID From</label>	
							<div class="form-group">
                            <select class="form-control" name="branchfrom">
                            <!-- <option>-select-</option> -->
                            <?php
                            
                           while ($cabang = sqlsrv_fetch_array($ex)) {?>
                               <option value="<?php echo $cabang['Branchid'] ?>" <?php if($cabang['Branchid']==$branchfrom){ echo 'selected';};?>><?php echo $cabang['BranchName']?></option>                           <?php
                           } 
                            ?>
                            </select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Branch ID To</label>
                                <select class="form-control" name="branchto">
                                <!-- <option>-select-</option> -->
                                <?php
                            
                           while ($cabang = sqlsrv_fetch_array($exx)) {?>
                               <option value="<?php echo $cabang['Branchid'] ?>" <?php if($cabang['Branchid']==$branchto){ echo 'selected';}?>><?php echo $cabang['BranchName']?></option>                           <?php
                           } 
                            ?>
                                </select>
							</div>
						</div>						 
                </div>
					<div class="row">
						 
						<div class="col-md-3">
							<div class="form-group">
								<label>Date From</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" autocomplete="off" name="datefrom" id="startDate" placeholder="Date from" value="<?php echo $datefrom?>">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Date To</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" autocomplete="off" name="dateto" id="endDate" placeholder="Date to" value="<?php echo $dateto?>">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-3">
							<label>Order No</label>	
							<div class="form-group">
								<input type="text" name="no_prospect" class="form-control" autocomplete="off" placeholder="Order Number" value="<?php echo $no_prospect?>">
							</div>
						</div>
                        
                </div>
					<div class="pull-left">
						<button type="submit" name="submit" class="btn btn-primary" onclick="submit()">Search</button>
					</div>

                    <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">APPROVAL NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ORDER NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">CUSTOMER NAME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">USERNAME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
									 
									</tr>
								</thead>
								<tbody>
									<?php
                                  
										$no=0;
										$call = "{call  SP_APPROVAL_GETLIST_APPROVAL(?,?,?,?,?,?)}";
                                        $param = array(
                                        array($branchfrom, SQLSRV_PARAM_IN),
                                        array($branchto, SQLSRV_PARAM_IN),
                                        array($no_prospect, SQLSRV_PARAM_IN),
                                        array($user, SQLSRV_PARAM_IN),
                                        array($datefrom, SQLSRV_PARAM_IN),
                                        array($dateto, SQLSRV_PARAM_IN));
										$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
										while($data = sqlsrv_fetch_array($exec)){
                                        $no++;
                                            // var_dump($data);exit();
									?> 
									<tr>
										
										<td class="td-center"><?php echo $no;?></td>
										<td class="td-center"><?php echo $data['BRANCH_ID']?></td>
										<td class="td-center"><?php echo $data['APV_NO']?></td>
										<td class="td-center"><?php echo $data['TRX_NO']?></td>
										<td class="td-center"><?php echo $data['CUSTOMER_NAME']?></td>
										<td class="td-center"><?php echo $data['USERNAME'];?></td>
										<td class="td-center"><?php echo $data['FINAL_STATUS'];?></td>
										<td class="td-center"><a href="<?php echo 'index.php?page=aproval-detail&USERNAME='.$user.'&trxno='.$data['TRX_NO'].'&apvno='.$data['APV_NO']?>">Select</a></td>
									 
										 
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
} );
</script>