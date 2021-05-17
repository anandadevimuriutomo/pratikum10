<?php
include('koneksi2.php');
$negara = mysqli_query($koneksi,"select * from negara");
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['nama_negara'];
	$active_cases[] = $row['active_cases'];
}
?>
<!doctype html>
<html>

<head>
	<title>Doughnut Chart Active Cases COVID-19</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'doughnut',
			data: {
				datasets: [{
					data:<?php echo json_encode($active_cases); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(235, 64, 52, 0.2)',
					'rgba(245, 93, 5, 0.2)',
					'rgba(240, 221, 10, 0.2)',
					'rgba(162, 255, 0, 0.2)',
					'rgba(0, 230, 122, 0.2)',
					'rgba(111, 0, 230, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(235, 64, 52, 0.2)',
					'rgba(245, 93, 5, 0.2)',
					'rgba(240, 221, 10, 0.2)',
					'rgba(162, 255, 0, 0.2)',
					'rgba(0, 230, 122, 0.2)',
					'rgba(111, 0, 230, 0.2)'
					],
					label: 'Active Cases COVID-19'
				}],
				labels: <?php echo json_encode($nama_negara); ?>},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>