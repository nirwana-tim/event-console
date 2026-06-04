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
                    alt="<?= e($event->name) ?>"
                    onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/error-404.svg') ?>'">
                <div class="card-body">
                    <h5><?= e($event->name) ?></h5>
                    <div class="event-meta">
                        <i class="bi bi-calendar3"></i>
                        <span><?= e(app_date($event->date)) ?></span>
                    </div>
                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($event->location) ?></span>
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
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text"
                                        id="phone_number"
                                        name="phone_number"
                                        class="form-control"
                                        value="<?= e(set_value('phone_number')) ?>"
                                        placeholder="08xxxxxxxxxx"
                                        required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="institution" class="form-label">Institution</label>
                                    <input type="text"
                                        id="institution"
                                        name="institution"
                                        class="form-control"
                                        value="<?= e(set_value('institution')) ?>"
                                        placeholder="School / Campus / Community"
                                        required>
                                </div>

                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address"
                                id="address"
                                rows="3"
                                class="form-control"
                                required><?= e(set_value('address')) ?></textarea>
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
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes"
                                id="notes"
                                rows="3"
                                class="form-control"><?= e(set_value('notes')) ?></textarea>
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
