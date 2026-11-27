<style>
th{
	text-align:center;
	font-weight:bold;
}
td{
	text-align:center;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Individual</h4>
				<p class="category">Sistem Informasi Debitur</p>
			</div>
			<div class="content">
				<form action="index.php?USERNAME=<?php echo $user;?>&page=result-pefindo" method="post">
					<div class="row">
						<div class="col-md-3">
							<label>Prospect Number</label>	
							<div class="form-group">
								<input type="text" name="no_prospect" class="form-control" placeholder="Prospect Number">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>KTP Number</label>
								<input type="text" name="no_ktp" class="form-control" placeholder="KTP Number">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Fullname</label>
								<input type="text" name="nama" class="form-control" placeholder="Fullname">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Date of Birth</label>
								<div class="input-group date">
									<input type="text" class="form-control pull-right" name="date" id="datepicker" placeholder="Date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="pull-right">
						<button type="submit" name="submit" class="btn btn-primary">Search</button>
						<button type="reset" class="btn btn-danger">Cancel</button>
					</div>
					<div style="clear:both;"></div>
				</form>
			</div>
		</div>
	</div>
</div>