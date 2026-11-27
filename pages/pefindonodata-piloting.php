<?php
require_once "config/configuration.php";
require_once "config/connection.php";
$date = date("Y-m-d");

$company = array(21, 22, 23, 24, 26, 27, 28, 29);
$companyType = array("COMPANY", "PENGURUS");

if (isset($_POST['submit'])) {
    $startDate = $_POST['nodatastartDate'];
    $endDate = $_POST['nodataendDate'];
    $branch = $_POST['branch'];
    $prospect_no = $_POST['prospect_no'];
    $status = $_POST['status'];
} else {
    $startDate = date("Y-m-d");
    $endDate = date("Y-m-d");
    $branch = "";
    $prospect_no = "";
    $status = "OPEN";
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

    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 99999999999999999999999999999;
        background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255, 255, 255);
        opacity: 1;
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
                <h4 class="title">Tasklist</h4>
                <p class="category">Daftar Pekerjaan Yang di request</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="nodatastartDate" id="nodatastartDate"
                                        autocomplete="off" value="<?php echo $startDate; ?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="nodataendDate" id="nodataendDate"
                                        autocomplete="off" value="<?php echo $endDate; ?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>BRANCH</label>
                                <select name="branch" class="form-control">
                                    <option value="">ALL BRANCH</option>
                                    <!--<option value="">ALL BRANCH</option>-->
                                    <?php
                                    $call2 = "{call SP_GET_ALL_BRANCH_2(?)}";
                                    $param2 = array(array($user, SQLSRV_PARAM_IN));
                                    $exec2 = sqlsrv_query($conn, $call2, $param2) or die(print_r(sqlsrv_errors(), true));
                                    while ($data2 = sqlsrv_fetch_array($exec2)) {
                                        ?>
                                        <option value="<?php echo $data2['OFFICE_CODE']; ?>" <?php if ($data2['OFFICE_CODE'] == $branch) {
                                               echo "selected";
                                           } ?>><?php echo $data2['OFFICE_CODE']; ?> - <?php echo $data2['OFFICE_NAME']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>PROSPECT / ORDER NO</label>
                                <input type="text" class="form-control" name="prospect_no" id="prospect_no"
                                    value="<?php echo $prospect_no; ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="" <?= ('' == $status) ? "selected" : "" ?>>ALL STATUS</option>
                                    <option value="OPEN" <?= ('OPEN' == $status) ? "selected" : "" ?>>OPEN</option>
                                    <option value="ON PROGRESS" <?= ('ON PROGRESS' == $status) ? "selected" : "" ?>>ON
                                        PROGRESS</option>
                                    <option value="REJECT" <?= ('REJECT' == $status) ? "selected" : "" ?>>REJECT</option>
                                    <option value="FINISH" <?= ('FINISH' == $status) ? "selected" : "" ?>>FINISH</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-custom" name="submit"
                                    style="width:100%;">CARI</button>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">TIPE CUST</th>
                            <?php
                            if ($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' || $_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI' || $_GET['USERNAME'] == 'ALIKA.HALIMAH' || $_GET['USERNAME'] == 'ALIKA.HALIMAH' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA' || $_GET['USERNAME'] == 'ADAM.WAHYU' || $_GET['USERNAME'] == 'ADAM.WAHYU' || $_GET['USERNAME'] == 'Ricky.Randhita' || $_GET['USERNAME'] == 'RICKY.RANDHITA' || $_GET['USERNAME'] == 'Herberth.Simbolon' || $_GET['USERNAME'] == 'HERBERTH.SIMBOLON' || $_GET['USERNAME'] == 'Moh.Junaidi.Siyam' || $_GET['USERNAME'] == 'MOH.JUNAIDI.SIYAM') {
                                ?>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">USER</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">USER PROSES</th>
                            <?php } ?>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $call = "{call CPY_GET_PEFINDO_NODATA(?,?,?,?,?,?)}";
                        // $call = "{call SP_GET_PEFINDO_NODATA_7(?,?,?,?,?,?)}";
                        //$call = "{call SP_GET_PEFINDO_NODATA_DUKCAPIL(?,?,?)}";
                        $param = array(array($startDate, SQLSRV_PARAM_IN), array($endDate, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN), array($branch, SQLSRV_PARAM_IN), array($prospect_no, SQLSRV_PARAM_IN), array($status, SQLSRV_PARAM_IN));
                        $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
                        while ($data = sqlsrv_fetch_array($exec)) {
                            $no++;
                            ?>
                            <tr>
                                <td class="td-center">
                                    <?php echo $no; ?>
                                </td>
                                <td class="td-left">
                                    <?php echo $data['PROSPECT_NO']; ?>
                                </td>
                                <td class="td-left">
                                    <?php echo $data['OFFICE_DESC']; ?>
                                </td>
                                <td class="td-left">
                                    <?php echo $data['ID_NO']; ?>
                                </td>
                                <td class="td-left">
                                    <?php echo $data['TIPE_CUST']; ?>
                                </td>
                                <?php
                                if ($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' || $_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI' || $_GET['USERNAME'] == 'ALIKA.HALIMAH' || $_GET['USERNAME'] == 'ALIKA.HALIMAH' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA' || $_GET['USERNAME'] == 'ADAM.WAHYU' || $_GET['USERNAME'] == 'ADAM.WAHYU' || $_GET['USERNAME'] == 'Ricky.Randhita' || $_GET['USERNAME'] == 'RICKY.RANDHITA' || $_GET['USERNAME'] == 'Herberth.Simbolon' || $_GET['USERNAME'] == 'HERBERTH.SIMBOLON' || $_GET['USERNAME'] == 'Moh.Junaidi.Siyam' || $_GET['USERNAME'] == 'MOH.JUNAIDI.SIYAM') {
                                    ?>
                                    <td class="td-left">
                                        <?php echo $data['CREATE_USER']; ?>
                                    </td>
                                    <td class="td-left">
                                        <?php echo $data['USER_PROSES']; ?>
                                    </td>
                                <?php } ?>
                                <td class="td-center">
                                    <?php
                                    if ($data['DESC_SUB_PARAM'] == "OPEN") {
                                        echo "<span class='badge' style='background-color:#d9534f;'>" . $data['DESC_SUB_PARAM'] . "</span>";
                                    } else if ($data['DESC_SUB_PARAM'] == "ON PROGRESS") {
                                        echo "<span class='badge' style='background-color:#428bca;'>" . $data['DESC_SUB_PARAM'] . "</span>";
                                    } else if ($data['DESC_SUB_PARAM'] == "REJECT") {
                                        echo "<span class='badge' style='background-color:#ffc107;'>" . $data['DESC_SUB_PARAM'] . "</span>";
                                    } else if ($data['DESC_SUB_PARAM'] == "HOLD DUKCAPIL") {
                                        echo "<span class='badge' style='background-color:#000000;'>" . $data['DESC_SUB_PARAM'] . "</span>";
                                    } else {
                                        echo "<span class='badge' style='background-color:#5cb85c;'>" . $data['DESC_SUB_PARAM'] . "</span>";
                                    }
                                    ?>
                                </td>
                                <td class="td-center">
                                    <?php if ($data['SUB_PARAM_CD'] == "5" && !in_array($data['TIPE_CUST'], $companyType, true)) { ?>
                                        <a href="index.php?page=note-reject-detail&USERNAME=<?php echo $user; ?>&prospect=<?php echo $data['PROSPECT_NO']; ?>&id_no=<?php echo $data['ID_NO']; ?>&id=<?php echo $data['PEFINDO_MAPPING_ID']; ?>"
                                            class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                    <?php } else if ($data['SUB_PARAM_CD'] == "0" || $data['SUB_PARAM_CD'] == "1" || $data['SUB_PARAM_CD'] == "2") { ?>
                                            <a href="index.php?page=prospek-group-new&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                        <?php } else if ($data['SUB_PARAM_CD'] == "4") {

                                        $callGetProspect = "{call SP_GET_PROSPEK_NUMBER_TASKLIST(?)}";
                                        $options = array("Scrollable" => "buffered");
                                        $param = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
                                        $execGetProspect = sqlsrv_query($conn, $callGetProspect, $param, $options) or die(print_r(sqlsrv_errors(), true));
                                        $data31 = sqlsrv_fetch_array($execGetProspect);

                                        $call4 = "{call PEFINDO_GETDATA_PASANGAN_NEWVERSE(?)}";
                                        $param4 = array(array($data['PROSPECT_NO'], SQLSRV_PARAM_IN));
                                        $exec4 = sqlsrv_query($conn, $call4, $param4) or die(print_r(sqlsrv_errors(), true));
                                        $data4 = sqlsrv_fetch_array($exec4);

                                        if ($data4['Pasangan_Noktp'] == "" || $data4['Pasangan_Noktp'] == null) {
                                            $siapanih = "Penjamin";
                                            $ktpsaya = $data4['Penjamin_Noktp'];
                                            $namasaya = $data4['Penjamin_Nama'];
                                            $tgllahirsaya = $data4['Penjamin_TglLahir'];
                                            $tempatlahirsaya = $data4['Penjamin_TempatLahir'];
                                        } else {
                                            $siapanih = "Pasangan";
                                            $ktpsaya = $data4['Pasangan_Noktp'];
                                            $namasaya = $data4['Pasangan_Nama'];
                                            $tgllahirsaya = $data4['Pasangan_TglLahir'];
                                            $tempatlahirsaya = $data4['Pasangan_TempatLahir'];
                                        }
                                        ?>

                                                <form action="index.php?page=dukcapil-ho&USERNAME=<?php echo $user; ?>" method="post"
                                                    enctype="multipart/form-data" id="ff">
                                                    <input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO']; ?>">
                                                    <input type="hidden" name="no_ktp" value="<?php echo $data31['ID_NO']; ?>">
                                                    <input type="hidden" name="name" value="<?php echo $data31['CUST_NAME']; ?>">
                                                    <input type="hidden" name="date"
                                                        value="<?php echo date('Y-m-d', strtotime($data31['BIRTH_DT'])); ?>">
                                                    <input type="hidden" name="mother_name" value="<?php echo $data31['MOTHER_NM']; ?>">
                                                    <input type="hidden" name="birth_place"
                                                        value="<?php echo $data31['BIRTH_PLACE']; ?>">
                                                    <input type="hidden" name="tipe_cust" value="<?php echo strtoupper($siapanih); ?>">
                                                </form>

                                            <?php if (strpos($data['PROSPECT_NO'], 'PRS') !== false) { ?>
                                            <?php if (in_array($data['SUB_PARAM_CD'], $company, true) || in_array($data['TIPE_CUST'], $companyType, true)) { ?>
                                                <a href="index.php?page=prospek-group-company&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                    class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                            <?php } else { ?>
                                                <a href="index.php?page=prospek-group-new&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                    class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                            <?php }
                                            } else { ?>
                                            <?php if (in_array($data['SUB_PARAM_CD'], $company, true) || in_array($data['TIPE_CUST'], $companyType, true)) { ?>
                                                <a href="index.php?page=prospek-group-company&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                    class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                            <?php } else if ($data['OFFICE_CODE'] == '1502' || $data['OFFICE_CODE'] == '1011' || $data['OFFICE_CODE'] == '1006' || $data['OFFICE_CODE'] == '1506') { ?>
                                                    <a href="index.php?page=prospek-group-vbs&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php } else { ?>
                                                    <a href="index.php?page=prospek-group-new&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php }
                                            }
                                    } else if ($data['DESC_SUB_PARAM'] == "REJECT") { ?>

                                            <?php if ($data['SUB_PARAM_CD'] != "24" && !in_array($data['TIPE_CUST'], $companyType, true)): ?>
                                                <a href="index.php?page=note-detail&USERNAME=<?php echo $user; ?>&id=<?php echo $data['PEFINDO_MAPPING_ID']; ?>"
                                                    class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                            <?php else: ?>
                                                <a href="index.php?page=note-detail-company&USERNAME=<?php echo $user; ?>&id=<?php echo $data['PEFINDO_MAPPING_ID']; ?>"
                                                    class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                            <?php endif; ?>

                                            <?php } else { ?>

                                                <?php if (strpos($data['PROSPECT_NO'], 'PRS') !== false) { ?>
                                                <?php if (in_array($data['TIPE_CUST'], $companyType, true)) { ?>
                                                    <a href="index.php?page=prospek-group-company&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php } else { ?>
                                                <?php if (in_array($data['SUB_PARAM_CD'], $company, true)) { ?>
                                                    <a href="index.php?page=prospek-group-company&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php } else { ?>
                                                    <a href="index.php?page=prospek-group-new&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php }
                                                }
                                                } else { ?>
                                                <?php if (in_array($data['SUB_PARAM_CD'], $company, true) || in_array($data['TIPE_CUST'], $companyType, true)) { ?>
                                                    <a href="index.php?page=prospek-group-company&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                        class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                <?php } else if ($data['OFFICE_CODE'] == '1502' || $data['OFFICE_CODE'] == '1011' || $data['OFFICE_CODE'] == '1006' || $data['OFFICE_CODE'] == '1506' || $data['OFFICE_CODE'] == '1013') { ?>
                                                        <a href="index.php?page=prospek-group-vbs&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                            class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                    <?php } else { ?>
                                                        <a href="index.php?page=prospek-group-new&USERNAME=<?php echo $user; ?>&no=<?php echo $data['PROSPECT_NO']; ?>"
                                                            class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                                    <?php }
                                                }
                                    } ?>
                                </td>
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

<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
    function alertdukcapil() {
        if (confirm('Apakah anda yakin ingin mengecek data ini? Pengecekan akan dikenakan biaya dan tercatat di log')) {
            document.getElementById('ff').submit();
        };
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $("#loader").fadeOut("slow");
        }, 2000);

        $('#nodata').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true
        });

        $('#nodatastartDate').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function (selectedDate) {
                $('#nodataendDate').datepicker("option", "minDate", selectedDate);
            }
        });
        $('#nodataendDate').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function (selectedDate) {
                $('#nodatastartDate').datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>