<?php

require_once("config/configuration.php");
require_once("config/connection.php");


if(isset($_POST['submit'])){
$rpt_date_from = $_POST['startDate'];
$rpt_date_to = $_POST['endDate'];
}
else{
$status="";
$nik="";
$startDate = date("Y-m-01");
$endDate = date("Y-m-d");

}

?>
<style>
.th-custom{
text-align:center;
background-color:#035c7a;
}
.td-center{
text-align:center;
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
<h4 class="title">Report Dashboard</h4>
<p class="category">Pilih tanggal untuk medownload report</p>
</div>
<div class="content">
<form action="action_report_dashboard.php" method="post">


<div class="col-md-6">
<div class="form-group">
<label>Start Date</label>
<div class="input-group date">
<input type="text" class="form-control" name="startDate" id="startDate" autocomplete="off" value="<?php echo $startDate;?>">
<div class="input-group-addon">
<span class="add-on"><i class="fa fa-calendar"></i></span>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label>End Date</label>
<div class="input-group date">
<input type="text" class="form-control" name="endDate" id="endDate" autocomplete="off" value="<?php echo $endDate;?>">
<div class="input-group-addon">
<span class="add-on"><i class="fa fa-calendar"></i></span>
</div>
</div>
</div>
</div>


<div class="pull-right">
<input type="submit" name="submit" class="btn btn-custom" value="DOWNLOAD">
</div>
<div style="clear:both;"></div>
</form>
<hr>


</div>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('#history').DataTable({
"bPaginate": true,
"bLengthChange": true,
        "bFilter": true,
        "bInfo": true
});
$('#startDate').datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
showButtonPanel: true,
onClose: function(selectedDate) {
$('#endDate').datepicker("option", "minDate", selectedDate);
}
});
$('#endDate').datepicker({
dateFormat: 'yy-mm-dd',
changeMonth: true,
changeYear: true,
showButtonPanel: true,
onClose: function(selectedDate) {
$('#startDate').datepicker("option", "maxDate", selectedDate);
}
});
} );
</script>