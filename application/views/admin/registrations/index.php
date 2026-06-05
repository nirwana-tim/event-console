<div class="page-content">

    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Participant Data</h4>

            <?php if ($selected_event_id) { ?>
                <a href="<?= base_url('event/export_participants/' . $selected_event_id) ?>" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i>
                    Export
                </a>
            <?php } ?>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('event/registrations') ?>" class="mb-4">
                <div class="row g-2 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label mb-1"><small>Search Participant</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e(isset($keyword) ? $keyword : '') ?>" placeholder="Name, email, event">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label mb-1"><small>Event</small></label>
                        <select name="event_id" class="form-select">
                            <option value="">All Events</option>
                            <?php foreach ($events as $event) { ?>
                                <option value="<?= e($event->id) ?>" <?= (int) $selected_event_id === (int) $event->id ? 'selected' : '' ?>>
                                    <?= e($event->name) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label mb-1"><small>Attendance</small></label>
                        <select name="attendance" class="form-select">
                            <option value="">All Attendance</option>
                            <option value="unconfirmed" <?= isset($selected_attendance) && $selected_attendance === 'unconfirmed' ? 'selected' : '' ?>>Unconfirmed</option>
                            <option value="present" <?= isset($selected_attendance) && $selected_attendance === 'present' ? 'selected' : '' ?>>Present</option>
                            <option value="absent" <?= isset($selected_attendance) && $selected_attendance === 'absent' ? 'selected' : '' ?>>Absent</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-md-1">
                        <a href="<?= base_url('event/registrations') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
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
                            <th>Attendance</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($registrations)) { ?>
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-people d-block mb-2"></i>
                                        No registrations found
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
                                    <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?>">
                                        <?= e(attendance_label($registration->attendance)) ?>
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
                                        <?php if ($registration->attendance === 'unconfirmed') { ?>
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
                                        <?php } else { ?>
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
