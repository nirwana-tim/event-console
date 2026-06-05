<div class="page-content">

    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">User Form</h4>
        </div>

        <div class="card-body">

            <form method="post" action="<?= base_url('admin/user/update/' . $user->id) ?>">

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                value="<?= e(set_value('name', $user->name)) ?>"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                value="<?= e(set_value('email', $user->email)) ?>"
                                required>
                        </div>
                    </div>

                </div>

                <div class="mb-4">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="participant" <?= set_select('role', 'participant', $user->role === 'participant') ?>>Participant</option>
                        <option value="admin" <?= set_select('role', 'admin', $user->role === 'admin') ?>>Admin</option>
                    </select>
                </div>

                <hr>

                <h5 class="mb-3">Optional Password Reset</h5>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                minlength="6"
                                placeholder="Leave empty to keep current password">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password"
                                id="confirm_password"
                                name="confirm_password"
                                class="form-control"
                                minlength="6"
                                placeholder="Fill only when changing password">
                        </div>
                    </div>

                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Save Changes
                    </button>

                    <a href="<?= base_url('admin/user') ?>" class="btn btn-light">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
