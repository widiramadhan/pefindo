<?php

require_once("config/configuration.php");
require_once("config/connection.php");

// GET/SESSION USER
if (!empty($_GET['USERNAME'])) {
    $user = $_GET['USERNAME'];
} elseif (!empty($_SESSION['USERNAME'])) {
    $user = $_SESSION['USERNAME'];
} else {
    $user = 'guest';
}

$date = date("Y-m-d");

// Fallback Mock Data for UI presentation matching the mockup image precisely
$mock_data = [
    [
        'PERIOD' => '20260701',
        'is_ready' => 1,
        'is_approval_done' => 1,
        'is_downloaded' => 1,
        'is_done' => 1,
        'LAST_ACTION' => 'Download excel',
        'LAST_DATE' => '2026-07-01 10:30:15',
        'TANGGAL_KIRIM' => '2026-07-01 10:32:00',
        'BATAS_LAPOR' => '2026-07-02 17:00:00',
        'STATUS_KETERLAMBATAN' => 'Tepat Waktu',
        'HARI_KETERLAMBATAN' => 0
    ],
    [
        'PERIOD' => '20260702',
        'is_ready' => 1,
        'is_approval_done' => 1,
        'is_downloaded' => 1,
        'is_done' => 1,
        'LAST_ACTION' => 'Download excel',
        'LAST_DATE' => '2026-07-02 11:15:22',
        'TANGGAL_KIRIM' => '2026-07-02 11:20:00',
        'BATAS_LAPOR' => '2026-07-03 17:00:00',
        'STATUS_KETERLAMBATAN' => 'Tepat Waktu',
        'HARI_KETERLAMBATAN' => 0
    ],
    [
        'PERIOD' => '20260703',
        'is_ready' => 1,
        'is_approval_done' => 1,
        'is_downloaded' => 1,
        'is_done' => 1,
        'LAST_ACTION' => 'Download excel',
        'LAST_DATE' => '2026-07-03 09:45:10',
        'TANGGAL_KIRIM' => '2026-07-03 09:50:00',
        'BATAS_LAPOR' => '2026-07-04 17:00:00',
        'STATUS_KETERLAMBATAN' => 'Tepat Waktu',
        'HARI_KETERLAMBATAN' => 0
    ]
];

// --- Ambil daftar task periode harian dari SP ---
$callScore = "{call SP_TASKLIST_PELAPORAN_SLIK_HARIAN_PERIODE}";
$execScore = sqlsrv_query($conn, $callScore);

$has_db_data = false;
$rows = [];
if ($execScore !== false) {

    while ($row = sqlsrv_fetch_array($execScore, SQLSRV_FETCH_ASSOC)) {
        $rows[] = $row;
    }
    if (count($rows) > 0) {
        $has_db_data = true;
    }
}

if (!$has_db_data) {
    $rows  =$mock_data;

}

// --- Ambil jumlah data harian yg belum dilaporkan & batas lapor ---
$callDataHarian = "{call SP_TASK_PELAPORAN_SLIK_HARIAN}";
$execDataHarian = sqlsrv_query($conn, $callDataHarian);
$spHarianExists = ($execDataHarian !== false);

$earliestTglLunas = null;
$jumlahBelumLapor = 0;

if ($spHarianExists) {
    while ($rowHarian = sqlsrv_fetch_array($execDataHarian, SQLSRV_FETCH_ASSOC)) {
        $jumlahBelumLapor++;
        if (isset($rowHarian['TglLunas'])) {
            $tgl = null;
            if ($rowHarian['TglLunas'] instanceof DateTime) {
                $tgl = $rowHarian['TglLunas'];
            } else {
                $tgl = DateTime::createFromFormat('Y-m-d', $rowHarian['TglLunas']);
                if (!$tgl) {
                    try {
                        $tgl = new DateTime($rowHarian['TglLunas']);
                    } catch (Exception $e) {
                        $tgl = null;
                    }
                }
            }
            if ($tgl) {
                $formattedTgl = $tgl->format('Y-m-d');
                if ($formattedTgl !== '1900-01-01' && $formattedTgl !== '0000-00-00') {
                    if ($earliestTglLunas === null || $tgl < $earliestTglLunas) {
                        $earliestTglLunas = clone $tgl;
                    }
                }
            }
        }
    }
}

