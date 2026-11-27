<?php
require_once("config/configuration.php");
if(isset($_POST['submit'])){
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
	$notes=$_POST['notes'];
	
	$call5 = "{call SP_INSERT_DUKCAPIL_REJECT(?,?,?,?,?)}";
	$param5 = array(array($prospect, SQLSRV_PARAM_IN),array($no_ktp, SQLSRV_PARAM_IN),array($nama, SQLSRV_PARAM_IN),array($notes, SQLSRV_PARAM_IN),array($_GET['USERNAME'], SQLSRV_PARAM_IN));
	$exec5 = sqlsrv_query( $conn, $call5, $param5) or die( print_r( sqlsrv_defaults(), true)); 
	
	//update status jadi finish
	$call6 = "{call SP_UPDATE_DUKCAPIL_HOLD(?,?,?)}";
	$param6 = array(array($prospect, SQLSRV_PARAM_IN),
					array($no_ktp, SQLSRV_PARAM_IN),
					array('5', SQLSRV_PARAM_IN));
	$exec6 = sqlsrv_query( $conn, $call6, $param6) or die( print_r( sqlsrv_defaults(), true)); 
	$data6= sqlsrv_fetch_array($exec6);
	
	if($exec5){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=pefindonodata&USERNAME=".$getUsername."'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
	
	

}else{
	$prospect=$_POST['prospect_no'];
	$no_ktp=$_POST['no_ktp'];
	$nama=$_POST['name'];
	$date = date("Y-m-d", strtotime($_POST['date']));
	//$date=$_POST['date'];
	$mother_nm=$_POST['mother_name'];
	$birth_place=$_POST['birth_place'];
	$siapanih=$_POST['tipe_cust'];
	$getUsername=$_GET['USERNAME'];
}	
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Dukcapil Reject</h4>
				<p class="category">Reject Dukcapil Yang Tidak Sesuai</p>
			</div>
			<div class="content">
				<form action="" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nomor KTP</label>
								<input type="text" name="ktp" class="form-control" disabled value="<?php echo $no_ktp;?> ">
							</div>
						</div>
				
				
						<div class="col-md-6">
							<div class="form-group">
								<label>Prospect / Order No</label>
								<input type="text" name="prospect" class="form-control" disabled value="<?php echo $prospect;?> ">
							</div>
						</div>
				</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Nama</label>
								<input type="text" name="nama" class="form-control"  disabled value="<?php echo $nama;?> ">
							</div>
						</div>
				
					
						<div class="col-md-6">
							<div class="form-group">
								<label>Tipe</label>
								<input type="text" name="tipe" class="form-control" disabled value="<?php echo $siapanih;?> ">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>User</label>
								<input type="text" name="tipe" class="form-control" disabled value="<?php echo $getUsername;?> ">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Notes</label>
								<textarea type="text" name="notes" class="form-control"></textarea>
							</div>
						</div>
					</div>
					<input name='prospect_no' type='hidden' value='<?php echo $prospect;?>'>
					<input name='no_ktp' type='hidden' value='<?php echo $no_ktp;?>'>
					<input name='name' type='hidden' value="<?php echo $nama;?>">
					<input name='date' type='hidden' value='<?php echo $date;?>'>
					<input name='mother_name' type='hidden' value="<?php echo $mother_nm;?>">
					<input name='birth_place' type='hidden' value='<?php echo $birth_place;?>'>
					<input name='tipe_cust' type='hidden' value='<?php echo $siapanih;?>'>
					<div class="pull-right">
						<input type="submit" name="submit" class="btn btn-custom" value="KIRIM">
					</div>
					
					
					<div style="clear:both;"></div>
				</form>
				<hr>
				
			</div>
		</div>
	</div>
</div>
