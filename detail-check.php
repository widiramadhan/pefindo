<?php
require_once("config/configuration.php");
require_once("config/connection.php");

$getUsername=$_GET['USERNAME'];
$order_no = $_GET['order_no'];
$nik = $_GET['nik'];
$assignment_id = $_GET['id'];
$req_id = $_GET['request_id'];

$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
$param = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
$data = sqlsrv_fetch_array($exec);

$call3 = "{call SP_GET_DETAIL_CHECK_REQUEST_MH_KTP(?,?,?)}";
$param3 = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN));
$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_errors(), true));
$data3 = sqlsrv_fetch_array($exec3);

$pengkinian_data = 0;
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
			</div>
			<div class="content">		
				<div class="row">
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nomor Order</td>
								<td>:</td>
								<td><?php echo $data['ORDER_NO'];?></td>
							</tr>
							<tr>
								<td>NIK</td>
								<td>:</td>
								<td><?php echo $nik;?></td>
							</tr>
							<tr>
								<td>Nama Customer</td>
								<td>:</td>
								<td><?php echo $data3['CUSTOMER_NAME'];?></td>
							</tr>
						</table>
					</div>
					<div class="col-md-6">
						<table class="table">
							<tr>
								<td>Nama Dealer</td>
								<td>:</td>
								<td><?php echo $data['DEALER_NAME'];?></td>
							</tr>
							<tr>
								<td>User Request</td>
								<td>:</td>
								<td><?php echo $data['MH'];?></td>
							</tr>
							<tr>
								<td>Tanggal Request</td>
								<td>:</td>
								<td><?php echo $data['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title"></h4>
				<p class="category"></p>
			</div>
			<div class="content">		
				<div class="row">
					<div class="col-md-12">
						<?php
						$call2 = "{call SP_GET_RESPONSE_RESULT_DUKCAPIL(?,?)}";
						$param2 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN));
						$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_defaults(), true)); 
						while($data2 = sqlsrv_fetch_array($exec2)){
						?>
						<table class="table table-bordered" style="width:100%;font-size:12px;">
							<thead>
								<tr>
									<th style="color:#FFF;font-weight:bold;background-color:#035c7a;" colspan="2">HASIL PENGECEKAN <?php echo $data2['SOURCE'];?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="width:50%;">Hasil Pengecekan</td>
									<td style="width:50%;">
										<?php 
											if($data2['RESULT'] == "PENGKINIAN DATA"){
												$call3 = "{call SP_GET_RESPONSE_RESULT_ERROR_DETAIL(?,?)}";
												$param3 = array(array($data['ORDER_NO'], SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN));
												$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_defaults(), true)); 
												while($data3 = sqlsrv_fetch_array($exec3)){
													echo strtoupper($data3['MSG_NAME']).", ";
												}
												$pengkinian_data = 1;
											}else{
												echo $data2['RESULT'];
											}
										?>
									</td>
								</tr>
								<tr>
									<td style="width:50%;">Checked By</td>
									<td style="width:50%;"><?php echo $data2['USER_CREATE'];?></td>
								</tr>
								<tr>
									<td style="width:50%;">Checked Date</td>
									<td style="width:50%;"><?php if($data2['CREATE_DATE']<>NULL){echo $data2['CREATE_DATE']->format('Y-m-d H:i:s');}?></td>
								</tr>
							</tbody>
						</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>