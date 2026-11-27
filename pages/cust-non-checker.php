<style>
.wrapper-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-top: 20px;
}
</style>

<?php
require_once(__DIR__ . "/../config/connection.php");

$user     = isset($_GET['USERNAME']) ? $_GET['USERNAME'] : '';
$prospect = isset($_GET['prospect']) ? $_GET['prospect'] : '';
$ktptemp = isset($_GET['no_ktp']) ? $_GET['no_ktp'] : '';

$row_view = []; // inisialisasi untuk tampilan view bawah

// Jika KTP tidak kosong, ambil data dari CUSTOMER_NON_CHECKER
if (!empty($ktptemp)) {
    // Panggil SP untuk data customer
    $sql = "{CALL SP_CHECK_AVAIL_CUSTOMER_NON_CHECKER(?, ?)}";
    $params = array($prospect, $ktptemp);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt !== false) {
        $row_view = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    // Panggil SP untuk gambar
    $sqlImg = "{CALL SP_GET_IMAGES_CUST_NON_CHECKER(?, ?)}";
    $paramsImg = array($prospect, $ktptemp);
    $stmtImg = sqlsrv_query($conn, $sqlImg, $paramsImg);

    $images = [
        'KTP' => '',
        'KK' => '',
        'DOKUMEN_PENDUKUNG' => ''
    ];

    while ($rowImg = sqlsrv_fetch_array($stmtImg, SQLSRV_FETCH_ASSOC)) {
        $jenis = strtoupper(trim($rowImg['JENIS_DOKUMEN']));
        if (isset($images[$jenis]) && $rowImg['IMG_SRC']) {
            $images[$jenis] = 'data:image/jpeg;base64,' . base64_encode($rowImg['IMG_SRC']);
        }
    }
	
	$sqlGet = "{CALL SP_GET_DATA_LOG_DUKCAPIL(?, ?)}";
    $paramsGet = array(
        array($prospect, SQLSRV_PARAM_IN),
        array($ktptemp, SQLSRV_PARAM_IN)
    );

    $stmtGet = sqlsrv_query($conn, $sqlGet, $paramsGet);

    if ($stmtGet === false) {
        die(print_r(sqlsrv_errors(), true)); // Debug jika ada error
    }

    $rowGet = sqlsrv_fetch_array($stmtGet, SQLSRV_FETCH_ASSOC);
}

$row    = null;
$imgRow = null;

$stmt1    = false;
$success2 = false;
$execLogScore    = false;

