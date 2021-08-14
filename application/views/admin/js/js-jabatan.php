<script src="<?= base_url(); ?>assets/template/js/jquery.mask.min.js"></script>
<script>
	var SITEURL = '<?= site_url(); ?>';
	$(document).ready(function() {
		$('#gaji').mask('000.000.000.000', {
			reverse: true
		});

		$('#dtJabatan').DataTable({
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
				"url": SITEURL + "jabatan/read",
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

		$('#tambah').click(function() {
			$('#btn-save').val("simpan");
			$('#id_jabatan').val('');
			$('#formJabatan').trigger("reset");
			$('#modalTitle').html("Tambah Jabatan Baru");
			$('#jabatan_error').html('');
			$('#gaji_error').html('');
			$('#modal-jabatan').modal('show');
		});

		$('body').on('click', '.edit-jabatan', function() {
			var id_jabatan = $(this).data("id");
			console.log(id_jabatan);
			$.ajax({
				type: "POST",
				url: SITEURL + "jabatan/getById",
				data: {
					id: id_jabatan,
					<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
				},
				dataType: "json",
				success: function(response) {
					if (response.success == true) {
						$('#modalTitle').html("Edit Data Jabatan");
						$('#btn-save').val("ubah");
						$('#jabatan_error').html('');
						$('#id_jabatan').val(response.data.id_jabatan);
						$('#jabatan').val(response.data.jabatan);
						$('#gaji').val(response.data.gaji).trigger('input');
						$('#modal-jabatan').modal('show');
					}
				},
				error: function(data) {
					console.log('Error:', data);
				}
			});
		});

		$('body').on('click', '.hapus-jabatan', function() {
			var id_jabatan = $(this).data("id");
			if (confirm("Hapus data jabatan ?")) {
				$.ajax({
					type: "Post",
					url: SITEURL + "jabatan/hapus",
					data: {
						id_jabatan: id_jabatan,
						<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
					},
					dataType: "json",
					success: function(data) {
						$("#id_jabatan_" + id_jabatan).remove();
						$("#dtJabatan").DataTable().ajax.reload();
						Toast.create('Hapus Data Sukses!', 'Data jabatan berhasil dihapus', TOAST_STATUS.SUCCESS, 5000);
					},
					error: function(data) {
						console.log('Error:', data);
						Toast.create('Error!', 'Terjadi kesalahan, coba lagi nanti', TOAST_STATUS.DANGER, 5000);
					}
				});
			}
		});
	});

	if ($("#formJabatan").length > 0) {
		$("#formJabatan").validate({
			submitHandler: function(form) {
				var actionType = $('#btn-save').val();
				$('#btn-save').html('<span class="spinner-border spinner-border-sm"></span>');
				$.ajax({
					data: $('#formJabatan').serialize(),
					url: SITEURL + "jabatan/simpan",
					type: "POST",
					dataType: 'json',
					beforeSend: function() {
						$('#btn-save').attr('disabled', 'disabled');
					},

					success: function(response) {
						if (response.error) {
							response.jabatan_error != '' ? $('#jabatan_error').html(response.jabatan_error) : $('#jabatan_error').html('');
							response.gaji_error != '' ? $('#gaji_error').html(response.gaji_error) : $('#gaji_error').html('');
							$('#btn-save').attr('disabled', false).html('SIMPAN');
						} else {
							$('#formJabatan').trigger("reset");
							$('#modal-jabatan').modal('hide');
							$('#btn-save').attr('disabled', false).html('SIMPAN');
							$("#dtJabatan").DataTable().ajax.reload();
							if ($('#id_jabatan').val().length > 0) {
								Toast.create('Update Data Sukses!', 'Data jabatan berhasil diperbarui', TOAST_STATUS.SUCCESS, 5000);
							} else {
								Toast.create('Input Data Sukses!', 'Data jabatan berhasil ditambahkan', TOAST_STATUS.SUCCESS, 5000);
							}
						}
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