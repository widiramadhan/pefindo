<?php 
$callDate = "{call SP_GET_DATE_SLIK}";
$execDate = sqlsrv_query( $conn, $callDate) or die( print_r( sqlsrv_errors(), true));
$dataDate = sqlsrv_fetch_array($execDate);
?>
<div class="row">
    <div class="col-md-12">

				
        <div class="card">
            <div class="header">
                <h4 class="title">Reject Note</h4>
                <p class="category">Your Task is Rejected, check reject note</p>
				<hr>
            </div>
            <div class="content">
            	<?php
				
			
		
					$id=$_GET['id'];

					$call = "{call SP_GET_NOTE_NEW_MAPPING(?)}";
					$param = array(array($id, SQLSRV_PARAM_IN));
					$exec = sqlsrv_query( $conn, $call, $param) or die( print_r( sqlsrv_errors(), true));
					while($data = sqlsrv_fetch_array($exec)){
				?>
            	<label>REJECTED BY : </label><br>
        		<p class="category"><b><?php echo strtoupper($data['USER_CREATE'])."</b> - ".$data['CREATE_DATE']->format("d F Y H:i:s");?></p>
            	<p class="category"><?php echo $data['NOTE_HO'];?></p>
            	<hr>
            	<?php } ?>
			
			</div>
       	</div>
    </div>
</div>