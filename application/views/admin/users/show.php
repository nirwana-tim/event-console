<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="row">

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Account Information</h4>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8"><?= e($user->name) ?></dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8"><?= e($user->email) ?></dd>

                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-<?= role_badge_class($user->role) ?>">
                                <?= e($user->role) ?>
                            </span>
                        </dd>

                        <dt class="col-sm-4">Registered At</dt>
                        <dd class="col-sm-8"><?= e(app_date($user->created_at)) ?></dd>
                    </dl>

                    <div class="btn-group-wrap mt-4">
                        <?php if ((int) $user->id !== (int) $current_user_id) { ?>
                            <a href="<?= base_url('users/update/' . $user->id) ?>" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-1"></i>
                                Update
                            </a>
                        <?php } ?>

                        <a href="<?= base_url('users') ?>" class="btn btn-light">
                            Back
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
