<?php
require_once "config/configuration.php";
require_once "config/connection.php";
ini_set('max_execution_time', 0);

$date = date("Y-m-d");

if (isset($_POST["submit"])) {
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $prospect = $_POST["prospect"];
} else {
    $startDate = date("Y-m-d");
    $endDate = date("Y-m-d");
    $prospect = "";
}
?>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<!-- jquery ui -->
<link rel="stylesheet" href="assets/css/jquery-ui.css">
<script src="assets/js/jquery-ui.js"></script>
<!-- end jquery ui -->

<!-- Datatable -->
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" type="text/css">
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<!-- End Datatable -->
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
                <h4 class="title">History</h4>
                <p class="category">History Activity Request</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="startDate" id="startDate" autocomplete="off" value="<?php echo $startDate; ?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>End Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="endDate" id="endDate" autocomplete="off" value="<?php echo $endDate; ?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NO PROSPECT / ORDER NO</label>
                                <input type="text" name="prospect" class="form-control" placeholder="Nomor Prospect / Order No" value="<?php echo $prospect; ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            &nbsp;<br>
                            <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
                        </div>
                        <div class="col-md-2">
                            &nbsp;<br>
                            <a href="pages/getExcelAll.php?USERNAME=<?php echo $user; ?>&startdate=<?php echo $startDate; ?>&enddate=<?php echo $endDate; ?>" class="btn btn-custom" name="submit" style="width:100%;">EXPORT TO EXCEL</a>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped" id="history" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT NO / ORDER NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NAME</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">SEARCH TYPE</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">CUSTOMER TYPE</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">CHECKED BY</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $call =
                            "{call CPY_PEFINDO_GETDATA_HISTORY_USER(?,?,?,?)}";
                        $param = [
                            [$startDate, SQLSRV_PARAM_IN],
                            [$endDate, SQLSRV_PARAM_IN],
                            [$prospect, SQLSRV_PARAM_IN],
							[$user, SQLSRV_PARAM_IN],
                        ];
                        ($exec = sqlsrv_query($conn, $call, $param)) or
                            die(print_r(sqlsrv_errors(), true));
                        while ($data = sqlsrv_fetch_array($exec)) {
                            $no++; ?>
                            <tr>
                                <td class="td-center"><?php echo $no; ?></td>
                                <td class="td-center"><?php echo $data["PROSPECT_NO"]; ?></td>
                                <td class="td-center"><?php echo $data["ID_NO"]; ?></td>
                                <td class=""><?php echo $data["CUST_NAME"]; ?></td>
                                <td class="td-center">
                                    <?php if ($data["TYPE"] != "COMPANY" && $data["TYPE"] != "PENGURUS") {
                                        echo "Individual";
                                    } else {
                                        echo "Company";
                                    } ?></td>
                                <td class="td-center"><?php echo $data["TYPE"]; ?></td>
                                <td class="td-center"><?php echo $data["SOURCE_BY"]; ?></td>
                                <td class="td-center">
                                    <?php if ($data["CREATE_DATE"] != null) {
                                        echo $data["CREATE_DATE"]->format("d-m-Y");
                                    } ?>
                                </td>
                                <td class="td-center">
                                    <div class="dropdown">
                                        <button class="btn btn-custom btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php
                                          if (
													$data["TYPE"] != "COMPANY" &&
													(
														$data["SOURCE_BY"] == "PEFINDO" ||
														$data["SOURCE_BY"] == "CLICK"
													)
												)  {
                                               if (substr($data['PEFINDO_ID'], 0, 4) == 'CLIK') {
													echo '<li><a href="index.php?USERNAME=' . $user . '&page=scoring-individual-click&id=' . $data['PEFINDO_MAPPING_ID'] . '&prospect_no=' . $data['PROSPECT_NO'] . '&id_no=' . $data['ID_NO'] . '">Detail</a></li>';
												} else {
													echo '<li><a href="index.php?USERNAME=' . $user . '&page=scoring-individual&id=' . $data['PEFINDO_MAPPING_ID'] . '&prospect_no=' . $data['PROSPECT_NO'] . '">Detail</a></li>';
												}
                                            } elseif (
                                                $data["TYPE"] == "COMPANY" &&
                                                $data["SOURCE_BY"] == "PEFINDO"
                                            ) {
                                                echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=scoring-company-piloting&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    "&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    '">Detail</a></li>';
                                            } elseif (
                                                $data["TYPE"] != "COMPANY" && $data["TYPE"] != "PENGURUS" &&
                                                $data["SOURCE_BY"] == "SLIK"
                                            ) {
												if (
                                                $data["NO_REGIST"] != ""
                                            ){
												 echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=slik-detail-new&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    "&custtype=" .
                                                    $data["TYPE"] .
                                                    "&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    '">Detail</a></li>';
												
											}else{
                                                echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=slik-detail-new&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    "&custtype=" .
                                                    $data["TYPE"] .
                                                    "&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    '">Detail</a></li>';
											}
                                            } elseif (
                                                $data["TYPE"] == "PENGURUS" &&
                                                $data["SOURCE_BY"] == "SLIK"
                                            ) {
												if (
                                                $data["NO_REGIST"] != ""
                                            ){
												 echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=slik-detail-new-pengurus&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    "&custtype=" .
                                                    $data["TYPE"] .
                                                    "&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    '">Detail</a></li>';
												
											}else{
                                                echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=slik-detail-new-company&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    "&custtype=" .
                                                    $data["TYPE"] .
                                                    "&id=" .
                                                    $data['PEFINDO_MAPPING_ID'] .
                                                    '">Detail</a></li>';
											}
                                            } elseif (
                                                $data["TYPE"] == "COMPANY" &&
                                                $data["SOURCE_BY"] == "SLIK"
                                            ) {
                                                echo '<li><a href="index.php?USERNAME=' .
                                                    $user .
                                                    "&page=slik-detail-new-company&no=" .
                                                    $data["PROSPECT_NO"] .
                                                    "&custtype=" .
                                                    $data["TYPE"] .
                                                    "&id=" .
                                                    $data['PEFINDO_MAPPING_ID'] .
                                                    '">Detail</a></li>';
                                            }

                                            if ($data["SOURCE_BY"] == "PEFINDO") {
                                                echo '<li><a href="pages/getExcel.php?USERNAME=' .
                                                    $user .
                                                    "&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    '" target="_blank">Export to Excel</a></li>';
                                            } else {
                                                echo '<li><a href="pages/getExcelSLIK.php?USERNAME=' .
                                                    $user .
                                                    "&id=" .
                                                    $data["PEFINDO_MAPPING_ID"] .
                                                    '" target="_blank">Export to Excel</a></li>';
                                            }

                                            // if (
                                            //     $_GET["USERNAME"] ==
                                            //     "iman.santoso" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "djoko.andrew" ||
                                            //     $_GET["USERNAME"] == "ramandona" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "IMAN.SANTOSO" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "DJOKO.ANDREW" ||
                                            //     $_GET["USERNAME"] == "RANI.VEMIA" ||
                                            //     $_GET["USERNAME"] == "rani.vemia" ||
                                            //     $_GET["USERNAME"] == "RAMANDONA" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "NOVRIKAWATI" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "KIKI.AMALIA" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "novrikawati" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "kiki.amalia" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "AHMAD.HABIBI" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "DENY.SAPUTRA" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "Haris.Siswanto" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "HARIS.SISWANTO" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "Yose.Kertapati" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "YOSE.KERTAPATI" ||
                                            //     $_GET["USERNAME"] == "Muhammad" ||
                                            //     $_GET["USERNAME"] == "MUHAMMAD" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "Ramandona.Dinara" ||
                                            //     $_GET["USERNAME"] ==
                                            //     "RAMANDONA.DINARA"
                                            // ) {
                                            //     if (
                                            //         $data["SOURCE_BY"] == "PEFINDO"
                                            //     ) {
                                            //         echo '<li><a href="pages/history-delete.php?USERNAME=' .
                                            //             $user .
                                            //             "&id=" .
                                            //             $data["PEFINDO_MAPPING_ID"] .
                                            //             "&type=" .
                                            //             $data["TYPE"] .
                                            //             '&flag=1" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini ?\');">Hapus</a></li>';
                                            //     } else {
                                            //         echo '<li><a href="pages/history-delete.php?USERNAME=' .
                                            //             $user .
                                            //             "&id=" .
                                            //             $data["PEFINDO_MAPPING_ID"] .
                                            //             "&type=" .
                                            //             $data["TYPE"] .
                                            //             '&flag=2" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini ?\');">Hapus</a></li>';
                                            //     }
                                            // } else {
                                            //     echo '<li><a href="#" disabled style="pointer-events:none;color:#AAA">Hapus</a></li>';
                                            // }
                                            ?>
                                        </ul>
                                    </div>
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
<script type="text/javascript">
    $(window).on("load", function() {
        setTimeout(function() {
            $("#loader").fadeOut("slow");
        }, 2000);
    });
</script>
<script>
    $(document).ready(function() {
        $('#history').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true
        });
        $('#startDate').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                $('#endDate').datepicker("option", "minDate", selectedDate);
            }
        });
        $('#endDate').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                $('#startDate').datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>