<div class="container-fluid">
    <div class="row justify-content-center align-items-center mt-5">
        <div class="col-sm-4 <?= $this->agent->is_mobile() ? '' : 'mt-5' ?>">
            <div class="card">
                <div class="text-center mt-4 font-weight-bold">
                    <h5>FORM GANTI PASSWORD</h5>
                </div>
                <form id="formPass" name="formPass" class="form-horizontal">
                    <input type="hidden" name="id_admin" id="id_admin" value=<?= $this->session->userdata('id_admin'); ?>>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="small" for="inputPassword">Password Baru</label>
                            <input class="form-control form-control-sm" name="npass" type="password" placeholder="masukkan password baru" value="" />
                            <small id="npass_error"></small>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small" for="inputPassword">Konfirmasi Password Baru</label>
                            <input class="form-control form-control-sm" name="repass" type="password" placeholder="ulangi password baru" value="" />
                            <small id="repass_error"></small>
                        </div>

                        <div class="callout callout-danger">
                            <small class="text-primary text-xs font-weight-bold">Untuk verifikasi, masukkan password anda saat ini.</small>
                        </div>

                        <div class="form-group">
                            <label class="small" for="inputPassword">Password Saat Ini</label>
                            <input class="form-control form-control-sm" name="password" type="password" placeholder="masukkan password saat ini" value="" />
                            <small id="pass_error"></small>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-dark btn-sm btn-flat" id="btn-save">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>