<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

require_once("config/configuration.php");
require_once("config/connection.php");

// Ambil user & periode
$user_raw = isset($_GET['USERNAME']) ? $_GET['USERNAME'] : 'guest';
$user = strtoupper(trim($user_raw));

$is_rizki_note_only = ($user === 'RIZKI.HILMI');

// === USER YANG BOLEH SUBMIT AFA ===
$allow_submit_afa_users = ['KIKI.AMALIA', 'AHMAD.HABIBI'];
$is_allowed_submit_afa  = in_array($user, $allow_submit_afa_users);


$periode = null;
if (isset($_GET['periode']) && $_GET['periode'] !== '') {
    $periode = $_GET['periode'];
} elseif (isset($_POST['periode']) && $_POST['periode'] !== '') {
    $periode = $_POST['periode'];
}

// Data Informasi Dashboard
$data_informasi = [];
if ($periode) {
    $params = [[$periode, SQLSRV_PARAM_IN]];
    $sql = "EXEC SP_DASHBOARD_PELAPORAN_SLIK @periode = ?";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error SP_DASHBOARD_PELAPORAN_SLIK: " . print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $hasil = isset($row['HASIL']) ? $row['HASIL'] : 0;
        $data_informasi[] = [$row['INFORMASI'], $hasil];
    }
    sqlsrv_free_stmt($stmt);
}

// --- CEK DIVISI IT ---
$is_it_division = false;
$sql_div = "SELECT TOP 1 DIVISI
            FROM H2H_PEFINDO.dbo.M_MENU_USER_ACCESS
            WHERE USERNAME = ?
              AND MENU_ID = 26
              AND IS_ACTIVE = 1";
$stmt_div = sqlsrv_query($conn, $sql_div, [$user]);
if ($stmt_div && ($row_div = sqlsrv_fetch_array($stmt_div, SQLSRV_FETCH_ASSOC))) {
    $divisi_user = strtoupper(trim((string)$row_div['DIVISI']));
    if ($divisi_user === 'DIVISI INFORMATION TECHNOLOGY') {
        $is_it_division = true;
    }
}
if ($stmt_div) sqlsrv_free_stmt($stmt_div);

// --- CEK AKSES USER ---
$is_allowed = 0;
$is_can_action = 0;
$active_username = null;
$params = [
    ['CHECK_ACCESS', SQLSRV_PARAM_IN],
    [$user, SQLSRV_PARAM_IN],
    [$periode, SQLSRV_PARAM_IN]
];
$sql = "EXEC SP_CHECK_USER_ACCESS_PELAPORAN_SLIK 
        @action = ?, 
        @username = ?, 
        @periode = ?";
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt && ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
    $is_allowed      = (int)$row['is_allowed'];
    $is_can_action   = (int)$row['is_can_action'];
    $active_username = $row['active_username'];
}
if ($stmt) sqlsrv_free_stmt($stmt);
// IT boleh tetap override
if ($is_it_division) {
    $is_allowed = 1;
    $is_can_action = 0;
}

// RIZKI.HILMI - NOTE ONLY
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['rizki_note_only'])
    && $is_rizki_note_only
    && $periode
) {
    $note = isset($_POST['note']) ? trim((string)$_POST['note']) : '';

    if ($note === '') {
        die("Error: Note tidak boleh kosong.");
    }

    $params = array(
        array('INSERT_NOTE_ONLY', SQLSRV_PARAM_IN),
        array($user, SQLSRV_PARAM_IN),
        array($periode, SQLSRV_PARAM_IN),
        array($note, SQLSRV_PARAM_IN),
    );

    $sql = "EXEC SP_CHECK_USER_ACCESS_PELAPORAN_SLIK
            @action = ?,
            @username = ?,
            @periode = ?,
            @note = ?";

    $stmt = sqlsrv_query($conn, $sql, $params);

    if (!$stmt) {
        die("Error insert note only: " . print_r(sqlsrv_errors(), true));
    }
    sqlsrv_free_stmt($stmt);

    // cegah double submit saat refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Handle submit form
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['submit_status'])
    && $is_allowed
    && $is_can_action
) {
    $note        = $_POST['note'];
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;
    $submit_status = $_POST['submit_status'];

    $params = [
        ['INSERT', SQLSRV_PARAM_IN],
        [$user, SQLSRV_PARAM_IN],
        [$periode, SQLSRV_PARAM_IN],
        [$note, SQLSRV_PARAM_IN],
        [$is_verified, SQLSRV_PARAM_IN],
        [$submit_status, SQLSRV_PARAM_IN]
    ];

    $sql = "EXEC SP_CHECK_USER_ACCESS_PELAPORAN_SLIK 
                @action = ?, 
                @username = ?, 
                @periode = ?, 
                @note = ?, 
                @is_verified = ?, 
                @submit_status = ?";

    $stmt = sqlsrv_query($conn, $sql, $params);

    if (!$stmt) {
        die("Error submit: " . print_r(sqlsrv_errors(), true));
    }
    sqlsrv_free_stmt($stmt);
}

