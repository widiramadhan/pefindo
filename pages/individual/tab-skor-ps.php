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
						<td style="vertical-align:middle;width:30%;"><?php echo $dataCIP['SCORE'];?></td>
						<td class="bg-td" style="vertical-align:middle;width:20%;">Kategori risiko</td>
						<td style="vertical-align:middle;width:30%;">
							<?php
								if($dataCIP['GRADE'] == "E3" || $dataCIP['GRADE'] == "E2" || $dataCIP['GRADE'] == "E1"){
									echo'<div class="box-red" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP['GRADE'] == "D3" || $dataCIP['GRADE'] == "D2" || $dataCIP['GRADE'] == "D1"){
									echo'<div class="box-red" style="background-color:#f3334b;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP['GRADE'] == "C3" || $dataCIP['GRADE'] == "C2" || $dataCIP['GRADE'] == "C1"){
									echo'<div class="box-yellow" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP['GRADE'] == "B3" || $dataCIP['GRADE'] == "B2" || $dataCIP['GRADE'] == "B1"){
									echo'<div class="box-green" style="background-color:#01b701;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else{
									echo'<div class="box-green" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}
							?>
								<center><?php echo $dataCIP['GRADE'];?><!-- C3 --></center>
							</div>
						</td>
					</tr>
					<tr>
						<td class="bg-td">Kemungkinan gagal bayar (%)</td>
						<td><?php echo $dataCIP['PROBABILITY_OF_DEFAULT'];?>
							<?php
								if($dataCIP['TREND'] == "Down"){
									echo'<i class="fa fa-arrow-down text-danger"></i>';
								}else if($dataCIP['TREND'] == "Up"){
									echo'<i class="fa fa-arrow-up text-success"></i>';
								}else{
									echo'<i class="fa fa-arrow-right"></i>';
								}
							?>
						</td>
						<td class="bg-td">Keterangan</td>
						<td>
							<?php
								if($dataCIP['GRADE'] == "E3" || $dataCIP['GRADE'] == "E2" || $dataCIP['GRADE'] == "E1"){
									echo'Risiko Sangat Tinggi';
								}else if($dataCIP['GRADE'] == "D3" || $dataCIP['GRADE'] == "D2" || $dataCIP['GRADE'] == "D1"){
									echo'Risiko Tinggi';
								}else if($dataCIP['GRADE'] == "C3" || $dataCIP['GRADE'] == "C2" || $dataCIP['GRADE'] == "C1"){
									echo'Risiko Sedang';
								}else if($dataCIP['GRADE'] == "B3" || $dataCIP['GRADE'] == "B2" || $dataCIP['GRADE'] == "B1"){
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
						$callReasonList = "{call SP_GET_TAB_SKOR_PS_TBL_REASON_LIST(?,?)}";
						$paramsReasonList = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
						$execReasonList = sqlsrv_query( $conn, $callReasonList, $paramsReasonList) or die( print_r( sqlsrv_errors(), true));
						while($dataReasonList = sqlsrv_fetch_array($execReasonList)){
					?>
					<tr>
						<td><b><?php echo $dataReasonList['CODE'];?></b></td>
						<td><?php echo $dataReasonList['DESCRIPTION'];?></td>
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
							$callCIP2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP(?)}";
							$paramsCIP2 = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
							$execCIP2 = sqlsrv_query( $conn, $callCIP2, $paramsCIP2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIP2 = sqlsrv_fetch_array($execCIP2)){
								if($dataCIP2['DATE']==NULL){
									echo "<th></th>";
								}else{
									echo "<th>".$dataCIP2['DATE']->format('m/Y')."</th>";
								}
							}
						?>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>Skor PS</b></td>
						<?php
							$callCIP2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP(?)}";
							$paramsCIP2 = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
							$execCIP2 = sqlsrv_query( $conn, $callCIP2, $paramsCIP2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIP2 = sqlsrv_fetch_array($execCIP2)){
								echo "<td align='center'>".$dataCIP2['SCORE']."</td>";
							}
						?>
					</tr>
					<tr>
						<td><b>Kemungkinan gagal bayar</b></td>
						<?php
							$callCIP2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP(?)}";
							$paramsCIP2 = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
							$execCIP2 = sqlsrv_query( $conn, $callCIP2, $paramsCIP2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIP2 = sqlsrv_fetch_array($execCIP2)){
								echo "<td align='center'>".$dataCIP2['PROBABILITY_OF_DEFAULT']."% </td>";
							}
						?>
					</tr>
					<tr>
						<td><b>Kategori Risiko</b></td>
						<?php
							$callCIP2 = "{call SP_GET_TAB_SKOR_PS_TBL_CIP(?)}";
							$paramsCIP2 = array(array($id, SQLSRV_PARAM_IN),array($dataCIP['M_CIP_ID'], SQLSRV_PARAM_IN));
							$execCIP2 = sqlsrv_query( $conn, $callCIP2, $paramsCIP2) or die( print_r( sqlsrv_errors(), true));
							while($dataCIP2 = sqlsrv_fetch_array($execCIP2)){
								echo "<td align='center'>";
								if($dataCIP2['GRADE'] == "E3" || $dataCIP2['GRADE'] == "E2" || $dataCIP2['GRADE'] == "E1"){
									echo'<div class="box-red" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP2['GRADE'] == "D3" || $dataCIP2['GRADE'] == "D2" || $dataCIP2['GRADE'] == "D1"){
									echo'<div class="box-red" style="background-color:#f3334b;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP2['GRADE'] == "C3" || $dataCIP2['GRADE'] == "C2" || $dataCIP2['GRADE'] == "C1"){
									echo'<div class="box-yellow" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}else if($dataCIP2['GRADE'] == "B3" || $dataCIP2['GRADE'] == "B2" || $dataCIP2['GRADE'] == "B1"){
									echo'<div class="box-green" style="background-color:#01b701;width:30px;height:25px;font-size:12px;padding:5px;">';
								}else{
									echo'<div class="box-green" style="width:30px;height:25px;font-size:12px;padding:5px;">';
								}
								echo $dataCIP2['GRADE'];
								echo "</td>";
							}
						?>
					</tr>
				</tbody>
			</table>
		</div>			
	</div>
</div>