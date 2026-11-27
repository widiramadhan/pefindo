<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php

 $error="";
$id = $_GET['id'];
$req_id = $_GET['request_id'];
$orderno = $_GET['order_no'];
$date = date("Y-m-d");
$call = "{call SP_GET_DETAIL_REQUEST_MH(?,?)}";
$param = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN));
$exec55 = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_defaults(), true)); 
$data = sqlsrv_fetch_array($exec55);

$branch = $data['BRANCH_ID'];
$branchType=substr($branch,0,2);

$call10 = "{call SP_APPROVAL_GETNAME_SFICA(?)}";
$param10 = array(array($branch),SQLSRV_PARAM_IN);
$exec10 = sqlsrv_query( $conn, $call10, $param10) or die( print_r( sqlsrv_errors(), true));	

	
$call2 = "{call SP_GET_IMG_REQUEST_MH(?,?,?)}";
$param2 = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array($orderno, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2) or die( print_r( sqlsrv_errors(), true));	
$data2 = sqlsrv_fetch_array($exec2);

$callpasangan = "{call SP_GET_DATA_KOREKSI(?)}";
$parampasangan = array(array($orderno, SQLSRV_PARAM_IN));
$execpasangan = sqlsrv_query( $conn, $callpasangan, $parampasangan) or die( print_r( sqlsrv_defaults(), true)); 
$datapasangan = sqlsrv_fetch_array($execpasangan);

$callspk = "{call SP_DATA_SPK(?)}";
$paramspk = array(array($orderno, SQLSRV_PARAM_IN));
$execspk = sqlsrv_query( $conn, $callspk, $paramspk) or die( print_r( sqlsrv_defaults(), true)); 
$dataspk = sqlsrv_fetch_array($execspk);

if($data2['FOTO_KTP_PASANGAN'] <> NULL){
	$siapanih="PASANGAN";
	$foto_siapanih=$data2['FOTO_KTP_PASANGAN'];
}else{
	$siapanih="PENJAMIN";
	$foto_siapanih=$data2['FOTO_KTP_PENJAMIN'];
}

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

