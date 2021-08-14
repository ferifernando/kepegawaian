<script>
    var SITEURL = '<?= site_url(); ?>';
    $(document).ready(function() {
        $('#dtAdmin').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "url": "<?= base_url('assets/template/plugins/indonesia.json') ?>",
                "sEmptyTable": "Tidads"
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": SITEURL + "admin/read",
                "type": "POST",
                "data": {
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
            },
            "aaSorting": [],
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 1, -1]
            }]
        });

        $('#tambah').click(function() {
            $('#btn-save').val("simpan");
            $('#formAdmin').trigger("reset");
            $('#modalTitle').html("Tambah Admin");
            $('#username').attr('readonly', false);
            $('#id_level').val(0).click().attr('readonly', false);
            $('#id_level_error').html('');
            $('#username_error').html('');
            $('#nama_error').html('');
            $('#hp_error').html('');
            $('#password_error').html('');
            $('#repassword_error').html('');
            $('#modal-admin').modal('show');
        });

        $('body').on('click', '.edit-admin', function() {
            var id_admin = $(this).data("id");
            console.log(id_admin);
            $.ajax({
                type: "POST",
                url: SITEURL + "admin/getById",
                data: {
                    id: id_admin,
                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                },
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        $('#modalTitle').html("Edit Data admin");
                        $('#btn-save').val("ubah");
                        $('#id_level_error').html('');
                        $('#username_error').html('');
                        $('#nama_error').html('');
                        $('#email_error').html('');
                        $('#hp_error').html('');
                        $('#password_error').html('');
                        $('#repassword_error').html('');
                        $('#id_admin').val(response.data.id_admin);
                        $('#username').val(response.data.username).attr('readonly', true);
                        $('#nama').val(response.data.nama);
                        $('#hp').val(response.data.hp);
                        $('#id_level').val(response.data.level).click().change();
                        $('#modal-admin').modal('show');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('body').on('click', '.hapus-admin', function() {
            var id_admin = $(this).data("id");
            if (confirm("Hapus admin ini?")) {
                $.ajax({
                    type: "Post",
                    url: SITEURL + "admin/hapus",
                    data: {
                        id_admin: id_admin,
                        <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#id_admin_" + id_admin).remove();
                        $("#dtAdmin").DataTable().ajax.reload();
                        Toast.create('Hapus Data Sukses!', 'Data admin berhasil dihapus', TOAST_STATUS.SUCCESS, 5000);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                    }
                });
            }
        });
    });

    if ($("#formAdmin").length > 0) {
        $("#formAdmin").validate({
            submitHandler: function(form) {
                $('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
                $.ajax({
                    data: $('#formAdmin').serialize(),
                    url: SITEURL + "admin/simpan",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-save').attr('disabled', 'disabled');
                    },
                    success: function(response) {
                        if (response.error) {
                            response.id_level_error != '' ? $('#id_level_error').html(response.id_level_error) : $('#id_level_error').html('');
                            response.nama_error != '' ? $('#nama_error').html(response.nama_error) : $('#nama_error').html('');
                            response.username_error != '' ? $('#username_error').html(response.username_error) : $('#username_error').html('');
                            response.email_error != '' ? $('#email_error').html(response.email_error) : $('#email_error').html('');
                            response.hp_error != '' ? $('#hp_error').html(response.hp_error) : $('#hp_error').html('');
                            response.password_error != '' ? $('#password_error').html(response.password_error) : $('#password_error').html('');
                            response.repassword_error != '' ? $('#repassword_error').html(response.repassword_error) : $('#repassword_error').html('');
                        } else {
                            $('#formAdmin').trigger("reset");
                            $('#modal-admin').modal('hide');
                            $('#dtAdmin').DataTable().ajax.reload();
                            if ($('#id_admin').val().length > 0) {
                                Toast.create('Update Data Sukses!', 'Data admin berhasil diperbarui', TOAST_STATUS.SUCCESS, 5000);
                            } else {
                                Toast.create('Input Data Sukses!', 'Data admin berhasil ditambahkan', TOAST_STATUS.SUCCESS, 5000);
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

    if ($("#formPass").length > 0) {
        $('#pass_error').html('');
        $('#npass_error').html('');
        $('#repass_error').html('');
        $("#formPass").validate({
            submitHandler: function(form) {
                $('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
                $.ajax({
                    data: $('#formPass').serialize(),
                    url: SITEURL + "admin/updatePassword",
                    type: "POST",
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn-save').attr('disabled', 'disabled');
                    },
                    success: function(response) {
                        if (response.wrongpass) {
                            Toast.create('Password Salah!', 'Silakan periksa kembali password anda', TOAST_STATUS.DANGER, 5000);
                        } else {
                            if (response.error) {
                                response.pass_error != '' ? $('#pass_error').html(response.pass_error) : $('#pass_error').html('');
                                response.npass_error != '' ? $('#npass_error').html(response.npass_error) : $('#npass_error').html('');
                                response.repass_error != '' ? $('#repass_error').html(response.repass_error) : $('#repass_error').html('');
                            } else {
                                $('#formPass').trigger("reset");
                                Toast.create('Update Profil Sukses!', 'Password berhasil diubah', TOAST_STATUS.SUCCESS, 5000);
                            }
                        }
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    },
                });
            },
        });
    }

    $('body').on('click', '.remove-avatar', function() {
        var id_admin = $(this).data("id");
        if (confirm("Apakah anda yakin ingin menghapus foto profil ?")) {
            $.ajax({
                type: "POST",
                url: SITEURL + "admin/removeAvatar",
                data: {
                    id_admin: id_admin,
                },
                dataType: "json",
                success: function(data) {
                    $(".myAvatar").attr("src", SITEURL + "assets/images/no-photo.jpg");
                    $(".profpic").attr("src", SITEURL + "assets/images/no-photo.jpg");
                    $("#btn-remove-avatar").addClass('d-none').attr('disabled', false);
                    Toast.create('Update Profil Sukses!', 'Foto profil berhasil dihapus', TOAST_STATUS.SUCCESS, 5000);
                    location.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
    });

    if ($("#formProfil").length > 0) {
        $('#nama_error').html('');
        $('#hp_error').html('');
        $('#password_error').html('');
        $("#formProfil").validate({
            submitHandler: function(form) {
                var formData = new FormData($('#formProfil')[0]);
                $('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
                $.ajax({
                    data: formData,
                    url: SITEURL + "admin/updateProfil",
                    type: "POST",
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#btn-save').attr('disabled', 'disabled');
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.wrongpass) {
                            Toast.create('Password Salah!', 'Silakan periksa kembali password anda', TOAST_STATUS.DANGER, 5000);
                        } else {
                            if (response.error) {
                                response.nama_error != '' ? $('#nama_error').html('<small>' + response.nama_error + '</small>') : $('#nama_error').html('');
                                response.hp_error != '' ? $('#hp_error').html('<small>' + response.hp_error + '</small>') : $('#hp_error').html('');
                                response.password_error != '' ? $('#password_error').html('<small>' + response.password_error + '</small>') : $('#password_error').html('');
                            } else {
                                $('#formProfil').trigger("reset");
                                $('#nama').val(response.data.nama);
                                $('#hp').val(response.data.hp);
                                location.reload();
                                Toast.create('Update Profil Sukses!', 'Profil berhasil diubah', TOAST_STATUS.SUCCESS, 5000);
                            }
                        }
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
                        $('#btn-save').attr('disabled', false).html('SIMPAN');
                    },
                });
            },
        });
    }
</script>