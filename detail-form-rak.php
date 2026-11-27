<?php

$user=$_GET['USERNAME'];
$app_no = $_GET['app'];
$prospect=$_GET['prospect'];
$branchid= substr($app_no,0,4);
$type_kendaraan= substr($app_no,0,2);


$callCust = "{call SP_RAK_GET_CUST_INFO(?)}";
$paramCust =  array(array($app_no, SQLSRV_PARAM_IN));
$execCust = sqlsrv_query( $conn, $callCust, $paramCust) or die( print_r( sqlsrv_errors(), true));
$dataCust = sqlsrv_fetch_array($execCust);

$order_no =  $dataCust['ORDER_NO'];

$callInfo = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN(?)}";
$paramInfo =  array(array($app_no, SQLSRV_PARAM_IN));
$execInfo = sqlsrv_query( $conn, $callInfo, $paramInfo) or die( print_r( sqlsrv_errors(), true));
$dataInfo = sqlsrv_fetch_array($execInfo);
if($dataInfo['BIRTH_DT']<>NULL){$tgllahirPemohon = $dataInfo['BIRTH_DT']->format("d F Y");}else{$tgllahirPemohon="";}

$callSvy= "{call SP_RAK_GET_SURVEY_ID(?)}";
$paramSvy =  array(array($app_no, SQLSRV_PARAM_IN));
$execSvy = sqlsrv_query( $conn, $callSvy, $paramSvy) or die( print_r( sqlsrv_errors(), true));
$dataSvy = sqlsrv_fetch_array($execSvy);


$callTagging = "{call SP_RAK_GET_GEOTAGING_SURVEY(?)}";
$paramTagging =  array(array($app_no, SQLSRV_PARAM_IN));
$execTagging = sqlsrv_query( $conn, $callTagging, $paramTagging) or die( print_r( sqlsrv_errors(), true));
$dataTagging = sqlsrv_fetch_array($execTagging);


$callBank = "{call SP_RAK_GET_BANK_INFO(?)}";
$paramBank =  array(array($app_no, SQLSRV_PARAM_IN));
$execBank = sqlsrv_query( $conn, $callBank, $paramBank) or die( print_r( sqlsrv_errors(), true));
$dataBank = sqlsrv_fetch_array($execBank);


$callAnalisCa = "{call SP_RAK_GET_ANALISA_CREDIT(?,?)}";
$paramAnalisCa =  array(array($app_no, SQLSRV_PARAM_IN),
						array(1, SQLSRV_PARAM_IN));
$execAnalisCa = sqlsrv_query( $conn, $callAnalisCa, $paramAnalisCa) or die( print_r( sqlsrv_errors(), true));
$dataAnalisCa = sqlsrv_fetch_array($execAnalisCa);


$callAnalisBm = "{call SP_RAK_GET_ANALISA_CREDIT(?,?)}";
$paramAnalisBm =  array(array($app_no, SQLSRV_PARAM_IN),
						array(2, SQLSRV_PARAM_IN));
$execAnalisBm = sqlsrv_query( $conn, $callAnalisBm, $paramAnalisBm) or die( print_r( sqlsrv_errors(), true));
$dataAnalisBm = sqlsrv_fetch_array($execAnalisBm);


$callAnalisAm = "{call SP_RAK_GET_ANALISA_CREDIT(?,?)}";
$paramAnalisAm =  array(array($app_no, SQLSRV_PARAM_IN),
						array(3, SQLSRV_PARAM_IN));
$execAnalisAm = sqlsrv_query( $conn, $callAnalisAm, $paramAnalisAm) or die( print_r( sqlsrv_errors(), true));
$dataAnalisAm = sqlsrv_fetch_array($execAnalisAm);


$ktp_pemohon = $dataInfo['ID_NO'];



$callInfoProfesi = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN_PROFESI(?)}";
$paramInfoProfesi =  array(array($app_no, SQLSRV_PARAM_IN));
$execInfoProfesi = sqlsrv_query( $conn, $callInfoProfesi, $paramInfoProfesi) or die( print_r( sqlsrv_errors(), true));
$dataInfoProfesi = sqlsrv_fetch_array($execInfoProfesi);

