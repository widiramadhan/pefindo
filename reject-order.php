<?php
$order_no=$_GET['no'];

if(isset($_POST['submit'])){
	$order_no = $_POST['order_no'];
	$reject_reason = $_POST['reject_reason'];
	$reject_note = $_POST['reject_note'];
	$user = $_GET['USERNAME'];
	
	$call = "{call SP_INSERT_REJECT_NOTE(?,?,?,?)}";
	$param = array(
		  array($order_no, SQLSRV_PARAM_IN),
		  array($reject_reason, SQLSRV_PARAM_IN),
		  array($reject_note, SQLSRV_PARAM_IN),
		  array($user, SQLSRV_PARAM_IN)
		);
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	if($exec){
		echo"<script>alert('Order berhasil di reject');
			window.location='index.php?page=hasil-pengecekan&USERNAME=".$user."'</script>";
	}else{
		echo"<script>alert('Order gagal di reject');
			history.back();</script>";
	}
}
?>
<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="header">
				<h4 class="title">Reject Order</h4>
				<p class="category"></p>
				<hr>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<form action="" method="post">
							<div class="form-group">
								<label>Nomor Order</label>
								<input type="text" class="form-control" disabled value="<?php echo $order_no;?>">
								<input type="hidden" name="order_no" value="<?php echo $order_no;?>">
							</div>
							<div class="form-group">
								<label>Reject Reason</label>
								<select name="reject_reason" class="form-control">
									<option value="CO2 - SESUAI DENGAN KETENTUAN BLACKLIST YANG BERLAKU (REGULASI MINIMUM TDP)">CO2 - SESUAI DENGAN KETENTUAN BLACKLIST YANG BERLAKU (REGULASI MINIMUM TDP)</option>
									<!--<option value="E01 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (DSR > 60%)">E01 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (DSR > 60%)</option>
									<option value="E03 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (REGULASI MINIMUM TDP)">E03 – DSR TIDAK SESUAI DENGAN KEBIJAKAN YANG BERLAKU (REGULASI MINIMUM TDP)</option>-->
								</select>
							</div>
							<div class="form-group">
								<label>Reject Notes</label>
								<textarea name="reject_note" class="form-control" rows="3" placeholder="Reject Notes" required></textarea>
							</div>
							<hr>
							<div class="pull-right">
								<input type="submit" name="submit" class="btn btn-custom" value="SUBMIT">
								<a href="index.php?page=hasil-pengecekan&USERNAME=<?php echo $_GET['USERNAME'];?>" class="btn btn-custom">BATAL</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>