if (!function_exists('addWorkingDays')) {
    function addWorkingDays($startDate, $days) {
        $date = clone $startDate;
        $added = 0;
        while ($added < $days) {
            $date->modify('+1 day');
            $w = (int)$date->format('w'); // 0 (Sunday), 6 (Saturday)
            if ($w !== 0 && $w !== 6) {
                $added++;
            }
        }
        return $date;
    }
}

$batasLaporStr = 'Batas Lapor: -';
if ($earliestTglLunas !== null) {
    $batasLaporDate = addWorkingDays($earliestTglLunas, 3);
    $batasLaporStr = 'Batas Lapor: ' . $batasLaporDate->format('d/m/Y');
}
?>

<style>
.card .content {
    padding: 20px 25px;
}

.table td,
.table th {
    padding: 8px 6px;
    vertical-align: middle;
    font-size: 11px;
}

.th-custom {
    text-align: center;
    background-color: #035c7a;
    color: #FFF !important;
    font-weight: bold;
    border: 1px solid #024a63 !important;
}

.td-center {
    text-align: center;
}

.action-link {
    color: #035c7a;
    text-decoration: underline;
    cursor: pointer;
    font-weight: 500;
    transition: color 0.2s ease;
}

.action-link:hover {
    color: #007bff;
}

.action-link-grey {
    color: #888;
    text-decoration: line-through;
    cursor: not-allowed;
}

.stacked-links {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: center;
    justify-content: center;
}

.badge-status {
    padding: 4px 8px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 10px;
}

