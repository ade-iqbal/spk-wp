<?php
	require_once 'configdb.php';
  require_once 'functions/kriteria.php';
  include_once "header.php";

  $kriterias = new Kriteria;
  $kriteria = $kriterias->getAllKriteria();
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
        <li><a href="kriteria.php" class="active">Data Kriteria</a></li>
        <li><a href="alternatif.php">Data Alternatif</a></li>
        <li><a href="perhitungan.php">Perhitungan</a></li>
      </ul>
    </aside>
    <main>
      <div class="container">

        <div id="page-wrapper">
          <a class="btn-add-alternatif" href='add-kriteria.php'><i class="bi bi-plus-square"></i> Tambah Data</a>
          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-primary card p-3" style="border-radius:16px;border:none;">
                <div class="panel-body table-responsive">
                  <table id="tabel-kriteria" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 2rem;">No.</th>
                        <th>Kriteria</th>
                        <th>Kepentingan</th>
                        <th>Cost / Benefit</th>
                        <th class='text-center'>Opsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=1;
                        foreach($kriteria as $k) :
                      ?>
                      <tr>
                        <td class="text-center"><?= $i++ ?>.</td>
                        <td><?= $k['kriteria'] ?></td>
                        <td><?= $k['kepentingan'] ?></td>
                        <td class="text-uppercase"><?= $k['cost_benefit'] ?></td>
                        <td class="text-center p-2">
                          <a href="edit-kriteria.php?id=<?= $k["id_kriteria"]; ?>" class="btn btn-warning py-2 px-3 mb-md-2 mb-lg-0"  data-bs-toggle="tooltip" data-bs-title="Edit"><i class="bi bi-pencil-square"></i></a>
                          <a href="#" class="btn btn-danger py-2 px-3 text-white" onclick="hapus(<?= $k['id_kriteria'] ?>, '<?= $k['kriteria'] ?>')" data-bs-toggle="tooltip" data-bs-title="Hapus"><i class="bi bi-trash"></i></a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div> <!-- /page wrapper -->
  </div> <!-- /container -->
  </main>
  </div>

  <?php include_once "footer.php"; ?>
  
  <script>
    // show datatables
    $(document).ready(function () {
      $(document).ready( function () {
          $('#tabel-kriteria').DataTable({
            language: {
                url: 'assets/js/Indonesian.json',
            },
          });
      } );
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
          window.location = `middleware.php?action=delete&menu=kriteria&id=${id}`
        }
      })
    }
  </script>
</body>

</html>