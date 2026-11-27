<?php

$user=$_GET['USERNAME'];
$prospect=$_GET['prospect'];
$app_no = $_GET['app'];



if (strpos($prospect, 'PRS') !== false) {
	$securityDeposit = "0";
	$branchid= substr($prospect,0,4);
	
	//echo "true";
    $call = "{call PEFINDO_GETDATA_PASANGAN_NEWVERSE_NEW(?)}";
	$param = array(array($prospect, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	

	if($data['Pasangan_Noktp'] == "" || $data['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$ktpsaya = $data['Penjamin_Noktp'];
		$namasaya = $data['Penjamin_Nama'];
		if($data['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $data['Penjamin_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data['Penjamin_TglLahir'];
		$tempatlahirsaya = $data['Penjamin_TempatLahir'];
		 if($data['Penjamin_Ibu']<>NULL){$namaibusaya = $data['Penjamin_Ibu'];}else{$namaibusaya="";}
		
	}else{
		$siapanih = "Pasangan";
		$ktpsaya = $data['Pasangan_Noktp'];
		$namasaya = $data['Pasangan_Nama'];
		if($data['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $data['Pasangan_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data['Pasangan_TglLahir'];
		$tempatlahirsaya = $data['Pasangan_TempatLahir'];
		if($data['Pasangan_Ibu']<>NULL){$namaibusaya = $data['Pasangan_Ibu'];}else{$namaibusaya="";}
		
	}
}else{
	//echo "false";

	$call = "{call PEFINDO_GETDATA_PASANGAN_BY_ORDER_NO_1(?)}";
	$param = array(array($prospect, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	
	$callBranch = "{call SP_GET_BRANCH_STATUS_ORDER(?,?)}";
	$paramBranch = array(array($prospect, SQLSRV_PARAM_IN),array('ORDER_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	
	$branchid= $dataBranch['OFFICE_CODE'];
	
	$siapanih = $data['TYPE'];
	$ktpsaya = $data['NIK_PASANGAN_PENJAMIN'];
	$namasaya = $data['NAMA_PASANGAN_PENJAMIN']; 	
	if($data['TTL_PASANGAN_PENJAMIN']<>NULL){$tgllahirsaya = $data['TTL_PASANGAN_PENJAMIN']->format("d F Y");}else{$tgllahirsaya="";}
	$tempatlahirsaya = "";
	$namaibusaya = $data['NAMA_IBU_PASANGAN_PNJMN'];
	$alamatsaya = $data['ALAMAT_PSGN_PNJMN'];

} 




$callDataPemohon = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
$paramDataPemohon =  array(array($prospect, SQLSRV_PARAM_IN),
					 array('PEMOHON', SQLSRV_PARAM_IN));
$execDataPemohon = sqlsrv_query( $conn, $callDataPemohon, $paramDataPemohon) or die( print_r( sqlsrv_errors(), true));
$dataDataPemohon = sqlsrv_fetch_array($execDataPemohon);

$callDataPasangan = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
$paramDataPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
					 array('Pasangan', SQLSRV_PARAM_IN));
$execDataPasangan = sqlsrv_query( $conn, $callDataPasangan, $paramDataPasangan) or die( print_r( sqlsrv_errors(), true));
$dataDataPasangan = sqlsrv_fetch_array($execDataPasangan);




if($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){
	
	$callDesc = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
	$paramDesc =  array(array($dataDataPemohon['SCORE'], SQLSRV_PARAM_IN),
					array('1', SQLSRV_PARAM_IN));
	$execDesc = sqlsrv_query( $conn, $callDesc, $paramDesc) or die( print_r( sqlsrv_errors(), true));
	$dataDesc = sqlsrv_fetch_array($execDesc);

	$callDescPasangan = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
	$paramDescPasangan =  array(array($dataDataPasangan['SCORE'], SQLSRV_PARAM_IN),
					array('1', SQLSRV_PARAM_IN));
	$execDescPasangan = sqlsrv_query( $conn, $callDescPasangan, $paramDescPasangan) or die( print_r( sqlsrv_errors(), true));
	$dataDescPasangan = sqlsrv_fetch_array($execDescPasangan);
	
	
$callScore = "{call SP_GET_FINAL_DESKRIPSI_SCORE(?)}";
$paramScore =  array(array($prospect, SQLSRV_PARAM_IN));
$execScore = sqlsrv_query( $conn, $callScore, $paramScore) or die( print_r( sqlsrv_errors(), true));
$dataScore = sqlsrv_fetch_array($execScore);




$scoreMax = $dataScore['scoremax']; 
$odMax =$dataScore['OD']; 

}ELSE{

	$callDesc = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK_ONLY(?,?)}";
	$paramDesc =  array(array($dataDataPemohon['OD'], SQLSRV_PARAM_IN),
					array('2', SQLSRV_PARAM_IN));
	$execDesc = sqlsrv_query( $conn, $callDesc, $paramDesc) or die( print_r( sqlsrv_errors(), true));
	$dataDesc = sqlsrv_fetch_array($execDesc);

	$callDescPasangan = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK_ONLY(?,?)}";
	$paramDescPasangan =  array(array($dataDataPasangan['OD'], SQLSRV_PARAM_IN),
					array('2', SQLSRV_PARAM_IN));
	$execDescPasangan = sqlsrv_query( $conn, $callDescPasangan, $paramDescPasangan) or die( print_r( sqlsrv_errors(), true));
	$dataDescPasangan = sqlsrv_fetch_array($execDescPasangan);
	
	$callScore = "{call SP_GET_FINAL_DESKRIPSI_SCORE_SLIK(?)}";
	$paramScore =  array(array($prospect, SQLSRV_PARAM_IN));
	$execScore = sqlsrv_query( $conn, $callScore, $paramScore) or die( print_r( sqlsrv_errors(), true));
	$dataScore = sqlsrv_fetch_array($execScore);




	$scoreMax = $dataScore['scoremax'];
	$odMax =$dataScore['OD']; 
}






$callCA = "{call SP_GET_DEVIASI_CA(?,?)}";
$paramCA =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($prospect, SQLSRV_PARAM_IN));
$execCA = sqlsrv_query( $conn, $callCA, $paramCA) or die( print_r( sqlsrv_errors(), true));
$dataCA = sqlsrv_fetch_array($execCA);


$callScheme = "{call SP_GET_SCHEME_ID_PROSPECT(?)}";
$paramScheme =  array(array($app_no, SQLSRV_PARAM_IN));
$execScheme = sqlsrv_query( $conn, $callScheme, $paramScheme) or die( print_r( sqlsrv_errors(), true));
$dataScheme = sqlsrv_fetch_array($execScheme);

$tipeKendaraan = $dataScheme['TIPE_KENDARAAN'];

if($dataScheme['SCHEME_ID'] == 'NMBBR'){
	$schemeId = '';
}else{
	$schemeId = $dataScheme['SCHEME_ID'];
}
$tdp = $dataScheme['TDP_PERCENT'];


IF($tipeKendaraan == '2W' && $schemeId =='NMTBR' && $dataScore['DESKRIPSI_SCORE'] == 'Data Tidak Ditemukan' && $tdp <= 14.99 && $data['DACOR'] <> 'YA' ){
	echo"<script>alert('Tidak Bisa Melanjutkan Karena TDP Tidak Mencukupi, TDP SEKARANG ".$tdp."');history.back();</script>";
	
}ELSE IF($tipeKendaraan == '2W' && $schemeId =='NMTBR' && $dataScore['DESKRIPSI_SCORE'] == 'Score Tidak Dapat Dihitung' && $tdp <= 14.99 && $data['DACOR'] <> 'YA'){
	echo"<script>alert('Tidak Bisa Melanjutkan Karena TDP Tidak Mencukupi, TDP SEKARANG ".$tdp." ');history.back();</script>";

}

IF($dataScheme['STAT_MOS'] == 'NEW'){

$callImgAll = "{call SP_GET_FOTO_SAP_RUMAH_USAHA_NEW(?,?,?)}";
$paramImgAll =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($dataScheme['STAT_MOS'], SQLSRV_PARAM_IN),
					 array($dataScheme['CUST_MODEL'], SQLSRV_PARAM_IN));
$execImgAll = sqlsrv_query( $conn, $callImgAll, $paramImgAll) or die( print_r( sqlsrv_errors(), true));
$dataImgAll = sqlsrv_fetch_array($execImgAll);


$imgRumah1 = $dataImgAll['RUMAH1'];
$imgRumah2 = $dataImgAll['RUMAH2'];
$imgRumah3 = $dataImgAll['RUMAH3'];
$imgRumah4 = $dataImgAll['RUMAH4'];
$imgUsaha1 = $dataImgAll['USAHA1'];
$imgUsaha2 = $dataImgAll['USAHA2'];
$imgUsaha3 = $dataImgAll['USAHA3'];

}Else{

if($tipeKendaraan == '4W'){

$fotoRumah1= '8FBF42F8-68D4-11E5-8140-6BAE0488A41C';
$fotoRumah2= 'CFB247D2-8C6D-11E6-9AF6-893A2040F36C';
$fotoRumah3= '9990B4BF-8C6D-11E6-9AF6-47BAAEE44A9B';
$fotoRumah4= 'DC548893-8C6D-11E6-9AF6-2DA542B425E9';
$fotoUsaha1= '007FA573-8C70-11E6-9AF6-31EB02DC21EB';
$fotoUsaha2= '0E943AE4-8C70-11E6-9AF6-9DA3C14EEEE8';
$fotoUsaha3= '1CA6AD75-8C70-11E6-9AF6-3F9AEBBEA505';
}ELSE{
$fotoRumah1= 'AF0D3F3A-72B4-11E7-8587-FB74903B42A2';
$fotoRumah2= 'BC5BB4CD-686D-11E7-8587-EB92397D31A5';
$fotoRumah3= 'D482432E-686D-11E7-8587-B710A10ED5AE';
$fotoRumah4= '46EAF673-8C73-11E6-9AF6-E5D171476C08';
$fotoUsaha1= '1824363D-72B6-11E7-8587-E168D8B4CEF0';
$fotoUsaha2= '27E1729E-72B6-11E7-8587-E52AA8B55C04';
$fotoUsaha3= '4AA8CC6F-72B6-11E7-8587-65032D522747';
}





$callImgRumah1 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgRumah1 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoRumah1, SQLSRV_PARAM_IN));
$execImgRumah1 = sqlsrv_query( $conn, $callImgRumah1, $paramImgRumah1) or die( print_r( sqlsrv_errors(), true));
$dataImgRumah1 = sqlsrv_fetch_array($execImgRumah1);

$callImgRumah2 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgRumah2 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoRumah2, SQLSRV_PARAM_IN));
$execImgRumah2 = sqlsrv_query( $conn, $callImgRumah2, $paramImgRumah2) or die( print_r( sqlsrv_errors(), true));
$dataImgRumah2 = sqlsrv_fetch_array($execImgRumah2);

$callImgRumah3 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgRumah3 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoRumah3, SQLSRV_PARAM_IN));
$execImgRumah3 = sqlsrv_query( $conn, $callImgRumah3, $paramImgRumah3) or die( print_r( sqlsrv_errors(), true));
$dataImgRumah3 = sqlsrv_fetch_array($execImgRumah3);

$callImgRumah4 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgRumah4 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoRumah4, SQLSRV_PARAM_IN));
$execImgRumah4 = sqlsrv_query( $conn, $callImgRumah4, $paramImgRumah4) or die( print_r( sqlsrv_errors(), true));
$dataImgRumah4 = sqlsrv_fetch_array($execImgRumah4);

