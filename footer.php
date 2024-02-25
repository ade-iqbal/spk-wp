<!-- bootstrap -->
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- datatables -->
<script type="text/javascript" language="javascript" src="assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>

<!-- sweetalert2 -->
<script src="assets/js/sweetalert2@11.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>

<!-- sweet alert success -->
<?php if(isset($_SESSION["success"])): ?>
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: '<?php echo $_SESSION["success"] ?>',
        showConfirmButton: false,
        timer: 1500
    })
</script>
<?php unset($_SESSION["success"]); endif; ?>

<!-- sweet alert fail -->
<?php if(isset($_SESSION["fail"])): ?> 
<script>
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $_SESSION["fail"] ?>',
        showConfirmButton: false,
        timer: 1500
    })
</script>
<?php unset($_SESSION["fail"]); endif; ?>