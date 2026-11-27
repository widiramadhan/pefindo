<?php

$user=$_GET['USERNAME'];
//$app_no = $_GET['app'];
$prospect=$_GET['prospect'];
$branchid= substr($prospect,0,4);
$type_kendaraan= substr($prospect,0,2);
$level = 2;	

$callCust = "{call SP_RAK_GET_CUST_INFO_MOS(?)}";
$paramCust =  array(array($prospect, SQLSRV_PARAM_IN));
$execCust = sqlsrv_query( $conn, $callCust, $paramCust) or die( print_r( sqlsrv_defaults(), true)); 
$dataCust = sqlsrv_fetch_array($execCust);
$app_no_ao = $dataCust['APP_NO_AO'];


$callInfo = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN_MOS(?)}";
$paramInfo =  array(array($prospect, SQLSRV_PARAM_IN));
$execInfo = sqlsrv_query( $conn, $callInfo, $paramInfo) or die( print_r( sqlsrv_defaults(), true)); 
$dataInfo = sqlsrv_fetch_array($execInfo);

$callApv = "{call SP_APPROVAL_GETLIST_APV_NO_RAK(?)}";
$paramApv =  array(array($prospect, SQLSRV_PARAM_IN));
$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_errors(), true));
$dataApv= sqlsrv_fetch_array($execApv);

$callDp= "{call SP_GET_STATUS_UP_DP_RAK(?)}";
$paramDp =  array(array($dataApv['APV_NO'], SQLSRV_PARAM_IN));
				 
$execDp = sqlsrv_query( $conn, $callDp, $paramDp) or die( print_r( sqlsrv_defaults(), true)); 
$dataDp = sqlsrv_fetch_array($execDp);

$callSvy= "{call SP_RAK_GET_SURVEY_ID_MOS(?)}";
$paramSvy =  array(array($prospect, SQLSRV_PARAM_IN));
$execSvy = sqlsrv_query( $conn, $callSvy, $paramSvy) or die( print_r( sqlsrv_defaults(), true)); 
$dataSvy = sqlsrv_fetch_array($execSvy);

$callTagging = "{call SP_RAK_GET_GEOTAGING_SURVEY_MOS(?)}";
$paramTagging =  array(array($prospect, SQLSRV_PARAM_IN));
$execTagging = sqlsrv_query( $conn, $callTagging, $paramTagging) or die( print_r( sqlsrv_defaults(), true)); 
$dataTagging = sqlsrv_fetch_array($execTagging);

$callSC1 = "{call SP_CREATE_RISK_INDICATOR(?,?)}";
$paramSC1 =  array(array($prospect, SQLSRV_PARAM_IN),
			   array($user, SQLSRV_PARAM_IN));
$execSC1 = sqlsrv_query($conn, $callSC1, $paramSC1) or die(print_r(sqlsrv_defaults(), true));
$dataSC1 = sqlsrv_fetch_array($execSC1);

$callBank = "{call SP_RAK_GET_BANK_INFO_MOS(?)}";
$paramBank =  array(array($prospect, SQLSRV_PARAM_IN));
$execBank = sqlsrv_query( $conn, $callBank, $paramBank) or die( print_r( sqlsrv_errors(), true)); 
$dataBank = sqlsrv_fetch_array($execBank);
$total_pendaptan_cra = $dataBank['GAJI_PEMOHON'] + $dataBank['GAJI_PASANGAN'];

$callBankAo = "{call SP_RAK_GET_BANK_INFO(?)}";
$paramBankAo =  array(array($app_no_ao, SQLSRV_PARAM_IN));
$execBankAo = sqlsrv_query( $conn, $callBankAo, $paramBankAo) or die( print_r( sqlsrv_defaults(), true)); 
$dataBankAo = sqlsrv_fetch_array($execBankAo);



$callAnalis = "{call SP_RAK_GET_ANALISA_CREDIT(?,?)}";
$paramAnalis =  array(array($prospect, SQLSRV_PARAM_IN),
						array(1, SQLSRV_PARAM_IN));
$execAnalis = sqlsrv_query( $conn, $callAnalis, $paramAnalis) or die( print_r( sqlsrv_defaults(), true)); 
$dataAnalis = sqlsrv_fetch_array($execAnalis);



$cust_model_pemohon = $dataInfo['CUST_MODEL'];
$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];

$callGetDeviasi = "{call SP_RAK_GET_DEVIASI_TRIGGER(?)}";
$paramGetDeviasi =  array(array($prospect, SQLSRV_PARAM_IN));
$execGetDeviasi = sqlsrv_query($conn, $callGetDeviasi, $paramGetDeviasi) or die(print_r(sqlsrv_defaults(), true));
$dataGetDeviasi = sqlsrv_fetch_array($execGetDeviasi);


$ktp_pemohon = $dataInfo['ID_NO'];

