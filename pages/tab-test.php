<style>
tr.header{
    cursor:pointer;
	display: table-row;
}
tr.child {
    display: none;
}
.header .sign:after{
  content:"+";
  display:inline-block;      
}
.header.expand .sign:after{
  content:"-";
 }
 </style>
<table class="table table-bordered">
	<tr>
		<th>PENGENAL</th>
		<th>NAMA LENGKAP</th>
		<th>JENIS HUBUNGAN</th>
	</tr>
	<tr class="header expand">
		<td>KTP</td>
		<td>Nama</td>
		<td>Selingkuhan<div class="pull-right"><i class="fa fa-caret-square-o-down"></i></div></td>
	</tr>
	<tr class="child">
		<td colspan="3">
			<table class="table table-bordered">
				<tr>
					<td class="bg-td"><b>Nilai Agunan</b></td>
					<td>IDR 350,000,000</td>
					<td class="bg-td"><b>Keterangan</b></td>
					<td>Rumah LT 100 LB 120, Jl. Mangga no. 17, Komplek Permai Asri, Medan Jaya</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="header expand">
		<td>KTP</td>
		<td>Nama <span class="sign"></span></td>
		<td>Selingkuhan<div class="pull-right"><i class="fa fa-caret-square-o-down"></i></div></td>
	</tr>
	<tr class="child">
		<td colspan="3">
			bbbbbbbbbbb
		</td>
	</tr>
</table>
<script>
/*$('.header').click(function(){
     $(this).toggleClass('expand').nextUntil('tr.header').slideToggle(100);
});
$('tr.header').click(function(){
    $(this).nextUntil('tr.header').css('display', function(i,v){
        return this.style.display === 'table-row' ? 'none' : 'table-row';
    });
});*/
</script>