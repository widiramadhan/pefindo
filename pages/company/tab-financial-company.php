<div id="Financial" class="tab-pane fade in active"> 
	<div class="card">
		<div class="header"><p class="name">Financial Statements</p></div>
			<div class="content">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered" style="width:100%;">
								<thead>
									<tr>
										<td align ="left" class="bg-td"><b>REPORTER</td></b>
									</tr>
								</thead>
								<?php
								/* select table FINANCIAL_COMPANY */
								$callFICOM = "{call SP_GET_TAB_FINANCIAL_COMPANY(?)}";
								$paramsFICOM = array(array($id, SQLSRV_PARAM_IN));
								$execFICOM = sqlsrv_query( $conn, $callFICOM, $paramsFICOM) or die( print_r( sqlsrv_errors(), true));
								while($dataFICOM = sqlsrv_fetch_array($execFICOM)){
								?>
									<tr class = "header">
										<td align ="left" ><?php echo $dataFICOM['SUBSCRIBER'];?><div class="pull-right"><i class="fa fa-caret-square-o-down"></i></div></td>
									</tr>
									<tr>
										<td colspan="4">
										<table class="table table-borderless">
								<tbody>
											<tr>
												<td><b>Reported Date</td></b>
												<td><?php echo $dataFICOM['REPORTED_DATE']->format('Y-m-d');?></td>
											</tr>
											<tr>	
												<td>Audited</td>
												<td><?php echo $dataFICOM['AUDITED'];?></td>
											</tr>
											<tr>
												<td>Total Aset</td>
												<td><?php echo $dataFICOM['TOTAL_ASSETS_CURRENCY']." ".number_format($dataFICOM['TOTAL_ASSETS_VALUE'],0,',','.');?></td>
											</tr>
											<tr>
												<td>Aktiva Lancar</td>
												<td><?php echo $dataFICOM['CURRENT_ASSET_CURRENCY']." ".number_format($dataFICOM['CURRENT_ASSET_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Kewajiban Lancar</td>
												<td><?php echo $dataFICOM['CURRENT_LIABILITIES_CURRENCY']." ".number_format($dataFICOM['CURRENT_LIABILITIES_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Liabilities to Bank</td>
												<td><?php echo $dataFICOM['LIABILITIES_BANK_CURRENCY']." ".number_format($dataFICOM['LIABILITIES_BANK_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Foreign Loans</td>
												<td><?php echo $dataFICOM['FOREIGN_LOANS'];?></td>
											</tr>
											
											<tr>	
												<td>Total Liabilities</td>
												<td><?php echo $dataFICOM['TOTAL_LIABILITIES_CURRENCY']." ".number_format($dataFICOM['TOTAL_LIABILITIES_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Equity</td>
												<td><?php echo $dataFICOM['EQUITY_CURRENCY']." ".number_format($dataFICOM['EQUITY_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Sales</td>
												<td><?php echo $dataFICOM['SALES_CURRENCY']." ".number_format($dataFICOM['SALES_VALUE'],0,',','.');?></td>
											</tr>
											
											<tr>	
												<td>Operational Revenues</td>
												<td><?php echo $dataFICOM['OPERASIONAL_REVENUES_CURRENCY']." ".number_format($dataFICOM['OPERASIONAL_REVENUES_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Operational Expenses</td>
												<td><?php echo $dataFICOM['OPERASIONAL_EXPENSES_CURRENCY']." ".number_format($dataFICOM['OPERASIONAL_EXPENSES_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Non Operational Revenues</td>
												<td><?php echo $dataFICOM['NONOPERASIONAL_REVENUES_CURRENCY']." ".number_format($dataFICOM['NONOPERASIONAL_REVENUES_VALUE'],0,',','.');?></td>
											</tr>
											
											<tr>	
												<td>Non Operational Expenses</td>
												<td><?php echo $dataFICOM['NONOPERASIONAL_EXPENSES_CURRENCY']." ".number_format($dataFICOM['NONOPERASIONAL_EXPENSES_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Profit Loss Previous Year</td>
												<td><?php echo $dataFICOM['PROFITLOSS_PREVIOUS_YEAR_CURRENCY']." ".number_format($dataFICOM['PROFITLOSS_PREVIOUS_YEAR_VALUE'],0,',','.');?></td>
											</tr>
											<tr>	
												<td>Profit Loss Current Year</td>
												<td><?php echo $dataFICOM['PROFITLOSS_CURRENT_YEAR_CURRENCY']." ".number_format($dataFICOM['PROFITLOSS_CURRENT_YEAR_VALUE'],0,',','.');?></td>
											</tr>
										</table>
										</td>
									</tr>
								</tbody>
								<?php
									}
								?>
							</table>
							<script>
								$('.header').click(function(){
									 $(this).toggleClass('expand').nextUntil('tr.header').slideToggle(100);
								});
							</script>
						</div>
					</div>
				</div>
			</div>
	</div>	
</div>	