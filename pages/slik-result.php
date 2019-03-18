<?php
$id=$_GET['id'];

//update progress
$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
$param = array(array($id, SQLSRV_PARAM_IN),array(1, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 

if(isset($_POST['notFound'])){
	$callInsert = "{call SP_INSERT_SLIK_RESULT(?,?,?,?,?,?,?,?,?,?,?)}";
	$paramInsert = array(
						array($id, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(NULL, SQLSRV_PARAM_IN),
						array(2, SQLSRV_PARAM_IN));
	$execInsert = sqlsrv_query( $conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));
	
	//update progress
	$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
	$param = array(array($id, SQLSRV_PARAM_IN),array(2, SQLSRV_PARAM_IN));
	$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
	
	if($execInsert){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
}else{
	if(isset($_POST['submit_slik'])){
		$daysOD=$_POST['daysOD'];
		$rangeDaysOD=$_POST['rangeDaysOD'];
		$slikScore=$_POST['slikScore'];
		$fasilitasAktif=$_POST['fasilitasAktif'];
		$totalPlafond=str_replace(",","",$_POST['totalPlafond']);
		$totalBakiDebet=str_replace(",","",$_POST['totalBakiDebet']);
		$pinjamanLancar=str_replace(",","",$_POST['pinjamanLancar']);
		$pinjamanMacet=str_replace(",","",$_POST['pinjamanMacet']);
		$totalPinjaman=$pinjamanLancar+$pinjamanMacet;
		
		$callInsert = "{call SP_INSERT_SLIK_RESULT(?,?,?,?,?,?,?,?,?,?,?)}";
		$paramInsert = array(
							array($id, SQLSRV_PARAM_IN),
							array($daysOD, SQLSRV_PARAM_IN),
							array($rangeDaysOD, SQLSRV_PARAM_IN),
							array($slikScore, SQLSRV_PARAM_IN),
							array($fasilitasAktif, SQLSRV_PARAM_IN),
							array($totalPlafond, SQLSRV_PARAM_IN),
							array($totalBakiDebet, SQLSRV_PARAM_IN),
							array($pinjamanLancar, SQLSRV_PARAM_IN),
							array($pinjamanMacet, SQLSRV_PARAM_IN),
							array($totalPinjaman, SQLSRV_PARAM_IN),
							array(1, SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));
		
		//update progress
		$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
		$param = array(array($id, SQLSRV_PARAM_IN),array(2, SQLSRV_PARAM_IN));
		$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));

		if($execInsert){
			echo"<script>alert('Data berhasil disimpan');window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
		}else{
			echo"<script>alert('Data gagal disimpan');history.back();</script>";
		}
	}
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Input SLIK Result</h4>
                <p class="category">Please input SLIK Result in here</p>
            </div>
            <div class="content">
				<form action="" method="post">
					<table class="table" style="width:100%;">
						<tr>
							<td><label>Data tidak ditemukan ?</label></td>
							<td>:</td>
							<td><input type="checkbox" name="notFound" id="notFound" value="2" onclick="myFunction()"> &nbsp;<label>Data tidak ditemukan di SLIK</label></td>
						</tr>
						<tr>
							<td><label>Days OD</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="daysOD" id="daysOD" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Range Days OD</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" id="rangeDaysOD" disabled onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>SLIK Score</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" id="slikScore" disabled onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Fasilitas Aktif (Account)</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="fasilitasAktif" id="fasilitasAktif" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Total Plafond</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="totalPlafond" id="totalPlafond" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Total Baki Debet</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="totalBakiDebet" id="totalBakiDebet" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Pinjaman Lancar</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="pinjamanLancar" id="pinjamanLancar" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td><label>Pinjaman Macet</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="pinjamanMacet" id="pinjamanMacet" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								<input type="hidden" name="rangeDaysOD" id="rangeDaysOD2">
								<input type="hidden" name="slikScore" id="slikScore2">
								<input type="hidden" name="checked" id="checked">
								
								<input type="submit" name="submit_slik" class="btn btn-primary" value="SUBMIT">
								<input type="reset" class="btn btn-default" value="CANCEL">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
		$('#daysOD').on('change', function() {
			var od = $('#daysOD').val();
			if(od >= 0 && od <=60){
				$('#rangeDaysOD').val("0 - 60");
				$('#slikScore').val("1");
				$('#rangeDaysOD2').val("0 - 60");
				$('#slikScore2').val("1");
			}else if(od >= 61 && od <=90){
				$('#rangeDaysOD').val("61 - 90");
				$('#slikScore').val("2");
				$('#rangeDaysOD2').val("61 - 90");
				$('#slikScore2').val("2");
			}else if(od >= 91 && od <=120){
				$('#rangeDaysOD').val("91 - 120");
				$('#slikScore').val("3");
				$('#rangeDaysOD2').val("91 - 120");
				$('#slikScore2').val("3");
			}else if(od >= 121 && od <=180){
				$('#rangeDaysOD').val("121 - 180");
				$('#slikScore').val("4");
				$('#rangeDaysOD2').val("121 - 180");
				$('#slikScore2').val("4");
			}else if(od > 180){
				$('#rangeDaysOD').val("> 180");
				$('#slikScore').val("5");
				$('#rangeDaysOD2').val("> 180");
				$('#slikScore2').val("5");
			}
		});
		
		
		
		$("#totalPlafond").on('keyup', function(){
			var n = parseInt($(this).val().replace(/\D/g,''),10);
			if($("#totalPlafond").val() != ""){
				$(this).val(n.toLocaleString());
			}
		});
		$("#totalBakiDebet").on('keyup', function(){
			var n = parseInt($(this).val().replace(/\D/g,''),10);
			if($("#totalBakiDebet").val() != ""){
				$(this).val(n.toLocaleString());
			}
		});
		$("#pinjamanLancar").on('keyup', function(){
			var n = parseInt($(this).val().replace(/\D/g,''),10);
			if($("#pinjamanLancar").val() != ""){
				$(this).val(n.toLocaleString());
			}
		});
		$("#pinjamanMacet").on('keyup', function(){
			var n = parseInt($(this).val().replace(/\D/g,''),10);
			if($("#pinjamanMacet").val() != ""){
				$(this).val(n.toLocaleString());
			}
		});
	});
	
	function onlyNumber(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57) || (charCode > 0 && charCode < 28) ){
			return false;
		}
		return true;
	}
	
	function setFormat(id) {
		if (document.getElementById(id).value != "") {
			document.getElementById(id).value = parseFloat(document.getElementById(id).value.replace(/\//g, ""))
				.toString()
				.replace(/\B(?=(\d{3})+(?!\d))/g, "/");
		}
	}
	
	function myFunction() {
		var checkBox = document.getElementById("notFound");

		if (checkBox.checked == true){
			$('#slikScore').val("2");
			$('#daysOD').attr("disabled", "disabled");
			$('#fasilitasAktif').attr("disabled", "disabled");
			$('#totalPlafond').attr("disabled", "disabled");
			$('#totalBakiDebet').attr("disabled", "disabled");
			$('#pinjamanLancar').attr("disabled", "disabled");
			$('#pinjamanMacet').attr("disabled", "disabled");
			
			$('#daysOD').val("");
			$('#rangeDaysOD').val("");
			$('#slikScore').val("");
			$('#fasilitasAktif').val("");
			$('#totalPlafond').val("");
			$('#totalBakiDebet').val("");
			$('#pinjamanLancar').val("");
			$('#pinjamanMacet').val("");
			
			$('#rangeDaysOD2').val("");
			$('#slikScore2').val("");
		}else{
			$('#slikScore').val("1");
			$('#daysOD').removeAttr("disabled", "disabled");
			$('#fasilitasAktif').removeAttr("disabled", "disabled");
			$('#totalPlafond').removeAttr("disabled", "disabled");
			$('#totalBakiDebet').removeAttr("disabled", "disabled");
			$('#pinjamanLancar').removeAttr("disabled", "disabled");
			$('#pinjamanMacet').removeAttr("disabled", "disabled");
			
			$('#daysOD').val("");
			$('#rangeDaysOD').val("");
			$('#slikScore').val("");
			$('#fasilitasAktif').val("");
			$('#totalPlafond').val("");
			$('#totalBakiDebet').val("");
			$('#pinjamanLancar').val("");
			$('#pinjamanMacet').val("");
			
			$('#rangeDaysOD2').val("");
			$('#slikScore2').val("");
		}
	} 
</script>