<?php
$lancar=0;
$days_1_30=0;
$days_31_60=0;
$days_61_90=0;
$days_91_120=0;
$days_121_150=0;
$days_151_180=0;
$lebih180=0;

$callSummary = "{call SP_GET_TAB_SUMMARY(?)}";
$optionsSummary =  array( "Scrollable" => "buffered" );
$paramsSummary = array(array($id, SQLSRV_PARAM_IN));
$execSummary = sqlsrv_query($conn, $callSummary, $paramsSummary, $optionsSummary) or die( print_r( sqlsrv_errors(), true));
$numRowsSummary = sqlsrv_num_rows($execSummary);
while($dataSummary = sqlsrv_fetch_array($execSummary)){
	$ktp=$dataSummary['KTP'];
	$nama=$dataSummary['FULL_NAME'];
	$duedays=$dataSummary['PASTDUE_DAYS'];
	if($duedays == 0){
		$lancar++;
	}else if($duedays >= 1 && $duedays <= 30){
		$days_1_30++;
	}else if($duedays >= 31 && $duedays <= 60){
		$days_31_60++;
	}else if($duedays >= 61 && $duedays <= 90){
		$days_61_90++;
	}else if($duedays >= 91 && $duedays <= 120){
		$days_91_120++;
	}else if($duedays >= 121 && $duedays <= 150){
		$days_121_150++;
	}else if($duedays >= 151 && $duedays <= 180){
		$days_151_180++;
	}else if($duedays > 180){
		$lebih180++;
	}else{
		
	}
}	
/* select table cip */
$callCIP = "{call SP_GET_TAB_DASHBOARD_TBL_CIP(?)}";
$paramsCIP = array(array($id, SQLSRV_PARAM_IN));
$execCIP = sqlsrv_query( $conn, $callCIP, $paramsCIP) or die( print_r( sqlsrv_errors(), true));
$dataCIP = sqlsrv_fetch_array($execCIP);

$totalPlafond2 = 0;
$totalBakiDebet2 = 0;
$totalJatuhTempo2 = 0;
$totalUsiaTunggakan2 = 0;

$callCONT2 = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
$optionsCONT2 =  array( "Scrollable" => "buffered" );
$paramsCONT2 = array(array($id, SQLSRV_PARAM_IN));
$execCONT2 = sqlsrv_query( $conn, $callCONT2, $paramsCONT2,$optionsCONT2) or die( print_r( sqlsrv_errors(), true));
						
while($dataCONT2 = sqlsrv_fetch_array($execCONT2)){
	$totalPlafond2 =+ $totalPlafond2 + $dataCONT2['TOTAL_AMOUNT_VALUE'];
	$totalBakiDebet2 =+ $totalBakiDebet2 + $dataCONT2['OUTSTANDING_AMOUNT_VALUE'];
	$totalJatuhTempo2 =+ $totalJatuhTempo2 + $dataCONT2['PASTDUE_AMOUNT_VALUE'];
	$totalUsiaTunggakan2 =+ $totalUsiaTunggakan2 + $dataCONT2['PASTDUE_DAYS'];
}
?>

