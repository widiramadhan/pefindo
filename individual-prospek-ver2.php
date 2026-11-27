<?php
$prospect_no=$_POST['prospect_no'];
$no_ktp=$_POST['no_ktp'];
$nama=$_POST['name'];
$date=$_POST['date'];
$mother_nm=$_POST['mother_name'];
$birth_place=$_POST['birth_place'];

$call = "{call PEFINDO_GETDATA_PASANGAN_NEWVERSE(?)}";
$param = array(array($prospect_no, SQLSRV_PARAM_IN));
$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
$data = sqlsrv_fetch_array($exec);

if($data['Pasangan_Noktp'] == "" || $data['Pasangan_Noktp'] == NULL){
	$siapanih = "Penjamin";
	$ktpsaya = $data['Penjamin_Noktp'];
	$namasaya = $data['Penjamin_Nama'];
	$tgllahirsaya = $data['Penjamin_TglLahir'];
	$tempatlahirsaya = $data['Penjamin_TempatLahir'];
	$namaibusaya = "-";
}else{
	$siapanih = "Pasangan";
	$ktpsaya = $data['Pasangan_Noktp'];
	$namasaya = $data['Pasangan_Nama'];
	$tgllahirsaya = $data['Pasangan_TglLahir'];
	$tempatlahirsaya = $data['Pasangan_TempatLahir'];
	$namaibusaya = $data['Pasangan_Ibu'];
}
?>
<style>
.th-custom{
	text-align:center;
	vertical-align:middle;
	font-weight:bold;
	background-color:#035c7a;
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
				<h4 class="title" style="color:#035c7a;"><b><?php echo $prospect_no;?></b></h4>
				<p class="category">Data Prospek berdasarkan Prospek yang dipilih</p>
			</div>
			<hr>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;font-size:12px;">
								<thead>
									<tr>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">No</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nomor KTP</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Lengkap</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Tanggal Lahir</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Status</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Nama Ibu Kandung</th>
										<th class="th-custom" style="color:#FFF;font-weight:bold;">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-custom">1</td>
										<td class="td-custom"><?php echo $data['ID_NO'];?></td>
										<td><?php echo $data['CUST_NAME'];?></td>
										<td class="td-custom"><?php if( $data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('d-m-Y');}?></td>
										<td class="td-custom">PEMOHON</td>
										<td class="td-custom"><?php echo $data['MOTHER_MAIDEN_NAME'];?></td>
										<td class="td-custom">
											<form action="index.php?page=check-blacklist-prospect&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $data['ID_NO'];?>">
												<input type="hidden" name="name" value="<?php echo $data['CUST_NAME'];?>">
												<input type="hidden" name="date" value="<?php if($data['BIRTH_DT']<>NULL){echo $data['BIRTH_DT']->format('Y-m-d');}?>">
												<input type="hidden" name="mother_name" value="<?php echo $data['MOTHER_MAIDEN_NAME'];?>">
												<input type="hidden" name="birth_place" value="<?php echo $birth_place;?>">
												<input type="hidden" name="tipe_cust" value="PEMOHON">
												<button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
											</form>
										</td>
									</tr>
									<tr>
										<td class="td-custom">2</td>
										<td class="td-custom"><?php echo $ktpsaya;?></td>
										<td><?php echo $namasaya;?></td>
										<td class="td-custom"><?php if($tgllahirsaya<>NULL){echo $tgllahirsaya->format('d-m-Y');}?></td>
										<td class="td-custom"><?php echo strtoupper($siapanih);?></td>
										<td class="td-custom"><?php echo $namaibusaya;?></td>
										<td class="td-custom">
											<?php
											if($siapanih == "Pasangan"){
											?>
											<form action="index.php?page=check-blacklist-prospect&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $ktpsaya;?>">
												<input type="hidden" name="name" value="<?php echo $namasaya;?>">
												<input type="hidden" name="date" value="<?php if($tgllahirsaya<>NULL){echo $tgllahirsaya->format('Y-m-d');}?>">
												<input type="hidden" name="mother_name" value="<?php echo $namaibusaya;?>">
												<input type="hidden" name="birth_place" value="">
												<input type="hidden" name="tipe_cust" value="<?php echo strtoupper($siapanih);?>">
												<button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
											</form>
											<?php
											}else{
											?>
											<form action="index.php?page=check-blacklist-prospect&USERNAME=<?php echo $user;?>" method="post">
												<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
												<input type="hidden" name="no_ktp" value="<?php echo $ktpsaya;?>">
												<input type="hidden" name="name" value="<?php echo $namasaya;?>">
												<input type="hidden" name="date" value="<?php if($tgllahirsaya<>NULL){echo $tgllahirsaya->format('Y-m-d');}?>">
												<input type="hidden" name="mother_name" value="">
												<input type="hidden" name="birth_place" value="">
												<input type="hidden" name="tipe_cust" value="<?php echo strtoupper($siapanih);?>">
												<button type="submit" class="btn btn-custom btn-xs"><i class="fa fa-search"></i> CEK DATA</button>
											</form>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<i class="text-danger">*Jika data kosong, mohon segera lakukan edit data pada CONFINS</i>
					</div>
				</div>
				<br>
			</div>
		</div>
	</div>
</div>						