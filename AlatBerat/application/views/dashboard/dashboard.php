<?php if (!empty($apps)): ?>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <a style="color: #0275d8" data-toggle="collapse" href="<?php echo base_url("dashboard") ?>">Single Sign On Application</a> / Dashboard
                </h6>
            </div>
            <div class="card-body">
                <div id="accordion" role="tablist" aria-multiselectable="true">
                    <?php foreach ($apps as $app_id => $app): ?>
                        <div class="card">
                            <div class="card-header" role="tab" id="heading<?php echo $app_id; ?>">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $app_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $app_id; ?>">
                                        <?php echo $app['app_nama']; ?>
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse<?php echo $app_id; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $app_id; ?>">
                                <div class="card-block">
                                    <div class="list-group">
                                        <?php if (!empty($app['roles'])): ?>
                                            <?php foreach ($app['roles'] as $role): ?>
                                                <a href="<?php echo base_url('Redirect') ?>?token=<?php echo $role['token']; ?>" class='list-group-item list-group-item-action'>
                                                    Login sebagai <?php echo $role['role_nama']; ?>
                                                </a>
                                                <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>Tidak ada roles yang tersedia.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Tidak ada aplikasi yang tersedia.</p>
<?php endif; ?>
