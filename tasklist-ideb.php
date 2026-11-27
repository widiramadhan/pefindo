<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");

$company = array(21, 22, 23, 24, 26, 27, 28, 29);

if (isset($_POST['submit'])) {
    $startDate = $_POST['nodatastartDate'];
    $endDate = $_POST['nodataendDate'];
   
    $status = $_POST['status'];
} else {
    $startDate = date("Y-m-01");
    $endDate = date("Y-m-d");
  
    $status = "0";
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
                                    <input type="text" class="form-control" name="nodatastartDate" id="nodatastartDate" autocomplete="off" value="<?php echo $startDate; ?>">
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
                                    <input type="text" class="form-control" name="nodataendDate" id="nodataendDate" autocomplete="off" value="<?php echo $endDate; ?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="" <?= ('' == $status) ? "selected" : "" ?>>ALL STATUS</option>
                                    <option value="0" <?= ('0' == $status) ? "selected" : "" ?>>0</option>
                                    <option value="1" <?= ('1' == $status) ? "selected" : "" ?>>1</option>
									  <option value="2" <?= ('2' == $status) ? "selected" : "" ?>>2</option>
                                    <option value="3" <?= ('3' == $status) ? "selected" : "" ?>>3</option>
                                  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
                            </div>
                        </div>
                    </form>
                </div>   
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">SUBJECT TYPE</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO IDENTITAS</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NAMA</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">TEMPAT LAHIR / PENDIRIAN</th>
                          
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL LAHIR / PENDIRIAN</th>
                                <th class="th-custom" style="color:#FFF;font-weight:bold;">TUJUAN PERMINTAAN</th>
							
							 <th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $call = "{call CPY_GET_PEFINDO_NODATA_NEW_TASKLIST_NEW_1(?,?,?)}";
                        // $call = "{call SP_GET_PEFINDO_NODATA_7(?,?,?,?,?,?)}";
                        //$call = "{call SP_GET_PEFINDO_NODATA_DUKCAPIL(?,?,?)}";
                        $param = array(array($startDate, SQLSRV_PARAM_IN), array($endDate, SQLSRV_PARAM_IN), array($status, SQLSRV_PARAM_IN));
                        $exec = sqlsrv_query($conn, $call, $param) or die(print_r(sqlsrv_errors(), true));
                        while ($data = sqlsrv_fetch_array($exec)) {
                            $no++;
                        ?>
                            <tr>
                                <td class="td-center"><?php echo $no; ?></td>
                                <td class="td-left"><?php echo $data['TIPE_DEBITUR']; ?></td>
                                <td class="td-left"><?php echo $data['ID_NO']; ?></td>
                                <td class="td-left"><?php echo $data['CUST_NAME']; ?></td>
                                <td class="td-left"><?php echo $data['BIRTH_PLACE']; ?></td>
								 <td class="td-left"><?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format("d-m-Y");}?></td>
								 <td class="td-left"><?php echo $data['TUJUAN_PERMINTAAN']; ?></td>
								 <td class="td-center">
                                    <?php
                                    if ($data['DESC_SUB_PARAM'] == "OPEN") {
                                        echo "<span class='badge' style='background-color:#d9534f;'>" . $data['LVL'] . "</span>";
                                    } else if ($data['DESC_SUB_PARAM'] == "ON PROGRESS") {
                                        echo "<span class='badge' style='background-color:#428bca;'>" . $data['LVL'] . "</span>";
                                    } else if ($data['DESC_SUB_PARAM'] == "REJECT") {
                                        echo "<span class='badge' style='background-color:#ffc107;'>" . $data['LVL'] . "</span>";
                                    } else {
                                        echo "<span class='badge' style='background-color:#5cb85c;'>" . $data['LVL'] . "</span>";
                                    }
                                    ?>
                                </td>
								 <td class="td-left">
								 <!-- <a href="index.php?page=detail-informasi-ideb&USERNAME=<?php //echo $user; ?>&no=<?php// echo $data['PROSPECT_NO']; ?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>-->
								 <?php if ($data['TUJUAN_PERMINTAAN'] == '01. Penilaian Calon Debitur' ){ ?>
								 <a href="index.php?page=detail-informasi-ideb-new&USERNAME=<?php echo $user;?>&id=<?php echo $data['PEFINDO_MAPPING_ID'];?>&prospect_no=<?php echo $data['PROSPECT_NO'];?>&no_ktp=<?php echo $data['ID_NO'];?>&branch_id=<?php echo $data['OFFICE_CODE'];?>
												&name=<?php echo $data['CUST_NAME'];?>&date=<?php echo $data['BIRTH_DT']->format('d-m-Y');?>&date1=<?php echo $data['BIRTH_DT']->format('Y-m-d');?>&birth_place=<?php echo $data['BIRTH_PLACE'];?>&tipe_cust=<?php echo $data['TIPE_CUST']?>
												&tipe_debitur=<?php echo $data['TIPE_DEBITUR']?>
												&tujuan=<?php echo $data['TUJUAN_PERMINTAAN']?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								 <?php }else if ($data['TUJUAN_PERMINTAAN'] == '03. Monitoring debitur existing' ){ ?>
								 <a href="index.php?page=detail-informasi-ideb-ho&USERNAME=<?php echo $user;?>&id=<?php echo $data['PEFINDO_MAPPING_ID'];?>&prospect_no=<?php echo $data['PROSPECT_NO'];?>&no_ktp=<?php echo $data['ID_NO'];?>&branch_id=<?php echo $data['OFFICE_CODE'];?>
												&name=<?php echo $data['CUST_NAME'];?>&date=<?php echo $data['BIRTH_DT']->format('d-m-Y');?>&date1=<?php echo $data['BIRTH_DT']->format('Y-m-d');?>&birth_place=<?php echo $data['BIRTH_PLACE'];?>&tipe_cust=<?php echo $data['TIPE_CUST']?>
												&tipe_debitur=<?php echo $data['TIPE_DEBITUR']?>
												&tujuan=<?php echo $data['TUJUAN_PERMINTAAN']?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
								<?php	} ?>
								 </td>
					<?php	} ?>
                            </tr>   
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
    $(document).ready(function() {
        setTimeout(function() {
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
            onClose: function(selectedDate) {
                $('#nodataendDate').datepicker("option", "minDate", selectedDate);
            }
        });
        $('#nodataendDate').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                $('#nodatastartDate').datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>