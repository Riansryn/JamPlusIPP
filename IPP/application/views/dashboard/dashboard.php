<canvas id="clusteredColumnChart" width="500" height="200"></canvas>

    <script>
        var clusteredColumnCtx = document.getElementById('clusteredColumnChart').getContext('2d');
        var clusteredColumnChart = new Chart(clusteredColumnCtx, {
            type: 'bar',
            data: {
                labels: <?= $categories; ?>,
                datasets: [{
                    label: 'Pengajaran',
                    data: <?= $dataset1; ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },{
                    label: 'Penelitian',
                    data: <?= $dataset2; ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },{
                    label: 'Pengabdian',
                    data: <?= $dataset3; ?>,
                    backgroundColor: 'rgba(144, 238, 144, 0.5)',
                    borderColor: 'rgba(144, 238, 144, 1)',
                    borderWidth: 1
                },{
                    label: 'Struktural',
                    data: <?= $dataset4; ?>,
                    backgroundColor: 'rgba(211, 211, 211, 0.5)',
                    borderColor: 'rgba(211, 211, 211, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        stacked: false
                    }
                }
            }
        });
    </script>
<div class="container mt-3">
   <h2>Gambar</h2>
<th>
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            // PHP code to generate dynamic image data
            $images = [
                'assets/img/image1.jpg',
                'assets/img/image2.jpg',
                'assets/img/image3.jpg'
                // Add more image filenames as needed
            ];


            foreach ($images as $index => $image) {
                ?>
                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                    <img src="<?php echo $image; ?>" class="d-block w-50 h-50" alt="Image <?php echo $index + 1; ?>">
                    <div class="carousel-caption d-none d-md-block">
                       
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </th>
</div>


