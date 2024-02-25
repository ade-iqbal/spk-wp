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
?>



<body>
	<div class="wrapper">
		<nav>
			<a class="logo" href="/">
				<span>WEB SPK</span>
				<span>wp method</span>
			</a>
		</nav>
		<aside style="border-radius:3px;">
			<ul>
				<li><a href="index.php">Dashboard</a></li>
				<li><a href="kriteria.php">Data Kriteria</a></li>
				<li><a href="alternatif.php">Data Alternatif</a></li>
				<li><a href="perhitungan.php" class="active">Perhitungan</a></li>
			</ul>
		</aside>
		<main>
			<div class="container">
				<!-- Main component for a primary marketing message or call to action -->
				<div class="panel panel-primary" style="border-radius:16px;border:none;">
					<div class="panel-body">
						<?php if($status > 0): ?>
						<div class="alert alert-danger d-flex align-items-center justify-content-center fw-bold"
							role="alert">
							<i class="bi bi-info-circle-fill mr-1"></i> Oopss... masih ada nilai kriteria yang belum diinputkan
							dibeberapa alternatif
						</div>

						<div class="text-center">
							<a href="alternatif.php" class="btn btn-warning">Masukkan nilai</a>
						</div>

						<?php else: ?>

						<div class="card rounded-3 p-3 mb-3">
							<p class="fw-bold">Keterangan : </p>
							<ul>
								<?php $a=1; foreach($kriteria as $k): ?>
								<li><span class="fw-bold">C<?= $a++ ?></span> <?= " : ".$k["kriteria"] ?></li>
								<?php endforeach; ?>
							</ul>
						</div>

						<span class="d-block"><b>Matrix Alternatif - Kriteria</b></span>
						<table class='table table-striped table-bordered table-hover mb-5'>
							<thead>
								<tr>
									<th>Alternatif / Kriteria</th>
									<?php $i=1; foreach($kriteria as $k): ?>
									<th><?= "C".$i++ ?></th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach($alternatif as $alt): ?>
								<tr>
									<td class="fw-bold"><?= $alt["alternatif"] ?></td>
									<?php 
									$detailAlternatif = $alternatifs->getDetailAlternatifById($alt["id_alternatif"]);
									foreach($detailAlternatif as $dalt): 
								?>
									<td><?= $dalt["nilai"]; ?>
									</td>
									<?php endforeach; ?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<span class="d-block"><b>Perhitungan Bobot Kepentingan</b></span>
						<table class='table table-striped table-bordered table-hover mb-5'>
							<thead>
								<tr>
									<th></th>
									<?php $i=1; foreach($kriteria as $k): ?>
									<th><?= "C".$i++ ?></th>
									<?php endforeach; ?>
									<th>Jumlah</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="fw-bold">Kepentingan</td>
									<?php 
										$totalKepentingan = 0;
										foreach($kriteria as $k):
										$totalKepentingan += $k["kepentingan"];
									?>
									<td><?= $k["kepentingan"] ?></td>
									<?php endforeach; ?>
									<td><?= $totalKepentingan ?></td>
								</tr>
								<tr>
									<td class="fw-bold">Bobot Kepentingan</td>
									<?php 
										$totalBobotKepentingan = 0;
										$arrBobotKepentingan = array();
										$arrPangkat = array();

										foreach($kriteria as $k):
											$bobotKepentingan = $k["kepentingan"]/$totalKepentingan;
											$totalBobotKepentingan += $bobotKepentingan;
									?>
									<td><?= round($bobotKepentingan, 6) ?></td>
									<?php 
											$pangkat = $k["cost_benefit"] === "benefit" ? $bobotKepentingan : (-1)*$bobotKepentingan;
											array_push($arrBobotKepentingan, $bobotKepentingan); 
											array_push($arrPangkat, $pangkat); 
										endforeach; 
									?>
									<td><?= $totalBobotKepentingan ?></td>
								</tr>
							</tbody>
						</table>

						<span class="d-block"><b>Normalisasi Bobot</b></span>
						<table class='table table-striped table-bordered table-hover mb-5'>
							<thead>
								<tr>
									<th></th>
									<?php $i=1; foreach($kriteria as $k): ?>
									<th><?= "C".$i++ ?></th>
									<?php endforeach; ?>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="fw-bold">Cost/Benefit</td>
									<?php foreach($kriteria as $k): ?>
									<td><?= ucwords($k["cost_benefit"]) ?></td>
									<?php endforeach ?>
								</tr>
								<tr>
									<td class="fw-bold">Pangkat</td>
									<?php foreach($arrPangkat as $pangkat): ?>
									<td><?= round($pangkat, 6) ?></td>
									<?php endforeach ?>
								</tr>
							</tbody>
						</table>

						<span class="d-block"><b>Perhitungan Nilai Vektor S</b></span>
						<table class='table table-striped table-bordered table-hover mb-5'>
							<thead>
								<tr>
									<th>Alternatif</th>
									<th>Vektor S</th>
								</tr>
							</thead>
							<tbody>
								<?php 
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
								?>
								<tr>
									<td class="fw-bold"><?= $alt["alternatif"] ?></td>
									<td><?= round($totalVectorS, 6) ?></td>
								</tr>
								<?php 
										array_push($arrVectorS, $totalVectorS);
									endforeach; 
								?>
							</tbody>
						</table>

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
								<?php 
									$totalAllVectorS = array_sum($arrVectorS);
									$hasilAkhir = array();
									$d = 0;

									foreach($alternatif as $alt):
										$vectorV = round($arrVectorS[$d]/$totalAllVectorS, 6);
										array_push($hasilAkhir, [$alt["alternatif"], $vectorV]);
										$d++;
									endforeach;

									usort($hasilAkhir, 'cmp');

									$ranking = 1;
									foreach ($hasilAkhir as $hasil):
								?>
								<tr>
									<td class="text-center"><?= $ranking++ ?>.</td>
									<td class="fw-bold"><?= $hasil[0] ?></td>
									<td><?= $hasil[1] ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table><hr><hr><hr>	

						<?php endif; ?>
					</div>
				</div>
			</div>
		</main>
	</div>

	<?php include_once "footer.php"; ?>

</body>

</html>