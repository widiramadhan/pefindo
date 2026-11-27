<?php

//session_start();
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

// --- Ambil daftar task dari SP ---
$callScore = "{call SP_TASKLIST_PELAPORAN_SLIK()}";
$execScore = sqlsrv_query($conn, $callScore);
if ($execScore === false) {
    die(print_r(sqlsrv_errors(), true));
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

.chk-green {
    accent-color: green;
}

.chk-gray {
    accent-color: #bbb;
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">TASK PELAPORAN SLIK</h4>
                <p class="category">PT. Suzuki Finance Indonesia</p>
            </div>
            <div class="content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="history" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">PERIODE PELAPORAN</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">DATA BALIKAN</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">HASIL PELAPORAN</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">AKTIVITAS TERAKHIR</th>
                                    <th class="th-custom" style="color:#FFF;font-weight:bold;">LAPORAN SELESAI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                $no = 1;
                while ($row = sqlsrv_fetch_array($execScore, SQLSRV_FETCH_ASSOC)) {
                    $periode = $row['PERIOD'];
                ?>
                                <tr>
                                    <td class="td-center"><?= $no++; ?></td>
                                    <td class="td-center"><?= $periode; ?></td>

                                    <!-- Kolom ACTION -->
                                    <td class="td-center">
                                        <div class="btn-group">
                                            <a href="index.php?USERNAME=<?= $user; ?>&page=task_control_pelaporan_slik&periode=<?= urlencode($periode); ?>"
                                                class="btn btn-sm <?= ($row['is_ready'] == 1) ? 'btn-primary' : 'btn-secondary disabled'; ?>">
                                                <i class="fa fa-search"></i> Detail
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);"
                                                onclick="openDownloadTxt('<?= $row['PERIOD']; ?>','<?= $user; ?>')"
                                                class="btn btn-sm <?= ($row['is_approval_done'] == 1) ? 'btn-primary' : 'btn-secondary disabled'; ?>"
                                                <?= ($row['is_approval_done'] == 1) ? '' : 'disabled'; ?>>
                                                <i class="fa fa-download"></i> Download .Txt
                                            </a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="javascript:void(0);"
                                                onclick="openDownloadExcel('<?= $row['PERIOD']; ?>','<?= $user; ?>')"
                                                class="btn btn-sm <?= ($row['is_approval_done'] == 1) ? 'btn-primary' : 'btn-secondary disabled'; ?>"
                                                <?= ($row['is_approval_done'] == 1) ? '' : 'disabled'; ?>>
                                                <i class="fa fa-file-excel-o"></i> Download Excel
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Kolom BALIKAN -->
                                    <td class="td-center">
                                        <div class="btn-group">
                                            <?php $is_downloaded = isset($row['is_downloaded']) ? $row['is_downloaded'] : 0; ?>
                                            <button type="button"
                                                class="btn btn-sm dropdown-toggle <?= ($is_downloaded == 1) ? 'btn-primary' : 'btn-secondary'; ?>"
                                                data-toggle="dropdown" <?= ($is_downloaded == 1) ? '' : 'disabled'; ?>>
                                                <i class="fa fa-undo"></i> Return <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="openUploadBalikan('<?= $row['PERIOD']; ?>', event)">
                                                        <i class="fa fa-upload"></i> Upload Balikan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="openDownloadBalikan('<?= $row['PERIOD']; ?>','<?= $user; ?>')">
                                                        <i class="fa fa-download"></i> Download Balikan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                    <!-- Kolom HASIL PELAPORAN -->
                                    <td class="td-center">
                                        <div class="btn-group">
                                            <?php 
            $is_downloaded = isset($row['is_downloaded']) ? $row['is_downloaded'] : 0; 
            $periode = $row['PERIOD']; 
            $username = isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME'] : (isset($_GET['USERNAME']) ? $_GET['USERNAME'] : ''); 
        ?>
                                            <button type="button"
                                                class="btn btn-sm dropdown-toggle <?= ($is_downloaded == 1) ? 'btn-primary' : 'btn-secondary'; ?>"
                                                data-toggle="dropdown" <?= ($is_downloaded == 1) ? '' : 'disabled'; ?>>
                                                <i class="fa fa-file-text"></i> View <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="openUploadLaporan('<?= $periode ?>','<?= $username ?>')">
                                                        <i class="fa fa-upload"></i> Upload Laporan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="openViewLaporan('<?= $periode ?>','<?= $username ?>')">
                                                        <i class="fa fa-eye"></i> View Laporan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                    <!-- Kolom AKTIVITAS TERAKHIR -->
                                    <td class="td-center">
                                        <?php if (!empty($row['LAST_ACTION'])): ?>
                                        <span
                                            class="badge badge-info"><?= htmlspecialchars($row['LAST_ACTION']); ?></span><br>
                                        <small><?= htmlspecialchars($row['LAST_DATE']); ?></small>
                                        <?php else: ?>
                                        <span class="badge badge-secondary">Belum ada log</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Kolom LAPORAN SELESAI -->
                                    <td class="td-center">
                                        <?php if (!empty($row['is_done']) && $row['is_done'] == 1): ?>
                                        <input type="checkbox" checked class="chk-green" onclick="return false;">
                                        <?php else: ?>
                                        <input type="checkbox" class="chk-gray" onclick="return false;">
                                        <?php endif; ?>
                                    </td>
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
var phpUsername = "<?php echo isset($user) ? $user : ''; ?>";

$(document).ready(function() {
    $('#history').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true
    });
});

