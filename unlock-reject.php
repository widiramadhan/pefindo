<?php


if(isset($_POST['submit'])){
	$note=$_POST['note'];
		$user=$_GET['USERNAME'];
		$prospect_no = $_POST['prospect_no'];
		$nik = $_POST['nik'];
		$id = $_POST['id'];
	
	$callInsertStat = "{call SP_INSERT_STATUS_UNLOCK_DUKCAPIL(?,?,?,?,?)}";
	$paramsInsertStat = array(array($id, SQLSRV_PARAM_IN),array($prospect_no, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($user, SQLSRV_PARAM_IN), array('2', SQLSRV_PARAM_IN));
	$execInsertStat = sqlsrv_query( $conn, $callInsertStat, $paramsInsertStat) or die( print_r( sqlsrv_errors(), true));
	
	$callInsertStat1 = "{call SP_INSERT_UNLOCK_REJECT(?,?,?,?,?)}";
	$paramsInsertStat1 = array(array($id, SQLSRV_PARAM_IN),array($prospect_no, SQLSRV_PARAM_IN),array($nik, SQLSRV_PARAM_IN),array($note, SQLSRV_PARAM_IN), array($user, SQLSRV_PARAM_IN));
	$execInsertStat1 = sqlsrv_query( $conn, $callInsertStat1, $paramsInsertStat1) or die( print_r( sqlsrv_errors(), true));
	
	
	if($execInsertStat){
		echo"<script>alert('Reject Berhasil, Silahkan untuk melakukan pengkinian data ulang ');window.location='index.php?USERNAME=".$user."&page=unlock-dukcapil'</script>";
	}else{
		echo"<script>alert('Reject Gagal, Silahkan hubungi IT HO');history.back();</script>";
	}
}else{
	$user=$_GET['USERNAME'];
$prospect_no = $_POST['prospect_no'];
$nik = $_POST['nik'];
$id = $_POST['id'];
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
					<input type="hidden" name="prospect_no" value="<?php echo $prospect_no;?>">
									<input type="hidden" name="nik" value="<?php echo $nik;?>">
									<input type="hidden" name="id" value="<?php echo $id;?>">
	            	<input type="submit" class="btn btn-primary" name="submit" value="SUBMIT" style="width:100%;">
	            </form>
            </div>
       	</div>
    </div>
</div>