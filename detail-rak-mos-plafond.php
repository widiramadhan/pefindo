<?php
// =====================================================================
// detail-rak-mos-plafond.php
// RAK MOS - Stock Financing Plafond (turunan dari detail-rak-mos.php)
//
// Perubahan dari versi lama:
//  - Tab "REVIEW RAK" dan "FLEET & AO" dihilangkan (PHONE VERIFICATION tetap)
//  - DSR tidak berlaku (kalkulasi DSR, kewajiban, total pendapatan dihapus)
//  - Kolom perhitungan Nota dihilangkan
//  - Tambah isian "Nominal Plafon yang Diajukan" di bawah NOTE
//  - Data dari SP baru (lihat sp_stockfin_plafond.sql), file dimuat saat diklik
//
// Parameter URL: USERNAME, prospect (= STOCKFIN_PLAFOND_H.TRX_NO)
//
// TODO:
//  [1] SP_RAK_INSERT_ANALISA_PLAFOND  -> SP simpan hasil RAK + plafon (belum dibuat)
//  [2] kode NAME file di $FILE_LABEL  -> sesuaikan hasil: SELECT DISTINCT NAME FROM STOCKFIN_PLAFOND_D_FILES
// =====================================================================

ini_set('max_execution_time', '300');

$user     = $_GET['USERNAME'];
$prospect = $_GET['prospect'];
$branchid = substr($prospect, 0, 4);

