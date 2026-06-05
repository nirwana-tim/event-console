<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-content">

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">My Participants</h4>
        </div>

        <div class="card-body">
            <form method="get" action="<?= base_url('participant') ?>">
                <div class="row g-2 align-items-end">

                    <div class="col-md-4">
                        <label class="form-label mb-1"><small>Search Registration</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e(isset($keyword) ? $keyword : '') ?>" placeholder="Event, location, institution">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label mb-1"><small>Registration</small></label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="pending" <?= isset($selected_status) && $selected_status === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="approved" <?= isset($selected_status) && $selected_status === 'approved' ? 'selected' : '' ?>>Approved</option>
                        </select>
                    </div>

                    <div class="col-md-3">
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
                        <a href="<?= base_url('participant') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($registrations)) { ?>
            <div class="col-12">
                <div class="empty-state py-5">
                    <i class="bi bi-clipboard-x d-block mb-2"></i>
                    No matching participation found
                    <div class="mt-3">
                        <a href="<?= base_url('participant/events') ?>" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i>
                            Find Events
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php foreach ($registrations as $registration) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden event-card-modern position-relative">
                    <div class="position-relative">
                        <img src="<?= e(base_url('uploads/banner/' . $registration->banner)) ?>"
                             class="card-img-top object-fit-cover"
                             alt="<?= e($registration->event_name) ?>"
                             style="height: 160px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="position-absolute top-0 end-0 p-2 d-flex flex-column gap-1 align-items-end">
                            <span class="badge bg-<?= status_badge_class($registration->status) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e(status_label($registration->status)) ?>
                            </span>
                            <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                <?= e(attendance_label($registration->attendance)) ?>
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-1">
                            <small class="text-primary fw-bold text-uppercase x-small letter-spacing-1">
                                <i class="bi bi-calendar2-check me-1"></i>
                                <?= e(human_diff($registration->date)) ?>
                            </small>
                        </div>

                        <h5 class="card-title fw-bold mb-2 fs-6">
                            <a href="<?= base_url('participant/show/' . $registration->id) ?>" class="stretched-link text-gray-800 text-decoration-none">
                                <?= e($registration->event_name) ?>
                            </a>
                        </h5>

                        <div class="d-flex align-items-center mb-3 text-muted x-small">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                            <span class="text-truncate"><?= e($registration->location) ?></span>
                        </div>

                        <div class="mt-auto">
                            <span class="btn btn-outline-primary btn-sm w-100 py-2 rounded-3">
                                <i class="bi bi-eye me-1"></i>
                                View Detail
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