.badge-ontime {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.badge-late {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.check-green {
    color: #28a745;
    font-weight: bold;
    font-size: 14px;
}

.check-gray {
    color: #ccc;
    font-weight: bold;
    font-size: 14px;
}
/* Tambahan untuk Tombol Dropdown Action */
.btn-action-dropdown {
    background-color: #035c7a;
    color: #fff;
    border: none;
    padding: 4px 8px;
    font-size: 11px;
    border-radius: 3px;
    transition: background-color 0.2s;
}

.btn-action-dropdown:hover, 
.btn-action-dropdown:focus {
    background-color: #024a63;
    color: #fff;
    outline: none;
}

.dropdown-menu-custom {
    font-size: 11px;
    min-width: 130px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.dropdown-menu-custom li a {
    padding: 6px 15px;
    cursor: pointer;
}

/* Mengatasi dropdown terpotong di DataTables */
.dataTables_scrollBody {
    min-height: 200px; /* Atur angka ini agar pas dengan tinggi menu dropdown Anda */
}

</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Task Pelaporan SLIK Harian (Konsolidasi Periode)</h4>
                <p class="category">PT. Suzuki Finance Indonesia - Ringkasan Pelaporan Harian per Periode</p>
            </div>
            <div class="content">
                <!-- Header Actions -->
                <div class="header-actions" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; margin-bottom: 15px;">
                    <div class="header-actions-left" style="display: flex; align-items: center; gap: 5px;">
                        <span style="font-weight: bold; color: #d9534f; font-size: 13px;">
                            <i class="fa fa-info-circle"></i> Jumlah Data Hari Ini Belum Dilaporkan: <?= $jumlahBelumLapor; ?>
                        </span>
                    </div>
                    <div class="header-actions-right" style="display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                        <div class="row-buttons" style="padding-top: 8px;">
                            <span style="font-weight: bold; color: #035c7a; font-size: 13px;">
                                <i class="fa fa-calendar"></i> <?= htmlspecialchars($batasLaporStr); ?>
                            </span>
                        </div>
                        <div class="row-buttons" style="display: flex; gap: 5px;">
                            <button type="button" class="btn-action-dropdown" style="padding: 6px 15px;" id="btnLaporkan" onclick="laporkanData()">
                                <i class="fa fa-paper-plane"></i> Laporkan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tblSlikHarianPeriode" style="font-size:12px; width:100%;">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 3%;">No</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 10%;">Periode pelaporan harian</th>
                                    <th colspan="3" class="th-custom" style="vertical-align:middle; width: 25%;"></th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 10%;">Script</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Data Balikan</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Hasil Pelaporan</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 10%;">Aktifitas terakhir</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Approval</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Tanggal Kirim Laporan</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Tanggal batas laporan</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Laporan selesai</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 8%;">Status Keterlambatan</th>
                                    <th rowspan="2" class="th-custom" style="vertical-align:middle; width: 5%;">Jumlah Hari Keterlambatan</th>
                                </tr>
                                <tr>
                                    <th class="th-custom" style="font-size:10px; padding: 4px;">Approval</th>
                                    <th class="th-custom" style="font-size:10px; padding: 4px;">Download Txt</th>
                                    <th class="th-custom" style="font-size:10px; padding: 4px;">Download Excel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($rows as $row) {
                                    $periode = $row['PERIOD'];
                                    
                                    // Parse dates nicely
                                    $tglKirim = '-';
                                    if (!empty($row['TANGGAL_LAPOR'])) {
                                        $tglKirim = ($row['TANGGAL_LAPOR'] instanceof DateTime) ? $row['TANGGAL_LAPOR']->format('d/m/Y H:i:s') : $row['TANGGAL_LAPOR'];
                                    }
                                    
                                    $tglBatas = '-';
                                    if (!empty($row['TGL_BATAS_LAPOR'])) {
                                        $tglBatas = ($row['TGL_BATAS_LAPOR'] instanceof DateTime) ? $row['TGL_BATAS_LAPOR']->format('d/m/Y H:i:s') : $row['BATAS_LAPOR'];
                                    }

                                    $lastActionDate = '';
                                    if (!empty($row['CREATE_DATE'])) {
                                        $lastActionDate = ($row['CREATE_DATE'] instanceof DateTime) ? $row['CREATE_DATE']->format('d/m/Y H:i') : $row['CREATE_DATE'];
                                    }
                                    
                                    // Check status lapor selesai
                                    $isDone = isset($row['IS_DONE']) && $row['IS_DONE'] == 1;
                                    
                                    // Status Keterlambatan
                                    $statusLate = isset($row['STATUS_KETERLAMBATAN']) ? $row['STATUS_KETERLAMBATAN'] : '';
                                    $hariLate = isset($row['JUMLAH_HARI_KETERLAMBATAN']) ? (int)$row['JUMLAH_HARI_KETERLAMBATAN'] : 0;
                                    
                                    $lateBadge = '-';
                                    if (!empty($statusLate)) {
                                        if (stripos($statusLate, 'Terlambat') !== false || $hariLate > 0) {
                                            $lateBadge = '<span class="badge-status badge-late">Terlambat</span>';
                                        } else {
                                            $lateBadge = '<span class="badge-status badge-ontime">Tepat Waktu</span>';
                                        }
                                    }
                                ?>
                                <tr>
                                    <td class="td-center"><?= $no++; ?></td>
                                    <td class="td-center" style="font-weight: bold;"><?= htmlspecialchars($periode); ?></td>
                                    
                                    <!-- Action: Detail -->
                                    <td class="td-center">
                                        <button type="button" class="btn-action-dropdown" onclick="window.location.href='index.php?USERNAME=<?= urlencode($user); ?>&page=task_control_pelaporan_slik_harian&periode=<?= urlencode($periode); ?>'">
                                            Approval
                                        </button>
                                    </td>
                                    
                                    <!-- Action: Download Txt M-1 / M -->
                                    <td class="td-center">
                                        <div class="stacked-links">
                                            <button type="button" class="btn-action-dropdown" onclick="downloadTxtM('<?= $periode; ?>')">Download txt</button>
                                        </div>
                                    </td>
                                    
                                    <!-- Action: Download Excel -->
                                    <td class="td-center">
                                        <button type="button" class="btn-action-dropdown" onclick="downloadExcel('<?= $periode; ?>')">Download excel</button>
                                    </td>
                                    
                                    <td class="td-center">
                                    <div class="dropdown">
                                        <button class="btn-action-dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                            Script <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-custom">
                                            <li><a href="javascript:void(0)" onclick="openUploadScriptDialog('<?= $periode; ?>')">Upload Script</a></li>
                                            <li><a href="action_task_slik_harian_periode.php?action=download_script&periode=<?= urlencode($periode); ?>&USERNAME=<?= urlencode($user); ?>">Download Script</a></li>
                                        </ul>
                                    </div>
                                </td>

                                <td class="td-center">
                                    <div class="dropdown">
                                        <button class="btn-action-dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                            Balikan <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-custom">
                                            <li><a href="javascript:void(0)" onclick="openUploadBalikanDialog('<?= $periode; ?>')">Upload Balikan</a></li>
                                            <li><a href="javascript:void(0)" onclick="downloadBalikan('<?= $periode; ?>')">Download Balikan</a></li>
                                      
                                        </ul>
                                    </div>
                                </td>

                                <td class="td-center">
                                    <div class="dropdown">
                                        <button class="btn-action-dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                            Laporan <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-custom">
                                            <li><a href="javascript:void(0)" onclick="openUploadLaporanPdfDialog('<?= $periode; ?>')">Upload Laporan</a></li>
                                            <li><a href="javascript:void(0)" onclick="viewLaporanPdf('<?= $periode; ?>')">View Laporan</a></li>
                                        <input type="file" id="hidden_laporan_input" accept=".pdf" multiple style="display:none;">
                                       
                                        </ul>
                                    </div>
                                </td>
                                    
                                    <!-- Aktifitas terakhir -->
                                    <td class="td-center">
                                        <?php if (!empty($row['MODUL'])): ?>
                                            <span><?= htmlspecialchars($row['MODUL']); ?></span>
                                            <?php if (!empty($lastActionDate)): ?>
                                                <br><small class="text-muted" style="font-size: 9px;"><?= $lastActionDate; ?></small>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted" style="font-size: 10px;">Belum ada log</span>
                                        <?php endif; ?>
                                    </td>
                                        <td class="td-center"><?= htmlspecialchars($row['PIC_NAME']); ?></td>
                                    <!-- Tanggal Kirim Laporan -->
                                    <td class="td-center"><?= htmlspecialchars($tglKirim); ?></td>
                                 
                                    
                                    <!-- Tanggal batas laporan -->
                                    <td class="td-center"><?= htmlspecialchars($tglBatas); ?></td>
                                    
                                    <!-- Laporan selesai -->
                                    <td class="td-center">
                                        <?php if ($isDone): ?>
                                            <span class="check-green">✓</span>
                                        <?php else: ?>
                                            <span class="check-gray">-</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Status Keterlambatan -->
                                    <td class="td-center"><?= $lateBadge; ?></td>
                                    
                                    <!-- Jumlah Hari Keterlambatan -->
                                    <td class="td-center"><?= $hariLate > 0 ? $hariLate . ' Hari' : '-'; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
var phpUsername = "<?php echo htmlspecialchars($user); ?>";

$(document).ready(function() {
    $('#tblSlikHarianPeriode').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "scrollX": true
    });
});

// Laporkan Data
function laporkanData() {
    swal({
        title: "Konfirmasi Laporkan",
        text: "Apakah Anda yakin ingin melaporkan data SLIK harian ini?",
        icon: "warning",
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Ya, Laporkan",
                closeModal: false
            }
        }
    }).then(function(value) {
        if (!value) return;

        fetch("action_task_slik_harian.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "action=laporkan&USERNAME=" + encodeURIComponent(phpUsername)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                swal("Sukses", data.message || "Data berhasil dilaporkan.", "success")
                .then(() => { 
                    location.reload();
                });
            } else {
                swal("Informasi", data.message || "Gagal melaporkan data.", "warning");
            }
        })
        .catch(err => {
            swal("Informasi", "Fitur Laporkan belum tersedia.", "info");
        });
    });
}

