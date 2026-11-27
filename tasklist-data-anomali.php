<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");


if (isset($_POST['submit'])) {
    $nokon = $_POST['nokon'];
} else {
    $nokon = '';
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
                <h4 class="title">Dukcapil</h4>
                <p class="category">Tasklist Request Dukcapil</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NO KONTRAK</label>
                                <input type="text" class="form-control" name="nokon" id="nokon" value="<?php echo $nokon; ?>">
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
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NOMOR KONTRAK
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">BRANCH ID</th>
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $call = "{call SP_TASKLIST_DATA_ANOMALI_SLIK(?,?)}";
                            $param = array(array($user, SQLSRV_PARAM_IN), array($nokon, SQLSRV_PARAM_IN));
                            $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
                            while ($data = sqlsrv_fetch_array($exec)) {
                                $no++;
                                /*$awal  = $data['START_DATE'];//date('Y-m-d H:i:s', strtotime($data['START_DATE'])); //Waktu awal
									$akhir = $data['END_DATE'];//date('Y-m-d H:i:s', strtotime($data['END_DATE'])); // Waktu sekarang atau akhir
									$interval="";
									
									if($awal <> NULL && $akhir <> NULL){
										$diff=$awal->diff($akhir);
										$interval=$diff->format('%H:%I:%S');
									}else if($awal <> NULL && $akhir == NULL){
										$interval="-";
									}else{
										$interval="-";
									}*/
                            ?>
                                <tr>
                                    <td class="td-center"><?php echo $no; ?></td>
                                    <td class="td-center"><?php echo $data['AGRMNT_NO']; ?></td>
                                    <td class="td-center"><?php echo $data['NAMA']; ?></td>
                                    <td class="td-center"><?php echo $data['NIK']; ?></td>
                                    <td class="td-center"><?php echo $data['BRANCH_ID']; ?></td>

                                    <?php if ($data['STAT_RETURN'] == 'RETURN') { ?>
                                        <td class="td-center"><a href="index.php?page=dukcapil-anomali-detail-return&USERNAME=<?php echo $user; ?>&NOREG=<?php echo $data['AGRMNT_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL RETURN</a>
                                        <?php } else { ?>
                                        <td class="td-center"><a href="index.php?page=dukcapil-anomali&USERNAME=<?php echo $user; ?>&NOREG=<?php echo $data['AGRMNT_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
                                        <?php } ?>
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
</div>
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