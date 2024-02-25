<?php
	require_once 'configdb.php';
  require_once 'functions/kriteria.php';
  require_once 'functions/alternatif.php';
  include_once "header.php";

  $kriterias = new Kriteria;
  $kriteria = $kriterias->getAllKriteria();

  $alternatifs = new Alternatif;
  $alternatif = $alternatifs->getAlternatifById($_GET["id"]);
  $detailAlternatif = $alternatifs->getDetailAlternatifById($_GET["id"]);
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
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="kriteria.php">Data Kriteria</a></li>
        <li><a href="alternatif.php" class="active">Data Alternatif</a></li>
        <li><a href="perhitungan.php">Perhitungan</a></li>
      </ul>
    </aside>
    <main>
      <div class="container">
        <!-- Main component for a primary marketing message or call to action -->
        <div class="panel panel-primary" style="border-radius:16px;border:none;">
          <!-- Default panel contents -->
          <div class="panel-heading"
            style="padding:24px;border:none;background:#fff;color:#000;font-family: 'DM Sans';font-size:24px;font-weight:700;">
            Edit Data Alternatif</div>
          <div class="panel-body">
            <form role="form" method="post" action="middleware.php?action=update&menu=alternatif&id=<?= $_GET['id'] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="alternatif">Alternatif</label>
                  <input type="text" class="form-control <?php if(isset($_SESSION["message"])): ?> is-invalid <?php endif; ?>" name="alternatif" id="alternatif"
                    value="<?php if(isset($_SESSION["old-alternatif"])): echo $_SESSION["old-alternatif"]; else: echo $alternatif["alternatif"]; endif; unset($_SESSION["old-alternatif"]) ?>" placeholder="Masukkan nama alternatif...">
                  <div class="invalid-feedback">
                    <?php echo $_SESSION["message"]."."; unset($_SESSION["message"]) ?>
                  </div>
                </div>

                <?php 
                  $i = 1;
                  $index = 0;
                  foreach($detailAlternatif as $dalt):
                ?>
                <div class="form-group">
                  <label for="<?= "C".$i ?>"><?= $dalt["kriteria"] ?></label>
                  <select class="form-control" name="nilai[]" id="<?= "C".$i ?>" required>
                    <option value="" hidden <?php if($dalt["nilai"]=='0'): ?> selected <?php endif; ?>>Masukkan nilai <?= strtolower($dalt["kriteria"]) ?>...</option>
                    <option value='1' <?php if($dalt["nilai"]=='1'): ?> selected <?php endif; ?>>1 - Sangat tidak baik</option>
                    <option value='2' <?php if($dalt["nilai"]=='2'): ?> selected <?php endif; ?>>2 - Tidak baik</option>
                    <option value='3' <?php if($dalt["nilai"]=='3'): ?> selected <?php endif; ?>>3 - Cukup baik</option>
                    <option value='4' <?php if($dalt["nilai"]=='4'): ?> selected <?php endif; ?>>4 - Baik</option>
                    <option value='5'<?php if($dalt["nilai"]=='5'): ?> selected <?php endif; ?>>5 - Sangat baik</option>
                  </select>
                </div>
                <?php endforeach; ?>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="alternatif.php" type="cancel" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>

  </div> <!-- /container -->
  </main>
  </div>

  <?php include_once "footer.php"; ?>

</body>

</html>