if(isset($_FILES['foto_spk']['name'])){
	$output = prepareImageDBString($_FILES['foto_spk']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO SPK";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_kk']['name'])){
	$output = prepareImageDBString($_FILES['foto_kk']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO KK PEMOHON";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_ktp_pemohon']['name'])){
	$output = prepareImageDBString($_FILES['foto_ktp_pemohon']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO KTP PEMOHON";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_ktp_pasangan_penjamin']['name'])){
	$output = prepareImageDBString($_FILES['foto_ktp_pasangan_penjamin']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO KTP ".$siapanih;
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_npwp']['name'])){
	$output = prepareImageDBString($_FILES['foto_npwp']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO NPWP";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_ss_wa']['name'])){
	$output = prepareImageDBString($_FILES['foto_ss_wa']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO SCRENSHOOT WA";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_pendukung']['name'])){
	$output = prepareImageDBString($_FILES['foto_pendukung']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO PENDUKUNG";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_FILES['foto_slip_gaji']['name'])){
	$output = prepareImageDBString($_FILES['foto_slip_gaji']['tmp_name']);
	//echo $output;
	
	$assignment_id = $_POST['assignment_id'];
	$order_no = $_POST['order_no'];
	$images = $output;
	$type = "FOTO SLIP GAJI";
	$user = $_GET['USERNAME'];
	
	$call = "{call  SP_UPDATE_IMAGES_REQUEST_MH(?,?,?,?,?,?)}";
	$param = array(
					array($assignment_id, SQLSRV_PARAM_IN),
					array($req_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($images, SQLSRV_PARAM_IN),
					array($type, SQLSRV_PARAM_IN),
					array($user, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

	echo"<script>window.location='index.php?USERNAME=".$user."&page=detail-request-mh&id=".$assignment_id."&request_id=".$req_id."&order_no=".$orderno."'</script>";
}

if(isset($_POST['submit'])){
	$order_no = $_POST['order_no'];
	$id_request = $_POST['id'];
	$req_id = $_POST['req_id'];

	$ktp_pemohon=$_POST['ktp_pemohon'];
	$nama_pemohon=$_POST['nama_pemohon'];
	$tgl_pemohon=$_POST['tgl_pemohon'];
	$nama_ibu_pemohon=$_POST['nama_ibu_pemohon'];
	$status_pemohon=$_POST['status_pemohon'];
	$type_pemohon="PEMOHON";
	$check_dt_pemohon2=$_POST['check_dt_pemohon'];
	$check_dt_pasangan2=$_POST['check_dt_pasangan'];
	$check_dt_kk2=$_POST['check_dt_kk'];
	$check_dt_pendukung2=$_POST['check_dt_pendukung'];
	$check_dt_slip_gaji2=$_POST['check_dt_slip_gaji'];
	$check_dt_spk2=$_POST['check_dt_spk'];
	$check_dt_npwp2=$_POST['check_dt_npwp'];
	$check_dt_ss_wa2=$_POST['check_dt_ss_wa'];

	$spk_no = $_POST['spk_no'];
	$tgl_spk = $_POST['tgl_spk'];
	$nama_pemesan = $_POST['nama_pemesan'];
	$alamat_ktp = $_POST['alamat_ktp'];
	$alamat_tinggal = $_POST['alamat_tinggal'];
	$no_hp = $_POST['no_hp'];
	$no_npwp = $_POST['no_npwp'];
	$merk_kendaraan = $_POST['merk_kendaraan'];
	$tipe_kendaraan = $_POST['tipe_kendaraan'];
	$model_kendaraan = $_POST['model_kendaraan'];
	$thn_kendaraan = $_POST['thn_kendaraan'];
	$harga_otr = str_replace(',','',$_POST['harga_otr']); 
	$tenor = $_POST['tenor'];
	$angsuran =str_replace(',', '', $_POST['angsuran']) ;
	$dp_total = str_replace(',', '', $_POST['dp_total']);
	$pencairan = str_replace(',', '', $_POST['pencairan']);
	$uang_jaminan = str_replace(',','',$_POST['uang_jaminan']);

	$user_ca = $_POST['approval'];
	
	if($ktp_pemohon == ""){
		echo"<script>alert('Nomor KTP Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_pemohon == ""){
		echo"<script>alert('Nomor Nama Pemohon Wajib Diisi');history.back();</script>";
	}else if($tgl_pemohon == ""){
		echo"<script>alert('Nomor Tanggal Lahir Pemohon Wajib Diisi');history.back();</script>";
	}else if($nama_ibu_pemohon == ""){
		echo"<script>alert('Nomor Nama Ibu Pemohon Wajib Diisi');history.back();</script>";
	}else if($check_dt_pemohon2 == ""){
		echo"<script>alert('Silahkan Ceklis Data Pemohon');history.back();</script>";
	}else if($check_dt_pasangan2 == ""){
		echo"<script>alert('Silahkan Ceklis Data Pasangan');history.back();</script>";
	}else if($check_dt_kk2 == ""){
		echo"<script>alert('Silahkan Ceklis Data Kartu Keluarga');history.back();</script>";
	//}else if($check_dt_pendukung2 == ""){
	//	echo"<script>alert('Silahkan Ceklis Data Pendukung');history.back();</script>";
	//}else if($check_dt_slip_gaji2 == ""){
	//	echo"<script>alert('Silahkan Ceklis Data Slip Gaji');history.back();</script>";
	}else if($check_dt_spk2 == ""){
		echo"<script>alert('Silahkan Ceklis Data SPK');history.back();</script>";
	}else if($check_dt_npwp2 == ""){
		echo"<script>alert('Silahkan Ceklis Data NPWP');history.back();</script>";
	}else if($check_dt_ss_wa2 == ""){
		echo"<script>alert('Silahkan Ceklis Data Screenshoot Whatsapp');history.back();</script>";

	}else if($spk_no == ""){
		echo"<script>alert('Silahkan isi No SPK');history.back();</script>";
	}else if($tgl_spk == ""){
		echo"<script>alert('Silahkan isi Tanggal SPK');history.back();</script>";
	}else if($nama_pemesan == ""){
		echo"<script>alert('Silahkan isi Nama Pemesan');history.back();</script>";
	}else if($alamat_ktp == ""){
		echo"<script>alert('Silahkan isi Alamat KTP');history.back();</script>";
	}else if($alamat_tinggal == ""){
		echo"<script>alert('Silahkan isi Alamat Tinggal');history.back();</script>";
	}else if($no_hp == ""){
		echo"<script>alert('Silahkan isi No Handphone');history.back();</script>";
	}else if($no_npwp == "" && $branchType == "15"){
		echo"<script>alert('Silahkan isi No NPWP');history.back();</script>";
	}else if($merk_kendaraan == ""){
		echo"<script>alert('Silahkan isi Merk Kendaraan');history.back();</script>";
	}else if($tipe_kendaraan == ""){
		echo"<script>alert('Silahkan isi Tipe Kendaraan');history.back();</script>";
	}else if($model_kendaraan == ""){
		echo"<script>alert('Silahkan isi Model Kendaraan');history.back();</script>";
	}else if($thn_kendaraan == ""){
		echo"<script>alert('Silahkan isi Tahun Kendaraan');history.back();</script>";
	}else if($harga_otr == ""){
		echo"<script>alert('Silahkan isi Harga OTR');history.back();</script>";
	}else if($tenor == ""){
		echo"<script>alert('Silahkan isi Tenor');history.back();</script>";
	}else if($angsuran == ""){
		echo"<script>alert('Silahkan isi Angsuran');history.back();</script>";
	}else if($dp_total == ""){
		echo"<script>alert('Silahkan isi Total DP');history.back();</script>";
	}else if($pencairan == ""){
		echo"<script>alert('Silahkan isi Pencairan');history.back();</script>";
	}else if($uang_jaminan == ""){
		echo"<script>alert('Silahkan isi Uang Jaminan');history.back();</script>";
	//}else if($user_ca == ""){
		//echo"<script>alert('Silahkan isi Approval');history.back();</script>";	
	}else{
		//pemohon 
		$call = "{call SP_INSERT_DETAIL_REQUEST_MH(?,?,?,?,?,?,?,?,?,?)}";
		$param = array(
						array($id_request, SQLSRV_PARAM_IN),
						array($req_id, SQLSRV_PARAM_IN),
						array($order_no, SQLSRV_PARAM_IN),
						array($ktp_pemohon, SQLSRV_PARAM_IN),
						array($nama_pemohon, SQLSRV_PARAM_IN),
						array($tgl_pemohon, SQLSRV_PARAM_IN),
						array($nama_ibu_pemohon, SQLSRV_PARAM_IN),
						array($status_pemohon, SQLSRV_PARAM_IN),
						array($type_pemohon, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 

		$mobile_survey_assigment_id = $_GET['id'];
		$order_no = $_GET['order_no'];
		$spk_no = $_POST['spk_no'];
		$tgl_spk = $_POST['tgl_spk'];
		$nama_pemesan = $_POST['nama_pemesan'];
		$alamat_ktp = $_POST['alamat_ktp'];
		$alamat_tinggal = $_POST['alamat_tinggal'];
		$no_hp = $_POST['no_hp'];
		$no_npwp = $_POST['no_npwp'];
		$merk_kendaraan = $_POST['merk_kendaraan'];
		$tipe_kendaraan = $_POST['tipe_kendaraan'];
		$model_kendaraan = $_POST['model_kendaraan'];
		$thn_kendaraan = $_POST['thn_kendaraan'];
		$harga_otr = str_replace(',','',$_POST['harga_otr']); 
		$tenor = $_POST['tenor'];
		$angsuran =str_replace(',', '', $_POST['angsuran']) ;
		$dp_total = str_replace(',', '', $_POST['dp_total']);
		$pencairan = str_replace(',', '', $_POST['pencairan']);
		$uang_jaminan = str_replace(',','',$_POST['uang_jaminan']);
		$user = $_GET['USERNAME'];
		$user_ca = $_POST['approval'];
		
		$call9 = "{call SP_INSERT_SPK (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
		$param9 = array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array($spk_no,SQLSRV_PARAM_IN),
						array($tgl_spk,SQLSRV_PARAM_IN),
						array($nama_pemesan,SQLSRV_PARAM_IN),
						array($alamat_ktp,SQLSRV_PARAM_IN),
						array($alamat_tinggal,SQLSRV_PARAM_IN),
						array($no_hp,SQLSRV_PARAM_IN),
						array($no_npwp,SQLSRV_PARAM_IN),
						array($merk_kendaraan,SQLSRV_PARAM_IN),
						array($tipe_kendaraan,SQLSRV_PARAM_IN),
						array($model_kendaraan,SQLSRV_PARAM_IN),
						array($thn_kendaraan,SQLSRV_PARAM_IN),
						array($harga_otr,SQLSRV_PARAM_IN),
						array($tenor,SQLSRV_PARAM_IN),
						array($angsuran,SQLSRV_PARAM_IN),
						array($dp_total,SQLSRV_PARAM_IN),
						array($pencairan,SQLSRV_PARAM_IN),
						array($uang_jaminan,SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN),
						array($user_ca,SQLSRV_PARAM_IN)
					);
		// var_dump($param9);
		// exit();
		$exec9 = sqlsrv_query( $conn, $call9, $param9) or die( print_r( sqlsrv_errors(), true)); 
		
		if($_POST['ktp_pasangan'] <> ""){ //jika ktp pasangannya diisi maka simpan pasangan	   
			$ktp_pasangan=$_POST['ktp_pasangan'];
			$nama_pasangan=$_POST['nama_pasangan'];
			$tgl_pasangan=$_POST['tgl_pasangan'];
			$nama_ibu_pasangan=$_POST['nama_ibu_pasangan'];
			$status_pasangan=$_POST['status_pasangan'];
			$type_pasangan=$siapanih;
			
			$call2 = "{call SP_INSERT_DETAIL_REQUEST_MH(?,?,?,?,?,?,?,?,?,?)}";
			$param2 = array(
							array($id_request, SQLSRV_PARAM_IN),
							array($req_id, SQLSRV_PARAM_IN),
							array($order_no, SQLSRV_PARAM_IN),
							array($ktp_pasangan, SQLSRV_PARAM_IN),
							array($nama_pasangan, SQLSRV_PARAM_IN),
							array($tgl_pasangan, SQLSRV_PARAM_IN),
							array($nama_ibu_pasangan, SQLSRV_PARAM_IN),
							array($status_pasangan, SQLSRV_PARAM_IN),
							array($type_pasangan, SQLSRV_PARAM_IN),
							array($_GET['USERNAME'], SQLSRV_PARAM_IN));
			$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true)); 
		}
		
		if($_POST['ktp_penjamin'] <> ""){ //jika ktp penjaminnya diisi maka simpan penjamin	 
			$ktp_penjamin=$_POST['ktp_penjamin'];
			$nama_penjamin=$_POST['nama_penjamin'];
			$tgl_penjamin=$_POST['tgl_penjamin'];
			$nama_ibu_penjamin=$_POST['nama_ibu_penjamin'];
			$status_penjamin=$_POST['status_penjamin'];
			$type_penjamin=$siapanih;
			
			$call3 = "{call  SP_INSERT_DETAIL_REQUEST_MH(?,?,?,?,?,?,?,?,?,?)}";
			$param3 = array(
							array($id_request, SQLSRV_PARAM_IN),
							array($req_id, SQLSRV_PARAM_IN),
							array($order_no, SQLSRV_PARAM_IN),
							array($ktp_penjamin, SQLSRV_PARAM_IN),
							array($nama_penjamin, SQLSRV_PARAM_IN),
							array($tgl_penjamin, SQLSRV_PARAM_IN),
							array($nama_ibu_penjamin, SQLSRV_PARAM_IN),
							array($status_penjamin, SQLSRV_PARAM_IN),
							array($type_penjamin, SQLSRV_PARAM_IN),
							array($_GET['USERNAME'], SQLSRV_PARAM_IN));
			$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_errors(), true)); 
		}
		if($_POST['check_dt_pemohon']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call8 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param8 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('KTP PEMOHON',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec8 = sqlsrv_query( $conn, $call8, $param8) or die( print_r( sqlsrv_errors(), true)); 
		}
		
		if($_POST['check_dt_pasangan']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call30 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param30 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('KTP PASANGAN',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec30 = sqlsrv_query( $conn, $call30, $param30) or die( print_r( sqlsrv_errors(), true)); 
		}
		if($_POST['check_dt_kk']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call31 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param31 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('KK',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec31 = sqlsrv_query( $conn, $call31, $param31) or die( print_r( sqlsrv_errors(), true));
		}
	/*	if($_POST['check_dt_pendukung']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call32 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param32 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('DOCUMENT PENDUKUNG',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec32 = sqlsrv_query( $conn, $call32, $param32) or die( print_r( sqlsrv_errors(), true));
		}
		if($_POST['check_dt_slip_gaji']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call33 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param33 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('SLIP GAJI',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec33 = sqlsrv_query( $conn, $call33, $param33) or die( print_r( sqlsrv_errors(), true));
		}*/
		if($_POST['check_dt_spk']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call34 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param34 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('SPK',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec34 = sqlsrv_query( $conn, $call34, $param34) or die( print_r( sqlsrv_errors(), true));
		}
		if($_POST['check_dt_npwp']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call35 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param35 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('NPWP',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec35 = sqlsrv_query( $conn, $call35, $param35) or die( print_r( sqlsrv_errors(), true));
		}
		if($_POST['check_dt_ss_wa']<> "" ){

			$mobile_survey_assigment_id = $_GET['id'];
			$order_no = $_GET['order_no'];
			$user = $_GET['USERNAME'];

			$call36 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
			$param36 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
							array($order_no,SQLSRV_PARAM_IN),
							array('1',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('SS WA',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array('',SQLSRV_PARAM_IN),
							array($user,SQLSRV_PARAM_IN));
			$exec36 = sqlsrv_query( $conn, $call36, $param36) or die( print_r( sqlsrv_errors(), true));
		}

		
		if($exec){
			//update status jadi on progress / jadi approval
			$call4 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
			$param4 = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('12', SQLSRV_PARAM_IN));
			$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_defaults(), true)); 
			$data4= sqlsrv_fetch_array($exec4);
			
			$call77 = "{call SP_INSERT_UPDATE_RESPONSE(?,?,?,?,?)}";
			$param77 = array(array($id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('12', SQLSRV_PARAM_IN),array($order_no, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
			$exec77 = sqlsrv_query( $conn, $call77, $param77) or die( print_r( sqlsrv_defaults(), true)); 
			$data77= sqlsrv_fetch_array($exec77);

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?page=request-mh&USERNAME=".$_GET['USERNAME']."'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}
}
$call6 = "{call  SP_GET_MERK_KENDARAAN(?)}";
$param6 = array(array($orderno),SQLSRV_PARAM_IN);
$exec6 = sqlsrv_query( $conn, $call6,$param6) or die( print_r( sqlsrv_errors(), true));


// $data6= sqlsrv_fetch_array($exec6);

// $call7 = "{call SP_GET_TIPE_KENDARAAN (?)}";
// $param7 = array(array('4'),SQLSRV_PARAM_IN);
// $exec7 = sqlsrv_query($conn, $call7, $param7) or die(print_r(sqlsrv_errors(), true));


if(isset($_POST['submit2'])){
	$request_id=$_POST['request_id'];
	$assignment_id=$_POST['assignment_id'];
	$order_no=$_POST['order_no'];
	$notes=$_POST['notes'];

	$check_dt_pemohon2=$_POST['check_dt_pemohon'];
	$check_dt_pasangan2=$_POST['check_dt_pasangan'];
	$check_dt_kk2=$_POST['check_dt_kk'];
	$check_dt_pendukung2=$_POST['check_dt_pendukung'];
	$check_dt_slip_gaji2=$_POST['check_dt_slip_gaji'];
	$check_dt_spk2=$_POST['check_dt_spk'];
	$check_dt_npwp2=$_POST['check_dt_npwp'];
	$check_dt_ss_wa2=$_POST['check_dt_ss_wa'];
	
	$id_request = $_POST['id'];
	$req_id = $_POST['req_id'];

	$ktp_pemohon=$_POST['ktp_pemohon'];
	$nama_pemohon=$_POST['nama_pemohon'];
	$tgl_pemohon=$_POST['tgl_pemohon'];
	$nama_ibu_pemohon=$_POST['nama_ibu_pemohon'];
	$status_pemohon=$_POST['status_pemohon'];
	$type_pemohon="PEMOHON";

	
	$mobile_survey_assigment_id = $_GET['id'];
	$order_no = $_GET['order_no'];
	$spk_no = $_POST['spk_no'];
	$tgl_spk = $_POST['tgl_spk'];
	$nama_pemesan = $_POST['nama_pemesan'];
	$alamat_ktp = $_POST['alamat_ktp'];
	$alamat_tinggal = $_POST['alamat_tinggal'];
	$no_hp = $_POST['no_hp'];
	$no_npwp = $_POST['no_npwp'];
	$merk_kendaraan = $_POST['merk_kendaraan'];
	$tipe_kendaraan = $_POST['tipe_kendaraan'];
	$model_kendaraan = $_POST['model_kendaraan'];
	$thn_kendaraan = $_POST['thn_kendaraan'];
	$harga_otr = str_replace(',','',$_POST['harga_otr']); 
	$tenor = $_POST['tenor'];
	$angsuran =str_replace(',', '', $_POST['angsuran']) ;
	$dp_total = str_replace(',', '', $_POST['dp_total']);
	$pencairan = str_replace(',', '', $_POST['pencairan']);
	$uang_jaminan = str_replace(',','',$_POST['uang_jaminan']);
	$user = $_GET['USERNAME'];
	$user_ca = $_POST['approval'];

	$vr_pemohon = $_POST['vr_pemohon'];
	$vr_pasangan = $_POST['vr_pasangan'];
	$vr_kk = $_POST['vr_kk'];
	$vr_pendukung = $_POST['vr_pendukung'];
	$vr_slip_gaji = $_POST['vr_slip_gaji'];
	$vr_spk = $_POST['vr_spk'];
	$vr_npwp = $_POST['vr_npwp'];
	$vr_ss_wa = $_POST['vr_ss_wa'];

	//PEMOHON
	
	
		$call = "{call SP_INSERT_DETAIL_KOREKSI_MH(?,?,?,?,?,?,?,?,?,?)}";
		$param = array(
						array($id_request, SQLSRV_PARAM_IN),
						array($req_id, SQLSRV_PARAM_IN),
						array($order_no, SQLSRV_PARAM_IN),
						array($ktp_pemohon, SQLSRV_PARAM_IN),
						array($nama_pemohon, SQLSRV_PARAM_IN),
						array($tgl_pemohon, SQLSRV_PARAM_IN),
						array($nama_ibu_pemohon, SQLSRV_PARAM_IN),
						array($status_pemohon, SQLSRV_PARAM_IN),
						array($type_pemohon, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
		
		
		
			if($_POST['ktp_pasangan'] <> ""){ //jika ktp pasangannya diisi maka simpan pasangan	   
			$ktp_pasangan=$_POST['ktp_pasangan'];
			$nama_pasangan=$_POST['nama_pasangan'];
			$tgl_pasangan=$_POST['tgl_pasangan'];
			$nama_ibu_pasangan=$_POST['nama_ibu_pasangan'];
			$status_pasangan=$_POST['status_pasangan'];
			$type_pasangan=$siapanih;
			
			$call2 = "{call SP_INSERT_DETAIL_KOREKSI_MH(?,?,?,?,?,?,?,?,?,?)}";
			$param2 = array(
							array($id_request, SQLSRV_PARAM_IN),
							array($req_id, SQLSRV_PARAM_IN),
							array($order_no, SQLSRV_PARAM_IN),
							array($ktp_pasangan, SQLSRV_PARAM_IN),
							array($nama_pasangan, SQLSRV_PARAM_IN),
							array($tgl_pasangan, SQLSRV_PARAM_IN),
							array($nama_ibu_pasangan, SQLSRV_PARAM_IN),
							array($status_pasangan, SQLSRV_PARAM_IN),
							array($type_pasangan, SQLSRV_PARAM_IN),
							array($_GET['USERNAME'], SQLSRV_PARAM_IN));
			$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true)); 
		}
		
		if($_POST['ktp_penjamin'] <> ""){ //jika ktp penjaminnya diisi maka simpan penjamin	 
			$ktp_penjamin=$_POST['ktp_penjamin'];
			$nama_penjamin=$_POST['nama_penjamin'];
			$tgl_penjamin=$_POST['tgl_penjamin'];
			$nama_ibu_penjamin=$_POST['nama_ibu_penjamin'];
			$status_penjamin=$_POST['status_penjamin'];
			$type_penjamin=$siapanih;
			
			$call3 = "{call  SP_INSERT_DETAIL_KOREKSI_MH(?,?,?,?,?,?,?,?,?,?)}";
			$param3 = array(
							array($id_request, SQLSRV_PARAM_IN),
							array($req_id, SQLSRV_PARAM_IN),
							array($order_no, SQLSRV_PARAM_IN),
							array($ktp_penjamin, SQLSRV_PARAM_IN),
							array($nama_penjamin, SQLSRV_PARAM_IN),
							array($tgl_penjamin, SQLSRV_PARAM_IN),
							array($nama_ibu_penjamin, SQLSRV_PARAM_IN),
							array($status_penjamin, SQLSRV_PARAM_IN),
							array($type_penjamin, SQLSRV_PARAM_IN),
							array($_GET['USERNAME'], SQLSRV_PARAM_IN));
			$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_errors(), true)); 
		}
	
	if($vr_pemohon <> "0"){
		$call40 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param40 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_pemohon,SQLSRV_PARAM_IN),
						array('KTP PEMOHON',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec40 = sqlsrv_query( $conn, $call40, $param40) or die( print_r( sqlsrv_defaults(), true)); 
	}else if($check_dt_pemohon2 == "1"){
		$call41 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param41 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('KTP PEMOHON',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec41 = sqlsrv_query( $conn, $call41, $param41) or die( print_r( sqlsrv_errors(), true)); 
		
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";
	}

	//PASANGAN
	if($vr_pasangan <> "0"){
		$call42 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param42 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_pasangan,SQLSRV_PARAM_IN),
						array('KTP PASANGAN',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec42 = sqlsrv_query( $conn, $call42, $param42) or die( print_r( sqlsrv_defaults(), true)); 
	}else if($check_dt_pasangan2 == "1"){
		$call43 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param43 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('KTP PASANGAN',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec43 = sqlsrv_query( $conn, $call43, $param43) or die( print_r( sqlsrv_errors(), true)); 
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";
	}
	//KK
	if($vr_kk <> "0"){
		$call44 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param44 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_kk,SQLSRV_PARAM_IN),
						array('KK',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec44 = sqlsrv_query( $conn, $call44, $param44) or die( print_r( sqlsrv_defaults(), true)); 
	}else if($check_dt_kk2 == "1"){
		$call45 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param45 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('KK',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec45 = sqlsrv_query( $conn, $call45, $param45) or die( print_r( sqlsrv_errors(), true)); 
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";
	}
	//PENDUKUNG
	if ($vr_pendukung <> "0") {
		$call46 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param46 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_pendukung,SQLSRV_PARAM_IN),
						array('DOCUMENT PENDUKUNG',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec46 = sqlsrv_query( $conn, $call46, $param46) or die( print_r( sqlsrv_defaults(), true));
	}else if($check_dt_pendukung2 == "1"){
		$call47 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param47 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('DOCUMENT PENDUKUNG',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec47 = sqlsrv_query( $conn, $call47, $param47) or die( print_r( sqlsrv_errors(), true));
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";	
	}

	// vr_slip_gaji
	if ($vr_slip_gaji <> "0") {
		$call48 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param48 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_slip_gaji,SQLSRV_PARAM_IN),
						array('SLIP GAJI',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec48 = sqlsrv_query( $conn, $call48, $param48) or die( print_r( sqlsrv_defaults(), true));
	}else if($check_dt_slip_gaji2 == "1"){
		$call49 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param49 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('SLIP GAJI',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec49 = sqlsrv_query( $conn, $call49, $param49) or die( print_r( sqlsrv_errors(), true));
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";		
	}

	//SPK
	if ($vr_spk <> "0") {
		$call50 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param50 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_spk,SQLSRV_PARAM_IN),
						array('SPK',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec50 = sqlsrv_query( $conn, $call50, $param50) or die( print_r( sqlsrv_defaults(), true));
	}else if($check_dt_spk2 == "1"){
		$call60 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param60 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('SPK',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec60 = sqlsrv_query( $conn, $call60, $param60) or die( print_r( sqlsrv_errors(), true));
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";	
	}

	//NPWP
	if ($vr_npwp <> "0") {
		$call61 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param61 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_npwp,SQLSRV_PARAM_IN),
						array('NPWP',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec61 = sqlsrv_query( $conn, $call61, $param61) or die( print_r( sqlsrv_defaults(), true));
	}else if($check_dt_npwp2 == "1"){
		$call62 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param62 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('NPWP',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec62 = sqlsrv_query( $conn, $call62, $param62) or die( print_r( sqlsrv_errors(), true));
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";	
	}

	//SS WA
	if ($vr_ss_wa <> "0") {
		$call63 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param63 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('0',SQLSRV_PARAM_IN),
						array($vr_ss_wa,SQLSRV_PARAM_IN),
						array('SS WA',SQLSRV_PARAM_IN),
						array($notes,SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec63 = sqlsrv_query( $conn, $call63, $param63) or die( print_r( sqlsrv_defaults(), true));
	}else if($check_dt_ss_wa2 == "1"){
		$call64 = "{call  SP_VERIFIKASI_DOKUMENT(?,?,?,?,?,?,?,?)}";
		$param64 =array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
						array($order_no,SQLSRV_PARAM_IN),
						array('1',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('SS WA',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array('',SQLSRV_PARAM_IN),
						array($user,SQLSRV_PARAM_IN));
		$exec64 = sqlsrv_query( $conn, $call64, $param64) or die( print_r( sqlsrv_errors(), true));
	}else{
		echo"<script>alert('Pilih Salah Satu !');history.back();</script>";	
	}

	$call20 = "{call SP_INSERT_RESPONSE_RETURN_NEW(?,?,?,?,?)}";
	$param20 = array(array($assignment_id, SQLSRV_PARAM_IN),
					array($request_id, SQLSRV_PARAM_IN),
					array($order_no, SQLSRV_PARAM_IN),
					array($_GET['USERNAME'], SQLSRV_PARAM_IN),
					array($notes, SQLSRV_PARAM_IN));
	// var_dump($param20);
	// exit();
	$exec20 = sqlsrv_query( $conn, $call20, $param20) or die( print_r( sqlsrv_defaults(), true)); 
	
	//update status jadi finish
	$call12 = "{call UPDATE_STATUS_REQUEST_MH(?,?,?)}";
	$param12 = array(array($assignment_id, SQLSRV_PARAM_IN),array($req_id, SQLSRV_PARAM_IN),array('6', SQLSRV_PARAM_IN));
	$exec12 = sqlsrv_query( $conn, $call12, $param12) or die( print_r( sqlsrv_defaults(), true)); 
	$data12 = sqlsrv_fetch_array($exec12);

	 $call13 = "{call SP_INSERT_SPK (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	 $param13 = array(array($mobile_survey_assigment_id,SQLSRV_PARAM_IN),
	 				array($order_no,SQLSRV_PARAM_IN),
	 				array($spk_no,SQLSRV_PARAM_IN),
	 				array($tgl_spk,SQLSRV_PARAM_IN),
	 				array($nama_pemesan,SQLSRV_PARAM_IN),
	 				array($alamat_ktp,SQLSRV_PARAM_IN),
	 				array($alamat_tinggal,SQLSRV_PARAM_IN),
					array($no_hp,SQLSRV_PARAM_IN),
	 				array($no_npwp,SQLSRV_PARAM_IN),
					array($merk_kendaraan,SQLSRV_PARAM_IN),
					array($tipe_kendaraan,SQLSRV_PARAM_IN),
					array($model_kendaraan,SQLSRV_PARAM_IN),
					array($thn_kendaraan,SQLSRV_PARAM_IN),
	 				array($harga_otr,SQLSRV_PARAM_IN),
	 				array($tenor,SQLSRV_PARAM_IN),
	 				array($angsuran,SQLSRV_PARAM_IN),
	 				array($dp_total,SQLSRV_PARAM_IN),
	 				array($pencairan,SQLSRV_PARAM_IN),
	 				array($uang_jaminan,SQLSRV_PARAM_IN),
	 				array($user,SQLSRV_PARAM_IN),
					array('',SQLSRV_PARAM_IN)
	 			);
	
	 $exec13 = sqlsrv_query( $conn, $call13, $param13) or die( print_r( sqlsrv_errors(), true)); 


	
	if($exec20){
		echo"<script>alert('Data berhasil dikembalikan');window.location='index.php?page=hasil-pengecekan&USERNAME=".$_GET['USERNAME']."'</script>";
	}else{
		echo"<script>alert('Data gagal dikembalikan');history.back();</script>";
	}
}
?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style><body onload="myFunctionALL();">
<!--<form action="" method="post">-->
	<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
	<input type="hidden" name="id" value="<?php echo $id;?>">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="header">
					<h4 class="title"></h4>
					<p class="category"></p>
				</div>
				<div class="content">		
					<div class="row">
						<div class="col-md-6">
							<table class="table">
								<tr>
									<td>Nomor Order</td>
									<td>:</td>
									<td><?php echo $data['ORDER_NO'];?></td>
								</tr>
								<tr>
									<td>NIK</td>
									<td>:</td>
									<td><?php echo $data['ID_NO'];?></td>
								</tr>
								<tr>
									<td>Nama Customer</td>
									<td>:</td>
									<td><?php echo $data['CUSTOMER_NAME'];?></td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table">
								<tr>
									<td>Nama Dealer</td>
									<td>:</td>
									<td><?php echo $data['DEALER_NAME'];?></td>
								</tr>
								<tr>
									<td>User Request</td>
									<td>:</td>
									<td><?php echo $data['MH'];?></td>
								</tr>
								<tr>
									<td>Tanggal Request</td>
									<td>:</td>
									<td>
									
										<?php if($data['CREATE_DATE']<>NULL){echo $data['CREATE_DATE']->format('Y-m-d H:i:s');}else{echo"-";}?></td>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	 
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PEMOHON</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KTP_PEMOHON'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP_PEMOHON']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP_PEMOHON']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_ktp_pemohon" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="ktp_pemohon" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" value="<?php echo $data['ID_NO'];?>" required id="ktp_pemohon" onkeyup="function_ktp_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pemohon <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_pemohon" class="form-control" placeholder="Nama Lengkap" value="<?php echo $data['CUSTOMER_NAME'];?>" required id="nama_pemohon" onkeyup="function_nama_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pemohon" class="form-control" placeholder="Tanggal Lahir" value="<?php if($data['BIRTH_DATE']<>NULL){echo $data['BIRTH_DATE']->format("Y-m-d");}?>" required id="ttl_pemohon" onchange="function_ttl_pemohon(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pemohon" class="form-control" placeholder="Nama Ibu Kandung" required id="ibu_pemohon" value="<?php echo $data['MOTHER_NAME'];?>" onkeyup="function_ibu_pemohon(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="status_kawin_pemohon"  id="status_pemohon" onchange="function_status_pemohon(this.value)">
												<option value="MAR" <?php if($data['MARITAL_STATUS']=="MAR"){echo "selected";}?>>KAWIN</option>
												<option value="SIN" <?php if($data['MARITAL_STATUS']=="SIN"){echo "selected";}?>>BELUM KAWIN</option>
												<option value="DIV" <?php if($data['MARITAL_STATUS']=="DIV"){echo "selected";}?>>CERAI HIDUP</option>
												<option value="WID" <?php if($data['MARITAL_STATUS']=="WID"){echo "selected";}?>>CERAI MATI</option>
											</select>
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<?php 
												
													$callCheckKtpPemohon = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckKtpPemohon = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('KTP PEMOHON', SQLSRV_PARAM_IN));
													$execCheckKtpPemohon = sqlsrv_query( $conn, $callCheckKtpPemohon, $paramCheckKtpPemohon) or die( print_r( sqlsrv_errors(), true));
													$dataCheckKtpPemohon = sqlsrv_fetch_array($execCheckKtpPemohon);
												?>
												
												<input type="checkbox" name="check_dt_pemohon" id="check_dt_pemohon" <?php if ($dataCheckKtpPemohon['STATUS_VERIFICATION']=='1') {echo 'checked';}?>  onclick="myFunction()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_pemohon" id="vr_pemohon"  <?php if ($dataCheckKtpPemohon['STATUS_VERIFICATION']=='1') {echo 'disabled';}?>  onchange ="function_vr_pemohon(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>
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
										<td style="width:50%;">Foto KTP</td>
										<td style="width:50%;">
											<?php if($foto_siapanih <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($foto_siapanih);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($foto_siapanih);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_ktp_pasangan_penjamin" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor KTP</td>
										<td style="width:50%;">
											<input type="text" name="ktp_pasangan" value="<?php echo $datapasangan['ID_NO']?>" onkeypress="return onlyNumber(event)" maxlength="16" class="form-control" placeholder="Nomor KTP" id="ktp_pasangan" onkeyup="function_ktp_pasangan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama <?php echo $siapanih;?></td>
										<td style="width:50%;">
											<input type="text" name="nama_pasangan" class="form-control" value="<?php echo $datapasangan['CUST_NAME']?>" placeholder="Nama Lengkap" id="nama_pasangan" onkeyup="function_nama_pasangan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Lahir</td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_pasangan" class="form-control" placeholder="Tanggal Lahir" value="<?php if($datapasangan['BIRTH_DATE']<>NULL){echo $datapasangan['BIRTH_DATE']->format("Y-m-d");}?>" id="ttl_pasangan" onchange ="function_ttl_pasangan(this.value)" autocomplete="off">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Ibu Kandung</td>
										<td style="width:50%;">
											<input type="text" name="nama_ibu_pasangan" class="form-control" placeholder="Nama Ibu Kandung" value="<?php echo $datapasangan['MOTHER_NAME']?>" id="ibu_pasangan" onkeyup="function_ibu_pasangan(this.value)" autocomplete="off">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Kawin</td>
										<td style="width:50%;">
											<select class="form-control" name="status_kawin_pasangan" id="status_pasangan" onchange="function_status_pasangan(this.value)">
												<option value="<?php echo $datapasangan['MARITAL_STATUS_CODE'];?>" <?php if($datapasangan['MARITAL_STATUS_CODE'] !== ''){ ?> selected  <?php } ?>
												><?php echo $datapasangan['MARITAL_STATUS_CODE']?></option>
												<option value="MAR" selected>KAWIN</option>
												<option value="SIN">BELUM KAWIN</option>
												<option value="DIV">CERAI HIDUP</option>
												<option value="WID">CERAI MATI</option>
											</select>
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<?php 
													$callCheckKtpPenjamin = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckKtpPenjamin = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('KTP PASANGAN', SQLSRV_PARAM_IN));
													$execCheckKtpPenjamin = sqlsrv_query( $conn, $callCheckKtpPenjamin, $paramCheckKtpPenjamin) or die( print_r( sqlsrv_errors(), true));
													$dataCheckKtpPenjamin = sqlsrv_fetch_array($execCheckKtpPenjamin);
												?>
												<input type="checkbox" name="check_dt_pasangan" id="check_dt_pasangan" <?php if ($dataCheckKtpPenjamin['STATUS_VERIFICATION']=='1') {echo 'checked';}?>   onclick="myFunction2()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_pasangan" id="vr_pasangan" <?php if ($dataCheckKtpPenjamin['STATUS_VERIFICATION']=='1') {echo 'disabled';}?>   onchange ="function_vr_pasangan(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>
									</tr>
								</table>	
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">KARTU KELUARGA</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto KK</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_KK_PEMOHON'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK_PEMOHON']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK_PEMOHON']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_kk" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<?php 
													$callCheckKK = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckKK = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('KK', SQLSRV_PARAM_IN));
													$execCheckKK = sqlsrv_query( $conn, $callCheckKK, $paramCheckKK) or die( print_r( sqlsrv_errors(), true));
													$dataCheckKK = sqlsrv_fetch_array($execCheckKK);
												?>
												<input type="checkbox" name="check_dt_kk" id="check_dt_kk" <?php if ($dataCheckKK['STATUS_VERIFICATION']=='1') {echo 'checked';}?>  onclick="myFunction3()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_kk" id="vr_kk" <?php if ($dataCheckKK['STATUS_VERIFICATION']=='1') {echo 'disabled';}?>  onchange ="function_vr_kk(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>	
									</tr>
								</table>

							</div>
						</div>
						<!--<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">PBB/AJB/Sertifikat</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto PBB/AJB/Sertifikat</td>
										<td style="width:50%;">
											<?php /*if($data2['FOTO_PENDUKUNG'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_PENDUKUNG']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_PENDUKUNG']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id; ?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];*/?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_pendukung" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="check_dt_pendukung" id="check_dt_pendukung" onclick="myFunction4()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_pendukung" id="vr_pendukung" onchange ="function_vr_pendukung(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>	
									</tr>
								</table>
							</div>
						</div>-->
						<!--<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">SLIP GAJI</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto Slip Gaji</td>
										<td style="width:50%;">
											<?php /*if($data2['FOTO_SLIP_GAJI'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SLIP_GAJI']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];*/?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_slip_gaji" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<input type="checkbox" name="check_dt_slip_gaji" id="check_dt_slip_gaji" onclick="myFunction5()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_slip_gaji" id="vr_slip_gaji" onchange ="function_vr_slip_gaji(this.value)" >
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>	
									</tr>
								</table>
							</div>
						</div>-->
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">SURAT PEMESANAN KENDARAAN</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto SPK</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SPK'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SPK']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SPK']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_spk" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<form action="" method="post" enctype="multipart/form-data">
									<tr>
										<td style="width:50%;">No SPK<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="spk_no" id="spk_no"  value="<?php echo $dataspk['NO_SPK']?>" class="form-control" style="width: 100%;" onkeyup="function_spk_no(this.value)" maxlength="10" required>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal SPK <span class="text-danger">*</span></td>
										<td style="width:50%;">
											<div class="input-group date">
												<input type="text" name="tgl_spk" class="form-control" placeholder="Tanggal SPK" 
												
												value="<?php if($dataspk['TANGGAL_SPK']<>NULL){echo $dataspk['TANGGAL_SPK']->format("Y-m-d");}?>"
												required id="tgl_spk" onchange="function_tgl_spk(this.value)" autocomplete="off" onkeyup="function_tgl_spk(this.value)">
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nama Pemesan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" style="width: 100%;" value="<?php echo $dataspk['NAMA_PEMESAN']?>" onkeyup="function_nama_pemesan(this.value)">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat KTP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat_ktp" id="alamat_ktp" style="width: 100%;" class="form-control" value="<?php echo $dataspk['ALAMAT_KTP']?>" onkeyup="function_alamat_ktp(this.value)">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Alamat Tinggal<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="alamat_tinggal" id="alamat_tinggal" style="width: 100%;" class="form-control" value="<?php echo $dataspk['ALAMAT_TINGGAL']?>" onkeyup="function_alamat_tinggal(this.value)">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">No HP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_hp" id="no_hp" style="width: 100%;" class="form-control" value="<?php echo $dataspk['NO_HP']?>" onkeypress="return hanyaAngka(event)" maxlength="13" onkeyup="function_no_hp(this.value)">
										</td>
									</tr>
										<?php if($branchType == "15"){?>
									<tr>
										<td style="width:50%;">No NPWP<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="no_npwp" id="no_npwp" style="width: 100%;" class="form-control" value="<?php echo $dataspk['NO_NPWP']?>" onkeypress="return hanyaAngka(event)" onkeyup="function_no_npwp(this.value)" maxlength="15">
										</td>
									</tr>
									<tr>
									<?php }else{ ?>
									<tr>
										<td style="width:50%;">No NPWP<span class="text-danger"></span></td>
										<td style="width:50%;">
											<input type="text" name="no_npwp" id="no_npwp" style="width: 100%;" class="form-control" value="<?php echo $dataspk['NO_NPWP']?>" onkeypress="return hanyaAngka(event)" onkeyup="function_no_npwp(this.value)" maxlength="15">
										</td>
									</tr>
									<tr>
									<?php } ?>
									<?php
									$callMerk = "{call  SP_GET_MERK_KENDARAAN_KOREKSI(?,?)}";
									$paramMerk = array(array($orderno,SQLSRV_PARAM_IN),
													   array($dataspk['MERK_KENDARAAN'],SQLSRV_PARAM_IN));
													   
									$execMerk = sqlsrv_query( $conn, $callMerk,$paramMerk) or die( print_r( sqlsrv_errors(), true));
									$dataMerk = sqlsrv_fetch_array($execMerk);
									?>
										<td style="width:50%;">Merk Kendaraan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<select class="form-control" name="merk_kendaraan" id="merk_kendaraan1" onchange ="function_merk_kendaraan(this.value)">
												 <option value="<?php echo $dataMerk['ASSET_HIERARCHY_L1_ID']; ?>" selected><?php echo $dataMerk['ASSET_HIERARCHY_L1_NAME']; ?></option>
												 <?php while($data6 = sqlsrv_fetch_array($exec6)){ ?>
												 <option value="<?php echo $data6['ASSET_HIERARCHY_L1_ID']; ?>"><?php echo $data6['ASSET_HIERARCHY_L1_NAME']; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Model Kendaraan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<!-- <input type="text" name="tipe_kendaraan" id="tipe_kendaraan" style="width: 100%;"> -->
											<select name="model_kendaraan" id="model_kendaraan1" class="form-control" onchange ="function_model_kendaraan(this.value)">
												<option value="<?php echo $dataspk['MODEL_KENDARAAN']?>" selected><?php echo $dataspk['MODEL_KENDARAAN']?></option>
												
											</select>	
											
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tipe Kendaraan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<!-- <input type="text" name="tipe_kendaraan" id="tipe_kendaraan" style="width: 100%;"> -->
											<select name="tipe_kendaraan" id="tipe_kendaraan1" class="form-control" onchange ="function_tipe_kendaraan(this.value)">
												<option value="<?php echo $dataspk['TIPE_KENDARAAN']?>" selected><?php echo $dataspk['TIPE_KENDARAAN']?></option>
												
											</select>	
											
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tahun Kendaraan<span class="text-danger">*</span><jg/td>
										<td style="width:50%;">
											<input type="text" name="thn_kendaraan" id="thn_kendaraan" class="form-control" value="<?php echo $dataspk['TAHUN_KENDARAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" maxlength="4" onkeyup="function_thn_kendaraan(this.value)">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Harga OTR<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="harga_otr" id="harga_otr" class="form-control" value="<?php echo $dataspk['HARGA_OTR']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);function_harga_otr(this.value);">
										</td>
									</tr>
									<tr>
									
										<td style="width:50%;">Tenor<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="tenor" id="tenor" class="form-control" value="<?php echo $dataspk['TENOR']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup="function_tenor(this.value)">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Angsuran<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="angsuran" id="angsuran" class="form-control" value="<?php echo $dataspk['ANGSURAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);function_angsuran(this.value);">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">DP Total<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="dp_total" id="dp_total" class="form-control" value="<?php echo $dataspk['DP_TOTAL']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);function_dp_total(this.value);">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Pencairan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="pencairan" id="pencairan" class="form-control" value="<?php echo $dataspk['PENCAIRAN']?>" style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);function_pencairan(this.value);">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Uang Jaminan<span class="text-danger">*</span></td>
										<td style="width:50%;">
											<input type="text" name="uang_jaminan" id="uang_jaminan" class="form-control" value="<?php echo $dataspk['UANG_JAMINAN']?>"  style="width: 100%;" onkeypress="return hanyaAngka(event)" onkeyup = "javascript:this.value=Comma(this.value);function_uang_jaminan(this.value);">
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
												<?php 
													$callCheckSPK = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckSPK = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('SPK', SQLSRV_PARAM_IN));
													$execCheckSPK = sqlsrv_query( $conn, $callCheckSPK, $paramCheckSPK) or die( print_r( sqlsrv_errors(), true));
													$dataCheckSPK = sqlsrv_fetch_array($execCheckSPK);
												?>
												<input type="checkbox" name="check_dt_spk" id="check_dt_spk" <?php if ($dataCheckSPK['STATUS_VERIFICATION']=='1') {echo 'checked';}?>  onclick="myFunction6()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_spk" id="vr_spk" <?php if ($dataCheckSPK['STATUS_VERIFICATION']=='1') {echo 'disabled';}?>  onchange ="function_vr_spk(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
													<option value="Document Tidak Sesuai">Tanda Tangan SPK Tidak Sesuai</option>
												</select>
											</td>
										</form>	
									</tr>
									<tr>
									</tr>
								</form>
								</table>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">NOMOR POKOK WAJIB PAJAK</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto NPWP</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_NPWP'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_NPWP']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_NPWP']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_npwp" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Nomor NPWP</td>
										<td style="width:50%;">
											<input type="text" name="npwp" class="form-control" onkeypress="return onlyNumber(event)" placeholder="Nomor NPWP" id="npwp" onkeyup="function_npwp(this.value)" autocomplete="off" value="<?php echo $data['NO_NPWP'];?>">
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Status Verification
											<span class="text-danger">*</span>
												<?php 
													$callCheckNPWP = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckNPWP = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('NPWP', SQLSRV_PARAM_IN));
													$execCheckNPWP = sqlsrv_query( $conn, $callCheckNPWP, $paramCheckNPWP) or die( print_r( sqlsrv_errors(), true));
													$dataCheckNPWP = sqlsrv_fetch_array($execCheckNPWP);
												?>
											<input type="checkbox" name="check_dt_npwp" id="check_dt_npwp"  <?php if ($dataCheckNPWP['STATUS_VERIFICATION']=='1') {echo 'checked';}?> onclick="myFunction7()">
										</td>
										<td style="width:50%;">
											<select class="form-control" name="vr_npwp" id="vr_npwp" <?php if ($dataCheckNPWP['STATUS_VERIFICATION']=='1') {echo 'disabled';}?>  onchange ="function_vr_npwp(this.value)">
												<option value="0"></option>
												<option value="Document Tidak Ada">Document Tidak Ada</option>
												<option value="Document Tidak Jelas">Document Tidak Jelas</option>
												<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
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
										<td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Screenshoot Whatsapp</td>
									</tr>
									<tr>
										<td style="width:50%;">Foto SS WA</td>
										<td style="width:50%;">
											<?php if($data2['FOTO_SS_WA'] <> NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SS_WA']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_SS_WA']);?>" width="100%" class="img-custom">
												</a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
												<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
												<div class="form-group" style="margin-top:5px;">
													<label style="color:#333;">Ganti Foto</label>
													<input type="file" name="foto_ss_wa" onchange="submit()">
												</div>
											</form>
										</td>
									</tr>
									<tr>
										<td style="width:50%;">Tanggal Dealer kirim foto</td>
										<td style="width:50%;"> 
											<input type="text" name="" class="form-control" value="<?php if($data['DEALER_DATE']<>NULL){echo $data['DEALER_DATE']->format('Y-m-d H:i:s');}?>" readonly>
											
										</td>
									</tr>
									<tr>
										<form action="" method="post" enctype="multipart/form-data">
											<td style="width:50%;">Status Verification
												<span class="text-danger">*</span>
											
												<?php 
													$callCheckWA = "{call GET_CHECK_KOREKSI(?,?)}";
													$paramCheckWA = array(
																	array($orderno, SQLSRV_PARAM_IN),
																	array('SS WA', SQLSRV_PARAM_IN));
													$execCheckWA = sqlsrv_query( $conn, $callCheckWA, $paramCheckWA) or die( print_r( sqlsrv_errors(), true));
													$dataCheckWA = sqlsrv_fetch_array($execCheckWA);
												?>
												<input type="checkbox" name="check_dt_ss_wa" id="check_dt_ss_wa"  <?php if ($dataCheckWA['STATUS_VERIFICATION']=='1') {echo 'checked';}?> onclick="myFunction8()">
											</td>
											<td style="width:50%;">
												<select class="form-control" name="vr_ss_wa" id="vr_ss_wa" <?php if ($dataCheckWA['STATUS_VERIFICATION']=='1') {echo 'disabled';}?> onchange ="function_vr_ss_wa(this.value)">
													<option value="0"></option>
													<option value="Document Tidak Ada">Document Tidak Ada</option>
													<option value="Document Tidak Jelas">Document Tidak Jelas</option>
													<option value="Document Tidak Sesuai">Document Tidak Sesuai</option>
												</select>
											</td>
										</form>	
									</tr>
								</table>
							</div>					
						</div>
					</div>
					<hr>
					<div class="col-md-6">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tr>
									<td>Reason Return</td>
									<td>
										<input type="text" class="form-control" name="notes" id="notes" onkeyup="function_notes(this.value)">
									</td>
								</tr>
							</table>
						</div>
					</div>
					<!--<div class="col-md-6">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tr>
									<td>Approval</td>
									<td>
										<!-- <input type="text" class="form-control" name="reason_return" id="reason_return"> -->
								<!--		<select class="form-control" name="approval" id="approval" onchange="function_approval(this.value)">
											<option value="">PILIH APPROVAL</option>
											<?php /* while($data10 = sqlsrv_fetch_array($exec10)){ ?>
											<option value="<?php echo $data10['USERNAME']; ?>"><?php echo $data10['USERNAME']; ?></option>
											<?php } */?>
										</select>
									</td>
								</tr>
							</table>
						</div>
					</div>-->
					
					<div class="row">
						<div class="col-md-8">
							<!-- <div class="table-responsive">
									<table class="table table-bordered">
										<tr>
											<td> -->
							<!-- <center> -->
								<form action="" method="post">
									<input type="hidden" name="id" value="<?php echo $id;?>">
									<input type="hidden" name="req_id" value="<?php echo $req_id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
								
									<input type="hidden" name="ktp_pemohon" id="ktp_pemohon2">
									<input type="hidden" name="nama_pemohon" id="nama_pemohon2">
									<input type="hidden" name="tgl_pemohon" id="ttl_pemohon2">
									<input type="hidden" name="nama_ibu_pemohon" id="ibu_pemohon2">
									<input type="hidden" name="status_pemohon" id="status_pemohon2">
									
									<input type="hidden" name="ktp_pasangan" id="ktp_pasangan2">
									<input type="hidden" name="nama_pasangan" id="nama_pasangan2">
									<input type="hidden" name="tgl_pasangan" id="ttl_pasangan2">
									<input type="hidden" name="nama_ibu_pasangan" id="ibu_pasangan2">
									<input type="hidden" name="status_pasangan" id="status_pasangan2">
									
									<input type="hidden" name="ktp_penjamin" id="ktp_penjamin2">
									<input type="hidden" name="nama_penjamin" id="nama_penjamin2">
									<input type="hidden" name="tgl_penjamin" id="ttl_penjamin2">
									<input type="hidden" name="nama_ibu_penjamin" id="ibu_penjamin2">
									<input type="hidden" name="status_penjamin" id="status_penjamin2">

									<input type="hidden" name="npwp" id="npwp2">

									<input type="hidden" name="check_dt_pemohon" id="check_dt_pemohon2" value="">
									<input type="hidden" name="vr_pemohon" id="vr_pemohon2">

									<input type="hidden" name="check_dt_pasangan" id="check_dt_pasangan2" value="">
									<input type="hidden" name="vr_pasangan" id="vr_pasangan2">

									<input type="hidden" name="check_dt_pendukung" id="check_dt_pendukung2" value="">
									<input type="hidden" name="vr_pendukung" id="vr_pendukung2">

									<input type="hidden" name="check_dt_slip_gaji" id="check_dt_slip_gaji2" value="">
									<input type="hidden" name="vr_slip_gaji" id="vr_slip_gaji2">

									<input type="hidden" name="check_dt_kk" id="check_dt_kk2" value="">
									<input type="hidden" name="vr_kk" id="vr_kk2">

									<input type="hidden" name="spk_no" id="spk_no2">
									<input type="hidden" name="tgl_spk" id="tgl_spk2">
									<input type="hidden" name="nama_pemesan" id="nama_pemesan2">
									<input type="hidden" name="alamat_ktp" id="alamat_ktp2">
									<input type="hidden" name="alamat_tinggal" id="alamat_tinggal2">
									<input type="hidden" name="no_hp" id="no_hp2">
									<input type="hidden" name="no_npwp" id="no_npwp2">
									<input type="hidden" name="merk_kendaraan" id="merk_kendaraan2">
									<input type="hidden" name="tipe_kendaraan" id="tipe_kendaraan2">
									<input type="hidden" name="model_kendaraan" id="model_kendaraan2">
									<input type="hidden" name="thn_kendaraan" id="thn_kendaraan2">
									<input type="hidden" name="harga_otr" id="harga_otr2">
									<input type="hidden" name="tenor" id="tenor2">
									<input type="hidden" name="angsuran" id="angsuran2">
									<input type="hidden" name="dp_total" id="dp_total2">
									<input type="hidden" name="pencairan" id="pencairan2">
									<input type="hidden" name="uang_jaminan" id="uang_jaminan2">

									<input type="hidden" name="check_dt_spk" id="check_dt_spk2" value="">
									<input type="hidden" name="vr_spk" id="vr_spk2">

									<input type="hidden" name="check_dt_npwp" id="check_dt_npwp2" value="">
									<input type="hidden" name="vr_npwp" id="vr_npwp2">

									<input type="hidden" name="check_dt_ss_wa" id="check_dt_ss_wa2" value="">
									<input type="hidden" name="vr_ss_wa" id="vr_ss_wa2">

									<input type="hidden" name="approval" id="approval2">

									<input type="hidden" name="request_id" value="<?php echo $req_id ?> ">
									<input type="hidden" name="assignment_id" value="<?php echo $id;?>">
									<input type="hidden" name="order_no" value="<?php echo $data['ORDER_NO'];?>">
									<input type="hidden" name="notes" id="notes2">
									<?php echo $error;?>
									<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN DATA" style="width:150px;">
									<a href="index.php?page=request-mh&USERNAME=<?php echo $user;?>" class="btn btn-custom" style="width:150px;">BATAL</a>
									<!-- <a href="index.php?page=return-mh&USERNAME=<?php echo $user;?>&id=<?php echo $id;?>&request_id=<?php echo $req_id;?>" class="btn btn-custom" style="width:150px;">KEMBALIKAN DATA</a> -->
									<!-- <a href="index.php?page=back-data&SPK=" class="btn btn-custom" style="width:150px;">Kembalikan Data</a> -->
									<input type="submit" name="submit2" value="Kembalikan Data" class="btn btn-custom" style="width:150px;">
								</form>
								</div> 
								<!-- </center> -->
							<br><br>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
<!--</form>-->
<script src="assets/js/jqueryrotate.min.js"></script>
	<script>
function hanyaAngka(evt) {
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))

return false;
return true;
}
</script>
<script>
$(document).ready(function() {
	 var ktp_pemohon = $("#ktp_pemohon").val();
	 $("#ktp_pemohon2").val(ktp_pemohon);
	 var nama_pemohon = $("#nama_pemohon").val();
	 $("#nama_pemohon2").val(nama_pemohon);
	 var ttl_pemohon = $("#ttl_pemohon").val();
	 $("#ttl_pemohon2").val(ttl_pemohon);
	 var ibu_pemohon = $("#ibu_pemohon").val();
	 $("#ibu_pemohon2").val(ibu_pemohon);
	 var status_pemohon = $("#status_pemohon").val();
	 $("#status_pemohon2").val(status_pemohon);
	 
	 var ktp_pasangan = $("#ktp_pasangan").val();
	 $("#ktp_pasangan2").val(ktp_pasangan);
	 var nama_pasangan = $("#nama_pasangan").val();
	 $("#nama_pasangan2").val(nama_pasangan);
	 var ttl_pasangan = $("#ttl_pasangan").val();
	 $("#ttl_pasangan2").val(ttl_pasangan);
	 var ibu_pasangan = $("#ibu_pasangan").val();
	 $("#ibu_pasangan2").val(ibu_pasangan);
	 var status_pasangan = $("#status_pasangan").val();
	 $("#status_pasangan2").val(status_pasangan);
	 
	 var ktp_penjamin = $("#ktp_penjamin").val();
	$("#ktp_penjamin2").val(ktp_penjamin);
	var nama_penjamin = $("#nama_penjamin").val();
	$("#nama_penjamin2").val(nama_penjamin);
	var ttl_penjamin = $("#ttl_penjamin").val();
	$("#ttl_penjamin2").val(ttl_penjamin);
	var ibu_penjamin = $("#ibu_penjamin").val();
	$("#ibu_penjamin2").val(ibu_penjamin);
	var status_penjamin = $("#status_penjamin").val();
	$("#status_penjamin2").val(status_penjamin);
	
	var npwp = $("#npwp").val();
	$("#npwp2").val(npwp);


	
	var vr_pemohon = $("#vr_pemohon").val();
	$("#vr_pemohon2").val(vr_pemohon);

	
	var vr_pasangan = $("#vr_pasangan").val();
	$("#vr_pasangan2").val(vr_pasangan);
	
	var vr_kk = $("#vr_kk").val();
	$("#vr_kk2").val(vr_kk);

	var vr_pendukung = $("#vr_pendukung").val();
	$("#vr_pendukung2").val(vr_pendukung);

	var vr_slip_gaji = $("#vr_slip_gaji").val();
	$("#vr_slip_gaji2").val(vr_slip_gaji);

	var spk_no = $("#spk_no").val();
	$("#spk_no2").val(spk_no);
	var tgl_spk = $("#tgl_spk").val();
	$("#tgl_spk2").val(tgl_spk);
	var nama_pemesan = $("#nama_pemesan").val();
	$("#nama_pemesan2").val(nama_pemesan);
	var alamat_ktp = $("#alamat_ktp").val();
	$("#alamat_ktp2").val(alamat_ktp);
	var alamat_tinggal = $("#alamat_tinggal").val();
	$("#alamat_tinggal2").val(alamat_tinggal);
	var no_hp = $("#no_hp").val();
	$("#no_hp2").val(no_hp);
	var no_npwp = $("#no_npwp").val();
	$("#no_npwp2").val(no_npwp);
	var merk_kendaraan1 = $("#merk_kendaraan1").val();
	$("#merk_kendaraan2").val(merk_kendaraan1);
	var tipe_kendaraan1 = $("#tipe_kendaraan1").val();
	$("#tipe_kendaraan2").val(tipe_kendaraan1);
	var model_kendaraan1 = $("#model_kendaraan1").val();
	$("#model_kendaraan2").val(model_kendaraan1);
	var thn_kendaraan = $("#thn_kendaraan").val();
	$("#thn_kendaraan2").val(thn_kendaraan);
	var harga_otr = $("#harga_otr").val();
	$("#harga_otr2").val(harga_otr);
	var tenor = $("#tenor").val();
	$("#tenor2").val(tenor);
	var angsuran = $("#angsuran").val();
	$("#angsuran2").val(angsuran);
	var dp_total = $("#dp_total").val();
	$("#dp_total2").val(dp_total);
	var pencairan = $("#pencairan").val();
	$("#pencairan2").val(pencairan);
	var uang_jaminan = $("#uang_jaminan").val();
	$("#uang_jaminan2").val(uang_jaminan);

	var vr_spk = $("#vr_spk").val();
	$("#vr_spk2").val(vr_spk);

	var vr_npwp = $("#vr_npwp").val();
	$("#vr_npwp2").val(vr_npwp);

	var vr_ss_wa = $("#vr_ss_wa").val();
	$("#vr_ss_wa2").val(vr_ss_wa);

	var approval = $("#approval").val();
	$("#approval2").val(approval);

	var notes = $("#notes").val();
	$("#notes2").val(notes);
});


function function_ktp_pemohon(value){ document.getElementById("ktp_pemohon2").value = value;}
function function_nama_pemohon(value){ document.getElementById("nama_pemohon2").value = value;}
function function_ttl_pemohon(value){ document.getElementById("ttl_pemohon2").value = value;}
function function_tgl_spk(value){ document.getElementById("tgl_spk").value = value;}
function function_ibu_pemohon(value){ document.getElementById("ibu_pemohon2").value = value;}
function function_status_pemohon(value){ document.getElementById("status_pemohon2").value = value;}

function function_ktp_pasangan(value){ document.getElementById("ktp_pasangan2").value = value;}
function function_nama_pasangan(value){ document.getElementById("nama_pasangan2").value = value;}
function function_ttl_pasangan(value){ document.getElementById("ttl_pasangan2").value = value;}
function function_ibu_pasangan(value){ document.getElementById("ibu_pasangan2").value = value;}
function function_status_pasangan(value){ document.getElementById("status_pasangan2").value = value;}

function function_ktp_penjamin(value){ document.getElementById("ktp_penjamin2").value = value;}
function function_nama_penjamin(value){ document.getElementById("nama_penjamin2").value = value;}
function function_ttl_penjamin(value){ document.getElementById("ttl_penjamin2").value = value;}
function function_ibu_penjamin(value){ document.getElementById("ibu_penjamin2").value = value;}
function function_status_penjamin(value){ document.getElementById("status_penjamin2").value = value;}

function function_npwp(value){ document.getElementById("npwp2").value = value;}



function function_vr_pemohon(value){ document.getElementById("vr_pemohon2").value = value;}


function function_vr_pasangan(value){ document.getElementById("vr_pasangan2").value = value;}


function function_vr_kk(value){ document.getElementById("vr_kk2").value = value;}


function function_vr_pendukung(value){ document.getElementById("vr_pendukung2").value = value;}


function function_vr_slip_gaji(value){ document.getElementById("vr_slip_gaji2").value = value;}



function function_spk_no(value){ document.getElementById("spk_no2").value = value;}
function function_tgl_spk(value){ document.getElementById("tgl_spk2").value = value;}
function function_nama_pemesan(value){ document.getElementById("nama_pemesan2").value = value;}
function function_alamat_ktp(value){ document.getElementById("alamat_ktp2").value = value;}
function function_alamat_tinggal(value){ document.getElementById("alamat_tinggal2").value = value;}
function function_no_hp(value){ document.getElementById("no_hp2").value = value;}
function function_no_npwp(value){ document.getElementById("no_npwp2").value = value;}
function function_merk_kendaraan(value){ document.getElementById("merk_kendaraan2").value = value;}
function function_tipe_kendaraan(value){ document.getElementById("tipe_kendaraan2").value = value;}
function function_model_kendaraan(value){ document.getElementById("model_kendaraan2").value = value;}
function function_thn_kendaraan(value){ document.getElementById("thn_kendaraan2").value = value;}
function function_harga_otr(value){ document.getElementById("harga_otr2").value = value;}
function function_tenor(value){ document.getElementById("tenor2").value = value;}
function function_angsuran(value){ document.getElementById("angsuran2").value = value;}
function function_dp_total(value){ document.getElementById("dp_total2").value = value;}
function function_pencairan(value){ document.getElementById("pencairan2").value = value;}
function function_uang_jaminan(value){ document.getElementById("uang_jaminan2").value = value;}


function function_vr_spk(value){ document.getElementById("vr_spk2").value = value;}


function function_vr_npwp(value){ document.getElementById("vr_npwp2").value = value;}


function function_vr_ss_wa(value){ document.getElementById("vr_ss_wa2").value = value;}


function function_approval(value){ document.getElementById("approval2").value = value;}

function function_notes(value){ document.getElementById("notes2").value = value;}
//function function_npwp(value){ document.getElementById("npwp2").value = value;}


function myFunction() {
  var checkBox = document.getElementById("check_dt_pemohon");
  var text = document.getElementById("check_dt_pemohon2");
  
  if (checkBox.checked == true){
    text.value = "1";
  } else {
     text.value = "";
  }
}
function myFunction2() {
  var checkBox2 = document.getElementById("check_dt_pasangan");
  var text2 = document.getElementById("check_dt_pasangan2");
  
  if (checkBox2.checked == true){
    text2.value = "1";
  } else {
     text2.value = "";
  }
}
function myFunction3() {
  var checkBox3 = document.getElementById("check_dt_kk");
  var text3 = document.getElementById("check_dt_kk2");
  
  if (checkBox3.checked == true){
    text3.value = "1";
  } else {
     text3.value = "";
  }
}

function myFunction4() {
  var checkBox4 = document.getElementById("check_dt_pendukung");
  var text4 = document.getElementById("check_dt_pendukung2");
  
  if (checkBox4.checked == true){
    text4.value = "1";
  } else {
     text4.value = "";
  }
}
function myFunction5() {
  var checkBox5 = document.getElementById("check_dt_slip_gaji");
  var text5 = document.getElementById("check_dt_slip_gaji2");
  
  if (checkBox5.checked == true){
    text5.value = "1";
  } else {
     text5.value = "";
  }
}
function myFunction6() {
  var checkBox6 = document.getElementById("check_dt_spk");
  var text6 = document.getElementById("check_dt_spk2");
  
  if (checkBox6.checked == true){
    text6.value = "1";
  } else {
     text6.value = "";
  }
}
function myFunction7() {
  var checkBox7 = document.getElementById("check_dt_npwp");
  var text7 = document.getElementById("check_dt_npwp2");
  
  if (checkBox7.checked == true){
    text7.value = "1";
  } else {
     text7.value = "";
  }
}
function myFunction8() {
  var checkBox8 = document.getElementById("check_dt_ss_wa");
  var text8 = document.getElementById("check_dt_ss_wa2");
  
  if (checkBox8.checked == true){
    text8.value = "1";
  } else {
     text8.value = "";
  }
}	


function myFunctionALL() {
	myFunction();
	myFunction2();
	myFunction3();
	myFunction6();
	myFunction7();
	myFunction8();
	


}	

</script>


<script>
$( document ).ready(function() {   
	$('#ttl_pemohon').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#ttl_pasangan').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#ttl_penjamin').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});
	$('#tgl_spk').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: '1900:2025',
		endDate: new Date()
	});

 $('#merk_kendaraan1').on("change",function(){
	
	$.get( "get_tipe_kendaraan.php",{
		merk_kendaraan:$('#merk_kendaraan1').val()
	}, function(data_merk) {
		var merk_value = $('#merk_kendaraan1').val();
		if(merk_value == ""){
			//document.getElementById('rowKecamatan').style.display='none';
			$('#model_kendaraan1').empty();
			$('#model_kendaraan1').append('<option value="" selected>Pilih</option>');
			// document.getElementById('rowKecamatan').style.display='none';
			// document.getElementById('rowKelurahan').style.display='none';
			// document.getElementById("zipcode").value = "";
			// document.getElementById("postal_code").value = "";
		}else{
			//document.getElementById('rowKecamatan').style.display='block';
			if(data_merk == null){

				$('#model_kendaraan1').empty();
				$('#model_kendaraan1').append('<option value="" selected>Pilih</option>');
				// document.getElementById('rowKecamatan').style.display='none';
				// document.getElementById('rowKelurahan').style.display='none';
				// document.getElementById("zipcode").value = "";
				// document.getElementById("postal_code").value = "";
			}else{

				$('#model_kendaraan1').empty();
				$('#model_kendaraan1').append('<option value="" selected>Pilih</option>');
					$.each(data_merk, function (index, value) {
					$('#model_kendaraan1').append('<option value="'+value.ASSET_NAME+'">'+value.ASSET_NAME+'</option>');
				});
				
			
				//$('#tipe_kendaraan1').append('<option value="" selected>Pilih</option>');
				// document.getElementById('rowKecamatan').style.display='block';
				// document.getElementById('rowKelurahan').style.display='none';
				// document.getElementById("zipcode").value = "";
				// document.getElementById("postal_code").value = "";
			}
		}
	});
});

 $('#model_kendaraan1').on("change",function(){
	
	$.get( "get_tipe_kendaraan_detail.php",{
		model_kendaraan:$('#model_kendaraan1').val()
	}, function(data_merk) {
		var merk_value = $('#model_kendaraan1').val();
		if(merk_value == ""){
			//document.getElementById('rowKecamatan').style.display='none';
			$('#tipe_kendaraan1').empty();
			$('#tipe_kendaraan1').append('<option value="" selected>Pilih</option>');
			// document.getElementById('rowKecamatan').style.display='none';
			// document.getElementById('rowKelurahan').style.display='none';
			// document.getElementById("zipcode").value = "";
			// document.getElementById("postal_code").value = "";
		}else{
			//document.getElementById('rowKecamatan').style.display='block';
			if(data_merk == null){

				$('#tipe_kendaraan1').empty();
				$('#tipe_kendaraan1').append('<option value="" selected>Pilih</option>');
				// document.getElementById('rowKecamatan').style.display='none';
				// document.getElementById('rowKelurahan').style.display='none';
				// document.getElementById("zipcode").value = "";
				// document.getElementById("postal_code").value = "";
			}else{

				$('#tipe_kendaraan1').empty();
				$('#tipe_kendaraan1').append('<option value="" selected>Pilih</option>');
					$.each(data_merk, function (index, value) {
					$('#tipe_kendaraan1').append('<option value="'+value.ASSET_NAME+'">'+value.ASSET_NAME+'</option>');
				});
				
			
				//$('#tipe_kendaraan1').append('<option value="" selected>Pilih</option>');
				// document.getElementById('rowKecamatan').style.display='block';
				// document.getElementById('rowKelurahan').style.display='none';
				// document.getElementById("zipcode").value = "";
				// document.getElementById("postal_code").value = "";
			}
		}
	});
});



});
</script>
<script>
 function Comma(Num) { //function to add commas to textboxes
           Num += '';
           Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
           Num = Num.replace(',', ''); Num = Num.replace(',', ''); Num = Num.replace(',', '');
           x = Num.split('.');
           x1 = x[0];
           x2 = x.length > 1 ? '.' + x[1] : '';
           var rgx = /(\d+)(\d{3})/;
           while (rgx.test(x1))
               x1 = x1.replace(rgx, '$1' + ',' + '$2');
           return x1 + x2;
       }

function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true;
}
function onCheckChange() {
	    if ($("#check_dt_pemohon").is(':checked')) {
	        $("#vr_pemohon").attr('disabled', 'disabled');
	        $("#check_dt_pemohon").val("TRUE");
	    } else {
	        $("#vr_pemohon").removeAttr('disabled');
	    }
	}
	$("#check_dt_pemohon").click(onCheckChange).change(onCheckChange);

function onCheckChange1() {
	    if ($("#check_dt_pasangan").is(':checked')) {
	        $("#vr_pasangan").attr('disabled', 'disabled');
	        $("#check_dt_pasangan").val("TRUE");
	    } else {
	        $("#vr_pasangan").removeAttr('disabled');
	    }
	}
	$("#check_dt_pasangan").click(onCheckChange1).change(onCheckChange1);

function onCheckChange2() {
	    if ($("#check_dt_kk").is(':checked')) {
	        $("#vr_kk").attr('disabled', 'disabled');
	        $("#check_dt_kk").val("TRUE");
	    } else {
	        $("#vr_kk").removeAttr('disabled');
	    }
	}
	$("#check_dt_kk").click(onCheckChange2).change(onCheckChange2);

function onCheckChange3() {
	    if ($("#check_dt_pendukung").is(':checked')) {
	        $("#vr_pendukung").attr('disabled', 'disabled');
	        $("#check_dt_pendukung").val("TRUE");
	    } else {
	        $("#vr_pendukung").removeAttr('disabled');
	    }
	}
	$("#check_dt_pendukung").click(onCheckChange3).change(onCheckChange3);

function onCheckChange4() {
	    if ($("#check_dt_slip_gaji").is(':checked')) {
	        $("#vr_slip_gaji").attr('disabled', 'disabled');
	        $("#check_dt_slip_gaji").val("TRUE");
	    } else {
	        $("#vr_slip_gaji").removeAttr('disabled');
	    }
	}
	$("#check_dt_slip_gaji").click(onCheckChange4).change(onCheckChange4);

function onCheckChange5() {
	    if ($("#check_dt_spk").is(':checked')) {
	        $("#vr_spk").attr('disabled', 'disabled');
	        $("#check_dt_spk").val("TRUE");
	    } else {
	        $("#vr_spk").removeAttr('disabled');
	    }
	}
	$("#check_dt_spk").click(onCheckChange5).change(onCheckChange5);

function onCheckChange6() {
	    if ($("#check_dt_npwp").is(':checked')) {
	        $("#vr_npwp").attr('disabled', 'disabled');
	        $("#check_dt_npwp").val("TRUE");
	    } else {
	        $("#vr_npwp").removeAttr('disabled');
	    }
	}
	$("#check_dt_npwp").click(onCheckChange6).change(onCheckChange6);

function onCheckChange7() {
	    if ($("#check_dt_ss_wa").is(':checked')) {
	        $("#vr_ss_wa").attr('disabled', 'disabled');
	        $("#check_dt_ss_wa").val("TRUE");
	    } else {
	        $("#vr_ss_wa").removeAttr('disabled');
	    }
	}
	$("#check_dt_ss_wa").click(onCheckChange7).change(onCheckChange7);


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