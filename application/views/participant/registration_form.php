<div class="page-heading">

    <h3>Event Registration Form</h3>
    <p class="page-subtitle">Complete your participant details before uploading payment proof.</p>

</div>

<div class="page-content">

    <?= validation_errors('<div class="alert alert-danger">', '</div>') ?>

    <div class="row">

        <div class="col-lg-4">

            <div class="card event-card">
                <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>"
                    class="card-img-top"
                    alt="<?= e($event->nama_event) ?>">
                <div class="card-body">
                    <h5><?= e($event->nama_event) ?></h5>
                    <div class="event-meta">
                        <i class="bi bi-calendar3"></i>
                        <span><?= e(app_date($event->tanggal)) ?></span>
                    </div>
                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($event->lokasi) ?></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Participant Data</h4>
                </div>

                <div class="card-body">

                    <form method="post"
                        action="<?= base_url('participant/register/' . $event->id) ?>">

                        <div class="row">

                            <div class="col-md-6">

                            <div class="mb-3">
                                    <label for="no_hp" class="form-label">Phone Number</label>
                                    <input type="text"
                                        id="no_hp"
                                        name="no_hp"
                                        class="form-control"
                                        value="<?= e(set_value('no_hp')) ?>"
                                        placeholder="08xxxxxxxxxx"
                                        required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="instansi" class="form-label">Institution</label>
                                    <input type="text"
                                        id="instansi"
                                        name="instansi"
                                        class="form-control"
                                        value="<?= e(set_value('instansi')) ?>"
                                        placeholder="School / Campus / Community"
                                        required>
                                </div>

                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Address</label>
                            <textarea name="alamat"
                                id="alamat"
                                rows="3"
                                class="form-control"
                                required><?= e(set_value('alamat')) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="team" class="form-label">Team (Optional)</label>
                            <input type="text"
                                id="team"
                                name="team"
                                class="form-control"
                                value="<?= e(set_value('team')) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label">Notes</label>
                            <textarea name="catatan"
                                id="catatan"
                                rows="3"
                                class="form-control"><?= e(set_value('catatan')) ?></textarea>
                        </div>

                        <div class="btn-group-wrap">
                            <button class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Register Now
                            </button>

                            <a href="<?= base_url('participant/events') ?>" class="btn btn-light">
                                Back
                            </a>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