if($dataInfo['Pasangan_Noktp'] == "" || $dataInfo['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$siapanih1 = "PENJAMIN";
		$ktpsaya = $dataInfo['Penjamin_Noktp'];
		$namasaya = $dataInfo['Penjamin_Nama'];
		if($dataInfo['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Penjamin_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Penjamin_TglLahir'];
		$tempatlahirsaya = $dataInfo['Penjamin_TempatLahir'];
		 if($dataInfo['Penjamin_Ibu']<>NULL){$namaibusaya = $dataInfo['Penjamin_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Penjamin_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Penjamin_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Penjamin_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Penjamin_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
		$profesisaya = $dataInfoProfesi['Penjamin_PROFESI'];
		$namaperusahaansaya = $dataInfoProfesi['Penjamin_NAMA_PERUSAHAAN'];
		$lamabekerjasaya = $dataInfoProfesi['Penjamin_LAMA_BEKERJA'];
		$custidsaya = $dataInfoProfesi['Penjamin_CUST_ID'];
	}else{
		$siapanih = "Pasangan";
		$siapanih1 = "PASANGAN";
		$ktpsaya = $dataInfo['Pasangan_Noktp'];
		$namasaya = $dataInfo['Pasangan_Nama'];
		if($dataInfo['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $dataInfo['Pasangan_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$dataInfo['Pasangan_TglLahir'];
		$tempatlahirsaya = $dataInfo['Pasangan_TempatLahir'];
		if($dataInfo['Pasangan_Ibu']<>NULL){$namaibusaya = $dataInfo['Pasangan_Ibu'];}else{$namaibusaya="";}
		$jksaya =  $dataInfo['Pasangan_JENIS_KELAMIN'];
		$alamat_ktpsaya = $dataInfo['Pasangan_ALAMAT_KTP'];
		$alamat_domisilisaya = $dataInfo['Pasangan_ALAMAT_DOMISILI'];
		$statuskawinsaya = $dataInfo['Pasangan_Status_Kawin'];
		$custmodelsaya = $dataInfo['Penjamin_CUST_MODEL'];
		$profesisaya = $dataInfoProfesi['Pasangan_PROFESI'];
		$namaperusahaansaya = $dataInfoProfesi['Pasangan_NAMA_PERUSAHAAN'];
		$lamabekerjasaya = $dataInfoProfesi['Pasangan_LAMA_BEKERJA'];
		$custidsaya = $dataInfoProfesi['Pasangan_CUST_ID'];
		
	}

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
$execMappingPemohon = sqlsrv_query( $conn, $callMappingPemohon, $paramMappingPemohon) or die( print_r( sqlsrv_errors(), true));
$dataMappingPemohon = sqlsrv_fetch_array($execMappingPemohon);
$mapping_id = $dataMappingPemohon['PEFINDO_MAPPING_ID'];


$callMappingPasangan = "{call SP_RAK_GET_MAPPING_ID_PEFINDOSLIK(?,?)}";
$paramMappingPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
					   array($ktpsaya, SQLSRV_PARAM_IN),);
$execMappingPasangan = sqlsrv_query( $conn, $callMappingPasangan, $paramMappingPasangan) or die( print_r( sqlsrv_errors(), true));
$dataMappingPasangan = sqlsrv_fetch_array($execMappingPasangan);
$mapping_idPasangan = $dataMappingPasangan['PEFINDO_MAPPING_ID'];


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


$callDesc = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
$paramDesc =  array(array($dataDataPemohon['SCORE'], SQLSRV_PARAM_IN),
				array('1', SQLSRV_PARAM_IN));
$execDesc = sqlsrv_query( $conn, $callDesc, $paramDesc) or die( print_r( sqlsrv_errors(), true));
$dataDesc = sqlsrv_fetch_array($execDesc);

$scorePemohon = $dataDesc['SCORE_DESC'];

$callDescPasangan = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
$paramDescPasangan =  array(array($dataDataPasangan['SCORE'], SQLSRV_PARAM_IN),
				array('1', SQLSRV_PARAM_IN));
$execDescPasangan = sqlsrv_query( $conn, $callDescPasangan, $paramDescPasangan) or die( print_r( sqlsrv_errors(), true));
$dataDescPasangan = sqlsrv_fetch_array($execDescPasangan);

$scorePasangan = $dataDescPasangan['SCORE_DESC'];


$callDsr = "{call SP_GET_DSR_PEFINDOLSIK(?)}";
$paramDsr =  array(array($app_no, SQLSRV_PARAM_IN));
$execDsr = sqlsrv_query( $conn, $callDsr, $paramDsr) or die( print_r( sqlsrv_errors(), true));
$dataDsr = sqlsrv_fetch_array($execDsr);

$callImgDomisili = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
$paramImgDomisili =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execImgDomisili = sqlsrv_query( $conn, $callImgDomisili, $paramImgDomisili) or die( print_r( sqlsrv_errors(), true));
$dataImgDomisili = sqlsrv_fetch_array($execImgDomisili);
$imgDomisiliCA = $dataImgDomisili['IMAGES_VALIDASI'];

$callImgRumah = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
$paramImgRumah =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOKUMEN PENDUKUNG RUMAH', SQLSRV_PARAM_IN));
$execImgRumah = sqlsrv_query( $conn, $callImgRumah, $paramImgRumah) or die( print_r( sqlsrv_defaults(), true)); 
$dataImgRumah = sqlsrv_fetch_array($execImgRumah);
$imgRumahCA = $dataImgRumah['IMAGES_VALIDASI'];

$callImgGeotaging = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
$paramImgGeotaging =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execImgGeotaging = sqlsrv_query( $conn, $callImgGeotaging, $paramImgGeotaging) or die( print_r( sqlsrv_errors(), true));
$dataImgGeotaging = sqlsrv_fetch_array($execImgGeotaging);
$ImgGeotagingCA = $dataImgGeotaging['IMAGES_VALIDASI'];


$callImgKunj = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
$paramImgKunj =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
$execImgKunj = sqlsrv_query( $conn, $callImgKunj, $paramImgKunj) or die( print_r( sqlsrv_errors(), true));
$dataImgKunj= sqlsrv_fetch_array($execImgKunj);
$ImgKunjCA = $dataImgKunj['IMAGES_VALIDASI'];

$callImgKryBank = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
$paramImgKryBank =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
$execImgKryBank = sqlsrv_query( $conn, $callImgKryBank, $paramImgKryBank) or die( print_r( sqlsrv_errors(), true));
$dataImgKryBank = sqlsrv_fetch_array($execImgKryBank);
$ImgKryBankCA = $dataImgKryBank['IMAGES_VALIDASI'];


//bm


$callImgDomisiliBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
$paramImgDomisiliBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execImgDomisiliBm = sqlsrv_query( $conn, $callImgDomisiliBm, $paramImgDomisiliBm) or die( print_r( sqlsrv_errors(), true));
$dataImgDomisiliBm = sqlsrv_fetch_array($execImgDomisiliBm);
$imgDomisiliBm = $dataImgDomisiliBm['IMAGES_VALIDASI'];


$callImgGeotagingBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
$paramImgGeotagingBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execImgGeotagingBm = sqlsrv_query( $conn, $callImgGeotagingBm, $paramImgGeotagingBm) or die( print_r( sqlsrv_errors(), true));
$dataImgGeotagingBm = sqlsrv_fetch_array($execImgGeotagingBm);
$ImgGeotagingBm = $dataImgGeotagingBm['IMAGES_VALIDASI'];


$callImgKunjBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
$paramImgKunjBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
$execImgKunjBm = sqlsrv_query( $conn, $callImgKunjBm, $paramImgKunjBm) or die( print_r( sqlsrv_errors(), true));
$dataImgKunjBm= sqlsrv_fetch_array($execImgKunjBm);
$ImgKunjBm = $dataImgKunjBm['IMAGES_VALIDASI'];

$callImgKryBankBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
$paramImgKryBankBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
$execImgKryBankBm = sqlsrv_query( $conn, $callImgKryBankBm, $paramImgKryBankBm) or die( print_r( sqlsrv_errors(), true));
$dataImgKryBankBm = sqlsrv_fetch_array($execImgKryBankBm);
$ImgKryBankBm = $dataImgKryBankBm['IMAGES_VALIDASI'];
//am 


$callImgDomisiliAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
$paramImgDomisiliAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execImgDomisiliAm = sqlsrv_query( $conn, $callImgDomisiliAm, $paramImgDomisiliAm) or die( print_r( sqlsrv_errors(), true));
$dataImgDomisiliAm = sqlsrv_fetch_array($execImgDomisiliAm);
$imgDomisiliAm = $dataImgDomisiliAm['IMAGES_VALIDASI'];


$callImgGeotagingAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
$paramImgGeotagingAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execImgGeotagingAm = sqlsrv_query( $conn, $callImgGeotagingAm, $paramImgGeotagingAm) or die( print_r( sqlsrv_errors(), true));
$dataImgGeotagingAm = sqlsrv_fetch_array($execImgGeotagingAm);
$ImgGeotagingAm = $dataImgGeotagingAm['IMAGES_VALIDASI'];


$callImgKunjAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
$paramImgKunjAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
$execImgKunjAm = sqlsrv_query( $conn, $callImgKunjAm, $paramImgKunjAm) or die( print_r( sqlsrv_errors(), true));
$dataImgKunjAm= sqlsrv_fetch_array($execImgKunjAm);
$ImgKunjAm = $dataImgKunjAm['IMAGES_VALIDASI'];

$callImgKryBankAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
$paramImgKryBankAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
$execImgKryBankAm = sqlsrv_query( $conn, $callImgKryBankAm, $paramImgKryBankAm) or die( print_r( sqlsrv_errors(), true));
$dataImgKryBankAm = sqlsrv_fetch_array($execImgKryBankAm);
$ImgKryBankAm = $dataImgKryBankAm['IMAGES_VALIDASI'];



$callHasilRak= "{call SP_RAK_GET_HASIL_RAK(?,?)}";
$paramHasilRak =  array(array($app_no, SQLSRV_PARAM_IN),
					array(1, SQLSRV_PARAM_IN));
$execHasilRak = sqlsrv_query( $conn, $callHasilRak, $paramHasilRak) or die( print_r( sqlsrv_errors(), true));
$dataHasilRak= sqlsrv_fetch_array($execHasilRak);


$callHasilRakBm= "{call SP_RAK_GET_HASIL_RAK(?,?)}";
$paramHasilRakBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array(2, SQLSRV_PARAM_IN));
$execHasilRakBm = sqlsrv_query( $conn, $callHasilRakBm, $paramHasilRakBm) or die( print_r( sqlsrv_errors(), true));
$dataHasilRakBm= sqlsrv_fetch_array($execHasilRakBm);


$callCatatanDomisili = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanDomisili =  array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execCatatanDomisili = sqlsrv_query( $conn, $callCatatanDomisili, $paramCatatanDomisili) or die( print_r( sqlsrv_errors(), true));
$dataCatatanDomisili = sqlsrv_fetch_array($execCatatanDomisili);

$callCatatanDomisiliBm = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanDomisiliBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('BM', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execCatatanDomisiliBm = sqlsrv_query( $conn, $callCatatanDomisiliBm, $paramCatatanDomisiliBm) or die( print_r( sqlsrv_errors(), true));
$dataCatatanDomisiliBm = sqlsrv_fetch_array($execCatatanDomisili);


$callCatatanDomisiliAm = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanDomisiliAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('AM', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN));
$execCatatanDomisiliAm = sqlsrv_query( $conn, $callCatatanDomisiliAm, $paramCatatanDomisiliAm) or die( print_r( sqlsrv_errors(), true));
$dataCatatanDomisiliAm = sqlsrv_fetch_array($execCatatanDomisili);

$callCatatanPemilikRmh = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanPemilikRmh =  array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('NAMA_PEMILIK_RUMAH', SQLSRV_PARAM_IN));
$execCatatanPemilikRmh = sqlsrv_query( $conn, $callCatatanPemilikRmh, $paramCatatanPemilikRmh) or die( print_r( sqlsrv_defaults(), true)); 
$dataCatatanPemilikRmh = sqlsrv_fetch_array($execCatatanPemilikRmh);

$callCatatanGeotaging = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanGeotaging =  array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execCatatanGeotaging = sqlsrv_query( $conn, $callCatatanGeotaging, $paramCatatanGeotaging) or die( print_r( sqlsrv_errors(), true));
$dataCatatanGeotaging = sqlsrv_fetch_array($execCatatanGeotaging);

$callCatatanGeotagingBm = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanGeotagingBm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('BM', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execCatatanGeotagingBm = sqlsrv_query( $conn, $callCatatanGeotagingBm, $paramCatatanGeotagingBm) or die( print_r( sqlsrv_errors(), true));
$dataCatatanGeotagingBm = sqlsrv_fetch_array($execCatatanGeotagingBm);

$callCatatanGeotagingAm = "{call SP_RAK_GET_NOTES(?,?,?)}";
$paramCatatanGeotagingAm =  array(array($app_no, SQLSRV_PARAM_IN),
					array('AM', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN));
$execCatatanGeotagingAm = sqlsrv_query( $conn, $callCatatanGeotagingAm, $paramCatatanGeotagingAm) or die( print_r( sqlsrv_errors(), true));
$dataCatatanGeotagingAm = sqlsrv_fetch_array($execCatatanGeotagingAm);


$callGetVal = "{call SP_RAK_GET_VALIDASI(?,?)}";
$paramGetVal =  array(array($app_no, SQLSRV_PARAM_IN),
								 array('BM', SQLSRV_PARAM_IN));
$execGetVal = sqlsrv_query( $conn, $callGetVal, $paramGetVal) or die( print_r( sqlsrv_errors(), true));
$dataGetVal = sqlsrv_fetch_array($execGetVal);


$callKapasitasKry = "{call SP_RAK_GET_KAPASITAS_KARYAWAN(?,?,?,?)}";
$paramKapasitasKry =  array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('KARYAWAN', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasKry = sqlsrv_query( $conn, $callKapasitasKry, $paramKapasitasKry) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasKry = sqlsrv_fetch_array($execKapasitasKry);


$callKapasitasWrs = "{call SP_RAK_GET_KAPASITAS_WIRASWASTA(?,?,?,?)}";
$paramKapasitasWrs =  array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('WIRASWASTA', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasWrs = sqlsrv_query( $conn, $callKapasitasWrs, $paramKapasitasWrs) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasWrs = sqlsrv_fetch_array($execKapasitasWrs);

$callKapasitasPro = "{call SP_RAK_GET_KAPASITAS_PROFESIONAL(?,?,?,?)}";
$paramKapasitasPro =  array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('PROFESSIONAL', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasPro = sqlsrv_query( $conn, $callKapasitasPro, $paramKapasitasPro) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasPro = sqlsrv_fetch_array($execKapasitasPro);

$callKapasitasNonPro = "{call SP_RAK_GET_KAPASITAS_NON_PROFESIONAL(?,?,?,?)}";
$paramKapasitasNonPro =  array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('NON PROFESIONAL', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasNonPro = sqlsrv_query( $conn, $callKapasitasNonPro, $paramKapasitasKry) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasNonPro = sqlsrv_fetch_array($execKapasitasNonPro);

$callKapasitasKryPasangan = "{call SP_RAK_GET_KAPASITAS_KARYAWAN(?,?,?,?)}";
$paramKapasitasKryPasangan =  array(array($app_no, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('KARYAWAN', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasKryPasangan = sqlsrv_query( $conn, $callKapasitasKryPasangan, $paramKapasitasKryPasangan) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasKryPasangan = sqlsrv_fetch_array($execKapasitasKryPasangan);

$callKapasitasWrsPasangan = "{call SP_RAK_GET_KAPASITAS_WIRASWASTA(?,?,?,?)}";
$paramKapasitasWrsPasangan =  array(array($app_no, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('WIRASWASTA', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasWrsPasangan = sqlsrv_query( $conn, $callKapasitasWrsPasangan, $paramKapasitasWrsPasangan) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasWrsPasangan = sqlsrv_fetch_array($execKapasitasWrsPasangan);

$callKapasitasProPasangan = "{call SP_RAK_GET_KAPASITAS_PROFESIONAL(?,?,?,?)}";
$paramKapasitasProPasangan =  array(array($app_no, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('PROFESSIONAL', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasProPasangan = sqlsrv_query( $conn, $callKapasitasProPasangan, $paramKapasitasProPasangan) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasProPasangan = sqlsrv_fetch_array($execKapasitasProPasangan);

$callKapasitasNonProPasangan = "{call SP_RAK_GET_KAPASITAS_NON_PROFESIONAL(?,?,?,?)}";
$paramKapasitasNonProPasangan =  array(array($app_no, SQLSRV_PARAM_IN),
						array($siapanih1, SQLSRV_PARAM_IN),
						array('NON PROFESIONAL', SQLSRV_PARAM_IN),
						array('BM', SQLSRV_PARAM_IN));
$execKapasitasNonProPasangan = sqlsrv_query( $conn, $callKapasitasNonProPasangan, $paramKapasitasNonProPasangan) or die( print_r( sqlsrv_errors(), true));
$dataKapasitasNonProPasangan = sqlsrv_fetch_array($execKapasitasNonProPasangan);



	if($branchid =="1006" && $branchid =="1005" && $branchid =="1066" && $branchid =="1011" &&
		$branchid =="1026" && $branchid =="1034" && $branchid =="1045" && $branchid =="1056" &&
		$branchid =="1064" && $branchid =="1080" &&	$branchid =="1501" && $branchid =="1502" &&
		$branchid =="1506" && $branchid =="1507" && $branchid =="1512" && $branchid =="1516" &&
		$branchid =="1518" && $branchid =="1524" && $branchid =="1543" && $branchid =="1548" && $branchid =="1031" ||
		$dataSvy['MOS_STAT'] == "NEW" ){
	



$namaLingkungan1='Q0072';
$jawabLingkungan1 = 'Q0073';


$namaLingkungan2='Q0068';
$jawabLingkungan2 = 'Q0069';

$namaLingkungan3='Q0070';
$jawabLingkungan3 = 'Q0071';
	}else{

$namaLingkungan1='32B2ED25-68EE-11E5-8140-25E4131A5084';
$jawabLingkungan1 = 'A914232F-8C8F-11E6-9AF6-6F665E932788';

$namaLingkungan2='34437847-68EE-11E5-8140-CF5A0DD3344C';
$jawabLingkungan2 = 'A2155C3B-6B07-11E5-8140-1DE76E33B28C';

$namaLingkungan3='35C5D199-68EE-11E5-8140-976A28EEAA49';
$jawabLingkungan3 = '803863DD-8C8F-11E6-9AF6-C13DB29DC1A8';
	}


$callLingkungan1 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan1 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($namaLingkungan1, SQLSRV_PARAM_IN));
$execLingkungan1 = sqlsrv_query( $conn, $callLingkungan1, $paramLingkungan1) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan1= sqlsrv_fetch_array($execLingkungan1);

$callLingkungan2 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan2 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($jawabLingkungan1, SQLSRV_PARAM_IN));
$execLingkungan2 = sqlsrv_query( $conn, $callLingkungan2, $paramLingkungan2) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan2= sqlsrv_fetch_array($execLingkungan2);


$callLingkungan3 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan3 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($namaLingkungan2, SQLSRV_PARAM_IN));
$execLingkungan3 = sqlsrv_query( $conn, $callLingkungan3, $paramLingkungan3) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan3= sqlsrv_fetch_array($execLingkungan3);



$callLingkungan4 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan4 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($jawabLingkungan2, SQLSRV_PARAM_IN));
$execLingkungan4 = sqlsrv_query( $conn, $callLingkungan4, $paramLingkungan4) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan4= sqlsrv_fetch_array($execLingkungan4);


$callLingkungan5 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan5 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($namaLingkungan3, SQLSRV_PARAM_IN));
$execLingkungan5 = sqlsrv_query( $conn, $callLingkungan5, $paramLingkungan5) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan5= sqlsrv_fetch_array($execLingkungan5);


$callLingkungan6 = "{call SP_RAK_GET_SURVEY_LINGKUNGAN(?,?)}";
$paramLingkungan6 =  array(array($order_no, SQLSRV_PARAM_IN),
						  array($jawabLingkungan3, SQLSRV_PARAM_IN));
$execLingkungan6 = sqlsrv_query( $conn, $callLingkungan6, $paramLingkungan6) or die( print_r( sqlsrv_errors(), true));
$dataLingkungan6= sqlsrv_fetch_array($execLingkungan6);

$callOrderInfo = "{call SP_RAK_GET_ORDER_INFO(?)}";
$paramOrderInfo =  array(array($app_no, SQLSRV_PARAM_IN));
$execOrderInfo = sqlsrv_query( $conn, $callOrderInfo, $paramOrderInfo) or die( print_r( sqlsrv_errors(), true));
$dataOrderInfo= sqlsrv_fetch_array($execOrderInfo);






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

/*
if(isset($_POST['submit1'])){
	
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	
	//$dataInfo['Pasangan_CUST_MODEL']
	if($dataInfo['CUST_MODEL'] == "KARYAWAN"){
		$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
		$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
		$output5 = "null";
		$output6 = "null";
	}
	
	if($dataInfo['CUST_MODEL'] == "WIRASWASTA"){
		$output3 = "null";
		$output4 = "null";
		$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
		$output6 = "null";
	}
	
	if($dataInfo['CUST_MODEL'] == "PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
	}
	
	
	
	
	$level = 3;
	$role_code = "AM";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace('.', '',$_POST['ph']);
	$otr = str_replace('.', '',$_POST['otr']);
	$tenor = str_replace('.', '',$_POST['tenor']);
	$amount_tdp = str_replace('.', '',$_POST['amount_tdp']);
	$tdp_persen = str_replace('.', '',$_POST['tdp_persen']); 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = $_POST['analisa'];
	$angsuran_new = str_replace('.', '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace('.', '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace('.', '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace('.', '',$_POST['total_pendapatan']);
	$dsr =  str_replace('.', '',$_POST['dsr']); 
	$rekomendasi = "REKOMENDASI";
	$approval = "APPROVE";



	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_errors(), true));		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_errors(), true));		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN_KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_errors(), true));		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_errors(), true));		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_errors(), true));		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_errors(), true));		


	}	
	

	
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_BM(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($approval, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true));
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}


if(isset($_POST['submitNo'])){
	
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	
	//$dataInfo['Pasangan_CUST_MODEL']
	if($dataInfo['CUST_MODEL'] == "KARYAWAN"){
		$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
		$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
		$output5 = "null";
		$output6 = "null";
	}
	
	if($dataInfo['CUST_MODEL'] == "WIRASWASTA"){
		$output3 = "null";
		$output4 = "null";
		$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
		$output6 = "null";
	}
	
	if($dataInfo['CUST_MODEL'] == "PROFESSIONAL"){
		$output3 = "null";
		$output4 = "null";
		$output5 = "null";
		$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
	}
	
	
	
	
	$level = 3;
	$role_code = "AM";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace('.', '',$_POST['ph']);
	$otr = str_replace('.', '',$_POST['otr']);
	$tenor = str_replace('.', '',$_POST['tenor']);
	$amount_tdp = str_replace('.', '',$_POST['amount_tdp']);
	$tdp_persen = str_replace('.', '',$_POST['tdp_persen']); 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = $_POST['analisa'];
	$angsuran_new = str_replace('.', '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace('.', '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace('.', '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace('.', '',$_POST['total_pendapatan']);
	$dsr =  str_replace('.', '',$_POST['dsr']); 
	$rekomendasi = "TIDAK REKOMENDASI";
	$approval = "REJECT";



	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_errors(), true));		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_errors(), true));		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN_KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_errors(), true));		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_errors(), true));		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_errors(), true));		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_errors(), true));		


	}	
	

	
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_BM(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($approval, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true));
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}

*/


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
</style>
<!--<form action="" method="post">-->	

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css"  media="screen" />	 
	<div class="row">
		<div class="col-md-12">
				<form enctype="multipart/form-data" name="form_mutasi_kry" id="form_mutasi_kry" action="" method="post">
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">RINGKASAN APLIKASI KREDIT</td>
									</tr>
									
									
								</table>
							</div>
						<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">RINGKASAN APLIKASI KREDIT (RAK)</td>
									</tr>
									
								
								</table>
							</div>
				 	</div>
						<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									
									<tr>
										<td >AREA</td>
										<td >
											<input type="text" name="area" id="area"  value="<?php echo $dataOrderInfo['AREA_NAME']; ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >CABANG</td>
										<td >
											<input type="text" name="branchid" id="branchid"  value="<?php echo $dataOrderInfo['OFFICE_NAME']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >NAMA DEBITUR</td>
										<td >
											<input type="text" name="debitur" id="debitur"  value="<?php echo $dataInfo['CUST_NAME'];?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >NAMA CA</td>
										<td >
											<input type="text" name="ca" id="ca"  value="<?php echo $dataAnalisCa['CREATE_USER'];?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
								</table>
							</div>
				 	</div>
					<div class="col-md-6 col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									
										<tr>
										<td >No Aplikasi</td>
										<td >
											<input type="text" name="ph" id="ph"  value="<?php echo $app_no;?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Tanggal Applikasi </td>
										<td >
											<input type="text" name="otr" id="otr"  value="<?php echo $dataOrderInfo['APP_DT']->format("d F Y") ; ?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >Nama CMO </td>
										<td >
											<input type="text" name="tenor" id="tenor"  value="<?php echo $dataOrderInfo['CMO'];?>" class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >NAMA Dealer</td>
										<td >
											<input type="text" name="amount_tdp" id="amount_tdp"  value="<?php echo $dataOrderInfo['DEALER_NAME'];?>" class="form-control" readonly onautocomplete="off">
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
										
									</tr>
									<tr>
										<td style="width:20%;">Tanggal Lahir </td>
										<td style="width:30%;">
											<input type="text" name="tanggal_pemohon" class="form-control" value="<?php echo $tgllahirPemohon;?>"  id="ttl_pemohon" readonly>
		
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
									<tr>
										<td style="width:20%;">Status Rumah </td>
										<td style="width:30%;">
											<input type="text" name="profil_status_rumah_pemohon" class="form-control" value="<?php echo $dataCust['MR_HOUSE_OWNERSHIP'];?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Customer Model</td>
										<td style="width:30%;">
											<input type="text" name="profil_cust_model_pemohon" class="form-control" value="<?php echo $dataInfo['CUST_MODEL'];?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Profesi</td>
										<td style="width:30%;">
											<input type="text" name="profil_profesi_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['PROFESI']; ?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Jabatan</td>
										<td style="width:30%;">
											<input type="text" name="profil_jabatan_pemohon" class="form-control" value="-"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Industry Type</td>
										<td style="width:30%;">
											<input type="text" name="profil_industry_nama_pemohon" class="form-control" value="-"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Nama Usaha / Perusahaan</td>
										<td style="width:30%;">
											<input type="text" name="profil_usaha_pemohon" class="form-control" value="<?php echo $dataInfoProfesi['NAMA_PERUSAHAAN']; ?>"   id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Lama Kerja / Usaha (Bulan)</td>
										<td style="width:30%;">
											<input type="text" name="profil_lama_kerja_pemohon" class="form-control" value="<?php echo $dataInfoProfesi['LAMA_BEKERJA'];  ?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr><tr>
										<td style="width:20%;">Pendapatan Per-Bulan</td>
										<td style="width:30%;">
											<input type="text" name="profil_pendapatan_nama_pemohon" class="form-control" value="<?php if($dataCust['PENDAPATAN_PEMOHON'] <> NULL){
											echo number_format($dataCust['PENDAPATAN_PEMOHON'],0,',','.');}else{ echo '-';
												
											}
											?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Pengeluaran Per-Bulan</td>
										<td style="width:30%;">
											<input type="text" name="profil_pengeluaran_nama_pemohon" class="form-control" value="<?php if($dataCust['PENGELUARAN_PEMOHON'] <> NULL){
											echo number_format($dataCust['PENGELUARAN_PEMOHON'],0,',','.');}else{ echo '-';
												
											}
											?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Tujuan Pembiayaan</td>
										<td style="width:30%;">
											<input type="text" name="profil_tujuan_pemohon" class="form-control" value="<?php echo $dataCust['TUJUAN_PEMBIAYAAN'];?>"  id="nama_pemohon" readonly>
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
									<tr>
										<td style="width:20%;">Status Rumah </td>
										<td style="width:30%;">
											<input type="text" name="profil_status_rumah_pemohon" class="form-control" value="<?php echo $dataCust['MR_HOUSE_OWNERSHIP'];?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Customer Model</td>
										<td style="width:30%;">
											<input type="text" name="profil_cust_model_pemohon" class="form-control" value="<?php echo $dataInfo['Pasangan_CUST_MODEL'];?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Profesi</td>
										<td style="width:30%;">
											<input type="text" name="profil_profesi_pemohon" class="form-control" value="<?php echo $profesisaya ?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Jabatan</td>
										<td style="width:30%;">
											<input type="text" name="profil_jabatan_pemohon" class="form-control" value="-"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Industry Type</td>
										<td style="width:30%;">
											<input type="text" name="profil_industry_nama_pemohon" class="form-control" value="-"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Nama Usaha / Perusahaan</td>
										<td style="width:30%;">
											<input type="text" name="profil_usaha_pemohon" class="form-control" value="<?php echo $namaperusahaansaya ?>"   id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Lama Kerja / Usaha (Bulan)</td>
										<td style="width:30%;">
											<input type="text" name="profil_lama_kerja_pemohon" class="form-control" value="<?php echo $lamabekerjasaya ?>"   id="nama_pemohon" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Pendapatan Per-Bulan</td>
										<td style="width:30%;">
											<input type="text" name="profil_pendapatan_nama_pemohon" class="form-control" value="<?php if($dataCust['PENDAPATAN_PASANGAN'] <> NULL){
											echo number_format($dataCust['PENDAPATAN_PASANGAN'],0,',','.');}else{ echo '-';
												
											}
											?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Pengeluaran Per-Bulan</td>
										<td style="width:30%;">
											<input type="text" name="profil_pengeluaran_nama_pemohon" class="form-control" value="<?php if($dataCust['PENGELUARAN_PEMOHON'] <> NULL){
											echo number_format($dataCust['PENGELUARAN_PEMOHON'],0,',','.');}else{ echo '-';
												
											}
											?>"  id="nama_pemohon" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Tujuan Pembiayaan</td>
										<td style="width:30%;">
											<input type="text" name="profil_tujuan_pemohon" class="form-control" value="<?php echo $dataCust['TUJUAN_PEMBIAYAAN'];?>"  id="nama_pemohon" readonly>
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
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Bukti Domisili</td>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('SHM', SQLSRV_PARAM_IN));
													$execDomisili1 = sqlsrv_query( $conn, $callDomisili1, $paramDomisili1,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili1=sqlsrv_fetch_array($execDomisili1);
													$checkDomisili1=sqlsrv_num_rows($execDomisili1);
												
												?>
											
											
												<input type="checkbox" name="shm_ck" id="shm_ck" value="SHM" disabled <?php if ($checkDomisili1 > 0) {echo 'checked';}?>  onclick="myFunctionCk1()">
												<input type="hidden" name="shm_ck1" id="shm_ck1"  value="SHM">
											</td>
										<td style="width:50%;">
											<select name="shm_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('AKTA JUAL BELI', SQLSRV_PARAM_IN));
													$execDomisili2 = sqlsrv_query( $conn, $callDomisili2, $paramDomisili2,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili2=sqlsrv_fetch_array($execDomisili2);
													$checkDomisili2=sqlsrv_num_rows($execDomisili2);
												?>
											
												<input type="checkbox" name="akta_jual_beli_ck" id="akta_jual_beli_ck" disabled value="AKTA JUAL BELI"  <?php if ($checkDomisili2 > 0) {echo 'checked';}?> onclick="myFunctionCk2()">
													<input type="hidden" name="akta_jual_beli_ck1" id="akta_jual_beli_ck1"  value="AKTA JUAL BELI">
											</td>
										<td style="width:50%;">
											<select name="akta_jual_beli_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('SURAT GIRIK', SQLSRV_PARAM_IN));
													$execDomisili3 = sqlsrv_query( $conn, $callDomisili3, $paramDomisili3,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili3=sqlsrv_fetch_array($execDomisili3);
													$checkDomisili3=sqlsrv_num_rows($execDomisili3);
												?>
												<input type="checkbox" name="surat_girik_ck" id="surat_girik_ck"disabled value="SURAT GIRIK"  <?php if ($checkDomisili3 > 0) {echo 'checked';}?> onclick="myFunctionCk3()">
												<input type="hidden" name="surat_girik_ck1" id="surat_girik_ck1"  value="SURAT GIRIK">
											</td>
										<td style="width:50%;">
											<select name="surat_girik_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('PBB', SQLSRV_PARAM_IN));
													$execDomisili4 = sqlsrv_query( $conn, $callDomisili4, $paramDomisili4,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili4=sqlsrv_fetch_array($execDomisili4);
													$checkDomisili4=sqlsrv_num_rows($execDomisili4);
														
												?>
												
												<input type="checkbox" name="pbb_ck" id="pbb_ck" value="PBB"  disabled <?php if ($checkDomisili4 > 0) {echo 'checked';}?> onclick="myFunctionCk4()">
												<input type="hidden" name="pbb_ck1" id="pbb_ck1"  value="PBB">
											</td>
										<td style="width:50%;">
											<select name="pbb_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('REK LISTRIK', SQLSRV_PARAM_IN));
													$execDomisili5 = sqlsrv_query( $conn, $callDomisili5, $paramDomisili5,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili5=sqlsrv_fetch_array($execDomisili5);
													$checkDomisili5=sqlsrv_num_rows($execDomisili5);
												?>
												<input type="checkbox" name="rek_listrik_ck" id="rek_listrik_ck" disabled <?php if ($checkDomisili5 > 0) {echo 'checked';}?> value="REK LISTRIK" onclick="myFunctionCk5()">
												<input type="hidden" name="rek_listrik_ck1" id="rek_listrik_ck1"  value="REK LISTRIK">
											</td>
										<td style="width:50%;">
											<select name="rek_listrik_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('REK LISTRIK', SQLSRV_PARAM_IN));
													$execDomisili6 = sqlsrv_query( $conn, $callDomisili6, $paramDomisili6,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili6=sqlsrv_fetch_array($execDomisili6);
													$checkDomisili6=sqlsrv_num_rows($execDomisili6);
												?>
												<input type="checkbox" name="rek_air_ck" id="rek_air_ck" disabled value="REK AIR"  <?php if ($checkDomisili6 > 0) {echo 'checked';}?> onclick="myFunctionCk6()">
												<input type="hidden" name="rek_air_ck1" id="rek_air_ck1"  value="REK AIR">
											</td>
										<td style="width:50%;">
											<select name="rek_air_val" class="form-control" readonly >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('SURAT KEPUTUSAN RUMAH DINAS', SQLSRV_PARAM_IN));
													$execDomisili7 = sqlsrv_query( $conn, $callDomisili7, $paramDomisili7,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili7=sqlsrv_fetch_array($execDomisili7);
													$checkDomisili7=sqlsrv_num_rows($execDomisili7);
												?>
												<input type="checkbox" name="skrd_ck" id="skrd_ck" disabled value="SURAT KEPUTUSAN RUMAH DINAS" onclick="myFunctionCk7()">
												<input type="hidden" name="skrd_ck1" id="skrd_ck1"  value="SURAT KEPUTUSAN RUMAH DINAS">
											</td>
										<td style="width:50%;">
											<select name="skrd_val" class="form-control" readonly>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('STATUS_RUMAH', SQLSRV_PARAM_IN));
													$execDomisili8 = sqlsrv_query( $conn, $callDomisili8, $paramDomisili8,$options) or die( print_r( sqlsrv_errors(), true));
													$dataDomisili8=sqlsrv_fetch_array($execDomisili8);
													$checkDomisili8=sqlsrv_num_rows($execDomisili8);
												?>
												
											<select name="status_rumah_val" class="form-control" readonly >
														<option value="">--Pilih--</option>
														<option value="COMPANY" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "COMPANY" ) {echo 'selected';}?> >COMPANY</option>
														<option value="FAMILY" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "FAMILY" ) {echo 'selected';}?> >FAMILY HOUSE</option>
														<option value="MORTGAGE" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "MORTGAGE" ) {echo 'selected';}?>>MORTGAGE</option>
														<option value="RENT" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "RENT" ) {echo 'selected';}?>>RENT</option>
														<option value="SELF" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "SELF" ) {echo 'selected';}?>>SELF OWNED</option>
														<option value="SPOUSE" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "SPOUSE" ) {echo 'selected';}?>>SPOUSE OWNED</option>
														<option value="OTHERS" <?php if ($dataDomisili8['VALIDASI_DOKUMEN'] == "OTHERS" ) {echo 'selected';}?> >OTHERS</option>
											</select>   
										</td>
									</tr>
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
						<div class="col-md-6 col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered">
								
						

									<tr>
										<td style="width:30%;">CARA VALIDASI</td>
										<td colspan= "2">
											<select name="domisili_val" class="form-control" readonly>
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
										<td style="width:30%;">NOTES CA</td>
										<td colspan="2">
													<textarea name="catatan_domisili_ca" id="catatan_domisili_ca" value="<?php echo $dataCatatanDomisili['NOTES']; ?>" class="form-control" readonly> <?php echo $dataCatatanDomisili['NOTES']; ?></textarea>
													
										</td>
									</tr>
									<tr>
												<td >Validasi Domisili CA </td>
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
										<td style="width:30%;">NOTES BM</td>
										<td colspan="2">
													<textarea name="catatan_domisili_bm" id="catatan_domisili_bm" value="<?php echo $dataCatatanDomisiliBm['NOTES']; ?>" class="form-control" readonly> <?php echo $dataCatatanDomisiliBm['NOTES']; ?></textarea>
													
										</td>
									</tr>
									<tr>
												<td >Validasi Domisili BM</td>
													<td colspan="2" >
														<?php if($imgDomisiliBm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliBm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliBm);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									
									<tr>
										<td style="width:30%;">NOTES AM</td>
										<td colspan="2">
													<textarea name="catatan_domisili_am" id="catatan_domisili_bm" value="<?php echo $dataCatatanDomisiliAm['NOTES']; ?>" class="form-control" readonly> <?php echo $dataCatatanDomisiliBm['NOTES']; ?></textarea>
													
										</td>
									</tr>
									<tr>
												<td >Validasi Domisili BM</td>
													<td colspan="2" >
														<?php if($imgDomisiliAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($imgDomisiliAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">BUKTI KAPASITAS -  ANALISA KAPASITAS & DSR</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">

								
									<tr>
										<td style="width:30%;">STATUS PEKERJAAN PEMOHON</td>
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
											<select name="join_income" id="join_income" class="form-control" onchange="myFunction()" readonly>
													<option value="">--- Pilih ---</option>
														<option value="YA" <?php if ($dataAnalisBm['JOIN_INCOME'] == "YA" ) {echo 'selected';}?>>YA</option>
														<option value="TIDAK" <?php if ($dataAnalisBm['JOIN_INCOME'] == "TIDAK" ) {echo 'selected';}?>>TIDAK</option>
													
											</select> 
									
										</td>
									
									</tr>
									
										
											
										
								
									
								</table>
							</div>	
							
						</div>
						
					</div>
					</div>
					<?php if ($dataAnalisBm['JOIN_INCOME'] == "YA") { ?>
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
											<select name="cust_model_pemohon" class="form-control" disabled>
														<option value="KARYAWAN">KARYAWAN</option>
														<option value="WIRASWASTA">WIRASWASTA</option>
														<option value="PROFESSIONAL">PROFESIONAL</option>
											</select>   
										</td>
									
									</tr>
									
								</table>
							</div>								
						</div>
						*/ ?>
						
						
					</div>
					</div>
					
					<input type="hidden" name="app_no_hide" id="app_no_hide"  value="<?php echo $app_no;?>">
										<input type="hidden" name="nama_pemohon_hide" id="nama_pemohon_hide"  value="<?php echo $dataInfo['CUST_NAME'];?>">
										<input type="hidden" name="user_hide" id="user_hide"  value="<?php echo $user;?>">
										<input type="hidden" name="branchid_hide" id="branchid_hide"  value="<?php echo $branchid;?>">
										<input type="hidden" name="cust_type_pasangan_hide" id="cust_type_pasangan_hide"  value="<?php echo $siapanih;?>">
					
					<!------------------Karyawan -->
					<?php if($dataInfo['CUST_MODEL'] == 'KARYAWAN'){ ?>
					
					<div id="kry_pemohon_div">
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">KARYAWAN PEMOHON</td>
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
											 <select name="nama_perusahaan_pemohon_val" class="form-control" disabled>
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
											 <select name="jabatan_val" class="form-control" disabled>
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
											 <select name="industry_type_val" class="form-control" disabled>
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
											 <select name="lama_bekerja_val" class="form-control" disabled>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SLIP GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry1 = sqlsrv_query( $conn, $callKapasitasKry1, $paramKapasitasKry1,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry1 = sqlsrv_fetch_array($execKapasitasKry1);
													$checkKapasitasKry1 = sqlsrv_num_rows($execKapasitasKry1);
												?>
											<input type="checkbox" class="aroClass" name="slip_gaji_pemohon_ck" disabled id="slip_gaji_pemohon_ck" value="SLIP GAJI" <?php if ($checkKapasitasKry1 > 0) {echo 'checked';}?> onclick="FuncKryPemohon1()">
												<input type="hidden" name="slip_gaji_pemohon_ck1" id="slip_gaji_pemohon_ck1"  value="SLIP GAJI">
										</td>
										<td style="width:50%;">
											 <select name="slip_gaji_pemohon_val" disabled class="form-control" >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('DAFTAR GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKry2 = sqlsrv_query( $conn, $callKapasitasKry2, $paramKapasitasKry2,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry2 = sqlsrv_fetch_array($execKapasitasKry2);
													$checkKapasitasKry2 = sqlsrv_num_rows($execKapasitasKry2);
												?>
											<input type="checkbox" class="aroClass" name="daftar_gaji_pemohon_ck" disabled id="daftar_gaji_pemohon_ck" <?php if ($checkKapasitasKry2 > 0) {echo 'checked';}?> value="DAFTAR GAJI" onclick="FuncKryPemohon2()">
											<input type="hidden" name="daftar_gaji_pemohon_ck1" id="daftar_gaji_pemohon_ck1"  value="DAFTAR GAJI">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pemohon_val" class="form-control" disabled >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKry3 = sqlsrv_query( $conn, $callKapasitasKry3, $paramKapasitasKry3,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry3 = sqlsrv_fetch_array($execKapasitasKry3);
													$checkKapasitasKry3 = sqlsrv_num_rows($execKapasitasKry3);
												?>
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pemohon_ck" disabled id="surat_ket_penghasilan_pemohon_ck"  <?php if ($checkKapasitasKry3 > 0) {echo 'checked';}?>  value="SURAT KETERANGAN PENGHASILAN" onclick="FuncKryPemohon3()">
											<input type="hidden" name="surat_ket_penghasilan_pemohon_ck1" id="surat_ket_penghasilan_pemohon_ck1"  value="SURAT KETERANGAN PENGHASILAN">
										</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pemohon_val" class="form-control" disabled >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKry4 = sqlsrv_query( $conn, $callKapasitasKry4, $paramKapasitasKry4,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry4 = sqlsrv_fetch_array($execKapasitasKry4);
													$checkKapasitasKry4 = sqlsrv_num_rows($execKapasitasKry4);
												?>
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pemohon_ck"disabled id="bukti_saldo_print_jamsos_pemohon_ck"  <?php if ($checkKapasitasKry4 > 0) {echo 'checked';}?>  value="BUKTI SALDO PRINT SCREEN JAMSOSTEK" onclick="FuncKryPemohon4()"> 
											<input type="hidden" name="bukti_saldo_print_jamsos_pemohon_ck1" id="bukti_saldo_print_jamsos_pemohon_ck1"  value="BUKTI SALDO PRINT SCREEN JAMSOSTEK">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pemohon_val" class="form-control" disabled>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasKry5 = sqlsrv_query( $conn, $callKapasitasKry5, $paramKapasitasKry5,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry5 = sqlsrv_fetch_array($execKapasitasKry5);
													$checkKapasitasKry5 = sqlsrv_num_rows($execKapasitasKry5);
												?>
											<input type="checkbox" class="aroClass" name="bukti_spt_pemohon_ck" id="bukti_spt_pemohon_ck" disabled<?php if ($checkKapasitasKry5 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR"  onclick="FuncKryPemohon5()">
											<input type="hidden" name="bukti_spt_pemohon_ck1" id="bukti_spt_pemohon_ck1"  value="BUKTI SPT PAJAK TAHUN TERAKHIR">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pemohon_val" class="form-control" disabled>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('REKENING TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasKry6 = sqlsrv_query( $conn, $callKapasitasKry6, $paramKapasitasKry6,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry6 = sqlsrv_fetch_array($execKapasitasKry6);
													$checkKapasitasKry6 = sqlsrv_num_rows($execKapasitasKry6);
												?>
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pemohon_ck"disabled id="rekening_tabungan_pemohon_ck"  <?php if ($checkKapasitasKry6 > 0) {echo 'checked';}?> value="REKENING TABUNGAN" onclick="FuncKryPemohon6()">
											<input type="hidden" name="rekening_tabungan_pemohon_ck1" id="rekening_tabungan_pemohon_ck1"  value="REKENING TABUNGAN">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pemohon_val" class="form-control"disabled >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('CA', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('FOTO KARTU IDENTITAS KARYAWAN', SQLSRV_PARAM_IN));
													$execKapasitasKry7 = sqlsrv_query( $conn, $callKapasitasKry7, $paramKapasitasKry7,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKry7 = sqlsrv_fetch_array($execKapasitasKry7);
													$checkKapasitasKry7 = sqlsrv_num_rows($execKapasitasKry7);
												?>
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pemohon_ck" disabled id="foto_kartu_identitas_pemohon_ck"  <?php if ($checkKapasitasKry7 > 0) {echo 'checked';}?> value="FOTO KARTU IDENTITAS KARYAWAN" onclick="FuncKryPemohon7()">
											<input type="hidden" name="foto_kartu_identitas_pemohon_ck1" id="foto_kartu_identitas_pemohon_ck1"  value="FOTO KARTU IDENTITAS KARYAWAN">
										</td> 
										<td style="width:50%;">
										<select name="foto_kartu_identitas_pasangan_val" class="form-control" disabled>
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
											 <select name="validasi_karyawan_pemohon" class="form-control" Disabled>
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
												<td >Validasi Kapasitas CA </td>
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
												<td >Validasi Kapasitas BM </td>
													<td colspan="2" >
													<?php 
														
														$callImgKunjBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
														$paramImgKunjBm =  array(array($app_no, SQLSRV_PARAM_IN),
																			array('PEMOHON', SQLSRV_PARAM_IN),
																			array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
														$execImgKunjBm = sqlsrv_query( $conn, $callImgKunjBm, $paramImgKunjBm) or die( print_r( sqlsrv_errors(), true));
														$dataImgKunjBm= sqlsrv_fetch_array($execImgKunjBm);
														$ImgKunjBm = $dataImgKunjBm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKunjBm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjBm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjBm);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>	
									<tr>
												<td >Validasi Kapasitas AM </td>
													<td colspan="2" >
													<?php 
														
														$callImgKunjAm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
														$paramImgKunjAm =  array(array($app_no, SQLSRV_PARAM_IN),
																			array('PEMOHON', SQLSRV_PARAM_IN),
																			array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
														$execImgKunjAm = sqlsrv_query( $conn, $callImgKunjAm, $paramImgKunjAm) or die( print_r( sqlsrv_errors(), true));
														$dataImgKunjAm= sqlsrv_fetch_array($execImgKunjAm);
														$ImgKunjAm = $dataImgKunjAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKunjAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
										<input type="hidden" name="app_no_hide" id="app_no_hide"  value="<?php echo $app_no;?>">
										<input type="hidden" name="nama_pemohon_hide" id="nama_pemohon_hide"  value="<?php echo $dataInfo['CUST_NAME'];?>">
										<input type="hidden" name="user_hide" id="user_hide"  value="<?php echo $user;?>">
										<input type="hidden" name="branchid_hide" id="branchid_hide"  value="<?php echo $branchid;?>">
										<input type="hidden" name="cust_type_hide" id="cust_type_hide"  value="Pemohon">
										<input type="hidden" name="cust_model_kry_hide" id="cust_model_kry_hide"  value="KARYAWAN">
											
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
										<select name="mutasi_karyawan" class="form-control" disabled >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka" selected>Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
														
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
											 <select name="validasi_karyawan_pemohon" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
								
								
									<tr>
												<td >Validasi Bukti TF CA </td>
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
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
														$callImgKryBankBm = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
														$paramImgKryBankBm =  array(array($app_no, SQLSRV_PARAM_IN),
																			array('PEMOHON', SQLSRV_PARAM_IN),
																			array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
														$execImgKryBankBm = sqlsrv_query( $conn, $callImgKryBankBm, $paramImgKryBankBm) or die( print_r( sqlsrv_errors(), true));
														$dataImgKryBankBm = sqlsrv_fetch_array($execImgKryBankBm);
														$ImgKryBankBm = $dataImgKryBankBm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKryBankBm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankBm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankBm);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									<tr>
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
														$callImgKryBankAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
														$paramImgKryBankAm =  array(array($app_no, SQLSRV_PARAM_IN),
																			array('PEMOHON', SQLSRV_PARAM_IN),
																			array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
														$execImgKryBankAm = sqlsrv_query( $conn, $callImgKryBankAm, $paramImgKryBankAm) or die( print_r( sqlsrv_errors(), true));
														$dataImgKryBankAm = sqlsrv_fetch_array($execImgKryBankAm);
														$ImgKryBankAm = $dataImgKryBankAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKryBankAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
					
					 <div id="tabeldata">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
					<?php } ?>
					
					<!------------------Karyawan Pasangan -->
					<?php if ($dataAnalisBm['JOIN_INCOME'] == "YA" && $dataAnalisBm['CUST_MODEL_PASANGAN'] == "KARYAWAN" ) { ?>
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
											 <select name="nama_perusahaan_pasangan_val" class="form-control" disabled>
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
											 <select name="jabatan_val" class="form-control" disabled>
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
											 <select name="industry_type_val" class="form-control" disabled>
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
											 <select name="lama_bekerja_val" class="form-control" disabled>
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
													$callKapasitasKryPas1 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas1 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SLIP GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKryPas1 = sqlsrv_query( $conn, $callKapasitasKryPas1, $paramKapasitasKryPas1,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas1 = sqlsrv_fetch_array($execKapasitasKryPas1);
													$checkKapasitasKryPas1 = sqlsrv_num_rows($execKapasitasKryPas1);
												?>
											<input type="checkbox" class="aroClass" name="slip_gaji_pasangan_ck" id="slip_gaji_pasangan_ck" value="SLIP GAJI" <?php if ($checkKapasitasKryPas1 > 0) {echo 'checked';}?> onclick="FuncKryPemohon1()">
												<input type="hidden" name="slip_gaji_pasangan_ck1" id="slip_gaji_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="slip_gaji_pasangan_val" class="form-control" disabled>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKryPas1['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">DAFTAR GAJI</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKryPas2 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas2 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('DAFTAR GAJI', SQLSRV_PARAM_IN));
													$execKapasitasKryPas2 = sqlsrv_query( $conn, $callKapasitasKryPas2, $paramKapasitasKryPas2,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas2 = sqlsrv_fetch_array($execKapasitasKryPas2);
													$checkKapasitasKryPas2 = sqlsrv_num_rows($execKapasitasKryPas2);
												?>
											<input type="checkbox" class="aroClass" name="daftar_gaji_pasangan_ck" id="daftar_gaji_pasangan_ck" <?php if ($checkKapasitasKryPas2 > 0) {echo 'checked';}?> value="DAFTAR GAJI" onclick="FuncKryPemohon2()">
											<input type="hidden" name="daftar_gaji_pasangan_ck1" id="daftar_gaji_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"<?php if ($dataKapasitasKryPas2['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">SURAT KETERANGAN PENGHASILAN</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKryPas3 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas3 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKryPas3 = sqlsrv_query( $conn, $callKapasitasKryPas3, $paramKapasitasKryPas3,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas3 = sqlsrv_fetch_array($execKapasitasKryPas3);
													$checkKapasitasKryPas3 = sqlsrv_num_rows($execKapasitasKryPas3);
												?>
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pasangan_ck" id="surat_ket_penghasilan_pasangan_ck"  <?php if ($checkKapasitasKryPas3 > 0) {echo 'checked';}?>  value="SURAT KETERANGAN PENGHASILAN" onclick="FuncKryPemohon3()">
											<input type="hidden" name="surat_ket_penghasilan_pasangan_ck1" id="surat_ket_penghasilan_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKryPas3['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">BUKTI SALDO PRINT SCREEN JAMSOSTEK</td>
										<td style="width:10%;">
											<?php 
													$callKapasitasKryPas4 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas4 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('SURAT KETERANGAN PENGHASILAN', SQLSRV_PARAM_IN));
													$execKapasitasKryPas4 = sqlsrv_query( $conn, $callKapasitasKryPas4, $paramKapasitasKryPas4,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas4 = sqlsrv_fetch_array($execKapasitasKryPas4);
													$checkKapasitasKryPas4 = sqlsrv_num_rows($execKapasitasKryPas4);
												?>
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pasangan_ck" id="bukti_saldo_print_jamsos_pasangan_ck"  <?php if ($checkKapasitasKryPas4 > 0) {echo 'checked';}?>  value="BUKTI SALDO PRINT SCREEN JAMSOSTEK" onclick="FuncKryPemohon4()"> 
											<input type="hidden" name="bukti_saldo_print_jamsos_pasangan_ck1" id="bukti_saldo_print_jamsos_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID <?php if ($dataKapasitasKryPas4['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									<tr>
										<td style="width:30%;">BUKTI SPT PAJAK TAHUN TERAKHIR</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKryPas5 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas5 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasKryPas5 = sqlsrv_query( $conn, $callKapasitasKryPas5, $paramKapasitasKryPas5,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas5 = sqlsrv_fetch_array($execKapasitasKryPas5);
													$checkKapasitasKryPas5 = sqlsrv_num_rows($execKapasitasKryPas5);
												?>
											<input type="checkbox" class="aroClass" name="bukti_spt_pasangan_ck" id="bukti_spt_pasangan_ck" <?php if ($checkKapasitasKryPas5 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR"  onclick="FuncKryPemohon5()">
											<input type="hidden" name="bukti_spt_pasangan_ck1" id="bukti_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKryPas5['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">REKENING TABUNGAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKryPas6 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas6 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('REKENING TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasKryPas6 = sqlsrv_query( $conn, $callKapasitasKryPas6, $paramKapasitasKryPas6,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas6 = sqlsrv_fetch_array($execKapasitasKryPas6);
													$checkKapasitasKryPas6 = sqlsrv_num_rows($execKapasitasKryPas6);
												?>
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pasangan_ck" id="rekening_tabungan_pasangan_ck"  <?php if ($checkKapasitasKryPas6 > 0) {echo 'checked';}?> value="REKENING TABUNGAN" onclick="FuncKryPemohon6()">
											<input type="hidden" name="rekening_tabungan_pasangan_ck1" id="rekening_tabungan_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID"  <?php if ($dataKapasitasKryPas6['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">FOTO KARTU IDENTITAS KARYAWAN</td>
										<td style="width:10%;">
										<?php 
													$callKapasitasKryPas7 = "{call GET_RAK_CHECK_KAPASITAS(?,?,?,?,?)}";
													$options =  array( "Scrollable" => "buffered" );
													$paramKapasitasKryPas7 = array(
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('KARYAWAN', SQLSRV_PARAM_IN),
																	array('FOTO KARTU IDENTITAS KARYAWAN', SQLSRV_PARAM_IN));
													$execKapasitasKryPas7 = sqlsrv_query( $conn, $callKapasitasKryPas7, $paramKapasitasKryPas7,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasKryPas7 = sqlsrv_fetch_array($execKapasitasKryPas7);
													$checkKapasitasKryPas7 = sqlsrv_num_rows($execKapasitasKryPas7);
												?>
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pasangan_ck" id="foto_kartu_identitas_pasangan_ck"  <?php if ($checkKapasitasKryPas7 > 0) {echo 'checked';}?> value="FOTO KARTU IDENTITAS KARYAWAN" onclick="FuncKryPemohon7()">
											<input type="hidden" name="foto_kartu_identitas_pasangan_ck1" id="foto_kartu_identitas_pasangan_ck1"  value="">
										</td> 
										<td style="width:50%;">
										<select name="foto_kartu_identitas_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID" <?php if ($dataKapasitasKryPas7['VALIDASI_KAPASITAS'] == "TIDAK VALID" ) {echo 'selected';}?>>TIDAK VALID</option>
													
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
											 <select name="validasi_karyawan_pasangan" class="form-control" disabled>
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
												<td >Validasi Kapasitas CA </td>
													<td colspan="2" >
													<?php 
													$callImgKunjPas = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgKunjPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKunjPas = sqlsrv_query( $conn, $callImgKunjPas, $paramImgKunjPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgKunjPas= sqlsrv_fetch_array($execImgKunjPas);
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
												<td >Validasi Kapasitas BM </td>
													<td colspan="2" >
													<?php 
													$callImgKunjBmPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgKunjBmPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKunjBmPas = sqlsrv_query( $conn, $callImgKunjBmPas, $paramImgKunjBmPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgKunjBmPas= sqlsrv_fetch_array($execImgKunjBmPas);
													$ImgKunjBmPas = $dataImgKunjBmPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKunjBmPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjBmPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjBmPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>	
									
									<tr>
												<td >Validasi Kapasitas AM </td>
													<td colspan="2" >
													<?php 
													$callImgKunjAmPas = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgKunjAmPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKunjAmPas = sqlsrv_query( $conn, $callImgKunjAmPas, $paramImgKunjAmPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgKunjAmPas= sqlsrv_fetch_array($execImgKunjAmPas);
													$ImgKunjAmPas = $dataImgKunjAmPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKunjAmPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjAmPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKunjAmPas);?>" style="height:300px;width:200px;"  class="img-custom">
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
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
								
										<input type="hidden" name="cust_model_kry_hide" id="cust_model_kry_hide"  value="KARYAWAN">
											
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
										<select name="mutasi_karyawan_pasangan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka"  <?php if ($dataKapasitasKryPasangan['MUTASI_YANG_DILAMPIRKAN'] == "Terbaru/Baru Buka" ) {echo 'selected';}?> >Terbaru/Baru Buka</option>
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
											 <select name="validasi_karyawan_pasangan" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
										<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgKryBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgKryBankPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKryBankPas = sqlsrv_query( $conn, $callImgKryBankPas, $paramImgKryBankPas) or die( print_r( sqlsrv_errors(), true));
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
											<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgKryBankBmPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgKryBankBmPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKryBankBmPas = sqlsrv_query( $conn, $callImgKryBankBmPas, $paramImgKryBankBmPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgKryBankBmPas = sqlsrv_fetch_array($execImgKryBankBmPas);
													$ImgKryBankBmPas = $dataImgKryBankBmPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKryBankBmPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankBmPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankBmPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									<tr>
											<td >Validasi Bukti TF AM</td>
													<td colspan="2" >
													<?php 
													
													$callImgKryBankAmPas = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgKryBankAmPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN));
													$execImgKryBankAmPas = sqlsrv_query( $conn, $callImgKryBankAmPas, $paramImgKryBankAmPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgKryBankAmPas = sqlsrv_fetch_array($execImgKryBankAmPas);
													$ImgKryBankAmPas = $dataImgKryBankAmPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgKryBankAmPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankAmPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgKryBankAmPas);?>" style="height:300px;width:200px;"  class="img-custom">
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs1 = sqlsrv_query( $conn, $callKapasitasWrs1, $paramKapasitasWrs1,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrs1 = sqlsrv_fetch_array($execKapasitasWrs1);
													$checkKapasitasWrs1 = sqlsrv_num_rows($execKapasitasWrs1);
												?>				
											<input type="checkbox" disabled name="rek_tabungan_pemohon_wrs_ck" id="rek_tabungan_pemohon_wrs_ck" value="REK TABUNGAN" <?php if ($checkKapasitasWrs1 > 0) {echo 'checked';}?> onclick="FuncWrsPemohon1()">
										</td>
										<input type="hidden" name="rek_tabungan_pemohon_wrs_ck1" id="rek_tabungan_pemohon_wrs_ck1"  value="">
										<td style="width:50%;">
											 <select disabled name="rek_tabungan_pemohon_val" class="form-control" >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PEMBELIAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs2 = sqlsrv_query( $conn, $callKapasitasWrs2, $paramKapasitasWrs2,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrs2 = sqlsrv_fetch_array($execKapasitasWrs2);
													$checkKapasitasWrs2 = sqlsrv_num_rows($execKapasitasWrs2);
												?>
											<input type="checkbox" disabled name="nota_pembelian_wrs_pemohon_ck" id="nota_pembelian_wrs_pasangan_ck" <?php if ($checkKapasitasWrs2 > 0) {echo 'checked';}?> value="NOTA PEMBELIAN" onclick="FuncWrsPemohon2()">
										</td>
										<input type="hidden" name="nota_pembelian_wrs_pemohon_ck1" id="nota_pembelian_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select disabled name="nota_pembelian_pasangan_val" class="form-control" >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PENJUALAN', SQLSRV_PARAM_IN));
													$execKapasitasWrs3 = sqlsrv_query( $conn, $callKapasitasWrs3, $paramKapasitasWrs3,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrs3 = sqlsrv_fetch_array($execKapasitasWrs3);
													$checkKapasitasWrs3 = sqlsrv_num_rows($execKapasitasWrs3);
												?>
											<input type="checkbox" disabled name="nota_penjualan_wrs_pasangan_ck" id="nota_penjualan_wrs_pasangan_ck" <?php if ($checkKapasitasWrs3 > 0) {echo 'checked';}?> value="NOTA PENJUALAN" onclick="FuncWrsPemohon3()">
										</td>
										<input type="hidden" name="nota_penjualan_wrs_pasangan_ck1" id="nota_penjualan_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select disabled name="nota_penjualan_pasangan_val" class="form-control" >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasWrs4 = sqlsrv_query( $conn, $callKapasitasWrs4, $paramKapasitasWrs4,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrs4 = sqlsrv_fetch_array($execKapasitasWrs4);
													$checkKapasitasWrs4 = sqlsrv_num_rows($execKapasitasWrs4);
												?>
											<input type="checkbox" disabled  name="spt_wrs_pasangan_ck" id="spt_wrs_pasangan_ck" <?php if ($checkKapasitasWrs4 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR" onclick="FuncWrsPemohon4()">
												<input type="hidden" name="spt_wrs_pasangan_ck1" id="spt_wrs_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select disabled name="spt_wrs_pasangan_val" class="form-control" >
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
										<select name="wrs_pemohon_mutasi" class="form-control" disabled >
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
											 <select name="validasi_wrs_pemohon" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBank = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgWirBank =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBank = sqlsrv_query( $conn, $callImgWirBank, $paramImgWirBank) or die( print_r( sqlsrv_errors(), true));
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
								
										<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankBM = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgWirBankBM =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankBM = sqlsrv_query( $conn, $callImgWirBankBM, $paramImgWirBankBM) or die( print_r( sqlsrv_errors(), true));
													$dataImgWirBankBM = sqlsrv_fetch_array($execImgWirBankBM);
													$ImgWirBankBM = $dataImgWirBankBM['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBankBM <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankBM);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankBM);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
									<tr>
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgWirBankAm =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankAm = sqlsrv_query( $conn, $callImgWirBankAm, $paramImgWirBankAm) or die( print_r( sqlsrv_errors(), true));
													$dataImgWirBankAm = sqlsrv_fetch_array($execImgWirBankAm);
													$ImgWirBankAm = $dataImgWirBankAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBankAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
											<select name="nota_lampiran_pemohon" disabled class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Nota Penjualan" <?php if ($dataKapasitasWrs['LAMPIRAN_NOTA'] == "Nota Penjualan" ) {echo 'selected';}?> >Nota Penjualan</option>
														<option value="Nota Belanja"  <?php if ($dataKapasitasWrs['LAMPIRAN_NOTA'] == "Nota Belanja" ) {echo 'selected';}?>>Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pemohon" class="form-control" disabled >
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
										<td style="width:30%;">RATA-RATA PENDAPATAN USAHA (Berdasarkan Nota)</td>
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
					</div>
					<?php } ?>
					<!--- PASANGAN WIRASWASTA-->
					<?php if ($dataAnalisBm['JOIN_INCOME'] == "YA" && $dataAnalisBm['CUST_MODEL_PASANGAN'] == "WIRASWASTA" ) { ?>
					
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas1 = sqlsrv_query( $conn, $callKapasitasWrsPas1, $paramKapasitasWrsPas1,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrsPas1 = sqlsrv_fetch_array($execKapasitasWrsPas1);
													$checkKapasitasWrsPas1 = sqlsrv_num_rows($execKapasitasWrsPas1);
												?>
											<input type="checkbox"  name="rek_tabungan_pasangan_wrs_ck" id="rek_tabungan_pasangan_wrs_ck" value="REK TABUNGAN" <?php if ($checkKapasitasWrsPas1 > 0) {echo 'checked';}?> onclick="FuncWrsPasangan1()" disabled>
										</td>
										<input type="hidden" name="rek_tabungan_pasangan_wrs_ck1" id="rek_tabungan_pasangan_wrs_ck1"  value="REK TABUNGAN">
										<td style="width:50%;">
											 <select name="rek_tabungan_pasangan_val" class="form-control" disabled >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PEMBELIAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas2 = sqlsrv_query( $conn, $callKapasitasWrsPas2, $paramKapasitasWrsPas2,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrsPas2 = sqlsrv_fetch_array($execKapasitasWrsPas2);
													$checkKapasitasWrsPas2 = sqlsrv_num_rows($execKapasitasWrsPas2);
												?>
											<input type="checkbox"  name="nota_pembelian_wrs_pasangan_ck" id="nota_pembelian_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas2 > 0) {echo 'checked';}?> value="NOTA PEMBELIAN" onclick="FuncWrsPasangan2()" disabled>
										</td>
										<input type="hidden" name="nota_pembelian_wrs_pasangan_ck1" id="nota_pembelian_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_pembelian_pasangan_val" class="form-control" disabled>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('NOTA PENJUALAN', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas3 = sqlsrv_query( $conn, $callKapasitasWrsPas3, $paramKapasitasWrsPas3,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrsPas3 = sqlsrv_fetch_array($execKapasitasWrsPas3);
													$checkKapasitasWrsPas3 = sqlsrv_num_rows($execKapasitasWrsPas3);
												?>
											<input type="checkbox"  name="nota_penjualan_wrs_pasangan_ck" id="nota_penjualan_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas3 > 0) {echo 'checked';}?> value="NOTA PENJUALAN" onclick="FuncWrsPasangan3()" disabled>
										</td>
										<input type="hidden" name="nota_penjualan_wrs_pasangan_ck1" id="nota_penjualan_wrs_pasangan_ck1"  value="NOTA PENJUALAN">
										<td style="width:50%;">
											 <select name="nota_penjualan_pasangan_val" class="form-control"disabled >
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('WIRASWASTA', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasWrsPas4 = sqlsrv_query( $conn, $callKapasitasWrsPas4, $paramKapasitasWrsPas4,$options) or die( print_r( sqlsrv_errors(), true));
													$dataKapasitasWrsPas4 = sqlsrv_fetch_array($execKapasitasWrsPas4);
													$checkKapasitasWrsPas4 = sqlsrv_num_rows($execKapasitasWrsPas4);
												?>
											<input type="checkbox"  name="spt_wrs_pasangan_ck" id="spt_wrs_pasangan_ck" <?php if ($checkKapasitasWrsPas4 > 0) {echo 'checked';}?> value="BUKTI SPT PAJAK TAHUN TERAKHIR" onclick="FuncWrsPasangan4()" disabled>
												<input type="hidden" name="spt_wrs_pasangan_ck1" id="spt_wrs_pasangan_ck1"  value="BUKTI SPT PAJAK TAHUN TERAKHIR">
										</td>
										<td style="width:50%;">
											 <select name="spt_wrs_pasangan_val" class="form-control" disabled >
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
											 <input type="text" name="wrs_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="wrs_pasangan_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pasangan_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="wrs_pasangan_norek" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="wrs_pasangan_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="wrs_pasangan_rekening" readonly >
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan  </td>
										<td style="width:50%;">
										<select name="wrs_pasangan_mutasi" class="form-control" disabled >
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
											 <select name="validasi_wrs_pasangan" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgWirBankPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankPas = sqlsrv_query( $conn, $callImgWirBankPas, $paramImgWirBankPas) or die( print_r( sqlsrv_errors(), true));
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
										<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankBMPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgWirBankBMPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankBMPas = sqlsrv_query( $conn, $callImgWirBankBMPas, $paramImgWirBankBMPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgWirBankBMPas = sqlsrv_fetch_array($execImgWirBankBMPas);
													$ImgWirBankBMPas = $dataImgWirBankBMPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBankBMPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankBMPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankBMPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
									<tr>
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
													
													$callImgWirBankAmPas = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgWirBankAmPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN));
													$execImgWirBankAmPas = sqlsrv_query( $conn, $callImgWirBankAmPas, $paramImgWirBankAmPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgWirBankAmPas = sqlsrv_fetch_array($execImgWirBankAmPas);
													$ImgWirBankAmPas = $dataImgWirBankAmPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgWirBankAmPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankAmPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgWirBankAmPas);?>" style="height:300px;width:200px;"  class="img-custom">
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
											<select name="nota_lampiran_pasangan" class="form-control" disabled  >
														<option value="">--Pilih--</option>
														<option value="Nota Penjualan" <?php if ($dataKapasitasWrsPasangan['LAMPIRAN_NOTA'] == "Nota Penjualan" ) {echo 'selected';}?> >Nota Penjualan</option>
														<option value="Nota Belanja"  <?php if ($dataKapasitasWrsPasangan['LAMPIRAN_NOTA'] == "Nota Belanja" ) {echo 'selected';}?>>Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pasangan" class="form-control" disabled>
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
										<td style="width:30%;">RATA-RATA PENDAPATAN USAHA (Berdasarkan Nota)</td>
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
					</div>
					<!---- end wiraswasta--->
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasPro1 = sqlsrv_query( $conn, $callKapasitasPro1, $paramKapasitasPro1,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasPro2 = sqlsrv_query( $conn, $callKapasitasPro2, $paramKapasitasPro2,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasPro3 = sqlsrv_query( $conn, $callKapasitasPro3, $paramKapasitasPro3,$options) or die( print_r( sqlsrv_errors(), true));
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
										<select name="pro_pemohon_mutasi" class="form-control" >
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
											 <select name="validasi_pro_pemohon" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
									<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankCA = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgProBankCA =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankCA = sqlsrv_query( $conn, $callImgProBankCA, $paramImgProBankCA) or die( print_r( sqlsrv_errors(), true));
													$dataImgProBankCA = sqlsrv_fetch_array($execImgProBankCA);
													$ImgProBankCA = $dataImgKryBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBankCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									
										<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBank = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgProBank =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBank = sqlsrv_query( $conn, $callImgProBank, $paramImgProBank) or die( print_r( sqlsrv_errors(), true));
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
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgProBankAm =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankAm = sqlsrv_query( $conn, $callImgProBankAm, $paramImgProBankAm) or die( print_r( sqlsrv_errors(), true));
													$dataImgProBankAm = sqlsrv_fetch_array($execImgProBankAm);
													$ImgProBankAm = $dataImgProBankAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBankAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
					</div>
					<?php } ?>
					<?php if ($dataAnalisBm['JOIN_INCOME'] == "YA" && $dataAnalisBm['CUST_MODEL_PASANGAN'] == "PROFESSIONAL" ) { ?>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasProPas1 = sqlsrv_query( $conn, $callKapasitasProPas1, $paramKapasitasProPas1,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasProPas2 = sqlsrv_query( $conn, $callKapasitasProPas2, $paramKapasitasProPas2,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('PROFESSIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasProPas3 = sqlsrv_query( $conn, $callKapasitasProPas3, $paramKapasitasProPas3,$options) or die( print_r( sqlsrv_errors(), true));
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
											 <input type="text" name="pro_pasangan_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="pro_pasangan_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="pro_pasangan_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="pro_pasangan_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="pro_pasangan_mutasi" class="form-control" >
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
											 <select name="validasi_pro_pasangan" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
									<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankCAPas = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgProBankCAPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankCAPas = sqlsrv_query( $conn, $callImgProBankCAPas, $paramImgProBankCAPas) or die( print_r( sqlsrv_errors(), true));
													$dataImgProBankCAPas = sqlsrv_fetch_array($execImgProBankCAPas);
													$ImgProBankCAPas = $dataImgKryBankPas['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBankCAPas <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankCAPas);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankCAPas);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
									</tr>
									<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgProBankPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankPas = sqlsrv_query( $conn, $callImgProBankPas, $paramImgProBankPas) or die( print_r( sqlsrv_errors(), true));
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
									<tr>
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
													
													$callImgProBankPasAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgProBankPasAm =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgProBankPasAm = sqlsrv_query( $conn, $callImgProBankPasAm, $paramImgProBankPasAm) or die( print_r( sqlsrv_errors(), true));
													$dataImgProBankPasAm = sqlsrv_fetch_array($execImgProBankPasAm);
													$ImgProBankPasAm = $dataImgProBankPasAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgProBankPasAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankPasAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgProBankPasAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
					</div>
					
				
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasNonPro1 = sqlsrv_query( $conn, $callKapasitasNonPro1, $paramKapasitasNonPro1,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasNonPro2 = sqlsrv_query( $conn, $callKapasitasNonPro2, $paramKapasitasNonPro2,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PEMOHON', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasNonPro3 = sqlsrv_query( $conn, $callKapasitasNonPro3, $paramKapasitasNonPro3,$options) or die( print_r( sqlsrv_errors(), true));
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
										<select name="nonpro_pemohon_mutasi" class="form-control" >
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
											 <select name="validasi_nonpro_pemohon" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
										<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankCa= "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgNonProBankCa=  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankCa= sqlsrv_query( $conn, $callImgNonProBankCa, $paramImgNonProBankCa) or die( print_r( sqlsrv_errors(), true));
													$dataImgNonProBankCa= sqlsrv_fetch_array($execImgNonProBankCa);
													$ImgNonProBankCa= $dataImgNonProBankCa['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBankCa <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankCa);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankCa);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
										
										<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBank= "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgNonProBank=  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBank= sqlsrv_query( $conn, $callImgNonProBank, $paramImgNonProBank) or die( print_r( sqlsrv_errors(), true));
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
												<td >Validasi Bukti TF AM</td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankAm= "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgNonProBankAm=  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PEMOHON', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankAm= sqlsrv_query( $conn, $callImgNonProBankAm, $paramImgNonProBankAm) or die( print_r( sqlsrv_errors(), true));
													$dataImgNonProBankAm= sqlsrv_fetch_array($execImgNonProBankAm);
													$ImgNonProBankAm= $dataImgNonProBankAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBankAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
					</div>
					<?php } ?>
					<?php if ($dataAnalisBm['JOIN_INCOME'] == "YA" && $dataAnalisBm['CUST_MODEL_PASANGAN'] == "NON PROFESSIONAL" ) { ?>
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI PENGHASILAN / USAHA', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas1 = sqlsrv_query( $conn, $callKapasitasNonProPas1, $paramKapasitasNonProPas1,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('REK TABUNGAN', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas2 = sqlsrv_query( $conn, $callKapasitasNonProPas2, $paramKapasitasNonProPas2,$options) or die( print_r( sqlsrv_errors(), true));
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
																	array($app_no, SQLSRV_PARAM_IN),
																	array('PASANGAN', SQLSRV_PARAM_IN),
																	array('BM', SQLSRV_PARAM_IN),
																	array('NON PROFESIONAL', SQLSRV_PARAM_IN),
																	array('BUKTI SPT PAJAK TAHUN TERAKHIR', SQLSRV_PARAM_IN));
													$execKapasitasNonProPas3 = sqlsrv_query( $conn, $callKapasitasNonProPas3, $paramKapasitasNonProPas3,$options) or die( print_r( sqlsrv_errors(), true));
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
											 <input type="text" name="nonpro_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['BANK_BRANCH'];?>"  id="nonpro_pasangan_bank_penerbit" readonly>
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pasangan_norek" class="form-control" value="<?php echo $dataBank['ACC_NO'];?>"  id="nonpro_pasangan_norek" readonly >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="nonpro_pasangan_rekening" class="form-control" value="<?php echo $dataBank['ACC_NAME'];?>"  id="nonpro_pasangan_rekening" readonly>
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="nonpro_pasangan_mutasi" class="form-control" >
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
											 <select name="validasi_nonpro_pasangan" class="form-control" disabled>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
									<tr>
												<td >Validasi Bukti TF CA </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankPasCA = "{call SP_RAK_GET_IMAGES_UPLOAD_CA(?,?,?)}";
													$paramImgNonProBankPasCA =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankPasCA = sqlsrv_query( $conn, $callImgNonProBankPasCA, $paramImgNonProBankPasCA) or die( print_r( sqlsrv_errors(), true));
													$dataImgNonProBankPasCA = sqlsrv_fetch_array($execImgNonProBankPasCA);
													$ImgNonProBankPasCA = $dataImgNonProBankPasCA['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBankPasCA <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPasCA);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPasCA);?>" style="height:300px;width:200px;"  class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>

													</td>
										</tr>
									<tr>
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgNonProBankPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankPas = sqlsrv_query( $conn, $callImgNonProBankPas, $paramImgNonProBankPas) or die( print_r( sqlsrv_errors(), true));
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
												<td >Validasi Bukti TF BM </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankPas = "{call SP_RAK_GET_IMAGES_UPLOAD_BM(?,?,?)}";
													$paramImgNonProBankPas =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankPas = sqlsrv_query( $conn, $callImgNonProBankPas, $paramImgNonProBankPas) or die( print_r( sqlsrv_errors(), true));
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
												<td >Validasi Bukti TF AM </td>
													<td colspan="2" >
													<?php 
													
													$callImgNonProBankPasAm = "{call SP_RAK_GET_IMAGES_UPLOAD_AM(?,?,?)}";
													$paramImgNonProBankPasAm =  array(array($app_no, SQLSRV_PARAM_IN),
																		array('PASANGAN', SQLSRV_PARAM_IN),
																		array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN));
													$execImgNonProBankPasAm = sqlsrv_query( $conn, $callImgNonProBankPasAm, $paramImgNonProBankPasAm) or die( print_r( sqlsrv_errors(), true));
													$dataImgNonProBankPasAm = sqlsrv_fetch_array($execImgNonProBankPasAm);
													$ImgNonProBankPasAm = $dataImgNonProBankPasAm['IMAGES_VALIDASI'];
													?>
														<?php if($ImgNonProBankPasAm <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPasAm);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($ImgNonProBankPasAm);?>" style="height:300px;width:200px;"  class="img-custom">
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
					
					</div>
					
					<!--- historical-->
					
					
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
					
					
					
					<div class="row">
					<div class="col-md-3 col-sm-3">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Aktif</th>
									
										
									</tr>
								</thead>
								
							</table>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					
					Pemohon
					<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
										<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$totalPlafondPemohon = 0;
								$totalBakiDebetPemohon = 0;
								$totalAngsuranPemohon = 0;
								
								$totalNaPlafondPemohon = 0;
								$totalNaBakiDebetPemohon = 0;
								$totalNaAngsuranPemohon = 0;
								
							IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){
								
									$callPefindoPemohon = "{call SP_RAK_GET_PEFINDO_AKTIF(?)}";
									$paramPefindoPemohon =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPefindoPemohon = sqlsrv_query( $conn, $callPefindoPemohon, $paramPefindoPemohon) or die( print_r( sqlsrv_defaults(), true)); 
									
									$callPefindoNaPemohon = "{call SP_RAK_GET_PEFINDO_NOT_AKTIF(?)}";
									$paramPefindoNaPemohon =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPefindoNaPemohon = sqlsrv_query( $conn, $callPefindoNaPemohon, $paramPefindoNaPemohon) or die( print_r( sqlsrv_defaults(), true)); 
									
							}else{
									$callPefindoPemohon = "{call SP_RAK_GET_SLIK_AKTIF(?)}";
									$paramPefindoPemohon =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPefindoPemohon = sqlsrv_query( $conn, $callPefindoPemohon, $paramPefindoPemohon) or die( print_r( sqlsrv_defaults(), true)); 
									
									$callPefindoNaPemohon = "{call SP_RAK_GET_SLIK_NOT_AKTIF(?)}";
									$paramPefindoNaPemohon =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPefindoNaPemohon = sqlsrv_query( $conn, $callPefindoNaPemohon, $paramPefindoNaPemohon) or die( print_r( sqlsrv_defaults(), true)); 
									
							}
									$num_rows=sqlsrv_num_rows($execPefindoPemohon);
									$no=0;
									
									while($rowGetProspect = sqlsrv_fetch_array($execPefindoPemohon)){
										$no++;
										$totalPlafondPemohon =+ $totalPlafondPemohon + $rowGetProspect['PLAFON'];
										$totalBakiDebetPemohon =+ $totalBakiDebetPemohon + $rowGetProspect['BAKI_DEBET'];
										$totalAngsuranPemohon =+ $totalAngsuranPemohon + $rowGetProspect['ANGSURAN'];
									
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['PEMBERI_CREDIT'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['CONTRACT_TYPE'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['PLAFON'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspect['TANGGAL_AKAD_AWAL']<>NULL){echo $rowGetProspect['TANGGAL_AKAD_AWAL']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspect['TGL_JATUH_TEMPO']<>NULL){echo $rowGetProspect['TGL_JATUH_TEMPO']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['TENOR'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['SISA_TENOR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['BAKI_DEBET'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspect['ANGSURAN'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['OD'];?></td>
										<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectPasangan['SISA_TENOR'];?></td> -->
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['CONTRACT_STATUS'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['RESTRUKTUR'];?></td>
									
									
									</tr>
								<?php } ?>
								</tr>
									<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">TOTAL</td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalPlafondPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalBakiDebetPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalAngsuranPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										
										
									
									</tr>
								</tr>
								
								</tbody>
							</table>
						</div>
								
							</div>
					</div>	
					
					<div class="row">
					<div class="col-md-3 col-sm-3">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Non Aktif</th>
									
										
									</tr>
								</thead>
								
							</table>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					
			
					<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
										<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
									</tr>
								</thead>
								<tbody>
								<?php
							
									$num_rows=sqlsrv_num_rows($execPefindoNaPemohon);
									$no=0;
									
									while($rowGetProspectNa = sqlsrv_fetch_array($execPefindoNaPemohon)){
										$no++;
										$totalNaPlafondPemohon =+ $totalNaPlafondPemohon + $rowGetProspectNa['PLAFON'];
										$totalNaBakiDebetPemohon =+ $totalNaBakiDebetPemohon + $rowGetProspectNa['BAKI_DEBET'];
										$totalNaAngsuranPemohon =+ $totalNaAngsuranPemohon + $rowGetProspectNa['ANGSURAN'];
									
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['PEMBERI_CREDIT'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['CONTRACT_TYPE'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['PLAFON'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectNa['TANGGAL_AKAD_AWAL']<>NULL){echo $rowGetProspectNa['TANGGAL_AKAD_AWAL']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectNa['TGL_JATUH_TEMPO']<>NULL){echo $rowGetProspectNa['TGL_JATUH_TEMPO']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['TENOR'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['SISA_TENOR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['BAKI_DEBET'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNa['ANGSURAN'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['OD'];?></td>
										<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectNaPasangan['SISA_TENOR'];?></td> -->
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['CONTRACT_STATUS'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNa['RESTRUKTUR'];?></td>
									
									
									</tr>
								<?php } ?>
								</tr>
									<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">TOTAL</td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaPlafondPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaBakiDebetPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaAngsuranPemohon,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										
										
									
									</tr>
								</tr>
								
								</tbody>
							</table>
						</div>
								
							</div>
					</div>
					
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Deskripsi Score</th>
										<td><?php echo $scorePemohon;?></td>
										
									</tr>
								</thead>
								
							</table>
							
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
					
				
					
					
					<div class="row">
					<div class="col-md-3 col-sm-3">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Aktif</th>
									
										
									</tr>
								</thead>
								
							</table>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					
					<?php echo $siapanih?>
					<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
										<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$totalPlafondPasangan = 0;
								$totalBakiDebetPasangan = 0;
								$totalAngsuranPasangan = 0;
								
								$totalNaPlafondNaPasangan = 0;
								$totalNaBakiDebetNaPasangan  = 0;
								$totalNaAngsuranNaPasangan  = 0;
								
								
								IF($dataDataPasangan['SOURCE_BY'] == 'PEFINDO'){
									$callPefindoPasangan = "{call SP_RAK_GET_PEFINDO_AKTIF(?)}";
									$paramPefindoPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPefindoPasangan = sqlsrv_query( $conn, $callPefindoPasangan, $paramPefindoPasangan) or die( print_r( sqlsrv_defaults(), true)); 
									
									$callPefindoNaPasangan = "{call SP_RAK_GET_PEFINDO_NOT_AKTIF(?)}";
									$paramPefindoNaPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPefindoNaPasangan = sqlsrv_query( $conn, $callPefindoNaPasangan, $paramPefindoNaPasangan) or die( print_r( sqlsrv_defaults(), true)); 
									
								}else{
									$callPefindoPasangan = "{call SP_RAK_GET_SLIK_AKTIF(?)}";
									$paramPefindoPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPefindoPasangan = sqlsrv_query( $conn, $callPefindoPasangan, $paramPefindoPasangan) or die( print_r( sqlsrv_defaults(), true)); 
									
									$callPefindoNaPasangan = "{call SP_RAK_GET_SLIK_NOT_AKTIF(?)}";
									$paramPefindoNaPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
									$execPefindoNaPasangan = sqlsrv_query( $conn, $callPefindoNaPasangan, $paramPefindoNaPasangan) or die( print_r( sqlsrv_defaults(), true)); 
								}
									$num_rows=sqlsrv_num_rows($execPefindoPasangan);
									$no=0;
									
									while($rowGetProspectPasangan = sqlsrv_fetch_array($execPefindoPasangan)){
										$no++;
										$totalPlafondPasangan =+ $totalPlafondPasangan + $rowGetProspectPasangan['PLAFON'];
										$totalBakiDebetPasangan =+ $totalBakiDebetPasangan + $rowGetProspectPasangan['BAKI_DEBET'];
										$totalAngsuranPasangan =+ $totalAngsuranPasangan + $rowGetProspectPasangan['ANGSURAN'];
									
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['PEMBERI_CREDIT'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['CONTRACT_TYPE'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['PLAFON'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectPasangan['TANGGAL_AKAD_AWAL']<>NULL){echo $rowGetProspectPasangan['TANGGAL_AKAD_AWAL']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectPasangan['TGL_JATUH_TEMPO']<>NULL){echo $rowGetProspectPasangan['TGL_JATUH_TEMPO']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['TENOR'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['SISA_TENOR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['BAKI_DEBET'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['ANGSURAN'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['OD'];?></td>
										<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectPasangan['SISA_TENOR'];?></td> -->
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['CONTRACT_STATUS'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['RESTRUKTUR'];?></td>
									
									
									</tr>
								<?php } ?>
								</tr>
									<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">TOTAL</td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalPlafondPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalBakiDebetPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalAngsuranPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
						
									
									</tr>
								</tr>
								
								</tbody>
							</table>
						</div>
						</div>
						</div>
					
						<div class="row">
					<div class="col-md-3 col-sm-3">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Non Aktif</th>
									
										
									</tr>
								</thead>
								
							</table>
					</div>
					</div>
					</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
				
					<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
										<!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
									</tr>
								</thead>
								<tbody>
								<?php
								
									
									
									$num_rows=sqlsrv_num_rows($execPefindoNaPasangan);
									$no=0;
									
									while($rowGetProspectNaPasangan = sqlsrv_fetch_array($execPefindoNaPasangan)){
										$no++;
										$totalNaPlafondNaPasangan =+ $totalNaPlafondNaPasangan + $rowGetProspectNaPasangan['PLAFON'];
										$totalNaBakiDebetNaPasangan =+ $totalNaBakiDebetNaPasangan + $rowGetProspectNaPasangan['BAKI_DEBET'];
										$totalNaAngsuranNaPasangan =+ $totalNaAngsuranNaPasangan + $rowGetProspectNaPasangan['ANGSURAN'];
									
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['PEMBERI_CREDIT'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['CONTRACT_TYPE'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['PLAFON'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectNaPasangan['TANGGAL_AKAD_AWAL']<>NULL){echo $rowGetProspectNaPasangan['TANGGAL_AKAD_AWAL']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php if($rowGetProspectNaPasangan['TGL_JATUH_TEMPO']<>NULL){echo $rowGetProspectNaPasangan['TGL_JATUH_TEMPO']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['TENOR'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['SISA_TENOR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['BAKI_DEBET'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['ANGSURAN'],0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['OD'];?></td>
										<!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectNaPasangan['SISA_TENOR'];?></td> -->
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['CONTRACT_STATUS'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['RESTRUKTUR'];?></td>
									
									
									</tr>
								<?php } ?>
								</tr>
									<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">TOTAL</td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaPlafondNaPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaBakiDebetNaPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaAngsuranNaPasangan,0,',','.');?></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
										<td class="td-custom" style="padding:5px;"></td>
									
									
									</tr>
								</tr>
								
								</tbody>
							</table>
						</div>
						</div>
						</div>
					
					
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
					<table id="datatable1" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Deskripsi Score</th>
										<td><?php echo $scorePasangan;?></td>
										
									</tr>
								</thead>
								
							</table>
							
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
					
				
					
						
					
					<div class="col-md-4 col-sm-4">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Perhitungan Kapasitas CA </td>
									</tr>
								
									<tr>
										<td style="width:20%;">Angsuran SFI</td>
										<td style="width:30%;">
											<input type="text" name="angsuran_sfi_ca" class="form-control"  value="<?php echo number_format($dataAnalisCa['NEW_ANGSURAN_SFI'],0,',','.');?>"  id="angsuran_sfi_ca" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Kewajiban </td>
										<td style="width:30%;">
											<input type="text" name="total_kewajiban_ca" class="form-control" value="<?php echo number_format($dataAnalisCa['TOTAL_KEWAJIBAN'],0,',','.');?>"  id="total_kewajiban_ca" readonly>
										</td>
										
									</tr>
									
									<tr>
										<td style="width:20%;">Total Pendapatan Pemohon RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pemohon_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisCa['PENDAPATAN_PEMOHON_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan Pasangan RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pasangan_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisCa['PENDAPATAN_PASANGAN_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_ca" class="form-control" value="<?php echo number_format($dataAnalisCa['TOTAL_PENDAPATAN'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">DSR</td>
										<td style="width:30%;">
											<input type="text" name="dsr_ca" class="form-control" value="<?php echo number_format($dataAnalisCa['DSR'],0,',','.');?>"  id="dsr_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">NOTES</td>
										<td style="width:30%;">
											<input type="text" name="notes_final_ca" class="form-control" value="<?php echo $dataAnalisCa['NOTE'];?>"  id="notes_final_ca" readonly>
										</td>
										
									</tr>
									
									
									
								</table>
							</div>								
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Perhitungan Kapasitas BM </td>
									</tr>
								
									<tr>
										<td style="width:20%;">Angsuran SFI</td>
										<td style="width:30%;">
											<input type="text" name="angsuran_sfi_ca" class="form-control"  value="<?php echo number_format($dataAnalisBm['NEW_ANGSURAN_SFI'],0,',','.');?>"   id="angsuran_sfi_ca" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Kewajiban </td>
										<td style="width:30%;">
											<input type="text" name="total_kewajiban_ca" class="form-control" value="<?php echo number_format($dataAnalisBm['TOTAL_KEWAJIBAN'],0,',','.');?>"  id="total_kewajiban_ca" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan Pemohon RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pemohon_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisBm['PENDAPATAN_PEMOHON_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan Pasangan RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pasangan_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisBm['PENDAPATAN_PASANGAN_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_ca" class="form-control" value="<?php echo number_format($dataAnalisBm['TOTAL_PENDAPATAN'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">DSR</td>
										<td style="width:30%;">
											<input type="text" name="dsr_ca" class="form-control" value="<?php echo number_format($dataAnalisBm['DSR'],0,',','.');?>"  id="dsr_ca" readonly>
										
									</tr>
									
									<tr>
										<td style="width:20%;">NOTES</td>
										<td style="width:30%;">
											<input type="text" name="notes_final_ca" class="form-control" value="<?php echo $dataAnalisBm['NOTE'];?>"  id="notes_final_ca" readonly>
										</td>
										
									</tr>
									
								</table>
							</div>								
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Perhitungan Kapasitas AM </td>
									</tr>
								
									<tr>
										<td style="width:20%;">Angsuran SFI</td>
										<td style="width:30%;">
											<input type="text" name="angsuran_sfi_ca" class="form-control"  value="<?php echo number_format($dataAnalisAm['NEW_ANGSURAN_SFI'],0,',','.');?>"   id="angsuran_sfi_ca" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Kewajiban </td>
										<td style="width:30%;">
											<input type="text" name="total_kewajiban_ca" class="form-control" value="<?php echo number_format($dataAnalisAm['TOTAL_KEWAJIBAN'],0,',','.');?>"  id="total_kewajiban_ca" readonly>
										</td>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan Pemohon RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pemohon_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisAm['PENDAPATAN_PEMOHON_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan Pasangan RAK </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_pasangan_rak_ca" class="form-control" value="<?php echo number_format($dataAnalisAm['PENDAPATAN_PASANGAN_RAK'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">Total Pendapatan </td>
										<td style="width:30%;">
											<input type="text" name="total_pendapatan_ca" class="form-control" value="<?php echo number_format($dataAnalisAm['TOTAL_PENDAPATAN'],0,',','.');?>"  id="total_pendapatan_ca" readonly>
										
									</tr>
									<tr>
										<td style="width:20%;">DSR</td>
										<td style="width:30%;">
											<input type="text" name="dsr_ca" class="form-control" value="<?php echo number_format($dataAnalisAm['DSR'],0,',','.');?>"  id="dsr_ca" readonly>
										
									</tr>
									
									<tr>
										<td style="width:20%;">NOTES</td>
										<td style="width:30%;">
											<input type="text" name="notes_final_ca" class="form-control" value="<?php echo $dataAnalisAm['NOTE'];?>"  id="notes_final_ca" readonly>
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
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Hasil Cek Lingkungan</td>
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
										<td>NAMA RT</td>
										<td><input type="text" name="nama_rt" class="form-control" value="<?php echo $dataLingkungan1['TEXT_ANSWER'];?>"  id="nama_rt"  readonly></td>
									</tr>
									<tr>
										<td>Hasil Wawancara</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value="<?php echo $dataLingkungan2['TEXT_ANSWER'];?>" "  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									<tr>
										<td>NAMA TETANGGA 1</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value="<?php echo $dataLingkungan3['TEXT_ANSWER'];?>" "  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									<tr>
										<td>Hasil Wawancara</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value="<?php echo $dataLingkungan4['TEXT_ANSWER'];?>" "  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									<tr>
										<td>NAMA TETANGGA 2</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value="<?php echo $dataLingkungan5['TEXT_ANSWER'];?>" "  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									<tr>
										<td>Hasil Wawancara</td>
										<td><input type="text" name="kewajiban_tempatlain" class="form-control" value="<?php echo $dataLingkungan6['TEXT_ANSWER'];?>" "  id="kewajiban_tempatlain" readonly></td>
										
										
									</tr>
									
									
									
									
								</table>
							</div>
						
					</div>	
					
					
						<?php if($type_kendaraan == '15'){ 
					
						$callRakCheck= "{call SP_CUT_OFF_RAK_POLICY_CREDIT(?)}";
						$paramRakCheck =  array(array($app_no, SQLSRV_PARAM_IN));
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
							
					
					
						
						
						
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">PROXY INCOME</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS LEVEL</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">SEGMENTASI</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS COLLECTIBILITY</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">DESKRIPSI SCORE</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
																		
									//$callProxy1= "{call SP_GET_PROXY_LEVEL_RAK(?)}";
									//$paramProxy1 =  array(array($app_no, SQLSRV_PARAM_IN));					
									$callProxy1= "{call SP_GET_NEW_MATRIKS_RAK(?)}";
									$paramProxy1 =  array(array($prospect, SQLSRV_PARAM_IN));
									$execProxy1 = sqlsrv_query( $conn, $callProxy1, $paramProxy1) or die( print_r( sqlsrv_defaults(), true)); 
									$dataProxy1 = sqlsrv_fetch_array($execProxy1);
									
							
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['Status_Proxy_income']; ?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['STATUS_LEVEL'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['SEGMENTATION'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['STATUS_COLLECTIBILITY'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['Score_Desc'];?></td>
										<input type="hidden" name="tdp_score" class="form-control"  value="<?php echo $dataCust['TDP_PERCENT']; ?>" id="tdp_score" readonly>
										<input type="hidden" name="prox_level" class="form-control"  value="<?php echo $dataProxy1['STATUS_LEVEL']; ?>" id="prox_level" readonly>
										<input type="hidden" name="segmentasi" class="form-control"  value="<?php echo $dataProxy1['SEGMENTATION']; ?>" id="segmentasi" readonly>
										<input type="hidden" name="stat_col" class="form-control"  value="<?php echo $dataProxy1['STATUS_COLLECTIBILITY']; ?>" id="stat_col" readonly>
										<input type="hidden" name="desc_score" class="form-control"  value="<?php echo $dataProxy1['Score_Desc']; ?>" id="desc_score" readonly>
									</tr>
									
								</tbody>
							</table>
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
									
									$callProxy= "{call SP_GET_LOA_NEW_MATRIK_RAK(?,?,?,?,?,?)}";
									$paramProxy =  array(array($prospect, SQLSRV_PARAM_IN),
														array($dataCust['TDP_PERCENT'], SQLSRV_PARAM_IN),
														//array(20, SQLSRV_PARAM_IN),
														 array($branchid, SQLSRV_PARAM_IN),
														 array($dataProxy1['STATUS_COLLECTIBILITY'], SQLSRV_PARAM_IN),
														 array($dataProxy1['SEGMENTATION'], SQLSRV_PARAM_IN),
														 array($dataProxy1['Score_Desc'], SQLSRV_PARAM_IN));
														 
									$execProxy = sqlsrv_query( $conn, $callProxy, $paramProxy) or die( print_r( sqlsrv_defaults(), true)); 
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
											<input type="text" name="final_approval" class="form-control"  value="<?php echo $dataProxy['APPROVAL'];?>"  id="final_approval" readonly>
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
									$paramProxy1 =  array(array($app_no, SQLSRV_PARAM_IN));
									$execProxy1 = sqlsrv_query( $conn, $callProxy1, $paramProxy1) or die( print_r( sqlsrv_defaults(), true)); 
									$dataProxy1 = sqlsrv_fetch_array($execProxy1);
									
							
									
							

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['Status_Proxy_income']; ?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataProxy1['STATUS_LEVEL'];?></td>
										
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
									$paramProxy =  array(array($app_no, SQLSRV_PARAM_IN),
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
							
							<br>
							<br>
						
					
					
					
				<?php 
					}
				} ?>
					<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Asset Data</td>
									</tr>
									
									
								</table>
							</div>
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
								
						
									<tr>
										<td >APP NO </td>
										<td >
											<input type="text" name="app_no" id="app_no"  value="<?php echo $app_no;?>" class="form-control" readonly onautocomplete="off">
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
										<td>Foto Survey</td>
										<td>
										<?php 
										if($dataSvy['MOS_STAT'] == "NEW" ){
								?>
											<!-- <a class="btn btn-warning btn-xs" style="width:100px;height:50px;"href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $dataSvy['ORDER_NO'];?>" target="_blank"
											>Foto Survey</a>-->
											<a class="btn btn-warning btn-xs" style="width:100px;height:50px;"href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $dataSvy['ORDER_NO'];?>" target="_blank"
											>Foto Survey</a>
										<?php }else{ ?>
								
										<a class="btn btn-warning btn-xs" style="width:100px;height:50px;"href="https://mos.sfi.co.id/mobile_survey/View_cust/Data1/<?php echo $dataSvy['TASK_ID'];?>" target="_blank"
											>Foto Survey</a>
										<?php } ?>
										</td>
										
									</tr>
									<tr>
									<td >Copy Link RAK</td>
									<td>
									

									
									
											<!--begin::Button-->
											<button id="kt_clipboard_3" type="button" class="btn btn-light-primary" data-clipboard-text="http://172.16.2.5/h2h_pefindo/frame-detail-form-rak.php?prospect=<?php echo $prospect; ?>&app=<?php echo $app_no; ?>">
												Copy to clipboard
											</button>
											<!--end::Button-->
										
								


									</td>
									</tr>
								</table>
							</div>
				 	</div>
							<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
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
					
				 </form>
				</div>
			</div>
				</div>
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
										$callApv = "{call SP_APPROVAL_GETLIST_APV_NO_RAK(?)}";
										$paramApv =  array(array($app_no, SQLSRV_PARAM_IN));
										$execApv = sqlsrv_query( $conn, $callApv, $paramApv) or die( print_r( sqlsrv_errors(), true));
										$dataApv= sqlsrv_fetch_array($execApv);

                                       $no=0;
                                       $callLoa = "{call  SP_APPROVAL_GETLIST_LOA_RAK_FORM(?)}";
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
 <script src="assets/clipboard.js-master/dist/clipboard.min.js"></script>
<script> 
const target = document.getElementById('kt_clipboard_3');

// Init clipboard -- for more info, please read the offical documentation: https://clipboardjs.com/
clipboard = new ClipboardJS(target);

// Success action handler
clipboard.on('success', function (e) {
    const currentLabel = target.innerHTML;

    // Exit label update when already in progress
    if (target.innerHTML === 'Copied!') {
        return;
    }

    // Update button label
    target.innerHTML = 'Copied!';

    // Revert button label after 3 seconds
    setTimeout(function () {
        target.innerHTML = currentLabel;
    }, 3000)
});

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

}

</script>
<script>


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
	
	
	function FuncNonProPemohon2() {
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

function FuncKryPasangan1() {
  var checkBox = document.getElementById("slip_gaji_pasangan_ck");
  var text = document.getElementById("slip_gaji_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "SLIP GAJI";
  } else {
     text.value = "";
  }
 }

function FuncKryPasangan2() {
  var checkBox = document.getElementById("daftar_gaji_pasangan_ck");
  var text = document.getElementById("daftar_gaji_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "DAFTAR GAJI";
  } else {
     text.value = "";
  }
 }

function FuncKryPasangan3() {
  var checkBox = document.getElementById("surat_ket_penghasilan_pasangan_ck");
  var text = document.getElementById("surat_ket_penghasilan_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "SURAT KETERANGAN PENGHASILAN";
  } else {
     text.value = "";
  }
 }

function FuncKryPasangan4() {
  var checkBox = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck");
  var text = document.getElementById("bukti_saldo_print_jamsos_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SALDO PRINT SCREEN JAMSOSTEK";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPasangan5() {
  var checkBox = document.getElementById("bukti_spt_pasangan_ck");
  var text = document.getElementById("bukti_spt_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPasangan6() {
  var checkBox = document.getElementById("rekening_tabungan_pasangan_ck");
  var text = document.getElementById("rekening_tabungan_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "REKENING TABUNGAN";
  } else {
     text.value = "";
  }
 }
 
function FuncKryPasangan7() {
  var checkBox = document.getElementById("foto_kartu_identitas_pasangan_ck");
  var text = document.getElementById("foto_kartu_identitas_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "FOTO KARTU IDENTITAS KARYAWAN";
  } else {
     text.value = "";
  }
 }
 
}else  if (join_income == "YA" && pasangan == "WIRASWASTA") {
	function FuncWrsPasangan1() {
  var checkBox = document.getElementById("rek_tabungan_pasangan_wrs_ck");
  var text = document.getElementById("rek_tabungan_pasangan_wrs_ck1");
  
  if (checkBox.checked == true){
    text.value = "REK TABUNGAN";
  } else {
     text.value = "";
  }
 }
 function FuncWrsPasangan2() {
  var checkBox = document.getElementById("nota_pembelian_wrs_pasangan_ck");
  var text = document.getElementById("nota_pembelian_wrs_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "NOTA PEMBELIAN";
  } else {
     text.value = "";
  }
 }
  function FuncWrsPasangan3() {
  var checkBox = document.getElementById("nota_penjualan_wrs_pasangan_ck");
  var text = document.getElementById("nota_penjualan_wrs_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "NOTA PENJUALAN";
  } else {
     text.value = "";
  }
 }
   function FuncWrsPasangan4() {
  var checkBox = document.getElementById("spt_wrs_pasangan_ck");
  var text = document.getElementById("spt_wrs_pasangan_ck1");
  
  if (checkBox.checked == true){
    text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
  } else {
     text.value = "";
  }
 }
 
 
}else  if (join_income == "YA" && pasangan == "PROFESSIONAL") {
  function FuncProPasangan1() {
	 var checkBox = document.getElementById("pro_bukti_penghasilan_pasangan_ck");
	 var text = document.getElementById("pro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	function FuncProPasangan2() {
	 var checkBox = document.getElementById("pro_rek_tabungan_pasangan_ck");
	 var text = document.getElementById("pro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "REK TABUNGAN";
	  } else {
		 text.value = "";
	  }
    }
	
	
	function FuncProPasangan3() {
	 var checkBox = document.getElementById("pro_spt_pasangan_ck");
	 var text = document.getElementById("pro_spt_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	
	
	
	
}else  if (join_income == "YA" && pasangan == "NON PROFESSIONAL") {
  function FuncNonProPasangan1() {
	 var checkBox = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck");
	 var text = document.getElementById("nonpro_bukti_penghasilan_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }
	
	function FuncNonProPasangan2() {
	 var checkBox = document.getElementById("nonpro_rek_tabungan_pasangan_ck");
	 var text = document.getElementById("nonpro_rek_tabungan_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "REK TABUNGAN";
	  } else {
		 text.value = "";
	  }
    }
	
	
	function FuncNonProPasangan3() {
	 var checkBox = document.getElementById("nonpro_spt_pasangan_ck");
	 var text = document.getElementById("nonpro_spt_pasangan_ck1");
  
	  if (checkBox.checked == true){
	text.value = "BUKTI PENGHASILAN / USAHA";
	  } else {
		 text.value = "";
	  }
    }

	
}




</script>


<script type="text/javascript">


$(document).ready(function(){
	//$('#subgrup').val(data[0].kolom);
	  var pemohon =  $("#cust_model_pemohon").val();
   var pasangan =  $("#cust_model_pasangan").val();

   var join_income =  $("#join_income").val();
   
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
                    url: 'view-mutasi-kry-bm.php',
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
                    url: 'view-mutasi-wrs-pasangan.php',
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
                    }
                });
            }		

 function viewMutasiProPasangan() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-pro-pasangan.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabelMutasiProPasangan').html(data);
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
		
			$('#dsr').val(nf.format(dsr[0].DSR));
			$('#total_kewajiban').val(nf.format(dsr[0].TOTAL_KEWAJIBAN));
			$('#total_pendapatan').val(nf.format(dsr[0].TOTAL_PENDAPATAN));
			$('#kewajiban_tempatlain').val(nf.format(dsr[0].KEWAJIBAN_TEMPAT_LAIN));
		
			
		
			
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

  var pemohon =  $("#cust_model_pemohon").val();
 

				
	
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


</script>

