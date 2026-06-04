<div class="page-heading">

    <h3>Create Event</h3>
    <p class="page-subtitle">Create a new event for participants.</p>

</div>

<div class="page-content">

    <?= flash_alert('error') ?>
    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Event Form</h4>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

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

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control"
                        value="<?= e(set_value('location')) ?>" required>
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

                    <a href="<?= base_url('event') ?>" class="btn btn-light">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
