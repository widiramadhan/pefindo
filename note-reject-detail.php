<?php 
$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query( $conn, $callDate) or die( print_r( sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);
?>
<div class="row">
    <div class="col-md-12">
		<?php if($dataDate['VOID'] == '1'){ ?> 
			<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right:20px;">&times;</a>
					<strong>PERHATIAN ! <br>
					UNTUK PENGECEKAN SLIK DIMULAI PUKUL 09:00 - 17:00 WIB<br>
				
					
			</div>
				<?php } ?>
        <div class="card">
            <div class="header">
                <h4 class="title">Reject Note</h4>
                <p class="category">Your Task is Rejected, check reject note</p>
				<hr>
            </div>
            <div class="content">
            	<?php
					$prospect=$_GET['prospect'];
					$id_no=$_GET['id_no'];
					$id=$_GET['id'];
					$username=$_GET['USERNAME'];
					$call = "{call SP_GET_REJECT_DUKCAPIL(?,?)}";
					$param = array(array($prospect, SQLSRV_PARAM_IN),
								   array($id_no, SQLSRV_PARAM_IN));
					$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
					
							
					$call1 = "{call SP_GET_NOTE(?)}";
					$param1 = array(array($id, SQLSRV_PARAM_IN));
					$exec1 = sqlsrv_query( $conn, $call1, $param1) or die( print_r( sqlsrv_errors(), true));
					$data1 = sqlsrv_fetch_array($exec1);
					
					while($data = sqlsrv_fetch_array($exec)){
				?>
            	<label>REJECTED BY : </label><br>
        		<p class="category"><b><?php echo strtoupper($data['CREATE_USER'])."</b> - ".$data['CREATE_DATE']->format("d F Y H:i:s");?></p>
            	<p class="category"><?php echo $data['NOTES'];?></p>
            	<hr>
            	<?php } ?>
					<?php if($data1['USER_CREATE'] != NULL) { ?>
					<p class="category"><b><?php echo strtoupper($data1['USER_CREATE'])."</b> - ".$data1['CREATE_DATE']->format("d F Y H:i:s");?></p>
            	<p class="category"><?php echo $data1['NOTE_HO'];?></p>
				<?php } ?>
            	<span class="text-danger">
            		<b>NOTE :</b><br>
            		* Silahkan ikuti instruksi yang diberikan credit HO<br>
					* Jika sudah, silahkan klik tombol dibawah ini untuk request task kembali

            	</span>
            	<br><br>
				
					<?php if($dataDate['VOID'] == '1'){ ?> 
					<input type="button" class="btn btn-custom btn-xs" value="REQUEST AGAIN" disabled>
					<?php }else{ ?>
            	<a href="pages/update-progress1.php?USERNAME=<?php echo $username;?>&id=<?php echo $id;?>&flag=3" class="btn btn-primary" style="width:100%;">REQUEST AGAIN</a>
					<?php } ?>
            </div>
       	</div>
    </div>
</div>