// list PIC
$data_pic = [];
$sql = "EXEC SP_CHECK_USER_ACCESS_PELAPORAN_SLIK @action = 'GET_LIST', @periode = ?";
$stmt = sqlsrv_query($conn, $sql, [[$periode, SQLSRV_PARAM_IN]]);
if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data_pic[] = $row;
    }
    sqlsrv_free_stmt($stmt);
}

$data_history = [];

$sql = "
    SELECT
        USERNAME,
        ACTION_TYPE,
        NOTE,
        CONVERT(VARCHAR, CREATED_DATE, 120) AS CREATED_DATE
    FROM dbo.PIC_PELAPORAN_SLIK_LOA_HISTORY
    WHERE PERIODE = ?
    ORDER BY CREATED_DATE ASC
";

$stmt = sqlsrv_query($conn, $sql, [$periode]);
if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $data_history[] = $row;
    }
    sqlsrv_free_stmt($stmt);
}

// Cek status submit dari log_validasi_pelaporan_slik
$is_all_valid = null;

if ($periode) {
    $sql = "SELECT TOP 1 hasil_validasi
            FROM H2H_PEFINDO.dbo.log_validasi_pelaporan_slik
            WHERE Periode = ? AND RuleName = 'STATUS_SUBMIT'
            ORDER BY CreatedDate DESC";

    $stmt = sqlsrv_query($conn, $sql, [$periode]);
    if ($stmt && $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $status_text = trim(strtoupper($row['hasil_validasi']));
        $is_all_valid = ($status_text === 'ENABLE');

        if ($is_all_valid) {
            echo "<div class='alert alert-success-soft'>
                ✅ Status validasi <strong>TRUE</strong> untuk periode $periode
            </div>";
        } else {
            echo "<div class='alert alert-danger-soft'>
                ❌ Status validasi <strong>FALSE</strong> untuk periode $periode
            </div>";
        }
    } else {
        echo "<div class='alert alert-warning-soft'>
            ⚠️ Belum Dilakukan Validasi Data untuk periode $periode
        </div>";
    }
    sqlsrv_free_stmt($stmt);
}

