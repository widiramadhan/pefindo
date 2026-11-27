<style>
a{
	color:#035c7a;
}
th{
	text-align:center;
	font-weight:bold;
}
a:hover{
	color:#035c7a;
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
	color:#035c7a;
}
ul > li > .active > a:focus {
	color:#035c7a;
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
	background-color:#035c7a;
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
	background-color:#035c7a;
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
tr.header{
    cursor:pointer;
	display: table-row;
}
tr.child {
    display: none;
}
.text-custom{
	color:#035c7a;
}
</style>
<script>
$(document).ready(function(){
  $("#collapseOne").on("hide.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
  });
  $("#collapseOne").on("show.bs.collapse", function(){
    $(".card-link").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
  });
  $("#collapseOne2").on("hide.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-down" style="color:#035c7a;"></span>');
  });
  $("#collapseOne2").on("show.bs.collapse", function(){
    $(".card-link2").html('<span class="fa fa-chevron-up" style="color:#035c7a;"></span>');
  });
});
</script>
<?php
require_once("config/connection.php");
require_once("header.php");
$id=$_GET['id'];
$prospect_no=$_GET['prospect_no'];
$user=$_GET['USERNAME'];
$date=date("Y-m-d");

?>


<div class="card">
	<div class="header"><p class="name">Daftar Fasilitas</p></div>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
			<p class="name">Rincian Fasilitas</p>	

			
			
				<p class="name text-custom">Penjamin Aktif</p>	
				<?php
					$no=300;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("Guarantor", SQLSRV_PARAM_IN),array("Open", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;

				?>
				
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-custom"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sifat Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CHARACTERISTIC'];?></td>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
										<td class="bg-td"><b>Orientasi Penggunaan</b></td>
										<td><?php echo $dataCONSUSECX['ORIENTATION_OF_USE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['SYNDICATED_LOAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Kategori Debitur</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Lokasi Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_LOCATION']<>NULL){echo $dataCONSUSECX['PROJECT_LOCATION'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
										<td class="bg-td"><b>Nilai Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_VALUE']<>NULL){echo $dataCONSUSECX['PROJECT_VALUE'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Program Pemerintah</b></td>
										<td><?php echo $dataCONSUSECX['GOVERMENT_PROGRAM'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Branch</b></td>
										<td><?php if($dataCONSUSECX['BRANCH']<>NULL){echo $dataCONSUSECX['BRANCH'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Akad Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_SUB_TYPE'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Restrukturisasi Awal</b></td>
										<td><?php if($dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Suku Bunga</b></td>
										
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d')<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bank Beneficiery</td>
										<td align="right"><?php if($dataCONSUSECX['BANK_BENEFICIARY']<>NULL){echo $dataCONSUSECX['BANK_BENEFICIARY'];}else{echo"-";}?></td>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE'];}else {echo "0";}?>%</td>
										<td class="bg-td">Setoran Jaminan</td>
										<td align="right"><?php if($dataCONSUSECX['GUARANTY_DEPOSIT']<>NULL){echo $dataCONSUSECX['GUARANTY_DEPOSIT'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURED_COUNT']<>NULL){echo $dataCONSUSECX['RESTRUCTURED_COUNT'];}else {echo "-";}?></td>
										<td class="bg-td">Jenis Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE_TYPE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE_TYPE'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Kode Cara Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURING_REASON']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_REASON'];}else{echo"-";}?></td>
										<td class="bg-td">Frekuensi Perpanjangan</td>
										<td align="right"><?php if($dataCONSUSECX['PROLONGATION_COUNTER']<>NULL){echo $dataCONSUSECX['PROLONGATION_COUNTER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Keterangan</td>
										<td align="right" colspan="3"></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php
					}	}
				?>
				
				<br>
				
				<!-- PENJAMIN NON AKTIF-->
				<p class="name text-custom">Penjamin Non Aktif</p>	
				<?php
					$no=300;
					$callCONSUSECX = "{call SP_GET_TAB_CONTRACT(?,?,?)}";
					$paramsCONSUSECX = array(array($id, SQLSRV_PARAM_IN),array("Guarantor", SQLSRV_PARAM_IN),array("Closed", SQLSRV_PARAM_IN));
					$options =  array( "Scrollable" => "buffered" );
					$execCONSUSECX = sqlsrv_query( $conn, $callCONSUSECX, $paramsCONSUSECX,$options) or die( print_r( sqlsrv_errors(), true));
					$nums = sqlsrv_num_rows($execCONSUSECX);
					if($nums == 0 ){
						echo"<div style='border:1px solid #EEE;padding:5px;'> Tidak ada fasilitas</div>";
					}else{
					while($dataCONSUSECX = sqlsrv_fetch_array($execCONSUSECX)){
						$no++;

				?>
				
				<div id="accordion<?php echo $no;?>">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="font-size:14px;"><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link2" data-toggle="collapse" href="#collapseOne<?php echo $no;?>">
									<i class="fa fa-chevron-down text-custom"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne<?php echo $no;?>" class="collapse content" data-parent="#accordion<?php echo $no;?>">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Peran Nasabah</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['ROLE_OF_CLIENT'];?></td>
										<td width="30%" class="bg-td"><b>Fase Fasilitas</b></td>
										<td width="20%"><?php echo $dataCONSUSECX['PHASE_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_TYPE'];?></td>
										<td class="bg-td"><b>Status Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_STATUS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sifat Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CHARACTERISTIC'];?></td>
										<td class="bg-td"><b>Kolektibilitas</b></td>
										<td><?php echo $dataCONSUSECX['NEGATIVE_STATUS_OF_CONTRACT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tujuan Pendanaan</b></td>
										<td><?php echo $dataCONSUSECX['PURPOSE_OF_FINANCING'];?></td>
										<td class="bg-td"><b>Orientasi Penggunaan</b></td>
										<td><?php echo $dataCONSUSECX['ORIENTATION_OF_USE'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Sektor Ekonomi</b></td>
										<td><?php echo $dataCONSUSECX['ECONOMIC_SECTOR'];?></td>
										<td class="bg-td"><b>Pinjaman sindikasi</b></td>
										<td><?php echo $dataCONSUSECX['SYNDICATED_LOAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Kategori Debitur</b></td>
										<td><?php echo $dataCONSUSECX['CREDIT_CLASIFICATION'];?></td>
										<td class="bg-td"><b>Nama Tertanggung</b></td>
										<td><?php if($dataCONSUSECX['NAME_OF_INSURED']<>NULL){echo $dataCONSUSECX['NAME_OF_INSURED'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Mata Uang Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CURRENCY'];?></td>
										<td class="bg-td"><b>Lokasi Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_LOCATION']<>NULL){echo $dataCONSUSECX['PROJECT_LOCATION'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Fasilitas</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_CODE'];?></td>
										<td class="bg-td"><b>Nilai Proyek</b></td>
										<td><?php if($dataCONSUSECX['PROJECT_VALUE']<>NULL){echo $dataCONSUSECX['PROJECT_VALUE'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Program Pemerintah</b></td>
										<td><?php echo $dataCONSUSECX['GOVERMENT_PROGRAM'];?></td>
										<td class="bg-td"><b>Jenis Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR_TYPE'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Pemberi Pinjaman</b></td>
										<td><?php echo $dataCONSUSECX['CREDITOR'];?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Branch</b></td>
										<td><?php if($dataCONSUSECX['BRANCH']<>NULL){echo $dataCONSUSECX['BRANCH'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td colspan="2"></td>
										<td class="bg-td"><b>Akad Kredit</b></td>
										<td><?php echo $dataCONSUSECX['CONTRACT_SUB_TYPE'];?></td>
									</tr>
								</table>
							</div>
							<br>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>TANGGAL FASILITAS</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Tanggal Pencairan</b></td>
										<td width="20%"><?php if($dataCONSUSECX['DISBURSEMENT_DATE']<>NULL){echo $dataCONSUSECX['DISBURSEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
										<td width="20%"><?php if($dataCONSUSECX['RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Mulai</b></td>
										<td><?php if($dataCONSUSECX['START_DATE']<>NULL){echo $dataCONSUSECX['START_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Restrukturisasi Awal</b></td>
										<td><?php if($dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']<>NULL){echo $dataCONSUSECX['INITIAL_RESTRUCTURING_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Pengkinian Terakhir</b></td>
										<td><?php if($dataCONSUSECX['LAST_UPDATE']<>NULL){echo $dataCONSUSECX['LAST_UPDATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
										<td><?php if($dataCONSUSECX['MATURITY_DATE']<>NULL){echo $dataCONSUSECX['MATURITY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tanggal Kondisi</b></td>
										<td><?php if($dataCONSUSECX['CONDITION_DATE']<>NULL){echo $dataCONSUSECX['CONDITION_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal pelunasan</b></td>
										<td><?php if($dataCONSUSECX['REAL_END_DATE']<>NULL){echo $dataCONSUSECX['REAL_END_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>RINCIAN KONTRAK AWAL</b></p></td>
									</tr>
									<tr>
										<td width="30%" class="bg-td"><b>Jumlah Plafond</b></td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td"><b>Suku Bunga</b></td>
										
									</tr>
									<tr>
										<td class="bg-td"><b>Plafond Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INITIAL_TOTAL_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['INITIAL_TOTAL_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Nomor Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Baki Debet</b></td>
										<td align="right"><?php if($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']<>NULL){echo $dataCONSUSECX['TOTAL_TAKEN_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_TAKEN_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td"><b>Tanggal Akad Awal</b></td>
										<td align="right"><?php if($dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d')<>NULL){echo $dataCONSUSECX['INITIAL_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Total Plafon Fasilitas</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['TOTAL_FACILITY_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['TOTAL_FACILITY_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Nomor Akad Terakhir</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_NUMBER']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_NUMBER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Terutang</td>
										<td align="right"><?php if($dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['OUTSTANDING_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['OUTSTANDING_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Akad Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_AGREEMENT_DATE']<>NULL){echo $dataCONSUSECX['LAST_AGREEMENT_DATE']->format('Y-m-d');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Saldo Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_BALANCE_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_BALANCE_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Penggunaan Kredit Dalam 30 Hari Terakhir</td>
										<td align="right"><?php if($dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS']<>NULL){echo $dataCONSUSECX['CREDIT_USAGE_LAST_30_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bank Beneficiery</td>
										<td align="right"><?php if($dataCONSUSECX['BANK_BENEFICIARY']<>NULL){echo $dataCONSUSECX['BANK_BENEFICIARY'];}else{echo"-";}?></td>
										<td class="bg-td">Denda</td>
										<td align="right"><?php if($dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PENALTY_CURRENCY']." ".number_format($dataCONSUSECX['PENALTY_VALUE'],0,',','.');}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE'];}else {echo "0";}?>%</td>
										<td class="bg-td">Setoran Jaminan</td>
										<td align="right"><?php if($dataCONSUSECX['GUARANTY_DEPOSIT']<>NULL){echo $dataCONSUSECX['GUARANTY_DEPOSIT'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURED_COUNT']<>NULL){echo $dataCONSUSECX['RESTRUCTURED_COUNT'];}else {echo "-";}?></td>
										<td class="bg-td">Jenis Suku Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_INTEREST_RATE_TYPE']<>NULL){echo $dataCONSUSECX['LAST_INTEREST_RATE_TYPE'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Kode Cara Restrukturisasi</td>
										<td align="right"><?php if($dataCONSUSECX['RESTRUCTURING_REASON']<>NULL){echo $dataCONSUSECX['RESTRUCTURING_REASON'];}else{echo"-";}?></td>
										<td class="bg-td">Frekuensi Perpanjangan</td>
										<td align="right"><?php if($dataCONSUSECX['PROLONGATION_COUNTER']<>NULL){echo $dataCONSUSECX['PROLONGATION_COUNTER'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Keterangan</td>
										<td align="right" colspan="3"></td>
									</tr>
								</table>
							</div>
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td width="30%" class="bg-td">Nominal Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td width="30%" class="bg-td">Umur Tunggakan</td>
										<td width="20%" align="right"><?php if($dataCONSUSECX['PASTDUE_DAYS']<>NUll){echo $dataCONSUSECX['PASTDUE_DAYS'];}else{echo"-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Bunga Jatuh Tempo</td>
										<td align="right"><?php if($dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PASTDUE_INTEREST_CURRENCY']." ".number_format($dataCONSUSECX['PASTDUE_INTEREST_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Terjadinya tunggakan terakhir (lewat lebih dari 90 hari)</td>
										<td align="right"><?php if($dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS']<>NULL){echo $dataCONSUSECX['LAST_DELINQUENCY_90_PLUS_DAYS'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Jumlah keterlambatan terbesar</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_AMOUNT_CURRENCY']." ".number_format($dataCONSUSECX['WORST_PASTDUE_AMOUNT_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Tanggal Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DELINQUENCY_DATE']<>NULL){echo $dataCONSUSECX['DELINQUENCY_DATE']->format('Y-m-d');}else{echo"-";}?></td>
										
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['PRINCIPAL_AREAS_CURRENCY']." ".number_format($dataCONSUSECX['PRINCIPAL_AREAS_VALUE'],0,',','.');}else{echo"-";}?></td>										
										<td class="bg-td">Tanggal Wanprestasi</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_DATE']<>NULL){echo $dataCONSUSECX['DEFAULT_DATE']->format('Y-m-d');}else{echo"-";}?></td>										
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Pokok</td>
										<td align="right"><?php if($dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['PRINCIPAL_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Sebab Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.')<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_CURRENCY']." ".number_format($dataCONSUSECX['INTEREST_ARREARS_VALUE'],0,',','.');}else{echo"-";}?></td>
										<td class="bg-td">Keterangan Macet</td>
										<td align="right"><?php if($dataCONSUSECX['DEFAULT_REASON_DESCRIPTION']<>NULL){echo $dataCONSUSECX['DEFAULT_REASON_DESCRIPTION'];}else {echo "-";}?></td>
									</tr>
									<tr>
										<td class="bg-td">Frekuensi Tunggakan Bunga</td>
										<td align="right"><?php if($dataCONSUSECX['INTEREST_ARREARS_FREQUENCY']<>NULL){echo $dataCONSUSECX['INTEREST_ARREARS_FREQUENCY'];}else {echo "-";}?></td>
										<td class="bg-td">Keterlambatan Terlama (hari)</td>
										<td align="right"><?php if($dataCONSUSECX['WORST_PASTDUE_DAYS']<>NULL){echo $dataCONSUSECX['WORST_PASTDUE_DAYS'];}else {echo "-";}?></td>
									</tr>
								</table>
							</div>
							
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="4" class="bg-td"><p class="text-default" style="font-size:14px;"><b>DEBITUR YANG BERSANGKUTAN LAINNYA</b></p></td>
									</tr>
									<tr>
										<td width="20%" class="bg-td" > <b>NAMA</b> </td>
										<td width="20%" class="bg-td" > <b>PERAN</b> </td>
										<td width="40%" class="bg-td" > <b>JOINT ACCOUNT SEQUENCE</b> </td>
										<td width="20%" class="bg-td" > <b>KETERANGAN PENJAMIN<b> </td>
									</tr>
									<?php
										$callCORELSUB = "{call SP_GET_TAB_CONTRACT_RELATED_SUBJECT(?)}";
										$paramsCORELSUB = array(array($id, SQLSRV_PARAM_IN));
										$optionsCORELSUB =  array( "Scrollable" => "buffered" );
										$execCORELSUB = sqlsrv_query( $conn, $callCORELSUB, $paramsCORELSUB) or die( print_r( sqlsrv_errors(), true));
										$checkCORELSUB=sqlsrv_num_rows($execCORELSUB);
										while($dataCORELSUB = sqlsrv_fetch_array($execCORELSUB)){
									?>
									<tr>
										<td><?php if( $dataCORELSUB['NAME']<>NULL){echo $dataCORELSUB['NAME'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['ROLE_OF_CLIENT']<>NULL){echo $dataCORELSUB['ROLE_OF_CLIENT'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE']<>NULL){echo $dataCORELSUB['JOINT_ACCOUNT_SEQUENCE'];}else{echo "-";}?></td>
										<td><?php if( $dataCORELSUB['GUARANCY_DESCRIPTION']<>NULL){echo $dataCORELSUB['GUARANCY_DESCRIPTION'];}else{echo "-";}?></td>
									</tr>
									<?php }?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php
					}	}
				?>

			
			
</div>
</div>
</div>
</div>
</div>

<script>

$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});
</script>				
<?php require_once("footer.php"); ?>