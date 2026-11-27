<?php
$getUsername=$_GET['USERNAME'];
$req_id = $_GET['request_id'];
$order_no = $_GET['order_no'];

$id=$_POST['id'];
$no_ktp=$_GET['nik'];
$nama=$_POST['name'];
$date=$_POST['date'];
$mother_nm=$_POST['mother_name'];
$siapanih=$_POST['tipe_cust'];



$callList= "{call SP_PROSES_DATA_INTERNAL_SCORING(?)}";
$paramList = array(array($order_no, SQLSRV_PARAM_IN));
$execList = sqlsrv_query( $conn, $callList, $paramList) or die( print_r( sqlsrv_defaults(), true)); 


$callGen= "{call SP_PROSES_DATA_GENERATE_INTERNAL_SCORING(?)}";
$paramGen = array(array($order_no, SQLSRV_PARAM_IN));
$options =  array( "Scrollable" => "buffered" );
$execGen = sqlsrv_query( $conn, $callGen, $paramGen) or die( print_r( sqlsrv_defaults(), true)); 
$dataGen = sqlsrv_fetch_array($execGen);

$MAX_OD = $dataGen['Max_OD'];
$MAX_OD_12 =  $dataGen['MAX_OD_12'];
$KONDISI_MACET =  $dataGen['kondisi_MACET'];
$PROXY_INCOME_MAX = $dataGen['PROXY_INCOME_MAX'];
$RECOMENDATION_PROXY_INCOME = $dataGen['recomendation_proxy_income'];
$JENIS_FASILITAS_MAPPING = $dataGen['JENIS_FASILITAS_MAPPING'];
$SURVEY_STATUS =  $dataGen['Survey_Status'];

$CODE = $dataGen['STATUS_LEVEL'];
$CODE_DESC = $dataGen['Status_Proxy_income'];

$callScore = "{call SP_INSERT_CREDIT_SCORING_INTERNAL(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
$paramScore = array(array($id, SQLSRV_PARAM_IN),
				 array($order_no, SQLSRV_PARAM_IN),
				 array($no_ktp, SQLSRV_PARAM_IN),
				 array($CODE, SQLSRV_PARAM_IN),
				 array($CODE_DESC, SQLSRV_PARAM_IN),
				 array($siapanih, SQLSRV_PARAM_IN),
				 array($getUsername, SQLSRV_PARAM_IN),
				 array($MAX_OD, SQLSRV_PARAM_IN),
				 array($MAX_OD_12, SQLSRV_PARAM_IN),
				 array($KONDISI_MACET, SQLSRV_PARAM_IN),
				 array($PROXY_INCOME_MAX, SQLSRV_PARAM_IN),
				 array($RECOMENDATION_PROXY_INCOME, SQLSRV_PARAM_IN),
				 array($JENIS_FASILITAS_MAPPING, SQLSRV_PARAM_IN),
				 array($SURVEY_STATUS, SQLSRV_PARAM_IN));
	
	//echo '<pre>' . var_export($paramScore, true) . '</pre>';
	//exit();
$execScore = sqlsrv_query( $conn, $callScore, $paramScore) or die( print_r( sqlsrv_defaults(), true)); 

?>
<style>
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
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

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Cek Ulang Dukcapil</h4>
				<p class="category">Detail Cek Ulang Dukcapil</p>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width:100%;font-size:12px;">
								<thead></thead>
								<tbody>
									<tr>
										<td colspan="3" style="color:#FFF;background-color:#035c7a;"><b>DISDUKCAPIL</td>
									</tr>
									<?php
								$callCheckDuk = "{call SP_GET_CREDIT_SCORING_INTERNAL(?,?)}";
												$paramCheckDuk = array(array($order_no, SQLSRV_PARAM_IN),
																 array($no_ktp, SQLSRV_PARAM_IN));
												$execCheckDuk = sqlsrv_query( $conn, $callCheckDuk, $paramCheckDuk) or die( print_r( sqlsrv_defaults(), true)); 
												$dataCheckDuk = sqlsrv_fetch_array($execCheckDuk);

											echo"
																<tr>
																	<td style='width:33%;'>Hasil Pengecekan</td>
																	<td style='width:33%;'>".strtoupper($dataCheckDuk['CREDIT_SCORE_CODE'])."</td>
																	<td style='width:33%;'>Checked by ".$dataCheckDuk['USER_CREATE']." (".$dataCheckDuk['CREATE_DATE']->format("Y-m-d H:i:s")." )</td>
																</tr>";

										
			
									?>
								</tbody>
							</table>
							<a href="index.php?page=detail-pengecekan-mh&USERNAME=<?php echo $user;?>&id=<?php echo $id;?>&request_id=<?php echo $req_id;?>" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> Kembali Ke Tasklist</a>
						</div>
					</div>
				</div>
			
			</div>
		</div>
	</div>
	</div>
