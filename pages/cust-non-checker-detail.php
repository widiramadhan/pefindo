<style>
.wrapper-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-top: 20px;
}
</style>

<?php
require_once(__DIR__ . "/../config/connection.php");

// Ambil parameter dari GET
$order_no = isset($_GET['order_no']) ? $_GET['order_no'] : '';
$no_ktp   = isset($_GET['no_ktp']) ? $_GET['no_ktp'] : '';

// Panggil Stored Procedure
$sql = "{CALL SP_GET_DATA_CUST_NON_CHECK_DETAIL(?, ?)}";
$params = array($order_no, $no_ktp);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($row) {
    // Format tanggal lahir ke string
    if ($row['TANGGAL_LAHIR'] instanceof DateTime) {
        $row['TANGGAL_LAHIR'] = $row['TANGGAL_LAHIR']->format('Y-m-d');
    }

    // Konversi binary ke Base64
    $row['IMG_KTP'] = !empty($row['IMG_KTP'])
        ? 'data:image/jpeg;base64,' . base64_encode($row['IMG_KTP'])
        : '';

    $row['IMG_KK'] = !empty($row['IMG_KK'])
        ? 'data:image/jpeg;base64,' . base64_encode($row['IMG_KK'])
        : '';

    // Jika dokumen lain kosong → tampilkan teks penanda
    if (!empty($row['IMG_DOKUMEN_LAINNYA'])) {
        $row['IMG_DOKUMEN_LAINNYA'] = 'data:image/jpeg;base64,' . base64_encode($row['IMG_DOKUMEN_LAINNYA']);
    } else {
        $row['IMG_DOKUMEN_LAINNYA'] = '';
    }
} else {
    echo "<div style='color:red;'>Data tidak ditemukan</div>";
    exit;
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<div class="wrapper-card">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            
            <!-- Data Customer -->
            <div class="col-md-6 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">
                                DETAIL PENJAMIN CALON DEBITUR
                            </td>
                        </tr>
                        <tr><td>Nomor Order</td><td><?php echo htmlspecialchars($row['ORDER_NO']); ?></td></tr>
                        <tr><td>Nomor KTP</td><td><?php echo htmlspecialchars($row['NO_KTP']); ?></td></tr>
                        <tr><td>Nama Penjamin Tambahan</td><td><?php echo htmlspecialchars($row['NAMA_PENJAMIN_TAMBAHAN']); ?></td></tr>
                        <tr><td>Tempat Lahir</td><td><?php echo htmlspecialchars($row['TEMPAT_LAHIR']); ?></td></tr>
                        <tr><td>Tanggal Lahir</td><td><?php echo htmlspecialchars($row['TANGGAL_LAHIR']); ?></td></tr>
                        <tr><td>Alamat</td><td><?php echo htmlspecialchars($row['ALAMAT']); ?></td></tr>
                        <tr><td>Nama Ibu Kandung</td><td><?php echo htmlspecialchars($row['NAMA_IBU_KANDUNG']); ?></td></tr>
                        <tr><td>Status Kawin</td><td><?php echo htmlspecialchars($row['STATUS_KAWIN']); ?></td></tr>
                    </table>
                </div> 
            </div>

            <!-- Dokumen -->
            <div class="col-md-6 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" style="background-color:#035c7a;color:#FFF;font-weight:bold;">DOKUMEN</td>
                        </tr>

                        <!-- FOTO KTP -->
                        <tr>
                            <td>FOTO KTP</td>
                            <td style="text-align:center;">
                                <?php if ($row['IMG_KTP']): ?>
                                    <img src="<?php echo $row['IMG_KTP']; ?>" alt="Foto KTP" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:red;">Tidak ada foto KTP</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- FOTO KK -->
                        <tr>
                            <td>FOTO KK</td>
                            <td style="text-align:center;">
                                <?php if ($row['IMG_KK']): ?>
                                    <img src="<?php echo $row['IMG_KK']; ?>" alt="Foto KK" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:red;">Tidak ada foto KK</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- FOTO DOKUMEN PENDUKUNG -->
                        <tr>
                            <td>FOTO DOKUMEN PENDUKUNG</td>
                            <td style="text-align:center;">
                                <?php if ($row['IMG_DOKUMEN_LAINNYA']): ?>
                                    <img src="<?php echo $row['IMG_DOKUMEN_LAINNYA']; ?>" alt="Dokumen Pendukung" style="max-width:200px; border:1px solid #ccc; padding:5px; border-radius:4px;">
                                <?php else: ?>
                                    <span style="color:gray;">Tidak ada dokumen pendukung</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
