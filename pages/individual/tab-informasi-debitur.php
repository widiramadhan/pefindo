<?php
/* select table individual */
$callIndividual = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_INDIVIDUAL(?)}";
$paramsIndividual = array(array($id, SQLSRV_PARAM_IN));
$execIndividual = sqlsrv_query( $conn, $callIndividual, $paramsIndividual) or die( print_r( sqlsrv_errors(), true));
$dataIndividual = sqlsrv_fetch_array($execIndividual);

/* select table disputes summary */
$callDisputesSum = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_DISPUTES_SUMMARY(?)}";
$paramsDisputesSum = array(array($id, SQLSRV_PARAM_IN));
$execDisputesSum = sqlsrv_query( $conn, $callDisputesSum, $paramsDisputesSum) or die( print_r( sqlsrv_errors(), true));
$dataDisputesSum = sqlsrv_fetch_array($execDisputesSum);
?>
<div class="card">
	<div class="header"><p class="name">Informasi Debitur</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<tbody>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">NAMA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nama Lengkap</b></td>
								<td colspan="3"><?php echo $dataIndividual['FULL_NAME'];?></td>
								<td class="bg-td"><b>Nama Gadis Ibu Kandung</b></td>.
								<td colspan="3"><?php echo $dataIndividual['MOTHER_MAIDEN_NAME'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Alias</b></td>
								<td colspan="3"><?php echo $dataIndividual['ALIAS'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">ALAMAT</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Alamat</b></td> 
								<td colspan="7"><?php echo $dataIndividual['ADDRESS_LINE'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">KONTAK</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Seluler</b></td>
								<td colspan="3"><?php echo $dataIndividual['MOBILEPHONE'];?></td>
								<td class="bg-td"><b>Email</b></td>
								<td colspan="3"><?php echo $dataIndividual['EMAIL'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Telepon Rumah</b></td>
								<td colspan="7">-</td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">ID UTAMA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>KTP</b></td>
								<td colspan="3"><?php echo $dataIndividual['KTP'];?></td>
								<td class="bg-td"><b>NPWP</b></td>
								<td colspan="3"><?php echo $dataIndividual['NPWP'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">DATA KELAHIRAN</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Lahir</b></td>
								<td colspan="3"><?php if($dataIndividual['DATE_OF_BIRTH']<>NULL){echo $dataIndividual['DATE_OF_BIRTH']->format('Y-m-d');}else{echo"";}?></td>
								<td class="bg-td"><b>Tempat Lahir</b></td>
								<td colspan="3"><?php echo $dataIndividual['PLACE_OF_BIRTH'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">MAIN PERSONAL DATA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jenis Kelamin</b></td>
								<td colspan="3"><?php echo $dataIndividual['GENDER'];?></td>
								<td class="bg-td"><b>Kewarganegaraan</b></td>
								<td colspan="3"><?php echo $dataIndividual['CITIZENSHIP'];?></td>														
							</tr>
							<tr>
								<td class="bg-td"><b>Status pekerjaan</b></td>
								<td colspan="3"><?php echo $dataIndividual['SOCIAL_STATUS'];?></td>	
								<td class="bg-td"><b>Klasifikasi</b></td>
								<td colspan="3"><?php echo $dataIndividual['CLASSIFICATION_OF_INDIVIDUAL'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">TANDA PENGENAL LAINNYA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Paspor</b></td>
								<td colspan="3"><?php echo $dataIndividual['PASSPORT_NUMBER']." / ".$dataIndividual['CITIZENSHIP'];?></td>
								<td class="bg-td"><b>Pefindo ID</b></td>
								<td colspan="3"><?php echo $dataIndividual['PEFINDO_ID'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">PEKERJAAN DAN PENDIDIKAN</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Pekerjaan</b></td>
								<td colspan="3"><?php echo $dataIndividual['EMPLOYMENT'];?></td>
								<td class="bg-td"><b>Sektor Pemberi Kerja</b></td>
								<td colspan="3"><?php echo $dataIndividual['EMPLOYER_SECTOR'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nama Pemberi Kerja</b></td>
								<td colspan="3"><?php echo $dataIndividual['EMPLOYER_NAME'];?></td>
								<td class="bg-td"><b>Pendidikan</b></td>
								<td colspan="3"><?php echo $dataIndividual['EDUCATION'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">PENGADUAN</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jumlah pengaduan yang telah diselesaikan</b></td>
								<td colspan="3"><?php echo $dataDisputesSum['SUMMARY_NUMBER_OF_CLOSED_SUBJECT_DATA'];?></td>
								<td class="bg-td"><b>Jumlah pengaduan yang tidak sah</b></td>
								<td colspan="3"><?php echo $dataDisputesSum['SUMMARY_NUMBER_OF_FALSE'];?></td>
							</tr>
						</tbody>
					</table>
					<hr>
					<p class="name">Data Historis</p>
					<p class="name text-danger">Pengkinian data debitur</p>
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th class="bg-td">PERIHAL</th> 
								<th class="bg-td">PERUBAHAN</th>
								<th class="bg-td">BERLAKU SEJAK</th>
								<th class="bg-td">BERLAKU SAMPAI DENGAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/* select table subject info history general list */
								$callSubInfoGenList = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_SUBJECT_INFO_HISTORY_GENERAL_LIST(?)}";
								$paramsSubInfoGenList = array(array($id, SQLSRV_PARAM_IN));
								$execSubInfoGenList = sqlsrv_query( $conn, $callSubInfoGenList, $paramsSubInfoGenList) or die( print_r( sqlsrv_errors(), true));
								while($dataSubInfoGenList = sqlsrv_fetch_array($execSubInfoGenList)){
							?>
							<tr>
								<td><?php echo $dataSubInfoGenList['GENERAL_ITEM'];?></td>
								<td><?php echo $dataSubInfoGenList['GENERAL_VALUE'];?></td>
								<td><?php if($dataSubInfoGenList['GENERAL_VALID_FROM']==NULL){echo"";}else{echo $dataSubInfoGenList['GENERAL_VALID_FROM']->format('Y-m-d');}?></td>
								<td><?php if($dataSubInfoGenList['GENERAL_VALID_TO']==NULL){echo"";}else{echo $dataSubInfoGenList['GENERAL_VALID_TO']->format('Y-m-d');}?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>	
					<p class="name text-danger">Pengkinian data identitas</p>	
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th class="bg-td">PERIHAL</th> 
								<th class="bg-td">PERUBAHAN</th>
								<th class="bg-td">BERLAKU SEJAK</th>
								<th class="bg-td">BERLAKU SAMPAI DENGAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/* select table subject info history identification list */
								$callSubInfoIdList = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_SUBJECT_INFO_HISTORY_IDENTIFICATIONS_LIST(?)}";
								$paramsSubInfoIdList = array(array($id, SQLSRV_PARAM_IN));
								$execSubInfoIdList = sqlsrv_query( $conn, $callSubInfoIdList, $paramsSubInfoIdList) or die( print_r( sqlsrv_errors(), true));
								while($dataSubInfoIdList = sqlsrv_fetch_array($execSubInfoIdList)){
							?>
							<tr>
								<td><?php echo $dataSubInfoIdList['IDENTIFICATIONS_ITEM'];?></td>
								<td><?php echo $dataSubInfoIdList['IDENTIFICATIONS_VALUE'];?></td>
								<td><?php if($dataSubInfoIdList['IDENTIFICATIONS_VALID_FROM']==NULL){echo"";}else{echo $dataSubInfoIdList['IDENTIFICATIONS_VALID_FROM']->format('Y-m-d');}?></td>
								<td><?php if($dataSubInfoIdList['IDENTIFICATIONS_VALID_TO']==NULL){echo"";}else{echo $dataSubInfoIdList['IDENTIFICATIONS_VALID_TO']->format('Y-m-d');}?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>	
					<p class="name text-danger">Pengkinian Alamat</p>	
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th class="bg-td">PERIHAL</th> 
								<th class="bg-td">PERUBAHAN</th>
								<th class="bg-td">BERLAKU SEJAK</th>
								<th class="bg-td">BERLAKU SAMPAI DENGAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/* select table subject info history address list */
								$callSubInfoAddList = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_SUBJECT_INFO_HISTORY_ADDRESS_LIST(?)}";
								$paramsSubInfoAddList = array(array($id, SQLSRV_PARAM_IN));
								$execSubInfoAddList = sqlsrv_query( $conn, $callSubInfoAddList, $paramsSubInfoAddList) or die( print_r( sqlsrv_errors(), true));
								while($dataSubInfoAddList = sqlsrv_fetch_array($execSubInfoAddList)){
							?>
							<tr>
								<td><?php echo $dataSubInfoAddList['ADDRESS_ITEM'];?></td>
								<td><?php echo $dataSubInfoAddList['ADDRESS_VALUE'];?></td>
								<td><?php if($dataSubInfoAddList['ADDRESS_VALID_FORM']==NULL){echo"";}else{echo $dataSubInfoAddList['ADDRESS_VALID_FORM']->format('Y-m-d');}?></td>
								<td><?php if($dataSubInfoAddList['ADDRESS_VALID_TO']==NULL){echo"";}else{echo $dataSubInfoAddList['ADDRESS_VALID_TO']->format('Y-m-d');}?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>	
					<p class="name text-danger">Pengkinian kontak yang bisa dihubungi</p>	
					<table class="table table-bordered table-stripped">
						<thead>
							<tr>
								<th class="bg-td">PERIHAL</th> 
								<th class="bg-td">PERUBAHAN</th>
								<th class="bg-td">BERLAKU SEJAK</th>
								<th class="bg-td">BERLAKU SAMPAI DENGAN</th>
							</tr>
						</thead>
						<tbody>
							<?php
								/* select table subject info history contact list */
								$callSubInfoConList = "{call SP_GET_TAB_INFORMASI_DEBITUR_TBL_SUBJECT_INFO_HISTORY_CONTACT_LIST(?)}";
								$paramsSubInfoConList = array(array($id, SQLSRV_PARAM_IN));
								$execSubInfoConList = sqlsrv_query( $conn, $callSubInfoConList, $paramsSubInfoConList) or die( print_r( sqlsrv_errors(), true));
								while($dataSubInfoConList = sqlsrv_fetch_array($execSubInfoConList)){
							?>
							<tr>
								<td><?php echo $dataSubInfoConList['CONTACT_ITEM'];?></td>
								<td><?php echo $dataSubInfoConList['CONTACT_VALUE'];?></td>
								<td><?php if($dataSubInfoConList['CONTACT_VALID_FROM']==NULL){echo"";}else{echo $dataSubInfoConList['CONTACT_VALID_FROM']->format('Y-m-d');}?></td>
								<td><?php if($dataSubInfoConList['CONTACT_VALID_TO']==NULL){echo"";}else{echo $dataSubInfoConList['CONTACT_VALID_TO']->format('Y-m-d');}?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>													
				</div>
			</div>
		</div>
	</div>
</div>