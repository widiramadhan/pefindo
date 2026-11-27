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
				<h4 class="title">Data Company</h4>
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
										<th class="th-custom" style="color:#FFF;font-weight:bold;">NPWP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Perusahaan</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_COMPANY}";
									$options =  array( "Scrollable" => "buffered" );
									$params = array();
									$execGetProspect = sqlsrv_query($conn, $callGetProspect, $params, $options) or die( print_r( sqlsrv_errors(), true));
									$num_rows=sqlsrv_num_rows($execGetProspect);
									$no=0;
									$i=0;
									while($rowGetProspect = sqlsrv_fetch_array($execGetProspect)){
										$no++;
										$percent = intval($i/$num_rows * 100)."%";
								?>
									<tr>
										<td class="td-custom" style="padding:5px;"><?php echo $no;?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['PROSPECT_NO'];?></td>
										<td class="td-custom" style="padding:5px;"><?php echo $rowGetProspect['NPWP'];?></td>
										<td class="" style="padding:5px;"><?php echo $rowGetProspect['CUST_NAME'];?></td>
										<td class="td-custom" style="padding:5px;">
											<form action="index.php?page=company-prospek&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $rowGetProspect['PROSPECT_NO'];?>">
												<input type="hidden" name="npwp" value="<?php echo $rowGetProspect['NPWP'];?>">
												<input type="hidden" name="name" value="<?php echo $rowGetProspect['CUST_NAME'];?>">
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