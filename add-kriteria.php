<?php
  if(session_status() === 1 ){
      session_start();
  }
	require_once 'configdb.php';
  include_once "header.php";
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
            Tambah Data Kriteria
          </div>
          <div class="panel-body">
            <form role="form" method="post" action="middleware.php?action=store&menu=kriteria">
              <div class="box-body">
                <div class="form-group">
                  <label for="kriteria">Kriteria</label>
                  <input type="text" class="form-control <?php if(isset($_SESSION["message"])): ?> is-invalid <?php endif; ?>" name="kriteria" id="kriteria"
                    value="<?php if(isset($_SESSION["old-kriteria"])): echo $_SESSION["old-kriteria"]; endif; unset($_SESSION["old-kriteria"])?>" placeholder="Masukkan nama kriteria..." required>
                  <div class="invalid-feedback">
                    <?php echo $_SESSION["message"]."."; unset($_SESSION["message"]) ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="kepentingan">Nilai Kepentingan</label>
                  <select class="form-control" name="kepentingan" id="kepentingan" required>
                    <option value='' hidden>Masukkan nilai kepentingan kriteria...</option>
                    <option value='1' <?php if(isset($_SESSION["old-kepentingan"]) && $_SESSION["old-kepentingan"] == 1): ?> selected <?php endif; ?>>Sangat tidak
                      penting
                    </option>
                    <option value='2' <?php if(isset($_SESSION["old-kepentingan"]) && $_SESSION["old-kepentingan"] == 2): ?> selected <?php endif; ?>>Tidak penting
                    </option>
                    <option value='3' <?php if(isset($_SESSION["old-kepentingan"]) && $_SESSION["old-kepentingan"] == 3): ?> selected <?php endif; ?>>Cukup penting
                    </option>
                    <option value='4' <?php if(isset($_SESSION["old-kepentingan"]) && $_SESSION["old-kepentingan"] == 4): ?> selected <?php endif; ?>>Penting</option>
                    <option value='5' <?php if(isset($_SESSION["old-kepentingan"]) && $_SESSION["old-kepentingan"] == 5): ?> selected <?php endif; unset($_SESSION["old-kepentingan"]); ?>>Sangat penting
                    </option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="cost_benefit">Cost / Benefit</label>
                  <select class="form-control" name="cost_benefit" id="cost_benefit" required>
                    <option value='' hidden>Masukkan jenis kriteria...</option>
                    <option value='cost' <?php if(isset($_SESSION["old-cost-benefit"]) && $_SESSION["old-cost-benefit"] === "cost"): ?> selected <?php endif;?>>Cost</option>
                    <option value='benefit' <?php if(isset($_SESSION["old-cost-benefit"]) && $_SESSION["old-cost-benefit"] === "benefit"): ?> selected <?php endif; unset($_SESSION["old-cost-benefit"]); ?>>Benefit</option>
                  </select>
                </div>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="kriteria.php" type="cancel" class="btn btn-danger">Batal</a>
              </div>
            </form>
          </div>
        </div>

      </div> <!-- /container -->
    </main>
  </div>

  <?php include_once "footer.php"; ?>

</body>

</html>