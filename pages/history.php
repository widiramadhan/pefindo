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
				<table class="table table-bordered">
					<tr>
						<th class="th-custom">NO</th>
						<th class="th-custom">PROSPECT NO</th>
						<th class="th-custom">PEFINDO ID</th>
						<th class="th-custom">NAME</th>
						<th class="th-custom">CUSTOMER TYPE</th>
						<th class="th-custom">CREATE DATE</th>
						<th class="th-custom" width="200">ACTION</th>
					</tr>
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
							<a href="index.php?page=scoring-individual&id=<?php echo $data['PEFINDO_ID'];?>" class="btn btn-primary btn-sm" title="detail"><i class="fa fa-eye"></i></a>
							<a href="history-delete.php?id=<?php echo $data['PEFINDO_MAPPING_ID'];?>&type=<?php echo $data['CUST_TYPE'];?>" class="btn btn-danger btn-sm" title="delete"><i class="fa fa-trash-o"></i></a>
						</td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>