if (isset($_POST['save'])) {
    $order_no       = $_POST['order_no'];
    $no_ktp         = $_POST['no_ktp'];
    $nama_penjamin  = $_POST['nama_penjamin'];
    $tempat_lahir   = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $alamat         = $_POST['alamat'];
    $nama_ibu       = $_POST['nama_ibu_kandung'];
    $status_kawin   = $_POST['status_kawin'];

    // CEK DUPLIKASI NOMOR KTP
    $check_sql  = "SELECT COUNT(*) AS jml FROM CUSTOMER_NON_CHECKER WHERE NO_KTP = ?  AND ORDER_NO = ?";
    $params = array($no_ktp, $order_no);
    $check_stmt = sqlsrv_query($conn, $check_sql, $params);
    $rowcheck        = sqlsrv_fetch_array($check_stmt, SQLSRV_FETCH_ASSOC);

        

    if ($rowcheck['jml'] > 0) {
        echo "<script>alert('Nomor KTP sudah ada, tidak bisa input duplikat dengan nomor order yang sama!');</script>";
    } else {
        // INSERT DATA CUSTOMER
       $sql1 = "{CALL SP_INSERT_DATA_CUST_NON_CHECK_DETAIL(?, ?, ?, ?, ?, ?, ?, ?)}";

        $params1 = array(
            array($order_no, SQLSRV_PARAM_IN),
            array($no_ktp, SQLSRV_PARAM_IN),
            array($nama_penjamin, SQLSRV_PARAM_IN),
            array($tempat_lahir, SQLSRV_PARAM_IN),
            array($tanggal_lahir, SQLSRV_PARAM_IN),
            array($alamat, SQLSRV_PARAM_IN),
            array($nama_ibu, SQLSRV_PARAM_IN),
            array($status_kawin, SQLSRV_PARAM_IN)
        );

        $stmt1 = sqlsrv_query($conn, $sql1, $params1);

        if ($stmt1 === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // INSERT IMAGE JIKA ADA
        // Function helper untuk simpan image
        function insertImage($conn, $order_no, $no_ktp, $user, $file_input_name, $jenis_dokumen) {
            if (!empty($_FILES[$file_input_name]['tmp_name'])) {
                $img_data = file_get_contents($_FILES[$file_input_name]['tmp_name']);
                
                // Panggil stored procedure
                $sql = "{CALL SP_INSERT_DATA_IMAGES_CUST_NON_CHECK_DETAIL(?, ?, ?, ?, ?)}";

                $params = array(
                    array($order_no, SQLSRV_PARAM_IN),
                    array($no_ktp, SQLSRV_PARAM_IN),
                    array($img_data, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY), SQLSRV_SQLTYPE_VARBINARY('max')),
                    array($user, SQLSRV_PARAM_IN),
                    array($jenis_dokumen, SQLSRV_PARAM_IN)
                );
                
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt === false) {
                    // Tampilkan error detail kalau gagal
                    die(print_r(sqlsrv_errors(), true));
                }

                return true;
            }
            return false;
        }

        // === Pemanggilan ===

        // KTP (wajib)
        if (empty($_FILES['img_ktp']['tmp_name'])) {
            die("Foto KTP wajib diupload!");
        } else {
            $success2 = insertImage($conn, $order_no, $no_ktp, $user, 'img_ktp', 'KTP') || $success2;
        }

        // KK (wajib)
        if (empty($_FILES['img_kk']['tmp_name'])) {
            die("Foto KK wajib diupload!");
        } else {
            $success2 = insertImage($conn, $order_no, $no_ktp, $user, 'img_kk', 'KK') || $success2;
        }

        // Dokumen pendukung (opsional)
        if (!empty($_FILES['img_dk_pndkg']['tmp_name'])) {
            $success2 = insertImage($conn, $order_no, $no_ktp, $user, 'img_dk_pndkg', 'DOKUMEN_PENDUKUNG') || $success2;
        }

    }

    $NIK= $_POST['no_ktp'];
      $NAMA_LGKP= $_POST['nama_penjamin'];
      $ALAMAT= $_POST['alamat'];
      $STATUS_KAWIN= $_POST['status_kawin'];
      $TMPT_LHR= $_POST['tempat_lahir'];
      $TGL_LHR1= $_POST['tanggal_lahir'];
      $TGL_LHR2 = strtotime($TGL_LHR1);
      $TGL_LHR = date("d-m-Y", $TGL_LHR2);
      $JENIS_KLMIN= "";
      $JENIS_PKRJN= "";
      $NAMA_LGKP_IBU= $_POST['nama_ibu_kandung'];
      // $TGL_LHR= "06-07-1987";
      $KAB_NAME= " ";
      $KEC_NAME= " ";
      $KEL_NAME= " ";
      $PROP_NAME= "";
      $NO_RT= "";
      $NO_RW= "";
      $NO_KK = "";
  

      $TRESHOLD= "90";
      // $USER_ID= "10643174202101271dummy_suzuki_finance";
      // $PASSWORD= "123456";

      $USER_ID= "25082022141010SUZUKI_FINANCE4288";
      $PASSWORD= "MZ33CU";
      $IP_USER= "172.16.2.5";
	
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
      $DkcplNO_KK = "";
				
	if($no_ktp==""){
		echo"<script>alert('Nomor KTP tidak boleh kosong');history.back();</script>";
	}else if($NAMA_LGKP==""){
		echo"<script>alert('Nama tidak boleh kosong');history.back();</script>";
	}else if($TGL_LHR==""){
		echo"<script>alert('Tanggal lahir tidak boleh kosong');history.back();</script>";
	}else if(substr($no_ktp,0,1) == "0"){
		echo"<script>alert('Nomor KTP tidak boleh berawalan 0');history.back();</script>";
	}else if(substr($no_ktp,-4) == "0000"){
		echo"<script>alert('4 Digit Nomor KTP tidak boleh 0000');history.back();</script>";
	}else if(strlen(trim($no_ktp)) <> 16){
		echo"<script>alert('NIK harus 16 digit');history.back();</script>";
	}else if(preg_match("/^[a-zA-Z]$/", $no_ktp)){
		echo"<script>alert('NIK tidak boleh mengandung alphabet');history.back();</script>";
	}else{	
	$param_dukcapil_array= array('NO_KK'=>$NO_KK, 'NIK' => $NIK, 'NAMA_LGKP' => $NAMA_LGKP, 'ALAMAT' => $ALAMAT, 'STATUS_KAWIN' => $STATUS_KAWIN, 'TMPT_LHR' => $TMPT_LHR, 'TGL_LHR' => $TGL_LHR, 
							'KAB_NAME' => $KAB_NAME, 'KEC_NAME' => $KEC_NAME, 'KEL_NAME' => $KEL_NAME, 'PROP_NAME' => $PROP_NAME, 'NO_RT' => $NO_RT, 'JENIS_KLMIN' => $JENIS_KLMIN, 
							'JENIS_PKRJN' => $JENIS_PKRJN, 'NAMA_LGKP_IBU' => $NAMA_LGKP_IBU, 'TRESHOLD' => $TRESHOLD, 'USER_ID' => $USER_ID, 'PASSWORD' => $PASSWORD, 'IP_USER' => $IP_USER);
	$param_dukcapil = json_encode($param_dukcapil_array);
	$curlDkUpil = curl_init();
	curl_setopt_array($curlDkUpil, array(
		//CURLOPT_URL => "http://172.16.160.84:8000/dukcapil/get_json/suzuki_finance/nik_verifby_elemen",
		//CURLOPT_URL => "https://172.16.160.177:8000/dukcapil/get_json/SUZUKI_FINANCE/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_URL => "http://172.16.160.186:8000/dukcapil/get_json/990040921021160/CALL_VERIFY_BY_ELEMEN",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "$param_dukcapil",
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json',
			'Content-Type: application/json',
			"Postman-Token: ae0ace2e-aa92-4d66-8d14-d67edb42fa84",
			"cache-control: no-cache"
		),
	));

	$responseDkUpil = curl_exec($curlDkUpil);
	$errDkUpil = curl_error($curlDkUpil);

	curl_close($curlDkUpil);
	$resultDukcapil = json_decode($responseDkUpil, true);
	$curl = curl_init();

	curl_setopt_array($curl, array(
            //   CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
            CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>array('id_lembaga' => '041148', 
								'nik' => $no_ktp,
								'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
								'param' => '[{"NO_CIF": "' . $order_no . '"}]',

								
      CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
            'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
            ),
	)));

	$response = curl_exec($curl);
	
	curl_close($curl);


	$response_balikan = str_replace('"',"",$response);
		
	$callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
	$paramsLogDkUpilNtValid = array(array($order_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
	$execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	

			

		
	if(empty($resultDukcapil)){
		//----# Insert LOG
			$SourceLogDkUpilNtValid = "DUKCAPIL";
			$StatusLogDkUpilNtValid = "KTP TIDAK VALID";
			echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan NIK ke Dukcapil.!)');history.back();</script>";
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
				$DkcplNO_KK = "";
			//----# Insert LOG End

			//echo "<script>alert('Error : ".$StatusLogDkUpilNtValid." (Pada saat pengecekan No KTP di Dukcapil.!)')</script>";
			//$Warning_Data = $Warning_Data." - KTP TIDAK VALID (Pada saat pengecekan No KTP di Dukcapil.!) ";
		//----# Insert LOG End
	}else{
		if($errDkUpil){
			//----# Insert LOG
			$SourceLogDkUpil = "DUKCAPIL";
			$StatusLogDkUpil = "ERROR";

			$callSPLogDkUpil = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
			$paramsLogDkUpil = array(array($order_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
			$execLogDkUpil = sqlsrv_query( $conn, $callSPLogDkUpil, $paramsLogDkUpil) or die( print_r( sqlsrv_errors(), true));
			if($execLogDkUpil === false){
				echo"<script>alert('Error insert log Dukcapil');</script>";
			}
			//----# Insert LOG End
			echo "<script>alert('Error : ".$errDkUpil." (Pada saat pengecekan No KTP di Dukcapil..!)')</script>";
		}else{
			if(isset($resultDukcapil['content'][0]['RESPONSE'])) {
				//----# Insert LOG
				$SourceLogDkUpilnotfound = "DUKCAPIL";
				$StatusLogDkUpilnotfound = strtoupper($resultDukcapil['content'][0]['RESPONSE']);

				$callSPLogDkUpilnotfound = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkUpilnotfound = array(array($order_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkUpilnotfound = sqlsrv_query( $conn, $callSPLogDkUpilnotfound, $paramsLogDkUpilnotfound) or die( print_r( sqlsrv_errors(), true));
				//----# Insert LOG End
				
				echo "<script>alert('Error : ".$StatusLogDkUpilnotfound." (Pada saat pengecekan No KTP di Dukcapil!)')</script>";
				
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
				$DkcplNO_KK = "";
			}else{
				//----# Insert LOG
				$SourceLogDkcpl = "DUKCAPIL";
				$StatusLogDkcpl = "VALID";

				$callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
				$paramsLogDkcpl = array(array($order_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
				$execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
				//----# Insert LOG End
				
				$callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
				$paramsGetLog = array(array($order_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
				$execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
				$dataGetLog = sqlsrv_fetch_array($execGetLog);
				$idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];	
				
				foreach($resultDukcapil['content'] as $contentdata){
					$DkcplNIK = $contentdata['NIK'];
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
					$DkcplPROP_NAME = $contentdata['PROP_NAME'];
					$DkcplKAB_NAME = $contentdata['KAB_NAME'];
					$DkcplKEC_NAME = $contentdata['KEC_NAME'];
					$DkcplKEL_NAME = $contentdata['KEL_NAME'];
					$DkcplNO_KK = $contentdata['NO_KK'];

                    // $DkcplNIK = $NIK;
					// $DkcplNAMA_LGKP = $NAMA_LGKP;
					// $DkcplJENIS_KLMIN = $JENIS_KLMIN;
					// $DkcplTMPT_LHR = $TMPT_LHR;
					// $DkcplTGL_LHR = $TGL_LHR;
					// $DkcplSTATUS_KAWIN = $STATUS_KAWIN;
					// $DkcplNAMA_LGKP_IBU = $NAMA_LGKP_IBU;
					// $DkcplJENIS_PKRJN = $JENIS_PKRJN;
					// $DkcplALAMAT = $ALAMAT;
					// $DkcplNO_RT = $NO_RT;
					// $DkcplNO_RW = $NO_RW;
					// $DkcplPROP_NAME = $PROP_NAME;
					// $DkcplKAB_NAME = $KAB_NAME;
					// $DkcplKEC_NAME = $KEC_NAME;
					// $DkcplKEL_NAME = $KEL_NAME;
					// $DkcplNO_KK = $NO_KK;
                
					
					$callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL_1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
					$paramsLogScore = array(array($idLog, SQLSRV_PARAM_IN),
											array($order_no, SQLSRV_PARAM_IN),
											array($no_ktp, SQLSRV_PARAM_IN),
											array($user, SQLSRV_PARAM_IN),
											array($NIK, SQLSRV_PARAM_IN),
											array($DkcplNIK, SQLSRV_PARAM_IN),
											array($NAMA_LGKP, SQLSRV_PARAM_IN),
											array($DkcplNAMA_LGKP, SQLSRV_PARAM_IN),
											array($ALAMAT, SQLSRV_PARAM_IN),
											array($DkcplALAMAT, SQLSRV_PARAM_IN),
											array($STATUS_KAWIN, SQLSRV_PARAM_IN),
											array($DkcplSTATUS_KAWIN, SQLSRV_PARAM_IN),
											array($TMPT_LHR, SQLSRV_PARAM_IN),
											array($DkcplTMPT_LHR, SQLSRV_PARAM_IN),
											array($TGL_LHR, SQLSRV_PARAM_IN),
											array($DkcplTGL_LHR, SQLSRV_PARAM_IN),
											array($JENIS_KLMIN, SQLSRV_PARAM_IN),
											array($DkcplJENIS_KLMIN, SQLSRV_PARAM_IN),
											array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN),
											array($DkcplNAMA_LGKP_IBU, SQLSRV_PARAM_IN),
											array($JENIS_PKRJN, SQLSRV_PARAM_IN),
											array($DkcplJENIS_PKRJN, SQLSRV_PARAM_IN),
											array($NO_KK, SQLSRV_PARAM_IN),
											array($DkcplNO_KK, SQLSRV_PARAM_IN),);
					$execLogScore = sqlsrv_query( $conn, $callLogScore, $paramsLogScore) or die( print_r( sqlsrv_errors(), true));
                    
							
				}

						
			}
		}
	}

	}
}
else{
	$NIK= "";
    $NAMA_LGKP= "";
    $ALAMAT= "";
    $STATUS_KAWIN="";
    $TMPT_LHR= "";
	$TGL_LHR1="";
	$TGL_LHR2 = "";
	$TGL_LHR = "";
	$JENIS_KLMIN= "";
    $JENIS_PKRJN= "";
	$NAMA_LGKP_IBU= "";
	$NO_KK =  "";
}	


if ($stmt1 && $success2 && $execLogScore) {
    echo "<script>alert('Data berhasil disimpan ke semua tabel dan scoring');</script>";
} elseif ($stmt1 && $success2) {
    echo "<script>alert('Data berhasil disimpan ke customer & image, tapi gagal insert scoring');</script>";
} elseif ($stmt1) {
    echo "<script>alert('Data berhasil disimpan ke customer, tapi gagal simpan gambar dan scoring');</script>";
} elseif (isset($_POST['save'])) {
    echo "<script>alert('Gagal menyimpan data');</script>";
}

if ($stmt1) {
    // $sqlShow = "SELECT TOP 1 ORDER_NO, NO_KTP, NAMA_PENJAMIN_TAMBAHAN, TEMPAT_LAHIR, 
    //                     CONVERT(VARCHAR(10), TANGGAL_LAHIR, 120) as TANGGAL_LAHIR, 
    //                     ALAMAT, NAMA_IBU_KANDUNG, STATUS_KAWIN
    //             FROM CUSTOMER_NON_CHECKER
    //             WHERE ORDER_NO = ? AND NO_KTP = ?
    //             ORDER BY CREATED_AT DESC";
    // $paramsShow = array($order_no, $no_ktp);
    // $stmtShow   = sqlsrv_query($conn, $sqlShow, $paramsShow);
    // $row        = sqlsrv_fetch_array($stmtShow, SQLSRV_FETCH_ASSOC);

    $sqlShow = "{CALL SP_GET_DATA_LOG_DUKCAPIL(?, ?)}";
    $paramsShow = array(
        array($order_no, SQLSRV_PARAM_IN),
        array($no_ktp, SQLSRV_PARAM_IN)
    );

    $stmtShow = sqlsrv_query($conn, $sqlShow, $paramsShow);

    if ($stmtShow === false) {
        die(print_r(sqlsrv_errors(), true)); // Debug jika ada error
    }

    $row = sqlsrv_fetch_array($stmtShow, SQLSRV_FETCH_ASSOC);


}


if (isset($_POST['cek_slik'])) {
    $prospect   = $_POST['order_no'];
    $no_ktp     = $_POST['no_ktp'];
    $nama       = $_POST['nama_penjamin'];
    $birth_dt   = $_POST['tanggal_lahir'];
    $cust_type  = "P"; 
    $id_type    = "KTP";    
    $username   = $user;    
    $tipe_cust  = "ADDITIONAL"; 

    // 🔹 1. Cek apakah data sudah ada di tabel PEFINDO_MAPPING_NODATA
    $check_sql_slik = "SELECT COUNT(*) AS jmlslik 
                       FROM PEFINDO_MAPPING_NODATA 
                       WHERE ID_NO = ? AND PROSPECT_NO = ?";
    $params_slik = array($no_ktp, $prospect);
    $check_stmt_slik = sqlsrv_query($conn, $check_sql_slik, $params_slik);
    $row_slik = sqlsrv_fetch_array($check_stmt_slik, SQLSRV_FETCH_ASSOC);

    if ($row_slik['jmlslik'] > 0) {
        // 🔸 Jika data sudah ada, tampilkan pesan dan hentikan proses
        echo "<script>alert('Data dengan No KTP dan No Order yang sama sudah ada. Tidak dapat melakukan input ulang.');</script>";
    } else {
        // 🔹 2. Jika belum ada, jalankan SP insert
        $sqlSP = "{CALL SP_INSERT_PEFINDO_NODATA_NEW(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramsSP = array(
            array($prospect, SQLSRV_PARAM_IN),
            array($no_ktp, SQLSRV_PARAM_IN),
            array($nama, SQLSRV_PARAM_IN),
            array($birth_dt, SQLSRV_PARAM_IN),
            array($cust_type, SQLSRV_PARAM_IN),
            array($id_type, SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN),
            array($tipe_cust, SQLSRV_PARAM_IN)
        );

        $stmtSP = sqlsrv_query($conn, $sqlSP, $paramsSP);

        if ($stmtSP) {
            echo "<script>alert('Cek SLIK berhasil dijalankan');</script>";
        } else {
            echo "<script>alert('Gagal menjalankan Cek SLIK');</script>";
        }
    }

    // Opsional: tutup statement untuk efisiensi koneksi
    if (isset($check_stmt_slik)) sqlsrv_free_stmt($check_stmt_slik);
    if (isset($stmtSP)) sqlsrv_free_stmt($stmtSP);
}



?>

<?php if (!empty($row_view)) : ?>

<div class="wrapper-card">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="col-md-6 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">
                                DETAIL PENJAMIN CALON DEBITUR
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor Order</td>
                            <td><?php echo htmlspecialchars($row_view['ORDER_NO']); ?></td>
                        </tr>
                        <tr>
                            <td>Nomor KTP</td>
                            <td><?php echo htmlspecialchars($row_view['NO_KTP']); ?></td>
                        </tr>
                        <tr>
                            <td>Nama Penjamin Tambahan</td>
                            <td><?php echo htmlspecialchars($row_view['NAMA_PENJAMIN_TAMBAHAN']); ?></td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td><?php echo htmlspecialchars($row_view['TEMPAT_LAHIR']); ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>
                                <?php 
                                echo htmlspecialchars(
                                    is_object($row_view['TANGGAL_LAHIR']) 
                                    ? $row_view['TANGGAL_LAHIR']->format('Y-m-d') 
                                    : $row_view['TANGGAL_LAHIR']
                                ); 
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td><?php echo htmlspecialchars($row_view['ALAMAT']); ?></td>
                        </tr>
                        <tr>
                            <td>Nama Ibu Kandung</td>
                            <td><?php echo htmlspecialchars($row_view['NAMA_IBU_KANDUNG']); ?></td>
                        </tr>
                        <tr>
                            <td>Status Kawin</td>
                            <td><?php echo htmlspecialchars($row_view['STATUS_KAWIN']); ?></td>
                        </tr>
                    </table>
                </div> 
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
                        </tr>

                        <!-- FOTO KTP -->
                        <tr>
                            <td>FOTO KTP</td>
                            <td style="text-align:center;">
                                <?php if ($images['KTP']): ?>
                                    <img src="<?php echo $images['KTP']; ?>" alt="Foto KTP" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:red;">Tidak ada foto KTP</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- FOTO KK -->
                        <tr>
                            <td>FOTO KK</td>
                            <td style="text-align:center;">
                                <?php if ($images['KK']): ?>
                                    <img src="<?php echo $images['KK']; ?>" alt="Foto KK" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:red;">Tidak ada foto KK</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- FOTO DOKUMEN PENDUKUNG -->
                        <tr>
                            <td>FOTO DOKUMEN PENDUKUNG</td>
                            <td style="text-align:center;">
                                <?php if ($images['DOKUMEN_PENDUKUNG']): ?>
                                    <img src="<?php echo $images['DOKUMEN_PENDUKUNG']; ?>" alt="Dokumen Pendukung" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:gray;">Tidak ada dokumen pendukung</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tr>
                    

                    </table>
                </div>
            </div>
        </div>
    </div>

    <form method="post" enctype="multipart/form-data">
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 col-sm-12">
                <div class="col-md-6 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="3" style="background-color:#28a745;color:#FFF;font-weight:bold;">
                                    HASIL DATA INPUT DAN DUKCAPIL
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor KTP</td>
                                <td><?php echo htmlspecialchars($row_view['NO_KTP']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['NO_KTP']); ?></td>
                            </tr>
                            <tr>
                                <td>Nama Penjamin Tambahan</td>
                                <td><?php echo htmlspecialchars($row_view['NAMA_PENJAMIN_TAMBAHAN']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['NAMA_PENJAMIN_TAMBAHAN']); ?></td>
                            </tr>

                            <tr>
                                <td>Tempat Lahir</td>
                                <td><?php echo htmlspecialchars($row_view['TEMPAT_LAHIR']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['TEMPAT_LAHIR']); ?></td>
                            </tr>

                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>
                                    <?php 
                                    $tgl_lahir_db = is_object($row_view['TANGGAL_LAHIR']) 
                                        ? $row_view['TANGGAL_LAHIR']->format('Y-m-d') 
                                        : $row_view['TANGGAL_LAHIR'];

                                    echo htmlspecialchars($tgl_lahir_db);
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($rowGet['TANGGAL_LAHIR']); ?></td>
                            </tr>

                            <tr>
                                <td>Alamat</td>
                                <td><?php echo htmlspecialchars($row_view['ALAMAT']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['ALAMAT']); ?></td>
                            </tr>

                            <tr>
                                <td>Nama Ibu Kandung</td>
                                <td><?php echo htmlspecialchars($row_view['NAMA_IBU_KANDUNG']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['NAMA_IBU_KANDUNG']); ?></td>
                            </tr>

                            <tr>
                                <td>Status Kawin</td>
                                <td><?php echo htmlspecialchars($row_view['STATUS_KAWIN']); ?></td>
                                <td><?php echo htmlspecialchars($rowGet['STATUS_KAWIN']); ?></td>
                            </tr>

                        </table>
                    </div>
                </div>

                <!-- Hidden field -->
                <input type="hidden" name="order_no" value="<?php echo htmlspecialchars($row_view['ORDER_NO']); ?>">
                <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($row_view['NO_KTP']); ?>">
                <input type="hidden" name="nama_penjamin" value="<?php echo htmlspecialchars($row_view['NAMA_PENJAMIN_TAMBAHAN']); ?>">
                <input type="hidden" name="tanggal_lahir" value="<?php echo htmlspecialchars($row_view['TANGGAL_LAHIR']); ?>">

                

                <div class="col-md-12" style="margin-top:15px;">
                    <button type="submit" name="cek_slik" class="btn btn-success">Cek SLIK</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php else : ?>


<div class="wrapper-card">
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-md-6 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA TAMBAHAN PENJAMIN CALON DEBITUR</td>
                            </tr>
                            <tr>
                                <td>Nomor Order</td>
                                <td>
                                    <input type="text" name="order_no" id="order_no" value="<?php echo htmlspecialchars($prospect); ?>" class="form-control" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor KTP</td>
                                <td>
                                    <input 
                                        type="text" 
                                        name="no_ktp" 
                                        id="no_ktp" 
                                        class="form-control" 
                                        required
                                        maxlength="16" 
                                        pattern="\d{16}" 
                                        title="Nomor KTP harus terdiri dari 16 digit angka"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);"
                                    >
                                </td>
                            </tr>

                            <tr>
                                <td>Nama Penjamin Tambahan</td>
                                <td>
                                    <input type="text" name="nama_penjamin" id="nama_penjamin" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                                </td>
                            </tr>

                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="tanggal_lahir" id="tanggal_lahir" placeholder="YYYY-MM-DD">
                                        <div class="input-group-addon">
                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Nama Ibu Kandung</td>
                                <td>
                                    <input type="text" name="nama_ibu_kandung" id="nama_ibu_kandung" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Status Kawin</td>
                                <td>    
                                    <select name="status_kawin" class="form-control" required>
                                        <option value="SINGLE">SINGLE</option>
                                        <option value="MENIKAH">MENIKAH</option>
                                        <option value="MENIKAH">CERAI MATI</option>
                                        <option value="MENIKAH">CERAI HIDUP</option>
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
                                <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
                            </tr>
                            <tr>
                                <td>FOTO KTP</td>
                                <td>
                                    <input type="file" name="img_ktp" required style="margin-bottom:5px;" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td>FOTO KK</td>
                                <td>
                                    <input type="file" name="img_kk" required style="margin-bottom:5px;" />
                                </td>
                            </tr>
                            
                            <tr>
                                <td>FOTO DOKUMEN PENDUKUNG LAINNYA </td>
                                <td>
                                    <input type="file" name="img_dk_pndkg" style="margin-bottom:5px;" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top:15px;">
                    <button type="submit" name="save" class="btn btn-success">Cek Validasi Dukcapil</button>
                </div>
            </div>
        </div>
    </form>

    <?php if (!empty($row)) : ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="row" style="margin-top:20px;">
            <div class="col-md-12 col-sm-12">
                <div class="col-md-6 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" style="background-color:#28a745;color:#FFF;font-weight:bold;">
                                    HASIL INPUT (SUDAH TERSIMPAN)
                                </td>
                            </tr>
                            <tr>
                                <td>Nomor KTP</td>
                                <td><?php echo htmlspecialchars($row['NO_KTP']); ?></td>
                            </tr>
                            <tr>
                                <td>Nama Penjamin Tambahan</td>
                                <td><?php echo htmlspecialchars($row['NAMA_PENJAMIN_TAMBAHAN']); ?></td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td><?php echo htmlspecialchars($row['TEMPAT_LAHIR']); ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td><?php echo htmlspecialchars($row['TANGGAL_LAHIR']); ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?php echo htmlspecialchars($row['ALAMAT']); ?></td>
                            </tr>
                            <tr>
                                <td>Nama Ibu Kandung</td>
                                <td><?php echo htmlspecialchars($row['NAMA_IBU_KANDUNG']); ?></td>
                            </tr>
                            <tr>
                                <td>Status Kawin</td>
                                <td><?php echo htmlspecialchars($row['STATUS_KAWIN']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Hidden field untuk dikirim saat klik Cek SLIK -->
                <input type="hidden" name="order_no" value="<?php echo htmlspecialchars($row['ORDER_NO']); ?>">
                <input type="hidden" name="no_ktp" value="<?php echo htmlspecialchars($row['NO_KTP']); ?>">
                <input type="hidden" name="nama_penjamin" value="<?php echo htmlspecialchars($row['NAMA_PENJAMIN_TAMBAHAN']); ?>">
                <input type="hidden" name="tanggal_lahir" value="<?php echo htmlspecialchars($row['TANGGAL_LAHIR']); ?>">

                <div class="col-md-12" style="margin-top:15px;">
                    <button type="submit" name="cek_slik" class="btn btn-success">Cek SLIK</button>
                </div>
            </div>
        </div>
    </form>


    <?php endif; ?>
</div>

<?php endif; ?>

<script>

$(document).ready(function() {
		
		$('#tanggal_lahir').datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: "1950:2025"
		});
	});

</script>