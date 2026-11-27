<?php

set_time_limit(120);

// for file directory (choose one)
// const BASE_URL = "http://172.16.2.5/h2h_pefindo/"; # OUTSIDE 2.5
const BASE_URL = ""; # INSIDE 2.5

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

function displayFileByBase64($_fileType, $_fileBase64)
{
    // extension reader
    $is_image = array('IMAGE/JPEG');
    $is_doc = array('APPLICATION/PDF');

    if (in_array(strtoupper($_fileType), $is_image)) {
        echo '<a href="data:image/jpeg;base64,' . base64_encode($_fileBase64) . '" data-lightbox="property">
            <img src="data:image/jpeg;base64,' . base64_encode($_fileBase64) . '" style="height:300px;width:200px;" class="img-custom">
        </a>';
    }
    else if (in_array(strtoupper($_fileType), $is_doc)) {
        echo '<iframe src="data:application/pdf;base64,' . base64_encode($_fileBase64) . '" width="100%" height="400px"></iframe>';
    }
}

function format_tanggal($tanggal)
{
    if ($tanggal <> null)
    {
        return $tanggal->format('Y-m-d');
    } else {
        return "-";
    }
}

# parameter
$user      = $_GET['USERNAME'];
$apv_no    = $_GET['APV_NO'];
$role_code = $_GET['ROLE_CODE'];
$id        = $_GET['ID'];

