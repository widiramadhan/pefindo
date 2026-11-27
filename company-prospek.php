<?php
$prospect_no=$_POST['prospect_no'];
$npwp=$_POST['npwp'];
$nama=$_POST['name'];

$call = "{call PEFINDO_GETDATA_PEMEGANG_SAHAM_COMPANY(?,?)}";
$param = array(array($prospect_no, SQLSRV_PARAM_IN),array('1', SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	background-color:#035c7a;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"><b><?php echo $prospect_no;?></b></h4>
				<p class="category">Data Prospek berdasarkan Prospek yang dipilih</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<b>DATA PERUSAHAAN :</b>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor NPWP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom"><?php echo $prospect_no;?></td>
										<td class="td-custom"><?php echo $npwp;?></td>
										<td><?php echo $data['CUST_NAME'];?></td>
										<td class="td-custom">
											<form action="index.php?page=company-check&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
												<input type="hidden" name="npwp" value="<?php echo $npwp;?>">
												<input type="hidden" name="name" value="<?php echo $data['CUST_NAME'];?>">
												<button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
											</form>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<br><br>
			</div>
		</div>
	</div>
</div>						