$callImgUsaha1 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgUsaha1 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoUsaha1, SQLSRV_PARAM_IN));
$execImgUsaha1 = sqlsrv_query( $conn, $callImgUsaha1, $paramImgUsaha1) or die( print_r( sqlsrv_errors(), true));
$dataImgUsaha1 = sqlsrv_fetch_array($execImgUsaha1);

$callImgUsaha2 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgUsaha2 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoUsaha2, SQLSRV_PARAM_IN));
$execImgUsaha2 = sqlsrv_query( $conn, $callImgUsaha2, $paramImgUsaha2) or die( print_r( sqlsrv_errors(), true));
$dataImgUsaha2 = sqlsrv_fetch_array($execImgUsaha2);

$callImgUsaha3 = "{call SP_GET_FOTO_SAP_RUMAH_USAHA(?,?)}";
$paramImgUsaha3 =  array(array($app_no, SQLSRV_PARAM_IN),
					 array($fotoUsaha3, SQLSRV_PARAM_IN));
$execImgUsaha3 = sqlsrv_query( $conn, $callImgUsaha3, $paramImgUsaha3) or die( print_r( sqlsrv_errors(), true));
$dataImgUsaha3 = sqlsrv_fetch_array($execImgUsaha3);

$imgRumah1 = $dataImgRumah1['LOB_FILE'];
$imgRumah2 = $dataImgRumah2['LOB_FILE'];
$imgRumah3 = $dataImgRumah3['LOB_FILE'];
$imgRumah4 = $dataImgRumah4['LOB_FILE'];
$imgUsaha1 = $dataImgUsaha1['LOB_FILE'];
$imgUsaha2 = $dataImgUsaha2['LOB_FILE'];
$imgUsaha3 = $dataImgUsaha3['LOB_FILE'];
}


