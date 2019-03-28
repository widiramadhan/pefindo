<?php
    require_once("config/configuration.php");
    require_once("config/connection.php");
    $date=date("Y-m-d");


    if(isset($_POST['submit'])){
        $startDate = $_POST['nodatastartDate'];
        $endDate = $_POST['nodataendDate'];
    }else{
        $startDate = date("Y-m-d");
        $endDate = date("Y-m-d");
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
.th-custom{
	text-align:center;
}
.td-center{
	text-align:center;
}
.loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 99999999999999999999999999999;
    background: url('assets/img/basicloader.gif') 50% 50% no-repeat rgb(255,255,255);
    opacity: 1;
}
</style>
<div class="loader" id="loader"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Tasklist SLIK</h4>
                <p class="category">Please search for data not found in Pefindo here</p>
            </div>
            <div class="content">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Start Date</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" name="nodatastartDate" id="nodatastartDate" autocomplete="off" value="<?php echo $startDate;?>">
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
                                    <input type="text" class="form-control" name="nodataendDate" id="nodataendDate" autocomplete="off" value="<?php echo $endDate;?>">
                                    <div class="input-group-addon">
                                        <span class="add-on"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            &nbsp;<br>
                            <button type="submit" class="btn btn-primary" name="submit" style="width:100%;">Cari</button>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom">NO</th>
                            <th class="th-custom">PROSPECT NO</th>
                            <th class="th-custom">NAME</th>
                            <th class="th-custom">NO KTP</th>
                            <th class="th-custom">CUSTOMER TYPE</th>
                            <th class="th-custom">CUSTOMER</th>
                            <th class="th-custom">CREATE DATE</th>
							<th class="th-custom">STATUS</th>
                            <th class="th-custom">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0;
                            $call = "{call SP_GET_PEFINDO_NODATA(?,?)}";
                            $param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN));
                            $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
                            while($data = sqlsrv_fetch_array($exec)){
                                $no++;
                        ?>
                        <tr>
                            <td class="td-center"><?php echo $no;?></td>
                            <td class="td-center"><?php echo $data['PROSPECT_NO'];?></td>                            
                            <td class="td-center"><?php echo $data['CUST_NAME'];?></td>
                            <td class="td-center"><?php echo $data['ID_NO'];?></td>
                            <td class="td-center"><?php if($data['CUST_TYPE']=="P"){echo"Individual";}else{echo"Company";}?></td>
                            <td class="td-center"><?php echo $data['TIPE_CUST'];?></td>
                            <td class="td-center"><?php echo $data['CREATE_DATE']->format("d-m-Y");?></td>
							<td class="td-center">
								<?php
									if($data['SUB_PARAM_ID'] == "0"){
										echo"<span class='badge' style='background-color:#d9534f;'>".$data['DESC_SUB_PARAM']."</span>";
									}else if($data['SUB_PARAM_ID'] == "1"){
										echo"<span class='badge' style='background-color:#428bca;'>".$data['DESC_SUB_PARAM']."</span>";
									}else{
										echo"<span class='badge' style='background-color:#5cb85c;'>".$data['DESC_SUB_PARAM']."</span>";
									}
								?>		
							</td>
							<td class="td-center">
								<?php
									if($data['SUB_PARAM_ID'] == "0" || $data['SUB_PARAM_ID'] == "1"){
										echo'<button type="button" class="btn btn-primary btn-sm" disabled>SLIK RESULT</button> ';
									}else if($data['SUB_PARAM_ID'] == "2"){
										echo'<a href="index.php?USERNAME='.$user.'&page=slik-result&id='.$data['PEFINDO_MAPPING_ID'].'" class="btn btn-primary btn-sm">SLIK RESULT</a> ';
									}
									
									if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona'){
										if($data['SUB_PARAM_ID'] == "0"){
											echo'&nbsp;&nbsp;<a href="pages/update-progress.php?USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&flag=0" class="btn btn-danger btn-sm"><i class="fa fa-thumbs-down"></i> Kerjakan</a>';
										}else if($data['SUB_PARAM_ID'] == "1"){
											echo'&nbsp;&nbsp;<a href="pages/update-progress.php?USERNAME='.$user.'&id='.$data['PEFINDO_MAPPING_ID'].'&flag=1" class="btn btn-warning btn-sm"><i class="fa fa-thumbs-down"></i> Selesaikan</a>';
										}else if($data['SUB_PARAM_ID'] == "2"){
											echo'&nbsp;&nbsp;<a href="#" disabled class="btn btn-success btn-sm"><i class="fa fa-thumbs-up"></i> Done</a>';
										}
									}else{
										
									}
								?>
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
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function(){
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