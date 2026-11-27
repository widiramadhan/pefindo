<?php
require_once("config/configuration.php");
$user = $_GET['USERNAME'];
$id_fasilitas = $_GET['ID_FASILITAS'];
$PEFINDO_CHECKING_DATA_ID = $_GET['PEFINDO_CHECKING_DATA_ID'];

$callFasilitas = "{call SP_GET_M_NEW_PEFINDO_FASILITAS_DETAIL (?,?)}";
$paramFasilitas =  array(array($PEFINDO_CHECKING_DATA_ID, SQLSRV_PARAM_IN),array($id_fasilitas, SQLSRV_PARAM_IN));
$execFasilitas = sqlsrv_query($conn, $callFasilitas, $paramFasilitas) or die(print_r(sqlsrv_defaults(), true));
$dataFasilitas = sqlsrv_fetch_array($execFasilitas);

?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}

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
	background-color:#80FF00;
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
});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Detail Fasilitas</h4>
				<!-- <p class="category">Host to Host SFI - Pefindo</p> -->
			</div>
			<div class="content">
				<div id="accordion">
					<div class="card">
						<div class="header">
							<div class="pull-left">
								<p class="name" style="color:#035c7a;"><?php echo $dataFasilitas['PELAPOR'];?></p>
							</div>
							<div class="pull-right">
								<a class="card-link" data-toggle="collapse" href="#collapseOne">
									<i class="fa fa-chevron-down" style="color:#035c7a;"></i>
								</a>
							</div>
							<div style="clear:both"></div>
						</div>
						<div id="collapseOne" class="collapse content" data-parent="#accordion">
							<div class="table-responsive">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td style="font-weight: bold;">Pelapor</td>
											<td><?php echo $dataFasilitas['PELAPOR'];?></td>
											<td style="font-weight: bold;">Tipe Pelapor</td>
											<td><?php echo $dataFasilitas['JENIS_PELAPOR'];?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Tipe</td>
											<td><?php echo $dataFasilitas['JENIS_KREDIT'];?></td>
											<td style="font-weight: bold;">Sub Tipe</td>
											<td ><?php echo $dataFasilitas['SKIM_PEMBIAYAAN'];?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Saldo Terutang</td>
											<td><?php echo 'Rp. '.number_format($dataFasilitas['SALDO_TERUTANG'],0,',','.');?></td>
											<td style="font-weight: bold;">Nilai Tunggakan</td>
											<td ><?php echo 'Rp. '.number_format($dataFasilitas['JML_TUNGGAKAN'],0,',','.');?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Plafon Kredit</td>
											<td><?php echo 'Rp. '.number_format($dataFasilitas['PLAFON'],0,',','.');?></td>
											<td style="font-weight: bold;">Hari Tunggakan</td>
											<td ><?php echo $dataFasilitas['JUMLAH_HARI_TUNGGAKAN'];?></td>
										</tr>
										<tr>
											<td style="font-weight: bold;">Tanggal Diperbarui</td>
											<td><?php if($dataFasilitas['TAHUN_BULAN_DATA']<>NULL){echo $dataFasilitas['TAHUN_BULAN_DATA']->format('d M Y');}else{echo"";}?></td>
											<td style="font-weight: bold;">Kolektabilitas</td>
											<td ><?php echo $dataFasilitas['KOLEKTABILITAS']." - ".$dataFasilitas['DESC_KOLEKTABILITAS'];?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered" style="width:100%;">
						<tbody>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">Detail Fasilitas</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Kode Fasilitas</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['NOMOR_REKENING_FASILITAS'];?></td>
								<td class="bg-td"><b>Sektor Ekonomi</b></td>
								<td colspan="3"><?php echo $dataFasilitas['SEKTOR_EKONOMI'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jenis Kredit</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['JENIS_KREDIT'];?></td>
								<td class="bg-td"><b>Status Fasilitas</b></td>
								<td colspan="3"><?php echo $dataFasilitas['KONDISI'];?></td>
							</tr><tr>
								<td class="bg-td"><b>Sifat Kredit</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['JENIS_FASILITAS'];?></td>
								<td class="bg-td"><b>Realisasi</b></td>
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['REALISASI_ATAU_PENCAIRAN_BULAN_BERJALAN'],0,',','.');?></td>
							</tr><tr>
								<td class="bg-td"><b>Jenis Penggunaan</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['JENIS_PENGGUNAAN'];?></td>
								<td class="bg-td"><b>Tipe Bunga</b></td>
								<td colspan="3"><?php echo $dataFasilitas['JENIS_SUKU_BUNGA_ATAU_IMBALAN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Akad Kredit</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['JENIS_FASILITAS'];?></td>
								<td class="bg-td"><b>Bunga Pinjaman</b></td>
								<td colspan="3"><?php echo $dataFasilitas['SUKU_BUNGA_ATAU_IMBALAN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Jenis Penggunaan</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['JENIS_PENGGUNAAN'];?></td>
								<td class="bg-td"><b>Nama Penjamin</b></td>
								<td colspan="3"><?php echo $dataFasilitas['NAMA_LENGKAP_PENJAMIN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Baki Debet</b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['BAKI_DEBET'],0,',','.');?></td>
								<td class="bg-td"><b>Pinjaman Sindikasi</b></td>
								<td colspan="3"><?php echo 0;?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nilai Tukar Kontrak</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['VALUTA'];?></td>
								<td class="bg-td"><b>Terdaftar Bursa</b></td>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nilai Dalam Mata uang asal</b></td>.
								<td colspan="3" align="right"><?php echo number_format($dataFasilitas['NILAI_DALAM_MATA_UANG_ASAL'],0,',','.');?></td>
								<td class="bg-td"><b>Kantor Cabang</b></td>
								<td colspan="3"><?php echo $dataFasilitas['KANTOR_CABANG'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Total Plafon Awal</b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['PLAFON_AWAL'],0,',','.');?></td>
								<td class="bg-td"><b>Deskripsi</b></td>
								<td colspan="3"><?php echo $dataFasilitas['KETERANGAN'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">Detail Lainnya</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Program Pemerintah </b></td>.
								<td colspan="3"><?php echo $dataFasilitas['KREDIT_PROGRAM_PEMERINTAH'];?></td>
								<td class="bg-td"><b>Alasan Restrukturisasi</b></td>
								<td colspan="3"><?php echo $dataFasilitas['CARA_RESTRUKTURISASI'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Frekuensi Restrukturisasi </b></td>.
								<td colspan="3"><?php echo $dataFasilitas['FREKUENSI_RESTRUKTURISASI'];?></td>
								<td class="bg-td"><b>Frekuensi Perpanjangan Fasilitas </b></td>
								<td colspan="3"><?php echo $dataFasilitas['FREKUENSI_PERPANJANGAN_FASILITAS'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Restrukturisasi</b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_RESTRUKTURISASI_AWAL']<>NULL){echo $dataFasilitas['TANGGAL_RESTRUKTURISASI_AWAL']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Restrukturisasi Akhir</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_RESTRUKTURISASI_AKHIR']<>NULL){echo $dataFasilitas['TANGGAL_RESTRUKTURISASI_AKHIR']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Lokasi Proyek </b></td>.
								<td colspan="3"><?php echo $dataFasilitas['KABUPATEN_KOTA'];?></td>
								<td class="bg-td"><b>Nilai Proyek</b></td>
								<td colspan="3"><?php echo $dataFasilitas['NILAI_PROYEK'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nomor Akad Awal</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['NOMOR_AKAD_AWAL'];?></td>
								<td class="bg-td"><b>Nomor Akad Akhir</b></td>
								<td colspan="3"><?php echo $dataFasilitas['NOMOR_AKAD_AKHIR'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Mulai Akad </b></td>.
								<td colspan="3"><?php if($dataFasilitas['TAHUN_BULAN_DATA']<>NULL){echo $dataFasilitas['TAHUN_BULAN_DATA']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Akhir Akad</b></td>
								<td colspan="3"><?php if($dataFasilitas['TAHUN_BULAN_DATA']<>NULL){echo $dataFasilitas['TAHUN_BULAN_DATA']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">Tanggal Penting</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Awal Kredit </b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_AWAL_KREDIT_ATAU_PEMBIAYAAN']<>NULL){echo $dataFasilitas['TANGGAL_AWAL_KREDIT_ATAU_PEMBIAYAAN']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Akhir Kredit</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_AKHIR']<>NULL){echo $dataFasilitas['TANGGAL_AKHIR']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Mulai</b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_MULAI']<>NULL){echo $dataFasilitas['TANGGAL_MULAI']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Jatuh Tempo</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_JATUH_TEMPO']<>NULL){echo $dataFasilitas['TANGGAL_JATUH_TEMPO']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Pencairan</b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_PEMBELIAN']<>NULL){echo $dataFasilitas['TANGGAL_PEMBELIAN']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Kondisi</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_KONDISI']<>NULL){echo $dataFasilitas['TANGGAL_KONDISI']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Terbit L/C</b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_PENERBITAN']<>NULL){echo $dataFasilitas['TANGGAL_PENERBITAN']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Wanprestasi L/C</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_WANPRESTASI']<>NULL){echo $dataFasilitas['TANGGAL_WANPRESTASI']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">INDIKATOR RISIKO</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Kolektibilitas terburuk </b></td>.
								<td colspan="3"><?php echo $dataFasilitas['KOLEKTABILITAS_TERBURUK']." - ".$dataFasilitas['DESC_KOLEKTABILITAS_TERBURUK'];?></td>
								<td class="bg-td"><b>Hari tunggakan terburuk saat Ini</b></td>
								<td colspan="3"><?php echo $dataFasilitas['JML_HARI_TUNGGAKAN_TERBURUK'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Kolektibilitas terburuk dalam 12 bulan</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['KOLEKTABILITAS_TERBURUK_12BLN']." - ".$dataFasilitas['DESC_KOLEKTABILITAS_TERBURUK_12'];;?></td>
								<td class="bg-td"><b>Hari tunggakan terburuk dalam 12 bulan</b></td>
								<td colspan="3"><?php echo $dataFasilitas['JML_HARI_TUNGGAKAN_TERBURUK_12BLN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tunggakan bunga</b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['TUNGGAKAN_BUNGA_ATAU_IMBALAN'],0,',','.');?></td>
								<td class="bg-td"><b>Denda</b></td>
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['DENDA'],0,',','.');?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tunggakan pokok </b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['TUNGGAKAN_POKOK'],0,',','.');?></td>
								<td class="bg-td"><b>Frekuensi tunggakan pokok</b></td>
								<td colspan="3"><?php echo $dataFasilitas['FREKUENSI_TUNGGAKAN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nilai tunggakan terburuk</b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['TUNGGAKAN_TERBURUK'],0,',','.');?></td>
								<td class="bg-td"><b>Akumulasi tunggakan</b></td>
								<td colspan="3"><?php echo $dataFasilitas['JML_TUNGGAKAN'];?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nilai tunggakan terburuk dalam 12 bulan </b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['TUNGGAKAN_TERBURUK_12BLN'],0,',','.');?></td>
								<td class="bg-td"><b>Tanggal terakhir 90+ hari jatuh tempo</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_JATUH_TEMPO']<>NULL){echo $dataFasilitas['TANGGAL_JATUH_TEMPO']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b></b></td>.
								<td colspan="3"></td>
								<td class="bg-td"><b>Tanggal macet </b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_MACET']<>NULL){echo $dataFasilitas['TANGGAL_WANPRESTASI']->format('d M Y');}else{echo"";};?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Sebab macet</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['SEBAB_MACET'];?></td>
								<td class="bg-td"><b>Deskripsi sebab macet</b></td>
								<td colspan="3"><?php echo $dataFasilitas['KETERANGAN_SEBAB_MACET'];?></td>
							</tr>
							<tr>
								<td colspan="8" class="bg-td"><p class="name text-default">DETAIL SURAT BREHARGA</p></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Nilai Pasar</b></td>.
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['NILAI_PASAR'],0,',','.');?></td>
								<td class="bg-td"><b>Nilai Perolehan</b></td>
								<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataFasilitas['NILAI_PEROLEHAN'],0,',','.');?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Tanggal Pembelian Surat Berharga</b></td>.
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_PENERBITAN']<>NULL){echo $dataFasilitas['TANGGAL_PENERBITAN']->format('d M Y');}else{echo"";}?></td>
								<td class="bg-td"><b>Tanggal Penerbitan Surat Berharga</b></td>
								<td colspan="3"><?php if($dataFasilitas['TANGGAL_PEMBELIAN']<>NULL){echo $dataFasilitas['TANGGAL_PEMBELIAN']->format('d M Y');}else{echo"";}?></td>
							</tr>
							<tr>
								<td class="bg-td"><b>Peringkat Surat Berharga</b></td>.
								<td colspan="3"><?php echo $dataFasilitas['PERINGKAT_SURAT_BERHARGA'];?></td>
							</tr>
						</tbody>
					</table>					
				</div>

				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#agunan">Agunan</a></li>
					<li><a data-toggle="tab" href="#penjamin">Penjamin</a></li>
					<li><a data-toggle="tab" href="#riwayat-fasilitas">Riwayat Fasilitas</a></li>
				</ul>

				<div class="tab-content">
					<div id="agunan" class="tab-pane fade in active">
						<br>
						<?php 
							$no = 0;
							$isEmpty = 1;
							$callAgunan = "{call SP_GET_M_NEW_PEFINDO_AGUNAN (?,?)}";
							$paramAgunan =  array(array($PEFINDO_CHECKING_DATA_ID, SQLSRV_PARAM_IN),array($id_fasilitas, SQLSRV_PARAM_IN));
							$execAgunan = sqlsrv_query($conn, $callAgunan, $paramAgunan) or die(print_r(sqlsrv_defaults(), true));
							while($dataAgunan = sqlsrv_fetch_array($execAgunan)){
								$no++;
								$isEmpty = 0;
						?>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="8" class="bg-td"><p class="name text-default">Detail Agunan <?php echo $no ?></p></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kode Agunan</b></td>.
										<td colspan="3"><?php echo $dataAgunan['KODE_REGISTER_ATAU_NOMOR_AGUNAN'];?></td>
										<td class="bg-td"><b>Status Agunan</b></td>
										<td colspan="3"><?php echo $dataAgunan['STATUS_AGUNAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nama Pemilik</b></td>.
										<td colspan="3"><?php echo $dataAgunan['NAMA_PEMILIK_AGUNAN'];?></td>
										<td class="bg-td"><b>Asuransi</b></td>
										<td colspan="3"><?php echo $dataAgunan['DIASURANSIKAN'] == 1 ? 'Diasuransikan' : 'Tidak Diasuransikan';?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Agunan</b></td>.
										<td colspan="3"><?php echo $dataAgunan['JENIS_AGUNAN'];?></td>
										<td class="bg-td"><b>Tanggal Penilaian menurut pelapor</b></td>
										<td colspan="3"><?php if($dataAgunan['TANGGAL_PENILAIAN_AGUNAN_MENURUT_PELAPOR']<>NULL){echo $dataAgunan['TANGGAL_PENILAIAN_AGUNAN_MENURUT_PELAPOR']->format('d M Y');}else{echo"";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nilai Agunan Sesuai NJOP</b></td>.
										<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataAgunan['NILAI_AGUNAN_SESUAI_NJOP'],0,',','.');?></td>
										<td class="bg-td"><b>Tanggal Pengikatan</b></td>
										<td colspan="3" ><?php if($dataAgunan['TANGGAL_PENGIKATAN']<>NULL){echo $dataAgunan['TANGGAL_PENGIKATAN']->format('d M Y');}else{echo"";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nilai Agunan menurut Pelapor</b></td>.
										<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataAgunan['NILAI_AGUNAN_MENURUT_PELAPOR'],0,',','.');?></td>
										<td class="bg-td"><b>Tanggal Penilaian menurut Penilai Independen</b></td>
										<td colspan="3"><?php echo $dataAgunan['TANGGAL_PENILAIAN_AGUNAN_MENURUT_PENILAI_INDEPENDEN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nilai Agunan Menurut Penilai Independen</b></td>.
										<td colspan="3" align="right"><?php echo 'Rp. '.number_format($dataAgunan['NILAI_AGUNAN_MENURUT_PENILAI_INDEPENDEN'],0,',','.');?></td>
										<td class="bg-td"><b>Nama Penilai Independen</b></td>
										<td colspan="3"><?php echo $dataAgunan['NAMA_PENILAI_INDEPENDEN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Status Paripasu</b></td>.
										<td colspan="3"><?php echo $dataAgunan['STATUS_PARIPASU'];?></td>
										<td class="bg-td"><b>Institusi Pemeringkatan</b></td>
										<td colspan="3"><?php echo $dataAgunan['LEMBAGA_PEMERINGKAT'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Jenis Pengikatan</b></td>.
										<td colspan="3"><?php echo $dataAgunan['JENIS_PENGIKATAN'];?></td>
										<td class="bg-td"><b>Bukti Kepemilikan</b></td>
										<td colspan="3"><?php echo $dataAgunan['BUKTI_KEPEMILIKAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Status Joint Account</b></td>.
										<td colspan="3"><?php echo $dataAgunan['STATUS_KREDIT_JOINT_ACCOUNT'];?></td>
										<td class="bg-td"><b>Kantor Cabang</b></td>
										<td colspan="3"><?php echo $dataAgunan['KANTOR_CABANG'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Alamat</b></td>.
										<td colspan="3" ><?php echo $dataAgunan['ALAMAT_AGUNAN'];?></td>
										<td class="bg-td"><b>Deskripsi</b></td>
										<td colspan="3"><?php echo $dataAgunan['KETERANGAN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Kabupaten / Kota</b></td>.
										<td colspan="3" ><?php echo $dataAgunan['KABUPATEN_KOTA'];?></td>
										<td class="bg-td"><b>ID Agunan</b></td>
										<td colspan="3"><?php echo $dataAgunan['ID_AGUNAN'];?></td>
									</tr>
								</tbody>
							</table>	
						</div>
						<?php
							}
							if($isEmpty == 1){
						?>
							<table class="table table-bordered" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="8" class="bg-td"><p class="name text-default">Data Tidak Ditemukan</p></td>
									</tr>
								</tbody>
							</table>
						<?php		
							}
						?>
					</div>
					<div id="penjamin" class="tab-pane fade in">
						<br>
						<?php 
							$no = 0;
							$isEmpty = 1;
							$callPenjamin = "{call SP_GET_M_NEW_PEFINDO_PENJAMIN (?,?)}";
							$paramPenjamin =  array(array($PEFINDO_CHECKING_DATA_ID, SQLSRV_PARAM_IN),array($id_fasilitas, SQLSRV_PARAM_IN));
							$execPenjamin = sqlsrv_query($conn, $callPenjamin, $paramPenjamin) or die(print_r(sqlsrv_defaults(), true));
							while($dataPenjamin = sqlsrv_fetch_array($execPenjamin)){
								$no++;
								$isEmpty = 0;
						?>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="8" class="bg-td"><p class="name text-default">Detail Penjamin <?php echo $no ?></p></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nama Lengkap Penjamin</b></td>.
										<td colspan="3"><?php echo $dataPenjamin['NAMA_LENGKAP_PENJAMIN'];?></td>
										<td class="bg-td"><b>Tanggal</b></td>
										<td colspan="3"><?php if($dataPenjamin['TAHUN_BULAN_DATA']<>NULL){echo $dataPenjamin['TAHUN_BULAN_DATA']->format('d M Y');}else{echo"";}?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nama Penjamin Sesuai Identitas</b></td>.
										<td colspan="3"><?php echo $dataPenjamin['NAMA_PENJAMIN_SESUAI_IDENTITAS'];?></td>
										<td class="bg-td"><b>Tipe Penjamin</b></td>
										<td colspan="3"><?php echo $dataPenjamin['GOLONGAN_DEBITUR'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Tipe Identitas Penjamin</b></td>.
										<td colspan="3"><?php echo $dataPenjamin['JENIS_IDENTITAS'];?></td>
										<td class="bg-td"><b>Tipe Fasilitas</b></td>
										<td colspan="3"><?php echo $dataPenjamin['JENIS_FASILITAS'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Nomor identitas penjamin </b></td>.
										<td colspan="3" ><?php echo $dataPenjamin['NOMOR_IDENTITAS_PENJAMIN'];?></td>
										<td class="bg-td"><b>Kantor cabang</b></td>
										<td colspan="3" ><?php echo $dataPenjamin['KANTOR_CABANG'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>NPWP penjamin</b></td>.
										<td colspan="3"><?php echo $dataPenjamin['NPWP_PENJAMIN'];?></td>
										<td class="bg-td"><b>Alamat penjamin</b></td>
										<td colspan="3"><?php echo $dataPenjamin['ALAMAT_PENJAMIN'];?></td>
									</tr>
									<tr>
										<td class="bg-td"><b>Deskripsi </b></td>.
										<td colspan="3"><?php echo $dataPenjamin['KETERANGAN'];?></td>
										<td class="bg-td"><b>Porsi yang digaransikan </b></td>
										<td colspan="3"><?php echo $dataPenjamin['PERSENTASE_FASILITAS_YANG_DIJAMIN'];?></td>
									</tr>
								</tbody>
							</table>	
						</div>
						<?php
							}
						if($isEmpty == 1){
						?>
							<table class="table table-bordered" style="width:100%;">
								<tbody>
									<tr>
										<td colspan="8" class="bg-td"><p class="name text-default">Data Tidak Ditemukan</p></td>
									</tr>
								</tbody>
							</table>
						<?php		
							}
						?>
					</div>
					<div id="riwayat-fasilitas" class="tab-pane fade in">
						<br>
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<thead>
									<tr>
										<th class="bg-td">Periode</th>
										<th class="bg-td">Saldo Terutang</th>
										<th class="bg-td">Nilai Tunggakan</th>
										<th class="bg-td">Tunggakan Pokok</th>
										<th class="bg-td">Tunggakan Bunga</th>
										<th class="bg-td">Denda</th>
										<th class="bg-td">Hari Tunggakan</th>
										<th class="bg-td">Kolektibilitas</th>
									</tr>
								</thead>						
								<tbody>
								<?php
									$no = 0;
									$isEmpty = 1;
									$callRiwayatFasilitas = "{call SP_GET_M_NEW_PEFINDO_RIWAYAT_FASILITAS(?,?)}";
									$paramsRiwayatFasilitas = array(array($PEFINDO_CHECKING_DATA_ID, SQLSRV_PARAM_IN),array($id_fasilitas, SQLSRV_PARAM_IN));
									$execRiwayatFasilitas = sqlsrv_query( $conn, $callRiwayatFasilitas, $paramsRiwayatFasilitas) or die( print_r( sqlsrv_errors(), true));
									while($dataRiwayatFasilitas = sqlsrv_fetch_array($execRiwayatFasilitas)){
										$no++;
										$isEmpty = 0;
								?>
									<tr>
										<td align="left"><?php if($dataRiwayatFasilitas['TAHUN_BULAN_DATA'] <> NULL){echo $dataRiwayatFasilitas['TAHUN_BULAN_DATA']->format('d M Y');}else{echo"-";}?></td>
										<td align="right"><?php echo 'Rp. '.number_format($dataRiwayatFasilitas['SALDO_TERUTANG'],0,',','.');?></td>
										<td align="right"><?php echo 'Rp. '.number_format($dataRiwayatFasilitas['NOMINAL_TUNGGAKAN'],0,',','.');?></td>
										<td align="right"><?php echo 'Rp. '.number_format($dataRiwayatFasilitas['TUNGGAKAN_POKOK'],0,',','.');?></td>
										<td align="right"><?php echo 'Rp. '.number_format($dataRiwayatFasilitas['TUNGGAKAN_BUNGA_ATAU_IMBALAN'],0,',','.');?></td>
										<td align="right"><?php echo 'Rp. '.number_format($dataRiwayatFasilitas['DENDA'],0,',','.');?></td>
										<td align="left"><?php echo $dataRiwayatFasilitas['JUMLAH_HARI_TUNGGAKAN'];?></td>
										<td align="left"><?php echo $dataRiwayatFasilitas['KOLEKTABILITAS'];?></td>
										
									</tr>
									<?php
										}
									if($isEmpty == 1){
									?>
									<tr>
										<td colspan="8" class="bg-td"><p class="name text-default">Data Tidak Ditemukan</p></td>
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



<script>
	const base64 = "<?= $pdfFile ?>";
	const binary = atob(base64);
	const len = binary.length;
	const bytes = new Uint8Array(len);

	for (let i = 0; i < len; i++) {
	bytes[i] = binary.charCodeAt(i);
	}

	const blob = new Blob([bytes], { type: 'application/pdf' });
	const url = URL.createObjectURL(blob);

	document.getElementById('pdfFrame').src = url;
</script>




