<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>H2H SFI - PEFINDO</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/animate.min.css" rel="stylesheet" />
	<link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />
	<link href="assets/css/demo.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href='assets/css/fonts.css' rel='stylesheet' type='text/css'>
	<link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" type="text/css">
	<link rel="stylesheet" href="assets/css/jquery-ui.css">
	<link rel="stylesheet" href="assets/plugins/fancybox/source/jquery.fancybox.css?v=2.1.7" type="text/css"
		media="screen" />
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />

	<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
</head>

<?php
require_once "config/connection.php";
//error_reporting(0);
if (isset($_GET['USERNAME'])) {
	$user = $_GET['USERNAME'];
} else {
	echo "<script>window.location='access-denied.php'</script>";
}

if (isset($_POST['no_ktp'])) {
	$no_ktp_dkcupil = $_POST['no_ktp'];
} else {
	$no_ktp_dkcupil = "";
}

if (isset($_POST['prospect_no'])) {
	$prospect_dkcupil = $_POST['prospect_no'];
} else {
	$prospect_dkcupil = "";
}

# user branch Id
$bid = array();

$sp = "{call sp_COuserFindByBranchID (?)}";
$param1 = array(array($_GET['USERNAME'], SQLSRV_PARAM_IN));
$ex = sqlsrv_query($conn, $sp, $param1) or die(print_r(sqlsrv_errors(), true));
while ($data = sqlsrv_fetch_array($ex)) {
	$bid[] = $data['Branchid'];
}

# branch to piloting company
$sp_pilot = "{call CPY_CHECK_PILOTING_COMPANY}";
$param_pilot = array();
$exec_pilot = sqlsrv_query($conn, $sp_pilot, $param_pilot) or die(print_r(sqlsrv_errors(), true));
$is_piloting = false;

# baca data sambil memeriksa apakah branch ini termasuk branch untuk piloting
while ($data_pilot = sqlsrv_fetch_array($exec_pilot)) {
	$branch_to_pilot[] = $data_pilot['OFFICE_CODE'];

	if (in_array($data_pilot['OFFICE_CODE'], $bid)) {
		$is_piloting = true;
	}
}

/*
$sp_rak = "{call SP_BRANCH_PILOTING_RAK}";
$param_rak = array();
$exec_rak = sqlsrv_query($conn, $sp_rak, $param_rak) or die(print_r(sqlsrv_errors(), true));
$is_rak = false;

while ($data_rak = sqlsrv_fetch_array($exec_rak)) {
$branch_to_rak[] = $data_rak['OFFICE_CODE'];

if (in_array($data_rak['OFFICE_CODE'], $bid)) {
$is_rak = true;
}
}
 */


function hasAccessSP($conn, $user, $menuId)
{
	$tsql = "{CALL SP_HAS_USER_MENU_ACCESS(?, ?, ?)}";
	$allowed = 0; // akan diisi oleh OUTPUT param

	$params = [
		[&$user,    SQLSRV_PARAM_IN],
		[&$menuId,  SQLSRV_PARAM_IN],
		// PHPTYPE/SQLTYPE eksplisit agar aman untuk BIT
		array(&$allowed, SQLSRV_PARAM_OUT, SQLSRV_PHPTYPE_INT, SQLSRV_SQLTYPE_BIT)
	];

	// Lebih aman gunakan prepare + execute untuk OUTPUT param
	$stmt = sqlsrv_prepare($conn, $tsql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}

	if (!sqlsrv_execute($stmt)) {
		die(print_r(sqlsrv_errors(), true));
	}

	// Beberapa driver butuh next_result agar OUTPUT terisi
	sqlsrv_next_result($stmt);

	sqlsrv_free_stmt($stmt);



	return (bool)$allowed;
}

