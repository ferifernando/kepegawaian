<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="<?= site_url(); ?>">Home</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?= $breadcrumb; ?></li>
            </ol>
            <h6 class="font-weight-bolder mb-0"><?= $title; ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-md-auto justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="avatar avatar-xs me-2" src="<?= $this->session->userdata('foto') == null ? base_url('assets/images/no-photo.png') : base_url('assets/images/admin/' . $this->session->userdata('foto')); ?>" alt="user-profile">
                        <?php if (!$this->agent->is_mobile()) : ?>
                            <span class="font-weight-bold me-sm-1"><?= $this->session->userdata('nama'); ?></span>
                        <?php endif; ?>
                        <i class="fa fa-chevron-down fa-xs"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="<?= site_url('profil'); ?>">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="fa fa-user-edit avatar avatar-xs bg-gradient-info p-2 me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Edit Profil</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="<?= site_url('ganti-password'); ?>">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="fa fa-key avatar avatar-xs bg-gradient-dark p-2 me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Ganti Password</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <hr class="horizontal dark mt-0">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="<?= site_url('login/out'); ?>" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <i class="fa fa-key avatar avatar-xs bg-gradient-danger p-2 me-3"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Logout</h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>