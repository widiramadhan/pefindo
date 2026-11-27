<?php
$id=$_GET['id'];

$callPDF = "{call SP_GET_PDF_SLIK(?)}";
$paramPDF = array(array($id, SQLSRV_PARAM_IN));
$execPDF = sqlsrv_query( $conn, $callPDF, $paramPDF) or die( print_r( sqlsrv_errors(), true));
$dataPDF = sqlsrv_fetch_array($execPDF);

//update progress
/*$call = "{call SP_UPDATE_SLIK_RESULT(?,?)}";
$param = array(array($id, SQLSRV_PARAM_IN),array(1, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));*/

	
if(isset($_POST['submit'])){
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
		$execInsert = sqlsrv_query($conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));
		
		if($execInsert){
			echo"<script>alert('Data berhasil disimpan');window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
		}else{
			echo"<script>alert('Data gagal disimpan');history.back();</script>";
		}
	}else{
		$jenisFasilitas=$_POST['jenis_fasilitas'];
		$daysOD=$_POST['daysOD'];
		$slikScore=$_POST['slikScore'];
		$totalPlafond=str_replace(".","",str_replace(",","",$_POST['totalPlafond']));
		$totalBakiDebet=str_replace(".","",str_replace(",","",$_POST['totalBakiDebet']));
		if($jenisFasilitas == "Credit Card"){
			$akadAwal=NULL;
			$akadAkhir=NULL;
	
		}else{
			$akadAwal=$_POST['akad_awal'];
			$akadAkhir=$_POST['akad_akhir'];
		}
		
		$callInsert = "{call SP_INSERT_FASILITAS_SLIK(?,?,?,?,?,?,?,?,?)}";
		$paramInsert = array(
							array($id, SQLSRV_PARAM_IN),
							array($jenisFasilitas, SQLSRV_PARAM_IN),
							array($daysOD, SQLSRV_PARAM_IN),
							array($slikScore, SQLSRV_PARAM_IN),
							array($totalPlafond, SQLSRV_PARAM_IN),
							array($totalBakiDebet, SQLSRV_PARAM_IN),
							array($akadAwal, SQLSRV_PARAM_IN),
							array($akadAkhir, SQLSRV_PARAM_IN),
							array($_GET['USERNAME'], SQLSRV_PARAM_IN));
		$execInsert = sqlsrv_query( $conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));

		if($execInsert){
			echo"<script>alert('Data berhasil disimpan');window.location='index.php?page=slik-result&USERNAME=".$user."&id=".$id."'</script>";
		}else{
			echo"<script>alert('Data gagal disimpan');history.back();</script>";
		}
	}
}else if(isset($_POST['submit_slik'])){
	$mapping_id=$_POST['id_mapping'];
	
	$callInsert = "{call SP_INSERT_SLIK_RESULT_NEW(?)}";
	$paramInsert = array(array($mapping_id, SQLSRV_PARAM_IN));
	$execInsert = sqlsrv_query( $conn, $callInsert, $paramInsert) or die( print_r( sqlsrv_errors(), true));

	if($execInsert){
		echo"<script>alert('Data berhasil disimpan');window.location='index.php?USERNAME=".$user."&page=pefindonodata'</script>";
	}else{
		echo"<script>alert('Data gagal disimpan');history.back();</script>";
	}
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
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="header">
                <h4 class="title">Input Hasil SLIK</h4>
                <p class="category">Input hasil SLIK berdasarkan PDF yang tertera</p>
            </div>
            <div class="content">
				<form action="" method="post">
					<h4 style="margin-top:5px;">Fasilitas</h4>
					<table class="table" style="width:100%;">
						<tr>
							<td><label>Data tidak ditemukan ?</label></td>
							<td>:</td>
							<td><input type="checkbox" name="notFound" id="notFound" value="2" onclick="myFunction()"> &nbsp;<label>Data tidak ditemukan di SLIK</label></td>
						</tr>
						<!--
						<tr>
							<td><label>Jenis Fasilitas</label></td>
							<td>:</td>
							<td>
								<input type="radio" name="jenis_fasilitas" id="jenis_fasilitas" value="Credit Card" checked> &nbsp;<label>Credit Card</label> &nbsp; &nbsp; &nbsp;
								<input type="radio" name="jenis_fasilitas" id="jenis_fasilitas2" value="Non Credit Card"> &nbsp;<label>Non Credit Card</label>
							</td>
						</tr>
						<tr>
							<td><label>Days OD Terakhir</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="daysOD" id="daysOD" onkeypress="return onlyNumber(event)"></td>
						</tr>-->
						<tr style="display:none;">
							<td><label>Range Days OD</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" id="rangeDaysOD" disabled onkeypress="return onlyNumber(event)"></td>
						</tr>
						<!--
						<tr>
							<td><label>SLIK Score</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" id="slikScore" disabled onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr style="display:none;">
							<td><label>Fasilitas Aktif (Account)</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="fasilitasAktif" id="fasilitasAktif" onkeypress="return onlyNumber(event)" maxlength="4"></td>
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
						</tr>-->
						<tr style="display:none;">
							<td><label>Pinjaman Lancar</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="pinjamanLancar" id="pinjamanLancar" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr style="display:none;">
							<td><label>Pinjaman Macet</label></td>
							<td>:</td>
							<td><input type="text" class="form-control" name="pinjamanMacet" id="pinjamanMacet" onkeypress="return onlyNumber(event)"></td>
						</tr>
						<tr id="tgl_akad_awal">
							<td><label>Tanggal Akad Awal</label></td>
							<td>:</td>
							<td>
								<div class="input-group date">
									<input type="text" class="form-control" name="akad_awal" id="akad_awal" autocomplete="off">
									<div class="input-group-addon">
										<span class="add-on"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</td>
						</tr>
						<tr id="tgl_akad_akhir">
							<td><label>Tanggal Akad Akhir</label></td>
							<td>:</td>
							<td>
								<div class="input-group date">
									<input type="text" class="form-control" name="akad_akhir" id="akad_akhir" autocomplete="off">
									<div class="input-group-addon">
										<span class="add-on"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="right">
								<input type="hidden" name="rangeDaysOD" id="rangeDaysOD2">
								<input type="hidden" name="slikScore" id="slikScore2">
								<input type="hidden" name="checked" id="checked">
								
								<input type="submit" name="submit" class="btn btn-custom" value="SIMPAN">
								<input type="reset" class="btn btn-custom" value="CANCEL">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<?php
			$file = "assets/doc/".$dataPDF['PDF_SRC'];
			if($dataPDF['PDF_SRC'] <> ""){
				if(file_exists($file)){
					echo'<iframe src="assets/doc/'.$dataPDF['PDF_SRC'].'" style="width:100%;height:700px;"></iframe>';
				}else{
					echo'<iframe src="assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
				}
			}else{
				echo'<iframe src="assets/doc/notfound.pdf" style="width:100%;height:700px;"></iframe>';
			}
		?>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="header">
				<h4 class="title">Fasilitas</h4>
				<div class="pull-left">
					<p class="category">Fasilitas yang tertera di SLIK</p>
				</div>
				<div class="pull-right">
					<form action="" method="post">
						<input name="id_mapping" type="hidden" value="<?php echo $id;?>">
						<input type="submit" name="submit_slik" class="btn btn-custom" value="SUBMIT SEMUA FASILITAS" onclick="return confirm('Apakah anda yakin ingin menyimpan semua data fasilitas?');">
					</form>
				</div>
				<div style="clear:both;"></div>
            </div>
            <div class="content">
				<table class="table table-bordered table-striped" id="history" style="font-size:12px;">
					<thead>
						<tr>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">NO</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">JENIS FASILITAS</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">DAYS OD TERAKHIR</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">SLIK SCORE</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL PLAFOND</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">TOTAL BAKI DEBET</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AWAL</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">TANGGAL AKAD AKHIR</th>
							<th class="th-custom" style="color:#FFF;font-weight:bold;">CREATE DATE</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$call = "{call SP_GET_FASILITAS_SLIK(?)}";
						$param = array(array($id, SQLSRV_PARAM_IN));
						$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
						$no=0;
						while($data = sqlsrv_fetch_array($exec)){
							$no++;
						?>
						<tr>
							<td class="td-center"><?php echo $no;?></td>
							<td><?php echo $data['JENIS_FASILITAS'];?></td>
							<td class="td-center"><?php echo $data['DAYS_OD_TERAKHIR'];?></td>
							<td class="td-center"><?php echo $data['SLIK_SCORE'];?></td>
							<td style="text-align:right;">Rp. <?php echo number_format($data['TOTAL_PLAFOND']);?></td>
							<td style="text-align:right;">Rp. <?php echo number_format($data['TOTAL_BAKI_DEBET']);?></td>
							<td class="td-center"><?php if($data['TANGGAL_AKAD_AWAL']<>NULL){echo $data['TANGGAL_AKAD_AWAL']->format('Y-m-d');}?></td>
							<td class="td-center"><?php if($data['TANGGAL_AKAD_AKHIR']<>NULL){echo $data['TANGGAL_AKAD_AKHIR']->format('Y-m-d');}?></td>
							<td class="td-center"><?php echo $data['CREATE_DATE']->format('Y-m-d H:i:s');?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$('#history').DataTable({
		"bPaginate": true,
		"bLengthChange": true,
        "bFilter": true,
        "bInfo": true
	});
	$('#akad_awal').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		onClose: function(selectedDate) {
			$('#akad_akhir').datepicker("option", "minDate", selectedDate);
		}
	});
	$('#akad_akhir').datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		onClose: function(selectedDate) {
			$('#akad_awal').datepicker("option", "maxDate", selectedDate);
		}
	});
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
			$('#tgl_akad_awal').removeAttr("style").hide();
			$('#tgl_akad_akhir').removeAttr("style").hide();
		
		$('#jenis_fasilitas').click(function(){
			$('#tgl_akad_awal').removeAttr("style").hide();
			$('#tgl_akad_akhir').removeAttr("style").hide();
		});
		$('#jenis_fasilitas2').click(function(){
			$('#tgl_akad_awal').show();
			$('#tgl_akad_akhir').show();
		});
		
		
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
			$('#jenis_fasilitas').attr("disabled", "disabled");
			$('#jenis_fasilitas2').attr("disabled", "disabled");
			$('#akad_awal').attr("disabled", "disabled");
			$('#akad_akhir').attr("disabled", "disabled");
			
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
			$('#jenis_fasilitas').removeAttr("disabled", "disabled");
			$('#jenis_fasilitas2').removeAttr("disabled", "disabled");
			$('#akad_awal').removeAttr("disabled", "disabled");
			$('#akad_akhir').removeAttr("disabled", "disabled");
			
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