// Handle Validasi Ulang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['revalidate']) && $periode) {
    echo "<div id='loadingAlert' class='alert alert-info-soft' style='color:#000;'>
        ⏳ <strong>Proses validasi ulang sedang dijalankan...</strong> Mohon tunggu beberapa saat.
    </div>";
    flush();
    ob_flush();

    // --- ambil daftar rule yang masih FALSE ---
    $sql_false = "SELECT RuleName 
                  FROM H2H_PEFINDO.dbo.log_validasi_pelaporan_slik 
                  WHERE Periode = ? AND hasil_validasi = 'FALSE'";
    $stmt_false = sqlsrv_query($conn, $sql_false, [$periode]);

    $rules_false = [];
    if ($stmt_false) {
        while ($r = sqlsrv_fetch_array($stmt_false, SQLSRV_FETCH_ASSOC)) {
            $rules_false[] = $r['RuleName'];
        }
        sqlsrv_free_stmt($stmt_false);
    }
    if (!empty($rules_false)) {
        $total   = count($rules_false);
        $success = 0;
        $failed  = 0;

        // tampilkan daftar rule yang masih FALSE
        echo "<div class='alert alert-warning-soft' style='color:#000;'>
            ⚠️ <strong>Ditemukan $total rules yang masih FALSE:</strong>
            <ul style='font-size:12px;color:#b02a37;margin-top:6px;'>";
        foreach ($rules_false as $rname) {
            echo "<li>$rname</li>";
        }
        echo "</ul>
        </div>";
        flush();
        ob_flush();

        // proses validasi ulang per rule
        foreach ($rules_false as $rule_name) {
            $params = [
                [$periode, SQLSRV_PARAM_IN],
                [$rule_name, SQLSRV_PARAM_IN]
            ];
            $sql = "EXEC SP_VALIDASI_SUBMIT_PELAPORAN_SLIK @periode = ?, @rule_name = ?";
            $stmt = sqlsrv_query($conn, $sql, $params, ["QueryTimeout" => 300]);

            if ($stmt) {
                sqlsrv_free_stmt($stmt);
                $success++;
            } else {
                $failed++;
            }
        }
        echo "<div id='resultAlert' class='alert alert-success-soft' style='color:#000;'>
            🎯 <strong>Validasi ulang selesai.</strong><br>
            ✅ <strong>$success</strong> rule berhasil divalidasi ulang<br>
            ❌ <strong>$failed</strong> rule gagal divalidasi ulang<br>
            <button class='btn btn-outline-success btn-sm mt-2' onclick='window.location.reload()'>
                🔄 Refresh Status Sekarang
            </button>
        </div>";
    } else {
        echo "<div id='resultAlert' class='alert alert-success-soft' style='color:#000;'>
               ✅ Semua rule sudah TRUE, tidak perlu divalidasi ulang.
           </div>";
    }

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var loading = document.getElementById('loadingAlert');
            if (loading) {
                setTimeout(() => loading.remove(), 300); // hapus setelah hasil muncul
            }
        });
    </script>";
}

// SUBMIT AFA
// pastikan periode ada
if (!isset($periode) || $periode === null) {
    $periode = '';
}

// === CEK APAKAH SEMUA PIC LOA SUDAH SUBMIT ===
$is_all_pic_submit = false;

$sql_check = "
    SELECT 
        COUNT(DISTINCT L.USERNAME) AS total_submit,
        (
            SELECT COUNT(*)
            FROM H2H_PEFINDO.dbo.M_MENU_USER_ACCESS
            WHERE MENU_ID = 26
              AND IS_ACTIVE = 1
              AND USERNAME IN (
                    'KIKI.AMALIA',
                    'AHMAD.HABIBI',
                    'DJOKO.ANDREW',
                    'FERRY.LAYARDA',
                    'PUTU.ARYAN'
              )
        ) AS total_pic
    FROM dbo.PIC_PELAPORAN_SLIK_LOG L
    WHERE L.SUBMIT_STATUS = 'SUBMIT'
      AND L.PERIODE = ?
      AND L.USERNAME IN (
            'KIKI.AMALIA',
            'AHMAD.HABIBI',
            'DJOKO.ANDREW',
            'FERRY.LAYARDA',
            'PUTU.ARYAN'
      )
";

$stmt_check = sqlsrv_query($conn, $sql_check, [$periode]);
if ($stmt_check && ($row = sqlsrv_fetch_array($stmt_check, SQLSRV_FETCH_ASSOC))) {
    $is_all_pic_submit = ((int)$row['total_submit'] === (int)$row['total_pic']);
}
if ($stmt_check) {
    sqlsrv_free_stmt($stmt_check);
}

// === CEK APAKAH ADA AFA YANG SUDAH BERJALAN === SFISVRDBAPPLS-train DB_AFA, SFISVRDBAPPLS-prod DB_AFA
/* CEK AFA FINAL (APPROVE = FINAL) */
$is_afa_final = false;
$afa_final_status = null;

