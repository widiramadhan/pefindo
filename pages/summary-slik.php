<?php
require_once("config/connection.php");

$order_no = isset($_GET['order_no']) ? $_GET['order_no'] : '';
$no_ktp   = isset($_GET['no_ktp']) ? $_GET['no_ktp'] : '';

$mapping_idPasangan = isset($_GET['mapping_id']) ? $_GET['mapping_id'] : '';;
$siapanih = "ADDITIONAL";


$callDataPasangan = "{call SP_GET_SCORE_FASILITAS_PEFINDO_SLIK(?,?)}";
$paramDataPasangan =  array(
	array($order_no, SQLSRV_PARAM_IN),
	array($siapanih, SQLSRV_PARAM_IN)
);

$execDataPasangan = sqlsrv_query($conn, $callDataPasangan, $paramDataPasangan) or die(print_r(sqlsrv_defaults(), true));
$dataDataPasangan = sqlsrv_fetch_array($execDataPasangan);

$callDescPasangan = "{call SP_GET_SCORE_DESC_PEFINDO_SLIK(?,?)}";
$paramDescPasangan =  array(
	array($dataDataPasangan['SCORE'], SQLSRV_PARAM_IN),
	array('1', SQLSRV_PARAM_IN)
);
$execDescPasangan = sqlsrv_query($conn, $callDescPasangan, $paramDescPasangan) or die(print_r(sqlsrv_defaults(), true));
$dataDescPasangan = sqlsrv_fetch_array($execDescPasangan);

$scorePasangan = $dataDescPasangan['SCORE_DESC'];
?>



