<?php
$req_id=$_GET['id'];
$user=$_GET['USERNAME'];
if(isset($_POST['submit'])){
	$note=$_POST['note'];

	//update status ke REJECT (sub param id = 3)
	$callStat = "{call SP_UPDATE_SLIK_RESULT_NEW_MAPPING(?,?)}";
	$paramStat = array(array($req_id, SQLSRV_PARAM_IN),array(2, SQLSRV_PARAM_IN));
	$execStat = sqlsrv_query( $conn, $callStat, $paramStat) or die( print_r( sqlsrv_defaults(), true)); 
	

	//update kapan dia selesai ngerjain tasklist
	$call2 = "{call SP_UPDATE_PERFORMANCE_ACTIVITY_NEW_MAPPING(?)}";
	$param2 = array(array($req_id, SQLSRV_PARAM_IN));
	$exec2 = sqlsrv_query( $conn, $call2, $param2) or die( print_r( sqlsrv_defaults(), true)); 

	$call3 = "{call SP_INSERT_NOTE_NEW_MAPPING(?,?,?)}";
	$param3 = array(array($req_id, SQLSRV_PARAM_IN),array($note, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN));
	$exec3 = sqlsrv_query( $conn, $call3, $param3) or die( print_r( sqlsrv_errors(), true));
	

	if($exec3){
		echo"<script>alert('Data berhasil di Reject');window.location='index.php?USERNAME=".$user."&page=tasklist-pengecekan-slik';</script>";
	}else{
		echo"<script>alert('Error, hubungi administrator');history.back();</script>";
	}
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Reject Note</h4>
                <p class="category">Please input your reject note</p>
				<hr>
            </div>
            <div class="content">
            	<form action="" method="post">
	            	<div class="form-group">
	            		<label>Your Note :</label>
	            		<textarea name="note" class="form-control" rows="5" placeholder="Input your note"></textarea>
	            	</div>
	            	<input type="submit" class="btn btn-primary" name="submit" value="SUBMIT" style="width:100%;">
	            </form>
            </div>
       	</div>
    </div>
</div>