<div class="container-fluid px-4 py-4">
    <h4><?= $breadcrumb; ?></h4>
    <div class="row">
        <div class="col-sm-12 small">
            <div class="card">
                <div class="card-body text-sm">
                    <div class="" style="text-align: right;">
                        <a href="javascript:void(0)" class="btn btn-sm btn-dark float-right" id="tambah">TAMBAH</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover pb-2" id="dtLevel">
                            <thead>
                                <tr>
                                    <th width="1%" style="text-align: center;">No.</th>
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

<div class="modal fade" id="modal-level" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
            </div>
            <form id="formLevel" name="formLevel" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="id_level" id="id_level" value="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <div class="form-group mb-2">
                        <label class="small">Nama Level</label>
                        <input class="form-control" style="font-size: small;" id="level" name="level" type="text" placeholder="masukkan nama level" value="" />
                        <small id="level_error" class="text-danger" style="font-size: small;"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark btn-sm float-right" id="btn-save">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>