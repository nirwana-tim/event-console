<div class="page-heading">

    <h3>Edit Event</h3>
    <p class="page-subtitle">Update the information for this event.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0"><?= e($event->name) ?></h4>
        </div>

        <div class="card-body">

            <?= flash_alert('error') ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                value="<?= e(set_value('name', $event->name)) ?>">
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date"
                                id="date"
                                name="date"
                                class="form-control"
                                value="<?= e(set_value('date', $event->date)) ?>">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text"
                        id="location"
                        name="location"
                        class="form-control"
                        value="<?= e(set_value('location', $event->location)) ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description"
                        id="description"
                        rows="5"
                        class="form-control"><?= e(set_value('description', $event->description)) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Banner</label>

                    <?php if ($event->banner) { ?>

                    <div class="mb-3">
                        <img class="table-img"
                            src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                            alt="<?= e($event->name) ?>">
                    </div>

                    <?php } ?>

                    <input type="file"
                        id="banner"
                        name="banner"
                        accept="image/png,image/jpeg"
                        class="form-control">
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>
                        Update Event
                    </button>

                    <a href="<?= base_url('event') ?>" class="btn btn-light">
                        Back
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>
