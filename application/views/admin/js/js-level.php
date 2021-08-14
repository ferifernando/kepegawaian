<script>
	var SITEURL = '<?= site_url(); ?>';
	$(document).ready(function () {
		$('#dtLevel').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"language" :{
                "url": "<?= base_url('assets/template/plugins/indonesia.json') ?>",
				"sEmptyTable" : "Tidads"
			},
			"processing": true,
			"serverSide": true,
			"ajax": {
				"url": SITEURL + "level/read",
				"type": "POST",
				"data": {
					<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
				},
			},
            "aaSorting": [],
            "columnDefs": [{
                "orderable": false,
                "targets": [0, -1]
            }]
		});

		$('#tambah').click(function () {
			$('#btn-save').val("simpan");
			$('#id_level').val('');
			$('#formLevel').trigger("reset");
			$('#modalTitle').html("Tambah Level");
			$('#level_error').html('');
			$('#modal-level').modal('show');
		});

		$('body').on('click', '.edit-level', function () {
			var id_level = $(this).data("id");
			console.log(id_level);
			$.ajax({
				type: "POST",
				url: SITEURL + "level/getById",
				data: {
					id: id_level,
					<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
				},
				dataType: "json",
				success: function (kis) {
					if (kis.success == true) {
						$('#modalTitle').html("Edit Data Level");
						$('#btn-save').val("ubah");
						$('#level_error').html('');
						$('#id_level').val(kis.data.id_level);
						$('#level').val(kis.data.level);
						$('#modal-level').modal('show');
					}
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		});

		$('body').on('click', '.hapus-level', function () {
			var id_level = $(this).data("id");
			if (confirm("Hapus data level ?")) {
				$.ajax({
					type: "Post",
					url: SITEURL + "level/hapus",
					data: {
						id_level: id_level,
						<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
					},
					dataType: "json",
					success: function (data) {
						$("#id_level_" + id_level).remove();
						$("#dtLevel").DataTable().ajax.reload();
                        Toast.create('Hapus Data Sukses!', 'Data level berhasil dihapus', TOAST_STATUS.SUCCESS, 5000);
					},
					error: function (data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
					}
				});
			}
		});
	});

	if ($("#formLevel").length > 0) {
		$("#formLevel").validate({
			submitHandler: function (form) {
				var actionType = $('#btn-save').val();
				$('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
				$.ajax({
					data: $('#formLevel').serialize(),
					url: SITEURL + "level/simpan",
					type: "POST",
					dataType: 'json',
					beforeSend:function(){
						$('#btn-save').attr('disabled', 'disabled');
					},

					success: function (kis) {
						if(kis.error)
						{
							if(kis.level_error != ''){$('#level_error').html(kis.level_error);}
							else{$('#level_error').html('');}
							$('#btn-save').attr('disabled', false).html('SIMPAN');
						} else {
							$('#formLevel').trigger("reset");
							$('#modal-level').modal('hide');
							$('#btn-save').attr('disabled', false).html('SIMPAN');
							$("#dtLevel").DataTable().ajax.reload();
							if ($('#id_level').val().length>0) {	
                                Toast.create('Update Data Sukses!', 'Data level berhasil diperbarui', TOAST_STATUS.SUCCESS, 5000);
                            } else {
                                Toast.create('Input Data Sukses!', 'Data level berhasil ditambahkan', TOAST_STATUS.SUCCESS, 5000);
							}
						}
					},
					error: function (data) {
                        console.log('Error:', data);
                        Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
						$('#btn-save').attr('disabled', false).html('SIMPAN');
					}
				});
			}
		})
	}
</script>
