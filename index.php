<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Host to Host SFI - Pefindo</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href='assets/css/fonts.css' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" type="text/css">
	<link rel="stylesheet" href="assets/css/jquery-ui.css">
</head>
<?php
	require_once("config/connection.php");
	if(isset($_GET['USERNAME'])){
		$user=$_GET['USERNAME'];
	}else{
		echo"<script>window.location='access-denied.php'</script>";
	}

	if(isset($_POST['no_ktp'])){
		$no_ktp_dkcupil=$_POST['no_ktp'];
	}else{
		$no_ktp_dkcupil="";
	}

	if(isset($_POST['prospect_no'])){
		$prospect_dkcupil=$_POST['prospect_no'];
	}else{
		$prospect_dkcupil="";
	}
	
	
	$ktp2="";
	$nama2="";
	$tglLahir2=DateTime::createFromFormat('Y-m-d', '1970-01-01');
	$type_cust="";
	$noProsepekPemohonSLIK ="";
?>
<body>

<div class="wrapper">
    <div class="sidebar" data-image="assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper" style="background-color: #035c7a">
            <div class="logo">
                <a href="index.php" class="simple-text">
                    H2H SFI - PEFINDO
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="index.php?USERNAME=<?php echo $user;?>">
                        <i class="pe-7s-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="index.php?USERNAME=<?php echo $user;?>&page=individual">
                        <i class="pe-7s-user"></i>
                        <p>Individual</p>
                    </a>
                </li>
                <li>
                    <a href="index.php?USERNAME=<?php echo $user;?>&page=company">
                        <i class="pe-7s-culture"></i>
                        <p>Company</p>
                    </a>
                </li>
                <li>
                    <a href="index.php?USERNAME=<?php echo $user;?>&page=pefindonodata">
                        <i class="pe-7s-note2"></i>
                        <p>Tasklist SLIK</p>
                    </a>
                </li>
				<li>
                    <a href="index.php?USERNAME=<?php echo $user;?>&page=history">
                        <i class="pe-7s-refresh-2"></i>
                        <p>History</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
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
									<i class="fa fa-user"></i> <?php echo $user;?>
								</p>
							</a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
				<?php require_once("content.php");?>
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

<?php
	if(isset($_GET['page'])){
		if($_GET['page'] == "individual"){
?>
	<!-- MODAL PROSPECT INDIVIDUAL -->
	<div id="prospect" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Data Prospect</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="example" class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Prospect Number</th>
											<th>KTP Number</th>
											<th>Fullname</th>
											<th>Date of Birth</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$callGetProspect = "{call SP_GET_PROSPEK_NUMBER}";
										$execGetProspect = sqlsrv_query($conn, $callGetProspect) or die( print_r( sqlsrv_errors(), true));
										$no=0;
										while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
											$no++;
									?>
										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
											<td><?php echo $rowGetProspect['ID_NO'];?></td>
											<td><?php echo $rowGetProspect['CUST_NAME'];?></td>
											<td><?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?></td>
											<td>
												<form action="" method="post">
													<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
													<input type="hidden" name="id_no" value="<?php echo $rowGetProspect['ID_NO'];?>">
													<input type="hidden" name="cust_name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
													<input type="hidden" name="birth_dt" value="<?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?>">
													<button type="submit" name="select" class="btn btn-success">Select</button>
												</form>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } } ?>

<?php
	if(isset($_GET['page'])){
		if($_GET['page'] == "company"){
?>
	<!-- MODAL PROSPECT COMPANY -->
	<div id="prospectCompany" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Data Prospect</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="exampleCompany" class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Prospect Number</th>
											<th>NPWP</th>
											<th>Company Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_COMPANY}";
										$execGetProspect = sqlsrv_query($conn, $callGetProspect) or die( print_r( sqlsrv_errors(), true));
										$no=0;
										while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
											$no++;
									?>
										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
											<td><?php echo $rowGetProspect['NPWP'];?></td>
											<td><?php echo $rowGetProspect['CUST_NAME'];?></td>
											<td>
												<form action="" method="post">
													<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
													<input type="hidden" name="id_no" value="<?php echo $rowGetProspect['NPWP'];?>">
													<input type="hidden" name="comp_name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
													<button type="submit" name="select" class="btn btn-success">Select</button>
												</form>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } } ?>

