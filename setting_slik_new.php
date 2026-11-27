<?php

$user = $_GET['USERNAME'];

$callNormal = "{call SP_GET_INFO_DATE_SLIK}";
$execNormal = sqlsrv_query($conn, $callNormal) or die(print_r(sqlsrv_errors(), true));
$dataNormal = sqlsrv_fetch_array($execNormal);

$callNormal2 = "{call SP_GET_INFO_DATE_SLIK_SABTU}";
$execNormal2 = sqlsrv_query($conn, $callNormal2) or die(print_r(sqlsrv_errors(), true));
$dataNormal2 = sqlsrv_fetch_array($execNormal2);

$callStatSlik = "{call SP_GET_STATUS_SLIK}";
$execStatSlik = sqlsrv_query($conn, $callStatSlik) or die(print_r(sqlsrv_errors(), true));
$dataStatSlik = sqlsrv_fetch_array($execStatSlik);

$callLock = "{call SP_GET_SLIK_LOCK}";
$execLock = sqlsrv_query($conn, $callLock) or die(print_r(sqlsrv_errors(), true));
$dataLock = sqlsrv_fetch_array($execLock);



if (isset($_POST['submit1'])) {
	$jam_kerja_from = $_POST['jam_kerja_from'];
	$jam_kerja_to = $_POST['jam_kerja_to'];


	$queryInsert = "{call SP_UPDATE_TIME_SLIK(?,?,?)}";
	$parameterInsert = array(
		array($jam_kerja_from, SQLSRV_PARAM_IN),
		array($jam_kerja_to, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}

if (isset($_POST['submit2'])) {
	$jam_kerja_from = $_POST['jam_kerja_from2'];
	$jam_kerja_to = $_POST['jam_kerja_to2'];

	$queryInsert = "{call SP_UPDATE_TIME_SLIK_SABTU(?,?,?)}";
	$parameterInsert = array(
		array($jam_kerja_from, SQLSRV_PARAM_IN),
		array($jam_kerja_to, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}
if (isset($_POST['submit3'])) {
	$slik_khusus_2w = $_POST['slik_khusus_2w'];


	$queryInsert = "{call SP_UPDATE_SLIK_STAT_2W(?,?)}";
	$parameterInsert = array(
		array($slik_khusus_2w, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}
if (isset($_POST['submit4'])) {
	$slik_khusus = $_POST['slik_khusus'];


	$queryInsert = "{call SP_UPDATE_SLIK_STAT_GENERAL(?,?)}";
	$parameterInsert = array(
		array($slik_khusus, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}
if (isset($_POST['submitlock'])) {


	$queryInsert = "{call SP_UPDATE_SLIK_LOCK}";

	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}
if (isset($_POST['submitSlikError'])) {
	$slik_error = $_POST['slik_error'];


	$queryInsert = "{call SP_UPDATE_SLIK_STAT_ALL(?,?,?,?)}";
	$parameterInsert = array(
		array(2, SQLSRV_PARAM_IN),
		array($slik_error, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN),
		array('', SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}
if (isset($_POST['submitPefindoError'])) {
	$slik_pefindo_error1 = $_POST['slik_pefindo_error1'];
	$slik_pefindo_error2 = $_POST['slik_pefindo_error2'];

	if ($slik_pefindo_error1 == 'ON' && $slik_pefindo_error2 == 'ON') {
		echo "	
		<script>alert('Hanya boleh salah satu yang ON');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
		exit();
	} else {

		$queryInsert = "{call SP_UPDATE_SLIK_STAT_ALL(?,?,?,?)}";
		$parameterInsert = array(
			array(3, SQLSRV_PARAM_IN),
			array($slik_pefindo_error1, SQLSRV_PARAM_IN),
			array($user, SQLSRV_PARAM_IN),
			array($slik_pefindo_error2, SQLSRV_PARAM_IN)

		);
		//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
		//exit();
		$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

		if ($execInsert) {
			echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
		} else {
			echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}
}
if (isset($_POST['submitNasabah'])) {
	$stat_nasabah = $_POST['check_nb'];


	$queryInsert = "{call SP_UPDATE_SLIK_STAT_ALL(?,?,?,?)}";
	$parameterInsert = array(
		array(4, SQLSRV_PARAM_IN),
		array($stat_nasabah, SQLSRV_PARAM_IN),
		array($user, SQLSRV_PARAM_IN),
		array('', SQLSRV_PARAM_IN)

	);
	//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
	//exit();
	$execInsert = sqlsrv_query($conn, $queryInsert, $parameterInsert) or die(print_r(sqlsrv_defaults(), true));

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "&page=setting_slik'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}

//*/


?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>


<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />

<style>
	.img-custom {
		width: 100%;
		height: 200px;
	}

	.th-custom {
		text-align: center;
		vertical-align: middle;
		background-color: #035c7a;
	}

	.td-custom {
		text-align: center;
		vertical-align: middle;
	}

	.pagination>li>a,
	.pagination>li>span {
		background-color: #FFF;
		color: #035c7a;
	}

	.pagination>li.active>a,
	.pagination>li.active>span {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a:hover,
	.pagination>li.active>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.focus>a,
	.pagination>li.focus>span:hover {
		background-color: #035c7a;
		color: #FFF;
	}

	.pagination>li.active>a.page-link,
	.pagination>li.active>span.page-link {
		background-color: #035c7a;
		color: #FFF;
	}
</style>
<!--<form action="" method="post">-->

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
<div class="row">
	<div class="col-md-12">
		<form enctype="multipart/form-data" name="form_mutasi_kry" id="form_mutasi_kry" action="" method="post">
			<div class="card">
				<div class="content">
					<div class="header">
						<h4 class="title">Setting Time Slik</h4>
						<p class="category">Setting Time Slik</p>
					</div>
					<br>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#home">Slik Harian</a></li>
						<li><a data-toggle="tab" href="#menu3">Open Slik</a></li>
						<!--<li><a data-toggle="tab" href="#menu4">Slik Error</a></li>-->
						<li><a data-toggle="tab" href="#menu5">Pefindo Error</a></li>
						<li><a data-toggle="tab" href="#menu6">Pengecekan Nasabah</a></li>
					</ul>
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active">
							<div class="content">

								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Jam Normal Slik (Senin - Jumat)</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Dari Jam </label>
											<input type="time" name="jam_kerja_from" class="form-control" value="<?php echo $dataNormal['TIME_FROM']; ?>">


										</div>
									</div>

									<div class="col-md-5">
										<div class="form-group">
											<label>Sampai Jam</label>
											<input type="time" name="jam_kerja_to" class="form-control" value="<?php echo $dataNormal['TIME_END']; ?>">
										</div>
									</div>
								</div>


								<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Jam Normal Slik (Sabtu)</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Dari Jam </label>
											<input type="time" name="jam_kerja_from2" class="form-control" value="<?php echo $dataNormal2['TIME_FROM']; ?>">


										</div>
									</div>

									<div class="col-md-5">
										<div class="form-group">
											<label>Sampai Jam</label>
											<input type="time" name="jam_kerja_to2" class="form-control" value="<?php echo $dataNormal2['TIME_END']; ?>">
										</div>
									</div>
								</div>


								<input type="submit" name="submit2" id="submit2" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>

							<?php /* 
				<div class="content">
				
				
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Slik Aktif Kondisi Khusus</td>
									</tr>
									
								
								</table>
							</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label>Jika OFF Maka Pengecekan Slik Tidak Dibatasi Hari Dan Waktu </label>
								<select name="slik_khusus" class="form-control" >
														<option value="ON"  <?php if ($dataStatSlik['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >ON</option>
														<option value="OFF">OFF</option>
													
								</select>   
								
								
							
							</div>
						</div>
						</div>
						
						
						<input type="submit" name="submit3" id="submit3" class="btn btn-custom" value="UPDATE" style="width:200px;" >
						
						
					
					
				
				</div>
				 */ ?>

						</div>







						<div id="menu1" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Slik 2W</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Jika OFF Maka Pengecekan Slik 2W di Mos akan Diubah Menggunakan Pefindo </label>
											<select name="slik_khusus_2w" class="form-control">
												<option value="ON" <?php if ($dataStatSlik['STATUS_SLIK_2W'] == "ON") {
																		echo 'selected';
																	} ?>>ON</option>
												<option value="OFF" <?php if ($dataStatSlik['STATUS_SLIK_2W'] == "OFF") {
																		echo 'selected';
																	} ?>>OFF</option>

											</select>



										</div>
									</div>
								</div>


								<input type="submit" name="submit3" id="submit3" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>
						</div>
						<div id="menu2" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting General</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Jika OFF Maka Seluruh Pengecekan Slik Non Aktif</label>
											<select name="slik_khusus" class="form-control">
												<option value="ON" <?php if ($dataStatSlik['STATUS_SLIK_GENERAL'] == "ON") {
																		echo 'selected';
																	} ?>>ON</option>
												<option value="OFF" <?php if ($dataStatSlik['STATUS_SLIK_GENERAL'] == "OFF") {
																		echo 'selected';
																	} ?>>OFF</option>

											</select>



										</div>
									</div>
								</div>


								<input type="submit" name="submit4" id="submit4" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>

						</div>



						<div id="menu3" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Slik Open</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Jumlah Lock Slik</label>
											<input type="input" name="slik_lock" class="form-control" value="<?php echo $dataLock['LOCK']; ?>" readonly>



										</div>
									</div>
								</div>


								<input type="submit" name="submitlock" id="submitlock" class="btn btn-custom" value="OPEN SLIK" style="width:200px;">





							</div>

						</div>



						<div id="menu4" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting General</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Jika ON Maka : </label>
											<Br>
											<label>- Seluruh Pengecekan Slik Non Aktif</label>
											<label>- Pefindo Tidak Ditemukan Otomatis Finish Dengan Hasil Not Found</label>
											<label>- Pefindo Ditemukan Sesuai : Otomatis Finish</label>
											<label>- Pefindo Ditemukan Tidak Sesuai : Dianggap Not Found</label>
											<select name="slik_error" class="form-control">
												<option value="ON" <?php if ($dataStatSlik['STATUS_SLIK_ERROR'] == "ON") {
																		echo 'selected';
																	} ?>>ON</option>
												<option value="OFF" <?php if ($dataStatSlik['STATUS_SLIK_ERROR'] == "OFF") {
																		echo 'selected';
																	} ?>>OFF</option>

											</select>



										</div>
									</div>
								</div>


								<input type="submit" name="submitSlikError" id="submitSlikError" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>

						</div>


						<div id="menu5" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Pefindo Error</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<table class="table table-bordered">
												<tr>
													<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Pefindo Error From Server</td>
												</tr>


											</table>
											<label>Jika ON Maka : </label>
											<Br>
											<label>- Seluruh Pengecekan Pefindo Non Aktif</label>
											<Br>
											<label>- Pengecekan Tidak Meng-hit Pefindo</label>
											<Br>
											<label>- Langsung Masuk Ke Tasklist Slik</label>

											<select name="slik_pefindo_error1" class="form-control">
												<option value="ON" <?php if ($dataStatSlik['STATUS_PEFINDO_ERROR_1'] == "ON") {
																		echo 'selected';
																	} ?>>ON</option>
												<option value="OFF" <?php if ($dataStatSlik['STATUS_PEFINDO_ERROR_1'] == "OFF") {
																		echo 'selected';
																	} ?>>OFF</option>

											</select>



										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<table class="table table-bordered">
												<tr>
													<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Pefindo Off From User</td>
												</tr>


											</table>
											<label>Jika ON Maka : </label>
											<Br>
											<label>- Seluruh Pengecekan Pefindo Non Aktif</label>
											<Br>
											<label>- Pengecekan Tetap hit Pefindo untuk mendapatkan hasil pengecekan</label>
											<Br>
											<label>- Langsung Masuk Ke Tasklist Slik</label>

											<select name="slik_pefindo_error2" class="form-control">
												<option value="ON" <?php if ($dataStatSlik['STATUS_PEFINDO_ERROR_2'] == "ON") {
																		echo 'selected';
																	} ?>>ON</option>
												<option value="OFF" <?php if ($dataStatSlik['STATUS_PEFINDO_ERROR_2'] == "OFF") {
																		echo 'selected';
																	} ?>>OFF</option>

											</select>



										</div>
									</div>



									<input type="submit" name="submitPefindoError" id="submitPefindoError" class="btn btn-custom" value="UPDATE" style="width:200px;">





								</div>

							</div>

						</div>


						<div id="menu6" class="tab-pane fade">
							<div class="content">


								<div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Setting Pengecekan Nasabah</td>
										</tr>


									</table>
								</div>
								<div class="row">
									<div class="col-md-5">
										<div class="form-group">
											<label>Jika Dipilih : </label>
											<br>
											<label>- SLIK : Pefindo hanya digunakan untuk menampilkan status data ditemukan/tidak, sementara hasil akhir tetap menggunakan SLIK.</label>
											<label>- Pefindo : Melakukan hit ke Pefindo secara penuh.</label>
											<label>- CLIK : Pefindo hanya digunakan untuk menampilkan status data ditemukan/tidak, sementara hasil akhir tetap menggunakan CLIK.</label>

											<select name="check_nb" class="form-control">
												<option value="SLIK" <?php if ($dataStatSlik['STATUS_SLIK_ERROR'] == "OFF") {
																			echo 'selected';
																		} ?>>SLIK</option>
												<option value="PEFINDO" <?php if ($dataStatSlik['STATUS_SLIK_ERROR'] == "ON" && $dataStatSlik['STATUS_CLICK'] == "OFF") {
																			echo 'selected';
																		} ?>>PEFINDO</option>
												<option value="CLIK" <?php if ($dataStatSlik['STATUS_CLICK'] == "ON") {
																			echo 'selected';
																		} ?>>CLIK</option>

											</select>



										</div>
									</div>
								</div>


								<input type="submit" name="submitNasabah" id="submitNasabah" class="btn btn-custom" value="UPDATE" style="width:200px;">





							</div>

						</div>


					</div>
				</DIV>
			</DIV>

			<script src="assets/js/jqueryrotate.min.js"></script>
			<script src="assets/clipboard.js-master/dist/clipboard.min.js"></script>