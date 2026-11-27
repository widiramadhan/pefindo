<?php
require_once("config/configuration.php");

$prospect=$_POST['prospect_no'];
$no_ktp=$_POST['no_ktp'];
$nama=$_POST['name'];
$date=$_POST['date'];
$mother_nm=$_POST['mother_name'];
$birth_place=$_POST['birth_place'];
$siapanih=$_POST['tipe_cust'];
$getUsername=$_GET['USERNAME'];

if($no_ktp==""){
	echo"<script>alert('Nomor KTP tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($nama==""){
	echo"<script>alert('Nama tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if($date==""){
	echo"<script>alert('Tanggal lahir tidak boleh kosong, silahkan lakukan edit data di CONFINS');history.back();</script>";
}else if(substr($no_ktp,0,1) == "0"){
	echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
}else if(substr($no_ktp,-4) == "0000"){
	echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
}else if(strlen(trim($no_ktp)) <> 16){
	echo"<script>alert('NIK harus 16 digit');history.back();</script>";
}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
	echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
}else{

$Warning_Data ="";
$Warning_Data_Sementara ="";


/********** CEK BLACKLIST **********/
$call_bls = "{call SP_CHECK_PEFINDO_BLACKLIST(?,?,?,?,?,?,?)}";
$params_bls = array(
				array($no_ktp, SQLSRV_PARAM_IN),
				array($nama, SQLSRV_PARAM_IN),
				array($date, SQLSRV_PARAM_IN),
				array($birth_place, SQLSRV_PARAM_IN),
				array($mother_nm, SQLSRV_PARAM_IN),
				array($prospect, SQLSRV_PARAM_IN),
				array($user, SQLSRV_PARAM_IN)
			);
$options =  array( "Scrollable" => "buffered" );
$exec_bls = sqlsrv_query( $conn, $call_bls, $params_bls, $options) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec_bls);
$checkBlacklist=sqlsrv_num_rows($exec_bls);

if($checkBlacklist > 0){	//----# Cek Blacklist
	echo"<script>alert('Customer tersebut terdaftar di Customer Blacklist Internal.');</script>";
	$Warning_Data = $Warning_Data." - Customer ini terdaftar di Customer Blacklist Internal.!<br>";
}
/********** END CEK BLACKLIST **********/



/********** CEK DUKCAPIL **********/
$param_dukcapil_array= array('nik' => $no_ktp, 'user_id' => "singlesuzukifinance", 'password' => "s3Jsm8K9", 'IP_USER' => $getUsername);
$param_dukcapil = json_encode($param_dukcapil_array);

$curlDkUpil = curl_init();
curl_setopt_array($curlDkUpil, array(
  CURLOPT_URL => "http://172.16.160.128:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_NIK",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "$param_dukcapil",
  CURLOPT_HTTPHEADER => array(
	"Authorization: Basic " . base64_encode("singlesuzukifinance:s3Jsm8K9"),
	"Content-Type: application/json",
	"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
	"cache-control: no-cache"
  ),
));

$responseDkUpil = curl_exec($curlDkUpil);
$errDkUpil = curl_error($curlDkUpil);
			