if($dataInfo['Pasangan_Noktp'] == "" || $dataInfo['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$siapanih1 = "PENJAMIN";
		$ktpsaya = $dataInfo['Penjamin_Noktp'];
		$namasaya = $dataInfo['Penjamin_Nama'];
		if($dataInfo['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Penjamin_TglLahir'];}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Penjamin_TglLahir'];
		$tempatlahirsaya = $dataInfo['Penjamin_TempatLahir'];
		 if($dataInfo['Penjamin_Ibu']<>NULL){$namaibusaya = $dataInfo['Penjamin_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Penjamin_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Penjamin_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Penjamin_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Penjamin_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
	}else{
		$siapanih = "Pasangan";
		$siapanih1 = "PASANGAN";
		$ktpsaya = $dataInfo['Pasangan_Noktp'];
		$namasaya = $dataInfo['Pasangan_Nama'];
		if($dataInfo['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Pasangan_TglLahir'];}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Pasangan_TglLahir'];
		$tempatlahirsaya = $dataInfo['Pasangan_TempatLahir'];
		if($dataInfo['Pasangan_Ibu']<>NULL){$namaibusaya = $dataInfo['Pasangan_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Pasangan_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Pasangan_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Pasangan_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Pasangan_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
		
	}
$callInfoProfesi = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN_PROFESI_MOS(?)}";
$paramInfoProfesi =  array(array($prospect, SQLSRV_PARAM_IN));
$execInfoProfesi = sqlsrv_query( $conn, $callInfoProfesi, $paramInfoProfesi) or die( print_r( sqlsrv_errors(), true));
$dataInfoProfesi = sqlsrv_fetch_array($execInfoProfesi);
if($siapanih = "Pasangan"){
	$profesi_pasangan=$dataInfoProfesi['Pasangan_PROFESI'];
	$perusahaan_pasangan=$dataInfoProfesi['Pasangan_NAMA_PERUSAHAAN'];
	$lama_bekerja_pasangan=$dataInfoProfesi['Pasangan_LAMA_BEKERJA'];
	$industri_pasangan=$dataInfoProfesi['Pasangan_INDUSTRY_TYPE'];
}else{
	$profesi_pasangan=$dataInfoProfesi['Penjamin_PROFESI'];
	$perusahaan_pasangan=$dataInfoProfesi['Penjamin_NAMA_PERUSAHAAN'];
	$lama_bekerja_pasangan=$dataInfoProfesi['Penjamin_LAMA_BEKERJA'];
	$industri_pasangan=$dataInfoProfesi['Penjamin_INDUSTRY_TYPE'];
}



//pemohon
$callMappingPemohon = "{call SP_RAK_GET_MAPPING_ID_PEFINDOSLIK(?,?)}";
$paramMappingPemohon =  array(array($prospect, SQLSRV_PARAM_IN),
					   array($ktp_pemohon, SQLSRV_PARAM_IN),);
$execMappingPemohon = sqlsrv_query( $conn, $callMappingPemohon, $paramMappingPemohon) or die( print_r( sqlsrv_defaults(), true)); 
$dataMappingPemohon = sqlsrv_fetch_array($execMappingPemohon);
$mapping_id = $dataMappingPemohon['PEFINDO_MAPPING_ID'];


$callMappingPasangan = "{call SP_RAK_GET_MAPPING_ID_PEFINDOSLIK(?,?)}";
$paramMappingPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
					   array($ktpsaya, SQLSRV_PARAM_IN),);
$execMappingPasangan = sqlsrv_query( $conn, $callMappingPasangan, $paramMappingPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataMappingPasangan = sqlsrv_fetch_array($execMappingPasangan);
$mapping_idPasangan = $dataMappingPasangan['PEFINDO_MAPPING_ID'];


$callDataPemohon = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
$paramDataPemohon =  array(array($prospect, SQLSRV_PARAM_IN),
					 array('PEMOHON', SQLSRV_PARAM_IN));
$execDataPemohon = sqlsrv_query( $conn, $callDataPemohon, $paramDataPemohon) or die( print_r( sqlsrv_defaults(), true)); 
$dataDataPemohon = sqlsrv_fetch_array($execDataPemohon);

$callDataPasangan = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
$paramDataPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
					 array('Pasangan', SQLSRV_PARAM_IN));
$execDataPasangan = sqlsrv_query( $conn, $callDataPasangan, $paramDataPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataDataPasangan = sqlsrv_fetch_array($execDataPasangan);


$callDesc = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
$paramDesc =  array(array($dataDataPemohon['SCORE'], SQLSRV_PARAM_IN),
				array('1', SQLSRV_PARAM_IN));
$execDesc = sqlsrv_query( $conn, $callDesc, $paramDesc) or die( print_r( sqlsrv_defaults(), true)); 
$dataDesc = sqlsrv_fetch_array($execDesc);

$scorePemohon = $dataDesc['SCORE_DESC'];

$callDescPasangan = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
$paramDescPasangan =  array(array($dataDataPasangan['SCORE'], SQLSRV_PARAM_IN),
				array('1', SQLSRV_PARAM_IN));
$execDescPasangan = sqlsrv_query( $conn, $callDescPasangan, $paramDescPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataDescPasangan = sqlsrv_fetch_array($execDescPasangan);

$scorePasangan = $dataDescPasangan['SCORE_DESC'];


// $callDsr = "{call SP_GET_DSR_PEFINDOLSIK_MOS(?)}";
// $paramDsr =  array(array($prospect, SQLSRV_PARAM_IN));
// $execDsr = sqlsrv_query( $conn, $callDsr, $paramDsr) or die( print_r( sqlsrv_defaults(), true)); 
// $dataDsr = sqlsrv_fetch_array($execDsr);

$callImgDomisili = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
$paramImgDomisili =  array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execImgDomisili = sqlsrv_query( $conn, $callImgDomisili, $paramImgDomisili) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgDomisili = sqlsrv_fetch_array($execImgDomisili);
$imgDomisiliCA = $dataImgDomisili['IMAGES_VALIDASI'];

$callImgRumah = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
$paramImgRumah =  array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOKUMEN PENDUKUNG RUMAH', SQLSRV_PARAM_IN));
$execImgRumah = sqlsrv_query( $conn, $callImgRumah, $paramImgRumah) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgRumah = sqlsrv_fetch_array($execImgRumah);
$imgRumahCA = $dataImgRumah['IMAGES_VALIDASI'];

$callImgGeotaging = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
$paramImgGeotaging =  array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execImgGeotaging = sqlsrv_query( $conn, $callImgGeotaging, $paramImgGeotaging) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgGeotaging = sqlsrv_fetch_array($execImgGeotaging);
$ImgGeotagingCA = $dataImgGeotaging['IMAGES_VALIDASI'];


$callImgKunj = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
$paramImgKunj =  array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
$execImgKunj = sqlsrv_query( $conn, $callImgKunj, $paramImgKunj) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgKunj= sqlsrv_fetch_array($execImgKunj);
$ImgKunjCA = $dataImgKunj['IMAGES_VALIDASI'];

$callImgKryBank = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
$paramImgKryBank =  array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
$execImgKryBank = sqlsrv_query( $conn, $callImgKryBank, $paramImgKryBank) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgKryBank = sqlsrv_fetch_array($execImgKryBank);
$ImgKryBankCA = $dataImgKryBank['IMAGES_VALIDASI'];

$callHasilRak= "{call SP_RAK_GET_HASIL_RAK(?,?)}";
$paramHasilRak =  array(array($prospect, SQLSRV_PARAM_IN),
					array(1, SQLSRV_PARAM_IN));
$execHasilRak = sqlsrv_query( $conn, $callHasilRak, $paramHasilRak) or die( print_r( sqlsrv_defaults(), true)); 
$dataHasilRak= sqlsrv_fetch_array($execHasilRak);

$callCatatanDomisili = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanDomisili =  array(array($prospect, SQLSRV_PARAM_IN),
					array('SBH', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execCatatanDomisili = sqlsrv_query( $conn, $callCatatanDomisili, $paramCatatanDomisili) or die( print_r( sqlsrv_defaults(), true)); 
$dataCatatanDomisili = sqlsrv_fetch_array($execCatatanDomisili);

$callCatatanGeotaging = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanGeotaging =  array(array($prospect, SQLSRV_PARAM_IN),
					array('SBH', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execCatatanGeotaging = sqlsrv_query( $conn, $callCatatanGeotaging, $paramCatatanGeotaging) or die( print_r( sqlsrv_defaults(), true)); 
$dataCatatanGeotaging = sqlsrv_fetch_array($execCatatanGeotaging);


$callCatatanPemilikRmh = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanPemilikRmh =  array(array($prospect, SQLSRV_PARAM_IN),
					array('SBH', SQLSRV_PARAM_IN),
					array('NAMA_PEMILIK_RUMAH', SQLSRV_PARAM_IN));
$execCatatanPemilikRmh = sqlsrv_query( $conn, $callCatatanPemilikRmh, $paramCatatanPemilikRmh) or die( print_r( sqlsrv_defaults(), true)); 
$dataCatatanPemilikRmh = sqlsrv_fetch_array($execCatatanPemilikRmh);




$callKapasitasKry = "{call SP_RAK_GET_KAPASITAS_KARYAWAN(?,?,?,?)}";
$paramKapasitasKry =  array(array($prospect, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('KARYAWAN', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasKry = sqlsrv_query( $conn, $callKapasitasKry, $paramKapasitasKry) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasKry = sqlsrv_fetch_array($execKapasitasKry);

$callKapasitasWrs = "{call SP_RAK_GET_KAPASITAS_WIRASWASTA(?,?,?,?)}";
$paramKapasitasWrs =  array(array($prospect, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('WIRASWASTA', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasWrs = sqlsrv_query( $conn, $callKapasitasWrs, $paramKapasitasWrs) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasWrs = sqlsrv_fetch_array($execKapasitasWrs);

$callKapasitasPro = "{call SP_RAK_GET_KAPASITAS_PROFESIONAL(?,?,?,?)}";
$paramKapasitasPro =  array(array($prospect, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('PROFESSIONAL', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasPro = sqlsrv_query( $conn, $callKapasitasPro, $paramKapasitasPro) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasPro = sqlsrv_fetch_array($execKapasitasPro);

$callKapasitasNonPro = "{call SP_RAK_GET_KAPASITAS_NON_PROFESIONAL(?,?,?,?)}";
$paramKapasitasNonPro =  array(array($prospect, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasNonPro = sqlsrv_query( $conn, $callKapasitasNonPro, $paramKapasitasKry) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasNonPro = sqlsrv_fetch_array($execKapasitasNonPro);

$callKapasitasKryPasangan = "{call SP_RAK_GET_KAPASITAS_KARYAWAN(?,?,?,?)}";
$paramKapasitasKryPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('KARYAWAN', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasKryPasangan = sqlsrv_query( $conn, $callKapasitasKryPasangan, $paramKapasitasKryPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasKryPasangan = sqlsrv_fetch_array($execKapasitasKryPasangan);

$callKapasitasWrsPasangan = "{call SP_RAK_GET_KAPASITAS_WIRASWASTA(?,?,?,?)}";
$paramKapasitasWrsPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('WIRASWASTA', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasWrsPasangan = sqlsrv_query( $conn, $callKapasitasWrsPasangan, $paramKapasitasWrsPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasWrsPasangan = sqlsrv_fetch_array($execKapasitasWrsPasangan);

$callKapasitasProPasangan = "{call SP_RAK_GET_KAPASITAS_PROFESIONAL(?,?,?,?)}";
$paramKapasitasProPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('PROFESSIONAL', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasProPasangan = sqlsrv_query( $conn, $callKapasitasProPasangan, $paramKapasitasProPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasProPasangan = sqlsrv_fetch_array($execKapasitasProPasangan);

$callKapasitasNonProPasangan = "{call SP_RAK_GET_KAPASITAS_NON_PROFESIONAL(?,?,?,?)}";
$paramKapasitasNonProPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
						array('SBH', SQLSRV_PARAM_IN));
$execKapasitasNonProPasangan = sqlsrv_query( $conn, $callKapasitasNonProPasangan, $paramKapasitasNonProPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataKapasitasNonProPasangan = sqlsrv_fetch_array($execKapasitasNonProPasangan);



$callGetVal = "{call SP_RAK_GET_VALIDASI(?,?)}";
$paramGetVal =  array(array($prospect, SQLSRV_PARAM_IN),
								 array('SBH', SQLSRV_PARAM_IN));
$execGetVal = sqlsrv_query( $conn, $callGetVal, $paramGetVal) or die( print_r( sqlsrv_defaults(), true)); 
$dataGetVal = sqlsrv_fetch_array($execGetVal);


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

if($dataInfo['Pasangan_Noktp'] == "" || $dataInfo['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$siapanih1 = "PENJAMIN";
		$ktpsaya = $dataInfo['Penjamin_Noktp'];
		$namasaya = $dataInfo['Penjamin_Nama'];
		if($dataInfo['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Penjamin_TglLahir'];}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Penjamin_TglLahir'];
		$tempatlahirsaya = $dataInfo['Penjamin_TempatLahir'];
		 if($dataInfo['Penjamin_Ibu']<>NULL){$namaibusaya = $dataInfo['Penjamin_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Penjamin_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Penjamin_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Penjamin_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Penjamin_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
	}else{
		$siapanih = "Pasangan";
		$siapanih1 = "PASANGAN";
		$ktpsaya = $dataInfo['Pasangan_Noktp'];
		$namasaya = $dataInfo['Pasangan_Nama'];
		if($dataInfo['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Pasangan_TglLahir'];}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Pasangan_TglLahir'];
		$tempatlahirsaya = $dataInfo['Pasangan_TempatLahir'];
		if($dataInfo['Pasangan_Ibu']<>NULL){$namaibusaya = $dataInfo['Pasangan_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Pasangan_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Pasangan_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Pasangan_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Pasangan_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
		
	}

if(isset($_POST['submit1'])){
	
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$catatan1 = $_POST['catatan_domisili'];
	$catatan2 = $_POST['catatan_geotaging'];
	
	

	$level = 2;
	$cust_pemohon = "PEMOHON";
	$cust_pasangan = "PASANGAN";
	$role_code = "CA";		
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];	
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['ph']);
	$otr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['otr']);
	$tenor = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tenor']);
	$up_dp_cal = $_POST['up_dp_cal'];
	$note_rak = $_POST['note_rak'];
	if($up_dp_cal == 'YA'){
		$angsuran_new_dp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
		$amount_tdp_awal = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
		$tdp_persen_awal = $dataCust['TDP_PERCENT']; 
		$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['naik_amount_tdp_cal']);
		$tdp_persen = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['naik_tdp_persen_cal']); 
		
		
		$callInsDp= "{call SP_RAK_INSERT_UP_DP_NEW(?,?,?,?,?,?,?,?,?)}";
		$paramInsDp =  array(array($prospect, SQLSRV_PARAM_IN),
								array($otr, SQLSRV_PARAM_IN),
								array($amount_tdp_awal, SQLSRV_PARAM_IN),
								array($amount_tdp, SQLSRV_PARAM_IN),
								array($tdp_persen_awal, SQLSRV_PARAM_IN),
								array($tdp_persen, SQLSRV_PARAM_IN),
								array($angsuran_new_dp, SQLSRV_PARAM_IN),
								array($user, SQLSRV_PARAM_IN),
								array($note_rak, SQLSRV_PARAM_IN));
		$execInsDp = sqlsrv_query( $conn, $callInsDp, $paramInsDp) or die( print_r( sqlsrv_errors(), true)); 
		
		if($execInsDp){
			echo"<script>alert('Data Berhasil Dikembalikan ke MH untuk di update');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		exit();
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
	
		}else{
		$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
		$tdp_persen = $dataCust['TDP_PERCENT']; 
		}

	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];

	$analisa = '';
	$angsuran_new = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_pendapatan']);
	//$dsr =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['dsr']);
	$dsr = $_POST['dsr'];
	$rekomendasi = "REKOMENDASI";
	$approval = "APPROVE";
	$shm = $_POST['shm_ck1'];
	$shm_val = $_POST['shm_val'];
	$akta = $_POST['akta_jual_beli_ck1'];
	$akta_val = $_POST['akta_jual_beli_val'];
	$girik = $_POST['surat_girik_ck1'];
	$girik_val = $_POST['surat_girik_val'];
	$pbb = $_POST['pbb_ck1'];
	$pbb_val = $_POST['pbb_val'];
	$rek_listrik = $_POST['rek_listrik_ck1'];
	$rek_listrik_val = $_POST['rek_listrik_val'];
	$rek_air = $_POST['rek_air_ck1'];
	$rek_air_val = $_POST['rek_air_val'];
	$skrd = $_POST['skrd_ck1'];
	$skrd_val = $_POST['skrd_val'];
	$status_rumah_val = $_POST['status_rumah_val'];
	$alamat_domisili_pemohon_val =  "";
	$alamat_domisili_pemohon_notes =  "";
	$alamat_domisili_pasangan_val =  "";
	$alamat_domisili_pasangan_notes =  "";
	$domisili_val =  $_POST['domisili_val'];
	$catatan_domisili =  $_POST['catatan_domisili'];
	$hasil_foto_survey_val =  $_POST['hasil_foto_survey_val'];
	$catatan_geotaging =  $_POST['catatan_geotaging'];
	$angsuran_berjalan =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_berjalan']);


if($cust_model_pemohon == "KARYAWAN"){
		$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
		$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
		$output5 = "null";
		$output6 = "null";
		$output7 = "null";
		$nama_perusahaan_pemohon = $_POST['nama_perusahaan_pemohon'];
		$nama_perusahaan_pemohon_val = $_POST['nama_perusahaan_pemohon_val'];
		$jabatan_pemohon = $_POST['jabatan_pemohon'];
		$jabatan_pemohon_val = '';
		$industry_type_pemohon = $_POST['industry_type_pemohon'];
		$industry_type_pemohon_val ='';
		$lama_bekerja_pemohon = $_POST['lama_bekerja_pemohon'];
		$lama_bekerja_pemohon_val ='';
		$slip_gaji_pemohon = $_POST['slip_gaji_pemohon_ck1'];
		$slip_gaji_pemohon_val = $_POST['slip_gaji_pemohon_val'];
		$daftar_gaji_pemohon = $_POST['daftar_gaji_pemohon_ck1'];
		$daftar_gaji_pemohon_val = $_POST['daftar_gaji_pemohon_val'];
		$surat_ket_penghasilan_pemohon = $_POST['surat_ket_penghasilan_pemohon_ck1'];
		$surat_ket_penghasilan_pemohon_val = $_POST['surat_ket_penghasilan_pemohon_val'];
		$bukti_saldo_print_jamsos_pemohon = $_POST['bukti_saldo_print_jamsos_pemohon_ck1'];
		$bukti_saldo_print_jamsos_pemohon_val = $_POST['bukti_saldo_print_jamsos_pemohon_val'];
		$bukti_spt_pemohon = $_POST['bukti_spt_pemohon_ck1'];
		$bukti_spt_pemohon_val = $_POST['bukti_spt_pemohon_val'];
		$rekening_tabungan_pemohon = $_POST['rekening_tabungan_pemohon_ck1'];
		$rekening_tabungan_pemohon_val = $_POST['rekening_tabungan_pemohon_val'];
		$foto_kartu_identitas_pemohon = $_POST['foto_kartu_identitas_pemohon_ck1'];
		$foto_kartu_identitas_pemohon_val = $_POST['foto_kartu_identitas_pemohon_val'];
		$validasi_karyawan_pemohon = $_POST['validasi_karyawan_pemohon'];
		$telp_kantor_pemohon = $_POST['telp_kantor_pemohon'];
		$status_karyawan_pemohon = $_POST['status_karyawan_pemohon'];
		$pic_kantor_pemohon = $_POST['pic_kantor_pemohon'];
		$verf_kantor_kry_pemohon = $_POST['verf_kantor_kry_pemohon']; 
		
		if ($dataKapasitasKry['NOMINAL_GAJI_CRA']=='.00' || $dataKapasitasKry['NOMINAL_GAJI_CRA']=='.000'){
			$gaji_cra = 0;
		}ELSE{
			$gaji_cra = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['NOMINAL_GAJI_CRA']),0, -2);
		}	
				   
		if ($dataKapasitasKry['NOMINAL_GAJI_RAK']=='.00' || $dataKapasitasKry['NOMINAL_GAJI_RAK']=='.000'){
			$nominal_rak = 0;
		}ELSE{
			$nominal_rak = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['NOMINAL_GAJI_RAK']),0, -2);
		}	
		
		$tgl_gaji = $dataKapasitasKry['PENERIMAAN_GAJI'];
		
		if ($dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']=='.00' || $dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']=='.000'){
			$nominal_gajian = 0;
		}ELSE{
			$nominal_gajian = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']),0, -2);
		}

		
		
		$kry_bank_penerbit = $_POST['kry_bank_penerbit'];
		$kry_norek = $_POST['kry_norek'];
		$kry_pemilik_rekening = $_POST['kry_pemilik_rekening'];
		$mutasi_karyawan = $_POST['mutasi_karyawan'];
		$validasi_tf_pemohon = $_POST['validasi_tf_pemohon'];
		$val_tf = $_POST['validasi_tf_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
		
		
	$callInsKryPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($slip_gaji_pemohon, SQLSRV_PARAM_IN),
					array($slip_gaji_pemohon_val, SQLSRV_PARAM_IN),
					array($daftar_gaji_pemohon, SQLSRV_PARAM_IN),
					array($daftar_gaji_pemohon_val, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pemohon, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pemohon, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pemohon_val, SQLSRV_PARAM_IN),
					array($bukti_spt_pemohon, SQLSRV_PARAM_IN),
					array($bukti_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pemohon, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pemohon, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
			//		echo '<pre>' . var_export($paramInsKryPemD,true) .'<pre>'; 
			//exit();
	$exec1InsKryPemD = sqlsrv_query( $conn, $callInsKryPemD, $paramInsKryPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsKryPemH = "{call SP_RAK_INSERT_KAPASITAS_KARYAWAN_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pemohon, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pemohon_val, SQLSRV_PARAM_IN),
					array($jabatan_pemohon, SQLSRV_PARAM_IN),
					array($jabatan_pemohon_val, SQLSRV_PARAM_IN),
					array($industry_type_pemohon, SQLSRV_PARAM_IN),
					array($industry_type_pemohon_val, SQLSRV_PARAM_IN),
					array($lama_bekerja_pemohon, SQLSRV_PARAM_IN),
					array($lama_bekerja_pemohon_val, SQLSRV_PARAM_IN),
					array($validasi_karyawan_pemohon, SQLSRV_PARAM_IN),
					array($gaji_cra, SQLSRV_PARAM_IN),
					array($nominal_rak, SQLSRV_PARAM_IN),
					array($tgl_gaji, SQLSRV_PARAM_IN),
					array($nominal_gajian, SQLSRV_PARAM_IN),
					array($kry_bank_penerbit, SQLSRV_PARAM_IN),
					array($kry_norek, SQLSRV_PARAM_IN),
					array($kry_pemilik_rekening, SQLSRV_PARAM_IN),
					array($mutasi_karyawan, SQLSRV_PARAM_IN),
					array($validasi_tf_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($telp_kantor_pemohon, SQLSRV_PARAM_IN),
					array($status_karyawan_pemohon, SQLSRV_PARAM_IN),
					array($pic_kantor_pemohon, SQLSRV_PARAM_IN),
					array($verf_kantor_kry_pemohon, SQLSRV_PARAM_IN));
//		echo '<pre>' . var_export($paramInsKryPemH,true) .'<pre>'; 
			//exit();
	$exec1InsKryPemH = sqlsrv_query( $conn, $callInsKryPemH, $paramInsKryPemH) or die( print_r( sqlsrv_errors(), true)); 	
	
	}
	
	if($join_income == "YA" && $cust_model_pasangan == "KARYAWAN"){
		$output8 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pasangan']['tmp_name']);
		$output9 = prepareImageDBString($_FILES['img_tf_kry_pasangan']['tmp_name']);
		$output10 = "null";
		$output11 = "null";
		$output12 = "null";
		
		$nama_perusahaan_pasangan = $_POST['nama_perusahaan_pasangan'];
		$nama_perusahaan_pasangan_val = $_POST['nama_perusahaan_pasangan_val'];
		$jabatan_pasangan = $_POST['jabatan_pasangan'];
		$jabatan_pasangan_val = $_POST['jabatan_pasangan_val'];
		$industry_type_pasangan = $_POST['industry_type_pasangan'];
		$industry_type_pasangan_val = $_POST['industry_type_pasangan_val'];
		$lama_bekerja_pasangan = $_POST['lama_bekerja_pasangan'];
		$lama_bekerja_pasangan_val = $_POST['lama_bekerja_pasangan_val'];
		$slip_gaji_pasangan = $_POST['slip_gaji_pasangan_ck1'];
		$slip_gaji_pasangan_val = $_POST['slip_gaji_pasangan_val'];
		$daftar_gaji_pasangan = $_POST['daftar_gaji_pasangan_ck1'];
		$daftar_gaji_pasangan_val = $_POST['daftar_gaji_pasangan_val'];
		$surat_ket_penghasilan_pasangan = $_POST['surat_ket_penghasilan_pasangan_ck1'];
		$surat_ket_penghasilan_pasangan_val = $_POST['surat_ket_penghasilan_pasangan_val'];
		$bukti_saldo_print_jamsos_pasangan = $_POST['bukti_saldo_print_jamsos_pasangan_ck1'];
		$bukti_saldo_print_jamsos_pasangan_val = $_POST['bukti_saldo_print_jamsos_pasangan_val'];
		$bukti_spt_pasangan = $_POST['bukti_spt_pasangan_ck1'];
		$bukti_spt_pasangan_val = $_POST['bukti_spt_pasangan_val'];
		$rekening_tabungan_pasangan = $_POST['rekening_tabungan_pasangan_ck1'];
		$rekening_tabungan_pasangan_val = $_POST['rekening_tabungan_pasangan_val'];
		$foto_kartu_identitas_pasangan = $_POST['foto_kartu_identitas_pasangan_ck1'];
		$foto_kartu_identitas_pasangan_val = $_POST['foto_kartu_identitas_pasangan_val'];
		$validasi_karyawan_pasangan = $_POST['validasi_karyawan_pasangan'];
		
		if ($dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']=='.00' || $dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']=='.000'){
			$gaji_pasangan_cra = 0;
		}ELSE{
			$gaji_pasangan_cra = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']),0, -2);
		}	
		
		//$gaji_pasangan_cra = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']),0, -2);
		if ($dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']=='.00' || $dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']=='.000'){
			$nominal_pasangan_rak = 0;
		}ELSE{
			$nominal_pasangan_rak = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']),0, -2);
		}	
		$tgl_pasangan_gaji = $dataKapasitasKryPasangan['PENERIMAAN_GAJI'];
		//$besaran_nominal_pasangan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']),0, -2);
		
		if ($dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']=='.00' || $dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']=='.000'){
			$besaran_nominal_pasangan = 0;
		}ELSE{
			 $besaran_nominal_pasangan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']),0, -2);
		}
	
		
		
		$kry_bank_penerbit_pasangan = $_POST['kry_bank_penerbit_pasangan'];
		$kry_norek_pasangan = $_POST['kry_norek_pasangan'];
		$kry_pemilik_rekening_pasangan = $_POST['kry_pemilik_rekening_pasangan'];
		$mutasi_karyawan_pasangan = $_POST['mutasi_karyawan_pasangan'];
		$validasi_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$val_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan']);
		$telp_kantor_pasangan = $_POST['telp_kantor_pasangan'];
		$status_karyawan_pasangan = $_POST['status_karyawan_pasangan'];
		$pic_kantor_pasangan = $_POST['pic_kantor_pasangan'];
		$verf_kantor_kry_pasangan = $_POST['verf_kantor_kry_pasangan'];
		
	$callInsKryPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($slip_gaji_pasangan, SQLSRV_PARAM_IN),
					array($slip_gaji_pasangan_val, SQLSRV_PARAM_IN),
					array($daftar_gaji_pasangan, SQLSRV_PARAM_IN),
					array($daftar_gaji_pasangan_val, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pasangan, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pasangan, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pasangan_val, SQLSRV_PARAM_IN),
					array($bukti_spt_pasangan, SQLSRV_PARAM_IN),
					array($bukti_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pasangan, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pasangan, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsKryPasD = sqlsrv_query( $conn, $callInsKryPasD, $paramInsKryPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsKryPasH = "{call SP_RAK_INSERT_KAPASITAS_KARYAWAN_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pasangan, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pasangan_val, SQLSRV_PARAM_IN),
					array($jabatan_pasangan, SQLSRV_PARAM_IN),
					array($jabatan_pasangan_val, SQLSRV_PARAM_IN),
					array($industry_type_pasangan, SQLSRV_PARAM_IN),
					array($industry_type_pasangan_val, SQLSRV_PARAM_IN),
					array($lama_bekerja_pasangan, SQLSRV_PARAM_IN),
					array($lama_bekerja_pasangan_val, SQLSRV_PARAM_IN),
					array($validasi_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($gaji_pasangan_cra, SQLSRV_PARAM_IN),
					array($nominal_pasangan_rak, SQLSRV_PARAM_IN),
					array($tgl_pasangan_gaji, SQLSRV_PARAM_IN),
					array($besaran_nominal_pasangan, SQLSRV_PARAM_IN),
					array($kry_bank_penerbit_pasangan, SQLSRV_PARAM_IN),
					array($kry_norek_pasangan, SQLSRV_PARAM_IN),
					array($kry_pemilik_rekening_pasangan, SQLSRV_PARAM_IN),
					array($mutasi_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($validasi_tf_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($telp_kantor_pasangan, SQLSRV_PARAM_IN),
					array($status_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($pic_kantor_pasangan, SQLSRV_PARAM_IN),
					array($verf_kantor_kry_pasangan, SQLSRV_PARAM_IN));
	$exec1InsKryPasH = sqlsrv_query( $conn, $callInsKryPasH, $paramInsKryPasH) or die( print_r( sqlsrv_defaults(), true)); 				
	
	}
	
	
	
	
	
	
	
	if($cust_model_pemohon == "WIRASWASTA"){
		$output3 = "null";
		$output4 = "null";
		$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
		$output6 = "null";
		$output7 = "null";
		$rek_tabungan_pemohon_wrs_ck = $_POST['rek_tabungan_pemohon_wrs_ck1'];
		$rek_tabungan_pemohon_val = $_POST['rek_tabungan_pemohon_val'];
		$nota_pembelian_wrs_pemohon_ck = $_POST['nota_pembelian_wrs_pemohon_ck1'];
		$nota_pembelian_pemohon_val = $_POST['nota_pembelian_pemohon_val'];	
		$nota_penjualan_wrs_pemohon_ck = $_POST['nota_penjualan_wrs_pemohon_ck1'];
		$nota_penjualan_pemohon_val = $_POST['nota_penjualan_pemohon_val'];	
		$spt_wrs_pemohon_ck = $_POST['spt_wrs_pemohon_ck1'];
		$spt_wrs_pemohon_val = $_POST['spt_wrs_pemohon_val'];
		$nota_lampiran_pemohon = $_POST['nota_lampiran_pemohon'];
		$nota_periode_pemohon = $_POST['nota_periode_pemohon'];	
		 
		$wrs_pemohon_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasWrs['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		$tot_nota_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_nota_pendapatan_wrs_pemohon']);
		$margin_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['margin_pendapatan_wrs_pemohon']);
		$tot_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_pendapatan_wrs_pemohon']);
		$biaya_opr_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['biaya_opr_wrs_pemohon']);
		$net_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['net_wrs_pemohon']);
		$wrs_pemohon_bank_penerbit = $_POST['wrs_pemohon_bank_penerbit'];
		$wrs_pemohon_norek = $_POST['wrs_pemohon_norek'];
		$wrs_pemohon_rekening = $_POST['wrs_pemohon_rekening'];
		$wrs_pemohon_mutasi = $_POST['wrs_pemohon_mutasi'];
		$validasi_wrs_pemohon = $_POST['validasi_wrs_pemohon'];
		if($wrs_pemohon_pendapatan == ''){
			$wrs_pemohon_pendapatan  = 0;
		}
		$val_tf = $_POST['validasi_wrs_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
		
		
		
		
	$callInsWrsPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($rek_tabungan_pemohon_wrs_ck, SQLSRV_PARAM_IN),
					array($rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($nota_pembelian_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($nota_pembelian_pemohon_val, SQLSRV_PARAM_IN),
					array($nota_penjualan_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($nota_penjualan_pemohon_val, SQLSRV_PARAM_IN),
					array($spt_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($spt_wrs_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPemD = sqlsrv_query( $conn, $callInsWrsPemD, $paramInsWrsPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
			if($nota_lampiran_pemohon == NULL){
			$nota_lampiran_pemohon = '';
			$nota_periode_pemohon = '';
			$tot_nota_pendapatan_wrs_pemohon = 0;
			$margin_pendapatan_wrs_pemohon=0;
			$tot_pendapatan_wrs_pemohon = 0;
			$biaya_opr_wrs_pemohon = 0;
			$net_wrs_pemohon = 0;
		}
	$callInsWrsPemH = "{call SP_RAK_INSERT_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nota_lampiran_pemohon, SQLSRV_PARAM_IN),
					array($nota_periode_pemohon, SQLSRV_PARAM_IN),
					array($tot_nota_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($margin_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($tot_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($biaya_opr_wrs_pemohon, SQLSRV_PARAM_IN),
					array($net_wrs_pemohon, SQLSRV_PARAM_IN),
					array($wrs_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($wrs_pemohon_norek, SQLSRV_PARAM_IN),
					array($wrs_pemohon_rekening, SQLSRV_PARAM_IN),
					array($wrs_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($wrs_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_wrs_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPemH = sqlsrv_query( $conn, $callInsWrsPemH, $paramInsWrsPemH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "WIRASWASTA"){
		$output8 = "null";
		$output9 = "null";
		$output10 = prepareImageDBString($_FILES['img_tf_wrs_pasangan']['tmp_name']);
		$output11 = "null";
		$output12 = "null";
		$rek_tabungan_pasangan_wrs_ck = $_POST['rek_tabungan_pasangan_wrs_ck1'];
		$rek_tabungan_pasangan_val = $_POST['rek_tabungan_pasangan_val'];
		$nota_pembelian_wrs_pasangan_ck = $_POST['nota_pembelian_wrs_pasangan_ck1'];
		$nota_pembelian_pasangan_val = $_POST['nota_pembelian_pasangan_val'];	
		$nota_penjualan_wrs_pasangan_ck = $_POST['nota_penjualan_wrs_pasangan_ck1'];
		$nota_penjualan_pasangan_val = $_POST['nota_penjualan_pasangan_val'];	
		$spt_wrs_pasangan_ck = $_POST['spt_wrs_pasangan_ck1'];
		$spt_wrs_pasangan_val = $_POST['spt_wrs_pasangan_val'];
		$nota_lampiran_pasangan = $_POST['nota_lampiran_pasangan'];
		$nota_periode_pasangan = $_POST['nota_periode_pasangan'];	
		$wrs_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasWrsPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		$tot_nota_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_nota_pendapatan_wrs_pasangan']);
		$margin_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['margin_pendapatan_wrs_pasangan']);
		$tot_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_pendapatan_wrs_pasangan']);
		$biaya_opr_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['biaya_opr_wrs_pasangan']);
		$net_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['net_wrs_pasangan']);
		
		$wrs_pasangan_bank_penerbit = $_POST['wrs_pasangan_bank_penerbit'];
		$wrs_pasangan_norek = $_POST['wrs_pasangan_norek'];
		$wrs_pasangan_rekening = $_POST['wrs_pasangan_rekening'];
		$wrs_pasangan_mutasi = $_POST['wrs_pasangan_mutasi'];
		$validasi_wrs_pasangan = $_POST['validasi_wrs_pasangan'];
		if($wrs_pasangan_pendapatan == ''){
			$wrs_pasangan_pendapatan  = 0;
		}
		$val_tf_pasangan = 	$_POST['validasi_wrs_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan1']);
		
	$callInsWrsPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($rek_tabungan_pasangan_wrs_ck, SQLSRV_PARAM_IN),
					array($rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($nota_pembelian_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($nota_pembelian_pasangan_val, SQLSRV_PARAM_IN),
					array($nota_penjualan_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($nota_penjualan_pasangan_val, SQLSRV_PARAM_IN),
					array($spt_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($spt_wrs_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPasD = sqlsrv_query( $conn, $callInsWrsPasD, $paramInsWrsPasD)  or die( print_r( sqlsrv_defaults(), true));
//	or die( print_r( sqlsrv_defaults(), true)); 		
	 //or die( print_r( sqlsrv_defaults(), true));
		if($nota_lampiran_pasangan == NULL){
			$nota_lampiran_pasangan = '';
			$nota_periode_pasangan = '';
			$tot_nota_pendapatan_wrs_pasangan = 0;
			$margin_pendapatan_wrs_pasangan=0;
			$tot_pendapatan_wrs_pasangan = 0;
			$biaya_opr_wrs_pasangan = 0;
			$net_wrs_pasangan = 0;
		}
	$callInsWrsPasH = "{call SP_RAK_INSERT_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nota_lampiran_pasangan, SQLSRV_PARAM_IN),
					array($nota_periode_pasangan, SQLSRV_PARAM_IN),
					array($tot_nota_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($margin_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($tot_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($biaya_opr_wrs_pasangan, SQLSRV_PARAM_IN),
					array($net_wrs_pasangan, SQLSRV_PARAM_IN),
					array($wrs_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($wrs_pasangan_norek, SQLSRV_PARAM_IN),
					array($wrs_pasangan_rekening, SQLSRV_PARAM_IN),
					array($wrs_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($wrs_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_wrs_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	//echo '<pre>' . var_export($paramInsWrsPasH, true) . '</pre>';
	//var_dump($paramInsWrsPasH);
	//exit();
	$exec1InsWrsPasH = sqlsrv_query( $conn, $callInsWrsPasH, $paramInsWrsPasH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
		
		
	}
	
	if($cust_model_pemohon == "PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
		$output7 = "null";
		$pro_bukti_penghasilan_pemohon_ck = $_POST['pro_bukti_penghasilan_pemohon_ck1'];
		$pro_bukti_penghasilan_pemohon_val = $_POST['pro_bukti_penghasilan_pemohon_val'];
		$pro_rek_tabungan_pemohon_ck = $_POST['pro_rek_tabungan_pemohon_ck1'];
		$pro_rek_tabungan_pemohon_val = $_POST['pro_rek_tabungan_pemohon_val'];	
		$pro_spt_pemohon_ck = $_POST['pro_spt_pemohon_ck1'];
		$pro_spt_pemohon_val = $_POST['pro_spt_pemohon_val'];	
			
		$pro_pemohon_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasPro['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		
		
		$pro_pemohon_bank_penerbit = $_POST['pro_pemohon_bank_penerbit'];
		$pro_pemohon_norek = $_POST['pro_pemohon_norek'];
		$pro_pemohon_rekening = $_POST['pro_pemohon_rekening'];
		$pro_pemohon_mutasi = $_POST['pro_pemohon_mutasi'];
		$validasi_pro_pemohon = $_POST['validasi_pro_pemohon'];
		$val_tf = $_POST['validasi_pro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
		if($pro_pemohon_pendapatan == ''){
			$pro_pemohon_pendapatan  = 0;
		}
			
		
	$callInsProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($pro_spt_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPemD = sqlsrv_query( $conn, $callInsProPemD, $paramInsProPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsProPemH = "{call SP_RAK_INSERT_KAPASITAS_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($pro_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($pro_pemohon_norek, SQLSRV_PARAM_IN),
					array($pro_pemohon_rekening, SQLSRV_PARAM_IN),
					array($pro_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($pro_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_pro_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPemH = sqlsrv_query( $conn, $callInsProPemH, $paramInsProPemH) or die( print_r( sqlsrv_errors(), true)); 		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "PROFESSIONAL"){
		$output8 = "null";
		$output9 = "null";
		$output10 = "null";
		$output11 = prepareImageDBString($_FILES['img_tf_pro_pasangan']['tmp_name']);
		$output12 = "null";
		$pro_bukti_penghasilan_pasangan_ck = $_POST['pro_bukti_penghasilan_pasangan_ck1'];
		$pro_bukti_penghasilan_pasangan_val = $_POST['pro_bukti_penghasilan_pasangan_val'];
		$pro_rek_tabungan_pasangan_ck = $_POST['pro_rek_tabungan_pasangan_ck1'];
		$pro_rek_tabungan_pasangan_val = $_POST['pro_rek_tabungan_pasangan_val'];	
		$pro_spt_pasangan_ck = $_POST['pro_spt_pasangan_ck1'];
		$pro_spt_pasangan_val = $_POST['pro_spt_pasangan_val'];	
		
		$pro_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasProPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		if($pro_pasangan_pendapatan == ''){
			$pro_pasangan_pendapatan  = 0;
		}
		
		$pro_pasangan_bank_penerbit = $_POST['pro_pasangan_bank_penerbit'];
		$pro_pasangan_norek = $_POST['pro_pasangan_norek'];
		$pro_pasangan_rekening = $_POST['pro_pasangan_rekening'];
		$pro_pasangan_mutasi = $_POST['pro_pasangan_mutasi'];
		$validasi_pro_pasangan = $_POST['validasi_pro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_pro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan2']);
		
			
		
	$callInsProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($pro_spt_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPasD = sqlsrv_query( $conn, $callInsProPasD, $paramInsProPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsProPasH = "{call SP_RAK_INSERT_KAPASITAS_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($pro_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($pro_pasangan_norek, SQLSRV_PARAM_IN),
					array($pro_pasangan_rekening, SQLSRV_PARAM_IN),
					array($pro_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($pro_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_pro_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPasH = sqlsrv_query( $conn, $callInsProPasH, $paramInsProPasH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
	}

	
	if($cust_model_pemohon == "NON PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = "null";
		$output7 = prepareImageDBString($_FILES['img_tf_nonpro_pemohon']['tmp_name']);
		$nonpro_bukti_penghasilan_pemohon_ck = $_POST['nonpro_bukti_penghasilan_pemohon_ck1'];
		$nonpro_bukti_penghasilan_pemohon_val = $_POST['nonpro_bukti_penghasilan_pemohon_val'];
		$nonpro_rek_tabungan_pemohon_ck = $_POST['nonpro_rek_tabungan_pemohon_ck1'];
		$nonpro_rek_tabungan_pemohon_val = $_POST['nonpro_rek_tabungan_pemohon_val'];	
		$nonpro_spt_pemohon_ck = $_POST['nonpro_spt_pemohon_ck1'];
		$nonpro_spt_pemohon_val = $_POST['nonpro_spt_pemohon_val'];	
		
		$nonpro_pemohon_pendapatan =substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasNonPro['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
			if($nonpro_pemohon_pendapatan == ''){
			$nonpro_pemohon_pendapatan  = 0;
		}
			
		
		$nonpro_pemohon_bank_penerbit = $_POST['nonpro_pemohon_bank_penerbit'];
		$nonpro_pemohon_norek = $_POST['nonpro_pemohon_norek'];
		$nonpro_pemohon_rekening = $_POST['nonpro_pemohon_rekening'];
		$nonpro_pemohon_mutasi = $_POST['nonpro_pemohon_mutasi'];
		$validasi_nonpro_pemohon = $_POST['validasi_nonpro_pemohon'];
		$val_tf = $_POST['validasi_nonpro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
			
		
	$callInsNonProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($nonpro_spt_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPemD = sqlsrv_query( $conn, $callInsNonProPemD, $paramInsNonProPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsNonProPemH = "{call SP_RAK_INSERT_KAPASITAS_NON_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_norek, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_rekening, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_nonpro_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPemH = sqlsrv_query( $conn, $callInsNonProPemH, $paramInsNonProPemH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "NON PROFESSIONAL"){
		$output8 = "null";
		$output9 = "null";
		$output10 = "null";
		$output11 = "null";
		$output12 = prepareImageDBString($_FILES['img_tf_nonpro_pasangan']['tmp_name']);
		$nonpro_bukti_penghasilan_pasangan_ck = $_POST['nonpro_bukti_penghasilan_pasangan_ck1'];
		$nonpro_bukti_penghasilan_pasangan_val = $_POST['nonpro_bukti_penghasilan_pasangan_val'];
		$nonpro_rek_tabungan_pasangan_ck = $_POST['nonpro_rek_tabungan_pasangan_ck1'];
		$nonpro_rek_tabungan_pasangan_val = $_POST['nonpro_rek_tabungan_pasangan_val'];	
		$nonpro_spt_pasangan_ck = $_POST['nonpro_spt_pasangan_ck1'];
		$nonpro_spt_pasangan_val = $_POST['nonpro_spt_pasangan_val'];	
		
		$nonpro_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasNonProPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		if($nonpro_pasangan_pendapatan == ''){
			$nonpro_pasangan_pendapatan  = 0;
		}
		
		$nonpro_pasangan_bank_penerbit = $_POST['nonpro_pasangan_bank_penerbit'];
		$nonpro_pasangan_norek = $_POST['nonpro_pasangan_norek'];
		$nonpro_pasangan_rekening = $_POST['nonpro_pasangan_rekening'];
		$nonpro_pasangan_mutasi = $_POST['nonpro_pasangan_mutasi'];
		$validasi_nonpro_pasangan = $_POST['validasi_nonpro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_nonpro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan3']);
			
		
	$callInsNonProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($nonpro_spt_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPasD = sqlsrv_query( $conn, $callInsNonProPasD, $paramInsNonProPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsNonProPasH = "{call SP_RAK_INSERT_KAPASITAS_NON_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_norek, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_rekening, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_nonpro_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
					//echo '<pre>' . var_export($paramInsWrsPasH, true) . '</pre>';
	//var_dump($paramInsWrsPasH);
	//exit();
	$exec1InsNonProPasH = sqlsrv_query( $conn, $callInsNonProPasH, $paramInsNonProPasH) or die( print_r( sqlsrv_errors(), true)); 		
		
		
	}
	


	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_defaults(), true)); 		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_defaults(), true)); 		


	}
	if($output7 <> "null"){
	$callImg7 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg7 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
					array($output7, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img7 = sqlsrv_query( $conn, $callImg7, $paramImg7) or die( print_r( sqlsrv_defaults(), true)); 		


	}		
	
	if($join_income == "YA"){
		
		if($output8 <> "null"){
		$callImg8 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg8 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
						array($output8, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img8 = sqlsrv_query( $conn, $callImg8, $paramImg8) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		

		
		if($output9 <> "null"){
		$callImg9 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg9 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
						array($output9, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img9 = sqlsrv_query( $conn, $callImg9, $paramImg9) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		
		if($output10 <> "null"){
		$callImg10 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg10 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
						array($output10, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img10 = sqlsrv_query( $conn, $callImg10, $paramImg10) or die( print_r( sqlsrv_defaults(), true)); 		
			

		}	
		
		if($output11 <> "null"){
		$callImg11 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg11 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
						array($output11, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img11 = sqlsrv_query( $conn, $callImg11, $paramImg11) or die( print_r( sqlsrv_defaults(), true)); 		


		}
		if($output12 <> "null"){
		$callImg12 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg12 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
						array($output12, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img12 = sqlsrv_query( $conn, $callImg12, $paramImg12) or die( print_r( sqlsrv_defaults(), true)); 		


		}
	}
	
	if($catatan1 <> "null"){
	$callCatatan1 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan1 = array(array($prospect, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($catatan1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan1 = sqlsrv_query( $conn, $callCatatan1, $paramCatatan1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	
	if($catatan2 <> "null"){
	$callCatatan2 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan2 = array(array($prospect, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($catatan2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan2= sqlsrv_query( $conn, $callCatatan2, $paramCatatan2) or die( print_r( sqlsrv_defaults(), true)); 		
	}	
	
	$queryDomisili = "{call SP_RAK_INSERT_UPDATE_DOMISILI(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterDomisili = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($shm, SQLSRV_PARAM_IN),
					array($shm_val, SQLSRV_PARAM_IN),
					array($akta, SQLSRV_PARAM_IN),
					array($akta_val, SQLSRV_PARAM_IN),
					array($girik, SQLSRV_PARAM_IN),
					array($girik_val, SQLSRV_PARAM_IN),
					array($pbb, SQLSRV_PARAM_IN),
					array($pbb_val, SQLSRV_PARAM_IN),
					array($rek_listrik, SQLSRV_PARAM_IN),
					array($rek_listrik_val, SQLSRV_PARAM_IN),
					array($rek_air, SQLSRV_PARAM_IN),
					array($rek_air_val, SQLSRV_PARAM_IN),
					array($skrd, SQLSRV_PARAM_IN),
					array($skrd_val, SQLSRV_PARAM_IN),
					array($status_rumah_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execDomisili = sqlsrv_query( $conn, $queryDomisili, $parameterDomisili) or die( print_r( sqlsrv_defaults(), true)); 
	
	if($join_income == "TIDAK"){
	$val_tf_pasangan = '';
	$pendapatan_pasangan_cf = 0;
	$pendapatan_pasangan_rak  = 0;
	}
	$queryValidasi = "{call SP_RAK_INSERT_UPDATE_VALIDASI(?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterValidasi = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($alamat_domisili_pemohon_val, SQLSRV_PARAM_IN),
					array($alamat_domisili_pemohon_notes, SQLSRV_PARAM_IN),
					array($alamat_domisili_pasangan_val, SQLSRV_PARAM_IN),
					array($alamat_domisili_pasangan_notes, SQLSRV_PARAM_IN),
					array($domisili_val, SQLSRV_PARAM_IN),
					array($catatan_domisili, SQLSRV_PARAM_IN),
					array($hasil_foto_survey_val, SQLSRV_PARAM_IN),
					array($catatan_geotaging, SQLSRV_PARAM_IN),
					array($val_tf, SQLSRV_PARAM_IN),
					array($val_tf_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execValidasi = sqlsrv_query( $conn, $queryValidasi, $parameterValidasi) or die( print_r( sqlsrv_defaults(), true)); 
	
if($type_kendaraan == '15'){
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_CA_NEW_V1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterInsert = array(
					array($branchid, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($level, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_name, SQLSRV_PARAM_IN),
					array($jenis_kendaraan, SQLSRV_PARAM_IN),
					array($asset_name, SQLSRV_PARAM_IN),
					array($dealer_name, SQLSRV_PARAM_IN),
					array($ph, SQLSRV_PARAM_IN),
					array($otr, SQLSRV_PARAM_IN),
					array($tenor, SQLSRV_PARAM_IN),
					array($amount_tdp, SQLSRV_PARAM_IN),
					array($tdp_persen, SQLSRV_PARAM_IN),
					array($kordinat_geotagging, SQLSRV_PARAM_IN),
					array($join_income, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($note_rak, SQLSRV_PARAM_IN),
					array($analisa, SQLSRV_PARAM_IN),
					array($angsuran_new, SQLSRV_PARAM_IN),
					array($kewajiban_tempatlain, SQLSRV_PARAM_IN),
					array($total_kewajiban, SQLSRV_PARAM_IN),
					array($total_pendapatan, SQLSRV_PARAM_IN),
					array($dsr, SQLSRV_PARAM_IN),
					array($rekomendasi, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($approval, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN),
					array($ktp_pemohon, SQLSRV_PARAM_IN),
					array($dataInfo['CUST_NAME'], SQLSRV_PARAM_IN),
					array($dataInfo['ALAMAT_DOMISILI'], SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true)); 
	}else{
		$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_CA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterInsert = array(
					array($branchid, SQLSRV_PARAM_IN),
					array($app_no, SQLSRV_PARAM_IN),
					array($level, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_name, SQLSRV_PARAM_IN),
					array($jenis_kendaraan, SQLSRV_PARAM_IN),
					array($asset_name, SQLSRV_PARAM_IN),
					array($dealer_name, SQLSRV_PARAM_IN),
					array($ph, SQLSRV_PARAM_IN),
					array($otr, SQLSRV_PARAM_IN),
					array($tenor, SQLSRV_PARAM_IN),
					array($amount_tdp, SQLSRV_PARAM_IN),
					array($tdp_persen, SQLSRV_PARAM_IN),
					array($kordinat_geotagging, SQLSRV_PARAM_IN),
					array($join_income, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($note_rak, SQLSRV_PARAM_IN),
					array($analisa, SQLSRV_PARAM_IN),
					array($angsuran_new, SQLSRV_PARAM_IN),
					array($kewajiban_tempatlain, SQLSRV_PARAM_IN),
					array($total_kewajiban, SQLSRV_PARAM_IN),
					array($total_pendapatan, SQLSRV_PARAM_IN),
					array($dsr, SQLSRV_PARAM_IN),
					array($rekomendasi, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($approval, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_defaults(), true)); 
	}
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}

if(isset($_POST['submitNo'])){
	
	
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$catatan1 = $_POST['catatan_domisili'];
	$catatan2 = $_POST['catatan_geotaging'];
	
	

	
	
	
	$level = 2;
	$cust_pemohon = "PEMOHON";
	$cust_pasangan = "PASANGAN";
	$role_code = "CA";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['ph']);
	$otr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['otr']);
	$tenor = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tenor']);
	$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
	$tdp_persen = $dataCust['TDP_PERCENT']; 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = '';
	$angsuran_new = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_pendapatan']);
	//$dsr =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['dsr']); 
	$dsr = str_replace(str_split(','), '',$_POST['dsr']);
	//$dsr =  $_POST['dsr'];
	$rekomendasi = "TIDAK REKOMENDASI";
	$approval = "REJECT";
	$shm = $_POST['shm_ck1'];
	$shm_val = $_POST['shm_val'];
	$akta = $_POST['akta_jual_beli_ck1'];
	$akta_val = $_POST['akta_jual_beli_val'];
	$girik = $_POST['surat_girik_ck1'];
	$girik_val = $_POST['surat_girik_val'];
	$pbb = $_POST['pbb_ck1'];
	$pbb_val = $_POST['pbb_val'];
	$rek_listrik = $_POST['rek_listrik_ck1'];
	$rek_listrik_val = $_POST['rek_listrik_val'];
	$rek_air = $_POST['rek_air_ck1'];
	$rek_air_val = $_POST['rek_air_val'];
	$skrd = $_POST['skrd_ck1'];
	$skrd_val = $_POST['skrd_val'];
	$status_rumah_val = $_POST['status_rumah_val'];
	$alamat_domisili_pemohon_val = "";
	$alamat_domisili_pemohon_notes =  "";
	$alamat_domisili_pasangan_val =  "";
	$alamat_domisili_pasangan_notes =  "";
	$domisili_val =  $_POST['domisili_val'];
	$catatan_domisili =  $_POST['catatan_domisili'];
	$hasil_foto_survey_val =  $_POST['hasil_foto_survey_val'];
	$catatan_geotaging =  $_POST['catatan_geotaging'];
	$angsuran_berjalan =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_berjalan']);
	
	$dev_usia = $_POST['dev_usia1'];
	$dev_pas_ttd = $_POST['dev_pas_ttd1'];
	$dev_pengkinian = $_POST['dev_pengkinian1'];
	$dev_srv_kantor = $_POST['dev_srv_kantor1'];
	$dev_negative = $_POST['dev_negative1'];
	
	$rjc = $_POST['rjc'];
	if($rjc == ''){
		
		echo"<script>alert('Harap Isi Reject Reason');history.back();</script>";
	}

	
if($cust_model_pemohon == "KARYAWAN"){
		$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
		$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
		$output5 = "null";
		$output6 = "null";
		$output7 = "null";
		$nama_perusahaan_pemohon = $_POST['nama_perusahaan_pemohon'];
		$nama_perusahaan_pemohon_val = $_POST['nama_perusahaan_pemohon_val'];
		$jabatan_pemohon = $_POST['jabatan_pemohon'];
		$jabatan_pemohon_val = '';
		$industry_type_pemohon = $_POST['industry_type_pemohon'];
		$industry_type_pemohon_val = '';
		$lama_bekerja_pemohon = $_POST['lama_bekerja_pemohon'];
		$lama_bekerja_pemohon_val = '';
		$slip_gaji_pemohon = $_POST['slip_gaji_pemohon_ck1'];
		$slip_gaji_pemohon_val = $_POST['slip_gaji_pemohon_val'];
		$daftar_gaji_pemohon = $_POST['daftar_gaji_pemohon_ck1'];
		$daftar_gaji_pemohon_val = $_POST['daftar_gaji_pemohon_val'];
		$surat_ket_penghasilan_pemohon = $_POST['surat_ket_penghasilan_pemohon_ck1'];
		$surat_ket_penghasilan_pemohon_val = $_POST['surat_ket_penghasilan_pemohon_val'];
		$bukti_saldo_print_jamsos_pemohon = $_POST['bukti_saldo_print_jamsos_pemohon_ck1'];
		$bukti_saldo_print_jamsos_pemohon_val = $_POST['bukti_saldo_print_jamsos_pemohon_val'];
		$bukti_spt_pemohon = $_POST['bukti_spt_pemohon_ck1'];
		$bukti_spt_pemohon_val = $_POST['bukti_spt_pemohon_val'];
		$rekening_tabungan_pemohon = $_POST['rekening_tabungan_pemohon_ck1'];
		$rekening_tabungan_pemohon_val = $_POST['rekening_tabungan_pemohon_val'];
		$foto_kartu_identitas_pemohon = $_POST['foto_kartu_identitas_pemohon_ck1'];
		$foto_kartu_identitas_pemohon_val = $_POST['foto_kartu_identitas_pemohon_val'];
		$validasi_karyawan_pemohon = $_POST['validasi_karyawan_pemohon'];
		$telp_kantor_pemohon = $_POST['telp_kantor_pemohon'];
		$status_karyawan_pemohon = $_POST['status_karyawan_pemohon'];
		$pic_kantor_pemohon = $_POST['pic_kantor_pemohon'];
		$verf_kantor_kry_pemohon = $_POST['verf_kantor_kry_pemohon']; 
		
		if ($dataKapasitasKry['NOMINAL_GAJI_CRA']=='.00' || $dataKapasitasKry['NOMINAL_GAJI_CRA']=='.000'){
			$gaji_cra = 0;
		}ELSE{
			$gaji_cra = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['NOMINAL_GAJI_CRA']),0, -2);
		}	
		if ($dataKapasitasKry['NOMINAL_GAJI_RAK']=='.00' || $dataKapasitasKry['NOMINAL_GAJI_RAK']=='.000'){
			$nominal_rak = 0;
		}ELSE{
			$nominal_rak = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['NOMINAL_GAJI_RAK']),0, -2);
		}	
		$tgl_gaji = $dataKapasitasKry['PENERIMAAN_GAJI'];
		if ($dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']=='.00' || $dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']=='.000'){
			$nominal_gajian = 0;
		}ELSE{
			$nominal_gajian = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKry['BESARAN_NOMINAL_GAJIAN']),0, -2);
		}
		
		$kry_bank_penerbit = $_POST['kry_bank_penerbit'];
		$kry_norek = $_POST['kry_norek'];
		$kry_pemilik_rekening = $_POST['kry_pemilik_rekening'];
		$mutasi_karyawan = $_POST['mutasi_karyawan'];
		$validasi_tf_pemohon = $_POST['validasi_tf_pemohon'];
		$val_tf = $_POST['validasi_tf_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
		
	$callInsKryPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($slip_gaji_pemohon, SQLSRV_PARAM_IN),
					array($slip_gaji_pemohon_val, SQLSRV_PARAM_IN),
					array($daftar_gaji_pemohon, SQLSRV_PARAM_IN),
					array($daftar_gaji_pemohon_val, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pemohon, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pemohon, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pemohon_val, SQLSRV_PARAM_IN),
					array($bukti_spt_pemohon, SQLSRV_PARAM_IN),
					array($bukti_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pemohon, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pemohon, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
					
	$exec1InsKryPemD = sqlsrv_query( $conn, $callInsKryPemD, $paramInsKryPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsKryPemH = "{call SP_RAK_INSERT_KAPASITAS_KARYAWAN_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pemohon, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pemohon_val, SQLSRV_PARAM_IN),
					array($jabatan_pemohon, SQLSRV_PARAM_IN),
					array($jabatan_pemohon_val, SQLSRV_PARAM_IN),
					array($industry_type_pemohon, SQLSRV_PARAM_IN),
					array($industry_type_pemohon_val, SQLSRV_PARAM_IN),
					array($lama_bekerja_pemohon, SQLSRV_PARAM_IN),
					array($lama_bekerja_pemohon_val, SQLSRV_PARAM_IN),
					array($validasi_karyawan_pemohon, SQLSRV_PARAM_IN),
					array($gaji_cra, SQLSRV_PARAM_IN),
					array($nominal_rak, SQLSRV_PARAM_IN),
					array($tgl_gaji, SQLSRV_PARAM_IN),
					array($nominal_gajian, SQLSRV_PARAM_IN),
					array($kry_bank_penerbit, SQLSRV_PARAM_IN),
					array($kry_norek, SQLSRV_PARAM_IN),
					array($kry_pemilik_rekening, SQLSRV_PARAM_IN),
					array($mutasi_karyawan, SQLSRV_PARAM_IN),
					array($validasi_tf_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($telp_kantor_pemohon, SQLSRV_PARAM_IN),
					array($status_karyawan_pemohon, SQLSRV_PARAM_IN),
					array($pic_kantor_pemohon, SQLSRV_PARAM_IN),
					array($verf_kantor_kry_pemohon, SQLSRV_PARAM_IN));
	$exec1InsKryPemH = sqlsrv_query( $conn, $callInsKryPemH, $paramInsKryPemH) or die( print_r( sqlsrv_defaults(), true)); 		
	
	}
	
	if($join_income == "YA" && $cust_model_pasangan == "KARYAWAN"){
		$output8 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pasangan']['tmp_name']);
		$output9 = prepareImageDBString($_FILES['img_tf_kry_pasangan']['tmp_name']);
		$output10 = "null";
		$output11 = "null";
		$output12 = "null";
		
		$nama_perusahaan_pasangan = $_POST['nama_perusahaan_pasangan'];
		$nama_perusahaan_pasangan_val = $_POST['nama_perusahaan_pasangan_val'];
		$jabatan_pasangan = $_POST['jabatan_pasangan'];
		$jabatan_pasangan_val = $_POST['jabatan_pasangan_val'];
		$industry_type_pasangan = $_POST['industry_type_pasangan'];
		$industry_type_pasangan_val = $_POST['industry_type_pasangan_val'];
		$lama_bekerja_pasangan = $_POST['lama_bekerja_pasangan'];
		$lama_bekerja_pasangan_val = $_POST['lama_bekerja_pasangan_val'];
		$slip_gaji_pasangan = $_POST['slip_gaji_pasangan_ck1'];
		$slip_gaji_pasangan_val = $_POST['slip_gaji_pasangan_val'];
		$daftar_gaji_pasangan = $_POST['daftar_gaji_pasangan_ck1'];
		$daftar_gaji_pasangan_val = $_POST['daftar_gaji_pasangan_val'];
		$surat_ket_penghasilan_pasangan = $_POST['surat_ket_penghasilan_pasangan_ck1'];
		$surat_ket_penghasilan_pasangan_val = $_POST['surat_ket_penghasilan_pasangan_val'];
		$bukti_saldo_print_jamsos_pasangan = $_POST['bukti_saldo_print_jamsos_pasangan_ck1'];
		$bukti_saldo_print_jamsos_pasangan_val = $_POST['bukti_saldo_print_jamsos_pasangan_val'];
		$bukti_spt_pasangan = $_POST['bukti_spt_pasangan_ck1'];
		$bukti_spt_pasangan_val = $_POST['bukti_spt_pasangan_val'];
		$rekening_tabungan_pasangan = $_POST['rekening_tabungan_pasangan_ck1'];
		$rekening_tabungan_pasangan_val = $_POST['rekening_tabungan_pasangan_val'];
		$foto_kartu_identitas_pasangan = $_POST['foto_kartu_identitas_pasangan_ck1'];
		$foto_kartu_identitas_pasangan_val = $_POST['foto_kartu_identitas_pasangan_val'];
		$validasi_karyawan_pasangan = $_POST['validasi_karyawan_pasangan'];
		
		
		if ($dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']=='.00' || $dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']=='.000'){
			$gaji_pasangan_cra = 0;
		}ELSE{
			$gaji_pasangan_cra = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['NOMINAL_GAJI_CRA']),0, -2);
		}	
		if ($dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']=='.00' || $dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']=='.000'){
			$nominal_pasangan_rak = 0;
		}ELSE{
			$nominal_pasangan_rak = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['NOMINAL_GAJI_RAK']),0, -2);
		}	
		$tgl_pasangan_gaji = $dataKapasitasKryPasangan['PENERIMAAN_GAJI'];
		
		if ($dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']=='.00' || $dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']=='.000'){
			$besaran_nominal_pasangan = 0;
		}ELSE{
			 $besaran_nominal_pasangan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasKryPasangan['BESARAN_NOMINAL_GAJIAN']),0, -2);
		}
		$kry_bank_penerbit_pasangan = $_POST['kry_bank_penerbit_pasangan'];
		$kry_norek_pasangan = $_POST['kry_norek_pasangan'];
		$kry_pemilik_rekening_pasangan = $_POST['kry_pemilik_rekening_pasangan'];
		$mutasi_karyawan_pasangan = $_POST['mutasi_karyawan_pasangan'];
		$validasi_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$val_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan']);
		$telp_kantor_pasangan = $_POST['telp_kantor_pasangan'];
		$status_karyawan_pasangan = $_POST['status_karyawan_pasangan'];
		$pic_kantor_pasangan = $_POST['pic_kantor_pasangan'];
		$verf_kantor_kry_pasangan = $_POST['verf_kantor_kry_pasangan'];
		
	$callInsKryPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($slip_gaji_pasangan, SQLSRV_PARAM_IN),
					array($slip_gaji_pasangan_val, SQLSRV_PARAM_IN),
					array($daftar_gaji_pasangan, SQLSRV_PARAM_IN),
					array($daftar_gaji_pasangan_val, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pasangan, SQLSRV_PARAM_IN),
					array($surat_ket_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pasangan, SQLSRV_PARAM_IN),
					array($bukti_saldo_print_jamsos_pasangan_val, SQLSRV_PARAM_IN),
					array($bukti_spt_pasangan, SQLSRV_PARAM_IN),
					array($bukti_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pasangan, SQLSRV_PARAM_IN),
					array($rekening_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pasangan, SQLSRV_PARAM_IN),
					array($foto_kartu_identitas_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsKryPasD = sqlsrv_query( $conn, $callInsKryPasD, $paramInsKryPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsKryPasH = "{call SP_RAK_INSERT_KAPASITAS_KARYAWAN_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pasangan, SQLSRV_PARAM_IN),
					array($nama_perusahaan_pasangan_val, SQLSRV_PARAM_IN),
					array($jabatan_pasangan, SQLSRV_PARAM_IN),
					array($jabatan_pasangan_val, SQLSRV_PARAM_IN),
					array($industry_type_pasangan, SQLSRV_PARAM_IN),
					array($industry_type_pasangan_val, SQLSRV_PARAM_IN),
					array($lama_bekerja_pasangan, SQLSRV_PARAM_IN),
					array($lama_bekerja_pasangan_val, SQLSRV_PARAM_IN),
					array($validasi_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($gaji_pasangan_cra, SQLSRV_PARAM_IN),
					array($nominal_pasangan_rak, SQLSRV_PARAM_IN),
					array($tgl_pasangan_gaji, SQLSRV_PARAM_IN),
					array($besaran_nominal_pasangan, SQLSRV_PARAM_IN),
					array($kry_bank_penerbit_pasangan, SQLSRV_PARAM_IN),
					array($kry_norek_pasangan, SQLSRV_PARAM_IN),
					array($kry_pemilik_rekening_pasangan, SQLSRV_PARAM_IN),
					array($mutasi_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($validasi_tf_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($telp_kantor_pasangan, SQLSRV_PARAM_IN),
					array($status_karyawan_pasangan, SQLSRV_PARAM_IN),
					array($pic_kantor_pasangan, SQLSRV_PARAM_IN),
					array($verf_kantor_kry_pasangan, SQLSRV_PARAM_IN));
	$exec1InsKryPasH = sqlsrv_query( $conn, $callInsKryPasH, $paramInsKryPasH) or die( print_r( sqlsrv_defaults(), true)); 		
	
	}
	
	
	
	
	
	
	
	if($cust_model_pemohon == "WIRASWASTA"){
		$output3 = "null";
		$output4 = "null";
		$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
		$output6 = "null";
		$output7 = "null";
		$rek_tabungan_pemohon_wrs_ck = $_POST['rek_tabungan_pemohon_wrs_ck1'];
		$rek_tabungan_pemohon_val = $_POST['rek_tabungan_pemohon_val'];
		$nota_pembelian_wrs_pemohon_ck = $_POST['nota_pembelian_wrs_pemohon_ck1'];
		$nota_pembelian_pemohon_val = $_POST['nota_pembelian_pemohon_val'];	
		$nota_penjualan_wrs_pemohon_ck = $_POST['nota_penjualan_wrs_pemohon_ck1'];
		$nota_penjualan_pemohon_val = $_POST['nota_penjualan_pemohon_val'];	
		$spt_wrs_pemohon_ck = $_POST['spt_wrs_pemohon_ck1'];
		$spt_wrs_pemohon_val = $_POST['spt_wrs_pemohon_val'];
		$nota_lampiran_pemohon = $_POST['nota_lampiran_pemohon'];
		$nota_periode_pemohon = $_POST['nota_periode_pemohon'];	
	
		$wrs_pemohon_pendapatan = 	substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasWrs['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		$tot_nota_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_nota_pendapatan_wrs_pemohon']);
		$margin_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['margin_pendapatan_wrs_pemohon']);
		$tot_pendapatan_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_pendapatan_wrs_pemohon']);
		$biaya_opr_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['biaya_opr_wrs_pemohon']);
		$net_wrs_pemohon = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['net_wrs_pemohon']);
		$wrs_pemohon_bank_penerbit = $_POST['wrs_pemohon_bank_penerbit'];
		$wrs_pemohon_norek = $_POST['wrs_pemohon_norek'];
		$wrs_pemohon_rekening = $_POST['wrs_pemohon_rekening'];
		$wrs_pemohon_mutasi = $_POST['wrs_pemohon_mutasi'];
		$validasi_wrs_pemohon = $_POST['validasi_wrs_pemohon'];
		if($wrs_pemohon_pendapatan == ''){
			$wrs_pemohon_pendapatan  = 0;
		}
		$val_tf = $_POST['validasi_wrs_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
		
		
		
		
	$callInsWrsPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($rek_tabungan_pemohon_wrs_ck, SQLSRV_PARAM_IN),
					array($rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($nota_pembelian_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($nota_pembelian_pemohon_val, SQLSRV_PARAM_IN),
					array($nota_penjualan_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($nota_penjualan_pemohon_val, SQLSRV_PARAM_IN),
					array($spt_wrs_pemohon_ck, SQLSRV_PARAM_IN),
					array($spt_wrs_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPemD = sqlsrv_query( $conn, $callInsWrsPemD, $paramInsWrsPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
			if($nota_lampiran_pemohon == NULL){
			$nota_lampiran_pemohon = '';
			$nota_periode_pemohon = '';
			$tot_nota_pendapatan_wrs_pemohon = 0;
			$margin_pendapatan_wrs_pemohon=0;
			$tot_pendapatan_wrs_pemohon = 0;
			$biaya_opr_wrs_pemohon = 0;
			$net_wrs_pemohon = 0;
		}
	$callInsWrsPemH = "{call SP_RAK_INSERT_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nota_lampiran_pemohon, SQLSRV_PARAM_IN),
					array($nota_periode_pemohon, SQLSRV_PARAM_IN),
					array($tot_nota_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($margin_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($tot_pendapatan_wrs_pemohon, SQLSRV_PARAM_IN),
					array($biaya_opr_wrs_pemohon, SQLSRV_PARAM_IN),
					array($net_wrs_pemohon, SQLSRV_PARAM_IN),
					array($wrs_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($wrs_pemohon_norek, SQLSRV_PARAM_IN),
					array($wrs_pemohon_rekening, SQLSRV_PARAM_IN),
					array($wrs_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($wrs_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_wrs_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPemH = sqlsrv_query( $conn, $callInsWrsPemH, $paramInsWrsPemH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "WIRASWASTA"){
		$output8 = "null";
		$output9 = "null";
		$output10 = prepareImageDBString($_FILES['img_tf_wrs_pasangan']['tmp_name']);
		$output11 = "null";
		$output12 = "null";
		$rek_tabungan_pasangan_wrs_ck = $_POST['rek_tabungan_pasangan_wrs_ck1'];
		$rek_tabungan_pasangan_val = $_POST['rek_tabungan_pasangan_val'];
		$nota_pembelian_wrs_pasangan_ck = $_POST['nota_pembelian_wrs_pasangan_ck1'];
		$nota_pembelian_pasangan_val = $_POST['nota_pembelian_pasangan_val'];	
		$nota_penjualan_wrs_pasangan_ck = $_POST['nota_penjualan_wrs_pasangan_ck1'];
		$nota_penjualan_pasangan_val = $_POST['nota_penjualan_pasangan_val'];	
		$spt_wrs_pasangan_ck = $_POST['spt_wrs_pasangan_ck1'];
		$spt_wrs_pasangan_val = $_POST['spt_wrs_pasangan_val'];
		$nota_lampiran_pasangan = $_POST['nota_lampiran_pasangan'];
		$nota_periode_pasangan = $_POST['nota_periode_pasangan'];	
		
		$wrs_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasWrsPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		$tot_nota_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_nota_pendapatan_wrs_pasangan']);
		$margin_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['margin_pendapatan_wrs_pasangan']);
		$tot_pendapatan_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tot_pendapatan_wrs_pasangan']);
		$biaya_opr_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['biaya_opr_wrs_pasangan']);
		$net_wrs_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['net_wrs_pasangan']);
		
		$wrs_pasangan_bank_penerbit = $_POST['wrs_pasangan_bank_penerbit'];
		$wrs_pasangan_norek = $_POST['wrs_pasangan_norek'];
		$wrs_pasangan_rekening = $_POST['wrs_pasangan_rekening'];
		$wrs_pasangan_mutasi = $_POST['wrs_pasangan_mutasi'];
		$validasi_wrs_pasangan = $_POST['validasi_wrs_pasangan'];
		if($wrs_pasangan_pendapatan == ''){
			$wrs_pasangan_pendapatan  = 0;
		}
		$val_tf_pasangan = 	$_POST['validasi_wrs_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan1']);

	$callInsWrsPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($rek_tabungan_pasangan_wrs_ck, SQLSRV_PARAM_IN),
					array($rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($nota_pembelian_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($nota_pembelian_pasangan_val, SQLSRV_PARAM_IN),
					array($nota_penjualan_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($nota_penjualan_pasangan_val, SQLSRV_PARAM_IN),
					array($spt_wrs_pasangan_ck, SQLSRV_PARAM_IN),
					array($spt_wrs_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsWrsPasD = sqlsrv_query( $conn, $callInsWrsPasD, $paramInsWrsPasD)  or die( print_r( sqlsrv_defaults(), true));
//	or die( print_r( sqlsrv_defaults(), true)); 		
	 //or die( print_r( sqlsrv_defaults(), true));
		if($nota_lampiran_pasangan == NULL){
			$nota_lampiran_pasangan = '';
			$nota_periode_pasangan = '';
			$tot_nota_pendapatan_wrs_pasangan = 0;
			$margin_pendapatan_wrs_pasangan=0;
			$tot_pendapatan_wrs_pasangan = 0;
			$biaya_opr_wrs_pasangan = 0;
			$net_wrs_pasangan = 0;
		}
	$callInsWrsPasH = "{call SP_RAK_INSERT_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nota_lampiran_pasangan, SQLSRV_PARAM_IN),
					array($nota_periode_pasangan, SQLSRV_PARAM_IN),
					array($tot_nota_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($margin_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($tot_pendapatan_wrs_pasangan, SQLSRV_PARAM_IN),
					array($biaya_opr_wrs_pasangan, SQLSRV_PARAM_IN),
					array($net_wrs_pasangan, SQLSRV_PARAM_IN),
					array($wrs_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($wrs_pasangan_norek, SQLSRV_PARAM_IN),
					array($wrs_pasangan_rekening, SQLSRV_PARAM_IN),
					array($wrs_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($wrs_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_wrs_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	//echo '<pre>' . var_export($paramInsWrsPasH, true) . '</pre>';
	//var_dump($paramInsWrsPasH);
	//exit();
	$exec1InsWrsPasH = sqlsrv_query( $conn, $callInsWrsPasH, $paramInsWrsPasH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
		
		
	}
	
	if($cust_model_pemohon == "PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
		$output7 = "null";
		$pro_bukti_penghasilan_pemohon_ck = $_POST['pro_bukti_penghasilan_pemohon_ck1'];
		$pro_bukti_penghasilan_pemohon_val = $_POST['pro_bukti_penghasilan_pemohon_val'];
		$pro_rek_tabungan_pemohon_ck = $_POST['pro_rek_tabungan_pemohon_ck1'];
		$pro_rek_tabungan_pemohon_val = $_POST['pro_rek_tabungan_pemohon_val'];	
		$pro_spt_pemohon_ck = $_POST['pro_spt_pemohon_ck'];
		$pro_spt_pemohon_val = $_POST['pro_spt_pemohon_val'];	
		
		$pro_pemohon_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasPro['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		
		if($pro_pemohon_pendapatan == ''){
			$pro_pemohon_pendapatan  = 0;
		}
		$pro_pemohon_bank_penerbit = $_POST['pro_pemohon_bank_penerbit'];
		$pro_pemohon_norek = $_POST['pro_pemohon_norek'];
		$pro_pemohon_rekening = $_POST['pro_pemohon_rekening'];
		$pro_pemohon_mutasi = $_POST['pro_pemohon_mutasi'];
		$validasi_pro_pemohon = $_POST['validasi_pro_pemohon'];
		$val_tf = $_POST['validasi_pro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
			
		
	$callInsProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($pro_spt_pemohon_ck, SQLSRV_PARAM_IN),
					array($pro_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPemD = sqlsrv_query( $conn, $callInsProPemD, $paramInsProPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsProPemH = "{call SP_RAK_INSERT_KAPASITAS_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($pro_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($pro_pemohon_norek, SQLSRV_PARAM_IN),
					array($pro_pemohon_rekening, SQLSRV_PARAM_IN),
					array($pro_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($pro_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_pro_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPemH = sqlsrv_query( $conn, $callInsProPemH, $paramInsProPemH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "PROFESSIONAL"){
		$output8 = "null";
		$output9 = "null";
		$output10 = "null";
		$output11 = prepareImageDBString($_FILES['img_tf_pro_pasangan']['tmp_name']);
		$output12 = "null";
		$pro_bukti_penghasilan_pasangan_ck = $_POST['pro_bukti_penghasilan_pasangan_ck1'];
		$pro_bukti_penghasilan_pasangan_val = $_POST['pro_bukti_penghasilan_pasangan_val'];
		$pro_rek_tabungan_pasangan_ck = $_POST['pro_rek_tabungan_pasangan_ck1'];
		$pro_rek_tabungan_pasangan_val = $_POST['pro_rek_tabungan_pasangan_val'];	
		$pro_spt_pasangan_ck = $_POST['pro_spt_pasangan_ck1'];
		$pro_spt_pasangan_val = $_POST['pro_spt_pasangan_val'];	
		
		$pro_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasProPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
			if($pro_pasangan_pendapatan == ''){
			$pro_pasangan_pendapatan  = 0;
		}
		
		
		$pro_pasangan_bank_penerbit = $_POST['pro_pasangan_bank_penerbit'];
		$pro_pasangan_norek = $_POST['pro_pasangan_norek'];
		$pro_pasangan_rekening = $_POST['pro_pasangan_rekening'];
		$pro_pasangan_mutasi = $_POST['pro_pasangan_mutasi'];
		$validasi_pro_pasangan = $_POST['validasi_pro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_pro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan2']);
		
			
		
	$callInsProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_bukti_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($pro_spt_pasangan_ck, SQLSRV_PARAM_IN),
					array($pro_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPasD = sqlsrv_query( $conn, $callInsProPasD, $paramInsProPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsProPasH = "{call SP_RAK_INSERT_KAPASITAS_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($pro_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($pro_pasangan_norek, SQLSRV_PARAM_IN),
					array($pro_pasangan_rekening, SQLSRV_PARAM_IN),
					array($pro_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($pro_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_pro_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsProPasH = sqlsrv_query( $conn, $callInsProPasH, $paramInsProPasH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
	}

	
	if($cust_model_pemohon == "NON PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = "null";
		$output7 = prepareImageDBString($_FILES['img_tf_nonpro_pemohon']['tmp_name']);
		$nonpro_bukti_penghasilan_pemohon_ck = $_POST['pro_bukti_penghasilan_pemohon_ck1'];
		$nonpro_bukti_penghasilan_pemohon_val = $_POST['nonpro_bukti_penghasilan_pemohon_val'];
		$nonpro_rek_tabungan_pemohon_ck = $_POST['nonpro_rek_tabungan_pemohon_ck1'];
		$nonpro_rek_tabungan_pemohon_val = $_POST['nonpro_rek_tabungan_pemohon_val'];	
		$nonpro_spt_pemohon_ck = $_POST['nonpro_spt_pemohon_ck1'];
		$nonpro_spt_pemohon_val = $_POST['nonpro_spt_pemohon_val'];	
		
		$nonpro_pemohon_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasNonPro['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		
				if($nonpro_pemohon_pendapatan == ''){
			$nonpro_pemohon_pendapatan  = 0;
		}
		$nonpro_pemohon_bank_penerbit = $_POST['nonpro_pemohon_bank_penerbit'];
		$nonpro_pemohon_norek = $_POST['nonpro_pemohon_norek'];
		$nonpro_pemohon_rekening = $_POST['nonpro_pemohon_rekening'];
		$nonpro_pemohon_mutasi = $_POST['nonpro_pemohon_mutasi'];
		$validasi_nonpro_pemohon = $_POST['validasi_nonpro_pemohon'];
		$val_tf = $_POST['validasi_nonpro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pemohon']);
			
		
	$callInsNonProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pemohon_val, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pemohon_val, SQLSRV_PARAM_IN),
					array($nonpro_spt_pemohon_ck, SQLSRV_PARAM_IN),
					array($nonpro_spt_pemohon_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPemD = sqlsrv_query( $conn, $callInsNonProPemD, $paramInsNonProPemD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsNonProPemH = "{call SP_RAK_INSERT_KAPASITAS_NON_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_bank_penerbit, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_norek, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_rekening, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_mutasi, SQLSRV_PARAM_IN),
					array($nonpro_pemohon_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_nonpro_pemohon, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPemH = sqlsrv_query( $conn, $callInsNonProPemH, $paramInsNonProPemH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
		
		
	}
	if($join_income == "YA" && $cust_model_pasangan == "NON PROFESSIONAL"){
		$output8 = "null";
		$output9 = "null";
		$output10 = "null";
		$output11 = "null";
		$output12 = prepareImageDBString($_FILES['img_tf_nonpro_pasangan']['tmp_name']);
		$nonpro_bukti_penghasilan_pasangan_ck = $_POST['nonpro_bukti_penghasilan_pasangan_ck1'];
		$nonpro_bukti_penghasilan_pasangan_val = $_POST['nonpro_bukti_penghasilan_pasangan_val'];
		$nonpro_rek_tabungan_pasangan_ck = $_POST['nonpro_rek_tabungan_pasangan_ck1'];
		$nonpro_rek_tabungan_pasangan_val = $_POST['nonpro_rek_tabungan_pasangan_val'];	
		$nonpro_spt_pasangan_ck = $_POST['nonpro_spt_pasangan_ck1'];
		$nonpro_spt_pasangan_val = $_POST['nonpro_spt_pasangan_val'];	
	
		$nonpro_pasangan_pendapatan = substr(str_replace(str_split('\\/:*?"<>|,.'), '',$dataKapasitasNonProPasangan['TOTAL_PENDAPATAN_USAHA_MUTASI']),0, -2);
		
				if($nonpro_pasangan_pendapatan == ''){
			$nonpro_pasangan_pendapatan  = 0;
		}
		
		$nonpro_pasangan_bank_penerbit = $_POST['nonpro_pasangan_bank_penerbit'];
		$nonpro_pasangan_norek = $_POST['nonpro_pasangan_norek'];
		$nonpro_pasangan_rekening = $_POST['nonpro_pasangan_rekening'];
		$nonpro_pasangan_mutasi = $_POST['nonpro_pasangan_mutasi'];
		$validasi_nonpro_pasangan = $_POST['validasi_nonpro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_nonpro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['inputan_bm_pasangan3']);
			
		
	$callInsNonProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasD = array(array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_bukti_penghasilan_pasangan_val, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_rek_tabungan_pasangan_val, SQLSRV_PARAM_IN),
					array($nonpro_spt_pasangan_ck, SQLSRV_PARAM_IN),
					array($nonpro_spt_pasangan_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPasD = sqlsrv_query( $conn, $callInsNonProPasD, $paramInsNonProPasD) or die( print_r( sqlsrv_defaults(), true)); 		
	
		
	$callInsNonProPasH = "{call SP_RAK_INSERT_KAPASITAS_NON_PROFESIONAL (?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasH = array(array($prospect, SQLSRV_PARAM_IN),
					array($cust_pasangan, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_bank_penerbit, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_norek, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_rekening, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_mutasi, SQLSRV_PARAM_IN),
					array($nonpro_pasangan_pendapatan, SQLSRV_PARAM_IN),
					array($validasi_nonpro_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1InsNonProPasH = sqlsrv_query( $conn, $callInsNonProPasH, $paramInsNonProPasH) or die( print_r( sqlsrv_defaults(), true)); 		
		
		
	}
	


	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_defaults(), true)); 		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_defaults(), true)); 		


	}
	if($output7 <> "null"){
	$callImg7 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg7 = array(array($prospect, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
					array($output7, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img7 = sqlsrv_query( $conn, $callImg7, $paramImg7) or die( print_r( sqlsrv_defaults(), true)); 		


	}		
	
	if($join_income == "YA"){
		
		if($output8 <> "null"){
		$callImg8 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg8 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
						array($output8, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img8 = sqlsrv_query( $conn, $callImg8, $paramImg8) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		

		
		if($output9 <> "null"){
		$callImg9 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg9 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
						array($output9, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img9 = sqlsrv_query( $conn, $callImg9, $paramImg9) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		
		if($output10 <> "null"){
		$callImg10 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg10 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
						array($output10, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img10 = sqlsrv_query( $conn, $callImg10, $paramImg10) or die( print_r( sqlsrv_defaults(), true)); 		
			

		}	
		
		if($output11 <> "null"){
		$callImg11 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg11 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
						array($output11, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img11 = sqlsrv_query( $conn, $callImg11, $paramImg11) or die( print_r( sqlsrv_defaults(), true)); 		


		}
		if($output12 <> "null"){
		$callImg12 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg12 = array(array($prospect, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
						array($output12, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img12 = sqlsrv_query( $conn, $callImg12, $paramImg12) or die( print_r( sqlsrv_defaults(), true)); 		


		}
	}
	
	if($catatan1 <> "null"){
	$callCatatan1 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan1 = array(array($prospect, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($catatan1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan1 = sqlsrv_query( $conn, $callCatatan1, $paramCatatan1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	
	if($catatan2 <> "null"){
	$callCatatan2 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan2 = array(array($prospect, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($catatan2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan2= sqlsrv_query( $conn, $callCatatan2, $paramCatatan2) or die( print_r( sqlsrv_defaults(), true)); 		
	}	
	
	$queryDomisili = "{call SP_RAK_INSERT_UPDATE_DOMISILI(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterDomisili = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($shm, SQLSRV_PARAM_IN),
					array($shm_val, SQLSRV_PARAM_IN),
					array($akta, SQLSRV_PARAM_IN),
					array($akta_val, SQLSRV_PARAM_IN),
					array($girik, SQLSRV_PARAM_IN),
					array($girik_val, SQLSRV_PARAM_IN),
					array($pbb, SQLSRV_PARAM_IN),
					array($pbb_val, SQLSRV_PARAM_IN),
					array($rek_listrik, SQLSRV_PARAM_IN),
					array($rek_listrik_val, SQLSRV_PARAM_IN),
					array($rek_air, SQLSRV_PARAM_IN),
					array($rek_air_val, SQLSRV_PARAM_IN),
					array($skrd, SQLSRV_PARAM_IN),
					array($skrd_val, SQLSRV_PARAM_IN),
					array($status_rumah_val, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execDomisili = sqlsrv_query( $conn, $queryDomisili, $parameterDomisili) or die( print_r( sqlsrv_defaults(), true)); 
	
	if($join_income == "TIDAK"){
	$val_tf_pasangan = '';
	$pendapatan_pasangan_cf = 0;
	$pendapatan_pasangan_rak  = 0;
	}
	$queryValidasi = "{call SP_RAK_INSERT_UPDATE_VALIDASI(?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterValidasi = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($alamat_domisili_pemohon_val, SQLSRV_PARAM_IN),
					array($alamat_domisili_pemohon_notes, SQLSRV_PARAM_IN),
					array($alamat_domisili_pasangan_val, SQLSRV_PARAM_IN),
					array($alamat_domisili_pasangan_notes, SQLSRV_PARAM_IN),
					array($domisili_val, SQLSRV_PARAM_IN),
					array($catatan_domisili, SQLSRV_PARAM_IN),
					array($hasil_foto_survey_val, SQLSRV_PARAM_IN),
					array($catatan_geotaging, SQLSRV_PARAM_IN),
					array($val_tf, SQLSRV_PARAM_IN),
					array($val_tf_pasangan, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execValidasi = sqlsrv_query( $conn, $queryValidasi, $parameterValidasi) or die( print_r( sqlsrv_defaults(), true)); 
	
		
	
	if($type_kendaraan == '15'){
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_CA_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterInsert = array(
					array($branchid, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($level, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_name, SQLSRV_PARAM_IN),
					array($jenis_kendaraan, SQLSRV_PARAM_IN),
					array($asset_name, SQLSRV_PARAM_IN),
					array($dealer_name, SQLSRV_PARAM_IN),
					array($ph, SQLSRV_PARAM_IN),
					array($otr, SQLSRV_PARAM_IN),
					array($tenor, SQLSRV_PARAM_IN),
					array($amount_tdp, SQLSRV_PARAM_IN),
					array($tdp_persen, SQLSRV_PARAM_IN),
					array($kordinat_geotagging, SQLSRV_PARAM_IN),
					array($join_income, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($note_rak, SQLSRV_PARAM_IN),
					array($analisa, SQLSRV_PARAM_IN),
					array($angsuran_new, SQLSRV_PARAM_IN),
					array($kewajiban_tempatlain, SQLSRV_PARAM_IN),
					array($total_kewajiban, SQLSRV_PARAM_IN),
					array($total_pendapatan, SQLSRV_PARAM_IN),
					array($dsr, SQLSRV_PARAM_IN),
					array($rekomendasi, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($approval, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true)); 
	
	$queryInsRjc = "{call SP_RAK_REJECT_REASON(?,?,?)}"; 
	$parameterInsRjc = array(
					array($prospect, SQLSRV_PARAM_IN),
					array($rjc, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsRjc = sqlsrv_query( $conn, $queryInsRjc, $parameterInsRjc) or die( print_r( sqlsrv_defaults(), true)); 
	}else{
		$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_CA(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterInsert = array(
					array($branchid, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($level, SQLSRV_PARAM_IN),
					array($role_code, SQLSRV_PARAM_IN),
					array($cust_name, SQLSRV_PARAM_IN),
					array($jenis_kendaraan, SQLSRV_PARAM_IN),
					array($asset_name, SQLSRV_PARAM_IN),
					array($dealer_name, SQLSRV_PARAM_IN),
					array($ph, SQLSRV_PARAM_IN),
					array($otr, SQLSRV_PARAM_IN),
					array($tenor, SQLSRV_PARAM_IN),
					array($amount_tdp, SQLSRV_PARAM_IN),
					array($tdp_persen, SQLSRV_PARAM_IN),
					array($kordinat_geotagging, SQLSRV_PARAM_IN),
					array($join_income, SQLSRV_PARAM_IN),
					array($cust_model_pemohon, SQLSRV_PARAM_IN),
					array($cust_model_pasangan, SQLSRV_PARAM_IN),
					array($note_rak, SQLSRV_PARAM_IN),
					array($analisa, SQLSRV_PARAM_IN),
					array($angsuran_new, SQLSRV_PARAM_IN),
					array($kewajiban_tempatlain, SQLSRV_PARAM_IN),
					array($total_kewajiban, SQLSRV_PARAM_IN),
					array($total_pendapatan, SQLSRV_PARAM_IN),
					array($dsr, SQLSRV_PARAM_IN),
					array($rekomendasi, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN),
					array($prospect, SQLSRV_PARAM_IN),
					array($approval, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_defaults(), true)); 
	}
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}


if(isset($_POST['submitReturn'])){
	
	
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$catatan1 = $_POST['catatan_domisili'];
	$catatan2 = $_POST['catatan_geotaging'];
	$nama_pemilik_rumah = $_POST['nama_pemilik_rumah'];
	

	
	
	
	$level = 2;
	$cust_pemohon = "PEMOHON";
	$cust_pasangan = "PASANGAN";
	$role_code = "CA";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['ph']);
	$otr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['otr']);
	$tenor = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tenor']);
	$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
	$tdp_persen = $dataCust['TDP_PERCENT']; 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = '';
	$angsuran_new = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_pendapatan']);
	//$dsr =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['dsr']); 
	$dsr =  $_POST['dsr'];
	$rekomendasi = "TIDAK REKOMENDASI";
	$approval = "REJECT";
	$shm = $_POST['shm_ck1'];
	$shm_val = $_POST['shm_val'];
	$akta = $_POST['akta_jual_beli_ck1'];
	$akta_val = $_POST['akta_jual_beli_val'];
	$girik = $_POST['surat_girik_ck1'];
	$girik_val = $_POST['surat_girik_val'];
	$pbb = $_POST['pbb_ck1'];
	$pbb_val = $_POST['pbb_val'];
	$rek_listrik = $_POST['rek_listrik_ck1'];
	$rek_listrik_val = $_POST['rek_listrik_val'];
	$rek_air = $_POST['rek_air_ck1'];
	$rek_air_val = $_POST['rek_air_val'];
	$skrd = $_POST['skrd_ck1'];
	$skrd_val = $_POST['skrd_val'];
	$status_rumah_val = $_POST['status_rumah_val'];
	$alamat_domisili_pemohon_val = "";
	$alamat_domisili_pemohon_notes =  "";
	$alamat_domisili_pasangan_val =  "";
	$alamat_domisili_pasangan_notes =  "";
	$domisili_val =  $_POST['domisili_val'];
	$catatan_domisili =  $_POST['catatan_domisili'];
	$hasil_foto_survey_val =  $_POST['hasil_foto_survey_val'];
	$catatan_geotaging =  $_POST['catatan_geotaging'];
	$angsuran_berjalan =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_berjalan']);
	
	$dev_usia = $_POST['dev_usia1'];
	$dev_pas_ttd = $_POST['dev_pas_ttd1'];
	$dev_pengkinian = $_POST['dev_pengkinian1'];
	$dev_srv_kantor = $_POST['dev_srv_kantor1'];
	$dev_negative = $_POST['dev_negative1'];

	$queryInsert= "{call SP_RETURN_RAK(?)}"; 
	$parameterInsert = array(
					array($prospect, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_defaults(), true)); 

	if($execInsert){
		echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
	}else{
		echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
}

$callOtherIncomeData = "{call SP_GETSUBDATA_OTHER_INCOME(?)}";
$paramOtherIncomeData =  array(array($prospect, SQLSRV_PARAM_IN));
$execOtherIncomeData = sqlsrv_query($conn, $callOtherIncomeData, $paramOtherIncomeData) or die(print_r(sqlsrv_errors(), true));
$dataOtherIncomeData = sqlsrv_fetch_array($execOtherIncomeData);

?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 


<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />	 

<style>
.img-custom{
	width:100%;
	height:200px;
}

.th-custom{
	text-align:center;
	vertical-align:middle;
	background-color:#035c7a;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
.notice {
  background-color: #dc3545; /* merah */
  color: #ffffff; /* putih */
  border-left: 5px solid #b02a37; /* merah tua sedikit lebih gelap */
  padding: 12px 16px;
  margin: 10px 0;
  border-radius: 6px;
  font-family: sans-serif;
}	
</style>
<!--<form action="" method="post">-->	

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css"  media="screen" />	 
	<div class="row">
		<div class="col-md-12">
				<form enctype="multipart/form-data" name="form_mutasi_kry" id="form_mutasi_kry" action="" method="post">
			<div class="card">
				<div class="content">

		<ul class="nav nav-pills nav-justified">
    <li class="active"><a data-toggle="pill" href="#home">REVIEW RAK</a></li>
	<li><a data-toggle="pill" href="#fleet">FLEET & AO</a></li>
	<li><a data-toggle="pill" href="#phone_verif">PHONE VERIFICATION</a></li>
    <li><a data-toggle="pill" href="#menu1">RAK</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
	<br>
	<div class="table-responsive">
									<table class="table table-bordered">
									<tr>
										<td center  style="background-color:#ff3838;color:#FFF;font-weight:bold;">PENGAJUAN <?php echo $dataCust['PENGAJUAN']; ?> 
										<br>
										KATEGORI ORDER : <?php echo $dataCust['KATEGORI_ORDER']; ?>
										<br>
										STATUS ORDER FLEET : <?php echo $dataCust['FLEET_STATUS']; ?>
									 </td>
									</tr>
								</table>
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Review RAK</td>
									</tr>
									
									
								</table>
								<?php if (!empty($dataGetDeviasi['DEVIASI_USIA']) && trim($dataGetDeviasi['DEVIASI_USIA']) == 'YA'): ?>
                                <table class="table table-bordered" style="margin-top:10px;">
                                    <tr>
                                        <td colspan="2"
                                            style="background-color:#eb8500;color:#FFF;font-weight:bold;text-align:left;">
                                            Keterangan Deviasi Usia :
                                            <?= !empty($dataGetDeviasi['KETERANGAN_USIA']) 
                    ? htmlspecialchars($dataGetDeviasi['KETERANGAN_USIA']) 
                    : '-' ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php endif; ?>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
							

								<tr>
										<td style="width:50%;">Deviasi Batas Usia</td>
											<td style="width:10%;">
											<?php 
												
													$callDevck1 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0001', SQLSRV_PARAM_IN));
													$execDevck1 = sqlsrv_query( $conn, $callDevck1, $paramDevck1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck1=sqlsrv_fetch_array($execDevck1);
													$checkDevck1=sqlsrv_num_rows($execDevck1);
												?>

												<input type="checkbox" name="dev_usia" id="dev_usia" value="D0001" <?php if ($checkDevck1 > 0) {echo 'checked';}?> onclick="myDevCk1()" disabled>
												<input type="hidden" name="dev_usia1" id="dev_usia1"  value="">
											</td>
										
									</tr>
									
									<tr>
										<td style="width:50%;">Deviasi Pasangan Tidak Tanda Tangan (Berada di Luar Daerah / Negeri)</td>
											<td style="width:10%;">
											<?php 
												
													$callDevck2 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0002', SQLSRV_PARAM_IN));
													$execDevck2 = sqlsrv_query( $conn, $callDevck2, $paramDevck2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck2=sqlsrv_fetch_array($execDevck2);
													$checkDevck2=sqlsrv_num_rows($execDevck2);
												?>
												<input type="checkbox" name="dev_pas_ttd" id="dev_pas_ttd" value="D0002" <?php if ($checkDevck2 > 0) {echo 'checked';}?>  onclick="myDevCk2()" disabled>
													<input type="hidden" name="dev_pas_ttd1" id="dev_pas_ttd1"  value="">
											</td>
									
									</tr>

								

									<tr>
										<td style="width:50%;">Deviasi Pengkinian Data (Status Nikah yang tidak tercaratat DUKCAPIL, hanya melampirkan akta/buku nikah secara agama) </td>
											<td style="width:10%;">
											<?php 
												
													$callDevck3 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0003', SQLSRV_PARAM_IN));
													$execDevck3 = sqlsrv_query( $conn, $callDevck3, $paramDevck3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck3=sqlsrv_fetch_array($execDevck3);
													$checkDevck3=sqlsrv_num_rows($execDevck3);
												?>
												<input type="checkbox" name="dev_pengkinian" id="dev_pengkinian" value="D0003" <?php if ($checkDevck3 > 0) {echo 'checked';}?>  onclick="myDevCk3()" disabled>
													<input type="hidden" name="dev_pengkinian1" id="dev_pengkinian1"  value="">
											</td>
									
									</tr>

									
									<tr>
										<td style="width:50%;">Deviasi Tidak Survey Kantor / Hanyak Konfirmasi By Phone (Jarak Cukup Jauh) </td>
											<td style="width:10%;">
											<?php 
												
													$callDevck6 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck6 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0006', SQLSRV_PARAM_IN));
													$execDevck6 = sqlsrv_query( $conn, $callDevck6, $paramDevck6,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck6=sqlsrv_fetch_array($execDevck6);
													$checkDevck6=sqlsrv_num_rows($execDevck6);
												?>
												<input type="checkbox" name="dev_srv_kantor" id="dev_srv_kantor" value="D0006" <?php if ($checkDevck6 > 0) {echo 'checked';}?>  onclick="myDevCk6()" disabled>
													<input type="hidden" name="dev_srv_kantor1" id="dev_srv_kantor1"  value="">
											</td>
									
									</tr>

									<tr>
										<td style="width:50%;">Deviasi Negative List (Pernah di-Reject / Cancel)</td>
											<td style="width:10%;">
											<?php 
												
													$callDevck7 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck7 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0007', SQLSRV_PARAM_IN));
													$execDevck7 = sqlsrv_query( $conn, $callDevck7, $paramDevck7,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck7=sqlsrv_fetch_array($execDevck7);
													$checkDevck7=sqlsrv_num_rows($execDevck7);
												?>
												<input type="checkbox" name="dev_negative" id="dev_negative" value="D0007" <?php if ($checkDevck7 > 0) {echo 'checked';}?>  onclick="myDevCk7()" disabled>
													<input type="hidden" name="dev_negative1" id="dev_negative1"  value="">
											</td>
									
									</tr>
									<tr>
										<td style="width:50%;">Deviasi Matriks Tidak Sesuai Paket Credit</td>
											<td style="width:10%;">
											<?php 
												
													$callDevck8 = "{call GET_RAK_CHECK_DEVIASI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDevck8 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('D0008', SQLSRV_PARAM_IN));
													$execDevck8 = sqlsrv_query( $conn, $callDevck8, $paramDevck8,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDevck8=sqlsrv_fetch_array($execDevck8);
													$checkDevck8=sqlsrv_num_rows($execDevck8);
												?>
												<input type="checkbox" name="dev_matriks" id="dev_matriks" value="D0008" <?php if ($checkDevck8 > 0) {echo 'checked';}?>  onclick="myDevCk8()" disabled>
													<input type="hidden" name="dev_matriks1" id="dev_matriks1"  value="">
											</td>
									
									</tr>
									
									
									
									
									
									
									
								</table>
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Document Deviasi</td>
									</tr>
								</table>
								<?php
								$displayCheck2 = ($checkDevck2 > 0) ? 'block' : 'none';
								$displayCheck3 = ($checkDevck3 > 0) ? 'block' : 'none';
								$displayCheck4 = ($checkDevck4 > 0) ? 'block' : 'none';
								$displayCheck5 = ($checkDevck5 > 0) ? 'block' : 'none';
								$displayCheck6 = ($checkDevck6 > 0) ? 'block' : 'none';
								?>

								<div id="pas_ttd_doc" style="display: <?php echo $displayCheck2; ?>;">
									<table class="table table-bordered">
										<tr>
											<td style="width:500px;">Upload Bukti Validasi Pasangan Tidak Tanda Tangan </td>
											<td colspan="2">
												<?PHP
												$callImgDev1 = "{call SP_RAK_GET_IMAGES_UPLOAD_DEVIASI(?,?,?)}";
												$paramImgDev1 =  array(
													array($prospect, SQLSRV_PARAM_IN),
													array('D0002', SQLSRV_PARAM_IN),
													array(1, SQLSRV_PARAM_IN)
												);
												$execImgDev1 = sqlsrv_query($conn, $callImgDev1, $paramImgDev1) or die(print_r(sqlsrv_errors(), true));
												$dataImgDev1 = sqlsrv_fetch_array($execImgDev1);

												?>
												<?php if ($dataImgDev1 <> NULL) { ?>
													<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1['IMAGES_DEVIASI']); ?>" data-lightbox="property">
														<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1['IMAGES_DEVIASI']); ?>" style="height:300px;width:200px;" class="img-custom">
													</a>
												<?php } else { ?>
													<a href="assets/img/default.jpg" data-lightbox="property">
														<img src="assets/img/default.jpg" width="100%" class="img-custom">
													</a>
												<?php } ?>

											</td>
											<td colspan="2">
												<?PHP
												$callImgDev1a = "{call SP_RAK_GET_IMAGES_UPLOAD_DEVIASI(?,?,?)}";
												$paramImgDev1a =  array(
													array($prospect, SQLSRV_PARAM_IN),
													array('D0002', SQLSRV_PARAM_IN),
													array(2, SQLSRV_PARAM_IN)
												);
												$execImgDev1a = sqlsrv_query($conn, $callImgDev1a, $paramImgDev1a) or die(print_r(sqlsrv_defaults(), true));
												$dataImgDev1a = sqlsrv_fetch_array($execImgDev1a);

												?>
												<?php if ($dataImgDev1a <> NULL) { ?>
													<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1a['IMAGES_DEVIASI']); ?>" data-lightbox="property">
														<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev1a['IMAGES_DEVIASI']); ?>" style="height:300px;width:200px;" class="img-custom">
													</a>
												<?php } else { ?>
													<a href="assets/img/default.jpg" data-lightbox="property">
														<img src="assets/img/default.jpg" width="100%" class="img-custom">
													</a>
												<?php } ?>

											</td>
										</tr>
									</table>
								</div>
								<div id="pengkinian_doc" style="display: <?php echo $displayCheck3; ?>;">
									<table class="table table-bordered">
										<tr>
											<td style="width:500px;">Upload Bukti Pengkinian Data </td>
											<td colspan="2">
												<?PHP
												$callImgDev2 = "{call SP_RAK_GET_IMAGES_UPLOAD_DEVIASI(?,?,?)}";
												$paramImgDev2 =  array(
													array($prospect, SQLSRV_PARAM_IN),
													array('D0003', SQLSRV_PARAM_IN),
													array(1, SQLSRV_PARAM_IN)
												);
												$execImgDev2 = sqlsrv_query($conn, $callImgDev2, $paramImgDev2) or die(print_r(sqlsrv_defaults(), true));
												$dataImgDev2 = sqlsrv_fetch_array($execImgDev2);

												?>
												<?php if ($dataImgDev2 <> NULL) { ?>
													<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev2['IMAGES_DEVIASI']); ?>" data-lightbox="property">
														<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev2['IMAGES_DEVIASI']); ?>" style="height:300px;width:200px;" class="img-custom">
													</a>
												<?php } else { ?>
													<a href="assets/img/default.jpg" data-lightbox="property">
														<img src="assets/img/default.jpg" width="100%" class="img-custom">
													</a>
												<?php } ?>

											</td>
										</tr>
									</table>
								</div>
								
								<div id="srv_kantor_doc" style="display: <?php echo $displayCheck6; ?>;">
									<table class="table table-bordered">
										<tr>
											<td style="width:500px;">Upload Bukti Tidak Survey Kantor</td>
											<td colspan="2">
												<?PHP
												$callImgDev5 = "{call SP_RAK_GET_IMAGES_UPLOAD_DEVIASI(?,?,?)}";
												$paramImgDev5 =  array(
													array($prospect, SQLSRV_PARAM_IN),
													array('D0006', SQLSRV_PARAM_IN),
													array(1, SQLSRV_PARAM_IN)
												);
												$execImgDev5 = sqlsrv_query($conn, $callImgDev5, $paramImgDev5) or die(print_r(sqlsrv_defaults(), true));
												$dataImgDev5 = sqlsrv_fetch_array($execImgDev5);

												?>
												<?php if ($dataImgDev5 <> NULL) { ?>
													<a href="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev5['IMAGES_DEVIASI']); ?>" data-lightbox="property">
														<img src="data:image/jpeg;base64,<?php echo base64_encode($dataImgDev5['IMAGES_DEVIASI']); ?>" style="height:300px;width:200px;" class="img-custom">
													</a>
												<?php } else { ?>
													<a href="assets/img/default.jpg" data-lightbox="property">
														<img src="assets/img/default.jpg" width="100%" class="img-custom">
													</a>
												<?php } ?>

											</td>
										</tr>
									</table>
								
										</div>	
							
							</div>								
					
    </div>
	 <div id="fleet" class="tab-pane fade">
                            <!-- # *************************************** FLEET ORDER DETAIL *************************************** # -->
                            
                            <?php
                                
                                require('view-rak-individu-fleet-ao.php'); 
                            ?>

                            <!-- # *************************************** end of FLEET ORDER DETAIL *************************************** # -->
                        </div>
	<div id="phone_verif" class="tab-pane fade">
                            <!-- # *************************************** PHONE VERIF  *************************************** # -->
								<div id="phone-verif-container" class="p-2"
									data-orderno="<?= isset($prospect) ? htmlspecialchars($prospect) : '' ?>"
									>
									Loading phone verification... 
								</div>
                            <!-- # *************************************** end of PHONE VERIF*************************************** # -->
                        </div>
	
	<script>
	$(function () {
		$('a[href="#phone_verif"]').one('shown.bs.tab', function () {
			const container = $('#phone-verif-container');
			container
				.html('<div class="text-muted">Loading phone verification...</div>')
				.load('view-only-phone-verification.php', {
					orderno: container.data('orderno')
				});
		});
	});
	</script>
	<script>
	document.addEventListener('DOMContentLoaded', function () {

		var tabRak = document.getElementById('tab-rak');
		if (!tabRak) return;
		tabRak.addEventListener('click', function () {

			var orderNoInput = document.querySelector('input[name="order_no"]');
			if (!orderNoInput || !orderNoInput.value) return;

			fetch('check_phone_verif_exist.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'order_no=' + encodeURIComponent(orderNoInput.value)
			})
			.then(function (r) { return r.json(); })
			.then(function (res) {

				document.getElementById('done_phone_verif').value = res.exist ? 1 : 0;

			})
			.catch(function () {});
		});

	});
	</script>

    <div id="menu1" class="tab-pane fade">
      <br>
					<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
								<table class="table table-bordered">
								<tr>
										<td center  style="background-color:#ff3838;color:#FFF;font-weight:bold;">PENGAJUAN <?php echo $dataCust['PENGAJUAN']; ?> 
										<br>
										KATEGORI ORDER : <?php echo $dataCust['KATEGORI_ORDER']; ?> 
										<br>
										STATUS ORDER FLEET : <?php echo $dataCust['FLEET_STATUS']; ?>
									</td>
									</tr>
									
									
								</table>
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">MENU VALIDASI DAN ANALISA CREDIT ANALYST</td>
									</tr>
									
									
								</table>
							</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
								
						
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">VALIDASI DAN ANALISA CREDIT</td>
									</tr>
									
									<tr>
										<td >ORDER NO </td>
										<td >
											<input type="text" name="app_no" id="app_no"  value="<?php echo $prospect;?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Customer Name </td>
										<td >
											<input type="text" name="cust_name" id="cust_name"  value="<?php echo $dataCust['CUST_NAME']; ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Jenis Kendaraan </td>
										<td >
											<input type="text" name="jenis_kendaraan" id="jenis_kendaraan"  value="<?php echo $dataCust['SCHEME_ID']; ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Asset Name</td>
										<td >
											<input type="text" name="asset_name" id="asset_name"  value="<?php echo $dataCust['PRODUCT_ID']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Nama Dealer</td>
										<td >
											<input type="text" name="dealer_name" id="dealer_name"  value="<?php echo $dataCust['DEALER_NAME']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Pengajuan</td>
										<td >
											<input type="text" name="pengajuan" id="pengajuan"  value="<?php echo $dataCust['PENGAJUAN']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Tahun Kendaraan </td>
										<td >
											<input type="text" name="tahun_kendaraan" id="tahun_kendaraan"  value="<?php echo $dataCust['TAHUN_KENDARAAN']; ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
								</table>
								<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Kontrak Confins</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tgl Go Live</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									
									$callExists= "{call SP_RAK_GET_KONTRAK_EXISTS(?,?)}";
									$paramExists =  array(array($prospect, SQLSRV_PARAM_IN),
														  array($ktp_pemohon, SQLSRV_PARAM_IN));
									$execExists = sqlsrv_query( $conn, $callExists, $paramExists) or die( print_r( sqlsrv_defaults(), true)); 
								
									
									while($rowExists = sqlsrv_fetch_array($execExists)){
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $rowExists['AGRMNT_NO']; ?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowExists['GO_LIVE_DT']<>NULL){echo $rowExists['GO_LIVE_DT']->format('Y-m-d');}else{echo"-";} ?></td>
										
									</tr>
									<?php } ?>
								</tbody>
							</table>
							</div>
				 	</div>
							<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">VALIDASI DAN ANALISA CREDIT</td>
									</tr>
									<tr>
										<td >PH Berjalan </td>
										<td >
											<input type="text" name="ph" id="ph"  value="<?php echo number_format($dataCust['PH_AKUMULASI'],0,',','.');?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >PH AO </td>
										<td >
											<input type="text" name="ph_ao" id="ph_ao"  value="<?php echo number_format($dataCust['PH_AO_AKUMULASI'],0,',','.');?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >PH Akumulasi </td>
										<td >
											<input type="text" name="ph_total" id="ph_total"  value="<?php echo number_format($dataCust['PH_SELURUH'],0,',','.');?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >OTR </td>
										<td >
											<input type="text" name="otr" id="otr"  value="<?php echo number_format($dataCust['OTR'],0,',','.');?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >TENOR </td>
										<td >
											<input type="text" name="tenor" id="tenor"  value="<?php  echo number_format($dataCust['TENOR'],0,',','.'); ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Amount TDP</td>
										<td >
											<input type="text" name="amount_tdp" id="amount_tdp"  value="<?php echo number_format($dataCust['TDP'],0,',','.');?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >% TDP</td>
										<td >
											<input type="text" name="tdp_persen" id="tdp_persen"  value="<?php echo $dataCust['TDP_PERCENT']; ?>"%  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
								</table>
							</div>
				 	</div>
							<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI IDENTITAS</td>
									</tr>
									
									
								</table>
							</div>
							
							
						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PEMOHON </td>
									</tr>
								
									<tr>
										<td style="width:20%;">NIK E-KTP</td>
										<td style="width:30%;">
											<input type="text" name="nik_pemohon" class="form-control"  value="<?php echo $dataInfo['ID_NO'];?>"  id="nik_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Nama </td>
										<td style="width:30%;">
											<input type="text" name="nama_pemohon" class="form-control" value="<?php echo $dataInfo['CUST_NAME'];?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Tempat </td>
										<td style="width:30%;">
											<input type="text" name="tempat_pemohon" class="form-control" value="<?php echo $dataInfo['BIRTH_PLACE'];?>"  id="ttl_pemohon" readonly>
										<?php if ($dataInfo['WILAYAH_RED_PEMOHON'] == 'RED') {
																	echo '<small style="color:red;">*Red Population</small>';
																} ?>
										</td>
									</tr>
									<tr>
										<td style="width:20%;">Tanggal Lahir </td>
										<td style="width:30%;">
											<input type="text" name="tanggal_pemohon" class="form-control" value="<?php echo $dataInfo['BIRTH_DT'];?>"  id="ttl_pemohon" readonly>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Jenis Kelamin</td>
										<td style="width:30%;">
											<input type="text" name="jk_pemohon" class="form-control" value="<?php echo $dataInfo['JENIS_KELAMIN'];?>"  id="od" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Status Perkawinan</td>
										<td style="width:30%;">
											<input type="text" name="status_kawin_pemohon" class="form-control" value="<?php echo $dataInfo['STATUS_KAWIN'];?>"  id="status_kawin_pemohon" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:20%;">Nama Ibu Kandung</td>
										<td style="width:30%;">
											<input type="text" name="nama_ibu_kandung_pemohon" class="form-control" value="<?php echo $dataInfo['MOTHER_MAIDEN_NAME'];?>"  id="nama_ibu_kandung_pemohon" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Pendidikan Terakhir</td>
										<td style="width:30%;">
											<input type="text" name="pendidikan_terakhir" class="form-control" value="<?php echo $dataCust['PENDIDIKAN_TERAKHIR']; ?>" id="nama_ibu_kandung_pemohon" readonly>
										</td>

									</tr>
									
									<tr>
										<td style="width:20%;">Jumlah Tanggungan</td>
										<td style="width:30%;">
											<input type="text" name="jumlah_tanggungan" class="form-control" value="<?php echo $dataCust['JUMLAH_TANGGUNGAN']; ?>" id="nama_ibu_kandung_pemohon" readonly>
										</td>

									</tr>
									
									
									<tr>
										<td style="width:20%;">Alamat Sesuai E-KTP</td>
										<td style="width:30%;">
											<textarea type="textarea" name="alamat_ktp_pemohon" class="form-control" value="<?php echo $dataInfo['ALAMAT_KTP'];?>"  id="alamat_ktp_pemohon" readonly> <?php echo $dataInfo['ALAMAT_KTP'];?></textarea>
										</td>
										
											
										
									</tr>
									
									<tr>
										<td style="width:20%;">Alamat Domisili</td>
										<td style="width:30%;">
											<textarea type="text" name="alamat_domisili_pemohon" class="form-control" value="<?php echo $dataInfo['ALAMAT_DOMISILI'];?>"  id="alamat_domisili_pemohon" readonly><?php echo $dataInfo['ALAMAT_DOMISILI'];?> </textarea>
										</td>
									
									</tr>
									
								</table>
							</div>								
						</div>
		
						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;"><?php echo $siapanih; ?> </td>
									</tr>
								
									<tr>
										<td style="width:20%;">NIK E-KTP</td>
										<td style="width:30%;">
											<input type="text" name="nik_pasangan" class="form-control"  value="<?php echo $ktpsaya; ?>"  id="nik_pasangan" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Nama </td>
										<td style="width:30%;">
											<input type="text" name="nama_pasangan" class="form-control" value="<?php echo $namasaya; ?>"  id="nama_pasangan" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Tempat </td>
										<td style="width:30%;">
											<input type="text" name="tempat_pasangan" class="form-control" value="<?php echo $tempatlahirsaya;?>"  id="ttl_pasangan" readonly>
										<?php if ($dataInfo['WILAYAH_RED_PASANGAN'] == 'RED') {
																	echo '<small style="color:red;">*Red Population</small>';
																} ?>
										</td>
									</tr>
									<tr>
										<td style="width:20%;">Tanggal Lahir </td>
										<td style="width:30%;">
											<input type="text" name="tanggal_pasangan" class="form-control" value="<?php echo $tgllahirsaya;?>"  id="ttl_pasangan" readonly>
										
									</tr>
									
									
									<tr>
										<td style="width:20%;">Jenis Kelamin</td>
										<td style="width:30%;">
											<input type="text" name="jk_pasangan" class="form-control" value="<?php echo $jksaya;?>"  id="jk_pasangan" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Status Perkawinan</td>
										<td style="width:30%;">
											<input type="text" name="status_kawin_pasangan" class="form-control" value="<?php echo $statuskawinsaya;?>"  id="status_kawin_pasangan" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:20%;">Nama Ibu Kandung</td>
										<td style="width:30%;">
											<input type="text" name="nama_ibu_kandung_pasangan" class="form-control" value="<?php echo $namaibusaya;?>"  id="nama_ibu_kandung_pasangan" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Alamat Sesuai E-KTP</td>
										<td style="width:30%;">
											<textarea type="text" name="alamat_ktp_pasangan" class="form-control" value="<?php echo $alamat_ktpsaya;?>"  id="alamat_ktp_pasangan" readonly><?php echo $alamat_ktpsaya;?> </textarea>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Alamat Domisili</td>
										<td style="width:30%;">
											<textarea type="text" name="alamat_domisili_pasangan" class="form-control" value="<?php echo $alamat_domisilisaya;?>"  id="alamat_domisili_pasangan" readonly><?php echo $alamat_domisilisaya;?></textarea>
										</td>
										
									</tr>
									
								</table>
							</div>								
						</div>
						
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30px"><p><input type="checkbox" name="check_identitas" required oninvalid="this.setCustomValidity('Wajib Centang')"
	 								oninput="setCustomValidity('')">	
										</td>
										<td>
											<b>Pastikan semua Document Identitas Telah Terpenuhi, dan Valid sesuai Regulasi Yang berlaku<b>

											
										</td>
									</tr>
									
									
								</table>
							</div>
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Validasi  Domisili Pilih Salah Satu Sesuai Document yang di Lampirkan</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
							
						
									
									<tr>
										<td style="width:50%;">SHM</td>
											<td style="width:10%;">
												<?php 
												
													$callDomisili1 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('SHM', SQLSRV_PARAM_IN));
													$execDomisili1 = sqlsrv_query( $conn, $callDomisili1, $paramDomisili1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili1=sqlsrv_fetch_array($execDomisili1);
													$checkDomisili1=sqlsrv_num_rows($execDomisili1);
												
												?>
											
											
												<input type="checkbox" name="shm_ck" id="shm_ck" value="SHM" <?php if ($checkDomisili1 > 0) {echo 'checked';}?>  onclick="myFunctionCk1()">
												<input type="hidden" name="shm_ck1" id="shm_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="shm_val" class="form-control" >
														<option value="VALID" <?php if ($dataDomisili1['VALIDASI_DOKUMEN'] == "VALID" ) {echo 'selected';}?>>VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili1['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Akta Jual Beli</td>
											<td style="width:10%;">
											<?php 
												
													$callDomisili2 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('AKTA JUAL BELI', SQLSRV_PARAM_IN));
													$execDomisili2 = sqlsrv_query( $conn, $callDomisili2, $paramDomisili2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili2=sqlsrv_fetch_array($execDomisili2);
													$checkDomisili2=sqlsrv_num_rows($execDomisili2);
												?>
											
												<input type="checkbox" name="akta_jual_beli_ck" id="akta_jual_beli_ck" value="AKTA JUAL BELI"  <?php if ($checkDomisili2 > 0) {echo 'checked';}?> onclick="myFunctionCk2()">
													<input type="hidden" name="akta_jual_beli_ck1" id="akta_jual_beli_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="akta_jual_beli_val" class="form-control" >
														<option value="VALID" >VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili1['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Girik</td>
											<td style="width:10%;">
											<?php 
												
													$callDomisili3 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('SURAT GIRIK', SQLSRV_PARAM_IN));
													$execDomisili3 = sqlsrv_query( $conn, $callDomisili3, $paramDomisili3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili3=sqlsrv_fetch_array($execDomisili3);
													$checkDomisili3=sqlsrv_num_rows($execDomisili3);
												?>
												<input type="checkbox" name="surat_girik_ck" id="surat_girik_ck" value="SURAT GIRIK"  <?php if ($checkDomisili3 > 0) {echo 'checked';}?> onclick="myFunctionCk3()">
												<input type="hidden" name="surat_girik_ck1" id="surat_girik_ck1"  value="SURAT GIRIK">
											</td>
										<td style="width:50%;">
											<select name="surat_girik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili1['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">PBB</td>
											<td style="width:10%;">
												<?php 
													$callDomisili4 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili4 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PBB', SQLSRV_PARAM_IN));
													$execDomisili4 = sqlsrv_query( $conn, $callDomisili4, $paramDomisili4,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili4=sqlsrv_fetch_array($execDomisili4);
													$checkDomisili4=sqlsrv_num_rows($execDomisili4);
														
												?>
												
												<input type="checkbox" name="pbb_ck" id="pbb_ck" value="PBB"  <?php if ($checkDomisili4 > 0) {echo 'checked';}?> onclick="myFunctionCk4()">
												<input type="hidden" name="pbb_ck1" id="pbb_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="pbb_val" class="form-control" >
														<option value="VALID" >VALID </option>
														<option value="TIDAK VALID"  <?php if ($dataDomisili4['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Rek Listrik</td>
											<td style="width:10%;">
											<?php 
													$callDomisili5 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili5 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('REK LISTRIK', SQLSRV_PARAM_IN));
													$execDomisili5 = sqlsrv_query( $conn, $callDomisili5, $paramDomisili5,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili5=sqlsrv_fetch_array($execDomisili5);
													$checkDomisili5=sqlsrv_num_rows($execDomisili5);
												?>
												<input type="checkbox" name="rek_listrik_ck" id="rek_listrik_ck"  <?php if ($checkDomisili5 > 0) {echo 'checked';}?> value="REK LISTRIK" onclick="myFunctionCk5()">
												<input type="hidden" name="rek_listrik_ck1" id="rek_listrik_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_listrik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili5['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">REK AIR</td>
											<td style="width:10%;">
											<?php 
													$callDomisili6 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili6 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('REK LISTRIK', SQLSRV_PARAM_IN));
													$execDomisili6 = sqlsrv_query( $conn, $callDomisili6, $paramDomisili6,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili6=sqlsrv_fetch_array($execDomisili6);
													$checkDomisili6=sqlsrv_num_rows($execDomisili6);
												?>
												<input type="checkbox" name="rek_air_ck" id="rek_air_ck" value="REK AIR"  <?php if ($checkDomisili6 > 0) {echo 'checked';}?> onclick="myFunctionCk6()">
												<input type="hidden" name="rek_air_ck1" id="rek_air_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_air_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili6['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Keputusan Rumah Dinas (Jika Menempati Rumah)</td>
											<td style="width:10%;">
											<?php 
													$callDomisili7 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili7 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('SURAT KEPUTUSAN RUMAH DINAS', SQLSRV_PARAM_IN));
													$execDomisili7 = sqlsrv_query( $conn, $callDomisili7, $paramDomisili7,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili7=sqlsrv_fetch_array($execDomisili7);
													$checkDomisili7=sqlsrv_num_rows($execDomisili7);
												?>
												
												<input type="checkbox" name="skrd_ck" id="skrd_ck" value="SURAT KEPUTUSAN RUMAH DINAS" <?php if ($checkDomisili7 > 0) {echo 'checked';}?>  onclick="myFunctionCk7()">
												<input type="hidden" name="skrd_ck1" id="skrd_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="skrd_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataDomisili7['VALIDASI_DOKUMEN'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									<tr>
										<td style="width:50%;">STATUS RUMAH</td>
										<td style="width:50%;" colspan="2">
										<?php 
													$callDomisili8 = "{call GET_RAK_CHECK_DOMISILI(?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramDomisili8 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('STATUS_RUMAH', SQLSRV_PARAM_IN));
													$execDomisili8 = sqlsrv_query( $conn, $callDomisili8, $paramDomisili8,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataDomisili8=sqlsrv_fetch_array($execDomisili8);
													$checkDomisili8=sqlsrv_num_rows($execDomisili8);
												?>
												
											<select name="status_rumah_val" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="COMPANY" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "COMPANY" ) {echo 'selected';}?> >COMPANY</option>
														<option value="FAMILY" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "FAMILY" ) {echo 'selected';}?> >FAMILY HOUSE</option>
														<option value="MORTGAGE" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "MORTGAGE" ) {echo 'selected';}?>>MORTGAGE</option>
														<option value="RENT" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "RENT" ) {echo 'selected';}?>>RENT</option>
														<option value="SELF" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "SELF" ) {echo 'selected';}?>>SELF OWNED</option>
														<option value="SPOUSE" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "SPOUSE" ) {echo 'selected';}?>>SPOUSE OWNED</option>
											</select>   
										</td>
									</tr>
									
									
									
									
									
								</table>
							</div>								
						</div>
							<div class="col-md-6 col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered">
								
						

									<tr>
										<td style="width:30%;">CARA VALIDASI</td>
										<td colspan= "2">
											<select name="domisili_val" class="form-control" >
														<option value="Cek Ke BPN" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Cek Ke BPN" ) {echo 'selected';}?> >Cek Ke BPN</option>		
														<option value="Cek Notaris Penerbit" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Cek Notaris Penerbit" ) {echo 'selected';}?>  >Cek Notaris Penerbit</option>
														<option value="Cek by Virtual" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Cek by Virtual" ) {echo 'selected';}?>  >Cek by Virtual</option>
														<option value="Cek by Online" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Cek by Online" ) {echo 'selected';}?> >Cek by Online</option>
														<option value="Cek by Dispenda" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Cek by Dispenda" ) {echo 'selected';}?> >Cek by Dispenda</option>
														<option value="PV" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "PV" ) {echo 'selected';}?>  >PV</option>
														<option value="Kunjungan ke kantor" <?php if ($dataGetVal['VALIDASI_DOKUMEN_DOMISILI'] == "Kunjungan ke kantor" ) {echo 'selected';}?> >Kunjungan ke kantor</option>		
											</select>   
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NOTES SBH</td>
										<td colspan="2">
													<textarea name="catatan_domisili_ca" id="catatan_domisili_ca" readonly value="<?php echo $dataCatatanDomisili['NOTES']; ?>" class="form-control"><?php echo $dataCatatanDomisili['NOTES']; ?></textarea>
													
										</td>
									</tr>
									<tr>
												<td >Validasi Domisili SBH </td>
													<td colspan="2" >
														<?php if($imgDomisiliCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									
									<tr>
										<td style="width:30%;">NOTES</td>
										<td colspan="2">
													<textarea name="catatan_domisili" id="catatan_domisili" value="<?php echo $dataCatatanDomisili['NOTES']; ?>" class="form-control"> </textarea>
													
										</td>
									</tr>
									
										
									<tr>
												<td >Upload Bukti Validasi Domisili Jika Ada Revisi</td>
													<td colspan="2" >
														<input type="file" name="img_domisili"  style="margin-bottom:5px;" />

													</td>
									</tr>
									
									
									
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12"></div>
						<div class="col-md-6 col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">NAMA PEMIILIK RUMAH</td>
										<td colspan= "2">
											<input type="text" name="nama_pemilik_rumah" class="form-control" value="<?php echo $dataCatatanPemilikRmh['NOTES']; ?>"  id="nama_pemilik_rumah" readonly>
										</td>
									
									</tr>
								
									
									
									<tr>
												<td >BUKTI PENDUKUNG</td>
													<td colspan="2" >
														<?php if($imgRumahCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgRumahCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgRumahCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									
									
								</table>
							</div>								
						</div>
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Validasi Hasil Survey</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-7 col-sm-12">
							<div class="table-responsive">
								<input type="hidden" name="kordinat_geotagging" id="kordinat_geotagging"  value="<?php echo $dataTagging['LATITUDE']; ?>,<?php echo $dataTagging['LONGITUDE']; ?>">
								<table class="table table-bordered">

						
									<tr>
										<td style="width:30%;">Cek Titik Kordinat Geotaging</td>
										<td style="width:50%;">
												<?php echo $dataTagging['LATITUDE']; ?>,<?php echo $dataTagging['LONGITUDE']; ?>
										</td>
										<td style="width:50%;">
												Geotaging diambil dari Mobile Survey
										</td>
									</tr>
									
									<tr>
										<td style="width:30%;">Pencarian Google Maps</td>
										<td colspan= "2">
											<a class="btn btn-success btn-xs" style="width:100%;"href="https://www.google.com/maps/search/?api=1&query=<?php echo $dataTagging['LATITUDE']; ?>,<?php echo $dataTagging['LONGITUDE']; ?>" target="_blank"
											>Link Google Maps</a>
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">HASIL FOTO SURVEY VS HASIL GEOTAGING ALAMAT APAKAH SESUAI?</td>
										<td colspan="2">
											<select name="hasil_foto_survey_val" class="form-control" required>
														<option value="SESUAI" <?php if ($dataGetVal['VALIDASI_ALAMAT_GEOTAGING'] == "SESUAI" ) {echo 'selected';}?> >SESUAI</option>
														<option value="TIDAK SESUAI" <?php if ($dataGetVal['VALIDASI_ALAMAT_GEOTAGING'] == "TIDAK SESUAI" ) {echo 'selected';}?>>TIDAK SESUAI</option>
													
											</select> 
													
										</td>
									</tr>
									<?php 
										
										$callAdeb = "{call SP_GET_RAK_AUTO_DEBET_INFO_NO_PDF(?)}";
										$paramAdeb =  array(array($prospect, SQLSRV_PARAM_IN));
										$execAdeb = sqlsrv_query( $conn, $callAdeb, $paramAdeb) or die( print_r( sqlsrv_defaults(), true)); 
										$dataAdeb = sqlsrv_fetch_array($execAdeb);

									?>
									<tr>
										<td style="width:30%;">Auto Debet</td>
										<td colspan="2">
													<input name="autodebet" id="autodebet" readonly value="<?php echo $dataAdeb['AUTO_DEBET']; ?>" class="form-control"></input>
													
										</td>
									</tr>
									<tr>
									<td >Dokumen AUTO DEBET</td>
													<td colspan="2" >
													<?php if($dataAdeb['AUTO_DEBET'] == ''){ ?>
														<input name="db" id="db" value="NONE" readonly class="form-control"></input>
													
													<?php }else{ ?>
													<a href="autodebet_dl.php?prospect=<?php echo urlencode($prospect); ?>" class="btn btn-primary">Download PDF</a>
													
													<?php } ?>
													</td>
									</tr>
									<tr>
										<td style="width:30%;">NOTES SBH</td>
										<td colspan="2">
													<textarea name="catatan_geotaging_ca" id="catatan_geotaging_ca" readonly value="<?php echo $dataCatatanGeotaging['NOTES']; ?>" class="form-control"><?php echo $dataCatatanGeotaging['NOTES']; ?> </textarea>
													
										</td>
									</tr>
									<tr>
									<td >Validasi Geotagging SBH </td>
													<td colspan="2" >
														<?php if($ImgGeotagingCA<> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgGeotagingCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgGeotagingCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
										<tr>
										<td style="width:30%;">NOTES</td>
										<td colspan="2">
													<textarea name="catatan_geotaging" id="catatan_geotaging" value="" class="form-control"> </textarea>
													
										</td>
									</tr>
									
										
									<tr>
												<td >Upload Bukti Validasi Geotaging</td>
													<td colspan="2" >
														<input type="file" name="img_geotaging"  style="margin-bottom:5px;" />

													</td>
									</tr>
								
									
									
									
									
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					
					</div>
						<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30px"><p><input type="checkbox" name="check_geotagging" required oninvalid="this.setCustomValidity('Wajib Centang')"
	 								oninput="setCustomValidity('')">	
										</td>
										<td>
											<b>Pastikan semua Document Identitas Telah Terpenuhi, dan Valid sesuai Regulasi Yang berlaku<b>

											
										</td>
									</tr>
									
									
								</table>
							</div>
					
					
						
							<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI KAPASITAS</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="3" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PEMOHON </td>
									</tr>
								
									<tr>
										<td style="width:30%;">Customer Model</td>
										<td colspan="2">
										<input type="text" name="cust_model_pemohon" class="form-control" value="<?php	echo $dataInfo['CUST_MODEL']; ?>" 
										id="cust_model_pemohon" readonly>
									
										</td>
									
									</tr>
									
										
											
										
								
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">Join Income ?
										<td>
											<select name="join_income1" id="join_income1" class="form-control" disabled >
													<option value="">--- Pilih ---</option>
														<option value="YA" <?php if ($dataAnalis['JOIN_INCOME'] == "YA" ) {echo 'selected';}?>>YA</option>
														<?php if($siapanih <> 'PENJAMIN'){ ?>
																<option value="TIDAK" <?php if ($dataAnalis['JOIN_INCOME'] == "TIDAK" ) {echo 'selected';}?>>TIDAK</option>
														<?php } ?> 
													
													
											</select> 
											<input type="text" name="join_income" id="join_income" value ="<?php echo  $dataAnalis['JOIN_INCOME'];?>" hidden >
										</td>
									
									</tr>
									
										
											
										
								
									
								</table>
							</div>	
							
						</div>
						
					</div>
					</div>
					<?php if ($dataAnalis['JOIN_INCOME'] == "YA") { ?>
					<div id="cust_model_pasangan_div">
					<?php }else{ ?>
						<div id="cust_model_pasangan_div" 	style="display:none;">
					<?php } ?>

						<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="col-md-6 col-sm-6">
						<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="3" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PASANGAN </td>
									</tr>
								
									<tr>
										<td style="width:30%;">Customer Model</td>
										<td colspan="2">
										<input type="text" name="cust_model_pasangan" id="cust_model_pasangan" class="form-control" 
										value="<?php echo $dataInfo['Pasangan_CUST_MODEL'];?>" 
										id="cust_model_pasangan" readonly>
										 <!---$dataInfo['Pasangan_CUST_MODEL'];-->
									
										</td>
									
									</tr>
									
										
											
										
								
									
								</table>
							</div>
						</div>
						</div>
						</div>
						</div>
						<?php /*
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="3" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PASANGAN </td>
									</tr>
								
										<tr>
										<td style="width:30%;">Customer Model</td>
										<td colspan="2">
											<select name="cust_model_pemohon" class="form-control" required>
														<option value="KARYAWAN">KARYAWAN</option>
														<option value="WIRASWASTA">WIRASWASTA</option>
														<option value="PROFESIONAL">PROFESIONAL</option>
											</select>   
										</td>
									
									</tr>
									
								</table>
							</div>								
						</div>
						*/ ?>
						
						
					</div>
					</div>
									<input type="hidden" name="app_no_hide" id="app_no_hide"  value="<?php echo $prospect;?>">
										<input type="hidden" name="nama_pemohon_hide" id="nama_pemohon_hide"  value="<?php echo $dataInfo['CUST_NAME'];?>">
										<input type="hidden" name="user_hide" id="user_hide"  value="<?php echo $user;?>">
										<input type="hidden" name="branchid_hide" id="branchid_hide"  value="<?php echo $branchid;?>">
										<input type="hidden" name="cust_type_pasangan_hide" id="cust_type_pasangan_hide"  value="<?php echo $siapanih;?>">
										<input type="hidden" name="dacor" id="dacor"  value="<?php echo $dataCust['DACOR']; ?>" >
										
					
					<!------------------Karyawan -->
					<?php if($dataInfo['CUST_MODEL'] == 'KARYAWAN'){ ?>
					<div id="kry_pemohon_div">
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">PEMOHON KARYAWAN</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">NAMA PERUSAHAAN TEMPAT BEKERJA</td>
										<td style="width:50%;">
											<input type="text" name="nama_perusahaan_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['NAMA_PERUSAHAAN']; ?>"  id="nama_perusahaan_pemohon" readonly>
										</td>
										<td style="width:50%;">
											 <select name="nama_perusahaan_pemohon_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">JABATAN</td>
										<td style="width:50%;">
											<input type="text" name="jabatan_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['PROFESI']; ?>"  id="jabatan_pemohon" readonly>
										</td>
										<td style="width:50%;">
											 <select name="jabatan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">INDUSTRY TYPE</td>
										<td style="width:50%;">
											<input type="text" name="industry_type_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['INDUSTRY_TYPE']; ?>"  id="industry_type_pemohon" readonly>
										</td>
										<td style="width:50%;">
											 <select name="industry_type_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">LAMA BEKERJA</td>
										<td style="width:50%;">
											<input type="text" name="lama_bekerja_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['LAMA_BEKERJA']; ?> Bulan"  id="lama_bekerja_pemohon" readonly>
										</td>
										<td style="width:50%;">
											 <select name="lama_bekerja_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										
								
									
								</table>
							</div>								
						</div>
					
						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">NO TELPON KANTOR</td>
										<td style="width:50%;">
											<input type="text" name="telp_kantor_pemohon" class="form-control" value="<?php  echo $dataKapasitasKry['NO_TELP_KANTOR']; ?>"  id="telp_kantor_pemohon" readonly>
										</td>
									
									
									</tr>
								
									<tr>
										<td style="width:30%;">STATUS KARYAWAN</td>
										<td style="width:50%;">
											 <select name="status_karyawan_pemohon" id="status_karyawan_pemohon"  class="form-control" readonly>
														<option value="">-Pilih-</option>
														<option value="AKTIF" <?php if ($dataKapasitasKry['STATUS_KARYAWAN'] == "AKTIF" ) {echo 'selected';}?> >AKTIF</option>
														<option value="TIDAK AKTIF" <?php if ($dataKapasitasKry['STATUS_KARYAWAN'] == "TIDAK AKTIF" ) {echo 'selected';}?> >TIDAK AKTIF</option>
														<option value="DALAM PROSES RESIGN" <?php if ($dataKapasitasKry['STATUS_KARYAWAN'] == "DALAM PROSES RESIGN" ) {echo 'selected';}?> >DALAM PROSES RESIGN</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NAMA PIC KANTOR YANG DAPAT DIHUBUNGI</td>
										<td style="width:50%;">
											<input type="text" name="pic_kantor_pemohon" class="form-control" value="<?php  echo $dataKapasitasKry['NAMA_PIC_KANTOR']; ?>"  id="pic_kantor_pemohon" readonly>
										</td>
									
									
									</tr>
									<tr>
										<td style="width:30%;">HASIL VERIFIKASI KANTOR</td>
										<td style="width:50%;">
											<textarea type="input" name="verf_kantor_kry_pemohon"  class="form-control"   id="verf_kantor_kry_pemohon" readonly > <?php  echo $dataKapasitasKry['HASIL_VERIVIKASI']; ?> </textarea>
										</td>
									
									
									</tr>
										
								
									
								</table>
							</div>								
						</div>
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%;">SLIP GAJI</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SLIP GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry1 = sqlsrv_query( $conn, $callKapasitasKry1, $paramKapasitasKry1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry1 = sqlsrv_fetch_array($execKapasitasKry1);
													$checkKapasitasKry1 = sqlsrv_num_rows($execKapasitasKry1);
												?>
											<input type="checkbox" class="aroClass" name="slip_gaji_pemohon_ck" id="slip_gaji_pemohon_ck" value="" <?php if ($checkKapasitasKry1 > 0) {echo 'checked';}?> onclick="FuncKryPemohon1()">
												<input type="hidden" name="slip_gaji_pemohon_ck1" id="slip_gaji_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="slip_gaji_pemohon_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
						
									
									<tr>
										<td style="width:30%;">DAFTAR GAJI</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('DAFTAR GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry2 = sqlsrv_query( $conn, $callKapasitasKry2, $paramKapasitasKry2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry2 = sqlsrv_fetch_array($execKapasitasKry2);
													$checkKapasitasKry2 = sqlsrv_num_rows($execKapasitasKry2);
												?>
											<input type="checkbox" class="aroClass" name="daftar_gaji_pemohon_ck" id="daftar_gaji_pemohon_ck" <?php if ($checkKapasitasKry2 > 0) {echo 'checked';}?> value="DAFTAR GAJI" onclick="FuncKryPemohon2()">
											<input type="hidden" name="daftar_gaji_pemohon_ck1" id="daftar_gaji_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"<?php if ($dataKapasitasKry2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">SURAT KETERANGAN PENGHASILAN</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKry3 = sqlsrv_query( $conn, $callKapasitasKry3, $paramKapasitasKry3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry3 = sqlsrv_fetch_array($execKapasitasKry3);
													$checkKapasitasKry3 = sqlsrv_num_rows($execKapasitasKry3);
												?>
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pemohon_ck" id="surat_ket_penghasilan_pemohon_ck"  <?php if ($checkKapasitasKry3 > 0) {echo 'checked';}?>  value="SURAT KETERANGAN PENGHASILAN" onclick="FuncKryPemohon3()">
											<input type="hidden" name="surat_ket_penghasilan_pemohon_ck1" id="surat_ket_penghasilan_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKry3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">BUKTI SALDO PRINT SCREEN JAMSOSTEK</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry4 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry4 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('BUKTI SALDO PRINT SCREEN JAMSOSTEK', SQLSRV_PARAM_IN));
													$execKapasitasKry4 = sqlsrv_query( $conn, $callKapasitasKry4, $paramKapasitasKry4,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry4 = sqlsrv_fetch_array($execKapasitasKry4);
													$checkKapasitasKry4 = sqlsrv_num_rows($execKapasitasKry4);
												?>
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pemohon_ck" id="bukti_saldo_print_jamsos_pemohon_ck"  <?php if ($checkKapasitasKry4 > 0) {echo 'checked';}?>  value="BUKTI SALDO PRINT SCREEN JAMSOSTEK" onclick="FuncKryPemohon4()"> 
											<input type="hidden" name="bukti_saldo_print_jamsos_pemohon_ck1" id="bukti_saldo_print_jamsos_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID <?php if ($dataKapasitasKry4['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									<tr>
										<td style="width:30%;">BUKTI SPT PAJAK TAHUN TERAKHIR</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry5 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry5 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasKry5 = sqlsrv_query( $conn, $callKapasitasKry5, $paramKapasitasKry5,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry5 = sqlsrv_fetch_array($execKapasitasKry5);
													$checkKapasitasKry5 = sqlsrv_num_rows($execKapasitasKry5);
												?>
											<input type="checkbox" class="aroClass" name="bukti_spt_pemohon_ck" id="bukti_spt_pemohon_ck" <?php if ($checkKapasitasKry5 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR"  onclick="FuncKryPemohon5()">
											<input type="hidden" name="bukti_spt_pemohon_ck1" id="bukti_spt_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry5['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">REKENING TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry6 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry6 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('REKENING TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasKry6 = sqlsrv_query( $conn, $callKapasitasKry6, $paramKapasitasKry6,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry6 = sqlsrv_fetch_array($execKapasitasKry6);
													$checkKapasitasKry6 = sqlsrv_num_rows($execKapasitasKry6);
												?>
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pemohon_ck" id="rekening_tabungan_pemohon_ck"  <?php if ($checkKapasitasKry6 > 0) {echo 'checked';}?> value="REKENING TABUNGAN" onclick="FuncKryPemohon6()">
											<input type="hidden" name="rekening_tabungan_pemohon_ck1" id="rekening_tabungan_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry6['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">FOTO KARTU IDENTITAS KARYAWAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry7 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry7 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('FOTO KARTU IDENTITAS KARYAWAN', SQLSRV_PARAM_IN));
													$execKapasitasKry7 = sqlsrv_query( $conn, $callKapasitasKry7, $paramKapasitasKry7,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry7 = sqlsrv_fetch_array($execKapasitasKry7);
													$checkKapasitasKry7 = sqlsrv_num_rows($execKapasitasKry7);
												?>
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pemohon_ck" id="foto_kartu_identitas_pemohon_ck"  <?php if ($checkKapasitasKry7 > 0) {echo 'checked';}?> value="FOTO KARTU IDENTITAS KARYAWAN" onclick="FuncKryPemohon7()">
											<input type="hidden" name="foto_kartu_identitas_pemohon_ck1" id="foto_kartu_identitas_pemohon_ck1"  value="">
										</td> 
										<td style="width:50%;">
										<select name="foto_kartu_identitas_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKry7['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>	
											
								
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_karyawan_pemohon" class="form-control" required>
														<option value="PV">PV</option>
														<option value="KUNJUNGAN KE KANTOR">KUNJUNGAN KE KANTOR</option>
														<option value="BPJSTKU Mobile">BPJSTKU Mobile</option>
														<option value="SMS BPJS">SMS BPJS</option>
														<option value="www.sso.bpjsketenagakerjaan.go.id">www.sso.bpjsketenagakerjaan.go.id</option>
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									</tr>
										<tr>
												<td >Validasi Kapasitas SBH </td>
													<td colspan="2" >
														<?php if($ImgKunjCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
										
									<tr>
												<td >Upload Bukti Validasi Kapasitas Jika Ada Revisi</td>
													<td colspan="2" >
														<input type="file" name="img_kunjungan_karyawan_pemohon"  style="margin-bottom:5px;" />

													</td>
									</tr>
									
								
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
										<input type="hidden" name="app_no_hide" id="app_no_hide"  value="<?php echo $prospect;?>">
										<input type="hidden" name="nama_pemohon_hide" id="nama_pemohon_hide"  value="<?php echo $dataInfo['CUST_NAME'];?>">
										<input type="hidden" name="user_hide" id="user_hide"  value="<?php echo $user;?>">
										<input type="hidden" name="branchid_hide" id="branchid_hide"  value="<?php echo $branchid;?>">
										<input type="hidden" name="cust_type_hide" id="cust_type_hide"  value="Pemohon">
										<input type="hidden" name="cust_model_kry_hide" id="cust_model_kry_hide"  value="KARYAWAN">
										<input type="hidden" name="dacor" id="dacor"  value="<?php echo $dataCust['DACOR']; ?>" >
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="kry_bank_penerbit" readonly >
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="kry_norek" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_pemilik_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="kry_pemilik_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="mutasi_karyawan" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasKry ['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasKry['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasKry['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasKry['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_tf_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
								
								
									<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
														<?php if($ImgKryBankCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
										
									<tr>
												<td >Upload Bukti Validasi TF SBH</td>
													<td colspan="2" >
														<input type="file" name="img_tf_kry_pemohon"  style="margin-bottom:5px;" />

													</td>
									</tr>
										
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabeldata">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pemohon</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pemohon" id="tgl_penerimaan_gaji_pemohon" autocomplete="off" 
												value="<?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format("d-m-Y");}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pemohon" id="inputan_cra_pemohon" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PEMOHON_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pemohon" id="inputan_bm_pemohon" class="form-control" value="" required  >
										</td>
									</tr>
									
								
								</table>
							</div>
					
					<div id="historical_kredit_kry_pemohon" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					
					<!-- Tombol utama -->
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-kry" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-kry"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
			
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
					</div>	
					<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>
					
					</div>
					
					</div>
					<?php } ?>
					
					
					<!------------------Karyawan Pasangan -->
					<?php if ($dataAnalis['JOIN_INCOME'] == "YA" && $dataAnalis['CUST_MODEL_PASANGAN'] == "KARYAWAN" ) { ?>
					<div id="kry_pasangan_div">
					<?php }else{ ?>
							<div id="kry_pasangan_div" style="display:none;">
					<?php } ?>
				
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">KARYAWAN PASANGAN</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">NAMA PERUSAHAAN TEMPAT BEKERJA</td>
										<td style="width:50%;">
											<input type="text" name="nama_perusahaan_pasangan" class="form-control" value="<?php  echo $perusahaan_pasangan; ?>"  id="nama_perusahaan_pasangan" readonly>
										</td>
										<td style="width:50%;">
											 <select name="nama_perusahaan_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">JABATAN</td>
										<td style="width:50%;">
											<input type="text" name="jabatan_pasangan" class="form-control" value="<?php echo $profesi_pasangan; ?>"  id="jabatan_pasangan" readonly>
										</td>
										<td style="width:50%;">
											 <select name="jabatan_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">INDUSTRY TYPE</td>
										<td style="width:50%;">
											<input type="text" name="industry_type_pasangan" class="form-control" value="<?php echo $industri_pasangan; ?>"  id="industry_type_pasangan" readonly>
										</td>
										<td style="width:50%;">
											 <select name="industry_type_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">LAMA BEKERJA</td>
										<td style="width:50%;">
											<input type="text" name="lama_bekerja_pasangan" class="form-control" value="<?php echo $lama_bekerja_pasangan; ?> Bulan"  id="lama_bekerja_pasangan" readonly>
										</td>
										<td style="width:50%;">
											 <select name="lama_bekerja_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										
								
									
								</table>
								
						
							</div>								
						</div>
					
						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">NO TELPON KANTOR</td>
										<td style="width:50%;">
											<input type="text" name="telp_kantor_pasangan" class="form-control" value="<?php  echo $dataKapasitasKryPasangan['NO_TELP_KANTOR']; ?>"  id="telp_kantor_pasangan" >
										</td>
									
									
									</tr>
								
									<tr>
										<td style="width:30%;">STATUS KARYAWAN</td>
										<td style="width:50%;">
											 <select name="status_karyawan_pasangan" id="status_karyawan_pasangan"  class="form-control" >
														<option value="">-Pilih-</option>
														<option value="AKTIF" <?php if ($dataKapasitasKryPasangan['STATUS_KARYAWAN'] == "AKTIF" ) {echo 'selected';}?> >AKTIF</option>
														<option value="TIDAK AKTIF" <?php if ($dataKapasitasKryPasangan['STATUS_KARYAWAN'] == "TIDAK AKTIF" ) {echo 'selected';}?> >TIDAK AKTIF</option>
														<option value="DALAM PROSES RESIGN" <?php if ($dataKapasitasKryPasangan['STATUS_KARYAWAN'] == "DALAM PROSES RESIGN" ) {echo 'selected';}?> >DALAM PROSES RESIGN</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NAMA PIC KANTOR YANG DAPAT DIHUBUNGI</td>
										<td style="width:50%;">
											<input type="text" name="pic_kantor_pasangan" class="form-control" value="<?php  echo $dataKapasitasKryPasangan['NAMA_PIC_KANTOR']; ?>"  id="pic_kantor_pasangan" >
										</td>
									
									
									</tr>
									<tr>
										<td style="width:30%;">HASIL VERIFIKASI KANTOR</td>
										<td style="width:50%;">
											<textarea type="input" name="verf_kantor_kry_pasangan"  class="form-control"  id="verf_kantor_kry_pasangan" ><?php  echo $dataKapasitasKryPasangan['HASIL_VERIVIKASI']; ?> </textarea>
										</td>
									
									
									</tr>
										
								
									
								</table>
							</div>								
						</div>
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">SLIP GAJI</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SLIP GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry1 = sqlsrv_query( $conn, $callKapasitasKry1, $paramKapasitasKry1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry1 = sqlsrv_fetch_array($execKapasitasKry1);
													$checkKapasitasKry1 = sqlsrv_num_rows($execKapasitasKry1);
												?>
											<input type="checkbox" class="aroClass" name="slip_gaji_pasangan_ck" id="slip_gaji_pasangan_ck" value="" <?php if ($checkKapasitasKry1 > 0) {echo 'checked';}?> onclick="FuncKryPemohon1()">
												<input type="hidden" name="slip_gaji_pasangan_ck1" id="slip_gaji_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="slip_gaji_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
						
									
									<tr>
										<td style="width:30%;">DAFTAR GAJI</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('DAFTAR GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry2 = sqlsrv_query( $conn, $callKapasitasKry2, $paramKapasitasKry2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry2 = sqlsrv_fetch_array($execKapasitasKry2);
													$checkKapasitasKry2 = sqlsrv_num_rows($execKapasitasKry2);
												?>
											<input type="checkbox" class="aroClass" name="daftar_gaji_pasangan_ck" id="daftar_gaji_pasangan_ck" <?php if ($checkKapasitasKry2 > 0) {echo 'checked';}?> value="DAFTAR GAJI" onclick="FuncKryPemohon2()">
											<input type="hidden" name="daftar_gaji_pasangan_ck1" id="daftar_gaji_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"<?php if ($dataKapasitasKry2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">SURAT KETERANGAN PENGHASILAN</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKry3 = sqlsrv_query( $conn, $callKapasitasKry3, $paramKapasitasKry3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry3 = sqlsrv_fetch_array($execKapasitasKry3);
													$checkKapasitasKry3 = sqlsrv_num_rows($execKapasitasKry3);
												?>
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pasangan_ck" id="surat_ket_penghasilan_pasangan_ck"  <?php if ($checkKapasitasKry3 > 0) {echo 'checked';}?>  value="SURAT KETERANGAN PENGHASILAN" onclick="FuncKryPemohon3()">
											<input type="hidden" name="surat_ket_penghasilan_pasangan_ck1" id="surat_ket_penghasilan_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKry3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">BUKTI SALDO PRINT SCREEN JAMSOSTEK</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKry4 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry4 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKry4 = sqlsrv_query( $conn, $callKapasitasKry4, $paramKapasitasKry4,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry4 = sqlsrv_fetch_array($execKapasitasKry4);
													$checkKapasitasKry4 = sqlsrv_num_rows($execKapasitasKry4);
												?>
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pasangan_ck" id="bukti_saldo_print_jamsos_pasangan_ck"  <?php if ($checkKapasitasKry4 > 0) {echo 'checked';}?>  value="BUKTI SALDO PRINT SCREEN JAMSOSTEK" onclick="FuncKryPemohon4()"> 
											<input type="hidden" name="bukti_saldo_print_jamsos_pasangan_ck1" id="bukti_saldo_print_jamsos_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID <?php if ($dataKapasitasKry4['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									<tr>
										<td style="width:30%;">BUKTI SPT PAJAK TAHUN TERAKHIR</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry5 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry5 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasKry5 = sqlsrv_query( $conn, $callKapasitasKry5, $paramKapasitasKry5,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry5 = sqlsrv_fetch_array($execKapasitasKry5);
													$checkKapasitasKry5 = sqlsrv_num_rows($execKapasitasKry5);
												?>
											<input type="checkbox" class="aroClass" name="bukti_spt_pasangan_ck" id="bukti_spt_pasangan_ck" <?php if ($checkKapasitasKry5 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR"  onclick="FuncKryPemohon5()">
											<input type="hidden" name="bukti_spt_pasangan_ck1" id="bukti_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry5['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">REKENING TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry6 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry6 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('REKENING TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasKry6 = sqlsrv_query( $conn, $callKapasitasKry6, $paramKapasitasKry6,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry6 = sqlsrv_fetch_array($execKapasitasKry6);
													$checkKapasitasKry6 = sqlsrv_num_rows($execKapasitasKry6);
												?>
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pasangan_ck" id="rekening_tabungan_pasangan_ck"  <?php if ($checkKapasitasKry6 > 0) {echo 'checked';}?> value="REKENING TABUNGAN" onclick="FuncKryPemohon6()">
											<input type="hidden" name="rekening_tabungan_pasangan_ck1" id="rekening_tabungan_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKry6['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">FOTO KARTU IDENTITAS KARYAWAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKry7 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKry7 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('FOTO KARTU IDENTITAS KARYAWAN', SQLSRV_PARAM_IN));
													$execKapasitasKry7 = sqlsrv_query( $conn, $callKapasitasKry7, $paramKapasitasKry7,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasKry7 = sqlsrv_fetch_array($execKapasitasKry7);
													$checkKapasitasKry7 = sqlsrv_num_rows($execKapasitasKry7);
												?>
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pasangan_ck" id="foto_kartu_identitas_pasangan_ck"  <?php if ($checkKapasitasKry7 > 0) {echo 'checked';}?> value="FOTO KARTU IDENTITAS KARYAWAN" onclick="FuncKryPemohon7()">
											<input type="hidden" name="foto_kartu_identitas_pasangan_ck1" id="foto_kartu_identitas_pasangan_ck1"  value="">
										</td> 
										<td style="width:50%;">
										<select name="foto_kartu_identitas_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKry7['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
											
								
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_karyawan_pasangan" class="form-control" required>
														<option value="PV">PV</option>
														<option value="KUNJUNGAN KE KANTOR">KUNJUNGAN KE KANTOR</option>
														<option value="BPJSTKU Mobile">BPJSTKU Mobile</option>
														<option value="SMS BPJS">SMS BPJS</option>
														<option value="www.sso.bpjsketenagakerjaan.go.id">www.sso.bpjsketenagakerjaan.go.id</option>
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Kapasitas SBH </td>
													<td colspan="2" >
													<?php 
													$callImgKunjPas = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgKunjPas =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('KUNJUNGAN_KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKunjPas = sqlsrv_query( $conn, $callImgKunj, $paramImgKunj) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgKunjPas= sqlsrv_fetch_array($execImgKunj);
													$ImgKunjCAPas = $dataImgKunjPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKunjCAPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjCAPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjCAPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
										
									<tr>
												<td >Upload Bukti Validasi Kapasitas Jika Ada Revisi</td>
													<td colspan="2" >
														<input type="file" name="img_kunjungan_karyawan_pasangan"  style="margin-bottom:5px;" />

													</td>
									</tr>
									
								
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<!--
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%"; colspan="2">Jika Pilihan Slip Gaji/Daftar Gaji/SKT/Print Jamsostek/SPT 
										Nominal Gaji Yang tertera Pada Bukti Penghasilan Sesuai Dengan Bukti Kapasitas Yang dilampirkan
										</td>
										
									
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Gaji (Inputan CRA)
										</td>
											<td> <input type="text" name="gaji_pasangan_cra" class="form-control" value="<?php// echo number_format($dataBank['GAJI_PASANGAN'],0,',','.'); ?>"  id="gaji_pasangan_cra" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Gaji (RAK)
										</td>
											<td> <input type="text" name="nominal_pasangan_rak" class="form-control" value=""  id="nominal_pasangan_rak" >
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Penerimaan Gaji setiap tanggal   :
										</td>
											<td> <div class="input-group date">
												<input type="text" class="form-control" name="tgl_pasangan_gaji" id="tgl_pasangan_gaji" autocomplete="off" value="">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Besaran nominal  di Buku tabungan saat tanggal gajian :
										</td>
											<td> <input type="text" name="besaran_nominal_pasangan" class="form-control" value=""  id="besaran_nominal_pasangan" >
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	-->
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
								
										<input type="hidden" name="cust_model_kry_hide" id="cust_model_kry_hide"  value="KARYAWAN">
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_bank_penerbit_pasangan" class="form-control" value="<?php echo $dataBank['PASANGAN_BANK_BRANCH'];?>"  id="kry_bank_penerbit_pasangan" readonly >
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_norek_pasangan" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NO'];?>"  id="kry_norek_pasangan" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_pemilik_rekening_pasangan" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NAME'];?>"  id="kry_pemilik_rekening_pasangan" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="mutasi_karyawan_pasangan" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasKryPasangan  ['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasKryPasangan['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasKryPasangan['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasKryPasangan['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_tf_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
										<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgKryBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgKryBankPas =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKryBankPas = sqlsrv_query( $conn, $callImgKryBankPas, $paramImgKryBankPas) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgKryBankPas = sqlsrv_fetch_array($execImgKryBankPas);
													$ImgKryBankCAPas = $dataImgKryBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKryBankCAPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankCAPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankCAPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
										
									<tr>
												<td >Upload Bukti Validasi TF SBH</td>
													<td colspan="2" >
														<input type="file" name="img_tf_kry_pasangan"  style="margin-bottom:5px;" />

													</td>
									</tr>
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U> Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabeldataPasangan">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pasangan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pasangan" id="tgl_penerimaan_gaji_pasangan" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pasangan" id="inputan_cmo_pasangan" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pasangan" id="inputan_cra_pasangan" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pasangan" id="inputan_ca_pasangan" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PASANGAN_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pasangan" id="inputan_bm_pasangan" class="form-control" value=""   >
										</td>
									</tr>
									
								
								</table>
							</div>
							
							
					<div id="historical_kredit_kry_pasangan" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pasangan-kry" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif pasangan
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pasangan-kry"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
			
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){										
									$callPasanganScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								
								}else{
									$callPasanganScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								}		
									
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					
				
					
					</div>
					
					
					
					
					
					
					
					<!---------------------------------------------  WIRASWASTA  -->
					<?php if($dataInfo['CUST_MODEL'] == 'WIRASWASTA'){ ?>
					<div id="wrs_pemohon_div">
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">WIRASWASTA PEMOHON</td>
									</tr>
									
									
								</table>
							</div>
							
							<input type="hidden" name="cust_type_hide" id="cust_type_hide"  value="Pemohon">
										<input type="hidden" name="cust_model_wrs_hide" id="cust_model_wrs_hide"  value="WIRASWASTA">
					
						
					
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasWrs1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrs1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs1 = sqlsrv_query( $conn, $callKapasitasWrs1, $paramKapasitasWrs1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrs1 = sqlsrv_fetch_array($execKapasitasWrs1);
													$checkKapasitasWrs1 = sqlsrv_num_rows($execKapasitasWrs1);
												?>				
											<input type="checkbox"  name="rek_tabungan_pemohon_wrs_ck" id="rek_tabungan_pemohon_wrs_ck" value="REK TABUNGAN" <?php if ($checkKapasitasWrs1 > 0) {echo 'checked';}?> onclick="FuncWrsPemohon1()">
										</td>
										<input type="hidden" name="rek_tabungan_pemohon_wrs_ck1" id="rek_tabungan_pemohon_wrs_ck1"  value="">
										<td style="width:50%;">
											 <select name="rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($checkKapasitasWrs1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									
									<tr>
										<td style="width:30%;">Nota Pembelian</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrs2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrs2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PEMBELIAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs2 = sqlsrv_query( $conn, $callKapasitasWrs2, $paramKapasitasWrs2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrs2 = sqlsrv_fetch_array($execKapasitasWrs2);
													$checkKapasitasWrs2 = sqlsrv_num_rows($execKapasitasWrs2);
												?>
											<input type="checkbox"  name="nota_pembelian_wrs_pemohon_ck" id="nota_pembelian_wrs_pemohon_ck" <?php if ($checkKapasitasWrs2 > 0) {echo 'checked';}?> value="NOTA PEMBELIAN" onclick="FuncWrsPemohon2()">
										</td>
										<input type="hidden" name="nota_pembelian_wrs_pemohon_ck1" id="nota_pembelian_wrs_pemohon_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_pembelian_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($checkKapasitasWrs2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">Nota Penjualan</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrs3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrs3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PENJUALAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs3 = sqlsrv_query( $conn, $callKapasitasWrs3, $paramKapasitasWrs3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrs3 = sqlsrv_fetch_array($execKapasitasWrs3);
													$checkKapasitasWrs3 = sqlsrv_num_rows($execKapasitasWrs3);
												?>
											<input type="checkbox"  name="nota_penjualan_wrs_pemohon_ck" id="nota_penjualan_wrs_pemohon_ck" <?php if ($checkKapasitasWrs3 > 0) {echo 'checked';}?> value="NOTA PENJUALAN" onclick="FuncWrsPemohon3()">
										</td>
										<input type="hidden" name="nota_penjualan_wrs_pemohon_ck1" id="nota_penjualan_wrs_pemohon_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_penjualan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrs3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrs4 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrs4 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasWrs4 = sqlsrv_query( $conn, $callKapasitasWrs4, $paramKapasitasWrs4,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrs4 = sqlsrv_fetch_array($execKapasitasWrs4);
													$checkKapasitasWrs4 = sqlsrv_num_rows($execKapasitasWrs4);
												?>
											<input type="checkbox"  name="spt_wrs_pemohon_ck" id="spt_wrs_pemohon_ck" <?php if ($checkKapasitasWrs4 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR" onclick="FuncWrsPemohon4()">
												<input type="hidden" name="spt_wrs_pemohon_ck1" id="spt_wrs_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="spt_wrs_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrs4['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>	
									
									
									
									
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
							<input type="hidden" name="cust_model_wrs_hide" id="cust_model_wrs_hide"  value="WIRASWASTA" >
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pemohon_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="wrs_pemohon_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pemohon_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="wrs_pemohon_norek" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pemohon_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="wrs_pemohon_rekening" readonly >
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="wrs_pemohon_mutasi" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasWrs ['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasWrs['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasWrs['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasWrs['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_wrs_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBank = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgWirBank =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBank = sqlsrv_query( $conn, $callImgWirBank, $paramImgWirBank) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgWirBank = sqlsrv_fetch_array($execImgWirBank);
													$ImgWirBank = $dataImgWirBank['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBank <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBank);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBank);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_wrs_pemohon"  style="margin-bottom:5px;" />
													
												</td>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiWrsPemohon">
                    
               
								     </div>
									 
									 
								
							</div>
					</div>	
					
					</div>
					
				<!--NOTA     -->
							<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Nota</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
											
									<tr>
										<td style="width:30%;">Nota Yang Dilampirkan</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_lampiran_pemohon" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Nota Penjualan" <?php if ($dataKapasitasWrs['LAMPIRAN_NOTA'] == "Nota Penjualan" ) {echo 'selected';}?> >Nota Penjualan</option>
														<option value="Nota Belanja"  <?php if ($dataKapasitasWrs['LAMPIRAN_NOTA'] == "Nota Belanja" ) {echo 'selected';}?>>Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pemohon" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasWrs['PERIODE_NOTA'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasWrs['PERIODE_NOTA'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasWrs['PERIODE_NOTA'] == "3 Bulan Terakhir" ) {echo 'selected';}?>>3 Bulan Terakhir</option>
														
											</select>  
										</td>
										
									</tr>
									
								
									
								
									
								</table>
							</div>								
						</div>
				
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Nota</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
				
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelNotaWrsPemohon">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
											
									<tr>
										<td style="width:30%;">TOTAL PENDAPATAN USAHA (Berdasarkan Nota)</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_nota_pendapatan_wrs_pemohon"  id ="tot_nota_pendapatan_wrs_pemohon" class="form-control" readonly 
											value="<?php echo number_format($dataKapasitasWrs['TOTAL_PENDAPATAN_USAHA_NOTA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">% Margin Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="margin_pendapatan_wrs_pemohon"  id ="margin_pendapatan_wrs_pemohon" class="form-control" readonly
											value="<?php echo number_format($dataKapasitasWrs['MARRGIN_PENDAPATAN_USAHA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Total Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_pendapatan_wrs_pemohon"  id ="tot_pendapatan_wrs_pemohon" class="form-control" readonly 
											value="<?php echo number_format($dataKapasitasWrs['TOTAL_PENDAPATAN_USAHA'],0,',','.'); ?>">
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Biaya Operasional</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="biaya_opr_wrs_pemohon"  id ="biaya_opr_wrs_pemohon" class="form-control" readonly
											value="<?php echo number_format($dataKapasitasWrs['BIAYA_OPERASIONAL'],0,',','.'); ?>">
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Net Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="net_wrs_pemohon"  id ="net_wrs_pemohon" class="form-control" readonly 
												value="<?php echo number_format($dataKapasitasWrs['NET_PENDAPATAN_USAHA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
									
									
									
								
									
								
									
								</table>
							</div>								
						</div>
				
						
						
					</div>
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pemohon</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pemohon" id="tgl_penerimaan_gaji_pemohon" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pemohon" id="inputan_cra_pemohon" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PEMOHON_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pemohon" id="inputan_bm_pemohon" class="form-control" value=""  required >
										</td>
									</tr>
									
								
								</table>
							</div>
					<div id="historical_kredit_wrs_pemohon" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-wrs" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-wrs"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
					</div>	
					<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					
					</div>
					
					</div>
					</div>
					<?php } ?>
				
					
					
					<!--- PASANGAN WIRASWASTA-->
					<?php if ($dataAnalis['JOIN_INCOME'] == "YA" && $dataAnalis['CUST_MODEL_PASANGAN'] == "WIRASWASTA" ) { ?>
					<div id="wrs_pasangan_div">
					<?php }else{ ?>
							<div id="wrs_pasangan_div" style="display:none;">
					<?php } ?>
				
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">WIRASWASTA PASANGAN</td>
									</tr>
									
									
								</table>
							</div>
							
						
					
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasWrsPas1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrsPas1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas1 = sqlsrv_query( $conn, $callKapasitasWrsPas1, $paramKapasitasWrsPas1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrsPas1 = sqlsrv_fetch_array($execKapasitasWrsPas1);
													$checkKapasitasWrsPas1 = sqlsrv_num_rows($execKapasitasWrsPas1);
												?>
											<input type="checkbox"  name="rek_tabungan_pasangan_wrs_ck" id="rek_tabungan_pasangan_wrs_ck" value="" <?php if ($checkKapasitasWrsPas1 > 0) {echo 'checked';}?>>
										</td>
										<input type="hidden" name="rek_tabungan_pasangan_wrs_ck1" id="rek_tabungan_pasangan_wrs_ck1"  value="">
										<td style="width:50%;">
											 <select name="rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrsPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">Nota Pembelian</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrsPas2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrsPas2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PEMBELIAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas2 = sqlsrv_query( $conn, $callKapasitasWrsPas2, $paramKapasitasWrsPas2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrsPas2 = sqlsrv_fetch_array($execKapasitasWrsPas2);
													$checkKapasitasWrsPas2 = sqlsrv_num_rows($execKapasitasWrsPas2);
												?>
											<input type="checkbox"  name="nota_pembelian_wrs_pasangan_ck" id="nota_pembelian_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas2 > 0) {echo 'checked';}?> value="" >
										</td>
										<input type="hidden" name="nota_pembelian_wrs_pasangan_ck1" id="nota_pembelian_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_pembelian_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrsPas2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">Nota Penjualan</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrsPas3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrsPas3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PENJUALAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas3 = sqlsrv_query( $conn, $callKapasitasWrsPas3, $paramKapasitasWrsPas3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrsPas3 = sqlsrv_fetch_array($execKapasitasWrsPas3);
													$checkKapasitasWrsPas3 = sqlsrv_num_rows($execKapasitasWrsPas3);
												?>
											<input type="checkbox"  name="nota_penjualan_wrs_pasangan_ck" id="nota_penjualan_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas3 > 0) {echo 'checked';}?> value="NOTA PENJUALAN" >
										</td>
										<input type="hidden" name="nota_penjualan_wrs_pasangan_ck1" id="nota_penjualan_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_penjualan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrsPas3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasWrsPas4 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasWrsPas4 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas4 = sqlsrv_query( $conn, $callKapasitasWrsPas4, $paramKapasitasWrsPas4,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasWrsPas4 = sqlsrv_fetch_array($execKapasitasWrsPas4);
													$checkKapasitasWrsPas4 = sqlsrv_num_rows($execKapasitasWrsPas4);
												?>
											<input type="checkbox"  name="spt_wrs_pasangan_ck" id="spt_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas4 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR" >
												<input type="hidden" name="spt_wrs_pasangan_ck1" id="spt_wrs_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="spt_wrs_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasWrsPas4['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
							<input type="hidden" name="cust_model_wrs_hide" id="cust_model_wrs_hide"  value="WIRASWASTA" >
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['PASANGAN_BANK_BRANCH'];?>"  id="wrs_pasangan_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pasangan_norek" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NO'];?>"  id="wrs_pasangan_norek" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pasangan_rekening" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NAME'];?>"  id="wrs_pasangan_rekening" readonly >
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="wrs_pasangan_mutasi" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasWrsPasangan['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_wrs_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgWirBankPas =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankPas = sqlsrv_query( $conn, $callImgWirBankPas, $paramImgWirBankPas) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgWirBankPas = sqlsrv_fetch_array($execImgWirBankPas);
													$ImgWirBankPas = $dataImgWirBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBankPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
										
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_wrs_pasangan"  style="margin-bottom:5px;" />
													
												</td>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiWrsPasangan">
                    
               
								     </div>
									 
									 
									
							</div>
					</div>	
					
					</div>
					
				<!--NOTA     -->
							<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Nota</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
											
									<tr>
										<td style="width:30%;">Nota Yang Dilampirkan</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_lampiran_pasangan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Nota Penjualan" <?php if ($dataKapasitasWrsPasangan['LAMPIRAN_NOTA'] == "Nota Penjualan" ) {echo 'selected';}?> >Nota Penjualan</option>
														<option value="Nota Belanja"  <?php if ($dataKapasitasWrsPasangan['LAMPIRAN_NOTA'] == "Nota Belanja" ) {echo 'selected';}?>>Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pasangan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['PERIODE_NOTA'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['PERIODE_NOTA'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasWrsPasangan['PERIODE_NOTA'] == "3 Bulan Terakhir" ) {echo 'selected';}?>>3 Bulan Terakhir</option>
														
											</select>  
										</td>
										
									</tr>
									
								
									
								
									
								</table>
							</div>								
						</div>
				
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelNotaWrsPasangan">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
											
									<tr>
										<td style="width:30%;">TOTAL PENDAPATAN USAHA (Berdasarkan Nota)</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_nota_pendapatan_wrs_pasangan"  id ="tot_nota_pendapatan_wrs_pasangan" class="form-control" readonly 
											value="<?php echo number_format($dataKapasitasWrsPasangan['TOTAL_PENDAPATAN_USAHA_NOTA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">% Margin Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="margin_pendapatan_wrs_pasangan"  id ="margin_pendapatan_wrs_pasangan" class="form-control" readonly 
											value="<?php echo number_format($dataKapasitasWrsPasangan['MARRGIN_PENDAPATAN_USAHA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Total Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_pendapatan_wrs_pasangan"  id ="tot_pendapatan_wrs_pasangan" class="form-control" readonly 
											value="<?php echo number_format($dataKapasitasWrsPasangan['TOTAL_PENDAPATAN_USAHA'],0,',','.'); ?>">
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Biaya Operasional</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="biaya_opr_wrs_pasangan"  id ="biaya_opr_wrs_pasangan" class="form-control" readonly
											value="<?php echo number_format($dataKapasitasWrsPasangan['BIAYA_OPERASIONAL'],0,',','.'); ?>">
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Net Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="net_wrs_pasangan"  id ="net_wrs_pasangan" class="form-control" readonly 
												value="<?php echo number_format($dataKapasitasWrsPasangan['NET_PENDAPATAN_USAHA'],0,',','.'); ?>" >
											
										</td>
										
									</tr>
									
									
									
								
									
								
									
								</table>
							</div>								
						</div>
				
						
						
					</div>
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pasangan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pasangan" id="tgl_penerimaan_gaji_pasangan" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pasangan" id="inputan_cmo_pasangan" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pasangan" id="inputan_cra_pasangan" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pasangan" id="inputan_ca_pasangan" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PASANGAN_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pasangan1" id="inputan_bm_pasangan1" class="form-control" value=""   >
										</td>
									</tr>
									
									
								
								</table>
							</div>	
					<div id="historical_kredit_wrs_pasangan" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pasangan-wrs" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif pasangan
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pasangan-wrs"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){										
									$callPasanganScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								
								}else{
									$callPasanganScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								}		
									
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					
				
					
					</div>
					<!---- end wiraswasta--->
				<!-- -->	
					
					<!---------------------------------------------  Profesional  -->
					<?php if($dataInfo['CUST_MODEL'] == 'PROFESSIONAL'){ ?>
					<div id="pro_pemohon_div">
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Profesional PEMOHON</td>
									</tr>
									
									
								</table>
							</div>
							
						
						<input type="hidden" name="cust_type_hide" id="cust_type_hide"  value="Pemohon">
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									
									<tr>
										<td style="width:30%;">Bukti Penghasilan / Usaha</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasPro1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasPro1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasPro1 = sqlsrv_query( $conn, $callKapasitasPro1, $paramKapasitasPro1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasPro1 = sqlsrv_fetch_array($execKapasitasPro1);
													$checkKapasitasPro1 = sqlsrv_num_rows($execKapasitasPro1);
											?>
											<input type="checkbox"  name="pro_bukti_penghasilan_pemohon_ck" id="pro_bukti_penghasilan_pemohon_ck" value="BUKTI PENGHASILAN / USAHA" <?php if ($checkKapasitasPro1 > 0) {echo 'checked';}?>onclick="FuncProPemohon1()">
											<input type="hidden" name="pro_bukti_penghasilan_pemohon_ck1" id="pro_bukti_penghasilan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_bukti_penghasilan_pemohon_val" class="form-control"  >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasPro1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasPro2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasPro2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasPro2 = sqlsrv_query( $conn, $callKapasitasPro2, $paramKapasitasPro2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasPro2 = sqlsrv_fetch_array($execKapasitasPro2);
													$checkKapasitasPro2 = sqlsrv_num_rows($execKapasitasPro2);
											?>
											<input type="checkbox"  name="pro_rek_tabungan_pemohon_ck" id="pro_rek_tabungan_pemohon_ck" value="REK TABUNGAN" <?php if ($checkKapasitasPro2 > 0) {echo 'checked';}?> onclick="FuncProPemohon2()">
											<input type="hidden" name="pro_rek_tabungan_pemohon_ck1" id="pro_rek_tabungan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasPro2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasPro3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasPro3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasPro3 = sqlsrv_query( $conn, $callKapasitasPro3, $paramKapasitasPro3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasPro3 = sqlsrv_fetch_array($execKapasitasPro3);
													$checkKapasitasPro3 = sqlsrv_num_rows($execKapasitasPro3);
										?>
											<input type="checkbox"  name="pro_spt_pemohon_ck" id="pro_spt_pemohon_ck" value="BUKTI SPT PAJAK TAHUN TERAKHIR" <?php if ($checkKapasitasPro3 > 0) {echo 'checked';}?>  onclick="FuncProPemohon3()">
											<input type="hidden" name="pro_spt_pemohon_ck1" id="pro_spt_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="pro_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasPro3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>  >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>	
									
									
									
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<input type="hidden" name="cust_model_pro_hide" id="cust_model_pro_hide"  value="PROFESSIONAL">
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pemohon_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="pro_pemohon_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pemohon_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="pro_pemohon_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pemohon_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="pro_pemohon_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="pro_pemohon_mutasi" class="form-control"readonly >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasPro['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasPro['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasPro['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasPro['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_pro_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBank = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgProBank =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBank = sqlsrv_query( $conn, $callImgProBank, $paramImgProBank) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgProBank = sqlsrv_fetch_array($execImgProBank);
													$ImgProBank = $dataImgProBank['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBank <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBank);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBank);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
								
								<tr>
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_pro_pemohon"  style="margin-bottom:5px;" />
													
												</td>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiProPemohon">
                    
               
								     </div>
									 
									 
							
							</div>
					
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pemohon</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pemohon" id="tgl_penerimaan_gaji_pemohon" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pemohon" id="inputan_cra_pemohon" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PEMOHON_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pemohon" id="inputan_bm_pemohon" class="form-control" value="" required  >
										</td>
									</tr>
									
								
								</table>
							</div>
							
					<div id="historical_kredit_pro_pemohon" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-pro" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-pro"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
					</div>	
					<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>
					
					</div>
					</div>
					<?php } ?>
					
					<?php if ($dataAnalis['JOIN_INCOME'] == "YA" && $dataAnalis['CUST_MODEL_PASANGAN'] == "PROFESSIONAL" ) { ?>
					<div id="pro_pasangan_div">
					<?php }else{ ?>
							<div id="pro_pasangan_div" style="display:none;">
					<?php } ?>
			
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Profesional Pasangan</td>
									</tr>
									
									
								</table>
							</div>
							
						
					
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">Bukti Penghasilan / Usaha</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasProPas1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasProPas1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasProPas1 = sqlsrv_query( $conn, $callKapasitasProPas1, $paramKapasitasProPas1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasProPas1 = sqlsrv_fetch_array($execKapasitasProPas1);
													$checkKapasitasProPas1 = sqlsrv_num_rows($execKapasitasProPas1);
											?>
											<input type="checkbox"  name="pro_bukti_penghasilan_pasangan_ck" id="pro_bukti_penghasilan_pasangan_ck" value="BUKTI PENGHASILAN / USAHA" <?php if ($checkKapasitasProPas1 > 0) {echo 'checked';}?>onclick="FuncProPasangan1()">
											<input type="hidden" name="pro_bukti_penghasilan_pasangan_ck1" id="pro_bukti_penghasilan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_bukti_penghasilan_pasangan_val" class="form-control"  >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasProPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasProPas2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasProPas2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasProPas2 = sqlsrv_query( $conn, $callKapasitasProPas2, $paramKapasitasProPas2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasProPas2 = sqlsrv_fetch_array($execKapasitasProPas2);
													$checkKapasitasProPas2 = sqlsrv_num_rows($execKapasitasProPas2);
											?>
											<input type="checkbox"  name="pro_rek_tabungan_pasangan_ck" id="pro_rek_tabungan_pasangan_ck" value="REK TABUNGAN" <?php if ($checkKapasitasProPas2 > 0) {echo 'checked';}?> onclick="FuncProPasangan2()">
											<input type="hidden" name="pro_rek_tabungan_pasangan_ck1" id="pro_rek_tabungan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasProPas2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasProPas3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasProPas3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasProPas3 = sqlsrv_query( $conn, $callKapasitasProPas3, $paramKapasitasProPas3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasProPas3 = sqlsrv_fetch_array($execKapasitasProPas3);
													$checkKapasitasProPas3 = sqlsrv_num_rows($execKapasitasProPas3);
										?>
											<input type="checkbox"  name="pro_spt_pasangan_ck" id="pro_spt_pasangan_ck" value="BUKTI SPT PAJAK TAHUN TERAKHIR" <?php if ($checkKapasitasProPas3 > 0) {echo 'checked';}?>  onclick="FuncProPasangan3()">
											<input type="hidden" name="pro_spt_pasangan_ck1" id="pro_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="pro_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasProPas3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>  >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>	
								
									
									
									
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<input type="hidden" name="cust_model_pro_hide" id="cust_model_pro_hide"  value="PROFESSIONAL">
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="pro_pasangan_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pasangan_norek" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NO'];?>"  id="pro_pasangan_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pasangan_rekening" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NAME'];?>"  id="pro_pasangan_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="pro_pasangan_mutasi" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_pro_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
									<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgProBankPas =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankPas = sqlsrv_query( $conn, $callImgProBankPas, $paramImgProBankPas) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgProBankPas = sqlsrv_fetch_array($execImgProBankPas);
													$ImgProBankPas = $dataImgProBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBankPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_pro_pasangan"  style="margin-bottom:5px;" />
													
										</td>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiProPasangan">
                    
               
								     </div>
									 
									 
							
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pasangan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pasangan" id="tgl_penerimaan_gaji_pasangan" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pasangan" id="inputan_cmo_pasangan" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pasangan" id="inputan_cra_pasangan" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pasangan" id="inputan_ca_pasangan" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PASANGAN_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pasangan2" id="inputan_bm_pasangan2" class="form-control" value=""   >
										</td>
									</tr>
									
								
								</table>
							</div>
						<div id="historical_kredit_pro_pasangan" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pasangan-pro" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif pasangan
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pasangan-pro"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
				
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){										
									$callPasanganScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								
								}else{
									$callPasanganScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								}		
									
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					
				
					
					</div>
					
					<!-- non profesional-->

				<?php if($dataInfo['CUST_MODEL'] == 'NON PROFESSIONAL'){ ?>
					<div id="nonpro_pemohon_div">
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Non Profesional PEMOHON</td>
									</tr>
									
									
								</table>
							</div>
							
						<input type="hidden" name="cust_type_hide" id="cust_type_hide"  value="Pemohon">
					
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
										
									<tr>
										<td style="width:30%;">Bukti Penghasilan / Usaha</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonPro1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonPro1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasNonPro1 = sqlsrv_query( $conn, $callKapasitasNonPro1, $paramKapasitasNonPro1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonPro1 = sqlsrv_fetch_array($execKapasitasNonPro1);
													$checkKapasitasNonPro1 = sqlsrv_num_rows($execKapasitasNonPro1);
											?>
										
											<input type="checkbox"  name="nonpro_bukti_penghasilan_pemohon_ck" id="nonpro_bukti_penghasilan_pemohon_ck" value="BUKTI PENGHASILAN / USAHA" <?php if ($checkKapasitasNonPro1 > 0) {echo 'checked';}?> onclick="FuncNonProPemohon1()">
											<input type="hidden" name="nonpro_bukti_penghasilan_pemohon_ck1" id="nonpro_bukti_penghasilan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_bukti_penghasilan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonPro1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonPro2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonPro2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasNonPro2 = sqlsrv_query( $conn, $callKapasitasNonPro2, $paramKapasitasNonPro2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonPro2 = sqlsrv_fetch_array($execKapasitasNonPro2);
													$checkKapasitasNonPro2 = sqlsrv_num_rows($execKapasitasNonPro2);
										?>
											<input type="checkbox"  name="nonpro_rek_tabungan_pemohon_ck" id="nonpro_rek_tabungan_pemohon_ck" value="REK TABUNGAN" <?php if ($checkKapasitasNonPro1 > 0) {echo 'checked';}?> onclick="FuncNonProPemohon2()" >
											<input type="hidden" name="nonpro_rek_tabungan_pemohon_ck1" id="nonpro_rek_tabungan_pemohon_ck1"   value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonPro1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>  >TIDAK VALID</option>
													
											</select>     
										</td>
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonPro3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonPro3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasNonPro3 = sqlsrv_query( $conn, $callKapasitasNonPro3, $paramKapasitasNonPro3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonPro3 = sqlsrv_fetch_array($execKapasitasNonPro3);
													$checkKapasitasNonPro3 = sqlsrv_num_rows($execKapasitasNonPro3);
										?>
											<input type="checkbox"  name="nonpro_spt_pemohon_ck" id="nonpro_spt_pemohon_ck" value="BUKTI SPT PAJAK TAHUN TERAKHIR" <?php if ($checkKapasitasNonPro1 > 0) {echo 'checked';}?> onclick="FuncNonProPemohon3()">
											<input type="hidden" name="nonpro_spt_pemohon_ck1" id="nonpro_spt_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nonpro_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonPro1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									
								
									
									
									
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<input type="hidden" name="cust_model_nonpro_hide" id="cust_model_nonpro_hide"  value="NON PROFESSIONAL">
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pemohon_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="nonpro_pemohon_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pemohon_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="nonpro_pemohon_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pemohon_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="nonpro_pemohon_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="nonpro_pemohon_mutasi" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasNonPro['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasNonPro['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasNonPro['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasNonPro['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_nonpro_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBank= "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgNonProBank=  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBank= sqlsrv_query( $conn, $callImgNonProBank, $paramImgNonProBank) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgNonProBank= sqlsrv_fetch_array($execImgNonProBank);
													$ImgNonProBank= $dataImgNonProBank['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBank <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBank);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBank);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
									<tr>
										<td >Upload Bukti Validasi Jika Diperlukan</td>
												<td colspan="2" >
													<input type="file" name="img_tf_nonpro_pemohon"  style="margin-bottom:5px;" />
													
												</td>
									</tr>
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiNonProPemohon">
                    
               
								     </div>
									 
									 
								
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pemohon</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pemohon" id="tgl_penerimaan_gaji_pemohon" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pemohon" id="inputan_cra_pemohon" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pemohon" id="inputan_cmo_pemohon" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PEMOHON_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pemohon" id="inputan_bm_pemohon" class="form-control" value="" required  >
										</td>
									</tr>
									
								
								</table>
							</div>
					<div id="historical_kredit_nonpro_pemohon" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-nonpro" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-nonpro"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
				
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
					</div>	
					<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>
					
					</div>
					
					</div>
					<?php } ?>
					
					<?php if ($dataAnalis['JOIN_INCOME'] == "YA" && $dataAnalis['CUST_MODEL_PASANGAN'] == "NON PROFESSIONAL" ) { ?>
					<div id="nonpro_pasangan_div">
					<?php }else{ ?>
							<div id="nonpro_pasangan_div" style="display:none;">
					<?php } ?>
				
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Non Profesional Pasangan</td>
									</tr>
									
									
								</table>
							</div>
							
						
					
						
						
						
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Dokumen yang Dilampirkan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									
									<tr>
										<td style="width:30%;">Bukti Penghasilan / Usaha</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonProPas1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonProPas1 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas1 = sqlsrv_query( $conn, $callKapasitasNonProPas1, $paramKapasitasNonProPas1,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonProPas1 = sqlsrv_fetch_array($execKapasitasNonProPas1);
													$checkKapasitasNonProPas1 = sqlsrv_num_rows($execKapasitasNonProPas1);
											?>
										
											<input type="checkbox"  name="nonpro_bukti_penghasilan_pasangan_ck" id="nonpro_bukti_penghasilan_pasangan_ck" value="BUKTI PENGHASILAN / USAHA" <?php if ($checkKapasitasNonProPas1 > 0) {echo 'checked';}?> onclick="FuncNonProPasPemohon1()">
											<input type="hidden" name="nonpro_bukti_penghasilan_pasangan_ck1" id="nonpro_bukti_penghasilan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_bukti_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonProPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonProPas2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonProPas2 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas2 = sqlsrv_query( $conn, $callKapasitasNonProPas2, $paramKapasitasNonProPas2,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonProPas2 = sqlsrv_fetch_array($execKapasitasNonProPas2);
													$checkKapasitasNonProPas2 = sqlsrv_num_rows($execKapasitasNonProPas2);
										?>
											<input type="checkbox"  name="nonpro_rek_tabungan_pasangan_ck" id="nonpro_rek_tabungan_pasangan_ck" value="REK TABUNGAN" <?php if ($checkKapasitasNonProPas1 > 0) {echo 'checked';}?> onclick="FuncNonProPasPemohon2()" >
											<input type="hidden" name="nonpro_rek_tabungan_pasangan_ck1" id="nonpro_rek_tabungan_pasangan_ck1"   value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonProPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>  >TIDAK VALID</option>
													
											</select>     
										</td>
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasNonProPas3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasNonProPas3 = array(
																	array($prospect, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('SBH', SQLSRV_PARAM_IN),
																	array('NON PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas3 = sqlsrv_query( $conn, $callKapasitasNonProPas3, $paramKapasitasNonProPas3,$options) or die( print_r( sqlsrv_defaults(), true)); 
													$dataKapasitasNonProPas3 = sqlsrv_fetch_array($execKapasitasNonProPas3);
													$checkKapasitasNonProPas3 = sqlsrv_num_rows($execKapasitasNonProPas3);
										?>
											<input type="checkbox"  name="nonpro_spt_pasangan_ck" id="nonpro_spt_pasangan_ck" value="BUKTI SPT PAJAK TAHUN TERAKHIR" <?php if ($checkKapasitasNonProPas1 > 0) {echo 'checked';}?> onclick="FuncNoProPemohon3()">
											<input type="hidden" name="nonpro_spt_pasangan_ck1" id="nonpro_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nonpro_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasNonProPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?> >TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									
									
								
									
								</table>
							</div>								
						</div>
	
						
						
					</div>
					</div>
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<input type="hidden" name="cust_model_nonpro_hide" id="cust_model_nonpro_hide"  value="nonprofesional">
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['PASANGAN_BANK_BRANCH'];?>"  id="nonpro_pasangan_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pasangan_norek" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NO'];?>"  id="nonpro_pasangan_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pasangan_rekening" class="form-control" value="<?php echo $dataBank['PASANGAN_ACC_NAME'];?>"  id="nonpro_pasangan_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="nonpro_pasangan_mutasi" class="form-control" readonly>
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasNonProPasangan ['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir" <?php if ($dataKapasitasNonProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "1 Bulan Terakhir" ) {echo 'selected';}?> >1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir" <?php if ($dataKapasitasNonProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "2 Bulan Terakhir" ) {echo 'selected';}?>>2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir" <?php if ($dataKapasitasNonProPasangan['MUTASI_YANG_DILAMPIRKAN'] == "3 Bulan Terakhir" ) {echo 'selected';}?> >3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_nonpro_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
									<tr>
												<td >Validasi Bukti TF SBH </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_SBH(?,?,?)}";
													$paramImgNonProBankPas =  array(array($prospect, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankPas = sqlsrv_query( $conn, $callImgNonProBankPas, $paramImgNonProBankPas) or die( print_r( sqlsrv_defaults(), true)); 
													$dataImgNonProBankPas = sqlsrv_fetch_array($execImgNonProBankPas);
													$ImgNonProBankPas = $dataImgNonProBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBankPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
										<tr>
										<td >Upload Bukti Validasi Jika Diperlukan
										</td>
												<td colspan="2" >
													<input type="file" name="img_tf_nonpro_pasangan"  style="margin-bottom:5px;" />
													
												</td>
									</tr>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiNonProPasangan">
                    
               
								     </div>
									 
									 
								
							</div>
					</div>	
					
					</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Analisa Pendapatan Pasangan</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td style="width:30%";>
										Tanggal Penerimaan Gaji (Karyawan)   :
										</td>
											<td> 
												<input type="text" class="form-control" name="tgl_penerimaan_gaji_pasangan" id="tgl_penerimaan_gaji_pasangan" autocomplete="off" value=" <?php if($dataKapasitasKry['PENERIMAAN_GAJI']<>NULL){echo $dataKapasitasKry['PENERIMAAN_GAJI']->format('Y-m-d');}else{echo"";}?>" readonly>
												
										
										
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CMO
										</td>
											<td> <input type="text" name="inputan_cmo_pasangan" id="inputan_cmo_pasangan" class="form-control" value="<?php echo number_format($dataTagging['PENGHASILAN_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Hasil Inputan CRA
										</td>
											<td> <input type="text" name="inputan_cra_pasangan" id="inputan_cra_pasangan" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Income Final SBH 
										</td>
											<td> <input type="text" name="inputan_ca_pasangan" id="inputan_ca_pasangan" class="form-control" value="<?php echo number_format($dataAnalis['PENDAPATAN_PASANGAN_RAK'],0,',','.'); ?>"   readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%";>
										Nominal Income Final CA
										</td>
											<td> <input type="text" name="inputan_bm_pasangan3" id="inputan_bm_pasangan3" class="form-control" value=""   >
										</td>
									</tr>
									
								
								</table>
							</div>		
							<div id="historical_kredit_nonpro_pasangan" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pasangan-nonpro" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif pasangan
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pasangan-nonpro"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
				
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){										
									$callPasanganScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								
								}else{
									$callPasanganScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								}		
									
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					
				
					
					</div>
				<!-- -->	
					
					
						<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30px"><p><input type="checkbox" name="check_kapasitas" required oninvalid="this.setCustomValidity('Wajib Centang')"
	 								oninput="setCustomValidity('')">	
										</td>
										<td>
											<b>Pastikan semua Document Identitas Telah Terpenuhi, dan Valid sesuai Regulasi Yang berlaku<b>

											
										</td>
									</tr>
									
									
								</table>
							</div>
						
					
					
					<div id="historical_kredit" style="display:none">	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pasangan-other" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif pasangan
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pasangan-other"></div>
					
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
					</div>	
					<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>
					
					<!-- Tombol utama -->
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-kry" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-kry"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){										
									$callPasanganScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								
								}else{
									$callPasanganScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPasanganScore = sqlsrv_query( $conn, $callPasanganScore, $paramPasanganScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
									
								}		
									
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Data Other Income</td>
									</tr>
								</table>
							</div>
							<div class="row">
								<div class="col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table table-bordered">

											<?php
											$pendapatanlain = isset($dataOtherIncomeData['PENDAPATAN_BULAN']) ? $dataOtherIncomeData['PENDAPATAN_BULAN'] : '';
											$custModel = isset($dataOtherIncomeData['CUST_MODEL']) ? $dataOtherIncomeData['CUST_MODEL'] : '';
											$labelOtherIncome = 'Pemohon';
											if (!empty($dataOtherIncomeData['PENGHASILAN_LAIN'])) {
												$penghasilanLain = strtolower($dataOtherIncomeData['PENGHASILAN_LAIN']);
												$cust = strtoupper(trim($custModel));

												if ($penghasilanLain === 'pasangan') {
													$labelOtherIncome = 'Pasangan';
												} elseif ($penghasilanLain === 'pemohon') {
													if (in_array($cust, ['EMP', 'PROF'])) {
														$labelOtherIncome = 'Pemohon';
													} elseif ($cust === 'SME') {
														$labelOtherIncome = 'Pemohon';
													} elseif ($cust === 'SMEBU') {
														$labelOtherIncome = 'Pemohon';
													} else {
														$labelOtherIncome = 'Pemohon';
													}
												}
											}
											?>
											<tr id="row_other_income" style="<?= empty($totalIncome) ?  : '' ?>">
												<td style="width:30%;" id="label_other_income">
													Total Other Income <?= htmlspecialchars($labelOtherIncome) ?>
												</td>
												<td>
													<input type="text" class="form-control" 
														id="pendapatan_lain_cf" 
														name="pendapatan_lain_cf" 
														value="<?php echo number_format($pendapatanlain, 0, ',', '.') ?>"
														readonly>
												</td>
												<td>
													<input type="hidden" class="form-control" 
														id="isOtherIncome" 
														name="isOtherIncome" 
														value="<?= htmlspecialchars($dataOtherIncomeData['PENGHASILAN_LAIN']) ?>">
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>	
					</div>

					
					<?php if($type_kendaraan == '15'){ 
					
						$callRakCheck= "{call SP_CUT_OFF_RAK_POLICY_CREDIT(?)}";
						$paramRakCheck =  array(array($prospect, SQLSRV_PARAM_IN));
						$execRakCheck = sqlsrv_query( $conn, $callRakCheck, $paramRakCheck) or die( print_r( sqlsrv_defaults(), true)); 
						$dataRakCheck = sqlsrv_fetch_array($execRakCheck);
						
						if($dataRakCheck['RAK'] == 'NEW'){
					?>
						<!-- new -->
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Historikal Kredit Eksternal</td>
									</tr>
									
									
								</table>
							</div>
							
					
					
						
						
						
					<?php
											
											$callPkt = "{call SP_GET_PROXY_INCOME_MOS_PAKET_OUTPUT(?)}";
											$paramPkt =  array(array($prospect, SQLSRV_PARAM_IN));
											$execPkt = sqlsrv_query($conn, $callPkt, $paramPkt) or die(print_r(sqlsrv_defaults(), true));
											$dataPkt = sqlsrv_fetch_array($execPkt);
											
											$callCRisk = "{call SP_CREATE_SCORING_CREDIT_RISK(?,?)}";
											$paramCRisk =  array(array($prospect, SQLSRV_PARAM_IN),
															   array($user, SQLSRV_PARAM_IN));
											$execCRisk = sqlsrv_query($conn, $callCRisk, $paramCRisk) or die(print_r(sqlsrv_defaults(), true));
											
											$callGRisk = "{call SP_GET_SCORING_CREDIT_RISK(?)}";
											$paramGRisk =  array(array($prospect, SQLSRV_PARAM_IN));
											$execGRisk = sqlsrv_query($conn, $callGRisk, $paramGRisk) or die(print_r(sqlsrv_defaults(), true));
											$dataGRisk = sqlsrv_fetch_array($execGRisk);
											

											
												
											?>


											<table id="datatable2" class="table table-bordered" style="width:100%">
												<thead>
													<tr>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">PROXY INCOME</th>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">SEGMENTASI</th>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS COLLECTIBILITY</th>
														<?php if ($dataPkt['MATRIKS_VERS'] == 'NEW') { ?>
															<th class="th-custom" style="color:#FFF;font-weight:bold;">PAKET</th>
															<th class="th-custom" style="color:#FFF;font-weight:bold;">PAKET AWAL</th>
														<?php } ?>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">SCORE CARD SCORE</th>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">SCORE CARD LEVEL</th>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">SCORE RESULT</th>
														<th class="th-custom" style="color:#FFF;font-weight:bold;">QUALIFIED RATE</th>

													</tr>
												</thead>
												<tbody>
													<?php


													//$callProxy1= "{call SP_GET_PROXY_LEVEL_RAK(?)}";
													//$paramProxy1 =  array(array($app_no, SQLSRV_PARAM_IN));					
													$callProxy1 = "{call SP_GET_NEW_MATRIKS_RAK(?)}";
													$paramProxy1 =  array(array($prospect, SQLSRV_PARAM_IN));
													$execProxy1 = sqlsrv_query($conn, $callProxy1, $paramProxy1) or die(print_r(sqlsrv_defaults(), true));
													$dataProxy1 = sqlsrv_fetch_array($execProxy1);

													$callSC = "{call SP_GET_RESULT_SCORE_CARD(?)}";
													$paramSC =  array(array($prospect, SQLSRV_PARAM_IN));
													$execSC = sqlsrv_query($conn, $callSC, $paramSC) or die(print_r(sqlsrv_defaults(), true));
													$dataSC = sqlsrv_fetch_array($execSC);
													
													
													if($dataGRisk['NEW_DATA'] == 'NO'){
														$scScore= $dataSC['TOTAL_SCORE'];
														$scRating= $dataSC['RATING_DESC'];
														$scResult= '-';
													}else{
														$scScore= $dataGRisk['TOTAL_SCORE'];
														$scRating= $dataGRisk['RANGE_SCORE'];
														$scResult= $dataGRisk['SCORE_RESULT'];
													}


													//echo $percent;
													?>
													<tr>
														<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['Status_Proxy_income']; ?></td>

														<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['SEGMENTATION']; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $dataPkt['STATUS_COL']; ?></td>
														<?php if ($dataPkt['MATRIKS_VERS'] == 'NEW') { ?>
															<td class="td-custom" style="padding:5px;"><?php echo $dataPkt['PAKET']; ?></td>
															<td class="td-custom" style="padding:5px;"><?php echo $dataPkt['PAKET_AWAL']; ?></td>
														<?php } ?>
														<td class="td-custom" style="padding:5px;"><?php echo $scScore; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $scRating; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $scResult; ?></td>
														<td class="td-custom" style="padding:5px;"><?php echo $dataSC['RATE_DESC']; ?></td>
														<input type="hidden" name="tdp_score" class="form-control" value="<?php echo $dataCust['TDP_PERCENT']; ?>" id="tdp_score" readonly>
														<input type="hidden" name="prox_level" class="form-control" value="<?php echo $dataProxy1['STATUS_LEVEL']; ?>" id="prox_level" readonly>
														<input type="hidden" name="segmentasi" class="form-control" value="<?php echo $dataProxy1['SEGMENTATION']; ?>" id="segmentasi" readonly>
														<input type="hidden" name="stat_col" class="form-control" value="<?php echo $dataProxy1['STATUS_COLLECTIBILITY']; ?>" id="stat_col" readonly>
														<input type="hidden" name="desc_score" class="form-control" value="<?php echo $dataProxy1['Score_Desc']; ?>" id="desc_score" readonly>
														<input type="hidden" name="paket" class="form-control" value="<?php echo $dataPkt['PAKET']; ?>" id="paket" readonly>


													</tr>

												</tbody>
											</table>
											
<hr> <?php if($dataGRisk['NEW_DATA'] <> 'NO'){ ?> 
											<div class="notice"> <?php if ($dataGRisk['KONDISI'] == 1) { ?>
											⚠️ <strong>Perhatian:</strong>
											  <br> Berdasarkan data golive tahun 2018 hingga closing bulan sebelumnya (M-1), secara Nasional debitur dengan profil tersebut memiliki history nilai Loss dengan WO sebesar <?php echo $dataGRisk['WO_AMT_NASIONAL']; ?> dan LOR sebesar <?php echo $dataGRisk['REPO_AMT_NASIONAL']; ?>, sedangkan pada cabang ini history nilai WO sebesar <?php echo $dataGRisk['WO_AMT_BRANCH']; ?> dan LOR sebesar <?php echo $dataGRisk['REPO_AMT_BRANCH']; ?>. <?php } else if ($dataGRisk['KONDISI'] == 2) { ?> ⚠️ <strong>Perhatian:</strong>
											  <br> Berdasarkan data golive tahun 2018 hingga closing bulan sebelumnya (M-1), secara Nasional debitur dengan profil tersebut memiliki history nilai Loss dengan WO sebesar <?php echo $dataGRisk['WO_AMT_NASIONAL']; ?> dan LOR sebesar <?php echo $dataGRisk['REPO_AMT_NASIONAL']; ?>, sedangkan pada cabang ini tidak ditemukan history data terkait profil yang diajukan. <?php } else if ($dataGRisk['KONDISI'] == 3) { ?> ⚠️ <strong>Perhatian:</strong>
											  <br> Data profil yang diajukan belum memiliki history loss di cabang ini maupun secara Nasional. <?php } ?>
											</div> <?php } ?>
											
						<div class="table-responsive">
								<table class="table ">
									<tr>
										<td style="width:30%;"><b>TDP </b> : </td>
										<td style="width:50%;">
											<input type="text" name="desc_score" class="form-control"  value="<?php echo $dataCust['TDP_PERCENT']; ?>" id="tdp" readonly>
											<!--<input type="text" name="desc_score" class="form-control"  value="20" id="tdp" readonly>-->
										</td>
									</tr>
									
									<?php
									/*
									$callProxy= "{call SP_GET_MATRIX_RAK(?,?,?,?,?)}";
									$paramProxy =  array(array($app_no, SQLSRV_PARAM_IN),
														 array($dataCust['TDP_PERCENT'], SQLSRV_PARAM_IN),
														 array($branchid, SQLSRV_PARAM_IN),
														 array($dataCust['PH_AKUMULASI'], SQLSRV_PARAM_IN),
														 array($dataCust['SCHEME_ID'], SQLSRV_PARAM_IN));
														 
									$execProxy = sqlsrv_query( $conn, $callProxy, $paramProxy) or die( print_r( sqlsrv_defaults(), true)); 
									$dataProxy = sqlsrv_fetch_array($execProxy);
									*/
									
									$callProxy= "{call SP_GET_LOA_NEW_MATRIK_RAK_NEW_V1(?,?,?,?,?,?,?,?,?,?,?)}";
									$paramProxy =  array(array($prospect, SQLSRV_PARAM_IN),
														 array($dataCust['TDP_PERCENT'], SQLSRV_PARAM_IN),
														//array(20, SQLSRV_PARAM_IN),
														 array($branchid, SQLSRV_PARAM_IN),
														 array($dataProxy1['STATUS_COLLECTIBILITY'], SQLSRV_PARAM_IN),
														 array($dataProxy1['SEGMENTATION'], SQLSRV_PARAM_IN),
														 array($dataProxy1['TIPE_PRODUK'], SQLSRV_PARAM_IN),
														 array($dataCust['PRODUCT_ID'], SQLSRV_PARAM_IN),
														 array($dataCust['DEALER_NAME'], SQLSRV_PARAM_IN),
														 array($dataProxy1['STATUS_LEVEL'], SQLSRV_PARAM_IN),
														 array($dataProxy1['DANATUNAI'], SQLSRV_PARAM_IN),
														 array($dataCust['PH_SELURUH'], SQLSRV_PARAM_IN));
														 
									$execProxy = sqlsrv_query( $conn, $callProxy, $paramProxy) or die( print_r( sqlsrv_errors(), true)); 
									$dataProxy = sqlsrv_fetch_array($execProxy);
									?>
									<tr>
										<td style="width:30%;"><b>MIN TDP </b> : </td>
										<td style="width:50%;">
											<!-- <input type="text" name="desc_score" class="form-control"  value="<?php// echo $dataCust['TDP_PERCENT']; ?>" id="tdp" readonly>-->
											<input type="text" name="desc_score" class="form-control"  value="<?php echo $dataProxy['MIN_TDP'];?>" id="tdp" readonly>
										</td>
									</tr>
									
									<tr>
										<td style="width:30%;"><b>LEVEL APPROVAL</b> : </td>
										<td style="width:50%;">
											<input type="text" name="final_approval" class="form-control"  value="<?php echo $dataProxy['ROLE_CODE'];?>"  id="final_approval" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%;"><b>LANJUT APPROVAL / TIDAK</b> : </td>
										<td style="width:50%;">
											<input type="text" name="keputusan" class="form-control"  value="<?php echo $dataProxy['APPROVAL'];?>"  id="keputusan" readonly>
										</td>
									</tr>
									<hr>
									
									
								</table>
							</div>	
								
							</div>
							
							
							<br>
							<br>
					</div>		
					
						<?php }else{ ?>
				
					
					<!-- old -->
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Historikal Kredit Eksternal</td>
									</tr>
									
									
								</table>
							</div>
							
					
					
						
						
						
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">PROXY INCOME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS LEVEL</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
														
									$callProxy1= "{call SP_GET_PROXY_LEVEL_RAK(?)}";
									$paramProxy1 =  array(array($prospect, SQLSRV_PARAM_IN));
									$execProxy1 = sqlsrv_query( $conn, $callProxy1, $paramProxy1) or die( print_r( sqlsrv_defaults(), true)); 
									$dataProxy1 = sqlsrv_fetch_array($execProxy1);
									
							
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['Status_Proxy_income']; ?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['STATUS_LEVEL'];?></td>
										<input type="hidden" name="tdp_score" class="form-control"  value="<?php echo $dataCust['TDP_PERCENT']; ?>" id="tdp_score" readonly>
										<input type="hidden" name="prox_level" class="form-control"  value="<?php echo $dataProxy1['STATUS_LEVEL']; ?>" id="prox_level" readonly>
									</tr>
									
								</tbody>
							</table>
						<div class="table-responsive">
								<table class="table ">
									<tr>
										<td style="width:30%;"><b>TDP </b> : </td>
										<td style="width:50%;">
											<input type="text" name="desc_score" class="form-control"  value="<?php echo $dataCust['TDP_PERCENT']; ?>" id="tdp" readonly>
										</td>
									</tr>
									
									<?php
									$callProxy= "{call SP_GET_MATRIX_RAK(?,?,?,?,?)}";
									$paramProxy =  array(array($prospect, SQLSRV_PARAM_IN),
														 array($dataCust['TDP_PERCENT'], SQLSRV_PARAM_IN),
														 array($branchid, SQLSRV_PARAM_IN),
														 array($dataCust['PH_AKUMULASI'], SQLSRV_PARAM_IN),
														 array($dataCust['SCHEME_ID'], SQLSRV_PARAM_IN));
														 
									$execProxy = sqlsrv_query( $conn, $callProxy, $paramProxy) or die( print_r( sqlsrv_defaults(), true)); 
									$dataProxy = sqlsrv_fetch_array($execProxy);
									?>
									
									<tr>
										<td style="width:30%;"><b>LEVEL APPROVAL</b> : </td>
										<td style="width:50%;">
											<input type="text" name="final_approval" class="form-control"  value="<?php echo $dataProxy['ROLE_CODE'];?>"  id="final_approval" readonly>
										</td>
									</tr>
									<hr>
									
									
								</table>
							</div>	
								
							</div>
							<?php 
							IF($dataProxy1['STATUS_LEVEL'] == 'LEVEL 6' && $dataCust['TDP_PERCENT'] <'25'){ 
							$callDacor = "{call SP_GET_AFA_DACOR_RAK_TDP(?)}";
							$paramDacor =  array(array($prospect, SQLSRV_PARAM_IN));
							$execDacor = sqlsrv_query( $conn, $callDacor, $paramDacor) or die( print_r( sqlsrv_defaults(), true)); 
							$dataDacor = sqlsrv_fetch_array($execDacor);
							
							if($dataDacor['DACOR'] == 'TIDAK'){
							
							?>
								<span style="color:red">&nbsp &nbsp  * Aplikasi Tidak bisa di submit dikarenakan Level 6 dan TDP dibawah 25%
							</span>
							<?php }else{ ?>
							
							<span style="color:red">&nbsp &nbsp  * Aplikasi Menggunakan AFA DEVIASI
							</span>

							<?php } }
	
							?>
							<br>
							<br>
					</div>	
					<?php }
						} ?>	
					
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><B>Summary</B></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<?php

									if($dataDp['UP_DP'] == 'YA'){

										?>

								
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
								<tr>
										<td>OTR</td>
										<td><input type="text" name="otr_cal" class="form-control" value="<?php echo number_format($dataCust['OTR'],0,',','.');?>"  id="otr_cal" readonly ></td>
								</tr>
								<tr>
										<td>Amount TDP</td>
										<td><input type="text" name="amount_tdp_cal" class="form-control" value="<?php echo number_format($dataCust['TDP'],0,',','.');?>"  id="amount_tdp_cal" readonly ></td>
									</tr>
								
									<tr>
										<td >% TDP</td>
										<td >
											<input type="text" name="tdp_persen_view" id="tdp_persen_view"  value="<?php echo $dataCust['TDP_PERCENT']; ?>"%  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>	
									
									<tr>
										<td >UP DP</td>
										<td >
										<select name="up_dp_cal"  id="up_dp_cal"  class="form-control" onchange="dpFunction()">
														<option value="">--Pilih--</option>
														<option value="YA">YA</option>
														<option value="TIDAK">TIDAK</option>
													
											</select>     
										</td>
									</tr>	
									
										
								
								</table>
							</div>
					</div>
					</div>

					<div id="div_dp" class="row" style="display:none;">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
								
										<tr>
											<td >Naik %TDP</td>
											<td >
												<input type="text" name="naik_tdp_persen_cal" id="naik_tdp_persen_cal" class="form-control" value="" >
											</td>
										</tr>

									<tr>
										<td>OTR</td>
										<td><input type="text" name="otr_cal" class="form-control" value="<?php echo number_format($dataCust['OTR'],0,',','.');?>"  id="otr_cal" readonly ></td>
										</tr>
									<tr>
										<td>Amount TDP</td>
										<td><input type="text" name="naik_amount_tdp_cal" class="form-control" value=""  id="naik_amount_tdp_cal" readonly ></td>
									</tr>
									<tr>
									<td colspan="3" style="width:50%;">
											<input  type="button" name="cal_dp" id="cal_dp" class="btn btn-custom" value="Calculate" style="width:200px;" >
											
										</td>
									</tr>	
								</table>
							</div>
					</div>
					</div>
					<?php }else{ ?>
								<input type="hidden" name="up_dp_cal" id="up_dp_cal"  value="">

							<?php } ?>
					
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td>Pendapatan Pemohon (Confins)</td>
										<td><input type="text" name="pendapatan_pemohon_cf" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"  id="pendapatan_pemohon_cf" readonly ></td>
									</tr>
									<tr>
										<td>Pendapatan Pasangan (Confins)</td>
										<td><input type="text" name="pendapatan_pasangan_cf" class="form-control" value="<?php echo number_format($dataBank['GAJI_PASANGAN'],0,',','.'); ?>"  id="pendapatan_pasangan_cf" readonly ></td>
									</tr>
									<tr>
										<td>Total Pendapatan (Confins)</td>
										<td><input type="text" name="pendapatan_total" class="form-control" value="<?php echo number_format($total_pendaptan_cra,0,',','.'); ?>"  id="pendapatan_total" readonly ></td>
									</tr>
									<?php if($dataCust['FLEET_STATUS'] == 'YA'){ ?>
									<tr>
									<td>Angsuran NEW SFI</td>
										<td><input type="text" name="angsuran_new_fleet" class="form-control" value="<?php echo number_format($dataCust['ANGSURAN_MOS1'],0,',','.'); ?>"  id="angsuran_new_fleet" readonly ></td>
									</tr>
									<tr>
									<td>Angsuran NEW SFI Fleet <?php echo $dataCust['FLEET_COUNT'];?> Unit</td>
										<td><input type="text" name="angsuran_new" class="form-control" value="<?php echo number_format($dataCust['ANGSURAN'],0,',','.'); ?>"  id="angsuran_new" readonly ></td>
									</tr>
									
									<?php }else{ ?>
									<tr>
									<td>Angsuran NEW SFI </td>
										<td><input type="text" name="angsuran_new" class="form-control" value="<?php echo number_format($dataCust['ANGSURAN'],0,',','.'); ?>"  id="angsuran_new" readonly ></td>
									</tr>
									<?php } ?>
									
									<tr>
										<td>Angsuran Berjalan SFI</td>
										<td><input type="text" name="angsuran_berjalan" class="form-control" value="<?php echo number_format($dataCust['ANGSURAN_AO'],0,',','.'); ?>"  id="angsuran_berjalan" readonly ></td>
									</tr>
									<tr>
									<input type="hidden" name="kewajiban_tempatlain_pemohon_hide" id="kewajiban_tempatlain_pemohon_hide"  value="<?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.') ;?>">
									<input type="hidden" name="kewajiban_tempatlain_pasangan_hide" id="kewajiban_tempatlain_pasangan_hide"  value="<?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'],0,',','.') ;?>">
										<td>Kewajiban di tempat lain</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value=""  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									<tr>
										<td>Total Kewajiban</td>
										<td><input type="text" name="total_kewajiban" class="form-control" value=""  id="total_kewajiban" readonly></td>
										
									</tr>
									<tr>
										<td>Total Pendapatan</td>
										<td><input type="text" name="total_pendapatan" class="form-control" value=""  id="total_pendapatan" readonly></td>
										
									</tr>
									<tr>
										<td>DSR %</td>
										<td><input type="text" name="dsr" class="form-control" value="<?php // echo $dataDsr['TOTAL_DSR'];?>"  id="dsr" readonly></td>
										
										
									</tr>
									<tr>
										<td>Foto Survey</td>
										<td>
										<?php 
										if($branchid =="1006" && $branchid =="1005" && $branchid =="1066" && $branchid =="1011" &&
											$branchid =="1026" && $branchid =="1034" && $branchid =="1045" && $branchid =="1056" &&
											$branchid =="1064" && $branchid =="1080" &&	$branchid =="1501" && $branchid =="1502" &&
											$branchid =="1506" && $branchid =="1507" && $branchid =="1512" && $branchid =="1516" &&
											$branchid =="1518" && $branchid =="1524" && $branchid =="1543" && $branchid =="1548" ||
											$dataSvy['MOS_STAT'] == "NEW" ){
								?>
									<a class="btn btn-warning btn-xs" style="width:100px;height:50px;"href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $dataSvy['ORDER_NO'];?>" target="_blank"
											>Foto Survey</a>
												<a class="btn btn-warning btn-xs" style="width:150px;height:50px;"href="https://sfimos.sfi.co.id/mos_new/frame/surveyor_ext_view_rak/<?php echo $dataSvy['ORDER_NO'];?>" target="_blank"
											>Surveyor Eksternal</a>
										<?php }else{ ?>
								
										<a class="btn btn-warning btn-xs" style="width:100px;height:50px;"href="https://mos.sfi.co.id/mobile_survey/View_cust/Data1/<?php echo $dataSvy['TASK_ID'];?>" target="_blank"
											>Foto Survey</a>
										<?php } ?>
										</td>
										
									</tr>
									<tr>
									<td colspan="3" style="width:50%;">
											<input  type="button" name="cal_dsr" id="cal_dsr" class="btn btn-custom" value="Calculate" style="width:200px;" >
											
										</td>
									</tr>
									
									
									
								</table>
								<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
									<td>NOTE SBH : </td>
										<td><input type="text" name="note_rak_ca" class="form-control" value="<?php echo $dataHasilRak['NOTE']; ?>"  id="note_rak_ca" readonly></td>
								
									</tr>
									
									<tr>
										<td>NOTE : </td>
										<td><input type="text" name="note_rak" class="form-control" value=""  id="note_rak" ></td>
									</tr>

									
									
								</table>
							</div>
						
					</div>	
					
					</div>
					
							</div>
							
							<?php $callRejRS = "{call SP_GET_STATUS_REJECT_RAK_REASON(?)}";
									$paramRejRS =  array(array($dataApv['APV_NO'], SQLSRV_PARAM_IN));
													 
									$execRejRS = sqlsrv_query( $conn, $callRejRS, $paramRejRS) or die( print_r( sqlsrv_defaults(), true)); 
									$dataRejRS = sqlsrv_fetch_array($execRejRS);

									if($dataRejRS['REJECT'] == 'YA'){

										?>
								<table class="table table-bordered">
			
									<tr>
										<td >Reject Reason</td>
										<td >
											<?php 
											$callReject = "{call SP_GET_REJECT_REASON_RAK}"; 
											$execReject = sqlsrv_query($conn, $callReject) or die( print_r( sqlsrv_errors(), true));
											
											?>
										<select name="rjc"  id="rjc"  class="form-control">

														<option value="">--Pilih--</option>
														<?php
														while($rowReject=sqlsrv_fetch_array($execReject)){
														?>
															<option value="<?php echo $rowReject['REJECT_REASON'];?>" >
															<?php echo $rowReject['REJECT_REASON'];?>
															</option>
														<?php
														}
														?>
												
									
											</select>     
										</td>
									</tr>	
									
										
								
								</table>
						<?php } ?>
							<input type="submit" name="submitNo" id="submitNo" class="btn btn-custom" value="TIDAK REKOMEN" style="width:200px;" >
							<?php 
							if($dataProxy['APPROVAL'] == 'YA'){ ?>
								
							<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" style="width:200px;" >
							<?php }else{ ?>
							<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" disabled style="width:200px;" >
							<?php 
							}
							?> 
							<input type="submit" name="submitReturn" id="submitReturn" class="btn btn-custom" value="RETURN" style="width:200px;" >
					</div>	
					
					</div>
					</form>
				 </div>
				</div>
			</div>
			</DIV>	
			</DIV>	
			</DIV>
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
                           <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">APPROVAL NO</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">LEVEL</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">JABATAN</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">USERNAME</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                                       <th class="th-custom" style="color:#FFF;font-weight:bold;">NOTES</th>
									   <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL APPROVE</th>
                                    
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
										/*
										$callApv = "{call SP_APPROVAL_GETLIST_APV_NO_RAK(?)}";
										$paramApv =  array(array($prospect, SQLSRV_PARAM_IN));
										$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_errors(), true));
										$dataApv= sqlsrv_fetch_array($execApv);
										*/
                                       $no=0;
                                       $callLoa = "{call  SP_APPROVAL_GETLIST_LOA_RAK(?)}";
                                       $paramLoa = array(array($dataApv['APV_NO'], SQLSRV_PARAM_IN));
                                       $execLoa = sqlsrv_query( $conn, $callLoa, $paramLoa) or die( print_r( sqlsrv_errors(), true)); 
                                       while($dataLoa = sqlsrv_fetch_array($execLoa)){
                                           $no++;
                                   ?> 
                                   <tr>
                                       
                                       <td class="td-center"><?php echo $no;?></td>
                                       <td class="td-center"><?php echo $dataLoa['APV_NO']?></td>
                                       <td class="td-center"><?php echo $dataLoa['LEVEL']?></td>
                                       <td class="td-center"><?php echo $dataLoa['ROLE_CODE']?></td>
                                       <td class="td-center"><?php echo $dataLoa['USERNAME']?></td>
                                       <td class="td-center"><?php echo $dataLoa['STATUS']?></td>
                                       <td class="td-center"><?php echo $dataLoa['NOTES'];?></td>
									   <td class="td-center"><?php if($dataLoa['UPDATE_DATE']<>NULL){echo $dataLoa['UPDATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
									   
									   
                                        
                                   </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
							   
                           </table>
						 
					
						</div>
</DIV>
</DIV>						
</DIV>	
</DIV>	
						
<script src="assets/js/jqueryrotate.min.js"></script>	
<script> 

function dpFunction() {
	
	var div_dp = document.getElementById("div_dp");


   var up_dp_cal =  $("#up_dp_cal").val();

  

  if ( up_dp_cal == "YA") {
	$('#naik_tdp_persen_cal').keyup(function(){
  if ($(this).val() > 100){
    alert("DP Tidak Boleh Lebih Dari 100");
    $(this).val('');
  }
});
	div_dp.style.display = "flex";
  }else{
	div_dp.style.display = "none";
  }
}

function myFunction() {
  var r = document.getElementById("kry_pasangan_div");
  var x = document.getElementById("wrs_pasangan_div");
  var t = document.getElementById("pro_pasangan_div");
  var u = document.getElementById("nonpro_pasangan_div");
  var history = document.getElementById("historical_kredit");
  var history_kry_pemohon = document.getElementById("historical_kredit_kry_pemohon");
  var history_wrs_pemohon = document.getElementById("historical_kredit_wrs_pemohon");
  var history_pro_pemohon = document.getElementById("historical_kredit_pro_pemohon");
  var history_nonpro_pemohon = document.getElementById("historical_kredit_nonpro_pemohon");
  
   var history_kry_pasangan = document.getElementById("historical_kredit_kry_pasangan");
  var history_wrs_pasangan = document.getElementById("historical_kredit_wrs_pasangan");
  var history_pro_pasangan = document.getElementById("historical_kredit_pro_pasangan");
  var history_nonpro_pasangan = document.getElementById("historical_kredit_nonpro_pasangan");
  
  
  var join_pasangan = document.getElementById("cust_model_pasangan_div");
  var pasangan =  $("#cust_model_pasangan").val();

   var join_income =  $("#join_income").val();
 
  
  if ( join_income == "YA" && pasangan == "WIRASWASTA") {
    x.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("inputan_bm_pasangan1").required = true;
	 //history_wrs_pemohon.style.display = "block";
	 
var wrs_nominal_pasangan = document.getElementById('wrs_nominal_pasangan');

wrs_nominal_pasangan.addEventListener('keyup',function(e){
  	 		wrs_nominal_pasangan.value = formatRupiah(this.value);
  	 	});
		
var wrs_total_pasangan = document.getElementById('wrs_total_pasangan');

wrs_total_pasangan.addEventListener('keyup',function(e){
  	 		wrs_total_pasangan.value = formatRupiah(this.value);
  	 	});


var wrs_pasangan_saldoAwal = document.getElementById('wrs_pasangan_saldoAwal');

wrs_pasangan_saldoAwal.addEventListener('keyup',function(e){
  	 		wrs_pasangan_saldoAwal.value = formatRupiah(this.value);
  	 	});

var wrs_pasangan_mutasi_kredit = document.getElementById('wrs_pasangan_mutasi_kredit');

wrs_pasangan_mutasi_kredit.addEventListener('keyup',function(e){
  	 		wrs_pasangan_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var wrs_pasangan_mutasi_debit = document.getElementById('wrs_pasangan_mutasi_debit');

wrs_pasangan_mutasi_debit.addEventListener('keyup',function(e){
  	 		wrs_pasangan_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var wrs_pasangan_saldo = document.getElementById('wrs_pasangan_saldo');

wrs_pasangan_saldo.addEventListener('keyup',function(e){
  	 		wrs_pasangan_saldo.value = formatRupiah(this.value);
  	 	});
		

var margin_pendapatan_wrs_pasangan = document.getElementById('margin_pendapatan_wrs_pasangan');

margin_pendapatan_wrs_pasangan.addEventListener('keyup',function(e){
  	 		margin_pendapatan_wrs_pasangan.value = formatRupiah(this.value);
  	 	});
				
var biaya_opr_wrs_pasangan = document.getElementById('biaya_opr_wrs_pasangan');

biaya_opr_wrs_pasangan.addEventListener('keyup',function(e){
  	 		biaya_opr_wrs_pasangan.value = formatRupiah(this.value);
  	 	});

var final_ca_wrs_pasangan = document.getElementById('final_ca_wrs_pasangan');

final_ca_wrs_pasangan.addEventListener('keyup',function(e){
  	 		final_ca_wrs_pasangan.value = formatRupiah(this.value);
  	 	});
				
	
  }else if ( join_income == "YA" && pasangan == "KARYAWAN") {
    r.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("inputan_bm_pasangan").required = true;
     //history_kry_pemohon.style.display = "block";
	 
var kry_saldoAwal_pasangan = document.getElementById('kry_saldoAwal_pasangan');

kry_saldoAwal_pasangan.addEventListener('keyup',function(e){
  	 		kry_saldoAwal_pasangan.value = formatRupiah(this.value);
  	 	});

var kry_mutasi_kredit_pasangan = document.getElementById('kry_mutasi_kredit_pasangan');

kry_mutasi_kredit_pasangan.addEventListener('keyup',function(e){
  	 		kry_mutasi_kredit_pasangan.value = formatRupiah(this.value);
  	 	});
		

var kry_mutasi_debit = document.getElementById('kry_mutasi_debit_pasangan');

kry_mutasi_debit_pasangan.addEventListener('keyup',function(e){
  	 		kry_mutasi_debit_pasangan.value = formatRupiah(this.value);
  	 	});
		

var kry_saldo_pasangan = document.getElementById('kry_saldo_pasangan');

kry_saldo_pasangan.addEventListener('keyup',function(e){
  	 		kry_saldo_pasangan.value = formatRupiah(this.value);
  	 	});
				

		
var besaran_nominal_pasangan = document.getElementById('besaran_nominal_pasangan');

besaran_nominal_pasangan.addEventListener('keyup',function(e){
  	 		besaran_nominal_pasangan.value = formatRupiah(this.value);
  	 	});
		
var nominal_pasangan_rak = document.getElementById('nominal_pasangan_rak');

nominal_pasangan_rak.addEventListener('keyup',function(e){
  	 		nominal_pasangan_rak.value = formatRupiah(this.value);
  	 	});
		
var final_ca_kry_pasangan = document.getElementById('final_ca_kry_pasangan');

final_ca_kry_pasangan.addEventListener('keyup',function(e){
  	 		final_ca_kry_pasangan.value = formatRupiah(this.value);
  	 	});
				
  }else if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
    t.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("inputan_bm_pasangan2").required = true;
	// history_pro_pemohon.style.display = "block";


var pro_pasangan_saldoAwal = document.getElementById('pro_pasangan_saldoAwal');

pro_pasangan_saldoAwal.addEventListener('keyup',function(e){
  	 		pro_pasangan_saldoAwal.value = formatRupiah(this.value);
  	 	});

var pro_pasangan_mutasi_kredit = document.getElementById('pro_pasangan_mutasi_kredit');

pro_pasangan_mutasi_kredit.addEventListener('keyup',function(e){
  	 		pro_pasangan_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var pro_pasangan_mutasi_debit = document.getElementById('pro_pasangan_mutasi_debit');

pro_pasangan_mutasi_debit.addEventListener('keyup',function(e){
  	 		pro_pasangan_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var pro_pasangan_saldo = document.getElementById('pro_pasangan_saldo');

pro_pasangan_saldo.addEventListener('keyup',function(e){
  	 		pro_pasangan_saldo.value = formatRupiah(this.value);
  	 	});
	
var final_ca_pro_pasangan = document.getElementById('final_ca_pro_pasangan');

final_ca_pro_pasangan.addEventListener('keyup',function(e){
  	 		final_ca_pro_pasangan.value = formatRupiah(this.value);
  	 	});
  }else if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
    u.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("inputan_bm_pasangan3").required = true;
	 // history_nonpro_pemohon.style.display = "block";
	 
var pro_pasangan_saldoAwal = document.getElementById('nonpro_pasangan_saldoAwal');

nonpro_pasangan_saldoAwal.addEventListener('keyup',function(e){
  	 		nonpro_pasangan_saldoAwal.value = formatRupiah(this.value);
  	 	});

var nonpro_pasangan_mutasi_kredit = document.getElementById('nonpro_pasangan_mutasi_kredit');

nonpro_pasangan_mutasi_kredit.addEventListener('keyup',function(e){
  	 		nonpro_pasangan_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var nonpro_pasangan_mutasi_debit = document.getElementById('nonpro_pasangan_mutasi_debit');

nonpro_pasangan_mutasi_debit.addEventListener('keyup',function(e){
  	 		nonpro_pasangan_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var nonpro_pasangan_saldo = document.getElementById('nonpro_pasangan_saldo');

nonpro_pasangan_saldo.addEventListener('keyup',function(e){
  	 		nonpro_pasangan_saldo.value = formatRupiah(this.value);
  	 	});
	
var final_ca_nonpro_pasangan = document.getElementById('final_ca_nonpro_pasangan');

final_ca_nonpro_pasangan.addEventListener('keyup',function(e){
  	 		final_ca_nonpro_pasangan.value = formatRupiah(this.value);
  	 	});
		
  }else{
    x.style.display = "none";
	r.style.display = "none";
	t.style.display = "none";
	u.style.display = "none";
	 join_pasangan.style.display ="none";
  }
  
  
   if ( join_income == "TIDAK" && pasangan == "WIRASWASTA") {
    history.style.display = "block";
	document.getElementById("inputan_bm_pasangan1").required = false;
	//history_wrs_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pasangan == "KARYAWAN") {
    history.style.display = "block";
	document.getElementById("inputan_bm_pasangan").required = false;
	//history_kry_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pasangan == "PROFESSIONAL") {
    history.style.display = "block";
	document.getElementById("inputan_bm_pasangan2").required = false;
	//history_pro_pemohon.style.display = "none";
	
  }else if ( join_income == "TIDAK" && pasangan == "NON PROFESSIONAL") {
   history.style.display = "block";
   document.getElementById("inputan_bm_pasangan3").required = false;
 //  history_nonpro_pemohon.style.display = "none";
   
  }else{
	  history.style.display = "none";

  }
  /*else{
   	history.style.display = "none";
    history_kry_pemohon.style.display = "block";
	history_wrs_pemohon.style.display = "block";
	history_pro_pemohon.style.display = "block";
    history_nonpro_pemohon.style.display = "block";
  }
 */
	if ( join_income == "TIDAK" && pemohon == "WIRASWASTA") {
    history.style.display = "block";
	history_wrs_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pemohon == "KARYAWAN") {
    history.style.display = "block";
	history_kry_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pemohon == "PROFESSIONAL") {
    history.style.display = "block";
	history_pro_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pemohon == "NON PROFESSIONAL") {
   history.style.display = "block";
   history_nonpro_pemohon.style.display = "none";
  }
  
  
 
 /*
   if ( join_income == "TIDAK") {
    history.style.display = "block";
	history_kry_pemohon.style.display = "none";
	history_wrs_pemohon.style.display = "none";
	history_pro_pemohon.style.display = "none";
    history_nonpro_pemohon.style.display = "none";
  }else{
	history.style.display = "none";
    history_kry_pemohon.style.display = "block";
	history_wrs_pemohon.style.display = "block";
	history_pro_pemohon.style.display = "block";
    history_nonpro_pemohon.style.display = "block";
	
  }*/
  
}

</script>
<!--<script> 
function myFunction() {
  var r = document.getElementById("kry_pasangan_div");
  var x = document.getElementById("wrs_pasangan_div");
  var t = document.getElementById("pro_pasangan_div");
  var u = document.getElementById("nonpro_pasangan_div");
  var history = document.getElementById("historical_kredit");
  var history_kry_pemohon = document.getElementById("historical_kredit_kry_pemohon");
  var history_wrs_pemohon = document.getElementById("historical_kredit_wrs_pemohon");
  var history_pro_pemohon = document.getElementById("historical_kredit_pro_pemohon");
  var history_nonpro_pemohon = document.getElementById("historical_kredit_nonpro_pemohon");
  
  var history_kry_pasangan = document.getElementById("historical_kredit_kry_pasangan");
  var history_wrs_pasangan = document.getElementById("historical_kredit_wrs_pasangan");
  var history_pro_pasangan = document.getElementById("historical_kredit_pro_pasangan");
  var history_nonpro_pasangan = document.getElementById("historical_kredit_nonpro_pasangan");
  
  var join_pasangan = document.getElementById("cust_model_pasangan_div");
  var pasangan =  $("#cust_model_pasangan").val();

   var join_income =  $("#join_income").val();
 
  
  if ( join_income == "YA" && pasangan == "WIRASWASTA") {
    x.style.display = "block";
	 join_pasangan.style.display = "block";
  }else if ( join_income == "YA" && pasangan == "KARYAWAN") {
    r.style.display = "block";
	 join_pasangan.style.display = "block";
  }else if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
    t.style.display = "block";
	 join_pasangan.style.display = "block";
  }else if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
    u.style.display = "block";
	 join_pasangan.style.display = "block";
  }else{
    x.style.display = "none";
	r.style.display = "none";
	t.style.display = "none";
	u.style.display = "none";
	 join_pasangan.style.display ="none";
  }
  
   if ( join_income == "TIDAK") {
    history.style.display = "block";
	history_kry_pemohon.style.display = "none";
	history_wrs_pemohon.style.display = "none";
	history_pro_pemohon.style.display = "none";
    history_nonpro_pemohon.style.display = "none";
  }else{
	history.style.display = "none";
    history_kry_pemohon.style.display = "block";
	history_wrs_pemohon.style.display = "block";
	history_pro_pemohon.style.display = "block";
    history_nonpro_pemohon.style.display = "block";
	
  }
}

</script>
-->
<script>


function myDevCk1() {
  var checkBox = document.getElementById("dev_usia");
  var text = document.getElementById("dev_usia1");
  
  if (checkBox.checked == true){
    text.value = "D0001";
  } else {
     text.value = "";
  }
}

function myDevCk2() {
  var checkBox = document.getElementById("dev_pas_ttd");
  var text = document.getElementById("dev_pas_ttd1");
  
  if (checkBox.checked == true){
    text.value = "D0002";
  } else {
     text.value = "";
  }
}

function myDevCk3() {
  var checkBox = document.getElementById("dev_pengkinian");
  var text = document.getElementById("dev_pengkinian1");
  
  if (checkBox.checked == true){
    text.value = "D0003";
  } else {
     text.value = "";
  }
}

function myDevCk6() {
  var checkBox = document.getElementById("dev_srv_kantor");
  var text = document.getElementById("dev_srv_kantor1");
  
  if (checkBox.checked == true){
    text.value = "D0006";
  } else {
     text.value = "";
  }
}

function myDevCk7() {
  var checkBox = document.getElementById("dev_negative");
  var text = document.getElementById("dev_negative1");
  
  if (checkBox.checked == true){
    text.value = "D0007";			
  } else {
     text.value = "";
  }
}
function myFunctionCk1() {
  var checkBox = document.getElementById("shm_ck");
  var text = document.getElementById("shm_ck1");
  
  if (checkBox.checked == true){
    text.value = "SHM";
  } else {
     text.value = "";
  }
}
function myFunctionCk2() {
  var checkBox = document.getElementById("akta_jual_beli_ck");
  var text = document.getElementById("akta_jual_beli_ck1");
  
  if (checkBox.checked == true){
    text.value = "AKTA JUAL BELI";
  } else {
     text.value = "";
  }
}
function myFunctionCk3() {
  var checkBox = document.getElementById("surat_girik_ck");
  var text = document.getElementById("surat_girik_ck1");
  
  if (checkBox.checked == true){
    text.value = "SURAT GIRIK";
  } else {
     text.value = "";
  }
}
function myFunctionCk4() {
  var checkBox = document.getElementById("pbb_ck");
  var text = document.getElementById("pbb_ck1");
  
  if (checkBox.checked == true){
    text.value = "PBB";
  } else {
     text.value = "";
  }
}
function myFunctionCk5() {
  var checkBox = document.getElementById("rek_listrik_ck");
  var text = document.getElementById("rek_listrik_ck1");
  
  if (checkBox.checked == true){
    text.value = "REK LISTRIK";
  } else {
     text.value = "";
  }
}
function myFunctionCk6() {
  var checkBox = document.getElementById("rek_air_ck");
  var text = document.getElementById("rek_air_ck1");
  
  if (checkBox.checked == true){
    text.value = "REK AIR";
  } else {
     text.value = "";
  }
}
function myFunctionCk7() {
  var checkBox = document.getElementById("skrd_ck");
  var text = document.getElementById("skrd_ck1");
  
  if (checkBox.checked == true){
    text.value = "SURAT KEPUTUSAN RUMAH DINAS";
  } else {
     text.value = "";
  }
}

</script>

<script>
  var join_pasangan = document.getElementById("cust_model_pasangan_div");
  var pemohon =  $("#cust_model_pemohon").val();
  var pasangan =  $("#cust_model_pasangan").val();
   var join_income =  $("#join_income").val();
 
  
  if (pemohon == "KARYAWAN") {
	  
function FuncKryPemohon1() {
  var checkBox = document.getElementById("slip_gaji_pemohon_ck");
  var text = document.getElementById("slip_gaji_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "SLIP GAJI";
  } else {
     text.value = "";
  }
 }

function FuncKryPemohon2() {
  var checkBox = document.getElementById("daftar_gaji_pemohon_ck");
  var text = document.getElementById("daftar_gaji_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "DAFTAR GAJI";
  } else {
     text.value = "";
  }
 }

function FuncKryPemohon3() {
  var checkBox = document.getElementById("surat_ket_penghasilan_pemohon_ck");
  var text = document.getElementById("surat_ket_penghasilan_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "SURAT KETERANGAN PENGHASILAN";
  } else {
     text.value = "";
  }
 }

function FuncKryPemohon4() {
  var checkBox = document.getElementById("bukti_saldo_print_jamsos_pemohon_ck");
  var text = document.getElementById("bukti_saldo_print_jamsos_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SALDO PRINT SCREEN JAMSOSTEK";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPemohon5() {
  var checkBox = document.getElementById("bukti_spt_pemohon_ck");
  var text = document.getElementById("bukti_spt_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPemohon6() {
  var checkBox = document.getElementById("rekening_tabungan_pemohon_ck");
  var text = document.getElementById("rekening_tabungan_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "REKENING TABUNGAN";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPemohon7() {
  var checkBox = document.getElementById("foto_kartu_identitas_pemohon_ck");
  var text = document.getElementById("foto_kartu_identitas_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "FOTO KARTU IDENTITAS KARYAWAN";
  } else {
     text.value = "";
  }
 }
 
}else  if (pemohon == "WIRASWASTA") {
	function FuncWrsPemohon1() {
  var checkBox = document.getElementById("rek_tabungan_pemohon_wrs_ck");
  var text = document.getElementById("rek_tabungan_pemohon_wrs_ck1");
  
  if (checkBox.checked == true){
    text.value = "REK TABUNGAN";
  } else {
     text.value = "";
  }
 }
 function FuncWrsPemohon2() {
  var checkBox = document.getElementById("nota_pembelian_wrs_pemohon_ck");
  var text = document.getElementById("nota_pembelian_wrs_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "NOTA PEMBELIAN";
  } else {
     text.value = "";
  }
 }
  function FuncWrsPemohon3() {
  var checkBox = document.getElementById("nota_penjualan_wrs_pemohon_ck");
  var text = document.getElementById("nota_penjualan_wrs_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "NOTA PENJUALAN";
  } else {
     text.value = "";
  }
 }
   function FuncWrsPemohon4() {
  var checkBox = document.getElementById("spt_wrs_pemohon_ck");
  var text = document.getElementById("spt_wrs_pemohon_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text.value = "";
  }
 }
 
 
}else  if (pemohon == "PROFESSIONAL") {
  function FuncProPemohon1() {
	 var checkBox = document.getElementById("pro_bukti_penghasilan_pemohon_ck");
	 var text = document.getElementById("pro_bukti_penghasilan_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	function FuncProPemohon2() {
	 var checkBox = document.getElementById("pro_rek_tabungan_pemohon_ck");
	 var text = document.getElementById("pro_rek_tabungan_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "REK TABUNGAN";
	  } else {
		 text.value = "";
	  }
    }
	
	
	function FuncProPemohon3() {
	 var checkBox = document.getElementById("pro_spt_pemohon_ck");
	 var text = document.getElementById("pro_spt_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	
	
	
	
}else  if (pemohon == "NON PROFESSIONAL") {
  function FuncNonProPemohon1() {
	 var checkBox = document.getElementById("nonpro_bukti_penghasilan_pemohon_ck");
	 var text = document.getElementById("nonpro_bukti_penghasilan_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	function FuncNonProPemohon2() {
	 var checkBox = document.getElementById("nonpro_rek_tabungan_pemohon_ck");
	 var text = document.getElementById("nonpro_rek_tabungan_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "REK TABUNGAN";
	  } else {
		 text.value = "";
	  }
    }
	
	
	function FuncNonProPemohon3() {
	 var checkBox = document.getElementById("nonpro_spt_pemohon_ck");
	 var text = document.getElementById("nonpro_spt_pemohon_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }

	
}
if (join_income == "YA" && pasangan == "KARYAWAN") {

	$("#slip_gaji_pasangan_ck").click(function(){
  var checkBox1 = document.getElementById("slip_gaji_pasangan_ck");
  var text1 = document.getElementById("slip_gaji_pasangan_ck1");
  
  if (checkBox1.checked == true){
    text1.value = "SLIP GAJI";
  } else {
     text1.value = "";
  }
 });

	$("#daftar_gaji_pasangan_ck").click(function(){
  var checkBox2 = document.getElementById("daftar_gaji_pasangan_ck");
  var text2 = document.getElementById("daftar_gaji_pasangan_ck1");
  
  if (checkBox2.checked == true){
    text2.value = "DAFTAR GAJI";
  } else {
     text2.value = "";
  }
 });

	$("#surat_ket_penghasilan_pasangan_ck").click(function(){
  var checkBox3 = document.getElementById("surat_ket_penghasilan_pasangan_ck");
  var text3 = document.getElementById("surat_ket_penghasilan_pasangan_ck1");
  
  if (checkBox3.checked == true){
    text3.value = "SURAT KETERANGAN PENGHASILAN";
  } else {
     text3.value = "";
  }
 });

	$("#bukti_saldo_print_jamsos_pasangan_ck").click(function(){
  var checkBox4 = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck");
  var text4 = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck1");
  
  if (checkBox4.checked == true){
    text4.value = "BUKTI SALDO PRINT SCREEN JAMSOSTEK";
  } else {
     text4.value = "";
  }
});
 
$("#bukti_spt_pasangan_ck").click(function(){
  var checkBox5 = document.getElementById("bukti_spt_pasangan_ck");
  var text5 = document.getElementById("bukti_spt_pasangan_ck1");
  
  if (checkBox5.checked == true){
    text5.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text5.value = "";
  }
 });
 
$("#rekening_tabungan_pasangan_ck").click(function(){
  var checkBox6 = document.getElementById("rekening_tabungan_pasangan_ck");
  var text6 = document.getElementById("rekening_tabungan_pasangan_ck1");
  
  if (checkBox6.checked == true){
    text6.value = "REKENING TABUNGAN";
  } else {
     text6.value = "";
  }
 });
 
$("#foto_kartu_identitas_pasangan_ck").click(function(){
  var checkBox7 = document.getElementById("foto_kartu_identitas_pasangan_ck");
  var text7 = document.getElementById("foto_kartu_identitas_pasangan_ck1");
  
  if (checkBox7.checked == true){
    text7.value = "FOTO KARTU IDENTITAS KARYAWAN";
  } else {
     text7.value = "";
  }
 });
 
}else  if (join_income == "YA" && pasangan == "WIRASWASTA") {

	$("#rek_tabungan_pasangan_wrs_ck").click(function(){

  var checkBox1 = document.getElementById("rek_tabungan_pasangan_wrs_ck");
  var text1 = document.getElementById("rek_tabungan_pasangan_wrs_ck1");
  
  if (checkBox1.checked == true){
    text1.value = "REK TABUNGAN";
  } else {
     text1.value = "";
  }
		});

$("#nota_pembelian_wrs_pasangan_ck").click(function(){
  var checkBox2 = document.getElementById("nota_pembelian_wrs_pasangan_ck");
  var text2 = document.getElementById("nota_pembelian_wrs_pasangan_ck1");
  
  if (checkBox2.checked == true){
    text2.value = "NOTA PEMBELIAN";
  } else {
     text2.value = "";
  }
 });
 $("#nota_penjualan_wrs_pasangan_ck").click(function(){

  var checkBox3 = document.getElementById("nota_penjualan_wrs_pasangan_ck");
  var text3 = document.getElementById("nota_penjualan_wrs_pasangan_ck1");
  
  if (checkBox3.checked == true){
    text3.value = "NOTA PENJUALAN";
  } else {
     text3.value = "";
  }
 });
 
   $("#spt_wrs_pasangan_ck").click(function(){
  var checkBox4 = document.getElementById("spt_wrs_pasangan_ck");
  var text4 = document.getElementById("spt_wrs_pasangan_ck1");
  
  if (checkBox4.checked == true){
    text4.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text4.value = "";
  }
 });
 
 
}else  if (join_income == "YA" && pasangan == "PROFESSIONAL") {
$("#pro_bukti_penghasilan_pasangan_ck").click(function(){
	 var checkBox1 = document.getElementById("pro_bukti_penghasilan_pasangan_ck");
	 var text1 = document.getElementById("pro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox1.checked == true){
	text1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text1.value = "";
	  }
   });
	
$("#pro_rek_tabungan_pasangan_ck").click(function(){
	 var checkBox2 = document.getElementById("pro_rek_tabungan_pasangan_ck");
	 var text2 = document.getElementById("pro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox2.checked == true){
	text2.value = "REK TABUNGAN";
	  } else {
		 text2.value = "";
	  }
     });
	
	
$("#pro_spt_pasangan_ck").click(function(){
	 var checkBox3 = document.getElementById("pro_spt_pasangan_ck");
	 var text3 = document.getElementById("pro_spt_pasangan_ck1");
  
	  if (checkBox3.checked == true){
	text3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text3.value = "";
	  }
   });
	
	
	
	
	
}else  if (join_income == "YA" && pasangan == "NON PROFESSIONAL") {
$("#nonpro_bukti_penghasilan_pasangan_ck").click(function(){
	 var checkBox1 = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck");
	 var text1 = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox1.checked == true){
	text1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text1.value = "";
	  }
   });
	
$("#nonpro_rek_tabungan_pasangan_ck").click(function(){
	 var checkBox2 = document.getElementById("nonpro_rek_tabungan_pasangan_ck");
	 var text2 = document.getElementById("nonpro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox2.checked == true){
	text2.value = "REK TABUNGAN";
	  } else {
		 text2.value = "";
	  }
    });
	
	
$("#nonpro_spt_pasangan_ck").click(function(){
	 var checkBox3 = document.getElementById("nonpro_spt_pasangan_ck");
	 var text3 = document.getElementById("nonpro_spt_pasangan_ck1");
  
	  if (checkBox3.checked == true){
	text3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text3.value = "";
	  }
     });

	
}




</script>


<script type="text/javascript">


$(document).ready(function(){
	//$('#subgrup').val(data[0].kolom);
	  var pemohon =  $("#cust_model_pemohon").val();
   var pasangan =  $("#cust_model_pasangan").val();

   var r = document.getElementById("kry_pasangan_div");
  var x = document.getElementById("wrs_pasangan_div");
  var t = document.getElementById("pro_pasangan_div");
  var u = document.getElementById("nonpro_pasangan_div");
  var history = document.getElementById("historical_kredit");
  
   var history = document.getElementById("historical_kredit");
  var history_kry_pemohon = document.getElementById("historical_kredit_kry_pemohon");
  var history_wrs_pemohon = document.getElementById("historical_kredit_wrs_pemohon");
  var history_pro_pemohon = document.getElementById("historical_kredit_pro_pemohon");
  var history_nonpro_pemohon = document.getElementById("historical_kredit_nonpro_pemohon");
  
   var history_kry_pasangan = document.getElementById("historical_kredit_kry_pasangan");
  var history_wrs_pasangan = document.getElementById("historical_kredit_wrs_pasangan");
  var history_pro_pasangan = document.getElementById("historical_kredit_pro_pasangan");
  var history_nonpro_pasangan = document.getElementById("historical_kredit_nonpro_pasangan");
  
  var join_pasangan = document.getElementById("cust_model_pasangan_div");
 
   var join_income =  $("#join_income").val();
   
  
  var checkBoxD1 = document.getElementById("dev_usia");
  var textD1 = document.getElementById("dev_usia1");
  
  if (checkBoxD1.checked == true){
    textD1.value = "D0001";
  } else {
     textD1.value = "";
  }


  var checkBoxD2 = document.getElementById("dev_pas_ttd");
  var textD2 = document.getElementById("dev_pas_ttd1");
  
  if (checkBoxD2.checked == true){
    textD2.value = "D0002";
  } else {
     textD2.value = "";
  }


  var checkBoxD3 = document.getElementById("dev_pengkinian");
  var textD3 = document.getElementById("dev_pengkinian1");
  
  if (checkBoxD3.checked == true){
    textD3.value = "D0003";
  } else {
     textD3.value = "";
  }


  

  var checkBoxD6 = document.getElementById("dev_srv_kantor");
  var textD6 = document.getElementById("dev_srv_kantor1");
  
  if (checkBoxD6.checked == true){
    textD6.value = "D0006";
  } else {
     textD6.value = "";
  }


  var checkBoxD7 = document.getElementById("dev_negative");
  var textD7 = document.getElementById("dev_negative1");
  
  if (checkBoxD7.checked == true){
    textD7.value = "D0007";			
  } else {
     textD7.value = "";
  }

  
  var checkBoxK1 = document.getElementById("shm_ck");
  var textK1 = document.getElementById("shm_ck1");
  
  if (checkBoxK1.checked == true){
    textK1.value = "SHM";
  } else {
     textK1.value = "";
  }

  var checkBoxK2 = document.getElementById("akta_jual_beli_ck");
  var textK2 = document.getElementById("akta_jual_beli_ck1");
  
  if (checkBoxK2.checked == true){
    textK2.value = "AKTA JUAL BELI";
  } else {
     textK2.value = "";
  }

  var checkBoxK3 = document.getElementById("surat_girik_ck");
  var textK3 = document.getElementById("surat_girik_ck1");
  
  if (checkBoxK3.checked == true){
    textK3.value = "SURAT GIRIK";
  } else {
     textK3.value = "";
  }

  var checkBoxK4 = document.getElementById("pbb_ck");
  var textK4 = document.getElementById("pbb_ck1");
  
  if (checkBoxK4.checked == true){
    textK4.value = "PBB";
  } else {
     textK4.value = "";
  }

  var checkBoxK5 = document.getElementById("rek_listrik_ck");
  var textK5 = document.getElementById("rek_listrik_ck1");
  
  if (checkBoxK5.checked == true){
    textK5.value = "REK LISTRIK";
  } else {
     textK5.value = "";
  }


  var checkBoxK6 = document.getElementById("rek_air_ck");
  var textK6 = document.getElementById("rek_air_ck1");
  
  if (checkBoxK6.checked == true){
    textK6.value = "REK AIR";
  } else {
     textK6.value = "";
  }


  var checkBoxK7 = document.getElementById("skrd_ck");
  var textK7 = document.getElementById("skrd_ck1");
  
  if (checkBoxK7.checked == true){
    textK7.value = "SURAT KEPUTUSAN RUMAH DINAS";
  } else {
     textK7.value = "";
  }

   
   
   if ( pemohon == "KARYAWAN") {
     var history_kry_pemohon = document.getElementById("historical_kredit_kry_pemohon");
	 

  var checkBoxPe1 = document.getElementById("slip_gaji_pemohon_ck");
  var textPe1 = document.getElementById("slip_gaji_pemohon_ck1");
  
  if (checkBoxPe1.checked == true){
    textPe1.value = "SLIP GAJI";
  } else {
     textPe1.value = "";
  }
 


  var checkBoxPe2 = document.getElementById("daftar_gaji_pemohon_ck");
  var textPe2 = document.getElementById("daftar_gaji_pemohon_ck1");
  
  if (checkBoxPe2.checked == true){
    textPe2.value = "DAFTAR GAJI";
  } else {
     textPe2.value = "";
  }


  var checkBoxPe3 = document.getElementById("surat_ket_penghasilan_pemohon_ck");
  var textPe3 = document.getElementById("surat_ket_penghasilan_pemohon_ck1");
  
  if (checkBoxPe3.checked == true){
    textPe3.value = "SURAT KETERANGAN PENGHASILAN";
  } else {
     textPe3.value = "";
  }


  var checkBoxPe4 = document.getElementById("bukti_saldo_print_jamsos_pemohon_ck");
  var textPe4 = document.getElementById("bukti_saldo_print_jamsos_pemohon_ck1");
  
  if (checkBoxPe4.checked == true){
    textPe4.value = "BUKTI SALDO PRINT SCREEN JAMSOSTEK";
  } else {
     textPe4.value = "";
  }
 
 
  var checkBoxPe5 = document.getElementById("bukti_spt_pemohon_ck");
  var textPe5 = document.getElementById("bukti_spt_pemohon_ck1");
  
  if (checkBoxPe5.checked == true){
    textPe5.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     textPe5.value = "";
  }
 
  var checkBoxPe6 = document.getElementById("rekening_tabungan_pemohon_ck");
  var textPe6 = document.getElementById("rekening_tabungan_pemohon_ck1");
  
  if (checkBoxPe6.checked == true){
    textPe6.value = "REKENING TABUNGAN";
  } else {
     textPe6.value = "";
  }
 
 
  var checkBoxPe7 = document.getElementById("foto_kartu_identitas_pemohon_ck");
  var textPe7 = document.getElementById("foto_kartu_identitas_pemohon_ck1");
  
  if (checkBoxPe7.checked == true){
    textPe7.value = "FOTO KARTU IDENTITAS KARYAWAN";
  } else {
     textPe7.value = "";
  }
	 
	 
   
  }
  
  if ( pemohon == "WIRASWASTA") {
    
  var checkBoxPe1 = document.getElementById("rek_tabungan_pemohon_wrs_ck");
  var textPe1 = document.getElementById("rek_tabungan_pemohon_wrs_ck1");
  
  if (checkBoxPe1.checked == true){
    textPe1.value = "REK TABUNGAN";
  } else {
     textPe1.value = "";
  }
 

  var checkBoxPe2 = document.getElementById("nota_pembelian_wrs_pemohon_ck");
  var textPe2 = document.getElementById("nota_pembelian_wrs_pemohon_ck1");
  
  if (checkBoxPe2.checked == true){
    textPe2.value = "NOTA PEMBELIAN";
  } else {
     textPe2.value = "";
  }
 
  
  var checkBoxPe3 = document.getElementById("nota_penjualan_wrs_pemohon_ck");
  var textPe3 = document.getElementById("nota_penjualan_wrs_pemohon_ck1");
  
  if (checkBoxPe3.checked == true){
    textPe3.value = "NOTA PENJUALAN";
  } else {
     textPe3.value = "";
  }
 
 
  var checkBoxPe4 = document.getElementById("spt_wrs_pemohon_ck");
  var textPe4 = document.getElementById("spt_wrs_pemohon_ck1");
  
  if (checkBoxPe4.checked == true){
    textPe4.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     textPe4.value = "";
  }
 
 
 
}
    if ( pemohon == "PROFESSIONAL") {
  var history_pro_pemohon = document.getElementById("historical_kredit_pro_pemohon");
  
   var checkBoxPe1 = document.getElementById("pro_bukti_penghasilan_pemohon_ck");
	 var textPe1 = document.getElementById("pro_bukti_penghasilan_pemohon_ck1");
  
	  if (checkBoxPe1.checked == true){
	textPe1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 textPe1.value = "";
	  }
    
	
	
	 var checkBoxPe2 = document.getElementById("pro_rek_tabungan_pemohon_ck");
	 var textPe2 = document.getElementById("pro_rek_tabungan_pemohon_ck1");
  
	  if (checkBoxPe2.checked == true){
	textPe2.value = "REK TABUNGAN";
	  } else {
		 textPe2.value = "";
	  }
    
	
	
	
	 var checkBoxPe3 = document.getElementById("pro_spt_pemohon_ck");
	 var textPe3 = document.getElementById("pro_spt_pemohon_ck1");
  
	  if (checkBoxPe3.checked == true){
	textPe3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 textPe3.value = "";
	  }
    
	
   }
 if ( pemohon == "NON PROFESSIONAL") {
  var history_nonpro_pemohon = document.getElementById("historical_kredit_nonpro_pemohon");

	 var checkBoxPe1 = document.getElementById("nonpro_bukti_penghasilan_pemohon_ck");
	 var textPe1 = document.getElementById("nonpro_bukti_penghasilan_pemohon_ck1");
  
	  if (checkBoxPe1.checked == true){
	textPe1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 textPe1.value = "";
	  }
    
	
	
	 var checkBoxPe2 = document.getElementById("nonpro_rek_tabungan_pemohon_ck");
	 var textPe2 = document.getElementById("nonpro_rek_tabungan_pemohon_ck1");
  
	  if (checkBoxPe2.checked == true){
	textPe2.value = "REK TABUNGAN";
	  } else {
		 textPe2.value = "";
	  }
    
	
	

	 var checkBoxPe3 = document.getElementById("nonpro_spt_pemohon_ck");
	 var textPe3 = document.getElementById("nonpro_spt_pemohon_ck1");
  
	  if (checkBoxPe3.checked == true){
	textPe3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 textPe3.value = "";
	  }
    }
    
   
    if ( pasangan == "KARYAWAN") {
     var history_kry_pasangan = document.getElementById("historical_kredit_kry_pasangan");
   }
   if ( pasangan == "WIRASWASTA") {
      var history_wrs_pasangan = document.getElementById("historical_kredit_wrs_pasangan");
   }
    if ( pasangan == "PROFESSIONAL") {
    var history_pro_pasangan = document.getElementById("historical_kredit_pro_pasangan");
   }
   if ( pasangan == "NON PROFESSIONAL") {
  var history_nonpro_pasangan = document.getElementById("historical_kredit_nonpro_pasangan");
   }   


  
 
 

 
   
 
  
  if ( join_income == "YA" && pasangan == "WIRASWASTA") {
    x.style.display = "block";
	 join_pasangan.style.display = "block";

  var checkBox1 = document.getElementById("rek_tabungan_pasangan_wrs_ck");
  var text1 = document.getElementById("rek_tabungan_pasangan_wrs_ck1");
  
  if (checkBox1.checked == true){
    text1.value = "REK TABUNGAN";
  } else {
     text1.value = "";
  }
	


  var checkBox2 = document.getElementById("nota_pembelian_wrs_pasangan_ck");
  var text2 = document.getElementById("nota_pembelian_wrs_pasangan_ck1");
  
  if (checkBox2.checked == true){
    text2.value = "NOTA PEMBELIAN";
  } else {
     text2.value = "";
  }



  var checkBox3 = document.getElementById("nota_penjualan_wrs_pasangan_ck");
  var text3 = document.getElementById("nota_penjualan_wrs_pasangan_ck1");
  
  if (checkBox3.checked == true){
    text3.value = "NOTA PENJUALAN";
  } else {
     text3.value = "";
  }


  var checkBox4 = document.getElementById("spt_wrs_pasangan_ck");
  var text4 = document.getElementById("spt_wrs_pasangan_ck1");
  
  if (checkBox4.checked == true){
    text4.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text4.value = "";
  }

	 
  }else if ( join_income == "YA" && pasangan == "KARYAWAN") {
    r.style.display = "block";
	 join_pasangan.style.display = "block";
	 
	
  var checkBox1 = document.getElementById("slip_gaji_pasangan_ck");
  var text1 = document.getElementById("slip_gaji_pasangan_ck1");
  
  if (checkBox1.checked == true){
    text1.value = "SLIP GAJI";
  } else {
     text1.value = "";
  }



  var checkBox2 = document.getElementById("daftar_gaji_pasangan_ck");
  var text2 = document.getElementById("daftar_gaji_pasangan_ck1");
  
  if (checkBox2.checked == true){
    text2.value = "DAFTAR GAJI";
  } else {
     text2.value = "";
  }



  var checkBox3 = document.getElementById("surat_ket_penghasilan_pasangan_ck");
  var text3 = document.getElementById("surat_ket_penghasilan_pasangan_ck1");
  
  if (checkBox3.checked == true){
    text3.value = "SURAT KETERANGAN PENGHASILAN";
  } else {
     text3.value = "";
  }



  var checkBox4 = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck");
  var text4 = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck1");
  
  if (checkBox4.checked == true){
    text4.value = "BUKTI SALDO PRINT SCREEN JAMSOSTEK";
  } else {
     text4.value = "";
  }

 

  var checkBox5 = document.getElementById("bukti_spt_pasangan_ck");
  var text5 = document.getElementById("bukti_spt_pasangan_ck1");
  
  if (checkBox5.checked == true){
    text5.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text5.value = "";
  }


  var checkBox6 = document.getElementById("rekening_tabungan_pasangan_ck");
  var text6 = document.getElementById("rekening_tabungan_pasangan_ck1");
  
  if (checkBox6.checked == true){
    text6.value = "REKENING TABUNGAN";
  } else {
     text6.value = "";
  }

 
  var checkBox7 = document.getElementById("foto_kartu_identitas_pasangan_ck");
  var text7 = document.getElementById("foto_kartu_identitas_pasangan_ck1");
  
  if (checkBox7.checked == true){
    text7.value = "FOTO KARTU IDENTITAS KARYAWAN";
  } else {
     text7.value = "";
  }

 
  }else if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
    t.style.display = "block";
	 join_pasangan.style.display = "block";
	 

	 var checkBox1 = document.getElementById("pro_bukti_penghasilan_pasangan_ck");
	 var text1 = document.getElementById("pro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox1.checked == true){
	text1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text1.value = "";
	  }


	 var checkBox2 = document.getElementById("pro_rek_tabungan_pasangan_ck");
	 var text2 = document.getElementById("pro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox2.checked == true){
	text2.value = "REK TABUNGAN";
	  } else {
		 text2.value = "";
	  }

	
	
	 var checkBox3 = document.getElementById("pro_spt_pasangan_ck");
	 var text3 = document.getElementById("pro_spt_pasangan_ck1");
  
	  if (checkBox3.checked == true){
	text3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text3.value = "";
	  }
 
   
  }else if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
    u.style.display = "block";
	 join_pasangan.style.display = "block";
	 
	 var checkBox1 = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck");
	 var text1 = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox1.checked == true){
	text1.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text1.value = "";
	  }

	
	 var checkBox2 = document.getElementById("nonpro_rek_tabungan_pasangan_ck");
	 var text2 = document.getElementById("nonpro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox2.checked == true){
	text2.value = "REK TABUNGAN";
	  } else {
		 text2.value = "";
	  }

	
	
	 var checkBox3 = document.getElementById("nonpro_spt_pasangan_ck");
	 var text3 = document.getElementById("nonpro_spt_pasangan_ck1");
  
	  if (checkBox3.checked == true){
	text3.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text3.value = "";
	  }


  }else{
    x.style.display = "none";
	r.style.display = "none";
	t.style.display = "none";
	u.style.display = "none";
	 join_pasangan.style.display ="none";
  }
  

	if ( join_income == "TIDAK" &&  pemohon == "KARYAWAN" ) {
		  history.style.display = "block";
		  history_kry_pemohon.style.display = "none";
	}
	if ( join_income == "TIDAK" &&  pemohon == "WIRASWASTA" ) {
		  history.style.display = "block";
		  history_wrs_pemohon.style.display = "none";
	}
	if ( join_income == "TIDAK" &&  pemohon == "PROFESSIONAL" ) {
		  history.style.display = "block";
		  history_pro_pemohon.style.display = "none";
	}
	if ( join_income == "TIDAK" &&  pemohon == "NON PROFESSIONAL" ) {
		  history.style.display = "block";
		  history_nonpro_pemohon.style.display = "none";
	}
	if ( join_income == "YA" &&  pemohon == "KARYAWAN" ) {
		  history.style.display = "none";
		  history_kry_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pemohon == "WIRASWASTA" ) {
		  history.style.display = "none";
		  history_wrs_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pemohon == "PROFESSIONAL" ) {
		  history.style.display = "none";
		  history_pro_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pemohon == "NON PROFESSIONAL" ) {
		  history.style.display = "none";
		  history_nonpro_pemohon.style.display = "block";
	}
	
	
	/*
	if ( join_income == "YA" &&  pasangan == "KARYAWAN" ) {
		  history.style.display = "none";
		  history_kry_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pasangan == "WIRASWASTA" ) {
		  history.style.display = "none";
		  history_wrs_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pasangan == "PROFESSIONAL" ) {
		  history.style.display = "none";
		  history_pro_pemohon.style.display = "block";
	}
	if ( join_income == "YA" &&  pasangan == "NON PROFESSIONAL" ) {
		  history.style.display = "none";
		  history_nonpro_pemohon.style.display = "block";
	}
	*/
	
  /*
   if ( join_income == "TIDAK") {
    history.style.display = "block";
	history_kry_pemohon.style.display = "none";
	history_wrs_pemohon.style.display = "none";
	history_pro_pemohon.style.display = "none";
    history_nonpro_pemohon.style.display = "none";
  }else{
	history.style.display = "none";
    history_kry_pemohon.style.display = "block";
	history_wrs_pemohon.style.display = "block";
	history_pro_pemohon.style.display = "block";
    history_nonpro_pemohon.style.display = "block";
	
  }
  
  
   */
   
   
   if ( pemohon == "WIRASWASTA") {
   viewWrsPemohon();
	viewMutasiWrsPemohon();
  }if ( pemohon == "KARYAWAN") {
   view();
  }if ( pemohon == "PROFESSIONAL") {
    viewMutasiProPemohon();
  }if ( pemohon == "NON PROFESSIONAL") {
    viewMutasiNonProPemohon();
  }
   
  if ( join_income == "YA" && pasangan == "WIRASWASTA") {
    viewWrsPasangan();
	viewMutasiWrsPasangan();
  }
  if ( join_income == "YA" && pasangan == "KARYAWAN") {
   viewMutasiKryPasangan();
  } 
  if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
  viewMutasiProPasangan();
  } 
  if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
   viewMutasiNonProPasangan();
  }
	var nf = new Intl.NumberFormat('en-US');
	//document.getElementById('submit_from').disabled = true;
	//var timeout = setInterval(reloadChat, 10000);    
//function reloadChat () {

  //   	view();
//}

/*
$(function () {
  $("#join_income").change(function() {
    var val = $(this).val();
	var pasangan =  $("#cust_model_pasangan").val();
    if(val === "YA") {
        $("#wrs_pasangan_div").style.display = "block";
    }else{
		 $("#wrs_pasangan_div").style.display = "none";
	}
  
  });
});
*/
	$('#kry_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#tgl_gaji').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#wrs_tgl_transaksi_pemohon').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#wrs_pemohon_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	
	$('#pro_pemohon_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	
	
	
	
	 function view() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-kry-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabeldata').html(data);
                    }
                });
            }
			
		 function viewMutasiKryPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-kry-pasangan-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabeldata').html(data);
                    }
                });
            }
			
	 function viewMutasiWrsPemohon() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-wrs-pemohon.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiWrsPemohon').html(data);
                    }
                });
            }
			
	 function viewMutasiWrsPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-wrs-pasangan-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiWrsPasangan').html(data);
                    }
                });
            }		
			
	 function viewWrsPemohon() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-nota-wrs-pemohon-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelNotaWrsPemohon').html(data);
                    }
                });
            }		
	 function viewWrsPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-nota-wrs-pasangan-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelNotaWrsPasangan').html(data);
                    }
                });
            }		
			
	 function viewMutasiProPemohon() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-pro-pemohon.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiProPemohon').html(data);
                    },
					 error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                },
                });
            }		

 function viewMutasiProPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-pro-pasangan-bm.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiProPasangan').html(data);
                    }
                });
            }		

 function viewMutasiNonProPemohon() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-nonpro-pemohon.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiNonProPemohon').html(data);
                    }
                });
            }		

 function viewMutasiNonProPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-nonpro-pasangan.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiNonProPasangan').html(data);
                    }
                });
            }		

	
	
	$("#cal_dsr").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_calc_dsr_bm.php",
			data: data,
			success: function(dsr) {
			// $('#tabeldata').load("view-mutasi-kry.php");
			console.log(dsr);
		
			$('#dsr').val(parseFloat(dsr[0].DSR));
			$('#total_kewajiban').val(nf.format(dsr[0].TOTAL_KEWAJIBAN));
			$('#total_pendapatan').val(nf.format(dsr[0].TOTAL_PENDAPATAN));
			$('#kewajiban_tempatlain').val(nf.format(dsr[0].KEWAJIBAN_TEMPAT_LAIN));
			//$('#pendapatan_total').val(nf.format(dsr[0].ANGSURAN_CRA));
			var dsrVal = parseFloat(dsr[0].DSR); 
			var dacor = $("#dacor").val();
			var pengajuan = $("#pengajuan").val();
			var segmentasi = $("#segmentasi").val();
			var paket = $("#paket").val();
			
			
			let tdp_persen = parseFloat($('#tdp_persen').val());
			//console.log(dacor);
			//console.log(dsrVal);
			if (dacor == 'YA'){
				if (pengajuan == 'DANA TUNAI'){
					$('#submit1').prop("disabled", true);
					alert("Aplikasi Dana Tunai Tidak Bisa Lanjut Per 1 Agustus 2024");
					/* if (dsrVal > 60) {
				  
					$('#submit1').prop("disabled", true);
					alert("DSR tidak boleh lebih dari 60%");
				}else{
					$('#submit1').prop("disabled", false);
				} */
				}else{
					$('#submit1').prop("disabled", false);
				}
			}else if (pengajuan == 'DANA TUNAI'){
				$('#submit1').prop("disabled", true);
					alert("Aplikasi Dana Tunai Tidak Bisa Lanjut Per 1 Agustus 2024");
			}else{
				if (dsrVal > 60) {
				  
					$('#submit1').prop("disabled", true);
					alert("DSR tidak boleh lebih dari 60%");
				}else if(segmentasi == 'PASSENGER' && tdp_persen < 20)  {
					alert('TDP Tidak boleh dibawah 20%! ');
					$('#submit1').prop("disabled", true);
				}else if(segmentasi == 'COMMERCIAL' && paket == 'CABANG KHUSUS' && tdp_persen < 20 )  {
					alert('TDP Tidak boleh dibawah 20%! ');
					$('#submit1').prop("disabled", true);
				}else if(segmentasi == 'COMMERCIAL' && paket != 'CABANG KHUSUS' && tdp_persen < 25 )  {
					alert('TDP Tidak boleh dibawah 25%! ');
					$('#submit1').prop("disabled", true);
				}else if(tdp_persen < 27.5 && dsrVal > 40)  {
					alert('Total DSR untuk Order ini '+dsrVal+'% , Minimum Tdp 27.5% .! ');
					$('#submit1').prop("disabled", true);
				}else{
					$('#submit1').prop("disabled", false);
				}
			
			}
			var keputusan = $("#keputusan").val();
			if (keputusan == 'TIDAK'){
				$('#submit1').prop("disabled", true);
			}
			
			//$('#subgrup').val(data[0].kolom);

		}
		});
	});
	

	
	$("#cal_dp").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_calc_up_dp.php",
			data: data,
			success: function(dp) {
			// $('#tabeldata').load("view-mutasi-kry.php");
			console.log(dp);
		
			$('#naik_amount_tdp_cal').val(nf.format(dp[0].TDP_UP));
			//$('#pendapatan_total').val(nf.format(dsr[0].ANGSURAN_CRA));
			
		
			
			//$('#subgrup').val(data[0].kolom);

		}
		});
	});
	
	/*
$("#cal_nota_wrs_pemohon").click(function(){
	$.get( "action_calc_wrs.php",{
		app_no_hide:$('#margin_pendapatan_wrs_pemohon').val(),
		biaya_opr_wrs_pemohon:$('#biaya_opr_wrs_pemohon').val(),
		cust_type_hide:$('#cust_type_hide').val(),
		app_no_hide:$('#app_no_hide').val(),

	}, function(data_nota) {
		console.log(data_nota);
				$.each(data_nota, function (index, value) {
					document.getElementById("tot_nota_pendapatan_wrs_pemohon").value = value.RATA_RATA_NOTA;
					document.getElementById("margin_pendapatan_wrs_pemohon").value = value.MARGIN;
					document.getElementById("tot_pendapatan_wrs_pemohon").value = value.TOTAL_PENDAPATAN;
					document.getElementById("biaya_opr_wrs_pemohon").value = value.BIAYA_OPERATIONAL;
					document.getElementById("net_wrs_pemohon").value = value.NET;
				});
			
		
	});
});

	
	
	*/
	
});

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
<script>

 
				
	
function onlyNumber(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57) || (charCode > 0 && charCode < 28) ){
				return false;
			}
			return true;
		}

		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? + rupiah : '');
		}
 var pemohon =  $("#cust_model_pemohon").val();
  var inputan_bm_pemohon = document.getElementById('inputan_bm_pemohon');

inputan_bm_pemohon.addEventListener('keyup',function(e){
  	 		inputan_bm_pemohon.value = formatRupiah(this.value);
  	 	});

		
		  var inputan_bm_pasangan = document.getElementById('inputan_bm_pasangan');

inputan_bm_pasangan.addEventListener('keyup',function(e){
  	 		inputan_bm_pasangan.value = formatRupiah(this.value);
  	 	});
		
 var inputan_bm_pasangan1 = document.getElementById('inputan_bm_pasangan1');

inputan_bm_pasangan1.addEventListener('keyup',function(e){
  	 		inputan_bm_pasangan1.value = formatRupiah(this.value);
  	 	});
		 var inputan_bm_pasangan2 = document.getElementById('inputan_bm_pasangan2');

inputan_bm_pasangan2.addEventListener('keyup',function(e){
  	 		inputan_bm_pasangan2.value = formatRupiah(this.value);
  	 	});
		 var inputan_bm_pasangan3 = document.getElementById('inputan_bm_pasangan3');
 
inputan_bm_pasangan3.addEventListener('keyup',function(e){
  	 		inputan_bm_pasangan3.value = formatRupiah(this.value);
  	 	});


</script>

<script>
$(document).ready(function() {
  $('#loadDetail-pemohon-kry').click(function() {
    let mapping_id = '<?= $mapping_id ?>'; // ambil dari PHP kalau tersedia

    $('#hasilLoad-pemohon-kry').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-karyawan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>"},
      success: function(response) {
        $('#hasilLoad-pemohon-kry').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pemohon-kry').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pasangan-kry').click(function() {
    let mapping_id = '<?= $mapping_idPasangan ?>';

    $('#hasilLoad-pasangan-kry').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-karyawan-pasangan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>", siapanih :"<?= $siapanih; ?>"},
      success: function(response) {
        $('#hasilLoad-pasangan-kry').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pasangan-kry').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pemohon-wrs').click(function() {
    let mapping_id = '<?= $mapping_id ?>'; // ambil dari PHP kalau tersedia

    $('#hasilLoad-pemohon-wrs').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-wiraswasta.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>"},
      success: function(response) {
        $('#hasilLoad-pemohon-wrs').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pemohon-wrs').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pasangan-wrs').click(function() {
    let mapping_id = '<?= $mapping_idPasangan ?>';

    $('#hasilLoad-pasangan-wrs').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-wiraswasta-pasangan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>", siapanih :"<?= $siapanih; ?>"},
      success: function(response) {
        $('#hasilLoad-pasangan-wrs').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pasangan-wrs').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pemohon-pro').click(function() {
    let mapping_id = '<?= $mapping_id ?>'; // ambil dari PHP kalau tersedia

    $('#hasilLoad-pemohon-pro').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-profesional.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>"},
      success: function(response) {
        $('#hasilLoad-pemohon-pro').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pemohon-pro').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pasangan-pro').click(function() {
    let mapping_id = '<?= $mapping_idPasangan ?>';

    $('#hasilLoad-pasangan-pro').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-profesional-pasangan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>", siapanih :"<?= $siapanih; ?>"},
      success: function(response) {
        $('#hasilLoad-pasangan-pro').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pasangan-pro').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pemohon-nonpro').click(function() {
    let mapping_id = '<?= $mapping_id ?>'; // ambil dari PHP kalau tersedia

    $('#hasilLoad-pemohon-nonpro').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-nonprof.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>"},
      success: function(response) {
        $('#hasilLoad-pemohon-nonpro').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pemohon-nonpro').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pasangan-nonpro').click(function() {
    let mapping_id = '<?= $mapping_idPasangan ?>';

    $('#hasilLoad-pasangan-nonpro').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-nonprof-pasangan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>", siapanih :"<?= $siapanih; ?>"},
      success: function(response) {
        $('#hasilLoad-pasangan-nonpro').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pasangan-nonpro').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pemohon-other').click(function() {
    let mapping_id = '<?= $mapping_id ?>'; // ambil dari PHP kalau tersedia

    $('#hasilLoad-pemohon-other').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-other.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>"},
      success: function(response) {
        $('#hasilLoad-pemohon-other').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pemohon-other').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
$(document).ready(function() {
  $('#loadDetail-pasangan-other').click(function() {
    let mapping_id = '<?= $mapping_idPasangan ?>';

    $('#hasilLoad-pasangan-other').html('<p>Loading data...</p>');

    $.ajax({
      url: 'detail-rak-mos/detail-rak-mos-other-pasangan.php',
      type: 'POST',
      data: { mapping_id: mapping_id, prospect: "<?= $prospect; ?>", siapanih :"<?= $siapanih; ?>"},
      success: function(response) {
        $('#hasilLoad-pasangan-other').html(response);
      },
      error: function(xhr, status, error) {
        $('#hasilLoad-pasangan-other').html('<p style="color:red;">Gagal load data: ' + error + '</p>');
      }
    });
  });
});
</script>
<script>
	document.getElementById("submit1").addEventListener("click", function (e) {
    // ambil angka pendapatan (hilangkan format ribuan)
    let moneyText = document.getElementById("pendapatan_lain_cf").value;
    let money = moneyText.replace(/\./g, "");

    // AJAX untuk kirim ke PHP
    $.ajax({
        url: "save_other_income.php",
        type: "POST",
        data: {
            prospect_no: "<?php echo $prospect; ?>", 
            role: "CA",
            money: money
        },
        success: function (response) {
           console.log("DATA SAVED SUCCESSFULLY");
        },
        error: function () {
            console.log("ERROR SAVING DATA");
        }
    });
});
</script>