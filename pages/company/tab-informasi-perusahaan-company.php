<?php
/* select table company */
$callcompany = "{call SP_GET_TAB_INFORMASI_COMPANY_TBL_COMPANY(?)}";
$paramscompany = array(array($id, SQLSRV_PARAM_IN));
$execcompany = sqlsrv_query( $conn, $callcompany, $paramscompany) or die( print_r( sqlsrv_errors(), true));
$datacompany = sqlsrv_fetch_array($execcompany);

$callDISPTcompany = "{call SP_GET_TAB_INFORMASI_COMPANY_TBL_DISPUTES_SUMMARY_COMPANY(?)}";
$paramsDISPTcompany = array(array($id, SQLSRV_PARAM_IN));
$execDISPTcompany = sqlsrv_query( $conn, $callDISPTcompany, $paramsDISPTcompany) or die( print_r( sqlsrv_errors(), true));
$dataDISPTcompany = sqlsrv_fetch_array($execDISPTcompany);
?>

<div class="card">
	<div class="header"><p class="name">Informasi perusahaan</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<tbody>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">IDENTITAS UTAMA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>NPWP</b></td>
								<td colspan="3"><?php echo $datacompany['NPWP'];?></td>
								<td class="bg-td"><b>Nomor Registrasi</b></td>
								<td colspan="3"><?php echo $datacompany['REGISTRATION_NUMBER'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Pefindo ID</b></td>
								<td colspan="3"><?php echo $datacompany['PEFINDO_ID'];?></td>
								<td class="bg-td"><b></b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">NAMA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nama Perusahaan</b></td>
								<td colspan="3"><?php echo $datacompany['COMPANY_NAME'];?></td>
								<td class="bg-td"><b>Nama Dagang</b></td>
								<td colspan="3"><?php echo $datacompany['GROUP_NAME'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nama Alias Perusahaan</b></td>
								<td colspan="3"><?php echo $datacompany['COMPANY_NAME_LOCAL'];?></td>
								<td class="bg-td"><b></b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">DATA UTAMA PERUSAHAAN</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Legal Form</b></td>
								<td colspan="3"><?php echo $datacompany['LEGAL_FORM'];?></td>
								<td class="bg-td"><b>Nomor Akad Terakhir</b></td>
								<td colspan="3"><?php echo $datacompany['LATEST_DEED_NUMBER'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Pendirian</b></td>
								<td colspan="3"><?php echo $datacompany['ESTABILISHMENT_DATE']->format('Y-m-d');?></td>
								<td class="bg-td"><b>Tanggal Akad Terakhir</b></td>
								<td colspan="3"><?php echo $datacompany['LATEST_DATE_OF_DEED']->format('Y-m-d');?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Domisili Pendirian</b></td>
								<td colspan="3"><?php echo $datacompany['ESTABILISHMENT_LOCATION'];?></td>
								<td class="bg-td"><b>Terdaftar di Bursa</b></td>
								<td colspan="3"><?php echo $datacompany['MARKET_LISTED'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>sektor ekonomi</b></td>
								<td colspan="3"><?php echo $datacompany['ECONOMIN_SECTOR']?></td>
								<td class="bg-td"><b>Kategori</b></td>
								<td colspan="3"><?php echo $datacompany['CATEGORY'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Rating</b></td>
								<td colspan="3"><?php echo $datacompany['RATING'];?></td>
								<td class="bg-td"><b>Rating Lembaga</b></td>
								<td colspan="3"><?php echo $datacompany['RATING_AUTHORITY'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Rating</b></td>
								<td colspan="3"><?php echo $datacompany['RATING_DATE']->format('Y-m-d');?></td>
								<td class="bg-td"><b></b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">ALAMAT</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Alamat</b></td>
								<td colspan="3"><?php echo $datacompany['ADDRESS_LINE'];?></td>
								<td class="bg-td"><b></b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">KONTAK</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Selular</b></td>
								<td colspan="3"><?php echo $datacompany['MOBILE_PHONE'];?></td>
								<td class="bg-td"><b>Email</b></td>
								<td colspan="3"><?php echo $datacompany['EMAIL'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Telepon Rumah</b></td>
								<td colspan="3"><?php echo $datacompany['FIXED_LINE'];?></td>
								<td class="bg-td"><b></b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">DISPUTES</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>No. of Closed Disputes</b></td>
								<td colspan="3"><?php echo $dataDISPTcompany['SUMMARY_NUMBER_OF_CLOSED_SUBJECT_DATA'];?></td>
								<td class="bg-td"><b>No. of False Disputes</b></td>
								<td colspan="3"><?php echo $dataDISPTcompany['SUMMARY_NUMBER_OF_FALSE'];?></td>
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
						<?php
						$callsubihis = "{call SP_GET_TAB_INFORMASI_COMPANY_TBL_SUBJECT_INFO_HISTORY_GENERAL_LIST(?)}";
						$paramssubihis = array(array($id, SQLSRV_PARAM_IN));
						$execsubihis = sqlsrv_query( $conn, $callsubihis, $paramssubihis) or die( print_r( sqlsrv_errors(), true));
						while($datasubihis = sqlsrv_fetch_array($execsubihis)){
						?>
						<tbody>
							<tr>
								<td><?php echo $datasubihis['GENERAL_ITEM'];?></td>
								<td><?php echo $datasubihis['GENERAL_VALUE'];?></td>
								<td><?php echo $datasubihis['GENERAL_VALID_FROM']->format('Y-m-d');?></td>
								<td><?php echo $datasubihis['GENERAL_VALID_TO']->format('Y-m-d');?></td>
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
						<?php
						$callsubihisil = "{call SP_GET_TAB_INFO_COMPANY_TBL_SUBJECT_INFO_HISTORY_IDENTIFICATIONS_LIST(?)}";
						$paramssubihisil = array(array($id, SQLSRV_PARAM_IN));
						$execsubihisil = sqlsrv_query( $conn, $callsubihisil, $paramssubihisil) or die( print_r( sqlsrv_errors(), true));
						while($datasubihisil = sqlsrv_fetch_array($execsubihisil)){
						?>
						<tbody>
							<tr>
								<td><?php echo $datasubihisil['IDENTIFICATIONS_ITEM'];?></td>
								<td><?php echo $datasubihisil['IDENTIFICATIONS_VALUE'];?></td>
								<td><?php echo $datasubihisil['IDENTIFICATIONS_VALID_FROM']->format('Y-m-d');?></td>
								<td><?php echo $datasubihisil['IDENTIFICATIONS_VALID_TO']->format('Y-m-d');?></td>
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
						<?php
						$callsubhisADD = "{call SP_GET_TAB_INFO_COMPANY_TBL_SUBJECT_INFO_HISTORY_ADDRESS_LISTCOM(?)}";
						$paramssubhisADD = array(array($id, SQLSRV_PARAM_IN));
						$execsubhisADD = sqlsrv_query( $conn, $callsubhisADD, $paramssubhisADD) or die( print_r( sqlsrv_errors(), true));
						while($datasubhisADD = sqlsrv_fetch_array($execsubhisADD)){
						?>
						<tbody>
							<tr>
								<td><?php echo $datasubhisADD['ADDRESS_ITEM'];?></td>
								<td><?php echo $datasubhisADD['ADDRESS_VALUE'];?></td>
								<td><?php echo $datasubhisADD['ADDRESS_VALID_FORM']->format('Y-m-d');?></td>
								<td><?php echo $datasubhisADD['ADDRESS_VALID_TO']->format('Y-m-d');?></td>
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
							$callsubhisCON = "{call SP_GET_TAB_INFO_COMPANY_TBL_SUBJECT_INFO_HISTORY_CONTACT_LIST_COM(?)}";
							$paramssubhisCON = array(array($id, SQLSRV_PARAM_IN));
							$execsubhisCON = sqlsrv_query( $conn, $callsubhisCON, $paramssubhisCON) or die( print_r( sqlsrv_errors(), true));
							while($datasubhisCON = sqlsrv_fetch_array($execsubhisCON)){
							?>
							<tr>
								<td><?php echo $datasubhisCON['CONTACT_ITEM'];?></td>
								<td><?php echo $datasubhisCON['CONTACT_VALUE'];?></td>
								<td><?php echo $datasubhisCON['CONTACT_VALID_FROM']->format('Y-m-d');?></td>
								<td><?php echo $datasubhisCON['CONTACT_VALID_TO']->format('Y-m-d');?></td>
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