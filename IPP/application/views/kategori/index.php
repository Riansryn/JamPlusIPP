<!-- index.php -->
<div class="container-fluid">
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Kategori</h6>
        </div>
            <div class="card-body">
            <div>
            <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Data Kategori</h6>
        </div>
        <div class="card-body">
            <a href="<?= base_url('kategori/create'); ?>" class="btn btn-success">Tambah Data</a>
            <br><br>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($kategori as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->ktg_nama ?></td>
                                <td><?= $row->ktg_status == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                                <td>
                                    <a href="<?= base_url('kategori/update/' . $row->ktg_id); ?>" class=""> <i class="fas fa-edit"></i>
                                    </a>
                                    <input type="checkbox" data-toggle="switchbutton" class="status-switch" data-ktg-id="<?= $row->ktg_id ?>" <?= $row->ktg_status == 1 ? 'checked' : '' ?> data-onstyle="primary" data-onlabel="Aktif" data-offlabel="Tidak Aktif">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
