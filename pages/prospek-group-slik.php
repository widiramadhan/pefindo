<?php
$prospek=$_GET['no'];
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
                                    $call = "{call SP_PROSPEK_GROUP(?)}";
                                    $param = array(array($prospek, SQLSRV_PARAM_IN));
                                    $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
                                    while($data = sqlsrv_fetch_array($exec)){
                                        $no++;
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
                                                if($data['SUB_PARAM_ID'] == "0"){
                                                    echo"<span class='badge' style='background-color:#d9534f;'>OPEN</span>";
                                                }else if($data['SUB_PARAM_ID'] == "1"){
                                                    echo"<span class='badge' style='background-color:#428bca;'>ON PROGRESS</span>";
												}else if($data['SUB_PARAM_ID'] == "3"){
                                                    echo"<span class='badge' style='background-color:#ffc107;'>REJECT</span>";
                                                }else{
                                                    echo"<span class='badge' style='background-color:#5cb85c;'>FINISH</span>";
                                                }
                                            ?>
                                        </td>
                                        <td class="td-center">
											<div class="dropdown">
												<button class="btn btn-custom btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
												<span class="caret"></span></button>
												<ul class="dropdown-menu">
													<?php
													if($data['SUB_PARAM_ID'] == "0" || $data['SUB_PARAM_ID'] == "1"){
														echo'<li><a href="#" disabled style="pointer-events:none;color:#AAA">Input Hasil SLIK</a></li>';
													}else if($data['SUB_PARAM_ID'] == "2"){
														if($data['VOID'] == "0"){
															echo'<li><a href="index.php?USERNAME='.$user.'&page=slik-result&id='.$data['PEFINDO_MAPPING_ID'].'">Input Hasil SLIK</a></li>';
														}else{
															//echo'<li><a href="#" disabled>Input Hasil SLIK</a></li>';
															echo'<li><a href="index.php?USERNAME='.$user.'&page=slik-result&id='.$data['PEFINDO_MAPPING_ID'].'">Input Hasil SLIK</a></li>';
														}
													}else if($data['SUB_PARAM_ID'] == "3"){
														echo'<li><a href="index.php?page=note-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'">Detail</a></li>';
													}
													
													if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RANI.VEMIA' || $_GET['USERNAME'] == 'rani.vemia' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'LUDY.HARDIYAN' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'LUDY.HARDIYAN' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA'){	  
														if($data['SUB_PARAM_ID'] == "0"){
															echo'<li><a href="index.php?page=prospek-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&no='.$data['PROSPECT_NO'].'&nik='.$data['ID_NO'].'&custtype='.$data['TIPE_CUST'].'&name='.$data['CUST_NAME'].'">Proses</a></li>';
														}else if($data['SUB_PARAM_ID'] == "1"){
															echo'<li><a href="index.php?page=prospek-detail&USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&no='.$data['PROSPECT_NO'].'&nik='.$data['ID_NO'].'&custtype='.$data['TIPE_CUST'].'&name='.$data['CUST_NAME'].'">Proses</a></li>';
														}else if($data['SUB_PARAM_ID'] == "2"){
															echo'<li><a href="#" disabled style="pointer-events:none;color:#AAA">Selesai</a></li>';
														}else if($data['SUB_PARAM_ID'] == "3"){
															echo'&nbsp;&nbsp;<button type="button" disabled style="pointer-events:none;color:#AAA">Proses</button>';
														}
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