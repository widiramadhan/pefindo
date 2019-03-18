<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title">Dashboard</h4>
				<p class="category">Host to Host SFI - Pefindo</p>
			</div>
			<div class="content all-icons">
				<div class="row">
					<!--<div style="text-align:center;font-size:48px;color:#EEE;margin-top:100px;margin-bottom:300px;">-->
					<div style="padding:30px;font-size:14px;color:#AAA;">
						Selamat datang, <?php echo $_GET['USERNAME'];?>.<br>
						Silahkan pilih menu Individual untuk pengecekan Prospek personal, dan pilih menu Company untuk pengecekan Prospek Perusahaan
						<br><br><br><br><br><br><br><br><br><br>
					</div>
					<!--<div class="font-icon-list col-md-6">
						<div class="font-icon-detail">
							<p>Request PerHari ini :</p>
							<div style="font-size:42px;font-weight:bold;">201</div>
						</div>
					</div>
					<div class="font-icon-list col-md-6">
						<div class="font-icon-detail">
							<p>Request PerBulan ini :</p>
							<div style="font-size:42px;font-weight:bold;">9425</div>
						</div>
					</div>-->
				</div>
			</div>
			<!--<div class="content">
				<div id="container" style="height:350px;"></div>
			</div>-->
		</div>
	</div>
</div>	
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
Highcharts.chart('container', {
	credits: {
		 enabled: false
	},
	exporting: { 
		enabled: false 
	},
    title: {
        text: 'Request to PEFINDO'
    },

    subtitle: {
        text: 'Suzuki Finance Indonesia'
    },

    yAxis: {
        title: {
            text: 'Total Request'
        }
    },
	
	xAxis: {
			categories: [<?php for($i=1;$i<=8;$i++) { echo '"' . $i . '/' . date('m/Y') . '",';}?>]
	},
	
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    series: [{
        name: 'Request to Pefindo',
        data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
    }],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>