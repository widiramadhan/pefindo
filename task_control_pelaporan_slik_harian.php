<?php
ini_set('max_execution_time', 0);
set_time_limit(0);

require_once("config/configuration.php");
require_once("config/connection.php");

// Ambil user & periode
$user_raw = isset($_GET['USERNAME']) ? $_GET['USERNAME'] : 'guest';
$user = strtoupper(trim($user_raw));

$periode = null;
if (isset($_GET['periode']) && $_GET['periode'] !== '') {
    $periode = $_GET['periode'];
} elseif (isset($_POST['periode']) && $_POST['periode'] !== '') {
    $periode = $_POST['periode'];
}

// Fallback Dashboard Data
$mock_dashboard = [
    ['Total Kontrak Lunas', 142],
    ['Sudah Divalidasi', 142],
    ['Belum Divalidasi', 0],
    ['Data Silaras', 1] // 1 means "Sudah ada"
];

// Call SP if exists
$data_informasi = [];
if ($periode) {
    $params = [[$periode, SQLSRV_PARAM_IN]];
    $sql = "{call SP_TASKLIST_CONTROL_PELAPORAN_SLIK_HARIAN_GROUPING(?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $hasil = isset($row['JUMLAH']) ? $row['JUMLAH'] : 0;
            $data_informasi[] = [$row['INFORMASI'], $hasil];
        }
        sqlsrv_free_stmt($stmt);
    }
}
if (empty($data_informasi)) {
    $data_informasi = $mock_dashboard;
}

// Check IT division
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



 
$data_pic = [];
if ($periode) {
    $sql = "{call SP_GET_SLIK_PIC_CONTROL_HARIAN(?)}";
    $paramPic  =  array(array($periode, SQLSRV_PARAM_IN));
    $stmt = sqlsrv_query($conn, $sql, $paramPic) or die( print_r( sqlsrv_defaults(), true)); 
    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data_pic[] = $row;
        }
        sqlsrv_free_stmt($stmt);
    }
}


// Fallback History LOA
$mock_history = [
    ['USERNAME' => 'KIKI.AMALIA', 'ACTION_TYPE' => 'SUBMIT', 'NOTE' => 'Laporan SLIK Harian periode ' . $periode . ' siap untuk dilaporkan.', 'CREATED_DATE' => '2026-07-01 10:15:30'],
    ['USERNAME' => 'AHMAD.HABIBI', 'ACTION_TYPE' => 'SUBMIT', 'NOTE' => 'Laporan validasi selesai.', 'CREATED_DATE' => '2026-07-01 10:20:45']
];

$data_history = [];
if ($periode) {
    $sql = "SELECT USERNAME, ACTION_TYPE, NOTE, CONVERT(VARCHAR, CREATED_DATE, 120) AS CREATED_DATE
            FROM dbo.PIC_PELAPORAN_SLIK_HARIAN_LOA_HISTORY
            WHERE PERIODE = ?
            ORDER BY CREATED_DATE ASC";
    $stmt = sqlsrv_query($conn, $sql, [$periode]);
    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $data_history[] = $row;
        }
        sqlsrv_free_stmt($stmt);
    }
}
if (empty($data_history)) {
    $data_history = $mock_history;
}

