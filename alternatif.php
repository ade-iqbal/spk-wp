<?php
	require_once 'configdb.php';
  require_once 'functions/kriteria.php';
  require_once 'functions/alternatif.php';
  include_once "header.php";

  $kriterias = new Kriteria;
  $kriteria = $kriterias->getAllKriteria();

  $alternatifs = new Alternatif;
  $alternatif = $alternatifs->getAllAlternatif();
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
        <li><a href="alternatif.php" class="active">Data Alternatif</a></li>
        <li><a href="perhitungan.php">Perhitungan</a></li>
      </ul>
    </aside>
    <main>
      <div class="container">
        <a class="btn-add-alternatif" href='add-alternatif.php'><i class="bi bi-plus-square"></i> Tambah
          Data</a>
        <!-- Main component for a primary marketing message or call to action -->
        <div class="panel panel-primary" style="border-radius:16px;border:none;">
          <div class="panel-body table-responsive">
            <table id="tabel-alternatif" class="table table-striped table-bordered table-hover" cellspacing="0"
              width="100%">
              <thead>
                <tr>
                  <th class="text-center" style="width: 2rem;">No.</th>
                  <th>Alternatif</th>
                  <?php foreach($kriteria as $k): ?>
                  <th><?= $k["kriteria"] ?></th>
                  <?php endforeach; ?>
                  <th class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $i = 1;
                  foreach($alternatif as $alt):
                ?>
                <tr>
                  <td class="text-center"><?= $i++ ?>.</td>
                  <td><?= $alt["alternatif"] ?></td>
                  <?php 
                    $detailAlternatif = $alternatifs->getDetailAlternatifById($alt["id_alternatif"]);
                    foreach($detailAlternatif as $da): 
                  ?>
                  <td><?php if($da["nilai"] != 0): echo $da["nilai"]; else: echo "belum ada nilai"; endif; ?></td>

                  <?php endforeach; ?>
                  <td class="text-center p-2">
                    <a href="edit-alternatif.php?id=<?= $alt["id_alternatif"]; ?>"
                      class="btn btn-warning py-2 px-3 mb-md-2 mb-lg-0" data-bs-toggle="tooltip" data-bs-title="Edit"><i class="bi bi-pencil-square"></i></a>
                    <a href="#" class="btn btn-danger py-2 px-3 text-white"
                      onclick="hapus(<?= $alt['id_alternatif'] ?>, '<?= $alt['alternatif'] ?>')"  data-bs-toggle="tooltip" data-bs-title="Hapus"><i
                        class="bi bi-trash"></i></a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

  </div> <!-- /container -->
  </main>
  </div>

  <?php include_once "footer.php"; ?>

  <script>
    // show datatables
    $(document).ready(function () {
      $(document).ready(function () {
        $('#tabel-alternatif').DataTable({
          language: {
            url: 'assets/js/Indonesian.json',
          },
        });
      });
    });
  </script>
  <script>
    // show tooltip
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  </script>
  <script>
    // show sweetalert
    function hapus(id, kriteria) {
      Swal.fire({
        title: 'Kamu yakin?',
        text: `Apakah kamu yakin menghapus '${kriteria}'`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Lanjut menghapus',
        cancleButtonText: 'Batal',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location = `middleware.php?action=delete&menu=alternatif&id=${id}`
        }
      })
    }
  </script>
</body>

</html>