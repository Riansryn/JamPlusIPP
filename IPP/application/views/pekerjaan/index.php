<div class="container-fluid">
	<div class="card mb-4">
		<label for="filter_tanggal">Filter by Date:</label>
		<input type="month" id="filter_tanggal" name="filter_tanggal" required>
		<button type="button" onclick="filterChart()">Filter</button>
	</div>
	<div class="card mb-4">
		<canvas id="pekerjaanChart"></canvas>
	</div>
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Data Pekerjaan</h6>
		</div>
		<div class="card-body">
			<a href="<?= base_url('pekerjaan/create'); ?>" class="btn btn-success">Tambah Data</a>
			<br><br>
			<div class="table-responsive">
				<label>Date Filter:
					<select id="dateFilter">
						<option value="">All</option>
						<option value="today">Today</option>
						<option value="lastWeek">Last Week</option>
						<option value="thisMonth">This Month</option>
					</select>
				</label>
				<table class="table table-bordered" id="pekerjaanTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Pekerjaan</th>
							<th>Kategori Pekerjaan</th>
							<th>Tanggal Pekerjaan</th>
							<th>Rencana Jam</th>
							<th>Status Pekerjaan</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1; ?>
						<?php foreach ($Dashboard as $row) : ?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $row->pkj_nama ?></td>
								<?php foreach ($kategori as $row2) : ?>
									<?php if ($row->ktg_id == $row2->ktg_id) : ?>
										<td><?= $row2->ktg_nama ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
								<td><?= $row->pkj_tanggal ?></td>
								<td><?= strval($row->pkj_rencana_jam_awal) . " s.d. " . strval($row->pkj_rencana_jam_akhir); ?></td>
								<td><?php
									if ($row->pkj_status == 0) {
										echo "Draft";
									} else if ($row->pkj_status == 1) {
										echo "On going";
									} else {
										echo "Done";
									} ?></td>
								<td>
									<?php if ($row->pkj_status == 0) { ?>
										<a href="<?= base_url('Pekerjaan/kirim/' . $row->pkj_id); ?>" class="btn btn-primary btn-sm">Kirim</a>
										<a href="<?= base_url('Pekerjaan/update/' . $row->pkj_id); ?>" class="btn btn-primary btn-sm">Edit</a>
									<?php } else if ($row->pkj_status == 1) { ?>
										<a href="<?= base_url('Pekerjaan/selesai/' . $row->pkj_id); ?>" class="btn btn-primary btn-sm">Selesaikan</a>
									<?php } else { ?>
										<!-- <a href="<?= base_url('Pekerjaan/update/' . $row->pkj_id); ?>" class="btn btn-primary btn-sm">Detail</a> -->
										<button class="btn btn-primary btn-sm" disabled>Selesai</button>
									<?php } ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