<style>
.wrapper-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    margin-top: 20px;
}
</style>
<div class="wrapper-card">
    <div id="historical_kredit_kry_pasangan">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td style="background-color:#035c7a;color:#FFF;font-weight:bold;"><U>Kewajiban Di Tempat Lain (Summary Hasil Pefindo / SLIK OJK )</u></td>
                        </tr>


                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Aktif</th>


                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php echo $siapanih ?>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr style="background-color:#035c7a;color:#FFF;font-weight:bold;">
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
                                <!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPlafondPasangan = 0;
                            $totalBakiDebetPasangan = 0;
                            $totalAngsuranPasangan = 0;

                            $totalNaPlafondNaPasangan = 0;
                            $totalNaBakiDebetNaPasangan = 0;
                            $totalNaAngsuranNaPasangan = 0;

                            if ($dataDataPasangan['SOURCE_BY'] == 'PEFINDO') {
                                $callPefindoPasangan = "{call SP_RAK_GET_PEFINDO_AKTIF(?)}";
                                $paramPefindoPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPefindoPasangan = sqlsrv_query($conn, $callPefindoPasangan, $paramPefindoPasangan) or die(print_r(sqlsrv_defaults(), true));

                                $callPefindoNaPasangan = "{call SP_RAK_GET_PEFINDO_NOT_AKTIF(?)}";
                                $paramPefindoNaPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPefindoNaPasangan = sqlsrv_query($conn, $callPefindoNaPasangan, $paramPefindoNaPasangan) or die(print_r(sqlsrv_defaults(), true));
                            } else {
                                $callPefindoPasangan = "{call SP_RAK_GET_SLIK_AKTIF(?)}";
                                $paramPefindoPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPefindoPasangan = sqlsrv_query($conn, $callPefindoPasangan, $paramPefindoPasangan) or die(print_r(sqlsrv_defaults(), true));

                                $callPefindoNaPasangan = "{call SP_RAK_GET_SLIK_NOT_AKTIF(?)}";
                                $paramPefindoNaPasangan =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPefindoNaPasangan = sqlsrv_query($conn, $callPefindoNaPasangan, $paramPefindoNaPasangan) or die(print_r(sqlsrv_defaults(), true));
                            }


                            $num_rows = sqlsrv_num_rows($execPefindoPasangan);
                            $no = 0;

                            while ($rowGetProspectPasangan = sqlsrv_fetch_array($execPefindoPasangan)) {
                                $no++;
                                $totalPlafondPasangan = +$totalPlafondPasangan + $rowGetProspectPasangan['PLAFON'];
                                $totalBakiDebetPasangan = +$totalBakiDebetPasangan + $rowGetProspectPasangan['BAKI_DEBET'];
                                $totalAngsuranPasangan = +$totalAngsuranPasangan + $rowGetProspectPasangan['ANGSURAN'];

                                //echo $percent;
                            ?>
                                <tr>
                                    <td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['PEMBERI_CREDIT']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['CONTRACT_TYPE']; ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['PLAFON'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectPasangan['TANGGAL_AKAD_AWAL'] <> NULL) {
                                                                                    echo $rowGetProspectPasangan['TANGGAL_AKAD_AWAL']->format('Y-m-d');
                                                                                } else {
                                                                                    echo "-";
                                                                                } ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectPasangan['TGL_JATUH_TEMPO'] <> NULL) {
                                                                                    echo $rowGetProspectPasangan['TGL_JATUH_TEMPO']->format('Y-m-d');
                                                                                } else {
                                                                                    echo "-";
                                                                                } ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['TENOR']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['SISA_TENOR']; ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['BAKI_DEBET'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectPasangan['ANGSURAN'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['OD']; ?></td>
                                    <!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectPasangan['SISA_TENOR'];
                                                                                    ?></td> -->
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['CONTRACT_STATUS']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['RESTRUKTUR']; ?></td>


                                </tr>
                            <?php } ?>
                            </tr>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">TOTAL</td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalPlafondPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalBakiDebetPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalAngsuranPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>


                            </tr>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Fasilitas Non Aktif</th>


                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr style="background-color:#035c7a;color:#FFF;font-weight:bold;">
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemberi Fasilitas</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Jenis Fasilitas</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Plafon</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Awal</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Akad Akhir</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Tenor</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Baki Debet</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Angsuran</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">OD</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan Status</th>
                                <!-- <th class="th-custom" style="color:#FFF;font-weight:bold;">Sisa Tenor</th> -->
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Restruktur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php



                            $num_rows = sqlsrv_num_rows($execPefindoNaPasangan);
                            $no = 0;

                            while ($rowGetProspectNaPasangan = sqlsrv_fetch_array($execPefindoNaPasangan)) {
                                $no++;
                                $totalNaPlafondNaPasangan = +$totalNaPlafondNaPasangan + $rowGetProspectNaPasangan['PLAFON'];
                                $totalNaBakiDebetNaPasangan = +$totalNaBakiDebetNaPasangan + $rowGetProspectNaPasangan['BAKI_DEBET'];
                                $totalNaAngsuranNaPasangan = +$totalNaAngsuranNaPasangan + $rowGetProspectNaPasangan['ANGSURAN'];

                                //echo $percent;
                            ?>
                                <tr>
                                    <td class="td-custom" style="padding:5px;"><?php echo $no; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['PEMBERI_CREDIT']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['CONTRACT_TYPE']; ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['PLAFON'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectNaPasangan['TANGGAL_AKAD_AWAL'] <> NULL) {
                                                                                    echo $rowGetProspectNaPasangan['TANGGAL_AKAD_AWAL']->format('Y-m-d');
                                                                                } else {
                                                                                    echo "-";
                                                                                } ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php if ($rowGetProspectNaPasangan['TGL_JATUH_TEMPO'] <> NULL) {
                                                                                    echo $rowGetProspectNaPasangan['TGL_JATUH_TEMPO']->format('Y-m-d');
                                                                                } else {
                                                                                    echo "-";
                                                                                } ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['TENOR']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['SISA_TENOR']; ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['BAKI_DEBET'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($rowGetProspectNaPasangan['ANGSURAN'], 0, ',', '.'); ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['OD']; ?></td>
                                    <!-- <td class="td-custom" style="padding:5px;"><?php //echo $rowGetProspectNaPasangan['SISA_TENOR'];
                                                                                    ?></td> -->
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectNaPasangan['CONTRACT_STATUS']; ?></td>
                                    <td class="td-custom" style="padding:5px;"><?php echo $rowGetProspectPasangan['RESTRUKTUR']; ?></td>


                                </tr>
                            <?php } ?>
                            </tr>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">TOTAL</td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaPlafondNaPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaBakiDebetNaPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($totalNaAngsuranNaPasangan, 0, ',', '.'); ?></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>
                            <td class="td-custom" style="padding:5px;"></td>


                            </tr>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="table-responsive">
                    <table id="datatable1" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Deskripsi Score</th>
                                <td><?php echo $scorePasangan; ?></td>

                            </tr>
                        </thead>

                    </table>

                    <table id="datatable2" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr style="background-color:#035c7a;color:#FFF;font-weight:bold;">
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Keterangan</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Jumlah</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">Amount angsuran / bln</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($dataDataPasangan['SOURCE_BY'] == 'PEFINDO') {
                                $callPasanganScore = "{call SP_RAK_GET_PEFINDO_COUNT_LUNAS_NEW(?)}";
                                $paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPasanganScore = sqlsrv_query($conn, $callPasanganScore, $paramPasanganScore) or die(print_r(sqlsrv_defaults(), true));
                                $dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
                            } else {
                                $callPasanganScore = "{call SP_RAK_GET_SLIK_COUNT_LUNAS_NEW(?)}";
                                $paramPasanganScore =  array(array($mapping_idPasangan, SQLSRV_PARAM_IN));
                                $execPasanganScore = sqlsrv_query($conn, $callPasanganScore, $paramPasanganScore) or die(print_r(sqlsrv_defaults(), true));
                                $dataPasanganScore = sqlsrv_fetch_array($execPasanganScore);
                            }




                            //echo $percent;
                            ?>
                            <tr>
                                <td class="td-custom" style="padding:5px;">Fasilitas Aktif</td>
                                <td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_AKTIF']; ?></td>
                                <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_AKTIF'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="td-custom" style="padding:5px;">Fasilitas Non Aktif</td>
                                <td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_NON_AKTIF']; ?></td>
                                <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_NON_AKTIF'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="td-custom" style="padding:5px;">Fasilitas Restruktur Aktif</td>
                                <td class="td-custom" style="padding:5px;"><?php echo $dataPasanganScore['FASILITAS_RESTRUKTUR']; ?></td>
                                <td class="td-custom" style="padding:5px;">RP. <?php echo number_format($dataPasanganScore['ANGSURAN_RESTRUKTUR'], 0, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>


                </div>
                <span style="color:red"> * Apabila Terdapat Fasilitas Aktif Suzuki Finance Indonesia,
                    Fasilitas Tersebut Tidak Masuk Kedalam Hitungan, Digantikan Dengan Angsuran Yang Berjalan Di SFI Saat Ini
                </span>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>