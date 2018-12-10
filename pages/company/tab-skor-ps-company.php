<?php
	$callCIPCOM = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
	$paramsCIPCOM = array(array($id, SQLSRV_PARAM_IN));
	$execCIPCOM = sqlsrv_query($conn, $callCIPCOM, $paramsCIPCOM) or die( print_r( sqlsrv_errors(), true));
	$dataCIPCOM=sqlsrv_fetch_array($execCIPCOM);
?>
<div class="card">
	<div class="header"><p class="name">PEFINDO Predictor (CIP)</p></div>
	<div class="content">
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="bg-td" colspan="4" style="text-align:left;"><p class="name text-default">INFO PEFINDO PREDICTOR<p></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="bg-td" style="vertical-align:middle;width:20%;">Skor PS</td>
						<td style="vertical-align:middle;width:30%;"><?php echo $dataCIPCOM['SCORE'];?></td>
						<td class="bg-td" style="vertical-align:middle;width:20%;">Kategori risiko</td>
						<td style="vertical-align:middle;width:30%;">
							<?php
								if($dataCIPCOM['GRADE'] == "E3" || $dataCIPCOM['GRADE'] == "E2" || $dataCIPCOM['GRADE'] == "E1"){
									echo'<div class="box-red" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM['GRADE'] == "D3" || $dataCIPCOM['GRADE'] == "D2" || $dataCIPCOM['GRADE'] == "D1"){
									echo'<div class="box-red" style="background-color:#f3334b;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM['GRADE'] == "C3" || $dataCIPCOM['GRADE'] == "C2" || $dataCIPCOM['GRADE'] == "C1"){
									echo'<div class="box-yellow" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM['GRADE'] == "B3" || $dataCIPCOM['GRADE'] == "B2" || $dataCIPCOM['GRADE'] == "B1"){
									echo'<div class="box-green" style="background-color:#01b701;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else{
									echo'<div class="box-green" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}
							?>
								<center><?php echo $dataCIPCOM['GRADE'];?><!-- C3 --></center>
							</div>
						</td>
					</tr>
					<tr>
						<td class="bg-td">Kemungkinan gagal bayar (%)</td>
						<td><?php echo $dataCIPCOM['PROBABILITY_OF_DEFAULT'];?>
							<?php
								if($dataCIPCOM['TREND'] == "Down"){
									echo'<i class="fa fa-arrow-down text-danger"></i>';
								}else if($dataCIPCOM['TREND'] == "Up"){
									echo'<i class="fa fa-arrow-up text-success"></i>';
								}else{
									echo'<i class="fa fa-arrow-right"></i>';
								}
							?>
						</td>
						<td class="bg-td">Keterangan</td>
						<td>
							<?php
								if($dataCIPCOM['GRADE'] == "E3" || $dataCIPCOM['GRADE'] == "E2" || $dataCIPCOM['GRADE'] == "E1"){
									echo'Risiko Sangat Tinggi';
								}else if($dataCIPCOM['GRADE'] == "D3" || $dataCIPCOM['GRADE'] == "D2" || $dataCIPCOM['GRADE'] == "D1"){
									echo'Risiko Tinggi';
								}else if($dataCIPCOM['GRADE'] == "C3" || $dataCIPCOM['GRADE'] == "C2" || $dataCIPCOM['GRADE'] == "C1"){
									echo'Risiko Sedang';
								}else if($dataCIPCOM['GRADE'] == "B3" || $dataCIPCOM['GRADE'] == "B2" || $dataCIPCOM['GRADE'] == "B1"){
									echo'Risiko Rendah';
								}else{
									echo'Risiko Sangat Rendah';
								}
							?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<br><br>
		<center>
			<img src="assets/img/PefindoScore.png" style="width:50%;">
		</center>
		<br>
		<p class="name text-danger">Keterangan terkait resiko</p>	
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="bg-td"><p style="text-align:left;font-weight:bold;">KODE</p></th>
						<th class="bg-td"><p style="text-align:left;font-weight:bold;">KETERANGAN</p></th>
					</tr>
				</thead>
				<tbody>
					<?php
						/* select table subject info history contact list */
						$callReasonListCom = "{call SP_GET_TAB_SKOR_PS_TBL_REASON_LIST_COMPANY(?,?)}";
						$paramsReasonListCom = array(array($id, SQLSRV_PARAM_IN),array($dataCIPCOM['M_CIP_ID'], SQLSRV_PARAM_IN));
						$execReasonListCom = sqlsrv_query( $conn, $callReasonListCom, $paramsReasonListCom) or die( print_r( sqlsrv_errors(), true));
						while($dataReasonListCom = sqlsrv_fetch_array($execReasonListCom)){
					?>
					<tr>
						<td><b><?php echo $dataReasonListCom['CODE'];?></b></td>
						<td><?php echo $dataReasonListCom['DESCRIPTION'];?></td>
					</tr>
					<?php
						} 
					?>
				</tbody>
			</table>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="bg-td"><p style="text-align:left;font-weight:bold;">SKOR HISTORIS</p></th>
					</tr>
				</thead>
			</table>
		</div>
		<center><div id="container" style="width:80%;"></div></center>
		<br>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width='20%'>BULAN / TAHUN</th>
						<?php
							$callCIPCOM2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
							$paramsCIPCOM2 = array(array($id, SQLSRV_PARAM_IN));
							$execCIPCOM2 = sqlsrv_query($conn, $callCIPCOM2, $paramsCIPCOM2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIPCOM=sqlsrv_fetch_array($execCIPCOM2)){
								if($dataCIPCOM['DATE']==NULL){
									echo "<th></th>";
								}else{
									echo "<th>".$dataCIPCOM['DATE']->format('m/Y')."</th>";
								}
							}
						?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Skor PS</b></td>
						<?php
							$callCIPCOM2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
							$paramsCIPCOM2 = array(array($id, SQLSRV_PARAM_IN));
							$execCIPCOM2 = sqlsrv_query($conn, $callCIPCOM2, $paramsCIPCOM2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIPCOM=sqlsrv_fetch_array($execCIPCOM2)){
								echo "<td align='center'>".$dataCIPCOM['SCORE']."</td>";
							}
						?>
					</tr>
					<tr>
						<td><b>Kemungkinan gagal bayar</b></td>
						<?php
							$callCIPCOM2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
							$paramsCIPCOM2 = array(array($id, SQLSRV_PARAM_IN));
							$execCIPCOM2 = sqlsrv_query($conn, $callCIPCOM2, $paramsCIPCOM2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIPCOM2=sqlsrv_fetch_array($execCIPCOM2)){
								echo "<td align='center'>".$dataCIPCOM2['PROBABILITY_OF_DEFAULT']."% </td>";
							}
						?>
					</tr>
					<tr>
						<td><b>Kategori Risiko</b></td>
						<?php
							$callCIPCOM2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP_COMPANY(?)}";
							$paramsCIPCOM2 = array(array($id, SQLSRV_PARAM_IN));
							$execCIPCOM2 = sqlsrv_query($conn, $callCIPCOM2, $paramsCIPCOM2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIPCOM2=sqlsrv_fetch_array($execCIPCOM2)){
								echo "<td align='center'>";
								if($dataCIPCOM2['GRADE'] == "E3" || $dataCIPCOM2['GRADE'] == "E2" || $dataCIPCOM2['GRADE'] == "E1"){
									echo'<div class="box-red" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM2['GRADE'] == "D3" || $dataCIPCOM2['GRADE'] == "D2" || $dataCIPCOM2['GRADE'] == "D1"){
									echo'<div class="box-red" style="background-color:#f3334b;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM2['GRADE'] == "C3" || $dataCIPCOM2['GRADE'] == "C2" || $dataCIPCOM2['GRADE'] == "C1"){
									echo'<div class="box-yellow" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIPCOM2['GRADE'] == "B3" || $dataCIPCOM2['GRADE'] == "B2" || $dataCIPCOM2['GRADE'] == "B1"){
									echo'<div class="box-green" style="background-color:#01b701;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else{
									echo'<div class="box-green" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}
								echo $dataCIPCOM2['GRADE'];
								echo "</td>";
							}
						?>
					</tr>
				</tbody>
			</table>
		</div>			
	</div>
</div>