<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script> 
<?php

$req_id = $_GET['REQ_ID'];

$call2 = "{call SP_GET_IMG_DUKCAPIL_STAGING (?)}";
$param2 = array(array($req_id, SQLSRV_PARAM_IN));
$exec2 = sqlsrv_query( $conn, $call2,$param2)  or die( print_r( sqlsrv_errors(), true));
$data2 = sqlsrv_fetch_array($exec2);

$callVdr = "{call SP_GET_DATA_DUKCAPIL_STAGING(?)}";
$paramVdr = array(array($req_id, SQLSRV_PARAM_IN));
$execVdr = sqlsrv_query( $conn, $callVdr,$paramVdr)  or die( print_r( sqlsrv_errors(), true));
$dataVdr = sqlsrv_fetch_array($execVdr);


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

$uploadDir = 'pdf_upload/';


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


if(isset($_POST['submit'])){

  $notes= $_POST['reject_notes'];
		
    //proses pengecekan dukcapil
    $NIK= $_POST['no_ktp'];
    $NAMA_LGKP= $_POST['nama'];
    $ALAMAT= $_POST['alamat'];
    $STATUS_KAWIN= $_POST['status_kawin'];
    $TMPT_LHR= $_POST['tmpt_lahir'];
    $TGL_LHR1= $_POST['tgl_lahir'];
    $TGL_LHR2 = strtotime($TGL_LHR1);
    $TGL_LHR = date("d-m-Y", $TGL_LHR2);
    $JENIS_KLMIN= '';
    $JENIS_PKRJN= '';
    $NAMA_LGKP_IBU= $_POST['nama_ibu'];
    // $TGL_LHR= "06-07-1987";
    $KAB_NAME= " ";
    $KEC_NAME= " ";
    $KEL_NAME= " ";
    $PROP_NAME= "";
    $NO_RT= "";
    $NO_RW= "";
    $NO_KK = $_POST['no_kk'];
    
    
      $TRESHOLD= "90";
      //$USER_ID= "10643174202101271dummy_suzuki_finance";
    $USER_ID= "25082022141010SUZUKI_FINANCE4288";
      //$PASSWORD= "123456";
    $PASSWORD= "MZ33CU";
      $IP_USER= "172.16.2.5";
    
    
    $no_ktp = $_POST['no_ktp'];
    $user = $_GET['USERNAME'];
    
    
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
      $callCheckExistDukcapil = "{call SP_EXIST_CEK_DUKCAPIL_STAGING_MONTH(?,?,?,?)}";
      $paramCheckExistDukcapil = array(array($NIK, SQLSRV_PARAM_IN),
              array($NAMA_LGKP, SQLSRV_PARAM_IN),
              array($TGL_LHR1, SQLSRV_PARAM_IN),
              array($NAMA_LGKP_IBU, SQLSRV_PARAM_IN));
      $execCheckExistDukcapil = sqlsrv_query( $conn, $callCheckExistDukcapil, $paramCheckExistDukcapil) or die( print_r( sqlsrv_errors(), true));
      $dataCheckExistDukcapil = sqlsrv_fetch_array($execCheckExistDukcapil);

      $call = "{call SP_APPROVAL_DUKCAPIL_STAGING(?,?,?,?)}";
      $param = array(	array($req_id, SQLSRV_PARAM_IN),
              array($_GET['USERNAME'], SQLSRV_PARAM_IN),
              array('APPROVE', SQLSRV_PARAM_IN),
              array($notes, SQLSRV_PARAM_IN));
        //       				echo '<pre>' . var_export($param,true) .'<pre>'; 
        // exit();
      $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 

      
      if(!empty($dataCheckExistDukcapil)){
        $raw = [];
        while($dataCheckExistDukcapil = sqlsrv_fetch_array($execCheckExistDukcapil)){
          $raw[$dataCheckExistDukcapil['JENIS_DATA']] = $dataCheckExistDukcapil['DATA_DITERIMA'];
        }

        $resultDukcapil['content'] = [
            [
                'NIK' => isset($raw['NIK']) ? $raw['NIK'] : '',
                'NAMA_LGKP' =>isset($raw['NAMA_LENGKAP']) ? $raw['NAMA_LENGKAP'] : '',
                'JENIS_KLMIN' => isset($raw['JENIS_KLMIN']) ? $raw['JENIS_KLMIN'] : '',
                'TMPT_LHR' => isset($raw['TMPT_LHR'] ) ? $raw['TMPT_LHR'] : '',
                'TGL_LHR' => isset($raw['TGL_LHR']) ? $raw['TGL_LHR'] : '',
                'STATUS_KAWIN' => isset($raw['STATUS_KAWIN']) ? $raw['STATUS_KAWIN'] : '',
                'NAMA_LGKP_IBU' => isset($raw['NAMA_LGKP_IBU']) ? $raw['NAMA_LGKP_IBU'] : '',
                'JENIS_PKRJN' => isset($raw['JENIS_PKRJN']) ? $raw['JENIS_PKRJN'] : '',
                'ALAMAT' => isset($raw['ALAMAT']) ? $raw['ALAMAT'] : '',
                'NO_RT' => '',
                'NO_RW' => '',
                'PROP_NAME' => '',
                'KAB_NAME' => '',
                'KEC_NAME' => '',
                'KEL_NAME' => '',
                'NO_KK' => isset($raw['NO_KK']) ? $raw['NO_KK'] : ''
            ]
        ];
        
      }else{
        //apidukcapil
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
        
        // $resultDukcapil['content'] = [
            // [
                // 'NIK' => 'Sesuai',
                // 'NAMA_LGKP' => 'Sesuai (100)',
                // 'JENIS_KLMIN' => 'Sesuai',
                // 'TMPT_LHR' => 'Sesuai',
                // 'TGL_LHR' => 'Sesuai',
                // 'STATUS_KAWIN' => 'Sesuai',
                // 'NAMA_LGKP_IBU' => 'Sesuai (100)',
                // 'JENIS_PKRJN' => 'Sesuai',
                // 'ALAMAT' => 'Sesuai (91)',
                // 'NO_RT' => '',
                // 'NO_RW' => '',
                // 'PROP_NAME' => '',
                // 'KAB_NAME' => '',
                // 'KEC_NAME' => '',
                // 'KEL_NAME' => '',
                // 'NO_KK' => 'Sesuai'
            // ]
        // ];
      }
      
              
      // $curl = curl_init();

      // curl_setopt_array($curl, array(
      //   CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
      //  // CURLOPT_URL => 'http://172.16.160.189/data_balikan/public/Api/Nik_store',
      //   CURLOPT_RETURNTRANSFER => true,
      //   CURLOPT_ENCODING => '',
      //   CURLOPT_MAXREDIRS => 10,
      //   CURLOPT_TIMEOUT => 0,
      //   CURLOPT_FOLLOWLOCATION => true,
      //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      //   CURLOPT_CUSTOMREQUEST => 'POST',
      //   CURLOPT_POSTFIELDS =>array('id_lembaga' => '041148', 
      // 							'nik' => $no_ktp,
      // 							'nama_lembaga' => 'PT. SUZUKI FINANCE INDONESIA', 
      // 							//'param' => '[{"id_lembaga": "041148","NIK": "'.$no_ktp.'" ,"indexno": "0"},{ "id_lembaga": "041148","NO_ORDER":  "MANUAL","indexno": "1"}]'),
      // 							'param' => '[{"NO_CIF":  "MANUAL"}]'),
                    
      //   CURLOPT_HTTPHEADER => array(
      // 	'Authorization: Bearer nkqAt2em3pjIc9bR4xJJMNG8PT7yqVFLlu2RpfJNHHLPRNb70eZLnSf5A1cG8HcX5hrXpF4Av8A3C8YqVNxzdpuBZ4VZgvDmoAgB',
      // 	'Cookie: adminduk_session=eyJpdiI6ImZvSkY1SG1SeXJOa01xcHpGUUhkN0E9PSIsInZhbHVlIjoidDhsbjBrbEdSQ015NE8rS29OcDRzd0YybW9CbTJacmI4ZG5UZno3XC81R2lnOTllbFBXRklSSnFhcjVOZG9zcGVYVmlqTXBrZ0ZYZjZEWHZCV0p4akxBPT0iLCJtYWMiOiI5OWNkZDMxZWM1OGI5MzU2NmE4NDhkNGM0NTQzOWZiNWMxZDM3ZWZiZGUxM2I1NTkzOTE0MTIwMzY1ZDhhY2QyIn0%3D'
      //   ),
      // ));

      // $response = curl_exec($curl);
      
      // curl_close($curl);


      // $response_balikan = str_replace('"',"",$response);
        
      // $callSPLogDkUpilNtValid = "{call SP_INSERT_LOG_DATA_BALIKAN(?,?,?,?)}";
      // $paramsLogDkUpilNtValid = array(array($req_id, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN), array($response_balikan, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
      // $execLogDkUpilNtValid = sqlsrv_query( $conn, $callSPLogDkUpilNtValid, $paramsLogDkUpilNtValid) or die( print_r( sqlsrv_errors(), true));	

        

      
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
          $paramsLogDkUpil = array(array($req_id, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpil, SQLSRV_PARAM_IN),array($StatusLogDkUpil, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
            $paramsLogDkUpilnotfound = array(array($req_id, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkUpilnotfound, SQLSRV_PARAM_IN),array($StatusLogDkUpilnotfound, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
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
            // $SourceLogDkcpl = "DUKCAPIL";
            // $StatusLogDkcpl = "VALID";

            foreach ($resultDukcapil['content'] as $contentdata) {
              $DkcplCustType = "PEMOHON";
              $DkcplNIK = $contentdata['NIK'];
              $DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
              $DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
              $DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
              $DkcplTGL_LHR = $contentdata['TGL_LHR'];
              //$DkcplTGL_LHR = $contentdata['TGL_LHR'];
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

              if (
                $DkcplNAMA_LGKP != "Sesuai (100)" && $DkcplNAMA_LGKP != "Sesuai (99)" && $DkcplNAMA_LGKP != "Sesuai (98)" && $DkcplNAMA_LGKP != "Sesuai (97)"
                && $DkcplNAMA_LGKP != "Sesuai (96)" && $DkcplNAMA_LGKP != "Sesuai (95)" && $DkcplNAMA_LGKP != "Sesuai (94)"
                && $DkcplNAMA_LGKP != "Sesuai (93)" && $DkcplNAMA_LGKP != "Sesuai (92)" && $DkcplNAMA_LGKP != "Sesuai (91)"
                && $DkcplNAMA_LGKP != "Sesuai (90)"
              ) {
                $StatusLogDkcpl1 = "DATA DITEMUKAN TIDAK SESUAI";
              } else {
                $StatusLogDkcpl1 = "VALID";
              }

              if ($DkcplTGL_LHR == "Tidak Sesuai") {
                $StatusLogDkcpl2 = "DATA DITEMUKAN TIDAK SESUAI";
              } else {
                $StatusLogDkcpl2 = "VALID";
              }


              if ($checkStatNikah > 0) {
                $StatusLogDkcpl3 = "VALID";
              } else {
                if ($DkcplSTATUS_KAWIN == "Tidak Sesuai") {
                  $StatusLogDkcpl3 = "DATA DITEMUKAN TIDAK SESUAI";
                } else {
                  $StatusLogDkcpl3 = "VALID";
                }
              }

              /*	 	
            if(strtoupper($siapanih) == "PEMOHON"){ */
              if (
                $DkcplNAMA_LGKP_IBU != "Sesuai (100)"  && $DkcplNAMA_LGKP_IBU != "Sesuai (99)" && $DkcplNAMA_LGKP_IBU != "Sesuai (98)" && $DkcplNAMA_LGKP_IBU != "Sesuai (97)"
                && $DkcplNAMA_LGKP_IBU != "Sesuai (96)" && $DkcplNAMA_LGKP_IBU != "Sesuai (95)" && $DkcplNAMA_LGKP_IBU != "Sesuai (94)"
                && $DkcplNAMA_LGKP_IBU != "Sesuai (93)" && $DkcplNAMA_LGKP_IBU != "Sesuai (92)" && $DkcplNAMA_LGKP_IBU != "Sesuai (91)"
                && $DkcplNAMA_LGKP_IBU != "Sesuai (90)"
              ) {
                $StatusLogDkcpl4 = "DATA DITEMUKAN TIDAK SESUAI";
              } else {
                $StatusLogDkcpl4 = "VALID";
              }

              /*				
              }else{
                    $StatusLogDkcpl4 = "VALID";
                  } */
            }


            $SourceLogDkcpl = "DUKCAPIL";

            if ($StatusLogDkcpl1 == "VALID" && $StatusLogDkcpl2 == "VALID" && $StatusLogDkcpl3 == "VALID" && $StatusLogDkcpl4 == "VALID") {
              $StatusLogDkcpl = "VALID";
            } else {
              $StatusLogDkcpl = "DATA DITEMUKAN TIDAK SESUAI";
            }

            $callSPLogDkcpl = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
            $paramsLogDkcpl = array(array($req_id, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogDkcpl, SQLSRV_PARAM_IN),array($StatusLogDkcpl, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
            $execLogDkcpl = sqlsrv_query( $conn, $callSPLogDkcpl, $paramsLogDkcpl) or die( print_r( sqlsrv_errors(), true));
            //----# Insert LOG End
            
            $callGetLog = "{call SP_GET_LOG_ID_DUKCAPIL(?,?)}";
            $paramsGetLog = array(array($req_id, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN));
            $execGetLog = sqlsrv_query( $conn, $callGetLog, $paramsGetLog) or die( print_r( sqlsrv_errors(), true));
            $dataGetLog = sqlsrv_fetch_array($execGetLog);
            $idLog = $dataGetLog['LOG_CHECK_BYSOURCE_ID'];	
            
            foreach($resultDukcapil['content'] as $contentdata){
              $DkcplNIK = $contentdata['NIK'];
              $DkcplNAMA_LGKP = $contentdata['NAMA_LGKP'];
              $DkcplJENIS_KLMIN = $contentdata['JENIS_KLMIN'];
              $DkcplTMPT_LHR = $contentdata['TMPT_LHR'];
              $DkcplTGL_LHR = $contentdata['TGL_LHR'];
              //$DkcplTGL_LHR = $contentdata['TGL_LHR'];
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
              
              $callLogScore = "{call SP_INSERT_LOG_SCORING_DUKCAPIL_1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
              $paramsLogScore = array(array($idLog, SQLSRV_PARAM_IN),
                          array($req_id, SQLSRV_PARAM_IN),
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
      echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$user."&page=tasklist-cek-dukcapil'</script>";

    }
			
    if($exec){
			
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}
if(isset($_POST['submitNo'])){

  $notes= $_POST['reject_notes'];


		$call = "{call SP_APPROVAL_DUKCAPIL_STAGING(?,?,?,?)}";
		$param = array(	array($req_id, SQLSRV_PARAM_IN),
						array($_GET['USERNAME'], SQLSRV_PARAM_IN),
            array('REJECT', SQLSRV_PARAM_IN),
            array($notes, SQLSRV_PARAM_IN));
         
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
		
		if($exec){
			//update status jadi on progress
			

			echo"<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$user."&page=tasklist-cek-dukcapil'</script>";
		}else{
			echo"<script>alert('Data Gagal Disimpan');history.back();</script>";
		}
	}


?>
<style>
.img-custom{
	width:100%;
	height:200px;
}
</style>
<!--<form action="" method="post">-->

<form action="" method="post" enctype="multipart/form-data" onsubmit="return confirmSubmit(event)">
	<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
	 
	<div class="row">
		<div class="col-md-12">
			<div class="card">
          <div class="header">
                <h4 class="title">Detail Informasi</h4>
                <p class="category">Informasi Detail UntukPengajuan Cek Dukcapil</p>
            </div>
				<div class="content">
					<div class="row">
                    <div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DATA PENGAJUAN DUKCAPIL</td>
									</tr>
									<tr>
										<td>Nomor Regist</td>
										<td>:</td>
										<td><?php echo strtoupper($no_regist);?></td>
									</tr>
									<tr>
										<td>Nomor Identitas (KTP)</td>
										<td>:</td>
										<td><?php echo strtoupper($nik);?></td>
									</tr>
                  <tr>
										<td>Nomor KK</td>
										<td>:</td>
										<td><?php echo strtoupper($kk);?></td>
									</tr>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td><?php echo strtoupper($nama);?></td>
									</tr>
									<tr>
										<td>Tempat,Tanggal Lahir</td>
										<td>:</td>
										<td><?php echo strtoupper($tempat_lahir) .', ',strtoupper($birth_date);?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo strtoupper($alamat);?></td>
									</tr>
									<tr>
										<td>Nama Ibu Kandung</td>
										<td>:</td>
										<td><?php echo strtoupper($mother_name);?></td>
									</tr>
									<tr>
										<td>Status Kawin</td>
										<td>:</td>
										<td><?php echo strtoupper($status_kawin);?></td>
									</tr>
                  <tr>
										<td>Tujuan</td>
										<td>:</td>
										<td><?php echo strtoupper($tujuan);?></td>
									</tr>
								</table>
							</div>
              <h4><b>REJECT NOTES</b></h4>
              <textarea name='reject_notes' id="reject_notes" style="width: 500px;height: 100px;" ></textarea>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;font-weight:bold;">DOKUMEN PELAPOR</td>
									</tr>
									<tr>
										<td>KTP</td>
										<td>:</td>
										<td>
                    <?php if($data2['FOTO_KTP'] <> NULL && $data2['PDF_KTP'] == NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KTP']);?>" width="100%" class="img-custom">
												</a>
					<?php }else if($data2['PDF_KTP'] <> NULL){?>
											<a href="view-pdf-cek-dukcapil.php?REQ_ID=<?=$req_id?>&pdf=FOTO_KTP"
                        class="btn btn-custom btn-xs"
                        target="_blank">
                          <i class="fa fa-file"></i> PDF VIEW
                      </a>
											 
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<td>KARTU KELUARGA</td>
										<td>:</td>
										<td>
										<?php if($data2['FOTO_KK'] <> NULL && $data2['PDF_KK'] == NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_KK']);?>" width="100%" class="img-custom">
												</a>
											<?php }else if($data2['PDF_KK'] <> NULL){?>
											<a href="view-pdf-cek-dukcapil.php?REQ_ID=<?=$req_id?>&pdf=FOTO_KK"
                        class="btn btn-custom btn-xs"
                        target="_blank">
                          <i class="fa fa-file"></i> PDF VIEW
                      </a>
											<?php }else{ ?>
												<a href="assets/img/default.jpg" data-lightbox="property">
													<img src="assets/img/default.jpg" width="100%" class="img-custom">
												</a>
											<?php } ?>
										</td>
									</tr>
                  <tr>
										<td>DATA TAMBAHAN</td>
										<td>:</td>
										<td>
									<?php if($data2['FOTO_DT'] <> NULL && $data2['PDF_DT'] == NULL){?>
												<a href="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_DT']);?>" data-lightbox="property">
													<img src="data:image/jpeg;base64,<?php echo base64_encode($data2['FOTO_DT']);?>" width="100%" class="img-custom">
												</a>
							<?php }else if($data2['PDF_DT'] <> NULL){?>
											<a href="view-pdf-cek-dukcapil.php?REQ_ID=<?=$req_id?>&pdf=FOTO_DT"
                        class="btn btn-custom btn-xs"
                        target="_blank">
                          <i class="fa fa-file"></i> PDF VIEW
                      </a>
											 
											<?php }else{?>
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
        <hr>
          
        <div class="row">
          <center>
								
								<?php if($dataVdr['APPROVAL_STATUS']=='OPEN'){?>
                  <input type="text" name="no_ktp" id="no_ktp" autocomplete="off" value="<?php echo $nik;?>" hidden>
                  <input type="text" name="nama" id="nama" autocomplete="off" value="<?php echo $nama;?>" hidden>
                  <input type="text" name="alamat" id="alamat" autocomplete="off" value="<?php echo $alamat;?>" hidden>
                  <input type="text" name="status_kawin" id="status_kawin" autocomplete="off" value="<?php echo $status_kawin;?>" hidden>
                  <input type="text" name="tmpt_lahir" id="tmpt_lahir" autocomplete="off" value="<?php echo $tempat_lahir;?>" hidden>
                  <input type="text" name="tgl_lahir" id="tgl_lahir" autocomplete="off" value="<?php echo $birth_date;?>" hidden>
                  <input type="text" name="nama_ibu" id="nama_ibu" autocomplete="off" value="<?php echo $mother_name;?>" hidden>
                  <input type="text" name="no_kk" id="no_kk" autocomplete="off" value="<?php echo $kk;?>" hidden>

									<input type="submit" name="submit" class="btn btn-custom" value="APPROVE" style="width:200px;">
									<input type="submit" name="submitNo" class="btn btn-custom" value="REJECT" style="width:200px;">
                <?php }else{?>
                  <input type="submit" name="submit" class="btn btn-custom" value="APPROVE" style="width:200px;" disabled>
									<input type="submit" name="submitNo" class="btn btn-custom" value="REJECT" style="width:200px;" disabled>

                <?php }?>
									
								</form>
							</center>
        </div>
			</div>
		</div>
	</div>
  <!-- <div class="card">
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-sm-12">
						<div class="table-responsive">
                           <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:10px;">
                               <thead>
                                   <tr>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">NO</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">APPROVAL NO</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">LEVEL</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">JABATAN</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">USERNAME</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">STATUS</th>
                                       <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">NOTES</th>
									   <th class="th-custom" style="color:#FFF;background-color:#035c7a;font-weight:bold;">TANGGAL APPROVE</th>
                                    
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
                                       $callLoa = "{call  SP_APPROVAL_GETLIST_LOA_SLIK_DEALER(?)}";
                                       $paramLoa = array(array($req_id, SQLSRV_PARAM_IN));
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
</DIV>	 -->
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
<script>
function confirmSubmit(e) {
    var notes = document.getElementById('reject_notes').value.trim();
    const btn = e.submitter;


    if(btn.value === 'REJECT'){
      if (notes === '') {
          alert('Notes cannot be empty');
          return false;
      }
      return confirm('Data ini akan di Reject');
    }else{
       return confirm('Data ini akan dikirimkan ke dukcapil, pastikan data sudah benar');
    }
    
   
}
</script>
<script>
function onlyNumber(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
return true;
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

