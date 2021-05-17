<?php
//koneksi ke database
include('koneksi.php'); 

//membuat variabel negara
$negara = mysqli_query($koneksi,"SELECT * FROM tb_negara");//mengambil data dari tb_negara
while($row = mysqli_fetch_array($negara)){
	$nama_negara[] = $row['negara'];
	//variabel nama_produk dari kolom negara

	//query sql untuk mengambil data
	$query = mysqli_query($koneksi,"SELECT new_cases FROM tb_cases WHERE id_negara='".$row['id_negara']."'");
	$row = $query->fetch_array();
	$new_cases[] = $row['new_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Line Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($nama_negara); ?>,
				datasets: [{
					label: 'Grafik Line New Cases Covid - 19',
					data: <?php echo json_encode($new_cases); ?>,
					backgroundColor: 'rgba(100, 149, 237, 0.2)',
					borderColor: 'rgba(100, 149, 237,1)',
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