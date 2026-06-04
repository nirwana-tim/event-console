<div class="page-heading">

    <h3>Dashboard</h3>
    <p class="page-subtitle">
        <?= $dashboard_role === 'participant' ? 'Track your event registrations, attendance, and certificates.' : 'Summary of the online event and certificate system.' ?>
    </p>

</div>

<div class="page-content">

    <section class="row">

        <?php if ($dashboard_role === 'participant') { ?>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <h6>Registered Events</h6>
                            <h2><?= e($summary['registered_events']) ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <h6>Attendance Present</h6>
                            <h2><?= e($summary['attendance_present']) ?></h2>
                        </div>
                    </div>
                </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-info">
                            <i class="bi bi-award"></i>
                        </div>
                        <div>
                            <h6>Certificates</h6>
                            <h2><?= e($summary['certificates']) ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <?php } else { ?>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div>
                            <h6>Total Event</h6>
                            <h2><?= e($summary['total_events']) ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <h6>Total Participants</h6>
                            <h2>
                                <?= e($summary['total_participants']) ?>
                            </h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="col-12 col-md-6 col-xl-3">

            <div class="card stat-card">

                <div class="card-body py-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <div>
                            <h6>Total Registrations</h6>
                            <h2><?= e($summary['total_registrations']) ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>



        <?php } ?>

    </section>

    <section class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">
                        Welcome, <?= e($current_user_name) ?>
                    </h4>
                </div>

                <div class="card-body">
                    <p class="mb-0 text-muted">
                        <?= $dashboard_role === 'participant'
                            ? 'Use the sidebar menu to browse events, review your registrations, and download certificates.'
                            : 'Use the sidebar menu to manage events, registrations, and certificates.' ?>
                    </p>
                </div>

            </div>

        </div>

    </section>

    <?php if ($dashboard_role !== 'participant') { ?>

    <section class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title mb-0">Admin Workflow</h4>
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6 col-xl">
                            <a href="<?= base_url('event/create') ?>" class="btn btn-outline-primary w-100 text-start">
                                <i class="bi bi-plus-circle me-1"></i>
                                Create Event
                            </a>
                        </div>



                        <div class="col-md-6 col-xl">
                            <a href="<?= base_url('event/registrations') ?>" class="btn btn-outline-success w-100 text-start">
                                <i class="bi bi-person-check me-1"></i>
                                Mark Attendance
                                <span class="badge bg-success ms-1"><?= e($summary['total_attendance_pending']) ?></span>
                            </a>
                        </div>

                        <div class="col-md-6 col-xl">
                            <a href="<?= base_url('event/certificates') ?>" class="btn btn-outline-info w-100 text-start">
                                <i class="bi bi-award me-1"></i>
                                Certificates
                                <span class="badge bg-info ms-1"><?= e($summary['total_certificates']) ?></span>
                            </a>
                        </div>

                        <div class="col-md-6 col-xl">
                            <a href="<?= base_url('users') ?>" class="btn btn-outline-secondary w-100 text-start">
                                <i class="bi bi-person-gear me-1"></i>
                                User Management
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <?php } ?>

</div>
