<?php
$user = $_GET['USERNAME'];
if($user == 'iman.santoso' || $user == 'djoko.andrew' || $user == 'moh.junaedi' || $user == 'IMAN.SANTOSO' || $user == 'DJOKO.ANDREW' || $user == 'MOH.JUNAEDI' || $user == 'NOVRIKAWATI' || $user == 'KIKI.AMALIA' || $user == 'novrikawati' || $user == 'kiki.amalia' || $user == 'AHMAD.HABIBI' || $user == 'DENY.SAPUTRA' || $user == 'Haris.Siswanto' || $user == 'HARIS.SISWANTO' || $user == 'Yose.Kertapati' || $user == 'YOSE.KERTAPATI'	|| $user == 'Muhammad' || $user == 'MUHAMMAD' || $user == 'Ramandona.Dinara' || $user == 'RAMANDONA.DINARA'){ 
	$call = "{call SP_GET_DASHBOARD_COUNT_ADMIN}";
	$param = null;
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
}else{
	$call = "{call SP_GET_DASHBOARD_COUNT_CABANG(?)}";
	$param = array(array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
}
?>
<div class="row">
	<div class="col-md-3">
		<div class="card card-stats">
			<div class="content all-icons" style="padding:30px;">
				<div class="row">
					<div class="col-md-4">
						<h1 class="card-title" style="text-align:center;"><i class="fa fa-bar-chart mb-0 text-muted"></i></h1>
					</div>
					<div class="col-md-8">
						<h6 class="card-title text-uppercase text-muted mb-0">HIT DUKCAPIL</h6>
						<span class="h2 font-weight-bold mb-0"><?php echo $data['TOTAL_HIT_DUKCAPIL'];?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card card-stats">
			<div class="content all-icons" style="padding:30px;">
				<div class="row">
					<div class="col-md-4">
						<h1 class="card-title" style="text-align:center;"><i class="fa fa-credit-card mb-0 text-muted"></i></h1>
					</div>
					<div class="col-md-8">
						<h6 class="card-title text-uppercase text-muted mb-0">SCORING PEFINDO</h6>
						<span class="h2 font-weight-bold mb-0"><?php echo $data['TOTAL_SCORING_PEFINDO'];?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card card-stats">
			<div class="content all-icons" style="padding:30px;">
				<div class="row">
					<div class="col-md-4">
						<h1 class="card-title" style="text-align:center;"><i class="fa fa-file-text mb-0 text-muted"></i></h1>
					</div>
					<div class="col-md-8">
						<h6 class="card-title text-uppercase text-muted mb-0">Tasklist SLIK</h6>
						<span class="h2 font-weight-bold mb-0"><?php echo $data['TOTAL_TASKLIST_SLIK'];?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card card-stats">
			<div class="content all-icons" style="padding:30px;">
				<div class="row">
					<div class="col-md-4">
						<h1 class="card-title" style="text-align:center;"><i class="fa fa-list-alt mb-0 text-muted"></i></h1>
					</div>
					<div class="col-md-8">
						<h6 class="card-title text-uppercase text-muted mb-0">Aplikasi Masuk</h6>
						<span class="h2 font-weight-bold mb-0"><?php echo $data['TOTAL_APLIKASI_IN'];?></span>
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
				<h4 class="title">Dashboard</h4>
				<p class="category">Host to Host SFI - Pefindo</p>
			</div>
			<div class="content all-icons">
				<div class="row">
					<div style="padding:30px;font-size:14px;color:#AAA;">
						Selamat datang, <?php echo $_GET['USERNAME'];?>.<br>
						Silahkan pilih menu Individual untuk pengecekan Prospek personal, dan pilih menu Company untuk pengecekan Prospek Perusahaan
						<br><br><br><br><br><br><br><br><br><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	