<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$no=$_GET['prospect_no'];
$nik=$_GET['no_ktp'];
$id=$_GET['id'];
$userlogin=$_GET['USERNAME'];
$prospect=$_GET['prospect_no'];
$no_ktp=$_GET['no_ktp'];
$nama=$_GET['name'];
$date=$_GET['date'];
$date1=$_GET['date1'];
$birth_place=$_GET['birth_place'];
$siapanih1=$_GET['tipe_cust'];
$branch_id = $_GET['branch_id'];
$tipe_debitur = $_GET['tipe_debitur'];
$tujuan = $_GET['tujuan'];
$date = $_GET['date'];

$mapping_id = $_GET['id'];
$prospect_no = $_GET['prospect_no'];



$userlogin=$_GET['USERNAME'];
	$getUsername=$_GET['USERNAME'];
	$startDate=date("Y-m-d H:i:s");
	$inquiryDate=date("Y-m-d");
	$branch_id = $_GET['branch_id'];

	
$call1 = "{call SP_CHECK_STATUS_SLIK(?)}";
$param1 = array(array($id, SQLSRV_PARAM_IN));
$exec1 = sqlsrv_query( $conn, $call1, $param1) or die( print_r( sqlsrv_errors(), true));
$data1 = sqlsrv_fetch_array($exec1);

if($data1['SUB_PARAM_ID'] == 2 || $data1['SUB_PARAM_ID'] == 7 || $data1['SUB_PARAM_ID'] == 9 || $data1['SUB_PARAM_ID'] == 4 ){
	//jika sudah done maka tidak diupdate ke on progress
}
else{
	//jika selain done maka bisa diupdate ke on progress
	$call2 = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
	$param2 = array(array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN),
					array('6', SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true)); 
	
}