// ---------- helper ----------
function h($s){
	if ($s instanceof DateTime) { return $s->format('Y-m-d'); }
	return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
function only_digits($s){
	return preg_replace('/[^0-9]/', '', (string)$s);
}
function sp_rows($db, $call, $params){
	$stmt = sqlsrv_query($db, $call, $params) or die(print_r(sqlsrv_errors(), true));
	$rows = array();
	while ($r = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { $rows[] = $r; }
	return $rows;
}

// ---------- ambil data dari SP ----------
$param = array(array($prospect, SQLSRV_PARAM_IN));

$rowsMain = sp_rows($conn_mos_sim, "{call SP_RAK_GET_DATA_PLAFOND_MOS(?)}", $param);
if (count($rowsMain) == 0) {
	echo "<script>alert('Data plafond tidak ditemukan');</script>";
	echo "<script>window.location='index.php?USERNAME=".urlencode($user)."&page=tasklist-rak'</script>";
	exit();
}
$dp      = $rowsMain[0];
$related = sp_rows($conn_mos_sim, "{call SP_RAK_GET_RELATED_PLAFOND_MOS(?)}", $param);
$files   = sp_rows($conn_mos_sim, "{call SP_RAK_GET_FILES_PLAFOND_MOS(?)}", $param);

// daftar file dikelompokkan per NAME (isi file TIDAK diambil di sini)
$filesByName = array();
foreach ($files as $f) {
	$filesByName[$f['NAME']][] = $f;
}
$usedFiles = array();

// plafon pengajuan awal dari sistem sebelumnya
$plafon_awal = isset($dp['PENGAJUAN_PLAFON']) ? (float)$dp['PENGAJUAN_PLAFON'] : 0;

// ---------- data untuk Phone Verification ----------
$ktp_pemohon   = $dp['NO_KTP_PEMOHON'];
$siapanih      = '';
$ktpsaya       = '';
$custmodelsaya = '';
foreach ($related as $r) {
	if ($r['REL_TYPE'] == 'SPOUSE' && trim((string)$r['NO_KTP']) != '') {
		$siapanih      = 'Pasangan';
		$ktpsaya       = $r['NO_KTP'];
		$custmodelsaya = $r['CUST_MODEL_CODE'];
	}
}

$callMappingPemohon = "{call SP_RAK_GET_MAPPING_ID_PEFINDOSLIK_TYPE(?,?)}";
$paramMappingPemohon =  array(array($prospect, SQLSRV_PARAM_IN),
					   array('Pemohon', SQLSRV_PARAM_IN));
$execMappingPemohon = sqlsrv_query( $conn, $callMappingPemohon, $paramMappingPemohon) or die( print_r( sqlsrv_defaults(), true)); 
$dataMappingPemohon = sqlsrv_fetch_array($execMappingPemohon);
$mapping_id = $dataMappingPemohon['PEFINDO_MAPPING_ID'];


$callMappingPasangan = "{call SP_RAK_GET_MAPPING_ID_PEFINDOSLIK_TYPE(?,?)}";
$paramMappingPasangan =  array(array($prospect, SQLSRV_PARAM_IN),
					   array($siapanih, SQLSRV_PARAM_IN));
$execMappingPasangan = sqlsrv_query( $conn, $callMappingPasangan, $paramMappingPasangan) or die( print_r( sqlsrv_defaults(), true)); 
$dataMappingPasangan = sqlsrv_fetch_array($execMappingPasangan);


$mapping_idPasangan = $dataMappingPasangan['PEFINDO_MAPPING_ID'];
// ---------- next approval BM ----------
$callCheckNextApprovalBM  = "{call SP_CHECK_NEXT_APPROVAL_BM(?)}";
$paramCheckNextApprovalBM = array(array($branchid, SQLSRV_PARAM_IN));
$execCheckNextApprovalBM  = sqlsrv_query($conn, $callCheckNextApprovalBM, $paramCheckNextApprovalBM) or die(print_r(sqlsrv_errors(), true));
$dataCheckNextApprovalBM  = sqlsrv_fetch_array($execCheckNextApprovalBM);

// =====================================================================
// PEMETAAN FIELD TAMPILAN: array(label, kolom/kode file, tipe, wajib)
// tipe: text | money | file
// Untuk tipe file, kolom = kode NAME di STOCKFIN_PLAFOND_D_FILES
// =====================================================================
$FIELD_MAP = array(
	'PEMOHON' => array(
		array('Transaction No',                          'TRANSACTION_NO',        'text',  1),
		array('Tipe Produk',                             'TIPE_PRODUK',           'text',  1),
		array('Foto KTP Pemohon',                        'KTP',                   'file',  1),
		array('Nomor KTP Pemohon',                       'NO_KTP_PEMOHON',        'text',  1),
		array('Blacklist Pemohon',                       'BLACKLIST_PEMOHON',     'text',  1),
		array('Nama Lengkap Pemohon Sesuai KTP',         'NAMA_PEMOHON_KTP',      'text',  1),
		array('Nama Lengkap Pemohon Tanpa Gelar',        'NAMA_PEMOHON_TG',       'text',  1),
		array('Tanggal Lahir Pemohon',                   'TGL_LAHIR_PEMOHON',     'text',  1),
		array('Jenis Kelamin Pemohon',                   'JK_PEMOHON',            'text',  1),
		array('Status Pemohon',                          'STATUS_PEMOHON',        'text',  1),
		array('Nama Ibu Kandung Pemohon Sesuai KTP',     'IBU_PEMOHON_KTP',       'text',  1),
		array('Nama Ibu Kandung Pemohon Tanpa Gelar',    'IBU_PEMOHON_TG',        'text',  1),
		array('Foto KK',                                 'KK',                    'file',  1),
		array('Upload Buku Nikah',                       'BUKU_NIKAH',            'file',  0),
		array('Nomor HP/WhatsApp Pemohon',               'HP_PEMOHON',            'text',  1),
		array('Nomor HP/WhatsApp 2',                     'HP_PEMOHON_2',          'text',  0),
		array('Customer Model Pemohon',                  'CUST_MODEL_PEMOHON',    'text',  1),
		array('Profesi Pemohon',                         'PROFESI_PEMOHON',       'text',  1),
		array('Industry Type Pemohon',                   'INDUSTRY_PEMOHON',      'text',  1),
		array('Email Pemohon',                           'EMAIL_PEMOHON',         'text',  1),
	),
	'CUSTOMER CONSENT' => array(
		array('Pengiriman WA Consent',                   'WA_CONSENT_NO',         'text',  0),
		array('Status',                                  'WA_CONSENT_STATUS',     'text',  0),
	),
);

// bagian PASANGAN / SHAREHOLDER dibuat dari STOCKFIN_PLAFOND_D_RELATED
$REL_TITLE = array('SPOUSE' => 'PASANGAN', 'SHR1' => 'SHAREHOLDER 1', 'SHR2' => 'SHAREHOLDER 2');
$REL_FILE  = array('SPOUSE' => 'KTP_SPOUSE', 'SHR1' => 'FOTO_KTP_SHR1', 'SHR2' => 'FOTO_KTP_SHR2');

function rel_fields($type, $REL_FILE, $label){
	$fileKey = isset($REL_FILE[$type]) ? $REL_FILE[$type] : 'FOTO_KTP_'.$type;
	return array(
		array('Jenis Identitas '.$label,                 'JENIS_ID',      'text', 1),
		array('Foto KTP '.$label,                        $fileKey,        'file', 1),
		array('Nomor KTP '.$label,                       'NO_KTP',        'text', 1),
		array('Blacklist '.$label,                       'BLACKLIST',     'text', 1),
		array('Nama Lengkap '.$label.' Sesuai KTP',      'NAMA_KTP',      'text', 1),
		array('Nama Lengkap '.$label.' Tanpa Gelar',     'NAMA_TG',       'text', 1),
		array('Tanggal Lahir '.$label,                   'TGL_LAHIR',     'text', 1),
		array('Status '.$label,                          'STATUS_KAWIN',  'text', 1),
		array('Nama Ibu Kandung '.$label.' Sesuai KTP',  'IBU_KTP',       'text', 1),
		array('Nama Ibu Kandung '.$label.' Tanpa Gelar', 'IBU_TG',        'text', 1),
		array('Customer Model '.$label,                  'CUST_MODEL',    'text', 1),
		array('Profesi '.$label,                         'PROFESI',       'text', 1),
		array('Industry Type '.$label,                   'INDUSTRY',      'text', 1),
		array('Email '.$label,                           'EMAIL',         'text', 0),
	);
}

$FIELD_USAHA = array(
	'USAHA' => array(
		array('Nama Usaha (Dealer SF/SAP)',              'NAMA_DEALER',           'text',  1),
		array('Nama Usaha Pemohon',                      'NAMA_USAHA',            'text',  1),
		array('Alamat Identitas Pemohon',                'ALAMAT_ID_PEMOHON',     'text',  1),
		array('Alamat Domisili Pemohon',                 'ALAMAT_DOM_PEMOHON',    'text',  1),
		array('Alamat Legal Usaha Pemohon',              'ALAMAT_LEGAL_USAHA',    'text',  1),
		array('Alamat Domisili Usaha Pemohon',           'ALAMAT_DOM_USAHA',      'text',  1),
		array('Nomor Telp Usaha Pemohon',                'TELP_USAHA',            'text',  1),
		array('Email Usaha Pemohon',                     'EMAIL_USAHA',           'text',  1),
		array('Nomor NPWP Usaha Pemohon (atau NPWP Pemohon)', 'NPWP_USAHA',       'text',  1),
		array('Total Karyawan',                          'TOTAL_KARYAWAN',        'text',  1),
		array('Kepemilikan Tempat Usaha',                'KEPEMILIKAN_USAHA',     'text',  1),
		array('Upload Bukti Kepemilikan Tempat Usaha',   'KEPEMILIKAN',     'file',  1),
		array('Foto Stok Kendaraan 1',                   'FOTO_STOCK',          'file',  1),
		array('Foto Stok Kendaraan 2',                   'FOTO_STOCK_2',          'file',  1),
		array('Foto Dealer Tampak Depan',                'DEALER_DEPAN',     'file',  1),
		array('Foto Dealer Tampak Jalan Depan',          'DEALER_JALAN_DEPAN',     'file',  1),
		array('Foto Dealer Tampak Jalan Depan Sisi Kanan','DEALER_JALAN_DEPAN_KANAN',    'file',  1),
		array('Foto Dealer Tampak Jalan Depan Sisi Kiri','DEALER_JALAN_DEPAN_KIRI',      'file',  1),
		array('Upload List Stok Kendaraan',              'LIST_STOK',            'file',  1),
		array('Upload Rekening Koran 3 Bulan Terakhir',  'REK_KORAN',           'file',  1),
		array('Upload Rekening Koran 3 Bulan Terakhir 2','REK_KORAN_2',           'file',  1),
		array('Upload Rekening Koran 3 Bulan Terakhir 3','REK_KORAN_3',           'file',  1),
		array('Upload Laporan Keuangan 1 Tahun Terakhir','LAP_KEUANGAN',          'file',  1),
		array('Upload PKS reguler Mobil Bekas',          'PKS_REGULER',           'file',  1),
		array('Pengajuan Plafon',                        'PENGAJUAN_PLAFON',      'money', 1),
	),
	'PERJANJIAN KERJA SAMA' => array(
		array('Bukti Transfer',                          'BUKTI_BAYAR',        'file',  1),
		array('PKS Final',                               'PKS',             'file',  1),
	),
);

// tombol file: isi file baru diambil saat tombol diklik
function file_cell($filesByName, $key, $trx){
	if (!isset($filesByName[$key]) || count($filesByName[$key]) == 0) {
		return '<span class="text-muted">- belum ada file -</span>';
	}
	$out = '';
	foreach ($filesByName[$key] as $f) {
		$mime = strtolower(trim((string)$f['MIME_TYPE']));
		if (strpos($mime, 'image/') === 0)        { $lbl = 'Lihat Foto'; }
		elseif ($mime == 'application/pdf')       { $lbl = 'Lihat PDF'; }
		else                                      { $lbl = 'Download'; }
		$kb = ($f['SIZE_BYTES'] > 0) ? round($f['SIZE_BYTES'] / 1024).' KB' : '';
		$out .= '<div class="file-item" style="margin-bottom:8px;">';
		$out .= '<button type="button" class="btn btn-warning btn-xs btn-view-file" style="min-width:100px;"'
		      . ' data-trx="'.h($trx).'" data-slug="'.h($f['SLUG']).'" data-mime="'.h($mime).'" data-label="'.h($lbl).'">'.h($lbl).'</button> ';
		$out .= '<small class="text-muted">'.h($f['ORI_NAME']).($kb != '' ? ' ('.$kb.')' : '').'</small>';
		if (isset($f['LAT']) && $f['LAT'] !== null && $f['LAT'] !== '' && isset($f['LON']) && $f['LON'] !== null && $f['LON'] !== '') {
			$out .= ' <a href="https://www.google.com/maps?q='.h($f['LAT']).','.h($f['LON']).'" target="_blank"><small>Lokasi</small></a>';
		}
		$out .= '<div class="file-viewer" style="display:none;margin-top:8px;"></div>';
		$out .= '</div>';
	}
	return $out;
}

// render satu section (read only)
function render_section($title, $rows, $data, $filesByName, $trx, &$used){
	echo '<div class="row"><div class="col-md-12 col-sm-12">';
	echo '<div class="table-responsive"><table class="table table-bordered">';
	echo '<tr><td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">'.h($title).'</td></tr>';
	echo '</table></div>';
	echo '<div class="table-responsive"><table class="table table-bordered">';
	foreach ($rows as $r) {
		list($label, $key, $type, $wajib) = $r;
		$star = $wajib ? ' <span style="color:red;">*</span>' : '';
		echo '<tr><td style="width:35%;">'.h($label).$star.'</td><td>';
		if ($type == 'file') {
			$used[$key] = 1;
			echo file_cell($filesByName, $key, $trx);
		} elseif ($type == 'money') {
			$val = isset($data[$key]) ? $data[$key] : 0;
			echo '<div class="input-group" style="max-width:350px;"><span class="input-group-addon">Rp</span>';
			echo '<input type="text" class="form-control" value="'.number_format((float)$val, 0, ',', '.').'" readonly></div>';
		} else {
			$val = isset($data[$key]) ? $data[$key] : '';
			echo '<input type="text" class="form-control" value="'.h($val).'" readonly>';
		}
		echo '</td></tr>';
	}
	echo '</table></div>';
	echo '</div></div>';
}

// =====================================================================
// SUBMIT
// =====================================================================
if (isset($_POST['submit1']) || isset($_POST['submitNo'])) {

	$rekomendasi = isset($_POST['submit1']) ? "REKOMENDASI" : "TIDAK REKOMENDASI";
	$note_rak    = isset($_POST['note_rak']) ? $_POST['note_rak'] : '';

	// plafon: bila "Ya" server memakai nilai dari DB (tidak percaya nilai dari browser)
	$plafon_sesuai = (isset($_POST['plafon_sesuai']) && $_POST['plafon_sesuai'] == 'TIDAK') ? 'TIDAK' : 'YA';
	if ($plafon_sesuai == 'YA') {
		$plafon_diajukan = $plafon_awal;
	} else {
		$plafon_diajukan = (float)only_digits(isset($_POST['plafon_nominal']) ? $_POST['plafon_nominal'] : '0');
		if ($plafon_diajukan <= 0) {
			echo "<script>alert('Nominal plafon yang diajukan harus diisi dan lebih dari 0');history.back();</script>";
			exit();
		}
	}

	// [1] SP simpan - sesuaikan dengan SP yang dibuat
	$queryInsert = "{call SP_RAK_INSERT_ANALISA_PLAFOND(?,?,?,?,?,?,?,?)}";
	$parameterInsert = array(
		array($branchid,        SQLSRV_PARAM_IN),
		array($prospect,        SQLSRV_PARAM_IN),
		array($rekomendasi,     SQLSRV_PARAM_IN),
		array($note_rak,        SQLSRV_PARAM_IN),
		array($plafon_awal,     SQLSRV_PARAM_IN),
		array($plafon_sesuai,   SQLSRV_PARAM_IN),
		array($plafon_diajukan, SQLSRV_PARAM_IN),
		array($user,            SQLSRV_PARAM_IN)
	);
	$execInsert = sqlsrv_query($conn_mos_sim, $queryInsert, $parameterInsert);

	if ($execInsert) {
		echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=".$user."'</script>";
	} else {
		echo "<script>alert('Data Gagal Disimpan');history.back();</script>";
	}
	exit();
}
?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>

<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	background-color:#035c7a;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
.notice {
  background-color: #dc3545;
  color: #ffffff;
  border-left: 5px solid #b02a37;
  padding: 12px 16px;
  margin: 10px 0;
  border-radius: 6px;
  font-family: sans-serif;
}
.file-viewer img{ max-width:100%; max-height:600px; border:1px solid #ddd; padding:2px; }
.file-viewer iframe{ width:100%; height:600px; border:1px solid #ddd; }
</style>

<link rel="stylesheet" href="assets/css/lightbox.css" type="text/css" media="screen" />
<div class="row">
	<div class="col-md-12">
		<form enctype="multipart/form-data" name="form_rak_plafond" id="form_rak_plafond" action="" method="post">
			<input type="hidden" name="user_hide" id="user_hide" value="<?php echo h($user); ?>">
			<input type="hidden" name="order_no" value="<?php echo h($prospect); ?>">
			<div class="card">
				<div class="content">

					<ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#menu1" id="tab-rak">RAK</a></li>
						<li><a data-toggle="pill" href="#phone_verif">PHONE VERIFICATION</a></li>
						
					</ul>

					<div class="tab-content">

						<!-- ===================== PHONE VERIFICATION ===================== -->
						<div id="phone_verif" class="tab-pane fade">
							<br>
							<div id="phone-verif-container" class="p-2"
								data-siapanih="<?php echo h($siapanih); ?>"
								data-ktp="<?php echo h($ktp_pemohon); ?>"
								data-ktpsaya="<?php echo h($ktpsaya); ?>"
								data-custmodel="<?php echo h($dp['CUST_MODEL_CODE']); ?>"
								data-orderno="<?php echo h($prospect); ?>"
								data-custmodelpas="<?php echo h($custmodelsaya); ?>">
								Loading phone verification...
							</div>
						</div>
						<input type="hidden" name="done_phone_verif" id="done_phone_verif" value="0">

						<!-- ===================== RAK ===================== -->
						<div id="menu1" class="tab-pane fade in active">
							<br>
							<div class="row">
								<div class="col-md-12 col-sm-12">

									<div class="table-responsive">
										<table class="table table-bordered">
											<tr>
												<td style="background-color:#ff3838;color:#FFF;font-weight:bold;">
													STOCK FINANCING PLAFON
													<br>
													TRANSACTION NO : <?php echo h($dp['TRANSACTION_NO']); ?>
													<br>
													STATUS : <?php echo h($dp['STAT']); ?>
												</td>
											</tr>
										</table>
										<table class="table table-bordered">
											<tr>
												<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">MENU VALIDASI DAN ANALISA CREDIT ANALYST</td>
											</tr>
										</table>
									</div>

									<!-- ---------- VIEW DATA (read only) ---------- -->
									<?php
									// PEMOHON + CUSTOMER CONSENT
									foreach ($FIELD_MAP as $judul => $rows) {
										render_section($judul, $rows, $dp, $filesByName, $prospect, $usedFiles);
									}

									// PASANGAN / SHAREHOLDER (hanya baris yang terisi)
									$adaRelated = false;
									foreach ($related as $r) {
										if (trim((string)$r['NO_KTP']) == '' && trim((string)$r['NAMA_KTP']) == '') { continue; }
										$adaRelated = true;
										$type  = $r['REL_TYPE'];
										$title = isset($REL_TITLE[$type]) ? $REL_TITLE[$type] : $type;
										$label = ($type == 'SPOUSE') ? 'Pasangan' : ucwords(strtolower($title));
										render_section($title, rel_fields($type, $REL_FILE, $label), $r, $filesByName, $prospect, $usedFiles);
									}
									if (!$adaRelated) {
										render_section('PASANGAN', array(), array(), $filesByName, $prospect, $usedFiles);
										echo '<div class="text-muted" style="margin:-10px 0 15px 5px;">Data pasangan / shareholder belum diisi.</div>';
									}

									// USAHA + PERJANJIAN KERJA SAMA
									foreach ($FIELD_USAHA as $judul => $rows) {
										render_section($judul, $rows, $dp, $filesByName, $prospect, $usedFiles);
									}

									

									// file yang kodenya belum ada di mapping (supaya tidak ada yang terlewat)
									$lain = array();
									foreach ($filesByName as $nama => $list) {
										if (!isset($usedFiles[$nama])) { $lain[$nama] = $list; }
									}
									if (count($lain) > 0) {
										echo '<div class="row"><div class="col-md-12 col-sm-12">';
										echo '<div class="table-responsive"><table class="table table-bordered">';
										echo '<tr><td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">DOKUMEN LAINNYA</td></tr>';
										echo '</table></div><div class="table-responsive"><table class="table table-bordered">';
										foreach ($lain as $nama => $list) {
											echo '<tr><td style="width:35%;">'.h($nama).'</td><td>'.file_cell($filesByName, $nama, $prospect).'</td></tr>';
										}
										echo '</table></div></div></div>';
									}
									?>
									<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Validasi  Domisili Pilih Salah Satu Sesuai Document yang di Lampirkan</td>
									</tr>
									
									
								</table>
							</div>
							
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
							
									
									<tr>
										<td style="width:50%;">SHM</td>
											<td style="width:10%;">
												<input type="checkbox" name="shm_ck" id="shm_ck" value="SHM" onclick="myFunctionCk1()">
												<input type="hidden" name="shm_ck1" id="shm_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="shm_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Akta Jual Beli</td>
											<td style="width:10%;">
												<input type="checkbox" name="akta_jual_beli_ck" id="akta_jual_beli_ck" value="AKTA JUAL BELI" onclick="myFunctionCk2()">
													<input type="hidden" name="akta_jual_beli_ck1" id="akta_jual_beli_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="akta_jual_beli_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Girik</td>
											<td style="width:10%;">
												<input type="checkbox" name="surat_girik_ck" id="surat_girik_ck" value="SURAT GIRIK" onclick="myFunctionCk3()">
												<input type="hidden" name="surat_girik_ck1" id="surat_girik_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="surat_girik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">PBB</td>
											<td style="width:10%;">
												<input type="checkbox" name="pbb_ck" id="pbb_ck" value="PBB" onclick="myFunctionCk4()">
												<input type="hidden" name="pbb_ck1" id="pbb_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="pbb_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Rek Listrik</td>
											<td style="width:10%;">
												<input type="checkbox" name="rek_listrik_ck" id="rek_listrik_ck" value="REK LISTRIK" onclick="myFunctionCk5()">
												<input type="hidden" name="rek_listrik_ck1" id="rek_listrik_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_listrik_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">REK AIR</td>
											<td style="width:10%;">
												<input type="checkbox" name="rek_air_ck" id="rek_air_ck" value="REK AIR" onclick="myFunctionCk6()">
												<input type="hidden" name="rek_air_ck1" id="rek_air_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="rek_air_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									
									<tr>
										<td style="width:50%;">Surat Keputusan Rumah Dinas (Jika Menempati Rumah)</td>
											<td style="width:10%;">
												<input type="checkbox" name="skrd_ck" id="skrd_ck" value="SURAT KEPUTUSAN RUMAH DINAS" onclick="myFunctionCk7()">
												<input type="hidden" name="skrd_ck1" id="skrd_ck1"  value="">
											</td>
										<td style="width:50%;">
											<select name="skrd_val" class="form-control" >
														<option value="VALID">VALID</option>
														<option value="TIDAK VALID">TIDAK VALID</option>
											</select>   
										</td>
									</tr>
									<tr>
										<td style="width:50%;">STATUS USAHA</td>
										<td style="width:50%;" colspan="2">
											<select name="status_rumah_val" class="form-control" required>
														<option value="">--Pilih--</option>
														<option value="COMPANY">COMPANY</option>
														<option value="FAMILY">FAMILY HOUSE</option>
														<option value="MORTGAGE">MORTGAGE</option>
														<option value="RENT">RENT</option>
														<option value="SELF">SELF OWNED</option>
														<option value="SPOUSE">SPOUSE OWNED</option>
											</select>  
															
														
										</td>
									</tr>
									
									
									
									
									
									
								</table>
							</div>								
						</div>
							<div class="col-md-6 col-sm-12">
								<div class="table-responsive">
									<table class="table table-bordered">

									<tr>
										<td style="width:30%;">CARA VALIDASI</td>
										<td colspan= "2">
											<select name="domisili_val" class="form-control" >
														<option value="Cek Ke BPN">Cek Ke BPN</option>
														<option value="Cek Notaris Penerbit">Cek Notaris Penerbit</option>
														<option value="Cek by Virtual">Cek by Virtual</option>
														<option value="Cek by Online">Cek by Online</option>
														<option value="Cek by Dispenda">Cek by Dispenda</option>
														<option value="PV">PV</option>
														<option value="Kunjungan ke kantor">Kunjungan ke kantor</option>
														
											</select>   
										</td>
									
									</tr>
									
									<tr>
										<td style="width:30%;">NOTES</td>
										<td colspan="2">
													<textarea name="catatan_domisili" id="catatan_domisili" value="" class="form-control"> </textarea>
													
										</td>
									</tr>
									<tr>
												<td >Upload Bukti Validasi </td>
													<td colspan="2" >
														<input type="file" name="img_domisili" required style="margin-bottom:5px;" />

													</td>
									</tr>
									
									
									
									
								</table>
							</div>								
						</div>
						<div id="kry_pemohon_div">
					
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">Verifikasi</td>
									</tr>
									
									
								</table>
							</div>
						</div>	
					</div>	
					
					<div class="col-md-12 col-sm-12">	
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
					
									
											
									<tr>
										<td style="width:30%;">Nama Bank Penerbit </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_bank_penerbit" class="form-control" value=""  id="kry_bank_penerbit"  >
										</td>
										
									</tr>
								
									<tr>
										<td style="width:30%;">Nomor Rekening</td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_norek" class="form-control" value=""  id="kry_norek" >
										</td>
										
									</tr>
									
									<tr>
										<td style="width:30%;">Nama Pemilik Rekening </td>
										<td colspan="2" style="width:50%;">
											 <input type="text" name="kry_pemilik_rekening" class="form-control" value=""  id="kry_pemilik_rekening" >
										</td>
										
									</tr>
									<tr>
										<td rowspan="4" style="width:30%;">Mutasi Yang Dilampirkan </td>
										<td style="width:50%;">
										<select name="mutasi_karyawan" class="form-control" >
														<option value="">--Pilih--</option>
														<option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option>
														<option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
														<option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
														<option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
														
											</select>   
										</td>
										
									</tr>
									
								
									
								</table>
							</div>								
						</div>
				
						<div class="col-md-6 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									
								
									<tr>
										<td style="width:30%;">Cara Validasi</td>
										<td style="width:50%;">
											 <select name="validasi_tf_pemohon" class="form-control" required>										
														<option value="Melakukan Percobaan Transfer">Melakukan Percobaan Transfer</option>
											</select>   
										</td>
									</tr>

										<td >Upload Bukti Validasi </td>
												<td colspan="2" >
													<input type="file" name="img_tf_kry_pemohon"  style="margin-bottom:5px;" />
													
												</td>
									
										
								
									
								</table>
							</div>								
						</div>
						
						
						
					</div>
					</div>
					
						<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Input Mutasi</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					<div class="col-md-12 col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="6" style="background-color:#035c7a;color:#FFF;font-weight:bold;">Form Input </td>
									</tr>
									<div id="inputSaldokry">
									<tr>	
										<td style="width:10%;">Saldo Awal</td>
										<td style="width:20%;">
										<input type="text" name="kry_saldoAwal" class="form-control" value="" 
										id="kry_saldoAwal" >
									
									
										</td>
									</tr>
									<tr>
								
										<td colspan="6"> 
										
										<input  type="button" name="submit_saldoAwalKry" id="submit_saldoAwalKry" class="btn btn-primary" value="Submit Saldo"  style="width:200px;" >
										</td>
									</tr>
									</div>	
									
										
									<div id="inputkry">
								
									<tr>
										<td style="width:10%;">Tanggal Transaksi</td>
										<td style="width:20%;">
											<div class="input-group date">
												<input type="text" class="form-control" name="kry_tgl_transaksi" id="kry_tgl_transaksi" autocomplete="off" value="" > 
												<div class="input-group-addon">
													<span class="add-on"><i class="fa fa-calendar"></i></span>
												</div> 
											</div>
										
										
									
										</td>
										
										<td style="width:10%;">Keterangan Transaksi</td>
										<td style="width:20%;">
										<input type="text" name="kry_ket_transaksi" class="form-control" value="" 
										id="kry_ket_transaksi" >
									
										</td>
										
										<td style="width:10%;">Mutasi Debit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_debit" class="form-control" value="0" 
										id="kry_mutasi_debit" >
									
										</td>
									</tr>
									<tr>
										<td style="width:10%;">Mutasi Kredit</td>
										<td style="width:20%;">
										<input type="text" name="kry_mutasi_kredit" class="form-control" value="0" 
										id="kry_mutasi_kredit" >
									
										</td>
										
									</tr>
									<input type="hidden" name="kry_saldo" class="form-control" value="0" 
										id="kry_saldo" >
									<tr>
									<td colspan="6">
										<input  name="submit_from" id="submit_from" class="btn btn-custom" value="Submit" style="width:200px;" >
									</td>
									</tr>
									</div>
								</table>
								
								
							</div>								
						</div>
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
					
					 <div id="tabeldata">
                    
               
								     </div>
							</div>
					</div>	
					
					</div>
	
					
					<div id="historical_kredit_kry_pemohon" style="display:block;" >	
					<div class="row">
					<div class="col-md-12 col-sm-12">	
					<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
									</tr>
									
									
								</table>
							</div>
					</div>
					</div>
					
					<!-- Tombol utama -->
					<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
						<button type="button" id="loadDetail-pemohon-kry" class="btn btn-custom" style="width: 90%; max-width: 800px;">
							Load Detail Fasilitas aktif dan non aktif
						</button>
					</div>
					<!-- Tempat hasil muncul -->
					<div id="hasilLoad-pemohon-kry"></div>
					
					<div class="row">
					<div class="col-md-6 col-sm-6">	
					<div class="table-responsive">
				
							
					<table id="datatable2" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>
										
									</tr>
								</thead>
								<tbody>
								<?php
								
								$callDataPemohon = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
								$paramDataPemohon =  array(array($prospect, SQLSRV_PARAM_IN),
													array('PEMOHON', SQLSRV_PARAM_IN));
								$execDataPemohon = sqlsrv_query( $conn, $callDataPemohon, $paramDataPemohon) or die( print_r( sqlsrv_defaults(), true)); 
								$dataDataPemohon = sqlsrv_fetch_array($execDataPemohon);

																		
								IF($dataDataPemohon['SOURCE_BY'] == 'PEFINDO'){										
									$callPemohonScore= "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								
								}else{
									$callPemohonScore= "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
									$paramPemohonScore =  array(array($mapping_id, SQLSRV_PARAM_IN));
									$execPemohonScore = sqlsrv_query( $conn, $callPemohonScore, $paramPemohonScore) or die( print_r( sqlsrv_defaults(), true)); 
									$dataPemohonScore = sqlsrv_fetch_array($execPemohonScore);
								}

										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_NON_AKTIF'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_NON_AKTIF'],0,',','.');?></td>
									</tr>
									<tr>
										<td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
										<td class="td-custom" style="padding:5px;"><?php echo $dataPemohonScore['FASILITAS_RESTRUKTUR'];?></td>
										<td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPemohonScore['ANGSURAN_RESTRUKTUR'],0,',','.');?></td>
									</tr>
								</tbody>
							</table>
							
								
							</div>
							<span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia, 
									Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini  
							</span>
							<br>
							<br>
					</div>	
					
					</div>
					
					</div>
					</div>
						
					</div>
									<!-- ---------- SUMMARY ---------- -->
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered">
													<tr><td><b>Summary</b></td></tr>
												</table>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12 col-sm-12">
											<div class="table-responsive">
												<table class="table table-bordered">
													<tr>
														<td style="width:35%;">Next Approval BM User Name</td>
														<td>
															<input type="text" name="next_approval_bm" class="form-control" value="<?php echo h($dataCheckNextApprovalBM['USERNAME']); ?>" id="next_approval_bm" readonly>
															<?php if ($dataCheckNextApprovalBM['USERNAME'] == $user) { ?>
															<br>
															<div style="color:red"> WARNING: USER dan next Approval tidak boleh sama, silahkan hubung IT Help desk.</div>
															<?php } ?>
														</td>
													</tr>
												</table>

												<!-- ---------- NOTE + PLAFON ---------- -->
												<table class="table table-bordered">
													<tr>
														<td style="width:35%;">NOTE : </td>
														<td><input type="text" name="note_rak" class="form-control" value="" id="note_rak"></td>
													</tr>
													<tr>
														<td>Plafon yang diajukan sesuai pengajuan sebelumnya?</td>
														<td>
															<select name="plafon_sesuai" id="plafon_sesuai" class="form-control" style="max-width:200px;">
																<option value="YA" selected>Ya</option>
																<option value="TIDAK">Tidak</option>
															</select>
														</td>
													</tr>
													<tr>
														<td>Nominal Plafon yang Diajukan <span style="color:red;">*</span></td>
														<td>
															<div class="input-group" style="max-width:350px;">
																<span class="input-group-addon">Rp</span>
																<input type="text" name="plafon_nominal" id="plafon_nominal" class="form-control"
																	value="<?php echo number_format($plafon_awal, 0, ',', '.'); ?>"
																	data-awal="<?php echo number_format($plafon_awal, 0, ',', '.'); ?>"
																	autocomplete="off" readonly>
															</div>
															<small class="text-muted">Pengajuan plafon awal: Rp <?php echo number_format($plafon_awal, 0, ',', '.'); ?>. Pilih "Tidak" untuk menyesuaikan nominal.</small>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>

									<?php if ($dataCheckNextApprovalBM['USERNAME'] != $user) { ?>
									<input type="submit" name="submitNo" id="submitNo" class="btn btn-custom" value="TIDAK REKOMEN" style="width:200px;">
									<input type="submit" name="submit1" id="submit1" class="btn btn-custom" value="REKOMEN" style="width:200px;">
									<?php } ?>
									<br>
									<div id="error" hidden>
										<div id="error-message" style="color:red"></div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
$(function () {

	// ---------- Phone Verification (aktif di tab pertama, langsung load) ----------
	var container = $('#phone-verif-container');
	container
		.html('<div class="text-muted">Loading phone verification...</div>')
		.load('view-phone-verification.php', {
			siapanih: container.data('siapanih'),
			ktp_pemohon: container.data('ktp'),
			ktpsaya: container.data('ktpsaya'),
			custmodel: container.data('custmodel'),
			custmodelpas: container.data('custmodelpas'),
			orderno: container.data('orderno')
		});

	// cek apakah phone verification sudah ada saat buka tab RAK
	$('#tab-rak').on('click', function () {
		var orderNo = $('input[name="order_no"]').val();
		if (!orderNo) return;
		$.post('check_phone_verif_exist.php', { order_no: orderNo }, function (res) {
			$('#done_phone_verif').val(res && res.exist ? 1 : 0);
		}, 'json');
	});

	// ---------- Viewer file: isi file baru diminta saat tombol diklik ----------
	$(document).on('click', '.btn-view-file', function () {
		var $b    = $(this);
		var $item = $b.closest('.file-item');
		var $v    = $item.find('.file-viewer');
		var label = $b.data('label');

		// klik kedua = tutup
		if ($v.is(':visible')) {
			$v.hide();
			$b.text(label);
			return;
		}

		if (!$v.data('loaded')) {
			var url  = 'view-file-plafond.php?trx=' + encodeURIComponent($b.data('trx')) + '&slug=' + encodeURIComponent($b.data('slug')) + '&v=3';
			var mime = String($b.data('mime') || '');

			if (mime.indexOf('image/') === 0) {
				var fileTitle = $item.find('small.text-muted').text() || 'Detail Foto';
				var $loading  = $('<div class="text-muted">Memuat gambar...</div>');
				var $lbLink   = $('<a data-lightbox="property"></a>')
					.attr('href', url)
					.attr('title', fileTitle);

				var $img = $('<img alt="" style="cursor:pointer;" title="Klik untuk memperbesar (Lightbox)">')
					.on('load', function () { $loading.remove(); })
					.on('error', function () {
						$img.remove();
						// ambil pesan error asli dari server supaya penyebabnya kelihatan
						$.ajax({ url: url + '&debug=1&_=' + new Date().getTime(), dataType: 'text', cache: false })
							.done(function (t) {
								$loading.html('<span style="color:red;">Gagal memuat gambar.</span><pre style="max-height:150px;overflow:auto;white-space:pre-wrap;">' + $('<div>').text(String(t).substring(0, 800)).html() + '</pre>');
							})
							.fail(function (x) {
								$loading.html('<span style="color:red;">Gagal memuat gambar (HTTP ' + x.status + ').</span><pre style="max-height:150px;overflow:auto;white-space:pre-wrap;">' + $('<div>').text(String(x.responseText || '').substring(0, 800)).html() + '</pre>');
							});
					});

				$lbLink.append($img);
				$v.append($loading).append($lbLink);
				$img.attr('src', url);
			} else if (mime === 'application/pdf') {
				var $link = $('<a target="_blank"></a>').attr('href', url).text('Buka di tab baru');
				var $frame = $('<iframe></iframe>');
				$v.append($frame).append('<br>').append($link);
				$frame.attr('src', url);
			} else {
				window.open(url, '_blank');
				return;
			}
			$v.data('loaded', 1);
		}
		$v.show();
		$b.text('Tutup');
	});

	// ---------- Plafon ----------
	var $sesuai  = $('#plafon_sesuai');
	var $nominal = $('#plafon_nominal');
	var awal     = $nominal.data('awal');

	function formatRupiah(v) {
		var d = String(v).replace(/[^0-9]/g, '');
		if (d === '') return '';
		return d.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}

	$sesuai.on('change', function () {
		if ($(this).val() === 'YA') {
			$nominal.val(awal).prop('readonly', true);
		} else {
			$nominal.prop('readonly', false).focus().select();
		}
	});

	$nominal.on('input', function () {
		$(this).val(formatRupiah($(this).val()));
	});

	$('#form_rak_plafond').on('submit', function () {
		if ($sesuai.val() === 'TIDAK') {
			var n = parseInt(String($nominal.val()).replace(/[^0-9]/g, ''), 10);
			if (!n || n <= 0) {
				alert('Nominal plafon yang diajukan harus diisi dan lebih dari 0');
				$nominal.focus();
				return false;
			}
		}
		return true;
	});
});
</script>

<script src="assets/js/jqueryrotate.min.js"></script>
<script>
(function() {
  var $, Lightbox, LightboxOptions;

  $ = jQuery;

  LightboxOptions = (function() {
    function LightboxOptions() {
      this.fadeDuration = 500;
      this.fitImagesInViewport = true;
      this.resizeDuration = 700;
      this.showImageNumberLabel = true;
      this.wrapAround = false;
    }

    LightboxOptions.prototype.albumLabel = function(curImageNum, albumSize) {
      return "Image " + curImageNum + " of " + albumSize;
    };

    return LightboxOptions;

  })();

  Lightbox = (function() {
    function Lightbox(options) {
      this.options = options;
      this.album = [];
      this.currentImageIndex = void 0;
      this.init();
    }

    Lightbox.prototype.init = function() {
      this.enable();
      return this.build();
    };

    Lightbox.prototype.enable = function() {
      var _this = this;
      return $('body').on('click', 'a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]', function(e) {
        _this.start($(e.currentTarget));
        return false;
      });
    };

    Lightbox.prototype.build = function() {
      var _this = this;
      if ($('#lightbox').length === 0) {
        $("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close' style='margin:5px;'><button class='btn btn-danger btn-sm btn-fill'><i class='fa fa-times'></i></button></a>&nbsp;&nbsp;&nbsp;<a class='lb-rotate' style='margin:5px;'><button class='btn btn-primary btn-sm btn-fill' style='margin-right:5px;'><i class='fa fa-undo'></i></button></a></div></div></div></div>").appendTo($('body'));
      }
      this.$lightbox = $('#lightbox');
      this.$overlay = $('#lightboxOverlay');
      this.$outerContainer = this.$lightbox.find('.lb-outerContainer');
      this.$container = this.$lightbox.find('.lb-container');
      this.containerTopPadding = parseInt(this.$container.css('padding-top'), 10);
      this.containerRightPadding = parseInt(this.$container.css('padding-right'), 10);
      this.containerBottomPadding = parseInt(this.$container.css('padding-bottom'), 10);
      this.containerLeftPadding = parseInt(this.$container.css('padding-left'), 10);
      this.$overlay.hide().on('click', function() {
        _this.end();
        return false;
      });
      this.$lightbox.hide().on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$outerContainer.on('click', function(e) {
        if ($(e.target).attr('id') === 'lightbox') {
          _this.end();
        }
        return false;
      });
      this.$lightbox.find('.lb-prev').on('click', function() {
        if (_this.currentImageIndex === 0) {
          _this.changeImage(_this.album.length - 1);
        } else {
          _this.changeImage(_this.currentImageIndex - 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-next').on('click', function() {
        if (_this.currentImageIndex === _this.album.length - 1) {
          _this.changeImage(0);
        } else {
          _this.changeImage(_this.currentImageIndex + 1);
        }
        return false;
      });
      this.$lightbox.find('.lb-rotate').on('click', function() {
          $cont = _this.$lightbox.find('.lb-outerContainer');
          $image = _this.$lightbox.find('.lb-image');
          
          if ($($cont).attr('angle') == null) {
              $($cont).attr('angle', 0);
          }
          var value = Number($($cont).attr('angle'));
          value += 90;
      
          if (typeof $($cont).rotate === 'function') {
              $($cont).rotate({ animateTo: value });
          } else {
              $($cont).css('transform', 'rotate(' + value + 'deg)');
          }
          $($cont).attr('angle', value);          
          
          return false;
      });      
      
      return this.$lightbox.find('.lb-loader, .lb-close').on('click', function() {
        _this.end();
        return false;
      });
    };

    Lightbox.prototype.start = function($link) {
      var $window, a, dataLightboxValue, i, imageNumber, left, top, _i, _j, _len, _len1, _ref, _ref1;
      $(window).on("resize", this.sizeOverlay);
      $('select, object, embed').css({
        visibility: "hidden"
      });
      this.$overlay.width($(document).width()).height($(document).height()).fadeIn(this.options.fadeDuration);
      this.album = [];
      imageNumber = 0;
      dataLightboxValue = $link.attr('data-lightbox');
      if (dataLightboxValue) {
        _ref = $($link.prop("tagName") + '[data-lightbox="' + dataLightboxValue + '"]');
        for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
          a = _ref[i];
          this.album.push({
            link: $(a).attr('href'),
            title: $(a).attr('title')
          });
          if ($(a).attr('href') === $link.attr('href')) {
            imageNumber = i;
          }
        }
      } else {
        if ($link.attr('rel') === 'lightbox') {
          this.album.push({
            link: $link.attr('href'),
            title: $link.attr('title')
          });
        } else {
          _ref1 = $($link.prop("tagName") + '[rel="' + $link.attr('rel') + '"]');
          for (i = _j = 0, _len1 = _ref1.length; _j < _len1; i = ++_j) {
            a = _ref1[i];
            this.album.push({
              link: $(a).attr('href'),
              title: $(a).attr('title')
            });
            if ($(a).attr('href') === $link.attr('href')) {
              imageNumber = i;
            }
          }
        }
      }
      $window = $(window);
      top = $window.scrollTop() + $window.height() / 10;
      left = $window.scrollLeft();
      this.$lightbox.css({
        top: top + 'px',
        left: left + 'px'
      }).fadeIn(this.options.fadeDuration);
      this.changeImage(imageNumber);
    };

    Lightbox.prototype.changeImage = function(imageNumber) {
      var $image, preloader,
        _this = this;
      this.disableKeyboardNav();
      $image = this.$lightbox.find('.lb-image');
      
      var $cont = this.$lightbox.find('.lb-outerContainer');
      $cont.attr('angle', 0);
      if (typeof $cont.rotate === 'function') {
        $cont.rotate({ animateTo: 0 });
      } else {
        $cont.css('transform', '');
      }

      this.sizeOverlay();
      this.$overlay.fadeIn(this.options.fadeDuration);
      $('.lb-loader').fadeIn('slow');
      this.$lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption').hide();
      this.$outerContainer.addClass('animating');
      preloader = new Image();
      preloader.onload = function() {
        var $preloader, imageHeight, imageWidth, maxImageHeight, maxImageWidth, windowHeight, windowWidth;
        $image.attr('src', _this.album[imageNumber].link);
        $preloader = $(preloader);
        $image.width(preloader.width);
        $image.height(preloader.height);
        if (_this.options.fitImagesInViewport) {
          windowWidth = $(window).width();
          windowHeight = $(window).height();
          maxImageWidth = windowWidth - _this.containerLeftPadding - _this.containerRightPadding - 20;
          maxImageHeight = windowHeight - _this.containerTopPadding - _this.containerBottomPadding - 110;
          if ((preloader.width > maxImageWidth) || (preloader.height > maxImageHeight)) {
            if ((preloader.width / maxImageWidth) > (preloader.height / maxImageHeight)) {
              imageWidth = maxImageWidth;
              imageHeight = parseInt(preloader.height / (preloader.width / imageWidth), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            } else {
              imageHeight = maxImageHeight;
              imageWidth = parseInt(preloader.width / (preloader.height / imageHeight), 10);
              $image.width(imageWidth);
              $image.height(imageHeight);
            }
          }
        }
        return _this.sizeContainer($image.width(), $image.height());
      };
      preloader.src = this.album[imageNumber].link;
      this.currentImageIndex = imageNumber;
    };

    Lightbox.prototype.sizeOverlay = function() {
      return $('#lightboxOverlay').width($(document).width()).height($(document).height());
    };

    Lightbox.prototype.sizeContainer = function(imageWidth, imageHeight) {
      var newHeight, newWidth, oldHeight, oldWidth,
        _this = this;
      oldWidth = this.$outerContainer.outerWidth();
      oldHeight = this.$outerContainer.outerHeight();
      newWidth = imageWidth + this.containerLeftPadding + this.containerRightPadding;
      newHeight = imageHeight + this.containerTopPadding + this.containerBottomPadding;
      this.$outerContainer.animate({
        width: newWidth,
        height: newHeight
      }, this.options.resizeDuration, 'swing');
      setTimeout(function() {
        _this.$lightbox.find('.lb-dataContainer').width(newWidth);
        _this.$lightbox.find('.lb-prevLink').height(newHeight);
        _this.$lightbox.find('.lb-nextLink').height(newHeight);
        _this.showImage();
      }, this.options.resizeDuration);
    };

    Lightbox.prototype.showImage = function() {
      this.$lightbox.find('.lb-loader').hide();
      this.$lightbox.find('.lb-image').fadeIn('slow');
      this.updateNav();
      this.updateDetails();
      this.preloadNeighboringImages();
      this.enableKeyboardNav();
    };

    Lightbox.prototype.updateNav = function() {
      this.$lightbox.find('.lb-nav').show();
      if (this.album.length > 1) {
        if (this.options.wrapAround) {
          this.$lightbox.find('.lb-prev, .lb-next').show();
        } else {
          if (this.currentImageIndex > 0) {
            this.$lightbox.find('.lb-prev').show();
          }
          if (this.currentImageIndex < this.album.length - 1) {
            this.$lightbox.find('.lb-next').show();
          }
        }
      }
    };

    Lightbox.prototype.updateDetails = function() {
      var _this = this;
      if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "") {
        this.$lightbox.find('.lb-caption').html(this.album[this.currentImageIndex].title).fadeIn('fast');
      }
      if (this.album.length > 1 && this.options.showImageNumberLabel) {
        this.$lightbox.find('.lb-number').text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn('fast');
      } else {
        this.$lightbox.find('.lb-number').hide();
      }
      this.$outerContainer.removeClass('animating');
      this.$lightbox.find('.lb-dataContainer').fadeIn(this.resizeDuration, function() {
        return _this.sizeOverlay();
      });
    };

    Lightbox.prototype.preloadNeighboringImages = function() {
      var preloadNext, preloadPrev;
      if (this.album.length > this.currentImageIndex + 1) {
        preloadNext = new Image();
        preloadNext.src = this.album[this.currentImageIndex + 1].link;
      }
      if (this.currentImageIndex > 0) {
        preloadPrev = new Image();
        preloadPrev.src = this.album[this.currentImageIndex - 1].link;
      }
    };

    Lightbox.prototype.enableKeyboardNav = function() {
      $(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
    };

    Lightbox.prototype.disableKeyboardNav = function() {
      $(document).off('.keyboard');
    };

    Lightbox.prototype.keyboardAction = function(event) {
      var KEYCODE_ESC, KEYCODE_LEFTARROW, KEYCODE_RIGHTARROW, key, keycode;
      KEYCODE_ESC = 27;
      KEYCODE_LEFTARROW = 37;
      KEYCODE_RIGHTARROW = 39;
      keycode = event.keyCode;
      key = String.fromCharCode(keycode).toLowerCase();
      if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
        this.end();
      } else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
        if (this.currentImageIndex !== 0) {
          this.changeImage(this.currentImageIndex - 1);
        }
      } else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
        if (this.currentImageIndex !== this.album.length - 1) {
          this.changeImage(this.currentImageIndex + 1);
        }
      }
    };

    Lightbox.prototype.end = function() {
      this.disableKeyboardNav();
      $(window).off("resize", this.sizeOverlay);
      this.$lightbox.fadeOut(this.options.fadeDuration);
      this.$overlay.fadeOut(this.options.fadeDuration);
      return $('select, object, embed').css({
        visibility: "visible"
      });
    };

    return Lightbox;

  })();

  $(function() {
    var lightbox, options;
    options = new LightboxOptions();
    return lightbox = new Lightbox(options);
  });

}).call(this);
</script>