document.addEventListener("DOMContentLoaded", function() {
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] != '') {
        // escape karakter khusus agar JS tidak error
        $js_msg = addslashes($_GET['msg']);
        echo "swal('Informasi', '{$js_msg}', 'warning');";
    }
    ?>
});

// Download .Txt SweetAlert
function openDownloadTxt(periode, username) {
    swal({
        title: "Menyiapkan File .Txt...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("task_download_laporan_slik.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "periode=" + encodeURIComponent(periode) +
                "&USERNAME=" + encodeURIComponent(username)
        })
        .then(response => {
            // Cek apakah responsenya file ZIP (binary)
            const contentType = response.headers.get("Content-Type");
            if (contentType && contentType.includes("application/zip")) {
                return response.blob().then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = url;
                    a.download = "SLIK_" + periode + ".zip";
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    swal.close();
                    window.URL.revokeObjectURL(url);
                });
            } else {
                // Kalau bukan ZIP (berarti ada pesan error dari PHP)
                return response.text().then(text => {
                    swal("Informasi", text || "File tidak ditemukan untuk periode " + periode, "warning");
                });
            }
        })
        .catch(err => {
            swal("Error", "Terjadi kesalahan: " + err.message, "error");
        });
}

// Download Excel SweetAlert
function openDownloadExcel(periode, username) {
    swal({
        title: "Menyiapkan File Excel...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("task_download_laporan_slik_excel.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "periode=" + encodeURIComponent(periode) +
                "&USERNAME=" + encodeURIComponent(username)
        })
        .then(res => res.json())
        .then(data => {
            swal.close();
            if (data.status === "ok") {
                window.location.href = data.download_url;
            } else {
                swal("Informasi", data.message || "File Excel belum tersedia untuk periode " + periode, "warning");
            }
        })
        .catch(err => {
            swal("Error", "Gagal memeriksa file: " + err, "error");
        });
}

