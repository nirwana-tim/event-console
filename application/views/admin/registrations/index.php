<div class="page-heading">

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3>Participant Registrations</h3>
            <p class="page-subtitle">Monitor registrations, payment status, and manual attendance.</p>
        </div>
    </div>

</div>

<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header">
            <h4 class="card-title mb-0">Filter Data</h4>
        </div>

        <div class="card-body">

            <form method="get" class="mb-4">

                <div class="row g-2 align-items-end">

                    <div class="col-md-5">

                        <label for="event_id" class="form-label">Filter Event</label>

                        <select id="event_id" name="event_id" class="form-select">

                            <option value="">All Events</option>

                            <?php foreach ($events as $event) { ?>

                                <option value="<?= e($event->id) ?>"
                                    <?= (int) $selected_event_id === (int) $event->id ? 'selected' : '' ?>>
                                    <?= e($event->name) ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="col-md-7">

                        <div class="btn-group-wrap">

                            <button class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>
                                Show
                            </button>

                            <?php if ($selected_event_id) { ?>

                                <a href="<?= base_url('event/export_participants/' . $selected_event_id) ?>"
                                    class="btn btn-success">
                                    <i class="bi bi-file-earmark-excel me-1"></i>
                                    Export Excel
                                </a>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="table-registrations">

                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Event</th>
                            <th>Phone</th>
                            <th>Institution</th>
                            <th>Registration</th>
                            <th>Payment</th>
                            <th>Attendance</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if (empty($registrations)) { ?>

                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <i class="bi bi-people d-block mb-2"></i>
                                    No registrations yet
                                </div>
                            </td>
                        </tr>

                        <?php } ?>

                        <?php foreach ($registrations as $registration) { ?>

                        <tr>

                            <td><strong><?= e($registration->user_name) ?></strong></td>
                            <td><?= e($registration->email) ?></td>
                            <td><?= e($registration->event_name) ?></td>
                            <td><?= e($registration->phone_number) ?></td>
                            <td><?= e($registration->institution) ?></td>
                            <td>
                                <span class="badge bg-<?= status_badge_class($registration->status) ?>">
                                    <?= e($registration->status) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($registration->status_payment === 'verified') { ?>
                                    <span class="badge bg-success">verified</span>
                                <?php } elseif ($registration->status_payment === 'pending') { ?>
                                    <span class="badge bg-warning">pending</span>
                                <?php } elseif ($registration->status_payment === 'rejected') { ?>
                                    <span class="badge bg-danger">rejected</span>
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
                                <?php if ($registration->certificate_id) { ?>
                                    <a href="<?= base_url('event/certificate/' . $registration->certificate_id) ?>"
                                        class="btn btn-primary btn-sm"
                                        target="_blank">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>
                                        PDF
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">Not ready</span>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="btn-group-wrap">
                                    <a href="<?= base_url('event/attendance/' . $registration->id . '/present') ?>"
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Mark this participant as present?')">
                                        <i class="bi bi-check2 me-1"></i>
                                        Present
                                    </a>

                                    <a href="<?= base_url('event/attendance/' . $registration->id . '/absent') ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Mark this participant as absent?')">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Absent
                                    </a>

                                    <?php if ($registration->attendance !== 'unconfirmed') { ?>
                                        <a href="<?= base_url('event/attendance/' . $registration->id . '/unconfirmed') ?>"
                                            class="btn btn-light btn-sm">
                                            Reset
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
