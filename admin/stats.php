<?php 
include dirname(__FILE__) . '/includes/header.php'; 

include dirname(__FILE__) . '/includes/header_under.php'; 
?>  
	<title>Website Stats: <?php echo(getMetaTitle()) ?></title>
	<script type="text/javascript" src="style/js/highcharts.js" ></script>
	</head>
	<body>
	<?php include "includes/top_navbar.php"; ?>	
	<div class="clearfix"></div>
	<div id="wrapper">
		<div id="page-wrapper">
			<div class="row page-ttl">
				<div class="col-lg-12">
					<h1><i class="fa fa-bar-chart-o"></i> Website Stats <small>Full website stats</small></h1>
				</div>
			</div><!-- /.row -->
			<ol class="page-content">
				<div class="margin_sides">
					<div class="row">	   
						<div class="col-lg-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Daily Statistics</h3>
								</div>
								<div class="widget-body">
									<div class="chart-container">
										<div  class="chart-placeholder" data-highcharts-chart="0">
											<div id="home-chart" class="highcharts-container"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br/><br/>
					<div class="row">
						<div class="col-lg-6">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">Monthly Statistics</h3>
								</div>
								<div class="panel-body">
									<center>
										<div id="total_week_chart" class="chart-placeholder" data-highcharts-chart="1">
											<div class="highcharts-container" id="total_month_chart">
											</div>
										</div>
									</center>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3 class="panel-title">All Time Statistics</h3>
								</div>
								<div class="panel-body">
									<center>
										<div id="total_week_chart" class="chart-placeholder" data-highcharts-chart="1">
											<div class="highcharts-container" id="total_chart">
											</div>
										</div>
									</center>
								</div>
							</div>
						</div>
					</div>
					<br/>
				</div>
			</ol>
		</div>
	</div>
	<?php
	
	$sql = mysqlQuery("SELECT pageviews,unique_hits,affiliates_hits,date from stats WHERE date >= CURDATE() - INTERVAL 6 DAY ORDER BY `date` ASC");
	
	$count_values = 0;
	
	while ($result = @mysql_fetch_array($sql))
	{
	
		$views[] = $result['pageviews'];
		
		$hits[] = $result['unique_hits'];
		
		$affiliates[] = $result['affiliates_hits'];
		
		$search[] = return_total_searches($result['date']);
		
		$date[] = $result['date'];
		
		$count_values+= 1;
		
	}
	
	$viewarray = array(
	0 => (int)$views[0],
	1 => (int)$views[1],
	2 => (int)$views[2],
	3 => (int)$views[3],
	4 => (int)$views[4],
	5 => (int)$views[5],
	6 => (int)$views[6]
	);
	
	$hitsarray = array(
	0 => (int)$hits[0],
	1 => (int)$hits[1],
	2 => (int)$hits[2],
	3 => (int)$hits[3],
	4 => (int)$hits[4],
	5 => (int)$hits[5],
	6 => (int)$hits[6]
	);
	
	$searcharray = array(
	0 => (int)$search[0],
	1 => (int)$search[1],
	2 => (int)$search[2],
	3 => (int)$search[3],
	4 => (int)$search[4],
	5 => (int)$search[5],
	6 => (int)$search[6]
	);
	
	$affiliatesarray = array(
	0 => (int)$affiliates[0],
	1 => (int)$affiliates[1],
	2 => (int)$affiliates[2],
	3 => (int)$affiliates[3],
	4 => (int)$affiliates[4],
	5 => (int)$affiliates[5],
	6 => (int)$affiliates[6]
	);
	
	if ($count_values > 0)
	{
		?>
		<script type="text/javascript">
			var vArray= <?php
			echo json_encode($viewarray);
			?>;
			
			var dArray= <?php
			echo json_encode($date);
			?>;	
			
			var hArray= <?php
			echo json_encode($hitsarray);
			?>;	
			
			var dsArray= <?php
			echo json_encode($searcharray);			
			?>
			
			var affArray= <?php
			echo json_encode($affiliatesarray);			
			?>
		</script>
		
		<script type="text/javascript">
			$(function () {
				$('#home-chart').highcharts({
					chart: {
						type: 'column'
					},
					title: {
						text: 'Statistics of last seven days'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [
						dArray[0],
						dArray[1],
						dArray[2],
						dArray[3],
						dArray[4],
						dArray[5],
						dArray[6]
						]
					},
					credits: { enabled: false },
					yAxis: {
					min: 0,
					title: {
						text: 'Total Value'
					}
					},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table style="width:100px;">',
						pointFormat: '<tr><td style="color:{series.color};padding:0;font-size:10px;">{series.name}: </td>' +
						'<td style="padding:0;font-size:12px;"><b>{point.y:.0f} </b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Total Searches',
						data: [dsArray[0],dsArray[1],dsArray[2],dsArray[3],dsArray[4],dsArray[5],dsArray[6]]

						}, {
						name: 'Views',
						data: [vArray[0],vArray[1],vArray[2],vArray[3],vArray[4],vArray[5],vArray[6]]

						}, {
						name: 'Unique hits',
						data: [hArray[0],hArray[1],hArray[2],hArray[3],hArray[4],hArray[5],hArray[6]]

						}, {
						name: 'Affiliates clicks',
						data: [affArray[0],affArray[1],affArray[2],affArray[3],affArray[4],affArray[5],affArray[6]]

					}]
				});
			});   
		</script>
		<?php
	} 
	else
	{
		?>
		<script>
			$("#home-chart").html("<div style='position: absolute; left: 44%; top: 50%;'><h4>No web searches in this week</h4></div>");
		</script>
		<?php
	}
	
	$count_value     = 0;
	
	$sql_total_month = mysqlQuery("SELECT SUM(pageviews) AS pageviews,SUM(affiliates_hits) AS affiliates_hits,SUM(unique_hits) AS unique_hits from stats WHERE YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE())");
	
	$total_month[] = array();
	
	while ($result_total_month = @mysql_fetch_array($sql_total_month))
	{
	
		$total_month[0] = $result_total_month['pageviews'];
		
		$total_month[1] = $result_total_month['unique_hits'];
		
		$total_month[2] = return_downloads_this_month();
		
		$total_month[3] = $result_total_month['affiliates_hits'];
		
		$count_value += $result_total_month['pageviews'] + $result_total_month['unique_hits'] + $result_total_month['affiliates_hits'] + return_downloads_this_month();
		
	}
	if ($count_value > 0)
	{
		?>
		<script type="text/javascript">
			$(function () {
				var chart;
				$(document).ready(function () {
					$('#total_month_chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: ''
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
						},
						credits: { enabled: false },
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: false
								},
								showInLegend: true
							}
						},
						series: [{
							type: 'pie',
							name: 'Value',
							data: [
								['Total Searches',   <?php echo($total_month[2]) ?>],
								['Views',       <?php echo($total_month[0]) ?>],                   
								['Unique Hits', <?php echo($total_month[1]) ?>], 
                                ['Affiliates clicks', <?php echo($total_month[3]) ?>]								
							]
						}]
					});
				});
			});
		</script>	
		<?php
	} 
	else
	{
	
		?>
		<script>
			$("#total_chart").html("<div style='position: absolute; left: 38%; top: 50%;'><h4>No Records Found</h4></div>");
		</script>
		<?php
		
	}
	
	$sql_total  = mysqlQuery("SELECT SUM(pageviews) AS pageviews,SUM(affiliates_hits) AS affiliates_hits,SUM(unique_hits) AS unique_hits from stats");
	
	$count_vals = 0;
	
	$total_array = array();
	
	while ($result_total = @mysql_fetch_array($sql_total)) 
	{
	
		$total_array[0] = $result_total['pageviews'];
		
		$total_array[1] = $result_total['unique_hits'];
		
		$total_array[2] = return_downloads_all_time();
		
		$total_array[3] = $result_total['affiliates_hits'];
		
		$count_vals += $result_total['pageviews'] + $result_total['unique_hits'] + $result_total['affiliates_hits'] + return_downloads_all_time();
		
	}
	if ($count_vals > 0)
	{
		?>
		<script type="text/javascript">
			$(function () {
				var chart;
				$(document).ready(function () {
					$('#total_chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: ''
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
								enabled: false
								},
								showInLegend: true
							}
						},
						credits: { enabled: false },
						series: [{
							type: 'pie',
							name: 'Value',
							data: [
								['Total Searches',  <?php echo($total_array[2]) ?>],
								['Views',      <?php echo($total_array[0]) ?>],                   
								['Unique Hits',<?php echo($total_array[1]) ?>], 
                                ['Affiliates clicks',<?php echo($total_array[3]) ?>]								
							]
						}]
					});
				});
			});
		</script>  
		<?php
	} 
	else 
	{
	
		?>
		<script>
			$("#total_chart").html("<div style='position: absolute; left: 38%; top: 50%;'><h4>No Records Found</h4></div>");
		</script>
		<?php
		
	} 	
	?>
	</body>
</html>