// upload multi file
function openUploadBalikan(periode) {
    swal({
        title: "Upload File Balikan",
        text: "Silahkan pilih file ZIP untuk periode " + periode,
        content: {
            element: "input",
            attributes: {
                type: "file",
                id: "swal_file",
                accept: ".zip",
                multiple: true
            }
        },
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Upload",
                closeModal: false
            }
        }
    }).then(function(value) {
        if (!value) return;

        var fileInput = document.getElementById("swal_file");
        if (!fileInput || !fileInput.files.length) {
            swal("Error", "Silakan pilih minimal 1 file ZIP", "error");
            return;
        }

        var formData = new FormData();
        formData.append("periode", periode);
        formData.append("USERNAME", phpUsername);

        for (var i = 0; i < fileInput.files.length; i++) {
            formData.append("balikan_file[]", fileInput.files[i]);
        }

        fetch("upload_balikan_laporan_slik.php", {
                method: "POST",
                body: formData
            })
            .then(function(res) {
                return res.text();
            })
            .then(function(resText) {
                swal("Sukses", resText, "success").then(function() {
                    location.reload();
                });
            })
            .catch(function(err) {
                swal("Error", "Gagal upload: " + err, "error");
            });
    });
}

// download balikan
function openDownloadBalikan(periode, username) {
    swal({
        title: "Menyiapkan file...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    fetch("task_download_balikan_laporan_slik.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "periode=" + encodeURIComponent(periode) + "&USERNAME=" + encodeURIComponent(username)
        })
        .then(res => res.json())
        .then(data => {
            swal.close();
            if (data.status === "ok") {
                // Jika file ada → buka URL download
                window.location.href = data.download_url;
            } else {
                swal("Informasi", data.message || "File balikan tidak ditemukan untuk periode " + periode,
                    "warning");
            }
        })
        .catch(err => {
            swal("Error", "Gagal memeriksa file: " + err, "error");
        });
}

// upload laporan PDF
function openUploadLaporan(periode, username) {
    swal({
        title: "Upload File Laporan",
        text: "Silahkan pilih file PDF untuk periode " + periode,
        content: {
            element: "input",
            attributes: {
                type: "file",
                id: "swal_file_laporan",
                accept: ".pdf",
                multiple: true
            }
        },
        buttons: {
            cancel: "Batal",
            confirm: {
                text: "Upload",
                closeModal: false
            }
        }
    }).then(function(value) {
        if (!value) return;

        var fileInput = document.getElementById("swal_file_laporan");
        if (!fileInput || !fileInput.files.length) {
            swal("Error", "Silakan pilih minimal 1 file PDF", "error");
            return;
        }

        var formData = new FormData();
        formData.append("periode", periode);
        formData.append("USERNAME", username);

        for (var i = 0; i < fileInput.files.length; i++) {
            formData.append("laporan_pdf[]", fileInput.files[i]);
        }

        fetch("upload_laporan_slik_pdf.php", {
                method: "POST",
                body: formData
            })
            .then(function(res) {
                return res.text();
            })
            .then(function(resText) {
                swal({
                    title: "Upload Berhasil!",
                    text: resText,
                    icon: "success",
                    button: "OK"
                }).then(function() {
                    location.reload();
                });
            })
            .catch(function(err) {
                swal("Error", "Gagal upload: " + err, "error");
            });
    });
}
// Cek file laporan sebelum buka tab PDF
function openViewLaporan(periode, username) {
    // Tampilkan loading dulu biar interaktif
    swal({
        title: "Memeriksa Laporan...",
        text: "Mohon tunggu sebentar",
        icon: "info",
        buttons: false,
        closeOnClickOutside: false,
        closeOnEsc: false
    });

    // cek apakah file PDF tersedia
    fetch("task_check_laporan_slik_pdf.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "periode=" + encodeURIComponent(periode)
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "ok") {
                swal.close();
                // Jika file ada, buka tab baru untuk lihat laporan
                window.open(
                    "view_laporan_slik_pdf.php?periode=" + encodeURIComponent(periode) +
                    "&USERNAME=" + encodeURIComponent(username),
                    "_blank"
                );
            } else {
                swal("Informasi", data.message || ("File laporan PDF belum tersedia untuk periode " + periode),
                    "warning");
            }
        })
        .catch(err => {
            swal("Error", "Gagal memeriksa laporan: " + err, "error");
        });
}
</script>