<div class="page-heading">

    <h3>Update Event</h3>
    <p class="page-subtitle">Update the information for this event.</p>

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
                                value="<?= e(set_value('name', $event->name)) ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="<?= e(set_value('date', $event->date)) ?>" required>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control"
                                value="<?= e(set_value('start_time', $event->start_time)) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control"
                                value="<?= e(set_value('end_time', $event->end_time)) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="quota" class="form-label">Quota</label>
                            <input type="number" id="quota" name="quota" min="0" class="form-control"
                                value="<?= e(set_value('quota', $event->quota)) ?>">
                        </div>
                    </div>

                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control"
                        value="<?= e(set_value('location', $event->location)) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="dibuka" <?= set_select('status', 'dibuka', $event->status === 'dibuka') ?>>Open</option>
                        <option value="ditutup" <?= set_select('status', 'ditutup', $event->status === 'ditutup') ?>>Closed</option>
                        <option value="selesai" <?= set_select('status', 'selesai', $event->status === 'selesai') ?>>Completed</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="form-control"><?= e(set_value('description', $event->description)) ?></textarea>
                </div>

                <?php if ($event->banner) { ?>
                    <div class="mb-3">
                        <label class="form-label">Current Banner</label>
                        <div>
                            <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                                alt="<?= e($event->name) ?>"
                                class="table-img"
                                onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/error-404.svg') ?>'">
                        </div>
                    </div>
                <?php } ?>

                <div class="mb-4">
                    <label for="banner" class="form-label">Change Banner</label>
                    <input type="file" id="banner" name="banner" class="form-control"
                        accept="image/png,image/jpeg">
                    <small class="text-muted">Leave empty if you do not want to change the banner.</small>
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Save Changes
                    </button>

                    <a href="<?= base_url('event') ?>" class="btn btn-light">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
