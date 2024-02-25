<?php
  require_once 'functions/kriteria.php';
  include_once "header.php";

  $kriterias = new Kriteria;
  $kriteria = $kriterias->getKriteriaById($_GET['id']);
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
        <li><a href="kriteria.php" class="active">Data Kriteria</a></li>
        <li><a href="alternatif.php">Data Alternatif</a></li>
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
            Edit Data Kriteria</div>
          <div class="panel-body">
            <form role="form" method="post" action="middleware.php?action=update&menu=kriteria&id=<?= $kriteria["id_kriteria"] ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="kriteria">Kriteria</label>
                  <input type="text" class="form-control <?php if(isset($_SESSION["message"])): ?> is-invalid <?php endif; ?>" name="kriteria" id="kriteria"
                    value="<?php if(isset($_SESSION["old-kriteria"])): echo $_SESSION["old-kriteria"]; else: echo $kriteria["kriteria"]; endif; unset($_SESSION["old-kriteria"])?>" placeholder="Kriteria" required>
                  <div class="invalid-feedback">
                    <?php echo $_SESSION["message"]."."; unset($_SESSION["message"]) ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="kepentingan">Nilai Kepentingan</label>
                  <select class="form-control" name="kepentingan" id="kepentingan" required>
                    <option value='1' <?php if($kriteria["kepentingan"]=='1') echo "selected"?>>Sangat tidak penting</option>
                    <option value='2' <?php if($kriteria["kepentingan"]=='2') echo "selected"?>>Tidak penting</option>
                    <option value='3' <?php if($kriteria["kepentingan"]=='3') echo "selected"?>>Cukup penting</option>
                    <option value='4' <?php if($kriteria["kepentingan"]=='4') echo "selected"?>>Penting</option>
                    <option value='5' <?php if($kriteria["kepentingan"]=='5') echo "selected"?>>Sangat penting</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cost_benefit">Cost / Benefit</label>
                  <select class="form-control" name="cost_benefit" id="cost_benefit" required>
                    <option value='cost' <?php if($kriteria["cost_benefit"]=='cost') echo "selected"?>>Cost</option>
                    <option value='benefit' <?php if($kriteria["cost_benefit"]=='benefit') echo "selected"?>>Benefit</option>
                  </select>
                </div>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Save</button>
                <a href="kriteria.php" type="cancel" class="btn btn-danger">Cancel</a>
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