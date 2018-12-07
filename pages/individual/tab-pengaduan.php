<?php
/* select table M_INQUIRIES_SUMMARY */
$callDISPUS = "{call SP_GET_TAB_PENGADUAN(?)}";
$paramsDISPUS = array(array($id, SQLSRV_PARAM_IN));
$execDISPUS = sqlsrv_query( $conn, $callDISPUS, $paramsDISPUS) or die( print_r( sqlsrv_errors(), true));
$dataDISPUS = sqlsrv_fetch_array($execDISPUS);
?>
<div class="card">
	<div class="header">
		<p class="name">Pengaduan</p>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<td colspan = "4" class="bg-td"><b>DETIL PENGADUAN</td></b>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="bg-td" width="30%"><b>Pengaduan Aktif - Fasilitas</td></b>
								<td align="right" width="20%"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_ACTIVE_CONTRACT'];?></td>
								<td class="bg-td" width="30%"><b>Pengaduan yang diselesaikan di waktu lalu - Fasilitas</td></b>
								<td align="right" width="20%"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_CLOSED_CONTRACT'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Pengaduan Aktif - Pribadi</td></b>
								<td align="right"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_ACTIVE_SUBJECT_DATA'];?></td>
								<td class="bg-td"><b>Pengaduan yang diselesaikan di waktu lalu - data identitas</td></b>
								<td align="right"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_CLOSED_SUBJECT_DATA'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Pengaduan Aktif - Dalam Pengadilan</td></b>
								<td align="right"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_ACTIVE_IN_COUR'];?></td>
								<td class="bg-td"><b>Jumlah pengaduan yang tidak sah di masa lalu</td></b>
								<td align="right"><?php echo $dataDISPUS['SUMMARY_NUMBER_OF_FALSE'];?></td>
							</tr>
						</tbody>	
					</table>
				</div>	
			</div>		
		</div>		
	</div>				
</div>