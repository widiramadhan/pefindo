<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Sistem Informasi Debitur</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" type="text/css">
	<!--<link href="assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" type='text/css'>-->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<?php
require_once("config/configuration.php");
require_once("config/connection.php");
if(isset($_GET['username'])){
	$user=$_GET['username'];
}else{
	echo"<script>window.location='access-denied.php'</script>";
}
?>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="red" data-image="assets/img/sidebar-5.jpg">
    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.creative-tim.com" class="simple-text">
                    H2H PEFINDO - SFI
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="index.php?username=<?php echo $user;?>">
                        <i class="pe-7s-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li>
                    <a href="index.php?username=<?php echo $user;?>&page=individual">
                        <i class="pe-7s-user"></i>
                        <p>Individual</p>
                    </a>
                </li>
                <li>
                    <a href="index.php?username=<?php echo $user;?>&page=company">
                        <i class="pe-7s-id"></i>
                        <p>Company</p>
                    </a>
                </li>
				<li>
                    <a href="index.php?username=<?php echo $user;?>&page=history">
                        <i class="pe-7s-note"></i>
                        <p>History</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                              <a href="">
                                    <p>
										<i class="fa fa-user"></i> <?php echo $user;?>
									</p>
                              </a>
                        </li>
						<li class="separator hidden-lg"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
				<?php require_once("content.php");?>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy; 2018 Suzuki Finance Indonesia. All Right Reserved
                </p>
            </div>
        </footer>

    </div>
</div>
</body>
<!-- MODAL PROSPECT INDIVIDUAL -->
<div id="prospect" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Data Prospect</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="example" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Prospect Number</th>
										<th>KTP Number</th>
										<th>Fullname</th>
										<th>Date of Birth</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$callGetProspect = "{call SP_GET_PROSPEK_NUMBER}";
									$execGetProspect = sqlsrv_query($conn, $callGetProspect) or die( print_r( sqlsrv_errors(), true));
									$no=0;
									while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
										$no++;
								?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
										<td><?php echo $rowGetProspect['ID_NO'];?></td>
										<td><?php echo $rowGetProspect['CUST_NAME'];?></td>
										<td><?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?></td>
										<td>
											<form action="" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
												<input type="hidden" name="id_no" value="<?php echo $rowGetProspect['ID_NO'];?>">
												<input type="hidden" name="cust_name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
												<input type="hidden" name="birth_dt" value="<?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?>">
												<button type="submit" name="select" class="btn btn-success">Select</button>
											</form>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL PROSPECT COMPANY -->
<div id="prospectCompany" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Data Prospect</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="exampleCompany" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>No</th>
										<th>Prospect Number</th>
										<th>NPWP</th>
										<th>Company Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_COMPANY}";
									$execGetProspect = sqlsrv_query($conn, $callGetProspect) or die( print_r( sqlsrv_errors(), true));
									$no=0;
									while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
										$no++;
								?>
									<tr>
										<td><?php echo $no;?></td>
										<td><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
										<td><?php echo $rowGetProspect['NPWP'];?></td>
										<td><?php echo $rowGetProspect['CUST_NAME'];?></td>
										<td>
											<form action="" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
												<input type="hidden" name="id_no" value="<?php echo $rowGetProspect['NPWP'];?>">
												<input type="hidden" name="comp_name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
												<button type="submit" name="select" class="btn btn-success">Select</button>
											</form>
										</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.maskedinput.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<!--<script src="assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/series-label.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
</html>
<script>
$(document).ready(function() {
    $('#example').DataTable({
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
	});
	$('#exampleCompany').DataTable({
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
	});
	/*$('#datepicker').datepicker({
		dateFormat: 'yy-mm-dd',
		endDate: "today",
		yearRange: '1950:2024',
		changeMonth: true,
		changeYear: true,
		autoclose: true
	});*/
});
</script>