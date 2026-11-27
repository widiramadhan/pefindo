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
<style>
.th-custom{
	text-align:center;
	background-color:#035c7a;
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
.pagination > li > a, .pagination > li > span{
	background-color:#FFF;
	color:#035c7a;
}
.pagination > li.active > a, .pagination > li.active > span{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a:hover, .pagination > li.active > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.focus > a, .pagination > li.focus > span:hover{
	background-color:#035c7a;
	color:#FFF;
}
.pagination > li.active > a.page-link, .pagination > li.active > span.page-link{
	background-color:#035c7a;
	color:#FFF;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Upload SPK</h4>
                <p class="category">Daftar prospek yang tidak ada di pengecekan Pefindo</p>
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
                            <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">CARI</button>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">PROSPECT NO</th>
							 <th class="th-custom" style="color:#FFF;font-weight:bold;">ID NO</th>
                            <?php
                                if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RANI.VEMIA' || $_GET['USERNAME'] == 'rani.vemia' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA'){ 
                            ?>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">USER</th>
                            <?php } ?>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">STATUS</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=0;
                            $call = "{call SP_GET_UPLOAD_SPK(?,?,?)}";
                            $param = array(array($startDate, SQLSRV_PARAM_IN),array($endDate, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
                            $exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
                            while($data = sqlsrv_fetch_array($exec)){
                                $no++;
                        ?>
                        <tr>
                            <td class="td-center"><?php echo $no;?></td>
                            <td class="td-center"><?php echo $data['PROSPECT_NO'];?></td> 
							<td class="td-center"><?php echo $data['ID_NO'];?></td> 
                            <?php
                               if($_GET['USERNAME'] == 'iman.santoso' || $_GET['USERNAME'] == 'djoko.andrew' || $_GET['USERNAME'] == 'ramandona' || $_GET['USERNAME'] == 'IMAN.SANTOSO' || $_GET['USERNAME'] == 'DJOKO.ANDREW' || $_GET['USERNAME'] == 'RANI.VEMIA' || $_GET['USERNAME'] == 'rani.vemia' || $_GET['USERNAME'] == 'RAMANDONA' || $_GET['USERNAME'] == 'NOVRIKAWATI' || $_GET['USERNAME'] == 'KIKI.AMALIA' || $_GET['USERNAME'] == 'novrikawati' || $_GET['USERNAME'] == 'kiki.amalia' || $_GET['USERNAME'] == 'AHMAD.HABIBI' ||$_GET['USERNAME'] == 'DENY.SAPUTRA' || $_GET['USERNAME'] == 'Haris.Siswanto' || $_GET['USERNAME'] == 'HARIS.SISWANTO' || $_GET['USERNAME'] == 'Yose.Kertapati' || $_GET['USERNAME'] == 'YOSE.KERTAPATI'	|| $_GET['USERNAME'] == 'Muhammad' || $_GET['USERNAME'] == 'MUHAMMAD' || $_GET['USERNAME'] == 'Ramandona.Dinara' || $_GET['USERNAME'] == 'RAMANDONA.DINARA'){ 
                            ?>
                            <td class="td-center"><?php echo $data['CREATE_USER'];?></td>
                            <?php } ?>                  
							<td class="td-center">
								<?php
									if($data['IMG_SPK'] == "1"){
										echo"<span class='badge' style='background-color:#5cb85c;'>Upload</span>";
									}else{
										echo"<span class='badge' style='background-color:#d9534f;'>Belum Upload</span>";
									}
								?>		
							</td>
							<td class="td-center">
							<?php if($data['DESC_SUB_PARAM'] == "REJECT"){ ?>
								<a href="index.php?page=note-detail&USERNAME=<?php echo $user;?>&id=<?php echo $data['PEFINDO_MAPPING_ID'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
							<?php }else{ ?>
								<a href="index.php?page=detail-upload-spk&USERNAME=<?php echo $user;?>&nik=<?php echo $data['ID_NO'];?>" class="btn btn-custom btn-xs"><i class="fa fa-eye"></i> DETAIL</a>
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