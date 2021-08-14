<div class="container-fluid">
    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-md-7 <?= $this->agent->is_mobile() ? '' : 'mt-5' ?>">
            <div class="card">
                <div class="card-header">
                    <h5>FORM EDIT PROFIL</h5>
                </div>
                <form id="formProfil" name="formProfil" class="form-horizontal">
                    <div class="card-body text-sm pt-5">
                        <div class="row">
                            <div class="col-sm-4 text-center pb-4">
                                <?php if ($profil->foto != NULL) : ?>
                                    <img src="<?= base_url('assets/images/admin/' . $profil->foto) ?>" class="img-circle myAvatar" style="max-width: 100%; max-height: 200px" alt="Default Avatar"><br>
                                    <a href="javascript:void(0)" data-id="<?= $profil->id_admin ?>" style="text-decoration: none;" class="btn btn-danger btn-sm mt-2 fw-bold remove-avatar" id="btn-remove-avatar">
                                        <span>hapus foto</span>
                                    </a>
                                <?php else : ?>
                                    <img src="<?= base_url('assets/images/no-photo.png') ?>" class="img-circle myAvatar" style="max-width: 100%; max-height: 200px" alt="Default Avatar">
                                <?php endif ?>
                            </div>
                            <div class="col-md-8">
                                <input type="hidden" name="id_admin" id="id_admin" value="<?= $this->session->userdata('id_admin'); ?>">
                                <div class="form-group mb-3">
                                    <label>Nama Lengkap</label>
                                    <input id="nama" name="nama" value="<?= $profil->nama ?>" class="form-control form-control-sm" type="text" placeholder="masukkan nama lengkap" />
                                    <span id="nama_error"></span>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Nomor HP</label>
                                    <input id="hp" name="hp" value="<?= $profil->hp ?>" class="form-control form-control-sm" type="text" placeholder="masukkan nomor handphone" />
                                    <span id="hp_error"></span>
                                </div>
                                <div class="input-group mt-3">
                                    <input class="form-control form-control-sm" type="file" id="gambar" name="gambar">
                                </div>
                                <small class="text-danger">abaikan bila tidak ingin mengganti foto</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <label>Konfirmasi Password</label>
                        <div class="input-group input-group-sm">
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="untuk verfikasi, masukkan password anda">
                            <button type="submit" class="input-group-text btn-dark btn-sm font-weight-bold" id="btn-save-profil">SIMPAN</button>
                        </div>
                        <span id="password_error"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>