if (strpos($no, 'PRS') !== false) {
	$securityDeposit = "0";
	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
	$paramBranch = array(array($prospect, SQLSRV_PARAM_IN),array('PROSPECT_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	
	//echo "true";
    $call = "{call PEFINDO_GETDATA_PASANGAN_1(?)}";
	$param = array(array($no, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	
	$call4 = "{call  SP_GET_IMG_SPK(?)}";
	$param4 = array(array($nik, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query( $conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true)); 
	$data4 = sqlsrv_fetch_array($exec4);
	
	$callNikah = "{call  SP_GET_IMAGES_STATUS_NIKAH(?,?)}";
	$paramNikah = array(array($prospect, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execNikah = sqlsrv_query( $conn, $callNikah, $paramNikah) or die( print_r( sqlsrv_errors(), true)); 
	$dataNikah = sqlsrv_fetch_array($execNikah);
	
	$callKk = "{call  SP_GET_IMAGES_KK_PASANGAN(?,?)}";
	$paramKk = array(array($prospect, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execKk = sqlsrv_query( $conn, $callKk, $paramKk) or die( print_r( sqlsrv_errors(), true)); 
	$dataKk = sqlsrv_fetch_array($execKk);
	
	$callJk = "{call  PEFINDO_GET_DATA_JENIS_KELAMIN(?)}";
	$paramJk = array(array($prospect, SQLSRV_PARAM_IN));
	$execJk = sqlsrv_query( $conn, $callJk, $paramJk) or die( print_r( sqlsrv_errors(), true)); 
	$dataJk = sqlsrv_fetch_array($execJk);
	
	$jkPemohon = $dataJk['JK'];
	$jkPasangan = $dataJk['JK_PASANGAN'];
	$jkPenjamin = $dataJk['JK_PENJAMIN'];
	
	

/*
	if($data['Pasangan_Noktp'] == "" || $data['Pasangan_Noktp'] == NULL){
		$siapanih = "Penjamin";
		$ktpsaya = $data['Penjamin_Noktp'];
		$namasaya = $data['Penjamin_Nama'];
		if($data['Penjamin_TglLahir']<>NULL){$tgllahirsaya = $data['Penjamin_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data['Penjamin_TglLahir'];
		$tempatlahirsaya = $data['Penjamin_TempatLahir'];
		$namaibusaya = $data['Penjamin_Ibu'];
		$alamatsaya = $data['Penjamin_Alamat'];
	}else{
		$siapanih = "Pasangan";
		$ktpsaya = $data['Pasangan_Noktp'];
		$namasaya = $data['Pasangan_Nama'];
		if($data['Pasangan_TglLahir']<>NULL){$tgllahirsaya = $data['Pasangan_TglLahir']->format("d F Y");}else{$tgllahirsaya="";}
		$tgllahirsaya1=$data['Pasangan_TglLahir'];
		$tempatlahirsaya = $data['Pasangan_TempatLahir'];
		$namaibusaya = $data['Pasangan_Ibu'];
		$alamatsaya = $data['Pasangan_Alamat'];
	}
	*/
}else{
	//echo "false";
	if($dataBranch['OFFICE_CODE']=="1025" || $dataBranch['OFFICE_CODE']=="1535" ){
	$securityDeposit = "1";
	}else{
		$securityDeposit = "0";
	}
	
	$callBranch = "{call SP_GET_BRANCH_STATUS_PROSPECT(?,?)}";
	$paramBranch = array(array($prospect, SQLSRV_PARAM_IN),array('ORDER_NO', SQLSRV_PARAM_IN));
	$execBranch = sqlsrv_query( $conn, $callBranch, $paramBranch) or die( print_r( sqlsrv_errors(), true));
	$dataBranch = sqlsrv_fetch_array($execBranch);
	
	$call = "{call PEFINDO_GETDATA_PASANGAN_BY_ORDER_NO_1(?)}";
	$param = array(array($no, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);
	
	$callNikah = "{call  SP_GET_IMAGES_STATUS_NIKAH(?,?)}";
	$paramNikah = array(array($prospect, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execNikah = sqlsrv_query( $conn, $callNikah, $paramNikah) or die( print_r( sqlsrv_errors(), true)); 
	$dataNikah = sqlsrv_fetch_array($execNikah);
	
	$callKk = "{call  SP_GET_IMAGES_KK_PASANGAN(?,?)}";
	$paramKk = array(array($prospect, SQLSRV_PARAM_IN),
						array($nik, SQLSRV_PARAM_IN));
	$execKk = sqlsrv_query( $conn, $callKk, $paramKk) or die( print_r( sqlsrv_errors(), true)); 
	$dataKk = sqlsrv_fetch_array($execKk);

	
	$siapanih = $data['TYPE'];
	$ktpsaya = $data['NIK_PASANGAN_PENJAMIN'];
	$namasaya = $data['NAMA_PASANGAN_PENJAMIN'];
	if($data['TTL_PASANGAN_PENJAMIN']<>NULL){$tgllahirsaya = $data['TTL_PASANGAN_PENJAMIN']->format("d F Y");}else{$tgllahirsaya="";}
	$tempatlahirsaya = "";
	$namaibusaya = $data['NAMA_IBU_PASANGAN_PNJMN'];
	$alamatsaya = $data['ALAMAT_PSGN_PNJMN'];
	
	$jkPemohon = '-';
	$jkPasangan = '-';
	$jkPenjamin = '-';
}



if($siapanih1 == 'PEMOHON'){
		$siapanih3 = '1';
		$jenis_kelamin = $jkPemohon;
	}else if ($siapanih1 == 'PASANGAN'){
		$siapanih3 = '2';
		$jenis_kelamin = $jkPasangan;
	}else if ($siapanih1 == 'PENJAMIN'){
		$siapanih3 = '3';
		$jenis_kelamin = $jkPenjamin;
	}else{
		$siapanih3 = '0';
		$jenis_kelamin = '-';
	}

$call3 = "{call SP_GET_PERFORMANCE_ACTIVITY(?)}";
$param3 = array(array($id, SQLSRV_PARAM_IN));
$option3 = array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query($conn, $call3, $param3, $option3) or die( print_r( sqlsrv_errors(), true));
$numrows3 = sqlsrv_num_rows($exec3);


	$call4 = "{call SP_INSERT_PERFORMANCE_ACTIVITY(?,?,?,?)}";
	$param4 = array(array($id, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($startDate, SQLSRV_PARAM_IN),array(NULL, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query($conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));
$kategori = $dataBranch['KATEGORI'];

	
	$callNoIdeb = "{call SP_GENERATE_DEBSLIK_INSERT_DEBITUR_H2H(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
	$paramNoIdeb = array(array($siapanih3, SQLSRV_PARAM_IN),
						 array($kategori, SQLSRV_PARAM_IN),
						 array($branch_id, SQLSRV_PARAM_IN),
						 array('PERSONAL', SQLSRV_PARAM_IN),
						 array($inquiryDate, SQLSRV_PARAM_IN),
						 array($nama, SQLSRV_PARAM_IN),
						 array('01', SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),	 
					     array($nik, SQLSRV_PARAM_IN),
						 array('', SQLSRV_PARAM_IN),
						 array($userlogin, SQLSRV_PARAM_IN),
						 array('1', SQLSRV_PARAM_IN));
	
	$execNoIdeb = sqlsrv_query( $conn, $callNoIdeb, $paramNoIdeb) or die( print_r( sqlsrv_errors(), true));
	//$dataBranch = sqlsrv_fetch_array($execBranch);
	
		
	$callGenerate = "{call SP_GENERATE_SLIK_GETDATA_DEBITUR(?,?)}";
	$paramGenerate = array(array($prospect, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN));
	$execGenerate = sqlsrv_query( $conn, $callGenerate, $paramGenerate) or die( print_r( sqlsrv_errors(), true));
	$dataGenerate = sqlsrv_fetch_array($execGenerate);
	
if (isset($_POST['submit'])) {
    $notfound = $_POST['notFound2'];

	if($notfound == ''){
		
		
	$callSave = "{call SP_INSERT_LIST_REQUEST_SLIK_ROBOT(?,?,?,?,?,?,?,?,?,?)}";
	$paramSave = array(array($id, SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN),
						 array($dataGenerate['IDEB_NO'], SQLSRV_PARAM_IN),
						 array($nama, SQLSRV_PARAM_IN),
						 array($date1, SQLSRV_PARAM_IN),
						 array($siapanih1, SQLSRV_PARAM_IN),
						 array($tipe_debitur, SQLSRV_PARAM_IN),
						 array($userlogin, SQLSRV_PARAM_IN),
						 array('OPEN', SQLSRV_PARAM_IN));
	//var_dump($paramSave);
	//echo '<pre>' . var_export($paramSave, true) . '</pre>';
	//exit();

	$execSave = sqlsrv_query( $conn, $callSave, $paramSave) or die( print_r( sqlsrv_errors(), true));
	
	if($execSave){
			//update kapan dia selesai ngerjain tasklist
			echo"<script>window.location='index.php?USERNAME=".$user."&page=tasklist-robot-slik-detail&prospect=".$prospect."&nik=".$nik."';</script>";
		}else{
			echo"<script>alert('Error, hubungi administrator');history.back();</script>";
		}
	
	}else{
		
	
	$callInsert3 = "{call SP_INSERT_SLIK_RESULT(?,?,?,?,?,?,?,?,?,?,?)}";
		$paramInsert3 = array(
							array($mapping_id, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(NULL, SQLSRV_PARAM_IN),
							array(2, SQLSRV_PARAM_IN));
		$execInsert3 = sqlsrv_query($conn, $callInsert3, $paramInsert3) or die( print_r( sqlsrv_errors(), true));
		
	

		//echo "File Berhasil di Upload  file ". basename( $_FILES['file']['name']). " is uploaded";
		//insert PDF
		$callInsert = "{call SP_INSERT_PDF_SLIK(?,?,?,?,?)}";
		$paramInsert = array(array($mapping_id, SQLSRV_PARAM_IN),
						array($prospect_no, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array('Tidak Ditemukan', SQLSRV_PARAM_IN),
						array($user, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));
	
	
		//----# Insert LOG
		$SourceLogSLIKNtfnd = "SLIK";
		$StatusLogSLIKNtfnd = "DATA DITEMUKAN";

		$callSPLogSLIKNtfnd = "{call SP_INSERT_LOG_BYSOURCE(?,?,?,?,?)}";
		$paramsLogSLIKNtfnd = array(array($prospect_no, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($SourceLogSLIKNtfnd, SQLSRV_PARAM_IN),array($StatusLogSLIKNtfnd, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
		$execLogSLIKNtfnd = sqlsrv_query( $conn, $callSPLogSLIKNtfnd, $paramsLogSLIKNtfnd) or die( print_r( sqlsrv_errors(), true));
		//----# Insert LOG End
		
		//update progress ke status DONE
		$call = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
		$param = array(array($prospect_no, SQLSRV_PARAM_IN),
						array($no_ktp, SQLSRV_PARAM_IN),
						array('7', SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
		
		$callSave = "{call SP_INSERT_LIST_REQUEST_SLIK_ROBOT(?,?,?,?,?,?,?,?,?,?)}";
	$paramSave = array(array($id, SQLSRV_PARAM_IN),
						 array($prospect, SQLSRV_PARAM_IN),
						 array($nik, SQLSRV_PARAM_IN),
						 array($dataGenerate['IDEB_NO'], SQLSRV_PARAM_IN),
						 array($nama, SQLSRV_PARAM_IN),
						 array($date, SQLSRV_PARAM_IN),
						 array($siapanih1, SQLSRV_PARAM_IN),
						 array($tipe_debitur, SQLSRV_PARAM_IN),
						 array($userlogin, SQLSRV_PARAM_IN),
						 array('FINISH', SQLSRV_PARAM_IN));
	
		if($exec){
			//update kapan dia selesai ngerjain tasklist
			$call2 = "{call SP_UPDATE_PERFORMANCE_ACTIVITY(?)}";
			$param2 = array(array($mapping_id, SQLSRV_PARAM_IN));
			$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_errors(), true));

			echo"<script>window.location='index.php?USERNAME=".$user."&page=tasklist-ideb';</script>";
		}else{
			echo"<script>alert('Error, hubungi administrator');history.back();</script>";
		}
	

	
}
		
		
		//
	}
$callcck = "{call SP_GET_DATA_LIST_REQUEST_SLIK_ROBOT_DETAIL(?,?)}";
$paramcck = array(array($prospect, SQLSRV_PARAM_IN), array($nik, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$execcck = sqlsrv_query($conn, $callcck,$paramcck,$options) or die(print_r(sqlsrv_errors(), true)); 	
$checkcck=sqlsrv_num_rows($execcck);



if($checkcck == 0){
	if($data1['SUB_PARAM_ID'] == 1 || $data1['SUB_PARAM_ID'] == 6 || $data1['SUB_PARAM_ID'] == 2 || $data1['SUB_PARAM_ID'] == 7 || $data1['SUB_PARAM_ID'] == 9 || $data1['SUB_PARAM_ID'] == 4 ){

echo "<script>alert('Error, hubungi');window.location='index.php?page=tasklist-ideb&USERNAME=".$userlogin."'</script>";
}	
}


	
	

?>
<style>
    .th-custom {
        text-align: center;
        background-color: #035c7a;
    }

    .td-center {
        text-align: center;
    }

    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 99999999999999999999999999999;
        background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255, 255, 255);
        opacity: 1;
    }

    .pagination>li>a,
    .pagination>li>span {
        background-color: #FFF;
        color: #035c7a;
    }

    .pagination>li.active>a,
    .pagination>li.active>span {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.active>a:hover,
    .pagination>li.active>span:hover {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.focus>a,
    .pagination>li.focus>span:hover {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.active>a.page-link,
    .pagination>li.active>span.page-link {
        background-color: #035c7a;
        color: #FFF;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Tasklist</h4>
                <p class="category">Daftar Pekerjaan Yang di request</p>
            </div>
            <div class="content">
               
		<form enctype="multipart/form-data"  action="" method="post">		
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">SUBJECT TYPE</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">GENERATE NO IDEB</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO IDENTITAS</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">JENIS KELAMIN</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">TEMPAT LAHIR / PENDIRIAN</th>
                          
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL LAHIR / PENDIRIAN</th>
								
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TUJUAN PERMINTAAN</th>
							   <th class="th-custom" style="color:#FFF;font-weight:bold;">DATA TIDAK DITEMUKAN</th>
           
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                            <tr>
                                <td class="td-center"><?php echo '1'; ?></td>
                                <td class="td-center"><?php echo $tipe_debitur; ?></td>
								<td class="td-left"><?php echo $dataGenerate['IDEB_NO']; ?></td>
                                <td class="td-left"><?php echo $nik; ?></td>
                                <td class="td-left"><?php echo $nama; ?></td>
								<td class="td-left"><?php echo $jenis_kelamin; ?></td>
                                <td class="td-left"><?php echo $birth_place; ?></td>
								 <td class="td-left"><?php echo $date;?></td>
								  <td class="td-left"><?php echo $tujuan; ?></td>
							  <td class="td-center">
							  <input type="checkbox" name="notFound" id="notFound"  onclick="myFunction()"> 
								<input type="hidden" name="notFound2" id="notFound2" value="">
							  </td>
							    <td class="td-left">
								 <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">Submit</button>
								</td>
			
                            </tr>   
                    </tbody>
                </table>
				</form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>



<script>

var checker = document.getElementById('notFound');


function myFunction() {
  var checkBox = document.getElementById("notFound");
  var text = document.getElementById("notFound2");
  
  if (checkBox.checked == true){
    text.value = "1";
  } else {
     text.value = "";
  }
}



</script>

<script type="text/javascript">0
    $(document).ready(function() {
        setTimeout(function() {
            $("#loader").fadeOut("slow");
        }, 2000);

        $('#nodata').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true
        });

     
    });
</script>