$sql_afa_final = "
    SELECT TOP 1 h.FINAL_STATUS
    FROM [SFISVRDBAPPLS].DB_AFA.dbo.TR_AFA_H h
    JOIN [SFISVRDBAPPLS].DB_AFA.dbo.TR_AFA_SLIK s
        ON h.TR_AFA_H_ID = s.TR_AFA_H_ID
    WHERE s.TRX_NO = ?
      AND h.FINAL_STATUS = 'APPROVE'
    ORDER BY h.CRT_DATE DESC
";

$stmt_final = sqlsrv_query($conn, $sql_afa_final, [$periode]);
if ($stmt_final && ($row = sqlsrv_fetch_array($stmt_final, SQLSRV_FETCH_ASSOC))) {
    $is_afa_final = true;
    $afa_final_status = 'APPROVE';
}
if ($stmt_final) {
    sqlsrv_free_stmt($stmt_final);
}

/* CEK AFA SEDANG BERJALAN */
$is_afa_running = false;

$sql_afa_running = "
    SELECT COUNT(*) AS jml
    FROM [SFISVRDBAPPLS].DB_AFA.dbo.TR_AFA_H h
    JOIN [SFISVRDBAPPLS].DB_AFA.dbo.TR_AFA_SLIK s 
        ON h.TR_AFA_H_ID = s.TR_AFA_H_ID
    WHERE s.TRX_NO = ?
      AND h.FINAL_STATUS IN ('ON PROGRESS','WAITING APPROVAL')
";

$stmt_run = sqlsrv_query($conn, $sql_afa_running, [$periode]);
if ($stmt_run && ($row = sqlsrv_fetch_array($stmt_run, SQLSRV_FETCH_ASSOC))) {
    $is_afa_running = ((int)$row['jml'] > 0);
}
if ($stmt_run) {
    sqlsrv_free_stmt($stmt_run);
}

/* APPROVE = FINAL = TIDAK BOLEH SUBMIT LAGI */
if ($is_afa_final) {
    $is_afa_running = true;
}
?>