// Download Txt M-1
function downloadTxtM1(periode) {
    swal({
        title: "Menyiapkan File Txt M-1...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian_periode.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=download_txt_m1&periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(phpUsername)
    })
    .then(response => {
        const contentType = response.headers.get("Content-Type");
        if (contentType && contentType.includes("application/zip")) {
            return response.blob().then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = "SLIK_HARIAN_M1_" + periode + ".zip";
                document.body.appendChild(a);
                a.click();
                a.remove();
                swal.close();
                window.URL.revokeObjectURL(url);
            });
        } else {
            return response.json().then(data => {
                swal("Informasi", data.message || "File Txt M-1 belum tersedia untuk periode " + periode, "warning");
            });
        }
    })
    .catch(err => {
        swal("Error", "Gagal mengunduh file: " + err, "error");
    });
}

// Download Txt M
function downloadTxtM(periode) {
    swal({
        title: "Menyiapkan File Txt M...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian_periode.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=download_txt_m&periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(phpUsername)
    })
    .then(response => {
        const contentType = response.headers.get("Content-Type");
        if (contentType && contentType.includes("application/zip")) {
            return response.blob().then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = "SLIK_HARIAN_M_" + periode + ".zip";
                document.body.appendChild(a);
                a.click();
                a.remove();
                swal.close();
                window.URL.revokeObjectURL(url);
            });
        } else {
            return response.json().then(data => {
                swal("Informasi", data.message || "File Txt M belum tersedia untuk periode " + periode, "warning");
            });
        }
    })
    .catch(err => {
        swal("Error", "Gagal mengunduh file: " + err, "error");
    });
}