<?php
	if(isset($_GET['page'])){
		if($_GET['page'] == "individual"){
?>
<!-- MODAL DUKCAPIL -->
	<div id="dataDukcapil" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg" style="width: 90%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Compare Data Prospek</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<span style="font-weight:bold;font-size:14px">Data Dukcapil :</span>
							<div class="table-responsive">
								<table id="exampleCompany" class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>NIK</th>
											<th>Nama</th>
											<th>Tanggal Lahir</th>
											<th>Tempat Lahir</th>
											<th>Jenis Kelamin</th>
											<th>Nama_Ibu Kandung</th>
											<th>ALAMAT</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$callGetDukcapil = "{call SP_DUKCAPIL_GETDATA_RESULT (?,?)}";
											$paramsDukcapil = array(array($prospect_dkcupil, SQLSRV_PARAM_IN),array($no_ktp_dkcupil, SQLSRV_PARAM_IN));
											$execGetDukcapil = sqlsrv_query($conn, $callGetDukcapil, $paramsDukcapil) or die( print_r( sqlsrv_errors(), true));
											$no=0;
											while($rowGetDukcapil = sqlsrv_fetch_array($execGetDukcapil)){
												$no++;
										?>
										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo $rowGetDukcapil['NIK'];?></td>
											<td><?php echo $rowGetDukcapil['NAMA'];?></td>
											<td><?php echo $rowGetDukcapil['BIRTH_DT']->format('Y-m-d');?></td>
											<td><?php echo $rowGetDukcapil['TEMPAT_LAHIR'];?></td>
											<td><?php echo $rowGetDukcapil['JENIS_KELAMIN'];?></td>
											<td><?php echo $rowGetDukcapil['MOTHER_MAIDEN_NAME'];?></td>
											<td><?php echo $rowGetDukcapil['ALAMAT'];?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<span style="font-weight:bold;font-size:14px">Data Prospek :</span>
							<div class="table-responsive">
								<table id="exampleCompany" class="table table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>NIK</th>
											<th>Nama</th>
											<th>Tanggal Lahir</th>
											<th>Nama Ibu Kandung</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$callPros = "{call SP_GET_PROSPEK_COMPARE (?)}";
											$paramsPros = array(array($prospect_dkcupil, SQLSRV_PARAM_IN));
											$execPros = sqlsrv_query($conn, $callPros, $paramsPros) or die( print_r( sqlsrv_errors(), true));
											$no=0;
											while($rowPros = sqlsrv_fetch_array($execPros)){
												$no++;
										?>
										<tr>
											<td><?php echo $no;?></td>
											<td><?php echo $rowPros['ID_NO'];?></td>
											<td><?php echo $rowPros['CUST_NAME'];?></td>
											<td><?php echo $rowPros['BIRTH_DT']->format('Y-m-d');?></td>
											<td><?php echo $rowPros['MOTHER_NM'];?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } } ?>

<?php
	if(isset($_GET['page'])){
		if($_GET['page'] == "scoring-individual" || $_GET['page'] == "slik-detail" ){
?>
<!-- MODAL DUKCAPIL PENJAMIN PEFINDO -->
<div id="dataDukcapilPenjamin" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Data <?php echo $type_cust;?></h4>
			</div>
			<div class="modal-body">
				<?php
					$callCheckExists = "{call CHECK_EXISTS_SCORING_PENJAMIN(?)}";
					$paramCheckExists = array(array($noProsepekPemohon, SQLSRV_PARAM_IN));
					$execCheckExists = sqlsrv_query( $conn, $callCheckExists, $paramCheckExists) or die( print_r( sqlsrv_errors(), true));
					$dataCheckExist = sqlsrv_fetch_array($execCheckExists);
					//echo $dataCheckExist['STATUS'];
					if($dataCheckExist['STATUS'] == 3){
				?>
				<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from CONFINS :</label></b>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">NIK</th>
										<th style="text-align:center;">Nama</th>
										<th style="text-align:center;">Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align:center;"><?php echo $ktp2;?></td>
										<td style="text-align:center;"><?php echo $nama2;?></td>
										<td style="text-align:center;"><?php if($tglLahir2<>""){echo $tglLahir2->format("Y-m-d");}else{echo"";}?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!--<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from Dukcapil :</label></b>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">NIK</th>
										<th style="text-align:center;">Nama</th>
										<th style="text-align:center;">Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align:center;"><?php echo $DkcplNIKPenjamin;?></td>
										<td style="text-align:center;"><?php echo $DkcplNAMA_LGKPPenjamin;?></td>
										<td style="text-align:center;"><?php if($DkcplTGL_LHRPenjamin <> ""){echo date("Y-m-d", strtotime($DkcplTGL_LHRPenjamin));}else{ echo"";}?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>-->
				<b><label style="color:red; font-size: 14px"><?php echo $Warning_DataPenjamin;?></label></b>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from Pefindo :</label></b>
						<?php
						if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
						?>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">No</th>
										<th style="text-align:center;">KTP Number</th>
										<th style="text-align:center;">Fullname</th>
										<th style="text-align:center;">Date of Birth</th>
										<th style="text-align:center;">Address</th>
										<th style="width:50px;text-align:center;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
								?>
									<tr>
										<td style="text-align:center;">1</td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?></td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName'];?></td>
										<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];?></td>
										<td style="text-align:center;">
											<a href="check-penjamin.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $noProsepekPemohon;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>&cust=<?php echo $type_cust;?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
										</td>
									</tr>
								<?php
									}else{
										$no=0;
										foreach($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord'] as $item) {
											$no++;
								?>
									<tr>
										<td style="text-align:center;"><?php echo $no;?></td>
										<td style="text-align:center;"><?php echo $item['aKTP'];?></td>
										<td style="text-align:center;"><?php echo $item['aFullName'];?></td>
										<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($item['aDateOfBirth']));?></td>
										<td style="text-align:center;"><?php echo $item['aAddress'];?></td>
										<td style="text-align:center;">
											<a href="check-penjamin.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $noProsepekPemohon;?>&id=<?php echo $item['aPefindoId'];?>&cust=<?php echo $type_cust;?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>								
										</td>
									</tr>
								<?php		
										}
									}
								?>
								</tbody>
							</table>
						</div>
						<?php
						}else{
							echo"<br><b><label style='color:red'>- Data Penjamin tidak ditemukan di record Pefindo, silahkan cek lewat SLIK</b><br>";
							echo"<center>
									<form action='check-slik.php' method='post'>
										<input name='prospect_no' type='hidden' value='".$noProsepekPemohon."'>
										<input name='no_ktp' type='hidden' value='".$ktp2."'>
										<input name='nama' type='hidden' value='".$nama2."'>
										<input name='birth_dt' type='hidden' value='".$tglLahir2->format("Y-m-d")."'>
										<input name='cust_type' type='hidden' value='P'>
										<input name='id_type' type='hidden' value='KTP'>
										<input name='username' type='hidden' value='".$user."'>
										<input name='tipe_cust' type='hidden' value='PENJAMIN'>
										<button type='submit' class='btn btn-danger'>CEK SCORING BY SLIK</div>
									</form>
								</center>";
						}
						?>
					</div>
				</div>
				<?php
					}else if($dataCheckExist['STATUS'] == 1){
						$callSPCheckExistPenjamin = "{call SP_GET_MASTER_INDIVIDUAL(?)}";
						$paramsCheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCheckExistPenjamin = sqlsrv_query( $conn, $callSPCheckExistPenjamin, $paramsCheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$dataCheckExistPenjamin = sqlsrv_fetch_array($execCheckExistPenjamin);
						
						
						$lancar_CheckExistPenjamin=0;
						$days_1_30_CheckExistPenjamin=0;
						$days_31_60_CheckExistPenjamin=0;
						$days_61_90_CheckExistPenjamin=0;
						$days_91_120_CheckExistPenjamin=0;
						$days_121_150_CheckExistPenjamin=0;
						$days_151_180_CheckExistPenjamin=0;
						$lebih180_CheckExistPenjamin=0;

						$callSummary_CheckExistPenjamin = "{call SP_GET_TAB_SUMMARY(?)}";
						$optionsSummary_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
						$paramsSummary_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execSummary_CheckExistPenjamin = sqlsrv_query($conn, $callSummary_CheckExistPenjamin, $paramsSummary_CheckExistPenjamin, $optionsSummary_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$numRowsSummary_CheckExistPenjamin = sqlsrv_num_rows($execSummary_CheckExistPenjamin);
						while($dataSummary_CheckExistPenjamin = sqlsrv_fetch_array($execSummary_CheckExistPenjamin)){
							$ktp_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['KTP'];
							$nama_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['FULL_NAME'];
							$duedays_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['PASTDUE_DAYS'];
							if($duedays_CheckExistPenjamin == 0){
								$lancar_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 1 && $duedays_CheckExistPenjamin <= 30){
								$days_1_30_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 31 && $duedays_CheckExistPenjamin <= 60){
								$days_31_60_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 61 && $duedays_CheckExistPenjamin <= 90){
								$days_61_90_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 91 && $duedays_CheckExistPenjamin <= 120){
								$days_91_120_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 121 && $duedays_CheckExistPenjamin <= 150){
								$days_121_150_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 151 && $duedays_CheckExistPenjamin <= 180){
								$days_151_180_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin > 180){
								$lebih180_CheckExistPenjamin++;
							}else{
								
							}
						}	
						/* select table cip */
						$callCIP_CheckExistPenjamin = "{call SP_GET_TAB_DASHBOARD_TBL_CIP(?)}";
						$paramsCIP_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCIP_CheckExistPenjamin = sqlsrv_query( $conn, $callCIP_CheckExistPenjamin, $paramsCIP_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$dataCIP_CheckExistPenjamin = sqlsrv_fetch_array($execCIP_CheckExistPenjamin);

						$totalPlafond2_CheckExistPenjamin = 0;
						$totalBakiDebet2_CheckExistPenjamin = 0;
						$totalJatuhTempo2_CheckExistPenjamin = 0;
						$totalUsiaTunggakan2_CheckExistPenjamin = 0;
						
						$callCONT2_CheckExistPenjamin = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
						$optionsCONT2_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
						$paramsCONT2_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCONT2_CheckExistPenjamin = sqlsrv_query( $conn, $callCONT2_CheckExistPenjamin, $paramsCONT2_CheckExistPenjamin,$optionsCONT2_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
												
						while($dataCONT2_CheckExistPenjamin = sqlsrv_fetch_array($execCONT2_CheckExistPenjamin)){
							$totalPlafond2_CheckExistPenjamin =+ $totalPlafond2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'];
							$totalBakiDebet2_CheckExistPenjamin =+ $totalBakiDebet2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'];
							$totalJatuhTempo2_CheckExistPenjamin =+ $totalJatuhTempo2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'];
							$totalUsiaTunggakan2_CheckExistPenjamin =+ $totalUsiaTunggakan2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['PASTDUE_DAYS'];
						}
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="content" style="padding:0px;">
								<div class="table-responsive">
									<table class="table" style="width:100%;">
										<tr>
											<td style="padding:10px;width:100px;"><img src="assets/img/default-user.png" style="width:100%;border-radius:50%;border:1px solid #CCC;"></td>
											<td style="vertical-align:middle;font-size:18px;"><b><?php echo $nama_CheckExistPenjamin;?></b><div style="font-size:16px;color:#AAA;"><?php echo $ktp_CheckExistPenjamin;?></div></td>
											<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $dataCIP_CheckExistPenjamin['SCORE'];?></b></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL FASILITAS</div>
									<div style="font-size:36px;font-weight:bold;"><?php echo $numRowsSummary_CheckExistPenjamin;?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL PLAFOND</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalPlafond2_CheckExistPenjamin,0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL BAKI DEBET</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalBakiDebet2_CheckExistPenjamin,0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;border:none;">
								<thead>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">Lancar</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">1 - 30</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">31 - 60</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">61 - 90</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">91 - 120</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">121 - 150</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">151 - 180</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">> 180</th>
								</thead>
								<tbody>
									<tr>
										<td align="center"><?php echo $lancar_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_1_30_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_31_60_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_61_90_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_91_120_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_121_150_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_151_180_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $lebih180_CheckExistPenjamin;?></td>
									</tr>
								</tbody>	
							</table>
							<p class="name">Daftar Fasilitas</p>
							<table class="table table-bordered" style="width:100%;font-size:10px;">
								<thead>
									<tr>
										<th class="bg-td">JENIS LEMBAGA</th>
										<th class="bg-td">JENIS FASILITAS</th>
										<th class="bg-td">TANGGAL PEMBUKAAN</th>
										<th class="bg-td">STATUS</th>
										<th class="bg-td">PLAFON</th>
										<th class="bg-td">BAKI DEBET</th>
										<th class="bg-td">JATUH TEMPO</th>
										<th class="bg-td">USIA TUNGGAKAN</th>
									</tr>
								</thead>						
								<tbody>
								<?php
									$totalPlafond_CheckExistPenjamin = 0;
									$totalBakiDebet_CheckExistPenjamin = 0;
									$totalJatuhTempo_CheckExistPenjamin = 0;
									$totalUsiaTunggakan_CheckExistPenjamin = 0;
									
									$callCONT_CheckExistPenjamin = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
									$optionsCONT_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
									$paramsCONT_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
									$execCONT_CheckExistPenjamin = sqlsrv_query( $conn, $callCONT_CheckExistPenjamin, $paramsCONT_CheckExistPenjamin,$optionsCONT_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
									while($dataCONT_CheckExistPenjamin = sqlsrv_fetch_array($execCONT_CheckExistPenjamin)){
										$totalPlafond_CheckExistPenjamin =+ $totalPlafond_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'];
										$totalBakiDebet_CheckExistPenjamin =+ $totalBakiDebet_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'];
										$totalJatuhTempo_CheckExistPenjamin =+ $totalJatuhTempo_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'];
										$totalUsiaTunggakan_CheckExistPenjamin =+ $totalUsiaTunggakan_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['PASTDUE_DAYS'];
								?>
									<tr>
										<td align="left"><?php echo $dataCONT_CheckExistPenjamin['CREDITOR_TYPE'];?></td>
										<td align="left"><a href="#"><?php echo $dataCONT_CheckExistPenjamin['CONTRACT_TYPE'];?></a></td>
										<td align="center"><?php echo $dataCONT_CheckExistPenjamin['START_DATE']->format('Y-m-d');?></td>
										<td align="left"><?php echo $dataCONT_CheckExistPenjamin['CONTRACT_STATUS'];?>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['PASTDUE_DAYS'];?> Days</td>
									</tr>
									<?php
										}
									?>
									<tr>
										<td align="left" colspan="4"><b>Jumlah</b></td>
										<td align="right"><b>IDR <?php echo number_format($totalPlafond_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b>IDR <?php echo number_format($totalBakiDebet_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b><?php echo $totalUsiaTunggakan_CheckExistPenjamin;?> Days</b></td>
									</tr>
								</tbody>
							</table>
						</div>	
					</div>	
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="index.php?USERNAME=iman.santoso&page=scoring-individual&id=<?php echo $dataCheckExist['PEFINDO_ID'];?>&no=<?php echo $noProsepekPemohon;?>" class="btn btn-primary" style="cursor:pointer;border:1px solid #035c7a;background-color:#035c7a;color:#FFF;width:100%;">DETAIL SCORING PENJAMIN</a>
					</div>
				</div>
				<br>
				<?php 
				}else{ 
					$callSPCheckExistPenjaminSLIK= "{call SP_GET_SLIK_INDIVIDUAL_REPORT(?)}";
					$paramsCheckExistPenjaminSLIK = array(array($noProsepekPemohon, SQLSRV_PARAM_IN));
					$optionsCheckExistPenjaminSLIK =  array( "Scrollable" => "buffered" );
					$execCheckExistPenjaminSLIK = sqlsrv_query( $conn, $callSPCheckExistPenjaminSLIK, $paramsCheckExistPenjaminSLIK, $optionsCheckExistPenjaminSLIK) or die( print_r( sqlsrv_errors(), true));
					$dataCheckExistPenjaminSLIK = sqlsrv_fetch_array($execCheckExistPenjaminSLIK);
					$numrowsCheckExistPenjaminSLIK = sqlsrv_num_rows($execCheckExistPenjaminSLIK);
				?>
				<div class="row">
					<div class="col-md-11">
						<div class="card">
							<div class="content" style="padding:0px;">
								<div class="table-responsive">
									<table class="table" style="width:100%;">
										<tr>
											<td style="padding:10px;width:100px;"><img src="assets/img/default-user.png" style="width:100%;border-radius:50%;border:1px solid #CCC;"></td>
											<td style="vertical-align:middle;font-size:18px;"><b><?php echo strtoupper($dataCheckExistPenjaminSLIK['CUST_NAME']);?></b><div style="font-size:16px;color:#AAA;"><?php echo $dataCheckExistPenjaminSLIK['ID_NO'];?></div></td>
											<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $dataCheckExistPenjaminSLIK['SLIK_SCORE'];?></b><br><div style="font-size:14px;"><?php echo $dataCheckExistPenjaminSLIK['RANGE_DAYS_OD'];?></div></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL FASILITAS</div>
									<div style="font-size:36px;font-weight:bold;"><?php echo $dataCheckExistPenjaminSLIK['TOTAL_FASILITAS'];?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL PLAFOND</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($dataCheckExistPenjaminSLIK['TOTAL_PLAFOND'],0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL BAKI DEBET</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($dataCheckExistPenjaminSLIK['TOTAL_BAKI_DEBET'],0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-11">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;border:none;">
								<thead>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">Lancar</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">1 - 30</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">31 - 60</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">61 - 90</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">91 - 120</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">121 - 150</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">151 - 180</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">> 180</th>
								</thead>
								<tbody>
									<tr>
										<?php
											if($numrowsCheckExistPenjaminSLIK <> 0){
										?>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD']==0){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 1 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 30){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 31 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 60){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 61 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 90){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 91 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 120){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 121 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 150){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] >= 151 && $dataCheckExistPenjaminSLIK['DAYS_OD'] <= 180){ echo "<i class='fa fa-check'></i>";}?></td>
										<td align="center"><?php if($dataCheckExistPenjaminSLIK['DAYS_OD'] > 180){ echo "<i class='fa fa-check'></i>";}?></td>
										<?php }else{ ?>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<td align="center"></td>
										<?php } ?>
									</tr>
								</tbody>	
							</table>
						</div>	
					</div>		
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php }} ?>

<?php
	if(isset($_GET['page'])){
		if($_GET['page'] == "scoring-individual" || $_GET['page'] == "slik-detail" ){
?>
<!-- MODAL DUKCAPIL PENJAMIN SLIK -->
<div id="dataDukcapilPenjaminSLIK" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style="width:80%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Data Penjamin</h4>
			</div>
			<div class="modal-body">
				<?php
					$callCheckExists = "{call CHECK_EXISTS_SCORING_PENJAMIN(?)}";
					$paramCheckExists = array(array($noProsepekPemohonSLIK, SQLSRV_PARAM_IN));
					$execCheckExists = sqlsrv_query( $conn, $callCheckExists, $paramCheckExists) or die( print_r( sqlsrv_errors(), true));
					$dataCheckExist = sqlsrv_fetch_array($execCheckExists);
					
					if($dataCheckExist['STATUS'] == 3){
				?>
				<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from CONFINS :</label></b>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">NIK</th>
										<th style="text-align:center;">Nama</th>
										<th style="text-align:center;">Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align:center;"><?php echo $ktp2;?></td>
										<td style="text-align:center;"><?php echo $nama2;?></td>
										<td style="text-align:center;"><?php if($tglLahir2<>""){echo $tglLahir2->format("Y-m-d");}else{echo"";}?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!--<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from Dukcapil :</label></b>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">NIK</th>
										<th style="text-align:center;">Nama</th>
										<th style="text-align:center;">Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align:center;"><?php //echo $DkcplNIKPenjamin;?></td>
										<td style="text-align:center;"><?php //echo $DkcplNAMA_LGKPPenjamin;?></td>
										<td style="text-align:center;"><?php //if($DkcplTGL_LHRPenjamin <> ""){echo date("Y-m-d", strtotime($DkcplTGL_LHRPenjamin));}else{ echo"";}?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>-->
				<b><label style="color:red; font-size: 14px"><?php echo $Warning_DataPenjamin;?></label></b>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<b><label style="font-size: 14px">Data from Pefindo :</label></b>
						<?php
						if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aStatus'] == 'SubjectFound'){
						?>
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th style="text-align:center;">No</th>
										<th style="text-align:center;">KTP Number</th>
										<th style="text-align:center;">Fullname</th>
										<th style="text-align:center;">Date of Birth</th>
										<th style="text-align:center;">Address</th>
										<th style="width:50px;text-align:center;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aPefindoId'] <> NULL){
								?>
									<tr>
										<td style="text-align:center;">1</td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aKTP'];?></td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aFullName'];?></td>
										<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aDateOfBirth']));?></td>
										<td style="text-align:center;"><?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aAddress'];?></td>
										<td style="text-align:center;">
											<a href="check-penjamin.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $noProsepekPemohonSLIK;?>&id=<?php echo $array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord']['aPefindoId'];?>&cust=<?php echo $type_cust;?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>
										</td>
									</tr>
								<?php
									}else{
										$no=0;
										foreach($array['SmartSearchIndividualResponse']['SmartSearchIndividualResult']['aIndividualRecords']['aSearchIndividualRecord'] as $item) {
											$no++;
								?>
									<tr>
										<td style="text-align:center;"><?php echo $no;?></td>
										<td style="text-align:center;"><?php echo $item['aKTP'];?></td>
										<td style="text-align:center;"><?php echo $item['aFullName'];?></td>
										<td style="text-align:center;"><?php echo date('d-m-Y', strtotime($item['aDateOfBirth']));?></td>
										<td style="text-align:center;"><?php echo $item['aAddress'];?></td>
										<td style="text-align:center;">
											<a href="check-penjamin.php?USERNAME=<?php echo $user;?>&request=individual&no=<?php echo $noProsepekPemohonSLIK;?>&id=<?php echo $item['aPefindoId'];?>&cust=<?php echo $type_cust;?>" class="btn btn-success"><i class="fa fa-search"></i> Check Scoring</a>								
										</td>
									</tr>
								<?php		
										}
									}
								?>
								</tbody>
							</table>
						</div>
						<?php
						}else{
							echo"<br><b><label style='color:red'>- Data Penjamin tidak ditemukan di record Pefindo, silahkan cek lewat SLIK</b><br>";
							echo"<center>
									<form action='check-slik.php' method='post'>
										<input name='prospect_no' type='hidden' value='".$noProsepekPemohonSLIK."'>
										<input name='no_ktp' type='hidden' value='".$ktp2."'>
										<input name='nama' type='hidden' value='".$nama2."'>
										<input name='birth_dt' type='hidden' value='".$tglLahir2->format("Y-m-d")."'>
										<input name='cust_type' type='hidden' value='P'>
										<input name='id_type' type='hidden' value='KTP'>
										<input name='username' type='hidden' value='".$user."'>
										<input name='tipe_cust' type='hidden' value='PENJAMIN'>
										<button type='submit' class='btn btn-danger'>CEK SCORING BY SLIK</div>
									</form>
								</center>";
						}
						?>
					</div>
				</div>
				<?php
					}else{
						$callSPCheckExistPenjamin = "{call SP_GET_MASTER_INDIVIDUAL(?)}";
						$paramsCheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCheckExistPenjamin = sqlsrv_query( $conn, $callSPCheckExistPenjamin, $paramsCheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$dataCheckExistPenjamin = sqlsrv_fetch_array($execCheckExistPenjamin);
						
						
						$lancar_CheckExistPenjamin=0;
						$days_1_30_CheckExistPenjamin=0;
						$days_31_60_CheckExistPenjamin=0;
						$days_61_90_CheckExistPenjamin=0;
						$days_91_120_CheckExistPenjamin=0;
						$days_121_150_CheckExistPenjamin=0;
						$days_151_180_CheckExistPenjamin=0;
						$lebih180_CheckExistPenjamin=0;

						$callSummary_CheckExistPenjamin = "{call SP_GET_TAB_SUMMARY(?)}";
						$optionsSummary_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
						$paramsSummary_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execSummary_CheckExistPenjamin = sqlsrv_query($conn, $callSummary_CheckExistPenjamin, $paramsSummary_CheckExistPenjamin, $optionsSummary_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$numRowsSummary_CheckExistPenjamin = sqlsrv_num_rows($execSummary_CheckExistPenjamin);
						while($dataSummary_CheckExistPenjamin = sqlsrv_fetch_array($execSummary_CheckExistPenjamin)){
							$ktp_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['KTP'];
							$nama_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['FULL_NAME'];
							$duedays_CheckExistPenjamin=$dataSummary_CheckExistPenjamin['PASTDUE_DAYS'];
							if($duedays_CheckExistPenjamin == 0){
								$lancar_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 1 && $duedays_CheckExistPenjamin <= 30){
								$days_1_30_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 31 && $duedays_CheckExistPenjamin <= 60){
								$days_31_60_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 61 && $duedays_CheckExistPenjamin <= 90){
								$days_61_90_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 91 && $duedays_CheckExistPenjamin <= 120){
								$days_91_120_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 121 && $duedays_CheckExistPenjamin <= 150){
								$days_121_150_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin >= 151 && $duedays_CheckExistPenjamin <= 180){
								$days_151_180_CheckExistPenjamin++;
							}else if($duedays_CheckExistPenjamin > 180){
								$lebih180_CheckExistPenjamin++;
							}else{
								
							}
						}	
						/* select table cip */
						$callCIP_CheckExistPenjamin = "{call SP_GET_TAB_DASHBOARD_TBL_CIP(?)}";
						$paramsCIP_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCIP_CheckExistPenjamin = sqlsrv_query( $conn, $callCIP_CheckExistPenjamin, $paramsCIP_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
						$dataCIP_CheckExistPenjamin = sqlsrv_fetch_array($execCIP_CheckExistPenjamin);

						$totalPlafond2_CheckExistPenjamin = 0;
						$totalBakiDebet2_CheckExistPenjamin = 0;
						$totalJatuhTempo2_CheckExistPenjamin = 0;
						$totalUsiaTunggakan2_CheckExistPenjamin = 0;
						
						$callCONT2_CheckExistPenjamin = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
						$optionsCONT2_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
						$paramsCONT2_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
						$execCONT2_CheckExistPenjamin = sqlsrv_query( $conn, $callCONT2_CheckExistPenjamin, $paramsCONT2_CheckExistPenjamin,$optionsCONT2_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
												
						while($dataCONT2_CheckExistPenjamin = sqlsrv_fetch_array($execCONT2_CheckExistPenjamin)){
							$totalPlafond2_CheckExistPenjamin =+ $totalPlafond2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'];
							$totalBakiDebet2_CheckExistPenjamin =+ $totalBakiDebet2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'];
							$totalJatuhTempo2_CheckExistPenjamin =+ $totalJatuhTempo2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'];
							$totalUsiaTunggakan2_CheckExistPenjamin =+ $totalUsiaTunggakan2_CheckExistPenjamin + $dataCONT2_CheckExistPenjamin['PASTDUE_DAYS'];
						}
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="content" style="padding:0px;">
								<div class="table-responsive">
									<table class="table" style="width:100%;">
										<tr>
											<td style="padding:10px;width:100px;"><img src="assets/img/default-user.png" style="width:100%;border-radius:50%;border:1px solid #CCC;"></td>
											<td style="vertical-align:middle;font-size:18px;"><b><?php echo $nama_CheckExistPenjamin;?></b><div style="font-size:16px;color:#AAA;"><?php echo $ktp_CheckExistPenjamin;?></div></td>
											<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $dataCIP_CheckExistPenjamin['SCORE'];?></b></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL FASILITAS</div>
									<div style="font-size:36px;font-weight:bold;"><?php echo $numRowsSummary_CheckExistPenjamin;?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL PLAFOND</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalPlafond2_CheckExistPenjamin,0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card">
							<div class="content">
								<center>
									<div style="color:#AAA;">TOTAL BAKI DEBET</div>
									<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalBakiDebet2_CheckExistPenjamin,0,',','.');?></div>
								</center>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;border:none;">
								<thead>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">Lancar</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">1 - 30</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">31 - 60</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">61 - 90</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">91 - 120</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">121 - 150</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">151 - 180</th>
									<th class="bg-td" style="width:12.5%;font-weight:bold;">> 180</th>
								</thead>
								<tbody>
									<tr>
										<td align="center"><?php echo $lancar_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_1_30_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_31_60_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_61_90_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_91_120_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_121_150_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $days_151_180_CheckExistPenjamin;?></td>
										<td align="center"><?php echo $lebih180_CheckExistPenjamin;?></td>
									</tr>
								</tbody>	
							</table>
							<p class="name">Daftar Fasilitas</p>
							<table class="table table-bordered" style="width:100%;font-size:10px;">
								<thead>
									<tr>
										<th class="bg-td">JENIS LEMBAGA</th>
										<th class="bg-td">JENIS FASILITAS</th>
										<th class="bg-td">TANGGAL PEMBUKAAN</th>
										<th class="bg-td">STATUS</th>
										<th class="bg-td">PLAFON</th>
										<th class="bg-td">BAKI DEBET</th>
										<th class="bg-td">JATUH TEMPO</th>
										<th class="bg-td">USIA TUNGGAKAN</th>
									</tr>
								</thead>						
								<tbody>
								<?php
									$totalPlafond_CheckExistPenjamin = 0;
									$totalBakiDebet_CheckExistPenjamin = 0;
									$totalJatuhTempo_CheckExistPenjamin = 0;
									$totalUsiaTunggakan_CheckExistPenjamin = 0;
									
									$callCONT_CheckExistPenjamin = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
									$optionsCONT_CheckExistPenjamin =  array( "Scrollable" => "buffered" );
									$paramsCONT_CheckExistPenjamin = array(array($dataCheckExist['PEFINDO_ID'], SQLSRV_PARAM_IN));
									$execCONT_CheckExistPenjamin = sqlsrv_query( $conn, $callCONT_CheckExistPenjamin, $paramsCONT_CheckExistPenjamin,$optionsCONT_CheckExistPenjamin) or die( print_r( sqlsrv_errors(), true));
									while($dataCONT_CheckExistPenjamin = sqlsrv_fetch_array($execCONT_CheckExistPenjamin)){
										$totalPlafond_CheckExistPenjamin =+ $totalPlafond_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'];
										$totalBakiDebet_CheckExistPenjamin =+ $totalBakiDebet_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'];
										$totalJatuhTempo_CheckExistPenjamin =+ $totalJatuhTempo_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'];
										$totalUsiaTunggakan_CheckExistPenjamin =+ $totalUsiaTunggakan_CheckExistPenjamin + $dataCONT_CheckExistPenjamin['PASTDUE_DAYS'];
								?>
									<tr>
										<td align="left"><?php echo $dataCONT_CheckExistPenjamin['CREDITOR_TYPE'];?></td>
										<td align="left"><a href="#"><?php echo $dataCONT_CheckExistPenjamin['CONTRACT_TYPE'];?></a></td>
										<td align="center"><?php echo $dataCONT_CheckExistPenjamin['START_DATE']->format('Y-m-d');?></td>
										<td align="left"><?php echo $dataCONT_CheckExistPenjamin['CONTRACT_STATUS'];?>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONT_CheckExistPenjamin['PASTDUE_AMOUNT_VALUE'],0,',','.');?></td>
										<td align="right"><?php echo $dataCONT_CheckExistPenjamin['PASTDUE_DAYS'];?> Days</td>
									</tr>
									<?php
										}
									?>
									<tr>
										<td align="left" colspan="4"><b>Jumlah</b></td>
										<td align="right"><b>IDR <?php echo number_format($totalPlafond_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b>IDR <?php echo number_format($totalBakiDebet_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo_CheckExistPenjamin,0,',','.');?></b></td>
										<td align="right"><b><?php echo $totalUsiaTunggakan_CheckExistPenjamin;?> Days</b></td>
									</tr>
								</tbody>
							</table>
						</div>	
					</div>	
				</div>
				<div class="row">
					<div class="col-md-12">
						<a href="index.php?USERNAME=iman.santoso&page=scoring-individual&id=<?php echo $dataCheckExist['PEFINDO_ID'];?>&no=<?php echo $noProsepekPemohonSLIK;?>" class="btn btn-primary" style="cursor:pointer;border:1px solid #035c7a;background-color:#035c7a;color:#FFF;width:100%;">DETAIL SCORING PENJAMIN</a>
					</div>
				</div>
				<br>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php }}?>

    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.maskedinput.js"></script>
	<script src="assets/js/jquery.dataTables.min.js"></script>
	<script src="assets/js/dataTables.bootstrap4.min.js"></script>
</html>
<script>
$(document).ready(function() {
    $('#example').DataTable({
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
	});
	$('#exampleCompany').DataTable({
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
	});
});
</script>