<div class="page-heading">

    <h3>Registration Detail</h3>
    <p class="page-subtitle">Check your registration, payment, attendance, and certificate status.</p>

</div>

<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="row">

        <div class="col-lg-4">

            <div class="card event-card">
                <img src="<?= e(base_url('uploads/banner/' . $registration->banner)) ?>"
                    class="card-img-top"
                    alt="<?= e($registration->event_name) ?>"
                    onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/error-404.svg') ?>'">
                <div class="card-body">
                    <h5><?= e($registration->event_name) ?></h5>
                    <div class="event-meta">
                        <i class="bi bi-calendar3"></i>
                        <span><?= e(app_date($registration->date)) ?></span>
                    </div>
                    <div class="event-meta">
                        <i class="bi bi-geo-alt"></i>
                        <span><?= e($registration->location) ?></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Participant Status</h4>
                </div>

                <div class="card-body">

                    <div class="row g-3 mb-4">

                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">Registration</small>
                            <span class="badge bg-<?= status_badge_class($registration->status) ?>">
                                <?= e($registration->status) ?>
                            </span>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">Payment</small>
                            <?php if ($registration->payment_status === 'verified') { ?>
                                <span class="badge bg-success">verified</span>
                            <?php } elseif ($registration->payment_status === 'pending') { ?>
                                <span class="badge bg-warning">pending</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">not uploaded</span>
                            <?php } ?>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted d-block mb-1">Attendance</small>
                            <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?>">
                                <?= e($registration->attendance) ?>
                            </span>
                        </div>

                    </div>

                    <dl class="row mb-0">
                        <dt class="col-sm-4">Phone Number</dt>
                        <dd class="col-sm-8"><?= e($registration->phone_number) ?></dd>

                        <dt class="col-sm-4">Institution</dt>
                        <dd class="col-sm-8"><?= e($registration->institution) ?></dd>

                        <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8"><?= e($registration->address) ?></dd>

                        <dt class="col-sm-4">Team</dt>
                        <dd class="col-sm-8"><?= e($registration->team ?: '-') ?></dd>

                        <dt class="col-sm-4">Notes</dt>
                        <dd class="col-sm-8"><?= e($registration->notes ?: '-') ?></dd>

                        <dt class="col-sm-4">Certificate</dt>
                        <dd class="col-sm-8">
                            <?php if ($registration->certificate_id) { ?>
                                <a href="<?= base_url('participant/download/' . $registration->certificate_id) ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-download me-1"></i>
                                    Download Certificate
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">Not available yet</span>
                            <?php } ?>
                        </dd>
                    </dl>

                    <div class="btn-group-wrap mt-4">
                        <?php if (!$registration->payment_status) { ?>
                            <a href="<?= base_url('participant/upload_payment_proof/' . $registration->id) ?>"
                                class="btn btn-success">
                                <i class="bi bi-cloud-arrow-up me-1"></i>
                                Upload Payment
                            </a>
                        <?php } ?>

                        <a href="<?= base_url('participant') ?>" class="btn btn-light">Back</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
