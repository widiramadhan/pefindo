<?php
 //or die( print_r( sqlsrv_defaults(), true)); 
// or die( print_r( sqlsrv_defaults(), true)); 
//or die( print_r( sqlsrv_errors(), true));
$user=$_GET['USERNAME'];
$app_no = $_GET['app'];
$prospect=$_GET['prospect'];
$branchid= substr($app_no,0,4);

$type_kendaraan= substr($app_no,0,2);

$callCust = "{call SP_RAK_GET_CUST_INFO(?)}";
$paramCust =  array(array($app_no, SQLSRV_PARAM_IN));
$execCust = sqlsrv_query( $conn, $callCust, $paramCust) or die( print_r( sqlsrv_defaults(), true)); 
$dataCust = sqlsrv_fetch_array($execCust);

$ph_val =  number_format($dataCust['PH_AKUMULASI'],0,',','.');

if($ph_val == 0){
	echo"<script>alert('Mohon Lengkapi Data Di Finansial Data');</script>";
	echo"<script>window.location='index.php?USERNAME=".$user."&page=tasklist-rak'</script>";
}
//----# Insert LOG End


if($type_kendaraan == '15'){

$callChkProx = "{call SP_PROSES_DATA_GENERATE_INTERNAL_SCORING_RAK(?)}";
$paramsChkProx = array(
				array($prospect, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$execChkProx = sqlsrv_query($conn, $callChkProx, $paramsChkProx, $options) or die( print_r( sqlsrv_errors(), true)); 
$dataChkProx = sqlsrv_fetch_array($execChkProx);
$checkChkProx=sqlsrv_num_rows($execChkProx);

	if($checkChkProx == 0){
		$callInsProx = "{call SFIBI_SP_REPORT_FASILITAS_SLIK_PEFINDO_by_Order_no_summary_SLIK(?)}";
	$paramInsProx =  array(array($prospect, SQLSRV_PARAM_IN));
	$execInsProx = sqlsrv_query( $conn, $callInsProx, $paramInsProx) or die( print_r( sqlsrv_defaults(), true)); 
	$dataInsProx = sqlsrv_fetch_array($execInsProx);
	}
}
$app_no_ao = $dataCust['APP_NO_AO'];


$callInfo = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN(?)}";
$paramInfo =  array(array($app_no, SQLSRV_PARAM_IN));
$execInfo = sqlsrv_query( $conn, $callInfo, $paramInfo) or die( print_r( sqlsrv_defaults(), true)); 
$dataInfo = sqlsrv_fetch_array($execInfo);

$callSvy= "{call SP_RAK_GET_SURVEY_ID(?)}";
$paramSvy =  array(array($app_no, SQLSRV_PARAM_IN));
$execSvy = sqlsrv_query( $conn, $callSvy, $paramSvy) or die( print_r( sqlsrv_errors(), true)); 
$dataSvy = sqlsrv_fetch_array($execSvy);




$callTagging = "{call SP_RAK_GET_GEOTAGING_SURVEY(?)}";
$paramTagging =  array(array($app_no, SQLSRV_PARAM_IN));
$execTagging = sqlsrv_query( $conn, $callTagging, $paramTagging) or die( print_r( sqlsrv_defaults(), true)); 
$dataTagging = sqlsrv_fetch_array($execTagging);


$callBank = "{call SP_RAK_GET_BANK_INFO(?)}";
$paramBank =  array(array($app_no, SQLSRV_PARAM_IN));
$execBank = sqlsrv_query( $conn, $callBank, $paramBank) or die( print_r( sqlsrv_defaults(), true)); 
$dataBank = sqlsrv_fetch_array($execBank);
$total_pendaptan_cra = $dataBank['GAJI_PEMOHON'] + $dataBank['GAJI_PASANGAN'];

$callBankAo = "{call SP_RAK_GET_BANK_INFO(?)}";
$paramBankAo =  array(array($app_no_ao, SQLSRV_PARAM_IN));
$execBankAo = sqlsrv_query( $conn, $callBankAo, $paramBankAo) or die( print_r( sqlsrv_defaults(), true)); 
$dataBankAo = sqlsrv_fetch_array($execBankAo);



$ktp_pemohon = $dataInfo['ID_NO'];


if($dataInfo['Pasangan_Noktp'] == "" || $dataInfo['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
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
	}else{
		$siapanih = "Pasangan";
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
	}
	
	
	
$callInfoProfesi = "{call SP_RAK_GET_DATA_PEMOHON_PASANGAN_PROFESI(?)}";
$paramInfoProfesi =  array(array($app_no, SQLSRV_PARAM_IN));
$execInfoProfesi = sqlsrv_query( $conn, $callInfoProfesi, $paramInfoProfesi) or die( print_r( sqlsrv_errors(), true));
$dataInfoProfesi = sqlsrv_fetch_array($execInfoProfesi);
if($siapanih == "Pasangan"){
	$profesi_pasangan=$dataInfoProfesi['Pasangan_PROFESI'];
	$perusahaan_pasangan=$dataInfoProfesi['Pasangan_NAMA_PERUSAHAAN'];
	$lama_bekerja_pasangan=$dataInfoProfesi['Pasangan_LAMA_BEKERJA'];
	$industri_pasangan=$dataInfoProfesi['Pasangan_INDUSTRY_TYPE'];
	$phn_kerja_pasangan=$dataInfoProfesi['PASANGAN_KANTOR_PHONE'];
}else{
	$profesi_pasangan=$dataInfoProfesi['Penjamin_PROFESI'];
	$perusahaan_pasangan=$dataInfoProfesi['Penjamin_NAMA_PERUSAHAAN'];
	$lama_bekerja_pasangan=$dataInfoProfesi['Penjamin_LAMA_BEKERJA'];
	$industri_pasangan=$dataInfoProfesi['Penjamin_INDUSTRY_TYPE'];
	$phn_kerja_pasangan=$dataInfoProfesi['PENJAMIN_KANTOR_PHONE'];
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
					 array($siapanih, SQLSRV_PARAM_IN));
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


$callDsr = "{call SP_GET_DSR_PEFINDOLSIK(?)}";
$paramDsr =  array(array($app_no, SQLSRV_PARAM_IN));
$execDsr = sqlsrv_query( $conn, $callDsr, $paramDsr) or die( print_r( sqlsrv_errors(), true)); 
$dataDsr = sqlsrv_fetch_array($execDsr);

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


if(isset($_POST['submit1'])){
	/*
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
	$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
	$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
	$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
	*/
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$outputRumah = prepareImageDBString($_FILES['img_status_rumah']['tmp_name']);
	$catatan1 = $_POST['catatan_domisili'];
	$catatan2 = $_POST['catatan_geotaging'];
	$nama_pemilik_rumah = $_POST['nama_pemilik_rumah'];
	//$dataInfo['Pasangan_CUST_MODEL']
	
	$level = 1;
	$role_code = "CA";
	$cust_pemohon = "PEMOHON";
	$cust_pasangan = "PASANGAN";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['ph']);
	$otr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['otr']);
	$tenor = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tenor']);
	$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
	$tdp_persen = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tdp_persen']); 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = $_POST['analisa'];
	$angsuran_new = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_pendapatan']);
	//$dsr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['dsr']); 
	$dsr = $_POST['dsr'];
	$rekomendasi = "REKOMENDASI";
	
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
	$alamat_domisili_pemohon_val = $_POST['alamat_domisili_pemohon_val'];
	$alamat_domisili_pemohon_notes = $_POST['alamat_domisili_pemohon_notes'];
	$alamat_domisili_pasangan_val = $_POST['alamat_domisili_pasangan_val'];
	$alamat_domisili_pasangan_notes = $_POST['alamat_domisili_pasangan_notes'];
	$domisili_val =  $_POST['domisili_val'];
	$catatan_domisili =  $_POST['catatan_domisili'];
	$hasil_foto_survey_val =  $_POST['hasil_foto_survey_val'];
	$catatan_geotaging =  $_POST['catatan_geotaging'];
	$angsuran_berjalan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_berjalan']);
	
		if($type_kendaraan == '15'){
	$final_approval = $_POST['final_approval'];
	$tdp_score = $_POST['tdp_score'];
	$prox_level = $_POST['prox_level'];
	
	IF($prox_level == 'LEVEL 6' && $tdp_score < 25){
		$callDacor = "{call SP_GET_AFA_DACOR_RAK_TDP(?)}";
		$paramDacor =  array(array($app_no, SQLSRV_PARAM_IN));
		$execDacor = sqlsrv_query( $conn, $callDacor, $paramDacor) or die( print_r( sqlsrv_defaults(), true)); 
		$dataDacor = sqlsrv_fetch_array($execDacor);
		
		if($dataDacor == 'TIDAK'){
		
		echo"<script>alert('TDP Tidak boleh Dibawah 25 Jika Status Level 6');history.back();</script>";
		exit;
		}
		}
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
		$jabatan_pemohon_val = $_POST['jabatan_pemohon_val'];
		$industry_type_pemohon = $_POST['industry_type_pemohon'];
		$industry_type_pemohon_val = $_POST['industry_type_pemohon_val'];
		$lama_bekerja_pemohon = $_POST['lama_bekerja_pemohon'];
		$lama_bekerja_pemohon_val = $_POST['lama_bekerja_pemohon_val'];
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
		
		$gaji_cra = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['gaji_cra']);
		$nominal_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_rak']);
		$tgl_gaji = $_POST['tgl_gaji'];
		$nominal_gajian = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_gajian']);
		$kry_bank_penerbit = $_POST['kry_bank_penerbit'];
		$kry_norek = $_POST['kry_norek'];
		$kry_pemilik_rekening = $_POST['kry_pemilik_rekening'];
		$mutasi_karyawan = $_POST['mutasi_karyawan'];
		$validasi_tf_pemohon = $_POST['validasi_tf_pemohon'];
		$val_tf = $_POST['validasi_tf_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_kry_pemohon']);
		$telp_kantor_pemohon = $_POST['telp_kantor_pemohon'];
		$status_karyawan_pemohon = $_POST['status_karyawan_pemohon'];
		$pic_kantor_pemohon = $_POST['pic_kantor_pemohon'];
		$verf_kantor_kry_pemohon = $_POST['verf_kantor_kry_pemohon']; 
		
		
		
	$callInsKryPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsKryPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$gaji_pasangan_cra = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['gaji_pasangan_cra']);
		$nominal_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_pasangan_rak']);
		$tgl_pasangan_gaji = $_POST['tgl_pasangan_gaji'];
		$besaran_nominal_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['besaran_nominal_pasangan']);
		$kry_bank_penerbit_pasangan = $_POST['kry_bank_penerbit_pasangan'];
		$kry_norek_pasangan = $_POST['kry_norek_pasangan'];
		$kry_pemilik_rekening_pasangan = $_POST['kry_pemilik_rekening_pasangan'];
		$mutasi_karyawan_pasangan = $_POST['mutasi_karyawan_pasangan'];
		$validasi_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$val_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_kry_pasangan']);
		$telp_kantor_pasangan = $_POST['telp_kantor_pasangan'];
		$status_karyawan_pasangan = $_POST['status_karyawan_pasangan'];
		$pic_kantor_pasangan = $_POST['pic_kantor_pasangan'];
		$verf_kantor_kry_pasangan = $_POST['verf_kantor_kry_pasangan'];
		
		
	$callInsKryPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsKryPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$wrs_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['wrs_pemohon_pendapatan']);
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
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_wrs_pemohon']);
		
		
		
		
	$callInsWrsPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsWrsPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
	$exec1InsWrsPemH = sqlsrv_query( $conn, $callInsWrsPemH, $paramInsWrsPemH) or die( print_r( sqlsrv_errors(), true)); 		
		
		
		
		
		
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
		$wrs_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['wrs_pasangan_pendapatan']);
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
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_wrs_pasangan']);
		
		
		
	$callInsWrsPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsWrsPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$pro_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pro_pemohon_pendapatan']);
		
		
		$pro_pemohon_bank_penerbit = $_POST['pro_pemohon_bank_penerbit'];
		$pro_pemohon_norek = $_POST['pro_pemohon_norek'];
		$pro_pemohon_rekening = $_POST['pro_pemohon_rekening'];
		$pro_pemohon_mutasi = $_POST['pro_pemohon_mutasi'];
		$validasi_pro_pemohon = $_POST['validasi_pro_pemohon'];
		$val_tf = $_POST['validasi_pro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_pro_pemohon']);
		
			
		
	$callInsProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsProPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$pro_spt_pasangan_ck = $_POST['pro_spt_pasangan_ck'];
		$pro_spt_pasangan_val = $_POST['pro_spt_pasangan_val'];	
		
		$pro_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pro_pasangan_pendapatan']);
		
		
		$pro_pasangan_bank_penerbit = $_POST['pro_pasangan_bank_penerbit'];
		$pro_pasangan_norek = $_POST['pro_pasangan_norek'];
		$pro_pasangan_rekening = $_POST['pro_pasangan_rekening'];
		$pro_pasangan_mutasi = $_POST['pro_pasangan_mutasi'];
		$validasi_pro_pasangan = $_POST['validasi_pro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_pro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_pro_pasangan']);
			
		
	$callInsProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsProPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$nonpro_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nonpro_pemohon_pendapatan']);
		
		
		$nonpro_pemohon_bank_penerbit = $_POST['nonpro_pemohon_bank_penerbit'];
		$nonpro_pemohon_norek = $_POST['nonpro_pemohon_norek'];
		$nonpro_pemohon_rekening = $_POST['nonpro_pemohon_rekening'];
		$nonpro_pemohon_mutasi = $_POST['nonpro_pemohon_mutasi'];
		$validasi_nonpro_pemohon = $_POST['validasi_nonpro_pemohon'];
		$val_tf = $_POST['validasi_nonpro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_nonpro_pemohon']);
		
		
			
		
	$callInsNonProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsNonProPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$nonpro_spt_pasangan_ck = $_POST['nonpro_spt_pasangan_ck'];
		$nonpro_spt_pasangan_val = $_POST['nonpro_spt_pasangan_val'];	
		
		$nonpro_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nonpro_pasangan_pendapatan']);
		
		
		$nonpro_pasangan_bank_penerbit = $_POST['nonpro_pasangan_bank_penerbit'];
		$nonpro_pasangan_norek = $_POST['nonpro_pasangan_norek'];
		$nonpro_pasangan_rekening = $_POST['nonpro_pasangan_rekening'];
		$nonpro_pasangan_mutasi = $_POST['nonpro_pasangan_mutasi'];
		$validasi_nonpro_pasangan = $_POST['validasi_nonpro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_nonpro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_nonpro_pasangan']);
			
		
	$callInsNonProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsNonProPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
	$exec1InsNonProPasH = sqlsrv_query( $conn, $callInsNonProPasH, $paramInsNonProPasH) or die( print_r( sqlsrv_errors(), true)); 		
		
		
	}
		if($outputRumah <> "null"){
		$callImgRumah = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImgRumah = array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('DOKUMEN PENDUKUNG RUMAH', SQLSRV_PARAM_IN),
						array($outputRumah, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
				
		$exec1ImgRumah = sqlsrv_query( $conn, $callImgRumah, $paramImgRumah) or die( print_r( sqlsrv_defaults(), true)); 		
		
		}
	


	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_defaults(), true)); 		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_defaults(), true)); 		


	}
	if($output7 <> "null"){
	$callImg7 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg7 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
					array($output7, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img7 = sqlsrv_query( $conn, $callImg7, $paramImg7) or die( print_r( sqlsrv_defaults(), true)); 		


	}		
	
	if($join_income == "YA"){
		
		if($output8 <> "null"){
		$callImg8 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg8 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
						array($output8, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img8 = sqlsrv_query( $conn, $callImg8, $paramImg8) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		

		
		if($output9 <> "null"){
		$callImg9 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg9 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
						array($output9, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img9 = sqlsrv_query( $conn, $callImg9, $paramImg9) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		
		if($output10 <> "null"){
		$callImg10 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg10 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
						array($output10, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img10 = sqlsrv_query( $conn, $callImg10, $paramImg10) or die( print_r( sqlsrv_defaults(), true)); 		
			

		}	
		
		if($output11 <> "null"){
		$callImg11 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg11 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
						array($output11, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img11 = sqlsrv_query( $conn, $callImg11, $paramImg11) or die( print_r( sqlsrv_defaults(), true)); 		


		}
		if($output12 <> "null"){
		$callImg12 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg12 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
						array($output12, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img12 = sqlsrv_query( $conn, $callImg12, $paramImg12) or die( print_r( sqlsrv_errors(), true)); 		


		}
	}
	
	if($catatan1 <> "null"){
	$callCatatan1 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($catatan1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan1 = sqlsrv_query( $conn, $callCatatan1, $paramCatatan1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	
	if($catatan2 <> "null"){
	$callCatatan2 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($catatan2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan2= sqlsrv_query( $conn, $callCatatan2, $paramCatatan2) or die( print_r( sqlsrv_defaults(), true)); 		
	}
	
	if($nama_pemilik_rumah <> "null"){
	$callCatatanRumah = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatanRumah = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('NAMA_PEMILIK_RUMAH', SQLSRV_PARAM_IN),
					array($nama_pemilik_rumah, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatanRumah= sqlsrv_query( $conn, $callCatatanRumah, $paramCatatanRumah) or die( print_r( sqlsrv_defaults(), true)); 		
	}

	$queryDomisili = "{call SP_RAK_INSERT_UPDATE_DOMISILI_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterDomisili = array(
					array($app_no, SQLSRV_PARAM_IN),
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
					array($user, SQLSRV_PARAM_IN),
					array($nama_pemilik_rumah, SQLSRV_PARAM_IN)
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
					array($app_no, SQLSRV_PARAM_IN),
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
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN),
					array($final_approval, SQLSRV_PARAM_IN)
				);
			//echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true));	
	}else{
		
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN)
				);
			//echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_errors(), true));	
	}
	//or die( print_r( sqlsrv_errors(), true));	
	//or die( print_r( sqlsrv_defaults(), true)); 
	if($execInsert){
			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	
}




if(isset($_POST['submitNo'])){
	/*
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$output3 = prepareImageDBString($_FILES['img_kunjungan_karyawan_pemohon']['tmp_name']);
	$output4 = prepareImageDBString($_FILES['img_tf_kry_pemohon']['tmp_name']);
	$output5 = prepareImageDBString($_FILES['img_tf_wrs_pemohon']['tmp_name']);
	$output6 = prepareImageDBString($_FILES['img_tf_pro_pemohon']['tmp_name']);
	*/
	$output1 = prepareImageDBString($_FILES['img_domisili']['tmp_name']);
	$output2 = prepareImageDBString($_FILES['img_geotaging']['tmp_name']);
	$outputRumah = prepareImageDBString($_FILES['img_status_rumah']['tmp_name']);
	$catatan1 = $_POST['catatan_domisili'];
	$catatan2 = $_POST['catatan_geotaging'];
	$nama_pemilik_rumah = $_POST['nama_pemilik_rumah'];
	//$dataInfo['Pasangan_CUST_MODEL']
	
	$level = 1;
	$role_code = "CA";
	$cust_pemohon = "PEMOHON";
	$cust_pasangan = "PASANGAN";
	$cust_name = $_POST['cust_name'];
	$jenis_kendaraan = $_POST['jenis_kendaraan'];
	$asset_name = $_POST['asset_name'];
	$dealer_name = $_POST['dealer_name'];
	$ph = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['ph']);
	$otr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['otr']);
	$tenor = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tenor']);
	$amount_tdp = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['amount_tdp']);
	$tdp_persen = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['tdp_persen']); 
	$kordinat_geotagging = $_POST['kordinat_geotagging'];
	$join_income = $_POST['join_income'];
	$cust_model_pemohon = $dataInfo['CUST_MODEL'];
	$cust_model_pasangan = $dataInfo['Pasangan_CUST_MODEL'];
	$note_rak = $_POST['note_rak'];
	$analisa = $_POST['analisa'];
	$angsuran_new = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_new']);
	$kewajiban_tempatlain = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['kewajiban_tempatlain']);
	$total_kewajiban = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_kewajiban']);
	$total_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['total_pendapatan']);
	//$dsr = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['dsr']); 
	$dsr = $_POST['dsr'];
	$rekomendasi = "TIDAK REKOMENDASI";
	
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
	$alamat_domisili_pemohon_val = $_POST['alamat_domisili_pemohon_val'];
	$alamat_domisili_pemohon_notes = $_POST['alamat_domisili_pemohon_notes'];
	$alamat_domisili_pasangan_val = $_POST['alamat_domisili_pasangan_val'];
	$alamat_domisili_pasangan_notes = $_POST['alamat_domisili_pasangan_notes'];
	$domisili_val =  $_POST['domisili_val'];
	$catatan_domisili =  $_POST['catatan_domisili'];
	$hasil_foto_survey_val =  $_POST['hasil_foto_survey_val'];
	$catatan_geotaging =  $_POST['catatan_geotaging'];
	$angsuran_berjalan =  str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['angsuran_berjalan']);
	
		if($type_kendaraan == '15'){
	$final_approval = $_POST['final_approval'];
	$tdp_score = $_POST['tdp_score'];
	$prox_level = $_POST['prox_level'];
	
	IF($prox_level == 'LEVEL 6' && $tdp_score <'25'){
		$callDacor = "{call SP_GET_AFA_DACOR_RAK_TDP(?)}";
		$paramDacor =  array(array($app_no, SQLSRV_PARAM_IN));
		$execDacor = sqlsrv_query( $conn, $callDacor, $paramDacor) or die( print_r( sqlsrv_defaults(), true)); 
		$dataDacor = sqlsrv_fetch_array($execDacor);
		
		if($dataDacor == 'TIDAK'){
		
		echo"<script>alert('TDP Tidak boleh Dibawah 25 Jika Status Level 6');history.back();</script>";
		exit;
		}
	}
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
		$jabatan_pemohon_val = $_POST['jabatan_pemohon_val'];
		$industry_type_pemohon = $_POST['industry_type_pemohon'];
		$industry_type_pemohon_val = $_POST['industry_type_pemohon_val'];
		$lama_bekerja_pemohon = $_POST['lama_bekerja_pemohon'];
		$lama_bekerja_pemohon_val = $_POST['lama_bekerja_pemohon_val'];
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
		
		$gaji_cra = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['gaji_cra']);
		$nominal_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_rak']);
		$tgl_gaji = $_POST['tgl_gaji'];
		$nominal_gajian = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_gajian']);
		$kry_bank_penerbit = $_POST['kry_bank_penerbit'];
		$kry_norek = $_POST['kry_norek'];
		$kry_pemilik_rekening = $_POST['kry_pemilik_rekening'];
		$mutasi_karyawan = $_POST['mutasi_karyawan'];
		$validasi_tf_pemohon = $_POST['validasi_tf_pemohon'];
		$val_tf = $_POST['validasi_tf_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_kry_pemohon']);
		$telp_kantor_pemohon = $_POST['telp_kantor_pemohon'];
		$status_karyawan_pemohon = $_POST['status_karyawan_pemohon'];
		$pic_kantor_pemohon = $_POST['pic_kantor_pemohon'];
		$verf_kantor_kry_pemohon = $_POST['verf_kantor_kry_pemohon'];
		
	$callInsKryPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsKryPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$gaji_pasangan_cra = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['gaji_pasangan_cra']);
		$nominal_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nominal_pasangan_rak']);
		$tgl_pasangan_gaji = $_POST['tgl_pasangan_gaji'];
		$besaran_nominal_pasangan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['besaran_nominal_pasangan']);
		$kry_bank_penerbit_pasangan = $_POST['kry_bank_penerbit_pasangan'];
		$kry_norek_pasangan = $_POST['kry_norek_pasangan'];
		$kry_pemilik_rekening_pasangan = $_POST['kry_pemilik_rekening_pasangan'];
		$mutasi_karyawan_pasangan = $_POST['mutasi_karyawan_pasangan'];
		$validasi_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$val_tf_pasangan = $_POST['validasi_tf_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_kry_pasangan']);
		$telp_kantor_pasangan = $_POST['telp_kantor_pasangan'];
		$status_karyawan_pasangan = $_POST['status_karyawan_pasangan'];
		$pic_kantor_pasangan = $_POST['pic_kantor_pasangan'];
		$verf_kantor_kry_pasangan = $_POST['verf_kantor_kry_pasangan'];
		
		
	$callInsKryPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_KARYAWAN(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsKryPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsKryPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$wrs_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['wrs_pemohon_pendapatan']);
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
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_wrs_pemohon']);
		
		
		
	$callInsWrsPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsWrsPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$wrs_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['wrs_pasangan_pendapatan']);
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
		$val_pasangan = $wrs_pasangan_pendapatan;
		$val_tf_pasangan = 	 $wrs_pasangan_pendapatan;
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_wrs_pasangan']);
		
		
		
		
	$callInsWrsPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_WIRASWASTA(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsWrsPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsWrsPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$pro_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pro_pemohon_pendapatan']);
		
		
		$pro_pemohon_bank_penerbit = $_POST['pro_pemohon_bank_penerbit'];
		$pro_pemohon_norek = $_POST['pro_pemohon_norek'];
		$pro_pemohon_rekening = $_POST['pro_pemohon_rekening'];
		$pro_pemohon_mutasi = $_POST['pro_pemohon_mutasi'];
		$validasi_pro_pemohon = $_POST['validasi_pro_pemohon'];
		$val_tf = $_POST['validasi_pro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_pro_pemohon']);
		
			
		
	$callInsProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsProPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$pro_spt_pasangan_ck = $_POST['pro_spt_pasangan_ck'];
		$pro_spt_pasangan_val = $_POST['pro_spt_pasangan_val'];	
		
		$pro_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pro_pasangan_pendapatan']);
		
		
		$pro_pasangan_bank_penerbit = $_POST['pro_pasangan_bank_penerbit'];
		$pro_pasangan_norek = $_POST['pro_pasangan_norek'];
		$pro_pasangan_rekening = $_POST['pro_pasangan_rekening'];
		$pro_pasangan_mutasi = $_POST['pro_pasangan_mutasi'];
		$validasi_pro_pasangan = $_POST['validasi_pro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_pro_pasangan'];
			$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_pro_pasangan']);
			
		
	$callInsProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsProPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsProPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
		
		$nonpro_pemohon_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nonpro_pemohon_pendapatan']);
		
		
		$nonpro_pemohon_bank_penerbit = $_POST['nonpro_pemohon_bank_penerbit'];
		$nonpro_pemohon_norek = $_POST['nonpro_pemohon_norek'];
		$nonpro_pemohon_rekening = $_POST['nonpro_pemohon_rekening'];
		$nonpro_pemohon_mutasi = $_POST['nonpro_pemohon_mutasi'];
		$validasi_nonpro_pemohon = $_POST['validasi_nonpro_pemohon'];
		$val_tf = $_POST['validasi_nonpro_pemohon'];
		$pendapatan_pemohon_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pemohon_cf']);
		$pendapatan_pemohon_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_nonpro_pemohon']);
		
			
		
	$callInsNonProPemD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPemD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsNonProPemH = array(array($app_no, SQLSRV_PARAM_IN),
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
		$nonpro_spt_pasangan_ck = $_POST['nonpro_spt_pasangan_ck'];
		$nonpro_spt_pasangan_val = $_POST['nonpro_spt_pasangan_val'];	
		
		$nonpro_pasangan_pendapatan = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['nonpro_pasangan_pendapatan']);
		
		
		$nonpro_pasangan_bank_penerbit = $_POST['nonpro_pasangan_bank_penerbit'];
		$nonpro_pasangan_norek = $_POST['nonpro_pasangan_norek'];
		$nonpro_pasangan_rekening = $_POST['nonpro_pasangan_rekening'];
		$nonpro_pasangan_mutasi = $_POST['nonpro_pasangan_mutasi'];
		$validasi_nonpro_pasangan = $_POST['validasi_nonpro_pasangan'];
		$val_tf_pasangan = $_POST['validasi_nonpro_pasangan'];
		$pendapatan_pasangan_cf = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['pendapatan_pasangan_cf']);
		$pendapatan_pasangan_rak = str_replace(str_split('\\/:*?"<>|,.'), '',$_POST['final_ca_nonpro_pasangan']);
			
		
	$callInsNonProPasD = "{call SP_RAK_INSERT_UPDATE_KAPASITAS_NON_PROFESIONAL(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsNonProPasD = array(array($app_no, SQLSRV_PARAM_IN),
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
	$paramInsNonProPasH = array(array($app_no, SQLSRV_PARAM_IN),
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
	
	if($outputRumah <> "null"){
		$callImgRumah = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImgRumah = array(array($app_no, SQLSRV_PARAM_IN),
						array('PEMOHON', SQLSRV_PARAM_IN),
						array('DOKUMEN PENDUKUNG RUMAH', SQLSRV_PARAM_IN),
						array($outputRumah, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1ImgRumah = sqlsrv_query( $conn, $callImgRumah, $paramImgRumah) or die( print_r( sqlsrv_defaults(), true)); 		

		}

	
	if($output1 <> "null"){
	$callImg1 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($output1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img1 = sqlsrv_query( $conn, $callImg1, $paramImg1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	if($output2 <> "null"){
	$callImg2 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($output2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img2 = sqlsrv_query( $conn, $callImg2, $paramImg2) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	if($output3 <> "null"){
	$callImg3 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg3 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
					array($output3, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img3 = sqlsrv_query( $conn, $callImg3, $paramImg3) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	

	
	if($output4 <> "null"){
	$callImg4 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg4 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
					array($output4, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img4 = sqlsrv_query( $conn, $callImg4, $paramImg4) or die( print_r( sqlsrv_defaults(), true)); 		

	}	
	
	if($output5 <> "null"){
	$callImg5 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg5 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
					array($output5, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img5 = sqlsrv_query( $conn, $callImg5, $paramImg5) or die( print_r( sqlsrv_defaults(), true)); 		
		

	}	
	
	if($output6 <> "null"){
	$callImg6 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg6 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
					array($output6, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img6 = sqlsrv_query( $conn, $callImg6, $paramImg6) or die( print_r( sqlsrv_defaults(), true)); 		


	}
	if($output7 <> "null"){
	$callImg7 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
	$paramImg7 = array(array($app_no, SQLSRV_PARAM_IN),
					array('PEMOHON', SQLSRV_PARAM_IN),
					array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
					array($output7, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec1Img7 = sqlsrv_query( $conn, $callImg7, $paramImg7) or die( print_r( sqlsrv_defaults(), true)); 		


	}		
	
	if($join_income == "YA"){
		
		if($output8 <> "null"){
		$callImg8 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg8 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('KUNJUNGAN KARYAWAN', SQLSRV_PARAM_IN),
						array($output8, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img8 = sqlsrv_query( $conn, $callImg8, $paramImg8) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		

		
		if($output9 <> "null"){
		$callImg9 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg9 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK KARYAWAN', SQLSRV_PARAM_IN),
						array($output9, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img9 = sqlsrv_query( $conn, $callImg9, $paramImg9) or die( print_r( sqlsrv_defaults(), true)); 		

		}	
		
		if($output10 <> "null"){
		$callImg10 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg10 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK WIRASWASTA', SQLSRV_PARAM_IN),
						array($output10, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img10 = sqlsrv_query( $conn, $callImg10, $paramImg10) or die( print_r( sqlsrv_defaults(), true)); 		
			

		}	
		
		if($output11 <> "null"){
		$callImg11 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg11 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK PROFESIONAL', SQLSRV_PARAM_IN),
						array($output11, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img11 = sqlsrv_query( $conn, $callImg11, $paramImg11) or die( print_r( sqlsrv_defaults(), true)); 		


		}
		if($output12 <> "null"){
		$callImg12 = "{call SP_UPDATE_IMAGES_UPLOAD_CA(?,?,?,?,?)}";
		$paramImg12 = array(array($app_no, SQLSRV_PARAM_IN),
						array('PASANGAN', SQLSRV_PARAM_IN),
						array('VALIDASI BANK NON PROFESIONAL', SQLSRV_PARAM_IN),
						array($output12, SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$exec1Img12 = sqlsrv_query( $conn, $callImg12, $paramImg12) or die( print_r( sqlsrv_defaults(), true)); 		


		}
	}
	
	if($catatan1 <> "null"){
	$callCatatan1 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan1 = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('DOMISILI', SQLSRV_PARAM_IN),
					array($catatan1, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan1 = sqlsrv_query( $conn, $callCatatan1, $paramCatatan1) or die( print_r( sqlsrv_defaults(), true)); 		

	}
	
	if($catatan2 <> "null"){
	$callCatatan2 = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatan2 = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('GEOTAGING', SQLSRV_PARAM_IN),
					array($catatan2, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatan2= sqlsrv_query( $conn, $callCatatan2, $paramCatatan2) or die( print_r( sqlsrv_defaults(), true)); 		
	}
	
		
	if($nama_pemilik_rumah <> "null"){
	$callCatatanRumah = "{call SP_UPDATE_NOTES_UPLOAD(?,?,?,?,?)}";
	$paramCatatanRumah = array(array($app_no, SQLSRV_PARAM_IN),
					array('CA', SQLSRV_PARAM_IN),
					array('NAMA_PEMILIK_RUMAH', SQLSRV_PARAM_IN),
					array($nama_pemilik_rumah, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$execCatatanRumah= sqlsrv_query( $conn, $callCatatanRumah, $paramCatatanRumah) or die( print_r( sqlsrv_defaults(), true)); 		
	}
	
	
	
	if($join_income == "TIDAK"){
	$val_tf_pasangan = '';
	$pendapatan_pasangan_cf = 0;
	$pendapatan_pasangan_rak  = 0;
	}
	$queryValidasi = "{call SP_RAK_INSERT_UPDATE_VALIDASI(?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterValidasi = array(
					array($app_no, SQLSRV_PARAM_IN),
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
	

	$queryDomisili = "{call SP_RAK_INSERT_UPDATE_DOMISILI_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
	$parameterDomisili = array(
					array($app_no, SQLSRV_PARAM_IN),
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
					array($user, SQLSRV_PARAM_IN),
					array($nama_pemilik_rumah, SQLSRV_PARAM_IN)
				);
			//	echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execDomisili = sqlsrv_query( $conn, $queryDomisili, $parameterDomisili) or die( print_r( sqlsrv_defaults(), true)); 
	

		if($type_kendaraan == '15'){
		
		
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_REJECT_NEW(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN),
					array($final_approval, SQLSRV_PARAM_IN)
				);
				//echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_defaults(), true)); 
	}else{
		
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_CREDIT_REJECT(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}"; 
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
					array($pendapatan_pemohon_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_cf, SQLSRV_PARAM_IN),
					array($pendapatan_pemohon_rak, SQLSRV_PARAM_IN),
					array($pendapatan_pasangan_rak, SQLSRV_PARAM_IN),
					array($angsuran_berjalan, SQLSRV_PARAM_IN)
				);
				//echo '<pre>' . var_export($parameterInsert,true) .'<pre>'; 
			//exit();
	$execInsert = sqlsrv_query( $conn, $queryInsert, $parameterInsert) or die( print_r( sqlsrv_defaults(), true)); 
	}
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
										<td >APP SOURCE</td>
										<td >
											<input type="text" name="app_source" id="app_source"  value="<?php echo $dataCust['APP_SRC_NAME']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
									<tr>
										<td >PROD OFFERING</td>
										<td >
											<input type="text" name="prod_offering" id="prod_offering"  value="<?php echo $dataCust['PROD_OFFERING_NAME']; ?>"  class="form-control" readonly onautocomplete="off">
										</td>
									</tr>
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
							
						<div class="col-md-12 col-sm-12">
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
											<input type="text" name="tanggal_pemohon" class="form-control" value="<?php echo $dataInfo['BIRTH_DT']->format("d F Y");;?>"  id="ttl_pemohon" readonly>
										
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
										<td style="width:20%;">
											<select name="alamat_domisili_pemohon_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>   
										</td>
										<td style="width:30%;">
											<input type="text" name="alamat_domisili_pemohon_notes" class="form-control" placeholder="Notes Alamat Domisili" value=""  id="alamat_domisili_pemohon_notes">
										</td>
									</tr>
									
								</table>
							</div>								
						</div>
		
						<div class="col-md-12 col-sm-12">
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
										<td style="width:20%;">
											<select name="alamat_domisili_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>   
										</td>
										<td style="width:30%;">
											<input type="text" name="alamat_domisili_pasangan_notes" class="form-control" placeholder="Notes Alamat Domisili" value=""  id="alamat_domisili_pasangan_notes">
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
												<input type="checkbox" name="shm_ck" id="shm_ck" value="SHM" onclick="myFunctionCk1()">
												<input type="hidden" name="shm_ck1" id="shm_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="shm_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Akta Jual Beli</td>
											<td style="width:10%;">
												<input type="checkbox" name="akta_jual_beli_ck" id="akta_jual_beli_ck" value="AKTA JUAL BELI" onclick="myFunctionCk2()">
													<input type="hidden" name="akta_jual_beli_ck1" id="akta_jual_beli_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="akta_jual_beli_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Girik</td>
											<td style="width:10%;">
												<input type="checkbox" name="surat_girik_ck" id="surat_girik_ck" value="SURAT GIRIK" onclick="myFunctionCk3()">
												<input type="hidden" name="surat_girik_ck1" id="surat_girik_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="surat_girik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">PBB</td>
											<td style="width:10%;">
												<input type="checkbox" name="pbb_ck" id="pbb_ck" value="PBB" onclick="myFunctionCk4()">
												<input type="hidden" name="pbb_ck1" id="pbb_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="pbb_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Rek Listrik</td>
											<td style="width:10%;">
												<input type="checkbox" name="rek_listrik_ck" id="rek_listrik_ck" value="REK LISTRIK" onclick="myFunctionCk5()">
												<input type="hidden" name="rek_listrik_ck1" id="rek_listrik_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_listrik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">REK AIR</td>
											<td style="width:10%;">
												<input type="checkbox" name="rek_air_ck" id="rek_air_ck" value="REK AIR" onclick="myFunctionCk6()">
												<input type="hidden" name="rek_air_ck1" id="rek_air_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_air_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Keputusan Rumah Dinas (Jika Menempati Rumah)</td>
											<td style="width:10%;">
												<input type="checkbox" name="skrd_ck" id="skrd_ck" value="SURAT KEPUTUSAN RUMAH DINAS" onclick="myFunctionCk7()">
												<input type="hidden" name="skrd_ck1" id="skrd_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="skrd_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									<tr>
										<td style="width:50%;">STATUS RUMAH</td>
										<td style="width:50%;" colspan="2">
											<select name="status_rumah_val" class="form-control" required>
														<option value="">--Pilih--</option>
														<option value="COMPANY">COMPANY</option>
														<option value="FAMILY">FAMILY HOUSE</option>
														<option value="MORTGAGE">MORTGAGE</option>
														<option value="RENT">RENT</option>
														<option value="SELF">SELF OWNED</option>
														<option value="SPOUSE">SPOUSE OWNED</option>
														<option value="OTHERS">OTHERS</option>
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
														<option value="Cek Ke BPN">Cek Ke BPN</option>
														<option value="Cek Notaris Penerbit">Cek Notaris Penerbit</option>
														<option value="Cek by Virtual">Cek by Virtual</option>
														<option value="Cek by Online">Cek by Online</option>
														<option value="Cek by Dispenda">Cek by Dispenda</option>
														<option value="PV">PV</option>
														<option value="Kunjungan ke kantor">Kunjungan ke kantor</option>
														
											</select>   
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NOTES</td>
										<td colspan="2">
													<textarea name="catatan_domisili" id="catatan_domisili" value="" class="form-control"> </textarea>
													
										</td>
									</tr>
									<tr>
												<td >Upload Bukti Validasi </td>
													<td colspan="2" >
														<input type="file" name="img_domisili" required style="margin-bottom:5px;" />

													</td>
									</tr>
									
									
									
									
								</table>
							</div>								
						</div>
						<div class="col-md-6 col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered">

									<tr>
										<td style="width:30%;">NAMA PEMIILIK RUMAH</td>
										<td colspan= "2">
											<input type="text" name="nama_pemilik_rumah" class="form-control" value=""  id="nama_pemilik_rumah" required>
										</td>
									
									</tr>
								
									<tr>
												<td >UPLOAD BUKTI PENDUKUNG </td>
													<td colspan="2" >
														<input type="file" name="img_status_rumah" required style="margin-bottom:5px;" />

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
												<!-- -6.451138968166088, 106.8215519785069-->
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
														<option value="SESUAI">SESUAI</option>
														<option value="TIDAK SESUAI">TIDAK SESUAI</option>
													
											</select> 
													
										</td>
									</tr>
										<tr>
										<td style="width:30%;">NOTES</td>
										<td colspan="2">
													<textarea name="catatan_geotaging" id="catatan_geotaging" value="" class="form-control"> </textarea>
													
										</td>
									</tr>
									<tr>
												<td >Upload Bukti Validasi Geotaging </td>
												<td colspan="2" >
													<input type="file" name="img_geotaging" required style="margin-bottom:5px;" />
													
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
										<td style="width:30%;">Join Income ?</td>
										<td>
											<select name="join_income" id="join_income" class="form-control" onchange="myFunction()" required>
													<option value="">--- Pilih ---</option>
														<?php if($siapanih <> 'Penjamin'){ ?>
														<option value="YA">YA</option>
														<?php } ?> 
															<option value="TIDAK">TIDAK</option>
														
													
											</select> 
									
										</td>
									
									</tr>
									
										
											
										
								
									
								</table>
							</div>	
							
						</div>
						
					</div>
					</div>
					<div id="cust_model_pasangan_div" style="display:none;">
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
														<option value="PROFESSIONAL">PROFESIONAL</option>
											</select>   
										</td>
									
									</tr>
									
								</table>
							</div>								
						</div>
						*/ ?>
								<input type="hidden" name="app_no_hide" id="app_no_hide"  value="<?php echo $app_no;?>">
										<input type="hidden" name="nama_pemohon_hide" id="nama_pemohon_hide"  value="<?php echo $dataInfo['CUST_NAME'];?>">
										<input type="hidden" name="user_hide" id="user_hide"  value="<?php echo $user;?>">
										<input type="hidden" name="branchid_hide" id="branchid_hide"  value="<?php echo $branchid;?>">
										<input type="hidden" name="cust_type_pasangan_hide" id="cust_type_pasangan_hide"  value="<?php echo $siapanih;?>">
										
						
				
					<!------------------Karyawan -->
				
				<?php if($dataInfo['CUST_MODEL'] == 'KARYAWAN' ){ ?>
			
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
											 <select name="jabatan_pemohon_val" class="form-control" required>
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
											 <select name="industry_type_pemohon_val" class="form-control" required>
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
											 <select name="lama_bekerja_pemohon_val" class="form-control" required>
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
											<input type="text" name="telp_kantor_pemohon" class="form-control" value="<?php  echo $dataInfoProfesi['PEMOHON_KANTOR_PHONE']; ?>"  id="telp_kantor_pemohon" >
										</td>
									
									
									</tr>
								
									<tr>
										<td style="width:30%;">STATUS KARYAWAN</td>
										<td style="width:50%;">
											 <select name="status_karyawan_pemohon" id="status_karyawan_pemohon"  class="form-control">
														<option value="">-Pilih-</option>
														<option value="AKTIF">AKTIF</option>
														<option value="TIDAK AKTIF">TIDAK AKTIF</option>
														<option value="DALAM PROSES RESIGN">DALAM PROSES RESIGN</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NAMA PIC KANTOR YANG DAPAT DIHUBUNGI</td>
										<td style="width:50%;">
											<input type="text" name="pic_kantor_pemohon" class="form-control" value=""  id="pic_kantor_pemohon" >
										</td>
									
									
									</tr>
									<tr>
										<td style="width:30%;">HASIL VERIFIKASI KANTOR</td>
										<td style="width:50%;">
											<textarea type="input" name="verf_kantor_kry_pemohon"  class="form-control" value=""  id="verf_kantor_kry_pemohon" > </textarea>
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
											<input type="checkbox" class="aroClass" name="slip_gaji_pemohon_ck" id="slip_gaji_pemohon_ck" value="" onclick="FuncKryPemohon1()">
												<input type="hidden" name="slip_gaji_pemohon_ck1" id="slip_gaji_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="slip_gaji_pemohon_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">DAFTAR GAJI</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="daftar_gaji_pemohon_ck" id="daftar_gaji_pemohon_ck" value="" onclick="FuncKryPemohon2()">
											<input type="hidden" name="daftar_gaji_pemohon_ck1" id="daftar_gaji_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">SURAT KETERANGAN PENGHASILAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pemohon_ck" id="surat_ket_penghasilan_pemohon_ck" value="" value="" onclick="FuncKryPemohon3()">
											<input type="hidden" name="surat_ket_penghasilan_pemohon_ck1" id="surat_ket_penghasilan_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">BUKTI SALDO PRINT SCREEN JAMSOSTEK</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pemohon_ck" id="bukti_saldo_print_jamsos_pemohon_ck" value="" onclick="FuncKryPemohon4()"> 
											<input type="hidden" name="bukti_saldo_print_jamsos_pemohon_ck1" id="bukti_saldo_print_jamsos_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									<tr>
										<td style="width:30%;">BUKTI SPT PAJAK TAHUN TERAKHIR</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="bukti_spt_pemohon_ck" id="bukti_spt_pemohon_ck" value=""  onclick="FuncKryPemohon5()">
											<input type="hidden" name="bukti_spt_pemohon_ck1" id="bukti_spt_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">REKENING TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pemohon_ck" id="rekening_tabungan_pemohon_ck" value="" onclick="FuncKryPemohon6()">
											<input type="hidden" name="rekening_tabungan_pemohon_ck1" id="rekening_tabungan_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">FOTO KARTU IDENTITAS KARYAWAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pemohon_ck" id="foto_kartu_identitas_pemohon_ck" value="" onclick="FuncKryPemohon7()">
											<input type="hidden" name="foto_kartu_identitas_pemohon_ck1" id="foto_kartu_identitas_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="foto_kartu_identitas_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_kunjungan_karyawan_pemohon" required style="margin-bottom:5px;" />
													
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
										<td style="width:30%"; colspan="2">Jika Pilihan Slip Gaji/Daftar Gaji/SKT/Print Jamsostek/SPT 
										Nominal Gaji Yang tertera Pada Bukti Penghasilan Sesuai Dengan Bukti Kapasitas Yang dilampirkan
										</td>
										
									
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Gaji (Inputan CRA)
										</td>
											<td> <input type="text" name="gaji_cra" class="form-control" value="<?php echo number_format($dataBank['GAJI_PEMOHON'],0,',','.'); ?>"  id="gaji_cra" readonly>
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Gaji (RAK)
										</td>
											<td> <input type="text" name="nominal_rak" class="form-control" value=""  id="nominal_rak" >
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Penerimaan Gaji setiap tanggal   :
										</td>
											<td> <div class="input-group date">
												<input type="text" class="form-control" name="tgl_gaji" id="tgl_gaji" autocomplete="off" value="">
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
											<td> <input type="text" name="nominal_gajian" class="form-control" value=""  id="nominal_gajian" >
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
								
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
										<select name="mutasi_karyawan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_tf_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									</tr>

										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_kry_pemohon"  style="margin-bottom:5px;" />
													
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="kry_saldoAwal" class="form-control" value="" 
										id="kry_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwalKry" id="submit_saldoAwalKry" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="kry_tgl_transaksi" id="kry_tgl_transaksi" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="kry_ket_transaksi" class="form-control" value="" 
										id="kry_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_debit" class="form-control" value="0" 
										id="kry_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_kredit" class="form-control" value="0" 
										id="kry_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="kry_saldo" class="form-control" value="0" 
										id="kry_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from" id="submit_from" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
								
								
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_kry_pemohon" class="form-control" value=""  id="final_ca_kry_pemohon" required>
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					</div>
					
					<div id="historical_kredit_kry_pemohon" style="display:block;" >	
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
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					</div>
					
						
					
				
					<?php } ?>
					
					
					
					<!------------------Karyawan Pasangan -->
					<div id="kry_pasangan_div" style="display:none">
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
											<input type="text" name="lama_bekerja_pasangan" class="form-control" value="<?php echo $lama_bekerja_pasangan; ?> Bulan"   id="lama_bekerja_pasangan" readonly>
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
											<input type="text" name="telp_kantor_pasangan" class="form-control" value="<?php  echo $phn_kerja_pasangan; ?>"  id="telp_kantor_pasangan" >
										</td>
									
									
									</tr>
								
									<tr>
										<td style="width:30%;">STATUS KARYAWAN</td>
										<td style="width:50%;">
											 <select name="status_karyawan_pasangan" id="status_karyawan_pasangan"  class="form-control" >
														<option value="">-Pilih-</option>
														<option value="AKTIF">AKTIF</option>
														<option value="TIDAK AKTIF">TIDAK AKTIF</option>
														<option value="DALAM PROSES RESIGN">DALAM PROSES RESIGN</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">NAMA PIC KANTOR YANG DAPAT DIHUBUNGI</td>
										<td style="width:50%;">
											<input type="text" name="pic_kantor_pasangan" class="form-control" value=""  id="pic_kantor_pasangan" >
										</td>
									
									
									</tr>
									<tr>
										<td style="width:30%;">HASIL VERIFIKASI KANTOR</td>
										<td style="width:50%;">
											<textarea type="input" name="verf_kantor_kry_pasangan"  class="form-control" value=""  id="verf_kantor_kry_pasangan" > </textarea>
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
										
										<input type="checkbox" class="aroClass" name="slip_gaji_pasangan_ck" id="slip_gaji_pasangan_ck" value="" >
												<input type="hidden" name="slip_gaji_pasangan_ck1" id="slip_gaji_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="slip_gaji_pasangan_val" class="form-control" required>
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">DAFTAR GAJI</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="daftar_gaji_pasangan_ck" id="daftar_gaji_pasangan_ck" value="" >
											<input type="hidden" name="daftar_gaji_pasangan_ck1" id="daftar_gaji_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="daftar_gaji_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">SURAT KETERANGAN PENGHASILAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="surat_ket_penghasilan_pasangan_ck" id="surat_ket_penghasilan_pasangan_ck" value="" >
											<input type="hidden" name="surat_ket_penghasilan_pasangan_ck1" id="surat_ket_penghasilan_pasangan_ck1"  value="">
									</td>
										<td style="width:50%;">
											 <select name="surat_ket_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">BUKTI SALDO PRINT SCREEN JAMSOSTEK</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="bukti_saldo_print_jamsos_pasangan_ck" id="bukti_saldo_print_jamsos_pasangan_ck" value="" >
											<input type="hidden" name="bukti_saldo_print_jamsos_pasangan_ck1" id="bukti_saldo_print_jamsos_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_saldo_print_jamsos_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
									<tr>
										<td style="width:30%;">BUKTI SPT PAJAK TAHUN TERAKHIR</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="bukti_spt_pasangan_ck" id="bukti_spt_pasangan_ck" value="" >
										<input type="hidden" name="bukti_spt_pasangan_ck1" id="bukti_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="bukti_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">REKENING TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="rekening_tabungan_pasangan_ck" id="rekening_tabungan_pasangan_ck" value="" >
										<input type="hidden" name="rekening_tabungan_pasangan_ck1" id="rekening_tabungan_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="rekening_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>		
										<tr>
										<td style="width:30%;">FOTO KARTU IDENTITAS KARYAWAN</td>
										<td style="width:10%;">
											<input type="checkbox" class="aroClass" name="foto_kartu_identitas_pasangan_ck" id="foto_kartu_identitas_pasangan_ck" value="" >
										<input type="hidden" name="foto_kartu_identitas_pasangan_ck1" id="foto_kartu_identitas_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="foto_kartu_identitas_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_kunjungan_karyawan_pasangan"  style="margin-bottom:5px;" />
													
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
										<td style="width:30%"; colspan="2">Jika Pilihan Slip Gaji/Daftar Gaji/SKT/Print Jamsostek/SPT 
										Nominal Gaji Yang tertera Pada Bukti Penghasilan Sesuai Dengan Bukti Kapasitas Yang dilampirkan
										</td>
										
									
										</td>
									</tr>
									<tr>
										<td style="width:30%";>
										Nominal Gaji (Inputan CRA)
										</td>
											<td> <input type="text" name="gaji_pasangan_cra" class="form-control" value="<?php echo number_format($dataBank['GAJI_PASANGAN'],0,',','.'); ?>"  id="gaji_pasangan_cra" readonly>
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
					</div>	
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
										<select name="mutasi_karyawan_pasangan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_tf_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_kry_pasangan"  style="margin-bottom:5px;" />
													
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="kry_saldoAwal_pasangan" class="form-control" value="" 
										id="kry_saldoAwal_pasangan" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwalKry_pasangan" id="submit_saldoAwalKry_pasangan" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="kry_tgl_transaksi_pasangan" id="kry_tgl_transaksi_pasangan" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="kry_ket_transaksi_pasangan" class="form-control" value="" 
										id="kry_ket_transaksi_pasangan" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_debit_pasangan" class="form-control" value="0" 
										id="kry_mutasi_debit_pasangan" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_kredit_pasangan" class="form-control" value="0" 
										id="kry_mutasi_kredit_pasangan" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="kry_saldo_pasangan" class="form-control" value="0" 
										id="kry_saldo_pasangan" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_pasangan" id="submit_from_pasangan" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
								
								
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_kry_pasangan" class="form-control" value=""  id="final_ca_kry_pasangan">
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
								$totalNaBakiDebetNaPasangan = 0;
								$totalNaAngsuranNaPasangan = 0;
								
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
											<input type="checkbox"  name="rek_tabungan_pemohon_wrs_ck" id="rek_tabungan_pemohon_wrs_ck" value="" onclick="FuncWrsPemohon1()">
										</td>
										<input type="hidden" name="rek_tabungan_pemohon_wrs_ck1" id="rek_tabungan_pemohon_wrs_ck1"  value="">
										<td style="width:50%;">
											 <select name="rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">Nota Pembelian</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nota_pembelian_wrs_pemohon_ck" id="nota_pembelian_wrs_pemohon_ck" value="" onclick="FuncWrsPemohon2()">
											<input type="hidden" name="nota_pembelian_wrs_pemohon_ck1" id="nota_pembelian_wrs_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nota_pembelian_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">Nota Penjualan</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nota_penjualan_wrs_pemohon_ck" id="nota_penjualan_wrs_pemohon_ck" value="" onclick="FuncWrsPemohon3()">
											<input type="hidden" name="nota_penjualan_wrs_pemohon_ck1" id="nota_penjualan_wrs_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nota_penjualan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="spt_wrs_pemohon_ck" id="spt_wrs_pemohon_ck" value="" onclick="FuncWrsPemohon4()">
											<input type="hidden" name="spt_wrs_pemohon_ck1" id="spt_wrs_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="spt_wrs_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
										<select name="wrs_pemohon_mutasi" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_wrs_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_saldoAwal" class="form-control" value="" 
										id="wrs_pemohon_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_wrs_pemohon" id="submit_saldoAwal_wrs_pemohon" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="wrs_pemohon_tgl_transaksi" id="wrs_pemohon_tgl_transaksi" autocomplete="off" value="" readonly> 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_ket_transaksi" class="form-control" value="" readonly
										id="wrs_pemohon_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_mutasi_debit" class="form-control" value="0" readonly
										id="wrs_pemohon_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_mutasi_kredit" class="form-control" value="0" readonly
										id="wrs_pemohon_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_saldo" class="form-control" value="0" readonly
										id="wrs_pemohon_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_wrs_pemohon" id="submit_from_mutasi_wrs_pemohon" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiWrsPemohon">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Total Pendapatan Usaha (Berdasarkan Rek Tabungan)</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pemohon_pendapatan" class="form-control" value="" 
										id="wrs_pemohon_pendapatan" >
									
									
										</td>
									</tr>
								
								</table>
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
														<option value="Nota Penjualan">Nota Penjualan</option>
														<option value="Nota Belanja">Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pemohon" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
														
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
										<td><U>Input Nota</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
							
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="wrs_tgl_transaksi_pemohon" id="wrs_tgl_transaksi_pemohon" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>

										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="wrs_ket_transaksi_pemohon"  id ="wrs_ket_transaksi_pemohon" class="form-control" value="" >
										
									
										</td>
										
										<td style="width:10%;">Nominal </td>
										<td style="width:20%;">
										<input type="text" name="wrs_nominal_pemohon"  id ="wrs_nominal_pemohon" class="form-control" value="0" >
									
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Total</td>
										<td style="width:20%;">
										<input type="text" name="wrs_total_pemohon"  id ="wrs_total_pemohon" class="form-control" value="0" >
									
									
										</td>
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_nota_wrs_pemohon" id="submit_from_nota_wrs_pemohon" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
							
								</table>
							
								
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
											<input type="text" name="tot_nota_pendapatan_wrs_pemohon"  id ="tot_nota_pendapatan_wrs_pemohon" class="form-control" readonly value="" >
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">% Margin Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="margin_pendapatan_wrs_pemohon"  id ="margin_pendapatan_wrs_pemohon" class="form-control" value="" >
											
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Total Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_pendapatan_wrs_pemohon"  id ="tot_pendapatan_wrs_pemohon" class="form-control" readonly value="" >
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Biaya Operasional</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="biaya_opr_wrs_pemohon"  id ="biaya_opr_wrs_pemohon" class="form-control" value="" >
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Net Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="net_wrs_pemohon"  id ="net_wrs_pemohon" class="form-control" readonly value="" >
											
										</td>
										
									</tr>
									<tr>
										<td colspan="3" style="width:50%;">
											<input  name="cal_nota_wrs_pemohon" id="cal_nota_wrs_pemohon" class="btn btn-custom" value="Calculate" style="width:200px;" >
											
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_wrs_pemohon" class="form-control" value=""  id="final_ca_wrs_pemohon" required>
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
						</div>
					<?php } ?>
				
					
					<div id="wrs_pasangan_div" style="display:none;">
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
											<input type="checkbox"  name="rek_tabungan_pasangan_wrs_ck" id="rek_tabungan_pasangan_wrs_ck" value="">
										</td>
										<input type="hidden" name="rek_tabungan_pasangan_wrs_ck1" id="rek_tabungan_pasangan_wrs_ck1"  value="">
										<td style="width:50%;">
											 <select name="rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									<tr>
										<td style="width:30%;">Nota Pembelian</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nota_pembelian_wrs_pasangan_ck" id="nota_pembelian_wrs_pasangan_ck" value="">
										</td>
										<input type="hidden" name="nota_pembelian_wrs_pasangan_ck1" id="nota_pembelian_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_pembelian_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">Nota Penjualan</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nota_penjualan_wrs_pasangan_ck" id="nota_penjualan_wrs_pasangan_ck" value="" >
										</td>
										<input type="hidden" name="nota_penjualan_wrs_pasangan_ck1" id="nota_penjualan_wrs_pasangan_ck1"  value="">
										<td style="width:50%;">
											 <select name="nota_penjualan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="spt_wrs_pasangan_ck" id="spt_wrs_pasangan_ck" value="" >
												<input type="hidden" name="spt_wrs_pasangan_ck1" id="spt_wrs_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="spt_wrs_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
										<select name="wrs_pasangan_mutasi" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_wrs_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_saldoAwal" class="form-control" value="" 
										id="wrs_pasangan_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_wrs_pasangan" id="submit_saldoAwal_wrs_pasangan" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="wrs_pasangan_tgl_transaksi" id="wrs_pasangan_tgl_transaksi" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_ket_transaksi" class="form-control" value="" 
										id="wrs_pasangan_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_mutasi_debit" class="form-control" value="0" 
										id="wrs_pasangan_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_mutasi_kredit" class="form-control" value="0" 
										id="wrs_pasangan_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_saldo" class="form-control" value="0" 
										id="wrs_pasangan_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_wrs_pasangan" id="submit_from_mutasi_wrs_pasangan" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiWrsPasangan">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Total Pendapatan Usaha (Berdasarkan Rek Tabungan)</td>
										<td style="width:20%;">
										<input type="text" name="wrs_pasangan_pendapatan" class="form-control" value="" 
										id="wrs_pasangan_pendapatan" >
									
									
										</td>
									</tr>
								
								</table>
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
														<option value="Nota Penjualan">Nota Penjualan</option>
														<option value="Nota Belanja">Nota Belanja</option>
											</select>  
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Periode Nota</td>
										<td colspan="2" style="width:50%;">
											<select name="nota_periode_pasangan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
														
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
										<td><U>Input Nota</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
							
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="wrs_tgl_transaksi_pasangan" id="wrs_tgl_transaksi_pasangan" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="wrs_ket_transaksi_pasangan"  id ="wrs_ket_transaksi_pasangan" class="form-control" value="" 
										 >
									
										</td>
										
										<td style="width:10%;">Nominal </td>
										<td style="width:20%;">
										<input type="text" name="wrs_nominal_pasangan"  id ="wrs_nominal_pasangan" class="form-control" value="0" 
										 >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Total</td>
										<td style="width:20%;">
										<input type="text" name="wrs_total_pasangan"  id ="wrs_total_pasangan" class="form-control" value="0" 
										 >
									
										</td>
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_nota_wrs_pasangan" id="submit_from_nota_wrs_pasangan" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
							
								</table>
							
								
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
											<input type="text" name="tot_nota_pendapatan_wrs_pasangan"  id ="tot_nota_pendapatan_wrs_pasangan" class="form-control" value="" readonly>
											
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">% Margin Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="margin_pendapatan_wrs_pasangan"  id ="margin_pendapatan_wrs_pasangan" class="form-control" value="" >
											
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Total Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="tot_pendapatan_wrs_pasangan"  id ="tot_pendapatan_wrs_pasangan" class="form-control" value="" readonly  >
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Biaya Operasional</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="biaya_opr_wrs_pasangan"  id ="biaya_opr_wrs_pasangan" class="form-control" value="" >
											
										</td>
										
									</tr>
									<tr>
										<td style="width:30%;">Net Pendapatan Usaha</td>
										<td colspan="2" style="width:50%;">
											<input type="text" name="net_wrs_pasangan"  id ="net_wrs_pasangan" class="form-control" value="" readonly >
											
										</td>
										
									</tr>
									<tr>
										<td colspan="3" style="width:50%;">
											<input  name="cal_nota_wrs_pasangan" id="cal_nota_wrs_pasangan" class="btn btn-custom" value="Calculate" style="width:200px;" >
											
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_wrs_pasangan" class="form-control" value=""  id="final_ca_wrs_pasangan" >
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
					</div>
					<<div id="historical_kredit_wrs_pasangan" >	
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
								$totalNaBakiDebetNaPasangan = 0;
								$totalNaAngsuranNaPasangan = 0;
								
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
											<input type="checkbox"  name="pro_bukti_penghasilan_pemohon_ck" id="pro_bukti_penghasilan_pemohon_ck" value="" onclick="FuncProPemohon1()">
											<input type="hidden" name="pro_bukti_penghasilan_pemohon_ck1" id="pro_bukti_penghasilan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_bukti_penghasilan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox"  name="pro_rek_tabungan_pemohon_ck" id="pro_rek_tabungan_pemohon_ck" value="" onclick="FuncProPemohon2()">
											<input type="hidden" name="pro_rek_tabungan_pemohon_ck1" id="pro_rek_tabungan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="pro_spt_pemohon_ck" id="pro_spt_pemohon_ck" value="" onclick="FuncProPemohon3()">
											<input type="hidden" name="pro_spt_pemohon_ck1" id="pro_spt_pemohon_ck"  value="">
										</td>
										<td style="width:50%;">
											 <select name="pro_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_pro_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_saldoAwal" class="form-control" value="" 
										id="pro_pemohon_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_pro_pemohon" id="submit_saldoAwal_pro_pemohon" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="pro_pemohon_tgl_transaksi" id="pro_pemohon_tgl_transaksi" autocomplete="off" value="" readonly> 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_ket_transaksi" class="form-control" value="" readonly
										id="pro_pemohon_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_mutasi_debit" class="form-control" value="0" readonly
										id="pro_pemohon_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_mutasi_kredit" class="form-control" value="0" readonly
										id="pro_pemohon_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_saldo" class="form-control" value="0" readonly
										id="pro_pemohon_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_pro_pemohon" id="submit_from_mutasi_pro_pemohon" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiProPemohon">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Pendapatan Per-Bulan (analisa CA)</td>
										<td style="width:20%;">
										<input type="text" name="pro_pemohon_pendapatan" class="form-control" value="" 
										id="pro_pemohon_pendapatan" >
									
									
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_pro_pemohon" class="form-control" value=""  id="final_ca_pro_pemohon" required>
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					</div>
					<?php } ?>
					
					
					<div id="pro_pasangan_div" style="display:none">
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
											<input type="checkbox"  name="pro_bukti_penghasilan_pasangan_ck" id="pro_bukti_penghasilan_pasangan_ck" value="" >
											<input type="hidden" name="pro_bukti_penghasilan_pasangan_ck1" id="pro_bukti_penghasilan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_bukti_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox"  name="pro_rek_tabungan_pasangan_ck" id="pro_rek_tabungan_pasangan_ck" value="" >
											<input type="hidden" name="pro_rek_tabungan_pasangan_ck1" id="pro_rek_tabungan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="pro_rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="pro_spt_pasangan_ck" id="pro_spt_pasangan_ck" value="" >
											<input type="hidden" name="pro_spt_pasangan_ck1" id="pro_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="pro_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
											 <input type="text" name="pro_pasangan_bank_penerbit" class="form-control" value="<?php echo $dataBank['PASANGAN_BANK_BRANCH'];?>"  id="pro_pasangan_bank_penerbit" readonly>
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
										<select name="pro_pasangan_mutasi" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_pro_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_saldoAwal" class="form-control" value="" 
										id="pro_pasangan_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_pro_pasangan" id="submit_saldoAwal_pro_pasangan" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="pro_pasangan_tgl_transaksi" id="pro_pasangan_tgl_transaksi" autocomplete="off" value="" readonly> 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_ket_transaksi" class="form-control" value="" readonly
										id="pro_pasangan_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_mutasi_debit" class="form-control" value="0" readonly
										id="pro_pasangan_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_mutasi_kredit" class="form-control" value="0" readonly
										id="pro_pasangan_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_saldo" class="form-control" value="0" readonly
										id="pro_pasangan_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_pro_pasangan" id="submit_from_mutasi_pro_pasangan" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiProPasangan">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Pendapatan Per-Bulan (analisa CA)</td>
										<td style="width:20%;">
										<input type="text" name="pro_pasangan_pendapatan" class="form-control" value="" 
										id="pro_pasangan_pendapatan" >
									
									
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_pro_pasangan" class="form-control" value=""  id="final_ca_pro_pasangan" >
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
								$totalNaBakiDebetNaPasangan = 0;
								$totalNaAngsuranNaPasangan = 0;
								
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
											<input type="checkbox"  name="nonpro_bukti_penghasilan_pemohon_ck" id="nonpro_bukti_penghasilan_pemohon_ck" value="" onclick="FuncNonProPemohon1()">
											<input type="hidden" name="nonpro_bukti_penghasilan_pemohon_ck1" id="nonpro_bukti_penghasilan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_bukti_penghasilan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nonpro_rek_tabungan_pemohon_ck" id="nonpro_rek_tabungan_pemohon_ck" value="" onclick="FuncNonProPemohon2()" >
											<input type="hidden" name="nonpro_rek_tabungan_pemohon_ck1" id="nonpro_rek_tabungan_pemohon_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_rek_tabungan_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nonpro_spt_pemohon_ck" id="nonpro_spt_pemohon_ck" value="" onclick="FuncNonProPemohon3()">
											<input type="hidden" name="nonpro_spt_pemohon_ck1" id="nonpro_spt_pemohon_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nonpro_spt_pemohon_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_nonpro_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_nonpro_pemohon"  style="margin-bottom:5px;" />
													
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_saldoAwal" class="form-control" value="" 
										id="nonpro_pemohon_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_nonpro_pemohon" id="submit_saldoAwal_nonpro_pemohon" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="nonpro_pemohon_tgl_transaksi" id="nonpro_pemohon_tgl_transaksi" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_ket_transaksi" class="form-control" value="" 
										id="nonpro_pemohon_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_mutasi_debit" class="form-control" value="0" 
										id="nonpro_pemohon_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_mutasi_kredit" class="form-control" value="0" 
										id="nonpro_pemohon_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_saldo" class="form-control" value="0" 
										id="nonpro_pemohon_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_nonpro_pemohon" id="submit_from_mutasi_nonpro_pemohon" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiNonProPemohon">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Pendapatan Per-Bulan (analisa CA)</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pemohon_pendapatan" class="form-control" value="" 
										id="nonpro_pemohon_pendapatan" >
									
									
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_nonpro_pemohon" class="form-control" value=""  id="final_ca_nonpro_pemohon" required>
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					</div>
					<?php } ?>
					
					
					<div id="nonpro_pasangan_div" style="display:none">
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
											<input type="checkbox"  name="nonpro_bukti_penghasilan_pasangan_ck" id="nonpro_bukti_penghasilan_pasangan_ck" value="" >
											<input type="hidden" name="nonpro_bukti_penghasilan_pasangan_ck1" id="nonpro_bukti_penghasilan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_bukti_penghasilan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">REK TABUNGAN</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nonpro_rek_tabungan_pasangan_ck" id="nonpro_rek_tabungan_pasangan_ck" value=""  >
											<input type="hidden" name="nonpro_rek_tabungan_pasangan_ck1" id="nonpro_rek_tabungan_pasangan_ck1"  value="">
										</td>
										
										<td style="width:50%;">
											 <select name="nonpro_rek_tabungan_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
											</select>     
										</td>
									
									</tr>
								
									
									<tr>
										<td style="width:30%;">Bukti SPT Pajak Tahun Terakhir</td>
										<td style="width:10%;">
											<input type="checkbox"  name="nonpro_spt_pasangan_ck" id="nonpro_spt_pasangan_ck" value="" >
											<input type="hidden" name="nonpro_spt_pasangan_ck" id="nonpro_spt_pasangan_ck1"  value="">
										</td>
										<td style="width:50%;">
											 <select name="nonpro_spt_pasangan_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
													
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
										<select name="nonpro_pasangan_mutasi" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
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
											 <select name="validasi_nonpro_pasangan" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									
									
									</tr>
								
										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_nonpro_pasangan"  style="margin-bottom:5px;" />
													
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
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_saldoAwal" class="form-control" value="" 
										id="nonpro_pasangan_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwal_nonpro_pasangan" id="submit_saldoAwal_nonpro_pasangan" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="nonpro_pasangan_tgl_transaksi" id="nonpro_pasangan_tgl_transaksi" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_ket_transaksi" class="form-control" value="" 
										id="nonpro_pasangan_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_mutasi_debit" class="form-control" value="0" 
										id="nonpro_pasangan_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_mutasi_kredit" class="form-control" value="0" 
										id="nonpro_pasangan_mutasi_kredit" >
									
										</td>
										
										<td style="width:10%;">Saldo</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_saldo" class="form-control" value="0" 
										id="nonpro_pasangan_saldo" >
									
										</td>
									
									
										
									
									

									</tr>
									<tr>
									<td colspan="6">
										<input  name="submit_from_mutasi_nonpro_pasangan" id="submit_from_mutasi_nonpro_pasangan" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
							
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabelMutasiNonProPasangan">
                    
               
								     </div>
									 
									 
								<table class="table table-bordered">
							
									<tr>	
										<td style="width:10%;">Pendapatan Per-Bulan (analisa CA)</td>
										<td style="width:20%;">
										<input type="text" name="nonpro_pasangan_pendapatan" class="form-control" value="" 
										id="nonpro_pasangan_pendapatan" >
									
									
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
										<td style="width:30%";>
										Nominal Income Final CA 
										</td>
											<td> <input type="text" name="final_ca_nonpro_pasangan" class="form-control" value=""  id="final_ca_nonpro_pasangan">
										</td>
									</tr>
									
									
								</table>
							</div>
					</div>	
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
								$totalNaBakiDebetNaPasangan = 0;
								$totalNaAngsuranNaPasangan = 0;
								
								
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
					
					</div>
					<!-- -->	
					
					
					
					
					
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
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
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
								$totalNaBakiDebetNaPasangan = 0;
								$totalNaAngsuranNaPasangan = 0;
								
								
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
												
	echo '<pre>' . var_export($paramProxy,true) .'<pre>'; 
			exit();				 
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
									$paramProxy1 =  array(array($app_no, SQLSRV_PARAM_IN));
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
							<?php 
							IF($dataProxy1['STATUS_LEVEL'] == 'LEVEL 6' && $dataCust['TDP_PERCENT'] <'25'){ 
							$callDacor = "{call SP_GET_AFA_DACOR_RAK_TDP(?)}";
							$paramDacor =  array(array($app_no, SQLSRV_PARAM_IN));
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
										<td>NOTE : </td>
										<td><input type="text" name="note_rak" class="form-control" value=""  id="note_rak" required></td>
									</tr>
									<tr>
										<td>ANALISA KAPASITAS BERDASARKAN REKENING TABUNGAN DENGAN NOTA TRANSAKSI :</td>
										<td><input type="text" name="analisa" class="form-control" value=""  id="analisa" required></td>
										
										
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
										<td><B>Summary</B></td>
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
									<tr>
										<td>Angsuran NEW SFI</td>
										<td><input type="text" name="angsuran_new" class="form-control" value="<?php echo number_format($dataCust['ANGSURAN'],0,',','.'); ?>"  id="angsuran_new" readonly ></td>
									</tr>
									
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
									<td colspan="3" style="width:50%;">
											<input  type="button" name="cal_dsr" id="cal_dsr" class="btn btn-custom" value="Calculate" style="width:200px;" >	
					
									</td>

								</table>
							</div>

							<input type="submit" name="submitNo" id="submitNo" class="btn btn-custom" value="TIDAK REKOMEN" style="width:200px;" >
							<?php if($type_kendaraan == '15'){ 
						if($dataRakCheck['RAK'] == 'NEW'){
					?>
								<?php 
							if($dataProxy['APPROVAL'] == 'YA'){ ?>
								
							<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" style="width:200px;" >
							<?php }else{ ?>
							<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" disabled style="width:200px;" >
							<?php 
						
							}
						}else{ ?>
						<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" style="width:200px;" >			
						<?php } 
							}else{ ?>
						<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" style="width:200px;" >
						<?php } ?> 
					</div>	
					
					</div>
					</form>
				</div>
			</div>
				
					
<script src="assets/js/jqueryrotate.min.js"></script>	
<script>
 window.onbeforeunload = function () {
        $("input[type=submit]").attr("disabled", "disabled");
	
    };

</script>
<script> 
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
	 document.getElementById("final_ca_wrs_pasangan").required = true;
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
	var wrs_pasangan_pendapatan = document.getElementById('wrs_pasangan_pendapatan');

wrs_pasangan_pendapatan.addEventListener('keyup',function(e){
  	 		wrs_pasangan_pendapatan.value = formatRupiah(this.value);
  	 	});
			
		
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
 
		
				
	
  }else if ( join_income == "YA" && pasangan == "KARYAWAN") {
    r.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("final_ca_kry_pasangan").required = true;
	 document.getElementById("status_karyawan_pasangan").required = true;
	 document.getElementById("telp_kantor_pasangan").required = true;
	 document.getElementById("pic_kantor_pasangan").required = true;
	 document.getElementById("verf_kantor_kry_pasangan").required = true;
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
				


  }else if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
    t.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("final_ca_pro_pasangan").required = true;
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
		
	var pro_pasangan_pendapatan = document.getElementById('pro_pasangan_pendapatan');

pro_pasangan_pendapatan.addEventListener('keyup',function(e){
  	 		pro_pasangan_pendapatan.value = formatRupiah(this.value);
  	 	});
		
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
	
	
		
		
		
  }else if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
    u.style.display = "block";
	 join_pasangan.style.display = "block";
	 history.style.display = "none";
	 document.getElementById("final_ca_nonpro_pasangan").required = true;
	 // history_nonpro_pemohon.style.display = "block";
	 
var nonpro_pasangan_saldoAwal = document.getElementById('nonpro_pasangan_saldoAwal');

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
		
	var nonpro_pasangan_pendapatan = document.getElementById('nonpro_pasangan_pendapatan');

nonpro_pasangan_pendapatan.addEventListener('keyup',function(e){
  	 		nonpro_pasangan_pendapatan.value = formatRupiah(this.value);
  	 	});
	
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
	
  }else{
    x.style.display = "none";
	r.style.display = "none";
	t.style.display = "none";
	u.style.display = "none";
	 join_pasangan.style.display ="none";
  }
  
  
   if ( join_income == "TIDAK" && pasangan == "WIRASWASTA") {
    history.style.display = "block";
	document.getElementById("final_ca_wrs_pasangan").required = false;
	//history_wrs_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pasangan == "KARYAWAN") {
    history.style.display = "block";
	document.getElementById("final_ca_kry_pasangan").required = false;
	
	//history_kry_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pasangan == "PROFESSIONAL") {
    history.style.display = "block";
	document.getElementById("final_ca_pro_pasangan").required = false;
	//history_pro_pemohon.style.display = "none";
	
  }else if ( join_income == "TIDAK" && pasangan == "NON PROFESSIONAL") {
   history.style.display = "block";
   document.getElementById("final_ca_nonpro_pasangan").required = false;
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
	document.getElementById("status_karyawan_pemohon").required = true;
	 document.getElementById("telp_kantor_pemohon").required = true;
	 document.getElementById("pic_kantor_pemohon").required = true;
	 document.getElementById("verf_kantor_kry_pemohon").required = true;
  }else if ( join_income == "TIDAK" && pemohon == "PROFESSIONAL") {
    history.style.display = "block";
	history_pro_pemohon.style.display = "none";
  }else if ( join_income == "TIDAK" && pemohon == "NON PROFESSIONAL") {
   history.style.display = "block";
   history_nonpro_pemohon.style.display = "none";
  }
  
  if ( join_income == "YA" && pemohon == "WIRASWASTA") {
    history.style.display = "none";
	history_wrs_pemohon.style.display = "block";
  }else if ( join_income == "YA" && pemohon == "KARYAWAN") {
    history.style.display = "none";
	history_kry_pemohon.style.display = "block";
	document.getElementById("status_karyawan_pemohon").required = true;
	 document.getElementById("telp_kantor_pemohon").required = true;
	 document.getElementById("pic_kantor_pemohon").required = true;
	 document.getElementById("verf_kantor_kry_pemohon").required = true;
  }else if ( join_income == "YA" && pemohon == "PROFESIONAL") {
    history.style.display = "none";
	history_pro_pemohon.style.display = "block";
  }else if ( join_income == "YA" && pemohon == "NON PROFESSIONAL") {
   history.style.display = "none";
   history_nonpro_pemohon.style.display = "block";
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
	text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
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
	text.value = "BUKTI SPT PAJAK TAHUN TERAKHIR";
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

   var join_income =  $("#join_income").val();
   
   
   if ( pemohon == "WIRASWASTA") {
   viewWrsPemohon();
	viewMutasiWrsPemohon();
	  var val_saldo_wrsPem =  $("#wrs_pemohon_saldoAwal").val();
	if ( val_saldo_wrsPem != "") {
	document.getElementById('wrs_pemohon_tgl_transaksi').readOnly = false;
	document.getElementById('wrs_pemohon_ket_transaksi').readOnly = false;
	document.getElementById('wrs_pemohon_mutasi_debit').readOnly = false;
	document.getElementById('wrs_pemohon_mutasi_kredit').readOnly = false;
	document.getElementById('wrs_pemohon_saldo').readOnly = false;
  }
  }if ( pemohon == "KARYAWAN") {
   view();
    var val_saldo_kryPem =  $("#kry_saldoAwal").val();
   if ( val_saldo_kryPem != "") {
		 document.getElementById('kry_tgl_transaksi').readOnly = false;
		 document.getElementById('kry_ket_transaksi').readOnly = false;
		 document.getElementById('kry_mutasi_debit').readOnly = false;
		 document.getElementById('kry_mutasi_kredit').readOnly = false;
		 document.getElementById('kry_saldo').readOnly = false;
  }
  }if ( pemohon == "PROFESSIONAL") {
    viewMutasiProPemohon();
	var val_saldo_proPem =  $("#pro_pemohon_saldoAwal").val();
	 if ( val_saldo_proPem != "") {
	document.getElementById('pro_pemohon_tgl_transaksi').readOnly = false;
	document.getElementById('pro_pemohon_ket_transaksi').readOnly = false;
	document.getElementById('pro_pemohon_mutasi_debit').readOnly = false;
	document.getElementById('pro_pemohon_mutasi_kredit').readOnly = false;
	document.getElementById('pro_pemohon_saldo').readOnly = false;
  }
  }if ( pemohon == "NON PROFESSIONAL") {
    viewMutasiNonProPemohon();
	var val_saldo_nonproPem =  $("#nonpro_pemohon_saldoAwal").val();
	  if ( val_saldo_nonproPem != "") {
	document.getElementById('nonpro_pemohon_tgl_transaksi').readOnly = false;
	document.getElementById('nonpro_pemohon_ket_transaksi').readOnly = false;
	document.getElementById('nonpro_pemohon_mutasi_debit').readOnly = false;
	document.getElementById('nonpro_pemohon_mutasi_kredit').readOnly = false;
	document.getElementById('nonpro_pemohon_saldo').readOnly = false;
  }
  }
   
  if ( join_income == "YA" && pasangan == "WIRASWASTA") {
    viewWrsPasangan();
	viewMutasiWrsPasangan();
	
	var val_saldo_wrsPas =  $("#wrs_pasangan_saldoAwal").val();   
	 if ( val_saldo_wrsPas != "") {
	document.getElementById('wrs_pasangan_tgl_transaksi').readOnly = false;
	document.getElementById('wrs_pasangan_ket_transaksi').readOnly = false;
	document.getElementById('wrs_pasangan_mutasi_debit').readOnly = false;
	document.getElementById('wrs_pasangan_mutasi_kredit').readOnly = false;
	document.getElementById('wrs_pasangan_saldo').readOnly = false;
  }
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

	

  }
  if ( join_income == "YA" && pasangan == "KARYAWAN") {
   viewMutasiKryPasangan();
	var val_saldo_kryPas =  $("#kry_saldoAwal_pasangan").val();
    if ( val_saldo_kryPas != "") {
		document.getElementById('kry_tgl_transaksi_pasangan').readOnly = false;
		document.getElementById('kry_ket_transaksi_pasangan').readOnly = false;
		document.getElementById('kry_mutasi_debit_pasangan').readOnly = false;
		document.getElementById('kry_mutasi_kredit_pasangan').readOnly = false;
		document.getElementById('kry_saldo_pasangan').readOnly = false;
  }
  } 
  if ( join_income == "YA" && pasangan == "PROFESSIONAL") {
  viewMutasiProPasangan();
  var val_saldo_proPem =  $("#pro_pasangan_saldoAwal").val();   
   if ( val_saldo_proPem != "") {
	document.getElementById('pro_pemohon_tgl_transaksi').readOnly = false;
	document.getElementById('pro_pemohon_ket_transaksi').readOnly = false;
	document.getElementById('pro_pemohon_mutasi_debit').readOnly = false;
	document.getElementById('pro_pemohon_mutasi_kredit').readOnly = false;
	document.getElementById('pro_pemohon_saldo').readOnly = false;
  }
  } 
  if ( join_income == "YA" && pasangan == "NON PROFESSIONAL") {
   viewMutasiNonProPasangan();
	var val_saldo_nonproPem =  $("#nonpro_pasangan_saldoAwal").val();   
    if ( val_saldo_nonproPem != "") {
	document.getElementById('nonpro_pemohon_tgl_transaksi').readOnly = false;
	document.getElementById('nonpro_pemohon_ket_transaksi').readOnly = false;
	document.getElementById('nonpro_pemohon_mutasi_debit').readOnly = false;
	document.getElementById('nonpro_pemohon_mutasi_kredit').readOnly = false;
	document.getElementById('nonpro_pemohon_saldo').readOnly = false;
  }
  }
  
	/* view();
	viewWrsPemohon();
	viewMutasiWrsPemohon();
	viewMutasiProPemohon();
	viewMutasiNonProPemohon();
	
	viewMutasiKryPasangan();
	viewWrsPasangan();
	viewMutasiWrsPasangan();
	viewMutasiProPasangan();
	viewMutasiNonProPasangan();
	*/
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
	$('#nonpro_pemohon_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	
	//pasangan
	
	
	$('#kry_tgl_transaksi_pasangan').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#tgl_pasangan_gaji').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#wrs_tgl_transaksi_pasangan').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#wrs_pasangan_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	
	$('#pro_pasangan_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});
	$('#nonpro_pasangan_tgl_transaksi').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		
	});

 
	 function view() {
	var data = $('#form_mutasi_kry').serialize();
                $.ajax({
                    url: 'view-mutasi-kry.php',
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
                    url: 'view-mutasi-kry-pasangan.php',
                    type: "POST",
					data: data,
                    success: function(data) {
                        $('#tabeldataPasangan').html(data);
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
                    url: 'view-nota-wrs-pemohon.php',
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
                    url: 'view-nota-wrs-pasangan.php',
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
$("#submit_saldoAwalKry").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_kry.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			view();
			
			document.getElementById('kry_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwalKry').disabled = true;
			document.getElementById('submit_from').disabled = false;
			
			document.getElementById('kry_mutasi_kredit').readOnly = false;
			document.getElementById('kry_saldo').readOnly = false;
			document.getElementById('kry_mutasi_debit').readOnly = false;
			document.getElementById('kry_ket_transaksi').readOnly = false;
			document.getElementById('kry_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_kry.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			view();
			 $('[name="kry_ket_transaksi"]').val("");
		     $('[name="kry_mutasi_debit"]').val(0);
		     $('[name="kry_mutasi_kredit"]').val(0);
		     $('[name="kry_saldo"]').val(0);
			 $('[name="kry_tgl_transaksi"]').val("");
			 document.getElementById('kry_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwalKry').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_kry_pemohon', function(){
    var id = $(this).attr('id');
     if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
	$.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         view();
        }
    });
	 }
});
	
	
	
$("#submit_saldoAwalKry_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_kry_pasangan.php",
			data: data,
			success: function(hasil) {
				
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiKryPasangan();
			document.getElementById('kry_saldoAwal_pasangan').readOnly = true;
			document.getElementById('submit_saldoAwalKry_pasangan').disabled = true;
			document.getElementById('submit_from_pasangan').disabled = false;
			
			document.getElementById('kry_mutasi_kredit_pasangan').readOnly = false;
			document.getElementById('kry_saldo_pasangan').readOnly = false;
			document.getElementById('kry_mutasi_debit_pasangan').readOnly = false;
			document.getElementById('kry_ket_transaksi_pasangan').readOnly = false;
			document.getElementById('kry_tgl_transaksi_pasangan').readOnly = false;
			
		}
		});
	});

	$("#submit_from_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_kry_pasangan.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiKryPasangan();
			 $('[name="kry_ket_transaksi_pasangan"]').val("");
		     $('[name="kry_mutasi_debit_pasangan"]').val(0);
		     $('[name="kry_mutasi_kredit_pasangan"]').val(0);
		     $('[name="kry_saldo_pasangan"]').val(0);
			 $('[name="kry_tgl_transaksi_pasangan"]').val("");
			 document.getElementById('kry_saldoAwal_pasangan').readOnly = true;
			document.getElementById('submit_saldoAwalKry_pasangan').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_kry_pasangan', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiKryPasangan();
        }
    });
	}
});
	
	
	$("#submit_saldoAwal_wrs_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_wrs.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiWrsPemohon();
			document.getElementById('wrs_pemohon_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_wrs_pemohon').disabled = true;
			document.getElementById('submit_from_mutasi_wrs_pemohon').disabled = false;
			
				document.getElementById('wrs_pemohon_mutasi_kredit').readOnly = false;
			document.getElementById('wrs_pemohon_saldo').readOnly = false;
			document.getElementById('wrs_pemohon_mutasi_debit').readOnly = false;
			document.getElementById('wrs_pemohon_ket_transaksi').readOnly = false;
			document.getElementById('wrs_pemohon_tgl_transaksi').readOnly = false;
			
			
		}
		});
	});

	$("#submit_from_mutasi_wrs_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_wrs.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiWrsPemohon();
			 $('[name="wrs_pemohon_ket_transaksi"]').val("");
		     $('[name="wrs_pemohon_mutasi_debit"]').val(0);
		     $('[name="wrs_pemohon_mutasi_kredit"]').val(0);
		     $('[name="wrs_pemohon_saldo"]').val(0);
			 $('[name="wrs_pemohon_tgl_transaksi"]').val("");
			 document.getElementById('wrs_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_wrs_pasangan').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_wrs_pemohon', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiWrsPemohon();
        }
    });
	}
});
	
	
	$("#submit_saldoAwal_wrs_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_wrs_pasangan.php",
			data: data,
			success: function(hasil) {
				//console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiWrsPasangan();
			document.getElementById('wrs_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_wrs_pasangan').disabled = true;
			document.getElementById('submit_from_mutasi_wrs_pasangan').disabled = false;
			
				document.getElementById('wrs_pasangan_mutasi_kredit').readOnly = false;
			document.getElementById('wrs_pasangan_saldo').readOnly = false;
			document.getElementById('wrs_pasangan_mutasi_debit').readOnly = false;
			document.getElementById('wrs_pasangan_ket_transaksi').readOnly = false;
			document.getElementById('wrs_pasangan_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from_mutasi_wrs_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_wrs_pasangan.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiWrsPasangan();
			 $('[name="wrs_pasangan_ket_transaksi"]').val("");
		     $('[name="wrs_pasangan_mutasi_debit"]').val(0);
		     $('[name="wrs_pasangan_mutasi_kredit"]').val(0);
		     $('[name="wrs_pasangan_saldo"]').val(0);
			 $('[name="wrs_pasangan_tgl_transaksi"]').val("");
			 document.getElementById('wrs_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_wrs_pasangan').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_wrs_pasangan', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiWrsPasangan();
        }
    });
	}
});
	
	$("#submit_from_nota_wrs_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_nota_wrs.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewWrsPemohon();
			 $('[name="wrs_tgl_transaksi_pemohon"]').val("");
		     $('[name="wrs_nominal_pemohon"]').val(0);
		     $('[name="wrs_total_pemohon"]').val(0);
			 $('[name="wrs_ket_transaksi_pemohon"]').val("");
		}
		});
	});
	$(document).on('click', '.hapus_data_wrs_nota_pemohon', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-nota-wiraswasta.php",
        data: {id:id},
        success: function() {
         viewWrsPemohon();
        }
    });
	}
});
	
	$("#cal_nota_wrs_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		
		$.ajax({
			type: "POST",
			url: "action_nota_wrs_calculate.php",
			data: data,
			success: function(nota) {
			// $('#tabeldata').load("view-mutasi-kry.php");
			console.log(nota);
		
			$('#tot_nota_pendapatan_wrs_pemohon').val(nf.format(nota[0].RATA_RATA_NOTA));
			$('#margin_pendapatan_wrs_pemohon').val(nf.format(nota[0].MARGIN));
			$('#tot_pendapatan_wrs_pemohon').val(nf.format(nota[0].TOTAL_PENDAPATAN));
			$('#biaya_opr_wrs_pemohon').val(nf.format(nota[0].BIAYA_OPERATIONAL));
			$('#net_wrs_pemohon').val(nf.format(nota[0].NET));
			
		
			
			//$('#subgrup').val(data[0].kolom);

		}
		});
	});
	
	$("#submit_from_nota_wrs_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_nota_wrs_pasangan.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewWrsPasangan();
			 $('[name="wrs_tgl_transaksi_pasangan"]').val("");
		     $('[name="wrs_nominal_pasangan"]').val(0);
		     $('[name="wrs_total_pasangan"]').val(0);
			 $('[name="wrs_ket_transaksi_pasangan"]').val("");
		}
		});
	});
	
		$(document).on('click', '.hapus_data_wrs_nota_pasangan', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-nota-wiraswasta.php",
        data: {id:id},
        success: function() {
         viewWrsPasangan();
        }
    });
	}
});
	
	$("#cal_nota_wrs_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		
		$.ajax({
			type: "POST",
			url: "action_nota_wrs_calculate_pasangan.php",
			data: data,
			success: function(nota) {
			// $('#tabeldata').load("view-mutasi-kry.php");
			console.log(nota);
		
			$('#tot_nota_pendapatan_wrs_pasangan').val(nf.format(nota[0].RATA_RATA_NOTA));
			$('#margin_pendapatan_wrs_pasangan').val(nf.format(nota[0].MARGIN));
			$('#tot_pendapatan_wrs_pasangan').val(nf.format(nota[0].TOTAL_PENDAPATAN));
			$('#biaya_opr_wrs_pasangan').val(nf.format(nota[0].BIAYA_OPERATIONAL));
			$('#net_wrs_pasangan').val(nf.format(nota[0].NET));
			
		
			
			//$('#subgrup').val(data[0].kolom);

		}
		});
	});
	
	
	
	$("#submit_saldoAwal_pro_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_pro.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiProPemohon();
			document.getElementById('pro_pemohon_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_pro_pemohon').disabled = true;
			document.getElementById('submit_from_mutasi_pro_pemohon').disabled = false;
			
				document.getElementById('pro_pemohon_mutasi_kredit').readOnly = false;
			document.getElementById('pro_pemohon_saldo').readOnly = false;
			document.getElementById('pro_pemohon_mutasi_debit').readOnly = false;
			document.getElementById('pro_pemohon_ket_transaksi').readOnly = false;
			document.getElementById('pro_pemohon_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from_mutasi_pro_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_pro.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiProPemohon();
			 $('[name="pro_pemohon_ket_transaksi"]').val("");
		     $('[name="pro_pemohon_mutasi_debit"]').val(0);
		     $('[name="pro_pemohon_mutasi_kredit"]').val(0);
		     $('[name="pro_pemohon_saldo"]').val(0);
			 $('[name="pro_pemohon_tgl_transaksi"]').val("");
			 document.getElementById('pro_pemohon_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_pro_pemohon').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_pro_pemohon', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiProPemohon();
        }
    });
	}
});
	
	$("#submit_saldoAwal_pro_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_pro_pasangan.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiProPasangan();
			document.getElementById('pro_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_pro_pasangan').disabled = true;
			document.getElementById('submit_from_mutasi_pro_pasangan').disabled = false;
			
				document.getElementById('pro_pasangan_mutasi_kredit').readOnly = false;
			document.getElementById('pro_pasangan_saldo').readOnly = false;
			document.getElementById('pro_pasangan_mutasi_debit').readOnly = false;
			document.getElementById('pro_pasangan_ket_transaksi').readOnly = false;
			document.getElementById('pro_pasangan_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from_mutasi_pro_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_pro_pasangan.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiProPasangan();
			 $('[name="pro_pasangan_ket_transaksi"]').val("");
		     $('[name="pro_pasangan_mutasi_debit"]').val(0);
		     $('[name="pro_pasangan_mutasi_kredit"]').val(0);
		     $('[name="pro_pasangan_saldo"]').val(0);
			 $('[name="pro_pasangan_tgl_transaksi"]').val("");
			 document.getElementById('pro_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_pro_pasangan').disabled = true;
		}
		});
	});
		$(document).on('click', '.hapus_data_pro_pasangan', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiProPasangan();
        }
    });
	}
});
	
	
	
	//non pro
	$("#submit_saldoAwal_nonpro_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_nonpro.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiNonProPemohon();
			document.getElementById('nonpro_pemohon_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_nonpro_pemohon').disabled = true;
			document.getElementById('submit_from_mutasi_nonpro_pemohon').disabled = false;
			
				document.getElementById('nonpro_pemohon_mutasi_kredit').readOnly = false;
			document.getElementById('nonpro_pemohon_saldo').readOnly = false;
			document.getElementById('nonpro_pemohon_mutasi_debit').readOnly = false;
			document.getElementById('nonpro_pemohon_ket_transaksi').readOnly = false;
			document.getElementById('nonpro_pemohon_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from_mutasi_nonpro_pemohon").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_nonpro.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiNonProPemohon();
			 $('[name="nonpro_pemohon_ket_transaksi"]').val("");
		     $('[name="nonpro_pemohon_mutasi_debit"]').val(0);
		     $('[name="nonpro_pemohon_mutasi_kredit"]').val(0);
		     $('[name="nonpro_pemohon_saldo"]').val(0);
			 $('[name="nonpro_pemohon_tgl_transaksi"]').val("");
			 document.getElementById('nonpro_pemohon_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_nonpro_pemohon').disabled = true;
		}
		});
	});
		$(document).on('click', '.hapus_data_nonpro_pemohon', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiNonProPemohon();
        }
    });
	}
});
	
	$("#submit_saldoAwal_nonpro_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_nonpro_pasangan.php",
			data: data,
			success: function(hasil) {
				console.log(hasil);
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiNonProPasangan();
			document.getElementById('nonpro_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_nonpro_pasangan').disabled = true;
			document.getElementById('submit_from_mutasi_nonpro_pasangan').disabled = false;
			
				document.getElementById('nonpro_pasangan_mutasi_kredit').readOnly = false;
			document.getElementById('nonpro_pasangan_saldo').readOnly = false;
			document.getElementById('nonpro_pasangan_mutasi_debit').readOnly = false;
			document.getElementById('nonpro_pasangan_ket_transaksi').readOnly = false;
			document.getElementById('nonpro_pasangan_tgl_transaksi').readOnly = false;
			
		}
		});
	});

	$("#submit_from_mutasi_nonpro_pasangan").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_mutasi_nonpro_pasangan.php",
			data: data,
			success: function() {
			// $('#tabeldata').load("view-mutasi-kry.php");
			viewMutasiNonProPasangan();
			 $('[name="nonpro_pasangan_ket_transaksi"]').val("");
		     $('[name="nonpro_pasangan_mutasi_debit"]').val(0);
		     $('[name="nonpro_pasangan_mutasi_kredit"]').val(0);
		     $('[name="nonpro_pasangan_saldo"]').val(0);
			 $('[name="nonpro_pasangan_tgl_transaksi"]').val("");
			 document.getElementById('nonpro_pasangan_saldoAwal').readOnly = true;
			document.getElementById('submit_saldoAwal_nonpro_pasangan').disabled = true;
		}
		});
	});
	
	$(document).on('click', '.hapus_data_nonpro_pasangan', function(){
    var id = $(this).attr('id');
	if(confirm("Apakah Anda Yakin Ingin Menghapus data ini ?")){
    $.ajax({
        type: 'POST',
        url: "hapus-mutasi.php",
        data: {id:id},
        success: function() {
         viewMutasiNonProPasangan();
        }
    });
	}
});
	
	$("#cal_dsr").click(function(){
		var data = $('#form_mutasi_kry').serialize();
		$.ajax({
			type: "POST",
			url: "action_calc_dsr.php",
			data: data,
			success: function(dsr) {
			// $('#tabeldata').load("view-mutasi-kry.php");
			console.log(dsr);
		
			$('#dsr').val(nf.format(dsr[0].DSR));
			$('#total_kewajiban').val(nf.format(dsr[0].TOTAL_KEWAJIBAN));
			$('#total_pendapatan').val(nf.format(dsr[0].TOTAL_PENDAPATAN));
			$('#kewajiban_tempatlain').val(nf.format(dsr[0].KEWAJIBAN_TEMPAT_LAIN));
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

  var pemohon =  $("#cust_model_pemohon").val();
   var pasangan =  $("#cust_model_pasangan").val();

   var join_income =  $("#join_income").val();
   
if ( pemohon == "KARYAWAN") {
	var kry_saldoAwal = document.getElementById('kry_saldoAwal');

kry_saldoAwal.addEventListener('keyup',function(e){
  	 		kry_saldoAwal.value = formatRupiah(this.value);
  	 	});

var kry_mutasi_kredit = document.getElementById('kry_mutasi_kredit');

kry_mutasi_kredit.addEventListener('keyup',function(e){
  	 		kry_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var kry_mutasi_debit = document.getElementById('kry_mutasi_debit');

kry_mutasi_debit.addEventListener('keyup',function(e){
  	 		kry_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var kry_saldo = document.getElementById('kry_saldo');

kry_saldo.addEventListener('keyup',function(e){
  	 		kry_saldo.value = formatRupiah(this.value);
  	 	});
				

var nominal_gajian = document.getElementById('nominal_gajian');

nominal_gajian.addEventListener('keyup',function(e){
  	 		nominal_gajian.value = formatRupiah(this.value);
  	 	});
var nominal_rak = document.getElementById('nominal_rak');

nominal_rak.addEventListener('keyup',function(e){
  	 		nominal_rak.value = formatRupiah(this.value);
  	 	});
var final_ca_kry_pemohon = document.getElementById('final_ca_kry_pemohon');

final_ca_kry_pemohon.addEventListener('keyup',function(e){
  	 		final_ca_kry_pemohon.value = formatRupiah(this.value);
  	 	});		
		
		
}

	
else if ( pemohon == "WIRASWASTA") {
	
$('#margin_pendapatan_wrs_pemohon').keyup(function(){
  if ($(this).val() > 100){
    alert("Margin Tidak Boleh Lebih Dari 100");
    $(this).val('');
  }
});
var wrs_nominal_pemohon = document.getElementById('wrs_nominal_pemohon');

wrs_nominal_pemohon.addEventListener('keyup',function(e){
  	 		wrs_nominal_pemohon.value = formatRupiah(this.value);
  	 	});
		
var wrs_total_pemohon = document.getElementById('wrs_total_pemohon');

wrs_total_pemohon.addEventListener('keyup',function(e){
  	 		wrs_total_pemohon.value = formatRupiah(this.value);
  	 	});


var wrs_pemohon_saldoAwal = document.getElementById('wrs_pemohon_saldoAwal');

wrs_pemohon_saldoAwal.addEventListener('keyup',function(e){
  	 		wrs_pemohon_saldoAwal.value = formatRupiah(this.value);
  	 	});

var wrs_pemohon_mutasi_kredit = document.getElementById('wrs_pemohon_mutasi_kredit');

wrs_pemohon_mutasi_kredit.addEventListener('keyup',function(e){
  	 		wrs_pemohon_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var wrs_pemohon_mutasi_debit = document.getElementById('wrs_pemohon_mutasi_debit');

wrs_pemohon_mutasi_debit.addEventListener('keyup',function(e){
  	 		wrs_pemohon_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var wrs_pemohon_saldo = document.getElementById('wrs_pemohon_saldo');

wrs_pemohon_saldo.addEventListener('keyup',function(e){
  	 		wrs_pemohon_saldo.value = formatRupiah(this.value);
  	 	});
		
var margin_pendapatan_wrs_pemohon = document.getElementById('margin_pendapatan_wrs_pemohon');

margin_pendapatan_wrs_pemohon.addEventListener('keyup',function(e){
  	 		margin_pendapatan_wrs_pemohon.value = formatRupiah(this.value);
  	 	});
				
var biaya_opr_wrs_pemohon = document.getElementById('biaya_opr_wrs_pemohon');

biaya_opr_wrs_pemohon.addEventListener('keyup',function(e){
  	 		biaya_opr_wrs_pemohon.value = formatRupiah(this.value);
  	 	});
				
var final_ca_wrs_pemohon = document.getElementById('final_ca_wrs_pemohon');

final_ca_wrs_pemohon.addEventListener('keyup',function(e){
  	 		final_ca_wrs_pemohon.value = formatRupiah(this.value);
  	 	});		

var wrs_pemohon_pendapatan = document.getElementById('wrs_pemohon_pendapatan');

wrs_pemohon_pendapatan.addEventListener('keyup',function(e){
  	 		wrs_pemohon_pendapatan.value = formatRupiah(this.value);
  	 	});		
		
}else if (pemohon == "PROFESSIONAL"){
	

var pro_pemohon_saldoAwal = document.getElementById('pro_pemohon_saldoAwal');

pro_pemohon_saldoAwal.addEventListener('keyup',function(e){
  	 		pro_pemohon_saldoAwal.value = formatRupiah(this.value);
  	 	});

var pro_pemohon_mutasi_kredit = document.getElementById('pro_pemohon_mutasi_kredit');

pro_pemohon_mutasi_kredit.addEventListener('keyup',function(e){
  	 		pro_pemohon_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var pro_pemohon_mutasi_debit = document.getElementById('pro_pemohon_mutasi_debit');

pro_pemohon_mutasi_debit.addEventListener('keyup',function(e){
  	 		pro_pemohon_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var pro_pemohon_saldo = document.getElementById('pro_pemohon_saldo');

pro_pemohon_saldo.addEventListener('keyup',function(e){
  	 		pro_pemohon_saldo.value = formatRupiah(this.value);
  	 	});
		
		
var pro_pemohon_pendapatan = document.getElementById('pro_pemohon_pendapatan');

pro_pemohon_pendapatan.addEventListener('keyup',function(e){
  	 		pro_pemohon_pendapatan.value = formatRupiah(this.value);
  	 	});
		
		
var final_ca_pro_pemohon = document.getElementById('final_ca_pro_pemohon');

final_ca_pro_pemohon.addEventListener('keyup',function(e){
  	 		final_ca_pro_pemohon.value = formatRupiah(this.value);
  	 	});		
		

}else if (pemohon == "NON PROFESSIONAL"){
	

var pro_pemohon_saldoAwal = document.getElementById('nonpro_pemohon_saldoAwal');

nonpro_pemohon_saldoAwal.addEventListener('keyup',function(e){
  	 		nonpro_pemohon_saldoAwal.value = formatRupiah(this.value);
  	 	});

var nonpro_pemohon_mutasi_kredit = document.getElementById('nonpro_pemohon_mutasi_kredit');

nonpro_pemohon_mutasi_kredit.addEventListener('keyup',function(e){
  	 		nonpro_pemohon_mutasi_kredit.value = formatRupiah(this.value);
  	 	});
		

var nonpro_pemohon_mutasi_debit = document.getElementById('nonpro_pemohon_mutasi_debit');

nonpro_pemohon_mutasi_debit.addEventListener('keyup',function(e){
  	 		nonpro_pemohon_mutasi_debit.value = formatRupiah(this.value);
  	 	});
		

var nonpro_pemohon_saldo = document.getElementById('nonpro_pemohon_saldo');

nonpro_pemohon_saldo.addEventListener('keyup',function(e){
  	 		nonpro_pemohon_saldo.value = formatRupiah(this.value);
  	 	});
var nonpro_pemohon_pendapatan = document.getElementById('nonpro_pemohon_pendapatan');

nonpro_pemohon_pendapatan.addEventListener('keyup',function(e){
  	 		nonpro_pemohon_pendapatan.value = formatRupiah(this.value);
  	 	});
		
		
var final_ca_nonpro_pemohon = document.getElementById('final_ca_nonpro_pemohon');

final_ca_nonpro_pemohon.addEventListener('keyup',function(e){
  	 		final_ca_nonpro_pemohon.value = formatRupiah(this.value);
  	 	});

}


//pasangan

if ( join_income == "YA" && pasangan == "KARYAWAN") {
	
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
}

else if ( join_income == "YA" && pasangan == "WIRASWASTA") {
	
$('#margin_pendapatan_wrs_pasangan').keyup(function(){
  if ($(this).val() > 100){
    alert("Margin Tidak Boleh Lebih Dari 100");
    $(this).val('');
  }
});
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
		

						
				

		
}else if (join_income == "YA" && pasangan == "PROFESSIONAL"){
	

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

}else if (join_income == "YA" && pasangan == "NON PROFESSIONAL"){
	

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

}
 
  

				
	
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


				