<?php
require_once("config/configuration.php");
?>
<style>
    .th-custom {
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
    }

    .td-custom {
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Individual</h4>
                <p class="category">Pengecekan Individual Manual CLIK</p>
            </div>
            <div class="content">
                <form action="check-click-manual.php" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="no_ktp" class="form-control" placeholder="NIK" value="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NAMA</label>
                                <input type="text" name="name" class="form-control" placeholder="NAMA" value="">
                                <input type="hidden" name="user" class="form-control" value="<?php echo $_GET['USERNAME']; ?>">

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>JENIS KELAMIN</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>TANGGAL LAHIR</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control pull-right" name="date" id="datepicker" placeholder="TANGGAL LAHIR" value="">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ALAMAT</label>
                                <input type="text" name="alamat" class="form-control" placeholder="ALAMAT">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>KELURAHAN</label>
                                <input type="text" name="kelurahan" class="form-control" placeholder="KELURAHAN">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>KECAMATAN</label>
                                <input type="text" name="kecamatan" class="form-control" placeholder="KECAMATAN">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kota Kabupaten</label>
                                <select name="cityCode" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $callCity = "{call SP_CLICK_GET_CITY}";
                                    $execCity = sqlsrv_query($conn, $callCity) or die(print_r(sqlsrv_errors(), true));
                                    $no = 0;

                                    while ($rowCity = sqlsrv_fetch_array($execCity, SQLSRV_FETCH_ASSOC)) {
                                        $no++;
                                    ?>
                                        <option value="<?php echo $rowCity['CITY_CODE']; ?>"><?php echo $rowCity['CITY_VALUE']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>KODE POS</label>
                                <input type="text" name="kode_pos" class="form-control" placeholder="KODE POS">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="NO HP">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Type Customer</label>
                                <select name="tipe_cust" class="form-control">
                                    <option value="Pemohon">Pemohon</option>
                                    <option value="Pasangan">Pasangan</option>
                                    <option value="Penjamin">Penjamin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pull-right">
                        <input type="submit" name="submit" class="btn btn-custom" value="CARI">
                    </div>
                    <div style="clear:both;"></div>
                </form>
            </div>
        </div>
    </div>
</div>