<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	background-color:#035c7a;
}
.td-custom{
	text-align:center;
	vertical-align:middle;
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
				<h4 class="title">Data Prospek</h4>
				<p class="category">Silahkan pilih prospek yang akan di cek</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="datatable" class="table table-bordered" style="width:100%">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor Prospek</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor KTP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Pemohon</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Lahir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Ibu Kandung</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_NEW(?)}";
									$options =  array( "Scrollable" => "buffered" );
									$param = array(array($user, SQLSRV_PARAM_IN));
									$execGetProspect = sqlsrv_query($conn, $callGetProspect, $param, $options) or die( print_r( sqlsrv_errors(), true));
									$num_rows=sqlsrv_num_rows($execGetProspect);
									$no=0;
									$i=0;
									while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
										$no++;
										$i++;
										$percent = intval($i/$num_rows * 100)."%";
										//echo $percent;
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['ID_NO'];?></td>
										<td style="padding:5px;"><?php echo $rowGetProspect['CUST_NAME'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?></td>
										<td style="padding:5px;"><?php echo $rowGetProspect['MOTHER_NM'];?></td>
										<td class="td-custom" style="padding:5px;">
											<!--<form action="index.php?page=individual-prospek-ver2&USERNAME=<?php// echo $user;?>" method="post">-->
											<form action="index.php?page=individual-prospek&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
												<input type="hidden" name="no_ktp" value="<?php echo $rowGetProspect['ID_NO'];?>">
												<input type="hidden" name="name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
												<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($rowGetProspect['BIRTH_DT']));?>">
												<input type="hidden" name="mother_name" value="<?php echo $rowGetProspect['MOTHER_NM'];?>">
												<input type="hidden" name="birth_place" value="<?php echo $rowGetProspect['BIRTH_PLACE'];?>">
												<button type="submit" name="select" class="btn btn-custom btn-sm"><i class="fa fa-search"></i> PILIH</button>
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
<script>
$(document).ready(function() {
    $('#datatable').DataTable({
		/*"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "data.php",
		"aoColumns": [
		  null,
		  null,
		  null,
		  {
			"mData": "0", <!-- Ini adalah untuk Link ID urutan kolom seperti table mulai dari 0 untuk data pertama -->
			"mRender": function ( data, type, full ) {
				return '<a href="#" onclick="alert(\'ID adalah = '+data+'\')"><span class="label label-primary">Link ID<span></a>';
			  }
		  }
		]*/
	});
});
</script>