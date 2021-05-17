<?php
include('koneksi2.php');
$negara = mysqli_query($koneksi,"select * from negara");
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['nama_negara'];
	$total_cases[] = $row['total_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bar Chart Total Cases COVID-19</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>


	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_negara); ?>,
				datasets: [{
					label: 'Total Cases',
					data: <?php echo json_encode($total_cases); ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>