<?php
/* select table M_INQUIRIES_SUMMARY */
$callDISPUSCOM = "{call SP_GET_TAB_PENGADUAN_COMPANY(?)}";
$paramsDISPUSCOM = array(array($id, SQLSRV_PARAM_IN));
$execDISPUSCOM = sqlsrv_query( $conn, $callDISPUSCOM, $paramsDISPUSCOM) or die( print_r( sqlsrv_errors(), true));
$dataDISPUSCOM = sqlsrv_fetch_array($execDISPUSCOM);
?>
<div id="Pengaduan" class="tab-pane fade in active"> 
		<div class="card">
			<div class="header"><p class="name">Pengaduan</p></div>
				<div class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<tbody>
									<table class="table table-bordered" style="width:100%;">
									<tr>
										<td colspan = "4" class="bg-td"><b>DETIL PENGADUAN</td></b>
									</tr>
										<tr>
											<td class="bg-td" width="30%"><b>Pengaduan Aktif - Fasilitas</td></b>
											<td align="right" width="20%"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_ACTIVE_CONTRACT'];?></td>
											<td class="bg-td" width="30%"><b>Pengaduan yang diselesaikan di waktu lalu - Fasilitas</td></b>
											<td align="right" width="20%"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_CLOSED_CONTRACT'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Pengaduan Aktif - Pribadi</td></b>
											<td align="right"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_ACTIVE_SUBJECT_DATA'];?></td>
											<td class="bg-td"><b>Pengaduan yang diselesaikan di waktu lalu - data identitas</td></b>
											<td align="right"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_CLOSED_SUBJECT_DATA'];?></td>
										</tr>
										<tr>
											<td class="bg-td"><b>Pengaduan Aktif - Dalam Pengadilan</td></b>
											<td align="right"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_ACTIVE_IN_COUR'];?></td>
											<td class="bg-td"><b>Jumlah pengaduan yang tidak sah di masa lalu</td></b>
											<td align="right"><?php echo $dataDISPUSCOM['SUMMARY_NUMBER_OF_FALSE'];?></td>
										</tr>
									</table>	
								</tbody>
								<div class="disclaimer">
									<b>Disclaimer PBK</b><br>
									Informasi Perkreditan ini didasarkan pada data yang dihimpun dari Sistem Informasi Debitur Bank Indonesia / Sistem Layanan Informasi Keuangan (SLIK) Otoritas Jasa Keuangan (OJK), Lembaga Keuangan yang menjadi Anggota atau Mitra PEFINDO Biro Kredit (PBK), serta instansi pemerintah maupun pihak swasta yang menjadi sumber data PBK.<br>
									PBK tidak bertanggungjawab atas kebenaran dan keakuratan data yang dihimpun dari pemberi data.<br>
									PBK tidak bertanggungjawab terhadap segala akibat yang timbul sehubungan dengan ketidakbenaran dan ketidakakuratan data serta penggunaan Informasi Perkreditan ini di kemudian hari.<br>
									PBK menerima aduan atas indikasi ketidakbenaran dan ketidakakuratan data dan akan menindaklanjuti sesuai ketentuan peraturan perundangan yang berlaku.	
								</div>
							</div>	
						</div>		
					</div>		
				</div>				
		</div>						
	</div>		