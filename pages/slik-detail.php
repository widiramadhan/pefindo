<?php
require_once("config/configuration.php");
$noProsepekPemohonSLIK=$_GET['no'];
$cust_type=$_GET['custtype'];
$id=$_GET['id'];

$callSP = "{call SP_GET_SLIK_INDIVIDUAL_REPORT(?,?)}";
$options = array( "Scrollable" => "buffered" );
$params = array(array($noProsepekPemohonSLIK, SQLSRV_PARAM_IN),array($cust_type, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $callSP, $params, $options) or die( print_r( sqlsrv_errors(), true));
$numrows = sqlsrv_num_rows($exec);
$data = sqlsrv_fetch_array($exec);
?>
<style>
a{
	color:red;
}
th{
	text-align:center;
	font-weight:bold;
}
a:hover{
	color:red;
}
.text-default{
	color:#AAA;
}
.name{
	font-size:18px;
	font-weight:bold;
}
.table-borderless > tbody > tr > td{
    border: none;
}
ul > li > a {
	color:black;
}
ul > li > a:hover {
	color:red;
}
ul > li > .active > a:focus {
	color:red;
}
.box-yellow{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#ff8b00;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-green{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#009a00;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-red{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#c5071f;
	color:#FFF;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.box-white{
	padding:10px;
	font-size:24px;
	font-weight:bold;
	background-color:#FFF;
	color:#AAA;
	border:1px solid #AAA;
	width:80px;
	margin-right:10px;
	border-radius:5px;
	margin-bottom:10px;
}
.circle-green{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#009a00;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-red{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#c5071f;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-yellow{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#ff8b00;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.circle-default{
	padding:8px 5px 5px 5px;
	font-size:8px;
	font-weight:bold;
	background-color:#CCC;
	color:#FFF;
	border:0px solid #333;
	width:28px;
	height:28px;
	border-radius:50%;
}
.disclaimer{
	padding:30px;
	background-color:#EEE;
}
.bg-td{
	background-color:#f9f9f9;
}

.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
}
tr.header{
    cursor:pointer;
	display: table-row;
}
tr.child {
    display: none;
}
.th-custom{
	text-align:center;
	background-color:#035c7a;
}
.td-center{
	text-align:center;
}
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>
<script>
$(document).ready(function(){
  $("#collapseOne").on("hide.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-down text-danger"></span>');
  });
  $("#collapseOne").on("show.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-up text-danger"></span>');
  });
  $("#collapseOne2").on("hide.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-down text-danger"></span>');
  });
  $("#collapseOne2").on("show.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-up text-danger"></span>');
  });
});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="pull-left">
					<h4 class="title">SCORING REPORT <?php echo $data['TIPE_CUST'];?></h4>
					<p class="category">Host to Host SFI - Pefindo</p>
				</div>
				<div style="clear:both;"></div>
			</div>
			<?php
				if($data['DATA_NOT_FOUND']==1){
			?>
				<div class="content">
					<div class="card">
						<div class="header">
							<div class="row">
								<div class="col-md-11">
									<p class="name pull-left">Summary</p>
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
														<td style="vertical-align:middle;font-size:18px;"><b><?php echo strtoupper($data['CUST_NAME']);?></b><div style="font-size:16px;color:#AAA;"><?php echo $data['ID_NO'];?></div></td>
														<td style="vertical-align:middle;font-size:36px;width:200px;text-align:center;background-color:#035c7a;color:#FFF;"><div style="font-size:16px;">SCORE</div><b><?php echo $data['SLIK_SCORE'];?></b><br><div style="font-size:14px;"><?php echo $data['RANGE_DAYS_OD'];?></div></td>
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
												<div style="font-size:36px;font-weight:bold;"><?php echo $data['TOTAL_FASILITAS'];?></div>
											</center>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card">
										<div class="content">
											<center>
												<div style="color:#AAA;">TOTAL PLAFOND</div>
												<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($data['TOTAL_PLAFOND'],0,',','.');?></div>
											</center>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card">
										<div class="content">
											<center>
												<div style="color:#AAA;">TOTAL BAKI DEBET</div>
												<div style="font-size:36px;font-weight:bold;"><span style="color:#AAA;font-size:18px;">Rp.</span> <?php echo number_format($data['TOTAL_BAKI_DEBET'],0,',','.');?></div>
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
													<?php
														if($numrows <> 0){
													?>
													<td align="center"><?php if($data['DAYS_OD']==0){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 1 && $data['DAYS_OD'] <= 30){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 31 && $data['DAYS_OD'] <= 60){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 61 && $data['DAYS_OD'] <= 90){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 91 && $data['DAYS_OD'] <= 120){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 121 && $data['DAYS_OD'] <= 150){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] >= 151 && $data['DAYS_OD'] <= 180){ echo "<i class='fa fa-check'></i>";}?></td>
													<td align="center"><?php if($data['DAYS_OD'] > 180){ echo "<i class='fa fa-check'></i>";}?></td>
													<?php }else{ ?>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<td align="center"></td>
													<?php } ?>
												</tr>
											</tbody>	
										</table>
									</div>	
								</div>		
							</div>	
							<div class="row">
								<div class="col-md-11">
									<div class="table-responsive">
							<table class="table table-bordered table-striped" id="history" style="font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">JENIS FASILITAS</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">DAYS OD TERAKHIR</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">SLIK SCORE</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL PLAFOND</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL BAKI DEBET</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AWAL</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AKHIR</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$call = "{call SP_GET_FASILITAS_SLIK(?)}";
									$param = array(array($id, SQLSRV_PARAM_IN));
									$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
									$no=0;
									while($data4 = sqlsrv_fetch_array($exec)){
										$no++;
									?>
									<tr>
										<td class="td-center"><?php echo $no;?></td>
										<td><?php echo $data4['JENIS_FASILITAS'];?></td>
										<td class="td-center"><?php echo $data4['DAYS_OD_TERAKHIR'];?></td>
										<td class="td-center"><?php echo $data4['SLIK_SCORE'];?></td>
										<td style="text-align:right;">Rp. <?php echo number_format($data4['TOTAL_PLAFOND']);?></td>
										<td style="text-align:right;">Rp. <?php echo number_format($data4['TOTAL_BAKI_DEBET']);?></td>
										<td class="td-center"><?php if($data4['TANGGAL_AKAD_AWAL']<>NULL){echo $data4['TANGGAL_AKAD_AWAL']->format('Y-m-d');}?></td>
										<td class="td-center"><?php if($data4['TANGGAL_AKAD_AKHIR']<>NULL){echo $data4['TANGGAL_AKAD_AKHIR']->format('Y-m-d');}?></td>
										<td class="td-center"><?php echo $data4['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
										</div>	
								</div>		
							</div>	
							<div class="row">
								<div class="col-md-11">
									<?php
										$callPDF = "{call SP_GET_PDF_SLIK(?)}";
										$paramPDF = array(array($data['PEFINDO_MAPPING_ID'], SQLSRV_PARAM_IN));
										$execPDF = sqlsrv_query($conn, $callPDF, $paramPDF) or die( print_r( sqlsrv_errors(), true));
										$dataPDF = sqlsrv_fetch_array($execPDF);

										$file = "http://172.16.2.6/h2h_pefindo/assets/doc/".$dataPDF['PDF_SRC'];
										
										if($dataPDF['PDF_SRC'] <> ""){
											if($file){
												echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/'.$dataPDF['PDF_SRC'].'" style="width:100%;height:700px;"></iframe>';
												echo'a';
											}else{
												echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
												echo'b';
											}
										}else{
											echo'<iframe src="http://172.16.2.6/h2h_pefindo/assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
												echo'c';
										}
									?>
								</div>
							</div>
						</div>				
					</div>
				</div>
			<?php
				}else{
			?>
				<div class="content">
					<div class="card">
						<div class="header">
							<div class="row">
								<div class="col-md-12">
									<center>
										<h3>DATA <?php echo $data['TIPE_CUST'];?> <br>TIDAK DITEMUKAN DI PEFINDO DAN SLIK</h3><br>
									</center>
									<br><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(window).on("load", function(){
		setTimeout(function(){
			$("#loader").fadeOut("slow");
		}, 2000);
	});
</script>
<script>
$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});
</script>