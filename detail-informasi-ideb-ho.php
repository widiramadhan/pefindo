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

	

/*
$callKar = "{call SP_GET_DATA_DEBITUR_EXISTING_NOREG(?,?)}";
$paramKar = array(array($prospect, SQLSRV_PARAM_IN),
				  array($nik, SQLSRV_PARAM_IN));
$execKar = sqlsrv_query( $conn, $callKar,$paramKar)  or die( print_r( sqlsrv_errors(), true));
$dataKar = sqlsrv_fetch_array($execKar);
*/

$callKar = "{call SP_GET_DATA_DEBITUR_EXISTING(?)}";
$paramKar = array(array($id, SQLSRV_PARAM_IN));
$execKar = sqlsrv_query( $conn, $callKar,$paramKar)  or die( print_r( sqlsrv_errors(), true));
$dataKar = sqlsrv_fetch_array($execKar);

$req_id = $dataKar['TASKLIST_SLIK_CHECK_ID'];

$nik=$dataKar['ID_NO'];
$nama=$dataKar['CUST_NAME'];
$no_regist = $dataKar['NOMOR_KONTRAK'];
if($dataKar['BIRTH_DATE']<>NULL){$birth_date = $dataKar['BIRTH_DATE']->format("d F Y");}else{$birth_date="";}
$alamat = $dataKar['ALAMAT'];
$mother_name = $dataKar['MOTHER_NAME'];
$status_kawin = $dataKar['STATUS_KAWIN'];
$type = $dataKar['TYPE'];



	
	$callJk = "{call  PEFINDO_GET_DATA_JENIS_KELAMIN_KONTRAK(?)}";
	$paramJk = array(array($prospect, SQLSRV_PARAM_IN));
	$execJk = sqlsrv_query( $conn, $callJk, $paramJk) or die( print_r( sqlsrv_errors(), true)); 
	$dataJk = sqlsrv_fetch_array($execJk);
	
	$jkPemohon = $dataJk['JK'];
	$jkPasangan = $dataJk['JK_PASANGAN'];
	$jkPenjamin = $dataJk['JK_PENJAMIN'];
	


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

if(substr($prospect,0,2) == '10'){
$kategori = '2W';
}else{
	$kategori = '4W';
}
	
	$callNoIdeb = "{call SP_GENERATE_DEBSLIK_INSERT_DEBITUR_H2H_HO(?,?,?,?,?,?,?,?,?,?,?,?,?)}";
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
	
$call = "{call SP_GET_DATA_FROM_NOMOR_KONTRAK(?)}";
	$param = array(array($no_regist, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
	$data = sqlsrv_fetch_array($exec);


	$callStat = "{call SP_UPDATE_SLIK_RESULT_NEW_MAPPING(?,?)}";
	$paramStat = array(array($req_id, SQLSRV_PARAM_IN),array(3, SQLSRV_PARAM_IN));
	$execStat = sqlsrv_query( $conn, $callStat, $paramStat) or die( print_r( sqlsrv_defaults(), true)); 

$call3 = "{call SP_GET_PERFORMANCE_ACTIVITY_NEW_MAPPING(?)}";
$param3 = array(array($req_id, SQLSRV_PARAM_IN));
$option3 = array( "Scrollable" => "buffered" );
$exec3 = sqlsrv_query($conn, $call3, $param3, $option3) or die( print_r( sqlsrv_errors(), true));
$numrows3 = sqlsrv_num_rows($exec3);

	$call4 = "{call SP_INSERT_PERFORMANCE_ACTIVITY_NEW_MAPPING(?,?,?,?)}";
	$param4 = array(array($req_id, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN),array($startDate, SQLSRV_PARAM_IN),array(NULL, SQLSRV_PARAM_IN));
	$exec4 = sqlsrv_query($conn, $call4, $param4) or die( print_r( sqlsrv_errors(), true));
	
	

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
							   <th class="th-custom" style="color:#FFF;font-weight:bold;">UPLOAD TXT </th>
           
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
							  
						
						<form action="pages/action-upload-slik-robot-karyawan.php" method="post" enctype="multipart/form-data" id="myForm">
					
						
							  <input type="hidden" name="mapping_id" value="<?php echo $id;?>"> 
								<input type="hidden" name="prospect_no" value="<?php echo $prospect;?>"> 
								<input type="hidden" name="no_ktp" value="<?php echo $nik;?>"> 
								<input type="hidden" name="user" value="<?php echo $userlogin;?>"> 
								<input type="hidden" name="idebno" value="<?php echo $dataGenerate['IDEB_NO'];?>"> 
							  <input type="checkbox" name="notFound" id="notFound"  onclick="myFunction()"> 
								<input type="hidden" name="notFound2" id="notFound2" value="">
								<input type="hidden" name="nama" value="<?php echo $nama;?>"> 
								<input type="hidden" name="tgl" value="<?php echo $date1;?>"> 
								<input type="hidden" name="siapanih1" value="<?php echo $siapanih1;?>"> 
								<input type="hidden" name="tipe_debitur" value="<?php echo $tipe_debitur;?>"> 
									<input type="hidden" name="req_id" value="<?php echo $req_id;?>"> 
								<input type="hidden" name="nomor_regist" value="<?php echo $no_regist;?>"> 
							
								<input type="hidden" name="user" value="<?php echo $getUsername;?>"> 
								<input type="hidden" name="tipe" id="tipe" value="DEBITUR" >
								
								
					
								
							  </td>
							  <td class="td-left">
								<input type="file" name="slik" id="slik" class="form-control" >
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