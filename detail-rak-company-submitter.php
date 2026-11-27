<?php

ini_set('max_execution_time', 0);

// for file directory (choose one)
// const BASE_URL = "http://172.16.2.5/h2h_pefindo/"; # OUTSIDE 2.5
const BASE_URL = ""; # INSIDE 2.5

const FILE_DIR_NPWP = "assets/company/NPWP/";
const FILE_DIR_LO = "assets/company/LO/";
const FILE_DIR_FAPP = "assets/company/FAPP/";
function displayFile($_fileName, $_fileType, $_filePath, $_fileTitle)
{
    // extension reader
    $is_image = array('gif', 'png', 'jpg', 'jpeg');

    if ($_fileName <> NULL) {
        if (in_array(strtolower($_fileType), $is_image)) {
            $lightbox = '<a href="' . BASE_URL . $_filePath . '" ';

            $lightbox .= 'data-lightbox="property">';
            $lightbox .= '<button type="button" class="btn btn-custom btn-xs img-polaroid" style="width:180px;"><i class="fa fa-image">';
            $lightbox .= "</i>Foto $_fileTitle</button></a>";

            echo $lightbox;
        } else {
            echo '<a href="' . BASE_URL . $_filePath . '" target="_blank" class="btn btn-custom btn-xs img-polaroid" style="width:180px;">File ' . $_fileTitle . '</a>';
        }
    }
}

function verifyToDecimal($param) {
	// return (isset($param) && !empty($param)) ? str_replace(str_split('\\/:*?"<>|,.'), '', $param) : 0;
	
    if (isset($param) && !empty($param)) {
        // Menghapus karakter pemisah ribuan ('.') dan mengganti pemisah desimal (',') dengan titik ('.')
        $param = str_replace('.', '', $param); // Menghapus titik pemisah ribuan
        $param = str_replace(',', '.', $param); // Mengganti koma pemisah desimal dengan titik
        return (float) $param; // Mengembalikan nilai sebagai float
    }
    return 0;
}

function prepareImageDBString($filepath){
	$output = 'null';
	$handle = @fopen($filepath, 'rb');
	if ($handle){
		$content = @fread($handle, filesize($filepath));
		$content = bin2hex($content);
		@fclose($handle);
		$output = "0x".strtoupper($content);
	}
	return $output;
}

# parameter
$user      = $_GET['USERNAME'];
$order_no  = $_GET['ORDER_NO'];