# submit
if (isset($_POST['submit_RAK']))
{
    $alert = "";

    # Header
    $rak_h_id = $_POST['CPY_RAK_H_ID'];
    $username = $_POST['username'];

    # Approval
    switch ($_POST['submit_RAK']) {
        case 'APPROVE':
            $hasil_rekomendasi = "REKOMENDASI";
            break;

        case 'REJECT':
            $hasil_rekomendasi = "TIDAK REKOMENDASI";
            break;
        
        default:
            $hasil_rekomendasi = $_POST['submit_RAK'];
            break;
    }

    $notes = $_POST['approval_notes'];

    if ($_POST['is_final_user'] === "YA" && $hasil_rekomendasi === "TIDAK REKOMENDASI") {
        $queryInsRjc = "{call SP_RAK_CPY_INSERT_REJECT_REASON(?,?,?)}";
		$parameterInsRjc = array(
			array($_POST['ref_no'], SQLSRV_PARAM_IN),
			array($_POST['apv_reject_reason'], SQLSRV_PARAM_IN),
			array($user, SQLSRV_PARAM_IN)
		);
		$execInsRjc = sqlsrv_query($conn, $queryInsRjc, $parameterInsRjc) or die(print_r(sqlsrv_errors(), true));
    }   

    if ($hasil_rekomendasi === "REKOMENDASI") {

        # Menu UP DP hanya muncul saat approval final
        if ($_POST['is_final_user'] === "YA")
        {
            $rak_up_dp_stat = $_POST['rak_up_dp_stat'];
            $rak_up_dp_persen = str_replace(str_split('\\/:*?"<>|,.'), '', $_POST['rak_up_dp_persen']);
            $rak_up_dp_persen_type = "decimal";

            # Simpan hanya jika UP DP
            if ($rak_up_dp_stat === "YA") {
                $queryRecUpDp = "{call SP_RAK_CPY_INSERT_UPDATE_REKOMENDASI(?, ?, ?, ?, ?, ?, ?)}";
                
                $parameterRecUpDp = array(
                    array($rak_h_id, SQLSRV_PARAM_IN),
                    array($rak_up_dp_stat, SQLSRV_PARAM_IN),
                    array("UP DP", SQLSRV_PARAM_IN),
                    array($rak_up_dp_persen, SQLSRV_PARAM_IN),
                    array($rak_up_dp_persen_type, SQLSRV_PARAM_IN),
                    array($notes, SQLSRV_PARAM_IN),
                    array($user, SQLSRV_PARAM_IN)
                );

                $execRecUpDp = sqlsrv_query($conn, $queryRecUpDp, $parameterRecUpDp) or die(print_r(sqlsrv_errors(), true));

                if ($execRecUpDp) {
                    $alert = "<script>alert('Data Berhasil dikembalikan ke MH untuk diupdate');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "'</script>";
                } else {
                    $alert = "<script>alert('Data Gagal Disimpan');history.back();</script>";
                }
            }
        }

        # Menu Fleet rekomendasi muncul di BM & Up
        $sum_fleet_rec = str_replace(str_split('\\/:*?"<>|,.'), '', $_POST['sum_fleet_rec']);
        $sum_fleet_rec_type = "int";
        $sum_fleet_recommended_opt = $_POST['sum_fleet_recommended_opt'];

        if ($sum_fleet_recommended_opt === "SEBAGIAN")
        {
            $queryRecFleet = "{call SP_RAK_CPY_INSERT_UPDATE_REKOMENDASI(?, ?, ?, ?, ?, ?, ?)}";
                
                $parameterRecFleet = array(
                    array($rak_h_id, SQLSRV_PARAM_IN),
                    array($sum_fleet_recommended_opt, SQLSRV_PARAM_IN),
                    array("REKOMENDASI FLEET", SQLSRV_PARAM_IN),
                    array($sum_fleet_rec, SQLSRV_PARAM_IN),
                    array($sum_fleet_rec_type, SQLSRV_PARAM_IN),
                    array($notes, SQLSRV_PARAM_IN),
                    array($user, SQLSRV_PARAM_IN)
                );

                $execRecFleet = sqlsrv_query($conn, $queryRecFleet, $parameterRecFleet) or die(print_r(sqlsrv_errors(), true));

                if ($execRecFleet) {
                    $alert = "<script>alert('Data Berhasil dikembalikan ke MH untuk diupdate');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "'</script>";
                } else {
                    $alert = "<script>alert('Data Gagal Disimpan');history.back();</script>";
                }
        }
    }

    $callApv = "{call SP_RAK_CPY_UPDATE_APPROVAL(?, ?, ?, ?, ?, ?)}";
    $paramApv = array(
        array($rak_h_id, SQLSRV_PARAM_IN),
        array($apv_no, SQLSRV_PARAM_IN),
        array($hasil_rekomendasi, SQLSRV_PARAM_IN),
        array($notes, SQLSRV_PARAM_IN),
        array($role_code, SQLSRV_PARAM_IN),
        array($username, SQLSRV_PARAM_IN)
    );
    $execApv = sqlsrv_query($conn, $callApv, $paramApv) or die(print_r(sqlsrv_errors(), true));

    if ($alert === "")
    {
        $alert = "<script>alert('Data Berhasil Disimpan');window.location='index.php?USERNAME=" . $_GET['USERNAME'] . "'</script>";
    }
    
    echo $alert;
    exit();
}
else 
{
    # Detail Ringkasan
    $callCpy = "{call SP_RAK_CPY_GET_TEMP_INFO(?)}";
    $paramCpy = array(array($id, SQLSRV_PARAM_IN));
    $execCpy = sqlsrv_query($conn, $callCpy, $paramCpy) or die(print_r(sqlsrv_errors(), true));
    $dataCpy = sqlsrv_fetch_array($execCpy, SQLSRV_FETCH_ASSOC);


    # Detail Company untuk file LO (by Prospect No)
    $callCompanyDetail = "{call CPY_PEFINDO_GETDATA_DETAIL_COMPANY(?)}";
    $paramCompanyDetail = array(array($dataCpy['REF_NO'], SQLSRV_PARAM_IN));
    $execCompanyDetail = sqlsrv_query($conn, $callCompanyDetail, $paramCompanyDetail) or die(print_r(sqlsrv_errors(), true));
    $dataCompanyDetail = sqlsrv_fetch_array($execCompanyDetail);


    # Lain-lain
    $pendapatanNET = htmlentities($dataCpy['PENDAPATAN_BAHUK'], ENT_QUOTES, 'UTF-8');
    $angsuranOrder = htmlentities($dataCpy['ANGSURAN'], ENT_QUOTES, 'UTF-8');
    $angsuranOrderNewSFI = htmlentities($dataCpy['ANGSURAN_BY_MOS'], ENT_QUOTES, 'UTF-8');
    $angsuranAO = htmlentities($dataCpy['ANGSURAN_BY_AO'], ENT_QUOTES, 'UTF-8');
    $angsuranLain = htmlentities($dataCpy['KEWAJIBAN_TEMPAT_LAIN'], ENT_QUOTES, 'UTF-8');
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
            <input type="hidden" name="username" id="username" value="<?= $user; ?>">
            <input type="hidden" name="ref_no" id="ref_no" value="<?= $dataCpy['REF_NO']; ?>">
            <input type="hidden" name="ref_type" id="ref_type" value="NOMOR ORDER">
            <input type="hidden" name="cust_id" id="cust_id" value="<?= $dataCpy['CUST_ID']; ?>">
            <input type="hidden" name="branch_id" id="branch_id" value="<?= $dataCpy['KODE_CABANG']; ?>">
            
            <input type="hidden" name="latitude" id="latitude" value="<?= $dataCpy['LATITUDE']; ?>">
            <input type="hidden" name="longitude" id="longitude" value="<?= $dataCpy['LONGITUDE']; ?>">

            <input type="hidden" name="status_proxy_income" id="status_proxy_income" value="<?= htmlentities($dataCpy['PROXY_INCOME'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="status_collectibility" id="status_collectibility" value="<?= htmlentities($dataCpy['STATUS_COLLECTIBILITY'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="status_level" id="status_level" value="<?= htmlentities($dataCpy['STATUS_LEVEL'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="score_desc" id="score_desc" value="<?= htmlentities($dataCpy['DESKRIPSI_SCORE'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="segmentation" id="segmentation" value="<?= htmlentities($dataCpy['SEGMENTASI'], ENT_QUOTES, 'UTF-8'); ?>">

            <input type="hidden" name="CPY_RAK_H_ID" id="CPY_RAK_H_ID" value="<?= $id; ?>">
            <input type="hidden" name="is_final_user" id="is_final_user" value="<?= ($user === $dataCpy['USER_FINAL']) ? 'YA' : 'TIDAK'; ?>">

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
                        <li class="active">
                            <a data-toggle="pill" href="#approval">APPROVAL</a>
                        </li>
                        <li>
                            <a data-toggle="pill" href="#review">REVIEW RAK</a>
                        </li>
						<li>
                            <a data-toggle="pill" href="#main">RAK</a>
                        </li>
						<li><a data-toggle="pill" href="#phone_verif">PHONE VERIFICATION</a></li>
                        <li>
                            <a data-toggle="pill" href="#fleet">FLEET & AO</a>
                        </li>
					</ul>

                    <br>

                    <div class="tab-content">
                        <div id="approval" class="tab-pane fade">
                            <div class="row">
                                <!-- *************************************** APPROVAL *************************************** -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">APPROVAL</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><b>NOTE APPROVAL</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea id="approval_notes" name="approval_notes" class="form-control" rows="7"></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <?php if ($user === $dataCpy['USER_FINAL']) : ?>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Reject Reason</td>
                                                <td>
                                                    <?php
                                                    $callReject = "{call SP_GET_REJECT_REASON_RAK}";
                                                    $execReject = sqlsrv_query($conn, $callReject) or die(print_r(sqlsrv_errors(), true));
                                                    ?>

                                                    <select name="apv_reject_reason" id="apv_reject_reason" class="form-control">
                                                        <option value="">-- PILIH --</option>
                                                        <?php while ($rowReject = sqlsrv_fetch_array($execReject)) : ?>
                                                            <option value="<?php echo $rowReject['REJECT_REASON']; ?>">
                                                                <?php echo $rowReject['REJECT_REASON']; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <?php endif; ?>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>
                                                    <input type="submit" name="submit_RAK" id="submit_RAK_return" class="btn btn-custom" value="RETURN">
                                                    <input type="submit" name="submit_RAK" id="submit_RAK_notrec" class="btn btn-outline-danger" value="REJECT">
                                                    <input type="submit" name="submit_RAK" id="submit_RAK_rec" class="btn btn-custom" value="APPROVE">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- *************************************** end of APPROVAL *************************************** -->
                            </div>
                        </div>
                        
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
                                                    <input type="checkbox" name="dev_lap_keu_opt" id="dev_lap_keu_opt" value="1" <?php if ($dataCpy['DEV_LAP_KEU_STAT'] === "1") echo "checked"; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi Tidak melampirkan data keuangan (rekening koran/tabungan 3 bulan terakhir atau tidak melampirkan invoice/nota/pembukuan)</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_data_keuangan_opt" id="dev_data_keuangan_opt" value="1" <?php if ($dataCpy['DEV_DATA_KEU_STAT'] === "1") echo "checked"; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi Perusahaan berdiri kurang dari 1 tahun</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_durasi_perusahaan_opt" id="dev_durasi_perusahaan_opt" value="1" <?php if ($dataCpy['DEV_PERUSAHAAN_STAT'] === "1") echo "checked"; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi DSR diatas 60%</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_dsr_opt" id="dev_dsr_opt" value="1" <?php if ($dataCpy['DEV_DSR_STAT'] === "1") echo "checked"; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Deviasi TDP dibawah 27,5% untuk DSR >40%</td>
                                                <td style="text-align: center;">
                                                    <input type="checkbox" name="dev_tdp_opt" id="dev_tdp_opt" value="1" <?php if ($dataCpy['DEV_TDP_STAT'] === "1") echo "checked"; ?>>
                                                </td>
                                            </tr>
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- # *************************************** end of REVIEW RAK *************************************** # -->
                        </div>

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
                                                        <textarea disabled id="rak_company_profile" name="rak_company_profile" class="form-control" rows="7"><?= htmlentities($dataCpy['COMPANY_PROFILE'], ENT_QUOTES, 'UTF-8'); ?></textarea>
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
                                                            <input type="text" name="rak_area" id="rak_area" value="<?= htmlentities($dataCpy['AREA'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cabang</td>
                                                        <td>
                                                            <input type="text" name="rak_cabang" id="rak_cabang" value="<?= htmlentities($dataCpy['KODE_CABANG'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Order</td>
                                                        <td>
                                                            <input type="text" name="rak_no_order" id="rak_no_order" value="<?= htmlentities($dataCpy['REF_NO'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Order</td>
                                                        <td>
                                                            <input type="text" name="rak_tanggal_order" id="rak_tanggal_order" value="<?= htmlentities(($dataCpy['REF_NO_DT'] !== NULL) ? $dataCpy['REF_NO_DT']->format('Y-m-d') : 'NULL', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Nama CMO</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_CMO" id="rak_nama_CMO" value="<?= htmlentities($dataCpy['NAMA_CMO'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama SBH</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_SBH" id="rak_nama_SBH" value="<?php echo htmlentities($dataCpy['NAMA_SBH'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama CA</td>
                                                        <td>
                                                            <input type="text" name="rak_nama_CA" id="rak_nama_CA" value="<?php echo htmlentities($dataCpy['NAMA_CA'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
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
                                                    <input type="text" id="vi_company_type" name="vi_company_type" class="form-control" value="<?= htmlentities($dataCpy['TIPE_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                                <td>Legal Opinion (LO)</td>
                                                <td>
                                                    <?php displayFile($dataCompanyDetail['FILE_LO'], $dataCompanyDetail['FILE_TYPE_LO'], "assets/company/LO/" . $dataCompanyDetail['FILE_LO'], 'LO'); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_nama_badan_hukum" name="vi_nama_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['NAMA_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No NPWP Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_no_npwp" name="vi_no_npwp" class="form-control" value="<?= htmlentities($dataCpy['NO_NPWP_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tgl. Pendirian</td>
                                                <td>
                                                    <input type="text" id="vi_tgL_pendirian" name="vi_tgL_pendirian" class="form-control" value="<?= htmlentities(($dataCpy['TANGGAL_PENDIRIAN_BAHUK'] !== NULL) ? $dataCpy['TANGGAL_PENDIRIAN_BAHUK']->format('Y-m-d') : 'NULL', ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Total Karyawan</td>
                                                <td>
                                                    <input type="text" id="vi_jum_total_karyawan" name="vi_jum_total_karyawan" class="form-control" value="<?= htmlentities($dataCpy['JUMLAH_TOTAL_KARYAWAN_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>No Telephone</td>
                                                <td>
                                                    <input type="text" id="vi_no_telp" name="vi_no_telp" class="form-control" value="<?= htmlentities($dataCpy['NO_TELP_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat Pendirian Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_alamat_pendirian_badan_hukum" name="vi_alamat_pendirian_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['ALAMAT_PENDIRIAN_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Alamat Domisili Badan Hukum</td>
                                                <td>
                                                    <input type="text" id="vi_alamat_dom_badan_hukum" name="vi_alamat_dom_badan_hukum" class="form-control" value="<?= htmlentities($dataCpy['ALAMAT_DOMISILI_BAHUK'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
                                                </td>
                                                <td>
                                                    <select name="vi_summary_val" class="form-control" required>
                                                        <option <?php if ($dataCpy['ALAMAT_DOMISILI_BAHUK_STAT'] === "0" || $dataCpy['ALAMAT_DOMISILI_BAHUK_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['ALAMAT_DOMISILI_BAHUK_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['ALAMAT_DOMISILI_BAHUK_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea disabled id="vi_summary_note" name="vi_summary_note" class="form-control" placeholder="Notes Alamat Domisili Badan Hukum" rows="2"><?= htmlentities($dataCpy['ALAMAT_DOMISILI_BAHUK_NOTE'], ENT_QUOTES, 'UTF-8'); ?></textarea>
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
                                                    <input type="checkbox" value="1" name="vd_siup_nib_opt" id="vd_siup_nib_opt" <?php if ($dataCpy['SIUP_NIB_STAT'] !== "0" && $dataCpy['SIUP_NIB_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_siup_nib_val" name="vd_siup_nib_val" class="form-control">
                                                        <option <?php if ($dataCpy['SIUP_NIB_STAT'] === "0" || $dataCpy['SIUP_NIB_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['SIUP_NIB_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['SIUP_NIB_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>IMB (Izin Mendirikan Bangunan)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_imb_opt" id="vd_imb_opt" <?php if ($dataCpy['IMB_STAT'] !== "0" && $dataCpy['IMB_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_imb_val" name="vd_imb_val" class="form-control">
                                                        <option <?php if ($dataCpy['IMB_STAT'] === "0" || $dataCpy['IMB_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['IMB_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['IMB_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bukti kepemilikan tanah atau perjanjian sewa gedung (sertifikat/akta jual beli/faktur)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_bukti_kepem_tanah_opt" id="vd_bukti_kepem_tanah_opt" <?php if ($dataCpy['BUKTI_KEPEM_TANAH_STAT'] !== "0" && $dataCpy['BUKTI_KEPEM_TANAH_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_bukti_kepem_tanah_val" name="vd_bukti_kepem_tanah_val" class="form-control">
                                                        <option <?php if ($dataCpy['BUKTI_KEPEM_TANAH_STAT'] === "0" || $dataCpy['BUKTI_KEPEM_TANAH_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['BUKTI_KEPEM_TANAH_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['BUKTI_KEPEM_TANAH_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat keterangan domisili gedung dari Aparat Pemerintahan setempat</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_surat_ket_dom_gedung_opt" id="vd_surat_ket_dom_gedung_opt" <?php if ($dataCpy['SK_DOM_GEDUNG_STAT'] !== "0" && $dataCpy['SK_DOM_GEDUNG_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_surat_ket_dom_gedung_val" name="vd_surat_ket_dom_gedung_val" class="form-control">
                                                        <option <?php if ($dataCpy['SK_DOM_GEDUNG_STAT'] === "0" || $dataCpy['SK_DOM_GEDUNG_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['SK_DOM_GEDUNG_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['SK_DOM_GEDUNG_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bukti pembayaran Pajak Bumi dan Bangunan (PBB)</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_bukti_pembayaran_pbb_opt" id="vd_bukti_pembayaran_pbb_opt" <?php if ($dataCpy['BUKTI_BAYAR_PBB_STAT'] !== "0" && $dataCpy['BUKTI_BAYAR_PBB_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_bukti_pembayaran_pbb_val" name="vd_bukti_pembayaran_pbb_val" class="form-control">
                                                        <option <?php if ($dataCpy['BUKTI_BAYAR_PBB_STAT'] === "0" || $dataCpy['BUKTI_BAYAR_PBB_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['BUKTI_BAYAR_PBB_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['BUKTI_BAYAR_PBB_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Rekening Listrik</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_rek_listrik_opt" id="vd_rek_listrik_opt" <?php if ($dataCpy['REK_LISTRIK_STAT'] !== "0" && $dataCpy['REK_LISTRIK_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_rek_listrik_val" name="vd_rek_listrik_val" class="form-control">
                                                        <option <?php if ($dataCpy['REK_LISTRIK_STAT'] === "0" || $dataCpy['REK_LISTRIK_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['REK_LISTRIK_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['REK_LISTRIK_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Surat keterangan izin tempat usaha</td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_surat_izin_tempat_usaha_opt" id="vd_surat_izin_tempat_usaha_opt" <?php if ($dataCpy['SK_IZIN_USAHA_STAT'] !== "0" && $dataCpy['SK_IZIN_USAHA_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_surat_izin_tempat_usaha_val" name="vd_surat_izin_tempat_usaha_val" class="form-control">
                                                        <option <?php if ($dataCpy['SK_IZIN_USAHA_STAT'] === "0" || $dataCpy['SK_IZIN_USAHA_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['SK_IZIN_USAHA_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['SK_IZIN_USAHA_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    Status Badan Hukum

                                                    <select id="vd_status_badan_hukum_type" name="vd_status_badan_hukum_type" class="form-control">
                                                        <option <?php if ($dataCpy['STATUS_BAHUK'] === "0" || $dataCpy['STATUS_BAHUK'] === NULL) echo "selected"; ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['STATUS_BAHUK'] === "KANTOR PUSAT") echo "selected"; ?> value="KANTOR PUSAT">KANTOR PUSAT</option>
                                                        <option <?php if ($dataCpy['STATUS_BAHUK'] === "KANTOR CABANG") echo "selected"; ?> value="KANTOR CABANG">KANTOR CABANG</option>
                                                        <option <?php if ($dataCpy['STATUS_BAHUK'] === "LAINNYA") echo "selected"; ?> value="LAINNYA">LAINNYA</option>
                                                    </select>

                                                    <label style="margin-top: 1rem;">Catatan :</label>
                                                    <textarea disabled id="vd_status_badan_hukum_type_note" name="vd_status_badan_hukum_type_note" class="form-control" rows="3"><?= htmlentities($dataCpy['STATUS_BAHUK_NOTE'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_status_badan_hukum_opt" id="vd_status_badan_hukum_opt" <?php if ($dataCpy['STATUS_BAHUK_STAT'] !== "0" && $dataCpy['STATUS_BAHUK_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_status_badan_hukum_val" name="vd_status_badan_hukum_val" class="form-control">
                                                        <option <?php if ($dataCpy['STATUS_BAHUK_STAT'] === "0" || $dataCpy['STATUS_BAHUK_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['STATUS_BAHUK_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['STATUS_BAHUK_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Status Kepemilikan Tempat

                                                    <select id="vd_status_kep_tempat_type" name="vd_status_kep_tempat_type" class="form-control" style="margin-top: 0.3rem;">
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "0" || $dataCpy['STATUS_KEPEM_TEMPAT'] === NULL) echo "selected"; ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "MILIK SENDIRI (COMPANY)") echo "selected"; ?> value="MILIK SENDIRI (COMPANY)">MILIK SENDIRI (COMPANY)</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "MILIK SENDIRI (PENGURUS)") echo "selected"; ?> value="MILIK SENDIRI (PENGURUS)">MILIK SENDIRI (PENGURUS)</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "SEWA") echo "selected"; ?> value="SEWA">SEWA</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "KONTRAK") echo "selected"; ?> value="KONTRAK">KONTRAK</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT'] === "LAINNYA") echo "selected"; ?> value="LAINNYA">LAINNYA</option>
                                                    </select>

                                                    <label style="margin-top: 1rem;">Catatan :</label>
                                                    <textarea disabled id="vd_status_kep_tempat_type_note" name="vd_status_kep_tempat_type_note" class="form-control" rows="3"><?= htmlentities($dataCpy['STATUS_KEPEM_TEMPAT_NOTE'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                </td>
                                                <td style="text-align:center;">
                                                    <input type="checkbox" value="1" name="vd_status_kep_tempat_opt" id="vd_status_kep_tempat_opt" <?php if ($dataCpy['STATUS_KEPEM_TEMPAT_STAT'] !== "0" && $dataCpy['STATUS_KEPEM_TEMPAT_STAT'] !== NULL) echo "checked"; ?> >
                                                </td>
                                                <td>
                                                    <select id="vd_status_kep_tempat_val" name="vd_status_kep_tempat_val" class="form-control">
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT_STAT'] === "0" || $dataCpy['STATUS_KEPEM_TEMPAT_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['STATUS_KEPEM_TEMPAT_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
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
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "0" || $dataCpy['VALIDASI_DOM_USAHA'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "Cek Notaris Penerbit") echo "selected" ?> value="Cek Notaris Penerbit">Cek Notaris Penerbit</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "Cek by Online") echo "selected" ?> value="Cek by Online">Cek by Online</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "PHONE VERIFIKASI") echo "selected" ?> value="PHONE VERIFIKASI">PHONE VERIFIKASI</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "Kunjungan ke Kantor") echo "selected" ?> value="Kunjungan ke Kantor">Kunjungan ke Kantor</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "Cek dokumen pendukung") echo "selected" ?> value="Cek dokumen pendukung">Cek dokumen pendukung</option>
                                                        <option <?php if ($dataCpy['VALIDASI_DOM_USAHA'] === "Cek BPN") echo "selected" ?> value="Cek BPN">Cek BPN</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <?php
                                            $callFileDomSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileDomSBH = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('SBH', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execFileDomSBH = sqlsrv_query($conn, $callFileDomSBH, $paramFileDomSBH) or die(print_r(sqlsrv_errors(), true));
                                            $fileDomSBH = sqlsrv_fetch_array($execFileDomSBH);
                                            
                                            if ($fileDomSBH['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileDomSBH['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileDomSBH['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileDomSBH['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Domisili <?= $fileDomSBH['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileDomSBH['TIPE_FILE_UP'], $fileDomSBH['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFilePendDomSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFilePendDomSBH = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('SBH', SQLSRV_PARAM_IN),
                                                array('Bukti Pendukung', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execFilePendDomSBH = sqlsrv_query($conn, $callFilePendDomSBH, $paramFilePendDomSBH) or die(print_r(sqlsrv_errors(), true));
                                            $filePendDomSBH = sqlsrv_fetch_array($execFilePendDomSBH);
                                            
                                            if ($filePendDomSBH['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Pendukung <?= $filePendDomSBH['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($filePendDomSBH['TIPE_FILE_UP'], $filePendDomSBH['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $callFileDomCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileDomCA = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('CA', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execfileDomCA = sqlsrv_query($conn, $callFileDomCA, $paramFileDomCA) or die(print_r(sqlsrv_errors(), true));
                                            $fileDomCA = sqlsrv_fetch_array($execfileDomCA);
                                            
                                            if ($fileDomCA['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileDomCA['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileDomCA['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileDomCA['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Domisili <?= $fileDomCA['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileDomCA['TIPE_FILE_UP'], $fileDomCA['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $callFilePendDomCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFilePendDomCA = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('CA', SQLSRV_PARAM_IN),
                                                array('Bukti Pendukung', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execFilePendDomCA = sqlsrv_query($conn, $callFilePendDomCA, $paramFilePendDomCA) or die(print_r(sqlsrv_errors(), true));
                                            $filePendDomCA = sqlsrv_fetch_array($execFilePendDomCA);
                                            
                                            if ($filePendDomCA['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Pendukung <?= $filePendDomCA['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($filePendDomCA['TIPE_FILE_UP'], $filePendDomCA['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileDomBM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileDomBM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('BM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execfileDomBM = sqlsrv_query($conn, $callFileDomBM, $paramFileDomBM) or die(print_r(sqlsrv_errors(), true));
                                            $fileDomBM = sqlsrv_fetch_array($execfileDomBM);
                                            
                                            if ($fileDomBM['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileDomBM['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileDomBM['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileDomBM['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Domisili <?= $fileDomBM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileDomBM['TIPE_FILE_UP'], $fileDomBM['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileDomAM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileDomAM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('AM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Domisili', SQLSRV_PARAM_IN),
                                                array('DOMISILI USAHA', SQLSRV_PARAM_IN),
                                            );
                                            $execfileDomAM = sqlsrv_query($conn, $callFileDomAM, $paramFileDomAM) or die(print_r(sqlsrv_errors(), true));
                                            $fileDomAM = sqlsrv_fetch_array($execfileDomAM);
                                            
                                            if ($fileDomAM['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileDomAM['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileDomAM['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileDomAM['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Domisili <?= $fileDomAM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileDomAM['TIPE_FILE_UP'], $fileDomAM['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
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
                                                <td>HASIL FOTO SURVEY VS HASIL GEOTAGGING ALAMAT<br>APAKAH SESUAI?</td>
                                                <td>
                                                    <select name="vhs_hasil_foto_vs_geotag_val" class="form-control">
                                                        <option <?php if ($dataCpy['FOTO_DAN_ALAMAT_SESUAI_STAT'] === "0" || $dataCpy['FOTO_DAN_ALAMAT_SESUAI_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['FOTO_DAN_ALAMAT_SESUAI_STAT'] === "SESUAI") echo "selected" ?> value="SESUAI">SESUAI</option>
                                                        <option <?php if ($dataCpy['FOTO_DAN_ALAMAT_SESUAI_STAT'] === "TIDAK SESUAI") echo "selected" ?> value="TIDAK SESUAI">TIDAK SESUAI</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            
                                            <?php
                                            $callFileGeoSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileGeoSBH = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('SBH', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
                                                array('HASIL SURVEY', SQLSRV_PARAM_IN),
                                            );
                                            $execFileGeoSBH = sqlsrv_query($conn, $callFileGeoSBH, $paramFileGeoSBH) or die(print_r(sqlsrv_errors(), true));
                                            $fileGeoSBH = sqlsrv_fetch_array($execFileGeoSBH);
                                            
                                            if ($fileGeoSBH['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileGeoSBH['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileGeoSBH['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileGeoSBH['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Geotagging <?= $fileGeoSBH['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileGeoSBH['TIPE_FILE_UP'], $fileGeoSBH['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileGeoCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileGeoCA = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('CA', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
                                                array('HASIL SURVEY', SQLSRV_PARAM_IN),
                                            );
                                            $execFileGeoCA = sqlsrv_query($conn, $callFileGeoCA, $paramFileGeoCA) or die(print_r(sqlsrv_errors(), true));
                                            $fileGeoCA = sqlsrv_fetch_array($execFileGeoCA);
                                            
                                            if ($fileGeoCA['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileGeoCA['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileGeoCA['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileGeoCA['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Geotagging <?= $fileGeoCA['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileGeoCA['TIPE_FILE_UP'], $fileGeoCA['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileGeoBM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileGeoBM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('BM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
                                                array('HASIL SURVEY', SQLSRV_PARAM_IN),
                                            );
                                            $execFileGeoBM = sqlsrv_query($conn, $callFileGeoBM, $paramFileGeoBM) or die(print_r(sqlsrv_errors(), true));
                                            $fileGeoBM = sqlsrv_fetch_array($execFileGeoBM);
                                            
                                            if ($fileGeoBM['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileGeoBM['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileGeoBM['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileGeoBM['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Geotagging <?= $fileGeoBM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileGeoBM['TIPE_FILE_UP'], $fileGeoBM['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileGeoAM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileGeoAM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('AM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Geotagging', SQLSRV_PARAM_IN),
                                                array('HASIL SURVEY', SQLSRV_PARAM_IN),
                                            );
                                            $execFileGeoAM = sqlsrv_query($conn, $callFileGeoAM, $paramFileGeoAM) or die(print_r(sqlsrv_errors(), true));
                                            $fileGeoAM = sqlsrv_fetch_array($execFileGeoAM);
                                            
                                            if ($fileGeoAM['CATATAN'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Catatan <?= $fileGeoAM['JOB_CODE'] ?></td>
                                                    <td>
                                                        <textarea disabled class="form-control" rows="3"><?= htmlentities($fileGeoAM['CATATAN'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                                    </td>
                                                </tr>
                                            <?php endif; if ($fileGeoAM['DATA_FILE_UP'] <> NULL) : ?>
                                                <tr>
                                                    <td>Bukti Validasi Geotagging <?= $fileGeoAM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileGeoAM['TIPE_FILE_UP'], $fileGeoAM['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
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
                                                    <input type="text" name="vk_customer_model" id="vk_customer_model" value="<?= htmlentities($dataCpy['CUSTOMER_MODEL'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
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
                                                        <option <?php if ($dataCpy['REK_BAHUK_STAT'] === "0" || $dataCpy['REK_BAHUK_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['REK_BAHUK_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['REK_BAHUK_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
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
                                                        <option <?php if ($dataCpy['REK_PENGURUS_STAT'] === "0" || $dataCpy['REK_PENGURUS_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['REK_PENGURUS_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['REK_PENGURUS_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
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
                                                        <option <?php if ($dataCpy['LAP_KEU_TERAKHIR_STAT'] === "0" || $dataCpy['LAP_KEU_TERAKHIR_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['LAP_KEU_TERAKHIR_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['LAP_KEU_TERAKHIR_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
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
                                                        <option <?php if ($dataCpy['LAP_PEMBUKUAN_TERAKHIR_STAT'] === "0" || $dataCpy['LAP_PEMBUKUAN_TERAKHIR_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['LAP_PEMBUKUAN_TERAKHIR_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['LAP_PEMBUKUAN_TERAKHIR_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
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
                                                        <option <?php if ($dataCpy['LAP_SPT_STAT'] === "0" || $dataCpy['LAP_SPT_STAT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['LAP_SPT_STAT'] === "VALID") echo "selected" ?> value="VALID">VALID</option>
                                                        <option <?php if ($dataCpy['LAP_SPT_STAT'] === "TIDAK VALID") echo "selected" ?> value="TIDAK VALID">TIDAK VALID</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td>Nama Bank Penerbit</td>
                                                <td>
                                                    <input type="text" name="vk_nama_bank_penerbit" id="vk_nama_bank_penerbit" value="<?= htmlentities($dataCpy['NAMA_BANK_PENERBIT_REK'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Rekening</td>
                                                <td>
                                                    <input type="text" name="vk_nomor_rekening" id="vk_nomor_rekening" value="<?= htmlentities($dataCpy['NOMOR_REK'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pemilik Rekening</td>
                                                <td>
                                                    <input type="text" name="vk_nama_pemilik_rekening" id="vk_nama_pemilik_rekening" value="<?= htmlentities($dataCpy['NAMA_PEMILIK_REK'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mutasi Yang Dilampirkan</td>
                                                <td>
                                                    <select id="vk_mutasi_yang_dilampirkan_type" name="vk_mutasi_yang_dilampirkan_type" class="form-control">
                                                        <option <?php if ($dataCpy['MUTASI_YANG_DILAMPIRKAN'] === "0" || $dataCpy['MUTASI_YANG_DILAMPIRKAN'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['MUTASI_YANG_DILAMPIRKAN'] === "1 Bulan Terakhir") echo "selected" ?> value="1 Bulan Terakhir">1 Bulan Terakhir</option>
                                                        <option <?php if ($dataCpy['MUTASI_YANG_DILAMPIRKAN'] === "2 Bulan Terakhir") echo "selected" ?> value="2 Bulan Terakhir">2 Bulan Terakhir</option>
                                                        <option <?php if ($dataCpy['MUTASI_YANG_DILAMPIRKAN'] === "3 Bulan Terakhir") echo "selected" ?> value="3 Bulan Terakhir">3 Bulan Terakhir</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cara Validasi</td>
                                                <td>
                                                    <select id="vk_cara_validasi" name="vk_cara_validasi" class="form-control">
                                                        <option <?php if ($dataCpy['CARA_VALIDASI'] === "0" || $dataCpy['CARA_VALIDASI'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['CARA_VALIDASI'] === "PHONE VERIFIKASI") echo "selected" ?> value="PHONE VERIFIKASI">PHONE VERIFIKASI</option>
                                                        <option <?php if ($dataCpy['CARA_VALIDASI'] === "KUNJUNGAN KE KANTOR") echo "selected" ?> value="KUNJUNGAN KE KANTOR">KUNJUNGAN KE KANTOR</option>
                                                        <option <?php if ($dataCpy['CARA_VALIDASI'] === "BPJSTKU Mobile ; SMS BPJS ; www.sso.bpjsketenagakerjaan.go.id/") echo "selected" ?> value="BPJSTKU Mobile ; SMS BPJS ; www.sso.bpjsketenagakerjaan.go.id/">BPJSTKU Mobile ; SMS BPJS ; www.sso.bpjsketenagakerjaan.go.id/</option>
                                                        <option <?php if ($dataCpy['CARA_VALIDASI'] === "MELAKUKAN PERCOBAAN TRANSFER") echo "selected" ?> value="MELAKUKAN PERCOBAAN TRANSFER">MELAKUKAN PERCOBAAN TRANSFER</option>
                                                    </select>
                                                </td>
                                            </tr>

                                            <?php
                                            $callFileBankSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileBankSBH = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('SBH', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Bank Account', SQLSRV_PARAM_IN),
                                                array('KAPASITAS', SQLSRV_PARAM_IN),
                                            );
                                            $execFileBankSBH = sqlsrv_query($conn, $callFileBankSBH, $paramFileBankSBH) or die(print_r(sqlsrv_errors(), true));
                                            $fileBankSBH = sqlsrv_fetch_array($execFileBankSBH);
                                            
                                            if ($fileBankSBH['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Validasi Bank Account <?= $fileBankSBH['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileBankSBH['TIPE_FILE_UP'], $fileBankSBH['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php
                                            $callFileBankCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileBankCA = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('CA', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Bank Account', SQLSRV_PARAM_IN),
                                                array('KAPASITAS', SQLSRV_PARAM_IN),
                                            );
                                            $execFileBankCA = sqlsrv_query($conn, $callFileBankCA, $paramFileBankCA) or die(print_r(sqlsrv_errors(), true));
                                            $fileBankCA = sqlsrv_fetch_array($execFileBankCA);
                                            
                                            if ($fileBankCA['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Validasi Bank Account <?= $fileBankCA['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileBankCA['TIPE_FILE_UP'], $fileBankCA['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $callFileBankBM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileBankBM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('BM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Bank Account', SQLSRV_PARAM_IN),
                                                array('KAPASITAS', SQLSRV_PARAM_IN),
                                            );
                                            $execFileBankBM = sqlsrv_query($conn, $callFileBankBM, $paramFileBankBM) or die(print_r(sqlsrv_errors(), true));
                                            $fileBankBM = sqlsrv_fetch_array($execFileBankBM);
                                            
                                            if ($fileBankBM['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Validasi Bank Account <?= $fileBankBM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileBankBM['TIPE_FILE_UP'], $fileBankBM['DATA_FILE_UP']) ?></td>
                                                 </tr>
                                            <?php endif; ?>
                                            
                                            <?php
                                            $callFileBankAM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                            $paramFileBankAM = array(
                                                array($id, SQLSRV_PARAM_IN),
                                                array('AM', SQLSRV_PARAM_IN),
                                                array('Bukti Validasi Bank Account', SQLSRV_PARAM_IN),
                                                array('KAPASITAS', SQLSRV_PARAM_IN),
                                            );
                                            $execFileBankAM = sqlsrv_query($conn, $callFileBankAM, $paramFileBankAM) or die(print_r(sqlsrv_errors(), true));
                                            $fileBankAM = sqlsrv_fetch_array($execFileBankAM);
                                            
                                            if ($fileBankAM['DATA_FILE_UP'] <> NULL) :
                                            ?>
                                                <tr>
                                                    <td>Bukti Validasi Bank Account <?= $fileBankAM['JOB_CODE'] ?></td>
                                                    <td><?= displayFileByBase64($fileBankAM['TIPE_FILE_UP'], $fileBankAM['DATA_FILE_UP']) ?></td>
                                                </tr>
                                            <?php endif; ?>
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
                                                <td>Saldo Awal</td>
                                                <td colspan="2">
                                                    <input type="text" name="mrt_saldo_awal" id="mrt_saldo_awal" value="<?= number_format(htmlentities($dataCpy['MUTASI_SALDO_AWAL'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" onautocomplete="off" readonly>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="table-container-mutasi">
                                            <?php
                                            $callViewMutasiRek = "{call SP_RAK_CPY_GET_MUTASI_REK_TABUNGAN_TEMP(?, ?)}";
                                            $paramsViewMutasiRek = array(
                                                array($dataCpy['REF_NO'], SQLSRV_PARAM_IN),
                                                array($user, SQLSRV_PARAM_IN),
                                            );
                                            $execViewMutasiRek = sqlsrv_query($conn, $callViewMutasiRek, $paramsViewMutasiRek) or die( print_r( sqlsrv_errors(), true));
                                        
                                            $rowTable = '';
                                            $rowCountViewMutasiRek = 0;
                                            $saldoAkhir = 0;
                                        
                                            while ($rowViewMutasiRek = sqlsrv_fetch_array($execViewMutasiRek)) :
                                                $rowCountViewMutasiRek += 1;
                                                $saldoAkhir = number_format($rowViewMutasiRek['SALDO_AKHIR'], 0, ',', '.');
                                        
                                                $rowTable .= '<tr>
                                                        <td>' . $rowViewMutasiRek['SEQ'] . '</td>
                                                        <td>' . format_tanggal($rowViewMutasiRek['TGL_TRANSAKSI']) . '</td>
                                                        <td>' . $rowViewMutasiRek['KET_TRANSAKSI'] . '</td>
                                                        <td>' . 'Rp' . number_format($rowViewMutasiRek['MUTASI_DEBIT'], 0, ',', '.') . '</td>
                                                        <td>' . 'Rp' . number_format($rowViewMutasiRek['MUTASI_KREDIT'], 0, ',', '.') . '</td>
                                                        <td>' . 'Rp' . number_format($rowViewMutasiRek['SALDO_AKHIR'], 0, ',', '.') . '</td>
                                                    </tr>
                                                ';
                                        
                                            endwhile;
                                        
                                            if ($rowCountViewMutasiRek == 0)
                                            {
                                                $rowTable = '<tr>
                                                        <td colspan="7" style="text-align:center;">Belum ada data mutasi</td>
                                                    </tr>
                                                ';
                                            }
                                        
                                            echo '
                                            <input type="hidden" name="mrt_saldo_akhir" id="mrt_saldo_akhir" value="' . $saldoAkhir .'">
                                            <table class="table table-bordered">
                                                <col style="width:4%">
                                                <col style="width:10%">
                                                <col style="width:20%">
                                                <col style="width:19%">
                                                <col style="width:19%">
                                                <col>
                                        
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">No</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Tanggal</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Keterangan</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Debit</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Credit</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                ' . $rowTable . '
                                                </tbody>
                                            </table>';
                                            ?>
                                        </div>
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
                                        <div id="table-container-summary-mutasi">
                                            <?php
                                            $callViewSumMutasiRek = "{call SP_RAK_CPY_GET_MUTASI_REK_TABUNGAN_SUMMARY_TEMP(?, ?)}";
                                            $paramsViewSumMutasiRek = array(
                                                array($dataCpy['REF_NO'], SQLSRV_PARAM_IN),
                                                array($user, SQLSRV_PARAM_IN),
                                            );
                                            $execViewSumMutasiRek = sqlsrv_query($conn, $callViewSumMutasiRek, $paramsViewSumMutasiRek) or die( print_r( sqlsrv_errors(), true));
                                        
                                            $rowTable = '';
                                            $rowHeader = '';
                                        
                                            // Mendapatkan metadata kolom
                                            $metadata = sqlsrv_field_metadata($execViewSumMutasiRek);
                                        
                                            foreach ($metadata as $field) {
                                                $rowHeader .= '<th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">' . $field['Name'] . '</th>';
                                            }
                                        
                                            while ($rowViewSumMutasiRek = sqlsrv_fetch_array($execViewSumMutasiRek, SQLSRV_FETCH_ASSOC)) :
                                                $rowTable .= '<tr>';
                                                $parameter = $rowViewSumMutasiRek['Parameter'];
                                        
                                                foreach ($rowViewSumMutasiRek as $v) {
                                                    $rowTable .= '<td>' . (is_numeric($v) ? ($parameter == 'Frekuensi Mutasi Kredit' || $parameter == 'Frekuensi Mutasi Debit' ? '' : 'Rp') . number_format($v, 0, ',', '.') : $v) . '</td>';
                                                }
                                        
                                                $rowTable .= '</tr>';
                                            endwhile;
                                        
                                            echo '<table class="table table-bordered">
                                                <col style="width:20%">
                                                <col style="width:20%">
                                                <col style="width:20%">
                                                <col style="width:20%">
                                                <col style="width:20%">
                                        
                                                <thead>
                                                    <tr>
                                                        ' . $rowHeader . '
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ' . $rowTable . '
                                                </tbody>
                                            </table>';
                                            ?>
                                        </div>
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
                                                        <option <?php if ($dataCpy['INVOICE_YANG_DILAMPIRKAN'] === "0" || $dataCpy['INVOICE_YANG_DILAMPIRKAN'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['INVOICE_YANG_DILAMPIRKAN'] === "Invoice Penjualan") echo "selected" ?> value="Invoice Penjualan">Invoice Penjualan</option>
                                                        <option <?php if ($dataCpy['INVOICE_YANG_DILAMPIRKAN'] === "Invoice Belanja") echo "selected" ?> value="Invoice Belanja">Invoice Belanja</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Periode Invoice</td>
                                                <td>
                                                    <select name="inv_periode_type" id="inv_periode_type" class="form-control">
                                                        <option <?php if ($dataCpy['INVOICE_PERIODE'] === "0" || $dataCpy['INVOICE_PERIODE'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                        <option <?php if ($dataCpy['INVOICE_PERIODE'] === "1 Bulan Terakhir") echo "selected" ?> value="1 Bulan Terakhir">1 Bulan Terakhir</option>
                                                        <option <?php if ($dataCpy['INVOICE_PERIODE'] === "2 Bulan Terakhir") echo "selected" ?> value="2 Bulan Terakhir">2 Bulan Terakhir</option>
                                                        <option <?php if ($dataCpy['INVOICE_PERIODE'] === "3 Bulan Terakhir") echo "selected" ?> value="3 Bulan Terakhir">3 Bulan Terakhir</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- List Invoice -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div id="table-container-invoice">
                                            <?php
                                            $callViewInvoice = "{call SP_RAK_CPY_GET_INVOICE_TEMP(?, ?)}";
                                            $paramsViewInvoice = array(
                                                array($dataCpy['REF_NO'], SQLSRV_PARAM_IN),
                                                array($user, SQLSRV_PARAM_IN),
                                            );
                                            $execViewInvoice = sqlsrv_query($conn, $callViewInvoice, $paramsViewInvoice) or die( print_r( sqlsrv_errors(), true));
                                        
                                            $rowTable = '';
                                            $rowCountViewInvoice = 0;
                                            $nominalAkhir = 0;
                                        
                                            while ($rowViewInvoice = sqlsrv_fetch_array($execViewInvoice)) :
                                                $rowCountViewInvoice += 1;
                                                $nominalAkhir = number_format($rowViewInvoice['TOTAL'], 0, ',', '.');
                                        
                                                $rowTable .= '<tr>
                                                        <td>' . $rowViewInvoice['SEQ'] . '</td>
                                                        <td>' . format_tanggal($rowViewInvoice['TGL_INVOICE']) . '</td>
                                                        <td>' . $rowViewInvoice['JENIS_INVOICE'] . '</td>
                                                        <td>' . $rowViewInvoice['KET_INVOICE'] . '</td>
                                                        <td>' . number_format($rowViewInvoice['NOMINAL'], 0, ',', '.') . '</td>
                                                        <td>' . number_format($rowViewInvoice['TOTAL'], 0, ',', '.') . '</td>
                                                    </tr>
                                                ';
                                        
                                            endwhile;
                                        
                                            if ($rowCountViewInvoice == 0)
                                            {
                                                $rowTable = '<tr>
                                                        <td colspan="7" style="text-align:center;">Belum ada data mutasi</td>
                                                    </tr>
                                                ';
                                            }
                                        
                                            echo '
                                            <input type="hidden" name="inv_nominal_akhir" id="inv_nominal_akhir" value="' . $nominalAkhir .'">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">No</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Jenis Invoice</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Tanggal Transaksi</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Keterangan Transaksi</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Nominal</th>
                                                        <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                ' . $rowTable . '
                                                </tbody>
                                            </table>';
                                            ?>
                                        </div>
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
                                    <div id="table-container-summary-invoice">
                                        <?php
                                        $callViewSumInvoice = "{call SP_RAK_CPY_GET_INVOICE_SUMMARY_TEMP(?, ?)}";
                                        $paramsViewSumInvoice = array(
                                            array($dataCpy['REF_NO'], SQLSRV_PARAM_IN),
                                            array($user, SQLSRV_PARAM_IN),
                                        );
                                        $execViewSumInvoice = sqlsrv_query($conn, $callViewSumInvoice, $paramsViewSumInvoice) or die( print_r( sqlsrv_errors(), true));
                                    
                                        $rowTable = '';
                                    
                                        while ($rowViewSumInvoice = sqlsrv_fetch_array($execViewSumInvoice, SQLSRV_FETCH_ASSOC)) :
                                            $rowTable .= '<tr>';
                                    
                                            $rowTable .= '<td>' . $rowViewSumInvoice['BULAN'] . '</td>';
                                            $rowTable .= '<td>' . 'Rp' . number_format($rowViewSumInvoice['TOTAL_INVOICE'], 0, ',', '.') . '</td>';
                                    
                                            $rowTable .= '</tr>';
                                        endwhile;
                                    
                                        echo '<table class="table table-bordered">
                                            <col style="width:50%">
                                            <col style="width:50%">
                                    
                                            <thead>
                                                <tr>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Bulan</th>
                                                    <th style="text-align:center;vertical-align:middle;background-color:#035c7a;color:#FFF;font-weight:bold;">Total Invoice Transaksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>'
                                                . $rowTable .
                                            '</tbody>
                                        </table>';
                                        ?>
                                    </div>
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
                                                <input type="text" name="lkt_tahun_laporan" id="lkt_tahun_laporan" class="form-control number-only" value="<?= htmlentities($dataCpy['LAP_KEU_TAHUN_LAPORAN'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="4" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="margin-top: 1rem;">Status Audit :</label>
                                                <select name="lkt_status_audit" class="form-control" disabled>
                                                    <option <?php if ($dataCpy['LAP_KEU_STATUS_AUDIT'] === "0" || $dataCpy['LAP_KEU_STATUS_AUDIT'] === NULL) echo "selected" ?> value="">-- PILIH --</option>
                                                    <option <?php if ($dataCpy['LAP_KEU_STATUS_AUDIT'] === "AUDIT") echo "selected" ?> value="AUDIT">AUDIT</option>
                                                    <option <?php if ($dataCpy['LAP_KEU_STATUS_AUDIT'] === "NON AUDIT") echo "selected" ?> value="NON AUDIT">NON AUDIT</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="margin-top: 1rem;">Nominal :</label>
                                                <input type="text" name="lkt_nominal_laporan" id="lkt_nominal_laporan" class="form-control" value="<?= number_format(htmlentities($dataCpy['LAP_KEU_NOMINAL'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>% Margin Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_margin_pendapatan_usaha" id="lkt_margin_pendapatan_usaha" class="form-control number-only" value="<?= (isset($dataCpy['LAP_KEU_MARGIN'])) ? number_format(htmlentities($dataCpy['LAP_KEU_MARGIN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.') : ''; ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_total_pendapatan_usaha" id="lkt_total_pendapatan_usaha" class="form-control" value="<?= number_format(htmlentities($dataCpy['LAP_KEU_TOTAL_PENDAPATAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Biaya Operasional</td>
                                            <td>
                                                <input type="text" name="lkt_biaya_operasional" id="lkt_biaya_operasional" class="form-control" value="<?= number_format(htmlentities($dataCpy['LAP_KEU_BIAYA_OPERASIONAL'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Net Pendapatan Usaha</td>
                                            <td>
                                                <input type="text" name="lkt_net_pendapatan_usaha" id="lkt_net_pendapatan_usaha" class="form-control" value="<?= number_format(htmlentities($dataCpy['LAP_KEU_NET_PENDAPATAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="text-align: right;">
                                                <!-- <input type="button" name="lkt_btn_calculate" id="lkt_btn_calculate" class="btn btn-primary" onclick="act_calculate_pendapatan()" value="Calculate"> -->
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <?php
                                        $callFileLabaRugiSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileLabaRugiSBH = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('SBH', SQLSRV_PARAM_IN),
                                            array('Bukti Laporan Laba Rugi', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileLabaRugiSBH = sqlsrv_query($conn, $callFileLabaRugiSBH, $paramFileLabaRugiSBH) or die(print_r(sqlsrv_errors(), true));
                                        $fileLabaRugiSBH = sqlsrv_fetch_array($execFileLabaRugiSBH);
                                        
                                        if ($fileLabaRugiSBH['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Laporan Laba Rugi <?= $fileLabaRugiSBH['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileLabaRugiSBH['TIPE_FILE_UP'], $fileLabaRugiSBH['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileNeracaSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileNeracaSBH = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('SBH', SQLSRV_PARAM_IN),
                                            array('Bukti Neraca', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileNeracaSBH = sqlsrv_query($conn, $callFileNeracaSBH, $paramFileNeracaSBH) or die(print_r(sqlsrv_errors(), true));
                                        $fileNeracaSBH = sqlsrv_fetch_array($execFileNeracaSBH);
                                        
                                        if ($fileNeracaSBH['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Neraca <?= $fileNeracaSBH['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileNeracaSBH['TIPE_FILE_UP'], $fileNeracaSBH['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFilePendSBH = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFilePendSBH = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('SBH', SQLSRV_PARAM_IN),
                                            array('Bukti Pendukung', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFilePendSBH = sqlsrv_query($conn, $callFilePendSBH, $paramFilePendSBH) or die(print_r(sqlsrv_errors(), true));
                                        $filePendSBH = sqlsrv_fetch_array($execFilePendSBH);
                                        
                                        if ($filePendSBH['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Pendukung <?= $filePendSBH['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($filePendSBH['TIPE_FILE_UP'], $filePendSBH['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileLabaRugiCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileLabaRugiCA = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('CA', SQLSRV_PARAM_IN),
                                            array('Bukti Laporan Laba Rugi', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileLabaRugiCA = sqlsrv_query($conn, $callFileLabaRugiCA, $paramFileLabaRugiCA) or die(print_r(sqlsrv_errors(), true));
                                        $fileLabaRugiCA = sqlsrv_fetch_array($execFileLabaRugiCA);
                                        
                                        if ($fileLabaRugiCA['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Laporan Laba Rugi <?= $fileLabaRugiCA['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileLabaRugiCA['TIPE_FILE_UP'], $fileLabaRugiCA['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileNeracaCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileNeracaCA = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('CA', SQLSRV_PARAM_IN),
                                            array('Bukti Neraca', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileNeracaCA = sqlsrv_query($conn, $callFileNeracaCA, $paramFileNeracaCA) or die(print_r(sqlsrv_errors(), true));
                                        $fileNeracaCA = sqlsrv_fetch_array($execFileNeracaCA);
                                        
                                        if ($fileNeracaCA['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Neraca <?= $fileNeracaCA['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileNeracaCA['TIPE_FILE_UP'], $fileNeracaCA['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFilePendCA = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFilePendCA = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('CA', SQLSRV_PARAM_IN),
                                            array('Bukti Pendukung', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFilePendCA = sqlsrv_query($conn, $callFilePendCA, $paramFilePendCA) or die(print_r(sqlsrv_errors(), true));
                                        $filePendCA = sqlsrv_fetch_array($execFilePendCA);
                                        
                                        if ($filePendCA['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Pendukung <?= $filePendCA['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($filePendCA['TIPE_FILE_UP'], $filePendCA['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileLabaRugiBM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileLabaRugiBM = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('BM', SQLSRV_PARAM_IN),
                                            array('Bukti Laporan Laba Rugi', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileLabaRugiBM = sqlsrv_query($conn, $callFileLabaRugiBM, $paramFileLabaRugiBM) or die(print_r(sqlsrv_errors(), true));
                                        $fileLabaRugiBM = sqlsrv_fetch_array($execFileLabaRugiBM);
                                        
                                        if ($fileLabaRugiBM['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Laporan Laba Rugi <?= $fileLabaRugiBM['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileLabaRugiBM['TIPE_FILE_UP'], $fileLabaRugiBM['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileNeracaBM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileNeracaBM = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('BM', SQLSRV_PARAM_IN),
                                            array('Bukti Neraca', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileNeracaBM = sqlsrv_query($conn, $callFileNeracaBM, $paramFileNeracaBM) or die(print_r(sqlsrv_errors(), true));
                                        $fileNeracaBM = sqlsrv_fetch_array($execFileNeracaBM);
                                        
                                        if ($fileNeracaBM['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Neraca <?= $fileNeracaBM['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileNeracaBM['TIPE_FILE_UP'], $fileNeracaBM['DATA_FILE_UP']) ?></td>
                                             </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileNeracaAM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileNeracaAM = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('AM', SQLSRV_PARAM_IN),
                                            array('Bukti Neraca', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileNeracaAM = sqlsrv_query($conn, $callFileNeracaAM, $paramFileNeracaAM) or die(print_r(sqlsrv_errors(), true));
                                        $fileNeracaAM = sqlsrv_fetch_array($execFileNeracaAM);
                                        
                                        if ($fileNeracaAM['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Neraca <?= $fileNeracaAM['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileNeracaAM['TIPE_FILE_UP'], $fileNeracaAM['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php
                                        $callFileLabaRugiAM = "{call SP_RAK_CPY_GET_FILE_INFO (?, ?, ?, ?)}";
                                        $paramFileLabaRugiAM = array(
                                            array($id, SQLSRV_PARAM_IN),
                                            array('AM', SQLSRV_PARAM_IN),
                                            array('Bukti Laporan Laba Rugi', SQLSRV_PARAM_IN),
                                            array('KAPASITAS', SQLSRV_PARAM_IN),
                                        );
                                        $execFileLabaRugiAM = sqlsrv_query($conn, $callFileLabaRugiAM, $paramFileLabaRugiAM) or die(print_r(sqlsrv_errors(), true));
                                        $fileLabaRugiAM = sqlsrv_fetch_array($execFileLabaRugiAM);
                                        
                                        if ($fileLabaRugiAM['DATA_FILE_UP'] <> NULL) :
                                        ?>
                                            <tr>
                                                <td>Bukti Laporan Laba Rugi <?= $fileLabaRugiAM['JOB_CODE'] ?></td>
                                                <td><?= displayFileByBase64($fileLabaRugiAM['TIPE_FILE_UP'], $fileLabaRugiAM['DATA_FILE_UP']) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>

                            <!-- ----------------- NOMINAL INCOME INPUTAN ----------------- -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <col style="width:50%">
                                        <col style="width:50%">

                                        <?php if (isset($dataCpy['NOMINAL_INCOME_FINAL_SBH']) && $dataCpy['NOMINAL_INCOME_FINAL_SBH'] <> NULL) : ?>

                                        <tr>
                                            <td><b>NOMINAL INCOME FINAL SBH</b></td>
                                            <td>
                                                <input type="text" name="lkt_nominal_income_final_SBH" id="lkt_nominal_income_final_SBH" class="form-control" value="<?= number_format(htmlentities($dataCpy['NOMINAL_INCOME_FINAL_SBH'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>

                                        <?php endif; ?>

                                        <?php if (isset($dataCpy['NOMINAL_INCOME_FINAL_CA']) && $dataCpy['NOMINAL_INCOME_FINAL_CA'] <> NULL) : ?>

                                        <tr>
                                            <td><b>NOMINAL INCOME FINAL CA</b></td>
                                            <td>
                                                <input type="text" name="lkt_nominal_income_final_CA" id="lkt_nominal_income_final_CA" class="form-control" value="<?= number_format(htmlentities($dataCpy['NOMINAL_INCOME_FINAL_CA'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>

                                        <?php endif; ?>

                                        <?php if (isset($dataCpy['NOMINAL_INCOME_FINAL_BM']) && $dataCpy['NOMINAL_INCOME_FINAL_BM'] <> NULL) : ?>

                                        <tr>
                                            <td><b>NOMINAL INCOME FINAL BM</b></td>
                                            <td>
                                                <input type="text" name="lkt_nominal_income_final_BM" id="lkt_nominal_income_final_BM" class="form-control" value="<?= number_format(htmlentities($dataCpy['NOMINAL_INCOME_FINAL_BM'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>

                                        <?php endif; ?>

                                        <?php if (isset($dataCpy['NOMINAL_INCOME_FINAL_AM']) && $dataCpy['NOMINAL_INCOME_FINAL_AM'] <> NULL) : ?>

                                        <tr>
                                            <td><b>NOMINAL INCOME FINAL AM</b></td>
                                            <td>
                                                <input type="text" name="lkt_nominal_income_final_AM" id="lkt_nominal_income_final_AM" class="form-control" value="<?= number_format(htmlentities($dataCpy['NOMINAL_INCOME_FINAL_AM'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>

                                        <?php endif; ?>

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
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?= htmlentities($dataCpy['PROXY_INCOME'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?= htmlentities($dataCpy['STATUS_COLLECTIBILITY'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?= htmlentities($dataCpy['STATUS_LEVEL'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?= htmlentities($dataCpy['DESKRIPSI_SCORE'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td style="padding:5px;text-align:center;vertical-align:middle;"><?= htmlentities($dataCpy['SEGMENTASI'], ENT_QUOTES, 'UTF-8'); ?></td>
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
                                                <input type="text" name="hke_TDP" id="hke_TDP" class="form-control" value="<?= number_format(htmlentities($dataCpy['TDP'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>MIN TDP</td>
                                            <td>
                                                <input type="text" name="hke_min_TDP" id="hke_min_TDP" class="form-control" value="<?= number_format(htmlentities($dataCpy['MIN_TDP'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>LEVEL APPROVAL</td>
                                            <td>
                                                <input type="text" name="hke_level_approval" id="hke_level_approval" class="form-control" value="<?= htmlentities($dataCpy['LEVEL_APPROVAL'], ENT_QUOTES, 'UTF-8'); ?>" readonly>
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

                                        <tr>
                                            <td><b>ANALISA KAPASITAS BERDASARKAN REKENING TABUNGAN DENGAN INVOICE TRANSAKSI</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea disabled id="hke_analisa_kapasitas_note" name="hke_analisa_kapasitas_note" class="form-control" rows="7"><?= htmlentities($dataCpy['ANALISIS_KAPASITAS'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- *************************************** end of HISTORIKAL KREDIT EKSTERNAL *************************************** -->

                            <div class="row">
                                <!-- *************************************** SUMMARY *************************************** -->
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
                                                <td>Pendapatan Badan Hukum (Confins/MOS)</td>
                                                <td>
                                                    <input type="text" name="sum_pendapatan_badan_hukum" class="form-control" id="sum_pendapatan_badan_hukum" value="<?= number_format($pendapatanNET, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Angsuran New SFI (MOS)</td>
                                                <td>
                                                    <input type="text" class="form-control" value="<?php echo number_format($angsuranOrder, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <?php if ($dataCpy['QTY_ORDER'] > 1) : ?>

                                                <tr>
                                                    <td>Angsuran New SFI (MOS) Fleet <?= $dataCpy['QTY_ORDER'] ?> Unit</td>
                                                    <td>
                                                        <input type="text" class="form-control" value="<?php echo number_format($angsuranOrderNewSFI, 0, ',', '.'); ?>" readonly>
                                                    </td>
                                                </tr>

                                            <?php endif; ?>
                                            <tr>
                                                <td>Angsuran Berjalan SFI (AO/RO by Confins)</td>
                                                <td>
                                                    <input type="text" name="sum_angsuran_berjalan_SFI" class="form-control" id="sum_angsuran_berjalan_SFI" value="<?= number_format($angsuranAO, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Kewajiban Angsuran di tempat lain</td>
                                                <td>
                                                    <input type="text" name="sum_kewajiban_angsuran_ditempat_lain" class="form-control" id="sum_kewajiban_angsuran_ditempat_lain" value="<?= number_format($angsuranLain, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Kewajiban</td>
                                                <td>
                                                    <input type="text" name="sum_total_kewajiban" class="form-control" id="sum_total_kewajiban" value="<?= number_format($totalKewajiban, 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Pendapatan</td>
                                                <td>
                                                    <input type="text" name="sum_total_pendapatan" class="form-control" id="sum_total_pendapatan" value="<?= number_format(htmlentities($dataCpy['TOTAL_PENDAPATAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>DSR %</td>
                                                <td>
                                                    <input type="text" name="sum_DSR_percentage" class="form-control" id="sum_DSR_percentage" value="<?= number_format(htmlentities($dataCpy['DSR'], ENT_QUOTES, 'UTF-8'), 2, ',', '.'); ?>" readonly>

                                                    <?php 
                                                    // Mengubah string menjadi nilai float
                                                    $dsrToFloat = floatval(htmlentities($dataCpy['DSR'], ENT_QUOTES, 'UTF-8'));

                                                    // Memeriksa apakah nilai lebih dari 60
                                                    if ($dsrToFloat > 60) {
                                                        echo '<label id="sum_trigger_DSR" style="color:red;background:yellow;"><b>*WARNING : DSR lebih dari 60%!</b></label>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Foto Survey</td>
                                                <td>
                                                    <a class="btn btn-warning" href="https://sfimos.sfi.co.id/mos_new/Survey_Frame/surveidetail_new/<?php echo $dataCpy['REF_NO'];?>" target="_blank">FOTO SURVEY</a>
											        <a class="btn btn-warning" href="https://sfimos.sfi.co.id/mos_new/frame/surveyor_ext_view_rak/<?php echo $dataCpy['REF_NO'];?>" target="_blank">FOTO SURVEYOR EKSTERNAL</a>
                                                </td>
                                            </tr>
                                            <?php if ($dataCpy['QTY_ORDER'] > 1) : ?>

                                            <tr>
                                                <td>Fleet Disetujui</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <select name="sum_fleet_recommended_opt" id="sum_fleet_recommended_opt" class="form-control">
                                                                <option <?php if (isset($dataCpy['REKOMENDASI_FLEET']) && $dataCpy['REKOMENDASI_FLEET'] === "") echo "selected" ?> value="">SELURUHNYA</option>
                                                                <option <?php if (isset($dataCpy['REKOMENDASI_FLEET']) && $dataCpy['REKOMENDASI_FLEET'] === "SEBAGIAN") echo "selected" ?> value="SEBAGIAN">SEBAGIAN</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div id="section_rec_fleet" class="row">
                                                        <br />

                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Total Pengajuan</td>
                                                                        <td><input type="text" name="sum_fleet_total" id="sum_fleet_total" value="<?= $dataCpy['QTY_ORDER'] ?>" class="form-control" readonly onautocomplete="off"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pengajuan disetujui</td>
                                                                        <td>
                                                                            <input type="text" name="sum_fleet_rec" id="sum_fleet_rec" class="form-control number-only" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <?php endif; ?>

                                            <input type="hidden" name="sum_angsuran_new_SFI" class="form-control" id="sum_angsuran_new_SFI" value="<?php echo number_format($angsuranOrderNewSFI, 0, ',', '.'); ?>" readonly>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- *************************************** end of SUMMARY *************************************** -->


                                <!-- *************************************** ASSET DATA *************************************** -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" style="background-color:#eb8500;color:#FFF;font-weight:bold;">ASSET DATA</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
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
                                                            <input type="text" name="rak_asset_name" id="rak_asset_name" value="<?= htmlentities($dataCpy['NAMA_KENDARAAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
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
                                                            <input type="text" name="rak_jenis_pengajuan" id="rak_jenis_pengajuan" value="<?= htmlentities($dataCpy['TIPE_PENGAJUAN'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
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
                                                            <input type="text" name="rak_ph" id="rak_ph" value="<?= number_format(htmlentities($dataCpy['PH_BERJALAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PH Add. Order</td>
                                                        <td>
                                                            <input type="text" name="rak_ph_ao" id="rak_ph_ao" value="<?= number_format(htmlentities($dataCpy['PH_AO'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>PH Akumulasi</td>
                                                        <td>
                                                            <input type="text" name="rak_ph_total" id="rak_ph_total" value="<?= number_format(htmlentities($dataCpy['PH_AKUMULASI'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Harga OTR</td>
                                                        <td>
                                                            <input type="text" name="rak_otr" id="rak_otr" value="<?= number_format(htmlentities($dataCpy['HARGA_OTR'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tenor</td>
                                                        <td>
                                                            <input type="text" name="rak_tenor" id="rak_tenor" value="<?= number_format(htmlentities($dataCpy['TENOR'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Amount TDP</td>
                                                        <td>
                                                            <input type="text" name="rak_amount_tdp" id="rak_amount_tdp" value="<?= number_format(htmlentities($dataCpy['AMOUNT_TDP'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>% TDP</td>
                                                        <td>
                                                            <input type="text" name="rak_tdp_persen" id="rak_tdp_persen" value="<?= htmlentities($dataCpy['PERSEN_TDP'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" readonly onautocomplete="off">
                                                        </td>
                                                    </tr>
                                                    <?php if ($user === $dataCpy['USER_FINAL']) : # Function Up DP - View ?>
                                                    
                                                    <tr>
                                                        <td>UP TDP*</td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <select name="rak_up_dp_stat" id="rak_up_dp_stat" class="form-control" required>
                                                                        <option <?php if (isset($dataCpy['UP_DP']) && $dataCpy['UP_DP'] === "") echo "selected" ?> value="TIDAK">TIDAK</option>
                                                                        <option <?php if (isset($dataCpy['UP_DP']) && $dataCpy['UP_DP'] === "YA") echo "selected" ?> value="YA">YA</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div id="section_up_dp" class="row">
                                                                <br />

                                                                <div class="col-md-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered">
                                                                            <tr>
                                                                                <td>%Naik TDP</td>
                                                                                <td>
                                                                                    <input type="text" name="rak_up_dp_persen" id="rak_up_dp_persen" class="form-control number-only" value="">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>OTR</td>
                                                                                <td><input type="text" name="rak_up_dp_otr" id="rak_up_dp_otr" value="<?= number_format(htmlentities($dataCpy['HARGA_OTR'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Amount TDP</td>
                                                                                <td><input type="text" name="rak_up_dp_amt" id="rak_up_dp_amt" class="form-control" value="" readonly></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" style="text-align: right;">
                                                                                    <button type="button" name="btn_cal_up_DP" id="btn_cal_up_DP" class="btn btn-custom">Calculate</button>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <?php endif; ?>

                                                    <input type="hidden" name="rak_angsuran" id="rak_angsuran" value="<?= number_format(htmlentities($dataCpy['ANGSURAN'], ENT_QUOTES, 'UTF-8'), 0, ',', '.'); ?>" class="form-control" readonly onautocomplete="off">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- *************************************** end of ASSET DATA *************************************** -->
                            </div>
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
									data-orderno="<?= isset($dataCpy['REF_NO']) ? htmlspecialchars($dataCpy['REF_NO']) : '' ?>"
									>
									Loading phone verification... 
								</div>
                            <!-- # *************************************** end of PHONE VERIF*************************************** # -->
                        </div>
	
	<script>
	$(function () {
		$('a[href="#phone_verif"]').one('shown.bs.tab', function () {
			const container = $('#phone-verif-container');
			container
				.html('<div class="text-muted">Loading phone verification...</div>')
				.load('view-only-phone-verification.php', {
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

			var orderNoInput = document.querySelector('input[name="order_no"]');
			if (!orderNoInput || !orderNoInput.value) return;

			fetch('check_phone_verif_exist.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: 'order_no=' + encodeURIComponent(orderNoInput.value)
			})
			.then(function (r) { return r.json(); })
			.then(function (res) {

				document.getElementById('done_phone_verif').value = res.exist ? 1 : 0;

			})
			.catch(function () {});
		});

	});
	</script>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tb_list_apv" style="font-size:12px;">
                                    <thead>
                                        <tr>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">NO</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">APPROVAL NO</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">LEVEL</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">JABATAN</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">USERNAME</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">STATUS</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">NOTES</th>
                                            <th style="background-color:#035c7a;color:#FFF;font-weight:bold;text-align:center;">TANGGAL APPROVE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $callLoa = "{call SP_APPROVAL_GETLIST_LOA_RAK(?)}";
                                        $paramLoa = array(array($apv_no, SQLSRV_PARAM_IN));
                                        $execLoa = sqlsrv_query($conn, $callLoa, $paramLoa) or die(print_r(sqlsrv_errors(), true));
                                        while ($dataLoa = sqlsrv_fetch_array($execLoa)) :
                                            $no++;
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $no; ?></td>
                                                <td style="text-align: center;"><?php echo $dataLoa['APV_NO'] ?></td>
                                                <td style="text-align: center;"><?php echo $dataLoa['LEVEL'] ?></td>
                                                <td style="text-align: center;"><?php echo $dataLoa['ROLE_CODE'] ?></td>
                                                <td><?php echo $dataLoa['USERNAME'] ?></td>
                                                <td><?php echo $dataLoa['STATUS'] ?></td>
                                                <td><?php echo $dataLoa['NOTES']; ?></td>
                                                <td style="text-align: center;"><?php if ($dataLoa['UPDATE_DATE'] <> NULL) {
                                                                            echo $dataLoa['UPDATE_DATE']->format('Y-m-d H:i:s');
                                                                        } else {
                                                                            echo "-";
                                                                        } ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
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
</script>


<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').prop('disabled', true);
        $('select').prop('disabled', true);
        $('#apv_reject_reason').prop('disabled', false);
        $('#rak_up_dp_stat').prop('disabled', false);
        $('#sum_fleet_recommended_opt').prop('disabled', false);

        // jika apv final, tambahkan validasi pada not rec
        <?php if ($user === $dataCpy['USER_FINAL']) : ?>

            // -- Validasi Reject Reason
            $('#submit_RAK_notrec').on('click', function() {
                if ($('#apv_reject_reason').val() === '') {
                    alert('Harap Isi Reject Reason');
                    return false; // Prevent form submission
                }
            });
            // -- End of Validasi Reject Reason

            // -- Up DP
            $('#btn_cal_up_DP').on('click', calculate_up_DP);

            const rak_up_dp_stat = $('#rak_up_dp_stat');
            const rak_up_dp_persen = $('#rak_up_dp_persen');
            const section_up_dp = $('#section_up_dp');
            section_up_dp.hide();

            rak_up_dp_stat.change(function() {
                var selectedValue = $(this).val();
                console.log(selectedValue);
                
                if (selectedValue === "YA") {
                    section_up_dp.show();
                    rak_up_dp_persen.prop('required', true);
                } else {
                    section_up_dp.hide();
                    rak_up_dp_persen.prop('required', false);
                }
            });

            rak_up_dp_persen.on('input', function(){
                var sourceText = $(this).val();
                
                if (sourceText !== '') {
                    calculate_up_DP();
                }
            });
            // -- End of Up DP

        <?php endif; ?>


        <?php if ($dataCpy['QTY_ORDER'] > 1) : ?>

        // -- Fleet Rekomendasi
        const section_rec_fleet = $('#section_rec_fleet');
        const sum_fleet_recommended_opt = $('#sum_fleet_recommended_opt');
        const sum_fleet_rec = $('#sum_fleet_rec');
        const sum_fleet_total = $('#sum_fleet_total');
        section_rec_fleet.hide();

        sum_fleet_recommended_opt.change(function() {
            var selectedValue = $(this).val();
            
            if (selectedValue === "SEBAGIAN") {
                section_rec_fleet.show();
                sum_fleet_rec.prop('required', true);
            } else {
                section_rec_fleet.hide();
                sum_fleet_rec.prop('required', false);
            }
        });

        sum_fleet_rec.on('input', function(){
            var sourceText = $(this).val();

            const totalFleet = sum_fleet_total.val().replace(/[^\d]/g, '');
            const totalDirekomendasikan = sourceText.replace(/[^\d]/g, '');
            
            if (totalDirekomendasikan >= totalFleet) {
                alert('Rekomendasi Fleet tidak boleh sama atau lebih besar dari pengajuan awal!');
                
                // Larang karakter lainnya
                e.preventDefault();
            }
        });
        // -- End of Fleet Rekomendasi

        <?php endif; ?>

        // loadAjax();
    });

    function calculate_up_DP() {
        const rak_up_dp_persen = $('#rak_up_dp_persen');
        const upDpPersen = rak_up_dp_persen.val().replace(/[^\d]/g, '');
        const upDpOtr = $('#rak_up_dp_otr').val().replace(/[^\d]/g, '');
        const rak_up_dp_amt = $('#rak_up_dp_amt');

        if (upDpPersen === '')
        {
            alert('[%Naik TDP] tidak boleh kosong!');
        }
        else if (upDpPersen >= 100)
        {
            // Hapus karakter terakhir
            rak_up_dp_persen.val(upDpPersen.slice(0, -1));
            
            alert('[%Naik TDP] tidak boleh 100% atau lebih!');
        }
        else
        {
            // konversi 
            let fUpDpPersen = parseFloat($('#rak_up_dp_persen').val()); // Mengonversi nilai input menjadi angka desimal

            const upDpAmt = (upDpOtr * fUpDpPersen) / 100;
            const upDpAmtRp = upDpAmt.toString().replace('.', ',');

            rak_up_dp_amt.val(formatRupiah(upDpAmtRp));
        }
    }
</script>

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
      $("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close' style='margin:5px;'><button class='btn btn-danger btn-sm btn-fill'><i class='fa fa-times'></i></button></a>&nbsp;&nbsp;&nbsp;<a class='lb-rotate' style='margin:5px;'><button class='btn btn-primary btn-sm btn-fill' style='margib-right:5px;'><i class='fa fa-undo'></i></button></a></div></div></div></div>").appendTo($('body'));
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
        
            $($cont).rotate({ animateTo:value});
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const url_fasilitas_company = `view-rak-company-fasilitas-badan-hukum.php?no_trx=<?= $dataCpy['REF_NO'] ?>&npwp_perusahaan=<?= $dataCpy['NO_NPWP_BAHUK'] ?>&nama_perusahaan=<?= $dataCpy['NAMA_PERUSAHAAN'] ?>`;
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
</script>