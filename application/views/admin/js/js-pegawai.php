<script src="<?= base_url(); ?>assets/template/plugins/datepicker/bootstrap-datepicker.min.js"></script>
<script>
    var SITEURL = '<?= site_url(); ?>';
    function PreviewImage() {
        $('#foto-preview').addClass('d-none');
        $('#uploadPreview').removeClass('d-none');
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("foto").files[0]);

        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result;
        };
    };

    $(document).ready(function() {
        $('.datepicker').datepicker({
            clearBtn: true,
            autoclose: true,
            format: "yyyy-mm-dd",
        });
        
        $('#dtPegawai').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "language": {
                "url": "<?= base_url('assets/template/plugins/indonesia.json') ?>",
                "sEmptyTable": "Tidads"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": SITEURL + "pegawai/read",
                "type": "POST",
                "data": {
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
            },
            "aaSorting": [],
        });

        $('#tambah').click(function() {
            $('#btn-save').val("simpan");
            $('#id_pegawai').val('');
            $('#formPegawai').trigger("reset");
            $('#modalTitle').html("Tambah Pegawai Baru");
            $('#jabatan_error').html('');
            $('#nama_error').html('');
            $('#jenis_kelamin_error').html('');
            $('#nomor_hp_error').html('');
            $('#alamat_error').html('');
            $('#mulai_kerja_error').html('');
            $('#uploadPreview').addClass('d-none');
            $('#foto-preview').addClass('d-none');
            $('#modal-pegawai').modal('show');
        });

        $('body').on('click', '.edit-pegawai', function() {
            var id_pegawai = $(this).data("id");
            $.ajax({
                type: "POST",
                url: SITEURL + "pegawai/getByid",
                data: {
                    id: id_pegawai,
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#modalTitle').html("Edit Pegawai");
                        $('#btn-save').val("ubah");
                        $('#pegawai_error').html('');
                        $('#id_pegawai').val(response.data.id_pegawai);
                        $('#jabatan').val(response.data.jabatan);
                        $('#nama').val(response.data.nama);
                        $('#jenis_kelamin').val(response.data.jenis_kelamin);
                        $('#nomor_hp').val(response.data.nomor_hp);
                        $('#mulai_kerja').val(response.data.mulai_kerja);
                        $('#alamat').val(response.data.alamat);
                        if (response.data.foto) {
                            $('#label-foto').text('Ganti foto');
                            $('#foto-preview div').html('<img src="' + SITEURL + 'assets/images/pegawai/' + response.data.foto + '" class="img-responsive" style="max-height: 100px; max-width: 100%; display: block; margin-bottom: 10px">');
                        } else {
                            $('#label-foto').text('Upload foto');
                            $('#foto-preview div').html('<small class="text-danger">(tidak ada foto)</small>');
                        }

                        $('#uploadPreview').addClass('d-none');
                        $('#foto-preview').removeClass('d-none');
                        $('#modal-pegawai').modal('show');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('body').on('click', '.hapus-pegawai', function() {
            var id_pegawai = $(this).data("id");
            if (confirm("Hapus data pegawai ini ?")) {
                $.ajax({
                    type: "Post",
                    url: SITEURL + "pegawai/hapus",
                    data: {
                        id_pegawai: id_pegawai,
                        <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#id_pegawai_" + id_pegawai).remove();
                        $("#dtPegawai").DataTable().ajax.reload();
                        Toast.create('Hapus Data Sukses!', 'Data pegawai berhasil dihapus', TOAST_STATUS.SUCCESS, 5000);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                    }
                });
            }
        });
    });

    if ($("#formPegawai").length > 0) {
        $("#formPegawai").validate({
            submitHandler: function(form) {
                var formData = new FormData($('#formPegawai')[0]);
                $('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
                $.ajax({
                    data: formData,
                    url: SITEURL + "pegawai/simpan",
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btn-save').attr('disabled', 'disabled');
                    },

                    success: function(response) {
                        if (response.failed_upload) {
                            Toast.create('Gagal Upload Gambar!', 'Ganti foto atau coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                        } else {
                            if (response.error) {
                                response.jabatan_error != '' ? $('#jabatan_error').html(response.jabatan_error) : $('#jabatan_error').html('');
                                response.nama_error != '' ? $('#nama_error').html(response.nama_error) : $('#nama_error').html('');
                                response.alamat_error != '' ? $('#alamat_error').html(response.alamat_error) : $('#alamat_error').html('');
                                response.jenis_kelamin_error != '' ? $('#jenis_kelamin_error').html(response.jenis_kelamin_error) : $('#jenis_kelamin_error').html('');
                                response.nomor_hp_error != '' ? $('#nomor_hp_error').html(response.nomor_hp_error) : $('#nomor_hp_error').html('');
                                response.mulai_kerja_error != '' ? $('#mulai_kerja_error').html(response.mulai_kerja_error) : $('#mulai_kerja_error').html('');
                            } else {
                                $('#formPegawai').trigger("reset");
                                $('#modal-pegawai').modal('hide');
                                $("#dtPegawai").DataTable().ajax.reload();
                                if ($('#id_pegawai').val().length > 0) {
                                    Toast.create('Update Data Sukses!', 'Data pegawai berhasil diperbarui', TOAST_STATUS.SUCCESS, 5000);
                                } else {
                                    Toast.create('Input Data Sukses!', 'Data pegawai berhasil ditambahkan', TOAST_STATUS.SUCCESS, 5000);
                                }
                            }
                        }
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    }
                });
            }
        })
    }
</script>