# submit
if (isset($_POST['submit_RAK']))
{

    # Header
    $rak_area            = $_POST['rak_area'];
    $branch_id           = $_POST['branch_id'];
    $rak_cabang          = $_POST['rak_cabang'];
    $rak_no_order        = $_POST['rak_no_order'];
    $ref_type            = $_POST['ref_type'];
    $rak_tanggal_order   = $_POST['rak_tanggal_order'];
    $cust_id             = $_POST['cust_id'];
    $rak_nama_perusahaan = $_POST['rak_nama_perusahaan'];
    $rak_jenis_kendaraan = $_POST['rak_jenis_kendaraan'];
    $rak_tahun_kendaraan = $_POST['rak_tahun_kendaraan'];
    $rak_asset_name      = $_POST['rak_asset_name'];
    $rak_nama_dealer     = $_POST['rak_nama_dealer'];
    $rak_jenis_pengajuan = $_POST['rak_jenis_pengajuan'];
    $rak_ph              = verifyToDecimal($_POST['rak_ph']);
    $rak_ph_ao           = verifyToDecimal($_POST['rak_ph_ao']);
    $rak_ph_total        = verifyToDecimal($_POST['rak_ph_total']);
    $rak_otr             = verifyToDecimal($_POST['rak_otr']);
    $rak_tenor           = verifyToDecimal($_POST['rak_tenor']);
    $rak_amount_tdp      = verifyToDecimal($_POST['rak_amount_tdp']);
    $rak_tdp_persen      = $_POST['rak_tdp_persen'];
    $rak_angsuran        = verifyToDecimal($_POST['rak_angsuran']);
    $rak_nama_CMO        = $_POST['rak_nama_CMO'];
    $rak_nama_SBH        = $_POST['rak_nama_SBH'];
    $rak_nama_CA         = $_POST['rak_nama_CA'];
    $rak_company_profile = $_POST['rak_company_profile'];
    $is_subbranch        = $_POST['is_subbranch'];
    $username            = $_POST['username'];


    
    $callHeader = "{call SP_RAK_CPY_INSERT_HEADER(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramHeader = array(
        array($rak_area, SQLSRV_PARAM_IN),
        array($branch_id, SQLSRV_PARAM_IN),
        array($rak_cabang, SQLSRV_PARAM_IN),
        array($rak_no_order, SQLSRV_PARAM_IN),
        array($ref_type, SQLSRV_PARAM_IN),
        array($rak_tanggal_order, SQLSRV_PARAM_IN),
        array($cust_id, SQLSRV_PARAM_IN),
        array($rak_nama_perusahaan, SQLSRV_PARAM_IN),
        array($rak_jenis_kendaraan, SQLSRV_PARAM_IN),
        array($rak_tahun_kendaraan, SQLSRV_PARAM_IN),
        array($rak_asset_name, SQLSRV_PARAM_IN),
        array($rak_nama_dealer, SQLSRV_PARAM_IN),
        array($rak_jenis_pengajuan, SQLSRV_PARAM_IN),
        array($rak_ph, SQLSRV_PARAM_IN),
        array($rak_ph_ao, SQLSRV_PARAM_IN),
        array($rak_ph_total, SQLSRV_PARAM_IN),
        array($rak_otr, SQLSRV_PARAM_IN),
        array($rak_tenor, SQLSRV_PARAM_IN),
        array($rak_amount_tdp, SQLSRV_PARAM_IN),
        array($rak_tdp_persen, SQLSRV_PARAM_IN),
        array($rak_angsuran, SQLSRV_PARAM_IN),
        array($rak_nama_CMO, SQLSRV_PARAM_IN),
        array($rak_nama_SBH, SQLSRV_PARAM_IN),
        array($rak_nama_CA, SQLSRV_PARAM_IN),
        array($rak_company_profile, SQLSRV_PARAM_IN),
        array($is_subbranch, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execHeader = sqlsrv_query($conn, $callHeader, $paramHeader) or die(print_r(sqlsrv_errors(), true)); // Return ID
    $rowHeader = sqlsrv_fetch_array($execHeader, SQLSRV_FETCH_ASSOC);

    # parameter
    $rak_h_id = $rowHeader['CPY_RAK_H_ID'];
    $role_code = ($is_subbranch === "YA") ? 'SBH' : 'CA';

    # Detail - Deviasi
    $callDetailDeviasi = "{call SP_RAK_CPY_INSERT_UPDATE_DEVIASI(?, ?, ?, ?, ?, ?, ?)}";
    $paramDetailDeviasi = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['dev_lap_keu_opt']) ? $_POST['dev_lap_keu_opt'] : '0', SQLSRV_PARAM_IN),
        array(isset($_POST['dev_data_keuangan_opt']) ? $_POST['dev_data_keuangan_opt'] : '0', SQLSRV_PARAM_IN),
        array(isset($_POST['dev_durasi_perusahaan_opt']) ? $_POST['dev_durasi_perusahaan_opt'] : '0', SQLSRV_PARAM_IN),
        array(isset($_POST['dev_dsr_opt']) ? $_POST['dev_dsr_opt'] : '0', SQLSRV_PARAM_IN),
        array(isset($_POST['dev_tdp_opt']) ? $_POST['dev_tdp_opt'] : '0', SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execDetailDeviasi = sqlsrv_query($conn, $callDetailDeviasi, $paramDetailDeviasi) or die(print_r(sqlsrv_errors(), true));

    # Detail - Badan Hukum
    $callDetailBahuk = "{call SP_RAK_CPY_INSERT_UPDATE_BADAN_HUKUM(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramDetailBahuk = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_company_type']) ? $_POST['vi_company_type'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_nama_badan_hukum']) ? $_POST['vi_nama_badan_hukum'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_no_npwp']) ? $_POST['vi_no_npwp'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_tgL_pendirian']) ? $_POST['vi_tgL_pendirian'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_jum_total_karyawan']) ? $_POST['vi_jum_total_karyawan'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_no_telp']) ? $_POST['vi_no_telp'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_alamat_pendirian_badan_hukum']) ? $_POST['vi_alamat_pendirian_badan_hukum'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_alamat_dom_badan_hukum']) ? $_POST['vi_alamat_dom_badan_hukum'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_summary_val']) ? $_POST['vi_summary_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vi_summary_note']) ? $_POST['vi_summary_note'] : NULL, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execDetailBahuk = sqlsrv_query($conn, $callDetailBahuk, $paramDetailBahuk) or die(print_r(sqlsrv_errors(), true));
    
    # Detail - Dom Usaha
    $_POST['vd_siup_nib_val']                = (isset($_POST['vd_siup_nib_opt']) && $_POST['vd_siup_nib_opt'] == '1') ? $_POST['vd_siup_nib_val'] : '0';
    $_POST['vd_imb_val']                     = (isset($_POST['vd_imb_opt']) && $_POST['vd_imb_opt'] == '1') ? $_POST['vd_imb_val'] : '0';
    $_POST['vd_bukti_kepem_tanah_val']       = (isset($_POST['vd_bukti_kepem_tanah_opt']) && $_POST['vd_bukti_kepem_tanah_opt'] == '1') ? $_POST['vd_bukti_kepem_tanah_val'] : '0';
    $_POST['vd_surat_ket_dom_gedung_val']    = (isset($_POST['vd_surat_ket_dom_gedung_opt']) && $_POST['vd_surat_ket_dom_gedung_opt'] == '1') ? $_POST['vd_surat_ket_dom_gedung_val'] : '0';
    $_POST['vd_bukti_pembayaran_pbb_val']    = (isset($_POST['vd_bukti_pembayaran_pbb_opt']) && $_POST['vd_bukti_pembayaran_pbb_opt'] == '1') ? $_POST['vd_bukti_pembayaran_pbb_val'] : '0';
    $_POST['vd_rek_listrik_val']             = (isset($_POST['vd_rek_listrik_opt']) && $_POST['vd_rek_listrik_opt'] == '1') ? $_POST['vd_rek_listrik_val'] : '0';
    $_POST['vd_surat_izin_tempat_usaha_val'] = (isset($_POST['vd_surat_izin_tempat_usaha_opt']) && $_POST['vd_surat_izin_tempat_usaha_opt'] == '1') ? $_POST['vd_surat_izin_tempat_usaha_val'] : '0';

    if (!isset($_POST['vd_status_badan_hukum_opt'])) {
        $_POST['vd_status_badan_hukum_type'] = '0';
        $_POST['vd_status_badan_hukum_val'] = NULL;
        $_POST['vd_status_badan_hukum_type_note'] = NULL;
    }

    if (!isset($_POST['vd_status_kep_tempat_opt'])) {
        $_POST['vd_status_kep_tempat_type'] = '0';
        $_POST['vd_status_kep_tempat_val'] = NULL;
        $_POST['vd_status_kep_tempat_type_note'] = NULL;
    }
    
    $callDomUsaha = "{call SP_RAK_CPY_INSERT_UPDATE_DOM_USAHA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramDomUsaha = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_siup_nib_val']) ? $_POST['vd_siup_nib_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_imb_val']) ? $_POST['vd_imb_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_bukti_kepem_tanah_val']) ? $_POST['vd_bukti_kepem_tanah_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_surat_ket_dom_gedung_val']) ? $_POST['vd_surat_ket_dom_gedung_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_bukti_pembayaran_pbb_val']) ? $_POST['vd_bukti_pembayaran_pbb_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_rek_listrik_val']) ? $_POST['vd_rek_listrik_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_surat_izin_tempat_usaha_val']) ? $_POST['vd_surat_izin_tempat_usaha_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_badan_hukum_type']) ? $_POST['vd_status_badan_hukum_type'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_badan_hukum_val']) ? $_POST['vd_status_badan_hukum_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_badan_hukum_type_note']) ? $_POST['vd_status_badan_hukum_type_note'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_kep_tempat_type']) ? $_POST['vd_status_kep_tempat_type'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_kep_tempat_val']) ? $_POST['vd_status_kep_tempat_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_status_kep_tempat_type_note']) ? $_POST['vd_status_kep_tempat_type_note'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_cara_validasi']) ? $_POST['vd_cara_validasi'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vd_cara_validasi_note']) ? $_POST['vd_cara_validasi_note'] : NULL, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execDomUsaha = sqlsrv_query($conn, $callDomUsaha, $paramDomUsaha) or die(print_r(sqlsrv_errors(), true));

    # Detail - Validasi Hasil Survey
    $callHasilSurvey = "{call SP_RAK_CPY_INSERT_UPDATE_HASIL_SURVEY(?, ?, ?, ?, ?, ?)}";
    $paramHasilSurvey = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['latitude']) ? $_POST['latitude'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['longitude']) ? $_POST['longitude'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vhs_hasil_foto_vs_geotag_val']) ? $_POST['vhs_hasil_foto_vs_geotag_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vhs_hasil_foto_vs_geotag_note']) ? $_POST['vhs_hasil_foto_vs_geotag_note'] : NULL, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execHasilSurvey = sqlsrv_query($conn, $callHasilSurvey, $paramHasilSurvey) or die(print_r(sqlsrv_errors(), true));

    # Detail - Kapasitas
    $_POST['vk_rekening_badan_hukum_val']   = (isset($_POST['vk_rekening_badan_hukum_opt']) && $_POST['vk_rekening_badan_hukum_opt'] == '1') ? $_POST['vk_rekening_badan_hukum_val'] : '0';
    $_POST['vk_rekening_pengurus_val']      = (isset($_POST['vk_rekening_pengurus_opt']) && $_POST['vk_rekening_pengurus_opt'] == '1') ? $_POST['vk_rekening_pengurus_val'] : '0';
    $_POST['vk_lap_keu_terakhir_val']       = (isset($_POST['vk_lap_keu_terakhir_opt']) && $_POST['vk_lap_keu_terakhir_opt'] == '1') ? $_POST['vk_lap_keu_terakhir_val'] : '0';
    $_POST['vk_lap_pembukuan_terakhir_val'] = (isset($_POST['vk_lap_pembukuan_terakhir_opt']) && $_POST['vk_lap_pembukuan_terakhir_opt'] == '1') ? $_POST['vk_lap_pembukuan_terakhir_val'] : '0';
    $_POST['vk_spt_terakhir_val']           = (isset($_POST['vk_spt_terakhir_opt']) && $_POST['vk_spt_terakhir_opt'] == '1') ? $_POST['vk_spt_terakhir_val'] : '0';
    
    $callKapasitas = "{call SP_RAK_CPY_INSERT_UPDATE_KAPASITAS(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramKapasitas = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_customer_model']) ? $_POST['vk_customer_model'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_rekening_badan_hukum_val']) ? $_POST['vk_rekening_badan_hukum_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_rekening_pengurus_val']) ? $_POST['vk_rekening_pengurus_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_lap_keu_terakhir_val']) ? $_POST['vk_lap_keu_terakhir_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_lap_pembukuan_terakhir_val']) ? $_POST['vk_lap_pembukuan_terakhir_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_spt_terakhir_val']) ? $_POST['vk_spt_terakhir_val'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_nama_bank_penerbit']) ? $_POST['vk_nama_bank_penerbit'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_nomor_rekening']) ? $_POST['vk_nomor_rekening'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_nama_pemilik_rekening']) ? $_POST['vk_nama_pemilik_rekening'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_mutasi_yang_dilampirkan_type']) ? $_POST['vk_mutasi_yang_dilampirkan_type'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['vk_cara_validasi']) ? $_POST['vk_cara_validasi'] : NULL, SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['mrt_saldo_awal']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['mrt_saldo_akhir']), SQLSRV_PARAM_IN),
        array(isset($_POST['inv_yang_dilampirkan_type']) ? $_POST['inv_yang_dilampirkan_type'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['inv_periode_type']) ? $_POST['inv_periode_type'] : NULL, SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['inv_nominal_akhir']), SQLSRV_PARAM_IN),
        array(isset($_POST['lkt_tahun_laporan']) ? $_POST['lkt_tahun_laporan'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['lkt_status_audit']) ? $_POST['lkt_status_audit'] : NULL, SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['lkt_nominal_laporan']), SQLSRV_PARAM_IN),
        array(isset($_POST['lkt_margin_pendapatan_usaha']) ? $_POST['lkt_margin_pendapatan_usaha'] : NULL, SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['lkt_total_pendapatan_usaha']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['lkt_biaya_operasional']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['lkt_net_pendapatan_usaha']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['lkt_nominal_income_final']), SQLSRV_PARAM_IN),
        array($role_code, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execKapasitas = sqlsrv_query($conn, $callKapasitas, $paramKapasitas) or die(print_r(sqlsrv_errors(), true));

    # Detail - Historikal Kredit Eksternal
    $callHistorikal = "{call SP_RAK_CPY_INSERT_UPDATE_HISTORIKAL_KREDIT(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramHistorikal = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(isset($_POST['status_proxy_income']) ? $_POST['status_proxy_income'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['status_collectibility']) ? $_POST['status_collectibility'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['status_level']) ? $_POST['status_level'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['score_desc']) ? $_POST['score_desc'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['segmentation']) ? $_POST['segmentation'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['hke_TDP']) ? $_POST['hke_TDP'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['hke_min_TDP']) ? $_POST['hke_min_TDP'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['hke_level_approval']) ? $_POST['hke_level_approval'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['hke_lanjut_approval']) ? $_POST['hke_lanjut_approval'] : NULL, SQLSRV_PARAM_IN),
        array(isset($_POST['hke_analisa_kapasitas_note']) ? $_POST['hke_analisa_kapasitas_note'] : NULL, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execHistorikal = sqlsrv_query($conn, $callHistorikal, $paramHistorikal) or die(print_r(sqlsrv_errors(), true));

    # Detail - Summary
    $callSummary = "{call SP_RAK_CPY_INSERT_UPDATE_SUMMARY(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramSummary = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_pendapatan_badan_hukum']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_angsuran_new_SFI']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_angsuran_berjalan_SFI']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_kewajiban_angsuran_ditempat_lain']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_total_kewajiban']), SQLSRV_PARAM_IN),
        array(verifyToDecimal($_POST['sum_total_pendapatan']), SQLSRV_PARAM_IN),
        array($_POST['sum_DSR_percentage'], SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execSummary = sqlsrv_query($conn, $callSummary, $paramSummary) or die(print_r(sqlsrv_errors(), true));

    # Upload File
    $vd_upl_bukti_validasi = prepareImageDBString($_FILES['vd_upl_bukti_validasi']['tmp_name']);
    if ($vd_upl_bukti_validasi <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array(isset($_POST['vd_cara_validasi_note']) ? $_POST['vd_cara_validasi_note'] : NULL, SQLSRV_PARAM_IN),
            array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
            array($vd_upl_bukti_validasi, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['vd_upl_bukti_validasi']['type']), SQLSRV_PARAM_IN),
            array('DOMISILI USAHA', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }
    else if (isset($_POST['vd_cara_validasi_note']) && $_POST['vd_cara_validasi_note'] !== "")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array($_POST['vd_cara_validasi_note'], SQLSRV_PARAM_IN),
            array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
            array(NULL, SQLSRV_PARAM_IN),
            array(NULL, SQLSRV_PARAM_IN),
            array('DOMISILI USAHA', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    $vd_upl_bukti_pendukung = prepareImageDBString($_FILES['vd_upl_bukti_pendukung']['tmp_name']);
    if ($vd_upl_bukti_pendukung <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN),
            array('Bukti Pendukung', SQLSRV_PARAM_IN),
            array($vd_upl_bukti_pendukung, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['vd_upl_bukti_pendukung']['type']), SQLSRV_PARAM_IN),
            array('DOMISILI USAHA', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }
    
    $vhs_upl_hasil_geotagging = prepareImageDBString($_FILES['vhs_upl_hasil_geotagging']['tmp_name']);
    if ($vhs_upl_hasil_geotagging <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array(isset($_POST['vhs_hasil_foto_vs_geotag_note']) ? $_POST['vhs_hasil_foto_vs_geotag_note'] : NULL, SQLSRV_PARAM_IN),
            array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
            array($vhs_upl_hasil_geotagging, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['vhs_upl_hasil_geotagging']['type']), SQLSRV_PARAM_IN),
            array('HASIL SURVEY', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }
    else if (isset($_POST['vhs_hasil_foto_vs_geotag_note']) && $_POST['vhs_hasil_foto_vs_geotag_note'] !== "")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array($_POST['vhs_hasil_foto_vs_geotag_note'], SQLSRV_PARAM_IN),
            array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
            array(NULL, SQLSRV_PARAM_IN),
            array(NULL, SQLSRV_PARAM_IN),
            array('HASIL SURVEY', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    $vk_upl_bukti_validasi = prepareImageDBString($_FILES['vk_upl_bukti_validasi']['tmp_name']);
    if ($vk_upl_bukti_validasi <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN),
            array('Bukti Validasi Bank Account', SQLSRV_PARAM_IN),
            array($vk_upl_bukti_validasi, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['vk_upl_bukti_validasi']['type']), SQLSRV_PARAM_IN),
            array('KAPASITAS', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    $lkt_upl_bukti_lap_laba_rugi = prepareImageDBString($_FILES['lkt_upl_bukti_lap_laba_rugi']['tmp_name']);
    if ($lkt_upl_bukti_lap_laba_rugi <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN),
            array('Bukti Laporan Laba Rugi', SQLSRV_PARAM_IN),
            array($lkt_upl_bukti_lap_laba_rugi, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['lkt_upl_bukti_lap_laba_rugi']['type']), SQLSRV_PARAM_IN),
            array('KAPASITAS', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    $lkt_upl_bukti_neraca = prepareImageDBString($_FILES['lkt_upl_bukti_neraca']['tmp_name']);
    if ($lkt_upl_bukti_neraca <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN),
            array('Bukti Neraca', SQLSRV_PARAM_IN),
            array($lkt_upl_bukti_neraca, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['lkt_upl_bukti_neraca']['type']), SQLSRV_PARAM_IN),
            array('KAPASITAS', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    $lkt_upl_bukti_pendukung = prepareImageDBString($_FILES['lkt_upl_bukti_pendukung']['tmp_name']);
    if ($lkt_upl_bukti_pendukung <> "null")
    {
        $callFileUp = "{call SP_RAK_CPY_INSERT_FILES(?, ?, ?, ?, ?, ?, ?, ?)}";
        $paramFileUp = array(
            array($rak_h_id, SQLSRV_PARAM_IN),
            array($role_code, SQLSRV_PARAM_IN),
            array('', SQLSRV_PARAM_IN),
            array('Bukti Pendukung', SQLSRV_PARAM_IN),
            array($lkt_upl_bukti_pendukung, SQLSRV_PARAM_IN),
            array(strtoupper($_FILES['lkt_upl_bukti_pendukung']['type']), SQLSRV_PARAM_IN),
            array('KAPASITAS', SQLSRV_PARAM_IN),
            array($username, SQLSRV_PARAM_IN)
        );
        $execFileUp = sqlsrv_query($conn, $callFileUp, $paramFileUp) or die(print_r(sqlsrv_errors(), true));
    }

    # Approval
    $hasil_rekomendasi = $_POST['submit_RAK'];

    $callApv = "{call SP_RAK_CPY_INSERT_APPROVAL(?, ?, ?, ?)}";
    $paramApv = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array($hasil_rekomendasi, SQLSRV_PARAM_IN),
        array($_POST['hke_note'], SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execApv = sqlsrv_query($conn, $callApv, $paramApv) or die(print_r(sqlsrv_errors(), true));

    echo "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "'</script>";
    exit();
}
else 
{
    # Detail Ringkasan
    $callCpy = "{call SP_RAK_CPY_GET_CUST_INFO(?)}";
    $paramCpy = array(array($order_no, SQLSRV_PARAM_IN));
    $execCpy = sqlsrv_query($conn, $callCpy, $paramCpy) or die(print_r(sqlsrv_errors(), true));
    $dataCpy = sqlsrv_fetch_array($execCpy);


    # Detail Subbranch
    $callSubbranch = "{call SP_RAK_CPY_GET_SUBBRANCH_INFO(?)}";
    $paramSubbranch = array(array($order_no, SQLSRV_PARAM_IN));
    $execSubbranch = sqlsrv_query($conn, $callSubbranch, $paramSubbranch) or die(print_r(sqlsrv_errors(), true));
    $dataSubbranch = sqlsrv_fetch_array($execSubbranch);


    # Detail Company untuk file LO
    $callCompanyDetail = "{call CPY_PEFINDO_GETDATA_DETAIL_COMPANY(?)}";
    $paramCompanyDetail = array(array($dataCpy['ORDER_NO'], SQLSRV_PARAM_IN));
    $execCompanyDetail = sqlsrv_query($conn, $callCompanyDetail, $paramCompanyDetail) or die(print_r(sqlsrv_errors(), true));
    $dataCompanyDetail = sqlsrv_fetch_array($execCompanyDetail);


    # Detail Proxy
    $callChkProx = "{call SP_PROSES_DATA_GENERATE_INTERNAL_SCORING_RAK(?)}";
    $paramsChkProx = array(
        array($dataCpy['ORDER_NO'], SQLSRV_PARAM_IN)
    );
    $options =  array("Scrollable" => "buffered");
    $execChkProx = sqlsrv_query($conn, $callChkProx, $paramsChkProx, $options) or die(print_r(sqlsrv_errors(), true));
    $checkChkProx = sqlsrv_num_rows($execChkProx);

    if ($checkChkProx == 0) {
        # buat data proxy baru
        // $callInsProx = "{call SFIBI_SP_REPORT_FASILITAS_SLIK_PEFINDO_by_Order_no_summary_SLIK(?)}";
		$callInsProx = "{call SFIBI_SP_REPORT_FASILITAS_SLIK_PEFINDO_by_Order_no_summary_SLIK_CPY(?)}";
        $paramInsProx = array(array($dataCpy['ORDER_NO'], SQLSRV_PARAM_IN));
        $execInsProx = sqlsrv_query($conn, $callInsProx, $paramInsProx) or die(print_r(sqlsrv_errors(), true));
    }

    $callProxy = "{call SP_RAK_CPY_GET_MATRIKS(?)}";
    $paramProxy = array(array($dataCpy['ORDER_NO'], SQLSRV_PARAM_IN));
    $execProxy = sqlsrv_query($conn, $callProxy, $paramProxy) or die(print_r(sqlsrv_errors(), true));
    $dataProxy = sqlsrv_fetch_array($execProxy);
    

    # Detail Approval
    $callApvLevel = "{call SP_RAK_CPY_GET_LOA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
    $paramApvLevel = array(
        array($dataCpy['ORDER_NO'], SQLSRV_PARAM_IN),
        array($dataCpy['KODE_CABANG'], SQLSRV_PARAM_IN),
        array($dataCpy['TDP_PERCENT'], SQLSRV_PARAM_IN),
        array(number_format(htmlentities($dataCpy['PH_TOTAL'], ENT_QUOTES, 'UTF-8'), 0, ',', ''), SQLSRV_PARAM_IN),
        array($dataProxy['Status_Proxy_income'], SQLSRV_PARAM_IN),
        array($dataProxy['STATUS_COLLECTIBILITY'], SQLSRV_PARAM_IN),
        array($dataProxy['STATUS_LEVEL'], SQLSRV_PARAM_IN),
        array($dataProxy['Score_Desc'], SQLSRV_PARAM_IN),
        array($dataProxy['SEGMENTATION'], SQLSRV_PARAM_IN),
        array($user, SQLSRV_PARAM_IN),
    );
    $execApvLevel = sqlsrv_query($conn, $callApvLevel, $paramApvLevel) or die(print_r(sqlsrv_errors(), true));
    $dataApvLevel = sqlsrv_fetch_array($execApvLevel);

    # Lain-lain
    $pendapatanNET = htmlentities($dataCpy['PENDAPATAN'], ENT_QUOTES, 'UTF-8');
    $angsuranOrder = htmlentities($dataCpy['ANGSURAN'], ENT_QUOTES, 'UTF-8');
    $angsuranOrderNewSFI = htmlentities($dataCpy['ANGSURAN_NEW'], ENT_QUOTES, 'UTF-8');
    $angsuranAO = htmlentities($dataCpy['ANGSURAN_AO'], ENT_QUOTES, 'UTF-8');
    $angsuranLain = htmlentities($dataCpy['ANGSURAN_LAIN'], ENT_QUOTES, 'UTF-8');
    $totalKewajiban = $angsuranOrderNewSFI + $angsuranAO + $angsuranLain;
}

?>

<style>
    .img-custom {
        width: 100%;
        height: 200px;
    }

    .pagination>li>a,
    .pagination>li>span {
        background-color: #FFF;
        color: #035c7a;
    }

    .pagination>li.active>a,
    .pagination>li.active>span {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.active>a:hover,
    .pagination>li.active>span:hover {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.focus>a,
    .pagination>li.focus>span:hover {
        background-color: #035c7a;
        color: #FFF;
    }

    .pagination>li.active>a.page-link,
    .pagination>li.active>span.page-link {
        background-color: #035c7a;
        color: #FFF;
    }
</style>

<?php
// echo "<pre>";
// echo var_dump($dataCpy);
// echo "</pre>";
?>

<div class="row">
    <div class="col-md-12">
        <form action="" id="form_RAK_company" name="form_RAK_company" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="username" id="username" value="<?php echo $user; ?>">
            <input type="hidden" name="ref_no" id="ref_no" value="<?php echo $dataCpy['ORDER_NO']; ?>">
            <input type="hidden" name="ref_type" id="ref_type" value="NOMOR ORDER">
            <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $dataCpy['CUST_ID']; ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $dataCpy['KODE_CABANG']; ?>">
            <input type="hidden" name="is_subbranch" id="is_subbranch" value="<?php echo (isset($dataSubbranch['IS_SUBBRANCH']) && $dataSubbranch['IS_SUBBRANCH'] <> NULL) ? $dataSubbranch['IS_SUBBRANCH'] : 'TIDAK'; ?>">
            
            <input type="hidden" name="latitude" id="latitude" value="<?php echo $dataCpy['LATITUDE']; ?>">
            <input type="hidden" name="longitude" id="longitude" value="<?php echo $dataCpy['LONGITUDE']; ?>">

            <input type="hidden" name="status_proxy_income" id="status_proxy_income" value="<?php echo $dataProxy['Status_Proxy_income']; ?>">
            <input type="hidden" name="status_collectibility" id="status_collectibility" value="<?php echo $dataProxy['STATUS_COLLECTIBILITY']; ?>">
            <input type="hidden" name="status_level" id="status_level" value="<?php echo $dataProxy['STATUS_LEVEL']; ?>">
            <input type="hidden" name="score_desc" id="score_desc" value="<?php echo $dataProxy['Score_Desc']; ?>">
            <input type="hidden" name="segmentation" id="segmentation" value="<?php echo $dataProxy['SEGMENTATION']; ?>">
			<input type="hidden" name="dacor" id="dacor" value="<?php echo $dataCompanyDetail['DACOR']; ?>">

            <div class="card" style="background-color:#eb8500;color:#FFF;font-weight:bold;">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center"> <b>RINGKASAN APLIKASI KREDIT (RAK) BADAN HUKUM</b> </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="content">

                    <ul class="nav nav-pills nav-justified">
                        <li class="active"><a data-toggle="pill" href="#review">REVIEW RAK</a></li>
						<li><a data-toggle="pill" href="#fleet">FLEET & AO</a></li>
						<li><a data-toggle="pill" href="#phone_verif">PHONE VERIFICATION</a></li>
						<li><a data-toggle="pill" href="#main"id="tab-rak">RAK</a></li>
					</ul>

                    <br>

                    <div class="tab-content">
                        <div id="review" class="tab-pane fade in active">
                            <!-- # *************************************** REVIEW RAK *************************************** # -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">REVIEW RAK</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                   <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:80%">
                                            <col style="width:20%">

                                            <tr>
                                                <td>Deviasi Tidak melampirkan laporan keuangan tahun terakhir</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_lap_keu_opt" id="dev_lap_keu_opt" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi Tidak melampirkan data keuangan (rekening koran/tabungan 3 bulan terakhir atau tidak melampirkan invoice/nota/pembukuan)</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_data_keuangan_opt" id="dev_data_keuangan_opt" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi Perusahaan berdiri kurang dari 1 tahun</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_durasi_perusahaan_opt" id="dev_durasi_perusahaan_opt" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi DSR diatas 60%</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_dsr_opt" id="dev_dsr_opt" value="1" oninvalid="handleInvalidInput('Silahkan centang [Deviasi DSR diatas 60%]!')" oninput="handleValidInput()">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi TDP dibawah 27,5% untuk DSR >40%</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_tdp_opt" id="dev_tdp_opt" value="1" oninvalid="handleInvalidInput('Silahkan centang [Deviasi TDP dibawah 27,5% untuk DSR >40%]!')" oninput="handleValidInput()">
                                                </td>
                                            </tr>
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- # *************************************** end of REVIEW RAK *************************************** # -->
                        </div>

                        <div id="fleet" class="tab-pane fade">
                            <!-- # *************************************** FLEET ORDER DETAIL *************************************** # -->
                            
                            <?php
                                $order_no = $dataCpy['REF_NO']; 
                                $cust_id  = $dataCpy['CUST_ID']; 
                                
                                require('view-rak-company-fleet-ao.php'); 
                            ?>

                            <!-- # *************************************** end of FLEET ORDER DETAIL *************************************** # -->
                        </div>
						<div id="phone_verif" class="tab-pane fade">
                            <!-- # *************************************** PHONE VERIF  *************************************** # -->
								<div id="phone-verif-container" class="p-2"
									data-siapanih="<?= isset($siapanih) ? htmlspecialchars($siapanih) : '' ?>"
									data-ktp="<?= isset($ktp_pemohon) ? htmlspecialchars($ktp_pemohon) : '' ?>"
									data-ktpsaya="<?= isset($ktpsaya) ? htmlspecialchars($ktpsaya) : '' ?>"
									data-custmodel="BADAN HUKUM"
									data-orderno="<?= isset($order_no) ? htmlspecialchars($order_no) : '' ?>"
									data-custmodelpas="<?= isset($custmodelsaya) ? htmlspecialchars($custmodelsaya) : '' ?>"
									>
									Loading phone verification... 
								</div>>
                            <!-- # *************************************** end of PHONE VERIF*************************************** # -->
                        </div>
	
                        <script>
                        $(function () {
                            $('a[href="#phone_verif"]').one('shown.bs.tab', function () {
                                const container = $('#phone-verif-container');
                                console.log('siapanih =', container.data('siapanih'));
                                console.log('ktp =', container.data('ktp'));
                                console.log('ktpsaya =', container.data('ktpsaya'));
                                console.log('custmodel =', container.data('custmodel'));
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
                            });
                        });
                        </script>
    <script>
	document.addEventListener('DOMContentLoaded', function () {
		var tabRak = document.getElementById('tab-rak');
		if (!tabRak) return;
		tabRak.addEventListener('click', function () {
			const container = document.getElementById('phone-verif-container');
			const orderNoInput = container?.dataset?.orderno;
			console.log('ACTIVE TAB : ',orderNoInput)
			if (!orderNoInput) return;
			console.log('ACTIVE TAB PROG')
			fetch('check_phone_verif_exist.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'order_no=' + encodeURIComponent(orderNoInput)
			})
			.then(function (r) { return r.json(); })
			.then(function (res) {

				document.getElementById('done_phone_verif').value = res.exist ? 1 : 0;
				console.log('ACTIVE TAB DONE')
			})
			.catch(function () {});
		});

	});
	
	</script>
	<script>
document.addEventListener('shown.bs.tab', function (e) {

    // ambil target tab (support href & bootstrap 5)
    var target = e.target.getAttribute('href') || e.target.getAttribute('data-bs-target');

    // sesuaikan dengan TAB RAK kamu (INI KUNCI!)
    if (target !== '#main') return;

    console.log('TAB RAK AKTIF');

    var orderNoInput = document.querySelector('input[name="order_no"]');
    if (!orderNoInput || !orderNoInput.value) {
        console.log('order_no kosong');
        return;
    }

    fetch('check_phone_verif_exist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'order_no=' + encodeURIComponent(orderNoInput.value)
    })
    .then(r => r.json())
    .then(res => {

        console.log('HASIL:', res);

        document.getElementById('done_phone_verif').value = res.exist ? 1 : 0;

    })
    .catch(err => console.log('ERROR:', err));

});
</script>


	<input type="hidden" name="done_phone_verif" id="done_phone_verif" value="0">

                        <div id="main" class="tab-pane fade">
                            <!-- *************************************** RINGKASAN APLIKASI KREDIT *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">RINGKASAN APLIKASI KREDIT</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">

                                                <tr>
                                                    <td style="background-color:#035c7a;color:#FFF;font-weight:bold;">COMPANY PROFILE*</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea id="rak_company_profile" name="rak_company_profile" class="form-control" rows="7" required></textarea>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Area</td>
                                                        <td>
                                                            <input type="text" name="rak_area" id="rak_area" value="<?= htmlentities($dataCpy['NAMA_AREA'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cabang</td>
                                                        <td>
                                                            <input type="text" name="rak_cabang" id="rak_cabang" value="<?= htmlentities($dataCpy['NAMA_CABANG'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Order</td>
                                                        <td>
                                                            <input type="text" name="rak_no_order" id="rak_no_order" value="<?= htmlentities($dataCpy['ORDER_NO'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Order</td>
                                                        <td>
                                                            <input type="text" name="rak_tanggal_order" id="rak_tanggal_order" value="<?= htmlentities($dataCpy['TANGGAL_ORDER'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Perusahaan</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_perusahaan" id="rak_nama_perusahaan" value="<?= htmlentities($dataCpy['NAMA_PERUSAHAAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kendaraan</td>
                                                        <td>
                                                            <input type="text" name="rak_jenis_kendaraan" id="rak_jenis_kendaraan" value="<?= htmlentities($dataCpy['JENIS_KENDARAAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tahun Kendaraan</td>
                                                        <td>
                                                            <input type="text" name="rak_tahun_kendaraan" id="rak_tahun_kendaraan" value="<?= htmlentities($dataCpy['TAHUN_KENDARAAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Asset Name</td>
                                                        <td>
                                                            <input type="text" name="rak_asset_name" id="rak_asset_name" value="<?= htmlentities($dataCpy['ASSET_NAME'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Dealer</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_dealer" id="rak_nama_dealer" value="<?= htmlentities($dataCpy['NAMA_DEALER'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pengajuan</td>
                                                        <td>
                                                            <input type="text" name="rak_jenis_pengajuan" id="rak_jenis_pengajuan" value="<?= htmlentities($dataCpy['JENIS_PENGAJUAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>PH Berjalan</td>
                                                        <td>
                                                            <input type="text" name="rak_ph" id="rak_ph" value="<?php echo number_format(htmlentities($dataCpy['PH'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PH Add. Order</td>
                                                        <td>
                                                            <input type="text" name="rak_ph_ao" id="rak_ph_ao" value="<?php echo number_format(htmlentities($dataCpy['PH_AO'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PH Akumulasi</td>
                                                        <td>
                                                            <input type="text" name="rak_ph_total" id="rak_ph_total" value="<?php echo number_format(htmlentities($dataCpy['PH_TOTAL'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga OTR</td>
                                                        <td>
                                                            <input type="text" name="rak_otr" id="rak_otr" value="<?php echo number_format(htmlentities($dataCpy['OTR'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tenor</td>
                                                        <td>
                                                            <input type="text" name="rak_tenor" id="rak_tenor" value="<?php echo number_format(htmlentities($dataCpy['TENOR'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount TDP</td>
                                                        <td>
                                                            <input type="text" name="rak_amount_tdp" id="rak_amount_tdp" value="<?php echo number_format(htmlentities($dataCpy['TDP'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>% TDP</td>
                                                        <td>
                                                            <input type="text" name="rak_tdp_persen" id="rak_tdp_persen" value="<?php echo htmlentities($dataCpy['TDP_PERCENT'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama CMO</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_CMO" id="rak_nama_CMO" value="<?php echo htmlentities($dataCpy['NAMA_CMO'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>

                                                    <?php if ($dataSubbranch['IS_SUBBRANCH'] === "YA") : ?>

                                                        <tr>
                                                            <td>Nama SBH</td>
                                                            <td>
                                                                <input type="text" name="rak_nama_SBH" id="rak_nama_SBH" value="<?php echo htmlentities($dataSubbranch['FULLNAME_SBH'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama CA</td>
                                                            <td>
                                                                <input type="text" name="rak_nama_CA" id="rak_nama_CA" value="<?php echo htmlentities($dataSubbranch['FULLNAME_CA'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                            </td>
                                                        </tr>

                                                    <?php else : ?>

                                                        <tr>
                                                            <td>Nama SBH</td>
                                                            <td>
                                                                <input type="text" name="rak_nama_SBH" id="rak_nama_SBH" value="-" class="form-control" readonly onautocomplete="off">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama CA</td>
                                                            <td>
                                                                <input type="text" name="rak_nama_CA" id="rak_nama_CA" value="<?php echo htmlentities($user, ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                            </td>
                                                        </tr>

                                                    <?php endif; ?>

                                                    <input type="hidden" name="rak_angsuran" id="rak_angsuran" value="<?php echo number_format(htmlentities($dataCpy['ANGSURAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- *************************************** end of RINGKASAN APLIKASI KREDIT *************************************** -->


                            <!-- *************************************** VALIDASI IDENTITAS BADAN HUKUM *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI IDENTITAS BADAN HUKUM</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:25%">
                                            <col style="width:25%">

                                            <tr>
                                                <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DATA PEMOHON BADAN HUKUM</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:25%">
                                            <col style="width:25%">
                                            <col style="width:25%">
                                            <col style="width:25%">

                                            <tr>
                                                <td>Company Type</td>
                                                <td>
                                                    <input type="text" id="vi_company_type" name="vi_company_type" class="form-control" value="<?= htmlentities($dataCpy['COMPANY_TYPE'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                                <td>Legal Opinion (LO)</td>
                                                <td><?php displayFile($dataCompanyDetail['FILE_LO'], $dataCompanyDetail['FILE_TYPE_LO'], "assets/company/LO/" . $dataCompanyDetail['FILE_LO'], 'LO'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nama Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_nama_badan_hukum" name="vi_nama_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['NAMA_BADAN_HUKUM'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No NPWP Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_no_npwp" name="vi_no_npwp" class="form-control" value="<?= htmlentities($dataCpy['ID_NO'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tgl. Pendirian</td>
                                                <td>
                                                    <input type="text" id="vi_tgL_pendirian" name="vi_tgL_pendirian" class="form-control" value="<?= htmlentities($dataCpy['TANGGAL_PENDIRIAN'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Total Karyawan</td>
                                                <td>
                                                    <input type="text" id="vi_jum_total_karyawan" name="vi_jum_total_karyawan" class="form-control" value="<?= htmlentities($dataCpy['JUMLAH_KARYAWAN'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No Telephone</td>
                                                <td>
                                                    <input type="text" id="vi_no_telp" name="vi_no_telp" class="form-control" value="<?= htmlentities($dataCpy['NO_TELEPON'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat Pendirian Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_alamat_pendirian_badan_hukum" name="vi_alamat_pendirian_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['ALAMAT_PENDIRIAN'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat Domisili Badan Hukum<i style="color: red;">*</i></td>
                                                <td>
                                                    <input type="text" id="vi_alamat_dom_badan_hukum" name="vi_alamat_dom_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['ALAMAT_DOMISILI'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                                <td>
                                                    <select name="vi_summary_val" class="form-control" required>
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea id="vi_summary_note" name="vi_summary_note" class="form-control" placeholder="Notes Alamat Domisili Badan Hukum" rows="2"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- *************************************** end of VALIDASI IDENTITAS BADAN HUKUM *************************************** -->


                            <!-- *************************************** VALIDASI DOMISILI USAHA *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI DOMISILI USAHA</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:10%">
                                            <col style="width:40%">

                                            <tr>
                                                <td style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">NAMA DOKUMEN</td>
                                                <td style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">DILAMPIRKAN</td>
                                                <td style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">STATUS</td>
                                            </tr>
                                            <tr>
                                                <td>SIUP, NIB</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_siup_nib_opt" id="vd_siup_nib_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_siup_nib_val" name="vd_siup_nib_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IMB (Izin Mendirikan Bangunan)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_imb_opt" id="vd_imb_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_imb_val" name="vd_imb_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bukti kepemilikan tanah atau perjanjian sewa gedung (sertifikat/akta jual beli/faktur)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_bukti_kepem_tanah_opt" id="vd_bukti_kepem_tanah_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_bukti_kepem_tanah_val" name="vd_bukti_kepem_tanah_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat keterangan domisili gedung dari Aparat Pemerintahan setempat</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_surat_ket_dom_gedung_opt" id="vd_surat_ket_dom_gedung_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_surat_ket_dom_gedung_val" name="vd_surat_ket_dom_gedung_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bukti pembayaran Pajak Bumi dan Bangunan (PBB)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_bukti_pembayaran_pbb_opt" id="vd_bukti_pembayaran_pbb_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_bukti_pembayaran_pbb_val" name="vd_bukti_pembayaran_pbb_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rekening Listrik</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_rek_listrik_opt" id="vd_rek_listrik_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_rek_listrik_val" name="vd_rek_listrik_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat keterangan izin tempat usaha</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_surat_izin_tempat_usaha_opt" id="vd_surat_izin_tempat_usaha_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_surat_izin_tempat_usaha_val" name="vd_surat_izin_tempat_usaha_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    Status Badan Hukum

                                                    <select id="vd_status_badan_hukum_type" name="vd_status_badan_hukum_type" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="KANTOR PUSAT">KANTOR PUSAT</option>
                                                        <option value="KANTOR CABANG">KANTOR CABANG</option>
                                                        <option value="LAINNYA">LAINNYA</option>
                                                    </select>

                                                    <label style="margin-top: 1rem;">Catatan :</label>
                                                    <textarea id="vd_status_badan_hukum_type_note" name="vd_status_badan_hukum_type_note" class="form-control" rows="3"></textarea>
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_status_badan_hukum_opt" id="vd_status_badan_hukum_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_status_badan_hukum_val" name="vd_status_badan_hukum_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Status Kepemilikan Tempat

                                                    <select id="vd_status_kep_tempat_type" name="vd_status_kep_tempat_type" class="form-control" style="margin-top: 0.3rem;">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="MILIK SENDIRI (COMPANY)">MILIK SENDIRI (COMPANY)</option>
                                                        <option value="MILIK SENDIRI (PENGURUS)">MILIK SENDIRI (PENGURUS)</option>
                                                        <option value="SEWA">SEWA</option>
                                                        <option value="KONTRAK">KONTRAK</option>
                                                        <option value="LAINNYA">LAINNYA</option>
                                                    </select>

                                                    <label style="margin-top: 1rem;">Catatan :</label>
                                                    <textarea id="vd_status_kep_tempat_type_note" name="vd_status_kep_tempat_type_note" class="form-control" rows="3"></textarea>
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_status_kep_tempat_opt" id="vd_status_kep_tempat_opt">
                                                </td>
                                                <td>
                                                    <select id="vd_status_kep_tempat_val" name="vd_status_kep_tempat_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:50%">

                                            <tr>
                                                <td>Cara Validasi</td>
                                                <td>
                                                    <select name="vd_cara_validasi" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="Cek Notaris Penerbit">Cek Notaris Penerbit</option>
                                                        <option value="Cek by Online">Cek by Online</option>
                                                        <option value="PHONE VERIFIKASI">PHONE VERIFIKASI</option>
                                                        <option value="Kunjungan ke Kantor">Kunjungan ke Kantor</option>
                                                        <option value="Cek dokumen pendukung">Cek dokumen pendukung</option>
                                                        <option value="Cek BPN">Cek BPN</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Catatan</td>
                                                <td>
                                                    <textarea id="vd_cara_validasi_note" name="vd_cara_validasi_note" class="form-control" rows="3"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Upload Bukti Validasi Domisili<i style="color: red;">*</i></td>
                                                <td>
                                                    <input type="file" id="vd_upl_bukti_validasi" name="vd_upl_bukti_validasi" class="form-control" required style="margin-bottom:5px;" accept="application/pdf,image/jpeg,image/png,image/jpg">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Upload Bukti Pendukung<i style="color: red;">*</i></td>
                                                <td>
                                                    <input type="file" id="vd_upl_bukti_pendukung" name="vd_upl_bukti_pendukung" class="form-control" style="margin-bottom:5px;" accept="application/pdf,image/jpeg,image/png,image/jpg">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- *************************************** end of VALIDASI DOMISILI USAHA *************************************** -->


                            <!-- *************************************** VALIDASI HASIL SURVEY *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI HASIL SURVEY</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:40%">
                                            <col style="width:60%">

                                            <tr>
                                                <td>CEK TITIK KOORDINAT GEOTAGGING<i style="color: red;">*</i></td>
                                                <td><?php echo $dataCpy['LATITUDE']; ?>, <?php echo $dataCpy['LONGITUDE']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>PENCARIAN PADA GOOGLE MAPS</td>
                                                <td>
                                                    <a class="btn btn-success btn-xs" href="https://www.google.com/maps/search/?api=1&query=<?php echo $dataCpy['LATITUDE']; ?>,<?php echo $dataCpy['LONGITUDE']; ?>" target="_blank">
                                                        Link Google Maps
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2">HASIL FOTO SURVEY VS HASIL GEOTAGGING ALAMAT<br>APAKAH SESUAI?<i style="color: red;">*</i></td>
                                                <td style="padding: 12px 15px;">
                                                    <select name="vhs_hasil_foto_vs_geotag_val" class="form-control" required>
                                                        <option value="">-- PILIH --</option>
                                                        <option value="SESUAI">SESUAI</option>
                                                        <option value="TIDAK SESUAI">TIDAK SESUAI</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label style="margin-top: 1rem;">Catatan :</label>
                                                    <textarea id="vhs_hasil_foto_vs_geotag_note" name="vhs_hasil_foto_vs_geotag_note" class="form-control" rows="3"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Upload Bukti Validasi Geotagging<i style="color: red;">*</i></td>
                                                <td style="padding: 12px 15px;">
                                                    <input type="file" id="vhs_upl_hasil_geotagging" name="vhs_upl_hasil_geotagging" class="form-control" required style="margin-bottom:5px;" accept="application/pdf,image/jpeg,image/png,image/jpg">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-bottom: 2rem; margin-top: -1.7rem;">
                                    <i style="color: red;">*Geotagging diambil dari Mobile Survey</i>
                                </div>
                            </div>
                            <!-- *************************************** end of VALIDASI HASIL SURVEY *************************************** -->


                            <!-- *************************************** VALIDASI KAPASITAS *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">VALIDASI KAPASITAS</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>PEMOHON</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:50%">

                                            <tr>
                                                <td>Customer Model</td>
                                                <td>
                                                    <input type="text" name="vk_customer_model" id="vk_customer_model" value="<?php echo $dataCpy['COMPANY_TYPE']; ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>DOKUMEN YANG DILAMPIRKAN</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:10%">
                                            <col style="width:40%">

                                            <tr>
                                                <td>REKENING TABUNGAN / KORAN BADAN HUKUM</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" name="vk_rekening_badan_hukum_opt" id="vk_rekening_badan_hukum_opt">
                                                </td>
                                                <td>
                                                    <select id="vk_rekening_badan_hukum_val" name="vk_rekening_badan_hukum_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>REKENING TABUNGAN / KORAN PENGURUS (KHUSUS CV ATAU PERORANGAN)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" name="vk_rekening_pengurus_opt" id="vk_rekening_pengurus_opt">
                                                </td>
                                                <td>
                                                    <select id="vk_rekening_pengurus_val" name="vk_rekening_pengurus_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LAPORAN KEUANGAN TAHUN TERAKHIR</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" name="vk_lap_keu_terakhir_opt" id="vk_lap_keu_terakhir_opt">
                                                </td>
                                                <td>
                                                    <select id="vk_lap_keu_terakhir_val" name="vk_lap_keu_terakhir_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INVOICE / NOTA-NOTA / PEMBUKUAN TAHUN TERAKHIR</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" name="vk_lap_pembukuan_terakhir_opt" id="vk_lap_pembukuan_terakhir_opt">
                                                </td>
                                                <td>
                                                    <select id="vk_lap_pembukuan_terakhir_val" name="vk_lap_pembukuan_terakhir_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>LAPORAN SPT PAJAK BADAN HUKUM TAHUN TERAKHIR</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" name="vk_spt_terakhir_opt" id="vk_spt_terakhir_opt">
                                                </td>
                                                <td>
                                                    <select id="vk_spt_terakhir_val" name="vk_spt_terakhir_val" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="VALID">VALID</option>
                                                        <option value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <!-- <tr>
                                                <td>Rekening Atas Nama</td>
                                                <td>
                                                    <select name="vk_rekening_atas_nama_type" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="Perusahaan">Perusahaan</option>
                                                        <option value="Pemilik">Pemilik</option>
                                                        <option value="Salah satu Pengurus">Salah satu Pengurus</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td>Nama Bank Penerbit</td>
                                                <td>
                                                    <input type="text" name="vk_nama_bank_penerbit" id="vk_nama_bank_penerbit" value="<?php echo $dataCpy['NAMA_BANK_PENERBIT']; ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>
                                                    <input type="text" name="vk_nomor_rekening" id="vk_nomor_rekening" value="<?php echo $dataCpy['NOMOR_REKENING']; ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pemilik Rekening</td>
                                                <td>
                                                    <input type="text" name="vk_nama_pemilik_rekening" id="vk_nama_pemilik_rekening" value="<?php echo $dataCpy['NAMA_PEMILIK_REKENING']; ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mutasi Yang Dilampirkan<i style="color: red;">*</i></td>
                                                <td>
                                                    <select name="vk_mutasi_yang_dilampirkan_type" class="form-control" required>
                                                        <option value="">-- PILIH --</option>
                                                        <!-- <option value="Terbaru/Baru Buka">Terbaru/Baru Buka</option> -->
                                                        <option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
                                                        <option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
                                                        <option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cara Validasi<i style="color: red;">*</i></td>
                                                <td>
                                                    <select name="vk_cara_validasi" class="form-control" required>
                                                        <option value="">-- PILIH --</option>
                                                        <option value="PHONE VERIFIKASI">PHONE VERIFIKASI</option>
                                                        <option value="KUNJUNGAN KE KANTOR">KUNJUNGAN KE KANTOR</option>
                                                        <option value="BPJSTKU Mobile ; SMS BPJS ; www.sso.bpjsketenagakerjaan.go.id/">BPJSTKU Mobile ; SMS BPJS ; www.sso.bpjsketenagakerjaan.go.id/</option>
                                                        <option value="MELAKUKAN PERCOBAAN TRANSFER">MELAKUKAN PERCOBAAN TRANSFER</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Upload Bukti Validasi Bank Account<i style="color: red;">*</i></td>
                                                <td colspan="2">
                                                    <input type="file" id="vk_upl_bukti_validasi" name="vk_upl_bukti_validasi" class="form-control" style="margin-bottom:5px;" accept="application/pdf,image/jpeg,image/png,image/jpg" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>

                            <!-- ----------------- MUTASI REKENING TABUNGAN ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>MUTASI REKENING TABUNGAN</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:40%">
                                            <col style="width:10%">

                                            <tr>
                                                <td>Saldo Awal<i style="color: red;">*</i></td>
                                                <td>
                                                    <input type="text" name="mrt_saldo_awal" id="mrt_saldo_awal" value="" class="form-control" onautocomplete="off" onKeyUp="toRupiah(this)" required>
                                                </td>
                                                <td>
                                                    <input type="button" name="mrt_btn_submit_saldo_awal" id="mrt_btn_submit_saldo_awal" class="btn btn-primary" value="Submit Saldo" onclick="act_input_saldo_awal()">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table-input-mutasi">
                                            <col style="width:22%">
                                            <col style="width:22%">
                                            <col style="width:22%">
                                            <col style="width:22%">
                                            <col style="width:12%">

                                            <tr>
                                                <td colspan="5" style="background-color:#035c7a;color:#FFF;font-weight:bold;">FORM INPUT</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Transaksi</td>
                                                <td>Keterangan Transaksi</td>
                                                <td>Mutasi Debit</td>
                                                <td>Mutasi Kredit</td>
                                                <td style="text-align:center;">Action</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="fimrt_tanggal_transaksi" id="fimrt_tanggal_transaksi" autocomplete="off" value="">
                                                        <div class="input-group-addon">
                                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea name="fimrt_ket_transaksi" id="fimrt_ket_transaksi" class="form-control" rows="1"></textarea>
                                                </td>
                                                <td>
                                                    <input type="text" name="fimrt_mutasi_debit" id="fimrt_mutasi_debit" class="form-control" value="0" onKeyUp="toRupiah(this)">
                                                </td>
                                                <td>
                                                    <input type="text" name="fimrt_mutasi_kredit" id="fimrt_mutasi_kredit" class="form-control" value="0" onKeyUp="toRupiah(this)">
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="button" name="fimrt_btn_submit_mutasi" id="fimrt_btn_submit_mutasi" class="btn btn-primary" value="Tambah Mutasi" onclick="act_input_mutasi()">
                                                </td>
                                            </tr>
                                        </table>

                                        <div id="table-container-mutasi"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- ----------------- SUMMARY REKENING TABUNGAN ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>SUMMARY REKENING TABUNGAN</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">

                                        <div id="table-container-summary-mutasi"></div>

                                    </div>
                                </div>
                            </div>

                            <!-- ----------------- INVOICE ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>INVOICE</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Input Invoice -->
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:50%">

                                            <tr>
                                                <td>Invoice Yang Dilampirkan</td>
                                                <td>
                                                    <select name="inv_yang_dilampirkan_type" id="inv_yang_dilampirkan_type" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="Invoice Penjualan">Invoice Penjualan</option>
                                                        <option value="Invoice Belanja">Invoice Belanja</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Periode Invoice</td>
                                                <td>
                                                    <select name="inv_periode_type" id="inv_periode_type" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <option value="1 Bulan Terakhir">1 Bulan Terakhir</option>
                                                        <option value="2 Bulan Terakhir">2 Bulan Terakhir</option>
                                                        <option value="3 Bulan Terakhir">3 Bulan Terakhir</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- List Invoice -->
                                <div class="col-md-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <col style="width:25%">
                                            <col style="width:25%">
                                            <col style="width:25%">
                                            <col style="width:25%">

                                            <tr>
                                                <td colspan="4" style="background-color:#035c7a;color:#FFF;font-weight:bold;">FORM INPUT</td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Transaksi</td>
                                                <td>Keterangan Transaksi</td>
                                                <td>Nominal</td>
                                                <td style="text-align:center;">Action</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" name="inv_tanggal_transaksi" id="inv_tanggal_transaksi" autocomplete="off" value="">
                                                        <div class="input-group-addon">
                                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea name="inv_ket_transaksi" id="inv_ket_transaksi" class="form-control" rows="1"></textarea>
                                                </td>
                                                <td>
                                                    <input type="text" name="inv_nominal" id="inv_nominal" class="form-control" value="0" onKeyUp="toRupiah(this)">
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="button" name="inv_btn_submit" id="inv_btn_submit" class="btn btn-primary" value="Tambah Invoice" onclick="act_input_invoice()">
                                                </td>
                                            </tr>
                                        </table>

                                        <div id="table-container-invoice"></div>
                                    </div>
                                </div>

                                <!-- Hasil Kalkulasi Invoice -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>SUMMARY INVOICE</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div id="table-container-summary-invoice"></div>
                                </div>
                            </div>

                            <!-- ----------------- PENAMBAHAN INPUTAN LAPORAN TAHUNAN TERAKHIR BADAN USAHA ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2"><b>PENAMBAHAN INPUTAN LAPORAN TAHUNAN TERAKHIR BADAN USAHA</b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <tr>
                                            <td rowspan="3">Laporan Keuangan Tahunan</td>
                                            <td style="padding: 12px 15px;">
                                                <label style="margin-top: 1rem;">Tahun Laporan :</label>
                                                <input type="text" name="lkt_tahun_laporan" id="lkt_tahun_laporan" class="form-control number-only" value="" maxlength="4">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="margin-top: 1rem;">Status Audit :</label>
                                                <select name="lkt_status_audit" class="form-control">
                                                    <option value="">-- PILIH --</option>
                                                    <option value="AUDIT">AUDIT</option>
                                                    <option value="NON AUDIT">NON AUDIT</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="margin-top: 1rem;">Nominal :</label>
                                                <input type="text" name="lkt_nominal_laporan" id="lkt_nominal_laporan" class="form-control" value="0" onKeyUp="toRupiah(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>% Margin Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_margin_pendapatan_usaha" id="lkt_margin_pendapatan_usaha" class="form-control number-only" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_total_pendapatan_usaha" id="lkt_total_pendapatan_usaha" class="form-control" readonly value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Biaya Operasional</td>
                                            <td>
                                                <input type="text" name="lkt_biaya_operasional" id="lkt_biaya_operasional" class="form-control" value="" onKeyUp="toRupiah(this)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Net Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_net_pendapatan_usaha" id="lkt_net_pendapatan_usaha" class="form-control" readonly value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: right;">
                                                <input type="button" name="lkt_btn_calculate" id="lkt_btn_calculate" class="btn btn-primary" onclick="act_calculate_pendapatan()" value="Calculate">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <tr>
                                            <td>Upload Bukti Laporan Laba Rugi</td>
                                            <td>
                                                <input type="file" id="lkt_upl_bukti_lap_laba_rugi" name="lkt_upl_bukti_lap_laba_rugi" class="form-control" accept="application/pdf,image/jpeg,image/png,image/jpg" style="margin-bottom:5px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Upload Bukti Neraca</td>
                                            <td>
                                                <input type="file" id="lkt_upl_bukti_neraca" name="lkt_upl_bukti_neraca" class="form-control" accept="application/pdf,image/jpeg,image/png,image/jpg" style="margin-bottom:5px;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Upload Bukti Pendukung</td>
                                            <td>
                                                <input type="file" id="lkt_upl_bukti_pendukung" name="lkt_upl_bukti_pendukung" class="form-control" accept="application/pdf,image/jpeg,image/png,image/jpg" style="margin-bottom:5px;">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- ----------------- NOMINAL INCOME INPUTAN SBH / CA ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <tr>
                                            <?php if ($dataSubbranch['IS_SUBBRANCH'] === "YA") : ?>
                                            <td><b>NOMINAL INCOME FINAL SBH</b><i style="color: red;">*</i></td>
                                            <?php else : ?>
                                            <td><b>NOMINAL INCOME FINAL CA</b><i style="color: red;">*</i></td>
                                            <?php endif ?>

                                            <td>
                                                <input type="text" name="lkt_nominal_income_final" id="lkt_nominal_income_final" class="form-control" value="" onKeyUp="toRupiah(this); calculate_DSR();" required>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- *************************************** end of VALIDASI KAPASITAS *************************************** -->


                            <!-- *************************************** KEWAJIBAN DI TEMPAT LAIN *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">KEWAJIBAN DI TEMPAT LAIN (SUMMARY HASIL PEFINDO / SLIK OJK) - FASILITAS AKTIF - NON AKTIF</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- ----------------- Badan Hukum ----------------- -->
                            <?php 
                                // $no_trx          = $dataCpy['REF_NO'];
                                // $npwp_perusahaan = $dataCpy['ID_NO'];
                                // $nama_perusahaan = $dataCpy['NAMA_PERUSAHAAN'];

                                // require('view-rak-company-fasilitas-badan-hukum.php');
                            ?>

                            <div id="loading-fasilitas-company" style="display: none; margin-bottom: 2rem;">
                                <b><i>Sedang memuat Fasilitas Badan Hukum, silahkan tunggu...</i></b>
                            </div>

                            <div id="fasilitas-company"></div>

                            <!-- ----------------- Pengurus 1, 2, .. dst ----------------- -->
                            <!-- Tombol untuk memicu penguncian atau pembukaan tabel -->
                            <button type="button" id="toggle-fasilitas-pengurus" style="margin-bottom: 2rem;" class="btn btn-primary" data-toggle="collapse" data-target="#fasilitas-pengurus">Toggle View Fasilitas Pengurus</button>

                            <!-- Tabel yang akan disembunyikan saat diklik -->
                            <div id="fasilitas-pengurus" class="collapse d-none">

                            <?php 
                                // require('view-rak-company-fasilitas-pengurus.php');
                            ?>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 2rem; margin-top: -1.7rem;">
                                    <i style="color: red;">*Jika terdapat fasilitas aktif dari Suzuki Finance Indonesia, fasilitas tersebut tidak akan dimasukkan ke dalam perhitungan, melainkan akan digantikan dengan angsuran yang sedang berjalan di Suzuki Finance Indonesia saat ini.</i>
                                </div>
                            </div>
                            <!-- *************************************** end of KEWAJIBAN DI TEMPAT LAIN *************************************** -->


                            <!-- *************************************** HISTORIKAL KREDIT EKSTERNAL *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">HISTORIKAL KREDIT EKSTERNAL</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">PROXY INCOME</th>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">STATUS COLLECTIBILITY</th>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">STATUS LEVEL</th>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">DESKRIPSI SCORE</th>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">SEGMENTASI</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?php echo $dataProxy['Status_Proxy_income']; ?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?php echo $dataProxy['STATUS_COLLECTIBILITY'];?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?php echo $dataProxy['STATUS_LEVEL'];?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?php echo $dataProxy['Score_Desc'];?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?php echo $dataProxy['SEGMENTATION'];?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <tr>
                                            <td>TDP</td>
                                            <td>
                                                <input type="text" name="hke_TDP" id="hke_TDP" class="form-control" value="<?php echo $dataCpy['TDP_PERCENT']; ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>MIN TDP</td>
                                            <td>
                                                <input type="text" name="hke_min_TDP" id="hke_min_TDP" class="form-control" value="0" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LEVEL APPROVAL</td>
                                            <td>
                                                <input type="text" name="hke_level_approval" id="hke_level_approval" class="form-control" value="<?php echo $dataApvLevel['APV_LEVEL']; ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LANJUT APPROVAL / TIDAK</td>
                                            <td>
                                                <input type="text" name="hke_lanjut_approval" id="hke_lanjut_approval" class="form-control" value="YA" readonly>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <tr>
                                            <td><b>NOTE</b><i style="color: red;">*</i></td>
                                            <td><b>ANALISA KAPASITAS BERDASARKAN REKENING TABUNGAN DENGAN INVOICE TRANSAKSI</b><i style="color: red;">*</i></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea id="hke_note" name="hke_note" class="form-control" rows="7" required></textarea>
                                            </td>
                                            <td>
                                                <textarea id="hke_analisa_kapasitas_note" name="hke_analisa_kapasitas_note" class="form-control" rows="7" required></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- *************************************** end of HISTORIKAL KREDIT EKSTERNAL *************************************** -->


                            <!-- *************************************** SUMMARY *************************************** -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">SUMMARY</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:50%">

                                            <tr>
                                                <td>Pendapatan Badan Hukum (CONFINS/MOS)</td>
                                                <td>
                                                    <input type="text" name="sum_pendapatan_badan_hukum" class="form-control" id="sum_pendapatan_badan_hukum" value="<?php echo number_format($pendapatanNET, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Angsuran New SFI (MOS)</td>
                                                <td>
                                                    <input type="text" class="form-control" value="<?php echo number_format($angsuranOrder, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <?php if ($dataCpy['JUMLAH_FLEET'] > 1) : ?>

                                                <tr>
                                                    <td>Angsuran New SFI (MOS) Fleet <?= $dataCpy['JUMLAH_FLEET'] ?> Unit</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="<?php echo number_format($angsuranOrderNewSFI, 0, ',', '.'); ?>" readonly>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>
                                            <tr>
                                                <td>Angsuran Berjalan SFI (AO/RO by CONFINS)</td>
                                                <td>
                                                    <input type="text" name="sum_angsuran_berjalan_SFI" class="form-control" id="sum_angsuran_berjalan_SFI" value="<?php echo number_format($angsuranAO, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kewajiban Angsuran di tempat lain</td>
                                                <td>
                                                    <input type="text" name="sum_kewajiban_angsuran_ditempat_lain" class="form-control" id="sum_kewajiban_angsuran_ditempat_lain" value="<?php echo number_format($angsuranLain, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Kewajiban</td>
                                                <td>
                                                    <input type="text" name="sum_total_kewajiban" class="form-control" id="sum_total_kewajiban" value="<?php echo number_format($totalKewajiban, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Pendapatan</td>
                                                <td>
                                                    <input type="text" name="sum_total_pendapatan" class="form-control" id="sum_total_pendapatan" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>DSR %</td>
                                                <td>
                                                    <input type="text" name="sum_DSR_percentage" class="form-control" id="sum_DSR_percentage" readonly>
                                                    <label id="sum_trigger_DSR" style="display:none;color:red;background:yellow;"><b>*DSR tidak disarankan lebih dari 60%!</b></label>
                                                    <label id="sum_trigger_TDP" style="display:none;color:red;background:yellow;"><b>*TDP melewati batas minimum!</b></label>
                                                    <label id="sum_trigger_DSRTDP" style="display:none;color:red;background:yellow;"><b>*TDP harus diatas 27.5% jika DSR lebih dari 40%!</b></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Foto Survey</td>
                                                <td>
                                                    <a class="btn btn-warning" href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $dataCpy['ORDER_NO'];?>" target="_blank">FOTO SURVEY</a>
											        <a class="btn btn-warning" href="https://sfimos.sfi.co.id/mos_new/frame/surveyor_ext_view_rak/<?php echo $dataCpy['ORDER_NO'];?>" target="_blank">FOTO SURVEYOR EKSTERNAL</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: right;">
                                                    <button type="button" name="sum_btn_cal_DSR" id="sum_btn_cal_DSR" class="btn btn-custom">Calculate DSR</button>
                                                </td>
                                            </tr>

                                            <input type="hidden" name="sum_angsuran_new_SFI" class="form-control" id="sum_angsuran_new_SFI" value="<?php echo number_format($angsuranOrderNewSFI, 0, ',', '.'); ?>" readonly>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12" style="display:none;" id="error"><p style="color:red;background:yellow;padding:1rem;" id="error-message"></p></div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="submit" name="submit_RAK" id="submit_RAK_notrec" class="btn btn-custom" value="TIDAK REKOMENDASI">
                                                    <input type="submit" name="submit_RAK" id="submit_RAK_rec" class="btn btn-custom" value="REKOMENDASI">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- *************************************** end of SUMMARY *************************************** -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/jqueryrotate.min.js"></script>
<script>
    window.onbeforeunload = function() {
        $("input[type=submit]").attr("disabled", "disabled");
    };

    function formatRupiah(angka, prefix) {
        // Simpan tanda minus jika ada, dan buang dari string yang akan diproses
        var negative = angka.startsWith('-') ? '-' : '';
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // Tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

        // Menambahkan prefix jika ada, dan mengembalikan tanda minus
        return negative + (prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : ''));
    }

    function toRupiah(inputElement) {
        // Mengambil nilai dari input teks
        var textValue = inputElement.value;

        // Melakukan perubahan pada nilai, dan mengembalikannya
        inputElement.value = formatRupiah(textValue);
    }

    function checkFileSize(input){
        // Fungsi untuk memeriksa ukuran file yang diunggah

        var fileSize = input.files[0].size; // Mendapatkan ukuran file dalam bytes
        var maxSize = 5 * 1024 * 1024; // 5MB dalam bytes

        // Jika ukuran file melebihi batas
        if(fileSize > maxSize){
            alert('Ukuran file terlalu besar! Maksimum 5MB.');
            $(input).val(''); // Mengosongkan input file
        }
    }

    $('.form-control[type="file"]').change(function(){
        // Menambahkan event listener untuk setiap elemen input file dengan class 'form-control'
        checkFileSize(this);
    });

    function handleInvalidInput(message) {
        $('#error-message').html('<b>' + message + '</b>');
        $('#error').show();
    }

    // Fungsi untuk menangani peristiwa input pada input
    function handleValidInput() {
        $('#error-message').html('');
        $('#error').hide();
    }

</script>

<script>
    $(document).ready(function() {
        // ------------------------ [X] PROP CHECK VALIDASI DOMISILI USAHA ------------------------
        const vd_siup_nib_opt = $('#vd_siup_nib_opt');
        const vd_imb_opt = $('#vd_imb_opt');
        const vd_bukti_kepem_tanah_opt = $('#vd_bukti_kepem_tanah_opt');
        const vd_surat_ket_dom_gedung_opt = $('#vd_surat_ket_dom_gedung_opt');
        const vd_bukti_pembayaran_pbb_opt = $('#vd_bukti_pembayaran_pbb_opt');
        const vd_rek_listrik_opt = $('#vd_rek_listrik_opt');
        const vd_surat_izin_tempat_usaha_opt = $('#vd_surat_izin_tempat_usaha_opt');
        const vd_status_badan_hukum_opt = $('#vd_status_badan_hukum_opt');
        const vd_status_kep_tempat_opt = $('#vd_status_kep_tempat_opt');

        vd_siup_nib_opt.change(function() {
            $('#vd_siup_nib_val').prop('required', (this.checked)); // Menjadikan <select> wajib dipilih
        });

        vd_imb_opt.change(function() {
            $('#vd_imb_val').prop('required', (this.checked));
        });

        vd_bukti_kepem_tanah_opt.change(function() {
            $('#vd_bukti_kepem_tanah_val').prop('required', (this.checked));
        });

        vd_surat_ket_dom_gedung_opt.change(function() {
            $('#vd_surat_ket_dom_gedung_val').prop('required', (this.checked));
        });

        vd_bukti_pembayaran_pbb_opt.change(function() {
            $('#vd_bukti_pembayaran_pbb_val').prop('required', (this.checked));
        });

        vd_rek_listrik_opt.change(function() {
            $('#vd_rek_listrik_val').prop('required', (this.checked));
        });

        vd_surat_izin_tempat_usaha_opt.change(function() {
            $('#vd_surat_izin_tempat_usaha_val').prop('required', (this.checked));
        });

        vd_status_badan_hukum_opt.change(function() {
            $('#vd_status_badan_hukum_type').prop('required', (this.checked));
            $('#vd_status_badan_hukum_val').prop('required', (this.checked));
        });

        vd_status_kep_tempat_opt.change(function() {
            $('#vd_status_kep_tempat_type').prop('required', (this.checked));
            $('#vd_status_kep_tempat_val').prop('required', (this.checked));
        });



        // ------------------------ [X] PROP CHECK VALIDASI KAPASITAS ------------------------
        const vk_rekening_badan_hukum_opt = $('#vk_rekening_badan_hukum_opt');
        const vk_rekening_pengurus_opt = $('#vk_rekening_pengurus_opt');
        const vk_lap_keu_terakhir_opt = $('#vk_lap_keu_terakhir_opt');
        const vk_lap_pembukuan_terakhir_opt = $('#vk_lap_pembukuan_terakhir_opt');
        const vk_spt_terakhir_opt = $('#vk_spt_terakhir_opt');
		

        vk_rekening_badan_hukum_opt.change(function() {
            $('#vk_rekening_badan_hukum_val').prop('required', (this.checked));
        });

        vk_rekening_pengurus_opt.change(function() {
            $('#vk_rekening_pengurus_val').prop('required', (this.checked));
        });

        vk_lap_keu_terakhir_opt.change(function() {
            $('#vk_lap_keu_terakhir_val').prop('required', (this.checked));
        });

        vk_lap_pembukuan_terakhir_opt.change(function() {
            $('#vk_lap_pembukuan_terakhir_val').prop('required', (this.checked));
        });

        vk_spt_terakhir_opt.change(function() {
            $('#vk_spt_terakhir_val').prop('required', (this.checked));
        });





        // ------------------------ Other Script ------------------------

        $('#fimrt_tanggal_transaksi').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });

        $('#inv_tanggal_transaksi').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
        });

        $('.number-only').on('keydown', function(e) {
            // Izinkan: backspace, delete, tab, escape, enter, titik/decimal, koma, dan panah kiri/kanan
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 190, 37, 39]) !== -1 ||
                // Izinkan: angka 0 sampai 9
                (e.keyCode >= 48 && e.keyCode <= 57) ||
                (e.keyCode >= 96 && e.keyCode <= 105)) {
                // Izinkan input
                return;
            }
            // Larang karakter lainnya
            e.preventDefault();
        });

        $('#lkt_nominal_income_final').on('input', function(){
            var sourceText = $(this).val();
            $('#sum_total_pendapatan').val(formatRupiah(sourceText));
        });

        loadAjax();
		
        $('#sum_btn_cal_DSR').on('click', calculate_DSR);
        $('#fimrt_btn_submit_mutasi').prop('disabled', true);
        $('#submit_RAK_rec').prop("disabled", true);
        $('#submit_RAK_notrec').prop("disabled", true);
    });

    function calculate_DSR() {
        const totalKewajiban = $('#sum_total_kewajiban').val().replace(/[^\d]/g, '');
        const totalPendapatan = $('#sum_total_pendapatan').val().replace(/[^\d]/g, '');
		var dacor = $("#dacor").val();

		
        if (totalPendapatan === '')
        {
            alert('Total Pendapatan tidak boleh kosong!');
        }
        else
        {
            const dsr = (totalKewajiban / totalPendapatan) * 100;

            //validasi DSR
            
            $('#submit_RAK_notrec').prop("disabled", false);
            $('#sum_DSR_percentage').val(dsr);
			
			
            if (dacor == 'YA') {
				 $('#sum_trigger_DSR').hide();
                $('#submit_RAK_rec').prop("disabled", false);
                $('#dev_dsr_opt').prop('required', false);
				 $('#dev_tdp_opt').prop('required', false);
		
                        $('#sum_trigger_DSRTDP').hide();
						$('#sum_trigger_TDP').hide();
				}
            else if (dsr > 60) {
                //console.log("DSR value lebih dari 60:", dsr);
                $('#sum_trigger_DSR').show();
                $('#submit_RAK_rec').prop("disabled", true);
                $('#dev_dsr_opt').prop('required', true);
            } else {
                //console.log("DSR value kurang dari 60:", dsr);
                $('#sum_trigger_DSR').hide();
                // $('#submit_RAK_rec').prop("disabled", false);
                $('#dev_dsr_opt').prop('required', false);

                
                // validasi TDP
                let tdp_persen = parseFloat($('#rak_tdp_persen').val()); // Mengonversi nilai input menjadi angka desimal
				
                
                console.log(tdp_persen);
				console.log(dsr);

                // Melakukan pengecekan apakah konversi berhasil atau tidak
                if (!isNaN(tdp_persen)) {                    

                    // Trigger TDP <20%(passanger) dan <25% (komersil)
                    const jenis_pengajuan = $('#rak_jenis_pengajuan').val();
                    if (jenis_pengajuan.includes('COMMERCIAL')) {

                        const tdp_under_25 = (tdp_persen < 25);
                        
                        // console.log(tdp_under_25);

                        $('#submit_RAK_rec').prop("disabled", tdp_under_25);                
                        $('#sum_trigger_TDP').hide();

                        if (tdp_under_25) {
                            $('#sum_trigger_TDP').show();
                        }
                    }
                    else if (jenis_pengajuan.includes('PASSENGER')) {
                        const tdp_under_20 = (tdp_persen < 20);
                        $('#submit_RAK_rec').prop("disabled", tdp_under_20);
                        $('#sum_trigger_TDP').hide();
                        console.log("kena if 3");    
                        
                        if (tdp_under_20) {
                            $('#sum_trigger_TDP').show();
                        }
                    }

                    //Pengecekan jika DSR > 40 Minimum TDP  27.5
                    if (tdp_persen < 27.5 && dsr > 40) {
                        $('#submit_RAK_rec').prop("disabled", true);
                        $('#sum_trigger_DSRTDP').show();
                        $('#dev_tdp_opt').prop('required', true);
                    }
                    
                    else {
                        $('#dev_tdp_opt').prop('required', false);
                        $('#sum_trigger_DSRTDP').hide();
                    }

                } else {
                    alert('Gagal konversi TDP persen!');
                    $('#submit_RAK_rec').prop("disabled", true);
                }
            }           
            
        }
    }
