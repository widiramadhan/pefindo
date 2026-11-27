<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php

$req_id = $_GET['REQ_ID'];


$callVdr = "{call SP_GET_DATA_DUKCAPIL_STAGING(?)}";
$paramVdr = array(array($req_id, SQLSRV_PARAM_IN));
$execVdr = sqlsrv_query( $conn, $callVdr,$paramVdr)  or die( print_r( sqlsrv_errors(), true));
$dataVdr = sqlsrv_fetch_array($execVdr);

$callDetailDukcapil = "{call SP_HISTORY_DETAIL_DUKCAPIL_STAGING(?)}";
$paramDetailDukcapil = array(array($req_id, SQLSRV_PARAM_IN));
$execDetailDukcapil = sqlsrv_query( $conn, $callDetailDukcapil,$paramDetailDukcapil)  or die( print_r( sqlsrv_errors(), true));
// $dataDetailDukcapil = sqlsrv_fetch_array($execDetailDukcapil);

$dataDetailDukcapil = [];

while ($row = sqlsrv_fetch_array($execDetailDukcapil, SQLSRV_FETCH_ASSOC)) {
    $dataDetailDukcapil[] = $row;
}


$nik=$dataVdr['ID_NO'];
$kk=$dataVdr['KK_NO'];
$nama=$dataVdr['NAMA_PEMOHON'];
$no_regist = $dataVdr['NOMOR_REGIST'];
if($dataVdr['BIRTH_DATE']<>NULL){$birth_date = $dataVdr['BIRTH_DATE']->format("d F Y");}else{$birth_date="";}
$tempat_lahir =$dataVdr['TEMPAT_LAHIR'];
$alamat = $dataVdr['ALAMAT'];
$mother_name = $dataVdr['MOTHER_NAME'];
$status_kawin = $dataVdr['STATUS_KAWIN'];
$tujuan = $dataVdr['DESCRIPTION'];


?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
<!--<form action="" method="post">-->

<form action="" method="post" enctype="multipart/form-data">
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	 
	<div class="row">
		<div class="col-md-12">
			<div class="card">
          <div class="header">
                <h4 class="title">Detail Informasi</h4>
                <p class="category">Informasi detail dasil pengecekan dukcapil</p>
				<br>
				<h5 class="title"><strong>Hasil Pengecekan Dukcapil: </strong>
				<?php
									if($dataDetailDukcapil[0]['STATUS'] == "DATA TIDAK DITEMUKAN" || $dataDetailDukcapil[0]['STATUS'] == "KTP TIDAK VALID" || $dataDetailDukcapil[0]['STATUS'] == "ERROR"){
										echo"<span class='badge' style='background-color:#d9534f;'>".$dataDetailDukcapil[0]['STATUS']."</span>";
									}else if($dataDetailDukcapil[0]['STATUS'] == "DATA DITEMUKAN TIDAK SESUAI"){
                                        echo"<span class='badge' style='background-color:#ffc107;'>".$dataDetailDukcapil[0]['STATUS']."</span>";
									}else if($dataDetailDukcapil[0]['STATUS'] == "VALID"){
                                        echo"<span class='badge' style='background-color:#5cb85c;'>".$dataDetailDukcapil[0]['STATUS']."</span>";
									}else{
										echo"<span class='badge' style='background-color:#000000;'>".$dataDetailDukcapil[0]['STATUS']."</span>";
									}
								?></h5>
            </div>
				<div class="content">
					<div class="row">
                    <div class="col-md-6">
							<div class="table-responsive">
                <table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DATA PENGECEKAN DUKCAPIL</td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										
										<td><?php echo strtoupper($nik);?></td>
									</tr>
									<tr>
										<td>Nomor Kartu Keluarga</td>
										
										<td><?php echo strtoupper($kk);?></td>
									</tr>
									<tr>
										<td>Nama</td>
										
										<td><?php echo strtoupper($nama);?></td>
									</tr>
									<tr>
										<td>Tempat Lahir</td>
										
										<td><?php echo strtoupper($tempat_lahir);?></td>
									</tr>
                					<tr>
										<td>Tanggal Lahir</td>
										
										<td><?php echo strtoupper($birth_date);?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										
										<td><?php echo strtoupper($alamat);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										
										<td><?php echo strtoupper($mother_name);?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										
										<td><?php echo strtoupper($status_kawin);?></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">RESPONSE HASIL DUKCAPIL</td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'NIK') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
									<tr>
										<td>Nomor Kartu Keluarga</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'NO_KK') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
									<tr>
										<td>Nama</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'NAMA_LENGKAP') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
                  <tr>
										<td>Tempat Lahir</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'TMPT_LHR') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
                  <tr>
										<td>Tanggal Lahir</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'TGL_LHR') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'ALAMAT') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'NAMA_LGKP_IBU') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										
										<?php 
                    $result = '';
                    foreach ($dataDetailDukcapil as $row) {
                        if ($row['JENIS_DATA'] == 'STATUS_KAWIN') {
                            $result = $row['DATA_DITERIMA'];
                            break;
                        }
                    }
                    ?>
										<td><?php echo strtoupper($result);?></td>
									</tr>
								</table>
							</div>
					</div>
          
				</div>
			</div>
		</div>
	</div>
  
<!--</form>-->
<script src="assets/js/jqueryrotate.min.js"></script>

<script>
$( document ).ready(function() {   
	$('#tgl_pemohon').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	
});
</script>



