<!--
=========================================================
* Soft UI Dashboard - v1.0.3
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/images/favicon.png'); ?>">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png'); ?>">
    <title><?= $title; ?> - Sistem Kepegawaian</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/plugins/toastr/css/bootstrap-toaster.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/template/plugins/datatables-bs5/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link id="pagestyle" href="<?= base_url() ?>assets/template/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
    <?php if (isset($css)) {
        $this->load->view('admin/css/css-' . $css);
    } ?>
</head>

<body class="g-sidenav-show bg-gray-100">
    <!-- Sidebar -->
    <?php include 'components/sidebar.php' ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <?php include 'components/navbar.php' ?>

        <!-- Pages -->
        <?php $this->load->view($pages); ?>
    </main>
    <?php include 'components/footer.php' ?>

    <!--   Core JS Files   -->
    <script src="<?= base_url(); ?>assets/template/js/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/core/popper.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/core/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>assets/template/plugins/toastr/js/bootstrap-toaster.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/js/jquery_validation.js"></script>
    <script src="<?= base_url(); ?>assets/template/plugins/datatables-bs5/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/template/plugins/datatables-bs5/dataTables.bootstrap5.min.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url() ?>assets/template/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
    <script>
        Toast.configure(maxToasts = 3, placement = TOAST_PLACEMENT.BOTTOM_RIGHT, theme = TOAST_THEME.LIGHT, enableTimers = true);
    </script>
    <?php if (isset($js)) {
        $this->load->view('admin/js/js-' . $js);
    } ?>
</body>

</html>