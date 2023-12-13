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
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom Button Script -->
<script>

    //btnSave
    // document.getElementById('save').addEventListener('click', function() {
    // // Example of success notification
    // Swal.fire({
    //     icon: 'success',
    //     title: 'Sukses!',
    //     text: 'Data berhasil disimpan.',
    //     showConfirmButton: true,
    //     timer: 9000,
    // }).then((result) => {
    //         if (result.isConfirmed) {
    //         // Redirect to the index page after clicking OK
    //         window.location.href = '<?= base_url('kategori/index'); ?>';
    //         }
    //     });
    // });



    // toogle
    $(document).ready(function () {
        // Menangani peristiwa saat tombol switch (checkbox) diubah
        $('.status-switch').on('change', function (e) {
            // Ambil nilai status dan id kategori
            var status = $(this).prop('checked') ? 'Aktif' : 'Tidak Aktif';
            var ktgId = $(this).data('ktg-id');

            // Konfirmasi dengan alert Yes/No
            var confirmation = confirm('Anda yakin ingin mengubah status?');

            if (!confirmation) {
                // Batalkan perubahan jika pengguna memilih "No"
                // Gantilah sesuai dengan tindakan yang sesuai
                e.preventDefault();
                $(this).bootstrapToggle('toggle'); // Jika menggunakan Bootstrap Toggle
            } else {
                // Kirim permintaan AJAX ke fungsi update_status di controller
                $.ajax({
                    url: '<?= base_url('kategori/update_status'); ?>',
                    type: 'POST',
                    data: {
                        ktg_id: ktgId,
                        status: status
                    },
                    dataType: 'json',
                    success: function (response) {
                        // Perbarui tampilan jika berhasil
                        if (response.success) {
                            alert(response.message); // Gantilah dengan tindakan yang sesuai
                            window.location.href = '<?= base_url('kategori/index'); ?>';
                        } else {
                            alert('Gagal memperbarui status.');
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat mengirim permintaan.');
                    }
                });
            }
        });
    });

    // button
    function batal() {
        document.getElementById('nama_kategori').value = '';
        document.getElementById('status').value = '';

        window.location.href = '<?= base_url('kategori/index'); ?>';
    }

    function batalEdit() {
        window.location.href = '<?= base_url('kategori/index'); ?>';
    }

    // chart
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });

</script>
</body>
</body>

</html>