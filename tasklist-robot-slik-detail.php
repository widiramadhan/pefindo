<?php
require_once("config/configuration.php");
require_once("config/connection.php");
$date = date("Y-m-d");
$user = $_GET['USERNAME'];
$company = array(21, 22, 23, 24, 26, 27, 28, 29);

$prospect = $_GET['prospect'];
$nik = $_GET['nik'];
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
           
						
							
								
                <table class="table table-bordered table-striped" id="nodata" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">GENERATE NO IDEB</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">UPLOAD PDF</th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">UPLOAD TXT </th>
                            <th class="th-custom" style="color:#FFF;font-weight:bold;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $call = "{call SP_GET_DATA_LIST_REQUEST_SLIK_ROBOT_DETAIL(?,?)}";
                        // $call = "{call SP_GET_PEFINDO_NODATA_7(?,?,?,?,?,?)}";
                        //$call = "{call SP_GET_PEFINDO_NODATA_DUKCAPIL(?,?,?)}";
						$param = array(array($prospect, SQLSRV_PARAM_IN), array($nik, SQLSRV_PARAM_IN));
                        $exec = sqlsrv_query($conn, $call,$param) or die(print_r(sqlsrv_errors(), true));
                        while ($data = sqlsrv_fetch_array($exec)) {
                            $no++;
                        ?>
					
                            <tr>
                                <td class="td-center"><?php echo $no; ?></td>
                                <td class="td-left"><?php echo $data['NO_IDEB']; ?></td>
                                <td class="td-left">
									<?php if($data['TIPE_DEBITUR'] == 'INDIVIDUAL'){ ?>
						<form action="pages/action-upload-slik-robot-individu.php" method="post" enctype="multipart/form-data" id="myForm">
						<?php }else if($data['TIPE_DEBITUR'] == 'COMPANY'){?>
						<form action="pages/action-upload-slik-robot-individu.php" method="post" enctype="multipart/form-data" id="myForm">
						<?php }else if($data['TIPE_DEBITUR'] == 'PENGURUS'){?>
						<form action="pages/action-upload-slik-robot-individu.php" method="post" enctype="multipart/form-data" id="myForm">
						<?php } ?>
								<input type="file" name="file" class="form-control" >
								</td>
                                <td class="td-left">
								<input type="file" name="slik" id="slik" class="form-control" >
								</td>
                               
								 <td class="td-left">
								 
								 	
								 <input type="hidden" name="mapping_id" value="<?php echo $data['MAPPING_ID'];?>"> 
								<input type="hidden" name="prospect_no" value="<?php echo $data['PROSPECT_NO'];?>"> 
								<input type="hidden" name="no_ktp" value="<?php echo $data['ID_NO'];?>"> 
								<input type="hidden" name="user" value="<?php echo $user;?>"> 
								<input type="hidden" name="idebno" value="<?php echo $data['NO_IDEB'];?>"> 
								<input type="hidden" name="notFound" value=""> 
								 <button type="submit" class="btn btn-custom" name="submit" style="width:100%;">Submit</button>
								 	</form>
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