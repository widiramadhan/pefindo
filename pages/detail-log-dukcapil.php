<?php
$prospect_no = $_GET['no'];
$nik = $_GET['nik'];
?>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Detail Log Dukcapil</h4>
				<p class="category">Detail log penggunaan Dukcapil</p><hr>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<?php
							$no=0;
							$call = "{call SP_GET_DETAIL_LOG_DUKCAPIL(?,?)}";
							$param = array(array($prospect_no, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN));
							$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true)); 
							while($data = sqlsrv_fetch_array($exec)){
								$no++;
						?>
						<div class="card">
							<div class="header">
								<b>Pengecekan <?php echo $no;?></b>
							</div>
							<div class="content">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<tr>
												<td style="color:#FFF;font-weight:bold;background-color:#035c7a;">PROSPECT NO</td>
												<td style="color:#FFF;font-weight:bold;background-color:#035c7a;">NIK</td>
												<td style="color:#FFF;font-weight:bold;background-color:#035c7a;">STATUS</td>
												<td style="color:#FFF;font-weight:bold;background-color:#035c7a;">CREATE USER</td>
												<td style="color:#FFF;font-weight:bold;background-color:#035c7a;">CREATE DATE</td>
											</tr>
											<tr>
												<td><?php echo $data['PROSPECT_NO'];?></td>
												<td><?php echo $data['ID_NO'];?></td>
												<td><?php echo $data['STATUS'];?></td>
												<td><?php echo $data['CREATE_USER'];?></td>
												<td><?php echo $data['CREATE_DATE']->format("Y-m-d H:i:s");?></td>
											</tr>
										</table>
										<div class="row">
											<div class="col-md-12">
												<?php
												/*
													if($data['ERROR'] > 0){
												?>
												<div class="alert alert-danger alert-dismissible">
													<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
													<strong>Perhatian !</strong><br>
													<?php
														$call2 = "{call SP_GET_DETAIL_ERROR_DUKCAPIL (?,?,?)}";
														$param2 = array(array($prospect_no, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($data['LOG_CHECK_BYSOURCE_ID'], SQLSRV_PARAM_IN));
														$options2 =  array( "Scrollable" => "buffered" );
														$exec2 = sqlsrv_query( $conn, $call2, $param2, $options2) or die( print_r( sqlsrv_errors(), true)); 
														$numrows2 = sqlsrv_num_rows($exec2);
														while($data2 = sqlsrv_fetch_array($exec2)){
															echo $data2['MSG_NAME']."<br>";
														}
													?>
												</div>
												<?php } */?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>