$callApv = "{call SP_GET_MATRIX_TDP_ORDER(?,?,?,?,?,?,?,?)}";
$paramApv =  array(array($prospect, SQLSRV_PARAM_IN),
					array($branchid, SQLSRV_PARAM_IN),
					array($scoreMax, SQLSRV_PARAM_IN),
					array($dataDataPemohon['SOURCE_BY'], SQLSRV_PARAM_IN),
					array($tdp, SQLSRV_PARAM_IN),
					array($tipeKendaraan, SQLSRV_PARAM_IN),
					array($schemeId, SQLSRV_PARAM_IN),
					array($odMax, SQLSRV_PARAM_IN));
/*
$callApv = "{call SP_GET_MATRIX_TDP(?,?,?,?,?,?,?)}";
$paramApv =  array(array($branchid, SQLSRV_PARAM_IN),
					array($scoreMax, SQLSRV_PARAM_IN),
					array($dataDataPemohon['SOURCE_BY'], SQLSRV_PARAM_IN),
					array($tdp, SQLSRV_PARAM_IN),
					array($tipeKendaraan, SQLSRV_PARAM_IN),
					array($schemeId, SQLSRV_PARAM_IN),
					array($odMax, SQLSRV_PARAM_IN));
*/

$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_errors(), true));
$dataApv = sqlsrv_fetch_array($execApv);

