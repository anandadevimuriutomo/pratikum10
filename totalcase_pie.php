<?php
//koneksi ke database
include('koneksi.php');

//membuat variabel negara
$negara = mysqli_query($koneksi,"SELECT * FROM tb_negara");//mengambil data dari tb_negara
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['negara'];
	//variabel nama_produk dari kolom negara

	//query sql untuk mengambil data
	$query = mysqli_query($koneksi,"SELECT total_cases AS total_cases FROM tb_cases WHERE id_negara='".$row['id_negara']."'");
	$row = $query->fetch_array();
	$total_cases[] = $row['total_cases'];
}
?>
<!doctype html>
<html>

<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>

<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($total_cases); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(220, 20, 60, 0.2)',
					'rgba(65, 105, 225, 0.2)',
					'rgba(255, 165, 0, 0.2)',
					'rgba(154, 205, 50, 0.2)',
					'rgba(153, 50, 204, 0.2)',
					'rgba(64, 224, 208, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(220, 20, 60, 1)',
					'rgba(65, 105, 225, 1)',
					'rgba(255, 165, 0, 1)',
					'rgba(154, 205, 50, 1)',
					'rgba(153, 50, 204, 1)',
					'rgba(64, 224, 208, 1)'
					],
					label: 'Persentase Total Cases COVID-19'
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