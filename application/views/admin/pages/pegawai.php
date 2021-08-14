<div class="container-fluid px-4 py-4">
    <h4><?= $breadcrumb; ?></h4>
    <div class="row">
        <div class="col-sm-12 small">
            <div class="card">
                <div class="card-body text-sm">
                    <div style="text-align: right;">
                        <a href="javascript:void(0)" class="btn btn-sm btn-dark float-right" id="tambah">TAMBAH</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dtPegawai">
                            <thead>
                                <tr>
                                    <th width="1%" style="text-align: center;">No.</th>
                                    <th style="text-align: center;">Foto</th>
                                    <th>Data Pegawai</th>
                                    <th>Data Jabatan</th>
                                    <th style="text-align: center;">Alamat</th>
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

<div class="modal fade" id="modal-pegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
            </div>
            <form id="formPegawai" name="formPegawai" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_pegawai" id="id_pegawai" value="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Jabatan</label>
                            <select class="form-select form-select-sm" id="jabatan" name="jabatan" onclick="this.setAttribute('value', this.value);" value="">
                                <option value="0" disabled selected>Pilih Jabatan</option>
                                <?php foreach ($jabatan as $value) : ?>
                                    <option value="<?= $value->id_jabatan ?>"><?= $value->jabatan ?></option>
                                <?php endforeach ?>
                            </select>
                            <small id="jabatan_error"></small>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama</label>
                                <input class="form-control form-control-sm" id="nama" name="nama" type="text" placeholder="masukkan nama pegawai" value="" />
                                <small id="nama_error"></small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <input class="form-control form-control-sm" id="alamat" name="alamat" type="text" placeholder="masukkan alamat pegawai" value="" />
                        <small id="alamat_error"></small>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label>Jenis Kelamin</label>
                            <select class="form-select form-select-sm" id="jenis_kelamin" name="jenis_kelamin" onclick="this.setAttribute('value', this.value);" value="">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="0">Laki-Laki</option>
                                <option value="1">Perempuan</option>
                            </select>
                            <small id="jenis_kelamin_error"></small>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nomor HP</label>
                                <input class="form-control form-control-sm" id="nomor_hp" name="nomor_hp" type="text" placeholder="masukkan nomor HP pegawai" value="" />
                                <small id="nomor_hp_error"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Mulai Kerja</label>
                                <input class="datepicker date form-control form-control-sm" id="mulai_kerja" name="mulai_kerja" type="text" placeholder="masukkan tanggal mulai kerja" value="" />
                                <small id="mulai_kerja_error"></small>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="exampleInputFile">Foto <small class="text-danger">(max-size: 2MB; max-dimension: 2048 x 2048;)</small></label>
                        <div class="form-group" id="foto-preview">
                            <div class="col-md-12"><small>(tidak ada foto)</small></div>
                        </div>
                        <img id="uploadPreview" src="" class="ml-auto mr-auto mb-2" style="max-height: 100px; max-width: 100%; display: block;" />
                        <div class="input-group">
                            <div class="custom-file">
                                <input class="form-control form-control-sm" type="file" name="foto" id="foto" onchange="PreviewImage();">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark btn-sm btn-flat float-right" id="btn-save" value="create">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>