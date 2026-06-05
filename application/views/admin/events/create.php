<div class="page-content">

    <?= flash_alert('error') ?>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Event Form</h4>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data" action="<?= base_url('admin/event/store') ?>">

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="<?= e(set_value('name')) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="<?= e(set_value('date')) ?>" required>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control"
                                value="<?= e(set_value('start_time')) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control"
                                value="<?= e(set_value('end_time')) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="quota" class="form-label">Quota</label>
                            <input type="number" id="quota" name="quota" min="0" class="form-control"
                                value="<?= e(set_value('quota')) ?>">
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control"
                        value="<?= e(set_value('location')) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="dibuka" <?= set_select('status', 'dibuka', TRUE) ?>>Open</option>
                        <option value="ditutup" <?= set_select('status', 'ditutup') ?>>Closed</option>
                        <option value="selesai" <?= set_select('status', 'selesai') ?>>Completed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="form-control"><?= e(set_value('description')) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Event Banner</label>
                    <input type="file" id="banner" name="banner" class="form-control"
                        accept="image/png,image/jpeg" required>
                    <small class="text-muted">Allowed file types: JPG, JPEG, PNG. Max size 2 MB.</small>
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Save Event
                    </button>

                    <a href="<?= base_url('admin/event') ?>" class="btn btn-light">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
