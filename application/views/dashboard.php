<div class="page-content">
    <!-- Welcome Section -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-primary text-white welcome-banner">
                <div class="card-body p-4 p-md-5 d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="text-white fw-bold mb-2">Halo, <?= e($current_user_name) ?>! 👋</h2>
                        <p class="mb-4 opacity-75 fs-5">
                            <?= $dashboard_role === 'participant' 
                                ? 'Cek status pendaftaranmu dan temukan event menarik lainnya hari ini.' 
                                : 'Pantau perkembangan seluruh event dan pendaftaran peserta dalam satu layar.' ?>
                        </p>
                        <a href="<?= $dashboard_role === 'participant' ? base_url('participant/events') : base_url('event') ?>" class="btn btn-white text-primary fw-bold px-4 py-2 rounded-3 shadow">
                            <?= $dashboard_role === 'participant' ? 'Cari Event Baru' : 'Kelola Event' ?>
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
                            <h6 class="text-muted font-semibold mb-1">Event Diikuti</h6>
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
                            <h6 class="text-muted font-semibold mb-1">Kehadiran</h6>
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
                            <h6 class="text-muted font-semibold mb-1">Sertifikat</h6>
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
                            <h6 class="text-muted font-semibold mb-1">Total Peserta</h6>
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
                            <h6 class="text-muted font-semibold mb-1">Pendaftaran</h6>
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
                            <h6 class="text-muted font-semibold mb-1">Sertifikat</h6>
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
                <h4 class="fw-bold mb-0">Event Terbaru</h4>
                <a href="<?= base_url('participant/events') ?>" class="text-primary fw-bold text-decoration-none small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
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
                                            <?= e($event->status) ?>
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
        <!-- Admin Quick Access -->
        <section class="row g-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Akses Cepat Admin</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <a href="<?= base_url('event/create') ?>" class="btn btn-light-primary w-100 py-3 rounded-3 text-center d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-plus-square fs-3"></i>
                                    <span class="small fw-bold">Buat Event</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="<?= base_url('event/registrations') ?>" class="btn btn-light-success w-100 py-3 rounded-3 text-center d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-person-check fs-3"></i>
                                    <span class="small fw-bold">Verifikasi Absensi</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="<?= base_url('event/certificates') ?>" class="btn btn-light-info w-100 py-3 rounded-3 text-center d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-award fs-3"></i>
                                    <span class="small fw-bold">Kelola Sertifikat</span>
                                </a>
                            </div>
                            <div class="col-6 col-md-3">
                                <a href="<?= base_url('users') ?>" class="btn btn-light-secondary w-100 py-3 rounded-3 text-center d-flex flex-column align-items-center gap-2">
                                    <i class="bi bi-people fs-3"></i>
                                    <span class="small fw-bold">Kelola User</span>
                                </a>
                            </div>
                        </div>
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
.btn-light-secondary { background: #f8f9fa; color: #6c757d; border: none; }

.btn-light-primary:hover, .btn-light-success:hover, .btn-light-info:hover, .btn-light-secondary:hover {
    filter: brightness(0.95);
}
</style>