<div class="card">
	<div class="header">
		<div class="row">
			<div class="col-md-11">
				<p class="name pull-left">Summary</p>
				<?php
					if($data3['CUST_TYPE'] == "PEMOHON"){
				?>
				<p class="pull-right">
					<?php
						if($numrowsPenjamin<>0){
					?>
					<a href="#" data-target="#dataDukcapilPenjamin" data-toggle="modal" class="btn btn-primary btn-sm" style="cursor:pointer;border:1px solid #035c7a;color:#035c7a;">
						CHECK SCORING PENJAMIN
					</a>
					<?php }else{ ?>
					<a href="#" disabled class="btn btn-primary btn-sm" style="border:1px solid #035c7a;color:#035c7a;" data-toggle="tooltip" title="Prospek ini tidak memiliki penjamin">
						CHECK SCORING PENJAMIN
					</a>
					<?php } ?>
				</p>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="content">
		<div class="row">
			<div class="col-md-11">
				<div class="card">
					<div class="content" style="padding:0px;">
						<div class="table-responsive">
							<table class="table" style="width:100%;">
								<tr>
									<td style="padding:10px;width:100px;"><img src="assets/img/default-user.png" style="width:100%;border-radius:50%;border:1px solid #CCC;"></td>
									<td style="vertical-align:middle;font-size:18px;"><b><?php echo strtoupper($nama);?></b><div style="font-size:16px;color:#AAA;"><?php echo $ktp;?></div></td>
									<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $dataCIP['SCORE'];?></b></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="card">
					<div class="content">
						<center>
							<div style="color:#AAA;">TOTAL FASILITAS</div>
							<div style="font-size:36px;font-weight:bold;"><?php echo $numRowsSummary;?></div>
						</center>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="content">
						<center>
							<div style="color:#AAA;">TOTAL PLAFOND</div>
							<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalPlafond2,0,',','.');?></div>
						</center>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="content">
						<center>
							<div style="color:#AAA;">TOTAL BAKI DEBET</div>
							<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($totalBakiDebet2,0,',','.');?></div>
						</center>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-11">
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;border:none;">
						<thead>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">Lancar</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">1 - 30</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">31 - 60</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">61 - 90</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">91 - 120</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">121 - 150</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">151 - 180</th>
							<th class="bg-td" style="width:12.5%;font-weight:bold;">> 180</th>
						</thead>
						<tbody>
							<tr>
								<td align="center"><?php echo $lancar;?></td>
								<td align="center"><?php echo $days_1_30;?></td>
								<td align="center"><?php echo $days_31_60;?></td>
								<td align="center"><?php echo $days_61_90;?></td>
								<td align="center"><?php echo $days_91_120;?></td>
								<td align="center"><?php echo $days_121_150;?></td>
								<td align="center"><?php echo $days_151_180;?></td>
								<td align="center"><?php echo $lebih180;?></td>
							</tr>
						</tbody>	
					</table>
					<p class="name">Daftar Fasilitas</p>
					<table class="table table-bordered" style="width:100%;font-size:10px;">
						<thead>
							<tr>
								<th class="bg-td">JENIS LEMBAGA</th>
								<th class="bg-td">JENIS FASILITAS</th>
								<th class="bg-td">TANGGAL PEMBUKAAN</th>
								<th class="bg-td">STATUS</th>
								<th class="bg-td">PLAFON</th>
								<th class="bg-td">BAKI DEBET</th>
								<th class="bg-td">JATUH TEMPO</th>
								<th class="bg-td">USIA TUNGGAKAN</th>
							</tr>
						</thead>						
						<tbody>
						<?php
							$totalPlafond = 0;
							$totalBakiDebet = 0;
							$totalJatuhTempo = 0;
							$totalUsiaTunggakan = 0;
							
							$callCONT = "{call SP_GET_TAB_CONTRACT_MAINDEBTOR(?)}";
							$optionsCONT =  array( "Scrollable" => "buffered" );
							$paramsCONT = array(array($id, SQLSRV_PARAM_IN));
							$execCONT = sqlsrv_query( $conn, $callCONT, $paramsCONT,$optionsCONT) or die( print_r( sqlsrv_errors(), true));
							while($dataCONT = sqlsrv_fetch_array($execCONT)){
								$totalPlafond =+ $totalPlafond + $dataCONT['TOTAL_AMOUNT_VALUE'];
								$totalBakiDebet =+ $totalBakiDebet + $dataCONT['OUTSTANDING_AMOUNT_VALUE'];
								$totalJatuhTempo =+ $totalJatuhTempo + $dataCONT['PASTDUE_AMOUNT_VALUE'];
								$totalUsiaTunggakan =+ $totalUsiaTunggakan + $dataCONT['PASTDUE_DAYS'];
						?>
							<tr>
								<td align="left"><?php echo $dataCONT['CREDITOR_TYPE'];?></td>
								<td align="left"><a href="#"><?php echo $dataCONT['CONTRACT_TYPE'];?></a></td>
								<td align="center"><?php echo $dataCONT['START_DATE']->format('Y-m-d');?></td>
								<td align="left"><?php echo $dataCONT['CONTRACT_STATUS'];?>
								<td align="right"><?php echo $dataCONT['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONT['TOTAL_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONT['OUTSTANDING_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONT['PASTDUE_AMOUNT_VALUE'],0,',','.');?></td>
								<td align="right"><?php echo $dataCONT['PASTDUE_DAYS'];?> Days</td>
							</tr>
							<?php
								}
							?>
							<tr>
								<td align="left" colspan="4"><b>Jumlah</b></td>
								<td align="right"><b>IDR <?php echo number_format($totalPlafond,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalBakiDebet,0,',','.');?></b></td>
								<td align="right"><b>IDR <?php echo number_format($totalJatuhTempo,0,',','.');?></b></td>
								<td align="right"><b><?php echo $totalUsiaTunggakan;?> Days</b></td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>		
		</div>		
	</div>				
</div>