<div class="page-heading">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>User Management</h3>
            <p class="page-subtitle">Manage account roles for admins and participants.</p>
        </div>
        <div>
            <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i>
                Create User
            </a>
        </div>
    </div>

</div>

<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Filter Users</h4>
        </div>

        <div class="card-body">

            <form method="get" class="mb-4">

                <div class="row g-2 align-items-end">

                    <div class="col-md-5">
                        <label for="keyword" class="form-label">Search</label>
                        <input type="text"
                            id="keyword"
                            name="keyword"
                            class="form-control"
                            value="<?= e($keyword) ?>"
                            placeholder="Search name or email...">
                    </div>

                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select">
                            <option value="">All Roles</option>
                            <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="participant" <?= $role === 'participant' ? 'selected' : '' ?>>Participant</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="btn-group-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>
                                Search
                            </button>
                            <a href="<?= base_url('users') ?>" class="btn btn-light">
                                Reset
                            </a>
                        </div>
                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-users">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($users)) { ?>

                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-person-x d-block mb-2"></i>
                                    No users found
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach ($users as $user) { ?>

                        <tr>
                            <td><strong><?= e($user->name) ?></strong></td>
                            <td><?= e($user->email) ?></td>
                            <td>
                                <span class="badge bg-<?= role_badge_class($user->role) ?>">
                                    <?= e($user->role) ?>
                                </span>
                            </td>
                            <td><?= e(app_date($user->created_at)) ?></td>
                            <td>
                                <?php if ((int) $user->id === (int) $current_user_id) { ?>
                                    <span class="text-muted">Current account</span>
                                <?php } else { ?>
                                    <div class="btn-group-wrap">
                                        <a href="<?= base_url('users/show/' . $user->id) ?>"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye me-1"></i>
                                            Show
                                        </a>

                                        <a href="<?= base_url('users/update/' . $user->id) ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            Update
                                        </a>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
