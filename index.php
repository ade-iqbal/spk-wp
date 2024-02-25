<?php
	require_once 'configdb.php';
	require_once 'functions/alternatif.php';
	require_once 'functions/kriteria.php';
	require_once 'functions/perhitungan.php';
	include_once "header.php";

	$kriterias = new Kriteria;
	$kriteria = $kriterias->getAllKriteria();

	$alternatifs = new Alternatif;
	$alternatif = $alternatifs->getAllAlternatif();
	$status = $alternatifs->checkAlternatifKriteria();

	if(!($status > 0)):
		$totalKepentingan = 0;
		foreach($kriteria as $k):
		$totalKepentingan += $k["kepentingan"];
		endforeach;

		$totalBobotKepentingan = 0;
		$arrBobotKepentingan = array();
		$arrPangkat = array();

		foreach($kriteria as $k):
			$bobotKepentingan = $k["kepentingan"]/$totalKepentingan;
			$totalBobotKepentingan += $bobotKepentingan;
			$pangkat = $k["cost_benefit"] === "benefit" ? $bobotKepentingan : (-1)*$bobotKepentingan;
			array_push($arrBobotKepentingan, $bobotKepentingan); 
			array_push($arrPangkat, $pangkat); 
		endforeach;

		$arrVectorS = array();

		foreach($alternatif as $alt): 
			$vectorS = array();
			$c=0;
			$totalVectorS = 0;
			$detailAlternatif = $alternatifs->getDetailAlternatifById($alt["id_alternatif"]);
			foreach($detailAlternatif as $dalt):
				array_push($vectorS, pow($dalt["nilai"], $arrPangkat[$c++]));
			endforeach;

			$totalVectorS = array_product($vectorS);
			array_push($arrVectorS, $totalVectorS);
		endforeach;

		$totalAllVectorS = array_sum($arrVectorS);
		$hasilAkhir = array();
		$arrVectorV = array();
		$d = 0;

		foreach($alternatif as $alt):
			$vectorV = round($arrVectorS[$d]/$totalAllVectorS, 6);
			$arrVectorV[$d] = round($arrVectorS[$d]/$totalAllVectorS, 6);
			array_push($hasilAkhir, [$alt["alternatif"], $vectorV]);
			$d++;
		endforeach;

		usort($hasilAkhir, 'cmp');
	endif;
?>



<body>
	<div class="wrapper">
		<nav>
			<a class="logo" href="index.php">
				<span>WEB SPK</span>
				<span>wp method</span>
			</a>
		</nav>
		<aside style="border-radius:3px;">
			<ul>
				<li><a href="index.php" class="active">Dashboard</a></li>
				<li><a href="kriteria.php">Data Kriteria</a></li>
				<li><a href="alternatif.php">Data Alternatif</a></li>
				<li><a href="perhitungan.php">Perhitungan</a></li>
			</ul>
		</aside>
		<main>
			<div class="container">
				<!-- Main component for a primary marketing message or call to action -->
				<div class=" panel panel-primary" style="border-radius:16px;border:none;">
					<!-- Default panel contents -->
					<div class="panel-heading"
						style="padding:24px;border:none;background:#fff;color:#000;font-family: 'DM Sans';font-size:24px;font-weight:700;">
						Dashboard</div>
					<div class="panel-body">
						<?php if($status > 0): ?>
						<div class="alert alert-danger d-flex align-items-center justify-content-center fw-bold"
							role="alert">
							<i class="bi bi-info-circle-fill mr-1"></i> Oopss... masih ada nilai kriteria yang belum
							diinputkan
							dibeberapa alternatif
						</div>

						<div class="text-center">
							<a href="alternatif.php" class="btn btn-warning">Masukkan nilai</a>
						</div>

						<?php else: ?>
						<div>
							<canvas id="canvas"></canvas>
						</div>

						<hr>
						<hr>
						<hr>

						<span class="d-block"><b>Perhitungan Nilai Vektor V dan Perangkingan</b></span>
						<table class='table table-striped table-bordered table-hover'>
							<thead>
								<tr>
									<th class="text-center" style="width: 2rem;">Ranking</th>
									<th>Alternatif</th>
									<th>Vektor V</th>
								</tr>
							</thead>
							<tbody>
								<?php $ranking=1; foreach ($hasilAkhir as $hasil): ?>
								<tr>
									<td class="text-center"><?= $ranking++ ?>.</td>
									<td class="fw-bold"><?= $hasil[0] ?></td>
									<td><?= $hasil[1] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<hr>
						<hr>
						<hr>

						<?php endif; ?>

					</div>
				</div> <!-- /container -->
			</div>
		</main>
	</div>


	<?php //include_once "footer.php"; ?>

	<!-- chart -->
	<script src="assets/js/chart.js"></script>
	<script>
		const ctx = document.getElementById("canvas");

		// label
		const labels = []; 
		<?php foreach($alternatif as $alt): ?>
			labels.push(`<?=$alt["alternatif"] ?>`); 
		<?php endforeach; ?>

		// data
		const datas = []; 
		<?php foreach($arrVectorV as $v): ?>
			datas.push('<?= $v ?>'); 
		<?php endforeach; ?>

		Chart.defaults.font.size = 14;
		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: 'Nilai vektor V',
					data: datas,
					borderWidth: 2
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				},
				plugins: {
					legend: {
						display: false,
					},
					tooltip: {
						displayColors: false
					}
				}
			}
		});
	</script>

</body>

</html>