// Handle Form Submissions
// Handle Form Submissions  
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_status'])) {
    $note   = isset($_POST['note'])          ? trim($_POST['note'])          : '';
    $status = isset($_POST['submit_status']) ? trim($_POST['submit_status']) : '';

    $sql_sp = "{call SP_UPDATE_SLIK_PIC_CONTROL_HARIAN_TEST(?,?,?,?)}";
    $params_sp = array(array($periode, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array($status, SQLSRV_PARAM_IN), array($note, SQLSRV_PARAM_IN));
    $stmt_sp = sqlsrv_query($conn, $sql_sp, $params_sp);

    if ($stmt_sp === false) {
        $err = print_r(sqlsrv_errors(), true);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                swal('Error', 'Query gagal: " . addslashes($err) . "', 'error');
            });
        </script>";
    } else {
        $result_sp = sqlsrv_fetch_array($stmt_sp, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt_sp);

        $result_code = isset($result_sp['RESULT']) ? $result_sp['RESULT'] : 0;
        $result_msg  = isset($result_sp['MSG'])    ? $result_sp['MSG']    : '';

            if ($result_code == 1) {
            $redirect_url = 'index.php?USERNAME=' . urlencode($user_raw)
                        . '&page=task_control_pelaporan_slik_harian'
                        . '&periode=' . urlencode($periode);

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Sukses', 'Status Pelaporan berhasil diperbarui menjadi: " . htmlspecialchars($status) . "', 'success').then(function() {
                        window.location.href = '" . $redirect_url . "';
                    });
                });
            </script>";
        } else if ($result_code == -1) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Gagal', '" . addslashes($result_msg) . "', 'warning');
                });
            </script>";
        } else if ($result_code == -2) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Gagal', 'Status tidak valid.', 'warning');
                });
            </script>";
        } else if ($result_code == -3) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    swal('Gagal', 'User " . addslashes($result_msg) . "', 'error');
                });
            </script>";
        } 
    }
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

    .split {
        display: flex;
        height: 100%;
        gap: 0;
        position: relative;
    }

    .split .left {
        flex: 1;
        overflow: auto;
        padding-right: 15px;
    }

    .split .right {
        width: 400px;
        min-width: 250px;
        max-width: 600px;
        overflow: auto;
        padding-left: 15px;
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
</style>

<div class="row">
    <div class="col-md-12">
        <a href="index.php?USERNAME=<?= urlencode($user); ?>&page=task_pelaporan_slik_harian_periode" class="btn btn-default btn-sm" style="margin-bottom:15px;">
            <i class="fa fa-arrow-left"></i> Kembali ke Daftar Periode
        </a>
    </div>
</div>

<div class="split">
    <!-- Panel kiri -->
    <div class="left">
        <div class="card">
            <div class="header">
                <h4 class="title">Dashboard Control Pelaporan SLIK Harian (Periode: <?= htmlspecialchars($periode); ?>)</h4>
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
                                        <?php
                                            // Kategori yang hanya tampil angka tanpa tombol download
                                            $no_download_list = ['Data Silaras', 'Total Baki', 'Total Pokok hutang', 'Total Denda'];
                                        ?>
                                        <?php if ($row[0] === 'Data Silaras'): ?>
                                            <?php if ($row[1] == 1): ?>
                                                <span class="status-success">Sudah ada</span>
                                            <?php else: ?>
                                                <span class="status-danger">Belum ada</span>
                                            <?php endif; ?>
                                        <?php elseif (in_array($row[0], $no_download_list)): ?>
                                            <?= number_format($row[1]); ?>
                                        <?php else: ?>
                                            <?php
                                                $dl_url = 'export_detail_slik_harian.php'
                                                    . '?USERNAME=' . urlencode($user)
                                                    . '&periode='  . urlencode($periode)
                                                    . '&kategori=' . urlencode($row[0]);
                                            ?>
                                            <a href="javascript:void(0);"
                                               title="Download detail Excel: <?= htmlspecialchars($row[0]); ?>"
                                               style="text-decoration:none;"
                                               onclick="triggerExcelDownload('<?= addslashes(htmlspecialchars($dl_url)); ?>', '<?= addslashes(htmlspecialchars($row[0])); ?>')">
                                                <span style="
                                                    display:inline-flex;
                                                    align-items:center;
                                                    gap:4px;
                                                    background:#e8f4f8;
                                                    border:1px solid #b8dde9;
                                                    border-radius:4px;
                                                    padding:2px 8px;
                                                    color:#035c7a;
                                                    font-weight:600;
                                                    cursor:pointer;
                                                    transition:background 0.2s;
                                                "
                                                onmouseover="this.style.background='#cce8f4';"
                                                onmouseout="this.style.background='#e8f4f8';">
                                                    <i class="fa fa-file-excel-o" style="font-size:12px;"></i>
                                                    <?= number_format($row[1]); ?>
                                                </span>
                                            </a>
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
                <div style="margin-top: 15px; text-align: center;">
                    <a href="https://access.sfi.co.id/pica_v5/slik_harian.php?period=<?= urlencode($periode); ?>" target="_blank" class="btn btn-info btn-fill" style="padding: 10px 40px; font-size: 14px; font-weight: bold;">
                        <i class="fa fa-list"></i> Detail
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
                <h4 class="title">PIC Control Pelaporan SLIK Harian</h4>
            </div>
            <div class="content">
                <table class="table table-bordered table-striped" style="font-size:11px;">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>PIC NAME</th>
                            <th>ROLE CODE</th>
                            <th>TANGGAL</th>
                            <th>STATUS APPROVAL</th>
                            <th>NOTE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
       // Cek giliran user
$is_my_turn = false;
foreach ($data_pic as $row) {
    if (strtoupper(trim($row['PIC_NAME'])) === $user 
        && in_array($row['STATUS_APPROVAL'], array('OPEN', 'NOT APPROVE'))) {
        $is_my_turn = true;
      
    }

                            ?>
                        
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['PIC_NAME']); ?></td>
                                <td><?= htmlspecialchars($row['ROLE_CODE']); ?></td>
                                <td><?= htmlspecialchars($row['TANGGAL']); ?></td>
                                <td><?= htmlspecialchars($row['STATUS_APPROVAL']); ?></td>
                                <td><?= htmlspecialchars($row['NOTE']); ?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>

                <hr>

                <hr>
<?php if ($is_my_turn): ?>
    <form method="POST">
        <input type="hidden" name="periode" value="<?php echo htmlspecialchars($periode); ?>">
        <div class="form-group">
            <label>CATATAN ANDA :</label>
            <textarea class="form-control" name="note" rows="3" required placeholder="Tulis catatan persetujuan / penolakan..."></textarea>
        </div>
        <div class="form-group" style="display:flex; gap:10px;">
            <button type="submit" name="submit_status" value="APPROVE" class="btn btn-primary btn-sm">
                APPROVE
            </button>
            <button type="submit" name="submit_status" value="NOT APPROVE" class="btn btn-danger btn-sm">
                NOT APPROVE
            </button>
        </div>
    </form>
<?php else: ?>
    <?php
    $in_loa           = false;
    $already_approved = false;
    foreach ($data_pic as $row) {
        if (strtoupper(trim($row['PIC_NAME'])) === $user) {
            $in_loa = true;
            if ($row['STATUS_APPROVAL'] === 'APPROVE') {
                $already_approved = true;
            }
            break;
        }
    }
    ?>
    <?php if ($already_approved): ?>
        <div class="alert alert-success-soft" style="border-radius:4px; padding:10px;">
            <i class="fa fa-check-circle"></i> Anda sudah melakukan approval untuk periode ini.
        </div>
    <?php elseif ($in_loa): ?>
        <div class="alert alert-warning-soft" style="border-radius:4px; padding:10px;">
            <i class="fa fa-clock-o"></i> Menunggu approval dari PIC sebelumnya.
        </div>
    <?php else: ?>
        <div class="alert alert-danger-soft" style="border-radius:4px; padding:10px;">
            <i class="fa fa-ban"></i> Anda tidak memiliki akses approval untuk periode ini.
        </div>
    <?php endif; ?>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top:20px;">
    <div class="header">
        <h4 class="title">History LOA Pelaporan SLIK Harian</h4>
        <p class="category">Riwayat aktivitas approval & catatan user untuk periode ini</p>
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
                <?php if (!empty($data_pic)): ?>
                    <?php $no = 1;
                    foreach ($data_pic as $h): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($h['PIC_NAME']); ?></td>
                            <td>
                                <?php if ($h['STATUS_APPROVAL'] === 'APPROVE'): ?>
                                    <span class="label label-success">APPROVE</span>
                                <?php elseif ($h['STATUS_APPROVAL'] === 'NOT APPROVE'): ?>
                                    <span class="label label-danger">NOT APPROVE</span>
                                <?php else: ?>
                                    <span class="label label-warning"></span>
                                <?php endif; ?>
                            </td>
                            <td><?= nl2br(htmlspecialchars($h['NOTE'])); ?></td>
                            <td><?= htmlspecialchars($h['TANGGAL']); ?></td>
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

<!-- ===== DOWNLOAD PROGRESS OVERLAY ===== -->
<!-- Overlay diinject ke window.top.document via JS agar benar-benar di tengah layar browser -->

<!-- Hidden iframe: trigger download tanpa navigasi halaman -->
<iframe id="dlFrame" name="dlFrame" style="display:none;"></iframe>

<script>
    // CSS yang akan diinject ke top document
    var _dlCSS = [
        '#h2h-dl-overlay{display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;',
        'background:rgba(0,0,0,.55);z-index:2147483647;}',
        '#h2h-dl-overlay.show{display:block;}',
        '#h2h-dl-box{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);',
        'background:#fff;border-radius:12px;padding:36px 44px;width:380px;',
        'box-shadow:0 12px 48px rgba(0,0,0,.28);text-align:center;',
        'animation:h2hFadeIn .25s ease;}',
        '@keyframes h2hFadeIn{from{opacity:0;transform:translate(-50%,calc(-50% - 14px))}to{opacity:1;transform:translate(-50%,-50%)}}',
        '.h2h-dl-icon{font-size:40px;color:#035c7a;margin-bottom:12px;display:block;',
        'animation:h2hBounce .9s infinite alternate ease-in-out;}',
        '@keyframes h2hBounce{from{transform:translateY(0)}to{transform:translateY(-7px)}}',
        '.h2h-dl-title{font-size:16px;font-weight:700;color:#1a1a2e;margin-bottom:6px;}',
        '.h2h-dl-label{font-size:12px;color:#555;margin-bottom:20px;word-break:break-all;font-style:italic;}',
        '.h2h-dl-prog-wrap{background:#e9ecef;border-radius:20px;height:14px;overflow:hidden;margin-bottom:8px;}',
        '#h2h-dl-bar{height:100%;width:0%;border-radius:20px;',
        'background:linear-gradient(90deg,#035c7a 0%,#0899c5 50%,#035c7a 100%);background-size:200% 100%;',
        'animation:h2hShimmer 1.4s linear infinite;transition:width .35s ease;}',
        '@keyframes h2hShimmer{0%{background-position:200% center}100%{background-position:-200% center}}',
        '#h2h-dl-pct{font-size:13px;font-weight:700;color:#035c7a;margin-bottom:6px;}',
        '#h2h-dl-stat{font-size:11px;color:#888;min-height:16px;}',
        '#h2h-dl-stat.done{color:#28a745;font-weight:600;}',
        '#h2h-dl-box.completed .h2h-dl-icon{animation:none;color:#28a745;}'
    ].join('');

    // HTML overlay
    var _dlHTML = [
        '<div id="h2h-dl-overlay">',
        '  <div id="h2h-dl-box">',
        '    <span class="h2h-dl-icon"><i id="h2h-dl-icon-i" class="fa fa-file-excel-o"></i></span>',
        '    <div class="h2h-dl-title" id="h2h-dl-title">Menyiapkan File CSV...</div>',
        '    <div class="h2h-dl-label" id="h2h-dl-label">-</div>',
        '    <div class="h2h-dl-prog-wrap"><div id="h2h-dl-bar"></div></div>',
        '    <div id="h2h-dl-pct">0%</div>',
        '    <div id="h2h-dl-stat">Mengambil data dari server...</div>',
        '  </div>',
        '</div>'
    ].join('');

    var _dlInjected = false;

    function injectDlOverlay() {
        if (_dlInjected) return;
        try {
            var topDoc  = window.top.document;
            var topBody = topDoc.body || topDoc.getElementsByTagName('body')[0];
            if (!topBody) return;

            // Inject CSS ke top document
            if (!topDoc.getElementById('h2h-dl-style')) {
                var style    = topDoc.createElement('style');
                style.id     = 'h2h-dl-style';
                style.textContent = _dlCSS;
                (topDoc.head || topDoc.getElementsByTagName('head')[0]).appendChild(style);
            }

            // Inject Font Awesome jika belum ada (untuk ikon)
            if (!topDoc.getElementById('h2h-dl-fa')) {
                var existingFA = topDoc.querySelector('link[href*="font-awesome"]');
                if (!existingFA) {
                    var fa    = topDoc.createElement('link');
                    fa.id     = 'h2h-dl-fa';
                    fa.rel    = 'stylesheet';
                    fa.href   = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
                    topDoc.head.appendChild(fa);
                }
            }

            // Inject HTML overlay
            var wrapper = topDoc.createElement('div');
            wrapper.innerHTML = _dlHTML;
            topBody.appendChild(wrapper.firstChild);
            _dlInjected = true;
        } catch(e) {
            // Fallback: inject ke current document jika cross-origin
            if (!document.getElementById('h2h-dl-style')) {
                var s = document.createElement('style');
                s.id = 'h2h-dl-style';
                s.textContent = _dlCSS;
                document.head.appendChild(s);
            }
            if (!document.getElementById('h2h-dl-overlay')) {
                var w = document.createElement('div');
                w.innerHTML = _dlHTML;
                document.body.appendChild(w.firstChild);
            }
            _dlInjected = true;
        }
    }

    function getDlDoc() {
        try { return window.top.document; } catch(e) { return document; }
    }

    document.addEventListener('DOMContentLoaded', function () {
        injectDlOverlay();
    });

    var _dlTimer     = null;
    var _dlPollTimer = null;
    var _dlTimeout   = null;
    var _dlPct       = 0;
    var _dlToken     = '';

    function triggerExcelDownload(url, label) {
        clearInterval(_dlTimer);
        clearInterval(_dlPollTimer);
        clearTimeout(_dlTimeout);
        _dlPct = 0;

        // Pastikan overlay sudah diinject
        injectDlOverlay();

        var d       = getDlDoc();
        var overlay = d.getElementById('h2h-dl-overlay');
        var box     = d.getElementById('h2h-dl-box');
        var bar     = d.getElementById('h2h-dl-bar');
        var pctEl   = d.getElementById('h2h-dl-pct');
        var statEl  = d.getElementById('h2h-dl-stat');
        var titleEl = d.getElementById('h2h-dl-title');
        var iconEl  = d.getElementById('h2h-dl-icon-i');
        var labelEl = d.getElementById('h2h-dl-label');

        if (!overlay) return;

        // Reset UI
        box.classList.remove('completed');
        iconEl.className    = 'fa fa-file-excel-o';
        titleEl.textContent = 'Menyiapkan File XLSX...';
        statEl.textContent  = 'Mengambil data dari server...';
        statEl.className    = '';
        bar.style.width     = '0%';
        pctEl.textContent   = '0%';
        labelEl.textContent = label;

        overlay.classList.add('show');

        // Generate token unik & hapus cookie lama
        _dlToken = 'dl_' + Date.now() + '_' + Math.floor(Math.random() * 9999);
        deleteCookie('dl_ready_' + _dlToken);

        // Append token ke URL
        var dlUrl = url + '&dl_token=' + _dlToken;

        // Animasi progress bar: 0 → 90%
        _dlTimer = setInterval(function () {
            if (_dlPct < 90) {
                var step = Math.max(0.25, (90 - _dlPct) * 0.028);
                _dlPct   = Math.min(90, _dlPct + step);
                var p    = Math.round(_dlPct);
                bar.style.width   = p + '%';
                pctEl.textContent = p + '%';

                if (_dlPct >= 25 && _dlPct < 60) {
                    statEl.textContent = 'Memproses data...';
                } else if (_dlPct >= 60) {
                    statEl.textContent = 'Membangun file XLSX...';
                }
            }
        }, 80);

        // Trigger download via iframe
        document.getElementById('dlFrame').src = dlUrl;

        // Polling cookie setiap 500ms
        _dlPollTimer = setInterval(function () {
            if (getCookie('dl_ready_' + _dlToken) === '1') {
                clearInterval(_dlPollTimer);
                deleteCookie('dl_ready_' + _dlToken);
                finishDlProgress(bar, pctEl, statEl, titleEl, iconEl, box, overlay);
            }
        }, 500);

        // Safety timeout 90 detik
        _dlTimeout = setTimeout(function () {
            clearInterval(_dlPollTimer);
            finishDlProgress(bar, pctEl, statEl, titleEl, iconEl, box, overlay);
        }, 90000);
    }

    function finishDlProgress(bar, pctEl, statEl, titleEl, iconEl, box, overlay) {
        clearInterval(_dlTimer);
        clearTimeout(_dlTimeout);

        bar.style.width     = '100%';
        pctEl.textContent   = '100%';
        statEl.textContent  = '✔ File berhasil diunduh!';
        statEl.className    = 'done';
        titleEl.textContent = 'Download Selesai!';
        iconEl.className    = 'fa fa-check-circle';
        box.classList.add('completed');

        setTimeout(function () {
            overlay.classList.remove('show');
            box.classList.remove('completed');
        }, 1800);
    }

    function getCookie(name) {
        var cookies = document.cookie;
        try { cookies = window.top.document.cookie; } catch(e) {}
        var match = cookies.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? decodeURIComponent(match[2]) : null;
    }

    function deleteCookie(name) {
        var exp = '; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = name + '=' + exp;
        try { window.top.document.cookie = name + '=' + exp; } catch(e) {}
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const divider = document.getElementById("divider");
        const rightPanel = document.getElementById("rightPanel");
        const container = document.querySelector(".split");
        let isResizing = false;

        const savedWidth = localStorage.getItem("rightPanelWidthHarian");
        if (savedWidth) {
            rightPanel.style.width = savedWidth + "px";
        }

        divider.addEventListener("mousedown", e => {
            isResizing = true;
            document.body.style.cursor = "col-resize";
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
                localStorage.setItem("rightPanelWidthHarian", newWidth);
            }
        });

        document.addEventListener("mouseup", () => {
            if (isResizing) {
                isResizing = false;
                document.body.style.cursor = "default";
            }
        });

        divider.addEventListener("dblclick", () => {
            rightPanel.style.width = "350px";
            localStorage.setItem("rightPanelWidthHarian", 350);
        });
    });
</script>
