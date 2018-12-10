<div class="card">
	<div class="header">
		<p class="name">Pihak Terkait</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th class="bg-td"><b>PENGENAL</th></b>
								<th class="bg-td"><b>NAMA LENGKAP</th></b>
								<th class="bg-td"><b>JENIS HUBUNGAN</th></b>
							</tr>
						</thead>
							<?php
							/* select table RELATIONS_RELATED_PARTY_LIST */
							$callREPARLIST = "{call SP_GET_TAB_RELATIONS_RELATED_PARTY_LIST(?)}";
							$paramsREPARLIST = array(array($id, SQLSRV_PARAM_IN));
							$execREPARLIST = sqlsrv_query( $conn, $callREPARLIST, $paramsREPARLIST) or die( print_r( sqlsrv_errors(), true));
							while($dataREPARLIST = sqlsrv_fetch_array($execREPARLIST)){
							?>
						<tbody>
							<tr class="header expand">
								<td align ="center" ><?php echo $dataREPARLIST['ID_NUMBER_TYPE']." ".$dataREPARLIST['ID_NUMBER'];?></td>
								<td align ="center" ><?php echo $dataREPARLIST['FULL_NAME'];?></td>
								<td align ="center" ><?php echo $dataREPARLIST['TYPE_OF_RELATION'];?><div class="pull-right"><i class="fa fa-caret-square-o-down"></i></div></td>
							</tr>
							<tr class="child">
								<td colspan="3">
								<table class="table table-borderless">
									<tr>
										<td><b>Berlaku Sejak</td></b>
										<td><?php echo $dataREPARLIST['VALID_FROM']->format('Y-m-d');?></td>
										<td><b>Porsi Kepemilikan</td></b>
										<td><?php echo round((float)$dataREPARLIST['OWNER_SHIP_SHARE']).'%';?></td>
										
									</tr>
									<tr>
										<td><b>Jenis Kelamin</td></b>
										<td><?php echo $dataREPARLIST['GENDER'];?></td>
										<td><b>Bagian yang Dijaminkan</td></b>
										<td><?php echo round((float)$dataREPARLIST['LTV']).'%';?></td>
									</tr>
									<tr>
										<td><b>Status Pengurus/Pemilik</td></b>
										<td><?php echo $dataREPARLIST['SUBJECT_STATUS'];?></td>
									</tr>	
									<tr>
										<td rowspan="2" style="vertical-align:top;"><b>Alamat</td></b>
										<td rowspan="2" style="vertical-align:top;"><?php echo $dataREPARLIST['MAIN_ADDRESS_STREET'];?></td>
									</tr>
								</table>
								</td>
							</tr>
						</tbody>
						<?php
						}
						?>
					</table>
					<br>
					<p class="name">Pihak yang terkait dengan debitur</p>
					<div class="table-responsive">
						<table class="table table-bordered" style="width:100%;">
						<?php
						/* select table RELATIONS_INVOLMENT_LIST */
						$callINVOLLIST = "{call SP_GET_TAB_RELATIONS_INVOLMENT_LIST(?)}";
						$paramsINVOLLIST = array(array($id, SQLSRV_PARAM_IN));
						$optionsINVOLLIST =  array( "Scrollable" => "buffered" );
						$execINVOLLIST = sqlsrv_query( $conn, $callINVOLLIST, $paramsINVOLLIST, $optionsINVOLLIST) or die( print_r( sqlsrv_errors(), true));
						$dataINVOLLIST = sqlsrv_fetch_array($execINVOLLIST);
						$checkINVOLLIST=sqlsrv_num_rows($execINVOLLIST);
						?>
							<tr>
								<td><?php if($checkINVOLLIST < 0){ echo $dataINVOLLIST['INVOLMENT_LIST'];}else{ echo "No Data";}?></td>
							</tr>
						</table>
					</div>
					<br>
					<p class="name">Pihak yang terkait dengan fasilitas debitur</p>
					<div class="table-responsive">
						<table class="table table-bordered" style="width:100%;">
							<thead>
								<tr>
									<th class="bg-td"><b>PENGENAL</th></b>
									<th class="bg-td"><b>NAMA LENGKAP</th></b>
									<th class="bg-td"><b>JENIS HUBUNGAN</th></b>
								</tr>
							</thead>
							<tbody>
								<?php
								/* select table RELATIONS_CONTRACT_RELATION_LIST */
								$callCONRELLIST = "{call SP_GET_TAB_RELATIONS_CONTRACT_RELATION_LIST(?)}";
								$paramsCONRELLIST = array(array($id, SQLSRV_PARAM_IN));
								$execCONRELLIST = sqlsrv_query( $conn, $callCONRELLIST, $paramsCONRELLIST) or die( print_r( sqlsrv_errors(), true));
								while($dataCONRELLIST = sqlsrv_fetch_array($execCONRELLIST)){
								?>
								<tr class = "header expand">
									<td align ="center" ><?php echo $dataCONRELLIST['ID_NUMBER_TYPE']." ".$dataCONRELLIST['ID_NUMBER'];?></td>
									<td align ="center" ><?php echo $dataCONRELLIST['FULL_NAME'];?></td>
									<td align ="center" ><?php echo $dataCONRELLIST['ROLE_OF_CUSTOMER'];?><div class="pull-right"><i class="fa fa-caret-square-o-down"></i></div></td>
								</tr>
								<tr class="child">
									<td colspan="3">
										<table class="table table-borderless">
											<tr>
												<td><b>Berlaku Sejak</td></b>
												<td><?php echo $dataCONRELLIST['VALID_FORM']->format('Y-m-d');?></td>
											</tr>
											<tr>
												<td rowspan="2" style="vertical-align:top;"><b>Alamat</td></b>
												<td rowspan="2" style="vertical-align:top;"><?php echo $dataCONRELLIST['MAIN_ADDRESS_STREET'];?></td>
											</tr>
										</table>
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