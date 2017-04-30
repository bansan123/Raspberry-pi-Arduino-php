<?php
	$con = mysqli_connect('localhost:3306','root','','rasptest');
	date_default_timezone_set('PRC');
	$result = mysqli_query($con,"SELECT temp,date,humidity,light FROM farmol ORDER BY id desc LIMIT 10");
	//var_dump($result);
	while($row = mysqli_fetch_assoc($result)){
		$date[]=date('H:i:s', $row['date']); 
		$temp[]=(float)$row['temp'];
		$humidity[]=(float)$row['humidity'];
		$light[]=(float)$row['light'];
	};
	//var_dump($date);
	$temp_json=json_encode($temp);
	$date_json=json_encode($date);
	$humidity_json=json_encode($humidity);
	$light_json=json_encode($light)
	//var_dump($date_json);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highcharts Example by http://www.codefans.net</title>
		
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="./js/jquery.min.js"></script>
		<script type="text/javascript" src="./js/highcharts.js"></script>
		
		<!-- 1a) Optional: the exporting module -->
		<script type="text/javascript" src="./js/modules/exporting.js"></script>
		
		
		<!-- 2. Add the JavaScript to initialize the chart on document ready -->
		<script type="text/javascript">
		
			var chart_temp;
			var chart_humdity;
			$(document).ready(function() {
				chart_temp = new Highcharts.Chart({
					chart: {
						renderTo: 'temp',
						defaultSeriesType: 'spline',
						ignoreHiddenSeries: false
					},
					title: {
						text: '农庄温度检测'
					},
					subtitle: {
						text: '数据来源: DS18B20温度传感器'
					},
					xAxis: {
						categories: <?php  echo $date_json; ?>,
						reversed:true
					},
					yAxis: {
						title: {
							text: '温度'
						},
						labels: {
							formatter: function() {
								return this.value +'°'
							}
						}
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +'°C';
						}
					},
					plotOptions: {
						spline: {
							marker: {
								radius: 4,
								lineColor: '#666666',
								lineWidth: 1
							}
						}
					},
					series: [{
						name: '温度',
						marker: {
							symbol: 'square'
						},
						data: <?php echo $temp_json; ?>/*[7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, {
							y: 26.5,
							marker: {
								symbol: 'url(./graphics/sun.png)'
							}
						}, 23.3, 18.3, 13.9, 9.6]*/
				
					},]
				}); /*温度报表结束*/
				chart_humdity = new Highcharts.Chart({
					chart: {
						renderTo: 'humidity',
						defaultSeriesType: 'spline',
						ignoreHiddenSeries: false
					},
					title: {
						text: '农庄土壤湿度检测',
						style: {
							color:'#058DC6'
						}
					},
					subtitle: {
						text: '数据来源: 土壤湿度传感器',
						style: {
							color:'#0F8DC6'
						}
					},
					colors:['#0F8DC6'],
					xAxis: {
						categories: <?php  echo $date_json; ?>,
						reversed:true
					},
					yAxis: {
						title: {
							text: '湿度',
							style: {
							color:'#058DC6'
							}
						},
						labels: {
							formatter: function() {
								return this.value +'%'
							}
						}
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +'%';
						}
					},
					plotOptions: {
						spline: {
							marker: {
								radius: 4,
								lineColor: '#666666',
								lineWidth: 1
							}
						}
					},
					series: [{
						name: '湿度',
						marker: {
							symbol: 'diamond'							
						},
						data: <?php echo $humidity_json; ?>,
				
					},]
				});
				chart_humdity = new Highcharts.Chart({
					chart: {
						renderTo: 'light',
						defaultSeriesType: 'spline',
						ignoreHiddenSeries: false
					},
					title: {
						text: '农庄光照强度检测',
						style: {
							color:'#ED561B'
						}
					},
					subtitle: {
						text: '数据来源: 光照强度传感器',
						style: {
							color:'#CD5617'
						}
					},
					colors:['#ED561B'],
					xAxis: {
						categories: <?php  echo $date_json; ?>,
						reversed:true
					},
					yAxis: {
						title: {
							text: '光照强度',
							style: {
							color:'#ED561B'
						}
						},
						labels: {
							formatter: function() {
								return this.value +'Lx'
							}
						}
					},
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y +'Lx';
						}
					},
					plotOptions: {
						spline: {
							marker: {
								radius: 4,
								lineColor: '#666666',
								lineWidth: 1
							}
						}
					},
					series: [{
						name: '湿度',
						marker: {
							symbol: 'diamond'							
						},
						data: <?php echo $light_json; ?>,
				
					},]
				});
				
			});
				
		</script>
		
	</head>
	<body>
		
		<!-- 3. Add the container -->
		<div id="temp" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="humidity" style="width: 800px; height: 400px; margin: 0 auto"></div>
		<div id="light" style="width: 800px; height: 400px; margin: 0 auto"></div>		
	</body>
</html>
