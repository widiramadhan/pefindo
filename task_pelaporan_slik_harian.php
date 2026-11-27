<?php

require_once("config/configuration.php");
require_once("config/connection.php");

// GET/SESSION
if (!empty($_GET['USERNAME'])) {
    $user = $_GET['USERNAME'];
} elseif (!empty($_SESSION['USERNAME'])) {
    $user = $_SESSION['USERNAME'];
} else {
    $user = 'guest';
}

$date = date("Y-m-d");

// --- Ambil daftar data lunas harian dari SP ---
$callData = "{call SP_TASK_PELAPORAN_SLIK_HARIAN}";
$execData = sqlsrv_query($conn, $callData);
// Jika SP belum ada, tampilkan data kosong
$spExists = ($execData !== false);

$rows = [];
$earliestTglLunas = null;

if ($spExists) {
    while ($row = sqlsrv_fetch_array($execData, SQLSRV_FETCH_ASSOC)) {
        $rows[] = $row;
        if (isset($row['TglLunas'])) {
            $tgl = null;
            if ($row['TglLunas'] instanceof DateTime) {
                $tgl = $row['TglLunas'];
            } else {
                $tgl = DateTime::createFromFormat('Y-m-d', $row['TglLunas']);
                if (!$tgl) {
                    try {
                        $tgl = new DateTime($row['TglLunas']);
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

// Function to add working days (excluding Saturday and Sunday)
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
    padding-left: 7px;
    padding-right: 7px;
    vertical-align: middle;
}

.th-custom {
    text-align: center;
    background-color: #035c7a;
}

.td-center {
    text-align: center;
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

.btn-custom-header {
    background-color: #035c7a;
    color: #FFF;
    border: 1px solid #035c7a;
    font-size: 12px;
    padding: 6px 15px;
    margin: 2px;
}

.btn-custom-header:hover {
    background-color: #024a63;
    color: #FFF;
}

.btn-task-data {
    background-color: #f0f0f0;
    color: #333;
    border: 1px solid #ccc;
    font-size: 12px;
    padding: 6px 15px;
    margin: 2px;
}

.btn-task-data:hover {
    background-color: #e0e0e0;
    color: #333;
}

.header-actions {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.header-actions-left {
    display: flex;
    align-items: center;
    gap: 5px;
}

.header-actions-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}

.header-actions-right .row-buttons {
    display: flex;
    gap: 5px;
}

.status-lunas-gor {
    color: #28a745;
    font-weight: bold;
}

.status-lunas-lor {
    color: #dc3545;
    font-weight: bold;
}

.status-lunas-alda {
    color: #007bff;
    font-weight: bold;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Task Pelaporan SLIK Harian</h4>
                <p class="category">PT. Suzuki Finance Indonesia</p>
            </div>
            <div class="content">
                <!-- Header Actions -->
                <div class="header-actions">
                    <div class="header-actions-left">
                      
                    </div>
                    <div class="header-actions-right">
                        <div class="row-buttons" style="padding-top: 8px;">
                            <span style="font-weight: bold; color: #035c7a; font-size: 13px;">
                                <i class="fa fa-calendar"></i> <?= htmlspecialchars($batasLaporStr); ?>
                            </span>
                        </div>
                        <div class="row-buttons">
                            <button type="button" class="btn btn-custom-header" id="btnRefresh" onclick="refreshData()">
                                <i class="fa fa-refresh"></i> Refresh
                            </button>
                            <button type="button" class="btn btn-custom-header" id="btnLaporkan" onclick="laporkanData()">
                                <i class="fa fa-paper-plane"></i> Laporkan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tblSlikHarian" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Kontrak</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Lunas</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Debitur</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debit</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Denda</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Tunggakan Pokok</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Tunggakan Bunga</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">Status</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">ContractStat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($rows)) {
                                    $no = 1;
                                    foreach ($rows as $row) {
                                        // Tentukan class status
                                        $statusText = isset($row['STATUS']) ? $row['STATUS'] : '';
                                        $statusClass = '';
                                        if (stripos($statusText, 'Lunas Gor') !== false) {
                                            $statusClass = 'status-lunas-gor';
                                        } elseif (stripos($statusText, 'Lunas LOR') !== false) {
                                            $statusClass = 'status-lunas-lor';
                                        } elseif (stripos($statusText, 'Lunas Alda') !== false) {
                                            $statusClass = 'status-lunas-alda';
                                        }

                                        // Format tanggal lunas
                                        $tglLunas = '';
                                        if (isset($row['TglLunas'])) {
                                            if ($row['TglLunas'] instanceof DateTime) {
                                                $tglLunas = $row['TglLunas']->format('d/m/Y');
                                            } else {
                                                $tglLunas = $row['TglLunas'];
                                            }
                                        }

                                        // Format nominal Rp
                                        $bakiDebit       = isset($row['BakiDebet'])       ? 'Rp ' . number_format($row['BakiDebet'], 0, ',', '.') : 'Rp -';
                                        $denda           = isset($row['Denda'])            ? 'Rp ' . number_format($row['Denda'], 0, ',', '.') : 'Rp -';
                                        $plafon          = isset($row['Plafon'])           ? 'Rp ' . number_format($row['Plafon'], 0, ',', '.') : 'Rp -';
                                        $tunggakanPokok  = isset($row['TunggakanPokok'])  ? 'Rp ' . number_format($row['TunggakanPokok'], 0, ',', '.') : 'Rp -';
                                        $tunggakanBunga  = isset($row['TunggakanBunga'])  ? 'Rp ' . number_format($row['TunggakanBunga'], 0, ',', '.') : 'Rp -';
                                ?>
                                <tr>
                                    <td class="td-center"><?= $no++; ?></td>
                                    <td class="td-center"><?= isset($row['NomorRekeningFasilitas']) ? htmlspecialchars($row['NomorRekeningFasilitas']) : ''; ?></td>
                                    <td class="td-center"><?= $tglLunas; ?></td>
                                    <td><?= isset($row['Nama']) ? htmlspecialchars($row['Nama']) : ''; ?></td>
                                    <td class="td-center"><?= $bakiDebit; ?></td>
                                    <td class="td-center"><?= $denda; ?></td>
                                    <td class="td-center"><?= $plafon; ?></td>
                                    <td class="td-center"><?= $tunggakanPokok; ?></td>
                                    <td class="td-center"><?= $tunggakanBunga; ?></td>
                                     <td><?= isset($row['KATEGORI']) ? htmlspecialchars($row['KATEGORI']) : ''; ?></td>
                                      <td><?= isset($row['CONTRACT_STAT']) ? htmlspecialchars($row['CONTRACT_STAT']) : ''; ?></td>
                                </tr>
                                <?php
                                    }
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert/dist/sweetalert.min.js"></script>

<script>
var phpUsername = "<?php echo isset($user) ? $user : ''; ?>";

$(document).ready(function() {
    $('#tblSlikHarian').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "scrollX": true
    });
});


// Refresh Data
function refreshData() {
    swal({
        title: "Refresh Data",
        text: "Memperbarui data...",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("action_task_slik_harian.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "action=refresh&USERNAME=" + encodeURIComponent(phpUsername)
    })
    .then(res => res.json())
    .then(data => {
        swal.close();
        if (data.status === "ok") {
            swal("Sukses", data.message || "Data berhasil diperbarui.", "success")
            .then(() => { location.reload(); });
        } else {
            swal("Informasi", data.message || "Gagal refresh data.", "warning");
        }
    })
    .catch(err => {
        swal("Informasi", "Fitur Refresh belum tersedia.", "info");
    });
}

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
                    // Mengganti location.reload() dengan redirect (window.location.href)
                    // Menggunakan template literal (backtick) agar variabel PHP lebih mudah disisipkan
                    window.location.href = "index.php?USERNAME=<?php echo $user; ?>&page=task_pelaporan_slik_harian_periode";
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
</script>
