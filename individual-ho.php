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
						<form method="post" action="">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>BRANCH</label>
										<select name="branch" class="form-control">
											<option value="">SELECT BRANCH</option>
											<!--<option value="">ALL BRANCH</option>-->
											<?php
												$call2 = "{call SP_GET_ALL_BRANCH}";
												$exec2 = sqlsrv_query($conn, $call2) or die( print_r( sqlsrv_errors(), true));
												while($data2=sqlsrv_fetch_array($exec2)){
											?>
											<option value="<?php echo $data2['OFFICE_CODE'];?>"><?php echo $data2['OFFICE_CODE'];?> - <?php echo $data2['OFFICE_NAME'];?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-8">
									<br>
									<input type="submit" class="btn btn-custom" name="submit" value="SEARCH" style="margin-top:5px;">
								</div>
							</div>
						</form>
						<div class="table-responsive">
							<table id="datatable" class="table table-bordered table-striped" style="width:100%;font-size:12px;">
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
									if(isset($_POST['submit'])){
										$branch=$_POST['branch'];
										
										$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_NEW_HO(?)}";
										$options =  array( "Scrollable" => "buffered" );
										$param = array(array($branch, SQLSRV_PARAM_IN));
										$execGetProspect = sqlsrv_query($conn, $callGetProspect, $param, $options) or die( print_r( sqlsrv_errors(), true));
									}else{
										$callGetProspect = "{call SP_GET_PROSPEK_NUMBER_NEW_HO(?)}";
										$options =  array( "Scrollable" => "buffered" );
										$param = array(array('', SQLSRV_PARAM_IN));
										$execGetProspect = sqlsrv_query($conn, $callGetProspect, $param, $options) or die( print_r( sqlsrv_errors(), true));
									}
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
											<!--<form action="index.php?page=individual-prospek&USERNAME=<?php //echo $user;?>" method="post">-->
											<form action="index.php?page=individual-prospek1&USERNAME=<?php echo $user;?>" method="post">
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
		"pagingType": "full_numbers"
	});
});
</script>