<?php
$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query($conn, $callDate) or die(print_r(sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);
?>
<div class="row">
	<div class="col-md-12">
		<?php if ($dataDate['VOID'] == '1') { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
				<strong>PERHATIAN ! <br>
					UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
				</strong>
			</div>
		<?php } ?>

		<div class="card">
			<div class="header">
				<h4 class="title">Reject Note</h4>
				<p class="category">Your Task is Rejected, check reject note</p>
				<hr>
			</div>
			<div class="content">
				<?php
				$id = $_GET['id'];

				$call = "{call SP_GET_NOTE(?)}";
				$param = array(array($id, SQLSRV_PARAM_IN));
				$exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
				while ($data = sqlsrv_fetch_array($exec)) {
				?>
					<label>REJECTED BY : </label><br>
					<p class="category">
						<b><?php echo strtoupper($data['USER_CREATE']) . "</b> - " . $data['CREATE_DATE']->format("d F Y H:i:s"); ?>
					</p>
					<p class="category"><?php echo $data['NOTE_HO']; ?></p>
					<hr>
				<?php } ?>
				<span class="text-danger">
					<b>NOTE :</b><br>
					* Silahkan ikuti instruksi yang diberikan credit HO<br>
					* Jika sudah, silahkan klik tombol dibawah ini untuk request task kembali
				</span>
				<br><br>

				<?php if ($dataDate['VOID'] == '1') : ?>
					<a href="#" class="btn btn-primary" style="width:100%;" disabled>REQUEST AGAIN</a>
				<?php elseif ($dataDate['VOID'] == '0') : ?>
					<a href="pages/update-progress-company.php?USERNAME=<?php echo $user; ?>&id=<?php echo $id; ?>&flag=3" class="btn btn-primary" style="width:100%;">REQUEST AGAIN</a>
				<?php endif; ?>

			</div>
		</div>
	</div>
</div>