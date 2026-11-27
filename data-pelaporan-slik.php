<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
    // Tangkap data menggunakan atribut 'name' yang baru dari HTML
    $no_kontrak = trim($_POST['no_kontrak']);
    $no_nik = trim($_POST['no_nik']);
}else{
    // Berikan nilai string kosong saat halaman pertama kali di-load
    $no_kontrak = "";
    $no_nik = "";
}

?>
<style>
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
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Data Pelaporan SLIK</h4>
                <p class="category">Data Pelaporan SLIK</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NOMOR KONTRAK</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_kontrak" id="no_kontrak"
                                        autocomplete="off" value="<?php echo isset($no_kontrak) ? $no_kontrak : ''; ?>" placeholder="Masukkan No Kontrak">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-file-text-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NO NIK</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_nik" id="no_nik"
                                        autocomplete="off" value="<?php echo isset($no_nik) ? $no_nik : ''; ?>" placeholder="Masukkan NIK">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-id-card-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            &nbsp;<br>
                            <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="history" style="font-size:10px;">
                        <thead>
                            <tr>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">NO KONTRAK</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">NIK</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">PERIODE LAPOR</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">PLAFON</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">BAKI DEBET</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TUNGGAKAN POKOK</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TUNGGAKAN BUNGA</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">DENDA</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">HARI KETERLAMBATAN</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">KOLEKTIBILITAS</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS PELAPORAN</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS PELAPORAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$no=0;
								$call = "{call SP_GET_NOMOR_KONTRAK_PELAPORAN_SLIK(?,?)}";
								$param = array(array($no_kontrak, SQLSRV_PARAM_IN),array($no_nik, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
								while($data = sqlsrv_fetch_array($exec)){
									$no++;
							?>
                                <tr>
                                    <td class="td-center"><?php echo $no;?></td>
                                    <td class="td-center"><?php echo $data['NOMOR_KONTRAK'];?></td>
                                    <td class="td-center"><?php echo $data['NIK'];?></td>
                                    <td class="td-center"><?php echo $data['PERIODE_LAPOR'];?></td>
                                    <td class="td-center"><?php echo $data['PLAFON'];?></td>
                                    <td class="td-center"><?php echo $data['BAKI_DEBET'];?></td>
                                    <td class="td-center"><?php echo $data['TUNGGAKAN_POKOK'];?></td>
                                    <td class="td-center"><?php echo $data['TUNGGAKAN_BUNGA'];?></td>
                                    <td class="td-center"><?php echo $data['DENDA'];?></td>
                                    <td class="td-center"><?php echo $data['HARI_KETERLAMBATAN'];?></td>
                                    <td class="td-center"><?php echo $data['KOLEKTIBILITAS'];?></td>
                                    <td class="td-center"><?php echo $data['STATUS_PELAPORAN'];?></td>
                                    <td class="td-center"><?php echo $data['STATUS_PELAPORAN_DESC'];?></td>
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
<script>
$(document).ready(function() {
    $('#history').DataTable({
        "bPaginate": true,
        "scrollX": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true
    });
});
</script>