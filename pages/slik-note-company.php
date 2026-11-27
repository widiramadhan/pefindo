<?php
$id = $_GET['id'];
$user = $_GET['USERNAME'];

if (isset($_POST['submit'])) {
	$note = $_POST['note'];

	# Update status menjadi reject
	$call = "{call CPY_UPDATE_SLIK_RESULT(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN), array(24, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));


	//update kapan dia selesai ngerjain tasklist
	$call1 = "{call SP_UPDATE_PERFORMANCE_ACTIVITY(?)}";
	$param1 = array(array($id, SQLSRV_PARAM_IN));
	$exec1 = sqlsrv_query($conn, $call1, $param1) or die(print_r(sqlsrv_errors(), true));

	$call2 = "{call SP_INSERT_NOTE(?,?,?)}";
	$param2 = array(array($id, SQLSRV_PARAM_IN), array($note, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query($conn, $call2, $param2) or die(print_r(sqlsrv_errors(), true));


	if ($exec2) {
		echo "<script>alert('Data berhasil di Reject');window.location='index.php?USERNAME=" . $user . "&page=pefindonodata-piloting';</script>";
	} else {
		echo "<script>alert('Error, hubungi administrator');history.back();</script>";
	}
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Reject Note</h4>
				<p class="category">Please input your reject note</p>
				<hr>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="form-group">
						<label>Your Note :</label>
						<textarea name="note" class="form-control" rows="5" placeholder="Input your note"></textarea>
					</div>
					<input type="submit" class="btn btn-primary" name="submit" value="SUBMIT" style="width:100%;">
				</form>
			</div>
		</div>
	</div>
</div>