// Download Excel
function downloadExcel(periode) {
    swal({
        title: "Menyiapkan Laporan Excel...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian_periode.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=download_excel&periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(phpUsername)
    })
    .then(res => res.json())
    .then(data => {
        swal.close();
        if (data.status === "ok") {
            window.location.href = data.download_url;
        } else {
            swal("Informasi", data.message || "Laporan Excel belum tersedia untuk periode " + periode, "warning");
        }
    })
    .catch(err => {
        swal("Error", "Gagal menyiapkan file: " + err, "error");
    });
}

// Open Script Modal (Upload & Download Script)
function openScriptModal(periode) {
    swal({
        title: "Script (Upload / Download)",
        text: "Pilih aksi untuk file script periode " + periode,
        icon: "info",
        buttons: {
            cancel: "Batal",
            download: { text: "Unduh Script", value: "download" },
            upload: { text: "Unggah Script", value: "upload" }
        }
    }).then((value) => {
        if (value === "download") {
            window.location.href = "action_task_slik_harian_periode.php?action=download_script&periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(phpUsername);
        } else if (value === "upload") {
            openUploadScriptDialog(periode);
        }
    });
}

// Upload Script Dialog
function openUploadScriptDialog(periode) {
    swal({
        title: "Upload Script",
        text: "Pilih file script (.sql / .txt / .zip) untuk periode " + periode,
        content: {
            element: "input",
            attributes: {
                type: "file",
                id: "swal_script_file",
                accept: ".sql,.txt,.zip"
            }
        },
        buttons: {
            cancel: "Batal",
            confirm: { text: "Upload", closeModal: false }
        }
    }).then((value) => {
        if (!value) return;

        var fileInput = document.getElementById("swal_script_file");
        if (!fileInput || !fileInput.files.length) {
            swal("Error", "Silakan pilih file script terlebih dahulu", "error");
            return;
        }

        var formData = new FormData();
        formData.append("action", "upload_script");
        formData.append("periode", periode);
        formData.append("USERNAME", phpUsername);
        formData.append("script_file", fileInput.files[0]);

        fetch("action_task_slik_harian_periode.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                swal("Sukses", data.message || "Script berhasil diunggah.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error", data.message || "Gagal mengunggah script.", "error");
            }
        })
        .catch(err => {
            swal("Error", "Terjadi kesalahan upload: " + err, "error");
        });
    });
}

// Open Return Modal (Data Balikan)
function openReturnModal(periode) {
    swal({
        title: "Data Balikan (Return)",
        text: "Aksi file data balikan periode " + periode,
        icon: "info",
        buttons: {
            cancel: "Batal",
            download: { text: "Download Balikan", value: "download" },
            upload: { text: "Upload Balikan", value: "upload" }
        }
    }).then((value) => {
        if (value === "download") {
            downloadBalikan(periode);
        } else if (value === "upload") {
            openUploadBalikanDialog(periode);
        }
    });
}