<style>
    .card .content {
        padding: 20px 25px;
    }

    .alert-success-soft {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger-soft {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-warning-soft {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .table th {
        text-align: center;
        background-color: #035c7a;
        color: #FFF !important;
    }

    .table td,
    .table th {
        padding-left: 7px;
        padding-right: 7px;
        vertical-align: middle;
    }

    .td-center {
        text-align: center;
    }

    .table td.text-right {
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .split {
        display: flex;
        height: 100%;
        gap: 0;
        position: relative;
    }

    .split .left {
        flex: 1;
        overflow: auto;
    }

    .split .right {
        width: 400px;
        min-width: 250px;
        max-width: 600px;
        overflow: auto;
    }

    .divider {
        width: 5px;
        background: #ccc;
        cursor: col-resize;
        z-index: 10;
    }

    .divider:hover {
        background: #999;
    }

    .no-select {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .status-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
    }

    .status-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
        display: inline-block;
    }

    .swal2-popup.swal2-popup-lg {
        font-size: 16px !important;
        width: 450px !important;
        padding: 2em !important;
    }

    .swal2-title.swal2-title-lg {
        font-size: 22px !important;
        font-weight: 600 !important;
    }

    .swal2-actions .btn {
        padding: 6px 16px !important;
        font-size: 14px !important;
    }
</style>

<div class="split">
    <!-- Panel kiri -->
    <div class="left">
        <div class="card">
            <div class="header">
                <h4 class="title">Dashboard Control Pelaporan SLIK</h4>
                <p class="category">PT. Suzuki Finance Indonesia</p>
            </div>
            <div class="content">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:5%">NO</th>
                            <th style="width:75%">INFORMASI</th>
                            <th style="width:20%">HASIL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data_informasi)): ?>
                            <?php $no = 1;
                            foreach ($data_informasi as $row): ?>
                                <tr>
                                    <td class="td-center"><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row[0]); ?></td>
                                    <td class="td-center">
                                        <?php if ($row[0] === 'Data Silaras'): ?>
                                            <?php if ($row[1] == 1): ?>
                                                <span class="status-success">Sudah ada</span>
                                            <?php else: ?>
                                                <span class="status-danger">Belum ada</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?= number_format($row[1]); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="td-center">Data tidak tersedia</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-center" style="margin-top:15px;">
                    <a href="https://access.sfi.co.id/pica_v5/slik_silaras.php?period=<?= $periode ?>"
                        class="btn btn-primary btn-md"
                        style="min-width:180px;"
                        target="_blank">
                        CEK DETAIL
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="divider" id="divider"></div>

    <!-- Panel kanan -->
    <div class="right" id="rightPanel">
        <div class="card">
            <div class="header">
                <h4 class="title">PIC Control Pelaporan SLIK</h4>
            </div>
            <div class="content">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>PIC NAME</th>
                            <th>APPROVAL ROLE CODE</th>
                            <th>TANGGAL</th>
                            <th>NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data_pic as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['PIC_NAME']); ?></td>
                                <td><?= htmlspecialchars($row['APPROVAL_ROLE_CODE']); ?></td>
                                <td><?= htmlspecialchars($row['TANGGAL']); ?></td>
                                <td><?= htmlspecialchars($row['NOTE']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($is_rizki_note_only): ?>
                    <form method="POST" style="margin-bottom:15px;">
                        <input type="hidden" name="periode" value="<?php echo htmlspecialchars($periode); ?>">
                        <input type="hidden" name="rizki_note_only" value="1">
                        <div class="form-group">
                            <label>CATATAN PERUBAHAN DATA SLIK (IT ONLY):</label>
                            <textarea class="form-control" name="note" rows="3" required
                                placeholder="Tuliskan perubahan / penyesuaian data laporan SLIK..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">
                            SIMPAN NOTE
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($is_allowed): ?>
                    <form method="POST">
                        <input type="hidden" name="periode" value="<?php echo htmlspecialchars($periode); ?>">
                        <?php if ($is_it_division): ?>
                            <!-- USER IT -->
                            <?php if ($is_all_valid !== null): ?>
                                <button type="submit" name="revalidate" value="1"
                                    class="btn btn-warning btn-sm">
                                    🔄 VALIDASI ULANG (FALSE ONLY)
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- USER NON IT / IDEB -->
                            <div class="form-group">
                                <label>YOUR NOTE :</label>
                                <textarea class="form-control" name="note" rows="3" required></textarea>
                            </div>

                            <!-- Tombol Submit AFA -->
                            <div class="form-group mb-3">
                                <button type="button" id="btnSubmitAFA" class="btn btn-success btn-sm"
                                    <?= ($is_all_pic_submit && !$is_afa_running && $is_allowed_submit_afa) ? '' : 'disabled'; ?>>
                                    SUBMIT AFA
                                </button>

                                <?php if ($is_afa_final): ?>
                                    <p class="mt-2 mb-0" style="color:#000000;">
                                        🔒 <b>AFA periode ini sudah FINAL (<?= $afa_final_status ?>)</b>.
                                        Pengajuan AFA tidak dapat dilakukan kembali.
                                    </p>

                                <?php elseif ($is_afa_running): ?>
                                    <p class="mt-2 mb-0" style="color:#000000;">
                                        ⚠️ AFA periode ini sedang berjalan / menunggu approval.
                                    </p>

                                <?php elseif (!$is_all_pic_submit): ?>
                                    <p class="mt-2 mb-0" style="color:#000000;">
                                        ⏳ Menunggu semua PIC melakukan SUBMIT laporan.
                                    </p>

                                <?php elseif (!$is_allowed_submit_afa): ?>
                                    <p class="mt-2 mb-0" style="color:#000000;">
                                        🔒 Submit AFA dilakukan oleh <b>KIKI.AMALIA</b> atau <b>AHMAD.HABIBI</b>.
                                    </p>

                                <?php else: ?>
                                    <p class="mt-2 mb-0" style="color:#000000;">
                                        ✅ Siap untuk push ke AFA.
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="submit_status" value="SUBMIT"
                                    class="btn btn-primary btn-sm"
                                    <?php echo ($is_can_action && $is_all_valid) ? '' : 'disabled'; ?>>
                                    SUBMIT
                                </button>

                                <button type="submit" name="submit_status" value="NOT SUBMIT"
                                    class="btn btn-danger btn-sm"
                                    <?php echo $is_can_action ? '' : 'disabled'; ?>>
                                    NOT SUBMIT
                                </button>
                            </div>

                        <?php endif; ?>
                    </form>

                <?php else: ?>
                    <div class="alert alert-warning">
                        Anda tidak memiliki akses untuk melakukan submit laporan.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="card" style="margin-top:20px;">
    <div class="header">
        <h4 class="title">History LOA Pelaporan SLIK</h4>
        <p class="category">Riwayat aktivitas approval & catatan user</p>
    </div>
    <div class="content">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:5%">NO</th>
                    <th style="width:15%">PIC NAME</th>
                    <th style="width:15%">ACTION</th>
                    <th style="width:45%">NOTE</th>
                    <th style="width:20%">WAKTU</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data_history)): ?>
                    <?php $no = 1;
                    foreach ($data_history as $h): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($h['USERNAME']); ?></td>
                            <td>
                                <?php if ($h['ACTION_TYPE'] === 'SUBMIT'): ?>
                                    <span class="badge bg-success">SUBMIT</span>
                                <?php elseif ($h['ACTION_TYPE'] === 'NOT SUBMIT'): ?>
                                    <span class="badge bg-danger">NOT SUBMIT</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">REPORT</span>
                                <?php endif; ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($h['NOTE'])); ?></td>
                            <td><?= htmlspecialchars($h['CREATED_DATE']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada history LOA untuk periode ini
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const divider = document.getElementById("divider");
        const rightPanel = document.getElementById("rightPanel");
        const container = document.querySelector(".split");
        let isResizing = false;
        // load width terakhir dari localStorage
        const savedWidth = localStorage.getItem("rightPanelWidth");
        if (savedWidth) {
            rightPanel.style.width = savedWidth + "px";
        }
        divider.addEventListener("mousedown", e => {
            isResizing = true;
            document.body.style.cursor = "col-resize";
            document.body.classList.add("no-select");
            e.preventDefault();
        });
        document.addEventListener("mousemove", e => {
            if (!isResizing || !container) return;
            const containerWidth = container.offsetWidth;
            const newWidth = containerWidth - e.clientX;
            const minWidth = 250;
            const maxWidth = 600;
            if (newWidth >= minWidth && newWidth <= maxWidth) {
                rightPanel.style.width = newWidth + "px";
                localStorage.setItem("rightPanelWidth", newWidth); // simpan ukuran
            }
        });
        document.addEventListener("mouseup", () => {
            if (isResizing) {
                isResizing = false;
                document.body.style.cursor = "default";
                document.body.classList.remove("no-select");
            }
        });
        // double click divider untuk reset ke default 350px
        divider.addEventListener("dblclick", () => {
            rightPanel.style.width = "350px";
            localStorage.setItem("rightPanelWidth", 350);
        });
    });
    document.getElementById('btnSubmitAFA')?.addEventListener('click', function() {
        Swal.fire({
            title: 'Kirim ke AFA?',
            text: 'Apakah Anda yakin ingin melakukan push ke AFA untuk periode <?= $periode; ?>?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim sekarang',
            cancelButtonText: 'Batal',
            width: 450,
            padding: '2em',
            customClass: {
                popup: 'swal2-popup-lg',
                title: 'swal2-title-lg',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('task_push_afa_slik.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'periode=<?= $periode; ?>&user=<?= $user; ?>'
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            title: data.stat == 0 ? 'Berhasil!' : 'Gagal!',
                            text: data.msg,
                            icon: data.stat == 0 ? 'success' : 'error',
                            width: 450,
                            padding: '2em',
                            customClass: {
                                popup: 'swal2-popup-lg',
                                title: 'swal2-title-lg'
                            }
                        }).then(() => location.reload());
                    })
                    .catch(() => Swal.fire('Error', 'Terjadi kesalahan koneksi.', 'error'));
            }
        });
    });
</script>