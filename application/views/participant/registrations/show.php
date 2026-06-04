<div class="page-content">
    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <!-- Action Buttons -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="<?= base_url('participant') ?>" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <?php if ($registration->certificate_id) { ?>
            <a href="<?= base_url('participant/download/' . $registration->certificate_id) ?>" class="btn btn-success shadow-sm">
                <i class="bi bi-award-fill me-2"></i>Download Sertifikat
            </a>
        <?php } ?>
    </div>

    <!-- Banner & Header Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden mb-4 rounded-4">
                <div class="position-relative">
                    <div class="event-banner-container">
                        <img src="<?= e(base_url('uploads/banner/' . $registration->banner)) ?>" 
                             class="w-100 object-fit-cover" 
                             alt="<?= e($registration->event_name) ?>"
                             style="max-height: 400px; min-height: 250px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="banner-overlay p-4 d-flex flex-column justify-content-end">
                            <div class="container-fluid px-0">
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-<?= status_badge_class($registration->status) ?> py-2 px-3 text-uppercase shadow">
                                        Status: <?= e($registration->status) ?>
                                    </span>
                                    <span class="badge bg-<?= attendance_badge_class($registration->attendance) ?> py-2 px-3 text-uppercase shadow">
                                        Absensi: <?= e($registration->attendance) ?>
                                    </span>
                                </div>
                                <h1 class="text-white display-5 fw-bold mb-2 text-shadow"><?= e($registration->event_name) ?></h1>
                                <p class="text-white opacity-75 mb-0">
                                    <i class="bi bi-calendar3 me-1"></i> <?= e(human_diff($registration->date)) ?> (<?= e(app_date($registration->date)) ?>) | <i class="bi bi-geo-alt ms-2"></i> <?= e($registration->location) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Participant Info -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>Data Pendaftaran</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold">No. Telepon</label>
                            <p class="fw-bold text-gray-800 fs-5 mb-0"><?= e($registration->phone_number) ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold">Institusi</label>
                            <p class="fw-bold text-gray-800 fs-5 mb-0"><?= e($registration->institution) ?></p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold">Alamat</label>
                            <p class="text-gray-700 fs-6 mb-0"><?= e($registration->address) ?></p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold">Tim</label>
                            <p class="text-gray-800 fw-bold mb-0"><?= e($registration->team ?: '-') ?></p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold">Catatan</label>
                            <p class="text-gray-700 small mb-0"><?= e($registration->notes ?: '-') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Event Description -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Deskripsi Event</h5>
                </div>
                <div class="card-body p-4">
                    <div class="event-description text-gray-700 small lh-base" style="white-space: pre-wrap;"><?= $registration->description ? nl2br(e($registration->description)) : '<span class="text-muted italic">Tidak ada deskripsi untuk event ini.</span>' ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
