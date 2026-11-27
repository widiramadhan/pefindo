<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date=date("Y-m-d");


if(isset($_POST['submit'])){
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];
}else{
	$startDate = date("Y-m-d");
	$endDate = date("Y-m-d");
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
                <h4 class="title">Log SLIK</h4>
                <p class="category">Log penggunaan SLIK</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="startDate" id="startDate"
                                        autocomplete="off" value="<?php echo $startDate;?>">
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
                                    <input type="text" class="form-control" name="endDate" id="endDate"
                                        autocomplete="off" value="<?php echo $endDate;?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            &nbsp;<br>
                            <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
                        </div>
                        <div class="col-md-2">
                            &nbsp;<br>
                            <a href="pages/export-slik.php?startDate=<?php echo $startDate;?>&endDate=<?php echo $endDate;?>"
                                class="btn btn-custom" style="width:100%;">EXPORT TO EXCEL</a>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="history" style="font-size:10px;">
                        <thead>
                            <tr>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NAMA CABANG
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">TIPE</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT NO
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">NO
                                    IDENTITAS</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">TIPE
                                    CUSTOMER</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">REQUEST
                                    DATE</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">CHECKIN
                                    DATE</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">CHECKOUT
                                    DATE</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">INPUT DATE
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">USER
                                    REQUEST</th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">CHECKED BY
                                </th>
                                <th class="th-custom" class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
								$no=0;
								$call = "{call CPY_GET_LOG_SLIK(?,?)}";
								$param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN));
								$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
								while($data = sqlsrv_fetch_array($exec)){
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
                                <td class="td-center"><?php echo $no;?></td>
                                <td><?php echo $data['OFFICE_NAME'];?></td>
                                <td class="td-center"><?php echo $data['TYPE'];?></td>
                                <td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>
                                <td class="td-center"><?php echo $data['ID_NO'];?></td>
                                <td class="td-center"><?php echo $data['TIPE_CUST'];?></td>
                                <td class="td-center">
                                    <?php if($data['REQUEST_DATE']<>NULL){echo $data['REQUEST_DATE']->format("Y-m-d H:i:s");}?>
                                </td>
                                <td class="td-center">
                                    <?php if($data['CHECKIN_DATE']<>NULL){echo $data['CHECKIN_DATE']->format("Y-m-d H:i:s");}?>
                                </td>
                                <td class="td-center">
                                    <?php if($data['CHECKOUT_DATE']<>NULL){echo $data['CHECKOUT_DATE']->format("Y-m-d H:i:s");}?>
                                </td>
                                <td class="td-center">
                                    <?php if($data['INPUT_DATE']<>NULL){echo $data['INPUT_DATE']->format("Y-m-d H:i:s");}?>
                                </td>
                                <td class="td-center"><?php echo $data['REQUEST_BY'];?></td>
                                <td class="td-center"><?php echo $data['CHECKED_BY'];?></td>
                                <td class="td-center"><?php echo $data['STATUS'];?></td>
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