// Download Balikan
function downloadBalikan(periode) {
    swal({
        title: "Menyiapkan file balikan...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian_periode.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=download_balikan&periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(phpUsername)
    })
    .then(res => res.json())
    .then(data => {
        swal.close();
        if (data.status === "ok") {
            window.location.href = data.download_url;
        } else {
            swal("Informasi", data.message || "File balikan tidak ditemukan untuk periode " + periode, "warning");
        }
    })
    .catch(err => {
        swal("Error", "Gagal memeriksa file balikan: " + err, "error");
    });
}

// Upload Balikan Dialog
function openUploadBalikanDialog(periode) {
    swal({
        title: "Upload File Balikan",
        text: "Silahkan pilih file ZIP data balikan untuk periode " + periode,
        content: {
            element: "input",
            attributes: {
                type: "file",
                id: "swal_balikan_file",
                accept: ".zip"
            }
        },
        buttons: {
            cancel: "Batal",
            confirm: { text: "Upload", closeModal: false }
        }
    }).then((value) => {
        if (!value) return;

        var fileInput = document.getElementById("swal_balikan_file");
        if (!fileInput || !fileInput.files.length) {
            swal("Error", "Silakan pilih file ZIP terlebih dahulu", "error");
            return;
        }

        var formData = new FormData();
        formData.append("action", "upload_balikan");
        formData.append("periode", periode);
        formData.append("USERNAME", phpUsername);
        formData.append("balikan_file", fileInput.files[0]);

        fetch("action_task_slik_harian_periode.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                swal("Sukses", data.message || "File balikan berhasil diunggah.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error", data.message || "Gagal mengunggah file balikan.", "error");
            }
        })
        .catch(err => {
            swal("Error", "Terjadi kesalahan: " + err, "error");
        });
    });
}

// Open View Laporan Modal (Hasil Pelaporan)
function openViewLaporanModal(periode) {
    swal({
        title: "Hasil Pelaporan (View)",
        text: "Aksi hasil laporan PDF untuk periode " + periode,
        icon: "info",
        buttons: {
            cancel: "Batal",
            view: { text: "View Laporan", value: "view" },
            upload: { text: "Upload Laporan PDF", value: "upload" }
        }
    }).then((value) => {
        if (value === "view") {
            viewLaporanPdf(periode);
        } else if (value === "upload") {
            openUploadLaporanPdfDialog(periode);
        }
    });
}

// View Laporan PDF — tampilkan daftar file
function viewLaporanPdf(periode) {
    swal({
        title: "Memeriksa Laporan...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian_periode.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=check_laporan_pdf&periode=" + encodeURIComponent(periode)
    })
    .then(res => res.json())
    .then(data => {
        swal.close();
        if (data.status === "ok") {
            showPdfListModal(periode, data.files);
        } else {
            swal("Informasi", data.message || "File laporan PDF belum tersedia untuk periode " + periode, "warning");
        }
    })
    .catch(err => {
        swal("Error", "Gagal memeriksa file laporan: " + err, "error");
    });
}


