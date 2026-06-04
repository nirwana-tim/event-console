<div class="page-content">
    <?= flash_alert('success') ?>
    <?= flash_alert('error') ?>
    <?= flash_alert('info') ?>

    <!-- Action Buttons -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="<?= base_url('event') ?>" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
        <a href="<?= base_url('event/registrations/' . $event->id) ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-people me-2"></i>Lihat Peserta
        </a>
        <a href="<?= base_url('event/update/' . $event->id) ?>" class="btn btn-warning shadow-sm">
            <i class="bi bi-pencil-square me-2"></i>Edit Event
        </a>
        <a href="<?= base_url('event/delete/' . $event->id) ?>" class="btn btn-danger shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
            <i class="bi bi-trash me-2"></i>Hapus
        </a>
    </div>

    <!-- Banner & Header Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 overflow-hidden mb-4 rounded-4">
                <div class="position-relative">
                    <div class="event-banner-container">
                        <img src="<?= e(base_url('uploads/banner/' . $event->banner)) ?>" 
                             class="w-100 object-fit-cover" 
                             alt="<?= e($event->name) ?>"
                             style="max-height: 400px; min-height: 250px;"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">
                        <div class="banner-overlay p-4 d-flex flex-column justify-content-end">
                            <div class="container-fluid px-0">
                                <span class="badge bg-<?= status_badge_class($event->status) ?> mb-3 py-2 px-3 text-uppercase shadow">
                                    <i class="bi bi-circle-fill me-2 small"></i><?= e($event->status) ?>
                                </span>
                                <h1 class="text-white display-5 fw-bold mb-2 text-shadow"><?= e($event->name) ?></h1>
                                <p class="text-white opacity-75 mb-0">
                                    <i class="bi bi-person-circle me-1"></i> Created by: <strong><?= e($event->creator_name ?: 'Administrator') ?></strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm bg-white rounded-4">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-light-primary text-primary rounded-3 p-3 me-2">
                        <i class="bi bi-calendar-check fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-1 small text-uppercase">Tanggal</h6>
                        <h5 class="fw-bold mb-0"><?= e(human_diff($event->date)) ?></h5>
                        <small class="text-muted"><?= e(app_date($event->date)) ?></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm bg-white rounded-4">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-light-info text-info rounded-3 p-3 me-2">
                        <i class="bi bi-clock fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-1 small text-uppercase">Waktu</h6>
                        <h5 class="fw-bold mb-0 small"><?= e($event->start_time ?: '00:00') ?> - <?= e($event->end_time ?: 'Selesai') ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm bg-white rounded-4">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-light-success text-success rounded-3 p-3 me-2">
                        <i class="bi bi-geo-alt fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-1 small text-uppercase">Lokasi</h6>
                        <h5 class="fw-bold mb-0 text-truncate" style="max-width: 140px;" title="<?= e($event->location) ?>"><?= e($event->location) ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm bg-white rounded-4">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="stats-icon bg-light-warning text-warning rounded-3 p-3 me-2">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold mb-1 small text-uppercase">Kuota</h6>
                        <h5 class="fw-bold mb-0"><?= e($event->total_registrations) ?> / <?= e($event->quota ?: '∞') ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description Card - Optimized Spacing -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Deskripsi Event</h5>
                </div>
                <div class="card-body p-4">
                    <div class="event-description text-gray-700 fs-6 lh-base" style="white-space: pre-wrap;"><?= $event->description ? nl2br(e($event->description)) : '<span class="text-muted italic">Tidak ada deskripsi untuk event ini.</span>' ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.event-banner-container {
    position: relative;
    width: 100%;
}

.banner-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(0deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.3) 100%);
}

.text-shadow {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.stats-icon {
    width: 54px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-light-primary { background-color: #f0f7ff; }
.bg-light-info { background-color: #e6faff; }
.bg-light-success { background-color: #f0fff4; }
.bg-light-warning { background-color: #fffaf0; }

@media (max-width: 768px) {
    .banner-overlay h1 {
        font-size: 1.5rem;
    }
    .stats-icon {
        width: 48px;
        height: 48px;
    }
}
</style>