</script>

<script>
    // ------------------------ [^] AJAX CALL ------------------------
    const mrt_saldo_awal = $('#mrt_saldo_awal');
    const mrt_btn_submit_saldo_awal = $('#mrt_btn_submit_saldo_awal');

    const fimrt_tanggal_transaksi = $('#fimrt_tanggal_transaksi');
    const fimrt_ket_transaksi = $('#fimrt_ket_transaksi');
    const fimrt_mutasi_debit = $('#fimrt_mutasi_debit');
    const fimrt_mutasi_kredit = $('#fimrt_mutasi_kredit');

    const inv_yang_dilampirkan_type = $('#inv_yang_dilampirkan_type');
    const inv_tanggal_transaksi = $('#inv_tanggal_transaksi');
    const inv_ket_transaksi = $('#inv_ket_transaksi');
    const inv_nominal = $('#inv_nominal');

    const lkt_nominal_laporan = $('#lkt_nominal_laporan');
    const lkt_margin_pendapatan_usaha = $('#lkt_margin_pendapatan_usaha');
    const lkt_total_pendapatan_usaha = $('#lkt_total_pendapatan_usaha');
    const lkt_biaya_operasional = $('#lkt_biaya_operasional');
    const lkt_net_pendapatan_usaha = $('#lkt_net_pendapatan_usaha');

    const sum_angsuran_new_SFI = $('#sum_angsuran_new_SFI');
    const sum_angsuran_berjalan_SFI = $('#sum_angsuran_berjalan_SFI');
    const sum_kewajiban_angsuran_ditempat_lain = $('#sum_kewajiban_angsuran_ditempat_lain');
    const sum_total_kewajiban = $('#sum_total_kewajiban');
    const sum_total_pendapatan = $('#sum_total_pendapatan');
    const sum_DSR_percentage = $('#sum_DSR_percentage');

    function loadAjax() {
        act_refresh_mutasi_rekening_view();
        act_refresh_invoice_view();
    }

    // -- MUTASI REKENING --
    function act_input_saldo_awal() {

        if (mrt_saldo_awal.val() === '') {
            alert("Nominal saldo awal harus diisi!");
        } else {
            var data = $('#form_RAK_company').serialize();

            $.ajax({
                type: "POST",
                url: "company-rak-action.php?action=input-mutasi-rekening",
                data: data,
                success: function(hasil) {
                    $('#fimrt_btn_submit_mutasi').prop('disabled', false);
                    act_refresh_mutasi_rekening_view();
                    mrt_saldo_awal.prop('readonly', true);
                    view_input_mutasi(true);
                }
            });
        }
    }

    function act_input_mutasi() {
        if (fimrt_tanggal_transaksi.val() === '' || fimrt_mutasi_debit.val() === '' || fimrt_mutasi_kredit.val() === '') {
            alert("Silahkan lengkapi ['Tanggal Transaksi'], ['Mutasi Debit'] dan ['Mutasi Kredit'] mutasi rekeningnya!");
        } else {
            var data = $('#form_RAK_company').serialize();

            $.ajax({
                type: "POST",
                url: "company-rak-action.php?action=input-mutasi-rekening",
                data: data,
                success: function(hasil) {
                    // reset kolom
                    fimrt_ket_transaksi.val("");
                    fimrt_mutasi_debit.val(0);
                    fimrt_mutasi_kredit.val(0);

                    act_refresh_mutasi_rekening_view();
                }
            });
        }
    }

    function act_delete_row_mutasi_rek(id) {
        var data = $('#form_RAK_company').serialize();

        if (confirm("Apakah anda yakin ingin menghapus data ini?")) {

            $.ajax({
                type: "POST",
                url: "company-rak-action.php?action=hapus-mutasi-rekening&id=" + id,
                data: data,
                success: function(hasil) {
                    act_refresh_mutasi_rekening_view();
                }
            });

        }
    }

    function act_refresh_mutasi_rekening_view() {
        var data = $('#form_RAK_company').serialize();

        $.ajax({
            type: "POST",
            url: "company-rak-view.php?action=view-mutasi-rekening",
            data: data,
            success: function(response) {
                $('#table-container-mutasi').html(response);

                act_refresh_summary_mutasi_rekening_view();
            }
        });
    }

    function act_refresh_summary_mutasi_rekening_view() {
        var data = $('#form_RAK_company').serialize();

        $.ajax({
            type: "POST",
            url: "company-rak-view.php?action=view-summary-mutasi-rekening",
            data: data,
            success: function(response) {
                $('#table-container-summary-mutasi').html(response);
            }
        });
    }

    function view_input_mutasi(isVisible) {
        const table_input_mutasi = $('#table-input-mutasi');

        if (isVisible) {
            table_input_mutasi.show();
        } else {
            table_input_mutasi.hide();
        }
    }

    // -- END OF MUTASI REKENING --

    // -- INVOICE --
    function act_input_invoice() {
        if (inv_yang_dilampirkan_type.val() === '' || inv_tanggal_transaksi.val() === '' || inv_nominal.val() === '') {
            alert("Silahkan lengkapi ['Invoice Yang Dilampirkan'], ['Tanggal Transaksi'] dan ['Nominal'] invoicenya!");
        } else {
            var data = $('#form_RAK_company').serialize();

            $.ajax({
                type: "POST",
                url: "company-rak-action.php?action=input-invoice",
                data: data,
                success: function(hasil) {
                    // reset input
                    inv_ket_transaksi.val("");
                    inv_nominal.val(0);

                    // refresh view
                    act_refresh_invoice_view();
                }
            });
        }
    }

    function act_delete_row_invoice(id) {
        var data = $('#form_RAK_company').serialize();

        if (confirm("Apakah anda yakin ingin menghapus data ini?")) {

            $.ajax({
                type: "POST",
                url: "company-rak-action.php?action=hapus-invoice&id=" + id,
                data: data,
                success: function(hasil) {
                    act_refresh_invoice_view();
                }
            });

        }
    }

    function act_refresh_invoice_view() {
        var data = $('#form_RAK_company').serialize();

        $.ajax({
            type: "POST",
            url: "company-rak-view.php?action=view-invoice",
            data: data,
            success: function(response) {
                $('#table-container-invoice').html(response);

                act_refresh_summary_invoice_view();
            }
        });
    }

    function act_refresh_summary_invoice_view() {
        var data = $('#form_RAK_company').serialize();

        $.ajax({
            type: "POST",
            url: "company-rak-view.php?action=view-summary-invoice",
            data: data,
            success: function(response) {
                $('#table-container-summary-invoice').html(response);
            }
        });
    }

    // -- END OF INVOICE --

    // -- TOTAL PENDAPATAN --
    function act_calculate_pendapatan() {
        const pendapatanBruto = lkt_nominal_laporan.val().replace(/[^\d]/g, '');
        const marginPendapatan = lkt_margin_pendapatan_usaha.val().replace(/[^\d]/g, '');
        const biayaOperasional = lkt_biaya_operasional.val().replace(/[^\d]/g, '');

        if (pendapatanBruto === '' || marginPendapatan === '' || biayaOperasional === '') {
            alert("Silahkan lengkapi [Nominal], [% Margin Pendapatan Usaha] dan [Biaya Operasional]!");
        }
        else if ($('#lkt_tahun_laporan').val() === '' || $('#lkt_status_audit').val() === '') {
            alert("Silahkan pilih [Tahun Laporan] dan [Status Audit]!");
        }
        else
        {
            const totalPendapatanUsaha = (pendapatanBruto * marginPendapatan) / 100;
            const netPendapatan = totalPendapatanUsaha - biayaOperasional;

            // console.log(marginPendapatan);
            // console.log(biayaOperasional);
            // console.log(totalPendapatanUsaha);
            // console.log(netPendapatan);

            const totalPendapatanUsahaRp = totalPendapatanUsaha.toString().replace('.', ',');
            const netPendapatanRp = netPendapatan.toString().replace('.', ',');

            // console.log(totalPendapatanUsahaRp);
            // console.log(netPendapatanRp);

            lkt_total_pendapatan_usaha.val(formatRupiah(totalPendapatanUsahaRp));
            lkt_net_pendapatan_usaha.val(formatRupiah(netPendapatanRp));
        }
    }
    // -- END OF TOTAL PENDAPATAN --
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const url_fasilitas_company = `view-rak-company-fasilitas-badan-hukum.php?no_trx=<?= $dataCpy['REF_NO'] ?>&npwp_perusahaan=<?= $dataCpy['ID_NO'] ?>&nama_perusahaan=<?= $dataCpy['NAMA_PERUSAHAAN'] ?>`;
        const url_fasilitas_pengurus = `view-rak-company-fasilitas-pengurus.php?no_trx=<?= $dataCpy['REF_NO'] ?>`;

        document.getElementById('loading-fasilitas-company').style.display = 'block';

        fetch(url_fasilitas_company)
            .then(response => response.text())
            .then(data => {
                document.getElementById('loading-fasilitas-company').style.display = 'none';
                document.getElementById('fasilitas-company').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById('loading-fasilitas-company').style.display = 'none';
            });

        fetch(url_fasilitas_pengurus)
            .then(response => response.text())
            .then(data => {
                document.getElementById('fasilitas-pengurus').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
	
	$('#submit_RAK_rec').on('click', function(e) {
	const status = $('#done_phone_verif').val()
	if (status != "1") {
		alert("Isi Dulu Phone Verificationnya");
		e.preventDefault();
	}
	});

</script>