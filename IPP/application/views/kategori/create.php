<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tambah Kategori</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('kategori/tambah'); ?>" id="formTambahKategori" method="post">
                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori: <font color="red">*</font></label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" maxlength="100" required>
                </div>
                <div class="form-group">
                    <label for="status">Status: <font color="red">*</font></label>
                    <select class="form-control" id="status" name="status">
                        <option value="">---- Pilih Opsi ----</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
                <button type="submit" id="save" class="btn btn-primary">Simpan</button>
                <button type="button" id="cancel" class="btn btn-primary" onclick="batal()">Batal</button>
            </form>
        </div>
    </div>
</>