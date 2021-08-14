<?php $this->load->view('admin/components/copyright.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/images/favicon.png'); ?>">
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png'); ?>">
    <title><?= $title; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url() ?>assets/template/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100">
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                                    <p class="mb-0">Enter your username and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <?= '<span class="text-center">' . $this->session->flashdata('message') . '</span>'; ?>
                                    <form action="#" method="post">
                                        <label>Username</label>
                                        <div class="mb-3">
                                            <input type="username" name="username" class="form-control" placeholder="Username" autofocus aria-label="Username" aria-describedby="username-addon" value="<?= $this->session->flashdata('username'); ?>">
                                            <div class="input-group small">
                                                <small><?= form_error('username', '<small class="text-danger">', '</small>') ?></small>
                                            </div>
                                        </div>

                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" value="<?= $this->session->flashdata('password'); ?>">
                                            <div class="input-group small">
                                                <small><?= form_error('password', '<small class="text-danger">', '</small>') ?></small>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('<?= base_url() ?>assets/images/login-curved-image.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto text-center mb-2">
                    <p class="mb-0 text-secondary text-xs">
                        Copyright © <script>
                            document.write(new Date().getFullYear())
                        </script>. <a href="<?= site_url(); ?>" class="font-weight-bold">Feri fernando</a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core JS Files   -->
    <script src="<?= base_url() ?>assets/template/js/core/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/template/js/core/bootstrap.min.js"></script>
</body>

</html>