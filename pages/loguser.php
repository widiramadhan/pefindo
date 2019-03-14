<?php
$callLOG = "{call SP_GET_BRANCH_BY_USER(?)}";
$paramsLOG = array(array($username, SQLSRV_PARAM_IN));
$execLOG = sqlsrv_query( $conn, $callLOG, $paramsLOG) or die( print_r( sqlsrv_errors(), true));
$dataLOG = sqlsrv_fetch_array($execLOG);
?>
<div class="card">
	<div class="header">
		<p class="name">USER CHECKING</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<th>Branch Id</th>
							<th>Branch Name</th>
							<th>User Name</th>
							<th>No Prospect</th>
							<th>Tanggal</th>
						</thead>
						<tbody>
							<tr>
								<td align="center"><?php echo $dataLOG['BRanchid'];?></td>
								<td align="center"><?php echo $dataLOG['Branchname'];?></td>
								<td align="center"><?php echo $dataLOG['USERNAME'];?>
								<td align="center"><?php echo $dataLOG['PROSPECT_NO'];?></td>
								<td align="center"><?php echo $dataLOG['CREATE_DATE'];?></td>
							</tr>
						</tbody>	
					</table>
				</div>	
			</div>		
		</div>		
	</div>				
</div>