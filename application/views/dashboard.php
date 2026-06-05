<div class="page-content">
    <!-- Welcome Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-primary text-white welcome-banner">
                <div class="card-body p-4 p-md-5 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="text-white fw-bold mb-2">Hi, <?= e($current_user_name) ?>!</h2>
                        <p class="mb-4 opacity-75 fs-5">
                            <?= $dashboard_role === 'participant' 
                                ? 'Check your registration status and discover more events today.' 
                                : 'Monitor event progress, registrations, and participant activity in one place.' ?>
                        </p>
                        <a href="<?= $dashboard_role === 'participant' ? base_url('participant/events') : base_url('event') ?>" class="btn btn-white text-primary fw-bold px-4 py-2 rounded-3 shadow">
                            <?= $dashboard_role === 'participant' ? 'Find New Events' : 'Manage Events' ?>
                        </a>
                    </div>
                    <div class="d-none d-lg-block">
                        <i class="bi bi-rocket-takeoff display-1 opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Grid -->
    <section class="row g-4 mb-4">
        <?php if ($dashboard_role === 'participant') { ?>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-primary text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-calendar2-check-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Registered Events</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['registered_events']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-success text-success rounded-3 p-3 me-3">
                            <i class="bi bi-person-check-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Attendance</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['attendance_present']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-warning text-warning rounded-3 p-3 me-3">
                            <i class="bi bi-award-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Certificates</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['certificates']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-primary text-primary rounded-3 p-3 me-3">
                            <i class="bi bi-calendar2-event-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Total Event</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['total_events']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-success text-success rounded-3 p-3 me-3">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Total Participants</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['total_participants']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-warning text-warning rounded-3 p-3 me-3">
                            <i class="bi bi-clipboard-check-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Registrations</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['total_registrations']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="stats-icon bg-light-info text-info rounded-3 p-3 me-3">
                            <i class="bi bi-award-fill fs-3"></i>
                        </div>
                        <div>
                            <h6 class="text-muted font-semibold mb-1">Certificates</h6>
                            <h3 class="fw-bold mb-0"><?= e($summary['total_certificates']) ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>

    <?php if ($dashboard_role === 'participant') { ?>
        <!-- Latest Events for Participant -->
        <section class="row">
            <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">Latest Events</h4>
                <a href="<?= base_url('participant/events') ?>" class="text-primary fw-bold text-decoration-none small">View All <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-12">
                <div class="row g-4">
                    <?php foreach ($latest_events as $event) { ?>
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden event-card-modern position-relative">
                                <div class="position-relative">
                                    <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>" 
                                         class="card-img-top object-fit-cover" 
                                         style="height: 140px;"
                                         onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-<?= status_badge_class($event->status) ?> py-1 px-2 text-uppercase x-small shadow-sm">
                                            <?= e(status_label($event->status)) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body p-3 d-flex flex-column">
                                    <div class="mb-1">
                                        <small class="text-primary fw-bold text-uppercase x-small letter-spacing-1">
                                            <i class="bi bi-calendar2-event me-1"></i> <?= e(human_diff($event->date)) ?>
                                        </small>
                                    </div>
                                    <h5 class="card-title fw-bold mb-2 fs-6">
                                        <a href="<?= base_url('participant/event_show/' . $event->id) ?>" class="stretched-link text-gray-800 text-decoration-none">
                                            <?= e($event->name) ?>
                                        </a>
                                    </h5>
                                    <div class="d-flex align-items-center mb-1 text-muted x-small">
                                        <i class="bi bi-geo-alt-fill me-1 text-danger"></i>
                                        <span class="text-truncate"><?= e($event->location) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } else { ?>
        <!-- Admin Latest Data -->
        <section class="row g-4 mb-4">
            <div class="col-12 col-xl-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-calendar2-event-fill text-primary me-2"></i>
                            Latest Events
                        </h5>
                        <a href="<?= base_url('event') ?>" class="text-primary fw-bold text-decoration-none small">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <?php if (empty($latest_events)) { ?>
                            <div class="empty-state py-5">
                                <i class="bi bi-calendar-x"></i>
                                <span>No events yet</span>
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Date</th>
                                            <th>Quota</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($latest_events as $event) { ?>
                                            <tr>
                                                <td>
                                                    <a href="<?= base_url('event/show/' . $event->id) ?>" class="fw-bold text-gray-800 text-decoration-none">
                                                        <?= e($event->name) ?>
                                                    </a>
                                                    <div class="text-muted small">
                                                        <i class="bi bi-geo-alt me-1"></i>
                                                        <?= e($event->location) ?>
                                                    </div>
                                                </td>
                                                <td><?= e(app_date($event->date)) ?></td>
                                                <td><?= e($event->total_registrations) ?>/<?= e($event->quota ?: 'Unlimited') ?></td>
                                                <td>
                                                    <span class="badge bg-<?= status_badge_class($event->status) ?>">
                                                        <?= e(status_label($event->status)) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-activity text-success me-2"></i>
                            Recent Activities
                        </h5>
                        <a href="<?= base_url('event/registrations') ?>" class="text-primary fw-bold text-decoration-none small">
                            View All <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="card-body">
                        <?php if (empty($recent_activities)) { ?>
                            <div class="empty-state py-5">
                                <i class="bi bi-inbox"></i>
                                <span>No registration activity yet</span>
                            </div>
                        <?php } else { ?>
                            <div class="activity-list">
                                <?php foreach ($recent_activities as $activity) { ?>
                                    <div class="activity-item d-flex gap-3">
                                        <div class="activity-icon bg-light-primary text-primary">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between gap-3">
                                                <strong><?= e($activity->participant_name) ?></strong>
                                                <small class="text-muted text-nowrap"><?= e(human_diff($activity->created_at)) ?></small>
                                            </div>

                                            <div class="text-muted small">
                                                Registered for
                                                <a href="<?= base_url('event/registrations?event_id=' . $activity->event_id) ?>" class="fw-bold text-decoration-none">
                                                    <?= e($activity->event_name) ?>
                                                </a>
                                            </div>

                                            <div class="mt-2 d-flex flex-wrap gap-1">
                                                <span class="badge bg-<?= status_badge_class($activity->status) ?>">
                                                    <?= e(status_label($activity->status)) ?>
                                                </span>
                                                <span class="badge bg-<?= attendance_badge_class($activity->attendance) ?>">
                                                    <?= e(attendance_label($activity->attendance)) ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin Quick Access -->
        <section class="row g-4">
            <div class="col-12">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-grid-1x2-fill text-primary me-2"></i>Quick Actions</h5>
                </div>
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <a href="<?= base_url('event/create') ?>" class="quick-action-link text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center qa-card border-primary">
                                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="qa-icon-wrapper bg-light-primary text-primary rounded-circle mb-3">
                                        <i class="bi bi-plus-lg fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold text-gray-800 mb-1">Create Event</h6>
                                    <small class="text-muted qa-subtitle">Add new</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= base_url('event/registrations') ?>" class="quick-action-link text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center qa-card border-success">
                                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="qa-icon-wrapper bg-light-success text-success rounded-circle mb-3">
                                        <i class="bi bi-check2-square fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold text-gray-800 mb-1">Attendance</h6>
                                    <small class="text-muted qa-subtitle">Track attendance</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= base_url('event/certificates') ?>" class="quick-action-link text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center qa-card border-warning">
                                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="qa-icon-wrapper bg-light-warning text-warning rounded-circle mb-3">
                                        <i class="bi bi-award fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold text-gray-800 mb-1">Certificates</h6>
                                    <small class="text-muted qa-subtitle">Manage awards</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-md-3">
                        <a href="<?= base_url('users') ?>" class="quick-action-link text-decoration-none">
                            <div class="card h-100 border-0 shadow-sm rounded-4 text-center qa-card border-info">
                                <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                                    <div class="qa-icon-wrapper bg-light-info text-info rounded-circle mb-3">
                                        <i class="bi bi-people fs-3"></i>
                                    </div>
                                    <h6 class="fw-bold text-gray-800 mb-1">Manage Users</h6>
                                    <small class="text-muted qa-subtitle">Manage accounts</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
</div>

<style>
.welcome-banner {
    background: linear-gradient(135deg, #435ebe 0%, #6070e9 100%);
}
.btn-white {
    background: #fff;
    color: #435ebe;
    border: none;
}
.btn-white:hover {
    background: #f8f9fa;
    color: #3e56ad;
}
.btn-light-primary { background: #e7f1ff; color: #435ebe; border: none; }
.btn-light-success { background: #e8f5e9; color: #198754; border: none; }
.btn-light-info { background: #e0f7fa; color: #0dcaf0; border: none; }
.btn-light-warning { background: #fff8e1; color: #ffc107; border: none; }

/* Quick Action Styles */
.qa-card {
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    position: relative;
    top: 0;
    overflow: hidden; /* Clips the pseudo-element to match the rounded-4 corners */
}
/* Premium bottom border using a pseudo-element that scales and clips perfectly */
.qa-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    transition: all 0.3s ease;
}
.qa-card.border-primary::after { background-color: #435ebe; }
.qa-card.border-success::after { background-color: #198754; }
.qa-card.border-warning::after { background-color: #ffc107; }
.qa-card.border-info::after { background-color: #0dcaf0; }

.qa-icon-wrapper {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}
.stats-icon,
.qa-icon-wrapper,
.activity-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    flex-shrink: 0;
}
.stats-icon {
    width: 54px;
    height: 54px;
    padding: 0 !important;
}
.stats-icon .bi,
.qa-icon-wrapper .bi,
.activity-icon .bi {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.stats-icon .bi::before,
.qa-icon-wrapper .bi::before,
.activity-icon .bi::before {
    line-height: 1;
    vertical-align: 0;
}
.qa-subtitle {
    font-size: 0.8rem;
    opacity: 0.7;
    transition: all 0.3s ease;
}
.quick-action-link:hover .qa-card {
    top: -8px;
    box-shadow: 0 12px 24px rgba(0,0,0,0.1) !important;
}
.quick-action-link:hover .qa-icon-wrapper {
    transform: scale(1.15) rotate(5deg);
}

.quick-action-link:hover .qa-card.border-primary .qa-icon-wrapper { background: #435ebe !important; color: #fff !important; }
.quick-action-link:hover .qa-card.border-success .qa-icon-wrapper { background: #198754 !important; color: #fff !important; }
.quick-action-link:hover .qa-card.border-warning .qa-icon-wrapper { background: #ffc107 !important; color: #fff !important; }
.quick-action-link:hover .qa-card.border-info .qa-icon-wrapper { background: #0dcaf0 !important; color: #fff !important; }

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.activity-item:last-child {
    padding-bottom: 0;
    border-bottom: 0;
}

.activity-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 42px;
}
.empty-state {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: .75rem;
    min-height: 150px;
    text-align: center;
}
.empty-state .bi {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    margin: 0 !important;
    color: #c2cbe0;
    font-size: 2.25rem;
    line-height: 1;
}
.empty-state .bi::before {
    line-height: 1;
    vertical-align: 0;
}
.empty-state span {
    display: block;
    color: var(--event-console-muted);
    line-height: 1.4;
}

</style>