$typeDesc = $dataApv['TYPE_DESC'];

IF($dataApv['NOTES'] != NULL){
	$buktiLunas = 0;
	$dpMin = 1;  
}ELSE{
	$buktiLunas = 0;
	$dpMin = 0;
}
/*
IF($dataApv['NOTES'] == 'TDP Min 25% (4W)'){
	if(substr($branchid,0,-2) == '15'){
	$buktiLunas = 0;
	$dpMin = 1;
	}ELSE{
	$buktiLunas = 0;
	$dpMin = 0;
	}
}ELSE IF($dataApv['NOTES'] == 'Bukti Pelunasan Fasilitas Macet'){
	$buktiLunas = 1;
	$dpMin = 0;
}ELSE{
	$buktiLunas = 0;
	$dpMin = 0;
}
*/

$callRak = "{call SP_RAK_GET_HEADER(?)}";
$paramRak =  array(array($app_no, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$execRak = sqlsrv_query( $conn, $callRak, $paramRak,$options) or die( print_r( sqlsrv_errors(), true));
$dataRak = sqlsrv_fetch_array($execRak);
$rowRak=sqlsrv_num_rows($execRak);

function prepareImageDBString($filepath){
	$output = 'null';
	$handle = @fopen($filepath, 'rb');
	if ($handle){
		$content = @fread($handle, filesize($filepath));
		$content = bin2hex($content);
		@fclose($handle);
		$output = "0x".strtoupper($content);
	}
	return $output;
}


$siapanih=$dataDataPasangan['CUST_TYPE'];





if(isset($_POST['submit1'])){
	$notes = $_POST['catatan'];
	$deviasi = $_POST['deviasi'];

	$final_score = $dataScore['DESKRIPSI_SCORE'];
	$level_approval = $dataApv['ROLE_CODE'];
	
	
	$nama_baru = '';
	
	$queryInsert = "{call SP_INSERT_DEVIASI_CA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterInsert = array(
					array($branchid, SQLSRV_PARAM_IN),
					array($app_no, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($scoreMax, SQLSRV_PARAM_IN),
					array($dataScore['OD'], SQLSRV_PARAM_IN),
					array(substr($dataScore['BAKIDEBET_MACET'],0,-5), SQLSRV_PARAM_IN),
					array(substr($dataScore['BAKIDEBET_LANCAR'],0,-5), SQLSRV_PARAM_IN),
					array($final_score, SQLSRV_PARAM_IN),
					array($level_approval, SQLSRV_PARAM_IN),
					array($nama_baru, SQLSRV_PARAM_IN),
					array($notes, SQLSRV_PARAM_IN),
					array($deviasi, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($buktiLunas, SQLSRV_PARAM_IN),
					array($dpMin, SQLSRV_PARAM_IN),
					array($tipeKendaraan, SQLSRV_PARAM_IN),
					array($schemeId, SQLSRV_PARAM_IN),
					array($tdp, SQLSRV_PARAM_IN),
					array($typeDesc, SQLSRV_PARAM_IN),
				);
			
	
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true));
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}



?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 

<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
<!--<form action="" method="post">-->	

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />	 
	<div class="row">
		<div class="col-md-12">
			
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Hasil Pengecekan</td>
									</tr>
									<tr>
										<td >Prospek No / ORDER NO </td>
										<td >
											<input type="text" name="prospek_no" id="prospek_no"  value="<?php echo $prospect;?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
										<tr>
										<td >APP NO </td>
										<td >
											<input type="text" name="prospek_no" id="prospek_no"  value="<?php echo $app_no;?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									
								</table>
							</div>
							
							<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PEMOHON </td>
									</tr>
								
									<tr>
										<td style="width:50%;">HISTORICAL KREDIT </td>
										<td style="width:50%;">
											<input type="text" name="historical_kredit" class="form-control"  value="<?php echo $dataDataPemohon['SOURCE_BY'] ;?>"  id="historical_kredit" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama </td>
										<td style="width:50%;">
											<input type="text" name="nama_pemohon" class="form-control" value="<?php echo $data['CUST_NAME'];?>"  id="nama_pemohon" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Deskripsi Score </td>
										<td style="width:50%;">
											<input type="text" name="score" class="form-control" value="<?php echo $dataDesc['SCORE_DESC'];?>"  id="score" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">OD MAX</td>
										<td style="width:50%;">
											<input type="text" name="od" class="form-control" value="<?php echo $dataDataPemohon['OD'];?>"  id="od" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Total Baki Debet Macet</td>
										<td style="width:50%;">
											<input type="text" name="baki_debet" class="form-control" 
											value="<?php if($dataDataPemohon['BAKIDEBET_MACET']<>NULL){echo $dataDataPemohon['BAKIDEBET_MACET'];}else{echo '0';} ?>" id="baki_debet" readonly >
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Summary</td>
										<td style="width:50%;">
										<?php IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){?>
											<a class="btn btn-success btn-xs" href='scoring-individual-fram.php?USERNAME=<?php echo $user;?>&id=<?php echo $dataDataPemohon['PEFINDO_MAPPING_ID']; ?>&prospect_no=<?php echo $prospect;?>' target="_blank"
											>view</a>
										<?php }ELSE{ ?>
											<a class="btn btn-success btn-xs" href='slik-detail-fram.php?USERNAME=<?php echo $user;?>&id=<?php echo $dataDataPemohon['PEFINDO_MAPPING_ID']; ?>&no=<?php echo $prospect;?>&custtype=<?php echo 'PEMOHON';?>' target="_blank"
												>view</a>
										<?php } ?>
										</td>
									</tr>
									
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA <?php echo $siapanih;?></td>
									</tr>
								
									<tr>
										<td style="width:50%;">HISTORICAL KREDIT </td>
										<td style="width:50%;">
											<input type="text" name="historical_kredit" class="form-control"  value="<?php echo $dataDataPasangan['SOURCE_BY'] ;?>"  id="historical_kredit" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama </td>
										<td style="width:50%;">
											<input type="text" name="nama_pemohon" class="form-control" value="<?php echo $namasaya;?>"  id="nama_pemohon" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Deskripsi Score </td>
										<td style="width:50%;">
											<input type="text" name="score" class="form-control" value="<?php echo $dataDescPasangan['SCORE_DESC'];?>"  id="score" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">OD MAX</td>
										<td style="width:50%;">
											<input type="text" name="od" class="form-control" value="<?php echo $dataDataPasangan['OD'];?>"  id="od" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Total Baki Debet Macet</td>
										<td style="width:50%;">
											<input type="text" name="baki_debet" class="form-control" 
											value="<?php if($dataDataPasangan['BAKIDEBET_MACET']<>NULL){echo $dataDataPasangan['BAKIDEBET_MACET'];}else{echo '0';} ?>" id="baki_debet" readonly >
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Summary</td>
										<td style="width:50%;">
										<?php IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){?>
											<a class="btn btn-success btn-xs" href='scoring-individual-fram.php?USERNAME=<?php echo $user;?>&id=<?php echo $dataDataPasangan['PEFINDO_MAPPING_ID']; ?>&prospect_no=<?php echo $prospect;?>' target="_blank"
											>view</a>
										<?php }ELSE{ ?>
											<a class="btn btn-success btn-xs" href='slik-detail-fram.php?USERNAME=<?php echo $user;?>&id=<?php echo $dataDataPasangan['PEFINDO_MAPPING_ID']; ?>&no=<?php echo $prospect;?>&custtype=<?php echo $siapanih;?>' target="_blank"
												>view</a>
										<?php } ?>
								
										</td>
									</tr>
									
									
								</table>
							</div>								
						</div>
						
						<div class="table-responsive">
								<table class="table ">
								<tr>
										<td style="width:30%;"><b>SCHEME </b> : </td>
										<td style="width:50%;">
											<input type="text" name="desc_score" class="form-control"  value="<?php 
											if ($dataScheme['SCHEME_ID'] == 'NMTBR'){
											echo 'NMC';
											}else{
												echo 'UMC';
											}
											
											?>"  id="tdp" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%;"><b>TDP </b> : </td>
										<td style="width:50%;">
											<input type="text" name="desc_score" class="form-control"  value="<?php echo $tdp;?>"  id="tdp" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%;"><b>FINAL DESKRIPSI SCORE </b> : </td>
										<td style="width:50%;">
											<input type="text" name="desc_score" class="form-control"  value="<?php echo $dataScore['DESKRIPSI_SCORE'];?>"  id="historical_kredit" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%;"><b>LEVEL APPROVAL</b> : </td>
										<td style="width:50%;">
											<input type="text" name="historical_kredit" class="form-control"  value="<?php echo $dataApv['ROLE_CODE'];?>"  id="historical_kredit" readonly>
										</td>
									</tr>
									
									
								</table>
							</div>
						</div>
						
								<div class="table-responsive">
										<table class="table table-bordered">
											<tr>
												<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">LAMPIRAN</td>
											</tr>
											
											<tr>
												<td >Photo Usaha</td>
												<td >
													<button onclick="myFunction()">View Photo Usaha</button>
												</td>
											</tr>
												<form action="" method="post" enctype="multipart/form-data">
											<tr>
												<td >Upload Ringkasan Analisa Kredit (RAK) </td>
												<td >
												<a href="index.php?page=detail-form-rak&USERNAME=<?php echo $user;?>&prospect=<?php echo $dataRak['PROSPECT_NO'];?>&app=<?php echo $app_no;?>&apv_no=<?php echo $dataRak['APV_NO'];?>" target="_blank"class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
													<!--<input type="file" name="rak" required style="margin-bottom:5px;" />-->
													
													<?php /*
													<td style="width:150px;text-align:center;"><a href="assets/rak/<?php echo $dataCA['RAK'];?>" class="btn theme-btn" style="margin:0px;padding:10px;font-size:12px;">Download</a></td>
															*/?>		
													
												</td>
											</tr>	
											
								</div>
									</table>
									
									<div id="foto_rumah_usaha" style="display:none;">
									<div class="table-responsive">
										<?php IF($dataScheme['STAT_MOS'] == 'NEW'){ ?>
										<table class="table table-bordered">
									<tr>
										<td >Foto Rumah 1</td>
										<td  colspan="2">
											<?php if($imgRumah1 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgRumah1;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgRumah1;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									<tr>
										<td >Foto Rumah 2</td>
										<td  colspan="2">
											<?php if($imgRumah2 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgRumah2;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgRumah2;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									
									<tr>
										<td >Foto Rumah 3</td>
										<td  colspan="2">
											<?php if($imgRumah3 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgRumah3;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgRumah3;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									
									<tr>
										<td >Foto Rumah 4</td>
										<td  colspan="2">
											<?php if($imgRumah4 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgRumah4;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgRumah4;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 1</td>
										<td  colspan="2">
											<?php if($imgUsaha1 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgUsaha1;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgUsaha1;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 2</td>
										<td  colspan="2">
											<?php if($imgUsaha2 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgUsaha2;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgUsaha2;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 3</td>
										<td  colspan="2">
											<?php if($imgUsaha3 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo $imgUsaha3;?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo $imgUsaha3;?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									</div>
								</table>
									<?php }else{ ?>
									<table class="table table-bordered">
									<tr>
										<td >Foto Rumah 1</td>
										<td  colspan="2">
											<?php if($imgRumah1 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgRumah1);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgRumah1);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									<tr>
										<td >Foto Rumah 2</td>
										<td  colspan="2">
											<?php if($imgRumah2 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgRumah2);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgRumah2);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									
									<tr>
										<td >Foto Rumah 3</td>
										<td  colspan="2">
											<?php if($imgRumah3 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgRumah3);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgRumah3);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									
									<tr>
										<td >Foto Rumah 4</td>
										<td  colspan="2">
											<?php if($imgRumah4 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgRumah4);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgRumah4);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 1</td>
										<td  colspan="2">
											<?php if($imgUsaha1 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha1);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha1);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 2</td>
										<td  colspan="2">
											<?php if($imgUsaha2 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha2);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha2);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
										<tr>
										<td >Foto Usaha 3</td>
										<td  colspan="2">
											<?php if($imgUsaha3 <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha3);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgUsaha3);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											
											
																	
											
										</td>
									</tr>
									</div>
								</table>
									<?php } ?>
							</div>
							</div>
							<div id="mydiv"  style="display:block;">
								<div class="table-responsive">
										<table class="table table-bordered">
									
											<tr>
												<td colspan="3" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Catatan</td>
											</tr>
											<tr>
												<td >Catatan</td>
												<td colspan="2">
													<textarea name="catatan" id="catatan" value="" class="form-control"> </textarea>
													
												</td>
											</tr>	
											
											<tr>
												<td >Pengajuan Deviasi</td>
												<td >
													 <select name="deviasi" class="form-control" required>
														<option value="YA">YA</option>
														<option value="TIDAK">TIDAK</option>
													
													</select>     

												</td>
												<td >
													<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="Submit" style="width:200px;" >
												</td>
											</tr>
								</div>
									</table>
									</form>
							
						</div>
						</div>
						
					</div>
					
