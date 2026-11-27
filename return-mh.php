<?php
$assignment_id = $_GET['id'];
$req_id = $_GET['request_id'];

$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
$param = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
$data = sqlsrv_fetch_array($exec);

if(isset($_POST['submit'])){
	$request_id=$_POST['request_id'];
	$assignment_id=$_POST['assignment_id'];
	$order_no=$_POST['order_no'];
	$notes=$_POST['notes'];
	
	$call = "{call SP_INSERT_RESPONSE_RETURN(?,?,?,?,?)}";
	$param = array(array($assignment_id, SQLSRV_PARAM_IN),array($request_id, SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN),array($notes, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
	
	//update status jadi finish
	$call4 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param4 = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('3', SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_defaults(), true)); 
	$data4= sqlsrv_fetch_array($exec4);
	
	if($exec){
		echo"<script>alert('Data berhasil dikembalikan');window.location='index.php?page=hasil-pengecekan&USERNAME=".$_GET['USERNAME']."'</script>";
	}else{
		echo"<script>alert('Data gagal dikembalikan');history.back();</script>";
	}
}
?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
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
								<td><?php echo $data['ID_NO'];?></td>
							</tr>
							<tr>
								<td>Nama Customer</td>
								<td>:</td>
								<td><?php echo $data['CUSTOMER_NAME'];?></td>
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
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<form action="" method="post">
							<input type="hidden" name="request_id" value="<?php echo $req_id;?>">
							<input type="hidden" name="assignment_id" value="<?php echo $assignment_id;?>">
							<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
							<div class="form-group">
								<label>Masukan Note</label>
								<textarea name="notes" class="form-control" rows="5" placeholder="Masukan alasan kenapa order ini di kembalikan"></textarea>
							</div>
							<div class="pull-right">
								<input type="submit" class="btn btn-custom" value="SUBMIT" name="submit">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

