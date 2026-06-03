<div class="page-heading">

    <h3>Edit Event</h3>
    <p class="page-subtitle">Update the information for this event.</p>

</div>

<div class="page-content">

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0"><?= e($event->nama_event) ?></h4>
        </div>

        <div class="card-body">

            <?= flash_alert('error') ?>

            <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

            <form method="post" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-8">

                        <div class="mb-3">
                            <label for="nama_event" class="form-label">Event Name</label>
                            <input type="text"
                                id="nama_event"
                                name="nama_event"
                                class="form-control"
                                value="<?= e(set_value('nama_event', $event->nama_event)) ?>">
                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Date</label>
                            <input type="date"
                                id="tanggal"
                                name="tanggal"
                                class="form-control"
                                value="<?= e(set_value('tanggal', $event->tanggal)) ?>">
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Location</label>
                    <input type="text"
                        id="lokasi"
                        name="lokasi"
                        class="form-control"
                        value="<?= e(set_value('lokasi', $event->lokasi)) ?>">
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Description</label>
                    <textarea name="deskripsi"
                        id="deskripsi"
                        rows="5"
                        class="form-control"><?= e(set_value('deskripsi', $event->deskripsi)) ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="banner" class="form-label">Banner</label>

                    <?php if ($event->banner) { ?>

                    <div class="mb-3">
                        <img class="table-img"
                            src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                            alt="<?= e($event->nama_event) ?>">
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
