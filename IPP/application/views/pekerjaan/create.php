<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tambah Pekerjaan</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('Pekerjaan/tambah'); ?>" method="post">
                <div class="form-group">
                    <label for="nama_pekerjaan">Nama Pekerjaan:</label>
                    <input type="text" class="form-control" id="nama_pekerjaan" name="nama_pekerjaan" maxlength="100">
                </div>
                <div class="form-group">
                    <label for="tanggal_pekerjaan">Tanggal Pekerjaan:</label>
                    <input type="date" class="form-control" id="tanggal_pekerjaan" name="tanggal_pekerjaan">
                </div>
                <div class="form-group">
                    <label for="waktu_mulai">Waktu Mulai:</label>
                    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
                </div>
                <div class="form-group">
                    <label for="waktu_selesai">Waktu Selesai:</label>
                    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai">
                </div>
                <div class="form-group">
                    <label for="kategori_pekerjaan">Kategori Pekerjaan:</label>
                    <select class="form-control" id="kategori_pekerjaan" name="kategori_pekerjaan">
						<option value="">-- Pilih Kategori Pekerjaan --</option>
                        <?php foreach ($kategori as $row):?>
							<?php if($row->ktg_status == "1"): ?>
								<option value="<?= $row->ktg_id; ?>"><?= $row->ktg_nama; ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script>
	// instance date
	document.getElementById("tanggal_pekerjaan").valueAsDate = new Date();
</script>
