<div class="page-heading">

    <h3>Add Event</h3>
    <p class="page-subtitle">Create a new event for participants.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Event Information</h4>
        </div>

        <div class="card-body">

            <?= flash_alert('error') ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-6">

                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text"
                                id="name"
                                name="name"
                                class="form-control"
                                value="<?= e(set_value('name')) ?>"
                                placeholder="Example: Poster Design Competition">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date"
                                id="date"
                                name="date"
                                value="<?= e(set_value('date')) ?>"
                                class="form-control">
                        </div>

                    </div>

                    <div class="col-md-3">

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text"
                                id="location"
                                name="location"
                                class="form-control"
                                value="<?= e(set_value('location')) ?>"
                                placeholder="Campus / Online">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description"
                        id="description"
                        rows="5"
                        class="form-control"
                        placeholder="Brief event details"><?= e(set_value('description')) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Banner</label>
                    <input type="file"
                        id="banner"
                        name="banner"
                        accept="image/png,image/jpeg"
                        class="form-control">
                </div>

                <div class="btn-group-wrap">
                    <button type="submit" class="btn btn-success">
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