function hasAccessCabang($conn, $user)
{
	$tsql = "{CALL SP_HAS_USER_MENU_ACCESS_CABANG(?, ?)}";
	$allowed = 0; // will be filled by OUTPUT

	$params = array(
		array(&$user,    SQLSRV_PARAM_IN),
		// OUTPUT param for BIT:
		array(&$allowed, SQLSRV_PARAM_OUT, SQLSRV_PHPTYPE_INT, SQLSRV_SQLTYPE_BIT)
	);

	$stmt = sqlsrv_prepare($conn, $tsql, $params);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	if (!sqlsrv_execute($stmt)) {
		die(print_r(sqlsrv_errors(), true));
	}

	// Make sure OUTPUT param is populated
	sqlsrv_next_result($stmt);
	sqlsrv_free_stmt($stmt);

	return (bool)$allowed;
}



?>

<body>

	<div class="wrapper">
		<div class="sidebar" data-image="assets/img/sidebar-5.jpg">
			<div class="sidebar-wrapper" style="background-color: #035c7a">
				<div class="logo">
					<a href="index.php?USERNAME=<?php echo $user; ?>" class="simple-text">
						H2H SFI Customer Checking
					</a>
				</div>

				<ul class="nav">
					<?php

					if (hasAccessSP($conn, $user, 1)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>">
								<i class="pe-7s-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
					<?php endif;
					if (hasAccessSP($conn, $user, 2)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=individual-ho-new">
								<i class="pe-7s-user"></i>
								<p>Individual</p>
							</a>
						</li>

					<?php endif;
					if (hasAccessSP($conn, $user, 3)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=company-order-list">
								<i class="pe-7s-culture"></i>
								<p>Company</p>
							</a>
						</li>
					<?php endif;
					if (hasAccessSP($conn, $user, 4)):
					?>
						<?php if (hasAccessCabang($conn, $user)): ?>
							<li>
								<a href="index.php?USERNAME=<?php echo $user; ?>&page=pefindonodata">
									<i class="pe-7s-note2"></i>
									<p>Tasklist</p>
								</a>
							</li>
						<?php else: ?>
							<li>
								<a href="index.php?USERNAME=<?php echo $user; ?>&page=pefindonodata-piloting">
									<i class="pe-7s-note2"></i>
									<p>Tasklist</p>
								</a>
							</li>
					<?php endif;
					endif; ?>
					<?php if (hasAccessSP($conn, $user, 5)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=history">
								<i class="pe-7s-refresh-2"></i>
								<p>History</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 6)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=pengkinian-data-dukcapil">
								<i class="pe-7s-credit"></i>
								<p>Pengkinian Data</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 7)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=cek-ulang-dukcapil">
								<i class="pe-7s-pen"></i>
								<p>Cek Ulang Dukcapil</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 8)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-status-nikah">
								<i class="pe-7s-mail"></i>
								<p>Upload Dokumen</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 9)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-status-verifikasi">
								<i class="pe-7s-check"></i>
								<p>Upload Verifikasi Status</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 10)): ?>
						<li class="nav-item">
							<a href="#log" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-news-paper"></i>
								<p>Log <b class="caret"></b></p>
							</a>
							<div class="collapse " id="log">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=log-pefindo&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">PEFINDO</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=log-scoring&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">SCORING PEFINDO</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=log-slik&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">SLIK</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=log-dukcapil&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">DUKCAPIL</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 11)): ?>
						<li class="nav-item">
							<a href="#admin" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-settings"></i>
								<p>Administrator <b class="caret"></b></p>
							</a>
							<div class="collapse " id="admin">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=unlock-dukcapil&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">UNLOCK DUKCAPIL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=individual-manual-new&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">PEFINDO INDIVIDUAL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
											<a class="nav-link" href="index.php?page=individual-manual-clik&USERNAME=<?php echo $user; ?>">
												<span class="sidebar-normal">CLIK INDIVIDUAL</span>
											</a>
										</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=company-manual-new&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">PEFINDO COMPANY</span>
										</a>
									</li>

									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=dukcapil-manual-new1&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">Customer Identity Check - Dukcapil</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=setting_slik&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">SETTING SWITCH SLIK</span>
										</a>
									</li>
								</ul>
							</div>

						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 12)): ?>
						<li class="nav-item">
							<a href="#apv" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-upload"></i>
								<p>APPROVAL VERIFIKASI DOC <b class="caret"></b></p>
							</a>
							<div class="collapse " id="apv">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-verifikasi&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APPROVAL LIST</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-verifikasi-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APPROVAL INQUIRY</span>
										</a>
									</li>


								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 13)): ?>
						<li class="nav-item">
							<a href="#apvtdp" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-paperclip"></i>
								<p>Pengajuan Historical Kredit Eksternal <b class="caret"></b></p>
							</a>
							<div class="collapse " id="apvtdp">
								<ul class="nav">

									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-deviasi-ca-piloting&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">Pengajuan Historical Kredit Eksternal</span>
										</a>
									</li>


									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-tdp&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">Approval Pengajuan Historical Kredit
												Eksternal</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-tdp-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">Approval Pengajuan Historical Kredit Eksternal
												Inquiry</span>
										</a>
									</li>


								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 14)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist_hasil_survey">
								<i class="pe-7s-ribbon"></i>
								<p>List Hasil Survey Mos</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 15)): ?>
						<li class="nav-item">
							<a href="#rak" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-plane"></i>
								<p>RAK<b class="caret"></b></p>
							</a>
							<div class="collapse " id="rak">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-rak&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">Pengajuan RAK</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-rak&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">LOA APPROVAL RAK</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-rak-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APPROVAL INQUIRY RAK</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-loa-rak-inquiry-stg&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APPROVAL INQUIRY RAK < 2023</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 16)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist_print_po">
								<i class="pe-7s-ribbon"></i>
								<p>Print PO</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 17)): ?>
						<li class="nav-item">
							<a href="#req" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-id"></i>
								<p>VBS <b class="caret"></b></p>
							</a>
							<div class="collapse " id="req">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=request-mh&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">REQUEST</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=pengecekan-mh&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=hasil-pengecekan&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">RESPONSE</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-vbs-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INQUIRY</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 18)): ?>
					<li>	
							<a href="#ver1" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-wallet"></i>
								<p>PENGECEKAN SLIK HO<b class="caret"></b></p>
							</a>
							<div class="collapse " id="ver1">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-pengecekan-slik">
											<span class="sidebar-normal">TASKLIST HO</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=input-calon-karyawan&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT CALON KARYAWAN </span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=input-vendor&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT VENDOR </span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=input-debitur-existing&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT NASABAH LAMA </span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessCabang($conn, $user)): ?>
						<li class="nav-item">
							<a href="#ver1" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-wallet"></i>
								<p>PENGECEKAN SLIK HO<b class="caret"></b></p>
							</a>
							<div class="collapse " id="ver1">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-pengecekan-slik-cabang">
											<span class="sidebar-normal">TASKLIST HO</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 26)): ?>
					<li>
                        <a href="index.php?USERNAME=<?php echo $user; ?>&page=task_pelaporan_slik">
                            <i class="pe-7s-ribbon"></i>
                            <p>TASK PELAPORAN SLIK</p>
                        </a>
                    </li>
                  	<li class="nav-item">
						<a href="index.php?USERNAME=<?php echo $user; ?>&page=task_pelaporan_slik_harian_periode">
                            <i class="pe-7s-date"></i>
                            <p>TASK PELAPORAN SLIK HARIAN</p>
                        </a>
					</li>
						
              
				
				
                    <?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 1)): ?>
					<li>
						<a href="index.php?page=data-pelaporan-slik&USERNAME=<?php echo $user; ?>" class="nav-link">
							<i class="pe-7s-display2"></i>
							<p>Data Pelaporan SLIK<b class="caret"></b></p>
						</a>
					</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 19)): ?>
						<li class="nav-item">
							<a href="#slk-1" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-drawer"></i>
								<p>Pengecekan Slik Vendor <b class="caret"></b></p>
							</a>
							<div class="collapse " id="slk-1">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=input-vendor-cabang-individual&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT VENDOR INDIVIDUAL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=input-vendor-cabang-company&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT VENDOR COMPANY</span>
										</a>
									</li>

									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=tasklist-check-vendor&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST APPROVAL VENDOR</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=tasklist-check-inquiry-vendor&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST INQUIRY VENDOR</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 20)): ?>
						<li class="nav-item">
							<a href="#slk-2" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-browser"></i>
								<p>Pengecekan Slik <br>HRD<b class="caret"></b></p>
							</a>
							<div class="collapse " id="slk-2">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=input-slik-dealer&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INPUT DATA KARYAWAN</span>
										</a>
									</li>


									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=tasklist-check-slik-dealer&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST APPROVAL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=tasklist-check-inquiry-slik-dealer&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST INQUIRY</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 21)): ?>
						<li class="nav-item">
							<a href="#verSlik" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-exapnd2"></i>
								<p>CEK SLIK ALL<b class="caret"></b></p>
							</a>
							<div class="collapse " id="verSlik">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-slik-automation">
											<span class="sidebar-normal">TASKLIST SLIK </span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-slik-automation-deb-exists">
											<span class="sidebar-normal">TASKLIST DEBITUR EXISTING</span>
										</a>
									</li>
									<!-- Ahmad Arkana Dhanisworo 20250903 --> 
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?USERNAME=<?php echo $user; ?>&page=supervisor-req-slik">
											<span class="sidebar-normal">SUPERVISOR REQ SLIK</span>
										</a>
									</li>
									<!-- END --> 
								</ul>
							</div>
						</li>
					<?php endif; ?>

					<li>
						<a href="index.php?page=monitoring-debitur-menu&USERNAME=<?php echo $user; ?>" class="nav-link">
							<i class="pe-7s-display2"></i>
							<p>Monitoring Debitur<b class="caret"></b></p>
						</a>
					</li>
					<li>
						<a href="index.php?page=dakor-menu&USERNAME=<?php echo $user; ?>" class="nav-link">
							<i class="pe-7s-display2"></i>
							<p>Dakor Menu<b class="caret"></b></p>
						</a>
					</li>
					<?php if (hasAccessSP($conn, $user, 22)): ?>
						<li class="nav-item">
							<a href="#ver" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-check"></i>
								<p>VERIFIKASI FINAL<b class="caret"></b></p>
							</a>
							<div class="collapse " id="ver">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?USERNAME=<?php echo $user; ?>&page=verifikasi_final">
											<span class="sidebar-normal">VERIFIKASI</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=aproval&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APROVAL </span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=aproval-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APROVAL INQUIRY </span>
										</a>
									</li>
								</ul>
							</div>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 23)): ?>
						<li>
							<a href="index.php?page=report_dashboard&USERNAME=<?php echo $user; ?>">
								<i class="pe-7s-display2"></i>
								<p>Report</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 24)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=cetak_surat_pernyataan">
								<i class="pe-7s-print"></i>
								<p>Cetak Surat Pernyataan</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 11)): ?>
						<li>
							<a href="index.php?USERNAME=<?php echo $user; ?>&page=tasklist-setting-ca">
								<i class="pe-7s-bandaid"></i>
								<p>Setting CA Non Aktif</p>
							</a>
						</li>
					<?php endif; ?>
					<?php if (hasAccessSP($conn, $user, 25)): ?>
						<li class="nav-item">
							<a href="#anom" class="nav-link" data-toggle="collapse">
								<i class="pe-7s-comment"></i>
								<p>Dukcapil Anomali<b class="caret"></b></p>
							</a>
							<div class="collapse " id="anom">
								<ul class="nav">
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link" href="index.php?page=tasklist-data-anomali&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">TASKLIST CHECK DUKCAPIL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-dukcapil-anomali&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">APPROVAL CHECK DUKCAPIL</span>
										</a>
									</li>
									<li class="nav-item " style="margin-left:30px;">
										<a class="nav-link"
											href="index.php?page=tasklist-dukcapil-anomali-inquiry&USERNAME=<?php echo $user; ?>">
											<span class="sidebar-normal">INQUIRY CHECK DUKCAPIL</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
					<?php endif; ?>
					
					
					<?php 	if (hasAccessSP($conn, $user, 1)): ?>
						<li>
						<a href="index.php?page=tasklist-cust-non-check&USERNAME=<?php echo $user; ?>">
							<i class="pe-7s-note"></i>
							<p>List SLIK</p>
						</a>	
					</li>
					<?php endif; ?>
					
					<?php 	if (hasAccessSP($conn, $user, 1)): ?>
					<!-- tasklist dukcapil - dhanis -->
				<li class="nav-item">
                    <a href="#taskLDuk" class="nav-link" data-toggle="collapse">
                        <i class="pe-7s-culture"></i>
                        <p>TASKLIST DUKCAPIL <b class="caret"></b></p>
                    </a>
					<div class="collapse " id="taskLDuk">
						<ul class="nav">
							<?php
								$callGetRole = "{call SP_GET_ROLE_BY_USERNAME(?)}";
								$paramGetRole = array(array($user, SQLSRV_PARAM_IN));
								$execGetRole = sqlsrv_query( $conn, $callGetRole, $paramGetRole) or die( print_r( sqlsrv_errors(), true));
								$dataGetRole = sqlsrv_fetch_array($execGetRole);
								if(($dataGetRole['LEVEL'] > 5) || ($dataGetRole['LEVEL'] == 0 && $dataGetRole['ROLE_CODE'] != 'SFIBH')){
							?>
								<li class="nav-item " style="margin-left:30px;">
									<a class="nav-link" href="index.php?page=input-cek-dukcapil&USERNAME=<?php echo $user;?>">
										<span class="sidebar-normal">INPUT CEK DUKCAPIL</span>
									</a>
								</li>
							<?php
								}
							?>
							<li class="nav-item " style="margin-left:30px;">
								<a class="nav-link" href="index.php?page=tasklist-cek-dukcapil&USERNAME=<?php echo $user;?>">
									<span class="sidebar-normal">TASK APPROVAL DUKCAPIL</span>
								</a>
							</li>
							<li class="nav-item " style="margin-left:30px;">
								<a class="nav-link" href="index.php?page=history-cek-dukcapil&USERNAME=<?php echo $user;?>">
									<span class="sidebar-normal">HISTORY CEK DUKCAPIL</span>
								</a>
							</li>
							<li class="nav-item " style="margin-left:30px;">
								<a  href="view-pdf-panduan-dukcapil.php">
									<span class="sidebar-normal">MODUL PENGECEKAN DUKCAPIL</span>
								</a>
							</li>
						</ul>
					</div>
                </li>
				<!-- end -->
					
					
					<?php endif; ?>
				</ul>

			</div>
		</div>

		<div class="main-panel">
			<nav class="navbar navbar-default navbar-fixed">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
							data-target="#navigation-example-2">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="">
									<p>
										<i class="fa fa-user"></i>
										<?php echo $user; ?>
									</p>
								</a>
							</li>
							<li class="separator hidden-lg"></li>
						</ul>
					</div>
				</div>
			</nav>

			<?php
			$callDate = "{call SP_GET_DATE_SLIK}";
			$execDate = sqlsrv_query($conn, $callDate) or die(print_r(sqlsrv_errors(), true));
			$dataDate = sqlsrv_fetch_array($execDate);
			?>

			<div class="col-md-12">
				<i style="float:right">
					<?php if ($dataDate['CREATE_DATE'] != null) {
						echo $dataDate['CREATE_DATE']->format("l, d F Y, h:i:s");
					} ?>
				</i>

				<div style="clear:both;"></div>
			</div>

			<div class="content" style="background-color:#EEE;">
				<div class="container-fluid" style="background-color:#EEE;">
					<?php require_once "content.php"; ?>
				</div>
			</div>


			<footer class="footer">
				<div class="container-fluid">
					<p class="copyright pull-right">
						&copy; 2018 Suzuki Finance Indonesia. All Right Reserved
					</p>
				</div>
			</footer>

		</div>
	</div>
</body>



<script src="assets/js/jquery-ui.js"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/chartist.min.js"></script>
<script src="assets/js/bootstrap-notify.js"></script>
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
<script src="assets/js/demo.js"></script>
<script src="assets/js/jquery.maskedinput.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/fancybox/lib/jquery.mousewheel.pack.js"></script>
<script src="assets/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.7"></script>

</html>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			"lengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "All"]
			]
		});
		$('#exampleCompany').DataTable({
			"lengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "All"]
			]
		});
	});
</script>