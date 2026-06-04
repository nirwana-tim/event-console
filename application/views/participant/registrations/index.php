<div class="page-heading">

    <h3>My Participants</h3>
    <p class="page-subtitle">Review your event registrations and attendance status.</p>

</div>

<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Registration List</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Registration</th>
                            <th>Payment</th>
                            <th>Attendance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($registrations)) { ?>

                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-clipboard-x d-block mb-2"></i>
                                    You have not registered for any event yet
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach ($registrations as $registration) { ?>

                        <tr>
                            <td><strong><?= e($registration->event_name) ?></strong></td>
                            <td><?= e(app_date($registration->date)) ?></td>
                            <td>
                                <span class="badge bg-<?= status_badge_class($registration->status) ?>">
                                    <?= e($registration->status) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($registration->payment_status === 'verified') { ?>
                                    <span class="badge bg-success">verified</span>
                                <?php } elseif ($registration->payment_status === 'pending') { ?>
                                    <span class="badge bg-warning">pending</span>
                                <?php } else { ?>
                                    <span class="badge bg-secondary">not uploaded</span>
                                <?php } ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?>">
                                    <?= e($registration->attendance) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group-wrap">
                                    <a href="<?= base_url('participant/show/' . $registration->id) ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>
                                        Detail
                                    </a>

                                    <?php if (!$registration->payment_status) { ?>
                                        <a href="<?= base_url('participant/upload_payment_proof/' . $registration->id) ?>"
                                            class="btn btn-success btn-sm">
                                            <i class="bi bi-cloud-arrow-up me-1"></i>
                                            Upload Payment
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
