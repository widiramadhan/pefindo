<?php

require_once("config/configuration.php");
require_once("config/connection.php");


if(isset($_POST['submit'])){
$order = $_POST['order'];
$user = $_GET['USERNAME'];

$call = "{call SP_GET_DATA_ORDER_PEMOHON_PASANGAN_SURAT_PERNYATAAN(?)}";
$param = array(array($order, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
$data = sqlsrv_fetch_array($exec);

}
else{
$order = "";
$user = $_GET['USERNAME'];
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
<div class="col-md-12">
<div class="card">
<div class="header">
<h4 class="title">Cetak Surat Pernyataan</h4>
<p class="category">Cari Nomor Order untuk cetak</p>
</div>
<div class="content">
<form action="" method="post">


<div class="col-md-6">
<div class="form-group">
<label>Search Nomor Order</label>
<input type="text" class="form-control" name="order" id="order" autocomplete="off" value="<?php echo $order;?>">

</div>
</div>


<div class="col-md-6">
<br>
<div class="pull-right">
<input type="submit" name="submit" class="btn btn-custom" value="Cari">
</div>
</div>
<div style="clear:both;"></div>
</form>
<hr>



</div>
</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<h4 class="title">Data Order</h4><br>
						<div class="table-responsive">
							<?php if(isset($_POST['submit'])){ ?>
								<table class="table table-bordered table-striped" style="width:100%;font-size:10px;" id="history" name= "history">
									<thead >
										<tr>
											
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">ORDER NO</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PEMOHON NIK</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PEMOHON NAME</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PEMOHON TGL LAHIR</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PEMOHON IBU</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">STATUS KAWIN PEMOHON</th>
											<?php if($data['TIPE_PASANGAN'] == 'PASANGAN'){?>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PASANGAN NIK</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PASANGAN NAME</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PASANGAN TGL LAHIR</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PASANGAN IBU</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">STATUS KAWIN PASANGAN</th>
											<?php } else {?>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PENJAMIN NIK</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PENJAMIN_NAME</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PENJAMIN TGL LAHIR</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">PENJAMIN IBU</th>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px; text-align:center">STATUS KAWIN PENJAMIN</th>
											<?php } ?>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;font-size:10px;">ACTION</th>
										</tr>
										
									</thead>
									<tbody>
										<tr>
											
											<td><?php echo $data['ORDER_NO'];?></td>
											<td><?php echo $data['ID_NO_PEMOHON'];?></td>
											<td><?php echo $data['PEMOHON_NAME'];?></td>
											<td> <?php if($data['PEMOHON_TGL_LAHIR']<>''){echo $data['PEMOHON_TGL_LAHIR']->format('Y-m-d');}else{echo"-";}?></td>
											
											<td><?php echo $data['PEMOHON_IBU'];?></td>
											<td><?php echo $data['STATUS_KAWIN_PEMOHON'];?></td>
											
											<td><?php echo $data['ID_NO_PASANGAN'];?></td>
											<td><?php echo $data['PASANGAN_NAME'];?></td>
											<td> <?php if($data['PASANGAN_TGL_LAHIR']<>''){echo $data['PASANGAN_TGL_LAHIR']->format('Y-m-d');}else{echo"-";}?></td>
						
											<td><?php echo $data['PASANGAN_IBU'];?></td>
											<td><?php echo $data['STATUS_KAWIN_PASANGAN'];?></td>
											  <td style="vertical-align:middle;text-align:center;">
												 <a href="pdf_surat.php?USERNAME=<?php echo $user;?>&order=<?php echo $order;?>" class="btn btn-custom btn-xs" target="_blank" ><i class="fa fa-file"></i></a>
											  </td>
											
										</tr>
										
									</tbody>
								</table>
							<?php }else{ ?>
								<table class="table table-bordered table-stripped" style="width:100%;font-size:12px;">
									<thead>
										<tr>
											<th style="color:#FFF;background-color:#035c7a;font-weight:bold;">Data Order</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="text-align:center;">Silahkan cari order terlebih dahulu</td>
										</tr>
									</tbody>
								</table>
							<?php } ?>
						</div>
					</div>
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
} );
</script>
</script>