curl_close($curlDkUpil);
$resultDukcapil = json_decode($responseDkUpil, true);
//$resultDukcapil = null;
if(empty($resultDukcapil)){
	//----# Insert LOG
	$SourceLogDkUpilNtValid = "DUKCAPIL";
	$StatusLogDkUpilNtValid = "KTP TIDAK VALID";

	$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
	$paramsLogDkUpilNtValid = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpilNtValid, SQLSRV_PARAM_IN),array($StatusLogDkUpilNtValid, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));
	if($execLogDkUpilNtValid === false){
		echo"<script>alert('Error insert log Dukcapil Not Valid');</script>";
	}
	//----# Insert LOG End

	echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
	$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
}else{
	if ($errDkUpil){
		//----# Insert LOG
		$SourceLogDkUpil = "DUKCAPIL";
		$StatusLogDkUpil = "ERROR";

		$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
		$paramsLogDkUpil = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
		if($execLogDkUpil === false){
			echo"<script>alert('Error insert log Dukcapil');</script>";
		}
		//----# Insert LOG End
		echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
	}else{
		if (isset($resultDukcapil['content'][0]['RESPON'])) {
			//----# Insert LOG
			$SourceLogDkUpilnotfound = "DUKCAPIL";
			$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPON']);

			$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
			$paramsLogDkUpilnotfound = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpilnotfound === false){
				echo"<script>alert('NIK Tersebut Tidak ditemukan di Dukcapil.!');</script>";
			}
			//----# Insert LOG End

			echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			$Warning_Data = $Warning_Data."  ".$StatusLogDkUpilnotfound."  (Pada saat pengecekan No KTP di Dukcapil.!) ";
			
			$DkcplCustType = "";
			$DkcplNIK = "";
			$DkcplNAMA_LGKP = "";
			$DkcplJENIS_KLMIN = "";
			$DkcplTMPT_LHR =  "";
			$DkcplTGL_LHR = "";
			$DkcplSTATUS_KAWIN = "";
			$DkcplNAMA_LGKP_IBU = "";
			$DkcplJENIS_PKRJN = "";
			$DkcplALAMAT = "";
			$DkcplNO_RT = "";
			$DkcplNO_RW = "";
			$DkcplNO_PROP = "";
			$DkcplPROP_NAME = "";
			$DkcplNO_KAB = "";
			$DkcplKAB_NAME = "";
			$DkcplKEC_NAME = "";
			$DkcplNO_KEL = "";
			$DkcplNO_KEC = "";
			$DkcplKEL_NAME = "";
		}else{
			foreach($resultDukcapil['content'] as $contentdata){
				$DkcplCustType = "PEMOHON";
				$DkcplNIK = number_format($contentdata['NIK'], 0, '', '');
				$DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
				$DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
				$DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
				$DkcplTGL_LHR = $contentdata['TGL_LHR'];
				$DkcplSTATUS_KAWIN = $contentdata['STATUS_KAWIN'];
				$DkcplNAMA_LGKP_IBU = $contentdata['NAMA_LGKP_IBU'];
				$DkcplJENIS_PKRJN = $contentdata['JENIS_PKRJN'];
				$DkcplALAMAT = $contentdata['ALAMAT'];
				$DkcplNO_RT = $contentdata['NO_RT'];
				$DkcplNO_RW = $contentdata['NO_RW'];
				$DkcplNO_PROP = $contentdata['NO_PROP'];
				$DkcplPROP_NAME = $contentdata['PROP_NAME'];
				$DkcplNO_KAB = $contentdata['NO_KAB'];
				$DkcplKAB_NAME = $contentdata['KAB_NAME'];
				$DkcplKEC_NAME = $contentdata['KEC_NAME'];
				$DkcplNO_KEL = $contentdata['NO_KEL'];
				$DkcplNO_KEC = $contentdata['NO_KEC'];
				$DkcplKEL_NAME = $contentdata['KEL_NAME'];

				$namaTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP);
				$namaTanpaKomaD = str_replace(","," ",$namaTanpaTitikD);
				$namaTanpaPetikD = str_replace("'"," ",$namaTanpaKomaD);
				$namaTanpaStripD = str_replace("-"," ",$namaTanpaPetikD); 
				$namaTanpaSpasiDoubleD = str_replace("  "," ",$namaTanpaStripD);
				$namaTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleD)));
				//echo $namaTanpaSpasiD;
				
				$namaTanpaTitikP = str_replace("."," ",$nama);
				$namaTanpaKomaP = str_replace(","," ",$namaTanpaTitikP);
				$namaTanpaPetikP = str_replace("'"," ",$namaTanpaKomaP);
				$namaTanpaStripP =  str_replace("-"," ",$namaTanpaPetikP);
				$namaTanpaSpasiDoubleP = str_replace("  "," ",$namaTanpaStripP);
				$namaTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaTanpaSpasiDoubleP)));
				//echo $namaTanpaSpasiP;
				
				if($namaTanpaSpasiD != $namaTanpaSpasiP){
					//$Warning_Data_Sementara = $Warning_Data_Sementara." - Nama Lengkap Tidak Sama dengan data di Dukcapil.!<br>";
					$Warning_Data = $Warning_Data." - Nama Lengkap Tidak Sama dengan data di Dukcapil.!<br>";
				}
				if($DkcplTGL_LHR != $date){
					$Warning_Data = $Warning_Data." - Tanggal Lahir Tidak Sama dengan data di Dukcapil.!<br>";
				}
				if(strtoupper($siapanih) == "PEMOHON"){
					$namaIbuTanpaTitikD = str_replace("."," ",$DkcplNAMA_LGKP_IBU);
					$namaIbuTanpaKomaD = str_replace(","," ",$namaIbuTanpaTitikD);
					$namaIbuTanpaPetikD = str_replace("'"," ",$namaIbuTanpaKomaD);
					$namaIbuTanpaStripD = str_replace("-"," ",$namaIbuTanpaPetikD); 
					$namaIbuTanpaSpasiDoubleD = str_replace("  "," ",$namaIbuTanpaStripD);
					$namaIbuTanpaSpasiD = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleD)));
					
					$namaIbuTanpaTitikP = str_replace("."," ",$mother_nm);
					$namaIbuTanpaKomaP = str_replace(","," ",$namaIbuTanpaTitikP);
					$namaIbuTanpaPetikP = str_replace("'"," ",$namaIbuTanpaKomaP);
					$namaIbuTanpaStripP = str_replace("-"," ",$namaIbuTanpaPetikP);
					$namaIbuTanpaSpasiDoubleP = str_replace("  "," ",$namaIbuTanpaStripP);
					$namaIbuTanpaSpasiP = strtoupper(trim(preg_replace('/[\t|\s{2,}]/', '', $namaIbuTanpaSpasiDoubleP)));
					
					if($namaIbuTanpaSpasiD <> ""){
						if($namaIbuTanpaSpasiD != $namaIbuTanpaSpasiP){
							//$Warning_Data_Sementara = $Warning_Data_Sementara." - Nama Ibu Kandung Tidak Sama dengan data di Dukcapil.!<br>";
							$Warning_Data = $Warning_Data." - Nama Ibu Kandung Tidak Sama dengan data di Dukcapil.!<br>";
						}
					}
				}
				$Is_Similar = 0;
				if($Warning_Data != ""){
					$Is_Similar = 1;
				}

				$callSPDukcapil = "{call SP_INSERT_DUKCAPIL(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
				$paramsDukcapil = array(array($prospect, SQLSRV_PARAM_IN),
										array($DkcplCustType, SQLSRV_PARAM_IN),
										array($DkcplNIK, SQLSRV_PARAM_IN),
										array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
										array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
										array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
										array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
										array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
										array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
										array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN),
										array($DkcplALAMAT, SQLSRV_PARAM_IN),
										array($DkcplNO_RT, SQLSRV_PARAM_IN),
										array($DkcplNO_RW, SQLSRV_PARAM_IN),
										array($DkcplNO_PROP, SQLSRV_PARAM_IN),
										array($DkcplPROP_NAME, SQLSRV_PARAM_IN),
										array($DkcplNO_KAB, SQLSRV_PARAM_IN),
										array($DkcplKAB_NAME, SQLSRV_PARAM_IN),
										array($DkcplKEC_NAME, SQLSRV_PARAM_IN),
										array($DkcplNO_KEL, SQLSRV_PARAM_IN),
										array($DkcplNO_KEC, SQLSRV_PARAM_IN),
										array($DkcplKEL_NAME, SQLSRV_PARAM_IN),
										array($user, SQLSRV_PARAM_IN),
										array($Is_Similar, SQLSRV_PARAM_IN));
				$execDukcapil = sqlsrv_query( $conn, $callSPDukcapil, $paramsDukcapil) or die( print_r( sqlsrv_errors(), true));
				if($execDukcapil === false){
					echo"<script>alert('Error insert Data Dukcapil');</script>";
				}
			}
		}

		//----# Insert LOG
		$SourceLogDkcpl = "DUKCAPIL";
		$StatusLogDkcpl = "VALID";

		$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?)}";
		$paramsLogDkcpl = array(array($prospect, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
		if($execLogDkcpl === false){
			echo"<script>alert('Error insert log');</script>";
		}
		//----# Insert LOG End		
	}
}
/********** END CEK DUKCAPIL **********/
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Hasil Pengecekan</h4>
				<p class="category">Pengecekan berdasarkan Blacklist Internal, dan Dukcapil</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<b>DATA CONFINS :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom">No</th>
										<th class="th-custom">Nomor Prospek</th>
										<th class="th-custom">Nomor KTP</th>
										<th class="th-custom">Nama Lengkap</th>
										<th class="th-custom">Tanggal Lahir</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom"><?php echo $prospect;?></td>
										<td class="td-custom"><?php echo $no_ktp;?></td>
										<td><?php echo $nama;?></td>
										<td class="td-custom"><?php echo $date;?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<b>DATA DUKCAPIL :</b><br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom">No</th>
										<th class="th-custom">Nomor KTP</th>
										<th class="th-custom">Nama Lengkap</th>
										<th class="th-custom">Tanggal Lahir</th>
										<th class="th-custom">Tempat Lahir</th>
										<th class="th-custom">Jenis Kelamin</th>
										<th class="th-custom">Nama Ibu Kandung</th>
										<th class="th-custom">Alamat</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$callGetDukcapil = "{call SP_DUKCAPIL_GETDATA_RESULT (?,?)}";
										$paramsDukcapil = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
										$options =  array( "Scrollable" => "buffered" );
										$execGetDukcapil = sqlsrv_query($conn, $callGetDukcapil, $paramsDukcapil, $options) or die( print_r( sqlsrv_errors(), true));
										$numrows = sqlsrv_num_rows($execGetDukcapil);
										$no=0;
										if($numrows == 0){
											echo'<tr>
													<td colspan="8" style="text-align:center;">Data tidak ditemukan</td>
												</tr>';
										}else{
											while($rowGetDukcapil = sqlsrv_fetch_array($execGetDukcapil)){
												$no++;
									?>
									<tr>
										<td class="td-custom"><?php echo $no;?></td>
										<td class="td-custom"><?php echo $rowGetDukcapil['NIK'];?></td>
										<td><?php echo $rowGetDukcapil['NAMA'];?></td>
										<td class="td-custom"><?php echo $rowGetDukcapil['BIRTH_DT']->format('Y-m-d');?></td>
										<td class="td-custom"><?php echo $rowGetDukcapil['TEMPAT_LAHIR'];?></td>
										<td class="td-custom"><?php echo $rowGetDukcapil['JENIS_KELAMIN'];?></td>
										<td><?php echo $rowGetDukcapil['MOTHER_MAIDEN_NAME'];?></td>
										<td><?php echo $rowGetDukcapil['ALAMAT'];?></td>
									</tr>
									<?php } }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<b><label style="color:red; font-size: 14px"><?php echo $Warning_Data_Sementara;?></label></b><br>
				<b><label style="color:red; font-size: 14px"><?php echo $Warning_Data;?></label></b>
				<hr>
				<?php
				if($Warning_Data == ""){
				?>
				<div class="row">
					<div class="col-md-12">
						<form action='check-slik.php' method='post'>
							<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
							<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
							<input name='nama' type='hidden' value='<?php echo $nama;?>'>
							<input name='birth_dt' type='hidden' value='<?php echo $date;?>'>
							<input name='cust_type' type='hidden' value='P'>
							<input name='id_type' type='hidden' value='KTP'>
							<input name='username' type='hidden' value='<?php echo $user;?>'>
							<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
							<input name='message' type='hidden' value='<?php echo $Warning_Data_Sementara." ".$Warning_Data;?>'>
							<button type='submit' class='btn btn-danger' style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</div>
						</form>
					</div>
				</div>
				<?php }else{ ?>
					<div class="row">
						<div class="col-md-12">
							<button type='button' class='btn btn-danger' disabled style="width:100%;"><i class="fa fa-search"></i> CEK DI SLIK</button>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>
<?php } ?>