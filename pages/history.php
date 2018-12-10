<style>
.th-custom{
	text-align:center;
}
.td-center{
	text-align:center;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">History</h4>
				<p class="category">History Activity Request</p>
			</div>
			<div class="content">
				<table class="table table-bordered table-striped" id="history">
					<thead>
						<tr>
							<th class="th-custom">NO</th>
							<th class="th-custom">PROSPECT NO</th>
							<th class="th-custom">PEFINDO ID</th>
							<th class="th-custom">NAME</th>
							<th class="th-custom">CUSTOMER TYPE</th>
							<th class="th-custom">CREATE DATE</th>
							<th class="th-custom" width="200">ACTION</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$no=0;
							$call = "{call SP_GET_HISTORY}";
							$exec = sqlsrv_query( $conn, $call) or die( print_r( sqlsrv_errors(), true)); 
							while($data = sqlsrv_fetch_array($exec)){
								$no++;
						?>
						<tr>
							<td class="td-center"><?php echo $no;?></td>
							<td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
							<td class="td-center"><?php echo $data['PEFINDO_ID'];?></td>
							<td class="td-center"><?php echo $data['CUST_NAME'];?></td>
							<td class="td-center"><?php if($data['CUST_TYPE']=="P"){echo"Individual";}else{echo"Company";}?></td>
							<td class="td-center"><?php echo $data['CREATE_DATE']->format("d-m-Y");?></td>
							<td class="td-center">
								<?php 
								if($data['CUST_TYPE']=="P"){
								?>
								<a href="index.php?username=<?php echo $user;?>&page=scoring-individual&id=<?php echo $data['PEFINDO_ID'];?>" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>
								<?php }else{?>
								<a href="index.php?username=<?php echo $user;?>&page=scoring-company&id=<?php echo $data['PEFINDO_ID'];?>" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>
								<?php
								}
								?>
								<a href="pages/history-delete.php?username=<?php echo $user;?>&id=<?php echo $data['PEFINDO_MAPPING_ID'];?>&type=<?php echo $data['CUST_TYPE'];?>" class="btn btn-danger btn-sm" title="delete"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
    $('#history').DataTable();
} );
</script>