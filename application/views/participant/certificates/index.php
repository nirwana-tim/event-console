<?= flash_alert('success') ?>
<?= flash_alert('error') ?>
<?= flash_alert('info') ?>

<div class="page-content">

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">My Certificates</h4>
        </div>

        <div class="card-body">
            <form method="get" action="<?= base_url('participant/certificate') ?>">
                <div class="row g-2 align-items-end">

                    <div class="col-md-10">
                        <label class="form-label mb-1"><small>Search Certificate</small></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="keyword" class="form-control" value="<?= e(isset($keyword) ? $keyword : '') ?>" placeholder="Event name or certificate number">
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary w-100" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-md-1">
                        <a href="<?= base_url('participant/certificate') ?>" class="btn btn-light w-100" title="Reset filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($certificates)) { ?>
            <div class="col-12">
                <div class="empty-state py-5">
                    <i class="bi bi-award d-block mb-2"></i>
                    No matching certificates found
                </div>
            </div>
        <?php } ?>

        <?php foreach ($certificates as $certificate) { ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden certificate-card">
                    <div class="certificate-preview bg-light-primary position-relative d-flex align-items-center justify-content-center" style="height: 160px;">
                        <img src="<?= e(base_url('uploads/banner/' . $certificate->banner)) ?>"
                             class="w-100 h-100 object-fit-cover opacity-25 position-absolute"
                             alt="<?= e($certificate->event_name) ?>"
                             onerror="this.src='<?= base_url('mazer/dist/assets/static/images/samples/architecture.jpg') ?>'">

                        <div class="certificate-badge position-relative z-index-2 text-center">
                            <div class="bg-white rounded-circle shadow-sm d-inline-flex p-3 mb-2">
                                <i class="bi bi-award-fill text-warning fs-1"></i>
                            </div>
                            <div class="x-small fw-bold text-primary text-uppercase letter-spacing-1">Official Document</div>
                        </div>
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <div class="mb-1">
                            <small class="text-muted x-small">
                                <i class="bi bi-hash me-1"></i>
                                <?= e($certificate->certificate_number) ?>
                            </small>
                        </div>

                        <h5 class="card-title fw-bold mb-2 fs-6 text-gray-800">
                            <?= e($certificate->event_name) ?>
                        </h5>

                        <div class="d-flex align-items-center mb-3 text-muted x-small">
                            <i class="bi bi-calendar-check me-1"></i>
                            <span>Issued on <?= e(app_date($certificate->date)) ?></span>
                        </div>

                        <div class="mt-auto">
                            <a href="<?= base_url('participant/certificate/show/' . $certificate->id) ?>" class="btn btn-primary btn-sm w-100 py-2 rounded-3 shadow-sm">
                                <i class="bi bi-download me-1"></i>
                                Download Certificate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>

<style>
.certificate-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.certificate-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.certificate-preview {
    background: linear-gradient(135deg, #f0f7ff 0%, #e0f0ff 100%);
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.z-index-2 {
    z-index: 2;
}
</style>
