<div class="container-fluid px-4 py-4">
  <h4><?= $breadcrumb; ?></h4>
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body text-sm">
          <div style="text-align: right;">
            <a href="javascript:void(0)" class="btn btn-sm btn-dark" id="tambah">TAMBAH</a>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover pb-2" id="dtAdmin">
              <thead>
                <tr>
                  <th width="1%">No.</th>
                  <th>Nama</th>
                  <th>Level</th>
                  <th width="7%" style="text-align: center;">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-admin" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
      </div>

      <form id="formAdmin" name="formAdmin" class="form-horizontal">
        <div class="modal-body">
          <input type="hidden" name="id_admin" id="id_admin" value="">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">

          <div class="form-group mt-2 mb-3">
            <label>Level Admin</label>
            <select class="form-select form-select-sm" id="id_level" name="id_level" onclick="this.setAttribute('value', this.value);" value="">
              <option value="0" disabled selected>Pilih Level</option>
              <?php foreach ($level as $value) : ?>
                <option value="<?= $value->id_level ?>"><?= $value->level ?></option>
              <?php endforeach ?>
            </select>
            <span id="id_level_error"></span>
          </div>

          <div class="form-group mb-3">
            <label>Nama Admin</label>
            <input class="form-control form-control-sm" id="nama" name="nama" type="text" placeholder="masukkan nama admin" value="" />
            <span id="nama_error"></span>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label>Username</label>
                <input class="form-control form-control-sm" id="username" name="username" type="text" placeholder="masukkan username" value="" />
                <span id="username_error"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group mb-3">
                <label>Nomor HP</label>
                <input class="form-control form-control-sm" id="hp" name="hp" type="text" placeholder="masukkan nomor hp" value="" />
                <span id="hp_error"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputPassword">Password</label>
                <input class="form-control form-control-sm" id="password" name="password" type="password" placeholder="masukkan password baru" value="" />
                <span id="password_error"></span>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="inputPassword">Konfirmasi Password</label>
                <input class="form-control form-control-sm" id="repassword" name="repassword" type="password" placeholder="ulangi password baru" value="" />
                <span id="repassword_error"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-dark btn-sm float-right" id="btn-save">SIMPAN</button>
        </div>
      </form>
    </div>
  </div>
</div>