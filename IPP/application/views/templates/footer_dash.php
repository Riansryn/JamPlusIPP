</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright &copy; Your Website 2020</span>
		</div>
	</div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary" href="login.html">Logout</a>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Chart Js Plugin -->
<script src="<?= base_url('assets/'); ?>vendor/chart.js/Chart.min.js"></script>

<!-- DataTables Plugin -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Moment Js Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<?php
$kategori_counts = array();
$kategori_names = array();
$counter = 0;

// Populate $kategori_names array
foreach ($kategori as $row) {
	$kategori_names[$counter] = $row->ktg_id;
	$counter++;
}

// Initialize counts array
foreach ($kategori_names as $kategori_name) {
	$kategori_counts[$kategori_name] = 0;
}

// Count occurrences in Dashboard with pkj_status equal to 2
foreach ($Dashboard as $row) {
	if ($row->pkj_status == 2) {
		// Check if the category ID is in the counts array
		if (array_key_exists($row->ktg_id, $kategori_counts)) {
			// If yes, increment the count
			$kategori_counts[$row->ktg_id]++;
		}
	}
}

// Print the results
foreach ($kategori_counts as $kategori_id => $count) {
	echo '<script>console.log("Count each category ' . $kategori_id . ' : " + ' . $count . ')</script>';
}

?>

<script>
	const ctx = document.getElementById('pekerjaanChart');
	const labels = [<?php foreach ($kategori as $row) : echo '"' . $row->ktg_nama . '", ';
					endforeach; ?>];
	const datas = [<?php foreach ($kategori_counts as $kategori_name => $count) : echo $count . ", ";
					endforeach; ?>];
	const backgroundColors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'];

	new Chart(ctx, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: 'Data',
				data: datas,
				backgroundColor: backgroundColors, // Set the background color for each bar
				borderColor: backgroundColors, // Set the border color for each bar
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true,
					precision: 0
				}
			}
		}
	});

	// data table
	// Custom filtering function for date filtering
	$.fn.dataTableExt.afnFiltering.push(
		function(oSettings, aData, iDataIndex) {
			var filterType = $('#dateFilter').val(); // Get selected filter type
			var currentDate = new Date();
			var dataDate = new Date(aData[3]);

			if (filterType === 'today') {
				return currentDate.toDateString() === dataDate.toDateString();
			} else if (filterType === 'lastWeek') {
				var lastWeek = new Date();
				lastWeek.setDate(currentDate.getDate() - 7);
				return dataDate >= lastWeek && dataDate <= currentDate;
			} else if (filterType === 'thisMonth') {
				var firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
				var lastDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
				return dataDate >= firstDayOfMonth && dataDate <= lastDayOfMonth;
			}

			// If no filter is selected, show all data
			return true;
		}
	);

	$(document).ready(function() {
		var table = $('#pekerjaanTable').dataTable();

		// Add custom filtering by date
		$('#dateFilter').on('change', function() {
			table.fnDraw();
		});

	});

	// alert
	<?php if ($this->session->flashdata('error')) { ?>
		var isi = <?php echo json_encode($this->session->flashdata('error')) ?>;
		Swal.fire({
			icon: "error",
			title: "Oops...",
			text: isi,
		});
	<?php } ?>

	<?php if ($this->session->flashdata('success')) { ?>
		var isi = <?php echo json_encode($this->session->flashdata('success')) ?>;
		Swal.fire({
			icon: "success",
			title: "Berhasil...",
			text: isi,
		});
	<?php } ?>
</script>

</body>
</body>

</html>