<script src="assets/js/jqueryrotate.min.js"></script>	
		
<script>
 window.onbeforeunload = function () {
        $("input[type=submit]").attr("disabled", "disabled");
    };
function myFunction() {
  var x = document.getElementById("foto_rumah_usaha");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>		
<script>
(function() {
  var $, Lightbox, LightboxOptions;

  $ = jQuery;

  LightboxOptions = (function() {
    function LightboxOptions() {
      this.fadeDuration = 500;
      this.fitImagesInViewport = true;
      this.resizeDuration = 700;
      this.showImageNumberLabel = true;
      this.wrapAround = false;
    }

    LightboxOptions.prototype.albumLabel = function(curImageNum, albumSize) {
      return "Image " + curImageNum + " of " + albumSize;
    };

    return LightboxOptions;

  })();

  Lightbox = (function() {
    function Lightbox(options) {
      this.options = options;
      this.album = [];
      this.currentImageIndex = void 0;
      this.init();
    }

    Lightbox.prototype.init = function() {
      this.enable();
      return this.build();
    };

    Lightbox.prototype.enable = function() {
      var _this = this;
      return $('body').on('click', 'a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]', function(e) {
        _this.start($(e.currentTarget));
        return false;
      });
    };

    Lightbox.prototype.build = function() {
      var _this = this;
      $("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close' style='margin:5px;'><button class='btn btn-danger btn-sm btn-fill'><i class='fa fa-times'></i></button></a>&nbsp;&nbsp;&nbsp;<a class='lb-rotate' style='margin:5px;'><button class='btn btn-primary btn-sm btn-fill' style='margib-right:5px;'><i class='fa fa-undo'></i></button></a></div></div></div></div>").appendTo($('body'));
      this.$lightbox = $('#lightbox');
      this.$overlay = $('#lightboxOverlay');
      this.$outerContainer = this.$lightbox.find('.lb-outerContainer');
      this.$container = this.$lightbox.find('.lb-container');
      this.containerTopPadding = parseInt(this.$container.css('padding-top'), 10);
      this.containerRightPadding = parseInt(this.$container.css('padding-right'), 10);
      this.containerBottomPadding = parseInt(this.$container.css('padding-bottom'), 10);
      this.containerLeftPadding = parseInt(this.$container.css('padding-left'), 10);
      this.$overlay.hide().on('click', function() {
        _this.end();
        return false;
      });
      this.$lightbox.hide().on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$outerContainer.on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$lightbox.find('.lb-prev').on('click', function() {
        if (_this.currentImageIndex === 0) {
          _this.changeImage(_this.album.length - 1);
        } else {
          _this.changeImage(_this.currentImageIndex - 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-next').on('click', function() {
        if (_this.currentImageIndex === _this.album.length - 1) {
          _this.changeImage(0);
        } else {
          _this.changeImage(_this.currentImageIndex + 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-rotate').on('click', function() {
          $cont = _this.$lightbox.find('.lb-outerContainer');
          $image = _this.$lightbox.find('.lb-image');
          
            if ($($cont).attr('angle') == null) {
                $($cont).attr('angle', 0);
            }
            var value = Number($($cont).attr('angle'));
            value += 90;
        
            $($cont).rotate({ animateTo:value});
            $($cont).attr('angle', value);          
          
          return false;
      });      
      
      return this.$lightbox.find('.lb-loader, .lb-close').on('click', function() {
        _this.end();
        return false;
      });
    };

    Lightbox.prototype.start = function($link) {
      var $window, a, dataLightboxValue, i, imageNumber, left, top, _i, _j, _len, _len1, _ref, _ref1;
      $(window).on("resize", this.sizeOverlay);
      $('select, object, embed').css({
        visibility: "hidden"
      });
      this.$overlay.width($(document).width()).height($(document).height()).fadeIn(this.options.fadeDuration);
      this.album = [];
      imageNumber = 0;
      dataLightboxValue = $link.attr('data-lightbox');
      if (dataLightboxValue) {
        _ref = $($link.prop("tagName") + '[data-lightbox="' + dataLightboxValue + '"]');
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          a = _ref[i];
          this.album.push({
            link: $(a).attr('href'),
            title: $(a).attr('title')
          });
          if ($(a).attr('href') === $link.attr('href')) {
            imageNumber = i;
          }
        }
      } else {
        if ($link.attr('rel') === 'lightbox') {
          this.album.push({
            link: $link.attr('href'),
            title: $link.attr('title')
          });
        } else {
          _ref1 = $($link.prop("tagName") + '[rel="' + $link.attr('rel') + '"]');
          for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
            a = _ref1[i];
            this.album.push({
              link: $(a).attr('href'),
              title: $(a).attr('title')
            });
            if ($(a).attr('href') === $link.attr('href')) {
              imageNumber = i;
            }
          }
        }
      }
      $window = $(window);
      top = $window.scrollTop() + $window.height() / 10;
      left = $window.scrollLeft();
      this.$lightbox.css({
        top: top + 'px',
        left: left + 'px'
      }).fadeIn(this.options.fadeDuration);
      this.changeImage(imageNumber);
    };

    Lightbox.prototype.changeImage = function(imageNumber) {
      var $image, preloader,
        _this = this;
      this.disableKeyboardNav();
      $image = this.$lightbox.find('.lb-image');
      
      this.sizeOverlay();
      this.$overlay.fadeIn(this.options.fadeDuration);
      $('.lb-loader').fadeIn('slow');
      this.$lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption').hide();
      this.$outerContainer.addClass('animating');
      preloader = new Image();
      preloader.onload = function() {
        var $preloader, imageHeight, imageWidth, maxImageHeight, maxImageWidth, windowHeight, windowWidth;
        $image.attr('src', _this.album[imageNumber].link);
        $preloader = $(preloader);
        $image.width(preloader.width);
        $image.height(preloader.height);
        if (_this.options.fitImagesInViewport) {
          windowWidth = $(window).width();
          windowHeight = $(window).height();
          maxImageWidth = windowWidth - _this.containerLeftPadding - _this.containerRightPadding - 20;
          maxImageHeight = windowHeight - _this.containerTopPadding - _this.containerBottomPadding - 110;
          if ((preloader.width > maxImageWidth) || (preloader.height > maxImageHeight)) {
            if ((preloader.width / maxImageWidth) > (preloader.height / maxImageHeight)) {
              imageWidth = maxImageWidth;
              imageHeight = parseInt(preloader.height / (preloader.width / imageWidth), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            } else {
              imageHeight = maxImageHeight;
              imageWidth = parseInt(preloader.width / (preloader.height / imageHeight), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            }
          }
        }
        return _this.sizeContainer($image.width(), $image.height());
      };
      preloader.src = this.album[imageNumber].link;
      this.currentImageIndex = imageNumber;
    };

    Lightbox.prototype.sizeOverlay = function() {
      return $('#lightboxOverlay').width($(document).width()).height($(document).height());
    };

    Lightbox.prototype.sizeContainer = function(imageWidth, imageHeight) {
      var newHeight, newWidth, oldHeight, oldWidth,
        _this = this;
      oldWidth = this.$outerContainer.outerWidth();
      oldHeight = this.$outerContainer.outerHeight();
      newWidth = imageWidth + this.containerLeftPadding + this.containerRightPadding;
      newHeight = imageHeight + this.containerTopPadding + this.containerBottomPadding;
      this.$outerContainer.animate({
        width: newWidth,
        height: newHeight
      }, this.options.resizeDuration, 'swing');
      setTimeout(function() {
        _this.$lightbox.find('.lb-dataContainer').width(newWidth);
        _this.$lightbox.find('.lb-prevLink').height(newHeight);
        _this.$lightbox.find('.lb-nextLink').height(newHeight);
        _this.showImage();
      }, this.options.resizeDuration);
    };

    Lightbox.prototype.showImage = function() {
      this.$lightbox.find('.lb-loader').hide();
      this.$lightbox.find('.lb-image').fadeIn('slow');
      this.updateNav();
      this.updateDetails();
      this.preloadNeighboringImages();
      this.enableKeyboardNav();
    };

    Lightbox.prototype.updateNav = function() {
      this.$lightbox.find('.lb-nav').show();
      if (this.album.length > 1) {
        if (this.options.wrapAround) {
          this.$lightbox.find('.lb-prev, .lb-next').show();
        } else {
          if (this.currentImageIndex > 0) {
            this.$lightbox.find('.lb-prev').show();
          }
          if (this.currentImageIndex < this.album.length - 1) {
            this.$lightbox.find('.lb-next').show();
          }
        }
      }
    };

    Lightbox.prototype.updateDetails = function() {
      var _this = this;
      if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "") {
        this.$lightbox.find('.lb-caption').html(this.album[this.currentImageIndex].title).fadeIn('fast');
      }
      if (this.album.length > 1 && this.options.showImageNumberLabel) {
        this.$lightbox.find('.lb-number').text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn('fast');
      } else {
        this.$lightbox.find('.lb-number').hide();
      }
      this.$outerContainer.removeClass('animating');
      this.$lightbox.find('.lb-dataContainer').fadeIn(this.resizeDuration, function() {
        return _this.sizeOverlay();
      });
    };

    Lightbox.prototype.preloadNeighboringImages = function() {
      var preloadNext, preloadPrev;
      if (this.album.length > this.currentImageIndex + 1) {
        preloadNext = new Image();
        preloadNext.src = this.album[this.currentImageIndex + 1].link;
      }
      if (this.currentImageIndex > 0) {
        preloadPrev = new Image();
        preloadPrev.src = this.album[this.currentImageIndex - 1].link;
      }
    };

    Lightbox.prototype.enableKeyboardNav = function() {
      $(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
    };

    Lightbox.prototype.disableKeyboardNav = function() {
      $(document).off('.keyboard');
    };

    Lightbox.prototype.keyboardAction = function(event) {
      var KEYCODE_ESC, KEYCODE_LEFTARROW, KEYCODE_RIGHTARROW, key, keycode;
      KEYCODE_ESC = 27;
      KEYCODE_LEFTARROW = 37;
      KEYCODE_RIGHTARROW = 39;
      keycode = event.keyCode;
      key = String.fromCharCode(keycode).toLowerCase();
      if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
        this.end();
      } else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
        if (this.currentImageIndex !== 0) {
          this.changeImage(this.currentImageIndex - 1);
        }
      } else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
        if (this.currentImageIndex !== this.album.length - 1) {
          this.changeImage(this.currentImageIndex + 1);
        }
      }
    };

    Lightbox.prototype.end = function() {
      this.disableKeyboardNav();
      $(window).off("resize", this.sizeOverlay);
      this.$lightbox.fadeOut(this.options.fadeDuration);
      this.$overlay.fadeOut(this.options.fadeDuration);
      return $('select, object, embed').css({
        visibility: "visible"
      });
    };

    return Lightbox;

  })();

  $(function() {
    var lightbox, options;
    options = new LightboxOptions();
    return lightbox = new Lightbox(options);
  });

}).call(this);
</script>


				