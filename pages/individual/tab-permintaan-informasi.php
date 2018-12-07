<?php
/* select table M_INQUIRIES_SUMMARY */
$callPERMIN = "{call SP_GET_TAB_PERMINTAAN_INFORMASI(?)}";
$paramsPERMIN = array(array($id, SQLSRV_PARAM_IN));
$execPERMIN = sqlsrv_query( $conn, $callPERMIN, $paramsPERMIN) or die( print_r( sqlsrv_errors(), true));
$dataPERMIN = sqlsrv_fetch_array($execPERMIN);
?>
<div id="Permintaan" class="tab-pane fade in active"> 
	<div class="card">
		<div class="header">
			<p class="name">Permintaan Informasi</p>
		</div>
		<div class="content">
			<div class="row">
				<div class="col-md-12">
					<p class="name text-danger">Jumlah permintaan informasi di bulan lalu</p>
					<div class="table-responsive">
						<table class="table table-bordered" style="width:100%;">
							<thead>
								<tr>
									<th class="bg-td"><b>1 Bulan</b></th>
									<th class="bg-td"><b>3 Bulan</b></th>
									<th class="bg-td"><b>6 Bulan</b></th>
									<th class="bg-td"><b>12 Bulan</b></th>
									<th class="bg-td"><b>24 Bulan</b></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center" ><?php echo $dataPERMIN['NUMBER_OF_INQUIRIES_LAST_1MONTHS'];?></td>
									<td align="center" ><?php echo $dataPERMIN['NUMBER_OF_INQUIRIES_LAST_3MONTHS'];?></td>
									<td align="center" ><?php echo $dataPERMIN['NUMBER_OF_INQUIRIES_LAST_6MONTHS'];?></td>
									<td align="center" ><?php echo $dataPERMIN['NUMBER_OF_INQUIRIES_LAST_12MONTHS'];?></td>
									<td align="center" ><?php echo $dataPERMIN['NUMBER_OF_INQUIRIES_LAST_24MONTHS'];?></td>
								</tr>
							</tbody>
						</table>
						<div class="table-responsive">
								<table class="table table-bordered" style="width:100%;">
								<p class="name text-danger">15 permintaan informasi terakhir</p>
									<thead>
										<tr>
											<th class="bg-td">TANGGAL PERMINTAAN INFORMASI</th>
											<th class="bg-td">TUJUAN</th>
											<th class="bg-td">SEKTOR</th>
										</tr>
									</thead>
									<tbody>
										<?php
											/* select table M_INQUIRIES_SUMMARY */
											$callPERMINLIST = "{call SP_GET_TAB_PERMINTAAN_INFORMASI_LIST(?)}";
											$paramsPERMINLIST = array(array($id, SQLSRV_PARAM_IN));
											$execPERMINLIST = sqlsrv_query( $conn, $callPERMINLIST, $paramsPERMINLIST) or die( print_r( sqlsrv_errors(), true));
											while($dataPERMINLIST = sqlsrv_fetch_array($execPERMINLIST)){
										?>
										<tr>
											<td><?php echo $dataPERMINLIST['DATE_OF_INQUIRY']->format('Y-m-d');?></td>
											<td><?php echo $dataPERMINLIST['REASON'];?></td>
											<td><?php echo $dataPERMINLIST['SECTOR'];?></td>
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
	</div>
</div>