// Tampilkan modal daftar PDF
function showPdfListModal(periode, files) {
    var rows = '';
    files.forEach(function(f, i) {
        rows += '<tr>' +
            '<td style="text-align:center">' + (i + 1) + '</td>' +
            '<td>' + f.file_name + '</td>' +
            '<td style="text-align:center">' + f.pic_name + '</td>' +
            '<td style="text-align:center">' + f.upload_date + '</td>' +
            '<td style="text-align:center">' +
                '<button class="btn btn-info btn-xs" onclick="openPdfViewer(' + f.id + ', \'' + f.file_name.replace(/'/g, "\\'") + '\')">' +
                    '<i class="fa fa-eye"></i> View' +
                '</button>' +
            '</td>' +
        '</tr>';
    });

    document.getElementById('pdfListPeriode').textContent = periode;
    document.getElementById('pdfListBody').innerHTML = rows;
    document.getElementById('modalPdfList').style.display = 'block';
}


// Buka viewer PDF
function openPdfViewer(id, fileName) {
    document.getElementById('modalPdfList').style.display = 'none';
    document.getElementById('pdfViewerTitle').textContent = fileName;
    document.getElementById('pdfViewerFrame').src = 'action_task_slik_harian_periode.php?action=serve_laporan_pdf&id=' + id;
    document.getElementById('modalPdfViewer').style.display = 'block';
}

function closePdfViewer() {
    document.getElementById('pdfViewerFrame').src = '';
    document.getElementById('modalPdfViewer').style.display = 'none';
}

function closePdfList() {
    document.getElementById('modalPdfList').style.display = 'none';
}

// Upload Laporan PDF — support multiple
function openUploadLaporanPdfDialog(periode) {
    swal({
        title: "Upload Laporan PDF",
        text: "Pilih satu atau lebih file PDF untuk periode " + periode,
        content: {
            element: "input",
            attributes: {
                type: "file",
                id: "swal_laporan_file",
                accept: ".pdf",
                multiple: true
            }
        },
        buttons: {
            cancel: "Batal",
            confirm: { text: "Upload", closeModal: false }
        }
    }).then((value) => {
        if (!value) return;

        var fileInput = document.getElementById("swal_laporan_file");
        if (!fileInput || !fileInput.files.length) {
            swal("Error", "Silakan pilih minimal 1 file PDF", "error");
            return;
        }

        var formData = new FormData();
        formData.append("action", "upload_laporan_pdf");
        formData.append("periode", periode);
        formData.append("USERNAME", phpUsername);

        // Append semua file
        for (var i = 0; i < fileInput.files.length; i++) {
            formData.append("laporan_file[]", fileInput.files[i]);
        }

        fetch("action_task_slik_harian_periode.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                swal("Sukses", data.message || "Laporan PDF berhasil diunggah.", "success").then(() => {
                    location.reload();
                });
            } else {
                swal("Error", data.message || "Gagal mengunggah laporan PDF.", "error");
            }
        })
        .catch(err => {
            swal("Error", "Terjadi kesalahan: " + err, "error");
        });
    });
}

</script>
<!-- Modal Daftar PDF -->
<div id="modalPdfList" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9998;">
    <div style="position:relative; width:80%; max-width:800px; margin:5% auto; background:#fff; border-radius:6px; overflow:hidden;">
        <div style="padding:10px 15px; background:#035c7a; color:#fff; display:flex; justify-content:space-between; align-items:center;">
            <span style="font-weight:bold;">Daftar Laporan PDF — Periode <span id="pdfListPeriode"></span></span>
            <button onclick="closePdfList()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:15px; max-height:60vh; overflow-y:auto;">
            <table class="table table-bordered table-striped" style="font-size:12px;">
                <thead>
                    <tr>
                        <th style="width:5%; text-align:center; background:#035c7a; color:#fff;">NO</th>
                        <th style="background:#035c7a; color:#fff;">NAMA FILE</th>
                        <th style="width:20%; text-align:center; background:#035c7a; color:#fff;">DIUPLOAD OLEH</th>
                        <th style="width:20%; text-align:center; background:#035c7a; color:#fff;">TANGGAL</th>
                        <th style="width:10%; text-align:center; background:#035c7a; color:#fff;">AKSI</th>
                    </tr>
                </thead>
                <tbody id="pdfListBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Viewer PDF -->
<div id="modalPdfViewer" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999;">
    <div style="position:relative; width:90%; height:90%; margin:2% auto; background:#fff; border-radius:6px; overflow:hidden;">
        <div style="padding:10px 15px; background:#035c7a; color:#fff; display:flex; justify-content:space-between; align-items:center;">
            <span id="pdfViewerTitle" style="font-weight:bold;"></span>
            <button onclick="closePdfViewer()" style="background:none; border:none; color:#fff; font-size:20px; cursor:pointer;">&times;</button>
        </div>
        <iframe id="pdfViewerFrame" src="" style="width:100%; height:calc(100% - 45px); border:none;"></iframe>
    </div>
</div>