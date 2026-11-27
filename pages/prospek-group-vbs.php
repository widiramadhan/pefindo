<?php
$prospek=$_GET['no'];


$call1 = "{call PEFINDO_GETDATA_PASANGAN_1(?)}";
$param1 = array(array($prospek, SQLSRV_PARAM_IN));
$exec1 = sqlsrv_query( $conn, $call1, $param1) or die( print_r( sqlsrv_errors(), true));
$data1 = sqlsrv_fetch_array($exec1);


$call51 = "{call PEFINDO_GETDATA_PASANGAN_BY_ORDER_NO_1(?)}";
$param51 = array(array($prospek, SQLSRV_PARAM_IN));
$exec51 = sqlsrv_query( $conn, $call51, $param51) or die( print_r( sqlsrv_errors(), true));
$data51 = sqlsrv_fetch_array($exec51);


?>
<style>
.th-custom{
	text-align:center;
    font-weight:bold;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">PROSPEK GROUP / ORDER GROUP</h4>
				<p class="category">Nomor Prospek : <?php echo $prospek;?></p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%;font-size:10px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor KTP</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Nama</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Request</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Tipe</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Create Date</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Status</th>
                                        <th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no=0;
                                    ///$call = "{call SP_PROSPEK_GROUP_NEW(?)}";
									$call = "{call SP_PROSPEK_GROUP(?)}";
                                    $param = array(array($prospek, SQLSRV_PARAM_IN));
									$options =  array( "Scrollable" => "buffered" );
                                    $exec = sqlsrv_query( $conn, $call, $param,$options) or die( print_r( sqlsrv_errors(), true)); 
                                    while($data = sqlsrv_fetch_array($exec)){
                                        $no++;
										
									$call5 = "{call PEFINDO_GETDATA_SCORING_SOURCEBY(?,?)}";
                                    $param5 = array(array($prospek, SQLSRV_PARAM_IN),
												    array($data['ID_NO'], SQLSRV_PARAM_IN));
									$options5 =  array( "Scrollable" => "buffered" );
                                    $exec5 = sqlsrv_query( $conn, $call5, $param5,$options5) or die( print_r( sqlsrv_errors(), true)); 
									$data5 = sqlsrv_fetch_array($exec5);
									
									$call8 = "{call SP_GET_DETAIL_CHECK_REQUEST_MH_TASKLIST(?,?)}";
									$param8 = array(array($prospek, SQLSRV_PARAM_IN),array($data['ID_NO'], SQLSRV_PARAM_IN));
									$exec8 = sqlsrv_query( $conn, $call8, $param8) or die( print_r( sqlsrv_errors(), true));
									$data41 = sqlsrv_fetch_array($exec8);
                                ?>
                                    <tr>
                                        <td class="td-center"><?php echo $no;?></td>
                                        <td class="td-center"><?php echo $data['ID_NO'];?></td>
                                        <td class="td-center"><?php echo $data['CUST_NAME'];?></td>
                                        <td class="td-center"><?php if($data['CUST_TYPE']=="P"){echo"INDIVIDUAL";}else{echo"COMPANY";}?></td>
                                        <td class="td-center"><?php echo $data['TIPE_CUST'];?></td>
                                        <td class="td-center"><?php if($data['CREATE_DATE']<>NULL){echo $data['CREATE_DATE']->format("Y-m-d H:i:s");}?></td>
                                        <td class="td-center">
                                            <?php
                                                if($data['SUB_PARAM_ID'] == "0" || $data['SUB_PARAM_ID'] == "8" ){
                                                    echo"<span class='badge' style='background-color:#d9534f;'>OPEN</span>";
                                                }else if($data['SUB_PARAM_ID'] == "1" || $data['SUB_PARAM_ID'] == "6"){
                                                    echo"<span class='badge' style='background-color:#428bca;'>ON PROGRESS</span>";
												}else if($data['SUB_PARAM_ID'] == "3" || $data['SUB_PARAM_ID'] == "5"){
                                                    echo"<span class='badge' style='background-color:#ffc107;'>REJECT</span>";
                                                }else if($data['SUB_PARAM_ID'] == "4" ){
                                                    echo"<span class='badge' style='background-color:#000000;'>HOLD DUKCAPIL</span>";
                                                }
												else{
                                                    echo"<span class='badge' style='background-color:#5cb85c;'>FINISH</span>";
                                                }
                                            ?>
                                        </td>
                                        <td class="td-center">
											<div class="dropdown">
												<button class="btn btn-custom btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
												<span class="caret"></span></button>
												<ul class="dropdown-menu">
												<form action="index.php?page=detail-informasi&USERNAME=<?php echo $user;?>" method="post" id="formPemohon">
													<input type="hidden" name="id" value="<?php echo $data['PEFINDO_MAPPING_ID'];?>">
													<input type="hidden" name="prospect_no" value="<?php echo $prospek;?>">
													<input type="hidden" name="no_ktp" value="<?php echo $data['ID_NO'];?>">
													<input type="hidden" name="name" value="<?php echo $data['CUST_NAME'];?>">
													<input type="hidden" name="date" value="<?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('Y-m-d');}?>">
													<input type="hidden" name="mother_name" value="<?php echo $data41['MOTHER_NAME'];?>">
													<input type="hidden" name="birth_place" value="<?php echo $data51['BIRTH_PLACE'];?>">
													<input type="hidden" name="tipe_cust"  value="<?php echo $data['TIPE_CUST'];?>">
											
												</form>
												
												<?php //echo'<li><a href="index.php?page=prospek-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].
												//'&prospect_no='.$data['PROSPECT_NO'].'&no_ktp='.$data['ID_NO'].'&name='.$data['CUST_NAME'].'&date='.if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('Y-m-d');}.
												//'&mother_name='.$data41['MOTHER_NAME'].'&birth_place='.$data51['BIRTH_PLACE'].'&tipe_cust='.$data['TIPE_CUST'].'">Proses</a></li>';
												?>
												

												
												
													<form action="index.php?page=dukcapil-ho&USERNAME=<?php echo $user;?>" method="post" id="formPemohonDukcapil">
													<input type="hidden" name="id" value="<?php echo $data['PEFINDO_MAPPING_ID'];?>">
													<input type="hidden" name="prospect_no" value="<?php echo $prospek;?>">
													<input type="hidden" name="no_ktp" value="<?php echo $data['ID_NO'];?>">
													<input type="hidden" name="name" value="<?php echo $data['CUST_NAME'];?>">
													<input type="hidden" name="date" value="<?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('Y-m-d');}?>">
													<input type="hidden" name="mother_name" value="<?php echo $data41['MOTHER_NAME'];?>">
													<input type="hidden" name="birth_place" value="<?php echo $data51['BIRTH_PLACE'];?>">
													<input type="hidden" name="tipe_cust" value="PEMOHON">
											
												</form>
												<form action="index.php?page=dukcapil-ho&USERNAME=<?php echo $user;?>" method="post" id="formJaminanDukcapil">
													<input type="hidden" name="id" value="<?php echo $data['PEFINDO_MAPPING_ID'];?>">
													<input type="hidden" name="prospect_no" value="<?php echo $prospek;?>">
													<input type="hidden" name="no_ktp" value="<?php $data['ID_NO'];?>">
													<input type="hidden" name="name" value="<?php echo $data['CUST_NAME']?>">
													<input type="hidden" name="date" value="<?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('Y-m-d');}?>">
													<input type="hidden" name="mother_name" value="<?php echo $data41['MOTHER_NAME'];?>">
													<input type="hidden" name="birth_place" value="<?php echo $data51['BIRTH_PLACE'];?>">
													<input type="hidden" name="tipe_cust" value="<?php echo $data['TIPE_CUST'];?>">
												
												</form>
												
												
													<?php
													if($data['SUB_PARAM_ID'] == "0" || $data['SUB_PARAM_ID'] == "1" || $data['SUB_PARAM_ID'] == "6" || $data['SUB_PARAM_ID'] == "8" || $data['SUB_PARAM_ID'] == "4"){
														echo'<li><a href="#" disabled style="pointer-events:none;color:#AAA">Input Hasil SLIK</a></li>';
													}else if($data['SUB_PARAM_ID'] == "2" || $data['SUB_PARAM_ID'] == "7"){
														if($data['VOID'] == "0"){
															echo'<li><a href="index.php?USERNAME='.$user.'&page=slik-detail&no='.$data['PROSPECT_NO'].'&custtype='.$data['TIPE_CUST'].'&id='.$data['PEFINDO_MAPPING_ID'].'">Hasil SLIK</a></li>';
														}else{
															//echo'<li><a href="#" disabled>Input Hasil SLIK</a></li>';
															echo'<li><a href="index.php?USERNAME='.$user.'&page=slik-detail&no='.$data['PROSPECT_NO'].'&custtype='.$data['TIPE_CUST'].'&id='.$data['PEFINDO_MAPPING_ID'].'">Hasil SLIK</a></li>';
														}
													}else if($data['SUB_PARAM_ID'] == "9"){
														
														echo'<li><a href="index.php?USERNAME='.$user.'&page=scoring-individual&id='.$data5['PEFINDO_MAPPING_ID'].'&prospect_no='.$data['PROSPECT_NO'].'" </i> Hasil Scoring</a></li>';
													}
													else if($data['SUB_PARAM_ID'] == "3"){
														echo'<li><a href="index.php?page=note-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'">Detail</a></li>';
													}
													else if($data['SUB_PARAM_ID'] == "5"){
														echo'<li><a href="index.php?page=note-reject-detail&USERNAME='.$user.'&prospect='.$data['PROSPECT_NO'].'&id_no='.$data['ID_NO'].'&id='.$data['PEFINDO_MAPPING_ID'].'">Detail</a></li>';
													}
													
													if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'LUDY.HARDIYAN' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'LUDY.HARDIYAN' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA'){	  
														if($data['SUB_PARAM_ID'] == "0" || $data['SUB_PARAM_ID'] == "8"){
															//echo'<li><a href="index.php?page=prospek-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&no='.$data['PROSPECT_NO'].'&nik='.$data['ID_NO'].'">Proses</a></li>';
															
																echo'<li><a href="index.php?page=detail-informasi&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].
																	'&prospect_no='.$data['PROSPECT_NO'].'&no_ktp='.$data['ID_NO'].'&name='.$data['CUST_NAME'].'&date='.$data['BIRTH_DT']->format('Y-m-d').
																	'&mother_name='.$data41['MOTHER_NAME'].'&birth_place='.$data51['BIRTH_PLACE'].'&tipe_cust='.$data['TIPE_CUST'].'">Proses</a></li>';
															
																
														
														}
														else if($data['SUB_PARAM_ID'] == "1" || $data['SUB_PARAM_ID'] == "6"){
														//	echo'<li><a href="index.php?page=prospek-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&no='.$data['PROSPECT_NO'].'&nik='.$data['ID_NO'].'">Proses</a></li>';
														
															echo'<li><a href="index.php?page=detail-informasi&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].
																	'&prospect_no='.$data['PROSPECT_NO'].'&no_ktp='.$data['ID_NO'].'&name='.$data['CUST_NAME'].'&date='.$data['BIRTH_DT']->format('Y-m-d').
																	'&mother_name='.$data41['MOTHER_NAME'].'&birth_place='.$data51['BIRTH_PLACE'].'&tipe_cust='.$data['TIPE_CUST'].'">Proses</a></li>';
														
														}else if($data['SUB_PARAM_ID'] == "2" || $data['SUB_PARAM_ID'] == "7" ||  $data['SUB_PARAM_ID'] == "9"){
															echo'<li><a href="#" disabled style="pointer-events:none;color:#AAA">Selesai</a></li>';
														}else if($data['SUB_PARAM_ID'] == "3" || $data['SUB_PARAM_ID'] == "5"){
															echo'&nbsp;&nbsp;<button type="button" disabled style="pointer-events:none;color:#AAA">Proses</button>';
														}
														else if($data['SUB_PARAM_ID'] == "4"){
													
																echo'<li><a href="index.php?page=detail-informasi&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].
																	'&prospect_no='.$data['PROSPECT_NO'].'&no_ktp='.$data['ID_NO'].'&name='.$data['CUST_NAME'].'&date='. $data['BIRTH_DT']->format('Y-m-d').
																	'&mother_name='.$data41['MOTHER_NAME'].'&birth_place='.$data51['BIRTH_PLACE'].'&tipe_cust='.$data['TIPE_CUST'].'">Proses</a></li>';
														
														}
								
															?>
																
															
														<?php 
												}else{
														
													}
													
													?>
													
												</ul>
											</div> 
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
function alertdukcapilPenjamin()
{
if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')){
	 document.getElementById('formJaminanDukcapil').submit();
};
}
function alertdukcapilPemohon()
{
if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')){
	 document.getElementById('formPemohonDukcapil').submit();
};
}
function formPemohon()
{
document.getElementById('formPemohon').submit();

}
function formJaminan()
{
document.getElementById('formJaminan').submit();

}
</script>